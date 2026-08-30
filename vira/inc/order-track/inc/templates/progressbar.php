<?php
 // Don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

if(!class_exists('prk_ORDER_TRACKER')) {
	return;
}

?>

	<!-- cbwct Tracking Progress bar-->
	<div class="cbwct-tracking-porgressbar">

		<?php
			if(prk_ORDER_TRACKER::order_class($order->get_status())) {
				require_once('progress.php');
			}
		?>

	</div><!--/ cbwct Tracking Progress bar-->
