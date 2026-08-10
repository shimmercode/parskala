<?php
 // Don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

	if(!class_exists('CBWCT_ORDER_TRACKER')) {
		return;
	}

	get_header();

	// get template markup
	require_once( get_template_directory() . '/inc/order-track/inc/templates/progressbar.php');
	require_once( get_template_directory() . '/inc/main-form.php');

	get_footer();
