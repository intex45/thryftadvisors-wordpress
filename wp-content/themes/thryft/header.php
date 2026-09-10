<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
</head>
<body <?php body_class('html not-logged-in no-sidebars'); ?>>
<?php wp_body_open(); ?>
<div id="skip-link">
	<a href="#main-content" class="element-invisible element-focusable">Skip to main content</a>
</div>
<header id="navbar" role="banner" class="navbar navbar-default">
	<div class="container">
		<div class="row">
			<div class="navbar-header col-xs-12 col-sm-3 col-md-3">
				<a class="logo navbar-btn pull-left" href="<?php echo esc_url(home_url('/')); ?>" title="Home">
					<img src="<?php echo esc_url(thryft_uri('files/logo.png')); ?>" alt="Home" />
				</a>
				<div class="mobilemailus">
					<a class="hd-cta-callus" href="tel:888-316-6968"><img src="<?php echo esc_url(thryft_uri('images/call-32.png')); ?>" alt=""></a>
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
						<div class="hamburger hamburger--elastic js-hamburger">
							<div class="hamburger-box">
								<div class="hamburger-inner"></div>
							</div>
						</div>
					</button>
				</div>
			</div>
			<div class="navbar-header col-xs-12 col-sm-5 col-md-5">
				<div class="navbar-collapse collapse" id="navbar-collapse">
					<nav role="navigation">
						<ul class="menu nav navbar-nav">
							<li class="first leaf<?php echo thryft_nav_active('/') ? ' active' : ''; ?>"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
							<li class="leaf<?php echo thryft_nav_active('/about') ? ' active' : ''; ?>"><a href="<?php echo esc_url(home_url('/about/')); ?>">About</a></li>
							<li class="leaf<?php echo thryft_nav_active('/contact-us') ? ' active' : ''; ?>"><a href="<?php echo esc_url(home_url('/contact-us/')); ?>">Contact Us</a></li>
							<li class="expanded dropdown<?php echo (thryft_nav_active('/services') || thryft_nav_active('/expense-reduction') || thryft_nav_active('/specialized-savings') || thryft_nav_active('/tax-incentives')) ? ' active' : ''; ?>">
								<a href="<?php echo esc_url(home_url('/services/')); ?>" class="dropdown-toggle" data-toggle="dropdown">Services <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li class="first leaf"><a href="<?php echo esc_url(home_url('/expense-reduction/')); ?>">Expense Reduction</a></li>
									<li class="leaf"><a href="<?php echo esc_url(home_url('/specialized-savings/')); ?>">Specialized Savings</a></li>
									<li class="last leaf"><a href="<?php echo esc_url(home_url('/tax-incentives/')); ?>">Tax Incentives</a></li>
								</ul>
							</li>
							<li class="last leaf<?php echo thryft_nav_active('/faq') ? ' active' : ''; ?>"><a href="<?php echo esc_url(home_url('/faq/')); ?>">FAQ</a></li>
						</ul>
					</nav>
				</div>
			</div>
			<div class="navbar-cta col-xs-12 col-sm-4 col-md-4">
				<div class="hd-cta">
					<a class="hd-cta-callus" href="tel:888-316-6968">888-316-6968</a>
					<a class="hd-cta-emailus" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Request a quote</a>
				</div>
			</div>
		</div>
	</div>
</header>
