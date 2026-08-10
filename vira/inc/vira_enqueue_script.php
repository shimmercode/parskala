<?php


// Load the theme stylesheets

function add_theme_scripts() {


  wp_enqueue_style('general-css', parskala_URI . '/assets/css/general.css', array(), PRK_VERSION, 'all');
  wp_enqueue_style('menu-css', parskala_URI . '/assets/css/vira-menu.css', array(), PRK_VERSION, 'all');
  wp_enqueue_style('account-header', parskala_URI . '/assets/css/vira-account-header.css', array(), PRK_VERSION, 'all');


  if (prk_option('header_style_type') == 'mobit'){

    wp_enqueue_style('mobit-header', parskala_URI . '/assets/css/mobit-header.css', array(), PRK_VERSION, 'all');

  }

  if (prk_option('footer_style_type') == 'mobit'){

    wp_enqueue_style('mobit-footer', parskala_URI . '/assets/css/mobit-footer.css', array(), PRK_VERSION, 'all');

  }

  // لود فایل های فشرده پوسته || استایل های اصلی سایت
	if ( 'digikala' == theme_style()){

    wp_enqueue_style( 'prk-style', parskala_URI . '/assets/css/3.vira-classic.css', array(), PRK_VERSION );

  }
	elseif ('parskala' == theme_style() ) {

		wp_enqueue_style( 'prk-style', parskala_URI . '/assets/css/1.vira.css', array(), PRK_VERSION );

	}
  elseif ('prk-plus' == theme_style()) {

	  wp_enqueue_style( 'prk-style', parskala_URI . '/assets/css/2.vira-plus.css', array(), PRK_VERSION );

	}elseif ('prk-fashion' == theme_style()){
    wp_enqueue_style( 'fashion-style', parskala_URI . '/assets/css/4.vira-fashion.css', array(), PRK_VERSION );
  }
	else{

		wp_enqueue_style( 'prk-style', parskala_URI . '/assets/css/3.vira-classic.css', array(), PRK_VERSION );

	}


  #css main files
	wp_enqueue_style( 'style', get_stylesheet_uri() );


  #css swiper files

  if (class_exists( 'WooCommerce' )){

    if ( is_product() ){
      if ( mobile_cheker() || tablet_cheker() ) {
        wp_enqueue_style('swiper-main',  parskala_URI . '/assets/css/lunches/swiper.css', array(), PRK_VERSION);
      }
    }else {
      wp_enqueue_style('swiper-main',  parskala_URI . '/assets/css/lunches/swiper.css', array(), PRK_VERSION);
    }

    if ( empty( is_product() ) ) {
      wp_enqueue_style('slider-swiper',parskala_URI  . '/assets/css/lunches/swiper-slider.css', array(), PRK_VERSION );
    }

  }

  wp_enqueue_style('whishlist-css',parskala_URI . '/assets/css/lunches/whishlist.css', array(), PRK_VERSION, 'all');
  wp_enqueue_style('dokan-css',parskala_URI . '/assets/css/lunches/vira-dokan.css', array(), PRK_VERSION, 'all');
  wp_enqueue_style('modals-css',   parskala_URI . '/assets/css/lunches/modal.css', array(), PRK_VERSION, 'all');
  wp_enqueue_style('banners-css',   parskala_URI . '/assets/css/lunches/vira-banners.css', array(), PRK_VERSION, 'all');


  #css carousels files
  wp_enqueue_style( 'items',       parskala_URI . '/assets/css/carousels/owl.carousel-items.css', array(), PRK_VERSION );
  wp_enqueue_style( 'off-slider',  parskala_URI . '/assets/css/carousels/owl.article-off.css', array(), PRK_VERSION );
  wp_enqueue_style( 'hanis-slider',  parskala_URI . '/assets/css/carousels/owl.item-hanis.css', array(), PRK_VERSION );
  wp_enqueue_style( 'slider-main', parskala_URI . '/assets/css/carousels/owl.carousel.min.css', array(), PRK_VERSION );

  if ( prk_option('prk_filter_location') ) {
    wp_enqueue_style( 'filter-location', parskala_URI . '/assets/css/lunches/filter-location.css', array(), PRK_VERSION );
  }


  # font -icons
	wp_enqueue_style( 'remixicon', get_template_directory_uri() . '/assets/fonts/ri-fonts/remixicon.css' );
	wp_enqueue_style( 'flaticon', get_template_directory_uri() . '/assets/fonts/font/flaticon.css' );
	wp_enqueue_style( 'iconsax', get_template_directory_uri() . '/assets/fonts/parsfont/style.css' );


  #js jquery file
  wp_enqueue_script( 'ajax-nextshop', get_template_directory_uri() . '/assets/js/ajax-nextshop.js', array ( 'jquery' ),PRK_VERSION, true);
  wp_enqueue_script( 'crousel', get_template_directory_uri() . '/assets/js/crousel.js', array ( 'jquery' ),PRK_VERSION, true);
  wp_enqueue_script( 'carousel-main', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array ( 'jquery' ),PRK_VERSION, true);
  wp_enqueue_script( 'popper-min', get_template_directory_uri() . '/assets/js/popper.min.js',PRK_VERSION, true);
  wp_enqueue_script( 'tippy-min', get_template_directory_uri() . '/assets/js/tippy.tippy-bundle.js',PRK_VERSION, true);
  wp_enqueue_script( 'sweet-min', get_template_directory_uri() . '/assets/js/sweet.min.js',PRK_VERSION, true);
  #js options files
  wp_enqueue_script( 'simplebar.min.js', get_template_directory_uri() . '/assets/js/simplebar.min.js', array ( 'jquery' ),PRK_VERSION, true);
  #js modal files
	wp_enqueue_script( 'modal-js',       get_template_directory_uri() . '/assets/js/modal.js', array ( 'jquery' ), PRK_VERSION, true);
  wp_enqueue_script( 'remodal.min.js', get_template_directory_uri() . '/assets/js/remodal.min.js', array ( 'jquery' ),PRK_VERSION, true);

  # ceck woocommerce plugins and after load js files
	if (class_exists( 'WooCommerce' )){
    if ( is_product()){
      wp_enqueue_style('fancybox-css',   parskala_URI . '/assets/css/lunches/fancybox.min.css', array(), '4.3.3', 'all');
      wp_enqueue_script( 'fancybox.js', get_template_directory_uri() . '/assets/js/fancybox.js', array ( 'jquery' ),PRK_VERSION, true);
      if ( empty(mobile_cheker()) && empty(tablet_cheker()) ) {
        wp_enqueue_script('jzoom', parskala_URI . '/assets/js/jquery.elevateZoom-3.0.8.min.js', array(), PRK_VERSION, false );
      }

      wp_enqueue_script('highcharts', parskala_URI . '/assets/js/highcharts.js', array(), '6.1.1', true );


      if ( mobile_cheker() || tablet_cheker() ) {
        wp_enqueue_script('swiper-js', parskala_URI . '/assets/js/swiper.js', array(),PRK_VERSION, true);
    }

    }

    else {

      wp_enqueue_script('swiper-js', parskala_URI . '/assets/js/swiper.js', array(),PRK_VERSION, true);
      
    }

    wp_enqueue_script('theme-script', get_template_directory_uri()."/assets/js/ajax-carousel.js", array('jquery'),null,true);
    wp_localize_script('theme-script', 'themeScriptParams', [
      'pageID'    => get_the_ID(),
      'ajaxNonce' => wp_create_nonce('ajax-nonce'),
      'ajaxURL'   => admin_url('admin-ajax.php'),
      'ajaxError' => __('An error occurred while processing!', THEME_TEXTDOMAIN),
    ]);
    
    if( prk_option( 'ajax_add' ) == '1' && get_option( 'woocommerce_enable_ajax_add_to_cart' ) === 'yes' && get_option( 'woocommerce_cart_redirect_after_add' ) === 'no') {
      wp_enqueue_script( 'add-ajax.js', get_template_directory_uri() . '/assets/js/ajax-add.js', array ( 'jquery' ),PRK_VERSION, true);
    }

    /**
     * Enqueue confetti js - for cart sidebar for advance free shipping js
     */
    if (class_exists('WooCommerce_Advanced_Free_Shipping') && prk_option('free_shipping_effect') ) {
      wp_enqueue_script( 'jquery-confetti', get_template_directory_uri() . '/assets/js/jquery.confetti.min.js', array ( 'jquery' ),PRK_VERSION, true);
    }
  }

    wp_enqueue_script( 'leaflet', get_template_directory_uri() . '/assets/js/leaflet.js', array ( 'jquery' ), PRK_VERSION, false);
    wp_enqueue_script( 'checkout', get_template_directory_uri() . '/assets/js/checkout.js', array ( 'jquery' ), PRK_VERSION, false);
    wp_enqueue_style('leaflet-css', parskala_URI . '/assets/css/leaflet.css', array(), '4.3.3', 'all');

if (in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

  if ( prk_option('prk_shop_ajax_add') && ( is_shop() || is_product_category() ) ) {
    wp_enqueue_script( 'onloader.min', get_template_directory_uri() . '/assets/js/vira-onloader.js', array ( 'jquery' ), PRK_VERSION, false);
  }

}



  if ( prk_option('prk_filter_location') ) {
    wp_enqueue_script( 'location-picker', get_template_directory_uri() . '/assets/js/location-picker.js', array ( 'jquery' ), PRK_VERSION, true);
  }

  // faq page
  if ( prk_faq_page() ) {

    wp_enqueue_style('template-css', parskala_URI . '/assets/css/faq-template.css', array(), PRK_VERSION, 'all');
    if ( prk_faq_ajax_add() ) {
      wp_enqueue_script( 'prk-faq-onload.min', get_template_directory_uri() . '/assets/js/vira-faq-onload.js', array ( 'jquery' ), PRK_VERSION, false);
    }
  }

  if (is_front_page()) {
    wp_enqueue_script('vanilla-tilt', parskala_URI . '/assets/js/vanilla-tilt.min.js', array ( 'jquery' ),PRK_VERSION, true);
  }


}

