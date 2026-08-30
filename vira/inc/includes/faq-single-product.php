<?php

// نمایش فقط در دسکتاپ
if (! tablet_cheker() && ! mobile_cheker() ) {
  add_filter('woocommerce_product_tabs', 'parskala_add_tab_faq_single_product');
}


function parskala_add_tab_faq_single_product($tabs) {
    $tabs['parskala-faq'] = array(
        'title'     => __( 'question answer', 'parskala' ),
        'priority'  => 30,
        'callback'  => 'content_parskala_faq'
    );
    return $tabs;
}

function content_parskala_faq() {
    wc_get_template_part('single-product/faq');
}

function parskala_faq_posttype() {

	register_post_type( 'product-faq',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'پرسش ها', 'parskala' ),
				'singular _name' =>  __( 'پرسش', 'parskala' ),

			),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 20,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'show_in_rest' => false,
            'menu_icon' 				=>  'dashicons-format-chat',
            'supports' => array( "title", "editor",'comments',"author" ),
		)
	);
}
add_action( 'init', 'parskala_faq_posttype' );



add_filter( 'add_menu_classes', 'show_pending_number_faq');
function show_pending_number_faq( $menu ) {
    $type = "product-faq";
    $status = "pending";
    $num_posts = wp_count_posts( $type, 'readable' );
    $pending_count = 0;
    if ( !empty($num_posts->$status) )
        $pending_count = $num_posts->$status;

    // build string to match in $menu array
    if ($type == 'post') {
        $menu_str = 'edit.php';
    // support custom post types
    } else {
        $menu_str = 'edit.php?post_type=' . $type;
    }

    // loop through $menu items, find match, add indicator
    foreach( $menu as $menu_key => $menu_data ) {
        if( $menu_str != $menu_data[2] )
            continue;
        $menu[$menu_key][0] .= " <span class='update-plugins count-$pending_count'><span class='plugin-count'>" . number_format_i18n($pending_count) . '</span></span>';
    }
    return $menu;
}

add_action( "wp_ajax_inset_question_product", "inset_question_product" );
add_action( "wp_ajax_nopriv_inset_question_product", "inset_question_product" );
function inset_question_product(){
    $args = array(
        'post_title'    => 'پرسش برای : '.get_the_title($_POST['product_id']). ' | آیدی محصول:  '. $_POST['product_id'],
        'post_type'    => 'product-faq',
        'post_status'  => 'pending',
        'post_parent'  =>$_POST['product_id'],
        'post_content'      => $_POST['content'],
        'post_author'      => get_current_user_id() ? get_current_user_id() : 1,
    );
    $post_id = wp_insert_post( $args );
    if( $post_id )
        _e('پرسش شما درج شده و در انتظار تائید مدیر میباشد.', 'parskala');
    else
        _e('مشکلی پیش آمده است مجددا سعی نمائید.', 'parskala');

    die();
}


add_action( "wp_ajax_inset_replay_question_product", "inset_replay_question_product" );
add_action( "wp_ajax_nopriv_inset_replay_question_product", "inset_replay_question_product" );
function inset_replay_question_product(){

   $user_id =  get_current_user_id() ? get_current_user_id() : 0;

   if( $user_id ) {
        $user_info = get_userdata( $user_id );
        $comment_author = $user_info->display_name;
        $comment_author_email = $user_info->user_email;
   } else {
        $comment_author = __('کاربر مهمان', 'parskala');
        $comment_author_email = '';
   }

    $args = array(
        'comment_post_ID'  => trim($_POST['post_id']),
        'comment_content'      => trim($_POST['content']),
        'comment_author'      => $comment_author,
        'comment_author_email'      => $comment_author_email,
        'user_id'      => $user_id,
    );

    $id = wp_insert_comment($args);
    if( $id ){
        wp_set_comment_status( $id, "hold" );
        echo __('پاسخ شما با موفقیت درج شد و در انتظار تائید میباشد.', 'parskala');
    } else {
        echo __('در هنگام درج پاسخ مشکلی پیش آمده است . مجدد سعی نمائید.', 'parskala');
    }


    die();
}
