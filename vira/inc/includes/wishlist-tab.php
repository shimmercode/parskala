<?php
if(!shortcode_exists('yith_wcwl_wishlist')) return;
/**
 * @snippet       WooCommerce Add New Tab @ My Account
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 6.0
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

// ------------------
// 1. Register new endpoint (URL) for My Account page
// Note: Re-save Permalinks or it will give 404 error

function bbloomer_add_premium_support_endpoint() {
    add_rewrite_endpoint( 'wishlist', EP_ROOT | EP_PAGES );
}

add_action( 'init', 'bbloomer_add_premium_support_endpoint' );

// ------------------
// 2. Add new query var

function bbloomer_premium_support_query_vars( $vars ) {
    $vars[] = 'wishlist';
    return $vars;
}

add_filter( 'query_vars', 'bbloomer_premium_support_query_vars', 0 );

// ------------------
// 3. Insert the new endpoint into the My Account menu

function bbloomer_add_premium_support_link_my_account( $menu_links ) {

    $menu_links = array_slice( $menu_links, 0, 4, true )
	+ array( 'wishlist' => __( 'interests', 'parskala' ) )
	+ array_slice( $menu_links, 4, NULL, true );
	return $menu_links;
}

add_filter( 'woocommerce_account_menu_items', 'bbloomer_add_premium_support_link_my_account', 10 );

// ------------------
// 4. Add content to the new tab

function bbloomer_premium_support_content() { ?>

			<div class="sp_last_posts">
						<div class="sp_top_last_posts dsh_last_products_seen">
						<?php _e('لیست آخرین علاقه‌مندی‌ها', 'parskala'); ?>
						</div>
						<ul class="sp_bottom_last_posts">
							<?php  echo do_shortcode('[yith_wcwl_wishlist]'); ?>
						</ul>
				 </div>


<?php }

add_action( 'woocommerce_account_wishlist_endpoint', 'bbloomer_premium_support_content' );
