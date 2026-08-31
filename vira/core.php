<?php

// ParsKala National Guard must be loaded globally, not only inside the theme-options screen.
$prk_national_guard_boot = ( function_exists( 'get_template_directory' ) ? get_template_directory() : dirname( __FILE__ ) ) . '/inc/modules/national-guard/national-guard.php';
if ( file_exists( $prk_national_guard_boot ) ) {
    require_once $prk_national_guard_boot;
}


add_action('init', function () {
  // حذف اکشن اصلی
  remove_action('woocommerce_structured_data_product', [ 'WC_Brands', 'add_structured_data' ], 10);

  // اضافه کردن اکشن سفارشی برای جلوگیری از خطا
  add_action('woocommerce_structured_data_product', function ($data, $product) {
      if (!is_array($data)) {
          $data = []; // مقدار پیش‌فرض در صورت null بودن
      }
      return $data;
  }, 10, 2);
});


add_action( 'after_setup_theme', 'parskala_load_textdomain' );

function parskala_load_textdomain() {
    load_theme_textdomain( 'parskala', get_template_directory() . '/languages' );
}


add_action('init', function() {
    if ( function_exists('wp_get_theme') && wp_get_theme()->get('TextDomain') ) {
        $text_domain = wp_get_theme()->get('TextDomain');
        $languages_path = get_template_directory() . '/languages';
    } else {
        $text_domain = dirname(plugin_basename(__FILE__));
        $languages_path = plugin_dir_path(__FILE__) . 'languages';
    }
    if ( version_compare( $GLOBALS['wp_version'], '6.7', '<' ) ) {
        load_plugin_textdomain( $text_domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    } else {
        $locale = determine_locale();
        $mo_file = $languages_path . "/$text_domain-$locale.mo";

        if ( is_readable( $mo_file ) ) {
            load_textdomain( $text_domain, $mo_file );
        }
    }
});



// آرایه سلکتورها -> رنگ اصلی قالب
function gradient_general_selector(){
  $general_color = '';
  $options = get_option( 'prk_option' );
  $gradient = "";
  if(isset($options) && !empty($options)){
    if ( isset( $options['gradient_general_color']['background-gradient-color'] ) )	$gradient      =  $options['gradient_general_color']['background-gradient-color'];
  }

  if ($gradient) {
    return array(
      'background-color' => '.col-product.style4 .right-product .owl-nav span:not(.disabled),.image-amazing-category a.button,.header-carter,.primary-bg,body .woocommerce-form-login button.digits_login_via_otp.woocommerce-Button,.widget.side-box-post .article-off .owl-dots .owl-dot.active,body .slider-right .owl-dots .active,.prk-sticky-add .go-to-add,.progress-area .progress-bar,.quick_add2cart,button.single_add_to_cart_button,button.back-to-product,.header-mobiter header,input.button,.search-section select#cat,body ul.product-box.prk-item-style2 li.product .prs,.prk-size-tab.tabs-form li.active,.notifyproduct a.stock_data,.product-tooltips li.carter-mobiler i em,.button_bodner,.select_delivery_time span,.prk-main-ratings-opitons .noUi-connect,.noUi-horizontal .noUi-handle,.content_ask_page .get_back_button,.woocommerce-pagination li.current,.woocommerce-pagination .page-numbers li .current, .misha_loadmore,.widget_woocommerce-widget-layered-nav_brand ul li.chosen a:before, .widget_woocommerce-widget-layered-on_stock ul li.chosen a:before, .widget_woocommerce-widget-layered-nav_cat ul li.chosen a:before, .woocommerce-widget-layered-nav ul li.chosen a:before, .widget_woocommerce-widget-layered-nav ul li.chosen a:before,.prK_orderby_mobile ul li.is-active::before,.prK_orderby_filtering ul li.is-active,.woocommerce-pagination ul li .page-numbers.sec_progress_wrapper .sec_progress_bar,.woocommerce .woocommerce-form-login .woocommerce-form-login__submit, .woocommerce-form-register__submit,body #NavMenu .item-navbar.mini_cart a .icon-navbar i::before,.wenderfol_archive,.price_slider_wrapper .price_slider_amount .button,.side-form-search button,.prk-shoppingcart-next-contain-links a .border_solid_cart,.error-404 span a,.prk_open_mini_cart,.call_box .call_button,body.ceckout_page .woocommerce-bacs-bank-details ul li.bic::before,body .woocommerce p.woocommerce-thankyou-order-received::before,.pay_submit_order form a,.pay_submit_order form .button,.pay_submit_order form input,body .prk_order_confirm ul.order_details li.method::before,input[type="radio"]:checked:before,input[type="checkbox"]:checked,body.ceckout_page div.place-order button#place_order,.prk-shoppingcart-next-contain-links a i,.prk-shoppingcart-next-contain-links a em,.payment_navigtions .checkout-headers ul li::after,.foot-dn-app .dn-box,.continer-rating .go-insert-comment a,.show-insert-question,.seller-info-box-header,.woocommerce div.product .woocommerce-tabs ul.tabs li.reviews_tab a i,.prk_compare_page .misha_loadmore,.mail-foot button,.parskala.search-section button,.prk-factor-button,.toolbar_col .toolbar_item.go_up:hover,#nav-order .active,#top_products_table_compare li a.compare_permalink_product,.prk-loginbox #stm-sms-form-holder .stm-login-sms-btn, .prk-loginbox #stm-sms-form-holder .stm-sms-confirm--submit,.loader-bullet,.lists_add_to_cart i::before,.services_box article:hover,.prk-plus.prk-account .account,.page-promotes::after,.product-item-link i,.col-product.wee .product_wee .wee_tumbnail::before,.promotion-categories .categorys_item article:hover,.lists_product .swiper-slide.swiper-slide-active .product-lists::before,.lists_product .lists_add_to_cart,.mcarousel_product_head h4::before,.swiper_item_promotion_produt .swiper-slide-thumb-active span,.swiper_item_promotion_produt .swiper-slide-thumb-active span::before,.mcarousel_product .swiper-pagination-bullets-dynamic .swiper-pagination-bullet-active-main,.promotion_produt .go_more_link,.swiper_promotion_produt::before,.swiper_promotion_produt .swiper-slide.promotion_item::after,.go_link_view,.index-discount-pro,.cart-btn em,.button-insert-question,.insert-better,.switch input:checked + .slider,.insert-feed,.cart-pro .sale-off-pro, .cart-pro .sale-off-pro del,#respond .form-submit #submit,.header-carter .close-box:hover,.wishlist_table .product-add-to-cart a,.go-insert-comment a:hover,.item-navbar.active::before,.top-nav .mega-menus:hover .sub-menu:nth-child(2) li::before,.progress-bar-value,.product-cart,.woocommerce-notices-wrapper .woocommerce-message a,.toolbar_col.active .toolbar_item,.woocommerce .cart-order-user table.shop_table td.actions .coupon button,.woocommerce .cart-order-user table.shop_table td.actions button:hover,.woocommerce .cart-order-user table.shop_table td.actions button,.woocommerce .cart-order-user table.shop_table td.actions button:hover,.woocommerce .checkout_coupon button,.woocommerce-address-fields button.button,.woocommerce .tabs-forms .woocommerce-button,.mini-cart-user .woocommerce-mini-cart__buttons .wc-forward,.woocommerce-checkout .review-order-user .woocommerce-checkout-payment .place-order button.button,.support-tab,.ques-welcoming,.titles-pro::after,.woocommerce a.button,.toolbar_col.is_middle .toolbar_item,a.dokan-btn-info, .dokan-btn-info,input[type="submit"].dokan-btn-theme, a.dokan-btn-theme, .dokan-btn-theme,.dokan-product-listing .dokan-product-listing-area .dokan-btn,.dokan-product-listing .dokan-product-listing-area .dokan-btn,.dokan-product-listing .dokan-product-listing-area .dokan-btn,.dokan-btn-success,.dokan-orders-content .dokan-orders-area #dokan-order-notes .add_note .add_note.btn.btn-sm.btn-theme,.dokan-orders-content .dokan-orders-area .order_download_permissions button.revoke_access,.mail-foot:hover button,.lds-ellipsis span,.woocommerce-address-fields .sub-addres-user .button,.content-user .address-user-pro .edit,.content-user .no-Order-user .no-order-link,.content-user .woocommerce-orders-table__row .woocommerce-orders-table__cell .woocommerce-button,.content-user .woocommerce-EditAccountForm .sub-account-user .button,.top-nav .sub-menu:nth-child(2) li .sub-menu > li > a::before,.top-nav .dropdown li::after,.add-to-cart.offer .add-to-carter',

    );
  }

}
function general_selector(){

  $general_color = '';
  $options = get_option( 'prk_option' );
  $gradient = "";
  if(isset($options) && !empty($options)){
    if ( isset( $options['gradient_general_color']['background-gradient-color'] ) )	$gradient      =  $options['gradient_general_color']['background-gradient-color'];
  }

  if ($gradient) {

    $general_color = array(
      'color' => '.amazing-item .countdown-unit .number,body .slider-amazing .wc-product-item:hover .quick_add2cart.button,.prk-static-sidebar .nasa-total-condition-desc strong,.post-comment .comment-list .comment .comment-meta .comment-reply a,body ul.product-box li.product .prs,.col-product .prk-header-divs.prk-header-divs-active i,.col-product .prk-header-divs.prk-header-divs-active span,.col-product .prk-header-divs:hover i,.col-product .prk-header-divs:hover span,.modal-menu.digikala .toggle-submenu.opened::after,.selected-cities .selectedcty,.sellers-section-cell-buy .button_border,.order-items .order-item .product-img a.go-product,.delivery_time_mobile_header span.order-delivery-title i,.cart_page .woocommerce-cart-form__contents div.quantity input,.cart_page .woocommerce-cart-form__contents div.quantity i,.asked_btn_icon i,.main_box_faq_cats .link_faq_cats:hover span,.ask_accordion.active .toggle_icon,.main_result_ajax_ask_search a.result_post_search::after,.ask_top_page .faq_headerbox .circle_btn_icon i,.stm-sms-confirm .stm-sms-confirm--bottom,.widget_layered_nav_filters ul li a,.prK_orderby_mobile ul li.is-active a,body .widget.widget_woocommerce-widget-layered-on_stock ul li a,.woocommerce-pagination ul li .page-numbers:hover,body .woocommerce.prk_fashion div.product .cart-pro ins bdi,body.fashion-style .woocommerce.prk_fashion div.product .cart-pro del span.index-discount-pro,body .woocommerce.prk_fashion div.product .cart-pro del span.index-discount-pro p,.call_box .call_main ul li.call_close_mobile,body.ceckout_page .woocommerce ul#shipping_method li label .woocommerce-Price-amount,body .woocommerce .prk_order_confirm .pay_submit_order form .cancel,body.ceckout_page div.place-order .validate-required label .woocommerce-terms-and-conditions-checkbox-text a,.add_to_cart_all_main div#add-all-product,.prk-shoppingcart-next-contain-links a.active,.payment_navigtions .checkout-headers ul li i,.payment_navigtions .checkout-headers ul li p,.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,.woocommerce div.product .woocommerce-tabs ul.tabs li.active a::before,.index-prices-pro div del,.off-product.mories .w-categorys-link i,.cart-btn-hover i,.top-nav .dropdown li ul li ul li a:hover,.top-nav .dropdown li ul li ul li a:hover,.top-nav .sub-menu:nth-child(2) li .sub-menu > li > a::before,.top-nav .dropdown li ul li:hover::before,.cart-pro del, .cart-pro del span bdi, .cart-pro del span, .cart-pro del span bdi span,.mgrid_product.grid_product .mcarousel_product_head h4 i,.carousel_offer .right_carousel h4 i,.lists_product .product-lists-body del .woocommerce-Price-amount,.location-piker_mob i,.account-icon,.product-seller-info .product-seller-row .product-seller-row-detail ul li.pluses i,.nav-user-dashboard .woocommerce-MyAccount-navigation ul .is-active a,.woocommerce span.onsale.prs,.prs,.product_comment_link,.top-nav .mega-menus .sub-menu:nth-child(2) li ul li a:hover,.progress-count .p-cont,.pro-display-user .p-edit-user span,#dokan-store-listing-filter-wrap .right .toggle-view .active,.dokan-dashboard-content a.dokan-btn-sm, .dokan-btn-sm,.dokan-product-listing .dokan-product-listing-area .product-listing-top span.dokan-add-product-link a,#comments .comment-forms .text-com i,.timer-pros span,.pro-display-user .p-edit-user span i,.content-user .woocommerce-EditAccountForm .sub-account-user .button.pro-display-user .p-edit-user span,.nav-user-dashboard .woocommerce-MyAccount-navigation ul li:hover::before,.nav-user-dashboard .woocommerce-MyAccount-navigation ul li:hover a,.nav-user-dashboard .woocommerce-MyAccount-navigation ul .is-active::before,.head-archie-pro,.date-send-pro cite .date-head i,.dropdown:nth-child(1) li ul li ul li ul li:hover a,.top-nav .dropdown li ul li ul li a:hover',

      'border-color' => '.nasa-subtotal-condition .nasa-total-number,body .side-title-post,.post-comment .comment-list .comment .comment-meta .comment-reply a,.selected-cities .selectedcty,.sellers-section-cell-buy .button_border,.order-items .order-item .product-img a.go-product,.cart_page .woocommerce-cart-form__contents div.quantity,body .woocommerce.prk_fashion div.product .cart-pro del span.index-discount-pro,.call_box .call_main ul li.call_close_mobile,body .woocommerce .prk_order_confirm .pay_submit_order form .cancel,input[type="radio"]:checked, input[type="checkbox"]:checked,body.ceckout_page div.place-order .validate-required label .woocommerce-terms-and-conditions-checkbox-text a,input[type="checkbox"]:checked,body.ceckout_page div.place-order button#place_order,.add_to_cart_all_main div#add-all-product,.seller-info-box-avatar,#top_products_table_compare li a.compare_permalink_product,.col-product.wee,.lists_product .swiper-slide.swiper-slide-active .product-lists,.off-product.mories .w-categorys-link i,.title-psidebar a,.product_comment_link,.go-insert-comment a,.woocommerce .cart-order-user table.shop_table td.actions button,a.dokan-btn-info, .dokan-btn-info,.dokan-dashboard-content a.dokan-btn-sm, .dokan-btn-sm,input[type="submit"].dokan-btn-theme, a.dokan-btn-theme, .dokan-btn-theme,.dokan-product-listing .dokan-product-listing-area .product-listing-top span.dokan-add-product-link a,.dokan-btn-success,.preloader div:before,.loader-p:before, .loader-p:after,.head-archie-pro,.woocommerce div.product .woocommerce-tabs ul.tabs li.active,.head-pros,.titles-pro',
    );

  }else {

    $general_color = array(
      'background-color' => '.image-amazing-category a.button,.slider-home-three-wrapper .swiper-pagination-bullet-active,#nprogress .bar,.primary-bg,body .woocommerce-form-login button.digits_login_via_otp.woocommerce-Button,.widget.side-box-post .article-off .owl-dots .owl-dot.active,body .slider-right .owl-dots .active,.prk-sticky-add .go-to-add,.progress-area .progress-bar,.quick_add2cart,button.back-to-product,button.single_add_to_cart_button,.header-mobiter header,.search-section select#cat,body ul.product-box li.product .prs,.prk-size-tab.tabs-form li.active,.notifyproduct a.stock_data,.product-tooltips li.carter-mobiler i em,.button_bodner,.select_delivery_time span,.prk-main-ratings-opitons .noUi-connect,.noUi-horizontal .noUi-handle,.content_ask_page .get_back_button,.woocommerce-pagination .page-numbers li.current,.woocommerce-pagination li .current,.widget_woocommerce-widget-layered-nav_brand ul li.chosen a:before, .widget_woocommerce-widget-layered-on_stock ul li.chosen a:before, .widget_woocommerce-widget-layered-nav_cat ul li.chosen a:before, .woocommerce-widget-layered-nav ul li.chosen a:before, .widget_woocommerce-widget-layered-nav ul li.chosen a:before,.prK_orderby_mobile ul li.is-active::before,.prK_orderby_filtering ul li.is-active,.woocommerce-pagination ul li .page-numbers.sec_progress_wrapper .sec_progress_bar,.woocommerce .woocommerce-form-login .woocommerce-form-login__submit, .woocommerce-form-register__submit,body #NavMenu .item-navbar.mini_cart a .icon-navbar i::before,.wenderfol_archive,.price_slider_wrapper .price_slider_amount .button,.side-form-search button,.prk-shoppingcart-next-contain-links a .border_solid_cart,.error-404 span a,.prk_open_mini_cart,.call_box .call_button,.continer .nav-user-dashboard .woocommerce-MyAccount-navigation ul li.is-active::after,body.ceckout_page .woocommerce-bacs-bank-details ul li.bic::before,body .woocommerce p.woocommerce-thankyou-order-received::before,.pay_submit_order form a,.pay_submit_order form .button,.pay_submit_order form input,body .prk_order_confirm ul.order_details li.method::before,input[type="radio"]:checked:before,input[type="checkbox"]:checked,body.ceckout_page div.place-order button#place_order,.prk-shoppingcart-next-contain-links a i,.prk-shoppingcart-next-contain-links a em,.payment_navigtions .checkout-headers ul li::after,.foot-dn-app .dn-box,.continer-rating .go-insert-comment a,.show-insert-question,.seller-info-box-header,.woocommerce div.product .woocommerce-tabs ul.tabs li.reviews_tab a i,.prk_compare_page .misha_loadmore,.mail-foot button,.parskala.search-section button,.prk-factor-button,.toolbar_col .toolbar_item.go_up:hover,#nav-order .active,#top_products_table_compare li a.compare_permalink_product,.prk-loginbox #stm-sms-form-holder .stm-login-sms-btn, .prk-loginbox #stm-sms-form-holder .stm-sms-confirm--submit,.loader-bullet,.lists_add_to_cart i::before,.services_box article:hover,.prk-plus.prk-account .account,.page-promotes::after,.product-item-link i,.col-product.wee .product_wee .wee_tumbnail::before,.promotion-categories .categorys_item article:hover,.lists_product .swiper-slide.swiper-slide-active .product-lists::before,.lists_product .lists_add_to_cart,.mcarousel_product_head h4::before,.swiper_item_promotion_produt .swiper-slide-thumb-active span,.swiper_item_promotion_produt .swiper-slide-thumb-active span::before,.mcarousel_product .swiper-pagination-bullets-dynamic .swiper-pagination-bullet-active-main,.promotion_produt .go_more_link,.swiper_promotion_produt::before,.swiper_promotion_produt .swiper-slide.promotion_item::after,.go_link_view,.index-discount-pro,.cart-btn em,.button-insert-question,.insert-better,.switch input:checked + .slider,.insert-feed,.cart-pro .sale-off-pro, .cart-pro .sale-off-pro del,#respond .form-submit #submit,.header-carter .close-box:hover,.wishlist_table .product-add-to-cart a,.go-insert-comment a:hover,.item-navbar.active::before,.top-nav .mega-menus:hover .sub-menu:nth-child(2) li::before,.progress-bar-value,.product-cart,.woocommerce-notices-wrapper .woocommerce-message a,.toolbar_col.active .toolbar_item,.woocommerce .cart-order-user table.shop_table td.actions .coupon button,.woocommerce .cart-order-user table.shop_table td.actions button:hover,.woocommerce .cart-order-user table.shop_table td.actions button,.woocommerce .cart-order-user table.shop_table td.actions button:hover,.woocommerce .checkout_coupon button,.woocommerce-address-fields button.button,.woocommerce .tabs-forms .woocommerce-button,.mini-cart-user .woocommerce-mini-cart__buttons .wc-forward,.woocommerce-checkout .review-order-user .woocommerce-checkout-payment .place-order button.button,.support-tab,.ques-welcoming,.titles-pro::after,.woocommerce a.button,.toolbar_col.is_middle .toolbar_item,a.dokan-btn-info, .dokan-btn-info,input[type="submit"].dokan-btn-theme, a.dokan-btn-theme, .dokan-btn-theme,.dokan-product-listing .dokan-product-listing-area .dokan-btn,.dokan-product-listing .dokan-product-listing-area .dokan-btn,.dokan-product-listing .dokan-product-listing-area .dokan-btn,.dokan-btn-success,.dokan-orders-content .dokan-orders-area #dokan-order-notes .add_note .add_note.btn.btn-sm.btn-theme,.dokan-orders-content .dokan-orders-area .order_download_permissions button.revoke_access,.mail-foot:hover button,.lds-ellipsis span,.woocommerce-address-fields .sub-addres-user .button,.content-user .address-user-pro .edit,.content-user .no-Order-user .no-order-link,.content-user .woocommerce-orders-table__row .woocommerce-orders-table__cell .woocommerce-button,.content-user .woocommerce-EditAccountForm .sub-account-user .button,.woocommerce div.product form.cart .button,.top-nav .sub-menu:nth-child(2) li .sub-menu > li > a::before,.top-nav .dropdown li::after,.add-to-cart.offer .add-to-carter',

      'color' => '.amazing-item .countdown-unit .number,body .slider-amazing .wc-product-item:hover .quick_add2cart.button,.prk-static-sidebar .nasa-total-condition-desc strong,.post-comment .comment-list .comment .comment-meta .comment-reply a,body ul.product-box li.product .prs,.col-product .prk-header-divs.prk-header-divs-active i,.col-product .prk-header-divs.prk-header-divs-active span,.col-product .prk-header-divs:hover i,.col-product .prk-header-divs:hover span,body .woocommerce div.product .cart-pro .index-prices-pro div .index-discount-pro p, body.fashion-style .cart-pro span.index-discount-pro p,.modal-menu.digikala .toggle-submenu.opened::after,.selected-cities .selectedcty,.order-items .order-item .product-img a.go-product,.delivery_time_mobile_header span.order-delivery-title i,.cart_page .woocommerce-cart-form__contents div.quantity input,.cart_page .woocommerce-cart-form__contents div.quantity,.asked_btn_icon i,body.ceckout_page .woocommerce ul#shipping_method li label .woocommerce-Price-amount,body .woocommerce .prk_order_confirm .pay_submit_order form .cancel,.add_to_cart_all_main div#add-all-product,.payment_navigtions .checkout-headers ul li i,.payment_navigtions .checkout-headers ul li p,.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,.woocommerce div.product .woocommerce-tabs ul.tabs li.active a::before,.index-prices-pro div del,.off-product.mories .w-categorys-link i,.cart-btn-hover i,.top-nav .dropdown li ul li ul li a:hover,.top-nav .dropdown li ul li ul li a:hover,.top-nav .sub-menu:nth-child(2) li .sub-menu > li > a::before,.top-nav .dropdown li ul li:hover::before,.cart-pro del, .cart-pro del span bdi, .cart-pro del span, .cart-pro del span bdi span,.mgrid_product.grid_product .mcarousel_product_head h4 i,.carousel_offer .right_carousel h4 i,.lists_product .product-lists-body del .woocommerce-Price-amount,.location-piker_mob i,.account-icon,.product-seller-info .product-seller-row .product-seller-row-detail ul li.pluses i,.nav-user-dashboard .woocommerce-MyAccount-navigation ul .is-active a,.woocommerce span.onsale.prs,.prs,.product_comment_link,.top-nav .mega-menus .sub-menu:nth-child(2) li ul li a:hover,.progress-count .p-cont,.pro-display-user .p-edit-user span,#dokan-store-listing-filter-wrap .right .toggle-view .active,.dokan-dashboard-content a.dokan-btn-sm, .dokan-btn-sm,.dokan-product-listing .dokan-product-listing-area .product-listing-top span.dokan-add-product-link a,#comments .comment-forms .text-com i,.timer-pros span,.pro-display-user .p-edit-user span i,.content-user .woocommerce-EditAccountForm .sub-account-user .button.pro-display-user .p-edit-user span,.nav-user-dashboard .woocommerce-MyAccount-navigation ul li:hover::before,.nav-user-dashboard .woocommerce-MyAccount-navigation ul li:hover a,.nav-user-dashboard .woocommerce-MyAccount-navigation ul .is-active::before,.head-archie-pro,.date-send-pro cite .date-head i,.dropdown:nth-child(1) li ul li ul li ul li:hover a,.top-nav .dropdown li ul li ul li a:hover',

      'border-color' => '.nasa-subtotal-condition .nasa-total-number,body .side-title-post,.post-comment .comment-list .comment .comment-meta .comment-reply a,.selected-cities .selectedcty,.order-items .order-item .product-img a.go-product,.cart_page .woocommerce-cart-form__contents div.quantity,body .woocommerce .prk_order_confirm .pay_submit_order form .cancel,input[type="radio"]:checked, input[type="checkbox"]:checked,input[type="checkbox"]:checked,body.ceckout_page div.place-order button#place_order,.add_to_cart_all_main div#add-all-product,.seller-info-box-avatar,#top_products_table_compare li a.compare_permalink_product,.col-product.wee,.lists_product .swiper-slide.swiper-slide-active .product-lists,.off-product.mories .w-categorys-link i,.title-psidebar a,.product_comment_link,.go-insert-comment a,.woocommerce .cart-order-user table.shop_table td.actions button,a.dokan-btn-info, .dokan-btn-info,.dokan-dashboard-content a.dokan-btn-sm, .dokan-btn-sm,input[type="submit"].dokan-btn-theme, a.dokan-btn-theme, .dokan-btn-theme,.dokan-product-listing .dokan-product-listing-area .product-listing-top span.dokan-add-product-link a,.dokan-btn-success,.preloader div:before,.loader-p:before, .loader-p:after,.head-archie-pro,.woocommerce div.product .woocommerce-tabs ul.tabs li.active,.head-pros,.titles-pro',
    );

  }

  return $general_color;

}

// آرایه سلکتورها -> رنگ اصلی دوم قالب
function general2_selector(){
  return array(
    'background-color' => '.header-mobiter header .cart-btn em,.misha_loadmore,.mini_cart_counter,.main-cart .woocommerce-mini-cart__buttons.buttons a.checkout,.tabs-panel-mobile .add_comment_mobile,.woocommerce-mini-cart__buttons.buttons a:nth-child(2),.form_search.active::after,.account_mobile .loged,.slider-right .owl-dots .active,.woocommerce #respond .form-submit #submit,.percent-option-rating strong,.checkout-headers ul .nav span.actv,.checkout-headers.cart ul li.bar:nth-child(2) span,.checkout-headers.checkout ul li.bar:nth-child(2) span,.checkout-headers.checkout ul li.bar:nth-child(4) span,.checkout-headers.thankyou ul li.bar:nth-child(4) span ,.checkout-headers.thankyou ul li.bar:nth-child(2) span,.summary .cart-pro .tab-pro ul li::after,.ui-slider .ui-slider-range,.index-product .woocommerce-pagination ul .page-numbers.head-side,.item-thumb-index .cat-name-index',

    'color' => '.header-mobiter .promote_searchs span,.header-mobiter .promote_searchs span i,.multi-line .icon-carosel ,.multi-line .post_grid .number,.mini-cart-user .head-mini .cart-mini i,.product-tab-nav-mobiles ul li.nav-item_mobile.reviews_tab .view_comment_mobiles,.prk-dashboard ul li.woocommerce-MyAccount-navigation-link--customer-logout a,.category_searechd .result_category_search span,.meta-additional .show-mores,.product-seller-info .product-seller-row .product-seller-row-detail ul li::after,.sec-pages a,.feed-btn.desctop,.better-btn i,.show-replay-question,.parskala-faqs > li:before,.see-more-pside,.go-back a,.product_meta .countes,.share-square::before,.order-mobile #nav-order-mobile li a.active,.woocommerce-thankyou-order-received,.checkout-headers ul .nav p,.summary .cart-pro .tab-pro.hovr-tab .fa-share-square,.taxs-single a,#commentform .logged-in-as a:nth-child(2),.dashboard-menu ul .frist-li a,.dashboard-menu ul li a:hover,.item-cat i,.item-cat .promotion-cat,.mini-cart-user .head-mini .cart-mini::after,.mini-cart-user .head-mini .cart-mini',

    'border-color' => '.title-information::before,.left-product,.taxs-single a,.side-line-posts,.side-form-search input:focus,.title-item-index .line-item-index,.side-form-search input:active',
  );
}

// آرایه سلکتورها -> رنگ لینک های قالب
function links_selector(){
  return array(

    'background-color' => '.special_send_box .special_content_box ul li::before,.continer .date-send-order input[type="radio"]:checked:before,.custom_label,.continer .nav-user-dashboard .woocommerce-MyAccount-navigation ul li.is-active::after,.prk-traking-form-submit input[type=submit],.order-delivery-times li input:checked+label b.checkout-deliver-day-itmes::after,.dn-app-mobile a,.product-tab-nav-mobiles ul li.nav-item_mobile.reviews_tab .insert_comment_mobile,.ui-slider .ui-slider-range,.page-promotes:hover::after',

    'color' =>  '.footer-loginbox .copyright-login-footer a.linkp,.term-description a,.col-single1 .des-info .posted_in a,.prk-product-brand.prk-font a,.col-single1 .des-info .tagged_as a,body.product-single .product-more-icon-dates a i.done ,.btns-pro i.btns.done,.main-cont .conts p a,.foot-core .foot-box.text .show-more,.shop_attributes.woocommerce-group-attributes-layout-2 tbody tr th.attribute_group_name i,.content-product.single p a,body .attr_swatch_design_2.thwvsf-label-li.thwvsf-selected .thwvsf-item-span::before,.anchor-link,.order-delivery-times li input:checked+label,.view-product a,.continer .woocommerce .woocommerce-MyAccount-content div.woocommerce-Address header a,.prk-next-shoppingcart-card-grp-btn a.add-to-shopping-cart,.prk-add-to-next-shopping-list,body .woocommerce .continer .content-user .profile-section__more a,.user_welcome .account-details,body.cart_page.empty .page_shoper ul li a,.feed-btn.mobile,.product-tab-nav-mobiles ul li.nav-item_mobile.reviews_tab .view_comment_mobiles,.wc_mobile_nav_tab .open_ws_tab_mobile,.prk-account.active .account-text,.call-page i:hover,.product-card .product-title a:hover,.content_product_view .breadcrumb a,.location-piker .my_location,.des-location,.more_excerpt,.disble_excerpt,.meta-additional .show-mores, .show-less,.rating_and_nummbercomment .comments_number p,.col-single1 .breadcrumb a,.stm-sms-confirm .stm-sms-confirm--retrieve,.stm-reset-pass,.sec-pages a,.better-btn i,.feed-btn.desctop,.show-replay-question,.parskala-faqs > li:before,.see-more-pside,.nav-user-dashboard .woocommerce-MyAccount-navigation ul li:hover::before,.nav-user-dashboard .woocommerce-MyAccount-navigation ul li:hover a,.nav-user-dashboard .woocommerce-MyAccount-navigation ul .is-active a,.nav-user-dashboard .woocommerce-MyAccount-navigation ul .is-active::before,.nav-user-dashboard .woocommerce-MyAccount-navigation ul .is-active a,.woocommerce-tabs .tab-all,.share-square::before,.ui-slider-handle:nth-of-type(1)::before,.ui-slider-handle:nth-of-type(2)::before,.summary .cart-pro .tab-pro .stockon p,.go-back a,.product_meta .countes,.show-more,.timer-pros span,.prs,.taxs-single a,.view-all,.prk-dashboard ul li:hover a,.continer-login .forgat,.footer-login a,.prk-dashboard span a,.taxs-single a',

    'border-color' => '.thwvsf-wrapper-ul .thwvsf-wrapper-item-li.attr_swatch_design_2.thwvsf-selected,body .attr_swatch_design_2.thwvsf-label-li.thwvsf-selected .thwvsf-item-span::before,.date-send-order input[type="radio"]:checked,.continer .woocommerce .woocommerce-MyAccount-content div.woocommerce-Address header a,.prk-next-shoppingcart-card-grp-btn a.add-to-shopping-cart,.ui-slider .ui-slider-handle,.go-back a,.taxs-single a,.left-product',


  );
}

// آرایه سلکتورها -> رنگ متون هدر
function header_text_color(){
  return array(

    'background-color' => '#pencet span',
    'color' =>  '.prk_input_serach::placeholder,.faqs-mobile:before,.account-icon-arrow,.account-text,.account-icon i,.caret-down::before,.cart-btn i,.search-section button i::before,.search-section input',

  );
}

// اضافه کردن استایل سفارشی در هد سایت
function inline_style_prk(){
  $search_bg_color = "";
  $prk_preloader_color = prk_option('prk_preloader_color');
  $prk_preloader_back = prk_option('prk_preloader_back');
  $general_color = prk_option('general_color');
  $footer_color = prk_option('footer_color');
  $general_color2 = prk_option('general_color2');
  $links_color2 = prk_option('general_links');
  $options = get_option( 'prk_option' );
  $faq_img = $options['gradient_faq_color'];
  $faq_gradient = $options['gradient_faq_color'];
  $animated_color = $options['animated_color'];
  $search_bg_color = $options['prk_search_bg_backcolor'];
  ?>

<style media="screen" id="style_prk">

.prk-main-post-item .prk-post-item:hover {
  background: linear-gradient(white, #fff) padding-box, linear-gradient(180deg, <?= $general_color ?> 0, #fff 100%) border-box;

}

#nprogress .spinner{
  border-top-color: <?= $general_color ?>
}
.prk-static-sidebar #mini-cart-apply_coupon,.prk-static-sidebar .btn-mini-cart .woocommerce-mini-cart__buttons a.checkout,
.prk-static-sidebar .shipping-calculator-form button.button,
.slider-home-three-wrapper .swiper-pagination-bullet-active,
.prk-static-sidebar .ext-nodes-wrap #mini-cart-save_note{
  background-color: <?php echo $general_color;?> !important;
}
   <?php

     if ( ! empty( prk_option( 'custom_css' ) ) ) {
       print_r( prk_option( 'custom_css' ) ) . "\n";
   }
 

    ?>
     <?php if ($footer_color):?>
      @media (max-width: 990px) {
        body .main-footer .continer .foot-box.has-menu{
        background: transparent;
        border: 1px solid #fff !important;
      }
      }


    <?php endif;?>
    body #loader{
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding-top: 100px;
      z-index: 99999999
    }
    /* preloader prk */

    .prk-preload-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    #prk-preload-logo {
        margin-bottom: 20px;
    }

                div#prk-preload-gif>div {
                    display: flex!important;
                    justify-content: center;
                }
                #prk-preload-logo img {
                    width: 250px;
                    height: auto;
                }

                #prk-preload-gif img {
                    width: 250px;
                }

                #prk-preload-logo {
                    margin-bottom: 20px;
                }

                .prk-preload-wrap {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }

                .lds-ring, .lds-ring div {
                    box-sizing: border-box;
                }

                .lds-ring {
                    display: flex;
                    justify-content: center;
                    position: relative;
                    width: 80px;
                    height: 80px;
                }

                .lds-ring div {
                    box-sizing: border-box;
                    display: block;
                    position: absolute;
                    width: 50px;
                    height: 50px;
                    margin: 5px;
                    border: 5px solid #000;
                    border-radius: 50%;
                    margin-top: 10px;
                    animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
                    border-color: #d7d7d7 transparent transparent transparent;
                }

                .lds-ring div:nth-child(1) {
                    animation-delay: -0.45s;
                }

                .lds-ring div:nth-child(2) {
                    animation-delay: -0.3s;
                }

                .lds-ring div:nth-child(3) {
                    animation-delay: -0.15s;
                }

                @keyframes lds-ring {
                    0% {
                        transform: rotate(0deg);
                    }

                    100% {
                        transform: rotate(360deg);
                    }
                }

    .lds-ring.2{

    }



  <?php if ($prk_preloader_color): ?>
   body .lds-ring div{
     border: 6px solid <?= $prk_preloader_color?>;
    border-color: <?= $prk_preloader_color?> transparent transparent transparent;
   }
  <?php endif; ?>
  <?php if ($prk_preloader_back): ?>
  body.loaded #loader{
    background: <?= $prk_preloader_back?>
  }
    body #loader{
      background: <?= $prk_preloader_back?>
    }
  <?php endif; ?>
  .sec_progress_wrapper .sec_progress_bar{
    background-color: <?php echo $general_color;?>;
  }
  <?php
  if ( !empty($search_bg_color)  ): ?>
  body .search-section {
      border: none !important
  }

  <?php endif; ?>


  /*general_color*/
  .continer .date-send-order input[type="radio"]:checked:before{
    background: <?php echo $links_color2;?> !important;
  }
  body .top-nav #bor-line{
    background: <?php echo $general_color;?>;
  }
  .prk_mega_menu > li.mega_menu_tree_level.prk-side-tab > .prk-tab-menu-items > ul > li:hover, .prk_mega_menu > li.mega_menu_tree_level.prk-side-tab > .prk-tab-menu-items > ul > li.active{
    border-right:solid 3px  <?php echo $general_color;?>;
  }
  body .prk_mega_menu > li.mega_menu_tree_level > ul > li > ul > li ul li:hover a,body .prk_mega_menu > li.clasic_menu > ul a:hover,body .prk_mega_menu > li.mega_menu_tree_level > ul > li > ul li a:hover,body .prk_mega_menu > li.megamenu_by_tree_level.prk-side-tab > .prk-tab-menu-items > ul > li:hover > a,body  .prk_mega_menu > li.megamenu_by_tree_level.prk-side-tab > .prk-tab-menu-items > ul > li.active > a{
    color: <?php echo $general_color;?>;
  }
  .ask_top_page .form_search_faqpage .input_field:focus,.ask_top_page .form_search_faqpage .input_field:active{
    outline-color: <?php echo $general_color;?>;
  }
  .prk_mega_menu > li.mega_menu_two_level > ul > li > ul li a:hover,.prk_mega_menu > li.mega_menu_tree_level.prk-side-tab > .prk-tab-menu-items > ul > li:hover > a, .prk_mega_menu > li.mega_menu_tree_level.prk-side-tab > .prk-tab-menu-items > ul > li.active > a,body .prk_mega_menu > li.mega_menu_tree_level > ul > li:hover > a,body  .prk_mega_menu > li.mega_menu_tree_level > ul > li.active > a{
    color: <?php echo $general_color;?>;
    border-color: <?php echo $general_color;?>;
  }
  body .prk_mega_menu > li.megamenu_by_tree_level.prk-side-tab > .prk-tab-menu-items > ul > li > ul > li > a::before,body .prk_mega_menu > li.mega_menu_tree_level > ul > li > a::before{
    background: <?php echo $general_color;?>;
  }
  .prk_mega_menu > li.mega_menu_tree_level > ul > li > ul > li > a::before, .prk_mega_menu > li.mega_menu_tree_level.prk-side-tab > .prk-tab-menu-items > ul > li > ul > li > a::before, .prk_mega_menu > li.mega_menu_two_level > ul > li > a::before{
    background: <?php echo $general_color;?>;
  }
  .icon-caret-left-blue::before {
    content: "";
    position: relative;
    top: 0;
    border-style: solid;
    border-width: 9px 0 0 8px;
    border-color: transparent transparent transparent <?php echo $general_color;?>!important;
    transform: rotate(41deg);
    display: block;
}
  body .thwvsf-wrapper-ul .thwvsf-wrapper-item-li.attr_swatch_design_3.thwvsf-selected,body .thwvsf-wrapper-ul .thwvsf-wrapper-item-li.attr_swatch_design_3.thwvsf-selected:hover {
    -webkit-box-shadow: 0 0 0 2px <?php echo $general_color;?>;
    box-shadow: 0 0 0 2px <?php echo $general_color;?>;
    background: <?php echo $general_color;?>!important;
    color: #fff !important;
  }

  .reviw-tabs .commnet-lister::before{
    border-color: transparent transparent transparent <?php echo $general_color;?>!important;
  }
  /* .top-nav .sub-menu:nth-child(2) li:hover a {
    color:<?php echo $general_color;?>
  } */
  .informationproduct_title_tab::before {
    border-color: transparent transparent transparent <?php echo $general_color;?> !important;
  }
  .spinner
  {
    border-top:4px solid <?php echo $general_color;?>!important;
  }
  #top_products_table_compare li::after {
   border-color: transparent transparent <?php echo $general_color;?>!important;
  }
  ::-webkit-scrollbar-thumb {
    background: <?php echo $general_color;?>;
  }
  #top_products_table_compare{
    border-bottom: 2px solid <?php echo $general_color;?>!important;
  }
  /*general_color2*/

  .title-information::before{
    border-color: transparent transparent transparent <?php echo $general_color2;?>!important;
  }

  @keyframes pulse {
  		0% {
  				-moz-box-shadow: 0 0 0 0 <?php echo $animated_color;?>;
  				box-shadow: 0 0 0 0 <?php echo $animated_color;?>
  	 }
  		70% {
  				-moz-box-shadow: 0 0 0 10px rgba(255, 0, 0, 0);
  				box-shadow: 0 0 0 10px rgba(255, 0, 0, 0)
  	 }
  		100% {
  				-moz-box-shadow: 0 0 0 0 rgba(255, 0, 0, 0);
  				box-shadow: 0 0 0 0 rgba(255, 0, 0, 0)
  	 }
  }
   body .widget.woocommerce.widget_layered_nav.woocommerce-widget-layered-nav ul.woocommerce-widget-layered-nav-list{
     display: none;
   }
  </style>
  <?php

}
add_action('wp_head' ,'inline_style_prk');


