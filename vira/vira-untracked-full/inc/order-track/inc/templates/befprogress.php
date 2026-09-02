<div class="prk_wc_traking_steps">

<!--Single Step-->
	<div class="prk_wc_traking_step">
		<div class="prk-wc-traking-img">
			<img src="<?php echo esc_url(parskala_URI) . '/inc/order-track/img/payment.png'; ?>" title="Payment Pending" alt="Pending">
		</div>
		<div class="prk-wc-traking-title">

		</div>
	</div>
	<!--/ Single Step-->

<!--Single Step-->
	<div class="prk_wc_traking_step">
		<div class="prk-wc-traking-img">
			<img src="<?php echo esc_url(parskala_URI) . '/inc/order-track/img/hold.png'; ?>" title="On Hold" alt="Hold">
		</div>
		<div class="prk-wc-traking-title">

		</div>
	</div>
	<!--/ Single Step-->

<!--Single Step-->
	<div class="prk_wc_traking_step">
		<div class="prk-wc-traking-img">
			<img class="<?php prk_ORDER_TRACKER::cbwct_wcps('processing', $order->get_status(), 'cbwct_progress');?>" src="<?php echo esc_url(parskala_URI) . '/inc/order-track/img/processing.png'; ?>" title="Processing" alt="processing">
		</div>
		<div class="prk-wc-traking-title">

		</div>
	</div>
	<!--/ Single Step-->

<!--Single Step-->
	<div class="prk_wc_traking_step">
		<div class="prk-wc-traking-img">
			<img src="<?php echo esc_url(parskala_URI) . '/inc/order-track/img/delivery.png'; ?>" title="Shipping" alt="Shipping">
		</div>
		<div class="prk-wc-traking-round "></div>
	</div>
	<!--/ Single Step-->

<!--Single Step-->
	<div class="prk_wc_traking_step">
		<div class="prk-wc-traking-img">
			<img src="<?php echo esc_url(parskala_URI) . '/inc/order-track/img/delivered.png'; ?>" title="delivered" alt="delivered">
		</div>
		<div class="prk-wc-traking-title "></div>
	</div>
	<!--/ Single Step-->

</div>
