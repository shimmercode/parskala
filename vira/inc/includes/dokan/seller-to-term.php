<?php
add_action( 'init', 'prk_create_sellers_nonhierarchical_taxonomy', 999 );

function prk_create_sellers_nonhierarchical_taxonomy() {

	$custom_store_url = dokan_get_option( 'custom_store_url', 'dokan_general', 'store' );
	$args = array(
		'hierarchical' => true,
		'label' => __( 'فروشنده', 'newkala' ),
		'show_ui' => false,
		'show_in_menu' => false,
		'show_in_nav_menus' => false,
		'show_in_quick_edit' => false,
		'show_in_rest' => false,
		'show_admin_column' => false,
		'query_var' => $query_var,
		'rewrite' => array( 'slug' => $custom_store_url ),
	  );

	if( get_field('nk-store-style', 'option') == 'default' )
		$args['rewrite'] = array( 'slug' => 'fake-slug' );
	else
		$args['rewrite'] = array( 'slug' => $custom_store_url );


	if( isset($_GET['taxonomy']) && $_GET['taxonomy'] == prk_TAXONOMY_SELLERS ) $args['show_ui'] = true;


	if ( $_SERVER['HTTP_HOST'] === 'newkala-dev.me' ){
		$args = array(
			'hierarchical' => true,
			'label' => __( 'فروشنده', 'newkala' ),
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'show_in_quick_edit' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'query_var' => $query_var,
			'rewrite' => array( 'slug' => $custom_store_url ),
		  );
	}


	 register_taxonomy(prk_TAXONOMY_SELLERS,'product',  apply_filters('prk_sellers_taxonomy_args', $args));
}


function prk_set_taxonomy_sellers( $name = '' , $slug = '' , $user_id = 0){


  if( term_exists($slug, prk_TAXONOMY_SELLERS) ){

		$term = get_term_by('slug', $slug, prk_TAXONOMY_SELLERS);
		$store_settings  = dokan_get_store_info( $user_id );
		wp_update_term( $term->term_id , prk_TAXONOMY_SELLERS, array(
			'name' => $store_settings['store_name']
		) );

		return;
	}

  if( $term_id_seller = get_user_meta($user_id , 'prk_term_id_user_seller', true) ){

    if( isset( $_POST['dokan_store_url'] ) && $_POST['dokan_store_url'] != '' ){
			wp_update_term( $term_id_seller , prk_TAXONOMY_SELLERS, array(
				'slug' => trim($_POST['dokan_store_url'])
			) );
		}
    if( isset( $_POST['dokan_store_name'] ) && $_POST['dokan_store_name'] != '' ){
      wp_update_term( $term_id_seller , prk_TAXONOMY_SELLERS, array(
  			'name' => trim($_POST['dokan_store_name'])
  		) );
    }

    return;
  }



	$term = wp_insert_term($name,prk_TAXONOMY_SELLERS,array('slug'=> $slug ));
	if( ! is_array($term) ) return;
	$term_id = $term['term_id'];

	update_term_meta( $term_id, 'prk_seller_id_term_seller', $user_id );

	update_user_meta( $user_id, 'prk_term_id_user_seller', $term_id);

	return;

}



add_action('dokan_new_seller_created', 'prk_dokan_new_seller_created',999,2);
add_action('dokan_store_profile_saved', 'prk_dokan_new_seller_created',999,2);

function prk_dokan_new_seller_created($user_id, $dokan_settings){

	$store_name = $dokan_settings['store_name'];
	$user = get_user_by( 'ID', $user_id );
	$user_nicename = $user->user_nicename;

	prk_set_taxonomy_sellers( $store_name , $user_nicename , $user_id );

}




add_action( 'user_register', 'prk_set_taxonomy_sellers_new_user_admin', 10, 1 );
add_action( 'dokan_process_seller_meta_fields', 'prk_set_taxonomy_sellers_new_user_admin', 999, 1 );
add_action( 'personal_options_update', 'prk_set_taxonomy_sellers_new_user_admin', 999, 1 );
add_action( 'edit_user_profile_update', 'prk_set_taxonomy_sellers_new_user_admin', 999, 1 );

function prk_set_taxonomy_sellers_new_user_admin( $user_id ) {

    if ( isset( $_POST['role'] ) && ($_POST['role'] == 'seller' || $_POST['role'] == 'administrator' ) ){

		$user = get_user_by( 'ID', $user_id );
		$user_nicename = $user->user_nicename;
		$store_name = isset( $_POST['dokan_store_name'] ) && $_POST['dokan_store_name'] != '' ? $_POST['dokan_store_name'] : $user_nicename;

		prk_set_taxonomy_sellers( $store_name , $user_nicename , $user_id );
    return;
	}


  $user = get_userdata( $user_id );
  $user_roles = $user->roles;
  if ( in_array( 'administrator', $user_roles, true ) ){
    $user = get_user_by( 'ID', $user_id );
		$user_nicename = $user->user_nicename;
		$store_name = isset( $_POST['dokan_store_name'] ) && $_POST['dokan_store_name'] != '' ? $_POST['dokan_store_name'] : $user_nicename;

		prk_set_taxonomy_sellers( $store_name , $user_nicename , $user_id );
    return;
  }


}






add_action( 'dokan_new_vendor', 'prk_set_taxonomy_sellers_new_user_vendor_class', 999, 1 );
add_action( 'dokan_update_vendor', 'prk_set_taxonomy_sellers_new_user_vendor_class', 999, 1 );

function prk_set_taxonomy_sellers_new_user_vendor_class( $user_id ) {

		$user = get_user_by( 'ID', $user_id );
		$user_nicename = $user->user_nicename;
		$store_settings  = dokan_get_store_info( $user_id );
		$store_name = $store_settings['store_name'];
		prk_set_taxonomy_sellers( $store_name , $user_nicename , $user_id );

}


function add_book_place_columns( $columns ) {
    $columns['seller_id'] = 'آیدی فروشنده';
    return $columns;
}
add_filter( 'manage_edit-'.prk_TAXONOMY_SELLERS.'_columns', 'add_book_place_columns' );
function add_book_place_column_content($content,$column_name,$term_id){
    $seller_id = $column_name == 'seller_id' ? get_term_meta($term_id, 'prk_seller_id_term_seller', true) : 0;

    return $seller_id;
}
add_filter('manage_'.prk_TAXONOMY_SELLERS.'_custom_column', 'add_book_place_column_content',10,3);
