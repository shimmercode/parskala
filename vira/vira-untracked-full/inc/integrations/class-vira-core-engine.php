<?php
/**
 * Core engine — no Woodmart dependency.
 *
 * @package Vira
 */

namespace Vira\Integrations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Core_Engine_Integration {
	private static $instance = null;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'after_switch_theme', array( $this, 'migrate' ) );
		add_action( 'init', array( $this, 'maybe_migrate' ), 1 );
	}

	public function maybe_migrate() {
		if ( get_option( 'vira_migration_version' ) ) {
			return;
		}
		$this->migrate();
	}

	public function migrate() {
		if ( get_option( 'vira_migration_version' ) ) {
			return;
		}
		update_option( 'vira_free_shipping_threshold', 1500000 );
		update_option( 'vira_sms_gateway', 'kavenegar' );
		update_option( 'vira_migration_version', '1.2.0' );
	}
}

Core_Engine_Integration::get_instance();
