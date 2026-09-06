<?php
/**
 * Plugin Name: Thryft Advisors brand
 * Description: Drupal-matching fonts, teal #21cbba, logo, and phone on staging.
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
	wp_register_style('thryft-brand', false, array('thryft-fonts'), '1.0.0');
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
.pagelayer-header .p-ufg3368 {
	display: none !important;
}
.pagelayer-header {
	background: #fff !important;
	box-shadow: 0 1px 4px rgba(0,0,0,.08);
}
.pagelayer-header .p-e8e2189,
.pagelayer-header .p-e8e2189 .pagelayer-col-holder {
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
.pagelayer-phone {
	font-size: 0 !important;
}
.pagelayer-phone::after {
	content: "888-316-6968";
	font-size: 16px;
	font-weight: 700;
	font-family: Poppins, sans-serif;
	color: #000;
}
.entry-content a[href*="contact-us"],
.entry-content a[href^="tel:"] {
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
.entry-content a[href*="contact-us"]:hover,
.entry-content a[href^="tel:"]:hover {
	background: transparent;
	color: #21cbba !important;
}
CSS
	);
	wp_add_inline_script('jquery', "document.addEventListener('DOMContentLoaded',function(){document.querySelectorAll('a[href=\"tel:+1234567890\"]').forEach(function(a){a.href='tel:888-316-6968';});});");
}, 99);
