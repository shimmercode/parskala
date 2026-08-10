<?php
global $product;
global $woocommerce;
$currency = get_woocommerce_currency_symbol();
$price = get_post_meta( get_the_ID(), '_regular_price', true);

?>

<article class="item-pro">

   <a href="<?php the_permalink();?>">

      <?php echo pr_img(); ?>

     <div class="index-title-pro">
        <h2><?php echo wp_trim_words(get_the_title(),12,'...') ;?></h2>
     </div>
     <!--price-->
    <div class="index-prices-pro">

      <div class="price_onsale_ar">

           <?php if ($price|| $product->is_type( 'variable' )) {
             echo $product->get_price_html();
           }else{
             echo '<p class="call_pro">', _e('call' , 'vira'). '</p>';}
           ?>

      </div>
    </div>


     </a>
</article>
