<?php
/**
 * Create Drupal-matching pages, posts, and permalinks when the theme is activated.
 */

if (!defined('ABSPATH')) {
	exit;
}

function thryft_page_statuses() {
	return array('publish', 'draft', 'pending', 'private', 'future');
}

function thryft_pages_named($slug) {
	return get_posts(array(
		'name' => $slug,
		'post_type' => 'page',
		'post_status' => thryft_page_statuses(),
		'numberposts' => 20,
	));
}

function thryft_claim_page_slug($slug) {
	$candidates = array();
	foreach (array($slug, $slug . '-2', $slug . '-3', $slug . '-4') as $try) {
		$candidates = array_merge($candidates, thryft_pages_named($try));
	}

	$keep = 0;
	foreach ($candidates as $page) {
		if (get_post_meta($page->ID, '_thryft_path', true)) {
			$keep = (int) $page->ID;
		}
	}

	foreach ($candidates as $page) {
		if ((int) $page->ID === $keep) {
			continue;
		}
		wp_delete_post($page->ID, true);
	}

	if ($keep) {
		wp_update_post(array(
			'ID' => $keep,
			'post_name' => $slug,
			'post_status' => 'publish',
		));
	}
}

function thryft_find_page_by_slug($slug) {
	$found = thryft_pages_named($slug);
	return $found ? $found[0] : null;
}

function thryft_upsert_page($title, $slug, $content, $path = '', $parent_id = 0) {
	$existing = thryft_find_page_by_slug($slug);
	$payload = array(
		'post_title' => $title,
		'post_name' => $slug,
		'post_content' => $content,
		'post_status' => 'publish',
		'post_type' => 'page',
		'post_parent' => $parent_id,
		'comment_status' => 'closed',
		'ping_status' => 'closed',
	);
	if ($existing) {
		$payload['ID'] = $existing->ID;
		$id = wp_update_post($payload, true);
	} else {
		$id = wp_insert_post($payload, true);
	}
	if (is_wp_error($id) || !$id) {
		return 0;
	}
	if ($path) {
		update_post_meta($id, '_thryft_path', $path);
	}
	return (int) $id;
}

function thryft_upsert_post($title, $slug, $content, $image_relative) {
	$found = get_posts(array(
		'name' => $slug,
		'post_type' => 'post',
		'post_status' => 'any',
		'numberposts' => 1,
	));
	$payload = array(
		'post_title' => $title,
		'post_name' => $slug,
		'post_content' => $content,
		'post_status' => 'publish',
		'post_type' => 'post',
		'comment_status' => 'closed',
		'ping_status' => 'closed',
	);
	if ($found) {
		$payload['ID'] = $found[0]->ID;
		$id = wp_update_post($payload, true);
	} else {
		$id = wp_insert_post($payload, true);
	}
	if (is_wp_error($id) || !$id) {
		return 0;
	}
	update_post_meta($id, '_thryft_image', $image_relative);
	return (int) $id;
}

function thryft_faq_html() {
	$items = thryft_content()['faq'];
	$html = '<h2>Frequently Asked Questions</h2><h4>Ready to get started...?</h4><p>Use the form on the Contact Us page to schedule a meeting.</p>';
	$html .= '<div class="view view-custom-faq"><div class="view-content">';
	$section = '';
	foreach ($items as $item) {
		if ($item['section'] !== $section) {
			$section = $item['section'];
			$html .= '<h3>' . esc_html($section) . '</h3>';
		}
		$html .= '<div class="views-row faq-' . esc_attr($section) . '">';
		$html .= '<div class="views-field views-field-title"><h4 class="field-content faq-ques"><a href="#">' . esc_html($item['question']) . '</a></h4></div>';
		$html .= '<div class="views-field views-field-body">' . $item['answer'] . '</div>';
		$html .= '</div>';
	}
	$html .= '</div></div>';
	return $html;
}

