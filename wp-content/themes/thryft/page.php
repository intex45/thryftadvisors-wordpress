<?php
/**
 * Inner pages — Drupal titlebar + node body, with special layouts for About, Contact, FAQ, and service landings.
 */
get_header();

the_post();

$slug = get_post_field('post_name', get_the_ID());
$title = get_the_title();
$home = home_url('/');
$is_contact = ($slug === 'contact-us');
$is_about = ($slug === 'about');
$is_faq = ($slug === 'faq');
$categories = array('expense-reduction' => 'Expense Reduction', 'specialized-savings' => 'Specialized Savings', 'tax-incentives' => 'Tax Incentives');
$is_category = isset($categories[$slug]);
$service = thryft_service_by_slug($slug);

$crumbs = array(
	array('label' => 'Home', 'url' => $home),
);
if ($service) {
	$crumbs[] = array('label' => $title, 'url' => '');
} elseif ($is_category) {
	$crumbs[] = array('label' => 'Services', 'url' => home_url('/services/'));
	$crumbs[] = array('label' => $title, 'url' => '');
} else {
	$crumbs[] = array('label' => $title, 'url' => '');
}

$show_quote = ! $is_contact;
thryft_titlebar($is_faq ? 'FAQ' : $title, $crumbs, $show_quote);
?>

<div class="main-container">
	<div class="container">
		<div class="row">
			<section class="col-sm-12">
				<a id="main-content"></a>
				<div class="region region-content">
					<?php if ($is_about) : ?>
						<section id="block-imageblock-4" class="block block-imageblock clearfix">
							<h2 class="block-title">We Work Hard For You</h2>
							<div class="block-image">
								<img class="imageblock-image img-responsive" src="<?php echo esc_url(thryft_uri('files/imageblock/shutterstock_1715564146_new_1.jpg')); ?>" alt="" />
							</div>
							<div class="block-body">
								<h2 class="rtecenter">Our Mission</h2>
								<div class="row">
									<div class="col-md-4 col-sm-6 col-xs-12"><div class="why-choose-box">
										<p><img alt="" src="<?php echo esc_url(thryft_uri('files/icon-1.png')); ?>" /></p>
										<h4>Personalized Service</h4>
										<p>We know what it's like to be a business owner, so we take care of it's most important asset: You.</p>
									</div></div>
									<div class="col-md-4 col-sm-6 col-xs-12"><div class="why-choose-box">
										<p><img alt="" src="<?php echo esc_url(thryft_uri('files/icon-2.png')); ?>" /></p>
										<h4>Best practices/guidance</h4>
										<p>Upfront and transparent pricing before committing to any service.</p>
									</div></div>
									<div class="col-md-4 col-sm-6 col-xs-12"><div class="why-choose-box">
										<p><img alt="" src="<?php echo esc_url(thryft_uri('files/icon-3.png')); ?>" /></p>
										<h4>Targeted Efforts</h4>
										<p>We won't waste your time with savings that won't help you meet your target.</p>
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
