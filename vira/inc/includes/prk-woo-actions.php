<?php

add_action('nasa_mini_cart_before_total', 'elessi_ext_mini_cart', 5);
add_action('woocommerce_widget_shopping_cart_total', 'elessi_widget_shopping_cart_subtotal', 10);
add_action('woocommerce_widget_shopping_cart_total', 'elessi_widget_shopping_cart_ext', 15);

/**
 * Fix missing div.widget_shopping_cart_content in fragments
 */
add_filter('woocommerce_add_to_cart_fragments', 'elessi_add_widget_shopping_cart_content', 9999);
if (!function_exists('elessi_add_widget_shopping_cart_content')) :
    function elessi_add_widget_shopping_cart_content($fragments) {
       
            global $nasa_opt;
            
     
            
            // Hook fix Missing fragments[div.widget_shopping_cart_content]
            if (apply_filters('ns_fix_missing_wscc', true)) {
                ob_start();
                woocommerce_mini_cart();
                $mini_cart = ob_get_clean();

                $fragments['div.widget_shopping_cart_content'] = '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>';
            }
        
        
        return $fragments;
    }
endif;






/**
 * shopping cart subtotal
 */
if (!function_exists('elessi_widget_shopping_cart_subtotal')) :
    function elessi_widget_shopping_cart_subtotal() {
        $prk_option = get_option('prk_option');

        if ( isset($prk_option['mini_cart_total_price']) && $prk_option['mini_cart_total_price'] ){
            echo '<div class="total-price-label-wrap flexed">';
            echo '<span class="total-price-label">' . esc_html__('قیمت کالاها', 'elessi-theme') . '</span>';
            echo '<span class="total-price right">' . WC()->cart->get_cart_subtotal() . '</span>';
            echo '</div>';
        }


    }
endif;

/**
 * shopping cart ext
 */
if (!function_exists('elessi_widget_shopping_cart_ext')) :
    function elessi_widget_shopping_cart_ext() {
        global $nasa_opt;
        
  
        
        /**
         * Coupon
         */
            $file = PARSKALA_CHILD_PATH . '/inc/includes/nasa-mini-cart-coupons.php';
            include  PARSKALA_INC_TEMPLATEPATH . '/includes/nasa-mini-cart-coupons.php';
        
        
        /**
         * Shipping
         */
            $file = PARSKALA_CHILD_PATH . '/inc/includes/nasa-mini-cart-shipping.php';
            include  PARSKALA_INC_TEMPLATEPATH . '/includes/nasa-mini-cart-shipping.php';
        
        
        /**
         * Fees
         */
        $file = PARSKALA_CHILD_PATH . '/inc/includes/nasa-mini-cart-fees.php';
        include  PARSKALA_INC_TEMPLATEPATH . '/includes/nasa-mini-cart-fees.php';

        /**
         * Tax
         */
        $file = PARSKALA_CHILD_PATH . '/inc/includes/nasa-mini-cart-taxs.php';
        include PARSKALA_INC_TEMPLATEPATH . '/includes/nasa-mini-cart-taxs.php';

        /**
         * Total
         */
        $file = PARSKALA_CHILD_PATH . '/inc/includes/nasa-mini-cart-total.php';
        include  PARSKALA_INC_TEMPLATEPATH . '/includes/nasa-mini-cart-total.php';
    }
endif;

