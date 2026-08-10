<?php
// مدال های صفحه محصول

global $woocommerce, $product , $post;

$attachment_ids = $product->get_gallery_image_ids();
$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
 'woocommerce_single_product_image_gallery_classes',
 array(
   'woocommerce-product-gallery',
   'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
   'woocommerce-product-gallery--columns-' . absint( $columns ),
   'images',
 )
);


// تنظیمات سفارشی محصول
$meta_opt = $vidoe_aparats = $vidoe_upload = "";
$meta_opt = get_post_meta( get_the_ID(), 'prk_product_options', true );

if(isset($meta_opt) && !empty($meta_opt)){
  if ( isset( $meta_opt['vidoe_upload']['url'] ) )		$vidoe_upload   	    = $meta_opt['vidoe_upload']['url'];
  if ( isset( $meta_opt['vidoe_aparats'] ) )		      $vidoe_aparats   	    = $meta_opt['vidoe_aparats'];
}


// چک کردن افزونه دکان
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$active_dokan = is_plugin_active( 'dokan-lite/dokan.php' );

$single_product_send = prk_option('single_product_send');
$single_product_bail_text = prk_option('single_product_send_title');
$product_send_text = prk_option('single_product_send_text');

$send_title = "";
$send_text  = "";
if ($active_dokan) {
  $vendor_id = get_post_field( 'post_author', get_the_id() );
  $vendor = new WP_User($vendor_id);
  $store_info  = dokan_get_store_info( $vendor_id ); // Get the store data
  $store_name  = $store_info['store_name'];          // Get the store name
  $store_url   = dokan_get_store_url( $vendor_id );  // Get the store URL
  $send_title = 'ارسال توسط '.$store_name;
  $text_sender = ! empty( get_user_meta( $vendor_id, 'dokan_text_sends', true ) ) ? get_user_meta( $vendor_id, 'dokan_text_sends', true ) : $product_send_text;
  $text_send = $text_sender;
}else{
  $text_send = $product_send_text;
}
?>

<!--مدال ویدیو-->
<div class="modal micromodal-slide" id="modalvidoe" aria-hidden="true">
<div class="modal__overlay" tabindex="-1" data-micromodal-close>
  <div style="padding:10px !important; width:85%;" class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
    <button data-micromodal-close="modalvidoe" class="close-box"></button>
      <?php if ( $vidoe_aparats):?>
        <?Php echo $vidoe_aparats; ?>
      <?php elseif($vidoe_upload):?>
        <video width="100%" src="<?php echo $vidoe_upload; ?>"  controls></video>
      <?php endif;?>
  </div>
</div>
</div>

  <!--مدال اشتراک گذاری-->
<div class="modal micromodal-slide" id="modalshare" aria-hidden="true">
<div class="modal__overlay" tabindex="-1" data-micromodal-close>
  <div style="width:1000px;max-width:80%;" class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
    <div class="portal-share-pro">
      <div class="close-btns-pro">
         <button data-micromodal-close="modalshare" class="close-box"></button>
      </div>
      <span class="title-share-pro"><?php _e('share' , 'vira');?></span>
      <span class="text-share-pro"><?php _e('You can share this page with your friends using the methods below.' , 'vira');?></span>
      <div class="social-share-pro">
        <span> <a href="https://twitter.com/intent/tweet?url=<?php the_permalink();?>"><i class="fab fa-twitter" style="background:#4DCCEB;"></i></a> </span>
        <span> <a href="https://www.facebook.com/sharer/sharer.php?m2w&s=100&p[url]=<?php the_permalink();?>"><i class="fab fa-facebook-f" style="background: #4D8DEB;"></i></a> </span>
        <span> <a href="https://api.whatsapp.com/send/?phone&text=<?php the_permalink();?>"><i class="fab fa-whatsapp" style="background: #1BD741;"></i></a> </span>
        <span> <a href="https://telegram.me/share/url?url=<?php the_permalink();?>"><i class="fab fa-telegram-plane" style="background: #33a6dd;"></i></a> </span>
        <span> <a href="<?php the_permalink();?>"><i class="far fa-clone" style="background: transparent;border: 1px solid #535353;color: #535353;"></i></a> </span>
      </div>
    </div>
  </div>
</div>
</div>

