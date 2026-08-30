<?php
// Don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;
if(!class_exists('prk_ORDER_TRACKER')) {
	return;
}

// Register Shortcode
function prk_tracker_wc_shortcode($attrs, $content = NULL) {
	ob_start();
	extract(shortcode_atts(array(

		'post_type' =>'post'

	), $attrs));

		// get template markup
		require_once( get_template_directory() . '/inc/order-track/inc/main-form.php');

	return ob_get_clean();
}
add_shortcode('prk-order-tracker', 'prk_tracker_wc_shortcode');
