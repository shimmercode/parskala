<?php
/**
 * Vira Pro pack: demo, home sections, ajax shop, swatches, QV, campaign,
 * header presets, Elementor widgets, Plus/points, Persian search, performance.
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vira_Pro {

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ), 25 );
		add_action( 'admin_init', array( __CLASS__, 'save_admin' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'assets' ), 45 );
		add_action( 'wp_ajax_vira_pro_shop', array( __CLASS__, 'ajax_shop' ) );
		add_action( 'wp_ajax_nopriv_vira_pro_shop', array( __CLASS__, 'ajax_shop' ) );
		add_action( 'wp_ajax_vira_pro_qv', array( __CLASS__, 'ajax_qv' ) );
		add_action( 'wp_ajax_nopriv_vira_pro_qv', array( __CLASS__, 'ajax_qv' ) );
		add_action( 'woocommerce_before_shop_loop', array( __CLASS__, 'shop_toolbar' ), 12 );
		add_action( 'woocommerce_after_shop_loop_item', array( __CLASS__, 'loop_swatches_qv' ), 20 );
		add_action( 'add_meta_boxes', array( __CLASS__, 'campaign_box' ) );
		add_action( 'save_post_product', array( __CLASS__, 'save_campaign' ) );
		add_action( 'woocommerce_order_status_completed', array( __CLASS__, 'points_on_order' ) );
		add_filter( 'body_class', array( __CLASS__, 'body_class' ) );
		add_action( 'wp_footer', array( __CLASS__, 'qv_modal' ), 20 );
		add_action( 'elementor/widgets/register', array( __CLASS__, 'elementor' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'persian_search' ) );
		add_filter( 'script_loader_tag', array( __CLASS__, 'defer_theme_js' ), 10, 3 );
		add_action( 'woocommerce_account_dashboard', array( __CLASS__, 'account_plus' ) );
	}

	public static function sections_default() {
		return array(
			'stories'  => 1,
			'hero'     => 1,
			'chips'    => 1,
			'amazing'  => 1,
			'banners'  => 1,
			'cats'     => 1,
			'best'     => 1,
			'new'      => 1,
			'for_you'  => 1,
			'trust'    => 1,
		);
	}

	public static function sections() {
		$s = get_option( 'vira_home_sections', array() );
		return wp_parse_args( is_array( $s ) ? $s : array(), self::sections_default() );
	}

	public static function menu() {
		add_theme_page( 'ویرا پرو', 'ویرا پرو / دمو', 'manage_options', 'vira-pro', array( __CLASS__, 'page' ) );
	}

	public static function save_admin() {
		if ( empty( $_POST['vira_pro_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['vira_pro_nonce'] ) ), 'vira_pro' ) ) {
			return;
		}
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( ! empty( $_POST['vira_home_sections'] ) && is_array( $_POST['vira_home_sections'] ) ) {
			$out = self::sections_default();
			foreach ( $out as $k => $v ) {
				$out[ $k ] = empty( $_POST['vira_home_sections'][ $k ] ) ? 0 : 1;
			}
			update_option( 'vira_home_sections', $out );
		}
		if ( isset( $_POST['vira_header_preset'] ) ) {
			update_option( 'vira_header_preset', sanitize_text_field( wp_unslash( $_POST['vira_header_preset'] ) ) );
		}
		if ( ! empty( $_POST['vira_import_demo'] ) ) {
			self::import_demo();
			add_settings_error( 'vira_pro', 'demo', 'دمو نصب شد. صفحهٔ اصلی را یک‌بار باز کنید.', 'updated' );
		}
	}

	public static function page() {
		$sec    = self::sections();
		$preset = get_option( 'vira_header_preset', 'digikala' );
		settings_errors( 'vira_pro' );
		echo '<div class="wrap"><h1>ویرا پرو</h1><form method="post">';
		wp_nonce_field( 'vira_pro', 'vira_pro_nonce' );
		echo '<h2>۱) سکشن‌های صفحه اصلی</h2><p>هر بخش را روشن/خاموش کنید.</p>';
		$labels = array(
			'stories' => 'استوری',
			'hero'    => 'اسلایدر',
			'chips'   => 'چیپ سرویس',
			'amazing' => 'شگفت‌انگیز',
			'banners' => 'بنرها',
			'cats'    => 'دسته‌بندی',
			'best'    => 'پرفروش',
			'new'     => 'جدیدترین',
			'for_you' => 'منتخب شما',
			'trust'   => 'اعتماد',
		);
		foreach ( $labels as $k => $lab ) {
			echo '<label style="display:inline-block;margin:4px 12px"><input type="checkbox" name="vira_home_sections[' . esc_attr( $k ) . ']" value="1" ' . checked( ! empty( $sec[ $k ] ), true, false ) . '> ' . esc_html( $lab ) . '</label>';
		}
		echo '<h2>۴) هدر بیلدر</h2><select name="vira_header_preset">';
		foreach ( array( 'digikala' => 'دیجی‌کالا (لوگو-جستجو-حساب-سبد)', 'compact' => 'فشرده', 'centered' => 'لوگوی وسط' ) as $id => $l ) {
			echo '<option value="' . esc_attr( $id ) . '" ' . selected( $preset, $id, false ) . '>' . esc_html( $l ) . '</option>';
		}
		echo '</select><p><button class="button button-primary">ذخیره تنظیمات</button></p>';
		echo '<h2>۱) ایمپورت دمو</h2><p>دسته، ۸ محصول نمونه، کمپین شگفت‌انگیز و پیشنهاد چندفروشنده ساخته می‌شود. ووکامرس باید فعال باشد.</p>';
		echo '<p><button class="button button-secondary" name="vira_import_demo" value="1">نصب دمو دیجی‌کالا</button></p>';
		echo '</form><p>ویجت المنتور: «ویرا شگفت‌انگیز / چیپ / استوری» در المنتور → ویرا.</p></div>';
	}

	public static function import_demo() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			add_settings_error( 'vira_pro', 'woo', 'ووکامرس فعال نیست.', 'error' );
			return;
		}
		if ( get_option( 'vira_demo_imported' ) ) {
			add_settings_error( 'vira_pro', 'once', 'دمو قبلاً نصب شده. برای تکرار گزینه vira_demo_imported را از دیتابیس پاک کنید.', 'updated' );
			return;
		}
		$cats = array( 'موبایل', 'کالای دیجیتال', 'خانه و آشپزخانه', 'مد و پوشاک', 'سوپرمارکت' );
		$ids  = array();
		foreach ( $cats as $name ) {
			$t = term_exists( $name, 'product_cat' );
			if ( ! $t ) {
				$t = wp_insert_term( $name, 'product_cat' );
			}
			if ( ! is_wp_error( $t ) ) {
				$ids[] = (int) $t['term_id'];
			}
		}
		$samples = array(
			array( 'گوشی هوشمند ویرا A1', 12990000, 10990000 ),
			array( 'هدفون بی‌سیم ویرا', 2490000, 1890000 ),
			array( 'تلویزیون ۵۵ اینچ', 28900000, 25900000 ),
			array( 'یخچال ساید', 45900000, 0 ),
			array( 'کفش ورزشی', 1890000, 1490000 ),
			array( 'لپ‌تاپ دانشجویی', 32900000, 29900000 ),
			array( 'جارو شارژی', 4200000, 0 ),
			array( 'پک شوینده', 390000, 290000 ),
		);
		foreach ( $samples as $i => $s ) {
			$pid = wp_insert_post(
				array(
					'post_title'  => $s[0],
					'post_status' => 'publish',
					'post_type'   => 'product',
					'post_content'=> 'محصول نمونه دمو ویرا با الگوی دیجی‌کالا.',
				)
			);
			if ( is_wp_error( $pid ) || ! $pid ) {
				continue;
			}
			wp_set_object_terms( $pid, $ids[ $i % max( 1, count( $ids ) ) ], 'product_cat' );
			update_post_meta( $pid, '_regular_price', $s[1] );
			update_post_meta( $pid, '_price', $s[2] ? $s[2] : $s[1] );
			if ( $s[2] ) {
				update_post_meta( $pid, '_sale_price', $s[2] );
				update_post_meta( $pid, '_sale_price_dates_to', time() + 3 * DAY_IN_SECONDS );
				update_post_meta( $pid, '_vira_amazing', '1' );
			}
			update_post_meta( $pid, '_manage_stock', 'yes' );
			update_post_meta( $pid, '_stock', 12 );
			update_post_meta(
				$pid,
				'_vira_dk_offers',
				array(
					array( 'name' => get_bloginfo( 'name' ), 'price' => $s[2] ? $s[2] : $s[1], 'ship' => 'ارسال امروز', 'gar' => 'گارانتی ۱۸ ماهه', 'rate' => '4.7' ),
					array( 'name' => 'فروشگاه همکار', 'price' => ( $s[2] ? $s[2] : $s[1] ) + 50000, 'ship' => 'ارسال ۲ روزه', 'gar' => 'گارانتی اصالت', 'rate' => '4.4' ),
				)
			);
			wp_set_object_terms( $pid, 'simple', 'product_type' );
		}
		update_option( 'vira_demo_imported', 1 );
		update_option( 'show_on_front', 'posts' );
	}

	public static function assets() {
		$uri = get_template_directory_uri();
		$ver = defined( 'VIRA_THEME_VERSION' ) ? VIRA_THEME_VERSION : '1.7.0';
		wp_enqueue_style( 'vira-pro', $uri . '/assets/css/vira-pro.css', array(), $ver );
		wp_enqueue_script( 'vira-pro', $uri . '/assets/js/vira-pro.js', array( 'jquery' ), $ver, true );
		wp_localize_script(
			'vira-pro',
			'viraPro',
			array(
				'ajax'  => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'vira_pro' ),
			)
		);
	}

	public static function body_class( $c ) {
		$c[] = 'vira-hdr-' . sanitize_html_class( get_option( 'vira_header_preset', 'digikala' ) );
		if ( self::user_is_plus() ) {
			$c[] = 'vira-plus-user';
		}
		foreach ( self::sections() as $k => $on ) {
			if ( empty( $on ) ) {
				$c[] = 'vira-hide-' . sanitize_html_class( $k );
			}
		}
		return $c;
	}

	public static function user_is_plus() {
		if ( ! is_user_logged_in() ) {
			return false;
		}
		$until = (int) get_user_meta( get_current_user_id(), 'vira_plus_until', true );
		return $until > time();
	}

	public static function amazing_products() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return array();
		}
		$q = new WP_Query(
			array(
				'post_type'      => 'product',
				'posts_per_page' => 12,
				'meta_key'       => '_vira_amazing',
				'meta_value'     => '1',
			)
		);
		$out = array();
		foreach ( $q->posts as $p ) {
			$pr = wc_get_product( $p );
			if ( $pr ) {
				$out[] = $pr;
			}
		}
		if ( $out ) {
			return $out;
		}
		return class_exists( 'Vira_Digikala_Layer' ) ? Vira_Digikala_Layer::products( array( 'limit' => 10 ) ) : array();
	}

	public static function home() {
		if ( class_exists( 'Vira_Digikala_Layer' ) ) {
			Vira_Digikala_Layer::render_home();
		}
	}

	public static function shop_toolbar() {
		if ( ! function_exists( 'is_shop' ) || ( ! is_shop() && ! is_product_taxonomy() ) ) {
			return;
		}
		echo '<div class="vira-shop-bar" id="viraShopBar">';
		echo '<button type="button" data-ob="popularity">پرفروش</button>';
		echo '<button type="button" data-ob="date">جدید</button>';
		echo '<button type="button" data-ob="price">ارزان</button>';
		echo '<button type="button" data-ob="price-desc">گران</button>';
		echo '<button type="button" id="viraLoadMore">کالاهای بیشتر</button>';
		echo '</div>';
	}

	public static function ajax_shop() {
		check_ajax_referer( 'vira_pro', 'nonce' );
		if ( ! class_exists( 'WooCommerce' ) ) {
			wp_send_json_error();
		}
		$paged = max( 1, (int) ( $_POST['page'] ?? 1 ) );
		$ob    = sanitize_text_field( wp_unslash( $_POST['orderby'] ?? 'date' ) );
		$args  = array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => 12,
			'paged'          => $paged,
		);
		if ( 'price' === $ob || 'price-desc' === $ob ) {
			$args['orderby']  = 'meta_value_num';
			$args['meta_key'] = '_price';
			$args['order']    = 'price' === $ob ? 'ASC' : 'DESC';
		} elseif ( 'popularity' === $ob ) {
			$args['meta_key'] = 'total_sales';
			$args['orderby']  = 'meta_value_num';
		} else {
			$args['orderby'] = 'date';
		}
		$q = new WP_Query( $args );
		ob_start();
		if ( $q->have_posts() ) {
			while ( $q->have_posts() ) {
				$q->the_post();
				wc_get_template_part( 'content', 'product' );
			}
			wp_reset_postdata();
		}
		wp_send_json_success( array( 'html' => ob_get_clean(), 'max' => (int) $q->max_num_pages ) );
	}

	public static function loop_swatches_qv() {
		global $product;
		if ( ! $product ) {
			return;
		}
		echo '<button type="button" class="vira-qv" data-id="' . esc_attr( $product->get_id() ) . '">نمایش سریع</button>';
		if ( $product->is_type( 'variable' ) ) {
			$attrs = $product->get_variation_attributes();
			foreach ( $attrs as $name => $opts ) {
				if ( false === stripos( $name, 'color' ) && false === stripos( $name, 'رنگ' ) ) {
					continue;
				}
				echo '<span class="vira-swatches">';
				foreach ( array_slice( (array) $opts, 0, 6 ) as $o ) {
					echo '<i title="' . esc_attr( $o ) . '"></i>';
				}
				echo '</span>';
			}
		}
	}

	public static function ajax_qv() {
		check_ajax_referer( 'vira_pro', 'nonce' );
		$id = absint( $_POST['id'] ?? 0 );
		$p  = $id ? wc_get_product( $id ) : null;
		if ( ! $p ) {
			wp_send_json_error();
		}
		$html  = '<div class="vira-qv-in">';
		$html .= $p->get_image( 'medium' );
		$html .= '<h3>' . esc_html( $p->get_name() ) . '</h3>';
		$html .= '<div>' . $p->get_price_html() . '</div>';
		$html .= '<p>' . wp_kses_post( wp_trim_words( $p->get_short_description() ?: $p->get_description(), 40 ) ) . '</p>';
		$html .= '<a class="button" href="' . esc_url( $p->get_permalink() ) . '">مشاهده محصول</a></div>';
		wp_send_json_success( array( 'html' => $html ) );
	}

	public static function qv_modal() {
		echo '<div id="viraQv" class="vira-qv-modal" hidden><button type="button" class="vira-qv-x">×</button><div class="vira-qv-body"></div></div>';
	}

	public static function campaign_box() {
		add_meta_box(
			'vira_amazing',
			'کمپین شگفت‌انگیز',
			function ( $post ) {
				wp_nonce_field( 'vira_am', 'vira_am_nonce' );
				$on = get_post_meta( $post->ID, '_vira_amazing', true );
				echo '<label><input type="checkbox" name="vira_amazing" value="1" ' . checked( $on, '1', false ) . '> نمایش در شگفت‌انگیز</label>';
			},
			'product',
			'side'
		);
	}

	public static function save_campaign( $id ) {
		if ( empty( $_POST['vira_am_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['vira_am_nonce'] ) ), 'vira_am' ) ) {
			return;
		}
		update_post_meta( $id, '_vira_amazing', empty( $_POST['vira_amazing'] ) ? '' : '1' );
	}

	public static function account_plus() {
		$uid = get_current_user_id();
		$pts = (int) get_user_meta( $uid, 'vira_points', true );
		echo '<div class="dk-sec"><h2>باشگاه ویرا پلاس</h2><p>امتیاز شما: <b>' . (int) $pts . '</b></p>';
		if ( self::user_is_plus() ) {
			echo '<p>عضویت پلاس فعال است.</p>';
		} else {
			echo '<p>برای پلاس، متای کاربر <code>vira_plus_until</code> را روی timestamp آینده بگذارید یا از دمو استفاده کنید.</p>';
		}
		echo '</div>';
	}

	public static function points_on_order( $order_id ) {
		$order = wc_get_order( $order_id );
		if ( ! $order || ! $order->get_user_id() ) {
			return;
		}
		$pts = (int) get_user_meta( $order->get_user_id(), 'vira_points', true );
		$add = max( 1, (int) ( $order->get_total() / 10000 ) );
		update_user_meta( $order->get_user_id(), 'vira_points', $pts + $add );
	}

	public static function persian_search( $q ) {
		if ( is_admin() || ! $q->is_search() ) {
			return;
		}
		$s = (string) $q->get( 's' );
		if ( '' === $s ) {
			return;
		}
		$map = array( 'ي' => 'ی', 'ك' => 'ک', 'ة' => 'ه', '‌' => ' ' );
		$q->set( 's', strtr( $s, $map ) );
	}

	public static function defer_theme_js( $tag, $handle, $src ) {
		if ( is_admin() ) {
			return $tag;
		}
		if ( in_array( $handle, array( 'vira-dk', 'vira-pro', 'prk-custom' ), true ) && false === strpos( $tag, 'defer' ) ) {
			return str_replace( ' src', ' defer src', $tag );
		}
		return $tag;
	}

	public static function elementor( $widgets_manager ) {
		if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
			return;
		}
		require_once __DIR__ . '/elementor-widgets.php';
		if ( class_exists( '\Vira_Elementor_Amazing' ) ) {
			$widgets_manager->register( new \Vira_Elementor_Amazing() );
			$widgets_manager->register( new \Vira_Elementor_Chips() );
		}
	}
}

Vira_Pro::init();
