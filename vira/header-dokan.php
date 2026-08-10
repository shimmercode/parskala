<!DOCTYPE html>
<html  dir="rtl" lang="fa-IR" >
   <head>
      <meta charset="<?php bloginfo( 'charset' ); ?>">
      <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"/>
      <title><?php title_meta(); ?></title>
	  <?php

	    wp_head();
		$user_id = get_current_user_id();
		$seller_id = $user_id;
	  ?>
	<link rel="stylesheet" type="text/css" href="<?php echo parskala_URI; ?>/assets/css/prk-dashboard-dokan.css">
	<link type="text/css" rel="stylesheet" href="<?php echo parskala_URI; ?>/assets/css/persianDatepicker-default.css" />
	<script type="text/javascript" src="<?php echo parskala_URI; ?>/assets/js/persianDatepicker.min.js"></script>
</head>
<?php
global $wp;
$body_class = ' prk-dokan-dashboard-page ';
if ( isset( $wp->query_vars['settings'] )) $body_class .= ' prk-dokan-dashboard-settings-page ';

$title_page_dokan = prk_option('title_dash_page_dokan');

// لوگو فروشگاه
$factor_logo = $factor_titler = "";
$logo = get_parent_theme_file_uri('assets/img/logo-web.png' );
$logo_uploaded = prk_option('logo');
if(isset($logo_uploaded['url']) && $logo_uploaded['url'] != '') { $logo = $logo_uploaded['url']; }
$f_logo = prk_option('dash_page_logo');
if(isset($f_logo['url']) && $f_logo['url'] != '') { $factor_logo = $f_logo['url']; }

if ($factor_logo) {
   $img_logo = $factor_logo;
}else {
	 $img_logo = $logo;
}



?>

<body  <?php body_class($body_class); ?>  >

<?php if ( class_exists('Dokan_Pro') && prk_option('dokan_pro_active') ):?>

<header id="prk_sp_header">
     <div class="sp_title_header">
       <h1><?= $title_page_dokan; ?></h1>
      <img src="<?php echo esc_url($img_logo);?>" alt="logo">
     </div>
</header>


    <div class="sp_bottom_header">
     <div class="sp_Contents">
       <div class="sp_icon_humber">
       <a id="icon_menu_bar" href="#">
		   <img src="<?php echo parskala_IMG; ?>icon_humber.svg">
       </a>
       </div>
        <div class="sp_navbar">
          <ul class="sp_List_members">
            <li class="sp_first_list">
              <a href="<?php echo home_url(); ?>"> <?php _e('صفحه اصلی', 'parskala'); ?></a>
            </li>
		 <?php
        global $wp;

        $request = $wp->request;
        $active = explode( '/', $request );

        unset( $active[0] );

        if ( $active ) {
            $active_menu = implode( '/', $active );

            if ( $active_menu == 'new-product' ) {
                $active_menu = 'products';
            }

            if ( get_query_var( 'edit' ) && is_singular( 'product' ) ) {
                $active_menu = 'products';
            }
        } else {
            $active_menu = 'dashboard';
        }


        
		$nav_menus = dokan_get_dashboard_nav();

		$sub_nav_menus = $nav_menus['settings'];

		 foreach( $nav_menus as $key => $value ){

		 //if( $key == 'settings' ) continue;
		 ?>

            <li class="sp_first_list <?php echo $key; ?> <?php if( $active_menu ==  $key) echo 'active'; ?> ">
              <a href="<?php echo $value['url']; ?>"><?php //echo $value['icon']; ?> <?php echo $value['title']; ?></a>
            </li>

		 <?php } ?>

     <li class="sp_first_list <?php echo $key; ?> <?php if( $active_menu ==  $key) echo 'active'; ?> ">
              <a href="<?php echo dokan_get_navigation_url(); ?>/settings/verification/"> تایید هویت</a>
            </li>

          </ul>
        </div>
        
        <div class="sp_navbar">
           <ul class="sp_List_members1">
             <li class="sp_right_product">
                <a href="#"><?php echo get_user_meta( $user_id, 'dokan_store_name', true); ?> <?php _e('خوش آمدید ...', 'parskala'); ?>
                  <i class="fa fa-angle-down" aria-hidden="true"></i>
                </a>
                <div class="sp_Products_list1">
                  <ul class="sp_navbar_dropdown1">

                  <li class="sp_right_product1">
                    امتیاز شما:
                    <?php
                    prk_get_rating_seller($seller_id) ;
                    ?>
                  </li>

                  <a href="<?php echo dokan_get_navigation_url( 'reports' ); ?>">
                  <li>
                    <svg width="20" height="20" enable-background="new 0 0 443.294 443.294" viewBox="0 0 443.29 443.29" xmlns="http://www.w3.org/2000/svg">
                    <path d="m221.65 0c-122.21 0-221.65 99.433-221.65 221.65s99.433 221.65 221.65 221.65 221.65-99.433 221.65-221.65-99.433-221.65-221.65-221.65zm0 415.59c-106.94 0-193.94-87-193.94-193.94s87-193.94 193.94-193.94 193.94 87 193.94 193.94-87 193.94-193.94 193.94z"/>
                    <path d="m235.5 83.118h-27.706v144.26l87.176 87.176 19.589-19.589-79.059-79.059z"/>
                    </svg>
                    داشبورد عملکرد
                  </li>
                  </a>
                  <a href="<?php echo dokan_get_navigation_url( 'settings/store' ); ?>">
                  <li>
                    <svg width="20" height="20" enable-background="new 0 0 513.323 513.323" version="1.1" viewBox="0 0 513.32 513.32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                    		<path d="m256.66 257.32c-135.28 0-245.33 110.06-245.33 245.33 0 5.888 4.779 10.667 10.667 10.667s10.667-4.779 10.667-10.667c0-123.52 100.48-224 224-224s224 100.48 224 224c0 5.888 4.779 10.667 10.667 10.667s10.667-4.779 10.667-10.667c-1e-3 -135.3-110.06-245.33-245.34-245.33z"/>
                    		<path d="m256.66 0c-64.683 0-117.33 52.629-117.33 117.33s52.651 117.33 117.33 117.33 117.33-52.629 117.33-117.33-52.65-117.33-117.33-117.33zm0 213.33c-52.928 0-96-43.072-96-96s43.072-96 96-96 96 43.072 96 96-43.072 96-96 96z"/>
                    </svg>
                    پروفایل شما
                  </li>
                  </a>

                  <a href="<?php echo wp_logout_url( home_url() ); ?>">
                  <li>
                     <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" ratio="1"> <circle fill="none" stroke="#202020" stroke-width="1.1" cx="10" cy="10" r="9"></circle> <line fill="none" stroke="#202020" stroke-width="1.1" x1="4" y1="3.5" x2="16" y2="16.5"></line></svg>
                    خروج
                  </li>
                  </a>
                  </ul>
                </div>
             </li>
             <li>
               <a href="<?php echo dokan_get_navigation_url( 'reviews' ); ?>">
                 <i class="ri-mail-send-line" aria-hidden="true"></i>
               </a>
             </li>
             <li>
              <a href="<?php echo dokan_get_navigation_url( 'announcement' ); ?>">
                 <i class="ri-question-answer-line" aria-hidden="true"></i>
				 <?php

        $args = array(
            'post_type'   => 'dokan_announcement',
            'post_status' => 'publish',
            'orderby'     => 'post_date',
            'order'       => 'DESC',
            'meta_key'    => '_announcement_type',
            'meta_value'  => 'all_seller',
			      'posts_per_page' => -1,
        );

        //$template_notice->add_query_filter();

        $all_seller_posts = new \WP_Query( $args );

        //$template_notice->remove_query_filter();

        //$notices = array_merge( $all_seller_posts->posts, $query->posts );
		    define('ANNOUNCEMENT_COUNT', count($all_seller_posts->posts) );
				 ?>
                 <span class="sp_circle_number"><?php echo ANNOUNCEMENT_COUNT; ?></span>
              </a>
             </li>
           </ul>
        </div>
     </div>
     </div>


