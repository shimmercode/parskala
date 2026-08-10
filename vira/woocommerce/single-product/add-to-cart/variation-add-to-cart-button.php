<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.5.1
 */

defined( 'ABSPATH' ) || exit;

global $product;
$StockQ = $product->get_stock_quantity();
$checker = new mob_cheker;
$signle_cart_text = get_post_meta(get_the_ID(), 'prk_add_to_cart_label', true );
$general_cart_text = prk_option('prk_single_product_text_cart');
$opnened_miny_cart = prk_option('opnened_miny_cart');
if ($opnened_miny_cart) {
  $class_opened = "opnened_mcart";
}else {
  $class_opened = "";
}
?>

<?php if ( prk_option('prk_show_prod_up_date') == '1' || prk_option('prk_show_prod_up_date') == '' ):?>

	<span class="vira-update-price"><?php _e('Date Updated:', 'vira') ?>
		<span class="product-update-date"><?php echo get_the_modified_time('j F Y');  ?></span>
	</span>

<?php endif;?>

<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php
	do_action( 'woocommerce_before_add_to_cart_quantity' );

	woocommerce_quantity_input(
		array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		)
	);

	do_action( 'woocommerce_after_add_to_cart_quantity' );
	?>

	<button type="submit" class="single_add_to_cart_button button alt product-seller-row <?php echo $class_opened;  if ( $product->is_sold_individually( )|| ($StockQ==1 ) ){ echo 'maxw';};?>">

		<?php

			if ( ! empty($signle_cart_text) ) {

				echo esc_html( $signle_cart_text );

			}
			elseif( ! empty($general_cart_text) ) {

				echo esc_html( $general_cart_text );

			}
			else {

				echo esc_html( $product->single_add_to_cart_text() );

			}


		?>

	</button>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
