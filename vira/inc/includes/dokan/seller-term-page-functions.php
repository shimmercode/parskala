<?php

function prk_show_avatar_to_seller_term(){

  if (! is_tax(prk_TAXONOMY_SELLERS) ) return;

  $term_id = get_queried_object()->term_id;

  $seller_id = get_term_meta($term_id , 'prk_seller_id_term_seller', true);

  dokan_get_template_part( 'prk-store-avatar', '', array(
    'seller_id'      => $seller_id,
  ) );

}


function prk_get_rating_seller($seller_id){

  $rating = dokan_get_seller_rating( $seller_id );

  $reat_percent = $rating['rating']  ? (int) $rating['rating'] * 20 : 0;

             ?>
             <div class="prk-text-reating-seller">
               <?php
                 if( $reat_percent === 0 )
                   echo '<span class="prk-not-reat">'.__('امتیازی ثبت نشده', 'newkala').'</span>';
                 else
                   echo '<span class="prk-percent-customer">'.$reat_percent.'٪ رضایت مشتریان</span> | <span class="nk-count-reviews">'.$rating['count'].' رای</span>';
               ?>
             </div>
             <div class="prk-rating-seller">

               <span class="prk-rating-back"></span>
               <span class="prk-rating-front" style="width:<?= $reat_percent ?>%;"></span>

             </div>
<?php
}



//add_action('prk_before_products_catalog', 'move_result_count_before_store_tabs');
function move_result_count_before_store_tabs(){
  if (! is_tax(prk_TAXONOMY_SELLERS) ) return;
  remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20);
  add_action( 'woocommerce_before_main_content' , 'woocommerce_result_count', 21);
}
