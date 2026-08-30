<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WooCommerce_Group_Attributes {
	public function __construct() {
		add_action( 'init', array( $this, 'cpt' ) );
		add_action( 'add_meta_boxes', array( $this, 'box' ) );
		add_action( 'save_post_vira_attr_group', array( $this, 'save' ) );
		add_action( 'woocommerce_product_additional_information', array( $this, 'display' ), 5 );
	}

	public function run() {
		return $this;
	}

	public function cpt() {
		register_post_type(
			'vira_attr_group',
			array(
				'labels'   => array(
					'name'          => 'گروه ویژگی',
					'singular_name' => 'گروه',
				),
				'public'   => false,
				'show_ui'  => true,
				'supports' => array( 'title' ),
			)
		);
	}

	public function box() {
		add_meta_box( 'vira_ag', 'ویژگی‌های این گروه', array( $this, 'render_box' ), 'vira_attr_group', 'normal' );
	}

	public function render_box( $post ) {
		wp_nonce_field( 'vira_ag', 'vira_ag_nonce' );
		$selected = get_post_meta( $post->ID, '_vira_attrs', true );
		$selected = is_array( $selected ) ? $selected : array();
		$enabled  = get_post_meta( $post->ID, '_vira_ag_enabled', true );
		$order    = get_post_meta( $post->ID, '_vira_ag_order', true );
		$tax      = wc_get_attribute_taxonomies();
		echo '<p><label><input type="checkbox" name="vira_ag_enabled" value="1" ' . checked( $enabled, '1', false ) . '> فعال</label></p>';
		echo '<p>ترتیب <input type="number" name="vira_ag_order" value="' . esc_attr( $order ? $order : 10 ) . '"></p>';
		if ( $tax ) {
			foreach ( $tax as $t ) {
				$slug = 'pa_' . $t->attribute_name;
				echo '<p><label><input type="checkbox" name="vira_attrs[]" value="' . esc_attr( $slug ) . '" ' . checked( in_array( $slug, $selected, true ), true, false ) . '> ' . esc_html( $t->attribute_label ) . '</label></p>';
			}
		} else {
			echo '<p>هنوز ویژگی سراسری ووکامرس تعریف نشده.</p>';
		}
	}

	public function save( $post_id ) {
		if ( ! isset( $_POST['vira_ag_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['vira_ag_nonce'] ) ), 'vira_ag' ) ) {
			return;
		}
		$attrs = isset( $_POST['vira_attrs'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['vira_attrs'] ) ) : array();
		update_post_meta( $post_id, '_vira_attrs', $attrs );
		update_post_meta( $post_id, '_vira_ag_enabled', empty( $_POST['vira_ag_enabled'] ) ? '0' : '1' );
		update_post_meta( $post_id, '_vira_ag_order', isset( $_POST['vira_ag_order'] ) ? absint( $_POST['vira_ag_order'] ) : 10 );
	}

	public function display() {
		global $product;
		if ( ! $product ) {
			return;
		}
		$groups = get_posts(
			array(
				'post_type'      => 'vira_attr_group',
				'posts_per_page' => 20,
				'meta_key'       => '_vira_ag_order',
				'orderby'        => 'meta_value_num',
				'order'          => 'ASC',
			)
		);
		if ( ! $groups ) {
			return;
		}
		echo '<div class="vira-attr-groups">';
		foreach ( $groups as $g ) {
			if ( get_post_meta( $g->ID, '_vira_ag_enabled', true ) === '0' ) {
				continue;
			}
			$attrs = get_post_meta( $g->ID, '_vira_attrs', true );
			if ( ! is_array( $attrs ) ) {
				continue;
			}
			$rows = '';
			foreach ( $attrs as $tax ) {
				$vals = wc_get_product_terms( $product->get_id(), $tax, array( 'fields' => 'names' ) );
				if ( is_wp_error( $vals ) || empty( $vals ) ) {
					continue;
				}
				$rows .= '<li><strong>' . esc_html( wc_attribute_label( $tax ) ) . ':</strong> ' . esc_html( implode( '، ', $vals ) ) . '</li>';
			}
			if ( $rows ) {
				echo '<h4>' . esc_html( $g->post_title ) . '</h4><ul>' . $rows . '</ul>';
			}
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
