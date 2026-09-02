<?php

/**
 * Some Useful Constant
 */
define( 'SIT_PLUGIN_LOCATION', plugin_dir_path(__FILE__));
define( 'SIT_USER_META_KEY', 'sit_wishlist_ids' );
define( 'SIT_BEFORE_ADDED_BTN_HTML', 'sit_wishlist_before_html' );
define( 'SIT_AFTER_ADDED_BTN_HTML', 'sit_wishlist_after_html' );
define( 'SIT_DEFAULT_WISHLIST_BTN_VISIBILITY', 'sit_wishlist_btn_visibility' );
define( 'SIT_PLUGIN_URL' , plugin_dir_url(__FILE__));


class PRK_Wishlist{

    public function __construct() {
		$this->includes();
	}


    public function includes() {
		require __DIR__ . '/inc/overwrite-templates.php'; 	// Overwrite the plugin file
		require __DIR__ . '/inc/useful-functions.php'; 	// Overwrite the plugin file
		require __DIR__ . '/inc/add-to-wishlist-btn.php'; 	// add the button to front-end
		require __DIR__ . '/inc/ajax.php'; 					// Ajax function for add remove the wishlist
		require __DIR__ . '/inc/add-endpoint.php'; 			// Add woocommerce end point
	}
}

new PRK_Wishlist();
