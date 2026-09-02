<?php


// نمایش آخرین برند و دسته انتخاب شده
add_action('woocommerce_single_product_summary','add_summary_inner_before', 3);
function add_summary_inner_before(){

  echo '<div class="boxed_title">';

}

// نمایش آخرین برند و دسته انتخاب شده
add_action('woocommerce_single_product_summary','add_summary_inner_before_title', 5);
function add_summary_inner_before_title(){

  // آخرین دسته و برند انتخاب شده محصول
  breadcrumb_product();
   echo '</div>';

}




/* شروع قلاب اندازی محصولات ساده */

// تگ سمت راست باز شد
add_action('woocommerce_product_meta_start','add_product_meta_start_simple');
function add_product_meta_start_simple(){

   global $product;
   if (! $product->is_type('variable')){

     echo '<div class="des-info">
     <div class="flexed price_detales">';


   }

}



// تگ قبل از فرم سبد خرید
add_action('woocommerce_before_add_to_cart_form','add_before_add_to_cart_simple');
function add_before_add_to_cart_simple(){

  global $product;
  if (! $product->is_type('variable')){



     echo prk_fashion_detales();

     echo '<div class="woocommerce-variation-price">';
      products_price();
     echo '</div></div>';

    echo '</div>';


   }

}

// تگ قبل از فرم بسته شد
add_action('woocommerce_after_add_to_cart_form','add_after_add_to_cart_simple');
function add_after_add_to_cart_simple(){

   global $product;
   if (! $product->is_type('variable')){

     echo '</div>';



   }

}
