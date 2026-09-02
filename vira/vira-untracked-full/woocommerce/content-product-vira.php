<?php
/**
 * Compact product card used on the Vira homepage.
 *
 * @package Vira
 */

defined( 'ABSPATH' ) || exit;

global $product;
if ( ! $product || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'vira-product-card', $product ); ?> style="background:#fff;border-radius:14px;overflow:hidden;list-style:none;">
	<a href="<?php echo esc_url( $product->get_permalink() ); ?>" style="display:block;padding:12px;">
		<?php echo $product->get_image( 'woocommerce_thumbnail', array( 'style' => 'width:100%;height:180px;object-fit:contain;' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<h3 style="font-size:14px;margin:10px 0 6px;line-height:1.5;"><?php echo esc_html( $product->get_name() ); ?></h3>
		<div class="price"><?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
	</a>
</li>
