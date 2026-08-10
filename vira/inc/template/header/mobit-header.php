<?php


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
$header_account_text_before_login = prk_option('header_account_text_before_login');
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

  $checker = new mob_cheker;
  if ($checker->isMobile() || $checker->isTablet() ) {
    $device = 'mobile';
  }else {
    $device = 'desctop';
  }
  
?>

<div class="header-mobiter<?= prk_option('fixed_header_mobit') == '1'  ? ' fixed_header' : '' ?>">

<header class="main-header <?= $device ?>">

  <div class="logo-sec">

        <!--logo-->
        <div class="logo <?= prk_option('logo_animated') ? 'animated' : '' ?>">
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
        
        <!--menu-->
        <div class="menu-mobiter">
          <?php get_template_part('/inc/template/header/mobit-menu');?>
        </div>

  </div>

  <div class="search-sec">

  <?php

      if ($header_search_true){

        echo '<div class="search-box">';

          $placeholder =  __('جستجو در محصولات ....', 'parskala' );
          echo do_shortcode('[prk_search placeholder="'.$placeholder.'" ]');

        echo '</div>';

      }

   ?>

   <div class="flexed">

   <div class="login-btns">

    <?php
    if ( prk_option('call_true') ){
      ?>
        <div class="call-page">
          <a href="<?php echo $call_page;?>"><i class="<?php echo $call_icon;?>"></i></a>
        </div>
        
      <?php
    }
   ?>

   <?php if ($woo_active):?>

      <?php if ($header_account):?>

      <div class="<?php echo $classes;?> prk-account noselect <?php echo $classer;?>" <?php if ( ! is_user_logged_in() && empty(prk_option('header_account_type') == 'link') ){echo 'data-custom-open="loginmodal"';}?>>

      <?php  if ( ! is_user_logged_in() ):?>

          <?php if ( prk_option('header_account_type') == 'link' ): ?>

          <!--account-->
          <div class="account_mobile">

            <a href="<?= $account_url; ?>">
            <span class="account-icon"><i class="">

            <svg
                version="1.1"
                width="259.20001pt"
                height="259.20001pt"
                id="svg4"
                viewBox="0 0 259.20001 259.20001"
                sodipodi:docname="icon 5.cdr"
                xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:svg="http://www.w3.org/2000/svg">
                <defs
                  id="defs8" />
                <sodipodi:namedview
                  id="namedview6"
                  pagecolor="#ffffff"
                  bordercolor="#000000"
                  borderopacity="0.25"
                  inkscape:showpageshadow="2"
                  inkscape:pageopacity="0.0"
                  inkscape:pagecheckerboard="0"
                  inkscape:deskcolor="#d1d1d1"
                  inkscape:document-units="pt" />
                <path
                  d="m 128.9999,1.9199 c 26.3646,0 47.7374,21.3728 47.7374,47.7374 0,26.3646 -21.3728,47.7374 -47.7374,47.7374 -26.3646,0 -47.7374,-21.3728 -47.7374,-47.7374 0,-26.3646 21.3728,-47.7374 47.7374,-47.7374 z M 86.813,130.1451 h 87.7044 c 29.0035,0 52.7332,23.7297 52.7332,52.7332 v 22.2041 c 0,29.0034 -23.7297,52.7332 -52.7332,52.7332 H 86.813 c -29.0035,0 -52.7333,-23.7298 -52.7333,-52.7332 v -22.2041 c 0,-29.0035 23.7298,-52.7332 52.7333,-52.7332 z"
                  style="fill:#fff;fill-rule:evenodd"
                  id="path2" />
              </svg>


            </i></span>
            </a>

          </div>

          <?php else: ?>

            <div class="account_mobile">
              <span data-custom-open="loginmodal" class="account-icon"><i class="">

                
              <svg
                version="1.1"
                width="259.20001pt"
                height="259.20001pt"
                id="svg4"
                viewBox="0 0 259.20001 259.20001"
                sodipodi:docname="icon 5.cdr"
                xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:svg="http://www.w3.org/2000/svg">
                <defs
                  id="defs8" />
                <sodipodi:namedview
                  id="namedview6"
                  pagecolor="#ffffff"
                  bordercolor="#000000"
                  borderopacity="0.25"
                  inkscape:showpageshadow="2"
                  inkscape:pageopacity="0.0"
                  inkscape:pagecheckerboard="0"
                  inkscape:deskcolor="#d1d1d1"
                  inkscape:document-units="pt" />
                <path
                  d="m 128.9999,1.9199 c 26.3646,0 47.7374,21.3728 47.7374,47.7374 0,26.3646 -21.3728,47.7374 -47.7374,47.7374 -26.3646,0 -47.7374,-21.3728 -47.7374,-47.7374 0,-26.3646 21.3728,-47.7374 47.7374,-47.7374 z M 86.813,130.1451 h 87.7044 c 29.0035,0 52.7332,23.7297 52.7332,52.7332 v 22.2041 c 0,29.0034 -23.7297,52.7332 -52.7332,52.7332 H 86.813 c -29.0035,0 -52.7333,-23.7298 -52.7333,-52.7332 v -22.2041 c 0,-29.0035 23.7298,-52.7332 52.7333,-52.7332 z"
                  style="fill:#fff;fill-rule:evenodd"
                  id="path2" />
              </svg>


              </i></span>
            </div>

          <?php endif; ?>

          <?php if ('dropdown' == $header_account_type):?>

            <div class="account noselect">
              <div class="flexed">
                <span class="account-icon"><i class="">

                <svg
                version="1.1"
                width="259.20001pt"
                height="259.20001pt"
                id="svg4"
                viewBox="0 0 259.20001 259.20001"
                sodipodi:docname="icon 5.cdr"
                xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:svg="http://www.w3.org/2000/svg">
                <defs
                  id="defs8" />
                <sodipodi:namedview
                  id="namedview6"
                  pagecolor="#ffffff"
                  bordercolor="#000000"
                  borderopacity="0.25"
                  inkscape:showpageshadow="2"
                  inkscape:pageopacity="0.0"
                  inkscape:pagecheckerboard="0"
                  inkscape:deskcolor="#d1d1d1"
                  inkscape:document-units="pt" />
                <path
                  d="m 128.9999,1.9199 c 26.3646,0 47.7374,21.3728 47.7374,47.7374 0,26.3646 -21.3728,47.7374 -47.7374,47.7374 -26.3646,0 -47.7374,-21.3728 -47.7374,-47.7374 0,-26.3646 21.3728,-47.7374 47.7374,-47.7374 z M 86.813,130.1451 h 87.7044 c 29.0035,0 52.7332,23.7297 52.7332,52.7332 v 22.2041 c 0,29.0034 -23.7297,52.7332 -52.7332,52.7332 H 86.813 c -29.0035,0 -52.7333,-23.7298 -52.7333,-52.7332 v -22.2041 c 0,-29.0035 23.7298,-52.7332 52.7333,-52.7332 z"
                  style="fill:#fff;fill-rule:evenodd"
                  id="path2" />
              </svg>


                </i></span>
                <span class="account-text"><?php echo $header_account_text_before_login;?></span>
              </div>
            </div>

        <?php elseif ('link' == $header_account_type):?>

          <div class="account noselect">
            <a href="<?php echo $account_url;?>">
              <span class="account-icon"><i class="">

              <svg
                version="1.1"
                width="259.20001pt"
                height="259.20001pt"
                id="svg4"
                viewBox="0 0 259.20001 259.20001"
                sodipodi:docname="icon 5.cdr"
                xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:svg="http://www.w3.org/2000/svg">
                <defs
                  id="defs8" />
                <sodipodi:namedview
                  id="namedview6"
                  pagecolor="#ffffff"
                  bordercolor="#000000"
                  borderopacity="0.25"
                  inkscape:showpageshadow="2"
                  inkscape:pageopacity="0.0"
                  inkscape:pagecheckerboard="0"
                  inkscape:deskcolor="#d1d1d1"
                  inkscape:document-units="pt" />
                <path
                  d="m 128.9999,1.9199 c 26.3646,0 47.7374,21.3728 47.7374,47.7374 0,26.3646 -21.3728,47.7374 -47.7374,47.7374 -26.3646,0 -47.7374,-21.3728 -47.7374,-47.7374 0,-26.3646 21.3728,-47.7374 47.7374,-47.7374 z M 86.813,130.1451 h 87.7044 c 29.0035,0 52.7332,23.7297 52.7332,52.7332 v 22.2041 c 0,29.0034 -23.7297,52.7332 -52.7332,52.7332 H 86.813 c -29.0035,0 -52.7333,-23.7298 -52.7333,-52.7332 v -22.2041 c 0,-29.0035 23.7298,-52.7332 52.7333,-52.7332 z"
                  style="fill:#fff;fill-rule:evenodd"
                  id="path2" />
              </svg>


              </i></span>
              <span class="account-text"><?php echo $header_account_text_before_login;?></span>
            </a>
          </div>

        <?php endif;?>

        <?php else: ?>

          <div class="account_mobile">
              <a href="<?php echo $account_url;?>">
              <span class="account-icon"><i class="">
              <svg
                version="1.1"
                width="259.20001pt"
                height="259.20001pt"
                id="svg4"
                viewBox="0 0 259.20001 259.20001"
                sodipodi:docname="icon 5.cdr"
                xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:svg="http://www.w3.org/2000/svg">
                <defs
                  id="defs8" />
                <sodipodi:namedview
                  id="namedview6"
                  pagecolor="#ffffff"
                  bordercolor="#000000"
                  borderopacity="0.25"
                  inkscape:showpageshadow="2"
                  inkscape:pageopacity="0.0"
                  inkscape:pagecheckerboard="0"
                  inkscape:deskcolor="#d1d1d1"
                  inkscape:document-units="pt" />
                <path
                  d="m 128.9999,1.9199 c 26.3646,0 47.7374,21.3728 47.7374,47.7374 0,26.3646 -21.3728,47.7374 -47.7374,47.7374 -26.3646,0 -47.7374,-21.3728 -47.7374,-47.7374 0,-26.3646 21.3728,-47.7374 47.7374,-47.7374 z M 86.813,130.1451 h 87.7044 c 29.0035,0 52.7332,23.7297 52.7332,52.7332 v 22.2041 c 0,29.0034 -23.7297,52.7332 -52.7332,52.7332 H 86.813 c -29.0035,0 -52.7333,-23.7298 -52.7333,-52.7332 v -22.2041 c 0,-29.0035 23.7298,-52.7332 52.7333,-52.7332 z"
                  style="fill:#fff;fill-rule:evenodd"
                  id="path2" />
              </svg>


              </i></span>
            </a>
            <span class="loged"></span>
          </div>

          <div class="account">

          <div class="flexed">
              <span class="account-icon"><i class="">

              <svg
                version="1.1"
                width="259.20001pt"
                height="259.20001pt"
                id="svg4"
                viewBox="0 0 259.20001 259.20001"
                sodipodi:docname="icon 5.cdr"
                xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:svg="http://www.w3.org/2000/svg">
                <defs
                  id="defs8" />
                <sodipodi:namedview
                  id="namedview6"
                  pagecolor="#ffffff"
                  bordercolor="#000000"
                  borderopacity="0.25"
                  inkscape:showpageshadow="2"
                  inkscape:pageopacity="0.0"
                  inkscape:pagecheckerboard="0"
                  inkscape:deskcolor="#d1d1d1"
                  inkscape:document-units="pt" />
                <path
                  d="m 128.9999,1.9199 c 26.3646,0 47.7374,21.3728 47.7374,47.7374 0,26.3646 -21.3728,47.7374 -47.7374,47.7374 -26.3646,0 -47.7374,-21.3728 -47.7374,-47.7374 0,-26.3646 21.3728,-47.7374 47.7374,-47.7374 z M 86.813,130.1451 h 87.7044 c 29.0035,0 52.7332,23.7297 52.7332,52.7332 v 22.2041 c 0,29.0034 -23.7297,52.7332 -52.7332,52.7332 H 86.813 c -29.0035,0 -52.7333,-23.7298 -52.7333,-52.7332 v -22.2041 c 0,-29.0035 23.7298,-52.7332 52.7333,-52.7332 z"
                  style="fill:#fff;fill-rule:evenodd"
                  id="path2" />
              </svg>


              </i></span>
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
    <?php endif;?>

   </div>

   <div class="cart-btns">

    <?php if ($header_minicart):?>

        <?php if ( $header_minicart_type == 'link' ):?>

          <a class="cart-modal" href="<?php echo wc_get_cart_url(); ?>">

          <span class="cart-btn">

            <i class="">

