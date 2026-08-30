<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

global $post;
global $product;
global $woocommerce;
$attributes     = $product->get_attributes();
$export         = get_the_excerpt( $product->get_id() );
$the_content    = get_the_content();
$has_short_content = (bool) trim( $the_content );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! empty( $product_tabs ) ) : ?>

	<?php if ( prk_option('prk_tab_content_styles') !== 'default' && mobile_cheker() || tablet_cheker() ): ?>

		<div id="WooCommerce_tabs_mobiles" class="ws-tabs-mobiles">

		<div class="product-tab-nav-mobiles">
				<ul class="mobile-wc-tabs">
					<?php foreach ( $product_tabs as $key => $product_tab ) :?>
						<?php
						// هر بار اول خالی‌اش کن
						$class_events = '';

						// اگه اصلاً محتوایی نیست، کلاس مخفی‌کننده رو اضافه کن
						if ( ! $has_short_content ) {
							$class_events = 'hide-short-tab';
						}
						?>

						<?php

						do_action( 'prk_item_mobile_product_tabs_'.$key.'' );

							?>

						<li class="nav-item_mobile <?php echo esc_attr( $key ); ?>_tab <?= $class_events?>" id="tab-title-<?php echo esc_attr( $key ); ?>">

				<div class="flexed wc_mobile_nav_tab">
								<h4><?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?></h4>
								<span data-remodal-target="mob_tab_<?php echo esc_attr( $key ); ?>" class="open_ws_tab_mobile">نمایش بیشتر <i class="ri-external-link-line"></i></span>
							</div>

							<div class="short_content_tabs_mobile">
							<?php
							if ( isset( $product_tab['callback'] ) ) {
								call_user_func( $product_tab['callback'], $key, $product_tab );
							}
							?>
							</div>

						</li>
					<?php endforeach; ?>
				</ul>
		</div>

			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>

				<div id="tab-content-mobile" class="remodal tabs_content_product <?php echo esc_attr( $key ); ?> remodal-full" data-remodal-id="mob_tab_<?php echo esc_attr( $key ); ?>"  data-remodal-options="hashTracking: false">
					<div class="remodal-header">
						<div class="title"><?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?></div>
							<button data-remodal-action="close" class="remodal-back-tabs">بازگشت<i class="ri-arrow-left-s-line"></i></button>
					</div>

			<div class="pading-tabs">
					<?php
					if ( isset( $product_tab['callback'] ) ) {
						call_user_func( $product_tab['callback'], $key, $product_tab );
					}
					?>
			</div>
				</div>

			<?php endforeach; ?>

		</div>

	<?php endif;?>

	<?php if ( prk_option('prk_tab_content_styles') == 'default' ): ?>

				<div id="woocommerce-tabs" class="woocommerce-tabs wc-tabs-wrapper">
					<div class="prk_element_inline"></div>
				<div class="product-tabs">
						<ul class="nav nav-pills tabs wc-tabs" role="tablist">
							<?php foreach ( $product_tabs as $key => $product_tab ) :?>
								<li class="nav-item <?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
									<a class="nav-link" href="#tab-<?php echo esc_attr( $key ); ?>" data-scroll="tab-<?php echo esc_attr( $key ); ?>">
										<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
				</div>

					<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
						<div class="tab-content woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>" id="tab-<?php echo esc_attr( $key ); ?>">
							<?php
							if ( isset( $product_tab['callback'] ) ) {
								call_user_func( $product_tab['callback'], $key, $product_tab );
							}
							?>
						</div>

					<?php endforeach; ?>

				</div>

    <?php else:?>
        <?php if ( empty(mobile_cheker()) && empty(tablet_cheker()) ): ?>
		<div id="woocommerce-tabs" class="woocommerce-tabs wc-tabs-wrapper">
					<div class="prk_element_inline"></div>
				<div class="product-tabs">
						<ul class="nav nav-pills tabs wc-tabs" role="tablist">
							<?php foreach ( $product_tabs as $key => $product_tab ) :?>
								<li class="nav-item <?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
									<a class="nav-link" href="#tab-<?php echo esc_attr( $key ); ?>" data-scroll="tab-<?php echo esc_attr( $key ); ?>">
										<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
				</div>

					<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
						<div class="tab-content woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>" id="tab-<?php echo esc_attr( $key ); ?>">
							<?php
							if ( isset( $product_tab['callback'] ) ) {
								call_user_func( $product_tab['callback'], $key, $product_tab );
							}
							?>
						</div>

					<?php endforeach; ?>

		</div>
		<?php endif; ?>

	<?php endif; ?>

<?php do_action( 'woocommerce_product_after_tabs' ); ?>


<?php endif; ?>
