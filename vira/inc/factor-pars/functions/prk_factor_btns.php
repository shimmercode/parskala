<?php
use Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController;
function is_hpos_enabled() {
  return class_exists(CustomOrdersTableController::class) && 
  wc_get_container()->get(CustomOrdersTableController::class)->custom_orders_table_usage_is_enabled();
}







/* چک باکس صدور فاکتور درصفحه پرداخت */
add_action('woocommerce_after_order_notes', 'prk_factor_checkbox');
function prk_factor_checkbox($checkout) {
  if (prk_option('f_getfactor') == '1') {
    $dato   = date( strtotime('+1 day'));
    $miladi = prk_factor_jdates("d/M/Y", $dato);

    echo '<div class="get_factor_field"><h3>' . __('صدور فاکتور : ') . '</h3>';
    woocommerce_form_field('getmyfactor_checkbox',
    array(
    'type' => 'checkbox',
    'label' => '<i class="icon-caret-left-blue"></i><span>'.__('Request to send a purchase invoice' , 'parskala').'</span>',
    'required' => false,
    ),
    $checkout->get_value('getmyfactor_checkbox'));
    echo '<span class="get_send_time">'.$miladi.'</span>';
    echo '</div>';

  }
}

add_action('woocommerce_checkout_update_order_meta', 'cw_checkout_order_meta');

function cw_checkout_order_meta($order_id) {
    // دریافت سفارش به روش استاندارد HPOS
    $order = wc_get_order($order_id);
    
    if (!$order) {
        return;
    }

    // ذخیره متادیتای سفارشی در HPOS-compatible format
    if (!empty($_POST['getmyfactor_checkbox'])) {
        $order->update_meta_data('getmyfactor', sanitize_text_field($_POST['getmyfactor_checkbox']));
        $order->save(); // حتماً بعد از تغییر متادیتا، ذخیره کن
    }
}



/* دکمه سفارشات حساب کاربری */
add_filter('woocommerce_my_account_my_orders_actions', 'prk_factor_my_orders_account', 10, 2);

function prk_factor_my_orders_account($actions, $order) {
	$getfactore = 'my_account_getfactor';
  $actions[$getfactore] = array('url' => wp_nonce_url(site_url('?type=print_bill&print_factor_bill=true&post=' . $order->get_id()), 'client-print-factor'), 'name' => 'دریافت فاکتور', 'target' => '_blank');
    return $actions;

}

/*  دکمه دریافت فاکتور در صورت نصب افزونه دکان */
if (class_exists('WeDevs_Dokan')) {

add_filter( 'woocommerce_admin_order_actions', 'add_custom_order_status_actions_button', 100, 2 );

}

function add_custom_order_status_actions_button( $actions, $order ) {

   $factor_link = wp_nonce_url(site_url('?print_factor_bill=true&type=print_bill&post=' . $order->get_id()), 'client-print-factor');
   $label_link  = wp_nonce_url(site_url('?print_factor_bill=true&type=print_label&post=' . $order->get_id()), 'client-print-factor');
   echo '<a class="button tips factor_link_dokan" target="_blank" data-tip="" href="'.$label_link.'"  data-toggle="tooltip" data-placement="top" title="" data-original-title="چاپ برچسب"><i class="ri-price-tag-3-fill"></i></a>';
   echo '<a class="button tips factor_link_dokan" target="_blank" data-tip="" href="'.$factor_link.'" data-toggle="tooltip" data-placement="top" title="" data-original-title="چاپ فاکتور"><i class="ri-printer-fill"></i></a>';
    return $actions;
}



add_action( 'admin_init','dina_register_order_origin_column' );
function dina_register_order_origin_column() {

    $screen_id = wc_get_container()->get(CustomOrdersTableController::class)->custom_orders_table_usage_is_enabled() ? wc_get_page_screen_id( 'shop-order' ) : 'shop_order';
    
    // HPOS and non-HPOS use different hooks.
    add_filter( "manage_{$screen_id}_columns", 'prk_factor_columns_header' );
    add_filter( "manage_edit-{$screen_id}_columns", 'prk_factor_columns_header' );
    // HPOS and non-HPOS use different hooks.
    add_action( "manage_{$screen_id}_custom_column", 'prk_factor_action_column', 10, 2 );
    add_action( "manage_{$screen_id}_posts_custom_column", 'prk_factor_action_column', 10, 2 );
}




/*  عنوان فاکتور در جدول سفارشات */
function prk_factor_columns_header($columns) {
  $factor_columns = array();

  foreach ($columns as $column_name => $column_info) {
      $factor_columns[$column_name] = $column_info;
      if ('order_total' === $column_name) {
          $factor_columns['order_factor'] = __('فاکتور', 'parskala');
      }
  }

  return $factor_columns;
}


