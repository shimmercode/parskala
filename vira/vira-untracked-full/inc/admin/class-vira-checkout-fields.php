<?php
/**
 * Checkout extra fields admin + persistence.
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vira_Checkout_Fields_Admin {
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'save' ) );
		add_action( 'woocommerce_admin_order_data_after_billing_address', array( __CLASS__, 'admin_order' ) );
		add_action( 'woocommerce_order_details_after_customer_details', array( __CLASS__, 'account_order' ) );
	}

	public static function get_fields() {
		$fields = get_option( 'vira_checkout_extra_fields', array() );
		return is_array( $fields ) ? $fields : array();
	}

	public static function menu() {
		add_submenu_page(
			'vira-admin-dashboard',
			'فیلدهای تسویه',
			'فیلدهای تسویه',
			'manage_options',
			'vira-checkout-fields',
			array( __CLASS__, 'page' )
		);
	}

	public static function save() {
		if ( ! isset( $_POST['vira_cf_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['vira_cf_nonce'] ) ), 'vira_cf_save' ) ) {
			return;
		}
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$rows = isset( $_POST['vira_cf'] ) && is_array( $_POST['vira_cf'] ) ? wp_unslash( $_POST['vira_cf'] ) : array();
		$out  = array();
		foreach ( $rows as $row ) {
			$label = isset( $row['label'] ) ? sanitize_text_field( $row['label'] ) : '';
			if ( $label === '' ) {
				continue;
			}
			$out[] = array(
				'label'       => $label,
				'name'        => isset( $row['name'] ) ? sanitize_key( $row['name'] ) : sanitize_key( $label ),
				'type'        => isset( $row['type'] ) ? sanitize_key( $row['type'] ) : 'text',
				'placeholder' => isset( $row['placeholder'] ) ? sanitize_text_field( $row['placeholder'] ) : '',
				'description' => isset( $row['description'] ) ? sanitize_text_field( $row['description'] ) : '',
				'default'     => isset( $row['default'] ) ? sanitize_text_field( $row['default'] ) : '',
				'options'     => isset( $row['options'] ) ? sanitize_text_field( $row['options'] ) : '',
				'required'    => ! empty( $row['required'] ),
				'enabled'     => ! empty( $row['enabled'] ),
				'order'       => isset( $row['order'] ) ? absint( $row['order'] ) : 10,
			);
		}
		usort(
			$out,
			function ( $a, $b ) {
				return $a['order'] - $b['order'];
			}
		);
		update_option( 'vira_checkout_extra_fields', $out );
		add_settings_error( 'vira_cf', 'saved', 'ذخیره شد.', 'updated' );
	}

	public static function page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		settings_errors( 'vira_cf' );
		$fields = self::get_fields();
		if ( empty( $fields ) ) {
			$fields[] = array(
				'label'       => '',
				'name'        => '',
				'type'        => 'text',
				'placeholder' => '',
				'description' => '',
				'default'     => '',
				'options'     => '',
				'required'    => false,
				'enabled'     => true,
				'order'       => 10,
			);
		}
		echo '<div class="wrap" dir="rtl"><h1>فیلدهای تسویه ویرا</h1>';
		echo '<form method="post">';
		wp_nonce_field( 'vira_cf_save', 'vira_cf_nonce' );
		echo '<table class="widefat"><thead><tr><th>ترتیب</th><th>برچسب</th><th>نام</th><th>نوع</th><th>گزینه‌ها (با ,)</th><th>الزامی</th><th>فعال</th></tr></thead><tbody>';
		foreach ( $fields as $i => $f ) {
			echo '<tr>';
			echo '<td><input type="number" name="vira_cf[' . esc_attr( $i ) . '][order]" value="' . esc_attr( $f['order'] ) . '" style="width:60px"></td>';
			echo '<td><input name="vira_cf[' . esc_attr( $i ) . '][label]" value="' . esc_attr( $f['label'] ) . '"></td>';
			echo '<td><input name="vira_cf[' . esc_attr( $i ) . '][name]" value="' . esc_attr( $f['name'] ) . '"></td>';
			echo '<td><select name="vira_cf[' . esc_attr( $i ) . '][type]">';
			foreach ( array( 'text', 'textarea', 'select', 'checkbox', 'radio' ) as $t ) {
				echo '<option value="' . esc_attr( $t ) . '" ' . selected( $f['type'], $t, false ) . '>' . esc_html( $t ) . '</option>';
			}
			echo '</select></td>';
			echo '<td><input name="vira_cf[' . esc_attr( $i ) . '][options]" value="' . esc_attr( isset( $f['options'] ) ? $f['options'] : '' ) . '"></td>';
			echo '<td><input type="checkbox" name="vira_cf[' . esc_attr( $i ) . '][required]" value="1" ' . checked( ! empty( $f['required'] ), true, false ) . '></td>';
			echo '<td><input type="checkbox" name="vira_cf[' . esc_attr( $i ) . '][enabled]" value="1" ' . checked( ! empty( $f['enabled'] ), true, false ) . '></td>';
			echo '</tr>';
			echo '<tr><td colspan="7">placeholder <input name="vira_cf[' . esc_attr( $i ) . '][placeholder]" value="' . esc_attr( $f['placeholder'] ) . '"> default <input name="vira_cf[' . esc_attr( $i ) . '][default]" value="' . esc_attr( $f['default'] ) . '"> desc <input name="vira_cf[' . esc_attr( $i ) . '][description]" value="' . esc_attr( $f['description'] ) . '"></td></tr>';
		}
		$n = count( $fields );
		echo '<tr><td colspan="7"><strong>ردیف جدید:</strong></td></tr>';
		echo '<tr><td><input type="number" name="vira_cf[' . esc_attr( $n ) . '][order]" value="20" style="width:60px"></td>';
		echo '<td><input name="vira_cf[' . esc_attr( $n ) . '][label]" placeholder="برچسب"></td>';
		echo '<td><input name="vira_cf[' . esc_attr( $n ) . '][name]" placeholder="field_key"></td>';
		echo '<td><select name="vira_cf[' . esc_attr( $n ) . '][type]"><option value="text">text</option><option value="textarea">textarea</option><option value="select">select</option><option value="checkbox">checkbox</option><option value="radio">radio</option></select></td>';
		echo '<td><input name="vira_cf[' . esc_attr( $n ) . '][options]"></td>';
		echo '<td><input type="checkbox" name="vira_cf[' . esc_attr( $n ) . '][required]" value="1"></td>';
		echo '<td><input type="checkbox" name="vira_cf[' . esc_attr( $n ) . '][enabled]" value="1" checked></td></tr>';
		echo '</tbody></table>';
		submit_button( 'ذخیره فیلدها' );
		echo '</form></div>';
	}

	public static function print_saved( $order ) {
		if ( ! $order ) {
			return;
		}
		foreach ( self::get_fields() as $f ) {
			if ( empty( $f['enabled'] ) ) {
				continue;
			}
			$key = 'vira_cf_' . sanitize_key( $f['name'] );
			$val = $order->get_meta( '_' . $key );
			if ( $val === '' || $val === null ) {
				continue;
			}
			echo '<p><strong>' . esc_html( $f['label'] ) . ':</strong> ' . esc_html( $val ) . '</p>';
		}
	}

	public static function admin_order( $order ) {
		self::print_saved( $order );
	}

	public static function account_order( $order ) {
		self::print_saved( $order );
	}
}