/**
 * Extend Mini Cart From Cart
 */

    function elessi_ext_mini_cart() {

        $prk_option = get_option('prk_option');
        
        $ext_content = '';
        
        /**
         * 
         * Add Note
         */
        if ( isset($prk_option['mini_cart_notie']) && $prk_option['mini_cart_notie'] && apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'))) {
            $ext_content .= '<a href="javascript:void(0);" class="ext-mini-cart mini-cart-note flexed-clomen" data-act="note" rel="nofollow"><i class="prk-receipt-edit"></i>' . esc_html__('یاداشت', 'parskala') . '</a>';
            $ext_content .= '<span class="nssp"></span>';
        }
        
        /**
         * Add Shipping
         */
 
            $shipping_enable = 'no' === get_option('woocommerce_enable_shipping_calc') || ! WC()->cart->needs_shipping() ? false : true;
            if ( isset($prk_option['mini_cart_shipping']) && $prk_option['mini_cart_shipping'] && $shipping_enable) {
                $ext_content .= '<a href="javascript:void(0);" class="ext-mini-cart mini-cart-shipping flexed-clomen" data-act="shipping" rel="nofollow"><i class="prk-truck-fast"></i>' . esc_html__('حمل و نقل', 'parskala') . '</a>';
                $ext_content .= '<span class="nssp"></span>';
            }
        
        
        /**
         * Add Coupon
         */
        if ( isset($prk_option['mini_cart_coupon']) && $prk_option['mini_cart_coupon'] && wc_coupons_enabled()) {
            $ext_content .= '<a href="javascript:void(0);" class="ext-mini-cart mini-cart-coupon flexed-clomen" data-act="coupon" rel="nofollow"><i class="prk-tag-2"></i>' . esc_html__('کوپن', 'parskala') . '</a>';
        }
        
        /**
         * Output
         */
        if ($ext_content) {
            echo '<div class="ext-mini-cart-wrap flexed">' . $ext_content . '</div>';
        }
    }


/**
 * Get orders_comments from session
 */
add_filter('default_checkout_order_comments', 'elessi_order_comments_session');
if (!function_exists('elessi_order_comments_session')) :
    function elessi_order_comments_session($value) {
        $note = WC()->session->get('nasa_order_comments');
        return $note ? $note : $value;
    }
endif;

/**
 * Clear session nasa_order_comments
 */
add_action('woocommerce_thankyou', 'elessi_order_comments_session_clear');
if (!function_exists('elessi_order_comments_session_clear')) :
    function elessi_order_comments_session_clear() {
        WC()->session->set('nasa_order_comments', null);
    }
endif;



/**
 * enqueue scripts
 */
add_action( 'wp_enqueue_scripts', function () {

    $prk_option = get_option('prk_option');
    $prefix = 'prk-directory-js';
    $mini_cart_note = isset($prk_option['mini_cart_notie']) && $prk_option['mini_cart_notie'] ? true : false;
    $mini_cart_shipping = isset($prk_option['mini_cart_shipping']) && $prk_option['mini_cart_shipping'] ? true : false;
    $mini_cart_coupon = isset($prk_option['mini_cart_coupon']) && $prk_option['mini_cart_coupon'] ? true : false;
    if ($mini_cart_note || $mini_cart_shipping || $mini_cart_coupon) {
        wp_enqueue_style('select2');
        wp_enqueue_script('selectWoo');
        // wp_enqueue_script('wc-country-select');


        wp_enqueue_script( 'prk-ext-mini-cart', get_template_directory_uri() . '/assets/js/ext-mini-cart.js', array ( 'jquery' ),PRK_VERSION, true);
    }

});



/**
 * Update quantity mini cart
 */
add_action('wp_ajax_woocommerce_nasa_quantity_mini_cart' ,'nasa_quantity_mini_cart');
add_action('wp_ajax_nopriv_nasa_quantity_mini_cart' ,'nasa_quantity_mini_cart');
add_action('wc_ajax_nasa_quantity_mini_cart', 'nasa_quantity_mini_cart');
function nasa_quantity_mini_cart() {
    if (!isset($_REQUEST['hash']) || !isset($_REQUEST['quantity'])) {
        wp_die();
    }
    
    // Set item key as the hash found in input.qty's name
    $cart_item_key = $_REQUEST['hash'];

    // Get the array of values owned by the product we're updating
    $product_values = WC()->cart->get_cart_item($cart_item_key);

    // Get the quantity of the item in the cart
    $product_quantity = apply_filters('woocommerce_stock_amount_cart_item', apply_filters('woocommerce_stock_amount', preg_replace("/[^0-9\.]/", '', filter_var($_REQUEST['quantity'], FILTER_SANITIZE_NUMBER_INT))), $cart_item_key);

    // Update cart validation
    $passed_validation  = apply_filters('woocommerce_update_cart_validation', true, $cart_item_key, $product_values, $product_quantity);

    // Update the quantity of the item in the cart
    if ($passed_validation) {
        WC()->cart->set_quantity($cart_item_key, $product_quantity, true);
    }
    
    // do_action('woocommerce_update_quantity_mini_cart');

    // Return fragments
    ob_start();
    woocommerce_mini_cart();
    $mini_cart = ob_get_clean();

    $woo_notices = wc_print_notices(true);
    
    $woo_mess = empty($woo_notices) ? '<div class="woocommerce-message text-center" role="alert">' . esc_html__('Product quantity updated successfully!', 'elessi-theme') . '</div>' : $woo_notices;
    
    if (isset($_REQUEST['no-mess']) && $_REQUEST['no-mess']) {
        $woo_mess = false;
    }

    // Fragments and mini cart are returned
    $data = array(
        'fragments' => apply_filters(
            'woocommerce_add_to_cart_fragments',
            array(
                'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
            )
        ),
        'cart_hash' => WC()->cart->get_cart_hash(),
    );
    
    if ($woo_mess) {
        $data['woocommerce_add_to_cart_fragments']['.woocommerce-message'] = $woo_mess;
    }
    
    if (WC()->cart->is_empty()) {
        $data['url_redirect'] = apply_filters('nasa_url_redirect_after_update_quantity', esc_url(wc_get_cart_url()));
    }

    wp_send_json($data);
}



