<?php
/**
 * Thryft Advisors theme — Drupal 7 near-clone helpers, assets, and rewrites.
 */

if (!defined('ABSPATH')) {
	exit;
}

define('THRYFT_CONTENT_VERSION', 1);

function thryft_uri($relative = '') {
	return get_template_directory_uri() . '/' . ltrim($relative, '/');
}

function thryft_content() {
	static $data = null;
	if ($data === null) {
		$data = require get_template_directory() . '/inc/content.php';
	}
	return $data;
}

function thryft_services($category = null) {
	$items = thryft_content()['services'];
	if ($category) {
		$items = array_values(array_filter($items, static function ($row) use ($category) {
			return $row['category'] === $category;
		}));
	}
	return $items;
}

function thryft_service_by_slug($slug) {
	foreach (thryft_services() as $row) {
		if ($row['slug'] === $slug) {
			return $row;
		}
	}
	return null;
}

require_once get_template_directory() . '/inc/forms.php';
require_once get_template_directory() . '/inc/setup.php';

add_action('after_setup_theme', static function () {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
	register_nav_menus(array(
		'primary' => 'Primary',
	));
});

add_action('wp_enqueue_scripts', static function () {
	wp_enqueue_style('thryft-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css', array(), '3.4.1');
	wp_enqueue_style('thryft-fa', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0');
	wp_enqueue_style(
		'thryft-fonts',
		'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&family=Poppins:wght@500;600;700;800;900&family=Raleway:wght@400;500;600;700;800;900&display=swap',
		array(),
		null
	);
	wp_enqueue_style('thryft-style', thryft_uri('css/style.css'), array('thryft-bootstrap', 'thryft-fonts'), '1.0.0');
	wp_enqueue_style('thryft-custom', thryft_uri('css/custom.css'), array('thryft-style'), '1.0.0');
	wp_enqueue_style('thryft-wp', thryft_uri('css/wp.css'), array('thryft-custom'), '1.0.0');

	wp_enqueue_script('thryft-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js', array('jquery'), '3.4.1', true);
	wp_enqueue_script('thryft-script', thryft_uri('js/script.js'), array('jquery'), '1.0.0', true);
}, 20);

add_filter('document_title_parts', static function ($parts) {
	if (is_front_page()) {
		$parts['title'] = 'Welcome to THRYFT ADVISORS';
		$parts['site'] = 'Thryft Advisors';
	}
	return $parts;
});

add_action('wp_head', static function () {
	$icon = thryft_uri('files/fevicon.png');
	echo '<link rel="shortcut icon" href="' . esc_url($icon) . '" type="image/png" />' . "\n";
	?>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!n.queue)n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '157263089504378');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" src="https://www.facebook.com/tr?id=157263089504378&ev=PageView&noscript=1"/></noscript>
<!-- End Facebook Pixel Code -->
	<?php
}, 5);

add_filter('body_class', static function ($classes) {
	if (is_front_page()) {
		$classes[] = 'front';
		$classes[] = 'page-node';
		$classes[] = 'page-node-5';
		$classes[] = 'node-type-page';
	}
	if (is_page('about')) {
		$classes[] = 'page-node-1';
	}
	if (is_singular('post')) {
		$classes[] = 'node-type-article';
	}
	return $classes;
});

add_action('init', static function () {
	add_rewrite_rule(
		'^services/(expense-reduction|specialized-savings|tax-incentives)/([^/]+)/?$',
		'index.php?pagename=$matches[2]',
		'top'
	);
}, 5);

add_filter('page_link', static function ($link, $post_id) {
	$path = get_post_meta($post_id, '_thryft_path', true);
	if (is_string($path) && $path !== '') {
		return home_url(user_trailingslashit($path));
	}
	return $link;
}, 10, 2);

