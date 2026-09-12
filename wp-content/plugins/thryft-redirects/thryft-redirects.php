<?php
/**
 * Plugin Name: Thryft Advisors redirects
 * Description: Drupal URL 301s, cookie-banner hide, and workers-comp slug normalization for the Thryft theme. Same code as the must-use plugin; upload this if you do not have File Manager access to mu-plugins.
 * Version: 2.0.0
 */

if (!defined('ABSPATH')) {
	exit;
}
if (defined('THRYFT_REDIRECTS_LOADED')) {
	return;
}
define('THRYFT_REDIRECTS_LOADED', true);

add_action('wp_head', static function () {
	echo '<style id="thryft-chrome">.cookieadmin_law_container,.cookieadmin_cookie_modal,.cookieadmin-poweredby,.cookieadmin_reconsent{display:none!important}</style>' . "\n";
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
		'/services/expense-reduction' => '/expense-reduction/',
		'/services/specialized-savings' => '/specialized-savings/',
		'/services/tax-incentives' => '/tax-incentives/',
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
		'/node/54' => '/tax-incentives/',
		'/node/55' => '/services/specialized-savings/same-day-pay-employee-digital-wallet/',
		'/node/56' => '/specialized-savings/',
		'/node/57' => '/expense-reduction/',
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

	if (preg_match('#/services/expense-reduction/worker.s-comp-premium$#u', $path)
		&& strpos($path, '/workers-comp-premium') === false) {
		wp_safe_redirect(home_url('/services/expense-reduction/workers-comp-premium/'), 301);
		exit;
	}
});