/**
 * ext mini cart node
 */
add_action('wp_ajax_woocommerce_nasa_ext_mini_cart' ,'nasa_ext_mini_cart');
add_action('wp_ajax_nopriv_woocommerce_nasa_ext_mini_cart' ,'nasa_ext_mini_cart');
add_action('wc_ajax_nasa_ext_mini_cart', 'nasa_ext_mini_cart');

function nasa_ext_mini_cart() {
            if (!isset($_REQUEST['act']) || !isset($_REQUEST['act'])) {
                wp_die();
            }
            
            $_act = $_REQUEST['act'];
            
            $content = '<div class="ext-node mini-cart-' . esc_attr($_act) . '">';
            $content .= '<a href="javascript:void(0);" title="Close" class="nasa-close-node nasa-stclose" rel="nofollow"> <i class="ri-close-line"></i></a>';
            
            /**
             * Note
             */
            if ($_act == 'note') {
                ob_start();
                $file = PARSKALA_CHILD_PATH . '/includes/nasa-mini-cart-note.php';
                include  PARSKALA_INC_TEMPLATEPATH . '/includes/nasa-mini-cart-note.php';
                $content .= ob_get_clean();
            }
            
            /**
             * Shipping
             */
            if ($_act == 'shipping') {
                $content .= '<p class="node-title nasa-bold fs-20">' . esc_html__( prk_option('mini_cart_title_shipping') ? prk_option('mini_cart_title_shipping') : 'انتخاب آدرس حمل و نقل' ) . '</p>';
                ob_start();
                woocommerce_shipping_calculator();
                $content .= ob_get_clean();
            }
            
            /**
             * Coupon
             */
            if ($_act == 'coupon') {
                ob_start();
                $file = PARSKALA_CHILD_PATH . '/includes/nasa-mini-cart-add-coupon.php';
                include  PARSKALA_INC_TEMPLATEPATH . '/includes/nasa-mini-cart-add-coupon.php';
                $content .= ob_get_clean();
            }
            
            $content .= '</div>';
            
            $data = array(
                'content' => $content
            );
            
            wp_send_json($data);
}


/**
 * ext mini cart node
 */
