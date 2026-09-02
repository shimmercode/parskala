<?php
/**
 * Mobile bottom navigation.
 *
 * @package Vira
 */

namespace Vira\Modules\Bottom_Nav;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'wp_footer', array( __CLASS__, 'render' ), 5 );
		add_filter( 'body_class', array( __CLASS__, 'body_class' ) );
	}

	public static function body_class( $classes ) {
		$classes[] = 'has-vira-bottom-nav';
		return $classes;
	}

	public static function render() {
		if ( is_admin() ) {
			return;
		}
		$shop = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
		$acc  = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/' );
		$cart = ( function_exists( 'wc_get_cart_url' ) && function_exists( 'WC' ) && WC() && WC()->cart ) ? wc_get_cart_url() : '#';
		$count = ( function_exists( 'WC' ) && WC() && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
		?>
		<nav class="vira-mobile-bottom-nav" aria-label="<?php esc_attr_e( 'منوی موبایل', 'vira' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-item <?php echo is_front_page() ? 'active' : ''; ?>">
				<span class="nav-ico">⌂</span><span>خانه</span>
			</a>
			<a href="<?php echo esc_url( $shop ); ?>" class="nav-item <?php echo ( function_exists( 'is_shop' ) && is_shop() ) ? 'active' : ''; ?>">
				<span class="nav-ico">⊞</span><span>فروشگاه</span>
			</a>
			<a href="<?php echo esc_url( $cart ); ?>" class="nav-item">
				<span class="nav-ico">bag</span>
				<?php if ( $count ) : ?>
					<span class="cart-badge"><?php echo esc_html( function_exists( 'vira_to_persian_num' ) ? vira_to_persian_num( $count ) : $count ); ?></span>
				<?php endif; ?>
				<span>سبد</span>
			</a>
			<a href="<?php echo esc_url( $acc ); ?>" class="nav-item">
				<span class="nav-ico">☺</span><span>حساب</span>
			</a>
		</nav>
		<?php
	}
}
