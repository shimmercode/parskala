<?php


/**

* درصورت فعال بودن سیستم ووکامرس فایل های زیر لود میشوند !

* @package     parskala
* @Author      Hosein Esmaliyan
* @link        http://www.parskalas.ir
*/

// WooCommerce functions
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

  // توابع منحصر بفرد صفحه ووکامرس
  include(locate_template('/woocommerce/single-product/attributes.php'));
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/facke-brands-product.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/warning_hamta.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/product_excerpt.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/sku-product.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/serveis_product.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/send-product.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/recommended.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/english-name.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/product_sku.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/element_preloader.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/ratings_faq_counter.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/product_price.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/product_return.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/fashion_detales.php');
  include(locate_template('/woocommerce/single-product/product-seller-info.php'));
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/breadcrumb_product.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/special_send_product.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/single-product/brandlogo_product.php');
  include(parskala_TEMPLATEPATH.'/woocommerce/product-variation-swatches-for-woocommerce/product-variation-swatches-for-woocommerce.php');

  // فایل های مربوط به ووکامرس
  include(parskala_TEMPLATEPATH.'/inc/admin/woo/attached.php');
  include(parskala_TEMPLATEPATH.'/inc/includes/price-chart-pro.php');
  include(parskala_TEMPLATEPATH.'/inc/includes/product_price_chart.php');
  //include(parskala_TEMPLATEPATH.'/inc/includes/single_send_dates.php');
  include(parskala_TEMPLATEPATH.'/inc/includes/view_product.php');
  include(parskala_TEMPLATEPATH.'/inc/includes/jdfs.php');
  include( parskala_TEMPLATEPATH.'/inc/includes/advanced-review.php');
  include(parskala_TEMPLATEPATH.'/inc/includes/comments-tab.php');
  include(parskala_TEMPLATEPATH.'/inc/includes/prk_cart_function.php');
  include(parskala_TEMPLATEPATH.'/inc/includes/dokan_metabox.php');

  
  include(parskala_TEMPLATEPATH.'/inc/includes/subcategories-product.php');
  include(parskala_TEMPLATEPATH.'/inc/includes/subtitle-product.php');
  include(parskala_TEMPLATEPATH.'/inc/includes/brands-filter.php');
  include(parskala_TEMPLATEPATH.'/inc/includes/categorys-filter.php');
  include(parskala_TEMPLATEPATH.'/inc/includes/stock-status.php');
  include(parskala_TEMPLATEPATH.'/inc/includes/prk_related_products_args.php');
  include(parskala_TEMPLATEPATH.'/inc/includes/edit-price-woocommerce.php');
  include(parskala_TEMPLATEPATH.'/inc/prk-sms/prk-sms.php');
  include(parskala_TEMPLATEPATH.'/inc/auth/auth.php');
  include(parskala_TEMPLATEPATH.'/inc/includes/prk-woo-actions.php');

  include(parskala_TEMPLATEPATH.'/inc/template/brand-shortcode.php');


  include(parskala_TEMPLATEPATH.'/inc/whishlist-pars/prk_whishlist.php');
  include(parskala_TEMPLATEPATH.'/inc/elementor/prk-elementor.php');


  include(parskala_TEMPLATEPATH.'/inc/includes/subbetter-product.php');
  // هوک های اختصاصی به قالب
  include(parskala_TEMPLATEPATH.'/inc/woocomerce_functions/single_product_functions.php');

  // هوک های اختصاصی به صفحه فروشگاه
  include(parskala_TEMPLATEPATH.'/inc/woocomerce_functions/prk_archive_product.php');

  // لود ایجکسی صفحه فروشگاه
  if (prk_option('prk_shop_ajax_add') == 1 ) {
    include(parskala_TEMPLATEPATH.'/inc/includes/ajax-load-product.php');
  }

  // آدرس دهی داینامیک سیستم مقایسه محصول
  get_template_part( 'inc/template/compare-shortcode');
  if(! defined('YITH_WOOCOMPARE')) include(parskala_TEMPLATEPATH.'/inc/includes/compare.php');
  if(! defined('YITH_WOOCOMPARE')) include(parskala_TEMPLATEPATH.'/inc/includes/compare-class.php');

  if( prk_option( 'sort_by_stock' ) == 'instock' ) {
    include(parskala_TEMPLATEPATH.'/inc/includes/order-class.php');
  }
  // سیستم پرسش و پاسخ محصول
  if (prk_option('single_product_faq')) {
    include(parskala_TEMPLATEPATH.'/inc/includes/faq-single-product.php');
  }

  // زمان ارسال محصول
  if ( prk_option('checkout-delivery') ) {
    include(parskala_TEMPLATEPATH.'/inc/includes/functions-send-order.php');
  }


  // گروه بندی ویژگی های اختصاصی
  if ( prk_option('prk_gattributes_enable') == 1 || prk_option('prk_gattributes_enable') == NULL ) {

    add_action('after_setup_theme', function() {
      require_once get_template_directory() . '/inc/woocommerce-group-attributes/woocommerce-group-attributes.php';
  });
  
  }

  // فاکتور ساز پارس کالا
  if (prk_option('factor_pars') == 1 || prk_option('factor_pars') == NULL) {
    include(parskala_TEMPLATEPATH.'/inc/factor-pars/prk_factor.php');
  }

  // استوری ساز پارس کالا
  if ( prk_option('prk_story_Activation') == 1 ) {
    include(parskala_TEMPLATEPATH.'/inc/parskala-story/parskala-story.php');
  }


  // سیستم بازخورد دهی محصول
  if ( prk_option('feed_product') ) {
    include(parskala_TEMPLATEPATH.'/inc/includes/Feedback-single-product.php');
  }
  // سیستم تقارن در قیمت محصول
  if (prk_option('better_product')) {
    include(parskala_TEMPLATEPATH.'/inc/includes/better-single-product.php');
  }

  include(parskala_TEMPLATEPATH.'/inc/includes/prk-widget-carusel-product.php');


  // if(file_exists(parskala_TEMPLATEPATH.'/inc/prk-size-guide/prkSizeGuidePlugin.php')){ include_once(parskala_TEMPLATEPATH.'/inc/prk-size-guide/prkSizeGuidePlugin.php'); }

  // اضافه کردن به لیست سبد بعدی
  include(parskala_TEMPLATEPATH.'/inc/next_shopping/next_shopping.php');
  
  // سیستم نقشه
  if ( prk_option('checkout-map') == '1' ) {
    include(parskala_TEMPLATEPATH.'/inc/includes/google-map-checkout.php');
  }
  // افزودن به سبد خرید ایجکسی در صفحه محصول
  if( prk_option( 'ajax_add' ) && get_option( 'woocommerce_enable_ajax_add_to_cart' ) === 'yes' && get_option( 'woocommerce_cart_redirect_after_add' ) === 'no') {
    include(parskala_TEMPLATEPATH.'/inc/includes/prk-ajax-add-to-cart.php');
  }

  if (prk_option('prk_order_tracker') ) {
    include(parskala_TEMPLATEPATH.'/inc/order-track/order-track.php');
  }
  if ( prk_option('prk_order_tracker') && prk_option('order_tracker_myaccount') ) {
    include(parskala_TEMPLATEPATH.'/inc/order-track/inc/add-endpoint.php');
  }


  if (prk_option('get_location') == 1 && prk_option('prk_filter_location') == 1) {
    include(parskala_TEMPLATEPATH.'/inc/includes/set-location-Cookie.php');
  }

  // کد رهگیری سفارش
  // if ()
  include(parskala_TEMPLATEPATH.'/inc/includes/tracking-code.php');

  // سیستم دسته بندی ایجکسی
  include(parskala_TEMPLATEPATH.'/inc/woocomerce_functions/front-ajax.php');


}
  // سیستم جستجوی ایجکسی پارس کالا
  include(parskala_TEMPLATEPATH.'/inc/includes/search_product.php');

  // quick view
  include(parskala_TEMPLATEPATH.'/inc/woo-quick-view/woo-quick-view.php');
  

  // سیستم اطلاع رسانی از موجود شدن کالا !
  //include(parskala_TEMPLATEPATH.'/inc/notify-product-activity/notify-product-activity.php');
  // require_once(parskala_TEMPLATEPATH.'/inc/PRKSMSApp/PRKSMSApp.php');


  // سیستم ویرایشگر فرم صفحه پرداخت !
  if (prk_option('checkout_manager_form') == '1'){
    include(parskala_TEMPLATEPATH.'/inc/prkwoocfem/start.php');
  }