add_action('wp_ajax_woocommerce_nasa_all_ext_mini_cart' ,'nasa_all_ext_mini_cart');
add_action('wp_ajax_nopriv_woocommerce_nasa_all_ext_mini_cart' ,'nasa_all_ext_mini_cart');
add_action('wc_ajax_nasa_all_ext_mini_cart', 'nasa_all_ext_mini_cart');
function nasa_all_ext_mini_cart() {
            $prk_option = get_option('prk_option');
            
            $content = '';
            
            /**
             * Add Note
             */
            if ( isset($prk_option['mini_cart_notie']) && $prk_option['mini_cart_notie'] && apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'))) {

                $content .= '<div class="ext-node mini-cart-note">';
                $content .= '<a href="javascript:void(0);" title="Close" class="nasa-close-node nasa-stclose" rel="nofollow"><i class="ri-close-line"></i></a>';
                
                ob_start();
                $file = PARSKALA_CHILD_PATH . '/includes/nasa-mini-cart-note.php';
                include  PARSKALA_INC_TEMPLATEPATH . '/includes/nasa-mini-cart-note.php';
                $content .= ob_get_clean();
                
                $content .= '</div>';
            
            }
            /**
             * Add Shipping
             */
            if (
                isset($prk_option['mini_cart_shipping']) &&
                $prk_option['mini_cart_shipping']
            ) {
                $shipping_enable = 'no' === get_option('woocommerce_enable_shipping_calc') || !WC()->cart->needs_shipping() ? false : true;
                if ($shipping_enable) {                    $content .= '<div class="ext-node mini-cart-shipping">';
                    $content .= '<a href="javascript:void(0);" title="Close" class="nasa-close-node nasa-stclose" rel="nofollow"><i class="ri-close-line"></i></a>';
                    $content .= '<p class="node-title nasa-bold fs-20">' . esc_html__( prk_option('mini_cart_title_shipping') ? prk_option('mini_cart_title_shipping') : 'انتخاب آدرس حمل و نقل' ) . '</p>';
                    
                    ob_start();
                    woocommerce_shipping_calculator();
                    $content .= ob_get_clean();
                    
                    $content .= '</div>';
                }
            }
            
            /**
             * Add Coupon
             */
            if (isset($prk_option['mini_cart_coupon']) && $prk_option['mini_cart_coupon'] && wc_coupons_enabled()) {
                $content .= '<div class="ext-node mini-cart-coupon">';
                $content .= '<a href="javascript:void(0);" title="Close" class="nasa-close-node nasa-stclose" rel="nofollow"><i class="ri-close-line"></i></a>';
                
                ob_start();
                $file = PARSKALA_CHILD_PATH . '/includes/nasa-mini-cart-add-coupon.php';
                include  PARSKALA_INC_TEMPLATEPATH . '/includes/nasa-mini-cart-add-coupon.php';
                $content .= ob_get_clean();
                
                $content .= '</div>';
            }

            if ($content !== '') {
                $content .= mini_cart_get_ajax_nonce();
            }
        

            $data = array(
                'content' => $content
            );
            
            wp_send_json($data);
}
        


/**
 * ext mini cart Add Note
 */
add_action('wp_ajax_woocommerce_nasa_mini_cart_note' ,'nasa_mini_cart_note');
add_action('wp_ajax_nopriv_woocommerce_nasa_mini_cart_note' ,'nasa_mini_cart_note');
add_action('wc_ajax_nasa_mini_cart_note', 'nasa_mini_cart_note');

function nasa_mini_cart_note() {
    $note = isset($_POST['order_comments']) ? $_POST['order_comments'] : null;

    WC()->session->set('nasa_order_comments' , $note);

    // Fragments and mini cart are returned
    $data = array(
        'mess' => sprintf(
            '<div class="woocommerce-message" role="alert">%s</div>',
            esc_html__('یادداشت سفارش شما ذخیره شد.', 'parskala')
        )
    );

    wp_send_json($data);
}



/**
 * get List Coupons - Publish
 */
    function elessi_wc_publish_coupons() {
        
        $coupons = array();
        
            $coupons_fetch = explode("\n", prk_option('mini_cart_p_coupons'));
            
            if (!empty($coupons_fetch)) {
                foreach ($coupons_fetch as $coupon) {
                    $code = trim($coupon);
                    
                    $coupon_obj = new WC_Coupon($code);
                    
                    if ($coupon_obj instanceof WC_Coupon && $coupon_obj->get_id()) {
                        $coupons[] = $coupon_obj;
                    }
                }
            }
        
       
        return $coupons;
    }


    /**
 * ext mini cart Calculate Shipping
 */
add_action('wp_ajax_woocommerce_nasa_mini_cart_calculate_shipping' ,'nasa_mini_cart_calculate_shipping');
add_action('wp_ajax_nopriv_woocommerce_nasa_mini_cart_calculate_shipping' ,'nasa_mini_cart_calculate_shipping');
add_action('wc_ajax_nasa_mini_cart_calculate_shipping', 'nasa_mini_cart_calculate_shipping');
function nasa_mini_cart_calculate_shipping() {
    WC_Shortcode_Cart::calculate_shipping();
    
    // Return fragments
    ob_start();
    woocommerce_mini_cart();
    $mini_cart = ob_get_clean();

    // Fragments and mini cart are returned
    $data = array(
        'fragments' => apply_filters(
            'woocommerce_add_to_cart_fragments',
            array(
                'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
            )
        ),
        'cart_hash' => WC()->cart->get_cart_hash(),
        'mess' => wc_print_notices(true)
    );

    wp_send_json($data);
}

    /**
 * ext mini cart Remove Coupon
 */
