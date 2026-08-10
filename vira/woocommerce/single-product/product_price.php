<?php

function products_price(){
  $product_price = '';
  global $product;
  $text_price = prk_option('single_product_text_price');

  $class_support = '';
  if ( class_exists('WeDevs_Dokan') ) {
    $store_support_show = dokan_get_option( 'store_support_product_page', 'dokan_store_support_setting' );
  }

  if (prk_option('modern_mobile_toolbar_blur')) {
    $blur_class = ' blur_back';
  }else {
    $blur_class = '';
  }

   ?>

  <!-- display call price -->
  <div class="back_holder<?= $class_support.''.$blur_class?>">
  <div class="cart-pro price">

  <?php if($product->get_price_html()==null && $product->is_in_stock()):?>
  <p class="call_pro"><?php echo $text_price;?></p>
  <?php elseif($product->is_in_stock() ):?>

    <?php echo $product->get_price_html(); ?>

  <?php else:?>
  <span class="tab-pro unavailable">
  <div class="stock-pros single-stock">
  <span class=""><?php _e('unavailable' , 'vira');?></span>
  </div>
  </span>
  <?php endif;?>
  
  </div>
  <?php do_action('prk_add_after_price_product');?>
  <?php
  return $product_price;
}
