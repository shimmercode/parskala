<?php
	// remove box add product
	/*
	add_action('dokan_product_edit_before_main', function(){
		if( defined('SHH_DOKAN_PLUS_PLUS_CLASSES_DIR')) return;
		echo '<style>';
			if (dokan_get_option( 'hide-dokan-product-inventory', 'other_setting_tab_by_onliner', 'off' ) == 'on') echo '.dokan-product-inventory {display:none;}';
			if (dokan_get_option( 'hide-dokan-linked-product-options', 'other_setting_tab_by_onliner', 'off' ) == 'on') echo '.dokan-linked-product-options {display:none;}';
			if (dokan_get_option( 'hide-dokan-attribute-variation-options', 'other_setting_tab_by_onliner', 'off' ) == 'on') echo '.dokan-attribute-variation-options {display:none;}';
			if (dokan_get_option( 'hide-dokan-other-options', 'other_setting_tab_by_onliner', 'off' ) == 'on') echo '.dokan-other-options {display:none;}';
		echo '</style>';
	});
*/

add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_more_seller_product_tab', 98 );
function wcs_woo_remove_more_seller_product_tab($tabs) {
unset($tabs['more_seller_product']);
return $tabs;
}

if ( mobile_cheker() || tablet_cheker() ) {
add_filter( 'woocommerce_product_tabs', 'dokan_remove_seller_info_tab', 50 );
}
function dokan_remove_seller_info_tab( $array ) {
unset( $array['seller'] );
return $array;
}

	// remove become seller button
	function person_remove_button_account_migration(){
		if( defined('SHH_DOKAN_PLUS_PLUS_CLASSES_DIR')) return;

			remove_action('woocommerce_after_my_account', array(Dokan_Pro::init(), 'dokan_account_migration_button') );
	}
	//add_action('woocommerce_account_dashboard', 'person_remove_button_account_migration');


	// remove tab seller in single product
	add_filter('woocommerce_product_tabs', function($tabs){

		unset( $tabs['seller'] );
		unset( $tabs['more_seller_product'] );
    unset( $tabs['seller_enquiry_form'] );
		unset($tabs['shipping']);

		return $tabs;
	}, 99);


	add_action('woocommerce_register_form_start', function(){
			if( defined('SHH_DOKAN_PLUS_PLUS_CLASSES_DIR')) return;

			remove_action( 'woocommerce_register_form', 'dokan_seller_reg_form_fields' );

	});

	function mfields_test_remove_actions() {

			if( defined('SHH_DOKAN_PLUS_PLUS_CLASSES_DIR')) return;



	}
	//add_action( 'dokan_dashboard_content_before', 'mfields_test_remove_actions',1);


	function add_Selling_to_account_menu_items_woo( $items ) {

		if (! defined('SHH_DOKAN_PLUS_PLUS_CLASSES_DIR')  ){

			$current_user = wp_get_current_user();
			$roles = $current_user->roles;

			if (! in_array("seller", $roles)  ) $items['selling'] = __( 'فروشنده شو','vira');
		}


		return $items;

	}

	//add_filter( 'woocommerce_account_menu_items', 'add_Selling_to_account_menu_items_woo', 10, 1 );

	function add_Selling_to_my_account_endpoint() {
		if( defined('SHH_DOKAN_PLUS_PLUS_CLASSES_DIR')) return;
		add_rewrite_endpoint( 'selling', EP_PAGES );

	}

	//add_action( 'init', 'add_Selling_to_my_account_endpoint' );


	function selling_endpoint_content() {
		if( defined('SHH_DOKAN_PLUS_PLUS_CLASSES_DIR')) return;
		echo do_shortcode('[dokan-customer-migration]');
	}

	//add_action( 'woocommerce_account_selling_endpoint', 'selling_endpoint_content' );
