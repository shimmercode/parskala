<?php

// rating and faq counter

function ratings_counters(){

 $ratings_nummbercomment = '';
 $product_sku = prk_option('single_product_sku');
 global $product;
 global $post;
 ?>
 <div class="rating_and_nummbercomment">

   
  <div class="flexed">
   <div class="rating_product">
     <i class="ri-star-fill star"></i>
     <span class="average_rating"><?php echo $product->get_average_rating(); ?></span>
   </div>
   <span class="rating_count"> <?php echo _e( 'from', 'parskala' ); ?> <?php  echo $product->get_rating_count();  ?> <?php echo _e( 'vote', 'parskala' ); ?></span>
 </div>
   <div class="comments_number">
     <i class="ri-checkbox-blank-circle-fill"></i>
     <p><span><?php echo $product->get_rating_count(); ?></span><?php echo _e( 'comments', 'parskala' ); ?></p>
   </div>

   <div class="comments_number">

     <?php $myposts = get_posts( array(
         'posts_per_page' => -1,
         'post_type'         => 'product-faq',
         'post_parent'       => $product->get_id()
     ) );
     if ( $myposts ) {
       $counter = 0;
       foreach ($myposts as $post){
       setup_postdata( $post );
       $get_count_faq = $counter;
       $counter++;
       }
     echo '<p><span>'.$counter.'</span>'.__('question','parskala').'</p>';
    wp_reset_postdata();
     }
   ?>
   </div>
   
   <?= sku_product_prk();?>

 </div>
 <?php
 return $ratings_nummbercomment;
}

 ?>