<!--  نمودار تغییراتت  -->
<div class="modal micromodal-slide" id="modalchartprice" aria-hidden="true">
<div class="modal__overlay" tabindex="-1" data-micromodal-close>
 <div style="padding:20px !important; width:800px;max-width:60%;" class="modal__container priceshart" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
   <button data-micromodal-close="modalshare" class="close-box"></button>
     <div id="productchartprice">
       <img class="price_chart_ajax_loader" src="<?php echo get_template_directory_uri().'/assets/images/ajax-loader.gif'; ?>">
     </div>
 </div>
</div>
</div>

<!-- مدال جزیئات ارسال  -->
<div id="send_modal" class="modal feed micromodal-slide" >
<div class="modal__defaults sendbox"  data-micromodal-close>
  <div style="padding:10px !important; width:37%;" class="modal__container">

    <div class="flexed flex-feed send">
        <span class="title-feed">جزئیات ارسال</span>
        <button data-micromodal-close="send_modal" class="close-box"></button>
    </div>

    <div class="modal-content">
       <span class="title_send"><?php echo $send_title;?></span>
       <p><?php echo $text_send;?></p>
    </div>

  </div>
</div>
</div>

<!-- مدال گالری تصاویر محصول  -->
<div class="imgs-desctop">
<figure class="woocommerce-product-gallery__wrapper nk_woocommerce-product-gallery__wrapper">
  <?php if ( $post_thumbnail_id ) {
    echo '<div class="woocommerce-product-gallery__image">';
    echo get_the_post_thumbnail( $post , 'shop_single', array( 'id' => 'attachment-shop_single', 'data-zoom-image' => wp_get_attachment_url( $post_thumbnail_id ) ) );
    echo '<div id="show_zoom_container"></div>';
    echo '</div>';
  } else {
    echo '<div class="woocommerce-product-gallery__image--placeholder">';
    echo sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
    echo '</div>';
  }

?>
</figure>

<ul class="main_gallery_product">
<?php if( $attachment_ids ){
  $counter = 0;
    $image_link = wp_get_attachment_url( $post_thumbnail_id );
    echo '<li data-remodal-target="modalvidoe" class="show_modal_gallery vidoe" data-src="'.$image_link.'" >'.wp_get_attachment_image( $post_thumbnail_id, 'shop_thumbnail', false, array() ).'</li>';
    foreach($attachment_ids as $attachment_id){

      $image_link = wp_get_attachment_url( $attachment_id );
      $counter++;

      echo '<li count="'.$counter.'"  data-fancybox="gallery" data-src="'.$image_link.'" >'.wp_get_attachment_image( $attachment_id, 'shop_thumbnail', false, array() ).'</li>';
       if ( $counter == 4) {
        $image_link = wp_get_attachment_url( $post_thumbnail_id );
        echo '<li  data-fancybox="gallery"   class="show_modal_gallery" data-src="'.$image_link.'" >'.wp_get_attachment_image( $post_thumbnail_id, 'shop_thumbnail', false, array() ).'</li>';

        }

    }
}
?>
</ul>

</div>

<div class="imgs-mobile">
<div class="swiper-responsive-product-slider">
  <div class="swiper-wrapper">
  <?php
      if ( $product->get_image_id() ) {
        $image_link = wp_get_attachment_url( $post_thumbnail_id );
        echo '<div data-fancybox="gallery-mob" data-src="'.$image_link.'" class="swiper-slide newkala_product_image">';
        echo get_the_post_thumbnail( $post , 'shop_single' );

        echo '</div>';
      } else {
        echo '<div class="swiper-slide newkala_product_image">';
        echo sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
        echo '</div>';
      }
    ?>

<?php
$attachment_ids = $product->get_gallery_image_ids();
if ( $attachment_ids && has_post_thumbnail() ) {
foreach ( $attachment_ids as $attachment_id ) {
$image_link = wp_get_attachment_url( $attachment_id );
  echo '<div data-fancybox="gallery-mob" data-src="'.$image_link.'" class="swiper-slide">'.wp_get_attachment_image( $attachment_id, 'shop_single' ).'</div>';
}
}

?>
  </div>
  <!-- Add Pagination -->
  <div class="swiper-pagination"></div>

</div>

<script>
jQuery(document).ready(function($){
Fancybox.bind('[data-fancybox="gallery-mob"]',{
Toolbar: true,
closeButton: "top",
});
});

jQuery(document).ready(function(){
var swiper = new Swiper('.swiper-responsive-product-slider', {
pagination:{
el: '.swiper-pagination',
dynamicBullets: true,
lazy: true,
},
});
});


jQuery(document).ready(function($){
Fancybox.bind('[data-fancybox="gallery"]', {
Toolbar: true,
closeButton: "top",
});
});


</script>
</div>
