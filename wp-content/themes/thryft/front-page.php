<?php
/**
 * Homepage — Drupal welcome node + blocks.
 */
get_header();

$files = thryft_uri('files');
$posts = thryft_content()['posts'];
$steps = array(
	array('Schedule', 'Our initial meeting is typically no more than 15 minutes to gather basic information about your company to determine which expense reduction solutions can best suite your needs.'),
	array('Identify', 'Our proprietary system enables us to identify which solutions will deliver the best savings opportunity for your business and walk through the savings range potential as no obligation to you.'),
	array('Verify', 'Our team of business process experts, intellectual property, attorneys, engineers, finance and tax specialists do a comprehensive assessment of your business data for expense reduction, tax incentive and specialized savings programs identified in the evaluations phase. They will then create all the supporting documents necessary to implements each benefit opportunity.'),
	array('Implement', 'Once your tax incentive, business expense reduction and specialized savings opportunities are confirmed, our team of implementation experts will work directly with your service providers and tax agencies to secure your project.'),
	array('Relax!', 'Our team will continue to serve as an audit monitor ensuring that you no longer are assessed fees or charges that don’t apply to your business.'),
);
?>
<div class="highlighted"><div class="container">
	<div class="region region-highlighted">
		<section id="block-block-1" class="block block-block clearfix">
			<div class="row">
				<div class="col-md-7 col-sm-12 col-xs-12">
					<h2>Reduce Your</h2>
					<h2>Business Costs</h2>
					<p>We review your operating costs and help you save money. It's that simple.</p>
					<div class="whatwedodesc">
						<p><a class="requestaquote bluebtn" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Request a Consultation</a></p>
					</div>
				</div>
				<div class="banner-design col-md-5 col-sm-12 col-xs-12">
					<p><img alt="" src="<?php echo esc_url($files . '/banner-design.png'); ?>" /></p>
				</div>
			</div>
		</section>
	</div>
</div></div>

<div class="main-container">
	<div class="container">
		<div class="row">
			<section class="col-sm-12">
				<a id="main-content"></a>
				<div class="region region-content">
					<section id="block-block-3" class="block block-block clearfix">
						<h2>Why Choose Us?</h2>
						<p>6 reasons to choose Thryft Advisors</p>
						<div class="row">
							<?php
							$reasons = array(
								array('icon-1.png', 'Comprehensive Review', 'We will review and audit your entire business operations to ensure all potential cost recovery solutions can be identified and quantified.'),
								array('icon-2.png', 'Team of Experts', 'Our team of Consultants, Engineers, IP Attorneys, and Expense Auditors will review your Company Operations in all industries.'),
								array('icon-3.png', 'Strategic Solutions', 'Our team runs a multi-point expense analysis to indentify overcharges and billing errors in your key business expense areas.'),
								array('icon-1.png', 'No Cost Consultation', 'There are no fees for our evaluations. Compensation is based only on the amount of savings and recovery identified.'),
								array('icon-2.png', 'Flexible Scheduling', 'We cater your cost recovery solutions to your timeframe and schedule.'),
								array('icon-3.png', 'Recurring Support', 'We are commited to delivering lifelong support to our clients, including recurring programs that will continue to reduce cost for the life of your business.'),
							);
							foreach ($reasons as $reason) :
							?>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="why-choose-box">
									<p><img alt="" src="<?php echo esc_url($files . '/' . $reason[0]); ?>" /></p>
									<h4><?php echo esc_html($reason[1]); ?></h4>
									<p><?php echo esc_html($reason[2]); ?></p>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
					</section>
					<section id="block-imageblock-1" class="block block-imageblock clearfix">
						<div class="block-image">
							<img class="imageblock-image img-responsive" src="<?php echo esc_url($files . '/imageblock/AdobeStock_300167426.jpg'); ?>" alt="" />
						</div>
						<div class="block-body">
							<h2>Your Business Cannot Afford To Be Stagnate</h2>
							<p>Technology and innovation is progressing at a rapid pace, challenging normal business practices. Due to COVID, this speed is increasing further. We have the experience and expterise to help guide you and your business through these challenging times.</p>
							<p><a class="requestaquote bluebtn" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Request a quote</a></p>
						</div>
					</section>
				</div>
			</section>
		</div>
	</div>
