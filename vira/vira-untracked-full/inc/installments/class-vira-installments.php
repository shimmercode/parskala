<?php
/**
 * Installment providers — no fake payment.
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface ViraInstallmentProviderInterface {
	public function get_id();
	public function is_available();
	public function get_plans( $amount );
	public function create_payment( $order_id );
	public function verify( $payload );
	public function cancel( $order_id );
	public function refund( $order_id, $amount );
}

abstract class Vira_Installment_Provider implements ViraInstallmentProviderInterface {
	public function get_plans( $amount ) {
		return array();
	}
	public function create_payment( $order_id ) {
		return new WP_Error( 'installment_unconfigured', 'Provider not configured' );
	}
	public function verify( $payload ) {
		return new WP_Error( 'installment_unconfigured', 'Provider not configured' );
	}
	public function cancel( $order_id ) {
		return new WP_Error( 'installment_unconfigured', 'Provider not configured' );
	}
	public function refund( $order_id, $amount ) {
		return new WP_Error( 'installment_unconfigured', 'Provider not configured' );
	}
	protected function key() {
		return trim( (string) get_option( 'vira_installment_api_key', '' ) );
	}
}

class Vira_Installment_SnappPay extends Vira_Installment_Provider {
	public function get_id() {
		return 'snappay';
	}
	public function is_available() {
		return ( 'snappay' === get_option( 'vira_installment_provider', 'snappay' ) && $this->key() !== '' );
	}
}

class Vira_Installment_Tara extends Vira_Installment_Provider {
	public function get_id() {
		return 'tara';
	}
	public function is_available() {
		return ( 'tara' === get_option( 'vira_installment_provider', '' ) && $this->key() !== '' );
	}
}

class Vira_Installment_DigiPay extends Vira_Installment_Provider {
	public function get_id() {
		return 'digipay';
	}
	public function is_available() {
		return ( 'digipay' === get_option( 'vira_installment_provider', '' ) && $this->key() !== '' );
	}
}

class Vira_Installments {
	public static function providers() {
		return array(
			new Vira_Installment_SnappPay(),
			new Vira_Installment_Tara(),
			new Vira_Installment_DigiPay(),
		);
	}
	public static function current() {
		foreach ( self::providers() as $p ) {
			if ( $p->is_available() ) {
				return $p;
			}
		}
		return null;
	}
}
