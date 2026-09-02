<?php
/**
 * Single product — Vira.
 *
 * @package WooCommerce\Templates
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'shop' );

do_action( 'woocommerce_before_main_content' );

while ( have_posts() ) {
	the_post();
	echo '<main class="single-pro woocommerce vira-single-product">';
	wc_get_template_part( 'content', 'single-product' );
	echo '</main>';
}

do_action( 'woocommerce_after_main_content' );
get_footer( 'shop' );
