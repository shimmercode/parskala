<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

 defined( 'ABSPATH' ) || exit;

 // Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
 if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
 	return;
 }

 if (  class_exists( 'YITH_Woocompare' )) {
 	$result = do_shortcode('[yith_compare_button]');
 }

 global $product , $post;

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


// تنظیمات کلی قالب
$product_whislist = prk_option('single_product_whislist');
$product_share = prk_option('single_product_share');
$product_vidoe = prk_option('single_product_vidoe');
$general_product_compare = prk_option('single_product_compare');
$product_compare = prk_option('single_product_compare_btn');
$prk_chartp = prk_option('single_product_prk_chartp');
$product_ask = prk_option('single_product_ask');
$compare_page = prk_option('compare_page');
$themeـstyle = prk_option('theme-style');




// تنظیمات سفارشی محصول
$meta_opt = $vidoe_aparats = $vidoe_upload = "";
$meta_opt = get_post_meta( get_the_ID(), 'prk_product_options', true );

if(isset($meta_opt) && !empty($meta_opt)){
  if ( isset( $meta_opt['vidoe_upload']['url'] ) )		$vidoe_upload   	    = $meta_opt['vidoe_upload']['url'];
  if ( isset( $meta_opt['vidoe_aparats'] ) )		      $vidoe_aparats   	    = $meta_opt['vidoe_aparats'];
}


$onsales_round = get_post_meta(get_the_ID(), 'onsales_round', true );