function add_links_head(){

  wp_enqueue_script( 'jQuery' );

?>

<script src="<?php echo parskala_URI ?>/assets/js/jquery.timezz.js"></script>



<?php if (!prk_option('custom_font') && prk_fonts() == 'IRANSans') : ?>
    <?php if (prk_option('select_numer_count') == 'munen') : ?>
      <link rel="stylesheet" href="<?php echo parskala_URI ?>/fonts/iransans/irsans-config-en.css" type="text/css">
    <?php else : ?>
      <link rel="stylesheet" href="<?php echo parskala_URI ?>/fonts/iransans/irsans-config.css" type="text/css">
    <?php endif; ?>



  <?php elseif (!prk_option('custom_font') && prk_fonts() == 'IRANyekan') : ?>
    <?php if (prk_option('select_numer_count') == 'munen') : ?>
      <link rel="stylesheet" href="<?php echo parskala_URI ?>/fonts/iranyekan/yekan-config-en.css" type="text/css">
    <?php else : ?>
      <link rel="stylesheet" href="<?php echo parskala_URI ?>/fonts/iranyekan/yekan-config.css" type="text/css">
    <?php endif; ?>



  <?php elseif (!prk_option('custom_font') && prk_fonts() == 'IRANyekan_bakh') : ?>

    <?php if (prk_option('select_numer_count') == 'munen') : ?>
      <link rel="stylesheet" href="<?php echo parskala_URI ?>/fonts/iranyekan-bakh/yekan-bahk-config-en.css" type="text/css">
    <?php else : ?>
      <link rel="stylesheet" href="<?php echo parskala_URI ?>/fonts/iranyekan-bakh/yekan-bahk-config-fa.css" type="text/css">
    <?php endif; ?>


  <?php elseif (!prk_option('custom_font') && prk_fonts() == 'dana') : ?>
    <?php if (prk_option('select_numer_count') == 'munen') : ?>
      <link rel="stylesheet" href="<?php echo parskala_URI ?>/fonts/dana/dana-config-en.css" type="text/css">
    <?php else : ?>
      <link rel="stylesheet" href="<?php echo parskala_URI ?>/fonts/dana/dana-config.css" type="text/css">
    <?php endif; ?>


  <?php elseif (!prk_option('custom_font') && prk_fonts() == 'kalemeh') : ?>
    <?php if (prk_option('select_numer_count') == 'munen') : ?>
      <link rel="stylesheet" href="<?php echo parskala_URI ?>/fonts/kalemeh/kalemeh-config.css" type="text/css">
    <?php else : ?>
      <link rel="stylesheet" href="<?php echo parskala_URI ?>/fonts/kalemeh/kalemeh-config.css" type="text/css">
    <?php endif; ?>



  <?php elseif (!prk_option('custom_font')) : ?>

    <link rel="stylesheet" href="<?php echo parskala_URI ?>/fonts/iransans/irsans-config.css" type="text/css">

  <?php endif; ?>

<?php
}
add_action('wp_head', 'add_links_head', 6);