add_action( 'wp_enqueue_scripts', 'add_theme_scripts', 5 );



function prk_end_adder_enqueue(){

  # ceck woocommerce plugins and after load js files
  if (class_exists( 'WooCommerce' )){
    if ( is_product()){
      wp_enqueue_script('prk_productscript', parskala_URI . '/assets/js/vira-productscript.js', array ( 'jquery' ),PRK_VERSION, true);
    if ( mobile_cheker() || tablet_cheker() ) {
      wp_enqueue_script('prk-mobile-product', parskala_URI . '/assets/js/vira-mobile-product.js', array ( 'jquery' ),PRK_VERSION, true);
    }
    }
  }

  wp_enqueue_script( 'prk-fk-purchased', get_template_directory_uri() . '/assets/js/vira-fk-purchased.js', array ( 'jquery' ),PRK_VERSION, true);

  wp_enqueue_style('prk-mini-cart-link', parskala_URI . '/assets/css/mini-cart-link.css', array(), PRK_VERSION, 'all');
  wp_enqueue_script( 'woo-mini-cart', get_template_directory_uri() . '/assets/js/mini-cart.js', array ( 'jquery' ),PRK_VERSION, true);

  wp_enqueue_script( 'prk-custom', get_template_directory_uri() . '/assets/js/custom.js', array ( 'jquery' ),PRK_VERSION, true);

  // ajax load sestyam //
  wp_enqueue_script( 'nprogress-ajax', get_template_directory_uri() . '/assets/js/fct/nprogress.js', array ( 'jquery' ),PRK_VERSION, true);
  wp_enqueue_script( 'loader-ajax', get_template_directory_uri() . '/assets/js/loader.js', array ( 'jquery' ),PRK_VERSION, true);

}
add_action( 'wp_enqueue_scripts', 'prk_end_adder_enqueue', 999999999999999999999 );






