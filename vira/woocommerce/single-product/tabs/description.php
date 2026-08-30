<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post;
global $product;
$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

// تنظیمات صفحه محصول
$meta = get_post_meta( get_the_ID(), 'prk_product_options', true );
$list_ac = $list_adv = $list_Weak = $ratig = "";
if(isset($meta) && !empty($meta)){
   if ( isset( $meta['list_ac'] ) )	  	$list_ac          = $meta['list_ac'];
   if ( isset( $meta['list_adv'] ) )		$list_adv   	    = $meta['list_adv'];
   if ( isset( $meta['list_Weak'] ) )		$list_Weak   	    = $meta['list_Weak'];
   if ( isset( $meta['ratig'] ) )		$ratig   	    = $meta['ratig'];
}


$single_product_bio = prk_option('single_product_bio');
$product_bio_img   = prk_option('single_product_bio_img');

$bio_img = ''; // مقدار پیش‌فرض (خالی) برای جلوگیری از Undefined variable

if ( isset($product_bio_img['url']) && $product_bio_img['url'] != '' ) {
    $bio_img = $product_bio_img['url'];
}

defined( 'ABSPATH' ) || exit;
$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) );

?>

<?php if ( $heading ) : ?>
  <?php if (prk_option('small_title_show_product')): ?>
   	<h2 class="title-des-pro"><?php echo esc_html( 'نقد و بررسی' ); ?></h2>
  <?php endif; ?>

  <?php if ( prk_option('sub_title_show_product') == '1' ): ?>
    <span class="title-desctop"> <?php echo get_the_title();?></span>
  <?php endif; ?>


<?php endif; ?>



<?php if ($single_product_bio && !empty($short_description)):?>
    <div  class="subtitle">

      <div id="show-export" class="show-export content-product single <?php if (!$bio_img){echo 'fullw';} ?>">

        <div class="show-export-contents flexed">

          <span class="right-des-pro"><?php  echo $short_description; ?></span>
          <?php if ($bio_img): ?>
           	<span class="left-des-pro"><img src="<?php echo esc_url($bio_img); ?>"></span>
          <?php endif; ?>

        </div>

        <a href="#" class="mask-handler">
          <span class="show-more">نمایش بیشتر</span>
          <span class="show-less">- بستن</span>
        </a>


      </div>


    </div>

<?php endif;?>

<div class="about_rating_product">

<div class="single_product_accordion">
  <?php if ($list_ac):?>
    <?php foreach (  $list_ac as $item ):?>

 <button class="accordion"><?php echo $item['title_ac'];?></button>
 <div class="accordion_panel">

   <p class="content-accordion"><?php echo $item['content_ac'];?></p>
 </div>
<?php endforeach;?>
<?php endif;?>
</div>

<?php if ($list_adv):?>
<div class="product-points product-positive-points">
<?php foreach (  $list_adv as $item ):?>
  <ul><li><i class="far fa-plus"></i><?php echo $item['title_adv'];?></li></ul>
<?php endforeach;?>
</div>
<?php endif;?>

<?php if ($list_Weak):?>
<div class="product-points product-negative-points">
<?php foreach (  $list_Weak as $item ):?>
  <ul><li><i class="far fa-plus"></i><?php echo $item['title_Weak'];?></li></ul>
<?php endforeach;?>
</div>
<?php endif;?>

<?php if ($ratig):?>
<div class="product-points ratig">
  <?php foreach (  $ratig as $item ):?>
   <ul>
   <div class="c-content-expert__rating-title"><?php echo $item['title_rate'];?></div>
     <div class="c-content-expert__rating-value">
       <div class="c-rating c-rating--general js-rating">
       <div class="c-rating__rate js-rating-value"  style="width: <?php echo $item['slider_rate'];?>0%;"></div>
       </div>
     <span class="c-rating__overall-word"><?php echo $item['slider_rate'];?></span>
     </div>
      </ul>
      <?php endforeach;?>
</div>
<?php endif;?>
</div>
<div class="content-product single">
<?php the_content(); ?>
</div>
