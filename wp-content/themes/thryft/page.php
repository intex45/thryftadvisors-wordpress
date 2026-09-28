<?php
/**
 * Inner pages — Drupal titlebar + node body, with special layouts for About, Contact, FAQ, hubs, and service landings.
 */
get_header();

the_post();

$slug = get_post_field('post_name', get_the_ID());
$title = get_the_title();
$home = home_url('/');
$is_contact = ($slug === 'contact-us');
$is_about = ($slug === 'about');
$is_faq = ($slug === 'faq');
$is_save_hub = ($slug === 'save');
$is_services_hub = ($slug === 'services');
$is_ai_hub = ($slug === 'ai');
$is_guides = ($slug === 'guides');
$ai_package = thryft_ai_package_by_slug($slug);
$categories = array('expense-reduction' => 'Expense Reduction', 'specialized-savings' => 'Specialized Savings', 'tax-incentives' => 'Tax Incentives');
$is_category = isset($categories[$slug]);
$service = thryft_service_by_slug($slug);

$crumbs = array(
	array('label' => 'Home', 'url' => $home),
);
if ($service) {
	$crumbs[] = array('label' => 'Save', 'url' => home_url('/save/'));
	$crumbs[] = array('label' => $title, 'url' => '');
} elseif ($ai_package) {
	$crumbs[] = array('label' => 'AI', 'url' => home_url('/ai/'));
	$crumbs[] = array('label' => $title, 'url' => '');
} elseif ($is_category) {
	$crumbs[] = array('label' => 'Save', 'url' => home_url('/save/'));
	$crumbs[] = array('label' => $title, 'url' => '');
} elseif ($is_save_hub || $is_services_hub) {
	$crumbs[] = array('label' => 'Save', 'url' => '');
} elseif ($is_ai_hub) {
	$crumbs[] = array('label' => 'AI', 'url' => '');
} else {
	$crumbs[] = array('label' => $title, 'url' => '');
}

$show_quote = ! $is_contact;
$bar_title = $is_faq ? 'FAQ' : ($is_save_hub || $is_services_hub ? 'Save' : $title);
thryft_titlebar($bar_title, $crumbs, $show_quote);
?>

<div class="main-container">
	<div class="container">
		<div class="row">
			<section class="col-sm-12">
				<a id="main-content"></a>
				<div class="region region-content">
					<?php if ($is_about) : ?>
						<section id="block-imageblock-4" class="block block-imageblock clearfix">
							<h2 class="block-title">Two pillars. One desk.</h2>
							<div class="block-image">
								<img class="imageblock-image img-responsive" src="<?php echo esc_url(thryft_uri('files/imageblock/shutterstock_1715564146_new_1.jpg')); ?>" alt="" />
							</div>
							<div class="block-body">
								<h2 class="rtecenter">Our Mission</h2>
								<div class="row">
									<div class="col-md-4 col-sm-6 col-xs-12"><div class="why-choose-box">
										<p><img alt="" src="<?php echo esc_url(thryft_uri('files/icon-1.png')); ?>" /></p>
										<h4>Cost savings</h4>
										<p>Disclosed partners for recurring bills when a fit exists; advisors for recoveries and messy files.</p>
									</div></div>
									<div class="col-md-4 col-sm-6 col-xs-12"><div class="why-choose-box">
										<p><img alt="" src="<?php echo esc_url(thryft_uri('files/icon-2.png')); ?>" /></p>
										<h4>AI workflows</h4>
										<p>Scan, Pilot, and Embedding for SMB ops — talk to us for scope. No public package prices.</p>
									</div></div>
									<div class="col-md-4 col-sm-6 col-xs-12"><div class="why-choose-box">
										<p><img alt="" src="<?php echo esc_url(thryft_uri('files/icon-3.png')); ?>" /></p>
										<h4>Clear pay story</h4>
										<p>Affiliate commissions and consulting fees stay labeled. Read how we make money.</p>
									</div></div>
								</div>
							</div>
						</section>
						<section id="block-system-main" class="block block-system clearfix">
							<article class="node node-page clearfix">
								<?php the_content(); ?>
							</article>
						</section>
					<?php elseif ($is_contact) : ?>
						<section id="block-block-5" class="block block-block clearfix">
							<h2 class="block-title">Information</h2>
							<h3>Georgia, <strong>United States</strong></h3>
							<p>3455 Peachtree Road North East, 5th Floor, Atlanta, Georgia 30326</p>
							<p><a href="mailto:info@thryftadvisors.com">info@thryftadvisors.com</a></p>
							<h4><a href="tel:888-316-6968">888-316-6968</a></h4>
							<p>Tell us whether you need cost savings, AI workflows, or you are unsure — the form keeps those funnels separate.</p>
						</section>
						<?php thryft_render_form('Get In Touch'); ?>
						<section id="block-imageblock-2" class="block block-imageblock clearfix">
							<h2 class="block-title">How Can We Help You?</h2>
							<div class="block-image">
								<img class="imageblock-image img-responsive" src="<?php echo esc_url(thryft_uri('files/imageblock/cta-2.jpg')); ?>" alt="" />
							</div>
							<div class="block-body">
								<p>As owners and managers of businesses, we believe you should be empowered to make the right decisions to ensure longevity of your organization. Feel free to contact us with any questions or concerns you have and we'll make it right by you.</p>
							</div>
						</section>
					<?php elseif ($is_save_hub || $is_services_hub) : ?>
						<section id="block-thryft-save-hub" class="block block-thryft clearfix">
							<?php if ($is_services_hub) : ?>
								<p class="thryft-form-note">This page moved. Prefer <a href="<?php echo esc_url(home_url('/save/')); ?>">/save/</a> — the cost-savings hub. Nested service URLs are unchanged.</p>
							<?php endif; ?>
							<?php echo thryft_save_hub_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</section>
					<?php elseif ($is_ai_hub) : ?>
						<section id="block-thryft-ai-hub" class="block block-thryft clearfix">
							<?php echo thryft_ai_hub_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</section>
					<?php elseif ($is_guides) : ?>
						<section id="block-thryft-guides-hub" class="block block-thryft clearfix">
							<?php echo thryft_guides_hub_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</section>
					<?php elseif ($is_category) : ?>
						<section id="block-views-our-services-block-2" class="block block-views clearfix">
							<?php thryft_service_listing($slug); ?>
						</section>
					<?php else : ?>
						<section id="block-system-main" class="block block-system clearfix">
							<article class="node node-page clearfix">
								<?php the_content(); ?>
							</article>
						</section>
					<?php endif; ?>
				</div>
			</section>
		</div>
	</div>
</div>

<?php if ($is_contact) : ?>
<div class="googlemap">
	<div class="region region-googlemap">
		<section id="block-block-6" class="block block-block clearfix">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3313.5315794939506!2d-84.36239068479027!3d33.85018878066151!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88f50f56b89dd52f%3A0xdbd260d883e30e53!2s3455%20Peachtree%20Rd%20NE%205th%20Floor%2C%20Atlanta%2C%20GA%2030326%2C%20USA!5e0!3m2!1sen!2sin!4v1609315826015!5m2!1sen!2sin" width="100%" height="550" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
		</section>
	</div>
</div>
<?php elseif (! $is_contact) : ?>
	<?php thryft_get_in_touch(); ?>
<?php endif; ?>

<?php get_footer(); ?>
