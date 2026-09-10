<?php
/**
 * Fallback index — unused once the static front page and permalinks are in place.
 */
get_header();
if (have_posts()) {
	while (have_posts()) {
		the_post();
		the_content();
	}
}
get_footer();
