<?php

// remove breadcrumb and add bottom
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'woocommerce_after_main_content', 'woocommerce_breadcrumb', 10 );

function pek_add_mobile_scripts(){
  wp_enqueue_style('prk-mobile-style', parskala_URI . '/assets/css/prk-mobile.css', array(), '4.3.3', 'all');
  wp_enqueue_script( 'prk-mobile-script', get_template_directory_uri() . '/assets/js/prk-mobile.js', array ( 'jquery' ),PRK_VERSION, true);
}

add_action( 'wp_enqueue_scripts', 'pek_add_mobile_scripts', 5 );


function prk_navbar_mobile_add(){

  get_template_part('/inc/template/header/mobile-navbar');

}

add_action('wp_head','prk_navbar_mobile_add');

 