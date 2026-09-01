<?php
add_action( 'dokan_profile_settings_before_form', function(){
	if (defined('ACTIVE_TEMPLATE_DOKAN')) echo '<div class="dokan-dashboard-header"></div>';
});
add_action( 'dokan_settings_before_form', function(){
	if (defined('ACTIVE_TEMPLATE_DOKAN')) echo '<div class="dokan-dashboard-header"></div>';
});

add_filter('dokan_store_widget_args', 'prk_customize_html_widget_sidebar_store_page');
function prk_customize_html_widget_sidebar_store_page($args){



	$args = array(
				'name'          => __( 'Dokan Store Sidebar', 'dokan-lite' ),
				'class' => 'sidebar-store',
				'id'            => 'sidebar-store',
				'before_title' => '<div class="title-widget-archive-product"><h5>',
				'after_title' => '</h5></div>',
				'before_widget' => '<div id="%1$s" class="mian_widg_archive_product %2$s">',
				'after_widget' => '</div>'
			);

	return $args;
}
add_filter( 'body_class',function($classes){

	if(! function_exists('dokan_is_store_page') ) return $classes;

	if( dokan_is_store_page() )
		$classes[] = 'archive';
    return $classes;
});


add_action('dokan_after_listing_product', 'prk_remove_class_add_product_popup');
function prk_remove_class_add_product_popup(){
	echo '<script>jQuery("a.dokan-add-new-product").removeClass("dokan-add-new-product");</script>';
}




add_action('dokan_dashboard_content_before' , function(){

	global $wp;
	if ( isset( $wp->query_vars['settings'] ) && defined('ACTIVE_TEMPLATE_DOKAN') )
		get_sidebar('dokan');
});






	add_filter('post_date_column_time', 'prk_post_date_column_time_dokan2', 10, 2);

	function prk_post_date_column_time_dokan2($h_time, $post){

		if(is_admin()) return $h_time;

		//$order = wc_get_order( $order_id );
		//$order_timestamp = get_the_date($post); $order->order_date;
		//$h_time = date_i18n( get_option( 'date_format' ) . ' - ' . get_option( 'time_format' ), strtotime( $order_timestamp ) );

		$h_time = get_the_date( get_option( 'date_format' ) . ' - ' . get_option( 'time_format' ), $post );

		return $h_time;
	}







function prk_dokan_report_sales_overview( $start_date, $end_date ) {
    global $woocommerce, $wpdb, $wp_locale;

    $total_sales = $total_orders = $order_items = $discount_total = $shipping_total = 0;

    $order_totals = dokan_get_order_report_data( array(
        'data' => array(
            '_order_total' => array(
                'type'     => 'meta',
                'function' => 'SUM',
                'name'     => 'total_sales'
            ),
            '_order_shipping' => array(
                'type'     => 'meta',
                'function' => 'SUM',
                'name'     => 'total_shipping'
            ),
            'ID' => array(
                'type'     => 'post_data',
                'function' => 'COUNT',
                'name'     => 'total_orders'
            )
        ),
        'filter_range' => true,
        // 'debug' => true
    ), $start_date, $end_date );

    $total_sales    = $order_totals->total_sales;
    $total_shipping = $order_totals->total_shipping;
    $total_orders   = absint( $order_totals->total_orders );
    $total_items    = absint( dokan_get_order_report_data( array(
        'data' => array(
            '_qty' => array(
                'type'            => 'order_item_meta',
                'order_item_type' => 'line_item',
                'function'        => 'SUM',
                'name'            => 'order_item_qty'
            )
        ),
        'query_type' => 'get_var',
        'filter_range' => true
    ), $start_date, $end_date ) );

    // Get discount amounts in range
    $total_coupons = dokan_get_order_report_data( array(
        'data' => array(
            'discount_amount' => array(
                'type'            => 'order_item_meta',
                'order_item_type' => 'coupon',
                'function'        => 'SUM',
                'name'            => 'discount_amount'
            )
        ),
        'where' => array(
            array(
                'key'      => 'order_item_type',
                'value'    => 'coupon',
                'operator' => '='
            )
        ),
        'query_type' => 'get_var',
        'filter_range' => true
    ), $start_date, $end_date );

    $average_sales = $total_sales / ( 30 + 1 );

    $legend =  array(
        __('فروش در این ماه', 'parskala') =>  wc_price( $total_sales ) ,

        __('میانگین فروش روزانه', 'parskala') =>  wc_price( $average_sales ) ,

        __('سفارشات ثبت شده', 'parskala') =>  $total_orders ,

        __('تعداد کالای خریداری شده', 'parskala') =>  $total_items ,

        __('هزینه حمل و نقل', 'parskala') =>  wc_price( $total_shipping ) ,

        __('جمع کوپن های استفاده شده', 'parskala') =>  wc_price( $total_coupons )
        ) ;
    return $legend;
}







