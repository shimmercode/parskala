<?php
/**
 * Digikala-inspired storefront layer (homepage, search, mega, offers, cart, reviews).
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vira_Digikala_Layer {

	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'assets' ), 40 );
		add_action( 'wp_ajax_vira_dk_search', array( __CLASS__, 'ajax_search' ) );
		add_action( 'wp_ajax_nopriv_vira_dk_search', array( __CLASS__, 'ajax_search' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'offers_metabox' ) );
		add_action( 'save_post_product', array( __CLASS__, 'save_offers' ) );
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'render_offers' ), 35 );
		add_action( 'woocommerce_before_add_to_cart_form', array( __CLASS__, 'amazing_badge' ), 4 );
		add_action( 'woocommerce_after_shop_loop_item_title', array( __CLASS__, 'loop_timer' ), 15 );
		add_action( 'woocommerce_widget_shopping_cart_before_buttons', array( __CLASS__, 'cart_shipping_bar' ) );
		add_action( 'woocommerce_before_cart_table', array( __CLASS__, 'cart_shipping_bar' ) );
		add_action( 'woocommerce_review_after_comment_text', array( __CLASS__, 'review_media' ) );
		add_action( 'comment_post', array( __CLASS__, 'save_review_media' ), 20, 3 );
		add_filter( 'comment_form_field_comment', array( __CLASS__, 'review_upload_field' ) );
		add_action( 'wp_footer', array( __CLASS__, 'footer_widgets' ), 5 );
		add_filter(
			'comment_form_defaults',
			function ( $d ) {
				$d['form'] = str_replace( '<form', '<form enctype="multipart/form-data"', $d['form'] ?? '<form' );
				return $d;
			}
		);
	}

	public static function assets() {
		$uri = get_template_directory_uri();
		$ver = defined( 'VIRA_THEME_VERSION' ) ? VIRA_THEME_VERSION : '1.6.0';
		wp_enqueue_style( 'vira-dk', $uri . '/assets/css/digikala-layer.css', array(), $ver );
		wp_enqueue_script( 'vira-dk', $uri . '/assets/js/digikala-layer.js', array( 'jquery' ), $ver, true );
		$threshold = (int) prk_option( 'vira_free_ship_threshold', 500000 );
		wp_localize_script(
			'vira-dk',
			'viraDk',
			array(
				'ajax'      => admin_url( 'admin-ajax.php' ),
				'nonce'     => wp_create_nonce( 'vira_dk' ),
				'shop'      => class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ),
				'threshold' => $threshold,
				'cartTotal' => ( class_exists( 'WooCommerce' ) && WC()->cart ) ? (float) WC()->cart->get_displayed_subtotal() : 0,
			)
		);
	}

	public static function products( $args = array() ) {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return array();
		}
		$defaults = array(
			'status'  => 'publish',
			'limit'   => 12,
			'orderby' => 'date',
			'order'   => 'DESC',
		);
		return wc_get_products( array_merge( $defaults, $args ) );
	}

	public static function cats( $limit = 12 ) {
		if ( ! taxonomy_exists( 'product_cat' ) ) {
			return array();
		}
		$terms = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
				'number'     => $limit,
				'parent'     => 0,
			)
		);
		return is_wp_error( $terms ) ? array() : $terms;
	}

	public static function price_html( $product ) {
		if ( ! $product ) {
			return '';
		}
		$sale = $product->get_sale_price();
		$reg  = $product->get_regular_price();
		$html = '<div class="dk-price">';
		if ( $sale && $reg && (float) $sale < (float) $reg ) {
			$pct = round( ( ( $reg - $sale ) / max( 1, (float) $reg ) ) * 100 );
			$html .= '<span class="dk-pct">' . $pct . '٪</span>';
			$html .= '<del>' . wc_price( $reg ) . '</del>';
			$html .= '<ins>' . wc_price( $sale ) . '</ins>';
		} else {
			$html .= '<ins>' . $product->get_price_html() . '</ins>';
		}
		$html .= '</div>';
		return $html;
	}

	public static function card( $product ) {
		if ( ! $product ) {
			return '';
		}
		$img = $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'dk-card-img' ) );
		$end = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
		$stock = $product->get_stock_quantity();
		ob_start();
		?>
		<a class="dk-card" href="<?php echo esc_url( $product->get_permalink() ); ?>">
			<?php echo $img; // phpcs:ignore ?>
			<h3><?php echo esc_html( wp_trim_words( $product->get_name(), 12 ) ); ?></h3>
			<?php echo self::price_html( $product ); // phpcs:ignore ?>
			<?php if ( $end ) : ?>
				<div class="dk-timer" data-end="<?php echo esc_attr( (int) $end ); ?>"></div>
			<?php endif; ?>
			<?php if ( $stock && $stock < 20 ) : ?>
				<div class="dk-stock"><i style="width:<?php echo esc_attr( min( 100, $stock * 8 ) ); ?>%"></i><span>تنها <?php echo (int) $stock; ?> عدد</span></div>
			<?php endif; ?>
		</a>
		<?php
		return ob_get_clean();
	}

	public static function render_home() {
		$amazing = self::products( array( 'limit' => 10, 'orderby' => 'popularity' ) );
		$on_sale = array();
		if ( class_exists( 'Vira_Pro' ) ) {
			$on_sale = Vira_Pro::amazing_products();
		}
		if ( empty( $on_sale ) && class_exists( 'WooCommerce' ) ) {
			$on_sale = wc_get_products( array( 'status' => 'publish', 'limit' => 10, 'include' => wc_get_product_ids_on_sale() ) );
		}
		if ( empty( $on_sale ) ) {
			$on_sale = $amazing;
		}
		$best = self::products( array( 'limit' => 10, 'orderby' => 'popularity' ) );
		$new  = self::products( array( 'limit' => 10 ) );
		$cats = self::cats( 14 );
		$slides = array_slice( $new, 0, 5 );
		$chips = array(
			array( 'سوپرمارکت', '🛒' ),
			array( 'دیجی‌کالا جت', '⚡' ),
			array( 'دیجی‌استایل', '👗' ),
			array( 'الکترونیک', '📱' ),
			array( 'خانه و آشپزخانه', '🏠' ),
			array( 'موبایل', '📲' ),
			array( 'مد و پوشاک', '👜' ),
			array( 'کتاب و هنر', '📚' ),
		);
		$shop = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
		?>
		<div class="dk-home" dir="rtl">
			<div class="dk-wrap">
				<div class="dk-stories">
					<?php
					$i = 0;
					foreach ( array_slice( $new, 0, 8 ) as $p ) {
						++$i;
						echo '<a class="dk-story" href="' . esc_url( $p->get_permalink() ) . '"><span class="dk-story-ring">' . $p->get_image( 'thumbnail' ) . '</span><b>' . esc_html( wp_trim_words( $p->get_name(), 3, '' ) ) . '</b></a>';
					}
					if ( ! $new ) {
						for ( $i = 1; $i <= 6; $i++ ) {
							echo '<div class="dk-story"><span class="dk-story-ring dk-ph"></span><b>داستان ' . $i . '</b></div>';
						}
					}
					?>
				</div>

				<div class="dk-hero">
					<div class="dk-slider" id="dkSlider">
						<?php
						$n = 0;
						foreach ( $slides as $p ) {
							++$n;
							echo '<a class="dk-slide' . ( 1 === $n ? ' is-on' : '' ) . '" href="' . esc_url( $p->get_permalink() ) . '">' . $p->get_image( 'large' ) . '<span>' . esc_html( $p->get_name() ) . '</span></a>';
						}
						if ( ! $slides ) {
							echo '<div class="dk-slide is-on dk-slide-empty"><strong>ویرا</strong><p>فروشگاه اینترنتی با الگوی دیجی‌کالا — محصولات ووکامرس را اضافه کنید.</p></div>';
						}
						?>
						<button class="dk-prev" type="button" aria-label="قبلی">‹</button>
						<button class="dk-next" type="button" aria-label="بعدی">›</button>
					</div>
					<div class="dk-hero-side">
						<a href="<?php echo esc_url( $shop ); ?>" class="dk-side-ban dk-a">شگفت‌انگیز روزانه</a>
						<a href="<?php echo esc_url( $shop ); ?>" class="dk-side-ban dk-b">ارسال سریع امروز</a>
					</div>
				</div>

				<div class="dk-chips">
					<?php foreach ( $chips as $c ) : ?>
						<a href="<?php echo esc_url( $shop ); ?>"><i><?php echo $c[1]; ?></i><?php echo esc_html( $c[0] ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>

			<section class="dk-amazing">
				<div class="dk-wrap dk-amazing-in">
					<div class="dk-amazing-head">
						<strong>پیشنهاد شگفت‌انگیز</strong>
						<div class="dk-clock" data-hours="8"><em>08</em>:<em>00</em>:<em>00</em></div>
						<a href="<?php echo esc_url( $shop ); ?>">مشاهده همه ›</a>
					</div>
					<div class="dk-rail">
						<?php
						$list = $on_sale ? $on_sale : $amazing;
						if ( $list ) {
							foreach ( $list as $p ) {
								echo self::card( $p ); // phpcs:ignore
							}
						} else {
							echo '<p class="dk-empty">هنوز محصول تخفیف‌دار ندارید.</p>';
						}
						?>
					</div>
				</div>
			</section>

			<div class="dk-wrap">
				<div class="dk-banners">
					<a href="<?php echo esc_url( $shop ); ?>">خرید اقساطی</a>
					<a href="<?php echo esc_url( $shop ); ?>">سوپرمارکت</a>
					<a href="<?php echo esc_url( $shop ); ?>">دیجی‌پلاس</a>
					<a href="<?php echo esc_url( $shop ); ?>">کارت هدیه</a>
				</div>

				<?php if ( $cats ) : ?>
				<section class="dk-sec">
					<h2>دسته‌بندی‌های منتخب</h2>
					<div class="dk-cat-grid">
						<?php foreach ( $cats as $t ) : ?>
							<a href="<?php echo esc_url( get_term_link( $t ) ); ?>">
								<?php
								$thumb = get_term_meta( $t->term_id, 'thumbnail_id', true );
								if ( $thumb ) {
									echo wp_get_attachment_image( $thumb, 'thumbnail' );
								} else {
									echo '<span class="dk-cat-ph"></span>';
								}
								?>
								<span><?php echo esc_html( $t->name ); ?></span>
							</a>
						<?php endforeach; ?>
					</div>
				</section>
				<?php endif; ?>

				<?php self::rail( 'پرفروش‌ترین‌ها', $best, $shop ); ?>
				<?php self::rail( 'جدیدترین کالاها', $new, $shop ); ?>
				<?php self::rail( 'منتخب برای شما', $amazing, $shop ); ?>

				<section class="dk-trust">
					<div><b>امکان تحویل اکسپرس</b><span>ارسال سریع در شهرهای منتخب</span></div>
					<div><b>۲۴ ساعته، ۷ روز هفته</b><span>پشتیبانی خرید</span></div>
					<div><b>امکان پرداخت در محل</b><span>برای سفارش‌های مجاز</span></div>
					<div><b>۷ روز ضمانت بازگشت</b><span>حتی در صورت انصراف</span></div>
					<div><b>ضمانت اصل بودن کالا</b><span>تضمین اصالت</span></div>
				</section>
			</div>
		</div>
		<?php
	}

	private static function rail( $title, $items, $shop ) {
		echo '<section class="dk-sec"><div class="dk-sec-h"><h2>' . esc_html( $title ) . '</h2><a href="' . esc_url( $shop ) . '">مشاهده همه</a></div><div class="dk-rail">';
		if ( $items ) {
			foreach ( $items as $p ) {
				echo self::card( $p ); // phpcs:ignore
			}
		} else {
			echo '<p class="dk-empty">محصولی برای نمایش نیست.</p>';
		}
		echo '</div></section>';
	}

	public static function ajax_search() {
		check_ajax_referer( 'vira_dk', 'nonce' );
		$q = sanitize_text_field( wp_unslash( $_GET['q'] ?? '' ) );
		$out = array(
			'products'   => array(),
			'cats'       => array(),
			'suggestions'=> array(),
		);
		if ( strlen( $q ) < 1 ) {
			$out['suggestions'] = array( 'گوشی موبایل', 'لپ تاپ', 'هدفون', 'تلویزیون', 'یخچال' );
			wp_send_json_success( $out );
		}
		if ( class_exists( 'WooCommerce' ) ) {
			$ids = wc_get_products(
				array(
					's'     => $q,
					'limit' => 8,
					'return'=> 'ids',
					'status'=> 'publish',
				)
			);
			foreach ( $ids as $id ) {
				$p = wc_get_product( $id );
				if ( ! $p ) {
					continue;
				}
				$out['products'][] = array(
					'id'    => $id,
					'title' => $p->get_name(),
					'url'   => $p->get_permalink(),
					'price' => wp_strip_all_tags( $p->get_price_html() ),
					'img'   => get_the_post_thumbnail_url( $id, 'thumbnail' ),
				);
			}
			$terms = get_terms( array( 'taxonomy' => 'product_cat', 'search' => $q, 'number' => 5, 'hide_empty' => false ) );
			if ( ! is_wp_error( $terms ) ) {
				foreach ( $terms as $t ) {
					$out['cats'][] = array( 'title' => $t->name, 'url' => get_term_link( $t ) );
				}
			}
		}
		$out['suggestions'][] = $q;
		wp_send_json_success( $out );
	}

	public static function offers_metabox() {
		add_meta_box( 'vira_dk_offers', 'پیشنهاد فروشندگان (الگوی دیجی‌کالا)', array( __CLASS__, 'offers_box' ), 'product', 'normal' );
	}

	public static function offers_box( $post ) {
		wp_nonce_field( 'vira_dk_offers', 'vira_dk_offers_nonce' );
		$rows = get_post_meta( $post->ID, '_vira_dk_offers', true );
		if ( ! is_array( $rows ) ) {
			$rows = array();
		}
		echo '<p>هر ردیف یک فروشنده مستقل است (بدون دکان). قیمت را به تومان بنویسید.</p>';
		echo '<div id="dkOffers">';
		$i = 0;
		foreach ( $rows as $row ) {
			self::offer_row( $i++, $row );
		}
		if ( ! $rows ) {
			self::offer_row( 0, array() );
		}
		echo '</div><p><button type="button" class="button" id="dkAddOffer">افزودن فروشنده</button></p>';
		echo '<script>document.getElementById("dkAddOffer").onclick=function(){var w=document.getElementById("dkOffers");var n=w.querySelectorAll(".dk-off-row").length;var d=document.createElement("div");d.innerHTML=`<p class="dk-off-row">فروشنده <input name="dk_off[${n}][name]" placeholder="نام فروشنده"> قیمت <input name="dk_off[${n}][price]" type="number"> ارسال <input name="dk_off[${n}][ship]" placeholder="ارسال امروز"> گارانتی <input name="dk_off[${n}][gar]"> امتیاز <input name="dk_off[${n}][rate]" type="number" step="0.1" max="5"></p>`;w.appendChild(d.firstChild);};</script>';
	}

	private static function offer_row( $i, $row ) {
		$row = wp_parse_args(
			$row,
			array(
				'name'  => '',
				'price' => '',
				'ship'  => '',
				'gar'   => '',
				'rate'  => '',
			)
		);
		printf(
			'<p class="dk-off-row">فروشنده <input name="dk_off[%1$d][name]" value="%2$s"> قیمت <input name="dk_off[%1$d][price]" type="number" value="%3$s"> ارسال <input name="dk_off[%1$d][ship]" value="%4$s"> گارانتی <input name="dk_off[%1$d][gar]" value="%5$s"> امتیاز <input name="dk_off[%1$d][rate]" type="number" step="0.1" max="5" value="%6$s"></p>',
			(int) $i,
			esc_attr( $row['name'] ),
			esc_attr( $row['price'] ),
			esc_attr( $row['ship'] ),
			esc_attr( $row['gar'] ),
			esc_attr( $row['rate'] )
		);
	}

	public static function save_offers( $post_id ) {
		if ( ! isset( $_POST['vira_dk_offers_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['vira_dk_offers_nonce'] ) ), 'vira_dk_offers' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		$raw = isset( $_POST['dk_off'] ) ? wp_unslash( $_POST['dk_off'] ) : array();
		$out = array();
		if ( is_array( $raw ) ) {
			foreach ( $raw as $row ) {
				if ( empty( $row['name'] ) ) {
					continue;
				}
				$out[] = array(
					'name'  => sanitize_text_field( $row['name'] ),
					'price' => sanitize_text_field( $row['price'] ?? '' ),
					'ship'  => sanitize_text_field( $row['ship'] ?? '' ),
					'gar'   => sanitize_text_field( $row['gar'] ?? '' ),
					'rate'  => sanitize_text_field( $row['rate'] ?? '' ),
				);
			}
		}
		update_post_meta( $post_id, '_vira_dk_offers', $out );
	}

	public static function render_offers() {
		global $product;
		if ( ! $product ) {
			return;
		}
		$rows = get_post_meta( $product->get_id(), '_vira_dk_offers', true );
		if ( empty( $rows ) || ! is_array( $rows ) ) {
			$rows = array(
				array(
					'name'  => get_bloginfo( 'name' ),
					'price' => $product->get_price(),
					'ship'  => 'ارسال فروشگاه',
					'gar'   => 'گارانتی اصالت و سلامت فیزیکی',
					'rate'  => '4.6',
				),
			);
		}
		echo '<div class="dk-sellers"><h3>فروشندگان این کالا</h3>';
		foreach ( $rows as $r ) {
			echo '<div class="dk-seller">';
			echo '<div class="dk-s-name">' . esc_html( $r['name'] ) . '<small>رضایت ' . esc_html( $r['rate'] ?: '—' ) . '</small></div>';
			echo '<div class="dk-s-meta">' . esc_html( $r['ship'] ) . '<br>' . esc_html( $r['gar'] ) . '</div>';
			echo '<div class="dk-s-price">' . ( function_exists( 'wc_price' ) ? wc_price( $r['price'] ) : esc_html( $r['price'] ) ) . '</div>';
			echo '</div>';
		}
		echo '</div>';
	}

	public static function amazing_badge() {
		global $product;
		if ( $product && $product->is_on_sale() ) {
			echo '<div class="dk-amazing-tag">شگفت‌انگیز</div>';
		}
	}

	public static function loop_timer() {
		global $product;
		if ( ! $product ) {
			return;
		}
		$end = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
		if ( $end ) {
			echo '<div class="dk-timer" data-end="' . esc_attr( (int) $end ) . '"></div>';
		}
	}

	public static function cart_shipping_bar() {
		if ( ! class_exists( 'WooCommerce' ) || ! WC()->cart ) {
			return;
		}
		$th = (int) prk_option( 'vira_free_ship_threshold', 500000 );
		$sub = (float) WC()->cart->get_displayed_subtotal();
		$left = max( 0, $th - $sub );
		$pct = $th ? min( 100, round( ( $sub / $th ) * 100 ) ) : 100;
		echo '<div class="dk-shipbar"><div class="dk-shipbar-in" style="width:' . esc_attr( $pct ) . '%"></div></div>';
		if ( $left > 0 ) {
			echo '<p class="dk-shipmsg">فقط ' . wp_kses_post( wc_price( $left ) ) . ' تا ارسال رایگان</p>';
		} else {
			echo '<p class="dk-shipmsg ok">ارسال این سفارش رایگان شد</p>';
		}
		echo '<div class="dk-nextcart"><button type="button" class="dk-next-open">خرید بعدی</button><div class="dk-next-list" id="dkNextList"></div></div>';
	}

	public static function review_upload_field( $field ) {
		if ( ! is_product() ) {
			return $field;
		}
		$field .= '<p class="dk-rev-up"><label>عکس خریدار<br><input type="file" name="vira_dk_review_img" accept="image/*"></label></p>';
		$field .= '<p class="dk-rev-filters" id="dkRevFilters"><button type="button" data-f="all">همه</button><button type="button" data-f="photo">دارای عکس</button><button type="button" data-f="buyer">خریداران</button></p>';
		return $field;
	}

	public static function save_review_media( $comment_id, $approved, $data ) {
		if ( empty( $_FILES['vira_dk_review_img']['tmp_name'] ) ) {
			return;
		}
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		$att = media_handle_upload( 'vira_dk_review_img', $data['comment_post_ID'] ?? 0 );
		if ( ! is_wp_error( $att ) ) {
			add_comment_meta( $comment_id, 'vira_dk_img', (int) $att );
		}
		if ( ! empty( $data['user_id'] ) && function_exists( 'wc_customer_bought_product' ) ) {
			$u     = get_userdata( $data['user_id'] );
			$email = $u ? $u->user_email : '';
			$bought = wc_customer_bought_product( $email, $data['user_id'], $data['comment_post_ID'] );
			add_comment_meta( $comment_id, 'vira_dk_buyer', $bought ? '1' : '0' );
		}
	}

	public static function review_media( $comment ) {
		$id = get_comment_meta( $comment->comment_ID, 'vira_dk_img', true );
		$buyer = get_comment_meta( $comment->comment_ID, 'vira_dk_buyer', true );
		$cls = 'dk-rev';
		if ( $id ) {
			$cls .= ' has-photo';
		}
		if ( '1' === $buyer ) {
			$cls .= ' is-buyer';
		}
		echo '<div class="' . esc_attr( $cls ) . '">';
		if ( $id ) {
			echo wp_get_attachment_image( (int) $id, 'medium' );
		}
		if ( '1' === $buyer ) {
			echo '<span class="dk-buyer-tag">خریدار</span>';
		}
		echo '</div>';
	}

	public static function footer_widgets() {
		$cats = self::cats( 10 );
		echo '<div id="dkMega" class="dk-mega" hidden><div class="dk-mega-in">';
		echo '<aside>';
		foreach ( $cats as $t ) {
			echo '<a href="' . esc_url( get_term_link( $t ) ) . '">' . esc_html( $t->name ) . '</a>';
		}
		echo '</aside><div class="dk-mega-main">';
		if ( $cats ) {
			$children = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $cats[0]->term_id, 'hide_empty' => false, 'number' => 20 ) );
			if ( ! is_wp_error( $children ) ) {
				foreach ( $children as $c ) {
					echo '<a href="' . esc_url( get_term_link( $c ) ) . '">' . esc_html( $c->name ) . '</a>';
				}
			}
		}
		echo '</div></div></div>';
		echo '<div id="dkSearchDrop" class="dk-search-drop" hidden></div>';
	}
}

Vira_Digikala_Layer::init();
