<?php
  $seller_name = prk_option('archive_product_seller_name');
  $product_orginal = prk_option('archive_product_orginal');
  $product_stock = prk_option('archive_product_stock');
  $product_thumbnail_2 = prk_option('archive_product_thumbnail_2');
  $vendor_id = get_post_field( 'post_author', get_the_id() );

global $post, $product;
global $woocommerce;
$currency = get_woocommerce_currency_symbol();
$price = get_post_meta( get_the_ID(), '_regular_price', true);
$sale = get_post_meta( get_the_ID(), '_sale_price', true);
$regular_price 	= get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
$onsales_round = get_post_meta(get_the_ID(), 'onsales_round', true );
$img_up_pro = get_post_meta(get_the_ID(),'img_up_pro',true);
$Original_pro = get_post_meta(get_the_ID(),'Original_pro',true);
$regular_price 	= get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
$timer_id = generateRandomString();
$thumber = get_the_post_thumbnail();
$imager  = wc_placeholder_img_src();
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$active_dokan = is_plugin_active( 'dokan-lite/dokan.php' );
if($active_dokan){
$vendor = new WP_User($vendor_id);
  $store_info  = dokan_get_store_info( $vendor_id );
  $store_name  = $store_info['store_name'];
  $store_url   = dokan_get_store_url( $vendor_id );
}

 ?>

<article class="item-pro-index <?php if (! $product->is_in_stock()){ echo 'no-stock';}?>">

  <a href="<?php the_permalink();?>">
  <!-- sale-flash -->
  <div class="head-archie-pro not">

  <?php if ($onsales_round == 'yes' ):?>

    <div class="head-archie-pro">

    <span class="onsale prs"><?php _e('special offer !' , 'parskala');?></span>

      <?php if($regular_price):?>

       <p id="sales_timer_display" class="timer-pros1-<?php echo $timer_id;?>"></p>
       <script type="text/javascript">
         var dateEnd = new Date((<?php echo $regular_price; ?>) * 1000);
         new TimezZ('.timer-pros1-<?php echo $timer_id;?>', {
         date: dateEnd,
         template: '<span><span class="number">NUMBER</span><span class="dot">:</span><span class="letter">LETTER</span></span>',
         text: {
         days: 'روز',
         hours: 'ساعت',
         minutes: 'دقیقه',
         seconds: 'ثانیه',
           }
         });
        </script>

      <?php endif;?>

      </div>



  <?php elseif($product->is_on_sale()):?>

  <div class="head-archie-pro">
     <span class="onsale prs"><?php _e('onsale !' , 'parskala');?></span>
     <p id="sales_timer_display" class="timer-pros2-<?php echo $timer_id;?>"></p>
     <script type="text/javascript">
       var dateEnd = new Date((<?php echo $regular_price; ?>) * 1000);
       new TimezZ('.timer-pros2-<?php echo $timer_id;?>', {
       date: dateEnd,
       template: '<span><span class="number">NUMBER</span><span class="dot">:</span><span class="letter">LETTER</span></span>',
       text: {
       days: 'روز',
       hours: 'ساعت',
       minutes: 'دقیقه',
       seconds: 'ثانیه',
         }
       });
      </script>
  </div>

  <?php else:?>

    <div class="head-archie-pro no">
      <span class="onsale prs"></span>
    </div>

  <?php endif;?>

  </div>

  <div class="flexd_resposvie">
  <div class="dl_right">
   <?php echo pr_img(); ?>
  </div>




<div class="dl_left">
<!-- title -->
 <div class="index-title-pro archive">
    <h2><?php echo wp_trim_words(get_the_title(),15,'...') ;?></h2>
 </div>

<!-- stock -->
 <?php if ($product_stock):?>
 <span class="stock-archive">
<?php if ($product->is_in_stock()):?>
<i class="share-square"></i>
<?php if (wc_get_stock_html( $product )):?>
<span class="stockon"><?php global $product; echo wc_get_stock_html( $product ); ?></span>
<?php else:?>
<span class="in-stock"><?php _e('in stock' , 'parskala');?></span>
<?php endif;?>

<?php else:?>
  <i class="share-square"></i>
  <span class="in-stock"><?php _e('Not available in stock' , 'parskala');?></span>
<?php endif;?>
</span>
<?php endif;?>

<!--price-->
<div class="index-prices-pro">

  <div class="price_onsale_ar">

       <?php if ($price|| $product->is_type( 'variable' )) {
         echo $product->get_price_html();
       }else{
         echo '<p class="call_pro">', _e('call' , 'parskala'). '</p>';}
       ?>

  </div>
</div>

<!-- author -->
<div class="author-Original">
  <?php if ($product_orginal):?>
  <?php if($Original_pro):?>
  <span class="no-Original"><?php _e('non original' , 'parskala');?></span>
<?php endif;?>
<?php endif;?>
<?php if ($seller_name):?>
<span class="author-ar"><i class="seller-store"></i><?php _e('Seller' , 'parskala');?>
  <?php if($active_dokan):?>
  <span class="authours-ar"><?php echo $store_name;?></span>
<?php else:?>
<?php echo get_the_author_meta( 'display_name');?>
<?php endif;?>
</span>
<?php endif;?>
</div>
</div>
</div>
</a>
</article>