function prk_custom_font() {


    //Custom Font Normal
    $dina_font = '@font-face{font-family:dana;font-display: swap;font-fallback:arial, sans-serif,tahoma;font-weight:400;src:';

    if ( !empty( prk_option( 'theme_font_woff2', 'url' ) ) ) {
        $dina_font .= "url(". prk_option( 'theme_font_woff2', 'url' ) .") format('woff2'),";
    }

    if ( !empty( prk_option( 'theme_font_woff', 'url' ) ) ) {
        $dina_font .= "url(". prk_option( 'theme_font_woff', 'url' ) .") format('woff'),";
    }

    if ( !empty( prk_option( 'theme_font_ttf', 'url' ) ) ) {
        $dina_font .= "url(". prk_option( 'theme_font_ttf', 'url' ) .") format('ttf'),";
    }

    if ( !empty( prk_option( 'theme_font_eot', 'url' ) ) ) {
        $dina_font .= "url(". prk_option( 'theme_font_eot', 'url' ) .") format('eot'),";
    }

    if ( !empty( prk_option( 'theme_font_svg', 'url' ) ) ) {
        $dina_font .= "url(". prk_option( 'theme_font_svg', 'url' ) .") format('svg')";
    }

    $dina_font .= ';}';

    //Custom Font Bold
    $dina_font .= '@font-face{font-family:dana-md;font-display:swap;font-fallback:arial,sans-serif,tahoma;font-weight:500;src:';

    if ( prk_option( 'custom_bold_font' ) && !empty( prk_option( 'theme_font_bold_woff2', 'url' ) ) ) {
        $dina_font .= "url(". prk_option( 'theme_font_bold_woff2', 'url' ) .") format('woff2'),";
    } elseif ( !empty( prk_option( 'theme_font_woff2', 'url' ) ) ) {
        $dina_font .= "url(". prk_option( 'theme_font_woff2', 'url' ) .") format('woff2'),";
    }

    if ( prk_option( 'custom_bold_font' ) && !empty( prk_option( 'theme_font_bold_woff', 'url' ) ) ) {
        $dina_font .= "url(". prk_option( 'theme_font_bold_woff', 'url' ) .") format('woff'),";
    } elseif ( !empty( prk_option( 'theme_font_woff', 'url' ) ) ) {
        $dina_font .= "url(". prk_option( 'theme_font_woff', 'url' ) .") format('woff'),";
    }

    if ( prk_option( 'custom_bold_font' ) && !empty( prk_option( 'theme_font_bold_ttf', 'url' ) ) ) {
        $dina_font .= "url(". prk_option( 'theme_font_bold_ttf', 'url' ) .") format('ttf'),";
    } elseif ( !empty( prk_option( 'theme_font_ttf', 'url' ) ) ) {
        $dina_font .= "url(". prk_option( 'theme_font_ttf', 'url' ) .") format('ttf'),";
    }

    if ( prk_option( 'custom_bold_font' ) && !empty( prk_option( 'theme_font_bold_eot', 'url' ) ) ) {
        $dina_font .= "url(". prk_option( 'theme_font_bold_eot', 'url' ) .") format('eot'),";
    } elseif ( !empty( prk_option( 'theme_font_eot', 'url' ) ) ) {
        $dina_font .= "url(". prk_option( 'theme_font_eot', 'url' ) .") format('eot'),";
    }

    if ( prk_option( 'custom_bold_font' ) && !empty( prk_option( 'theme_font_bold_svg', 'url' ) ) ) {
        $dina_font .= "url(". prk_option( 'theme_font_bold_svg', 'url' ) .") format('svg')";
    } elseif ( !empty( prk_option( 'theme_font_svg', 'url' ) ) ) {
        $dina_font .= "url(". prk_option( 'theme_font_svg', 'url' ) .") format('svg')";
    }

    $dina_font .= ';}';


    $dina_font .= 'body,html{font-family:dana,Arial,sans-serif,tahoma;font-size:15px}';

    //Return Custom Font
    return $dina_font;
}