<svg
   version="1.1"
   width="259.20001pt"
   height="259.20001pt"
   id="svg6"
   viewBox="0 0 259.20001 259.20001"
   sodipodi:docname="icon 02.cdr"
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
     d="m 102.4353,74.0177 c 16.6045,21.2409 51.027,16.2635 60.8749,-7.0489 4.1235,-9.7639 5.0978,-21.4963 19.1905,-19.1157 7.2887,1.2313 10.8958,8.5433 11.0449,18.5167 0.7733,51.7394 -91.4031,82.0205 -122.9451,17.2707 -2.8046,-5.9052 -4.8387,-14.5622 -4.7134,-22.074 0.3152,-18.9326 25.9886,-20.7045 28.1066,-8.7536 1.2683,7.154 2.5339,13.6471 8.4416,21.2048 z"
     style="fill:#ffffff;fill-rule:evenodd"
     id="path2" />
  <path
     d="m 36.7311,59.7502 c 5.6924,-11.0374 14.1325,-20.3546 24.3583,-26.9565 5.3417,-3.4485 11.1705,-6.156 17.35,-7.9807 5.9306,-1.7515 12.1839,-2.6899 18.6385,-2.6899 h 67.9241 c 1.9363,0 3.8546,0.0845 5.7516,0.2501 6.0354,0.5266 11.8538,1.8738 17.3503,3.9328 16.0207,6.0015 29.3053,18.0491 37.2449,33.4442 5.0979,9.8852 7.9923,21.1504 7.9923,33.0812 v 74.7065 c 0,38.8898 -30.7525,70.7084 -68.3391,70.7084 H 97.0779 c -37.5867,0 -68.3391,-31.8186 -68.3391,-70.7084 V 92.8314 c 0,-11.9308 2.8944,-23.196 7.9923,-33.0812 z M 188.1039,3.9922 C 182.6714,2.7921 177.0415,2.16 171.2761,2.16 H 170.7536 90.8037 C 86.6023,2.16 82.4729,2.4955 78.4394,3.1422 72.4159,4.1074 66.6062,5.7666 61.0894,8.0373 40.0709,16.6879 23.3071,34.2144 15.1817,56.0814 11.7326,65.3649 9.84,75.4303 9.84,85.9309 v 88.5076 c 0,46.0744 36.4336,83.7709 80.9637,83.7709 h 80.4724 c 44.5301,0 80.9637,-37.6965 80.9637,-83.7709 V 85.9309 c 0,-9.132 -1.4311,-17.935 -4.0731,-26.1807 C 239.205,31.7805 216.3135,10.2247 188.1039,3.9922 Z M 28.7388,92.8314 v 74.7065 c 0,38.8898 30.7524,70.7084 68.3391,70.7084 h 67.9241 c 37.5866,0 68.3391,-31.8186 68.3391,-70.7084 V 92.8314 c 0,-11.9308 -2.8944,-23.196 -7.9923,-33.0812 -7.9396,-15.3951 -21.2242,-27.4427 -37.2449,-33.4442 -5.4965,-2.059 -11.3149,-3.4062 -17.3503,-3.9328 -1.897,-0.1656 -3.8153,-0.2501 -5.7516,-0.2501 H 97.0779 c -6.4546,0 -12.7079,0.9384 -18.6385,2.6899 -6.1795,1.8247 -12.0083,4.5322 -17.35,7.9807 -10.2258,6.6019 -18.6659,15.9191 -24.3583,26.9565 -5.0979,9.8852 -7.9923,21.1504 -7.9923,33.0812 z m 102.301,49.118 c -34.9289,0 -63.5071,-28.5782 -63.5071,-63.5074 V 62.7712 h 17.3499 v 11.3545 c 0,25.3866 20.7705,46.1571 46.1572,46.1571 25.3863,0 46.1571,-20.7705 46.1571,-46.1571 V 62.7712 h 17.3503 V 78.442 c 0,34.9292 -28.5782,63.5074 -63.5074,63.5074 z M 67.5327,78.442 c 0,34.9292 28.5782,63.5074 63.5071,63.5074 34.9292,0 63.5074,-28.5782 63.5074,-63.5074 V 62.7712 h -17.3503 v 11.3545 c 0,25.3866 -20.7708,46.1571 -46.1571,46.1571 -25.3867,0 -46.1572,-20.7705 -46.1572,-46.1571 V 62.7712 H 67.5327 Z m 1.4186,6.5147 C 102.0796,152.963 198.8918,121.159 198.0796,66.8175 197.923,56.3425 194.1345,48.6628 186.4793,47.3695 171.6778,44.8692 170.6545,57.1916 166.3236,67.4466 155.9804,91.9314 119.8267,97.1591 102.3871,74.85 96.1823,66.9122 94.853,60.0926 93.521,52.5787 91.2964,40.0268 64.3319,41.8879 64.0008,61.7726 c -0.1316,7.8896 2.0049,16.982 4.9505,23.1841 z"
     style="fill:#fff;fill-rule:evenodd"
     id="path4" />
