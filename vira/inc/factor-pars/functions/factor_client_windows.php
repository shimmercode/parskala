<?php

function prk_factor_template($type, $template) {
    $templates = array();
    if (file_exists(trailingslashit( parskala_TEMPLATEPATH ) . 'inc/factor-pars/template/' . $template )) {

        $templates['uri'] = trailingslashit(parskala_TEMPLATEPATH) . 'inc/factor-pars/template/';
        $templates['dir'] = trailingslashit(parskala_TEMPLATEPATH) . 'inc/factor-pars/template/';

    }
    return $templates[$type];
}


//  Function the printing window

add_action('init', 'prk_factor_client_windows');

function woocommerce_factor_user_access() {
    $access = (current_user_can('edit_shop_orders') || current_user_can('manage_woocommerce_orders')) ? false : true;
    return $access;
}


function prk_factor_client_windows() {

    if (isset($_GET['print_factor_bill']) && isset($_GET['post'])) {
        $nonce = $_REQUEST['_wpnonce'];
        $orderidss = $_GET['post'];
        $order = new WC_Order($orderidss);
        $current_user = wp_get_current_user();


        if (class_exists('WeDevs_Dokan') ) {
            $taypes = $_GET['type'];
            $client = false;
        remove_action('wp_footer', 'wp_admin_bar_render', 1500);

        // output.
        ob_start();
        require_once prk_factor_template('dir', 'factor-header.php') . 'factor-header.php';
        $content = ob_get_clean();
        ob_start();
        include prk_factor_template('dir', 'factor-body.php') . 'factor-body.php';
        $content.= ob_get_clean();
        ob_start();
        require_once prk_factor_template('dir', 'factor-footer.php') . 'factor-footer.php';
        $content.= ob_get_clean();
        echo $content;
        exit;
        }
        else {
          $taypes = 'print_bill';
          $client = true;

          remove_action('wp_footer', 'wp_admin_bar_render', 1500);

          // the output.
          ob_start();
          require_once prk_factor_template('dir', 'factor-header.php') . 'factor-header.php';
          $content = ob_get_clean();
          ob_start();
          include prk_factor_template('dir', 'factor-body.php') . 'factor-body.php';
          $content.= ob_get_clean();
          ob_start();
          require_once prk_factor_template('dir', 'factor-footer.php') . 'factor-footer.php';
          $content.= ob_get_clean();
          echo $content;
          exit;
        }

    }
}


// Function to printing window for single item and printing

add_action('admin_init', 'prk_factor_window_print');

function prk_factor_window_print() {
   if (isset($_GET['print_factor'])) {

       $nonce = $_REQUEST['_wpnonce'];
       $client = false;


       if ( !is_user_logged_in() || woocommerce_factor_user_access()){
         die('برای چاپ فاکتور باید وارد حساب کاربری خود شوید !');
       }

       remove_action('wp_footer', 'wp_admin_bar_render', 1500);
       $orders = explode(',', $_GET['post']);
       $taypes = $_GET['type'];
       $number_of_orders = count($orders);
       $order_loop = 0;

       ob_start();
       require_once prk_factor_template('dir', 'factor-header.php') . 'factor-header.php';
       $content = ob_get_clean();


       foreach ($orders as $order_id) {
           $order_loop++;
           $order = wc_get_order($order_id);
           ob_start();
           include prk_factor_template('dir', 'factor-body.php') . 'factor-body.php';
           $content.= ob_get_clean();
       }

       ob_start();
       require_once prk_factor_template('dir', 'factor-footer.php') . 'factor-footer.php';
       $content.= ob_get_clean();

       echo $content;
       exit;

   }
}

// prk factor order bulk
function prk_factor_order_bulk_action() {
	global $woocommerce;
  $wp_list_table = _get_list_table('WP_Posts_List_Table');
  $taypes = $wp_list_table->current_action();

  if ($taypes == 'print_bill' || $taypes == 'print_label') {

      $posts = '';
      foreach ($_REQUEST['post'] as $post_id) {
          if (empty($posts)) {
              $posts = $post_id;
          } else {
              $posts.= ',' . $post_id;
          }
      }

      $forward = wp_nonce_url(admin_url(), 'print-factor');
      $forward = add_query_arg(array('print_factor' => 'true', 'post' => $posts, 'type' => $taypes), $forward);
      wp_redirect($forward);
      exit();

  }

}
add_action('load-edit.php', 'prk_factor_order_bulk_action');

// templates functions




// جدول شماره فاکتور و شماره بارکد فاکتور
add_action('woocommerce_order_status_processing_to_completed', 'woocommerce_factor_getbarcode');
add_filter('woocommerce_subscriptions_renewal_order_meta_query', 'factor_remove_subscription_order_meta', 10, 4);
function factor_remove_subscription_order_meta($order_meta_query, $original_order_id, $renewal_order_id, $new_order_role) {
    // factor numberic
    $order_meta_query.= " AND `meta_key` NOT IN ( '_factor_bill_number' )";
    return $order_meta_query;

}

add_filter('woocommerce_subscriptions_renewal_order_meta_query', 'factor_remove_subscription_order_metas', 10, 5);
function factor_remove_subscription_order_metas($order_meta_query, $original_order_id, $renewal_order_id, $new_order_role) {
    // factor barcodes
    $order_meta_query.= " AND `meta_key` NOT IN ( 'prk_factor_barcodes' )";
    return $order_meta_query;

}
function woocommerce_factor_getbarcode($order_id){
    if (empty($order_id)) return;

    $order = wc_get_order($order_id);
    if (!is_a($order, 'WC_Order')) return;

    // فقط وقتی شماره فاکتور وجود نداره، ایجاد کن
    if (!$order->get_meta('_factor_bill_number')) {
        $factor_number = 'F-' . absint($order_id) . '-' . time();
        $order->update_meta_data('_factor_bill_number', $factor_number);
        $order->save();
    }
}