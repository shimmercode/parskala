<?php

// فراخونای فایل های مورد نیاز در فوتر


if ( class_exists( 'WooCommerce' ) ) {

  if ( prk_option('prk_filter_location') ) {
      get_template_part('/inc/template/footer/location-picker');
  }


  get_template_part('/inc/template/footer/form-login');

  if (prk_option('prk_modern_mobile') == 0 ) {
      get_template_part('/inc/template/footer/navbar');
  }


  if ( empty(is_checkout() ) && empty( is_cart() ) ) {
    get_template_part('/inc/template/footer/call-box');
  }
  if ( empty(prk_option('theme-style') == 'digikala' )  && empty( is_checkout() ) ) {
    get_template_part('/inc/template/footer/product_modal');
  }
}


get_template_part('/inc/template/footer/ques-box');




if (prk_apps_true() && is_front_page()) {
  get_template_part('/inc/template/footer/app-download');
}
