<?php
get_header();
thryft_titlebar('Page not found', array(
	array('label' => 'Home', 'url' => home_url('/')),
	array('label' => 'Page not found', 'url' => ''),
), false);
?>
<div class="main-container">
	<div class="container">
		<p>The page you requested was not found.</p>
		<p><a class="requestaquote bluebtn" href="<?php echo esc_url(home_url('/')); ?>">Back to Home</a></p>
	</div>
</div>
<?php
thryft_get_in_touch();
get_footer();
