<?php
// setcookie viewed products
function custom_track_product_view() {
    if ( ! is_singular( 'product' ) ) {
        return;
    }
    global $post;
    if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) )
        $viewed_products = array();
    else
        $viewed_products = (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] );
    if ( ! in_array( $post->ID, $viewed_products ) ) {
        $viewed_products[] = $post->ID;
    }
    if ( sizeof( $viewed_products ) > 15 ) {
        array_shift( $viewed_products );
    }
    // Store for session only
    wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
}
add_action( 'template_redirect', 'custom_track_product_view', 20 );

// add castom menu on woocommerce account menu

if ( prk_option('prk_myaccount_notif') ) {
  add_filter ( 'woocommerce_account_menu_items', 'misha_log_history_link', 40 );
}

function misha_log_history_link( $menu_links ){
	$menu_links = array_slice( $menu_links, 0, 5, true )
	+ array(
  'notification' => __( 'اعلانات من', 'parskala' ),
  'comments' => __( 'نظرات', 'parskala' ),
)
	+ array_slice( $menu_links, 5, NULL, true );
	return $menu_links;
}


if ( prk_option('prk_order_tracker') && ('order_tracker_myaccount') ) {
  add_filter ( 'woocommerce_account_menu_items', 'misha_order_history_link', 30 );
}



function misha_order_history_link( $menu_links ){
	$menu_links = array_slice( $menu_links, 0, 5, true )
	+ array(
   'ordertrak' => __( 'Order tracking', 'parskala' ),

)
	+ array_slice( $menu_links, 5, NULL, true );
	return $menu_links;
}



add_action( 'init', 'misha_add_endpoint' );
function misha_add_endpoint() {
	// WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
  add_rewrite_endpoint( 'notification', EP_PAGES );
	add_rewrite_endpoint( 'comments', EP_PAGES );

  if ( prk_option('prk_order_tracker') && ('order_tracker_myaccount') ) {
    add_rewrite_endpoint( 'ordertrak', EP_PAGES );
  }

}



add_action( 'woocommerce_account_notification_endpoint', 'notification_my_account_endpoint_content' );
function notification_my_account_endpoint_content() {
?>
  <div class="sp_Ports">
  	<?php
  		global $post;
      if( isset( $_GET['announcement'] ) ){
        $user_id = get_current_user_id();
        $announcement_id = $_GET['announcement'];
        echo '<div class="announcement_box"><h1 class="title">'.get_post_field( 'post_title', $announcement_id ).'</h1>';
        echo '<div class="content_box"><p>'.do_shortcode( get_post_field('post_content', $announcement_id) ).'</p></div>';
        echo '<div class="date">'.date_i18n("Y-m-d", strtotime( get_post_field( 'post_date', $announcement_id ) )).'</div></div>';
        if(empty( $post_read = get_user_meta($user_id, 'announcements', true) )){
          $post_read = array();
          $post_read[] = $announcement_id;
          update_user_meta($user_id, 'announcements', $post_read);
        }else{
          $post_read = get_user_meta($user_id, 'announcements', true);
          $post_read[] = $announcement_id ;
          update_user_meta($user_id, 'announcements', $post_read);
        }

      } else {
        $args = array(
    			'post_type' => 'notifications',
    			'posts_per_page' => 20,
    		);
    		$loop = new WP_Query( $args );
    		if ( $loop->have_posts() ) {
    		while ( $loop->have_posts() ) : $loop->the_post();
    		$type_vidoe = get_post_meta( $post->ID , 'type_notif', true);
    	?>
      <div class="comments_contienr noti">
      <div class="comment_thumb noti">
      <?php the_post_thumbnail();?>
      </div>
    		<div class="comment_box noti">
    			<div class="notif_box">
            <div class="name_content_product">
    			 <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ) ?>notification/?announcement=<?php echo $post->ID ?>"><?php the_title(); ?></a>
          <div class="date"><?php echo date_i18n("Y-m-d", strtotime( get_post_field( 'post_date' ) )) ?></div>
          </div>
           <?php the_excerpt(15) ?>
    			</div>

    		</div>
        </div>
    	<?php
    		endwhile;
      }else{
        echo '<p class="no_announcement">'.__( 'اعلانی وجود ندارد!', 'parskala' ).'</p>';
      }

      }
  	?>
  </div>

<?php
}
add_action( 'woocommerce_account_comments_endpoint', 'misha_my_account_endpoint_content' );
function misha_my_account_endpoint_content() {
  wc_get_template('myaccount/comments.php');
}

if (prk_option('order_tracker_myaccount')) {
  add_action( 'woocommerce_account_ordertrak_endpoint', 'ordertrak_my_account_endpoint_content' );
}
function ordertrak_my_account_endpoint_content() {

  require_once( get_template_directory() . '/inc/order-track/inc/main-form.php');

}
