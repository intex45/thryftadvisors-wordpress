<?php
/**
 * Homepage — dual-door: Save primary, AI secondary.
 */
get_header();

$files = thryft_uri('files');
$posts = thryft_content()['posts'];
$contact_save = add_query_arg('intent', 'savings', home_url('/contact-us/'));
$contact_ai = add_query_arg('intent', 'ai', home_url('/contact-us/'));
?>
<div class="highlighted thryft-dual-hero"><div class="container">
	<div class="region region-highlighted">
		<section id="block-block-1" class="block block-block clearfix">
			<div class="row">
				<div class="col-md-7 col-sm-12 col-xs-12">
					<p class="thryft-brand-hero">Thryft Advisors</p>
					<h1>Cut what you spend. Shrink the work that wastes time.</h1>
					<p class="thryft-hero-support">We help US businesses lower recurring bills and recover cash on projects that should pay you back — and use AI where it actually shrinks the work.</p>
					<div class="whatwedodesc thryft-hero-ctas">
						<p>
							<a class="requestaquote bluebtn" href="<?php echo esc_url(home_url('/save/')); ?>">See ways to save</a>
							<a class="thryft-secondary-cta" href="<?php echo esc_url(home_url('/ai/')); ?>">AI for your business</a>
						</p>
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
					<section id="block-thryft-dual-doors" class="block block-thryft clearfix">
						<div class="row thryft-door-row">
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="thryft-door thryft-door-save">
									<h2>Save on costs</h2>
									<p>Recurring bills (processing, shipping, phones, waste, energy) and one-time recoveries (tax studies, settlements). Disclosed partners when a fit exists; advisors for messy files.</p>
									<p><a class="requestaquote bluebtn" href="<?php echo esc_url(home_url('/save/')); ?>">Explore savings</a>
									<a class="thryft-text-link" href="<?php echo esc_url($contact_save); ?>">Talk to an advisor</a></p>
								</div>
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="thryft-door thryft-door-ai">
									<h2>AI for workflows</h2>
									<p>Packaged help to pick, pilot, and operationalize AI in real SMB work — intake, support, admin, ops — not a chatbot landing page.</p>
									<p><a class="requestaquote bluebtn thryft-btn-secondary" href="<?php echo esc_url(home_url('/ai/')); ?>">See AI packages</a>
									<a class="thryft-text-link" href="<?php echo esc_url($contact_ai); ?>">Book an AI consult</a></p>
								</div>
							</div>
						</div>
					</section>
					<section id="block-imageblock-1" class="block block-imageblock clearfix">
						<div class="block-image">
							<img class="imageblock-image img-responsive" src="<?php echo esc_url($files . '/imageblock/AdobeStock_300167426.jpg'); ?>" alt="" />
						</div>
						<div class="block-body">
							<h2>How we get paid stays clear</h2>
							<p>On cost-savings pages we may earn a commission when you use a disclosed partner — that is advertising, at no extra cost to you. AI packages are advisory work billed separately. Read <a href="<?php echo esc_url(home_url('/how-we-make-money/')); ?>">how we make money</a>.</p>
							<p><a class="requestaquote bluebtn" href="<?php echo esc_url(home_url('/save/')); ?>">See ways to save</a></p>
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
				<h2>Two doors. One desk.</h2>
				<p>Start with the bill you want lower, or the workflow that eats hours. Phone and form stay for complex files — tell us whether you came for savings, AI, or both.</p>
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
						<?php
						$steps = array(
							array('Tell us the job', 'Pick Save or AI — or say you are unsure. A short call gathers enough to point you at the right path.'),
							array('Map the waste', 'For bills: where money leaks. For AI: which workflows burn time. No unsubstantiated scoreboard.'),
							array('Partner or package', 'Disclosed apply links when a partner fits. Advisor help for recoveries. Scan / Pilot / Embedding for AI — talk to us for scope.'),
							array('Follow through', 'We stay available for the messy follow-ups — statements, SOPs, handoffs — so the change sticks.'),
						);
						foreach ($steps as $i => $step) :
						?>
						<div class="col-md-3 col-sm-6 col-xs-12 slide views-row">
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
					<h2>Guides <span>worth reading</span></h2>
					<p><a href="<?php echo esc_url(home_url('/guides/')); ?>">Browse all guides</a></p>
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
