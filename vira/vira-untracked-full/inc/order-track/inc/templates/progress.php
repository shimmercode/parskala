<?php
 // Don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

if(!class_exists('prk_ORDER_TRACKER')) {
	return;
}
$ordertrack_set1 = prk_option('des_ordertrack_set1');
$ordertrack_set2 = prk_option('des_ordertrack_set2');
$ordertrack_set3 = prk_option('des_ordertrack_set3');
$ordertrack_set4 = prk_option('des_ordertrack_set4');
$ordertrack_set5 = prk_option('des_ordertrack_set5');
?>
<div class="prk_ws_traking_box">

	<h4 class="statuses-title">وضعیت‌های سفارش</h4>

	<div class="prk_wc_traking_steps">

	<!--Single Step-->
	  <div class="prk_wc_traking_step <?php prk_ORDER_TRACKER::cbwct_wcps('pending', $order->get_status(), 'ali-wc-payment active');?>">
	  	<div class="prk-wc-traking-img">
	  		<img src="<?php echo esc_url(parskala_URI) . '/inc/order-track/img/payment.png'; ?>" title="Payment Pending" alt="Pending">
				<p class="title"><?php echo $ordertrack_set1;?></p>
	  	</div>
	  </div>
	  <!--/ Single Step-->

	<!--Single Step-->
	  <div class="prk_wc_traking_step <?php prk_ORDER_TRACKER::cbwct_wcps('on-hold', $order->get_status(), 'ali-wc-hold active');?>">
	  	<div class="prk-wc-traking-img">
	  		<img src="<?php echo esc_url(parskala_URI) . '/inc/order-track/img/hold.png'; ?>" title="On Hold" alt="Hold">
				<p class="title"><?php echo $ordertrack_set2;?></p>
	  	</div>

	  </div>
	  <!--/ Single Step-->

	<!--Single Step-->
	  <div class="prk_wc_traking_step <?php prk_ORDER_TRACKER::cbwct_wcps('processing', $order->get_status(), 'ali-wc-processing active');?>">
	  	<div class="prk-wc-traking-img">
	  		<img class="<?php prk_ORDER_TRACKER::cbwct_wcps('processing', $order->get_status(), 'cbwct_progress');?>" src="<?php echo esc_url(parskala_URI) . '/inc/order-track/img/processing.png'; ?>" title="Processing" alt="processing">
				<p class="title"><?php echo $ordertrack_set3;?></p>
			</div>
	  </div>
	  <!--/ Single Step-->

	<!--Single Step-->
	  <div class="prk_wc_traking_step <?php prk_ORDER_TRACKER::cbwct_wcps('shipped', $order->get_status(), 'ali-wc-shipping active');?>">
	  	<div class="prk-wc-traking-img">
	  		<img src="<?php echo esc_url(parskala_URI) . '/inc/order-track/img/delivery.png'; ?>" title="Shipping" alt="Shipping">
				<p class="title"><?php echo $ordertrack_set4;?></p>
			</div>
	  </div>
	  <!--/ Single Step-->

	<!--Single Step-->
	  <div class="prk_wc_traking_step <?php prk_ORDER_TRACKER::cbwct_wcps('completed', $order->get_status(), 'ali-wc-delivered active');?>">
	  	<div class="prk-wc-traking-img delivered_img">
	  		<img src="<?php echo esc_url(parskala_URI) . '/inc/order-track/img/delivered.png'; ?>" title="delivered" alt="delivered">
        <p class="title"><?php echo $ordertrack_set5;?></p>
			</div>
	  </div>
	  <!--/ Single Step-->

	</div>
</div>
