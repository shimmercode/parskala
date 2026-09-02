<?php

// modern header

$checker = new mob_cheker;
if ($checker->isMobile()) {
  $device = 'mobile';
}else {
  $device = 'desctop';
}

global $current_user;
$callـpage = '';
 wp_get_current_user();
$user = wp_get_current_user();
$woo_active = class_exists( 'WooCommerce' );
$supportsـtrue = prk_option('supports_true');
$theme_style = prk_option( 'theme-style' );
$call_page = prk_option('call_page');
$callـtrue = prk_option('call_true');
$call_icon = prk_option('call_icon');
$size_h1 = prk_option('size_h1');
$header_search_true = prk_option('header_search_true');
$get_location = prk_option('prk_filter_location');
$header_search_bg_color = prk_option('header_search_bg_color');
$header_search_text_color = prk_option('header_search_text_color');
$account_url = get_permalink( get_option('woocommerce_myaccount_page_id') );
$header_account_type = prk_option('header_account_type');
$header_sticky_menu = prk_option('header_sticky_menu');
$header_account = prk_option('header_account');
$header_minicart = prk_option('header_minicart');
$header_minicart_type = prk_option('header_minicart_type');
$headers_minicart_icon = prk_option('headers_minicart_icon');
$header_icon_usersـbefore = prk_option('header_icon_users_before');
$header_icon_users_after = prk_option('header_icon_users_after');

$header_account_text_before_login = prk_option('header_account_text_before_login') ? prk_option('header_account_text_before_login') : __('login/register','parskala');

$prk_modern_mobile = prk_option('prk_modern_mobile');
$fixed_header = prk_option('modern_mobile_fixed_header');
$prk_topbar_true = prk_option('prk_topbar_true');
$prk_topbar_stikey = prk_option('prk_topbar_stikey');
$gust_top_desctop = prk_option('gust_top_desctop');

if ($fixed_header && ! $prk_topbar_true ) {
  $position_type = 'mobile-navigation-fixed';
}else {
  $position_type = '';
}

if ($get_location) {
  $location_class = 'have_location';
}else {
  $location_class = "";
}
if (prk_option('rgbaback_line_true')) {
  $line_true = ' line_true';
}else {
  $line_true = '';
}
  $aicon = $header_icon_usersـbefore;
  $cicon = $headers_minicart_icon;
  $aicon_after = $header_icon_users_after;

  if ( $theme_style == 'prk-plus' || $theme_style == 'prk-fashion' ) {
    $classes = 'prk-plus';
  }else {
    $classes = 'parskala';
  }


  if (is_user_logged_in()) {
    $classer = 'logined';
  }
  else{
    $classer = 'nologin';
  }

  if (prk_option('header_style_type') == 'style_2' ){
    $header_type = 'header_2';
  }else{
    $header_type = 'header_def';
  }


  if (gust_home_top()) {

   if ( $prk_topbar_true && $prk_topbar_stikey && is_front_page() ) {
     $sticky_classes = ' top_stikey ';
   }else {
     $sticky_classes = '';
   }
  }else {
   if ( $prk_topbar_true && $prk_topbar_stikey ) {
     $sticky_classes = ' top_stikey ';
   }else {
     $sticky_classes = '';
   }
  }

  // mobile header typer
  if ($prk_modern_mobile) {
    $header_style_type = ' modern';
  }else{
    $header_style_type = '';
  }

  $topbar_class = '';
  if ( prk_option('prk_topbar_true') ){
    $topbar_class = ' topbar_true';
  }

  if ( prk_option('header_icon_users_before') ){
    $class_bef_icon = '';
  }else{
    $class_bef_icon = 'pad10';
  }

 ?>

<?php
  if (prk_option('blacki_trure')){
    ?>
      <div id="blacki" class="blacki"></div>
    <?php
  }
?>

