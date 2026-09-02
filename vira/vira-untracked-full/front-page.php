<?php
/**
 * Digikala-style homepage (no Elementor required).
 *
 * @package Vira
 */

get_header();

if ( class_exists( 'Vira_Digikala_Layer' ) ) {
	Vira_Digikala_Layer::render_home();
} elseif ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		the_content();
	}
}

get_footer();
