<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */
 $user_info = get_userdata(get_current_user_id());
 $first_name = $user_info->first_name;
 $last_name = $user_info->last_name;
 $user_info = get_userdata(get_current_user_id());
 $email = $user_info->user_email;
 $number_phone = get_user_meta( get_current_user_id(), 'billing_phone', true );
 global $current_user; wp_get_current_user();
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);


$current_user = wp_get_current_user();
/**
 * @example Safe usage:
 * $current_user = wp_get_current_user();
 * if ( ! $current_user->exists() ) {
 *     return;
 * }
 */
$current_user->user_email;
$current_user->user_firstname;
$current_user->user_lastname;
$current_user->display_name;
$user_phone = get_user_meta( get_current_user_id(), 'billing_phone', true );
$current_user_id = get_current_user_id();
 $on_hold_orders = wc_get_orders(array('status' => array('wc-on-hold'), 'customer_id' => $current_user_id));
 $processing_orders = wc_get_orders(array('status' => array('wc-processing'), 'customer_id' => $current_user_id));
 $completed_orders = wc_get_orders(array('status' => array('wc-completed'), 'customer_id' => $current_user_id));
 $pending_orders = wc_get_orders(array('status' => array('wc-pending'), 'customer_id' => $current_user_id));
 $canceled_orders = wc_get_orders(array('status' => array('wc-cancelled'), 'customer_id' => $current_user_id));
echo '<div class="content-user">';
if ( empty($current_user->user_email) || empty($current_user->user_firstname) || empty($current_user->user_lastname) ) {
?>
<div class="user_welcome">
  <p class="logout-user">
      <i class="Icon-Alert-Info-Fill"></i>
      <?php echo $current_user->display_name;?> برای افزایش امنیت حساب کاربری خود و جلوگیری از سوءاستفاده، لطفا هویت خود را تایید کنید

  </p>

  <!-- <span class="my-orders-summary__more profile-section__more">
    <a class="my-orders-link" href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-account' ) ); ?>"><span>اطلاعات کاربری</span>
      <i class="fa fa-chevron-left"></i>
    </a>
  </span> -->
  
</div>
<?php
}
 ?>
 <div class="my-orders-summary profile-section">

   <div class="my-orders-summary__header profile-section__header">

     <div class="my-orders-summary__title profile-section__title">
       <div>


         <p>سفارش&zwnj;های من</p>
       </div>
       <div class="title-border"></div>
     </div>

     <!-- <span class="my-orders-summary__more profile-section__more">
       <a class="my-orders-link" href="<?echo get_bloginfo('url');?>/my-account/orders/"><span>مشاهده همه</span>
         <i class="fa fa-chevron-left"></i>
       </a>
     </span> -->

   </div>

   <div class="my-orders-summary__main">

     <a class="my-orders-summary__status processing" href="<?php echo get_bloginfo('url');?>/my-account/orders/">
       <div class="order-status-icon">
         <img src="<?php echo esc_url(parskala_IMG.'status-processing.svg');?>" alt="order-processing">
       </div>
       <div class="order-status-info">
         <div class="order-status-count"><?= count($processing_orders); ?> سفارش</div>
         <span class="order-status-name">جاری</span>
     </div>
     </a>

     <a class="my-orders-summary__status completed" href="<?php echo get_bloginfo('url');?>/my-account/orders/">
       <div class="order-status-icon">
       <img src="<?php echo esc_url(parskala_IMG.'status-delivered.svg');?>" alt="order-processing">
       </div>
       <div class="order-status-info">
         <div class="order-status-count"><?= count($completed_orders) ?> سفارش</div>
         <span class="order-status-name">تحویل شده</span>
       </div>
     </a>

     <a class="my-orders-summary__status cancelled" href="<?php echo get_bloginfo('url');?>/my-account/orders/">
       <div class="order-status-icon">
         <img src="<?php echo esc_url(parskala_IMG.'status-returned.svg');?>" alt="order-processing">
       </div>
       <div class="order-status-info">
         <div class="order-status-count"><?= count($canceled_orders) ?> سفارش</div>
         <span class="order-status-name">لغو شده</span>
       </div>
     </a>

   </div>

 </div>
<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );
	echo '</div>';

?>
