<?php



$checker = new mob_cheker;
if ($checker->isMobile()) {
  $device = 'mobile';
}else {
  $device = 'desctop';
}

global $current_user;
 wp_get_current_user();
$user = wp_get_current_user();
$woo_active = class_exists( 'WooCommerce' );
$supportsـtrue = prk_option('supports_true');
$header_search_true = prk_option('header_search_true');
$get_location = prk_option('prk_filter_location');
$account_url = get_permalink( get_option('woocommerce_myaccount_page_id') );
$header_account_type = prk_option('header_account_type');
$header_sticky_menu = prk_option('header_sticky_menu');
$header_account = prk_option('header_account');
$header_minicart = prk_option('header_minicart');
$header_minicart_type = prk_option('header_minicart_type');
$call_page = prk_option('call_page');
$call_true = prk_option('call_true');
$menu_admin_link = '<a href="'. site_url('wp-admin/nav-menus.php').'" target="_blank">'.__('menu','parskala').'</a>' ;
$prk_topbar_true = prk_option('prk_topbar_true');
$prk_topbar_stikey = prk_option('prk_topbar_stikey');

if (gust_home_top()) {

 if ( $prk_topbar_true && $prk_topbar_stikey && is_front_page() ) {
   $sticky_classes = 'top_stikey';
 }else {
   $sticky_classes = '';
 }

}else {

 if ( $prk_topbar_true && $prk_topbar_stikey ) {
   $sticky_classes = 'top_stikey';
 }else {
   $sticky_classes = '';
 }

}

?>

<?php
  if (prk_option('blacki_trure')){
    ?>
      <div id="blacki" class="blacki"></div>
    <?php
  }
?>


<header style="position:sticky;" class="header <?php echo $device. ' '; echo $sticky_classes; ?>">
  <div class="header-borner">
  <div  class="continer noselect_moblie">

    <div class="col-1">


      <div class="btn-menu1 toggle-navigation" id="icon-menu">

        <div id="pencet">
          <span></span>
          <span></span>
          <span></span>
        </div>

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
      <?php if ($header_search_true):?>
      <div class="call-page mobile">
        <a href="<?php echo $call_page;?>"><i class="<?php echo $call_icon;?>"></i></a>
      </div>
      <?php endif;?>
 
    </div>

    <div class="col-mobile">

    <?php if ($header_search_true):?>

      <div class="col-2 row">

        <!--search-->
        <div class="search-box">

          <?php

          $placeholder =  __('جستجو در محصولات ....', 'parskala' );
          echo do_shortcode('[prk_search placeholder="'.$placeholder.'" ]');

          ?>

        </div>

      </div>

    <?php endif;?>


    <div class="col-3 row">

      <?php if ($header_account):?>

        <?php if ('dropdown' == $header_account_type):?>

          <?php if ( ! is_user_logged_in() ):?>

            <!--account-->
            <div class="account noselect">
              <a href="<?php echo $account_url;?>">
                <span class="account-icon"><i class="account-user"></i></span>
                <span class="account-text">ورود به حساب کاربری</span>
              </a>
            </div>

          <?php else:?>
            <!--account-hover-->
            <div class="account opener noselect">
              <span class="account_title">

                <span class="account-icon"><i class="account-user"></i></span>
                <span class="account-icon-arrow"><span class="icon-logged"></span><i class="caret-down"></i></span>

              </span>
            </div>

          <?php if ($woo_active):?>

          <!--dashboard-->
          <div id="dashboard-menu" class="dashboard-menu">

            <ul>

              <li class="frist-li">
                <i class="account-avatar">

                  <?php if ( $user ):?>
                    <img src="<?php echo esc_url( get_avatar_url( $user->ID)); ?>" height="32" width="32"/>
                  <?php endif;?>

                </i>

                <i class="account-name"><?php echo $current_user->display_name;?></i>
                <a href="<?php echo $myaccount_page_id; ?>"><?php _e('View account' , 'parskala');?></a>
              </li>

              <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>

                <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                  <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
                </li>

              <?php endforeach; ?>

            </ul>

          </div>

          <?php endif;?>

        <?php endif;?>

      <?php elseif ('link' == $header_account_type):?>

        <?php if ( ! is_user_logged_in() ):?>

          <div class="account">

            <a href="<?php echo $account_url;?>">
              <span class="account-icon"><i class="account-user"></i></span>
              <span class="account-text"><?php echo esc_html( $header_account_login );?></span>
            </a>

          </div>

        <?php else:?>

          <div style="border:0;" class="account">

            <a href="<?php echo $account_url;?>">

              <span style="color:#616161;margin-left:4px;"><i class="fas fa-caret-down"></i></span>
              <span class="account-icon"><i class="account-user"></i></span>

            </a>

          </div>

        <?php endif;?>

      <?php endif;?>

      <?php endif;?>

      <span class="line-r"></span>

      <?php if ($header_minicart):?>

        <?php if ($woo_active):?>

          <?php if ('dropdown' == $header_minicart_type):?>

            <!--mini-cart-->
            <a href="<?php echo wc_get_cart_url(); ?>">

              <span class="cart-btn">

                <i class="shopping-cart"></i>
                <em class="mini_cart_counter"><?php PRK_cart_count(); ?></em>

                <div class="mini-cart-user">

                  <span class="head-mini">
                    <i class="count-mini"><?php PRK_cart_count(); ?><?php _e('products' , 'parskala');?></i>
                    <a class="cart-mini" href="<?php echo wc_get_cart_url(); ?>"><?php _e('View cart' , 'parskala');?><i class="ri-arrow-drop-left-line"></i></a>
                  </span>

                </div>

              </span>

            </a>

          <?php elseif('link' == $header_minicart_type):?>

            <!--mini-cart-link-->
            <a href="<?php echo wc_get_cart_url(); ?>">

              <span class="cart-btn-hover"><i class="shopping-cart"></i></span>
              <em class="mini_cart_counter"><?php PRK_cart_count(); ?></em>

            </a>


          <?php endif;?>

        <?php else:?>

        <span class="cart-btn"><i class="shopping-cart"></i> </span>
        <em class="mini_cart_counter"><?php PRK_cart_count(); ?></em>

        <?php endif;?>

      <?php endif;?>

    </div>

  </div>

  <?php

  if ($get_location) {
    echo do_shortcode('[mob_select_location]');
  }
  ?>

   </div>
  </div>