//  fonts admin
function prk_fonts_admin() {

	 if ( 'iransans' == fonts_admin() ) {
	 	if (!function_exists( 'iransans_fonts' )) {
	 	  function iransans_fonts() {

	 	     wp_enqueue_style( 'custom_admin_panel_style', trailingslashit( parskala_URI )  . 'fonts/iransans/font-panel.css' );
	 	  }
	 	  add_action( 'admin_enqueue_scripts', 'iransans_fonts' );
	 	}
	 }

	elseif ( 'iranyekan' == fonts_admin()) {
		if (!function_exists( 'iranyekan_fonts' )) {
		  function iranyekan_fonts() {
		     wp_enqueue_style( 'custom_admin_panel_style', trailingslashit( parskala_URI )  . 'fonts/IRANYekanX/font-panel.css' );
		  }
		  add_action( 'admin_enqueue_scripts', 'iranyekan_fonts' );
		}
	}

}

add_action( 'init', 'prk_fonts_admin' );




add_action( 'admin_enqueue_scripts', 'load_admin_style' );
function load_admin_style() {
  if ( !is_rtl() ) {
    wp_enqueue_style( 'style-ltr', get_template_directory_uri() . '/assets/css/lunches/style-ltr.css', false, PRK_VERSION );
  }
    wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/assets/css/lunches/prk-admin1.css', false, PRK_VERSION );
    wp_enqueue_style( 'admin_remixicon', get_template_directory_uri() . '/assets/fonts/ri-fonts/remixicon.css', false, PRK_VERSION );

    wp_enqueue_script( 'prk-admin', get_template_directory_uri() . '/assets/js/admin.js', array ( 'jquery' ), PRK_VERSION, false);

}



// لود فایل ترجمه قالب
function my_theme_setup(){

   $prk_increase_max_variation_wc = get_option('prk_option')['prk_increase_max_variation_wc'] ? get_option('prk_option')['prk_increase_max_variation_wc'] : '30';
   if(filter_var($prk_increase_max_variation_wc, FILTER_VALIDATE_INT) == false || $prk_increase_max_variation_wc <= 0){
     $prk_increase_max_variation_wc = 50;
   }
   define( 'WC_MAX_LINKED_VARIATIONS', $prk_increase_max_variation_wc);
   
 }

add_action( 'after_setup_theme', 'my_theme_setup' );


function shh_unload_textdomain2( $override, $domain ) {
	return get_locale() == 'fa_IR' && ( $domain === 'product-variation-swatches-for-woocommerce' ) ? true : $override;
}

function shh_load_textdomain2( $mo_file, $domain ) {
	if ( get_locale() == 'fa_IR' && $domain === 'product-variation-swatches-for-woocommerce' ) {
		$mo_file = parskala_TEMPLATEPATH . '/languages/product-variation-swatches-for-woocommerce-fa_IR.mo';
	}

	return $mo_file;
}
add_filter( 'override_unload_textdomain',  'shh_unload_textdomain2' , 9999, 2 );
add_filter( 'load_textdomain_mofile',  'shh_load_textdomain2' , 10, 2 );


function check_dokan_plugin_state() {
  if (is_plugin_active('dokan-lite/dokan.php')) {
    return true;
  }
  else {
    return false;
  }
}
add_action('admin_init', 'check_dokan_plugin_state');