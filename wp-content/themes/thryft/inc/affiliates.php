<?php
/**
 * Disclosed affiliate helpers: footer copy, offer CTAs, and /go/{slug} cloaking.
 *
 * Destinations stay empty until a real partner URL is saved. Empty slugs fall
 * through to the advisor form — they must not invent a live paid program.
 */

if (!defined('ABSPATH')) {
	exit;
}

function thryft_go_links() {
	$defaults = array(
		'credit-card-fees' => array(
			'url' => '',
			'label' => 'Merchant services',
		),
		'zero-cost-processing' => array(
			'url' => '',
			'label' => 'Card acceptance review',
		),
		'merchant-services' => array(
			'url' => '',
			'label' => 'Merchant services',
		),
		'shipping' => array(
			'url' => '',
			'label' => 'Shipping platform',
		),
	);
	$stored = get_option('thryft_go_links', array());
	if (is_array($stored)) {
		foreach ($stored as $slug => $row) {
			if (!is_string($slug) || $slug === '') {
				continue;
			}
			$defaults[sanitize_title($slug)] = array(
				'url' => is_array($row) ? (string) ($row['url'] ?? '') : (string) $row,
				'label' => is_array($row) && !empty($row['label']) ? (string) $row['label'] : ($defaults[sanitize_title($slug)]['label'] ?? $slug),
			);
		}
	}
	foreach (array('credit-card-fees', 'zero-cost-processing', 'shipping', 'merchant-services') as $slug) {
		$opt = trim((string) get_option('thryft_go_url_' . str_replace('-', '_', $slug), ''));
		if ($opt !== '') {
			$defaults[$slug]['url'] = $opt;
		}
	}
	return apply_filters('thryft_go_links', $defaults);
}

function thryft_go_url($slug) {
	$slug = sanitize_title($slug);
	return home_url(user_trailingslashit('/go/' . $slug));
}

function thryft_disclosure_paragraph() {
	$money = home_url('/how-we-make-money/');
	return '<p class="thryft-disclosure"><strong>Advertising disclosure.</strong> Some recommendations on this site are advertisements. Thryft Advisors may earn a commission or referral fee if you use a partner we recommend, at no extra cost to you. Complex deals can still go through our advisor team by phone or form. <a href="' . esc_url($money) . '">How we make money</a>.</p>';
}

function thryft_offer_cta_html($go_slug) {
	$go_slug = sanitize_title($go_slug);
	$html = '<div class="thryft-offer-cta">';
	$html .= thryft_disclosure_paragraph();
	$html .= '<div class="btn-wrap">';
	$html .= '<div class="btn-sevices"><a class="thryft-offer-link" data-offer="' . esc_attr($go_slug) . '" rel="sponsored nofollow" href="' . esc_url(thryft_go_url($go_slug)) . '">See partner options</a></div>';
	$html .= '<div class="btn-sevices appointment"><a href="' . esc_url(add_query_arg('intent', 'savings', home_url('/contact-us/'))) . '">Talk to an advisor</a></div>';
	$html .= '</div>';
	$html .= '<p>Prefer the phone? Call <a href="tel:888-316-6968" data-thryft-event="click_to_call">888-316-6968</a>. Until a partner URL is assigned, “See partner options” reaches an advisor — we will not send you to a fake paid program.</p>';
	$html .= '</div>';
	return $html;
}

function thryft_seo_for_path($path) {
	$map = array(
		'/services/expense-reduction/credit-card-fees' => array(
			'title' => 'Credit Card Processing Fees for US Businesses | Thryft Advisors',
			'desc' => 'Understand interchange and merchant-statement markups. Compare a disclosed partner or talk to a Thryft advisor. We may earn a commission.',
		),
		'/services/expense-reduction/zero-cost-card-processing' => array(
			'title' => 'Dual Pricing and Card Acceptance Costs | Thryft Advisors',
			'desc' => 'Education on surcharge and dual-pricing rules — not 2013 legal advice. Get an advisor review or a disclosed processor partner path.',
		),
		'/services/expense-reduction/shipping-freight-platform' => array(
			'title' => 'Parcel and LTL Shipping Platform | Thryft Advisors',
			'desc' => 'Why multi-carrier shipping software cuts parcel and freight waste. Disclosed partner options plus advisor help for US shippers.',
		),
		'/privacy-policy' => array(
			'title' => 'Privacy Policy | Thryft Advisors',
			'desc' => 'How Thryft Advisors collects form data, uses cookies, and gates the Facebook Pixel and analytics behind CookieAdmin consent.',
		),
		'/terms-conditions' => array(
			'title' => 'Terms and Conditions | Thryft Advisors',
			'desc' => 'Terms for thryftadvisors.com, including advertising disclosures, advisor quotes, and limits of website content.',
		),
		'/how-we-make-money' => array(
			'title' => 'How We Make Money | Thryft Advisors',
			'desc' => 'Thryft Advisors is a hybrid advisor and disclosed affiliate. How partner commissions and advisor engagements work.',
		),
		'/save' => array(
			'title' => 'Ways to Save | Thryft Advisors',
			'desc' => 'Recurring bills and one-time recoveries for US businesses. Disclosed partners when under contract; advisors for complex files.',
		),
		'/ai' => array(
			'title' => 'AI Workflow Consulting | Thryft Advisors',
			'desc' => 'Scan, Pilot, and Embedding packages for SMB ops, intake, support, and admin. No public prices — book a consult.',
		),
		'/ai/scan' => array(
			'title' => 'AI Opportunity Scan | Thryft Advisors',
			'desc' => 'Map where AI helps vs does not across real SMB workflows. Talk to us to scope — no public package prices.',
		),
		'/ai/pilot' => array(
			'title' => 'AI Pilot Sprint | Thryft Advisors',
			'desc' => 'Time-boxed AI implementation for one workflow. Book a consult — pricing is not listed publicly.',
		),
		'/ai/embedding' => array(
			'title' => 'AI Ops Embedding | Thryft Advisors',
			'desc' => 'Ongoing AI advisory for playbooks, SOPs, and light automation. Talk to us — no public prices.',
		),
		'/guides' => array(
			'title' => 'Guides | Thryft Advisors',
			'desc' => 'Guides on payments, shipping, tax recoveries, and AI for SMB operations from Thryft Advisors.',
		),
	);
	$key = untrailingslashit($path);
	return $map[$key] ?? null;
}

