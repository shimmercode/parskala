<?php
/**
 * My Account page
 * @package WooCommerce\Templates
 * @version 3.5.0
 */
defined( 'ABSPATH' ) || exit;

/**
 * یک‌بار و ایمن: پردازش redirect_to (اگر داده شده باشد)
 */
$redirect_to = '';
if ( isset($_GET['redirect_to']) ) {
	// sanitize: از wp_unslash + esc_url_raw استفاده می‌کنیم
	$redirect_to = esc_url_raw( wp_unslash( $_GET['redirect_to'] ) );

	// فقط ریدایرکت‌های relative یا هم‌دامنه مجاز
	$home_host = wp_parse_url( home_url(), PHP_URL_HOST );
	$url_host  = wp_parse_url( $redirect_to, PHP_URL_HOST );

	$is_same_host_or_relative = ( empty( $url_host ) || strcasecmp( (string) $url_host, (string) $home_host ) === 0 );

	if ( $redirect_to && $is_same_host_or_relative ) {
		if ( ! headers_sent() ) {
			wp_safe_redirect( $redirect_to );
			exit;
		} else {
			// هدرها ارسال شده؛ fallback جاوااسکریپت
			echo '<script>location.replace(' . wp_json_encode( $redirect_to ) . ');</script>';
		}
	}
}

/**
 * ناوبری اکانت
 * @since 2.6.0
 */
do_action( 'woocommerce_account_navigation' );
?>

<div class="woocommerce-MyAccount-content">
	<?php do_action( 'woocommerce_account_content' ); ?>
</div>

<?php
/**
 * اگر منطق سفارشی شما نیاز دارد پس از لاگین در برخی شرایط
 * ریدایرکت کند، از همان redirect_to پاک‌سازی‌شده استفاده کنید،
 * نه دسترسی مستقیم به $_GET. (و تکرار نکنید—بلوک قبلی کافیست)
 */
if ( function_exists('prk_login_before_order') && prk_login_before_order() && $redirect_to ) {
	if ( ! headers_sent() ) {
		wp_safe_redirect( $redirect_to );
		exit;
	} else {
		echo '<script>location.replace(' . wp_json_encode( $redirect_to ) . ');</script>';
	}
}
