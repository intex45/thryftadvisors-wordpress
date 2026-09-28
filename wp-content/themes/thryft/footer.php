	<footer class="footer">
		<div class="container">
			<div class="region region-footer">
				<section id="block-block-7" class="block block-block clearfix">
					<p><img alt="" src="<?php echo esc_url(thryft_uri('files/logo_0.png')); ?>" /></p>
					<ul class="header-social-network">
						<li><a target="_blank" href="https://www.facebook.com/thryftadvisors/" class="fb tool-tip" title="Facebook" rel="noopener"><i class="fa fa-facebook"></i></a></li>
						<li><a target="_blank" href="https://www.linkedin.com/company/thryft-advisors/" class="linkedin tool-tip" title="Linkedin" rel="noopener"><i class="fa fa-linkedin"></i></a></li>
						<li><a target="_blank" href="https://www.instagram.com/thryftadvisors/" class="instagram tool-tip" title="Instagram" rel="noopener"><i class="fa fa-instagram"></i></a></li>
					</ul>
				</section>
			</div>
			<div class="region region-footer-middle">
				<section id="block-system-main-menu" class="block block-system block-menu clearfix">
					<h2 class="block-title">Main Links</h2>
					<ul class="menu nav">
						<li class="first leaf"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
						<li class="leaf"><a href="<?php echo esc_url(home_url('/save/')); ?>">Save</a></li>
						<li class="leaf"><a href="<?php echo esc_url(home_url('/ai/')); ?>">AI workflows</a></li>
						<li class="leaf"><a href="<?php echo esc_url(home_url('/guides/')); ?>">Guides</a></li>
						<li class="leaf"><a href="<?php echo esc_url(home_url('/about/')); ?>">About</a></li>
						<li class="leaf"><a href="<?php echo esc_url(home_url('/contact-us/')); ?>">Contact</a></li>
						<li class="last leaf"><a href="<?php echo esc_url(home_url('/how-we-make-money/')); ?>">How we make money</a></li>
					</ul>
				</section>
				<section id="block-menu-menu-expense-reduction" class="block block-menu clearfix">
					<h2 class="block-title">Recurring bills</h2>
					<ul class="menu nav"><?php thryft_footer_service_links('expense-reduction'); ?></ul>
				</section>
				<section id="block-menu-menu-specialized-savings" class="block block-menu clearfix">
					<h2 class="block-title">Specialized &amp; AI</h2>
					<ul class="menu nav">
						<?php thryft_footer_service_links('specialized-savings'); ?>
						<li class="leaf"><a href="<?php echo esc_url(home_url('/ai/scan/')); ?>">AI Opportunity Scan</a></li>
						<li class="leaf"><a href="<?php echo esc_url(home_url('/ai/pilot/')); ?>">AI Pilot Sprint</a></li>
						<li class="leaf"><a href="<?php echo esc_url(home_url('/ai/embedding/')); ?>">Ops Embedding</a></li>
					</ul>
				</section>
				<section id="block-menu-menu-tax-incentives" class="block block-menu clearfix">
					<h2 class="block-title">One-time recoveries</h2>
					<ul class="menu nav"><?php thryft_footer_service_links('tax-incentives'); ?></ul>
				</section>
			</div>
		</div>
	</footer>
	<div class="footerbuttom">
		<div class="container">
			<div class="region region-footer-bottom">
				<section id="block-block-8" class="block block-block clearfix">
					<p><a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>">Terms &amp; Conditions</a>&nbsp;&nbsp; |&nbsp;&nbsp; <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a>&nbsp;&nbsp; |&nbsp;&nbsp; <a href="<?php echo esc_url(home_url('/how-we-make-money/')); ?>">How we make money</a></p>
					<?php echo thryft_disclosure_paragraph(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<p>2026 © Thryft Advisors. All rights reserved.</p>
				</section>
			</div>
		</div>
	</div>
<?php wp_footer(); ?>
</body>
</html>
