<?php

function sku_product_prk(){
  $sku_product_prk = '';
  global $product;
 $product_sku = prk_option('single_product_sku');
 ?>

  <?php if ( $product_sku && wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
    <div class="product_meta">
  	   <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>
    </div>
  <?php endif; ?>

  <?php
 return $sku_product_prk;
}
