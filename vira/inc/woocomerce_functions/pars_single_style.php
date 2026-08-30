<?php

remove_action(
    'woocommerce_single_product_summary',
    'woocommerce_template_single_brand',
    6
);

remove_action(
    'woocommerce_single_product_summary',
    'woocommerce_template_single_brand',
    6
);


// نمایش بازخورد در حالت دسکتاپ
add_action('woocommerce_breadcrumb','add_before_single_product_summary');
function add_before_single_product_summary(){

    $feed_product = prk_option('feed_product');
    if ( is_singular('product') && $feed_product ){

    if (is_user_logged_in()) {

       echo '<div class="feed-btn show desctop" data-remodal-target="modal-feed" >'.__('Feedback about this product','parskala').'</div>';
       echo '<div class="feed-btn desctop thanks">متشکریم بازخورد شما دریافت شد</div>';

    }else {

       echo '<div class="feed-btn show desctop" data-custom-open="loginmodal" >'.__('Feedback about this product','parskala').'</div>';

    }

   }

}

// نمایش بازخورد در حالت موبایل
add_action('prk_item_mobile_product_tabs_reviews','add_after_single_product_summary', 5);
function add_after_single_product_summary(){

 $feed_product = prk_option('feed_product');
 if ($feed_product){
    echo '<div class="feed-btn show mobile" data-remodal-target="modal-feed" >'.__('Feedback about this product','parskala').'
     <i class="prk-info-circle"></i>
    </div>';
    echo '<div class="feed-btn mobile thanks">متشکریم بازخورد شما دریافت شد</div>';
    }

}

// نمایش سرویس های صفحه محصول
add_action('woocommerce_after_single_product_summary','prk_add_after_single_product_summary', 1);
function prk_add_after_single_product_summary(){

    echo prk_services();

}


// نمایش آخرین برند و دسته انتخاب شده
add_action('woocommerce_single_product_summary','add_summary_inner_before', 3);
function add_summary_inner_before(){

  echo '<div class="title_compleates flexed_start">';

  // // // نمایش لوگو برند محصول
  // brandlogo_product();

  echo '<div class="boxed_title">';

  // آخرین دسته و برند انتخاب شده محصول
  if (! mobile_cheker() && ! tablet_cheker()) {
    breadcrumb_product();
  }


}

// نمایش آخرین برند و دسته انتخاب شده
add_action('woocommerce_single_product_summary','add_summary_inner_before_title', 5);
function add_summary_inner_before_title(){
  $product_label = get_post_meta(get_the_ID(), 'prk_product_label', true );
  if ($product_label) {
    echo '<span class="single_custom_label">'.$product_label.'</span>';
  }

   echo product_pro_name();



   echo '</div></div>';
   
   

}


function prk_single_product_brand(){

   $brands = wc_get_product_terms(
      get_the_ID(),
      'product_brand',
      array(
         'fields' => 'all',
      )
   );

   if ( empty( $brands ) ) {
      return;
   }

   echo '<div class="prk-product-brand prk-font">';

      echo '<span class="label">برند:</span>';

      foreach ( $brands as $brand ) {

         echo '<a href="' . esc_url( get_term_link( $brand ) ) . '">';
            echo esc_html( $brand->name );
         echo '</a>';

      }

   echo '</div>';

}

/* شروع قلاب اندازی محصولات متغییر */

// تگ قبل از فرم باز شد
add_action('woocommerce_before_variations_form','add_before_add_to_cart_form');
function add_before_add_to_cart_form(){

   echo '<div class="des-info">';

}

// تگ بعد از فرم برای متغییر ها
add_action('woocommerce_before_variations_form','add_before_variations_form');
function add_before_variations_form(){

   global $product;
   global $post;
   echo '<div class="des-right">';
   
   if ( mobile_cheker() || tablet_cheker()) {
      breadcrumb_product();
   }
   ratings_counters();
   if (prk_option('prk_tag_product_viewed1') == 1 )
   echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n('prk-Tags:', '<span>Tags:</span>', count( $product->get_tag_ids() ), 'parskala' ) . ' ', '</span>' );
   count_recommended();

}