if ( $product -> is_type( 'variable' ) ) {
    $children_ids = $product->get_children();
    $date = '';
    foreach ( $children_ids as $children_id ) {
        if ( ! empty( $date ) )
            break;
        $child_date = get_post_meta( $children_id, '_sale_price_dates_to', true );
        if ( ! empty( $child_date ) ) {
            $date = $child_date;
        }
    }
} else {
    $date = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
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

<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?> mobit " data-columns="<?php echo esc_attr( $columns );?>">

    <?php if ($onsales_round == 'yes' ):?>
		 <div class="head-pros">
     <span class="onsale prs">
      <svg
        version="1.1"
        width="259.20001pt"
        height="259.20001pt"
        id="svg6"
        viewBox="0 0 259.20001 259.20001"
        sodipodi:docname="MOBIT   ICON.cdr"
        xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
        xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:svg="http://www.w3.org/2000/svg">
        <defs
          id="defs10" />
        <sodipodi:namedview
          id="namedview8"
          pagecolor="#ffffff"
          bordercolor="#000000"
          borderopacity="0.25"
          inkscape:showpageshadow="2"
          inkscape:pageopacity="0.0"
          inkscape:pagecheckerboard="0"
          inkscape:deskcolor="#d1d1d1"
          inkscape:document-units="pt" />
        <path
          d="m 129.7054,259.3709 c 106.9137,0 129.2631,-23.0399 129.2541,-129.3603 C 258.9504,22.3211 236.8941,1.026 129.7054,0.723 23.5047,0.4208 0.6073,23.5033 0.4213,130.0106 0.2317,237.1685 22.5049,259.3709 129.7054,259.3709 Z M 81.1769,36.1864 c -35.4725,4.2144 -42.6574,14.367 -46.3038,49.9257 -3.1474,30.6992 -2.808,64.0259 0.5871,93.7072 3.9666,34.6604 15.5011,41.4016 51.6486,45.1796 29.9135,3.1265 62.1442,2.6248 92.0269,-0.734 35.0851,-3.9422 41.995,-16.7414 45.43,-50.3648 3.1048,-30.4153 2.8816,-64.0904 -0.5507,-93.983 -3.9631,-34.5616 -17.1841,-41.3219 -51.7158,-44.8639 -30.5368,-3.1356 -61.1045,-2.4298 -91.1223,1.1332 z"
          style="fill:#fff;fill-rule:evenodd"
          id="path2" />
        <path
          d="m 167.5687,91.7902 v 0 c 6.3436,6.3436 6.3444,16.7235 9e-4,23.067 l -53.6166,53.6166 c -6.3436,6.3436 -16.7234,6.3427 -23.067,-9e-4 v 0 c -6.3436,-6.3435 -6.3436,-16.7234 0,-23.067 l 53.6157,-53.6157 c 6.3436,-6.3435 16.7234,-6.3435 23.067,0 z m -3.3302,57.4072 c 8.7113,0 15.7725,7.0612 15.7725,15.7724 0,8.7112 -7.0612,15.7725 -15.7725,15.7725 -8.7112,0 -15.7724,-7.0613 -15.7724,-15.7725 0,-8.7112 7.0612,-15.7724 15.7724,-15.7724 z M 95.1405,79.3479 c 8.7112,0 15.7724,7.0613 15.7724,15.7725 0,8.7112 -7.0612,15.7724 -15.7724,15.7724 -8.7113,0 -15.7725,-7.0612 -15.7725,-15.7724 0,-8.7112 7.0612,-15.7725 15.7725,-15.7725 z"
          style="fill:#fff;fill-rule:evenodd"
          id="path4" />
      </svg>
    <?php _e('special offer !' , 'parskala');?>

    </span>
		 <?php if($date):


       ?>
		 		<p id="sales_timer_display" class="countdown-item mobit"></p>
        <script type="text/javascript">
              var dateEnd = new Date((<?php echo $date; ?>) * 1000);
              new TimezZ('.countdown-item.mobit', {
              date: dateEnd,
              template: '<span class="countzarin-col"><span class="countdown-unit"> <span  class="number">NUMBER</span></span><span class="dot">:</span></span>',
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

 <div class="head-pros">
    <span class="onsale prs"><?php _e('فروش ویژه !' , 'parskala');?></span>
		<?php if($date) {
      echo '<p id="sales_timer_display" class="timer-pros" data-date=" '.date('Y-m-d',$date).'"></p>';?>
      <script type="text/javascript">
        var dateEnd = new Date((<?php echo $date; ?>) * 1000);
        new TimezZ('.timer-pros', {
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
  <?php
}
?>

</div>

<?php endif;?>




<?php


get_template_part('inc/template/feed-modal');

get_template_part('inc/template/better-modal');

?>

<!--مدال ویدیو-->

<div id="modalvidoes" class="remodal remodal-lg modalvidoes remodal-maxed" data-remodal-id="modalvidoe" data-remodal-options="hashTracking: false">




    <div class="remodal-header">
      <div class="remodal-title">ویدیو:</div>
      <button data-remodal-action="close" class="remodal-close"></button>
    </div>

    <?php if ( $vidoe_aparats):?>

    <?Php echo $vidoe_aparats; ?>


    <?php elseif($vidoe_upload):?>

      <video width="100%" src="<?php echo $vidoe_upload; ?>" controls></video>

    <?php endif;?>



</div>


  <!--مدال اشتراک گذاری-->


<div id="modalshare" class="remodal remodal-xs remodal-lg modalshare remodal-maxed" data-remodal-id="modalshare" data-remodal-options="hashTracking: false">

  <div class="remodal-header">
    <div class="remodal-title">اشتراک‌گذاری</div>
    <button data-remodal-action="close" class="remodal-close"></button>
  </div>
    <span class="text-share_modal">با استفاده از روش‌های زیر می‌توانید این صفحه را با دوستان خود به اشتراک بگذارید. </span>

    <div class="c-flex align-items-center border-top border-bottom py-3">

              <div class="socials_btns btn-primary copy-url-btn" data-copy="<?php echo get_the_permalink();?>">کپی لینک</div>
              <ul class="align-items-center">
                <li class="telegram_socal"><a target="_blank" href="https://telegram.me/share/url?url=<?php the_permalink();?>" class="d-inline-flex"><i class="ri-telegram-fill"></i>تلگرام</a></li>
                <li class="whatsapp_socal"><a target="_blank" href="https://api.whatsapp.com/send/?phone&text=<?php the_permalink();?>" class="d-inline-flex"><i class="ri-whatsapp-fill"></i>واتساپ</a></li>
                <li class="facebook_socal"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?m2w&s=100&p[url]=<?php the_permalink();?>" class="d-inline-flex"><i class="ri-facebook-circle-fill"></i>فیسبوک</a></li>
                <li class="twitter_socal"><a target="_blank" href="https://twitter.com/intent/tweet?url=<?php the_permalink();?>" class="d-inline-flex"><i class="ri-twitter-fill"></i>تویتر</a></li>
              </ul>



    </div>

</div>



<!--  نمودار تغییراتت  -->
<div class="remodal view_product remodal-lg remodal-maxed" data-remodal-id="modalchartprice" data-remodal-options="hashTracking: false">

  <div class="remodal-header">
    <div class="remodal-title">
     نمودار قیمت
     <span><?php the_title();?></span>
    </div>
    <button data-remodal-action="close" class="remodal-close"></button>
  </div>

   <div id="productchartprice">
     <img class="price_chart_ajax_loader" src="<?php echo get_template_directory_uri().'/assets/img/ajax-loader.gif'; ?>">
   </div>

</div>




<!-- start of quick-view-modal -->
<div class="remodal send_modal remodal-md" data-remodal-id="send_modal" data-remodal-options="hashTracking: false">

  <div class="remodal-header">
    <span class="title-feed">جزئیات ارسال</span>
     <button data-remodal-action="close" class="remodal-close"></button>
  </div>



    <div class="modal-content">
       <span class="title_send"><?php echo $send_title;?></span>
       <p><?php echo $text_send;?></p>
    </div>
  </div>

<?php if ( empty(mobile_cheker()) && empty(tablet_cheker()) ) :?>
<!-- مدال گالری تصاویر محصول  -->
<div class="imgs-desctop">
<figure class="woocommerce-product-gallery__wrapper prk_woocommerce-product-gallery__wrapper">
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
  get_template_part('inc/template/product-tooltips');

?>
</figure>


<ul class="main_gallery_product">
<?php if( $attachment_ids ){
  $counter = 0;
    $image_link = wp_get_attachment_url( $post_thumbnail_id );

    if ($vidoe_aparats || $vidoe_upload) {
    echo '<li data-remodal-target="modalvidoe" class="show_modal_gallery vidoe" data-src="'.$image_link.'" >'.wp_get_attachment_image( $post_thumbnail_id, 'thumbnail' ).'</li>';
    }
    foreach($attachment_ids as $attachment_id){

      $image_link = wp_get_attachment_url( $attachment_id );
      $counter++;

      echo '<li count="'.$counter.'"  data-fancybox="gallery" data-src="'.$image_link.'" >'.wp_get_attachment_image( $attachment_id, 'thumbnail').'</li>';
       if ( $counter == 4) {
        $image_link = wp_get_attachment_url( $post_thumbnail_id );
        echo '<li  data-fancybox="gallery"   class="show_modal_gallery" data-src="'.$image_link.'" >'.wp_get_attachment_image( $post_thumbnail_id, 'thumbnail').'</li>';

        }

    }
}
?>
</ul>

</div>

<?php endif;?>

<?php if ( mobile_cheker() || tablet_cheker() ) : ?>

<div class="imgs-mobile <?php if( $attachment_ids){echo 'gallery_hav';}?>">
<div class="swiper-responsive-product-slider">
  <div class="swiper-wrapper">
  <?php
      if ( $product->get_image_id() ) {
        $image_link = wp_get_attachment_url( $post_thumbnail_id );
        echo '<div data-fancybox="gallery-mob" data-src="'.$image_link.'" class="swiper-slide prk_product_image">';
        echo '<div class="woocommerce-product-gallery__image">';
        echo get_the_post_thumbnail( $post , 'shop_single', array( 'id' => 'attachment-shop_single' ) );

        echo '</div>';
        echo '</div>';
      } else {
        echo '<div class="swiper-slide prk_product_image">';
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

</div>

<?php
  if ( mobile_cheker() || tablet_cheker() ) {

     get_template_part('inc/template/product-tooltips');

  }
?>
<?php endif;?>
<script>


jQuery(document).ready(function($){

  Fancybox.bind('[data-fancybox="gallery"]', {
    Toolbar: {
    display: [
      { id: "prev", position: "center" },
      { id: "counter", position: "center" },
      { id: "next", position: "center" },
      "zoom",
      "slideshow",
      "fullscreen",
      "thumbs",
      "close",
    ],
  },
  closeButton: "top",
  });

});


</script>


</div>