<?php
/**
 * City taxonomy — admin metabox only after add_meta_boxes is available.
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function cpt_city_cats() {
	$labels = array(
		'name'          => 'استان و شهر',
		'singular_name' => 'استان و شهر',
		'menu_name'     => 'استان و شهر',
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
	);
	register_taxonomy( 'city_categories', array( 'product' ), $args );
}
add_action( 'init', 'cpt_city_cats' );

function vira_city_categories_metabox() {
	if ( ! function_exists( 'add_meta_box' ) ) {
		return;
	}
	add_meta_box(
		'city_categoriesdiv',
		'شهرها',
		'post_categories_meta_box',
		'product',
		'side',
		'default',
		array(
			'taxonomy'               => 'city_categories',
			'__back_compat_meta_box' => true,
		)
	);
}
add_action( 'add_meta_boxes', 'vira_city_categories_metabox' );

$rrprefix = 'prskala_search';
add_action( 'wp_ajax_' . $rrprefix . '_getCityChildern', 'so_wp_ajax_prskala_search_getCityChildern' );
add_action( 'wp_ajax_nopriv_' . $rrprefix . '_getCityChildern', 'so_wp_ajax_prskala_search_getCityChildern' );
add_action( 'wp_ajax_' . $rrprefix . '_getCities', 'so_wp_ajax_prskala_search_getCities' );
add_action( 'wp_ajax_nopriv_' . $rrprefix . '_getCities', 'so_wp_ajax_prskala_search_getCities' );
add_action( 'wp_ajax_' . $rrprefix . '_searchCityByName', 'so_wp_ajax_prskala_search_searchCityByName' );
add_action( 'wp_ajax_nopriv_' . $rrprefix . '_searchCityByName', 'so_wp_ajax_prskala_search_searchCityByName' );

function so_wp_ajax_prskala_search_getCities() {
	check_ajax_referer( 'vira_ajax_nonce', 'security', false );
	$cities = get_terms(
		array(
			'taxonomy'   => 'city_categories',
			'hide_empty' => false,
			'parent'     => 0,
		)
	);
	wp_send_json( is_wp_error( $cities ) ? array() : $cities );
}

function so_wp_ajax_prskala_search_getCityChildern() {
	$cityid   = isset( $_POST['cityid'] ) ? absint( $_POST['cityid'] ) : 0;
	$children = get_terms(
		array(
			'taxonomy'   => 'city_categories',
			'hide_empty' => false,
			'parent'     => $cityid,
		)
	);
	wp_send_json( is_wp_error( $children ) ? array() : $children );
}

function so_wp_ajax_prskala_search_searchCityByName() {
	$txt = isset( $_POST['txt'] ) ? sanitize_text_field( wp_unslash( $_POST['txt'] ) ) : '';
	$res = get_terms(
		array(
			'hide_empty' => false,
			'taxonomy'   => 'city_categories',
			'name__like' => $txt,
		)
	);
	wp_send_json( is_wp_error( $res ) ? array() : $res );
}
