<?php

/**
 *  Advanced order tracker parskala
 *
 * @package      order tracker
 * @Author      Hosein Esmalian
 * @link        http://masirwp.com
 */

 // Don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;


//Enqueue Style for Plugin
function prk_order_basic_scripts(){

	wp_enqueue_style('cbwct-tracker-style', get_template_directory_uri() .'/inc/order-track/css/style.css');

	wp_enqueue_script( 'cbwct-tracker-ajax', get_template_directory_uri() .'/inc/order-track/js/ajax-active.js', array('jquery'), 1.0, true );

	wp_localize_script( 'cbwct-tracker-ajax', 'cbwct_tracker', array( 'ajaxurl'	=> admin_url('admin-ajax.php')) );
}
add_action('wp_enqueue_scripts','prk_order_basic_scripts');


//Include additional file
require_once( get_template_directory() . '/inc/order-track/inc/custom.php' );
require_once( get_template_directory() . '/inc/order-track/inc/shortcode.php' );
require_once( get_template_directory() . '/inc/order-track/inc/hooks.php' );
