
<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.2.0
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

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

  <?php do_action( 'prk_woocommerce_add_to_cart_form'); ?>

	<?php do_action( 'woocommerce_after_add_to_cart_form' );?>
