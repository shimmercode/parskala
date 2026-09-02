<?php
/**
 * Ajax product filters on shop.
 *
 * @package Vira
 */

namespace Vira\Modules\Ajax_Filter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'woocommerce_before_shop_loop', array( __CLASS__, 'render_drawer' ), 15 );
		add_action( 'wp_ajax_vira_ajax_filter', array( __CLASS__, 'filter' ) );
		add_action( 'wp_ajax_nopriv_vira_ajax_filter', array( __CLASS__, 'filter' ) );
	}

	public static function render_drawer() {
		if ( ! function_exists( 'is_shop' ) || ( ! is_shop() && ! is_product_taxonomy() ) ) {
			return;
		}
		$cats = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0 ) );
		?>
		<div class="vira-ajax-filter" id="vira-ajax-filter">
			<button type="button" class="vira-filter-toggle js-toggle-filter">فیلتر کالاها</button>
			<form class="vira-filter-form" id="vira-filter-form">
				<?php if ( ! is_wp_error( $cats ) ) : ?>
					<fieldset>
						<legend>دسته‌بندی</legend>
						<?php foreach ( $cats as $cat ) : ?>
							<label><input type="checkbox" name="cats[]" value="<?php echo esc_attr( $cat->term_id ); ?>"> <?php echo esc_html( $cat->name ); ?></label>
						<?php endforeach; ?>
					</fieldset>
				<?php endif; ?>
				<fieldset>
					<legend>بازه قیمت (تومان)</legend>
					<input type="number" name="min_price" placeholder="از" min="0">
					<input type="number" name="max_price" placeholder="تا" min="0">
				</fieldset>
				<fieldset>
					<legend>مرتب‌سازی</legend>
					<select name="orderby">
						<option value="date">جدیدترین</option>
						<option value="popularity">پرفروش</option>
						<option value="price">ارزان‌ترین</option>
						<option value="price-desc">گران‌ترین</option>
					</select>
				</fieldset>
				<button type="submit" class="button">اعمال فیلتر</button>
			</form>
		</div>
		<?php
	}

	public static function filter() {
		if ( ! check_ajax_referer( 'vira_ajax_nonce', 'security', false ) && ! check_ajax_referer( 'vira_pro', 'nonce', false ) ) {
			wp_send_json_error( array( 'message' => 'bad nonce' ), 403 );
		}
		$cats = isset( $_POST['cats'] ) ? array_map( 'absint', (array) $_POST['cats'] ) : array();
		$min  = isset( $_POST['min_price'] ) ? absint( $_POST['min_price'] ) : 0;
		$max  = isset( $_POST['max_price'] ) ? absint( $_POST['max_price'] ) : 0;
		$orderby = isset( $_POST['orderby'] ) ? sanitize_text_field( wp_unslash( $_POST['orderby'] ) ) : 'date';

		$args = array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => 12,
		);
		if ( $cats ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $cats,
			);
		}
		$meta = array();
		if ( $min ) {
			$meta[] = array( 'key' => '_price', 'value' => $min, 'compare' => '>=', 'type' => 'NUMERIC' );
		}
		if ( $max ) {
			$meta[] = array( 'key' => '_price', 'value' => $max, 'compare' => '<=', 'type' => 'NUMERIC' );
		}
		if ( $meta ) {
			$args['meta_query'] = $meta;
		}
		switch ( $orderby ) {
			case 'price':
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = '_price';
				$args['order']    = 'ASC';
				break;
			case 'price-desc':
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = '_price';
				$args['order']    = 'DESC';
				break;
			case 'popularity':
				$args['meta_key'] = 'total_sales';
				$args['orderby']  = 'meta_value_num';
				break;
			default:
				$args['orderby'] = 'date';
		}

		$query = new \WP_Query( $args );
		ob_start();
		if ( $query->have_posts() ) {
			echo '<ul class="products vira-products-grid">';
			while ( $query->have_posts() ) {
				$query->the_post();
				wc_get_template_part( 'content', 'product' );
			}
			echo '</ul>';
			wp_reset_postdata();
		} else {
			echo '<p>کالایی با این فیلتر پیدا نشد.</p>';
		}
		wp_send_json_success( array( 'html' => ob_get_clean() ) );
	}
}