<?php if ( prk_option('header_style_type') == 'default' || prk_option('header_style_type') == 'style_2' || prk_option('header_style_type') == '' ){
?>


<header class="header <?php echo $device. ' '.$sticky_classes.''. $header_type.' '.$position_type.' '.$location_class; echo $line_true; echo $header_style_type; echo $topbar_class; ?>">

<?php if ( $prk_modern_mobile == 1 && mobile_cheker() || tablet_cheker() ): ?>

<?php get_template_part('/inc/template/header/mobile-header');?>

<?php else: ?>
  <div class="header-borner">
  <div  class="continer noselect_moblie">

    <div class="flexed">

      <div class="col-1">

        <!--icon-menu-->
        <div class="btn-menu1 toggle-navigation" id="icon-menu">
          <svg id="Layer" height="28" viewBox="0 0 24 24" width="28" xmlns="http://www.w3.org/2000/svg"><path id="menu-right-alt" d="m21 6.75h-13a.75.75 0 0 1 0-1.5h13a.75.75 0 0 1 0 1.5zm.75 5.25a.75.75 0 0 0 -.75-.75h-18a.75.75 0 0 0 0 1.5h18a.75.75 0 0 0 .75-.75zm0 6a.75.75 0 0 0 -.75-.75h-9a.75.75 0 0 0 0 1.5h9a.75.75 0 0 0 .75-.75z" fill="#5C677D"/></svg>
          <?php if ( prk_option('prk_text_icon_menu') ): ?>
            <span class="menu-text">منو</span>
           <?php endif; ?>
        </div>

        <!--logo-->
        <div class="logo">
          <a href="<?php bloginfo('url');?>">
          <?php
            if ( mobile_cheker() || tablet_cheker() ) {

              echo prk_logo_mobile();

            }else {
              echo prk_logo();
            }
         ?>
       </a>
        </div>

        <div class="call-page mobile">
          <a href="<?php echo $call_page;?>"><i class="<?php echo $call_icon;?>"></i></a>
        </div>

       </div>

    <div class="col-mobile">

    <?php if ($header_search_true || $get_location):?>

      <div class="col-2 row">

        <?php

          if ($header_search_true){

            echo '<div class="search-box">';

               $placeholder =  __('جستجو در محصولات ....', 'parskala' );
            	 echo do_shortcode('[prk_search placeholder="'.$placeholder.'" ]');

            echo '</div>';

          }

          if ($get_location) {
            echo do_shortcode('[select_location]');
          }

        ?>

      </div>

    <?php endif;?>

    <div class="col-3 row">
      
      <?php
        if ( prk_option('call_true') ){
          ?>
            <div class="call-page">
              <a href="<?php echo $call_page;?>"><i class="<?php echo $call_icon;?>"></i></a>
            </div>
            
            <i class="line-account"></i>
          <?php
        }
      ?>



    <?php if ($woo_active):?>

    <?php if ($header_account):?>

    <div class="<?php echo $classes;?> prk-account <?= $class_bef_icon ?> noselect <?php echo $classer;?>" <?php if ( ! is_user_logged_in() && empty(prk_option('header_account_type') == 'link') ){echo 'data-custom-open="loginmodal"';}?>>

     <?php  if ( ! is_user_logged_in() ):?>

        <?php if ( prk_option('header_account_type') == 'link' ): ?>

         <!--account-->
         <div class="account_mobile">

           <a href="<?= $account_url; ?>">
           <span class="account-icon"><i class="prk-user"></i></span>
           </a>

         </div>

         <?php else: ?>

           <div class="account_mobile">
             <span data-custom-open="loginmodal" class="account-icon"><i class="prk-user"></i></span>
           </div>

        <?php endif; ?>

         <?php if ('dropdown' == $header_account_type):?>

          <div class="account noselect <?= $class_bef_icon ?>">
            <div class="flexed">
              <span class="account-icon"><i class="<?php echo $aicon;?>"></i></span>
              <span class="account-text"><?php echo $header_account_text_before_login;?></span>
              <i class="prk-arrow-down-1 arrow_icon"></i>
            </div>
          </div>

      <?php elseif ('link' == $header_account_type):?>

        <div class="account noselect <?= $class_bef_icon ?>">
          <a href="<?php echo $account_url;?>">
            <span class="account-icon"><i class="<?php echo $aicon;?>"></i></span>
            <span class="account-text"><?php echo $header_account_text_before_login;?></span>
          </a>
        </div>

      <?php endif;?>

       <?php else: ?>

         <div class="account_mobile">
            <a href="<?php echo $account_url;?>">
             <span class="account-icon"><i class="prk-user"></i></span>
           </a>
           <span class="loged"></span>
         </div>

         <div class="account">

         <div class="flexed">
            <span class="account-icon"><i class="<?php echo $aicon_after;?>"></i></span>
            <span  class="account-text"><?php echo $current_user->display_name;?></span>
            <i class="prk-arrow-down-1"></i>
         </div>


         </div>

      <?php endif;?>

      <div id="prk-dashboard" class="prk-dashboard">

        <ul>

          <?php if(! is_user_logged_in()):?>
            <span>
             <a data-custom-open="loginmodal">وارد شوید</a>
            </span>
            <span>
              کاربر جدید هستید؟
             <a href="<?php echo $account_url;?>">ثبت نام</a>
            </span>

          <?php endif;?>

          <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>

            <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
              <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
            </li>

          <?php endforeach; ?>


        </ul>

      </div>

    </div>

    <!--dashboard-->
    <?php endif;?>

    

    <?php if ($header_minicart):?>

      <i class="line-account"></i>
      


        <?php if ( mobile_cheker() || tablet_cheker() ): ?>
          <a  class="cart-modal_mob" href="<?php echo wc_get_cart_url(); ?>">
            <span class="cart-btn">
              <i class="<?php echo $cicon;?>"></i>
              <em class="mini_cart_counter"><?php echo $count_cart = WC()->cart->cart_contents_count; ?></em>
            </span>
          </a>
       <?php else: ?>
        <?= elessi_mini_cart() ?>
       <?php endif; ?>


    <?php endif;?>

    <?php endif;?>

    </div>

  </div>

 </div>

 <?php

 if ($get_location) {
   echo do_shortcode('[mob_select_location]');
 }

 ?>

  </div>

 </div>
 
    <?php endif; ?>

   <?php get_template_part('/inc/template/header/prk-menu');?>

</header>

<?php if (prk_option('rgbaback_line_true') && !mobile_cheker() && !tablet_cheker()): ?>


  <div class="site-header__rgb-color"></div>

<?php endif; ?>


<?php

}elseif( prk_option('header_style_type') == 'mobit' ){

  if ( $prk_modern_mobile == 1 && mobile_cheker() || tablet_cheker() ){
    echo '<header class="header '. $device. ' '.$sticky_classes.''. $header_type.' '.$position_type.' '.$location_class. ' '.$line_true. ' '.$header_style_type. ' '.$topbar_class.' ">';
     echo get_template_part('/inc/template/header/mobile-header');
     echo get_template_part('/inc/template/header/prk-menu');
    echo '</header>';

  }else{
     echo get_template_part('/inc/template/header/mobit-header');
  }
  

}
?>