function prk_select_locations($attr_loc){
  $themeـstyle = prk_option('theme-style');
  $icon_font = 'ri-map-pin-line';

  $attr_loc = shortcode_atts( array(
    'class' => 'select_location',
    'id' => 'location-select',

  ), $attr_loc );

  ?>

<?php
function getUserSelectedCities(){
   $filter_subtitle_btn = prk_option('filter_location_btn_subtitle') ? prk_option('filter_location_btn_subtitle') : 'فیلتر شهر';

     $filter_city = $filter_subtitle_btn;


		if(!isset($_COOKIE['prskalaSearchCity'])) {

			return $filter_city;
		}
		else{
			//$arr=$_COOKIE['prskalaSearchCity'];
			$cities = explode(',', $_COOKIE['prskalaSearchCity']);
            if(sizeof($cities)>1){
                $count=0;
                foreach ($cities as $city){
					$city=intval($city);
                    $children=get_term_children( $city , 'city_categories' );
                    $sizeOfChildren=sizeof($children);
                    if($sizeOfChildren==0)
                        $count+=1;
                    else
                        $count+=$sizeOfChildren;
                }
                return $count." شهر ";
            }
            if(sizeof($cities)==1){
				$term = get_term_by( 'id', intval($cities[0]), 'city_categories');


				if($term)
                	return $term->name;
            }
		}
		return $filter_city;
	}
$location=(getUserSelectedCities());

	?>
  <!-- دکمه انتخاب موقعیت -->
  <div class="location-piker" data-remodal-target="location-piker">

    <i class="<?php echo $icon_font;?> "></i>
    <div class="location_flexed">
      <span class="location_name">
	   <i><?php echo $location;?></i> <em><?php echo prk_option('filter_location_btn_title') ? prk_option('filter_location_btn_title') : 'انتخاب مکان' ;?> </em>
	    </span>
      <span class="my_location"><?php echo $location;?></span>
    </div>

  </div>



  <?php
}

