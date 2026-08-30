<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PRKWOOCFEM_Front_End {
	public function __construct() {
		add_filter( 'woocommerce_checkout_fields', array( $this, 'fields' ) );
		add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'save' ) );
	}

	public function fields( $fields ) {
		$extra = get_option( 'vira_checkout_extra_fields', array() );
		if ( ! is_array( $extra ) ) {
			return $fields;
		}
		foreach ( $extra as $i => $f ) {
			$key = 'vira_cf_' . $i;
			$fields['billing'][ $key ] = array(
				'label'    => isset( $f['label'] ) ? $f['label'] : $key,
				'required' => ! empty( $f['required'] ),
				'type'     => isset( $f['type'] ) ? $f['type'] : 'text',
				'class'    => array( 'form-row-wide' ),
			);
		}
		return $fields;
	}

	public function save( $order_id ) {
		$extra = get_option( 'vira_checkout_extra_fields', array() );
		if ( ! is_array( $extra ) ) {
			return;
		}
		foreach ( $extra as $i => $f ) {
			$key = 'vira_cf_' . $i;
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $order_id, '_' . $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
			}
		}
	}
}

add_action(
	'init',
	function () {
		new PRKWOOCFEM_Front_End();
	}
);
