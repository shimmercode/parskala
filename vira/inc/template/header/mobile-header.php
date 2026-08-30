<?php
$call_page = prk_option('call_page');
$call_true = prk_option('call_true');
$call_icon = prk_option('call_icon');
$mobile_icon = prk_option('modern_mobile_icon');
$mobile_icon_text = prk_option('modern_mobile_icon_text');
$mobile_icon_url = prk_option('modern_mobile_left_icon_url');
$get_location = prk_option('prk_filter_location');
if (prk_option('like_icon')){
  $like_icon = prk_option('like_icon');
}else {
  $like_icon = 'ri-heart-3-fill';
}
?>


<?php if (class_exists( 'WooCommerce' ) && !is_product() ) :?>

  <div class="mobile-header">

    <div class="panel-handelr">
      <!--icon-menu-->
      <div class="btn-menu1 prk-toggle-navigation" id="icon-menu">
        <svg id="Layer" height="26" viewBox="0 0 24 24" width="26" xmlns="http://www.w3.org/2000/svg"><path id="menu-right-alt" d="m21 6.75h-13a.75.75 0 0 1 0-1.5h13a.75.75 0 0 1 0 1.5zm.75 5.25a.75.75 0 0 0 -.75-.75h-18a.75.75 0 0 0 0 1.5h18a.75.75 0 0 0 .75-.75zm0 6a.75.75 0 0 0 -.75-.75h-9a.75.75 0 0 0 0 1.5h9a.75.75 0 0 0 .75-.75z" fill="#5C677D"/></svg>

      </div>
    </div>

    <h1 class="mobile-img-logo">
      <a href="<?php bloginfo('url');?>" title="<?php bloginfo('name');?>" target="_self">
        <?php echo prk_logo_mobile();?>
      </a>
    </h1>

    <?php if ($mobile_icon && $mobile_icon_text): ?>
      <div class="call-page mobile">
        <a href="<?php echo $mobile_icon_url;?>"><i class="<?php echo $mobile_icon_text;?>"></i></a>
      </div>
    <?php endif; ?>

  </div>

<?php endif;?>

<?php if ( class_exists( 'WooCommerce' ) && is_product() ): ?>
  <div class="right-header-box">
    <a id="backer-button" class="backer-button" href="#">
      <i class="prk-arrow-right-3"></i>
    </a>
    <a id="backer-button" class="backer-button" href="<?php bloginfo('url');?>">
      <i class="prk-home"></i>
    </a>
  </div>




<div class="left-header-box">
  <ul class="product-tooltips">

    <li class="carter-mobiler">
        <a  href="<?= wc_get_cart_url()?>">
          <i class="prk-shopping-cart">
            <em class="mini_cart_counter"><?php PRK_cart_count(); ?></em>
          </i>
        </a>
    </li>

    <?php
      if (prk_option('single_product_whislist') == 1 ) {
          if (is_user_logged_in()){
          echo '<li><a  href="#">';
          echo sit_after_add_to_cart_btn();
          echo '</a></li>';
          }else{
            echo '<li data-custom-open="loginmodal"><a  href="#">';
            echo '<i class="'.$like_icon.' btns"></i>';

            echo '</a></li>';
          }
      }
      ?>
   <li class="more-tooltip">
     <a  href="#">
      <i class="prk-more"></i>
     </a>
   </li>



  </ul>
</div>

<?php endif; ?>

<?php

if ($get_location && !is_product() ) {
  echo '<div class="prk-mobile-location">';
  echo do_shortcode('[mob_select_location]');
  echo '</div>';
}

 ?>