</svg>


            </i>
            <em class="mini_cart_counter"><?php PRK_cart_count(); ?></em>

          </span>

          </a>

        <?php else :?>

          <?php if ( mobile_cheker() || tablet_cheker() ): ?>
            <a class="cart-modal_mob" href="<?php echo wc_get_cart_url(); ?>">
              <span class="cart-btn">
                <i class="">

<svg
   version="1.1"
   width="259.20001pt"
   height="259.20001pt"
   id="svg6"
   viewBox="0 0 259.20001 259.20001"
   sodipodi:docname="icon 02.cdr"
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
     d="m 102.4353,74.0177 c 16.6045,21.2409 51.027,16.2635 60.8749,-7.0489 4.1235,-9.7639 5.0978,-21.4963 19.1905,-19.1157 7.2887,1.2313 10.8958,8.5433 11.0449,18.5167 0.7733,51.7394 -91.4031,82.0205 -122.9451,17.2707 -2.8046,-5.9052 -4.8387,-14.5622 -4.7134,-22.074 0.3152,-18.9326 25.9886,-20.7045 28.1066,-8.7536 1.2683,7.154 2.5339,13.6471 8.4416,21.2048 z"
     style="unset"
     id="path2" />
  <path
     d="m 36.7311,59.7502 c 5.6924,-11.0374 14.1325,-20.3546 24.3583,-26.9565 5.3417,-3.4485 11.1705,-6.156 17.35,-7.9807 5.9306,-1.7515 12.1839,-2.6899 18.6385,-2.6899 h 67.9241 c 1.9363,0 3.8546,0.0845 5.7516,0.2501 6.0354,0.5266 11.8538,1.8738 17.3503,3.9328 16.0207,6.0015 29.3053,18.0491 37.2449,33.4442 5.0979,9.8852 7.9923,21.1504 7.9923,33.0812 v 74.7065 c 0,38.8898 -30.7525,70.7084 -68.3391,70.7084 H 97.0779 c -37.5867,0 -68.3391,-31.8186 -68.3391,-70.7084 V 92.8314 c 0,-11.9308 2.8944,-23.196 7.9923,-33.0812 z M 188.1039,3.9922 C 182.6714,2.7921 177.0415,2.16 171.2761,2.16 H 170.7536 90.8037 C 86.6023,2.16 82.4729,2.4955 78.4394,3.1422 72.4159,4.1074 66.6062,5.7666 61.0894,8.0373 40.0709,16.6879 23.3071,34.2144 15.1817,56.0814 11.7326,65.3649 9.84,75.4303 9.84,85.9309 v 88.5076 c 0,46.0744 36.4336,83.7709 80.9637,83.7709 h 80.4724 c 44.5301,0 80.9637,-37.6965 80.9637,-83.7709 V 85.9309 c 0,-9.132 -1.4311,-17.935 -4.0731,-26.1807 C 239.205,31.7805 216.3135,10.2247 188.1039,3.9922 Z M 28.7388,92.8314 v 74.7065 c 0,38.8898 30.7524,70.7084 68.3391,70.7084 h 67.9241 c 37.5866,0 68.3391,-31.8186 68.3391,-70.7084 V 92.8314 c 0,-11.9308 -2.8944,-23.196 -7.9923,-33.0812 -7.9396,-15.3951 -21.2242,-27.4427 -37.2449,-33.4442 -5.4965,-2.059 -11.3149,-3.4062 -17.3503,-3.9328 -1.897,-0.1656 -3.8153,-0.2501 -5.7516,-0.2501 H 97.0779 c -6.4546,0 -12.7079,0.9384 -18.6385,2.6899 -6.1795,1.8247 -12.0083,4.5322 -17.35,7.9807 -10.2258,6.6019 -18.6659,15.9191 -24.3583,26.9565 -5.0979,9.8852 -7.9923,21.1504 -7.9923,33.0812 z m 102.301,49.118 c -34.9289,0 -63.5071,-28.5782 -63.5071,-63.5074 V 62.7712 h 17.3499 v 11.3545 c 0,25.3866 20.7705,46.1571 46.1572,46.1571 25.3863,0 46.1571,-20.7705 46.1571,-46.1571 V 62.7712 h 17.3503 V 78.442 c 0,34.9292 -28.5782,63.5074 -63.5074,63.5074 z M 67.5327,78.442 c 0,34.9292 28.5782,63.5074 63.5071,63.5074 34.9292,0 63.5074,-28.5782 63.5074,-63.5074 V 62.7712 h -17.3503 v 11.3545 c 0,25.3866 -20.7708,46.1571 -46.1571,46.1571 -25.3867,0 -46.1572,-20.7705 -46.1572,-46.1571 V 62.7712 H 67.5327 Z m 1.4186,6.5147 C 102.0796,152.963 198.8918,121.159 198.0796,66.8175 197.923,56.3425 194.1345,48.6628 186.4793,47.3695 171.6778,44.8692 170.6545,57.1916 166.3236,67.4466 155.9804,91.9314 119.8267,97.1591 102.3871,74.85 96.1823,66.9122 94.853,60.0926 93.521,52.5787 91.2964,40.0268 64.3319,41.8879 64.0008,61.7726 c -0.1316,7.8896 2.0049,16.982 4.9505,23.1841 z"
     style="fill:#fff;fill-rule:evenodd"
     id="path4" />