add_shortcode('select_location','prk_select_locations');



// نسخه موبایل دکمه انتخاب مکان
function prk_mob_select_locations(){


  function mob_getUserSelectedCities(){

  		if(!isset($_COOKIE['prskalaSearchCity'])) {

  			return ''.__('Select a location to filter products', 'parskala').'';
  		}
  		else{
  			//$arr=$_COOKIE['prskalaSearchCity'];
  			$cities = explode(',', $_COOKIE['prskalaSearchCity']);
              if(sizeof($cities)>1){
                  $count=0;
                  foreach ($cities as $city){
  					$city=intval($city);
                      $children=get_term_children( $city , 'city_categories' );
                      $sizeOfChildren=sizeof($children);
                      if($sizeOfChildren==0)
                          $count+=1;
                      else
                          $count+=$sizeOfChildren;
                  }
                  return $count.' '.__('Selected city', 'parskala').'';
              }
              if(sizeof($cities)==1){
  				$term = get_term_by( 'id', intval($cities[0]), 'city_categories');


  				if($term)
                  	return ''.__('Your position in', 'parskala').'' . $term->name;
              }
  		}
  		return ''.__('Select a location to filter products', 'parskala').'';
  	}


    $icon_font = 'prk-location';
    $location=(mob_getUserSelectedCities());
  ?>

  <!-- دکمه انتخاب موقعیت -->
  <div class="location-piker_mob" data-remodal-target="location-piker">
    <i class="<?php echo $icon_font;?> icon"></i>
    <span class="location_name"><?= $location;?></span>
    <i class="ri-arrow-left-s-line"></i>
  </div>

  <?php
}