function thryft_import_content() {
	if (get_option('thryft_content_version') === (string) THRYFT_CONTENT_VERSION && !isset($_GET['thryft_reimport'])) {
		return;
	}

	if (get_option('permalink_structure') !== '/%postname%/') {
		update_option('permalink_structure', '/%postname%/');
	}

	$about = thryft_content()['about_body'];
	$about_img = '<div class="field field-name-field-image field-type-image field-label-hidden"><div class="field-items"><div class="field-item even"><img class="img-responsive" src="' . esc_url(thryft_uri('files/shutterstock_1689429739_new.jpg')) . '" alt="" /></div></div></div>';
	$about_body = $about_img . '<div class="field field-name-body"><div class="field-items"><div class="field-item even">' . $about . '</div></div></div>';

	$home_id = thryft_upsert_page('Welcome to THRYFT ADVISORS', 'welcome-thryft-advisors', '', '/');
	thryft_upsert_page('About', 'about', $about_body, '/about/');
	thryft_upsert_page('Contact Us', 'contact-us', '', '/contact-us/');
	thryft_upsert_page('Services', 'services', '', '/services/');
	thryft_upsert_page('FAQ', 'faq', thryft_faq_html(), '/faq/');
	thryft_upsert_page('Expense Reduction', 'expense-reduction', '', '/expense-reduction/');
	thryft_upsert_page('Specialized Savings', 'specialized-savings', '', '/specialized-savings/');
	thryft_upsert_page('Tax Incentives', 'tax-incentives', '', '/tax-incentives/');
	thryft_upsert_page('Terms & Conditions', 'terms-conditions', '', '/terms-conditions/');
	thryft_claim_page_slug('privacy-policy');
	$privacy_id = thryft_upsert_page('Privacy policy', 'privacy-policy', '', '/privacy-policy/');
	if ($privacy_id) {
		update_option('wp_page_for_privacy_policy', $privacy_id);
	}

	foreach (thryft_services() as $row) {
		$content = '<div class="field field-name-field-video-link">' . $row['video'] . '</div>';
		$content .= '<div class="field field-name-body field-type-text-with-summary"><div class="field-items"><div class="field-item even">' . $row['body'] . '</div></div></div>';
		thryft_upsert_page($row['title'], $row['slug'], $content, $row['path']);
	}

	foreach (thryft_content()['posts'] as $row) {
		thryft_upsert_post($row['title'], $row['slug'], $row['body'], $row['image']);
	}

	if ($home_id) {
		update_option('show_on_front', 'page');
		update_option('page_on_front', $home_id);
	}

	foreach (array(2 => 'sample-page', 1 => 'hello-world') as $maybe_id => $slug) {
		$post = thryft_find_page_by_slug($slug);
		if ($post) {
			wp_trash_post($post->ID);
		}
	}
	$hello = get_posts(array('name' => 'hello-world', 'post_type' => 'post', 'post_status' => 'any', 'numberposts' => 1));
	if ($hello) {
		wp_trash_post($hello[0]->ID);
	}

	update_option('blogname', 'Thryft Advisors');
	update_option('blogdescription', '');
	update_option('thryft_content_version', (string) THRYFT_CONTENT_VERSION);
	flush_rewrite_rules();
}

add_action('after_switch_theme', 'thryft_import_content');

add_action('init', static function () {
	if (get_template() !== 'thryft') {
		return;
	}
	if (get_option('thryft_content_version') === (string) THRYFT_CONTENT_VERSION) {
		return;
	}
	thryft_import_content();
}, 30);

add_action('admin_init', static function () {
	if (!current_user_can('manage_options')) {
		return;
	}
	if (isset($_GET['thryft_reimport']) && check_admin_referer('thryft_reimport')) {
		delete_option('thryft_content_version');
		thryft_import_content();
		wp_safe_redirect(admin_url('themes.php?thryft_imported=1'));
		exit;
	}
});

add_action('admin_notices', static function () {
	if (!current_user_can('manage_options')) {
		return;
	}
	$screen = function_exists('get_current_screen') ? get_current_screen() : null;
	if (!$screen || $screen->id !== 'themes') {
		return;
	}
	$url = wp_nonce_url(admin_url('themes.php?thryft_reimport=1'), 'thryft_reimport');
	echo '<div class="notice notice-info"><p>Thryft Advisors theme: Drupal pages and posts are imported on activation. <a href="' . esc_url($url) . '">Re-import content</a> if you need to refresh from the bundled copy.</p></div>';
});