add_action('wp_head','dokan_customization',999);
function dokan_customization() {
	if( ! defined('SHH_DOKAN_PLUS_PLUS_CLASSES_DIR')):
		if ( dokan_is_seller_dashboard() || dokan_is_store_page() ){

			$current_user_id        = get_current_user_id();
			$current_user           = wp_get_current_user();
			$current_user_avatare   = get_avatar_url($current_user_id);
			?>
            <div class="widget_avatar" style="display: none;"><?php echo $current_user_avatare; ?></div>
            <script>
                jQuery(document).ready(function($) {
                    // add profile widget
                    var user_profile_widget = '<div class="c-profile-box"><div class="c-profile-box__header"><div class="c-profile-box__avatar js-user-avatar"></div><button class="c-profile-box__btn-edit js-change-avatar"></button></div><div class="c-profile-box__username"><?php _e('سلام','parskala'); ?> ، <?php echo $current_user->data->display_name; ?></div><div class="c-profile-box__tabs"><a href="<?php echo dokan_get_store_url($current_user_id) ?>" class="c-profile-box__tab c-profile-box__tab--access"><?php _e('مشاهده فروشگاه','parskala'); ?></a><a href="<?php echo wp_logout_url(); ?>" class="c-profile-box__tab c-profile-box__tab--sign-out"><?php _e('خروج از حساب','parskala') ?></a></div></div>';
                    $('.dokan-dashboard-menu').before(user_profile_widget);
                    // change position of titles
                    $(".widget-title").each(function() {
                        $(this).parent().before(this);
                    });
                    // fix avatar url
                    $('.c-profile-box__avatar').css('background-image','url(<?php echo $current_user_avatare; ?>)');
                    // change tab name
                    $('#tab-title-more_seller_product a').text("<?php _e('محصولات بیشتر این فروشنده','parskala'); ?>");
                    // fix height in store list
                    var heights = jQuery("#dokan-seller-listing-wrap ul.dokan-seller-wrap li .store-content .store-info").map(function () {
                        return jQuery(this).height();
                    }).get();
                    maxHeight = Math.max.apply(null, heights);
                    jQuery("#dokan-seller-listing-wrap ul.dokan-seller-wrap li .store-content .store-info").height(maxHeight);
                });
            </script>
			<?php
		}
	endif;
}







add_action('dokan_product_edit_after_product_tags', function($post, $post_id){

	?>

<div class="dokan-form-group">
	<label for="garrantie" class="form-label"><?php _e('گارانتی محصول', 'parskala'); ?></label>
	<input type="text" name="product_granti_text" id="product_granti_text" value="<?php echo get_post_meta($post_id, 'product_granti_text', true); ?>" class="dokan-form-control" placeholder="">
</div>

<div class="dokan-form-group">
	<label for="send_by" class="form-label"><?php _e('بسته بندی و ارسال توسط:', 'parskala'); ?></label>
	<input type="text" name="send_by" id="send_by" value="<?php echo get_post_meta($post_id, 'send_by', true); ?>" class="dokan-form-control" placeholder="">
</div>

<div class="dokan-form-group">
	<label for="stock_name" class="form-label"><?php _e('آماده ارسال از انبار:', 'parskala'); ?></label>
	<input type="text" name="stock_name" id="stock_name" value="<?php echo get_post_meta($post_id, 'stock_name', true); ?>" class="dokan-form-control" placeholder="">
</div>

<?php }, 10, 2);





add_action('dokan_process_product_meta' ,function($post_id){


	$postdata = wp_unslash( $_POST );
	update_post_meta( $post_id, 'product_granti_text', $postdata['product_granti_text'] );
	update_post_meta( $post_id, 'send_by', $postdata['send_by'] );
	update_post_meta( $post_id, 'stock_name', $postdata['stock_name'] );
	update_post_meta( $post_id, 'custom_attributes', $postdata['custom_attributes'] );
}, 10, 1);








add_action('dokan_product_edit_after_title', function($post, $post_id){

	?>

<div class="dokan-form-group">
	<label for="parskala_subtitle_product" class="form-label"><?php _e('تیتر انگلیسی محصول', 'parskala'); ?></label>
	<input dir="ltr" type="text" name="en_pro_name" id="en_pro_name" value="<?php echo get_post_meta($post_id, 'en_pro_name', true); ?>" class="dokan-form-control" placeholder="">
</div>


<?php }, 10, 2);




add_action('dokan_process_product_meta' ,function($post_id){



	$postdata = wp_unslash( $_POST );
	update_post_meta( $post_id, 'en_pro_name', $postdata['en_pro_name'] );
}, 10, 1);