</svg>


                </i>
                <em class="mini_cart_counter"><?php echo $count_cart = WC()->cart->cart_contents_count; ?></em>
              </span>
            </a>
        <?php else: ?>
          <a class="cart-modal cart-link">
            <span class="cart-btn">
              <i class="">

<svg
   version="1.1"
   width="259.20001pt"
   height="259.20001pt"
   id="svg6"
   viewBox="0 0 259.20001 259.20001"
   sodipodi:docname="icon 02.cdr"
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
     d="m 102.4353,74.0177 c 16.6045,21.2409 51.027,16.2635 60.8749,-7.0489 4.1235,-9.7639 5.0978,-21.4963 19.1905,-19.1157 7.2887,1.2313 10.8958,8.5433 11.0449,18.5167 0.7733,51.7394 -91.4031,82.0205 -122.9451,17.2707 -2.8046,-5.9052 -4.8387,-14.5622 -4.7134,-22.074 0.3152,-18.9326 25.9886,-20.7045 28.1066,-8.7536 1.2683,7.154 2.5339,13.6471 8.4416,21.2048 z"
     style="unset"
     id="path2" />
  <path
     d="m 36.7311,59.7502 c 5.6924,-11.0374 14.1325,-20.3546 24.3583,-26.9565 5.3417,-3.4485 11.1705,-6.156 17.35,-7.9807 5.9306,-1.7515 12.1839,-2.6899 18.6385,-2.6899 h 67.9241 c 1.9363,0 3.8546,0.0845 5.7516,0.2501 6.0354,0.5266 11.8538,1.8738 17.3503,3.9328 16.0207,6.0015 29.3053,18.0491 37.2449,33.4442 5.0979,9.8852 7.9923,21.1504 7.9923,33.0812 v 74.7065 c 0,38.8898 -30.7525,70.7084 -68.3391,70.7084 H 97.0779 c -37.5867,0 -68.3391,-31.8186 -68.3391,-70.7084 V 92.8314 c 0,-11.9308 2.8944,-23.196 7.9923,-33.0812 z M 188.1039,3.9922 C 182.6714,2.7921 177.0415,2.16 171.2761,2.16 H 170.7536 90.8037 C 86.6023,2.16 82.4729,2.4955 78.4394,3.1422 72.4159,4.1074 66.6062,5.7666 61.0894,8.0373 40.0709,16.6879 23.3071,34.2144 15.1817,56.0814 11.7326,65.3649 9.84,75.4303 9.84,85.9309 v 88.5076 c 0,46.0744 36.4336,83.7709 80.9637,83.7709 h 80.4724 c 44.5301,0 80.9637,-37.6965 80.9637,-83.7709 V 85.9309 c 0,-9.132 -1.4311,-17.935 -4.0731,-26.1807 C 239.205,31.7805 216.3135,10.2247 188.1039,3.9922 Z M 28.7388,92.8314 v 74.7065 c 0,38.8898 30.7524,70.7084 68.3391,70.7084 h 67.9241 c 37.5866,0 68.3391,-31.8186 68.3391,-70.7084 V 92.8314 c 0,-11.9308 -2.8944,-23.196 -7.9923,-33.0812 -7.9396,-15.3951 -21.2242,-27.4427 -37.2449,-33.4442 -5.4965,-2.059 -11.3149,-3.4062 -17.3503,-3.9328 -1.897,-0.1656 -3.8153,-0.2501 -5.7516,-0.2501 H 97.0779 c -6.4546,0 -12.7079,0.9384 -18.6385,2.6899 -6.1795,1.8247 -12.0083,4.5322 -17.35,7.9807 -10.2258,6.6019 -18.6659,15.9191 -24.3583,26.9565 -5.0979,9.8852 -7.9923,21.1504 -7.9923,33.0812 z m 102.301,49.118 c -34.9289,0 -63.5071,-28.5782 -63.5071,-63.5074 V 62.7712 h 17.3499 v 11.3545 c 0,25.3866 20.7705,46.1571 46.1572,46.1571 25.3863,0 46.1571,-20.7705 46.1571,-46.1571 V 62.7712 h 17.3503 V 78.442 c 0,34.9292 -28.5782,63.5074 -63.5074,63.5074 z M 67.5327,78.442 c 0,34.9292 28.5782,63.5074 63.5071,63.5074 34.9292,0 63.5074,-28.5782 63.5074,-63.5074 V 62.7712 h -17.3503 v 11.3545 c 0,25.3866 -20.7708,46.1571 -46.1571,46.1571 -25.3867,0 -46.1572,-20.7705 -46.1572,-46.1571 V 62.7712 H 67.5327 Z m 1.4186,6.5147 C 102.0796,152.963 198.8918,121.159 198.0796,66.8175 197.923,56.3425 194.1345,48.6628 186.4793,47.3695 171.6778,44.8692 170.6545,57.1916 166.3236,67.4466 155.9804,91.9314 119.8267,97.1591 102.3871,74.85 96.1823,66.9122 94.853,60.0926 93.521,52.5787 91.2964,40.0268 64.3319,41.8879 64.0008,61.7726 c -0.1316,7.8896 2.0049,16.982 4.9505,23.1841 z"
     style="fill:#fff;fill-rule:evenodd"
     id="path4" />
</svg>


              </i>
              <em class="mini_cart_counter"><?php echo $count_cart = WC()->cart->cart_contents_count; ?></em>
            </span>
            <span class="cart-text">سبد خرید</span>

          </a>
        <?php endif; ?>

        <?php endif;?>

      <?php endif;?>
   </div>
   </div>
  </div>
   

</header>

</div>