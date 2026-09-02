<?php
/**
 * Vira creative pack — 20 live features, Woo-native, no Dokan.
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vira_Creative {

	public static function init() {
		if ( function_exists( 'vira_is_module_enabled' ) && ! vira_is_module_enabled( 'vira-creative-pack', true ) ) {
			return;
		}
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'assets' ), 46 );
		add_action( 'add_meta_boxes', array( __CLASS__, 'product_box' ) );
		add_action( 'save_post_product', array( __CLASS__, 'save_product' ) );
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'product_ui' ), 26 );
		add_action( 'woocommerce_after_single_product_summary', array( __CLASS__, 'after_product' ), 8 );
		add_action( 'woocommerce_after_add_to_cart_form', array( __CLASS__, 'oos_ui' ), 8 );
		add_action( 'woocommerce_checkout_after_customer_details', array( __CLASS__, 'checkout_fields' ) );
		add_action( 'woocommerce_checkout_update_order_meta', array( __CLASS__, 'save_checkout' ) );
		add_action( 'woocommerce_checkout_update_order_review', array( __CLASS__, 'review_wallet' ) );
		add_action( 'woocommerce_admin_order_data_after_billing_address', array( __CLASS__, 'admin_order_meta' ) );
		add_action( 'woocommerce_order_status_completed', array( __CLASS__, 'on_completed' ) );
		add_action( 'woocommerce_account_dashboard', array( __CLASS__, 'account' ), 6 );
		add_action( 'woocommerce_thankyou', array( __CLASS__, 'thankyou' ), 8 );
		add_action( 'template_redirect', array( __CLASS__, 'downloads_and_restore' ) );
		add_action( 'admin_init', array( __CLASS__, 'print_label' ) );
		add_action( 'init', array( __CLASS__, 'register_status' ) );
		add_filter( 'wc_order_statuses', array( __CLASS__, 'list_status' ) );
		add_action( 'woocommerce_cart_calculate_fees', array( __CLASS__, 'wallet_fee' ) );
		add_action( 'woocommerce_checkout_order_processed', array( __CLASS__, 'wallet_deduct' ) );
		add_action( 'woocommerce_product_object_updated_props', array( __CLASS__, 'stock_changed' ), 10, 2 );
		add_action( 'wp_footer', array( __CLASS__, 'seasonal_home' ), 5 );
		add_action( 'init', array( __CLASS__, 'capture_ref' ) );
		add_action( 'user_register', array( __CLASS__, 'ref_on_register' ) );
		add_filter( 'woocommerce_email_order_meta_fields', array( __CLASS__, 'email_meta' ), 10, 3 );

		add_action( 'wp_ajax_vira_waitlist', array( __CLASS__, 'ajax_waitlist' ) );
		add_action( 'wp_ajax_nopriv_vira_waitlist', array( __CLASS__, 'ajax_waitlist' ) );
		add_action( 'wp_ajax_vira_qa_ask', array( __CLASS__, 'ajax_qa' ) );
		add_action( 'wp_ajax_nopriv_vira_qa_ask', array( __CLASS__, 'ajax_qa' ) );
		add_action( 'wp_ajax_vira_return_req', array( __CLASS__, 'ajax_return' ) );
		add_action( 'wp_ajax_vira_wallet_apply', array( __CLASS__, 'ajax_wallet_flag' ) );
		add_action( 'wp_ajax_vira_cart_sms', array( __CLASS__, 'ajax_cart_sms' ) );
		add_action( 'wp_ajax_nopriv_vira_cart_sms', array( __CLASS__, 'ajax_cart_sms' ) );
		add_action( 'wp_ajax_vira_story_atc', array( __CLASS__, 'ajax_story_atc' ) );
		add_action( 'wp_ajax_nopriv_vira_story_atc', array( __CLASS__, 'ajax_story_atc' ) );
		add_action( 'wp_ajax_vira_view_ping', array( __CLASS__, 'ajax_view' ) );
		add_action( 'wp_ajax_nopriv_vira_view_ping', array( __CLASS__, 'ajax_view' ) );
		add_action( 'wp_ajax_vira_qa_answer', array( __CLASS__, 'ajax_qa_answer' ) );
	}

	public static function assets() {
		$uri = get_template_directory_uri();
		$ver = defined( 'VIRA_THEME_VERSION' ) ? VIRA_THEME_VERSION : '1.9.0';
		$deps = wp_style_is( 'vira-pro', 'registered' ) || wp_style_is( 'vira-pro', 'enqueued' ) ? array( 'vira-pro' ) : array();
		wp_enqueue_style( 'vira-creative', $uri . '/assets/css/vira-creative.css', $deps, $ver );
		wp_enqueue_script( 'vira-creative', $uri . '/assets/js/vira-creative.js', array( 'jquery' ), $ver, true );
		$pid = ( function_exists( 'is_product' ) && is_product() ) ? get_the_ID() : 0;
		wp_localize_script(
			'vira-creative',
			'viraCr',
			array(
				'ajax'  => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'vira_ajax_nonce' ),
				'pid'   => $pid,
			)
		);
	}

	public static function register_status() {
		register_post_status(
			'wc-return-request',
			array(
				'label'                     => 'درخواست مرجوعی',
				'public'                    => false,
				'show_in_admin_status_list' => true,
				'show_in_admin_all_list'    => true,
				'label_count'               => _n_noop( 'مرجوعی <span class="count">(%s)</span>', 'مرجوعی <span class="count">(%s)</span>' ),
			)
		);
	}

	public static function list_status( $st ) {
		$st['wc-return-request'] = 'درخواست مرجوعی';
		return $st;
	}

	public static function product_box() {
		add_meta_box(
			'vira_cr_prod',
			'ویرا — گارانتی، مرجوعی، انبار شهر',
			array( __CLASS__, 'product_box_html' ),
			'product',
			'side'
		);
	}

	public static function product_box_html( $post ) {
		wp_nonce_field( 'vira_cr_prod', 'vira_cr_prod_nonce' );
		$days = get_post_meta( $post->ID, '_vira_return_days', true );
		$gar  = get_post_meta( $post->ID, '_vira_warranty_months', true );
		$city = get_post_meta( $post->ID, '_vira_city_stock', true );
		echo '<p>روز مرجوعی <input type="number" name="vira_return_days" value="' . esc_attr( $days !== '' ? $days : 7 ) . '" min="0"></p>';
		echo '<p>ماه گارانتی <input type="number" name="vira_warranty_months" value="' . esc_attr( $gar !== '' ? $gar : 18 ) . '" min="0"></p>';
		echo '<p>موجودی شهر (هر خط: تهران=1)<br><textarea name="vira_city_stock" rows="4" style="width:100%">' . esc_textarea( $city ) . '</textarea></p>';
	}

	public static function save_product( $id ) {
		if ( empty( $_POST['vira_cr_prod_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['vira_cr_prod_nonce'] ) ), 'vira_cr_prod' ) ) {
			return;
		}
		update_post_meta( $id, '_vira_return_days', absint( $_POST['vira_return_days'] ?? 7 ) );
		update_post_meta( $id, '_vira_warranty_months', absint( $_POST['vira_warranty_months'] ?? 18 ) );
		update_post_meta( $id, '_vira_city_stock', sanitize_textarea_field( wp_unslash( $_POST['vira_city_stock'] ?? '' ) ) );
	}

	public static function product_ui() {
		global $product;
		if ( ! $product ) {
			return;
		}
		$id   = $product->get_id();
		$days = (int) get_post_meta( $id, '_vira_return_days', true );
		if ( $days <= 0 ) {
			$days = 7;
		}
		$gar = (int) get_post_meta( $id, '_vira_warranty_months', true );
		echo '<div class="vira-cr-box vira-return-badge">ضمانت بازگشت ' . (int) $days . ' روزه';
		if ( $gar ) {
			echo ' — گارانتی ' . (int) $gar . ' ماه';
		}
		echo '</div>';

		$loc  = function_exists( 'vira_get_user_location' ) ? vira_get_user_location() : array( 'city' => '' );
		$city = isset( $loc['city'] ) ? $loc['city'] : '';
		$map  = self::parse_city_stock( $id );
		if ( $city && isset( $map[ $city ] ) ) {
			$ok = ! empty( $map[ $city ] );
			echo '<div class="vira-cr-box">' . ( $ok ? 'موجود در انبار ' . esc_html( $city ) : 'ارسال از انبار مرکزی، ۲ تا ۴ روز' ) . '</div>';
		} elseif ( $city ) {
			echo '<div class="vira-cr-box">ارسال به ' . esc_html( $city ) . ' از انبار مرکزی، ۲ تا ۴ روز</div>';
		}

		$views = (int) get_post_meta( $id, '_vira_views_today', true );
		$vday  = get_post_meta( $id, '_vira_views_day', true );
		if ( $vday !== wp_date( 'Y-m-d' ) ) {
			$views = 0;
		}
		$sold = self::sold_24h( $id );
		echo '<div class="vira-cr-box vira-live-stats" data-pid="' . esc_attr( $id ) . '">';
		echo 'بازدید امروز: <b class="js-vira-views">' . (int) $views . '</b>';
		if ( $sold ) {
			echo ' — خرید ۲۴ ساعت: <b>' . (int) $sold . '</b>';
		}
		echo '</div>';

		$phone = preg_replace( '/\D+/', '', (string) get_option( 'woocommerce_store_phone', '' ) );
		if ( ! $phone ) {
			$phone = preg_replace( '/\D+/', '', (string) get_bloginfo( 'admin_email' ) );
		}
		$wa = 'https://wa.me/' . ( $phone ? $phone : '989000000000' ) . '?text=' . rawurlencode( $product->get_name() . ' — ' . wp_strip_all_tags( $product->get_price_html() ) . ' ' . get_permalink( $id ) );
		echo '<p><a class="button vira-wa-quote" target="_blank" rel="noopener" href="' . esc_url( $wa ) . '">پیش‌فاکتور واتساپ</a> ';
		echo '<button type="button" class="button js-vira-speak">خواندن مشخصات</button></p>';
	}

	public static function oos_ui() {
		global $product;
		if ( ! $product || $product->is_in_stock() ) {
			return;
		}
		echo '<form class="vira-waitlist-form vira-cr-box" data-pid="' . esc_attr( $product->get_id() ) . '">';
		echo '<p>موجود شد خبرم کن</p><input type="tel" name="mobile" placeholder="09xxxxxxxxx" required> ';
		echo '<button type="submit" class="button">ثبت</button></form>';
		$alts = wc_get_related_products( $product->get_id(), 4 );
		if ( ! $alts ) {
			$alts = wc_get_products( array( 'limit' => 4, 'exclude' => array( $product->get_id() ), 'status' => 'publish', 'stock_status' => 'instock' ) );
			$alts = array_map(
				function ( $p ) {
					return $p->get_id();
				},
				is_array( $alts ) ? $alts : array()
			);
		}
		if ( $alts ) {
			echo '<div class="vira-alts"><h4>کالاهای جایگزین موجود</h4><ul>';
			foreach ( $alts as $aid ) {
				$p = wc_get_product( $aid );
				if ( ! $p || ! $p->is_in_stock() ) {
					continue;
				}
				echo '<li><a href="' . esc_url( $p->get_permalink() ) . '">' . esc_html( $p->get_name() ) . '</a> ' . wp_kses_post( $p->get_price_html() ) . '</li>';
			}
			echo '</ul></div>';
		}
	}

	public static function after_product() {
		global $product;
		if ( ! $product ) {
			return;
		}
		$id   = $product->get_id();
		$qas  = get_post_meta( $id, '_vira_qa', true );
		$qas  = is_array( $qas ) ? $qas : array();
		echo '<section class="vira-qa vira-cr-box"><h3>پرسش و پاسخ</h3>';
		foreach ( $qas as $i => $qa ) {
			echo '<div class="vira-qa-item"><p><b>س:</b> ' . esc_html( $qa['q'] ) . '</p>';
			if ( ! empty( $qa['a'] ) ) {
				echo '<p><b>ج:</b> ' . esc_html( $qa['a'] ) . '</p>';
			} elseif ( current_user_can( 'edit_products' ) ) {
				echo '<form class="vira-qa-ans" data-pid="' . esc_attr( $id ) . '" data-i="' . (int) $i . '"><input name="a" placeholder="پاسخ فروشنده"><button class="button">ثبت پاسخ</button></form>';
			}
			echo '</div>';
		}
		echo '<form id="vira-qa-form" data-pid="' . esc_attr( $id ) . '"><textarea name="q" required placeholder="سوال شما"></textarea><button class="button">ارسال سوال</button></form></section>';

		self::cheapened_block( $id );
	}

	public static function cheapened_block( $exclude = 0 ) {
		$q = new WP_Query(
			array(
				'post_type'      => 'product',
				'posts_per_page' => 24,
				'post_status'    => 'publish',
				'meta_key'       => '_vira_price_history',
				'fields'         => 'ids',
			)
		);
		$hits = array();
		foreach ( $q->posts as $pid ) {
			if ( (int) $pid === (int) $exclude ) {
				continue;
			}
			$h = get_post_meta( $pid, '_vira_price_history', true );
			if ( ! is_array( $h ) || count( $h ) < 2 ) {
				continue;
			}
			$last = (float) $h[ count( $h ) - 1 ]['price'];
			$prev = (float) $h[ count( $h ) - 2 ]['price'];
			if ( $last < $prev && $prev > 0 ) {
				$hits[] = $pid;
			}
			if ( count( $hits ) >= 4 ) {
				break;
			}
		}
		if ( ! $hits ) {
			return;
		}
		echo '<section class="vira-cheapened vira-cr-box"><h3>اخیراً ارزان شده</h3><ul>';
		foreach ( $hits as $pid ) {
			$p = wc_get_product( $pid );
			if ( ! $p ) {
				continue;
			}
			echo '<li><a href="' . esc_url( $p->get_permalink() ) . '">' . esc_html( $p->get_name() ) . '</a> ' . wp_kses_post( $p->get_price_html() ) . '</li>';
		}
		echo '</ul></section>';
	}

	public static function checkout_fields() {
		$slots = array( '۱۰–۱۴', '۱۴–۱۸', '۱۸–۲۲' );
		$today = wp_date( 'Y/m/d' );
		$tom   = wp_date( 'Y/m/d', strtotime( '+1 day' ) );
		echo '<div class="vira-cr-box vira-slots"><h3>بازه تحویل</h3>';
		echo '<label><input type="radio" name="vira_ship_day" value="' . esc_attr( $today ) . '" checked> امروز (' . esc_html( $today ) . ')</label> ';
		echo '<label><input type="radio" name="vira_ship_day" value="' . esc_attr( $tom ) . '"> فردا</label><p>';
		foreach ( $slots as $i => $s ) {
			echo '<label><input type="radio" name="vira_ship_slot" value="' . esc_attr( $s ) . '" ' . checked( 0, $i, false ) . '> ' . esc_html( $s ) . '</label> ';
		}
		echo '</p></div>';
		echo '<div class="vira-cr-box"><h3>خرید سازمانی</h3>';
		echo '<p><input name="vira_b2b_company" placeholder="نام شرکت"></p>';
		echo '<p><input name="vira_b2b_eco" placeholder="کد اقتصادی"></p>';
		echo '<p><input name="vira_b2b_nid" placeholder="شناسه ملی"></p></div>';
		if ( is_user_logged_in() ) {
			$w = (int) get_user_meta( get_current_user_id(), 'vira_wallet', true );
			if ( $w > 0 ) {
				echo '<p><label><input type="checkbox" name="vira_use_wallet" value="1"> استفاده از کیف پول (' . wp_kses_post( wc_price( $w ) ) . ')</label></p>';
			}
		}
	}

	public static function review_wallet( $post_data ) {
		parse_str( (string) $post_data, $d );
		if ( WC()->session ) {
			WC()->session->set( 'vira_use_wallet', ! empty( $d['vira_use_wallet'] ) );
		}
	}

	public static function save_checkout( $order_id ) {
		$order = wc_get_order( $order_id );
		if ( ! $order ) {
			return;
		}
		foreach ( array( 'vira_ship_day', 'vira_ship_slot', 'vira_b2b_company', 'vira_b2b_eco', 'vira_b2b_nid' ) as $k ) {
			if ( isset( $_POST[ $k ] ) ) {
				$order->update_meta_data( '_' . $k, sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) );
			}
		}
		if ( ! empty( $_POST['vira_use_wallet'] ) ) {
			$order->update_meta_data( '_vira_use_wallet', '1' );
		}
		$ref = isset( $_COOKIE['vira_ref'] ) ? absint( $_COOKIE['vira_ref'] ) : 0;
		if ( $ref && $order->get_user_id() && $ref !== (int) $order->get_user_id() ) {
			$order->update_meta_data( '_vira_ref', $ref );
		}
		$order->save();
	}

	public static function admin_order_meta( $order ) {
		echo '<p><b>تحویل:</b> ' . esc_html( $order->get_meta( '_vira_ship_day' ) . ' ' . $order->get_meta( '_vira_ship_slot' ) ) . '</p>';
		if ( $order->get_meta( '_vira_b2b_company' ) ) {
			echo '<p>شرکت: ' . esc_html( $order->get_meta( '_vira_b2b_company' ) ) . ' — اقتصادی: ' . esc_html( $order->get_meta( '_vira_b2b_eco' ) ) . '</p>';
		}
		$url = wp_nonce_url( add_query_arg( array( 'vira_label' => $order->get_id() ), admin_url( 'admin.php' ) ), 'vira_label' );
		echo '<p><a class="button" href="' . esc_url( $url ) . '" target="_blank">چاپ برچسب انبار</a></p>';
	}

	public static function email_meta( $fields, $sent_to_admin, $order ) {
		if ( ! is_array( $fields ) ) {
			$fields = array();
		}
		if ( ! $order || ! is_a( $order, 'WC_Order' ) ) {
			return $fields;
		}
		$fields['slot'] = array(
			'label' => 'بازه تحویل',
			'value' => $order->get_meta( '_vira_ship_day' ) . ' ' . $order->get_meta( '_vira_ship_slot' ),
		);
		return $fields;
	}

	public static function on_completed( $order_id ) {
		$order = wc_get_order( $order_id );
		if ( ! $order ) {
			return;
		}
		$uid = $order->get_user_id();
		$ref = (int) $order->get_meta( '_vira_ref' );
		if ( $ref && $uid && ! $order->get_meta( '_vira_ref_paid' ) ) {
			$pts = (int) get_user_meta( $ref, 'vira_points', true );
			update_user_meta( $ref, 'vira_points', $pts + 50 );
			if ( $uid ) {
				$p2 = (int) get_user_meta( $uid, 'vira_points', true );
				update_user_meta( $uid, 'vira_points', $p2 + 25 );
			}
			$order->update_meta_data( '_vira_ref_paid', '1' );
			$order->save();
		}
	}

	public static function wallet_fee( $cart ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return;
		}
		if ( ! function_exists( 'WC' ) || ! WC() || empty( WC()->session ) || ! WC()->session->get( 'vira_use_wallet' ) || ! is_user_logged_in() ) {
			return;
		}
		$w = (int) get_user_meta( get_current_user_id(), 'vira_wallet', true );
		if ( $w <= 0 ) {
			return;
		}
		$use = min( $w, (float) $cart->get_subtotal() );
		if ( $use > 0 ) {
			$cart->add_fee( 'کیف پول ویرا', -$use, false );
		}
	}

	public static function wallet_deduct( $order_id ) {
		$order = wc_get_order( $order_id );
		if ( ! $order || ! $order->get_user_id() ) {
			return;
		}
		$used = 0;
		foreach ( $order->get_fees() as $fee ) {
			if ( false !== strpos( $fee->get_name(), 'کیف پول' ) ) {
				$used += abs( (float) $fee->get_total() );
			}
		}
		if ( $used > 0 ) {
			$w = (int) get_user_meta( $order->get_user_id(), 'vira_wallet', true );
			update_user_meta( $order->get_user_id(), 'vira_wallet', max( 0, $w - (int) $used ) );
		}
		if ( ! empty( WC()->session ) ) {
			WC()->session->set( 'vira_use_wallet', false );
		}
	}

	public static function account() {
		$uid = get_current_user_id();
		$w   = (int) get_user_meta( $uid, 'vira_wallet', true );
		$ref = add_query_arg( 'ref', $uid, home_url( '/' ) );
		echo '<div class="vira-cr-box"><h3>کیف پول</h3><p>موجودی: <b>' . wp_kses_post( wc_price( $w ) ) . '</b></p>';
		echo '<p>لینک معرفی شما: <code>' . esc_html( $ref ) . '</code> (۵۰ امتیاز برای شما، ۲۵ برای دوست)</p></div>';

		$orders = wc_get_orders( array( 'customer_id' => $uid, 'limit' => 10, 'status' => array( 'completed', 'processing' ) ) );
		echo '<div class="vira-cr-box"><h3>مرجوعی و گارانتی</h3>';
		foreach ( $orders as $o ) {
			$ok   = self::can_return( $o );
			$pdf  = wp_nonce_url( add_query_arg( array( 'vira_warranty' => $o->get_id() ), home_url( '/' ) ), 'vira_warr' );
			echo '<p>سفارش #' . (int) $o->get_id() . ' ';
			echo '<a href="' . esc_url( $pdf ) . '">گارانتی‌نامه PDF</a> ';
			if ( $ok ) {
				echo '<button type="button" class="button js-vira-return" data-id="' . esc_attr( $o->get_id() ) . '">درخواست مرجوعی</button>';
			}
			echo '</p>';
		}
		echo '</div>';
		echo '<div class="vira-cr-box"><h3>بازیابی سبد مهمان</h3><form class="vira-cart-sms"><input type="tel" name="mobile" placeholder="09xxxxxxxxx" required><button class="button">ارسال لینک سبد با پیامک</button></form></div>';
	}

	public static function thankyou( $order_id ) {
		$o = wc_get_order( $order_id );
		if ( ! $o ) {
			return;
		}
		$slot = trim( $o->get_meta( '_vira_ship_day' ) . ' ' . $o->get_meta( '_vira_ship_slot' ) );
		if ( $slot ) {
			echo '<p class="vira-cr-box">بازه تحویل انتخابی: ' . esc_html( $slot ) . '</p>';
		}
	}

	public static function can_return( $order ) {
		if ( ! $order || ! in_array( $order->get_status(), array( 'completed', 'processing' ), true ) ) {
			return false;
		}
		$created = $order->get_date_created();
		if ( ! $created ) {
			return false;
		}
		$days = 7;
		foreach ( $order->get_items() as $item ) {
			$d = (int) get_post_meta( $item->get_product_id(), '_vira_return_days', true );
			if ( $d > $days ) {
				$days = $d;
			}
		}
		return ( time() - $created->getTimestamp() ) <= $days * DAY_IN_SECONDS;
	}

	public static function downloads_and_restore() {
		if ( ! empty( $_GET['vira_restore_cart'] ) && function_exists( 'WC' ) && WC()->cart ) {
			$token = sanitize_text_field( wp_unslash( $_GET['vira_restore_cart'] ) );
			$cart  = get_transient( 'vira_saved_cart_' . $token );
			if ( is_array( $cart ) ) {
				WC()->cart->empty_cart();
				foreach ( $cart as $line ) {
					WC()->cart->add_to_cart( $line['product_id'], $line['qty'], $line['variation_id'], $line['variation'] );
				}
				wc_add_notice( 'سبد بازیابی شد.', 'success' );
				wp_safe_redirect( wc_get_cart_url() );
				exit;
			}
		}
		if ( ! empty( $_GET['vira_warranty'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'vira_warr' ) ) {
			$o = wc_get_order( absint( $_GET['vira_warranty'] ) );
			if ( $o && ( (int) $o->get_user_id() === get_current_user_id() || current_user_can( 'manage_woocommerce' ) ) ) {
				$lines = array( 'Order #' . $o->get_id(), 'Date ' . $o->get_date_created(), 'Customer ' . $o->get_formatted_billing_full_name() );
				foreach ( $o->get_items() as $item ) {
					$m = (int) get_post_meta( $item->get_product_id(), '_vira_warranty_months', true );
					$lines[] = $item->get_name() . ' — warranty ' . ( $m ? $m : 18 ) . ' months';
				}
				$pdf = class_exists( 'Vira_Pdf' ) ? Vira_Pdf::from_lines( 'Vira Warranty', $lines ) : implode( "\n", $lines );
				header( 'Content-Type: application/pdf' );
				header( 'Content-Disposition: attachment; filename="warranty-' . $o->get_id() . '.pdf"' );
				echo $pdf; // phpcs:ignore
				exit;
			}
		}
	}

	public static function print_label() {
		if ( empty( $_GET['vira_label'] ) || ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}
		if ( empty( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'vira_label' ) ) {
			return;
		}
		$o = wc_get_order( absint( $_GET['vira_label'] ) );
		if ( ! $o ) {
			return;
		}
		header( 'Content-Type: text/html; charset=utf-8' );
		echo '<html><body style="font-family:Tahoma;padding:24px"><h1>#' . (int) $o->get_id() . '</h1>';
		echo '<p style="font-size:28px;letter-spacing:4px">*' . (int) $o->get_id() . '*</p>';
		echo '<p>' . wp_kses_post( $o->get_formatted_shipping_address() ? $o->get_formatted_shipping_address() : $o->get_formatted_billing_address() ) . '</p>';
		echo '<p>' . esc_html( $o->get_meta( '_vira_ship_day' ) . ' ' . $o->get_meta( '_vira_ship_slot' ) ) . '</p>';
		foreach ( $o->get_items() as $item ) {
			echo '<p>' . esc_html( $item->get_name() . ' × ' . $item->get_quantity() ) . '</p>';
		}
		echo '<script>window.print()</script></body></html>';
		exit;
	}

	public static function ajax_waitlist() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$pid = absint( $_POST['product_id'] ?? 0 );
		$mob = isset( $_POST['mobile'] ) ? sanitize_text_field( wp_unslash( $_POST['mobile'] ) ) : '';
		if ( ! $pid || ! preg_match( '/^09[0-9]{9}$/', $mob ) ) {
			wp_send_json_error( array( 'message' => 'اطلاعات نامعتبر' ) );
		}
		$list = get_post_meta( $pid, '_vira_waitlist', true );
		$list = is_array( $list ) ? $list : array();
		$list[ $mob ] = time();
		update_post_meta( $pid, '_vira_waitlist', $list );
		wp_send_json_success( array( 'message' => 'ثبت شد. با موجود شدن پیامک می‌شود.' ) );
	}

	public static function stock_changed( $product, $changed ) {
		if ( ! $product || ! in_array( 'stock_status', (array) $changed, true ) ) {
			return;
		}
		if ( ! $product->is_in_stock() ) {
			return;
		}
		$list = get_post_meta( $product->get_id(), '_vira_waitlist', true );
		if ( ! is_array( $list ) ) {
			return;
		}
		foreach ( array_keys( $list ) as $mob ) {
			if ( function_exists( 'vira_send_sms' ) ) {
				vira_send_sms( $mob, 'کالای ' . $product->get_name() . ' موجود شد. ' . $product->get_permalink() );
			}
		}
		delete_post_meta( $product->get_id(), '_vira_waitlist' );
	}

	public static function ajax_qa() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$pid = absint( $_POST['product_id'] ?? 0 );
		$q   = isset( $_POST['q'] ) ? sanitize_textarea_field( wp_unslash( $_POST['q'] ) ) : '';
		if ( ! $pid || strlen( $q ) < 5 ) {
			wp_send_json_error( array( 'message' => 'سوال کوتاه است.' ) );
		}
		$qas   = get_post_meta( $pid, '_vira_qa', true );
		$qas   = is_array( $qas ) ? $qas : array();
		$qas[] = array( 'q' => $q, 'a' => '', 't' => time() );
		update_post_meta( $pid, '_vira_qa', $qas );
		wp_send_json_success( array( 'message' => 'سوال ثبت شد.' ) );
	}

	public static function ajax_qa_answer() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		if ( ! current_user_can( 'edit_products' ) ) {
			wp_send_json_error();
		}
		$pid = absint( $_POST['product_id'] ?? 0 );
		$i   = absint( $_POST['i'] ?? 0 );
		$a   = sanitize_textarea_field( wp_unslash( $_POST['a'] ?? '' ) );
		$qas = get_post_meta( $pid, '_vira_qa', true );
		if ( isset( $qas[ $i ] ) ) {
			$qas[ $i ]['a'] = $a;
			update_post_meta( $pid, '_vira_qa', $qas );
		}
		wp_send_json_success( array( 'message' => 'پاسخ ثبت شد.' ) );
	}

	public static function ajax_return() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$o = wc_get_order( absint( $_POST['order_id'] ?? 0 ) );
		if ( ! $o || (int) $o->get_user_id() !== get_current_user_id() || ! self::can_return( $o ) ) {
			wp_send_json_error( array( 'message' => 'قابل مرجوع نیست.' ) );
		}
		$o->update_status( 'return-request', 'درخواست مرجوعی مشتری' );
		wp_send_json_success( array( 'message' => 'درخواست مرجوعی ثبت شد.' ) );
	}

	public static function ajax_wallet_flag() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		if ( WC()->session ) {
			WC()->session->set( 'vira_use_wallet', ! empty( $_POST['on'] ) );
		}
		wp_send_json_success();
	}

	public static function ajax_cart_sms() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$mob = isset( $_POST['mobile'] ) ? sanitize_text_field( wp_unslash( $_POST['mobile'] ) ) : '';
		if ( ! preg_match( '/^09[0-9]{9}$/', $mob ) || ! WC()->cart ) {
			wp_send_json_error( array( 'message' => 'نامعتبر' ) );
		}
		$lines = array();
		foreach ( WC()->cart->get_cart() as $item ) {
			$lines[] = array(
				'product_id'   => $item['product_id'],
				'qty'          => $item['quantity'],
				'variation_id' => $item['variation_id'],
				'variation'    => $item['variation'],
			);
		}
		if ( ! $lines ) {
			wp_send_json_error( array( 'message' => 'سبد خالی است.' ) );
		}
		$token = wp_generate_password( 12, false, false );
		set_transient( 'vira_saved_cart_' . $token, $lines, WEEK_IN_SECONDS );
		$url = add_query_arg( 'vira_restore_cart', $token, home_url( '/' ) );
		$ok  = function_exists( 'vira_send_sms' ) ? vira_send_sms( $mob, 'سبد خرید: ' . $url ) : false;
		if ( ! $ok ) {
			wp_send_json_error( array( 'message' => 'پیامک پیکربندی نشده. لینک: ' . $url ) );
		}
		wp_send_json_success( array( 'message' => 'لینک سبد پیامک شد.' ) );
	}

	public static function ajax_story_atc() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$id = absint( $_POST['product_id'] ?? 0 );
		if ( ! $id || ! WC()->cart ) {
			wp_send_json_error();
		}
		WC()->cart->add_to_cart( $id, 1 );
		wp_send_json_success( array( 'cart' => wc_get_cart_url() ) );
	}

	public static function ajax_view() {
		$pid = absint( $_POST['product_id'] ?? 0 );
		if ( ! $pid ) {
			wp_send_json_error();
		}
		$day = wp_date( 'Y-m-d' );
		if ( get_post_meta( $pid, '_vira_views_day', true ) !== $day ) {
			update_post_meta( $pid, '_vira_views_day', $day );
			update_post_meta( $pid, '_vira_views_today', 0 );
		}
		$key = 'vira_v_' . $pid . '_' . md5( ( isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '' ) . wp_date( 'Y-m-d-H' ) );
		if ( ! get_transient( $key ) ) {
			set_transient( $key, 1, HOUR_IN_SECONDS );
			$n = (int) get_post_meta( $pid, '_vira_views_today', true );
			update_post_meta( $pid, '_vira_views_today', $n + 1 );
		}
		wp_send_json_success( array( 'views' => (int) get_post_meta( $pid, '_vira_views_today', true ) ) );
	}

	public static function capture_ref() {
		if ( ! empty( $_GET['ref'] ) ) {
			setcookie( 'vira_ref', absint( $_GET['ref'] ), time() + MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
		}
	}

	public static function ref_on_register( $user_id ) {
		$ref = isset( $_COOKIE['vira_ref'] ) ? absint( $_COOKIE['vira_ref'] ) : 0;
		if ( $ref && $ref !== (int) $user_id ) {
			update_user_meta( $user_id, 'vira_referred_by', $ref );
		}
	}

	public static function seasonal_home() {
		if ( ! function_exists( 'is_front_page' ) || ! is_front_page() || ! function_exists( 'wc_get_products' ) ) {
			return;
		}
		$m    = (int) wp_date( 'n' );
		$hint = ( $m >= 6 && $m <= 8 ) ? 'کولر' : ( ( $m >= 10 || $m <= 2 ) ? 'بخاری' : 'پرفروش' );
		$q    = new WP_Query(
			array(
				'post_type'      => 'product',
				's'              => $hint,
				'posts_per_page' => 4,
				'post_status'    => 'publish',
			)
		);
		if ( ! $q->have_posts() ) {
			return;
		}
		echo '<div class="vira-seasonal vira-cr-box" style="max-width:1100px;margin:16px auto"><h3>پیشنهاد فصل: ' . esc_html( $hint ) . '</h3><ul>';
		while ( $q->have_posts() ) {
			$q->the_post();
			$p = wc_get_product( get_the_ID() );
			if ( $p ) {
				echo '<li><a href="' . esc_url( $p->get_permalink() ) . '">' . esc_html( $p->get_name() ) . '</a></li>';
			}
		}
		wp_reset_postdata();
		echo '</ul></div>';
	}

	public static function parse_city_stock( $pid ) {
		$raw = (string) get_post_meta( $pid, '_vira_city_stock', true );
		$out = array();
		foreach ( preg_split( '/\r\n|\r|\n/', $raw ) as $line ) {
			if ( strpos( $line, '=' ) === false ) {
				continue;
			}
			list( $c, $v ) = array_map( 'trim', explode( '=', $line, 2 ) );
			if ( $c ) {
				$out[ $c ] = ( '0' !== $v && 'no' !== strtolower( $v ) );
			}
		}
		return $out;
	}

	public static function sold_24h( $pid ) {
		if ( ! function_exists( 'wc_get_orders' ) ) {
			return 0;
		}
		$n   = 0;
		$ord = wc_get_orders(
			array(
				'limit'      => 50,
				'status'     => array( 'processing', 'completed' ),
				'date_after' => gmdate( 'Y-m-d H:i:s', time() - DAY_IN_SECONDS ),
				'return'     => 'objects',
			)
		);
		foreach ( $ord as $o ) {
			foreach ( $o->get_items() as $item ) {
				if ( (int) $item->get_product_id() === (int) $pid ) {
					$n += (int) $item->get_quantity();
				}
			}
		}
		return $n;
	}
}

if ( ! function_exists( 'vira_iran_weight_shipping_init' ) ) {
add_action( 'woocommerce_shipping_init', 'vira_iran_weight_shipping_init' );
function vira_iran_weight_shipping_init() {
	if ( class_exists( 'Vira_Iran_Weight_Shipping' ) || ! class_exists( 'WC_Shipping_Method' ) ) {
		return;
	}
	class Vira_Iran_Weight_Shipping extends WC_Shipping_Method {
		public function __construct( $instance_id = 0 ) {
			$this->id                 = 'vira_iran_weight';
			$this->instance_id        = absint( $instance_id );
			$this->method_title       = 'ارسال وزنی ایران (ویرا)';
			$this->method_description = 'هزینه بر اساس وزن سبد (کیلو): پست پیشتاز / تیپاکس.';
			$this->supports           = array( 'shipping-zones', 'instance-settings' );
			$this->enabled            = 'yes';
			$this->title              = 'ارسال ویرا';
			$this->init_form_fields();
			$this->init_settings();
			$this->title = $this->get_option( 'title', $this->title );
			add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
		}
		public function init_form_fields() {
			$this->instance_form_fields = array(
				'title'    => array(
					'title'   => 'عنوان',
					'type'    => 'text',
					'default' => 'پست پیشتاز / تیپاکس',
				),
				'per_kg'   => array(
					'title'   => 'تومان هر کیلو',
					'type'    => 'number',
					'default' => '25000',
				),
				'base'     => array(
					'title'   => 'کرایه پایه',
					'type'    => 'number',
					'default' => '45000',
				),
			);
		}
		public function calculate_shipping( $package = array() ) {
			$w = 0;
			foreach ( $package['contents'] as $item ) {
				$p = $item['data'];
				$w += ( (float) $p->get_weight() ?: 0.5 ) * $item['quantity'];
			}
			$cost = (float) $this->get_option( 'base', 45000 ) + $w * (float) $this->get_option( 'per_kg', 25000 );
			$this->add_rate(
				array(
					'id'    => $this->id,
					'label' => $this->title,
					'cost'  => $cost,
				)
			);
		}
	}
}
}

add_filter(
	'woocommerce_shipping_methods',
	function ( $m ) {
		$m['vira_iran_weight'] = 'Vira_Iran_Weight_Shipping';
		return $m;
	}
);

Vira_Creative::init();
