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
		add_action( 'wp_ajax_vira_print_invoice', array( __CLASS__, 'pdf' ) );
		add_action( 'woocommerce_order_details_after_order_table', array( __CLASS__, 'link' ) );
		add_filter( 'woocommerce_my_account_my_orders_actions', array( __CLASS__, 'action' ), 10, 2 );
	}

	public static function action( $actions, $order ) {
		$actions['vira_invoice'] = array(
			'url'  => wp_nonce_url( admin_url( 'admin-ajax.php?action=vira_print_invoice&order_id=' . $order->get_id() ), 'vira_invoice' ),
			'name' => 'دانلود فاکتور PDF',
		);
		return $actions;
	}

	public static function link( $order ) {
		$url = wp_nonce_url( admin_url( 'admin-ajax.php?action=vira_print_invoice&order_id=' . $order->get_id() ), 'vira_invoice' );
		echo '<p><a class="button" href="' . esc_url( $url ) . '">دانلود فاکتور PDF</a></p>';
	}

	public static function pdf() {
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
		require_once get_template_directory() . '/inc/class-vira-pdf.php';
		$lines   = array();
		$lines[] = 'Invoice #' . $order->get_order_number();
		$lines[] = 'Date: ' . wc_format_datetime( $order->get_date_created() );
		$lines[] = 'Customer: ' . $order->get_formatted_billing_full_name();
		$lines[] = 'Phone: ' . $order->get_billing_phone();
		$lines[] = 'Status: ' . $order->get_status();
		$lines[] = '---';
		foreach ( $order->get_items() as $item ) {
			$lines[] = $item->get_name() . ' x' . $item->get_quantity() . ' = ' . $item->get_total();
		}
		$lines[] = 'Subtotal: ' . $order->get_subtotal();
		$ship    = $order->get_shipping_total();
		if ( $ship ) {
			$lines[] = 'Shipping: ' . $ship;
		}
		$tax = $order->get_total_tax();
		if ( $tax ) {
			$lines[] = 'Tax: ' . $tax;
		}
		$disc = $order->get_discount_total();
		if ( $disc ) {
			$lines[] = 'Discount: ' . $disc;
		}
		$lines[] = 'Total: ' . $order->get_total() . ' ' . $order->get_currency();
		$econ    = get_option( 'vira_seller_economic_code', '' );
		if ( $econ ) {
			$lines[] = 'Seller economic code: ' . $econ;
		}
		$bin = \Vira_Pdf::from_lines( 'VIRA INVOICE', $lines );
		nocache_headers();
		header( 'Content-Type: application/pdf' );
		header( 'Content-Disposition: attachment; filename="invoice-' . $order->get_order_number() . '.pdf"' );
		echo $bin; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		exit;
	}
}
