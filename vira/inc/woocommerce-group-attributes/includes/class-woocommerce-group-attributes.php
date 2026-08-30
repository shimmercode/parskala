<?php
/**
 * Attribute groups (readable reconstruction).
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WooCommerce_Group_Attributes {
	public function __construct() {
		add_action( 'init', array( $this, 'cpt' ) );
		add_action( 'woocommerce_product_additional_information', array( $this, 'display' ), 5 );
	}

	public function run() {
		return $this;
	}

	public function cpt() {
		register_post_type(
			'vira_attr_group',
			array(
				'labels'   => array( 'name' => 'گروه ویژگی' ),
				'public'   => false,
				'show_ui'  => true,
				'supports' => array( 'title' ),
			)
		);
	}

	public function display() {
		global $product;
		if ( ! $product ) {
			return;
		}
		$groups = get_posts( array( 'post_type' => 'vira_attr_group', 'numberposts' => 20 ) );
		if ( ! $groups ) {
			return;
		}
		echo '<div class="vira-attr-groups">';
		foreach ( $groups as $g ) {
			echo '<h4>' . esc_html( $g->post_title ) . '</h4>';
		}
		echo '</div>';
	}
}

add_action(
	'init',
	function () {
		$c = new WooCommerce_Group_Attributes();
		$c->run();
	}
);
