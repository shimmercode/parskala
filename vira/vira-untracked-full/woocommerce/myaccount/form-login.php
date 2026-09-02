<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.9.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$form_login = prk_option('chose_form_login');


do_action( 'woocommerce_before_customer_login_form' );


if ($form_login == 'sms_form') {
	// فرم ثبت نام اختصاصی پیامکی
	get_template_part('inc/template/login/sms_form');
}
else {
	// فرم ثبت نام پیشفرض ووکامرس
	get_template_part('inc/template/login/default_form');
}

do_action( 'woocommerce_after_customer_login_form' );

?>