if( class_exists('Dokan_Pro') && class_exists('WeDevs_Dokan') ){

	include(parskala_TEMPLATEPATH.'/inc/includes/dokan/dokan-functions.php');
	include(parskala_TEMPLATEPATH.'/inc/includes/dokan/dokan-customize.php');

	define('ACTIVE_TEMPLATE_DOKAN', true);
	include(parskala_TEMPLATEPATH.'/inc/includes/dokan/new-product.php');
	include(parskala_TEMPLATEPATH.'/inc/includes/dokan/seller-term-page-functions.php');




	if( defined('DOKAN_SPMV_DIR') )
	{

		include(parskala_TEMPLATEPATH.'/inc/includes/Dokan_SPMV_Products.php');
		$show_order = dokan_get_option( 'show_order', 'dokan_spmv', 'show_all' );
    //     if ( 'show_all' !== $show_order )
		// {
    //         add_filter( 'posts_where_request', 'prk_filter_where_request' , 10, 2 );
    //         add_filter( 'posts_join_request',  'prk_filter_join_request' , 10, 2 );
    //     }
		// function prk_filter_where_request( $where, $wp_query )
		// {
		// 	global $wpdb;

		// 	if ( 'product' === $wp_query->get( 'post_type' ) || 'product_cat' === $wp_query->get( 'taxonomy' ) ) {
		// 		$where .= " AND ( {$wpdb->prefix}dokan_product_map.visibility = 1 OR {$wpdb->prefix}dokan_product_map.visibility IS NULL )";
		// 	}

		// 	return $where;
		// }
		// function prk_filter_join_request( $join, $wp_query )
		// {
		// 	global $wpdb;

		// 	if ( 'product' === $wp_query->get( 'post_type' ) || 'product_cat' === $wp_query->get( 'taxonomy' ) ) {
		// 		$table = "{$wpdb->prefix}dokan_product_map";
		// 		$join .= " left join {$table} on {$wpdb->posts}.ID = {$table}.product_id";
		// 	}

		// 	return $join;
		// }

	}

}
