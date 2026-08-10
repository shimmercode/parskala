<?php
/**
 * Mini-cart
 * 
 * @author  NasaTheme
 * @package prk-theme/WooCommerce
 * @version 10.0.0
 */

if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

global $nasa_opt;

do_action('woocommerce_before_mini_cart');

if (!WC()->cart->is_empty()) : ?>
    <div class="nasa-minicart-items">
        <div class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>">
            <?php
            do_action('woocommerce_before_mini_cart_contents');

            $cart_items = WC()->cart->get_cart();
            
            foreach ($cart_items as $cart_item_key => $cart_item) :
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) :
                    
                    /**
                     * Filter the product name.
                     *
                     * @param string $product_name Name of the product in the cart.
                     */
                    $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                    $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    ?>
                    
                <div class="flexed mini-cart-item woocommerce-mini-cart-item <?php echo esc_attr(apply_filters('woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key)); ?>">

                    <div class="prk-image-cart-item flexed">
                        <?php
                            echo apply_filters('woocommerce_cart_item_remove_link',
                                sprintf(
                                    '<a href="%s" class="remove remove_product_mini_cart remove_from_cart_button item-in-cart nasa-stclose small" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><i class="ri-close-line"></i></a>',
                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                    /* translators: %s is the product name */
                                    esc_attr(sprintf(__('Remove %s from cart', 'elessi-theme'), $product_name)),
                                    esc_attr($product_id),
                                    esc_attr($cart_item_key),
                                    esc_attr($_product->get_sku())
                                ), $cart_item_key);
                        ?>
                        <?php echo $thumbnail; ?>
                    </div>

                        <div class="prk-info-cart-item padding-left-15 rtl-padding-left-0 rtl-padding-right-15">
                            <div class="mini-cart-info">
                                <div class="nasa-flex jbw align-start">
                                    <?php if (empty($product_permalink)) : ?>
                                        <span class="product-name nasa-bold"><?php echo wp_kses_post($product_name); ?></span>
                                    <?php else : ?>
                                        <a class="product-name nasa-bold" href="<?php echo esc_url($product_permalink); ?>" title="<?php echo esc_attr($product_name); ?>">
                                            <?php echo wp_kses_post($product_name); ?>
                                        </a>
                                    <?php endif; ?>

                                        
                                    </span>

                                <?php echo wc_get_formatted_cart_item_data($cart_item); ?>

                                <?php
                                if ($product_price) :
                                    echo '<div class="flexed mini-cart-item-price">';
                                
                   
                                    
                                    /**
                                     * Qty input
                                     * Elessi Theme Support
                                     */
                      
                                        $quantily_show = false;
                                        $wrap = true;
                                    
                                        if ($_product->is_sold_individually()) :
                                            $min_quantity = 1;
                                            $max_quantity = 1;
                                        else :
                                            $min_quantity = 0;
                                            $max_quantity = $_product->get_max_purchase_quantity();
                                        endif;
                                        
                                        $product_quantity = woocommerce_quantity_input(
                                            array(
                                                'input_name'   => 'cart[' . $cart_item_key . '][qty]',
                                                'input_value'  => $cart_item['quantity'],
                                                'max_value'    => $max_quantity,
                                                'min_value'    => $min_quantity,
                                                'product_name' => $_product->get_name(),
                                                'mini_cart'    => true
                                            ),
                                            $_product,
                                            false
                                        );
                                        
                                        echo '<div class="quantity-wrap flexed">';
                                        
                                   

                                    echo apply_filters('woocommerce_widget_cart_item_quantity', '<div class="cart_list_product_quantity">' . ($quantily_show ? sprintf('%s &times; %s', $cart_item['quantity'], $product_price) : sprintf( $product_price)) . '</div>', $cart_item, $cart_item_key);
                              
                                    echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.

                                    echo $wrap ? '</div>' : '';
                                    /**
                                     * SubTotal
                                     * Elessi Theme Support
                                     */
                                    // if ((!isset($nasa_opt['mini_cart_subtotal']) || $nasa_opt['mini_cart_subtotal'])) :
                               
                                    // endif;
                                    
                                    echo '</div></div>';
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                <?php
                endif;
            endforeach;

            do_action('woocommerce_mini_cart_contents');
            ?>

        </div>
    </div>
    
    <div class="nasa-minicart-footer">
        <?php do_action('nasa_mini_cart_before_total'); ?>
        
        <div class="minicart_total_checkout woocommerce-mini-cart__total total">
            <?php
            /**
             * Woocommerce_widget_shopping_cart_total hook.
             *
             * @removed woocommerce_widget_shopping_cart_subtotal - 10
             * @hooked elessi_widget_shopping_cart_subtotal - 10
             * @hooked elessi_subtotal_free_shipping - 20
             */
            do_action('woocommerce_widget_shopping_cart_total');
            ?>
        </div>
        <div class="btn-mini-cart inline-lists text-center">
            <?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>

            <p class="woocommerce-mini-cart__buttons buttons">
                <?php do_action('woocommerce_widget_shopping_cart_buttons'); ?>
            </p>

            <?php do_action('woocommerce_widget_shopping_cart_after_buttons'); ?>
        </div>
    </div>
<?php
/**
 * Empty cart
 */
else :
    $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
?>

<div class="cart-empty">
    <img src="<?= parskala_IMG ?>empty-cart.svg" width="84" height="133" alt="empty-cart">        <p>هیچ محصولی در سبد خرید نیست.</p>
    <div>جهت مشاهده محصولات بیشتر به صفحات زیر مراجعه نمایید.</div>
    <ul>
        <li>
            <a href="<?php bloginfo('url') ?>">صفحه اصلی</a>
        </li>
        <li class="separator"></li>
        <li>
            <a href="<?= $shop_page_url ?>">فروشگاه</a>
        </li>
    </ul>
</div>
<?php endif;


do_action('woocommerce_after_mini_cart');
