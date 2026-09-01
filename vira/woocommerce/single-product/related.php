
<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     10.3.0
 */

global $post;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) :
	$related_instock = false;
	foreach ( $related_products as $related_product ){
	$stock_status = $related_product->get_stock_status();

   if ( prk_option('out_stock_related_product') == '1' ) {
		if ( $stock_status == 'instock' ) {
			$related_instock = true;
			break;
		}
	   }elseif( prk_option('out_stock_related_product') == '0' || prk_option('out_stock_related_product') == '' ){
		$related_instock = true;
	  }
   }
   if( $related_instock){
?>

	<section class="right-product ">

		<?php $heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );
		if ( $heading ) :
		if ( 'prk-fashion' == theme_style() ) {
	    $margin = 30;
			$item = 4;
		}else {
	    $margin = 10;
			$item = 6;
		}
		$settings_slider =  array(
			'loop' => 'false',
			'nav' => 'true',
			'autoplay' => 'false',
			'delay' => 3000,
			'item' => $item,
			'margins' => $margin,

		);

		if ( mobile_cheker() || tablet_cheker() ) {
 		 $class_dev = 'verticaler';
 		 $class_section = 'carousel_lister';
 		 // $class_item = 'article-off';
      $json_settings = '';
    }else {
 		 $class_dev = '';
      $class_section = 'article-off';
 		 // $class_item = 'article-off';
 		 $json_settings = json_encode($settings_slider);

    }

		?>

		<div class="head-product">
			<h3><span class="titles-pro"><?php echo esc_html( $heading ); ?></span></h3>
			<span class="line-pro"></span>
		</div>

		<?php endif; ?>

		<div class="<?php echo $class_section;?>" settings-slider='<?php echo $json_settings; ?>'>

			<?php woocommerce_product_loop_start(); ?>

				<?php foreach ( $related_products as $related_product ) :

				$stock_status = $related_product->get_stock_status();

				if ( prk_option('out_stock_related_product') ) {

				if ( $stock_status == 'instock' ) {


				 $post_object = get_post( $related_product->get_id() );



					setup_postdata( $GLOBALS['post'] =& $post_object );

					  ?>
						<article class="item-pro">
								<a href="<?php the_permalink();?>">

						   		<?php echo pr_img(); ?>
								   <div class="shadow-product h-[0px] w-[180px] duration-500 group-hover:mt-[28px] group-hover:h-[20px] group-hover:rotate-1"></div>

									<div class="index-title-pro">
										 <h2><?php echo wp_trim_words(get_the_title(),12,'...') ;?></h2>
									</div>

									<!--price-->
								<?php
									// --- Price block (three-state) for $related_product ---
									$call_text = prk_option('single_product_text_price');
									if ($call_text === '' || $call_text === null) {
										$call_text = 'تماس بگیرید';
									}
									$has_price = $related_product instanceof WC_Product && $related_product->get_price() !== '' && $related_product->get_price() !== null;
									?>
									<div class="index-prices-pro border-dashed-gradient">
										<div class="price_onsale_ar">
											<?php
											if ( $related_product->is_in_stock() && ( $has_price || $related_product->is_type('variable') ) ) {
												echo $related_product->get_price_html();
											} elseif ( $related_product->is_in_stock() ) {
												echo '<p class="call_pro">' . esc_html($call_text) . '</p>';
											} else {
												echo '<p class="call_pro">' . esc_html__('ناموجود', 'vira') . '</p>';
											}
											?>
										</div>



									</a>
						</article>

				<?php
			}
		}else {
			$post_object = get_post( $related_product->get_id() );



			 setup_postdata( $GLOBALS['post'] =& $post_object );

				 ?>
				 <article class="item-pro">
						 <a href="<?php the_permalink();?>">

							 <div class="thumb-pro">
								 <?php echo get_the_post_thumbnail(get_the_ID(), 'woocommerce_thumbnail', array( 'class' => 'center' ) ); ?>
							 </div>

							 <div class="index-title-pro">
									<h2><?php echo wp_trim_words(get_the_title(),12,'...') ;?></h2>
							 </div>

							 <!--price-->
							<div class="index-prices-pro border-dashed-gradient">

								<div class="price_onsale_ar">

										 <?php

											 echo $related_product->get_price_html();



										 ?>

								</div>
							</div>




							 </a>
				 </article>

		 <?php
		}
			 endforeach; ?>

			<?php woocommerce_product_loop_end(); ?>

		</div>

	</section>

<?php
}
endif;
wp_reset_postdata();
