<?php
/**
 * News posts (Drupal article nodes).
 */
get_header();

the_post();
$title = get_the_title();
thryft_titlebar('Blog', array(
	array('label' => 'Home', 'url' => home_url('/')),
	array('label' => 'Blog', 'url' => ''),
));
$image = get_post_meta(get_the_ID(), '_thryft_image', true);
?>
<div class="main-container">
	<div class="container">
		<div class="row">
			<section class="col-sm-12">
				<a id="main-content"></a>
				<div class="region region-content">
					<article class="node node-article clearfix">
						<h1 class="page-header" style="font-size:32px;margin-bottom:20px;"><?php echo esc_html($title); ?></h1>
						<?php if ($image) : ?>
						<div class="field field-name-field-image">
							<img class="img-responsive" src="<?php echo esc_url(thryft_uri('files/' . $image)); ?>" alt="" />
						</div>
						<?php endif; ?>
						<div class="field field-name-body">
							<?php the_content(); ?>
						</div>
					</article>
				</div>
			</section>
		</div>
	</div>
</div>
<?php
thryft_get_in_touch();
get_footer();
