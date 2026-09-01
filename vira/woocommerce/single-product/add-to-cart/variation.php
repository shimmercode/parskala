<?php
/**
 * Single variation display
 *
 * This is a javascript-based template for single variations (see https://codex.wordpress.org/Javascript_Reference/wp.template).
 * The values will be dynamically replaced after selecting attributes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;




?>
<?php if (theme_style() == 'prk-fashion'): ?>

<script type="text/template" id="tmpl-variation-template">

	<div class="woocommerce-variation-description">{{{ data.variation.variation_description }}}</div>
	

	<div class="flexed price_detales">

	<?php echo prk_fashion_detales();?>

	 <div class="woocommerce-variation-price">{{{ data.variation.price_html }}}</div>
     
 </div>

  <?php if (prk_option('show_variation_stock') == '1' || prk_option('show_variation_stock') == '' ):?>
     <div class="woocommerce-variation-availability">{{{ data.variation.availability_html }}}</div>
  <?php endif;?>

</script>

<?php else: ?>

	<script type="text/template" id="tmpl-variation-template">
	    <?php if ( prk_option('show_variation_stock') == '1' || prk_option('show_variation_stock') == ''  ):?>
	       <div class="woocommerce-variation-availability">{{{ data.variation.availability_html }}}</div>
		<?php endif;?>
		<div class="woocommerce-variation-price">{{{ data.variation.price_html }}}</div>
		<div class="woocommerce-variation-description">{{{ data.variation.variation_description }}}</div>
		

	</script>

<?php endif;?>


<script type="text/template" id="tmpl-unavailable-variation-template">
	<p><?php esc_html_e( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' ); ?></p>
</script>
