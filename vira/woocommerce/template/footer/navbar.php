<?php

$tabsـtrue = prk_option('tabs_true');
$tabsـstyle = prk_option('tabs_style');

// text
$text_menu1 = prk_option('text_mob_menu1');
$text_menu2 = prk_option('text_mob_menu2');
$text_menu3 = prk_option('text_mob_menu3');
$text_menu4 = prk_option('text_mob_menu4');


// icon
$icon_menu1 = prk_option('icon_mob_menu1');
$icon_menu2 = prk_option('icon_mob_menu2');
$icon_menu3 = prk_option('icon_mob_menu3');
$icon_menu4 = prk_option('icon_mob_menu4');

// url
$url_menu1 = prk_option('url_mob_menu1');
$url_menu2 = prk_option('url_mob_menu2');
$url_menu3 = prk_option('url_mob_menu3');
$url_menu4 = prk_option('url_mob_menu4');
 
$url = get_bloginfo('url');
$cart_url = "";
$myaccount_page_id = "";
$shop_page_url = "";
$count_cart = "";
 if (class_exists( 'WooCommerce' )){
   global $woocommerce;
   $cart_url = wc_get_cart_url();
   $myaccount_page_id = get_permalink( get_option('woocommerce_myaccount_page_id') );
   $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
   $count_cart = WC()->cart->get_cart_contents_count();
 }

 if ( ! is_user_logged_in() ) {
   $class_logined = 'has-sale';
 }else {
   $class_logined = 'has-loggged';
 }
?>
<?php if ( prk_option( 'modern_mobile_toolbar') == '1' && $tabsـtrue && class_exists( 'WooCommerce' )):?>

	<div id="NavMenu">

	<div class="bottom-navbar">
	  <div class="item-navbar">
	    <a href="<?php echo $url_menu1;?>/">
	    <span class="icon-navbar"><i class="<?= $icon_menu1; ?>"></i></span>
	    <span class="name-navbar"><?php echo $text_menu1;?></span>
	    </a>
	</div>
	<div class="item-navbar">
	  <a href="<?php  echo $url_menu2;?>">
	  <span class="icon-navbar"><i class="<?= $icon_menu2; ?>"></i></span>
	  <span class="name-navbar"><?php echo $text_menu2;?></span>
	  </a>
	</div>

  <div class="item-navbar mini_cart">
    <a href="<?php  echo $cart_url;?>">
      <span class="icon-navbar"><i class="prk-shopping-cart"><em class="mini_cart_counter"><?php PRK_cart_count(); ?></em></i></span>
    </a>
  </div>

  <div class="item-navbar">
    <a href="<?php  echo $url_menu3;?>sit-wishlist/">
      <span class="icon-navbar"><i class="<?= $icon_menu3; ?>"></i></span>
      <span class="name-navbar"><?php echo $text_menu3;?></span>
    </a>
  </div>

	<div class="item-navbar">
  	<a href="<?php echo $url_menu4;?>">
    	<span class="icon-navbar <?php echo $class_logined;?>"><i class="<?= $icon_menu4; ?>"></i></span>
    	<span class="name-navbar"><?php echo $text_menu4;?></span>
  	</a>
	</div>

	</div>

</div>
<?php endif;?>
