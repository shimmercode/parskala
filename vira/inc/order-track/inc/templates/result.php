<?php
 // Don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

if(!class_exists('prk_ORDER_TRACKER')) {
	return;
}
$dato   = strtotime($order->get_date_created()) ;
$miladi = prk_factor_jdates("Y/m/d", $dato);
$order->get_date_created()->date_i18n('H:i:s , Y F j');
$order_items['total'] = floatval($order->get_subtotal())-floatval( $order_items['discount'])+floatval($order_items['shipping']);
$order_items['shipping']= $order->get_shipping_total();
$address_2 = $order->get_billing_address_2();
$symbol = get_woocommerce_currency_symbol();

if (! $address_2) {
	$not_ad2 = 'border-btm';
}else {
	$not_ad2 = '';// code...
}

?>
<p class="description"><?php echo prk_option('des_ordertrack');?></p>

<div class="prk-tracking-list">
 <div class="address-details">
   <div class="billing-address">

			<div value="customer-address">
				 <span class="label">
					 <span class="icons-Delivery-Post"></span>
					 آدرس صورت حساب
					 <span class="customer-result">
						<?php echo $order->get_billing_address_1(); ?>
					 </span>
				 </span>
			</div>

      <?php if ($order->get_billing_phone()): ?>
				<div value="customer-phone">
					 <span class="label">
						 تلفن
						 <span class="customer-result"><?php echo $order->get_billing_phone(); ?></span>
					 </span>
				</div>
      <?php endif; ?>

      <?php if ($order->get_billing_email()): ?>
				<div value="customer-email">
					 <span class="label">
						 آدرس ایمیل
						 <span class="customer-result"><?php echo $order->get_billing_email(); ?></span>
					 </span>
				</div>
      <?php endif; ?>
   </div>

   <?php if ($order->get_billing_address_2()): ?>
		 <div class="shipping-address">
	     <div class="customer-address">
		      <span class="label"><span data-icon="Badges-Delivery-Post"></span>آدرس برای ارسال بار : </span>
		      <span class="customer-result"><?php echo $order->get_billing_address_2(); ?></span>
	     </div>
	   </div>
   <?php endif; ?>

 </div>

 <div class="woocommerce-order-details">

  <div class="item-totals <?php echo $address_2;?>">

   <div class="cart_subtotal">
     <span class="label">مجموع: </span>
		 <span class="customer-result"><?php echo $order->get_shipping_total() . $symbol; ?></span>
   </div>

	 <div class="cart_subtotal">
		 <span class="label">حمل و نقل: </span>
		<span class="customer-result"><?php echo $order_items['shipping'].' '.get_woocommerce_currency_symbol(); ?></span>
	 </div>

	 <div class="cart_subtotal">
		 <span class="label">روش پرداخت: </span>
		<span class="customer-result"><?php echo ucwords($order->get_payment_method_title());?></span>
	 </div>

	 <div class="cart_subtotal">
		 <span class="label">قیمت کل: </span>
		<span class="customer-result"><?php echo $order_items['total'] . $symbol;; ?></span>
	 </div>

  </div>
  <div class="order-items">
    <?php foreach ($order->get_items() as $item_id => $item):

			$product_id = $item['product_id'];
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'shop_catalog')[0];
			$link = get_permalink($product_id);
			// تنظیمات گارانتی
			$general_show_granti = prk_option('single_product_Warranty');
			$granti_show = get_post_meta($product_id, 'product_granti_show', true );
			$granti_text = get_post_meta($product_id, 'product_granti_text', true );
      $product = wc_get_product( $product_id );
			if (prk_option('gard_icon')) {
				$gard_icon = prk_option('gard_icon');
			}else {
				$gard_icon = 'ri-shield-check-line';
			}
			 ?>
			<div class="order-item">
			  <div class="product-img">

			<a target="_blank" href='<?php echo $link ?>'><img src='<?php echo $image ?>' /></a>

			<a target="_blank" class="go-product" href='<?php echo $link ?>'>
      <span class="digikala-icon-cart"></span>
			</a>

			 </div>

			 <div class="product-name">
				 <h4 class="product-title">
          <a target="_blank" href='<?php echo $link ?>'> <?php echo esc_html(wp_trim_words($item->get_name(),9)); ?></a>
				 </h4>

        <?php

				if ($general_show_granti && $granti_show == null) {
					echo '<div class="product-info">';
					echo '<i class="icon '.$gard_icon.'"></i>';
					echo $granti_text;
					echo '</div>';
				}

				if (wc_get_stock_html( $product )){
					echo '<div class="product-info">';
					echo '<i class="icon share-square stock"></i>';
					echo wc_get_stock_html( $product );
					echo '</div>';
				}else {
					echo '<div class="product-info">';
					echo '<i class="icon share-square stock"></i>';
					echo 'موجود در انبار';
					echo '</div>';

				}

				?>
				<!--price-->
			<div class="index-prices-pro">

				<div class="price_onsale_ar">

						 <?php if ($price|| $product->is_type( 'variable' )) {
							 echo $product->get_price_html();
						 }else{
							 echo '<p class="call_pro">', _e('call' , 'parskala'). '</p>';}
						 ?>

				</div>
			</div>
			<div class="view-product">
	 		 <a href="<?php the_permalink($item->get_product_id());?>" target="_blank">مشاهده محصول</a>
	 	 </div>

			 </div>

			 <!-- <div class="product-info">
				 <span></span>

			 </div>

			 <div class="product-info">

			 </div> -->



			</div>
	<?php endforeach; ?>
  </div>
 </div>

</div>
