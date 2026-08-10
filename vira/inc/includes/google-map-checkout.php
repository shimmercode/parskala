<?php

function mapInputs (array $fields) : array {
 if ( prk_option('checkout-map', '1') !== '1' ) {
   return $fields;
 }

 $mapDefaultVal = prk_option('checkout-map-details');
 if ( is_array($mapDefaultVal) && isset($mapDefaultVal['latitude'], $mapDefaultVal['longitude']) ) {
   $mapDefaultVal = $mapDefaultVal['latitude'] . ',' . $mapDefaultVal['longitude'];
 } else {
   $mapDefaultVal = '';
 }

if ( prk_option('opti_checkout_map', '1') == '1' ) {
  $required_class = false;
}else {
  $required_class = true;
}

 $fields['billing']['billing_map_address'] = [
   'label'             => __('آدرس نقشه', 'parskala'),
   'required'          => $required_class,
   'class'             => ['address-field'],
   'input_class'       => ['input-has-map', 'prk-hidden'],
   'autocomplete'      => 'billing_map_address',
   'default'           => defined('SD_CUI') ? get_user_meta(SD_CUI, 'billing_map_address',
     true) : $mapDefaultVal,
   'priority'          => 200,
   'custom_attributes' => [
     'data-listen' => '#billing_city, #billing_state',
     'data-map'    => 'billing-map'
   ]
 ];

 $fields['shipping']['shipping_map_address'] = [
   'label'             => __('آدرس نقشه', 'parskala'),
   'required'          => $required_class,
   'class'             => ['address-field'],
   'input_class'       => ['input-has-map', 'prk-hidden'],
   'autocomplete'      => 'shipping_map_address',
   'default'           => defined('SD_CUI') ? get_user_meta(SD_CUI, 'shipping_map_address',
     true) : $mapDefaultVal,
   'priority'          => 200,
   'custom_attributes' => [
     'data-listen' => '#shipping_city, #shipping_state',
     'data-map'    => 'shipping-map'
   ]
 ];


 return $fields;
}



/**
* update order meta map
*/
function updateOrderMeta_map($order_id) {


 if ( isset( $_POST ['billing_map_address'] ) &&  '' != $_POST ['billing_map_address'] ) {
   add_post_meta( $order_id, 'billing_map_address',  sanitize_text_field( $_POST ['billing_map_address'] ) );
 }

 if ( isset( $_POST ['ship_to_different_address'] ) &&  '' != $_POST ['ship_to_different_address'] && isset( $_POST ['shipping_map_address'] ) &&  '' != $_POST ['shipping_map_address'] ) {
   add_post_meta( $order_id, 'shipping_map_address',  sanitize_text_field( $_POST ['shipping_map_address'] ) );
 }


}



// نمایش آدرس پیشفرض
function displayOrderBillingDetails($order){

  $mapLocation = $order->get_meta('billing_map_address');

  if ($mapLocation) {
     echo '<p>';
     echo '<strong>' . __('آدرس نقشه:', 'parskala') . '</strong> ';
     echo '<a href="https://www.google.com/maps/dir//' . $mapLocation . '" target="_blank">' . __('See on google map',
         'parskala') . '</a></p>';
  }

}

// نمایش آدرس سفارشی
function displayOrderShippingDetails($order){

  $mapLocation = $order->get_meta('shipping_map_address');

  if ($mapLocation) {
    echo '<p>';
    echo '<strong>' . __('آدرس نقشه:', 'parskala') . '</strong> ';
    echo '<a href="https://www.google.com/maps/dir//' . $mapLocation . '" target="_blank">' . __('See on google map',
       'parskala') . '</a></p>';
  }

}


add_filter('woocommerce_checkout_fields','mapInputs');
add_action('woocommerce_checkout_update_order_meta','updateOrderMeta_map', 10, 1);
add_action('woocommerce_admin_order_data_after_billing_address','displayOrderBillingDetails');
add_action('woocommerce_admin_order_data_after_shipping_address', 'displayOrderShippingDetails');
