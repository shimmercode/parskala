<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.6.0
 */
global $product;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) :

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

<section class="right-product">

	<?php $heading = apply_filters( 'woocommerce_product_upsells_products_heading', __( 'You may also like&hellip;', 'woocommerce' ) );

	if ( $heading ) :?>

		<div class="head-product up_selles">

			<h3><span class="titles-pro"><?php echo esc_html( $heading ); ?></span></h3>
			<span class="line-pro"></span>

		</div>

	<?php endif; ?>

	<div class="<?php echo $class_section;?>" settings-slider='<?php echo $json_settings; ?>'>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $upsells as $upsell ) : ?>

				<?php $post_object = get_post( $upsell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );?>

					<article class="item-pro">
							<a href="<?php the_permalink();?>">

								<?php echo pr_img(); ?>
								<div class="shadow-product h-[0px] w-[180px] duration-500 group-hover:mt-[28px] group-hover:h-[20px] group-hover:rotate-1"></div>

								<div class="index-title-pro">
									 <h2><?php echo wp_trim_words(get_the_title(),12,'...') ;?></h2>
								</div>

								<!--price-->
							 <div class="index-prices-pro">

								 <div class="price_onsale_ar">

											<?php

												echo $upsell->get_price_html();



											?>

								 </div>
							 </div>




								</a>
					</article>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

</section>

<?php
endif;

wp_reset_postdata();
