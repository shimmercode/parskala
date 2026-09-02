<?php
namespace Vira\Modules\Guest_Tracking;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( 'vira-guest-tracking' ) ) {
			return;
		}
		add_shortcode( 'vira_track_order', array( __CLASS__, 'shortcode' ) );
		add_action( 'init', array( __CLASS__, 'ensure_page' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'box' ) );
		add_action( 'woocommerce_process_shop_order_meta', array( __CLASS__, 'save' ) );
		add_action( 'wp_ajax_vira_guest_track_order', array( __CLASS__, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_vira_guest_track_order', array( __CLASS__, 'ajax' ) );
	}

	public static function ajax() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$id  = absint( isset( $_POST['order_id'] ) ? $_POST['order_id'] : 0 );
		$mob = isset( $_POST['mobile'] ) ? preg_replace( '/\D+/', '', wp_unslash( $_POST['mobile'] ) ) : '';
		$order = wc_get_order( $id );
		if ( ! $order ) {
			wp_send_json_error( array( 'message' => 'سفارش یافت نشد.' ) );
		}
		$bill = preg_replace( '/\D+/', '', (string) $order->get_billing_phone() );
		if ( $mob !== $bill ) {
			wp_send_json_error( array( 'message' => 'موبایل با سفارش مطابقت ندارد.' ) );
		}
		$items = array();
		foreach ( $order->get_items() as $item ) {
			$items[] = $item->get_name();
		}
		wp_send_json_success(
			array(
				'status'   => wc_get_order_status_name( $order->get_status() ),
				'total'    => wp_strip_all_tags( $order->get_formatted_order_total() ),
				'items'    => $items,
				'tracking' => $order->get_meta( '_vira_tracking' ),
			)
		);
	}

	public static function box() {
		add_meta_box( 'vira_track', 'کد پیگیری', array( __CLASS__, 'render_box' ), 'shop_order', 'side' );
		add_meta_box( 'vira_track', 'کد پیگیری', array( __CLASS__, 'render_box' ), wc_get_page_screen_id( 'shop-order' ), 'side' );
	}

	public static function render_box( $post ) {
		$order = $post instanceof \WC_Order ? $post : wc_get_order( $post->ID );
		$val   = $order ? $order->get_meta( '_vira_tracking' ) : '';
		echo '<input name="vira_tracking" style="width:100%" value="' . esc_attr( $val ) . '" placeholder="کد مرسوله">';
	}

	public static function save( $order_id ) {
		$order = wc_get_order( $order_id );
		if ( $order && isset( $_POST['vira_tracking'] ) ) {
			$order->update_meta_data( '_vira_tracking', sanitize_text_field( wp_unslash( $_POST['vira_tracking'] ) ) );
			$order->save();
		}
	}

	public static function ensure_page() {
		if ( get_option( 'vira_track_page_id' ) ) {
			return;
		}
		$id = wp_insert_post(
			array(
				'post_title'   => 'پیگیری سفارش',
				'post_name'    => 'order-tracking',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '[vira_track_order]',
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_option( 'vira_track_page_id', $id );
		}
	}

	public static function shortcode() {
		ob_start();
		echo '<form class="vira-guest-track-form">';
		echo '<input type="number" name="order_id" placeholder="شماره سفارش" required>';
		echo '<input type="tel" name="mobile" placeholder="موبایل صورتحساب" required>';
		echo '<button type="submit" class="button">پیگیری</button>';
		echo '<div class="vira-track-result"></div></form>';
		return ob_get_clean();
	}
}
