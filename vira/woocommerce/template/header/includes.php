<?php

$checker = new mob_cheker;

if (is_front_page()) {

  get_template_part( '/inc/template/header/preloaders' );
}

if ( prk_option('gust_top_desctop') ) {
  if (! mobile_cheker() && ! tablet_cheker()) {

    if (gust_home_top()) {

      if (is_front_page()) {
        get_template_part('/inc/template/header/topbars');
      }
    }else {
      get_template_part('/inc/template/header/topbars');
    }

  }
}else {

    if (gust_home_top()) {

      if (is_front_page()) {
        get_template_part('/inc/template/header/topbars');
      }
    }else {
      get_template_part('/inc/template/header/topbars');
    }


}


// فراخانی در دستگاه موبایل و فقط در صفحه اصلی سایت
if (is_front_page() && $checker->isMobile()) {

  get_template_part('/inc/template/header/navbar');
  get_template_part('/inc/template/header/app-download');

}



?>