add_shortcode('mob_select_location','prk_mob_select_locations');



// اضافه کردن المان بعد از لود سایت
function add_element_foot(){
  get_template_part('/inc/template/footer/location-picker');
}

add_action('wp_footer', 'add_element_foot',1);

// اضافه کردن اسکریپت سفارشی به فوتر
function add_script_foot(){
  get_template_part('/inc/template/footer/location-picker');
  get_template_part( '/inc/template/footer/includes' );

  ?>
  <script type='text/javascript' id='prk-ajax-jquery-js'>
  /* <![CDATA[ */
  var parskala_values = {"ajax_url":"<?php echo admin_url( 'admin-ajax.php' ); ?>","elementor_editor":"disable"};
  var cart_url = {"ajax_url":"<?php echo get_permalink( wc_get_page_id( 'cart' ) ); ?>","elementor_editor":"disable"};
  var prk_general_color = "<?php echo prk_option('general_color') ?>";
  var ajax_added_text = "<?php echo prk_option('ajax_added_cart_text') ?>";
  var ajax_added_confirm_text = "<?php echo prk_option('ajax_cart_confirm_text') ? prk_option('ajax_cart_confirm_text') : 'سبدخرید' ?>";
  var ajax_added_cancel_text = "<?php echo prk_option('ajax_cart_cancel_text') ? prk_option('ajax_cart_cancel_text') : 'بستن' ?>";
  var prk_popup_go_cart = <?php echo prk_option( 'ajax_added_cart_model' ) == 'modern' ? 'true' : 'false'?>;
  var prk_borline_menu = <?php echo prk_option( 'prk_borline_menu' ) == '1' ? 'true' : 'false'?>;
  var location_allcity_text = "<?php echo prk_option('prk_filter_location_allcity') ? prk_option('prk_filter_location_allcity') : 'همه شهرها' ?>";
  var location_sallcity_text = "<?php echo prk_option('prk_filter_location_sallcity') ? prk_option('prk_filter_location_sallcity') : 'همه شهرهای' ?>";
  var location_selectcity_text = "<?php echo prk_option('prk_filter_location_selectcity') ? prk_option('prk_filter_location_selectcity') : 'حداقل یک شهر را انتخاب کنید' ?>";
  /* ]]> */
  </script>
  <?php

}

