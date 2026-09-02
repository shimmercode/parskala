<?php

// تابع امکان برگشت

function product_return(){
  $return_product = '';
  $return_show = get_post_meta(get_the_ID(), 'product_return_show', true );
  $return_text = product_return_value();
  if ($return_show == 'yes' ){
  echo '<div class="product_return">';
  echo '<i class="ri-error-warning-line"></i>';
  echo '<span>'.$return_text.'</span>';
  echo '</div>';
  }
  return $return_product;
}
