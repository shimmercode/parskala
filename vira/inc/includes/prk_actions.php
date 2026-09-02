<?php

/* favicon */
function prk_favicon() {

	

		$fav_uploaded = prk_option('favicon');
		if(isset($fav_uploaded['url']) && $fav_uploaded['url'] != '') {
			$favicon = $fav_uploaded['url'];
		}

		$fav_uploaded_retina = prk_option( 'favicon_retina' );
		if(isset($fav_uploaded_retina['url']) && $fav_uploaded_retina['url'] != '') {
			$touch_icon = $fav_uploaded_retina['url'];
		}

	?>

  <?php if (prk_option('favicon')): ?>
   <link rel="shortcut icon" href="<?php echo esc_url($favicon); ?>" >
   <link rel="icon" href="<?php echo esc_url($favicon); ?>">
  <?php endif; ?>





	<?php
}

add_action( 'wp_head', 'prk_favicon',1 );



if (!function_exists('PRK_cart_count')) {
    function PRK_cart_count(){
    $count = WC()->cart->cart_contents_count;
     echo esc_html($count);
    }
}

# random class small
function generatesmallRandomString($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

# random id
function generateRandomString($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function slider_RandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function slider_notnuberRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

# class type
function class_type(){

	echo prk_option('theme-style').' ';
	
	$offer = "";
	if (is_product_category()){
		

	$term = get_queried_object();
    $meta = get_term_meta( $term->term_id, 'prk_taxonomy_options', true );

    if(isset($meta) && !empty($meta)){
        if (isset($meta['offer']))		$offer    = $meta['offer'];
        if (isset($meta['catchild-true']))	$catchild_true    = $meta['catchild-true'];
        if (isset($meta['offer_text']))		$offer_text    = $meta['offer_text'];
    }

	}

	$archives = '';
	if (class_exists( 'WooCommerce' )){

		if ( prk_option('header_style_type') == 'mobit' && ( is_product_category() || is_shop() ) ){
			if ( $offer == '1' ){
			  $archives = "product-archive product-shop mobit offer-cat";
			}else{
			  $archives = "product-archive product-shop mobit";
			}
		}elseif( is_product_category() || is_shop() ){
			if ( $offer == '1' ){
				$archives = "product-archive product-shop offer-cat";
			  }else{
				$archives = "product-archive product-shop";
			}
		}

		// Run code only for Single post page
		if ( is_single() && 'post' == get_post_type() ) {
			$archives = "single-post";
		}
		
		if (is_single() && 'product' == get_post_type() && theme_style() == 'prk-fashion' ) {
			$archives = "product-single single-product fashion-style";
		}elseif( is_single() && 'product' == get_post_type() && prk_option('style_product_page') == 'mobit' ) {
		  $archives = "product-single pars-style single-product mobit";
		}elseif( is_single() && 'product' == get_post_type() ) {
			$archives = "product-single pars-style single-product ". prk_option('style_product_page');
		}

    if (prk_faq_page()) {
    	$archives = "faq-page";
    }

    if (is_front_page()) {
			$archives = "index-page ". prk_option('header_style_type');
		}
		if ( is_checkout() ) {
			$archives = "ceckout_page";
			remove_action('woocommerce_add_error','prk_woocommerce_add_error');
		}
		if (is_cart() && WC()->cart->is_empty() ) {
			$archives = "cart_page empty";
		}
		elseif ( is_cart() ) {
			$archives = "cart_page";
		}
		if (is_order_received_page() ) {
			$archives = "order_page";
		}
		if (is_account_page() ) {
			$archives = "cart_page";
		}
		if ( ! is_user_logged_in() && is_account_page() ) {
			if (prk_option('hider_header_form') == '1' ) {
			  $archives = "page-login hiddener";
			}else {
				$archives = "page-login";
			}
		}
	}

	elseif (is_page()) {
		$archives = "page";
	}
	elseif (is_single() && 'post' == get_post_type()) {
		$archives = "post-single";
	}
	elseif ( is_category()){
		$archives = "category";
	}

	return $archives;


	
}

function title_meta(){
	$title = '';
	if (is_front_page()) {
		if ( get_bloginfo( 'description' ) ){
		$title = bloginfo('name') .' | ' . get_bloginfo( 'description' );
		}else {
		 $title = bloginfo('name');
		}
	}else {
	  $title = wp_title('-','true','right').''. bloginfo('name');
	}

	return $title;


}



if ( ! function_exists( 'prk_grid_loop_columns_product' ) ) {
function prk_grid_loop_columns_product(){

	$columns_product = '';
	if ( !empty(prk_option('prk_loop_columns_product')) ){
		$columns_product = 'style="grid-template-columns: repeat('.prk_option('prk_loop_columns_product').',1fr)"';
	}
	return $columns_product;

 }
}



# Gallery Zoom Handler
add_action('wp_footer','prk_gallery_zoom',100);
  function prk_gallery_zoom() {
		if (class_exists( 'WooCommerce' ) && prk_option('prk_zoom_image') ){
			if ( empty(mobile_cheker()) && empty(tablet_cheker()) ) {

				if ( is_product()){
					?>
					<script>

					jQuery('#attachment-shop_single').elevateZoom({
							zoomWindowFadeIn: 100,
							zoomWindowFadeOut: 120,
							zoomWindowWidth:520,
							zoomWindowHeight:620,
							easing : true,
							zoomWindowPosition: "show_zoom_container",
							lensSize    : 100,
							lensOpacity: 1,
							lensColour: false ,
							cursor:"crosshair",
							lensBorderColour: "#EF5661",
							lensBorderSize: 1,
							borderSize: 0.5,
							left: -10,
							borderColour: "#535353",

					});

					/* ------------------------------ image Zoom product ---------------------- */
					jQuery(".single-pro .thwvsf-checkbox").click(function () {
					  setTimeout(function () {
					    var ez = jQuery(".woocommerce-product-gallery__image .wp-post-image").data("elevateZoom");
					    var smallImage = jQuery(
					      "#attachment-shop_single"
					    ).attr("src");
					    var largeImage = jQuery(
					      ".woocommerce-product-gallery__wrapper .wp-post-image"
					    ).attr("data-src");
					    ez.swaptheimage(smallImage, largeImage);
					  }, 200);
					});
					jQuery(".single-pro input.variation_id").change(function () {
					  // jQuery('.ajax_add_to_cart').attr('data-variation_id',jQuery(this).val());
					  setTimeout(function () {
					    var ez = jQuery(".wp-post-image").data("elevateZoom");
					    var smallImage = jQuery(
					      "#attachment-shop_single"
					    ).attr("src");
					    var largeImage = jQuery(
					      ".woocommerce-product-gallery__wrapper .wp-post-image"
					    ).attr("data-src");
					    ez.swaptheimage(smallImage, largeImage);
					  }, 400);
					});

					</script>

					<?php
				}

			}
	  }

}


// add_filter( 'body_class', 'custom_class' );
// function custom_class( $classes ) {
	
//         $classes[] = prk_option('theme-style').' ' . class_type();
    
// 	return $classes;
// }