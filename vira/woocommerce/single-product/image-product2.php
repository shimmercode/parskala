<?php

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
// تنظیمات سفارشی محصول
$meta_opt = $vidoe_aparats = $vidoe_upload = "";
$meta_opt = get_post_meta( get_the_ID(), 'prk_product_options', true );

if(isset($meta_opt) && !empty($meta_opt)){
  if ( isset( $meta_opt['vidoe_upload']['url'] ) )		$vidoe_upload   	    = $meta_opt['vidoe_upload']['url'];
  if ( isset( $meta_opt['vidoe_aparats'] ) )		      $vidoe_aparats   	    = $meta_opt['vidoe_aparats'];
}

// تنظیمات کلی قالب
$product_share = prk_option('single_product_share');
$themeـstyle = prk_option('theme-style');

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

 ?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?> " data-columns="<?php echo esc_attr( $columns );?>">

  <?php if ($onsales_round == 'yes' ):?>

   <div class="head-pros">
   <span class="onsale prs"><?php _e('special offer !' , 'vira');?></span>
   <?php if($date):?>
   		<p id="sales_timer_display" class="timer-pros"></p>
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
      <?php endif;?>
  	</div>

  <?php else:?>

    <div class="head-pros">
      <span class="onsale prs"><?php _e('فروش ویژه !' , 'vira');?></span>
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

get_template_part('inc/template/product-tooltips');

 ?>

  <!--مدال اشتراک گذاری-->


  <div id="modalshare" class="remodal remodal-xs remodal-lg modalshare" data-remodal-id="modalshare" data-remodal-options="hashTracking: false">

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

 <?php if ( empty(mobile_cheker()) && empty(tablet_cheker()) ) :?>
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

        if ($vidoe_aparats || $vidoe_upload) {
        echo '<li data-remodal-target="modalvidoe" class="show_modal_gallery vidoe" data-src="'.$image_link.'" >'.wp_get_attachment_image( $post_thumbnail_id, 'shop_thumbnail', false, array() ).'</li>';
        }
        foreach($attachment_ids as $attachment_id){

          $image_link = wp_get_attachment_url( $attachment_id );
          $counter++;

          echo '<li count="'.$counter.'"  data-fancybox="gallery" data-src="'.$image_link.'" >'.wp_get_attachment_image( $attachment_id, 'shop_thumbnail', false, array() ).'</li>';
           if ( $counter == 3) {
            $image_link = wp_get_attachment_url( $post_thumbnail_id );
            echo '<li  data-fancybox="gallery"   class="show_modal_gallery" data-src="'.$image_link.'" >'.wp_get_attachment_image( $post_thumbnail_id, 'shop_thumbnail', false, array() ).'</li>';

            }

        }
    }
    ?>
    </ul>

  </div>
  <?php endif; ?>




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

              echo '</div></div>';
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
  <?php endif; ?>

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



  <script>

    jQuery(document).ready(function($){

      Fancybox.bind('[data-fancybox="gallery-mob"]',{
      Toolbar: true,
      closeButton: "top",
      });
      Fancybox.bind('[data-fancybox="gallery"]', {
      Toolbar: true,
      closeButton: "top",
      });

      var swiper = new Swiper('.swiper-responsive-product-slider', {
      slidesPerView: 1,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },

      });

      jQuery(".single-pro .thwvsf-checkbox").on('click', function (e) {
        e.preventDefault();
        swiper.slideTo(0);
      })


    });

  </script>

</div>