add_action('wp_footer', 'add_script_foot',5);


// ajax system
function prk_load_ajax_setting(){


  $is_active = prk_option('wpjsloader_activate') == '1' ? '1' : '0';
  $wpjsloader_logo = prk_option('wpjsloader_logo') == '1' ? '1' : '0';
  $wpjsloader_line = prk_option('wpjsloader_line') == '1' ? '1' : '0';
  $a_tags_exc_classes = get_option('wpjsloadbymdz_clasesexc');
?>

 
  <script type="text/javascript" id="prkjsload-js-settings">
  var wpjsloadbymdz_url = '<?php echo esc_url(home_url()); ?>';
  var wpjsloadbymdz_active = '<?php echo esc_html($is_active); ?>';
  var wpjsloadbymdz_doonscroll = '0';
  var wpjsloadbymdz_loding_line = '<?php echo esc_html($wpjsloader_line); ?>';
  var wpjsloadbymdz_loding_logo = '<?php echo esc_html($wpjsloader_logo); ?>';
  var wpjsloadbymdz_loaderclass = '';
  var wpjsloadbymdz_loadereff = '0';
  var wpjsloadbymdz_onexts = '0';
  var wpjsloadbymdz_exc_class = '<?php echo wp_kses($a_tags_exc_classes, ['"', "'"]); ?>';
  var wpjsloadbymdz_exc_attrs = '';
  var wpjsloadbymdz_exc_parclass = '';
  var wpjsloadbymdz_exc_parattr = '';
  var wpjsloadbymdz_cache = '0';
  var wpjsloadbymdz_cachetime = '30';
  var wpjsloadbymdz_exc_cachepages = '';
  var wpjsloadbymdz_cache_uesrs = '0';
  var wpjsloadbymdz_doncache_q = '0';
  var wpjsloadbymdz_cache_remover = '0';
  var wpjsloadbymdz_user_isin = '1';
  var wpjsloadbymdz_ajaxcache = '0';
  </script>

<?php

}

