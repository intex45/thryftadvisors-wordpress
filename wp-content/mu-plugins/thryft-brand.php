<?php
/**
 * Plugin Name: Thryft Advisors brand
 * Description: Drupal-matching fonts, teal #21cbba, and logo on staging.
 */

if (!defined('ABSPATH')) {
	exit;
}

add_action('wp_enqueue_scripts', static function () {
	wp_enqueue_style(
		'thryft-fonts',
		'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@500;600;700;800&family=Raleway:wght@400;600;700&display=swap',
		array(),
		null
	);
	wp_register_style('thryft-brand', false, array('thryft-fonts'), '1.0.5');
	wp_enqueue_style('thryft-brand');
	wp_add_inline_style('thryft-brand', <<<'CSS'
body.popularfx-body, .pagelayer-body, .pagelayer-body p, .pagelayer-body li {
	font-family: Raleway, sans-serif !important;
	color: #000;
}
body.popularfx-body, .pagelayer-body, .site-content, .entry-content, #content, .content-area {
	background-color: #ffffff !important;
	color: #000000 !important;
}
.pagelayer-body h1, .pagelayer-body h2, .pagelayer-body h3, .pagelayer-body h4,
.entry-content h1, .entry-content h2, .entry-content h3, .entry-content h4 {
	font-family: Poppins, sans-serif !important;
	color: #000 !important;
}
.pagelayer-header .p-sy11564,
.pagelayer-header .p-ufg3368,
.pagelayer-header .p-fql9423 {
	display: none !important;
}
.pagelayer-header {
	background: #fff !important;
	box-shadow: 0 1px 4px rgba(0,0,0,.08);
}
.pagelayer-header .p-e8e2189,
.pagelayer-header .p-e8e2189 .pagelayer-col-holder,
.pagelayer-header .p-twx5302,
.pagelayer-header .p-twx5302 .pagelayer-col-holder {
	background: #fff !important;
}
.pagelayer-header a {
	color: #000 !important;
	font-family: Raleway, sans-serif !important;
}
.pagelayer-svg-top .pagelayer-shape-fill,
.pagelayer-svg-bottom .pagelayer-shape-fill {
	fill: #21cbba !important;
}
.pagelayer-btn, .pagelayer-btn-holder, a.pagelayer-btn-inner {
	background: #21cbba !important;
	border-color: #21cbba !important;
	color: #fff !important;
	border-radius: 35px !important;
}
footer, .pagelayer-footer {
	background: #21cbba !important;
	color: #000 !important;
}
footer a, .pagelayer-footer a {
	color: #000 !important;
}
.pagelayer-header .pagelayer-wp-title-heading {
	font-size: 0 !important;
	color: transparent !important;
	background: url('/wp-content/uploads/logo.png') no-repeat left center;
	background-size: contain;
	width: 220px;
	height: 52px;
}
.pagelayer-header .pagelayer-wp-title-link,
.pagelayer-header .pagelayer-heading-holder {
	max-width: 220px !important;
	width: 220px !important;
	display: block !important;
}
.pagelayer-header .pagelayer-wp_menu-ul {
	display: flex !important;
	flex-wrap: nowrap !important;
	justify-content: flex-end;
	align-items: center;
	margin: 0 !important;
	white-space: nowrap;
}
.pagelayer-header .pagelayer-wp_menu-ul > li {
	float: none !important;
	display: inline-block !important;
}
.pagelayer-header .pagelayer-wp_menu-ul > li > a {
	font-size: 16px !important;
	padding: 18px 10px !important;
	white-space: nowrap !important;
	line-height: 1.2 !important;
}
.pagelayer-header .pagelayer-wp_menu-ul > li:has(a[href*="/blog/"]),
.pagelayer-header .pagelayer-wp_menu-ul > li:has(a[href*="terms-conditions"]),
.pagelayer-header .pagelayer-wp_menu-ul > li:has(a[href*="privacy-policy"]) {
	display: none !important;
}
.pagelayer-header .p-y3v7335,
.pagelayer-header .p-pls7134 {
	display: none !important;
}
.p-ztd8674,
.p-oca1429,
.cookieadmin_law_container,
.cookieadmin_cookie_modal,
.cookieadmin-poweredby,
.pagelayer-footer a[href*="/blog/"] {
	display: none !important;
}
.pagelayer-footer .pagelayer-wp_menu-ul > li:has(a[href*="/blog/"]) {
	display: none !important;
}
.pagelayer-footer a[href*="facebook.com/sitepad"],
.pagelayer-header a[href*="facebook.com/sitepad"],
.pagelayer-header a[href*="twitter.com/sitepad"],
.pagelayer-header a[href*="instagram.com/sitepad"],
.pagelayer-header a[href*="linkedin.com/company/sitepad"] {
	display: none !important;
}
.pagelayer-phone,
a[href^="tel:"],
a[href*="888-316-6968"],
a[href*="8883166968"] {
	display: none !important;
}
.entry-content a[href*="contact-us"] {
	display: inline-block;
	background: #21cbba;
	color: #fff !important;
	padding: 7px 15px;
	border-radius: 35px;
	border: 2px solid #21cbba;
	text-decoration: none;
	font-weight: 800;
	margin: 0 8px 8px 0;
}
.entry-content a[href*="contact-us"]:hover {
	background: transparent;
	color: #21cbba !important;
}
CSS
	);
	wp_add_inline_script('jquery', <<<'JS'
document.addEventListener('DOMContentLoaded',function(){
	document.querySelectorAll('a[href^="tel:"], a[href*="888-316-6968"]').forEach(function(a){a.remove();});
	var logoUrl='/wp-content/uploads/logo.png';
	document.querySelectorAll('.pagelayer-header .p-l9r55 a, .pagelayer-header .pagelayer-logo, .pagelayer-header .pagelayer-heading-holder a').forEach(function(a){
		if(a.querySelector('img'))return;
		a.innerHTML='<img src="'+logoUrl+'" alt="Thryft Advisors" style="max-height:52px;width:auto;">';
	});
	document.querySelectorAll('.pagelayer-footer a').forEach(function(a){
		var t=(a.textContent||'').trim();
		if(t==='Organizational Development'||t==='Strategic Planning'||t==='Performance Improvement'||t==='Change Management'||t==='Training and Development'){
			a.closest('li')?a.closest('li').remove():a.remove();
		}
	});
	document.querySelectorAll('a[href*="contact@domain.com"]').forEach(function(a){
		a.href='mailto:admin@thryftadvisors.com';
		a.textContent='admin@thryftadvisors.com';
	});
	var dummyCol=document.querySelector('.pagelayer-footer .p-z0c8668 .pagelayer-col-holder');
	if(dummyCol){
		dummyCol.innerHTML='<h4 style="font-family:Poppins,sans-serif;margin:0 0 12px;">Atlanta</h4><p style="margin:0 0 8px;">3455 Peachtree Road NE<br>5th Floor<br>Atlanta, Georgia 30326</p><p style="margin:0;"><a href="mailto:admin@thryftadvisors.com">admin@thryftadvisors.com</a></p>';
	}
});
JS
	);
}, 99);