// تگ بعد از فرم متغییر ها بسته شد و تگ دکمه سبد خرید باز شد
add_action('woocommerce_after_variations_table','add_after_variations_table');
function add_after_variations_table(){

   global $product;
   costom_attributes();
   exerpt_content();
   product_return();
   product_facke_brands();
   warning_hamta();
   special_sendproduct();

   prk_single_product_brand();

   product_sendes();
   echo '</div>';

   echo '<div class="des-left"><div class="' . esc_attr(prk_single_product_seller_box_class()) . '">';
   element_preloder();
   seller_info();

   $class_support = '';
   if ( class_exists('WeDevs_Dokan') ) {
     $store_support_show = dokan_get_option( 'store_support_product_page', 'dokan_store_support_setting', 'above_tab' );
     if ( 'above_tab' == $store_support_show ) {
       $class_support = 'tflex';
     }else {
       $class_support = '';
     }
   }

   if (prk_option('modern_mobile_toolbar_blur')) {
     $blur_class = 'blur_back';
   }else {
     $blur_class = '';
   }

   echo '<div class="back_holder '.$class_support.''.$blur_class.' ">';
}

// تگ بعد از دکمه سبد خرید بسته شد
add_action('woocommerce_after_single_variation','add_after_single_variation');
function add_after_single_variation(){

   echo '</div></div>';

}


// تگ قبل از فرم بسته شد
add_action('woocommerce_after_variations_form','add_after_add_to_cart_form');
function add_after_add_to_cart_form(){

   get_template_part('woocommerce/single-product/better_btn');
   echo '</div>';
   echo '</div>';

}
/* تگ قبل از فرم بسته شد */



/* شروع قلاب اندازی محصولات ساده */

// تگ قبل از فرم سبد خرید
add_action('woocommerce_before_add_to_cart_form','add_before_add_to_cart_simple');
function add_before_add_to_cart_simple(){

  global $product;
  if (! $product->is_type('variable')){

     echo '<div class="des-left"><div class="' . esc_attr(prk_single_product_seller_box_class()) . '">';
     element_preloder();
     seller_info();
     products_price();

   }

}

// تگ قبل از فرم بسته شد
add_action('woocommerce_after_add_to_cart_form','add_after_add_to_cart_simple');
function add_after_add_to_cart_simple(){

   global $product;
   if (! $product->is_type('variable')){

     echo '</div></div>';

     do_action('prk_after_info_box');

     get_template_part('woocommerce/single-product/better_btn');
     echo '</div>';
     echo '</div>';

   }

}

// تگ سمت راست باز شد
add_action('woocommerce_product_meta_start','add_product_meta_start_simple');
function add_product_meta_start_simple(){

   global $product;
   if (! $product->is_type('variable')){

     echo '<div class="des-info">';
     echo '<div class="des-right">';
     
     if ( mobile_cheker() || tablet_cheker()) {
        breadcrumb_product();
        ratings_counters();

        count_recommended();
     }else {
       ratings_counters();
       if (prk_option('prk_tag_product_viewed1') == 1 )
       echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n('prk-Tags:', '<span>Tags:</span>', count( $product->get_tag_ids() ), 'parskala' ) . ' ', '</span>' );
       count_recommended();
     }

     costom_attributes();
     exerpt_content();
     product_return();
     product_facke_brands();
     warning_hamta();
     special_sendproduct();

     prk_single_product_brand();

     product_sendes();

   }

}

// تگ سمت راست بسته شد
add_action('woocommerce_product_meta_end','add_after_product_meta_end_simple');
function add_after_product_meta_end_simple(){

 global $product;
 if (! $product->is_type('variable')){

   echo '</div>';

 }

}

function parskala_update_price(){
  if ( prk_option('prk_show_prod_up_date') == '1' || prk_option('prk_show_prod_up_date') == ''  ){
  ?>
      <span class="parskala-update-price"><?php _e('Date Updated:', 'parskala') ?>
        <span class="product-update-date"><?php echo get_the_modified_time('j F Y');  ?></span>
      </span>
  <?php
  }
}

  add_action('prk_add_after_price_product','parskala_update_price');

