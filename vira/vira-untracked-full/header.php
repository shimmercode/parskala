<!DOCTYPE html>
<html <?php language_attributes(); ?>>

  <head>

    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"/>

    <meta name="theme-color" content="<?php echo prk_addressbar_color();?>">
    <meta name="fontiran.com:license" content="B3L8B">

    <?php if (is_singular() ) { wp_enqueue_script('comment-reply'); } ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    
    <?php if (
    is_plugin_active('wordpress-seo/wp-seo.php') || is_plugin_active('wordpress-seo-premium/wp-seo-premium.php') || class_exists('WPSEO_Options') || is_plugin_active('rank-math/rank-math.php') ||class_exists( 'RankMath' ) 
    ) { ?>
      <title><?php wp_title(''); ?></title>
    <?php
    } else { ?>

      <title>

        <?php 

         if( get_bloginfo('description')==null && is_front_page() ){

            bloginfo('name'); 

          }elseif (get_bloginfo('name')==null){

            is_front_page() ? bloginfo('description') : wp_title('');

         }elseif(is_front_page()){

             bloginfo('name'); 

             echo ' &ndash; ';

             is_front_page() ? bloginfo('description') : wp_title('');

          }else{

            is_front_page() ? bloginfo('description') : wp_title(''); 

            echo ' &ndash; ';

            bloginfo('name'); 

          }
        
        ?>
       
      </title>
    <?php
    } ?>

    <?php
    wp_enqueue_script( 'jQuery' );
    wp_head();
    ?>

  </head>

  <body class="<?php echo class_type()?>" >

  <?php get_template_part( '/inc/template/header/includes' ); ?>

  <!--header-->
  <?php
   $prk_header = prk_option('header_type');


    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
      if ( empty( is_user_logged_in() ) &&  is_account_page() ) {

        if ( empty( prk_hider_header_loginform() ) ) {

          if( 'default' == $prk_header){
            if ( 'digikala' == theme_style() ) {
              get_template_part('/inc/template/header/main-header');
            }else {
              get_template_part('/inc/template/header/modren-header');
            }
          }
          elseif( 'default' == $prk_header){
            get_template_part('/inc/template/header/main-header');
          }
          elseif ('elementor' == $prk_header){
            get_template_part('/inc/template/header/elementor-header');
          }
          elseif ('disable' == $prk_header){
          }
          else {
            get_template_part('/inc/template/header/main-header');
          }

        }

      }
      elseif( class_exists( 'WooCommerce' ) && is_checkout() ) {

        if ( empty(prk_checkout_header_hide() ) ) {

          if( 'default' == $prk_header){
            if ( 'digikala' == theme_style() ) {
              get_template_part('/inc/template/header/main-header');
            }else {
              get_template_part('/inc/template/header/modren-header');
            }
          }
          elseif( 'default' == $prk_header){
            get_template_part('/inc/template/header/main-header');
          }
          elseif ('elementor' == $prk_header){
            get_template_part('/inc/template/header/elementor-header');
           }

          elseif ('disable' == $prk_header){
          }
          else {
            get_template_part('/inc/template/header/main-header');
          }

        }

      }
      else{


        if( 'default' == $prk_header){
          if ( 'digikala' == theme_style() ) {
            get_template_part('/inc/template/header/main-header');
          }else {
            get_template_part('/inc/template/header/modren-header');
          }
        }
        elseif ('elementor' == $prk_header){
          get_template_part('/inc/template/header/elementor-header');
         }

        elseif ('disable' == $prk_header){
        }
        else {
          get_template_part('/inc/template/header/main-header');
        }

      }
    }else {
      if ( empty( is_user_logged_in() ) ) {

        if ( empty( prk_hider_header_loginform() ) ) {

          if( 'default' == $prk_header){
            if ( 'digikala' == theme_style() ) {
              get_template_part('/inc/template/header/main-header');
            }else {
              get_template_part('/inc/template/header/modren-header');
            }
          }
          elseif( 'default' == $prk_header){
            get_template_part('/inc/template/header/main-header');
          }
          elseif ('elementor' == $prk_header){
            get_template_part('/inc/template/header/elementor-header');
           }

          elseif ('disable' == $prk_header){
          }
          else {
            get_template_part('/inc/template/header/main-header');
          }

        }

      }else{

        if( 'default' == $prk_header){
          if ( 'digikala' == theme_style() ) {
            get_template_part('/inc/template/header/main-header');
          }else {
            get_template_part('/inc/template/header/modren-header');
          }
        }
        elseif ('elementor' == $prk_header){
          get_template_part('/inc/template/header/elementor-header');
         }

        elseif ('disable' == $prk_header){
        }
        else {
          get_template_part('/inc/template/header/main-header');
        }


      }
    }







   // کنترل عرض سایت درصفحات غیر از صفحه اصلی
   if (! is_front_page() && ! prk_faq_page() && !is_page_template( 'page-full-wide.php' ) ){

    echo '<div class="continer">';

  }

  ?>