add_action('wp_ajax_woocommerce_nasa_mini_cart_apply_coupon' ,'nasa_mini_cart_apply_coupon');
add_action('wp_ajax_nopriv_woocommerce_nasa_mini_cart_apply_coupon' ,'nasa_mini_cart_apply_coupon');
add_action('wc_ajax_nasa_mini_cart_apply_coupon', 'nasa_mini_cart_apply_coupon');
function nasa_mini_cart_apply_coupon() {
    check_ajax_referer('apply-coupon', 'security');

    $coupon = isset($_POST['coupon_code']) ? wc_format_coupon_code(wp_unslash($_POST['coupon_code'])) : null;

    if (empty($coupon)) {
        wc_add_notice(WC_Coupon::get_generic_coupon_error(WC_Coupon::E_WC_COUPON_PLEASE_ENTER), 'error');
    } else {
        WC()->cart->add_discount($coupon);
    }
    
    $mess = wc_print_notices(true);
    
    // Return fragments
    ob_start();
    woocommerce_mini_cart();
    $mini_cart = ob_get_clean();

    // Fragments and mini cart are returned
    $data = array(
        'fragments' => apply_filters(
            'woocommerce_add_to_cart_fragments',
            array(
                'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
            )
        ),
        'cart_hash' => WC()->cart->get_cart_hash(),
        'mess' => $mess
    );

    wp_send_json($data);
}

/**
 * ext mini cart Remove Coupon
 */
add_action('wp_ajax_woocommerce_nnasa_mini_cart_remove_coupon' ,'nasa_mini_cart_remove_coupon');
add_action('wp_ajax_nopriv_woocommerce_nasa_mini_cart_remove_coupon' ,'nasa_mini_cart_remove_coupon');
add_action('wc_ajax_nasa_mini_cart_remove_coupon', 'nasa_mini_cart_remove_coupon');
function nasa_mini_cart_remove_coupon() {
    check_ajax_referer('remove-coupon', 'security');

    $coupon = isset($_POST['coupon']) ? wc_format_coupon_code(wp_unslash($_POST['coupon'])) : null;

    if (empty($coupon)) {
        $mess = sprintf(
            '<div class="woocommerce-message nasa-error" role="alert">%s</div>',
            esc_html__('Sorry there was a problem removing this coupon.', 'elessi-theme')
        );
    } else {
        WC()->cart->remove_coupon($coupon);
        
        $mess = sprintf(
            '<div class="woocommerce-message" role="alert">%s</div>',
            esc_html__('کوپن با موفقیت حذف شد.', 'elessi-theme')
        );
        
        WC()->cart->calculate_totals();
    }
    
    // Return fragments
    ob_start();
    woocommerce_mini_cart();   
    $mini_cart = ob_get_clean();

    // Fragments and mini cart are returned
    $data = array(
        'fragments' => apply_filters(
            'woocommerce_add_to_cart_fragments',
            array(
                'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
            )
        ),
        'cart_hash' => WC()->cart->get_cart_hash(),
        'mess' => $mess
    );

    wp_send_json($data);
}

        /**
         * get_ajax_nonce
         */
function mini_cart_get_ajax_nonce() {
    $ajax_none = '<div class="mini-cart-ajax-nonce hidden">';
    $ajax_none .= '<input type="hidden" name="update_shipping_method_nonce" value="' . esc_attr(wp_create_nonce('update-shipping-method')) . '" />';
    $ajax_none .= '<input type="hidden" name="apply_coupon_nonce" value="' . esc_attr(wp_create_nonce('apply-coupon')) . '" />';
    $ajax_none .= '<input type="hidden" name="remove_coupon_nonce" value="' . esc_attr(wp_create_nonce('remove-coupon')) . '" />';
    $ajax_none .= '</div>';
    
    return $ajax_none;
}






/**
 * Compatible WooCommerce_Advanced_Free_Shipping
 * Only with one Rule "subtotal >= Rule"
 */