/* دکمه دریافت فاکتور در صفحه سفارشات */
function prk_factor_action_column($column, $post_id) {
$order = wc_get_order( $post_id );

$order_id = $order ? $order->get_id() : get_the_ID(); // برای سازگاری با HPOS

$get_factor = prk_option('f_getfactor');
$give_factor =  $order->get_meta('getmyfactor');

$print_factor = wp_nonce_url(admin_url('?print_factor=true&post=' . $order_id . '&type=print_bill'), 'print-factor');
$print_label = wp_nonce_url(admin_url('?print_factor=true&post=' . $order_id . '&type=print_label'), 'print-factor');
  
  

  if ('order_factor' === $column) {

  // شرط اگر افزونه دکان نصب بود
  if (class_exists('WeDevs_Dokan')){
    if ($get_factor) {
       if ($give_factor) {
         echo '<div class="give_factor_order"><i class="ri-checkbox-circle-fill"></i>درخواست صدور فاکتور</div>';
       }else {
         echo '<div class="give_factor_order dont_want"><i class="ri-error-warning-fill"></i>عدم درخواست صدور فاکتور</div>';
       }
      }
    echo '<a class="button tips factor-link factor wp-core-ui button-primary" data-tip="" href="'.$print_factor.'"  target="_blank" data-toggle="tooltip" data-placement="top" data-original-title="چاپ فاکتور">
    <i class="ri-printer-line icon"></i>فاکتور
    </a>';
    echo '<a class="button tips factor-link label" data-tip="" href="'.$print_label.'"  target="_blank" data-toggle="tooltip" data-placement="top" data-original-title="چاپ برچسب">
    <i class="ri-price-tag-3-line icon"></i>برچسب
    </a>';
  }else {

    if ($get_factor) {
       if ($give_factor) {
         echo '<span class="give_factor">درخواست صدور فاکتور</span>';
       }else {
         echo '<span class="give_factor dont_want">عدم درخواست صدور فاکتور</span>';
       }
    }
    echo '<a class="button tips factor-link wp-core-ui button-primary" data-tip="چاپ فاکتور" href="'.$print_factor.'" target="_blank">
    <i class="ri-printer-line icon"></i>فاکتور
    </a>';
    echo '<a class="button tips factor-link" data-tip="چاپ برچسب" href="'.$print_label.'" target="_blank">
    <i class="ri-price-tag-3-line icon"></i>برچسب
    </a>';
  }

 }
}




// اضافه کردن دکمه در جدول
if (!function_exists('sv_helper_get_order_meta')){
  function sv_helper_get_order_meta($order, $key = '', $single = true, $context = 'edit') {
          $order_id = is_callable(array($order, 'get_id')) ? $order->get_id() : get_the_ID();
          $value = get_post_meta($order_id, $key, $single);

      return $value;
  }
}


/* دکمه دریافت فاکتور در صفحه سفارش */
add_action('add_meta_boxes', 'woocommerce_factor_add_box');
function woocommerce_factor_add_box() {
  $screen_id = is_hpos_enabled() ? wc_get_page_screen_id('shop-order') : 'shop_order';

    add_meta_box('prk-factor-box', __('عملیات فاکتور', 'prk-factor'),
     'prk_factor_create_box_order_page',
     $screen_id, // استفاده از screen ID سازگار با HPOS
     'side',
     'default');
}

function prk_factor_create_box_order_page() {

global $post_id;
$order = wc_get_order(get_the_ID());
$order_id = $order ? $order->get_id() : get_the_ID(); // برای سازگاری با HPOS

$get_factor = prk_option('f_getfactor');
$give_factor = $order ? $order->get_meta('getmyfactor') : get_post_meta($order_id, 'getmyfactor', true);

$print_factor = wp_nonce_url(admin_url('?print_factor=true&post=' . $order_id . '&type=print_bill'), 'print-factor');
$print_label = wp_nonce_url(admin_url('?print_factor=true&post=' . $order_id . '&type=print_label'), 'print-factor');



    echo '<div class="give_factor_single">';
    if ($get_factor) {
       if ($give_factor) {
         echo '<span class="give_factor"><i class="ri-checkbox-circle-fill"></i>درخواست صدور فاکتور</span>';
       }else {
         echo '<span class="give_factor dont_want"><i class="ri-error-warning-fill"></i>عدم درخواست صدور فاکتور</span>';
       }
    }
    echo '</div>';

    echo '<div class="flexd-btns">';
    echo '<a class="button tips factor-link single wp-core-ui button-primary" data-tip="چاپ فاکتور" href="'.$print_factor.'" target="_blank"><i class="ri-printer-line icon"></i>فاکتور</a>';
    echo '<a class="button tips factor-link single" data-tip="چاپ برچسب" href="'.$print_label.'" target="_blank"><i class="ri-price-tag-3-line icon"></i>برچسب</a>';
    echo '</div>';
  }


// چک باکس دریافت فاکتور در صفحه تشکر
function prk_get_factor_link($order) {
  global $post;
  $link_factor = wp_nonce_url(site_url('?print_factor_bill=true&type=print_bill&post=' . $order));
  if (prk_option('f_thankyou_link'))
    return '<a href="'.$link_factor .'" class="prk-factor-button" target="_blank"><i class="ri-printer-line"></i>'.__('print factor' , 'parskala').'</a>';
}

function prk_factor_order_print_thankyou($text, $order) {
    if ( ! $order || ! is_a( $order, 'WC_Order' ) ) {
        return $text;
    }

    $factor_link = prk_get_factor_link($order->get_id());
    return $text . ' ' . $factor_link;
}
add_filter('woocommerce_thankyou_order_received_text', 'prk_factor_order_print_thankyou', 999, 2);