</div>

<div class="contentbottom"><div class="container">
	<div class="region region-contentbottom">
		<section id="block-imageblock-3" class="block block-imageblock clearfix">
			<div class="block-image">
				<img class="imageblock-image img-responsive" src="<?php echo esc_url($files . '/imageblock/iphone.png'); ?>" alt="" />
			</div>
			<div class="block-body">
				<h2>Our Results</h2>
				<p>With over 20 years of cost reduction and tax analysis experience, our team of Engineers, IP Attorneys, Tax Consultants, and Service Specialists can determine quickly and accurately how to increase your cash flow and reduce expenses.</p>
			</div>
		</section>
		<section id="block-block-4" class="block block-block clearfix">
			<div class="row">
				<div class="col-md-3 col-sm-6 col-xs-12"><div class="count count-1"><h4>60</h4><p>Our team consists of professionals with experience in over 60 industries.</p></div></div>
				<div class="col-md-3 col-sm-6 col-xs-12"><div class="count count-2"><h4>42</h4><p>Our business consultants have experience serving clients in 42 industries.</p></div></div>
				<div class="col-md-3 col-sm-6 col-xs-12"><div class="count count-3"><h4>5000</h4><p>Our team has served over 5,000+ businesses.</p></div></div>
				<div class="col-md-3 col-sm-6 col-xs-12"><div class="count count-4"><h4>2</h4><p>Our cost saving solutions have helped our clients reclaim over $2.7bln</p></div></div>
			</div>
		</section>
	</div>
</div></div>

<div class="howitworks"><div class="container">
	<div class="region region-howitworks">
		<section id="block-views-how-it-works-block" class="block block-views clearfix">
			<h2 class="block-title">How It Works</h2>
			<div class="view view-how-it-works">
				<div class="view-content">
					<div class="row">
						<?php foreach ($steps as $i => $step) : ?>
						<div class="col-md-15 col-sm-6 col-xs-12 slide views-row">
							<div class="views-field views-field-counter"><span class="field-content"><?php echo (int) ($i + 1); ?></span></div>
							<div class="views-field views-field-nothing">
								<div class="field-content howitworksbox">
									<h4><?php echo esc_html($step[0]); ?></h4>
									<?php echo esc_html($step[1]); ?>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>
	</div>
</div></div>

<div class="latestnews"><div class="container">
	<div class="region region-latestnews">
		<section id="block-views-latest-blog-block" class="block block-views clearfix">
			<div class="view view-latest-blog">
				<div class="view-header">
					<h2>We have <span>stories </span>for you</h2>
					<p>Find the latest news</p>
				</div>
				<div class="view-content">
					<?php foreach ($posts as $i => $post) :
						$n = $i + 1;
						$odd = $n % 2 ? 'views-row-odd' : 'views-row-even';
						$extra = $n === 1 ? ' views-row-first' : ($n === count($posts) ? ' views-row-last' : '');
						$url = home_url($post['path']);
						?>
					<div class="views-row views-row-<?php echo (int) $n; ?> <?php echo esc_attr($odd . $extra); ?> col-sm-6 col-xs-12">
						<div class="views-field views-field-field-image">
							<div class="field-content"><img class="img-responsive" src="<?php echo esc_url($files . '/' . $post['image']); ?>" alt="" /></div>
						</div>
						<div class="views-field views-field-nothing">
							<div class="field-content latestblog-box">
								<h3><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($post['title']); ?></a></h3>
								<div class="readmoreblog"><a href="<?php echo esc_url($url); ?>">Read More</a></div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	</div>
</div></div>

<?php
thryft_get_in_touch();
get_footer();
