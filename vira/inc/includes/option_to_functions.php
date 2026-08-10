<?php

// نبدیل آیدی های تنظیمات به توابع

// نمایش ضمانت محصول
function gust_home_top(){
  if (prk_option('gust_home_top') == 1 ) {
      return prk_option('gust_home_top');
  }else {
    return false;
  }
}

//چک کردن دیوایس موبایل
function mobile_cheker(){

  $checker = new mob_cheker;
  if ($checker->isMobile()) {
    return true;
  }else {
    return false;
  }

}

//چک کردن دیوایس موبایل
function tablet_cheker(){

  $checker = new mob_cheker;
  if ($checker->isTablet()) {
    return true;
  }else {
    return false;
  }

}



// انتخاب تم قالب
function theme_style(){
  if (prk_option('theme-style')  ) {
      return prk_option('theme-style');
  }else {
    return false;
  }
}



// فونت قالب
function prk_fonts(){
  if ( prk_option( 'fonts' ) ) {
      return prk_option( 'fonts' );
  }else {
    return false;
  }
}

// فونت ادمین
function fonts_admin(){
  if ( prk_option( 'fonts_admin' ) ) {
      return prk_option( 'fonts_admin' );
  }else {
    return false;
  }
}

// تنظیمات ارسال
function prk_addressbar_color(){
  if (prk_option('prk_addressbar')  ) {
      return prk_option('prk_addressbar');
  }else {
    return get_bloginfo('name');
  }
}

// نمایش ضمانت محصول
function general_orginal_show(){
  if (prk_option('single_product_bail') == 1 ) {
      return prk_option('single_product_bail');
  }else {
    return false;
  }
}
function checkout_product_full(){
  if (prk_option('checkout_product_full_width') == 1 ) {
      return prk_option('checkout_product_full_width');
  }else {
    return false;
  }
}
// نمایش گارانتی محصول
function general_granty_show(){
  if (prk_option('single_product_Warranty') == 1 ) {
      return prk_option('single_product_Warranty');
  }else {
    return false;
  }
}

// تنظیمات ارسال
function product_send_title(){
  if (prk_option('single_product_send_title')  ) {
      return prk_option('single_product_send_title');
  }else {
    return get_bloginfo('name');
  }
}

// نمایش اطلاعات فروشنده
function product_seller_show(){
  if (prk_option('single_product_seller') == 1 ) {
      return prk_option('single_product_seller');
  }else {
    return false;
  }
}

// توابع تنظیمات فوتر


function prk_footer_type(){
  if (prk_option('footer_type') ) {
      return prk_option('footer_type');
  }else {
    return false;
  }
}

function prk_footer_seen_true(){
  if (prk_option('seen_true') ) {
      return prk_option('seen_true');
  }else {
    return false;
  }
}

function prk_footer_tops(){
  if (prk_option('footer_tops') ) {
      return prk_option('footer_tops');
  }else {
    return false;
  }
}
function prk_footer_tell(){
  if (prk_option('footer_tell') ) {
      return prk_option('footer_tell');
  }else {
    return false;
  }
}

function prk_footer_email(){
  if (prk_option('footer_email') ) {
      return prk_option('footer_email');
  }else {
    return false;
  }
}

function prk_footer_calls(){
  if (prk_option('footer_calls') ) {
      return prk_option('footer_calls');
  }else {
    return false;
  }
}

function prk_about_true(){
  if (prk_option('about_true') ) {
      return prk_option('about_true');
  }else {
    return false;
  }
}

// تنظیم شرایط ارسال کالا
function prk_special_send_box(){
  if (prk_option('special_send_box_true') ) {
      return prk_option('special_send_box_true');
  }else {
    return false;
  }
}
function prk_send_box_text(){
  if (prk_option('general_send_box_text') ) {
      return prk_option('general_send_box_text');
  }else {
    return false;
  }
}
function prk_send_box_url(){
  if (prk_option('general_send_box_url') ) {
      return prk_option('general_send_box_url');
  }else {
    return false;
  }
}
function prk_send_box_group(){
  if (prk_option('special_send_box_product') ) {
      return prk_option('special_send_box_product');
  }else {
    return false;
  }
}


//کد های اینماد بخش فوتر
function prk_enmad_group_box(){
  if (prk_option('enmad_group_box') ) {
      return prk_option('enmad_group_box');
  }else {
    return false;
  }
}
function prk_enmad_true(){
  if (prk_option('enmad_true') ) {
      return prk_option('enmad_true');
  }else {
    return false;
  }
}

function prk_about_title(){
  if (prk_option('about_title') ) {
      return prk_option('about_title');
  }else {
    return false;
  }
}
function prk_about_des(){
  if (prk_option('about_des') ) {
      return prk_option('about_des');
  }else {
    return false;
  }
}

