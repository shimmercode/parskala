<?php

// product english

function product_pro_name(){
  $englishs_name = '';
  $product_pro_name = get_post_meta( get_the_ID(), 'en_pro_name', true );
  if ($product_pro_name){
  echo '<div class="product-en"><span class="en_name_pro">'.$product_pro_name.'</span></div>';
  }
  return $englishs_name;
}

 ?>