add_action('template_redirect', static function () {
	if (is_admin() || wp_doing_ajax() || !is_page() || is_front_page()) {
		return;
	}
	$path = get_post_meta(get_queried_object_id(), '_thryft_path', true);
	if (!$path || $path === '/') {
		return;
	}
	$req = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
	$req_path = '/' . trim((string) strtok($req, '?'), '/') . '/';
	$want = user_trailingslashit($path);
	if ($req_path !== $want && $req_path !== untrailingslashit($want) . '/') {
		// Allow the nested Drupal path through; bounce the short slug URL.
		if (!preg_match('#^/services/(expense-reduction|specialized-savings|tax-incentives)/#', $req_path)) {
			wp_safe_redirect(home_url($want), 301);
			exit;
		}
	}
});

function thryft_current_path() {
	$req = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '/';
	$path = '/' . trim((string) strtok($req, '?'), '/');
	return $path === '/' ? '/' : $path;
}

function thryft_nav_active($path) {
	$current = thryft_current_path();
	if ($path === '/') {
		return $current === '/';
	}
	return $current === $path || strpos($current, $path . '/') === 0;
}

function thryft_titlebar($title, $crumbs = array(), $show_quote = true) {
	$bg = thryft_uri('images/inner-banner.jpg');
	?>
<div class="titlebar" style="background: url('<?php echo esc_url($bg); ?>');">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-8">
				<h1 class="page-header"><?php echo esc_html($title); ?></h1>
				<ol class="breadcrumb">
					<?php foreach ($crumbs as $i => $crumb) :
						$last = ($i === count($crumbs) - 1);
						?>
					<li<?php echo $last ? ' class="active"' : ''; ?>>
						<?php if (!$last && !empty($crumb['url'])) : ?>
							<a href="<?php echo esc_url($crumb['url']); ?>"><?php echo esc_html($crumb['label']); ?></a>
						<?php else : ?>
							<?php echo esc_html($crumb['label']); ?>
						<?php endif; ?>
					</li>
					<?php endforeach; ?>
				</ol>
				<?php if ($show_quote) : ?>
				<div class="getquote"><a href="<?php echo esc_url(home_url('/contact-us/')); ?>">Request a quote</a></div>
				<?php endif; ?>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-4"></div>
		</div>
	</div>
</div>
	<?php
}

function thryft_service_listing($category) {
	$items = thryft_services($category);
	echo '<div class="view view-our-services view-id-our_services view-display-id-block_2"><div class="view-content">';
	$i = 0;
	foreach ($items as $row) {
		$i++;
		$odd = $i % 2 ? 'views-row-odd' : 'views-row-even';
		$first = $i === 1 ? ' views-row-first' : '';
		$last = $i === count($items) ? ' views-row-last' : '';
		$url = home_url($row['path']);
		?>
		<div class="views-row views-row-<?php echo (int) $i; ?> <?php echo esc_attr($odd . $first . $last); ?>">
			<div class="views-field views-field-nothing"><span class="field-content"><div class="row">
				<div class="col-sm-6 col-xs-12 video-box">
					<div class="video-wrap"><?php echo $row['video']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="services-content">
						<h2><?php echo esc_html($row['title']); ?></h2>
						<div class="short-content"><?php echo esc_html($row['teaser']); ?></div>
						<div class="btn-wrap">
							<div class="btn-sevices viewnode"><a href="<?php echo esc_url($url); ?>">Read More</a></div>
							<div class="btn-sevices appointment"><a href="<?php echo esc_url(home_url('/contact-us/')); ?>">Schedule an appointment</a></div>
						</div>
					</div>
				</div>
			</div></span></div>
		</div>
		<?php
	}
	echo '</div></div>';
}

function thryft_footer_service_links($category) {
	foreach (thryft_services($category) as $row) {
		$label = $row['title'];
		if ($row['slug'] === 'employee-health-benefits-billing-transparency') {
			$label = 'Employee Health Benefits';
		} elseif ($row['slug'] === 'same-day-pay-employee-digital-wallet') {
			$label = 'Same Day Pay';
		}
		echo '<li class="leaf"><a href="' . esc_url(home_url($row['path'])) . '">' . esc_html($label) . '</a></li>';
	}
}