function prk_footer_copyright(){
  if (prk_option('footer_copyright') ) {
      return prk_option('footer_copyright');
  }else {
    return false;
  }
}
function prk_footer_copyright_latin(){
  if (prk_option('footer_copyright_latin') ) {
      return prk_option('footer_copyright_latin');
  }else {
    return false;
  }
}
function prk_checkout_header_hide(){
  if (prk_option('checkout_header_hide') == '1' ) {
      return prk_option('checkout_header_hide');
  }else {
    return false;
  }
}
// ورود عضویت اجباری
function prk_login_before_order(){
  if (prk_option('logined_before_order') == '1' ) {
      return prk_option('logined_before_order');
  }else {
    return false;
  }
}

function prk_caller(){
  if (prk_option('caller_tabs_true') == '1' ) {
      return prk_option('caller_tabs_true');
  }else {
    return false;
  }
}
function prk_caller_repaters(){
  if (prk_option('caller_repaters') ) {
      return prk_option('caller_repaters');
  }else {
    return false;
  }
}

function prk_header(){
  if (prk_option('header_type') ) {
      return prk_option('header_type');
  }else {
    return false;
  }
}

function prk_faq_ajax_add(){
  if (prk_option('prk_faq_ajax_add') == '1' ) {
      return prk_option('prk_faq_ajax_add');
  }else {
    return false;
  }
}

function prk_checkout_footer_hide(){
  if (prk_option('checkout_footer_hide') == '1' ) {
      return prk_option('checkout_footer_hide');
  }else {
    return false;
  }
}

function prk_hider_header_loginform(){
  if (prk_option('hider_header_form') == '1' ) {
      return prk_option('hider_header_form');
  }else {
    return false;
  }
}
function prk_hider_footer_loginform(){
  if (prk_option('hider_footer_form') == '1' ) {
      return prk_option('hider_footer_form');
  }else {
    return false;
  }
}

function prk_gradient_gcolor(){
  $gradient_uploaded = prk_option('gradient_general_color');
  if(isset($gradient_uploaded['background-gradient-direction']) && $gradient_uploaded['background-gradient-direction'] != '') { $prk_gradient = $gradient_uploaded['background-gradient-direction']; }
  if ($prk_gradient ) {

      return $prk_gradient;

  }else {
    return false;
  }
}

// فونت ادمین
function prk_show_related(){
  if ( prk_option( 'show_related' ) ) {
      return prk_option( 'show_related' );
  }else {
    return false;
  }
}

function prk_logo(){

  $prk_logo = get_parent_theme_file_uri('assets/img/logo-web.png' );
  $logo_uploaded = prk_option('logo');

  if(isset($logo_uploaded['url']) && $logo_uploaded['url'] != '') { $prk_logo = $logo_uploaded['url']; }

  $prk_logo = '<img src="' .$prk_logo. '" alt="'.get_bloginfo('name').'" />';

  return $prk_logo;
}

function prk_ajax_loader_logo(){
  $prk_logo = '';
  $logo_uploaded = prk_option('prk_ajax_loader_logo');
  
  if ( !empty( $logo_uploaded['url'] ) ) {
  if(isset($logo_uploaded['url']) && $logo_uploaded['url'] != '') { $prk_logo = $logo_uploaded['url']; }

  $prk_logo = '<img src="' .$prk_logo. '" alt="'.get_bloginfo('name').'" />';

  return $prk_logo;

  }else{
    return prk_logo();
  }
}

function prk_logo_payment_url(){
  $prk_logo = '';
  $logo_uploaded = prk_option('prk_logo_payment_url');
  
  if ( !empty( $logo_uploaded['url'] ) ) {
  if(isset($logo_uploaded['url']) && $logo_uploaded['url'] != '') { $prk_logo = $logo_uploaded['url']; }

  $prk_logo = '<img src="' .$prk_logo. '" alt="'.get_bloginfo('name').'" />';

  return $prk_logo;

  }else{
    return prk_logo();
  }
}

function prk_logo_mobile(){

  $prk_logo = '';
  $logo_uploaded = prk_option('logo_mobile');
  if(isset($logo_uploaded['url']) && $logo_uploaded['url'] != '') { $prk_logo = $logo_uploaded['url']; }
  if ($prk_logo) {
    $prk_logo = '<img src="' .$prk_logo. '" alt="'.get_bloginfo('name').'" />';
  }


  if ( !empty($prk_logo) ) {
    return $prk_logo;
  }
  else {
    return prk_logo();
  }

}

