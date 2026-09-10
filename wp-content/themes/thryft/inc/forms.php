<?php
/**
 * Contact / Get In Touch form (Drupal webform nid 73 fields).
 */

if (!defined('ABSPATH')) {
	exit;
}

function thryft_form_recipient() {
	return 'admin@thryftadvisors.com';
}

function thryft_handle_contact_form() {
	if (empty($_POST['thryft_contact']) || empty($_POST['thryft_contact_nonce'])) {
		return;
	}
	if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['thryft_contact_nonce'])), 'thryft_contact')) {
		wp_safe_redirect(add_query_arg('contact', 'error', wp_get_referer() ?: home_url('/contact-us/')));
		exit;
	}
	$honeypot = isset($_POST['thryft_website']) ? trim((string) wp_unslash($_POST['thryft_website'])) : '';
	if ($honeypot !== '') {
		wp_safe_redirect(add_query_arg('contact', 'sent', wp_get_referer() ?: home_url('/contact-us/')));
		exit;
	}

	$name = isset($_POST['submitted']['name']) ? sanitize_text_field(wp_unslash($_POST['submitted']['name'])) : '';
	$email = isset($_POST['submitted']['email']) ? sanitize_email(wp_unslash($_POST['submitted']['email'])) : '';
	$phone = isset($_POST['submitted']['phone']) ? sanitize_text_field(wp_unslash($_POST['submitted']['phone'])) : '';
	$message = isset($_POST['submitted']['message']) ? sanitize_textarea_field(wp_unslash($_POST['submitted']['message'])) : '';

	if ($name === '' || $email === '' || $message === '' || !is_email($email)) {
		wp_safe_redirect(add_query_arg('contact', 'error', wp_get_referer() ?: home_url('/contact-us/')));
		exit;
	}

	$to = thryft_form_recipient();
	$subject = 'Thryft Advisors quote request from ' . $name;
	$body = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\n\nMessage:\n{$message}\n";
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);
	$sent = wp_mail($to, $subject, $body, $headers);
	wp_safe_redirect(add_query_arg('contact', $sent ? 'sent' : 'error', wp_get_referer() ?: home_url('/contact-us/')));
	exit;
}
add_action('admin_post_nopriv_thryft_contact', 'thryft_handle_contact_form');
add_action('admin_post_thryft_contact', 'thryft_handle_contact_form');
add_action('template_redirect', static function () {
	if (!empty($_POST['thryft_contact'])) {
		thryft_handle_contact_form();
	}
});

function thryft_form_feedback() {
	if (empty($_GET['contact'])) {
		return;
	}
	if ($_GET['contact'] === 'sent') {
		echo '<div class="thryft-form-success">Thank you. We received your message and will be in touch.</div>';
		return;
	}
	if ($_GET['contact'] === 'error') {
		echo '<div class="thryft-form-error">Please complete the required fields and try again.</div>';
	}
}

function thryft_render_form($heading = 'Get In Touch') {
	?>
	<section id="block-webform-client-block-73" class="block block-webform clearfix">
		<h2 class="block-title"><?php echo esc_html($heading); ?></h2>
		<?php thryft_form_feedback(); ?>
		<form class="webform-client-form webform-client-form-73" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" id="webform-client-form-73" accept-charset="UTF-8">
			<div>
				<input type="hidden" name="action" value="thryft_contact" />
				<input type="hidden" name="thryft_contact" value="1" />
				<?php wp_nonce_field('thryft_contact', 'thryft_contact_nonce'); ?>
				<div class="form-item webform-component webform-component-textfield webform-component--name form-group">
					<label class="control-label" for="edit-submitted-name">Name <span class="form-required" title="This field is required.">*</span></label>
					<input required="required" class="form-control form-text required" type="text" id="edit-submitted-name" name="submitted[name]" value="" size="60" maxlength="128" />
				</div>
				<div class="form-item webform-component webform-component-email webform-component--email form-group">
					<label class="control-label" for="edit-submitted-email">Email <span class="form-required" title="This field is required.">*</span></label>
					<input required="required" class="email form-control form-text form-email required" type="email" id="edit-submitted-email" name="submitted[email]" size="60" />
				</div>
				<div class="form-item webform-component webform-component-textfield webform-component--phone form-group">
					<label class="control-label" for="edit-submitted-phone">Phone</label>
					<input class="form-control form-text" type="text" id="edit-submitted-phone" name="submitted[phone]" value="" size="60" maxlength="128" />
				</div>
				<div class="form-item webform-component webform-component-textarea webform-component--message form-group">
					<label class="control-label" for="edit-submitted-message">Message <span class="form-required" title="This field is required.">*</span></label>
					<div class="form-textarea-wrapper"><textarea required="required" class="form-control form-textarea required" id="edit-submitted-message" name="submitted[message]" cols="60" rows="5"></textarea></div>
				</div>
				<p class="thryft-hp" aria-hidden="true"><label>Website<input type="text" name="thryft_website" value="" tabindex="-1" autocomplete="off" /></label></p>
				<div class="form-actions">
					<button class="webform-submit button-primary btn btn-primary form-submit" type="submit" name="op" value="Submit">Submit</button>
				</div>
			</div>
		</form>
	</section>
	<?php
}

function thryft_get_in_touch() {
	?>
	<div class="getintouch"><div class="container">
		<?php thryft_render_form('Get In Touch'); ?>
		<div class="region region-getintouch">
			<section id="block-block-9" class="block block-block clearfix">
				<h2>Any Questions?<br />Get In Touch</h2>
			</section>
		</div>
	</div></div>
	<?php
}
