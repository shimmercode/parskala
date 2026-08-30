<?php

// product sku
function product_sku(){
  $skus = '';
  global $product;
?>
<div class="product_meta">


<?php do_action('prk_before_product_meta_woocomerce'); ?>

<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

  <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>

<?php endif; ?>

  </div>
<?php
    return $skus;
}