function prk_logo_sms_form_def(){
  $prk_logo = '';
  $logo_uploaded = prk_option('logo_sms_form_def');
  if ( isset($logo_uploaded['url']) && $logo_uploaded['url'] != '' ) {

    
    if(isset($logo_uploaded['url']) && $logo_uploaded['url'] != '') { $prk_logo = $logo_uploaded['url']; }
    if ($prk_logo) {
      $prk_logo = '<img src="' .$prk_logo. '" alt="'.get_bloginfo('name').'" />';
    }
    return $prk_logo;

  }
  else {
    echo prk_logo();
  }

}

function prk_sms_form_style_2(){
  $prk_logo = '';
  $logo_uploaded = prk_option('logo_sms_form_style_2');
  if ( isset($logo_uploaded['url']) && $logo_uploaded['url'] != '' ) {

    
    if(isset($logo_uploaded['url']) && $logo_uploaded['url'] != '') { $prk_logo = $logo_uploaded['url']; }
    if ($prk_logo) {
      $prk_logo = '<img src="' .$prk_logo. '" alt="'.get_bloginfo('name').'" />';
    }
    return $prk_logo;

  }

}


function prk_logo_menu(){

  $prk_logo = '';
  $logo_uploaded = prk_option('logo_menu');

  if(isset($logo_uploaded['url']) && $logo_uploaded['url'] != '') { $prk_logo = $logo_uploaded['url']; }

  if ($prk_logo) {
    $prk_logo = '<img src="' .$prk_logo. '" alt="'.get_bloginfo('name').'" />';
  }

  return $prk_logo;
}


function prk_logo_footer(){

  $prk_logo = '';
  $logo_uploaded = prk_option('footer_logo');
  if(isset($logo_uploaded['url']) && $logo_uploaded['url'] != '') { $prk_logo = $logo_uploaded['url']; }

  $prk_logo = '<img src="' .$prk_logo. '" alt="'.get_bloginfo('name').'" />';

  return $prk_logo;
}

function prk_apps_true(){
  if (prk_option('apps_true') == '1' ) {
      return prk_option('apps_true');
  }else {
    return false;
  }
}


function prk_header_btn_sticky(){
  if (prk_option('header_btn_sticky') == '1' ) {
      return prk_option('header_btn_sticky');
  }else {
    return false;
  }
}

// function faq page
function prk_faq_page(){

  if ( is_page_template('faq-template.php') ) {
    return true;
  }else {
    return false;
  }

}


function prk_app_icon(){

  $prk_logo = '';
  $logo_uploaded = prk_option('apps_pic');
  if(isset($logo_uploaded['url']) && $logo_uploaded['url'] != '') { $prk_logo = $logo_uploaded['url']; }

  $prk_logo = '<img src="' .$prk_logo. '" width="'.$logo_uploaded['width'].'" height="'.$logo_uploaded['height'].'" alt="'.get_bloginfo('name').'" />';

  return $logo_uploaded['url'] ? $prk_logo : '';

}

function prk_apps_text(){
  if (prk_option('apps_text') ) {
      return prk_option('apps_text');
  }else {
    return false;
  }
}
function prk_apps_btn_mob(){
  if (prk_option('apps_btn') ) {
      return prk_option('apps_btn');
  }else {
    return false;
  }
}
function prk_apps_btn_url(){
  if (prk_option('apps_btn_url') ) {
      return prk_option('apps_btn_url');
  }else {
    return false;
  }
}

function prk_preloader(){
  $prk_preloader = '';
  ?>

  <div class="content_loading">
    <div class="loader-wrapper">

        <?php
        
         echo prk_ajax_loader_logo();
         ?>
        <div class="loader-bullets">
            <i class="loader-bullet"></i>
            <i class="loader-bullet"></i>
            <i class="loader-bullet"></i>
            <i class="loader-bullet"></i>
        </div>

    </div>

  </div>

  <?php
  return $prk_preloader;
}
function preloader_prk(){
	?>
	<div class="onliner_main_loading">
	  <?php echo prk_preloader();?>
	</div>
	<?php
}
add_action('wp_footer','preloader_prk',1);


function prk_loading_modern(){
?>
			 <div class="loading">
				<svg class="svg" version="1.1" id="L4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
					<circle fill="#a1a3a8" stroke="none" cx="26" cy="50" r="6">
						<animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.1"></animate>
					</circle>
					<circle fill="#a1a3a8" stroke="none" cx="46" cy="50" r="6">
						<animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.2"></animate>
					</circle>
					<circle fill="#a1a3a8" stroke="none" cx="66" cy="50" r="6">
						<animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.3"></animate>
					</circle>
				</svg>
			</div>
<?php

}