// add_action('nasa_subtotal_free_shipping', 'elessi_subtotal_free_shipping');
add_action('woocommerce_widget_shopping_cart_total', 'elessi_subtotal_free_shipping', 20);
if (!function_exists('elessi_subtotal_free_shipping')) :
    function elessi_subtotal_free_shipping($return = false) {
        $prk_option = get_option('prk_option');
        $content = '';
        
        /**
         * Check active plug-in WooCommerce || WooCommerce_Advanced_Free_Shipping
         */
        if ( !class_exists('WooCommerce_Advanced_Free_Shipping') || !function_exists('WAFS')) {
            return $content;
        }

        if ( !$prk_option['mini_cart_shipping_free'] ) {
            return;
        }
        /**
         * Check setting plug-in
         */
        $wafs = WAFS();
        if (!isset($wafs->was_method)) {
            $wafs->wafs_free_shipping();
        }
        
        $wafs_method = isset($wafs->was_method) ? $wafs->was_method : null;
        if (!$wafs_method || $wafs_method->enabled === 'no') {
            return $content;
        }

        /**
         * Check has
         */
        $wafs_posts = get_posts(array(
            // 'posts_per_page'    => 2,
            'post_status'       => 'publish',
            'post_type'         => 'wafs'
        ));
        
        if (!$wafs_posts || count($wafs_posts) < 1) {
            return $content;
        }
        
        $value = 0;

        /**
         * Check and Rules
         */
        foreach ($wafs_posts as $wafs_post) {
            $condition_groups = get_post_meta($wafs_post->ID, '_wafs_shipping_method_conditions', true);
            if (!$condition_groups || count($condition_groups) !== 1) {
                continue;
            }
            
            $condition_group = reset($condition_groups);
            if (!$condition_group || count($condition_group) !== 1) {
                continue;
            }
            
            /**
             * Check rule is subtotal
             */
            foreach ($condition_group as $condition) {
                if ($condition['condition'] !== 'subtotal' || $condition['operator'] !== '>=' || !$condition['value']) {
                    continue;
                }

                if (!$value || $value > $condition['value']) {
                    $value = $condition['value'];
                }
            }
        }

        $subtotalCart = WC()->cart->subtotal;
        $spend = 0;
        
        $content_cond = '';
        $content_desc = '';
        
        /**
         * Check free shipping
         */
        if ($subtotalCart < $value) {
            $spend = $value - $subtotalCart;
            $per = intval(($subtotalCart/$value)*100);
            
            $allowed_html = array(
                'strong' => array(),
                'a' => array(
                    'class' => array(),
                    'href' => array(),
                    'title' => array()
                ),
                'span' => array(
                    'class' => array()
                ),
                'br' => array()
            );
            
            $content_desc .= '<div class="nasa-total-condition-desc text-center"><i class="prk-truck-fast"></i>' .
            sprintf(
                wp_kses(__('%s  تا ارسال <strong>رایگان</strong>', 'elessi-theme'), $allowed_html),
                wc_price($spend),
                esc_url(get_permalink(wc_get_page_id('shop')))
            ) . 
            '</div>';
        }
        /**
         * Congratulations! You've got free shipping!
         */
        else {
            $per = 100;
            $content_desc .= '<div class="nasa-total-condition-desc text-center">';
            $content_desc .= '<i class="text-success prk-truck-fast"></i>';
            $content_desc .= "تبریک، ارسال به صورت <strong>رایگان</strong>";
            $content_desc .= '</div>';
        }
        
        $class_cond = 'nasa-total-condition-wrap';
        
        $content_cond .= '<div class="nasa-total-condition" data-per="' . $per . '">' .
            '<div class="nasa-subtotal-condition primary-bg nasa-relative">' .
                '<span class="nasa-total-number primary-border text-center flexed jc">' . $per . '%</span>' .
            '</div>' .
        '</div>';
        
        $content .= '<div class="' . $class_cond . '">';
        $content .= $content_cond;
        $content .= '</div>';
        $content .= $content_desc;
        
        if (!$return) {
            echo $content;
            
            return;
        }
        
        return $content;
    }
endif;

/**
 * Add Free_Shipping to Cart page
 */
add_action('woocommerce_cart_contents', 'elessi_subtotal_free_shipping_in_cart');
if (!function_exists('elessi_subtotal_free_shipping_in_cart')) :
    function elessi_subtotal_free_shipping_in_cart() {
        $content = elessi_subtotal_free_shipping(true);
        
        if ($content !== '') {
            echo '<tr class="nasa-no-border"><td colspan="6" class="nasa-subtotal_free_shipping">' . $content . '</td></tr>';
        }
    }
