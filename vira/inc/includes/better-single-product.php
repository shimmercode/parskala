<?php
function parskala_better_posttype() {

	register_post_type( 'product-better',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'گزارش قیمت', 'parskala' ),
				'singular_name'       => _x( 'better', 'Post Type Singular Name', 'prk' ),
        'view_item'           => __( 'نمایش گزارشات', 'prk' ),
        'add_new'             => __( 'افزودن جدید', 'prk' ),
        'edit_item'           => __( 'ویرایش گزارش', 'prk' ),
        'update_item'         => __( 'بروز رسانی گزارش', 'prk' ),
        'search_items'        => __( 'جستجو در گزارشات', 'prk' ),
        'not_found'           => __( 'گزارشی یافت نشد', 'prk' ),
        'not_found_in_trash'  => __( 'اوپس چیزی پیدا نشد', 'prk' ),
        'item_published'      =>  __( 'اوپس چیزی پیدا نشد', 'prk' ),


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
						'menu_icon' 				=>  'dashicons-money-alt',
            'show_in_rest' => false,
            'supports' => array( "title"),

		)
	);
}
add_action( 'init', 'parskala_better_posttype' );

add_action( 'gettext', 'change_publish_better', 10, 2 );
function change_publish_better( $translation, $text ) {
 global $post;
if ( get_post_type(get_the_ID()) == 'product-better' && $text == 'Publish' )
    return 'ذخیره به عنوان خوانده شده؟';

return $translation;
}

add_filter('post_updated_messages', 'codex_better_updated_messages');
function codex_better_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['product-better'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('گزارش بروز رسانی شد') ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Book updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Book restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('گزارش به لیست خوانده شده ها اضافه شد') ),
    7 => __('گزارش خوانده شد.'),

  );
  return $messages;
}




add_filter( 'add_menu_classes', 'show_pending_number_better');
function show_pending_number_better( $menu ) {
    $type = "product-better";
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

add_action( "wp_ajax_inset_better_product", "inset_better_product" );
add_action( "wp_ajax_nopriv_inset_better_product", "inset_better_product" );
function inset_better_product(){
    $args = array(
        'post_title'    => 'گزارش قیمت برای : '.get_the_title($_POST['product_id']). ' | آیدی محصول:  '. $_POST['product_id'],
        'post_type'    => 'product-better',
        'post_status'  => 'pending',
        'post_parent'  =>$_POST['product_id'],
        'post_author'      => get_current_user_id() ? get_current_user_id() : 1,
    );
    $post_id = wp_insert_post( $args );
		update_post_meta($post_id, 'shop_price', $_POST['shop_price'] );
		update_post_meta($post_id, 'shop_name', $_POST['shop_name'] );
		update_post_meta($post_id, 'shop_city', $_POST['shop_city'] );
		update_post_meta($post_id, 'website_url', $_POST['website_url'] );
    if( $post_id )
        _e('متشکریم ، گزارش شما برای مدیریت ارسال شد.', 'parskala');
    else
        _e('مشکلی پیش آمده است مجددا سعی نمائید.', 'parskala');

    die();
}
