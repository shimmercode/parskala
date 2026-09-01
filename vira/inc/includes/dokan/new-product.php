<?php
add_action( 'init', 'prk_auto_build_taxonomy', 999 );

function prk_auto_build_taxonomy() {

  register_taxonomy('auto_build_tax','product',  array(
    'hierarchical' => true,
	 'label' => 'Auto Build',
		'show_ui' => false,
		'show_in_menu' => false,
		'show_in_nav_menus' => false,
		'show_in_quick_edit' => false,
		'show_in_rest' => false,
		'show_admin_column' => false,
    'query_var' => false,
    'rewrite' => array( 'slug' => 'auto-build' ),
  ));


  if ( term_exists( 'auto-build-term', 'auto_build_tax' ) ) return;
  wp_insert_term(
    'Auto Build',   // the term
    'auto_build_tax', // the taxonomy
    array(
        'slug'        => 'auto-build-term',
    )
);
}



// add_action('template_redirect', 'prk_build_product_for_new_product', 1);
// function prk_build_product_for_new_product(){


// 	$seller_id = get_current_user_id();
// 	$selling   = get_user_meta( $seller_id, 'dokan_enable_selling', true );
// 	if($selling == 'no') return;


// 	global $wp;
//     $request = $wp->request;
// 	if($request != 'dashboard/new-product') return;




// 	$post_id = wp_insert_post(array (
//    'post_type' => 'product',
//    'post_title' => 'بدون عنوان',
//    'post_status' => 'draft',
//    'post_author' => $seller_id,
// 	));


// 	if( ! $post_id ) return;

// 	wp_set_object_terms($post_id,'auto-build-term', 'auto_build_tax' );


// 	/*
// 	update_post_meta($post_id, 'prk_auto_create_post', 'true');

// 	if(! $post__not_in = get_user_meta($seller_id , 'prk_auto_create_post', true) )
// 		$post__not_in = array();

// 	$post__not_in[] = $post_id;
// 	update_user_meta($seller_id , 'prk_auto_create_post' , $post__not_in);
// 	*/

// 	$postdata = array();
// 	do_action( 'dokan_new_product_added', $post_id, $postdata );

// 	$url = dokan_edit_product_url( $post_id );

// 	if ( wp_safe_redirect( $url ) ) exit;
// }


// //add_action('dokan_before_listing_product', 'prk_remove_auto_build_products');
// add_action('dokan_dashboard_before_widgets', 'prk_remove_auto_build_products'); // در پیشخوان
// add_action('dokan_settings_before_form', 'prk_remove_auto_build_products'); // در تنظمیات فروشگاه
// add_action('dokan_order_inside_content', 'prk_remove_auto_build_products'); // در لیست سفارشات
// function prk_remove_auto_build_products(){

// 	$args = array(
// 		'posts_per_page' => -1,
// 		'post_type' => 'product',
// 		'post_status' => 'draft',
// 		'author'         => get_current_user_id(),
// 		'tax_query'      => array(
// 			array(
// 			'taxonomy' => 'auto_build_tax',
// 			'field' => 'slug',
// 			'terms' => 'auto-build-term',
// 			'operator'=> 'IN'
// 			),
// 		),
// 	);

// 	$posts = get_posts($args);

// 	if( empty( $posts ) ) return;

// 	foreach ( $posts as $post )
// 		wp_delete_post( $post->ID, true);



// if ( ! wp_next_scheduled( 'prk_cron_remove_all_auto_build_products' ) ) {
//     wp_schedule_event( time(), 'daily', 'prk_cron_remove_all_auto_build_products' );
// }
// add_action( 'prk_cron_remove_all_auto_build_products', 'prk_remove_all_auto_build_products' );
// function prk_remove_all_auto_build_products() {

// 	$args = array(
// 		'posts_per_page' => -1,
// 		'post_type' => 'product',
// 		'post_status' => 'draft',
// 		'tax_query'      => array(
// 			array(
// 			'taxonomy' => 'auto_build_tax',
// 			'field' => 'slug',
// 			'terms' => 'auto-build-term',
// 			'operator'=> 'IN'
// 			),
// 		),
// 	);

// 	$posts = get_posts($args);

// 	if( empty( $posts ) ) return;

// 	foreach ( $posts as $post )
// 		wp_delete_post( $post->ID, true);
// }


// function projects_custom_number_of_posts($query) {
//     if (!is_admin() || !$query->is_main_query()) return;
//     if ($query->get('post_type') !== 'product') return;

//     $taxquery = (array) $query->get('tax_query');
//     $taxquery[] = [
//         'taxonomy' => 'auto_build_tax',
//         'field'    => 'slug',
//         'terms'    => ['auto-build-term'],
//         'operator' => 'NOT IN',
//     ];
//     $query->set('tax_query', $taxquery);
// }
// add_action('pre_get_posts', 'projects_custom_number_of_posts', 1);





// add_action('dokan_product_updated', function($post_id, $postdata){

