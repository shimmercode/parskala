<?php
	 // Don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

if(!class_exists('prk_ORDER_TRACKER')) {
	return;
}

// set variable for getting value from input field
$get_order_number = sanitize_text_field($_POST['order_number']);
$get_phone_number = sanitize_text_field($_POST['phone_number']);




if(empty($get_order_number) || empty($get_phone_number)) { // search field empty check
	apply_filters( 'cbwct_order_number_phone_number_required', 'شماره شناسه یا موبایل نامعتبر' );
}else {

	if(!isset($get_order_number)) { //order number empty
		$order = NULL;

	}else {
		if(prk_ORDER_TRACKER::order_number_exists($get_order_number) == false) {
			 echo  'صورت حسابی با شماره ' .$get_order_number. ' یافت نشد';
		}else {
			$order = wc_get_order( $get_order_number ); // set order number

			$order_data = $order->get_data(); // The Order data

			// get user phone number from shipping form
			$user_shipping_phone_number = isset($order_data['shipping']['phone']) ? $order_data['shipping']['phone'] : '' ;

			// get user phone number from billing form
			$user_billing_phone_number = isset($order_data['billing']['phone']) ? $order_data['billing']['phone'] : '';

			// set phone number value
			if(!empty($user_billing_phone_number)) {
				$user_phone = $user_billing_phone_number;
			}elseif($user_billing_phone_number) {
				$user_phone = $user_billing_phone_number;
			}else {
				$user_phone = '4654654';
			}

			if($get_phone_number === $user_phone || $get_phone_number === $user_phone) {
					if(!empty($order)) {
						$order_data = $order->get_data(); // The Order data

						require_once( get_template_directory() . '/inc/order-track/inc/templates/progressbar.php');
						require_once( get_template_directory() . '/inc/order-track/inc/templates/result.php');
					}
			}else {
				echo apply_filters( 'cbwct_order_is_not_found', 'order is not found!', $get_order_number );
			}
		}
	}
}
