<?php

// define('PHP_PRK_ROOT',get_template_directory());

// require PHP_PRK_ROOT.'/vendor/autoload.php';

add_action('csf_prk_option_save_after', 'prk_generate_dynamic_styles_modular', 10, 2);


add_action('wp_enqueue_scripts', function () {
    $path = get_stylesheet_directory_uri() . '/assets/css/dynamic-style.css';
    $file = get_stylesheet_directory() . '/assets/css/dynamic-style.css';

    if (file_exists($file)) {
        wp_enqueue_style('parskala-dynamic-style', $path, [], filemtime($file));
    }
});

function prk_generate_dynamic_styles_modular($request, $instance) {
    $css = '';

    $global_styles = [

        // استایل های صفحه محصول
        'color_info_box_product' => [
            'type' => 'color',
            'property' => 'color',
            'selectors' => [
                '.woocommerce .des-left div.quantity a.plus',
                '.woocommerce .des-left div.quantity a.minus',
                '.woocommerce .des-left div.quantity input.qty',
                '.stills_contienr .shop_names .name',
                '.operation_stillses',
                '.single-product .cart-pro bdi',
                '.col-single1 .des-left .share-square::before',
                '.col-single1 .des-left .ui-box',
                '.col-single1 .des-left .seller-feedback .seller-feedback-item',
                'body .product-seller-info .product-seller-row .product-seller-row-icon i',
                'body.product-single .woocommerce div.product .woocommerce-variation-availability p.stock',
                'body.product-single .woocommerce div.product .cart-pro del span bdi',
                'body.product-single .product-seller-info .product-seller-row .product-seller-row-detail .product-seller-row-detail-title',
            ]
        ],

        'color_add_cart_btn_product' => [
            'type' => 'background',
            'property' => 'background',
            'selectors' => [
                '.single-product .single_add_to_cart_button.button',
            ]
        ],

        'shadow_add_cart_btn_product' => [
            'type' => 'box-shadow',
            'selectors' => [
                '.single-product .single_add_to_cart_button.button',
            ]
        ],
        
    ];

    $single_product_styles = [
       'border_radius_info_box' => [
            'type' => 'border-radius',
            'unit' => 'px',
            'important' => true,
            'selectors' => [
                '.col-single1 .des-left .ui-box, .col-single1 .des-left .tippy-content'
                ]
        ],
        'prk_background_single_pro' => [
            'type' => 'background',
            'property' => 'background-color',
            'selectors' => ['body.product-single']
        ],
        'gradient_info_box_product' => [
            'type' => 'background-gradient',
            'property' => 'background',
            'selectors' => [
                '.col-single1 .des-left .ui-box',
                '.col-single1 .des-left .tippy-content'
            ]
        ],
        'border_info_box_product' => [
            'type' => 'color',
            'property' => 'color',
            'selectors' => [
                '.parskala-update-price',
                '.col-single1 .des-left .tippy-content',
                '.product-seller-info .product-seller-row::after'
            ],
            'extra_css' => [
                '.product-seller-info .product-seller-row::after' => 'background-color',
            ]
        ],
        'back_add_cart_btn_product' => [
            'type' => 'background-gradient',
            'property' => 'background',
            'selectors' => [
                '.single-product .woocommerce div.product form.cart .button.single_add_to_cart_button',
            ]
        ],
    ];

    $total_cart_styles = [

        'gradient_total_box_product' => [
            'type' => 'background-gradient',
            'property' => 'background',
            'selectors' => [
                'body .shop_table.table-shop-cart-user,
                 body.ceckout_page .shop_table.woocommerce-checkout-review-order-table,
                 body.ceckout_page .woocommerce-checkout-payment,
                 body.ceckout_page .woocommerce-checkout-payment ul li div.payment_box
            ']
        ],

        'border_total_box_product' => [
            'type' => 'border-color',
            'property' => 'color',
            'selectors' => [
                'body .collateral-order-user table.shop_table .woocommerce-shipping-totals,
                 body .totals-order-user .order-total,
                 .woocommerce .collateral-order-user table.shop_table .woocommerce-shipping-totals,
                 tr.woocommerce-shipping-totals.shipping td ul li
            ']
        ],

        'color_total_box_product' => [

            [
                'type' => 'raw-style',
                'value' => 'background: transparent;',
                'important' => true, // یا true
                'custom_selectors' => ['body .woocommerce-checkout #payment div.payment_box'],
            ],

            [
                'type' => 'color',
                'property' => 'color',
                'important' => true, // یا true

                'selectors' => [
                    '.shipping-calculator-form .select2-selection--single .select2-selection__rendered',
                    '.totals-order-user table.shop_table tr.order-total td .woocommerce-Price-amount',
                    'body .collateral-order-user p.woocommerce-shipping-destination',
                    '.cart-subtotal .woocommerce-Price-amount',
                    'body .prk_cart table.shop_table th',
                    'body .prk_cart table.shop_table td',
                    'body .totals-order-user table.shop_table tr.order-total td .woocommerce-Price-amount',
                    'body .woocommerce form .form-row label',
                    'body .woocommerce-form-row label',
                    'body.ceckout_page div.place-order .prk-order-total',
                    'body.ceckout_page .shop_table.woocommerce-checkout-review-order-table tbody tr.cart-subtotal th',
                    'body .woocommerce table.shop_table th',
                    'body .woocommerce table.shop_table td',
                    'body.ceckout_page .woocommerce-checkout-payment ul li::before',
                    'body.ceckout_page .woocommerce-checkout-payment ul li label',
                    'body.ceckout_page .woocommerce .shop_table  ul#shipping_method li label .woocommerce-Price-amount',
                    'body.ceckout_page .woocommerce-checkout-payment ul li div.payment_box p',
                    'body.ceckout_page .shop_table.woocommerce-checkout-review-order-table tbody tr.tax-total td',
                    'body.ceckout_page .shop_table.woocommerce-checkout-review-order-table tbody tr.order-total td',
                    'body.ceckout_page .shop_table.woocommerce-checkout-review-order-table tbody tr.order-total th',
                ]
            ],

        ],

        'back_total_btn_product' => [
            'type' => 'background-gradient',
            'property' => 'background',
            'selectors' => [
                'body a.checkout-button.button',
                'body .woocommerce-checkout .form-row.place-order button#place_order'
                ]
        ],

        'color_total_btn_product' => [
            'type' => 'color',
            'property' => 'color',
            'selectors' => [
            'a.checkout-button.button',
            'body .woocommerce-checkout .form-row.place-order button#place_order'
            ]
        ],

        'shadow_total_btn_product' => [
            'type' => 'box-shadow',
            'selectors' => [
                'a.checkout-button.button',
                'body .woocommerce-checkout .form-row.place-order button#place_order'
            ]
        ],

        'border_radius_total_box' => [
        'type' => 'border-radius',
        'unit' => 'px',
        'important' => true,
        'selectors' => [
            'body .shop_table.table-shop-cart-user',
            'body .shop_table_responsive.table-shop-cart-user',
            'body.ceckout_page .shop_table.woocommerce-checkout-review-order-table, body.ceckout_page .woocommerce-checkout-payment'
            ]
        ],

    ];



    $css .= generate_css_from_options($global_styles);
    $css .= generate_css_from_options($total_cart_styles);
    $css .= generate_css_from_options($single_product_styles);

    // ذخیره در فایل
    $css_path = get_stylesheet_directory() . '/assets/css/dynamic-style.css';
    file_put_contents($css_path, $css);
}


/**
 *  تولید CSS از یک آرایه تنظیمات
 */
function generate_css_from_options($styles) {
    $css = '';
    $fallback_ids = [
    'back_add_cart_btn_product',
    // هر ID دیگه‌ای که fallback بخواد
    ];
    foreach ($styles as $option_id => $data) {
        $value = prk_option($option_id);
        if (!$value) continue;

        // اگه نوع‌های مختلف داشت (variants)، بررسی کن
        $variants = isset($data['type']) ? [$data] : $data;

        foreach ($variants as $variant) {
            $type = $variant['type'] ?? 'color';
            $important = isset($variant['important']) && $variant['important'] === false ? '' : ' !important';

            // 🎨 رنگ ساده
            if ($type === 'color' && is_string($value)) {
                if (!empty($variant['selectors'])) {
                    $css .= implode(",\n", $variant['selectors']) . " {\n";
                    $css .= "  {$variant['property']}: {$value}{$important};\n";
                    $css .= "}\n";
                }

                // استایل‌های اضافی
                if (!empty($variant['extra_css'])) {
                    foreach ($variant['extra_css'] as $selector => $prop) {
                        $css .= "{$selector} {\n";
                        $css .= "  {$prop}: {$value}{$important};\n";
                        $css .= "}\n";
                    }
                }
            }

            // 🎨 سایه
            elseif ($type === 'box-shadow' && is_string($value)) {
                if (!empty($variant['selectors'])) {
                    $css .= implode(",\n", $variant['selectors']) . " {\n";
                    $css .= "  box-shadow: 0px 0px 21.92px 0px {$value}{$important};\n";
                    $css .= "}\n";
                }
            }

            // 🎨 رنگ border
            elseif ($type === 'border-color' && is_string($value)) {
                if (!empty($variant['selectors'])) {
                    $css .= implode(",\n", $variant['selectors']) . " {\n";
                    $css .= "  border-color: {$value}{$important};\n";
                    $css .= "}\n";
                }
            }

            // 🧩 بک‌گراند ساده
            elseif ($type === 'background' && is_array($value) && !empty($value['background-color'])) {
                if (!empty($variant['selectors'])) {
                    $css .= implode(",\n", $variant['selectors']) . " {\n";
                    $css .= "  {$variant['property']}: {$value['background-color']}{$important};\n";
                    $css .= "}\n";
                }
            }

            // 🌀 گرادینت بک‌گراند با fallback
            elseif ($type === 'background-gradient') {
                $main_val = $value;

                $from = $main_val['background-color'] ?? null;
                $to   = $main_val['background-gradient-color'] ?? null;
                $dir  = $main_val['background-gradient-direction'] ? $main_val['background-gradient-direction'] : 'to right';

                // فقط برای IDهای خاص fallback اعمال کن
                if ((!$from || !$to) && in_array($option_id, $fallback_ids)) {
                    $gradient_org = prk_option('gradient_general_color');
                    if ($gradient_org && !empty($gradient_org['background-color']) && !empty($gradient_org['background-gradient-color'])) {
                        $from = $gradient_org['background-color'];
                        $to   = $gradient_org['background-gradient-color'];
                        $dir  = $main_val['background-gradient-direction'] ? $main_val['background-gradient-direction'] : 'to right';
                    } else {
                        $fallback = prk_option('general_color');
                        if ($fallback) {
                            $from = $fallback;
                            $to   = $fallback;
                        }
                    }
                }

                if ($from && $to && !empty($variant['selectors'])) {
                    $gradient = "linear-gradient({$dir}, {$from}, {$to})";
                    $css .= implode(",\n", $variant['selectors']) . " {\n";
                    $css .= "  {$variant['property']}: {$gradient}{$important};\n";
                    $css .= "}\n";
                }
            }

            // 🧪 حاشیه انحنای

            elseif ($type === 'border-radius' && is_numeric($value)) {
                $unit = $variant['unit'] ?? 'px';

                if (!empty($variant['selectors'])) {
                    $css .= implode(",\n", $variant['selectors']) . " {\n";
                    $css .= "  border-radius: {$value}{$unit}{$important};\n";
                    $css .= "}\n";
                }
            }

            // 🧪 استایل دستی
            elseif ($type === 'raw-style' && !empty($variant['value']) && !empty($variant['custom_selectors'])) {
                foreach ($variant['custom_selectors'] as $selector) {
                    $css .= "{$selector} {\n";
                    $lines = explode(';', $variant['value']);
                    foreach ($lines as $line) {
                        $line = trim($line);
                        if (!$line) continue;
                        $css .= "  {$line}{$important};\n";
                    }
                    $css .= "}\n";
                }
            }
        }
    }

    return $css;
}



// تابع آپدیت جداول سبدخرید بعد /////////////////////////////////////////

add_action('init', 'prk_upgrade_next_shopping_list_table');

function prk_upgrade_next_shopping_list_table() {
    // فقط یک بار اجرا بشه
    if (get_option('prk_next_list_db_upgraded')) {
        return;
    }

    global $wpdb;
    $table = $wpdb->prefix . 'next_shopping_list';

    // بررسی اینکه آیا ستون ها وجود دارن یا نه
    $columns = $wpdb->get_results("SHOW COLUMNS FROM {$table}", ARRAY_A);
    $column_names = array_column($columns, 'Field');

    if (!in_array('variation_id', $column_names)) {
        $wpdb->query("ALTER TABLE {$table} ADD COLUMN variation_id INT DEFAULT NULL;");
    }

    if (!in_array('variation_attributes', $column_names)) {
        $wpdb->query("ALTER TABLE {$table} ADD COLUMN variation_attributes LONGTEXT DEFAULT NULL;");
    }

    // ثبت فلگ آپگرید برای جلوگیری از اجرای دوباره
    update_option('prk_next_list_db_upgraded', true);
}

// تابع آپدیت جداول سبدخرید بعد //////







// سیستم پاداش ووکامرس

//  اسکریپت سیستم امتیازدهی خودکار
function prk_enqueue_points_converter_assets() {
    wp_enqueue_script('prk-points-converter', get_template_directory_uri() . '/assets/js/prk-points-converter.js', ['jquery'], null, true);

    wp_localize_script('prk-points-converter', 'prk_ajax_data', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('prk_point_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'prk_enqueue_points_converter_assets');



// ذخیره‌سازی امتیاز هنگام آپدیت کاربر
add_action('personal_options_update', 'prk_save_user_points_field');
add_action('edit_user_profile_update', 'prk_save_user_points_field');

function prk_save_user_points_field($user_id) {
    // مقدار جدیدی که مدیر وارد کرده
    $new_points = intval($_POST['prk_user_points']);

    // مقدار فعلی که در دیتابیس بوده
    $current_points = intval(get_user_meta($user_id, 'prk_user_points', true));

    // اگر تغییر نکرده باشه، کاری نکن
    if ($new_points === $current_points) return;

    // بروزرسانی متا
    update_user_meta($user_id, 'prk_user_points', $new_points);

    // محاسبه اختلاف
    $diff = $new_points - $current_points;
    $desc = $diff > 0 ? 'افزایش امتیاز توسط مدیر' : 'کاهش امتیاز توسط مدیر';

    // ذخیره در تاریخچه
    prk_add_points_to_user_history(
        $user_id,
        abs($diff),
        $desc,
        $diff > 0 ? 'increase' : 'decrease'
    );
}





// نمایش فیلد در صفحه ویرایش کاربر
add_action('show_user_profile', 'prk_add_user_points_field');
add_action('edit_user_profile', 'prk_add_user_points_field');

function prk_add_user_points_field($user) {
    ?>
    <h3>امتیاز وفاداری کاربر</h3>
    <table class="form-table">
        <tr>
            <th><label for="prk_user_points">میزان امتیاز</label></th>
            <td>
                <input type="number" name="prk_user_points" id="prk_user_points" value="<?php echo esc_attr(get_user_meta($user->ID, 'prk_user_points', true)); ?>" class="regular-text" />
                <p class="description">مقدار امتیاز وفاداری کاربر را وارد کنید. این مقدار قابل تبدیل به کوپن است.</p>
            </td>
        </tr>
    </table>
    <?php
}




// add_filter('woocommerce_account_menu_items', 'prk_add_loyalty_points_tab', 7);
function prk_add_loyalty_points_tab($items) {
    $items['prk-loyalty-points'] = 'امتیازهای من';
    return $items;
}

// add_action('woocommerce_account_prk-loyalty-points_endpoint', 'prk_render_user_loyalty_points_tab');
function prk_render_user_loyalty_points_tab() {
    echo do_shortcode('[prk_user_points_converter]');
    echo do_shortcode('[prk_history_table]');
}

// add_action('init', 'prk_add_loyalty_points_endpoint');
// function prk_add_loyalty_points_endpoint() {
//     add_rewrite_endpoint('prk-loyalty-points', EP_ROOT | EP_PAGES);
// }





add_shortcode('prk_user_points_converter', function () {
    $user_id = get_current_user_id();
    if (!$user_id) return '<p>برای مشاهده امتیازات، لطفاً وارد شوید.</p>';

    $points = (int) get_user_meta($user_id, 'prk_user_points', true);
    $points = max($points, 0);
    $conversion_rate = 10;

    ob_start();
    ?>
    <div id="prk-point-converter" class="point-box">
        <p>امتیاز فعلی شما: <strong id="user-current-points"><?php echo esc_html($points); ?></strong></p>

        <input type="number" id="convert-points-input" class="input" min="10" step="10" max="<?php echo esc_attr($points); ?>" value="100">
        <button id="convert-point-btn" class="button button-primary">تبدیل به کوپن</button>

        <div id="convert-point-result" style="margin-top:1em;"></div>
        <hr>
        <h3>تاریخچه کوپن‌ها:</h3>
        <div id="prk-coupon-history">
            <?php echo prk_render_user_coupon_history($user_id); ?>
        </div>
    </div>
    <script>
    jQuery(document).ready(function ($) {
        $('#convert-point-btn').on('click', function () {
            const amount = parseInt($('#convert-points-input').val());
            $.ajax({
                type: 'POST',
                url: prk_ajax_data.ajax_url,
                data: {
                    action: 'prk_convert_points_to_coupon',
                    nonce: prk_ajax_data.nonce,
                    amount: amount
                },
                success: function (res) {
                    if (res.success) {
                        $('#convert-point-result').html(res.data.message);
                        $('#prk-coupon-history').html(res.data.history);
                        $('#user-current-points').text(res.data.remaining);
                        $('#convert-points-input').val('0');
                    } else {
                        $('#convert-point-result').html(res.data.message);
                    }
                },
                error: function () {
                    $('#convert-point-result').html('\u274C \u062e\u0637\u0627\u06cc\u06cc \u0631\u062e \u062f\u0627\u062f\u0647 \u0627\u0633\u062a.');
                }
            });
        });
    });
    </script>
    <?php
    return ob_get_clean();
});

function prk_render_user_coupon_history($user_id) {
    $args = [
        'post_type'      => 'shop_coupon',
        'posts_per_page' => -1,
        'meta_query'     => [
            [
                'key'     => 'allowed_mobile',
                'value'   => get_user_meta($user_id, 'billing_phone', true),
                'compare' => '=',
            ],
        ],
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    $coupons = get_posts($args);

    if (!$coupons) return '<p>تاکنون کوپنی برای شما ساخته نشده است.</p>';

    $html = '<table class="wp-list-table widefat fixed striped"><thead><tr>
                <th>کد کوپن</th><th>مقدار</th><th>تاریخ ایجاد</th><th>وضعیت</th></tr></thead><tbody>';

    foreach ($coupons as $coupon) {
        $code = $coupon->post_title;
        $amount = get_post_meta($coupon->ID, 'coupon_amount', true);
        $used = get_post_meta($coupon->ID, 'usage_count', true);
        $created = get_the_date('Y/m/d', $coupon->ID);
      
        $status = $used ? 'استفاده شده' : 'قابل استفاده';

        $html .= "<tr><td><code>{$code}</code></td><td>" . wc_price($amount) . "</td><td>{$created}</td><td>{$status}</td></tr>";
    }

    $html .= '</tbody></table>';
    return $html;
}

add_action('wp_ajax_prk_convert_points_to_coupon', 'prk_convert_points_to_coupon_cb');
function prk_convert_points_to_coupon_cb() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'prk_point_nonce')) {
        wp_send_json_error(['message' => 'nonce نامعتبر است.']);
    }

    $user_id = get_current_user_id();
    $amount = isset($_POST['amount']) ? intval($_POST['amount']) : 0;
    $user_points = (int) get_user_meta($user_id, 'prk_user_points', true);
    $conversion_rate = 10;

    if ($amount <= 0 || $amount > $user_points) {
        wp_send_json_error(['message' => 'مقدار امتیاز وارد شده معتبر نیست.']);
    }

    $coupon_amount = intval($amount / $conversion_rate);
    if ($coupon_amount <= 0) {
        wp_send_json_error(['message' => 'امتیاز کافی نیست.']);
    }

    $coupon_code = 'prk-' . wp_generate_password(8, false);
    $coupon_id = wp_insert_post([
        'post_title'   => $coupon_code,
        'post_status'  => 'publish',
        'post_type'    => 'shop_coupon',
        'post_author'  => 1,
    ]);

    if (is_wp_error($coupon_id)) {
        wp_send_json_error(['message' => 'خطا در ساخت کوپن.']);
    }

    update_post_meta($coupon_id, 'discount_type', 'fixed_cart');
    update_post_meta($coupon_id, 'coupon_amount', $coupon_amount);
    update_post_meta($coupon_id, 'individual_use', 'yes');
    update_post_meta($coupon_id, 'usage_limit', 1);

    $user = get_userdata($user_id);
    $email = $user->user_email;
    $mobile = get_user_meta($user_id, 'billing_phone', true);

    if (!empty($email)) {
        update_post_meta($coupon_id, 'customer_email', $email);
    }
    if (!empty($mobile)) {
        update_post_meta($coupon_id, 'allowed_mobile', $mobile);
    }

    $remaining = $user_points - $amount;
    update_user_meta($user_id, 'prk_user_points', $remaining);
    prk_add_points_to_user_history($user_id, $amount, 'تبدیل امتیاز به کوپن با کد: ' . $coupon_code, 'decrease');


    wp_send_json_success([
        'message'   => '<p>✅ کد تخفیف شما: <code>' . esc_html($coupon_code) . '</code></p>',
        'history'   => prk_render_user_coupon_history($user_id),
        'remaining' => $remaining,
    ]);
}


// فانکشن تاریخچه امتیازات امشب
add_shortcode('prk_history_table','prk_render_user_points_history_table');

function prk_render_user_points_history_table( $user_id = null ) {
    if ( ! $user_id ) {
        $user_id = get_current_user_id();
    }

    if ( ! $user_id ) {
        echo '<p>لطفاً ابتدا وارد شوید.</p>';
        return;
    }

    $history = get_user_meta( $user_id, 'prk_user_points_history', true );
    if ( ! is_array( $history ) || empty( $history ) ) {
        echo '<p>هنوز هیچ امتیازی دریافت یا خرج نکرده‌اید.</p>';
        return;
    }

    // نمایش جدول
    echo '<table class="points-history-table" style="width:100%; border-collapse: collapse;">';
    echo '<thead><tr>
        <th style="padding:10px; border: 1px solid #ccc;">امتیاز</th>
        <th style="padding:10px; border: 1px solid #ccc;">دلیل</th>
        <th style="padding:10px; border: 1px solid #ccc;">تاریخ</th>
    </tr></thead>';
    echo '<tbody>';

    // از جدید به قدیم
    $history = array_reverse($history);

    foreach ( $history as $entry ) {
        $points = intval($entry['points']);
        $reason = esc_html($entry['reason'] ?? 'بدون توضیح');
        $date   = isset($entry['time']) ? get_the_date('Y/m/d', $coupon->ID) : '';

        $color = $points > 0 ? 'green' : 'red';
        $sign  = $points > 0 ? '+' : '';

        echo '<tr>';
        echo '<td style="padding:10px; border: 1px solid #ccc; color:' . $color . ';">' . $sign . number_format($points) . '</td>';
        echo '<td style="padding:10px; border: 1px solid #ccc;">' . $reason . '</td>';
        echo '<td style="padding:10px; border: 1px solid #ccc;">' . $date . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
}


// function prk_add_points_to_user_history($user_id, $points, $reason = '') {
//     $history = get_user_meta($user_id, 'prk_user_points_history', true);
//     if (!is_array($history)) $history = [];

//     $history[] = [
//         'points' => intval($points),
//         'reason' => $reason,
//         'time'   => time(),
//     ];

//     update_user_meta($user_id, 'prk_user_points_history', $history);
// }

function prk_add_points_to_user_history($user_id, $points, $reason = '', $type = 'increase') {
    if ($points <= 0) return;

    $history = get_user_meta($user_id, 'prk_user_points_history', true);
    if (!is_array($history)) $history = [];

    $sign = $type === 'decrease' ? '-' : '+';

    // زمان به شمسی
    $timestamp = current_time('timestamp');
    $date = function_exists('prk_factor_jdates') ? get_the_date('Y/m/d', $timestamp) : date('Y/m/d', $timestamp);

    $history[] = [
        'points'      => $sign . $points,
        'reason' => $reason,
        'time'        => $date,
    ];

    update_user_meta($user_id, 'prk_user_points_history', $history);
}

add_action('woocommerce_after_variations_table', function () {
    echo '<div id="prk-variation-features" class="prk-variation-features" aria-live="polite"></div>';
}, 15);

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
});

add_filter('pre_get_document_title', function ($title) {
    $site_name = wp_strip_all_tags(get_bloginfo('name'));
    $site_desc = wp_strip_all_tags(get_bloginfo('description'));

    // --- صفحه اصلی ---
    if (is_front_page() || (is_home() && !is_front_page())) {
        if ($site_name) {
            return $site_desc ? "{$site_name} – {$site_desc}" : $site_name;
        }
        // fallback اگر نام سایت نبود
        return $title;
    }

    // --- دسته بندی‌ها مقاله / محصول ---
    if (is_category() || is_tag() || is_tax() || is_product_category() || is_product_tag()) {
        $term = get_queried_object();
        if ($term && !is_wp_error($term)) {
            $term_name = wp_strip_all_tags($term->name);
            return $site_name ? "{$term_name} – {$site_name}" : $term_name;
        }
    }

    // --- برگه فروشگاه ووکامرس ---
    if (function_exists('is_shop') && is_shop()) {
        $shop_title = woocommerce_page_title(false);
        if (empty($shop_title)) {
            $shop_id = wc_get_page_id('shop');
            if ($shop_id > 0) {
                $shop_title = get_the_title($shop_id);
            }
        }
        $shop_title = wp_strip_all_tags($shop_title);
        return $site_name ? "{$shop_title} – {$site_name}" : $shop_title;
    }

    // --- فروشنده دکان ---
    if (function_exists('dokan_is_store_page') && dokan_is_store_page()) {
        $vendor_id = (int) get_query_var('author');
        $vendor_title = '';
        if ($vendor_id && function_exists('dokan')) {
            $vendor = dokan()->vendor->get($vendor_id);
            if ($vendor && !is_wp_error($vendor)) {
                $vendor_title = $vendor->get_shop_name();
                if ($vendor_title === '') {
                    $info = $vendor->get_shop_info();
                    if (is_array($info) && !empty($info['store_name'])) {
                        $vendor_title = $info['store_name'];
                    }
                }
            }
        }
        if ($vendor_title === '') {
            $u = get_user_by('id', $vendor_id);
            $vendor_title = $u ? ($u->display_name ?: $u->user_login) : '';
        }
        $vendor_title = wp_strip_all_tags($vendor_title);
        return $site_name ? "{$vendor_title} – {$site_name}" : $vendor_title;
    }

    // --- سایر صفحات / پست‌ها / برگه‌ها ---
    if (is_singular()) {
        $post_title = wp_strip_all_tags(single_post_title('', false));
        return $site_name ? "{$post_title} – {$site_name}" : $post_title;
    }

    // --- حالت پیش‌فرض بقیه (مثلاً بایگانی) ---
    return $title;
}, 9999);