// 	wp_remove_object_terms($post_id, 'auto-build-term', 'auto_build_tax');
// 	/*
// 	update_post_meta($post_id, 'prk_auto_create_post', 'false');

// 	$seller_id = get_current_user_id();
// 	$post__not_in = get_user_meta($seller_id , 'prk_auto_create_post', true);
// 	print_r($post__not_in);
// 	$key = array_search($post_id, $post__not_in);
// 	if ($key !== false) {
// 		unset($post__not_in[$key]);
// 	}
// 	update_user_meta($seller_id , 'prk_auto_create_post' , $post__not_in);
// 	*/
// }, 10, 2);






add_action('dokan_product_edit_after_options', 'prk_set_checkbox_set_pending');
function prk_set_checkbox_set_pending($post_id){

	global $post;
	if( $post->post_status == 'draft' ){ ?>

		<div class="dokan-form-group">

            <label class="" for="set-pending">
            <input name="set-pending" value="pending"  id="set-pending" type="checkbox" >
            ارسال برای بازبینی</label>
			<p>در صورتی که مایل هستید محصول را برای بازبینی ارسال کنید حتما این گزینه را تیک بزنید در غیر اینصورت محصول در حالت پیشنویس خواهد بود و بعدا هم میتوانید محصول را ویرایش نمائید</p>
        </div>

	<?php }
}



// add_filter('dokan_update_product_post_data', 'test_test_test');
// function test_test_test($product_data){



// 	if( get_post_status($product_data['ID']) != 'draft'  ){
// 			$product_data['post_status'] = get_post_status($product_data['ID']);
// 			return $product_data;
// 	}



// 	$postdata = wp_unslash( $_POST );

// 	$post_status = isset( $postdata['set-pending'] ) ? 'pending' : 'draft';



// 	$product_data['post_status'] = $post_status;

// 	$user_id = get_current_user_id();
// 	if ( dokan_is_seller_trusted( $user_id ) && isset( $postdata['set-pending'] ) )
// 		$product_data['post_status'] = 'publish';

// 	return $product_data;
// }


// // Ensure brand-new products are visible: remove auto-build term, fix author & slug
// add_action('dokan_new_product_added', function ($product_id, $postdata) {

//     // 1) Remove the auto-build term if it exists
//     wp_remove_object_terms($product_id, 'auto-build-term', 'auto_build_tax');

//     // 2) Ensure product author is the current vendor
//     $author = (int) get_post_field('post_author', $product_id);
//     if (!$author) {
//         wp_update_post([
//             'ID'          => $product_id,
//             'post_author' => get_current_user_id(),
//         ]);
//     }

//     // 3) Ensure a proper slug is generated if missing
//     $post = get_post($product_id);
//     if ($post && empty($post->post_name) && !empty($post->post_title)) {
//         wp_update_post([
//             'ID'        => $product_id,
//             'post_name' => sanitize_title($post->post_title),
//         ]);
//     }
// }, 10, 2);


// add_filter('dokan_pre_product_listing_args', function ($args, $get_data) {
//     if (empty($args['post_status'])) {
//         $args['post_status'] = ['publish', 'pending', 'draft'];
//     }
//     if (!isset($args['tax_query']) || !is_array($args['tax_query'])) {
//         $args['tax_query'] = [];
//     }
//     $args['tax_query'][] = [
//         'taxonomy' => 'auto_build_tax',
//         'field'    => 'slug',
//         'terms'    => 'auto-build-term',
//         'operator' => 'NOT IN'
//     ];
//     return $args;
// }, 20, 2);

// Normalize any new/updated product regardless of Dokan route
add_action('save_post_product', 'prk_normalize_new_product', 10, 3);
function prk_normalize_new_product($post_id, $post, $update) {
    // بی‌خیال اتوسیو/ریویژن
    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) return;

    // ضد لوپ
    static $running = false;
    if ($running) return;
    $running = true;

    $current_user = get_current_user_id();
    if (!$current_user) { $running = false; return; }

    // 1) حذف ترم auto-build اگر مونده
    if (taxonomy_exists('auto_build_tax')) {
        wp_remove_object_terms($post_id, 'auto-build-term', 'auto_build_tax');
    }

    // 2) نویسنده خالی بود، روی فروشنده فعلی ست کن
    if (empty($post->post_author)) {
        wp_update_post([
            'ID'          => $post_id,
            'post_author' => $current_user,
        ]);
    }

    // 3) اگر اسلاگ خالیه، بساز (مشکل "لینک یکتا نمی‌سازه")
    $fresh = get_post($post_id);
    if ($fresh && empty($fresh->post_name)) {
        $base = sanitize_title($fresh->post_title ?: ('product-' . $post_id));
        $slug = wp_unique_post_slug($base, $post_id, $fresh->post_status, $fresh->post_type, $fresh->post_parent);
        wp_update_post([
            'ID'        => $post_id,
            'post_name' => $slug,
        ]);
    }

    $running = false;
}