add_action('wp_head', 'prk_load_ajax_setting',5);



// add_action( 'after_setup_theme', 'prk_auto_refresh_options_on_update', 20 );

// function prk_auto_refresh_options_on_update() {

//     $installed = get_option( 'prk_installed_version' );

//     if ( $installed !== PRK_VERSION ) {

//         // ➤ اینجا عملیات ذخیره/بروزرسانی تنظیمات انجام میشه
//         prk_refresh_theme_options();

//         // ذخیره نسخه فعلی که دیگه تکراری اجرا نشه
//         update_option( 'prk_installed_version', PRK_VERSION );
//     }
// }

// function prk_refresh_theme_options() {
//     $opts = get_option( 'prk_option', [] );

//     // اینجا تغییراتی که باید اعمال بشه رو بنویس
//     // اگر فقط می‌خوای دوباره save بشه:
//     update_option( 'prk_option', $opts );
// }


if ( ! defined( 'PRK_VERSION' ) ) {
    define( 'PRK_VERSION', '3.9.7' );
}

add_action( 'after_setup_theme', 'prk_maybe_upgrade_theme_options_392', 20 );

function prk_maybe_upgrade_theme_options_392() {

    // نسخه‌ای که قبلاً روی سایت بوده و ما ذخیره‌اش کردیم
    $installed_version = get_option( 'prk_installed_version' );

    // اگر هیچ نسخه‌ای ذخیره نشده، یعنی نصب تازه یا قبلش سیستم نسخه نداشتیم.
    // با این حال migration نسخه 3.9.7 بدون دست زدن به مقدارهای ذخیره‌شده اجرا می‌شود.
    if ( ! $installed_version ) {
        prk_run_theme_options_migration_397();
        update_option( 'prk_installed_version', PRK_VERSION );
        return;
    }

    if ( version_compare( $installed_version, PRK_VERSION, '>=' ) ) {
        return;
    }

    if (
        version_compare( $installed_version, '3.9.0', '>=' ) &&
        version_compare( $installed_version, '3.9.2', '<' )
    ) {
        prk_run_theme_options_migration_392();
    }

    if ( version_compare( $installed_version, '3.9.7', '<' ) ) {
        prk_run_theme_options_migration_397();
    }

    update_option( 'prk_installed_version', PRK_VERSION );
}

function prk_run_theme_options_migration_392() {

    $options = get_option( 'prk_option', array() );

    update_option( 'prk_option', $options );
}

function prk_run_theme_options_migration_397() {

    $options = get_option( 'prk_option', array() );

    if ( ! is_array( $options ) ) {
        $options = array();
    }

    // از نسخه 3.9.7 پیش‌بارگذاری باکس فروشنده به‌صورت پیش‌فرض غیرفعال است.
    // اگر کاربر قبلاً خودش این گزینه را ذخیره/فعال کرده باشد، مقدارش حفظ می‌شود.
    if ( ! array_key_exists( 'single_product_seller_preloader', $options ) ) {
        $options['single_product_seller_preloader'] = false;
        update_option( 'prk_option', $options );
    }
}


add_action('after_setup_theme', 'prk_397_disable_single_product_seller_preloader_once', 30);

function prk_397_disable_single_product_seller_preloader_once() {

    $migration_key = 'prk_397_seller_preloader_migrated';

    if (get_option($migration_key)) {
        return;
    }

    $theme_version = wp_get_theme()->get('Version');

    if (version_compare($theme_version, '3.9.7', '<')) {
        return;
    }

    $options = get_option('prk_option');

    if (!is_array($options)) {
        $options = [];
    }

    $options['single_product_seller_preloader'] = false;

    update_option('prk_option', $options);
    update_option($migration_key, time(), false);
}

if (! function_exists('prk_single_product_seller_box_class')) {
    function prk_single_product_seller_box_class() {
        $classes = ['full_whidth', 'ui-box'];

        if (! prk_option('single_product_seller_preloader')) {
            $classes[] = 'prk-seller-preloader-disabled';
        }

        return implode(' ', array_map('sanitize_html_class', $classes));
    }
}

add_filter('prk_ng_guide_url', function () {
    return 'https://parskalas.com/docs/help/document/how/national-guard-parskala-guide/';
});