<div class="sp_menu_bar">

  <div class="sp_body_menu_bar">
    <div class="sp_top_body_menu_bar">

        <div class="sp_profile_menu">
           <a href="<?php echo dokan_get_navigation_url( 'announcement' ); ?>">پیام ها
             <i class="icon-mail-dg" aria-hidden="true"></i>
              <span class="sp_circle_number"><?php echo ANNOUNCEMENT_COUNT; ?></span>
           </a>
           <a href="<?php echo dokan_get_navigation_url( 'settings/store' ); ?>">پروفایل
             <i class="icon-mail-dg" aria-hidden="true"></i>
           </a>
           <a href="<?php echo wp_logout_url( home_url() ); ?>">خروج
          <i class="ri-logout-circle-r-line" aria-hidden="true"></i>
           </a>
        </div>
    </div>
    <div class="sp_bottom_body_menu_bar">
      <ul>
      <li class="">
        <a href="<?php echo home_url(); ?>">صفحه اصلی</a>
      </li>
<?php
        foreach( $nav_menus as $key => $value ){

        if( $key == 'settings' ) continue;


        ?>

               <li class=" <?php echo $key; ?> <?php if( $active_menu ==  $key) echo 'active'; ?> ">
                 <a href="<?php echo $value['url']; ?>"><?php //echo $value['icon']; ?> <?php echo $value['title']; ?></a>
               </li>

        <?php } ?>
     <li class=" <?php echo $key; ?> <?php if( $active_menu ==  $key) echo 'active'; ?> ">
                 <a href="<?php echo $sub_nav_menus['url']; ?>"><?php //echo $value['icon']; ?> <?php echo $sub_nav_menus['title']; ?></a>
               </li>
      <ul style="padding: 0 2rem; border-right: 1px solid; border-radius: 5px;">
       <?php
               foreach( $sub_nav_menus['submenu'] as $key => $value ){

               if( $key == 'back' ) continue;
               ?>
                     
                      <li class=" <?php echo $key; ?> <?php if( $active_menu ==  $key) echo 'active'; ?> ">
                        <a href="<?php echo $value['url']; ?>"><?php //echo $value['icon']; ?> <?php echo $value['title']; ?></a>
                      </li>

               <?php } ?>
               </ul>
      </ul>
    </div>
  </div>
</div>
<?php endif; ?>
