<?php

/**
 * woocommerce function hooks
 * قلاب اندازی به توابع منحصر بفرد به صفحات ووکامرس
 *
 * @package     Parskala
 * @Author      Hosein Esmaliyan
 * @link        http://www.parskalas.ir
 *
 */


// // نمایش توضیحات دسته بندی ها در فروشگاه و دسته بندی ها
// add_action('woocommerce_after_main_content','add_after_main_content');
// function add_after_main_content(){
//
//   if (! single_cat_title("", false)) {
//
//   } elseif(category_description()) {
//
//       echo '<div class="continer"><div class="foot-categorys"><div class="mask-text">';
//       echo '<h2>';
//       single_cat_title();
//       echo '</h2>';
//       echo '<p>'.category_description();'</p>';
//       echo '
//       </div>
//       <a href="#" class="mask-handler">
//       <span class="show-more">نمایش بیشتر</span>
//       <span class="show-less">- بستن</span>
//       </a>
//       </div></div>';
//   }else{
//
//       echo '<div class="continer"><div class="foot-categorys">';
//       echo '<h2>';
//       single_cat_title();
//       echo '</h2>';
//       echo '</div></div>';
//   }
// }

function prk_include_single_style(){

  if (theme_style() == 'prk-fashion') {

    get_template_part('inc/woocomerce_functions/fashon_single_style');

  }
  else {

    get_template_part('inc/woocomerce_functions/pars_single_style');

  }

}


add_action('init','prk_include_single_style');
