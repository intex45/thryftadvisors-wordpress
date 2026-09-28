<?php
/**
 * Thryft Advisors theme — Drupal 7 near-clone helpers, assets, and rewrites.
 */

if (!defined('ABSPATH')) {
	exit;
}

define('THRYFT_CONTENT_VERSION', 5);
define('THRYFT_AFFILIATE_SLICE', 1);
define('THRYFT_DUAL_PILLAR_SLICE', 1);

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
require_once get_template_directory() . '/inc/affiliates.php';
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/tracking.php';

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
	wp_enqueue_style('thryft-wp', thryft_uri('css/wp.css'), array('thryft-custom'), '1.3.0');

	wp_enqueue_script('thryft-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js', array('jquery'), '3.4.1', true);
	wp_enqueue_script('thryft-script', thryft_uri('js/script.js'), array('jquery'), '1.0.1', true);
}, 20);

add_filter('document_title_parts', static function ($parts) {
	if (is_front_page()) {
		$parts['title'] = 'Thryft Advisors — Cost savings and AI workflows';
		$parts['site'] = 'Thryft Advisors';
	}
	return $parts;
});

add_action('wp_head', static function () {
	$icon = thryft_uri('files/fevicon.png');
	echo '<link rel="shortcut icon" href="' . esc_url($icon) . '" type="image/png" />' . "\n";
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
	add_rewrite_rule(
		'^ai/(scan|pilot|embedding)/?$',
		'index.php?pagename=$matches[1]',
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
		if (!preg_match('#^/services/(expense-reduction|specialized-savings|tax-incentives)/#', $req_path)
			&& !preg_match('#^/ai/(scan|pilot|embedding)/#', $req_path)) {
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
				<div class="getquote"><a href="<?php echo esc_url(home_url('/save/')); ?>">See ways to save</a></div>
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
							<div class="btn-sevices appointment"><a href="<?php echo esc_url(add_query_arg('intent', 'savings', home_url('/contact-us/'))); ?>">Schedule an appointment</a></div>
						</div>
					</div>
				</div>
			</div></span></div>
		</div>
		<?php
	}
	echo '</div></div>';
}

function thryft_service_hub_groups() {
	return array(
		array(
			'key' => 'recurring',
			'title' => 'Recurring bills',
			'intro' => 'Monthly costs you can compare and, when a partner is under contract, apply through a disclosed referral. Messy files still go to an advisor.',
			'slugs' => array(
				'credit-card-fees',
				'zero-cost-card-processing',
				'parcel-shipping-bills',
				'shipping-freight-platform',
				'wireless-bills',
				'waste-recycle-bills',
				'gas-electric-bills',
				'copier-printer-charges',
				'workers-comp-premium',
				'accounts-payable-automation',
			),
		),
		array(
			'key' => 'one-time',
			'title' => 'One-time recoveries',
			'intro' => 'Project work — tax studies, hiring credits, settlements, and similar recoveries. These stay with the advisor team. They are not a click-out campaign.',
			'slugs' => array(
				'cost-segregation',
				'r-d-tax-credit',
				'workforce-hiring-incentive',
				'property-tax-mitigation',
				'class-action-claims',
				'same-day-pay-employee-digital-wallet',
				'employee-health-benefits-billing-transparency',
			),
		),
	);
}

function thryft_ai_packages() {
	return thryft_content()['ai_packages'] ?? array();
}

function thryft_ai_package_by_slug($slug) {
	foreach (thryft_ai_packages() as $row) {
		if ($row['slug'] === $slug) {
			return $row;
		}
	}
	return null;
}

function thryft_save_hub_html() {
	$by_slug = array();
	foreach (thryft_services() as $row) {
		$by_slug[$row['slug']] = $row;
	}

	$html = '<div class="thryft-services-hub thryft-save-hub">';
	$html .= '<div class="thryft-hub-intro">';
	$html .= '<h2>Ways to save</h2>';
	$html .= '<p>Recurring bills can go through a disclosed partner when one is under contract, or an advisor when the file is messy. One-time recoveries stay with the advisor team. Nested offer URLs under <code>/services/</code> still work; this hub is the front door.</p>';
	$html .= '<p><a class="requestaquote bluebtn" href="' . esc_url(add_query_arg('intent', 'savings', home_url('/contact-us/'))) . '">Talk to an advisor</a> ';
	$html .= '<a class="thryft-text-link" href="' . esc_url(home_url('/how-we-make-money/')) . '">How we get paid</a></p>';
	$html .= '</div>';

	foreach (thryft_service_hub_groups() as $group) {
		$html .= '<div class="thryft-hub-group thryft-hub-group-' . esc_attr($group['key']) . '">';
		$html .= '<h2>' . esc_html($group['title']) . '</h2>';
		$html .= '<p class="thryft-hub-group-intro">' . esc_html($group['intro']) . '</p>';
		$html .= '<div class="row">';
		foreach ($group['slugs'] as $slug) {
			if (empty($by_slug[$slug])) {
				continue;
			}
			$row = $by_slug[$slug];
			$url = home_url($row['path']);
			$teaser = wp_trim_words(wp_strip_all_tags($row['teaser']), 22, '…');
			$html .= '<div class="col-md-4 col-sm-6 col-xs-12">';
			$html .= '<div class="thryft-hub-card">';
			$html .= '<h3><a href="' . esc_url($url) . '">' . esc_html($row['title']) . '</a></h3>';
			$html .= '<p>' . esc_html($teaser) . '</p>';
			$html .= '<div class="btn-wrap"><div class="btn-sevices viewnode"><a href="' . esc_url($url) . '">Read More</a></div></div>';
			$html .= '</div></div>';
		}
		$html .= '</div></div>';
	}

	$html .= '</div>';
	return $html;
}

/** @deprecated Alias — Save hub replaced the bare /services/ landing. */
function thryft_services_hub_html() {
	return thryft_save_hub_html();
}

function thryft_ai_hub_html() {
	$html = '<div class="thryft-ai-hub">';
	$html .= '<div class="thryft-hub-intro">';
	$html .= '<h2>AI for real SMB workflows</h2>';
	$html .= '<p>Thryft Advisors packages AI advisory around operations work — intake, support, admin, quoting, scheduling, reporting — not a chatbot landing page. Three packages: Scan, Pilot, and Embedding. <strong>No public prices</strong>; CTA is always talk to us / book a consult.</p>';
	$html .= '<p><a class="requestaquote bluebtn" href="' . esc_url(add_query_arg('intent', 'ai', home_url('/contact-us/'))) . '">Book an AI consult</a> ';
	$html .= '<a class="thryft-text-link" href="' . esc_url(home_url('/save/')) . '">Prefer cost savings?</a></p>';
	$html .= '</div>';
	$html .= '<div class="row">';
	foreach (thryft_ai_packages() as $row) {
		$url = home_url($row['path']);
		$html .= '<div class="col-md-4 col-sm-6 col-xs-12">';
		$html .= '<div class="thryft-hub-card thryft-ai-card">';
		$html .= '<h3><a href="' . esc_url($url) . '">' . esc_html($row['title']) . '</a></h3>';
		$html .= '<p>' . esc_html($row['summary']) . '</p>';
		$html .= '<div class="btn-wrap"><div class="btn-sevices viewnode"><a href="' . esc_url($url) . '">Package details</a></div>';
		$html .= '<div class="btn-sevices appointment"><a href="' . esc_url(add_query_arg('intent', 'ai', home_url('/contact-us/'))) . '">Talk to us</a></div></div>';
		$html .= '</div></div>';
	}
	$html .= '</div>';
	$html .= '<p class="thryft-ai-note">AI pages sell expertise and scope. Partner / affiliate buttons stay on cost-savings offer pages with disclosure — not here.</p>';
	$html .= '</div>';
	return $html;
}

function thryft_guides_hub_html() {
	$posts = thryft_content()['posts'];
	$html = '<div class="thryft-guides-hub">';
	$html .= '<div class="thryft-hub-intro">';
	$html .= '<h2>Guides</h2>';
	$html .= '<p>Short reads on payments, shipping, tax recoveries, and where AI meets ops. A fuller resources index can follow later.</p>';
	$html .= '</div><div class="row">';
	foreach ($posts as $post) {
		$url = home_url($post['path']);
		$html .= '<div class="col-md-4 col-sm-6 col-xs-12">';
		$html .= '<div class="thryft-hub-card">';
		$html .= '<h3><a href="' . esc_url($url) . '">' . esc_html($post['title']) . '</a></h3>';
		$html .= '<div class="btn-wrap"><div class="btn-sevices viewnode"><a href="' . esc_url($url) . '">Read More</a></div></div>';
		$html .= '</div></div>';
	}
	$html .= '</div></div>';
	return $html;
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