function thryft_current_seo() {
	if (function_exists('thryft_current_path')) {
		return thryft_seo_for_path(thryft_current_path());
	}
	return null;
}

function thryft_set_siteseo_meta($post_id, $title, $desc) {
	if (!$post_id) {
		return;
	}
	update_post_meta($post_id, '_siteseo_titles_title', $title);
	update_post_meta($post_id, '_siteseo_titles_desc', $desc);
	update_post_meta($post_id, '_siteseo_social_fb_title', $title);
	update_post_meta($post_id, '_siteseo_social_fb_desc', $desc);
	update_post_meta($post_id, '_siteseo_social_twitter_title', $title);
	update_post_meta($post_id, '_siteseo_social_twitter_desc', $desc);
}

function thryft_allowed_go_hosts($hosts) {
	foreach (thryft_go_links() as $row) {
		if (empty($row['url'])) {
			continue;
		}
		$host = wp_parse_url($row['url'], PHP_URL_HOST);
		if (is_string($host) && $host !== '') {
			$hosts[] = $host;
		}
	}
	return $hosts;
}
add_filter('allowed_redirect_hosts', 'thryft_allowed_go_hosts');

function thryft_handle_go_slug($slug) {
	$slug = sanitize_title($slug);
	$links = thryft_go_links();
	$entry = isset($links[$slug]) ? $links[$slug] : null;
	$dest = is_array($entry) ? trim((string) ($entry['url'] ?? '')) : '';
	$dest = apply_filters('thryft_go_destination', $dest, $slug, $entry);

	nocache_headers();
	if (!headers_sent()) {
		header('X-Robots-Tag: noindex, nofollow', true);
	}

	if ($dest !== '') {
		$scheme = wp_parse_url($dest, PHP_URL_SCHEME);
		if (in_array($scheme, array('http', 'https'), true) && wp_http_validate_url($dest)) {
			$sep = (strpos($dest, '?') === false) ? '?' : '&';
			$dest .= $sep . 'utm_source=thryft&utm_medium=affiliate&utm_campaign=' . rawurlencode($slug);
			wp_safe_redirect($dest, 302);
			exit;
		}
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'from' => 'go-' . $slug,
				'intent' => 'savings',
			),
			home_url('/contact-us/')
		),
		302
	);
	exit;
}

function thryft_maybe_cloak_go() {
	if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
		return;
	}
	$req = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
	$path = '/' . trim((string) strtok($req, '?'), '/');
	if (!preg_match('#^/go/([a-z0-9-]+)$#', $path, $matches)) {
		return;
	}
	thryft_handle_go_slug($matches[1]);
}
add_action('template_redirect', 'thryft_maybe_cloak_go', 0);

add_action('admin_init', static function () {
	$slugs = array(
		'thryft_go_url_credit_card_fees' => 'Go link: /go/credit-card-fees/',
		'thryft_go_url_zero_cost_processing' => 'Go link: /go/zero-cost-processing/',
		'thryft_go_url_shipping' => 'Go link: /go/shipping/',
	);
	foreach ($slugs as $option => $label) {
		register_setting('general', $option, array(
			'type' => 'string',
			'sanitize_callback' => static function ($value) {
				$value = esc_url_raw(trim((string) $value));
				if ($value === '') {
					return '';
				}
				$scheme = wp_parse_url($value, PHP_URL_SCHEME);
				return in_array($scheme, array('http', 'https'), true) ? $value : '';
			},
			'default' => '',
		));
		add_settings_field(
			$option,
			$label,
			static function () use ($option) {
				$val = get_option($option, '');
				echo '<input type="url" class="regular-text" name="' . esc_attr($option) . '" value="' . esc_attr($val) . '" placeholder="https://" />';
				echo '<p class="description">Leave blank until a real partner program is approved. Blank sends /go/ visitors to the advisor form. Do not paste a fake paid destination.</p>';
			},
			'general'
		);
	}
});

