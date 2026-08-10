<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $post;
$count = $product->get_review_count();
if ( ! comments_open() ) {
	return;
}
$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

// تنظیمات صفحه محصول

$meta = get_post_meta( get_the_ID(), 'prk_product_options', true );
$option_ratings = "";
if(isset($meta) && !empty($meta)){
  if ( isset( $meta['options_ratings_review'] ) )   $option_ratings  = $meta['options_ratings_review'];
}
$global_option_ratings = prk_option( "global_options_ratings_review");
$display_advanced_review = prk_option( "display_advanced_review");

?>

<div class="reviw-tabs">

  <div class="panel-pad">

     <?php if (prk_option('sub_title_show_product') == '1' ): ?>
			 <div class="title-commenter">
 		    <h2><?php _e('Users score to:', 'parskala');?></h2>
 		    <div class="counter">

 			  	<span class="title-desctop"><?php echo get_the_title();?></span>

 			   	<span class="countes">(<?php echo $count;?><?php _e('person', 'parskala');?>)</span>
 				</div>
 		  </div>
     <?php endif; ?>


     <div class="continer-rating">
			 <?php if( !empty($global_option_ratings) && $display_advanced_review == 'on') {

				?>
			<div class="custom-option-ratings">
				<?php

				  if ($option_ratings){
						foreach( $option_ratings as $item ){
							$average = get_average_option_rating( $product->get_id()  , $item['slug'] );
							$percent = $average * 20;

							echo '<div class="detail-option-rating">';
								echo '<span class="title-option-ratings">'.$item['title'].'</span>';

								echo '<div class="progres-option-rating"><div  class="percent-option-rating"><strong style="width:'.$percent.'%"></strong></div><span>'.$average.'</span></div>';

							echo '</div>';
						}
					}elseif ($global_option_ratings)  {
						foreach( $global_option_ratings as $item ){
							$average = get_average_option_rating( $product->get_id()  , $item['slug'] );
							$percent = $average * 20;
							echo '<div class="detail-option-rating">';
								echo '<span class="title-option-ratings">'.$item['title'].'</span>';

								echo '<div class="progres-option-rating"><div  class="percent-option-rating"><strong style="width:'.$percent.'%"></strong></div><span>'.$average.'</span></div>';

							echo '</div>';
						}
					}

				?>
			</div>

      <?php } ?>
			<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
				<div class="go-insert-comment">
					<span class="title-insert"><?php _e('Express your opinion about this product', 'parskala');?></span>
					<span class="dec-insert">
						<?php _e('To post a comment, you must first log in to your account. If you have already bought this product from this store, your comment will be registered as the owner of the product.', 'parskala');?>
					</span>
					<a rel="nofollow" href="<?php echo add_query_arg( 'insert-comment', '', get_the_permalink() ); ?>"><?php _e('Add comment', 'parskala');?></a>
				</div>
			<?php else : ?>
				<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>
			<?php endif; ?>
		</div>

  </div>

	<span class="commnet-lister"><?php _e('User comments', 'parskala');?></span>
	<div id="comments">
		<?php if ( have_comments() ) : ?>

			<ol class="commentlist">
				<div class="coments-left">


				<?php
        $arg2 = array(
					'callback' => 'woocommerce_comments',
					'post_id' => $post->ID,
				 'orderby' => array('comment_date'),
				 'order' => 'DESC',
				);

				wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', $arg2  ));
        // wp_list_comments( $args );

				?>
                </div>
			</ol>

			<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => '&larr;',
							'next_text' => '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif;
			?>

			<?php if ( mobile_cheker() || tablet_cheker() ): ?>
		   	<span data-remodal-target="mob_tab_reviews" class="view_comment_mobiles">مشاهده همه <?php echo $count ;?> <?php _e('User comments', 'parskala');?></span>
      <?php endif; ?>

		<?php else : ?>
			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'woocommerce' ); ?></p>
		<?php endif; ?>
	</div>



	<div class="clear"></div>

</div>