endif;




/**
 * Mini cart icon
 * 
 * @global type $nasa_opt
 * @global type $nasa_mini_cart
 * @param type $recount
 * @return type
 */
if (!function_exists('elessi_mini_cart')) {
    function elessi_mini_cart() {
        global  $nasa_mini_cart;
        

            // $icon_class = 'prk-shopping-cart';
            $icon_class = prk_option('headers_minicart_icon') ? prk_option('headers_minicart_icon') : 'prk-shopping-cart';
            $icon_data = prk_option('headers_minicart_img');
            $icon_image = is_array($icon_data) && isset($icon_data['url']) ? $icon_data['url'] : '';

            if ( prk_option('headers_minicart_type') == 'icon' || prk_option('headers_minicart_type') == '' ){
                $icon_date = '<i class="'.$icon_class.'"></i>';
            }else{
                $icon_date = '<i ><img src="'.$icon_image.'" alt=""></i>';
            }
            
            $header_minicart_type = prk_option('header_minicart_type');
            $count = WC()->cart->cart_contents_count ? WC()->cart->cart_contents_count : '0';
            $class = $count ? ' pluser' : ' hidden-tag nasa-product-empty';

            
            
            if ($header_minicart_type == 'dropdown'){
                $nasa_mini_cart = 
                '<a href="javascript:void()" class="cart-link mini-cart cart-inner nasa-flex jc test" title="' . esc_attr__('Cart', 'parskala') . '" rel="nofollow">' .
                    '<span class="icon-wrap cart-btn">' .
                        $icon_date.
                        '<em class="nasa-cart-count nasa-mini-number cart-number mini_cart_counter' . $class . '">' .
                            apply_filters('nasa_mini_cart_total_items', $count) .
                        '</em>' .
                    '</span>' .
                '</a>';
            }else{
                $nasa_mini_cart = 
                '<a href="' .wc_get_cart_url(). '" class="mini-cart cart-inner" title="' . esc_attr__('Cart', 'parskala') . '" rel="nofollow">' .
                    '<span class="icon-wrap cart-btn">' .
                        $icon_date.
                        '<em class="nasa-cart-count nasa-mini-number cart-number mini_cart_counter' . $class . '">' .
                            apply_filters('nasa_mini_cart_total_items', $count) .
                        '</em>' .
                    '</span>' .
                '</a>';     
            }

            
            $nasa_mini_cart = apply_filters('nasa_mini_cart', $nasa_mini_cart);
            
            $GLOBALS['nasa_mini_cart'] = $nasa_mini_cart;
        
        
        return $nasa_mini_cart;
    }
}



if (!function_exists('elessi_mini_coun_cart')) {
    function elessi_mini_coun_cart() {
        global  $nasa_mini_count_cart;
        $class = '';

            $count = WC()->cart->cart_contents_count ? WC()->cart->cart_contents_count : '0';

            $nasa_mini_count_cart =  
             '<em class="em-plus cart-counter' . $class . '">' .
            apply_filters('nasa_mini_cart_total_items_count', $count) .
             '</em>' .
                  
            
            $nasa_mini_count_cart = apply_filters('elessi_mini_count_cart', $nasa_mini_count_cart);
            
            $GLOBALS['nasa_mini_count_cart'] = $nasa_mini_count_cart;
        
        
        return $nasa_mini_count_cart;
    }
}

/**
 * Add to cart dropdown - Refresh mini cart content.
 */
add_filter('woocommerce_add_to_cart_fragments', 'elessi_add_to_cart_refresh');
if (!function_exists('elessi_add_to_cart_refresh')) :
    function elessi_add_to_cart_refresh($fragments) {
        $fragments['.cart-inner'] = elessi_mini_cart(true);
        $fragments['.cart-counter'] = elessi_mini_coun_cart(true);
        
        if (isset($_REQUEST['product_id'])) {
            $fragments['.woocommerce-message'] = sprintf(
                '<div class="woocommerce-message text-center" role="alert">%s</div>',
                esc_html__('Product added to cart successfully!', 'elessi-theme')
            );
        }

        return $fragments;
    }
endif;