add_action('wp_head', static function () {
	echo "<style id=\"thryft-brand-late\">.pagelayer-header .pagelayer-wp-title-heading{background-image:url('/wp-content/uploads/logo.png')!important}.cookieadmin_law_container,.cookieadmin_cookie_modal,.cookieadmin-poweredby,.cookieadmin_reconsent,.p-oca1429,.pagelayer-footer a[href*=\"/blog/\"]{display:none!important}</style>\n";
}, 1000);

add_action('template_redirect', static function () {
	if (is_admin() || wp_doing_ajax()) {
		return;
	}
	$uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
	$path = rawurldecode((string) strtok($uri, '?'));
	$path = '/' . trim($path, '/');
	if ($path === '/') {
		return;
	}

	$redirects = array(
		'/contact' => '/contact-us/',
		'/welcome-thryft-advisors' => '/',
		'/news' => '/',
		'/blog' => '/',
		'/privacy-policy-2' => '/privacy-policy/',
		'/node/5' => '/',
		'/node/1' => '/about/',
		'/node/2' => '/contact-us/',
		'/node/3' => '/services/',
		'/node/4' => '/faq/',
		'/node/44' => '/terms-conditions/',
		'/node/45' => '/privacy-policy/',
		'/node/47' => '/think-you-cant-save-shipping-think-again/',
		'/node/48' => '/savings-oh-so-annoying-accounts-payable/',
		'/node/49' => '/cares-act-and-cost-segregation/',
		'/node/50' => '/services/tax-incentives/workforce-hiring-incentive/',
		'/node/51' => '/services/tax-incentives/r-d-tax-credit/',
		'/node/52' => '/services/tax-incentives/property-tax-mitigation/',
		'/node/53' => '/services/tax-incentives/cost-segregation/',
		'/node/54' => '/services/tax-incentives/',
		'/node/55' => '/services/specialized-savings/same-day-pay-employee-digital-wallet/',
		'/node/56' => '/services/specialized-savings/',
		'/node/57' => '/services/expense-reduction/',
		'/node/58' => '/services/specialized-savings/gas-electric-bills/',
		'/node/59' => '/services/specialized-savings/employee-health-benefits-billing-transparency/',
		'/node/60' => '/services/specialized-savings/class-action-claims/',
		'/node/61' => '/services/specialized-savings/accounts-payable-automation/',
		'/node/62' => '/services/expense-reduction/zero-cost-card-processing/',
		'/node/63' => '/services/expense-reduction/workers-comp-premium/',
		'/node/64' => '/services/expense-reduction/wireless-bills/',
		'/node/65' => '/services/expense-reduction/waste-recycle-bills/',
		'/node/66' => '/services/expense-reduction/shipping-freight-platform/',
		'/node/67' => '/services/expense-reduction/parcel-shipping-bills/',
		'/node/68' => '/services/expense-reduction/credit-card-fees/',
		'/node/69' => '/services/expense-reduction/copier-printer-charges/',
	);

	if (isset($redirects[$path])) {
		wp_safe_redirect(home_url($redirects[$path]), 301);
		exit;
	}

	if (preg_match('#^/privacy-policy-2$#', $path)) {
		wp_safe_redirect(home_url('/privacy-policy/'), 301);
		exit;
	}
	if (preg_match('#/services/expense-reduction/worker.s-comp-premium$#u', $path)
		&& strpos($path, '/workers-comp-premium') === false) {
		wp_safe_redirect(home_url('/services/expense-reduction/workers-comp-premium/'), 301);
		exit;
	}
});
