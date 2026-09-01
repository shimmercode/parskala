<?php

// تابع محصول غیر اصل

function product_facke_brands(){
    $facke_pro = '';
    $general_show = prk_option('single_product_bail');
    $product_facke_show = get_post_meta(get_the_ID(), 'product_facke_brand_show', true );
    $product_facke_text = product_facke_value();
      if ($general_show && $product_facke_show == 'yes' ){
      		echo '<span class="info-other">';
      		echo '<i class="exclamation-triangle"></i>';
          echo  _e($product_facke_text , 'vira');
      		echo '</span>';
      }
    return $facke_pro;
}
