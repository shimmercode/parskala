<?php
 // Don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

	if(!class_exists('prk_ORDER_TRACKER')) {
		return;
	}

?>


	<div class="prk-tracking-container">
		<div class="prk-tracking">
			<div class="prk-tracking-title">
				<span class="icon-tracking-title">
          <i class="icons-Delivery-Post"></i>
				</span>
				<h2><?php echo prk_option('title_ordertrack');?></h2>
			</div>

			<!--Tracking Form -->
			<div class="prk-tracking-from">
				<form method="POST">
					<div class="prk-tracking-form-area">

						<div class="prk-tracking-form-field order_number">
							<label for="order_number">شماره سفارش</label>
              <label class="prk-tracking-inputer">
								<input type="text" id="order_number" name="order_number" placeholder="شماره سفارش خود را وارد کنید.">
							</label>

						</div>

						<div class="prk-tracking-form-field phone">
							<label for="phone">شماره موبایل</label>

              <label class="prk-tracking-inputer">
					  		<input type="text" id="phone" name="phone_number" placeholder="شماره موبایلی که در هنگام خرید وارد کرده اید.">
							</label>
						</div>

						<div class="prk-tracking-form-field prk-traking-form-submit">
							<?php wp_nonce_field('cbwct_nonce_data'); ?>
							<input type="submit" value="رهگیری سفارش">
						</div>

					</div>
				</form>
			</div><!--/ Tracking Form -->


			<!-- Show All Output-->
			<div class="prk-traking-form-result"></div><!--/ Show All Output-->

		</div>
	</div>
