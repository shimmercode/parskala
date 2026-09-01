<?php
function parskala_feed_posttype() {

	register_post_type( 'product-feed',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'بازخوردها', 'parskala' ),
				'singular_name'       => _x( 'feed', 'Post Type Singular Name', 'prk' ),
        'view_item'           => __( 'نمایش بازخوردها', 'prk' ),
        'add_new'             => __( 'بازخورد جدید', 'prk' ),
        'edit_item'           => __( 'ویرایش بازخورد', 'prk' ),
        'update_item'         => __( 'بروز رسانی بازخورد', 'prk' ),
        'search_items'        => __( 'جستجو در بازخوردها', 'prk' ),
        'not_found'           => __( 'بازخوردی یافت نشد', 'prk' ),
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
						'menu_icon' 				=>  'dashicons-format-status',
            'show_in_rest' => false,
            'supports' => array( "title", "editor",),

		)
	);
}
add_filter('post_updated_messages', 'codex_book_updated_messages');
add_action( 'gettext', 'change_publish_button', 10, 2 );

function change_publish_button( $translation, $text ) {
 global $post;
if ( get_post_type(get_the_ID()) == 'product-feed' && $text == 'Publish' )
    return 'ذخیره به عنوان خوانده شده؟';

return $translation;
}
function codex_book_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['product-feed'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('بازخورد بروز رسانی شد','parskala') ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Book updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Book restored to revision from %s','parskala'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('بازخورد به لیست خوانده شده ها اضافه شد','parskala') ),
    7 => __('بازخورد خوانده شد.','parskala'),

  );

  return $messages;
}


add_action( 'init', 'parskala_feed_posttype' );



add_filter( 'add_menu_classes', 'show_pending_number_feed');
function show_pending_number_feed( $menu ) {
    $type = "product-feed";
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

add_action( "wp_ajax_inset_feed_product", "inset_feed_product" );
add_action( "wp_ajax_nopriv_inset_feed_product", "inset_feed_product" );
function inset_feed_product(){

    $checkboxes_translate = [
        "product_name" => __('Product name is not correct','parskala'),
        "product_thumb" => __('Product photos are not suitable','parskala'),
        "product_checked" => __('The technical specifications of the product are not correct','parskala'),
        "product_des" => __('Product description is not correct','parskala'),
    ];
    if(!empty($_POST['checkboxes']) and is_array($_POST['checkboxes'])){
        foreach($_POST['checkboxes'] as $key => $check){
            $conentcheckboxes .= ($check == 'true') ? '* '.$checkboxes_translate[$key].PHP_EOL:'';
        }
    }
  
    $args = array(
        'post_title'    =>  __('Feedback for','parskala') .get_the_title($_POST['product_id']).  __('| Product ID:','parskala') . $_POST['product_id'],
        'post_type'    => 'product-feed',
        'post_status'  => 'pending',
        'post_parent'  =>$_POST['product_id'],
        'post_content'      => $_POST['content'].PHP_EOL.$conentcheckboxes,
        'post_author'      => get_current_user_id() ? get_current_user_id() : 1,
    );
    $post_id = wp_insert_post( $args );
    if( $post_id )
        __('Thank you, your feedback has been received', 'parskala');

    else
        __('There is a problem, please try again.', 'parskala');

    die();

}
