<?php
/**
 * Product compare with difference highlight.
 *
 * @package Vira
 */

namespace Vira\Modules\Diff_Compare;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'woocommerce_after_shop_loop_item', array( __CLASS__, 'button' ), 20 );
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'button' ), 35 );
		add_action( 'wp_ajax_vira_compare_toggle', array( __CLASS__, 'toggle' ) );
		add_action( 'wp_ajax_nopriv_vira_compare_toggle', array( __CLASS__, 'toggle' ) );
		add_action( 'template_redirect', array( __CLASS__, 'maybe_page' ) );
		add_action( 'wp_footer', array( __CLASS__, 'bar' ) );
	}

	public static function ids() {
		$raw = isset( $_COOKIE['vira_compare'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['vira_compare'] ) ) : '';
		$ids = array_filter( array_map( 'absint', explode( ',', $raw ) ) );
		return array_slice( array_unique( $ids ), 0, 4 );
	}

	public static function button() {
		global $product;
		if ( ! $product ) {
			return;
		}
		echo '<button type="button" class="vira-compare-btn" data-id="' . esc_attr( $product->get_id() ) . '">افزودن به مقایسه</button>';
	}

	public static function toggle() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$id  = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;
		$ids = self::ids();
		if ( in_array( $id, $ids, true ) ) {
			$ids = array_values( array_diff( $ids, array( $id ) ) );
		} else {
			$ids[] = $id;
			$ids   = array_slice( $ids, 0, 4 );
		}
		setcookie( 'vira_compare', implode( ',', $ids ), time() + WEEK_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
		wp_send_json_success( array( 'ids' => $ids, 'count' => count( $ids ) ) );
	}

	public static function bar() {
		$ids = self::ids();
		if ( ! $ids ) {
			return;
		}
		echo '<div class="vira-compare-bar"><a href="' . esc_url( add_query_arg( 'vira_compare', '1', home_url( '/' ) ) ) . '">مقایسه ' . esc_html( count( $ids ) ) . ' کالا</a></div>';
	}

	public static function maybe_page() {
		if ( empty( $_GET['vira_compare'] ) ) {
			return;
		}
		$ids = self::ids();
		status_header( 200 );
		get_header();
		echo '<main class="vira-container vira-compare-page"><h1>مقایسه کالاها</h1>';
		if ( count( $ids ) < 2 ) {
			echo '<p>حداقل دو کالا انتخاب کنید.</p>';
		} else {
			$products = array_filter( array_map( 'wc_get_product', $ids ) );
			$attrs    = array( 'قیمت', 'موجودی', 'وزن', 'امتیاز' );
			echo '<table class="vira-compare-table"><thead><tr><th>ویژگی</th>';
			foreach ( $products as $p ) {
				echo '<th>' . esc_html( $p->get_name() ) . '</th>';
			}
			echo '</tr></thead><tbody>';
			$rows = array();
			foreach ( $products as $p ) {
				$rows['قیمت'][]   = $p->get_price();
				$rows['موجودی'][] = $p->is_in_stock() ? 'موجود' : 'ناموجود';
				$rows['وزن'][]    = $p->get_weight() ? $p->get_weight() : '—';
				$rows['امتیاز'][] = $p->get_average_rating();
			}
			foreach ( $rows as $label => $vals ) {
				$unique = count( array_unique( array_map( 'strval', $vals ) ) ) > 1;
				echo '<tr class="' . ( $unique ? 'diff' : '' ) . '"><th>' . esc_html( $label ) . '</th>';
				foreach ( $vals as $v ) {
					echo '<td>' . esc_html( is_numeric( $v ) && 'قیمت' === $label ? number_format( (float) $v ) : $v ) . '</td>';
				}
				echo '</tr>';
			}
			echo '</tbody></table>';
		}
		echo '</main>';
		get_footer();
		exit;
	}
}
