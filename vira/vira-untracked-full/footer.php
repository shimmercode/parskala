

<?php

// کنترل عرض سایت درصفحات غیر از صفحه اصلی *تگ بسته شد
 if (! is_front_page() && ! prk_faq_page() && !is_page_template( 'page-full-wide.php' ) ){

  echo '</div>';

}

// سکشن آحرین محصولات دیده شده
if (class_exists( 'WooCommerce' ) ) {
  // code...

  if ( prk_footer_seen_true() && empty(is_account_page()) && empty(is_checkout()) ){

     get_template_part( '/inc/template/footer/product-seen' );

  }

}
?>

<div class="clear"></div>

<footer class="footer-s">

  <?php

 if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

   if ( empty( is_user_logged_in() ) &&  is_account_page() ) {

     if ( empty( prk_hider_footer_loginform() ) ) {

       if ( 'default' == prk_footer_type() ){

         get_template_part( '/inc/template/footer/main-footer' );

       }
       elseif('elementor' == prk_footer_type() ){

         get_template_part( '/inc/template/footer/elementor-footer' );

       }
       elseif ('disable' == prk_footer_type() ){

         get_template_part( '/inc/template/footer/main-footer' );

       }

     }

   }
   elseif ( class_exists( 'WooCommerce' ) &&  is_checkout() ) {

     if (empty( prk_checkout_footer_hide() )) {

       if ( 'default' == prk_footer_type() ){

         get_template_part( '/inc/template/footer/main-footer' );

       }
       elseif('elementor' == prk_footer_type() ){

         get_template_part( '/inc/template/footer/elementor-footer' );

       }
       elseif ('disable' == prk_footer_type() ){

         get_template_part( '/inc/template/footer/main-footer' );

       }

     }

   }
   else {

     if ( 'default' == prk_footer_type() ){

       get_template_part( '/inc/template/footer/main-footer' );

     }
     elseif('elementor' == prk_footer_type() ){

       get_template_part( '/inc/template/footer/elementor-footer' );

     }
     elseif ('disable' == prk_footer_type() ){

       get_template_part( '/inc/template/footer/main-footer' );

     }

   }

 }else {
   if ( 'default' == prk_footer_type() ){

     get_template_part( '/inc/template/footer/main-footer' );

   }
   elseif('elementor' == prk_footer_type() ){

     get_template_part( '/inc/template/footer/elementor-footer' );

   }
   elseif ('disable' == prk_footer_type() ){

     get_template_part( '/inc/template/footer/main-footer' );

   }
 }








  ?>

</footer>
<div class="navigation-overlay"></div>
<?php wp_footer();?>


</html>
