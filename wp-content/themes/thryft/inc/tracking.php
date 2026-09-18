<?php
/**
 * Consent-gated Facebook Pixel, optional GA4, and event helpers.
 *
 * GA4 loads only when a real measurement ID is saved (Settings → General, or
 * the THRYFT_GA4_MEASUREMENT_ID constant). Do not invent an ID.
 */

if (!defined('ABSPATH')) {
	exit;
}

function thryft_fb_pixel_id() {
	$id = apply_filters('thryft_fb_pixel_id', '157263089504378');
	return preg_replace('/[^0-9]/', '', (string) $id);
}

function thryft_ga4_measurement_id() {
	$id = '';
	if (defined('THRYFT_GA4_MEASUREMENT_ID')) {
		$id = (string) THRYFT_GA4_MEASUREMENT_ID;
	}
	if ($id === '') {
		$id = (string) get_option('thryft_ga4_measurement_id', '');
	}
	$id = strtoupper(trim($id));
	$id = apply_filters('thryft_ga4_measurement_id', $id);
	if ($id === '' || !preg_match('/^G-[A-Z0-9]+$/', $id)) {
		return '';
	}
	return $id;
}

add_action('admin_init', static function () {
	register_setting('general', 'thryft_ga4_measurement_id', array(
		'type' => 'string',
		'sanitize_callback' => static function ($value) {
			$value = strtoupper(sanitize_text_field((string) $value));
			if ($value === '') {
				return '';
			}
			return preg_match('/^G-[A-Z0-9]+$/', $value) ? $value : '';
		},
		'default' => '',
	));
	add_settings_field(
		'thryft_ga4_measurement_id',
		'Thryft GA4 measurement ID',
		static function () {
			$val = get_option('thryft_ga4_measurement_id', '');
			echo '<input type="text" class="regular-text" id="thryft_ga4_measurement_id" name="thryft_ga4_measurement_id" value="' . esc_attr($val) . '" placeholder="G-XXXXXXXX" autocomplete="off" />';
			echo '<p class="description">Leave blank until you have a real GA4 ID from Google Analytics. Consent-gated events still fire to <code>dataLayer</code> without it. Do not invent an ID.</p>';
		},
		'general'
	);
});

add_action('admin_notices', static function () {
	if (!current_user_can('manage_options')) {
		return;
	}
	$screen = function_exists('get_current_screen') ? get_current_screen() : null;
	if (!$screen || !in_array($screen->id, array('dashboard', 'options-general', 'themes'), true)) {
		return;
	}
	if (thryft_ga4_measurement_id() !== '') {
		return;
	}
	echo '<div class="notice notice-warning"><p><strong>Thryft Advisors:</strong> GA4 is wired behind CookieAdmin analytics consent, but no measurement ID is configured. Add one under Settings → General, or define <code>THRYFT_GA4_MEASUREMENT_ID</code>. Do not invent an ID. Map the Facebook Pixel (ID 157263089504378) to CookieAdmin’s Advertisement category and any future GA4 cookies to Analytical.</p></div>';
});

add_action('wp_enqueue_scripts', static function () {
	wp_enqueue_script('thryft-tracking', thryft_uri('js/tracking.js'), array(), '1.0.0', true);
	wp_localize_script('thryft-tracking', 'thryftTracking', array(
		'fbPixelId' => thryft_fb_pixel_id(),
		'ga4Id' => thryft_ga4_measurement_id(),
	));
}, 30);

add_action('wp_head', static function () {
	$seo = thryft_current_seo();
	if (!$seo || empty($seo['desc'])) {
		return;
	}
	if (defined('SITESEO_VERSION')) {
		return;
	}
	echo '<meta name="description" content="' . esc_attr($seo['desc']) . '" />' . "\n";
}, 1);

add_filter('document_title_parts', static function ($parts) {
	$seo = thryft_current_seo();
	if ($seo && !empty($seo['title'])) {
		$parts['title'] = $seo['title'];
		unset($parts['site']);
	}
	return $parts;
}, 20);
