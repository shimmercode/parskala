<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PRKWOOCFEM_Front_End {
	public function __construct() {
		add_filter( 'woocommerce_checkout_fields', array( $this, 'fields' ) );
		add_action( 'woocommerce_checkout_process', array( $this, 'validate' ) );
		add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'save' ) );
	}

	private function extra() {
		$extra = get_option( 'vira_checkout_extra_fields', array() );
		return is_array( $extra ) ? $extra : array();
	}

	public function fields( $fields ) {
		foreach ( $this->extra() as $f ) {
			if ( empty( $f['enabled'] ) || empty( $f['name'] ) ) {
				continue;
			}
			$key  = 'vira_cf_' . sanitize_key( $f['name'] );
			$type = isset( $f['type'] ) ? $f['type'] : 'text';
			$def  = array(
				'label'       => $f['label'],
				'required'    => ! empty( $f['required'] ),
				'class'       => array( 'form-row-wide' ),
				'placeholder' => isset( $f['placeholder'] ) ? $f['placeholder'] : '',
				'description' => isset( $f['description'] ) ? $f['description'] : '',
				'default'     => isset( $f['default'] ) ? $f['default'] : '',
				'priority'    => isset( $f['order'] ) ? 120 + absint( $f['order'] ) : 120,
			);
			if ( in_array( $type, array( 'select', 'radio' ), true ) ) {
				$opts = array();
				foreach ( explode( ',', isset( $f['options'] ) ? $f['options'] : '' ) as $o ) {
					$o = trim( $o );
					if ( $o !== '' ) {
						$opts[ $o ] = $o;
					}
				}
				$def['type']    = $type;
				$def['options'] = $opts;
			} else {
				$def['type'] = $type;
			}
			$fields['billing'][ $key ] = $def;
		}
		return $fields;
	}

	public function validate() {
		foreach ( $this->extra() as $f ) {
			if ( empty( $f['enabled'] ) || empty( $f['required'] ) ) {
				continue;
			}
			$key = 'vira_cf_' . sanitize_key( $f['name'] );
			if ( empty( $_POST[ $key ] ) ) {
				wc_add_notice( sprintf( 'فیلد «%s» الزامی است.', $f['label'] ), 'error' );
			}
		}
	}

	public function save( $order_id ) {
		foreach ( $this->extra() as $f ) {
			if ( empty( $f['enabled'] ) ) {
				continue;
			}
			$key = 'vira_cf_' . sanitize_key( $f['name'] );
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
