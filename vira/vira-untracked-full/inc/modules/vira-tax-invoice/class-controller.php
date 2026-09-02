<?php
namespace Vira\Modules\Tax_Invoice;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( 'vira-tax-invoice' ) ) {
			return;
		}
		add_action( 'wp_ajax_vira_print_invoice', array( __CLASS__, 'print_html' ) );
		add_action( 'woocommerce_order_details_after_order_table', array( __CLASS__, 'link' ) );
		add_filter( 'woocommerce_my_account_my_orders_actions', array( __CLASS__, 'action' ), 10, 2 );
	}

	public static function action( $actions, $order ) {
		$actions['vira_invoice'] = array(
			'url'  => wp_nonce_url( admin_url( 'admin-ajax.php?action=vira_print_invoice&order_id=' . $order->get_id() ), 'vira_invoice' ),
			'name' => 'چاپ فاکتور',
		);
		return $actions;
	}

	public static function link( $order ) {
		$url = wp_nonce_url( admin_url( 'admin-ajax.php?action=vira_print_invoice&order_id=' . $order->get_id() ), 'vira_invoice' );
		echo '<p><a class="button" target="_blank" href="' . esc_url( $url ) . '">چاپ فاکتور</a></p>';
	}

	public static function print_html() {
		if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'vira_invoice' ) ) {
			wp_die( 'invalid' );
		}
		$order = wc_get_order( isset( $_GET['order_id'] ) ? absint( $_GET['order_id'] ) : 0 );
		if ( ! $order ) {
			wp_die( 'not found' );
		}
		if ( ! current_user_can( 'manage_woocommerce' ) && (int) $order->get_user_id() !== get_current_user_id() ) {
			wp_die( 'forbidden' );
		}
		$econ = get_option( 'vira_seller_economic_code', '' );
		nocache_headers();
		header( 'Content-Type: text/html; charset=utf-8' );
		echo '<!DOCTYPE html><html lang="fa" dir="rtl"><head><meta charset="utf-8"><title>فاکتور ' . esc_html( $order->get_order_number() ) . '</title>';
		echo '<style>
		@page { size: A4; margin: 12mm; }
		body { font-family: Tahoma, "IRANSansX", Vazirmatn, sans-serif; color:#111; }
		h1 { color:#ef394e; }
		table { width:100%; border-collapse:collapse; margin-top:16px; }
		th,td { border:1px solid #ccc; padding:8px; text-align:right; }
		.noprint { margin-bottom:16px; }
		@media print { .noprint { display:none; } body { background:#fff; } }
		</style></head><body>';
		echo '<button class="noprint" onclick="window.print()">چاپ / ذخیره PDF مرورگر</button>';
		echo '<h1>فاکتور فروش ' . esc_html( get_bloginfo( 'name' ) ) . '</h1>';
		echo '<p>شماره: ' . esc_html( $order->get_order_number() ) . ' — تاریخ: ' . esc_html( wc_format_datetime( $order->get_date_created() ) ) . '</p>';
		echo '<p>خریدار: ' . esc_html( $order->get_formatted_billing_full_name() ) . ' — ' . esc_html( $order->get_billing_phone() ) . '</p>';
		echo '<p>وضعیت: ' . esc_html( wc_get_order_status_name( $order->get_status() ) ) . ' — پرداخت: ' . esc_html( $order->get_payment_method_title() ) . '</p>';
		if ( $econ ) {
			echo '<p>کد اقتصادی فروشنده: ' . esc_html( $econ ) . '</p>';
		}
		echo '<table><thead><tr><th>کالا</th><th>تعداد</th><th>مبلغ</th></tr></thead><tbody>';
		foreach ( $order->get_items() as $item ) {
			echo '<tr><td>' . esc_html( $item->get_name() ) . '</td><td>' . esc_html( $item->get_quantity() ) . '</td><td>' . wp_kses_post( $order->get_formatted_line_subtotal( $item ) ) . '</td></tr>';
		}
		echo '</tbody></table>';
		echo '<p>جمع جزء: ' . wp_kses_post( wc_price( $order->get_subtotal() ) ) . '</p>';
		if ( $order->get_discount_total() ) {
			echo '<p>تخفیف: ' . wp_kses_post( wc_price( $order->get_discount_total() ) ) . '</p>';
		}
		if ( $order->get_shipping_total() ) {
			echo '<p>حمل: ' . wp_kses_post( wc_price( $order->get_shipping_total() ) ) . '</p>';
		}
		if ( $order->get_total_tax() ) {
			echo '<p>مالیات: ' . wp_kses_post( wc_price( $order->get_total_tax() ) ) . '</p>';
		}
		echo '<p><strong>جمع: ' . wp_kses_post( $order->get_formatted_order_total() ) . '</strong></p>';
		echo '</body></html>';
		exit;
	}
}
