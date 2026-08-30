<?php
/**
 * Printable tax invoice (HTML).
 *
 * @package Vira
 */

namespace Vira\Modules\Tax_Invoice;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'wp_ajax_vira_print_invoice', array( __CLASS__, 'print_invoice' ) );
		add_action( 'woocommerce_order_details_after_order_table', array( __CLASS__, 'link' ) );
	}

	public static function link( $order ) {
		if ( ! $order ) {
			return;
		}
		$url = wp_nonce_url( admin_url( 'admin-ajax.php?action=vira_print_invoice&order_id=' . $order->get_id() ), 'vira_invoice' );
		echo '<p><a class="button" target="_blank" href="' . esc_url( $url ) . '">چاپ فاکتور</a></p>';
	}

	public static function print_invoice() {
		if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'vira_invoice' ) ) {
			wp_die( 'نشست نامعتبر' );
		}
		$order_id = isset( $_GET['order_id'] ) ? absint( $_GET['order_id'] ) : 0;
		$order    = wc_get_order( $order_id );
		if ( ! $order ) {
			wp_die( 'سفارش یافت نشد' );
		}
		if ( ! current_user_can( 'manage_woocommerce' ) && (int) $order->get_user_id() !== get_current_user_id() ) {
			wp_die( 'دسترسی ندارید' );
		}
		nocache_headers();
		header( 'Content-Type: text/html; charset=utf-8' );
		echo '<!DOCTYPE html><html lang="fa" dir="rtl"><head><meta charset="utf-8"><title>فاکتور ' . esc_html( $order->get_order_number() ) . '</title>';
		echo '<style>body{font-family:Tahoma,sans-serif;padding:24px}table{width:100%;border-collapse:collapse}td,th{border:1px solid #ddd;padding:8px}h1{color:#ef394e}@media print{.noprint{display:none}}</style></head><body>';
		echo '<button class="noprint" onclick="window.print()">چاپ / ذخیره PDF</button>';
		echo '<h1>فاکتور فروش ویرا</h1>';
		echo '<p>شماره: ' . esc_html( $order->get_order_number() ) . ' — تاریخ: ' . esc_html( wc_format_datetime( $order->get_date_created() ) ) . '</p>';
		echo '<p>خریدار: ' . esc_html( $order->get_formatted_billing_full_name() ) . ' — ' . esc_html( $order->get_billing_phone() ) . '</p>';
		echo '<table><thead><tr><th>کالا</th><th>تعداد</th><th>مبلغ</th></tr></thead><tbody>';
		foreach ( $order->get_items() as $item ) {
			echo '<tr><td>' . esc_html( $item->get_name() ) . '</td><td>' . esc_html( $item->get_quantity() ) . '</td><td>' . wp_kses_post( $order->get_formatted_line_subtotal( $item ) ) . '</td></tr>';
		}
		echo '</tbody></table>';
		echo '<p><strong>جمع: ' . wp_kses_post( $order->get_formatted_order_total() ) . '</strong></p>';
		echo '</body></html>';
		exit;
	}
}
