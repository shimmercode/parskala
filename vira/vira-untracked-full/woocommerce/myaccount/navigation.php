<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>

<?php
$user = wp_get_current_user();

	$account_banner = prk_option('account_banner');
	$account_banner_url = prk_option('account_banner_url');
	$account_img = prk_option('account_img');
  if(isset($account_img['url']) && $account_img['url'] != '') { $baner_img = $account_img['url']; }

 ?>

	<section class="sec-account">

		<div class="nav-user-dashboard bio">
			<div class="account-avatar">
			<?php if ( $user ):?>
         <img src="<?php echo esc_url( get_avatar_url( $user->ID)); ?>" height="50" width="50"/>
      <?php endif;?>
				</div>
				<div class="account-name">
	       <p class="user-name"><?php global $current_user; wp_get_current_user(); echo $current_user->display_name;?></p>

					 <div class="flexed">
					 <a href="<?php bloginfo('url');?>/my-account/edit-account/"><i class="far fa-edit user-edit"></i></a>
					 <span class="user-email">اطلاعات حساب کاربری</span>
				   </div>
					 
		    </div>
		</div>
<div class="nav-user-dashboard">

<nav class="woocommerce-MyAccount-navigation">
	<ul>
		<div class="profile_menu_head">
         حساب کاربری شما
		</div>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
</div>
	</section>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
