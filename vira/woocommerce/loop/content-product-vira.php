<?php
/**
 * Vira Theme Next-Gen Iranian Product Card Template ([VIRA-04])
 * Overrides standard WooCommerce product loop item.
 *
 * @package Vira
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Direct access not allowed.
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$brand_name = '';
if ( function_exists( 'woodmart_get_product_brand_name' ) ) {
    $brand_name = woodmart_get_product_brand_name( $product->get_id() );
}
if ( empty( $brand_name ) ) {
    $brand_name = 'برند رسمی';
}

$rating_val = $product->get_average_rating();
if ( ! $rating_val ) {
    $rating_val = '۴.۵';
} else {
    $rating_val = vira_to_persian_num( number_format( $rating_val, 1 ) );
}

$discount_percent = 0;
if ( $product->is_on_sale() && $product->get_regular_price() > 0 ) {
    $discount_percent = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
}
?>
<div <?php wc_product_class( 'wd-iran-product-card wd-hover-base vira-product-item', $product ); ?> data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
    <div class="card-image-wrapper">
        <!-- Badges -->
        <div class="card-badges">
            <?php if ( $product->is_on_sale() ) : ?>
                <span class="badge badge-special">شگفت‌انگیز</span>
            <?php endif; ?>
            <span class="badge badge-shipping">ارسال امروز</span>
        </div>

        <!-- Thumbnail Link -->
        <a href="<?php echo esc_url( get_permalink() ); ?>" class="product-image-link">
            <?php woocommerce_template_loop_product_thumbnail(); ?>
        </a>

        <!-- Quick actions -->
        <div class="card-quick-actions" style="position: absolute; bottom: 10px; left: 10px; display: flex; gap: 4px; opacity: 0; transition: opacity 0.2s;">
            <?php if ( function_exists( 'woodmart_add_to_wishlist_button' ) ) { woodmart_add_to_wishlist_button(); } ?>
            <?php if ( function_exists( 'woodmart_add_to_compare_button' ) ) { woodmart_add_to_compare_button(); } ?>
        </div>
    </div>

    <div class="card-content-wrapper">
        <!-- Brand & Rating -->
        <div class="card-meta" style="display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: #64748b; margin-top: 8px;">
            <span class="product-brand"><?php echo esc_html( $brand_name ); ?></span>
            <div class="product-rating" style="color: #f59e0b; font-weight: bold;">
                <span class="rating-value"><?php echo esc_html( $rating_val ); ?></span>
                <i class="xts-i-star"></i>
            </div>
        </div>

        <!-- Title -->
        <h3 class="product-title">
            <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
        </h3>

        <!-- Swatches placeholder -->
        <div class="product-swatches-mini" style="margin: 6px 0;">
            <?php if ( function_exists( 'woodmart_swatches_list' ) ) { woodmart_swatches_list(); } ?>
        </div>

        <!-- Transparent Iranian Pricing -->
        <div class="product-pricing-wrapper">
            <?php if ( $product->is_on_sale() && $discount_percent > 0 ) : ?>
                <div class="price-discount-row">
                    <del class="old-price"><?php echo wc_price( $product->get_regular_price() ); ?></del>
                    <span class="discount-badge"><?php echo esc_html( vira_to_persian_num( $discount_percent ) ); ?>٪</span>
                </div>
            <?php endif; ?>
            <div class="final-price-row">
                <ins class="current-price"><?php echo wc_price( $product->get_price() ); ?></ins>
            </div>
        </div>

        <!-- Add to Cart AJAX Button -->
        <div class="card-footer-actions" style="margin-top: 10px;">
            <?php woocommerce_template_loop_add_to_cart( array( 'class' => 'button alt wd-add-to-cart vira-card-btn' ) ); ?>
        </div>
    </div>
</div>