<div class="menus <?php echo $sticky_classes;?>">

  <div class="continer">
    <nav class="top-nav">

      <?php

      // اگر مگامنو غیر فعال باشد

        $walker = new Prk_Walker_Nav_Menu;
        echo '<ul class="prk_mega_menu">';

        if ( has_nav_menu( 'mega-menu' ) ) {

        wp_nav_menu(
          array('container'=>'true',
          'theme_location'=> 'mega-menu','depth' => 4,
          'items_wrap' => '%3$s',
           'walker' => $walker)
          );

        }
        else{

					echo '<div class="no-main-menu">'.sprintf( __( 'Create a %s with main location to display here.', 'parskala' ), $menu_admin_link ).'</div>';

        }
        echo '</ul>';

        ?>
        <script>
          jQuery(document).ready(function($){

            jQuery('li.mega_menu_tree_level.prk-side-tab.menu-item-has-children > ul').wrap("<div class='prk-tab-menu-items'></div>");


            var maxHeight = 0;

            jQuery(".mega_menu_tree_level.prk-side-tab .sub-menu.prk-level-1").each(function(){
               if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
            });

            jQuery(".prk-tab-menu-items").height(maxHeight  + 30 );
            jQuery(".prk-tab-menu-items").css("display" , "none");

            jQuery('li.mega_menu_tree_level ul.prk-level-0 > li:first-child').addClass("active");

            jQuery('li.mega_menu_tree_level ul.prk-level-0 > li').mouseenter(function(){
                jQuery(this).parent().find('li').removeClass("active");
                jQuery(this).addClass("active");
            });

          });
        </script>

      <?php


        if ($get_location) {

        echo do_shortcode('[select_location]');

        }
       ?>

    </nav>

  </div>

</div>


<?php if ($checker->isMobile()) {
$menu_model = prk_option( 'menu_mobile_model' );
   ?>

<!-- main-menu-->
<nav id="mobile-menu1" class="modal-menu <?php echo $menu_model ? $menu_model : 'modern';?>">

  <div class="logo-mobile">
    <?php
    if ( prk_logo_menu() ){
     echo prk_logo_menu();
   }
   else {
     echo prk_logo();
   }
   ?>
  </div>

  <div class="off-canvas-main">

    <?php
        if ( has_nav_menu( 'mega-menu' ) ) {
        $args = array(
            'theme_location'=> 'mega-menu',
            'walker' => new Prk_Walker_Nav_Menu_mob(),
            );
        wp_nav_menu($args);
      }

    ?>

  </div>

</nav>

<?php } ?>

</header>

<?php
