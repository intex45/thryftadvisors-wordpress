(function () {
	'use strict';

	window.dataLayer = window.dataLayer || [];

	function readConsentCookie() {
		if (window.cookieadmin_is_consent && cookieadmin_is_consent.action) {
			return cookieadmin_is_consent.action;
		}
		var raw = document.cookie.split(';');
		for (var i = 0; i < raw.length; i++) {
			var part = raw[i].trim();
			if (part.indexOf('cookieadmin_consent=') === 0) {
				try {
					return JSON.parse(decodeURIComponent(part.slice('cookieadmin_consent='.length)));
				} catch (e) {
					return null;
				}
			}
		}
		return null;
	}

	function allows(category) {
		var action = readConsentCookie();
		if (!action || typeof action !== 'object') {
			return false;
		}
		if (action.accept === 'true' || action.accept === true) {
			return true;
		}
		if (action.reject === 'true' || action.reject === true) {
			return false;
		}
		return action[category] === 'true' || action[category] === true;
	}

	function loadFbPixel(id) {
		if (!id || window.fbq) {
			return;
		}
		!(function (f, b, e, v, n, t, s) {
			if (f.fbq) return;
			n = f.fbq = function () {
				n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments);
			};
			if (!n.queue) n.queue = [];
			t = b.createElement(e);
			t.async = true;
			t.src = v;
			s = b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t, s);
		})(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
		window.fbq('init', id);
		window.fbq('track', 'PageView');
	}

	function loadGa4(id) {
		if (!id || window.gtag) {
			return;
		}
		var s = document.createElement('script');
		s.async = true;
		s.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(id);
		document.head.appendChild(s);
		window.gtag = function () {
			window.dataLayer.push(arguments);
		};
		window.gtag('js', new Date());
		window.gtag('config', id, { anonymize_ip: true });
	}

	function applyConsent() {
		var cfg = window.thryftTracking || {};
		if (allows('marketing') && cfg.fbPixelId) {
			loadFbPixel(cfg.fbPixelId);
		}
		if (allows('analytics') && cfg.ga4Id) {
			loadGa4(cfg.ga4Id);
		}
	}

	window.thryftEvent = function (name, payload) {
		payload = payload || {};
		window.dataLayer.push(Object.assign({ event: name }, payload));
		if (typeof window.gtag === 'function') {
			window.gtag('event', name, payload);
		}
		if (typeof window.fbq === 'function') {
			if (name === 'generate_lead') {
				window.fbq('track', 'Lead');
			} else {
				window.fbq('trackCustom', name, payload);
			}
		}
	};

	applyConsent();
	document.addEventListener('DOMContentLoaded', applyConsent);
	document.addEventListener('click', function (event) {
		var target = event.target;
		if (!target || !target.closest) {
			return;
		}
		if (target.closest('.cookieadmin_accept_btn, .cookieadmin_reject_btn, .cookieadmin_save_btn')) {
			window.setTimeout(applyConsent, 50);
			window.setTimeout(applyConsent, 400);
		}
		var link = target.closest('a');
		if (!link) {
			return;
		}
		if (link.hasAttribute('data-offer') || (link.pathname && link.pathname.indexOf('/go/') === 0)) {
			window.thryftEvent('click_offer', {
				slug: link.getAttribute('data-offer') || (link.pathname || '').replace(/^\/go\//, '').replace(/\/$/, ''),
			});
		}
		if ((link.getAttribute('href') || '').indexOf('tel:') === 0 || link.getAttribute('data-thryft-event') === 'click_to_call') {
			window.thryftEvent('click_to_call', { tel: link.getAttribute('href') || '' });
		}
	});
	window.setInterval(applyConsent, 4000);

	if (/[?&]contact=sent(?:&|$)/.test(window.location.search)) {
		window.thryftEvent('generate_lead', { form: 'quote' });
	}
})();
