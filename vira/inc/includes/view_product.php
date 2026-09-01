<?php

/**
 *  product view modal
 *
 * @package      view modal product
 * @Author      Hosein Esmalian
 * @link        http://parskalas.ir
 */


add_action('wp_footer', function(){

?>
<!-- start of quick-view-modal -->
<div class="remodal view_product remodal-lg nohead" data-remodal-id="quick-view-modal" data-remodal-options="hashTracking: false">

  <div class="remodal-header">
      <button data-remodal-action="close" class="remodal-close"></button>
  </div>

  <div class="onliner_main_loading product_view">

   <?php echo prk_preloader();?>

  </div>

  <div class="remodal-content">

      <div class="product-detail-container">



      </div>

  </div>



</div>
<!-- end of quick-view-modal -->
<?php

});




add_action( 'wp_ajax_nopriv_get_quick_view', 'get_quick_view' );
add_action( 'wp_ajax_get_quick_view', 'get_quick_view' );

function get_quick_view() {


	?>

	<?php
			$args = array(
					'post_type'      => 'product',
          'p'  => $_POST['productId'],
		);

			$loop = new WP_Query( $args );

			while ( $loop->have_posts() ) : $loop->the_post();
            global $product;
            global $woocommerce;
            $currency = get_woocommerce_currency_symbol();
            $price = get_post_meta( get_the_ID(), '_regular_price', true);
            $sale = get_post_meta( get_the_ID(), '_sale_price', true);
						?>
               <div class="main_product_view">

                   <div class="gallery_tombnail_view">

                     <!-- start of product-gallery -->
                     <div class="product-gallery">
                         <div class="gallery-img-container">
                             <!-- Slider main container -->
                             <div class="swiper gallery-swiper-slider noselect">
                                 <!-- Additional required wrapper -->
                                 <div class="swiper-wrapper">

                                   <?php
                                       if ( $product->get_image_id() ) {
                                         $image_link = wp_get_attachment_url( $post_thumbnail_id );
                                         echo '<div class="swiper-slide"><div class="gallery-img">';

                                         echo get_the_post_thumbnail( $post , 'shop_single' );
                                         echo '</div></div>';
                                       } else {
                                         echo '<div class="swiper-slide"><div class="gallery-img">';

                                         echo sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );

                                         echo '</div></div>';

                                       }
                                     ?>
                                     <?php
                                         $attachment_ids = $product->get_gallery_image_ids();
                                         if ( $attachment_ids && has_post_thumbnail() ) {

                                           foreach ( $attachment_ids as $attachment_id ) {

                                             $image_link = wp_get_attachment_url( $attachment_id );
                                             echo '<div class="swiper-slide"><div class="gallery-img">';

                                             echo wp_get_attachment_image( $attachment_id, 'shop_single' );

                                             echo '</div></div>';

                                           }

                                         }

                                     ?>

                                 </div>

                                 <!-- If we need pagination -->
                                 <div class="swiper-pagination"></div>

                                 <!-- If we need navigation buttons -->
                                 <div class="swiper-button-prev view_nav"></div>
                                 <div class="swiper-button-next view_nav"></div>

                             </div>
                             <!-- Slider main container -->
                             <div class="swiper gallery-thumbs-swiper-slider noselect">
                                 <!-- Additional required wrapper -->
                                 <div class="swiper-wrapper">

                                     <!-- Slides -->
                                     <?php
                                         if ( $product->get_image_id() ) {
                                           $image_link = wp_get_attachment_url( $post_thumbnail_id );
                                           echo '<div class="swiper-slide"><div class="gallery-thumb">';

                                           echo get_the_post_thumbnail( $post , 'shop_single' );
                                           echo '</div></div>';

                                         } else {
                                           echo '<div class="swiper-slide"><div class="gallery-thumb">';

                                           echo sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );

                                           echo '</div></div>';

                                         }
                                       ?>
                                       <?php
                                           $attachment_ids = $product->get_gallery_image_ids();
                                           if ( $attachment_ids && has_post_thumbnail() ) {

                                             foreach ( $attachment_ids as $attachment_id ) {

                                               $image_link = wp_get_attachment_url( $attachment_id );
                                               echo '<div class="swiper-slide"><div class="gallery-thumb">';

                                               echo wp_get_attachment_image( $attachment_id, 'shop_single' );

                                               echo '</div></div>';

                                             }

                                           }

                                       ?>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <!-- end of product-gallery -->
                     <script>
                         jQuery(function ($) {
                           if ($(".gallery-swiper-slider").length) {
                         const gallerySwiperSlider = new Swiper(".gallery-swiper-slider", {
                           centeredSlides: true,
                         });
                         const galleryThumbsSwiperSlider = new Swiper(
                           ".gallery-thumbs-swiper-slider",
                           {
                             slidesPerView: 4,
                             slideToClickedSlide: true,
                             centeredSlides: true,
                             spaceBetween: 15,
                             navigation: {
                               nextEl: ".swiper-button-next.view_nav",
                               prevEl: ".swiper-button-prev.view_nav",
                             },
                           }
                         );
                         gallerySwiperSlider.controller.control = galleryThumbsSwiperSlider;
                         galleryThumbsSwiperSlider.controller.control = gallerySwiperSlider;
                       }

                         });
                      </script>
                   </div>

                   <div class="content_product_view">

                     <div class="viwe_breadcrumb">

                       <?php
                         echo breadcrumb_product();
                       ?>

                     </div>

                     <div class="viwe_title_product">

                       <?php echo $product->get_name(); ?>
                     </div>

                     <div class="viwe_pro_name">

                    <?php echo product_pro_name(); ?>

                     </div>

                     <div class="viwe_count_recommended">

                      <?php echo count_recommended(); ?>

                     </div>

                     <div class="viwe_ratings_counters">

                      <?php echo ratings_counters(); ?>

                     </div>

                     <div class="viwe_product_sku">

                       <?php echo product_sku(); ?>

                     </div>
                     <div class="viwe_attributes">
                       <?php echo costom_attributes(); ?>
                     </div>

                     <div class="viewe_single_price">
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
                     </div>



                   </div>


               </div>
               <div class="remodal-footer">

                 <button type="button" name="button" class="close_modal_view" data-remodal-action="close" >بستن</button>
                 <a href="<?php echo get_permalink(); ?>" alt= "جزئیات بیشتر" title= "جزئیات بیشتر" target="_blank" class="go_link_view">دیدن محصول</a>

               </div>
						<?php
			endwhile;

			wp_reset_query();
	?>



	<?php


    wp_die();
}
