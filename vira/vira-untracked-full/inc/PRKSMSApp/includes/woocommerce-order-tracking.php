<?php


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly...
}

/**
 * @class PRK_Woocommerce_Order_Tracking
 */

use Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController;

class PRK_Woocommerce_Order_Tracking
{

    /**
     * @var object $instance
     */
    private static $instance;
    private static $did_save_request = false;

    
    /**
     * Constructor.
     */
    private function __construct()
    {
        $this->init_text_domain();

        add_action('init', array($this, 'init_hooks'), 0);

    }

    /**
     * Initializes text domain.
     */
    private function init_text_domain()
    {
        load_plugin_textdomain('woocommerce-order-tracking', false, 'woocommerce-order-tracking/languages');
    }

    /**
     * Initializes singleton instance.
     *
     * @return object self::$instance
     */
    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Cloning is forbidden.
     */
    public function __clone()
    {
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'woocommerce-order-tracking'), '0.1');
    }

    /**
     * Unserializing instances of this class is forbidden.
     */
    public function __wakeup()
    {
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'woocommerce-order-tracking'), '0.1');
    }


    /**
     * Initialization hooks.
     */
    public function init_hooks()
    {
        if (is_admin()) {

            add_action('admin_enqueue_scripts', array($this, 'registerAdminAssets'));

            // Order page hooks...
            add_action('admin_notices', array($this, 'admin_notice'));
            add_action('add_meta_boxes', array($this, 'add_meta_box'));

            // ✅ جدید: ذخیره سفارش در حالت HPOS و حالت کلاسیک
            // add_action('woocommerce_admin_process_shop_order_object', [$this, 'save_meta_box_from_order_object'], 10, 1);
            add_action('woocommerce_after_order_object_save', [$this, 'prk_after_admin_saved_order'], 20, 2);

            add_action('woocommerce_process_shop_order_meta', [$this, 'save_meta_box_from_post_id'], 10, 2);

            // fallback خیلی امن (اگر هیچکدوم فایر نشدن)
             add_action('save_post_shop_order', [$this, 'save_meta_box_from_save_post_fallback'], 10, 3);

            add_filter('is_protected_meta', array($this, 'protect_meta'), 10, 2);

        } else {
            // Frontend hooks...
            add_action('woocommerce_view_order', array($this, 'information_display'), 5, 1);
            add_action('woocommerce_email_order_meta', array($this, 'information_display'), 10, 1);
        }
    }

    function registerAdminAssets()
    {
        $url = get_template_directory_uri() . '/inc/PRKSMSApp/includes/templates/assets/';

        wp_enqueue_style('custom_prk_styles', $url . 'css/customprkstyles.admin.css');
        wp_enqueue_script('custom_prk_script', $url . 'js/customprkscript.admin.js', array('jquery'));

    }

    public function prk_after_admin_saved_order($order, $data_store) {

        if (!is_admin() || !$order || !is_a($order, 'WC_Order')) return;

        // فقط وقتی فرم رهگیری ما ارسال شده
        if (empty($_POST['prk_woocot_order_picked_up'])) return;

        $order_id = $order->get_id();

        if (!$this->check_valid_set_tracking_post_info($order_id)) return;

        // وضعیت از تنظیمات قالب
        $opt =  prk_option('prk_order_status_after_save_tracking_post');
        $new_status = $opt ? $opt : 'completed';
        // اگر already همونه، کاری نکن
        if ($order->get_status() === $new_status) return;

        // ⭐ اینجا دیگه overwrite نمیشه
        $order->update_status($new_status, '', true);
    }

    public function save_meta_box_from_order_object($order) {
        if (!is_admin() || !$order || !is_a($order, 'WC_Order')) return;
        $this->save_meta_box_core($order);
    }

    public function save_meta_box_from_post_id($post_id, $post) {
        if (!is_admin() || empty($post_id)) return;

        $order = wc_get_order($post_id);
        if (!$order) return;

        $this->save_meta_box_core($order);
    }

    // fallback
    public function save_meta_box_from_save_post_fallback($post_id, $post, $update) {
        if (!is_admin() || wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) return;

        // فقط وقتی فیلدهای ما ارسال شده باشند
        $has_our_fields =
            isset($_POST['prk_woocot_order_picked_up']) ||
            isset($_POST['prk_woocot_shipper']) ||
            isset($_POST['prk_woocot_number']) ||
            isset($_POST['prk_woocot_transport_type']) ||
            isset($_POST['prk_woocot_postage_date']);

        if (!$has_our_fields) return;

        $order = wc_get_order($post_id);
        if (!$order) return;

        $this->save_meta_box_core($order);
    }



    /**
     * ✅ هسته اصلی ذخیره: یک بار نوشته میشه و هر دو حالت HPOS/Legacy ازش استفاده می‌کنن
     * - متاها را روی خود Order ذخیره می‌کنه (HPOS-safe)
     * - در صورت فعال شدن "تحویل پست" می‌تونه وضعیت سفارش را تغییر بده
     * - اگر وضعیت تغییر کرد و تحویل پست = yes بود، پیامک را یک بار تریگر می‌کنه
     *
     * @param WC_Order $order
     */
private function save_meta_box_core($order) {

    if (self::$did_save_request) return;
    self::$did_save_request = true;

    $order_id = $order->get_id();
    if (!current_user_can('edit_shop_order', $order_id)) return;

    $has_our_fields =
        isset($_POST['prk_woocot_order_picked_up']) ||
        isset($_POST['prk_woocot_shipper']) ||
        isset($_POST['prk_woocot_number']) ||
        isset($_POST['prk_woocot_transport_type']) ||
        isset($_POST['prk_woocot_postage_date']);

    if (!$has_our_fields) return;

    // وضعیت از تنظیمات قالب
    $opt =  prk_option('prk_order_status_after_save_tracking_post');
    $new_order_status = $opt ? $opt : 'completed';

    $picked_up_on = (isset($_POST['prk_woocot_order_picked_up']) && $_POST['prk_woocot_order_picked_up'] === 'on');

    if ($picked_up_on) {

        if ($this->check_valid_set_tracking_post_info($order_id)) {

            $this->update_meta_box($order);

            // این متا حتماً yes
            $order->update_meta_data('prk_woocot_order_picked_up', 'yes');

            // تغییر وضعیت
            if ($order->get_status() !== $new_order_status) {
                $order->update_status($new_order_status, '', true);
            }

        } else {
            $order->update_meta_data('prk_woocot_order_picked_up', 'no');
        }

    } else {
        $order->update_meta_data('prk_woocot_order_picked_up', 'no');
    }

    // فقط یک بار save
    $order->save();
}

    /**
     * Adds tracking meta box.
     *
     * Hooked into `add_meta_boxes` action hook.
     */
    public function add_meta_box()
    {
        $screen_id = $this->is_hpos_enabled() ? wc_get_page_screen_id('shop-order') : 'shop_order';

        add_meta_box(
            'prk_woocot',
            __('اطلاعات پستی مرسوله', 'woocommerce-order-tracking'),
            array($this, 'meta_box'),
            $screen_id, // استفاده از screen ID سازگار با HPOS
            'side',
            'high'
        );
    }

    public function is_hpos_enabled()
    {
        return class_exists(CustomOrdersTableController::class) &&
            wc_get_container()->get(CustomOrdersTableController::class)->custom_orders_table_usage_is_enabled();
    }

    /**
     * Meta box template.
     */
    public function meta_box()
    {
        $shippers = $this->get_shippers();
        $order = wc_get_order(get_the_ID());

        if ($order) {
            $prk_woocot_shipper = $order->get_meta('prk_woocot_shipper', true);
            $prk_woocot_number = $order->get_meta('prk_woocot_number', true);
            $prk_woocot_transport_type = $order->get_meta('prk_woocot_transport_type', true);
            $prk_woocot_postage_date = $order->get_meta('prk_woocot_postage_date', true);
            $prk_woocot_order_picked_up = $order->get_meta('prk_woocot_order_picked_up', true);
        }

        $prk_woocot_order_picked_up_checked = $prk_woocot_order_picked_up == 'yes' ? 'checked' : '';
        echo '
		<section class="buttons-wrapper">

		<label class="prk_woocot-order-picked-up-label" >سفارش تحویل پست داده شد؟</label>
		<label class="toggler-wrapper style-11">

		<input name="prk_woocot_order_picked_up" type="checkbox" ' . $prk_woocot_order_picked_up_checked . '>
		<div class="toggler-slider">
		  <div class="toggler-knob"></div>
		</div>
	  </label>

		</section>
		';
        echo '<div class="prk_woocot_wrapper" style="display:' . ($prk_woocot_order_picked_up == "yes" ? "block" : "none") . '"><p class="description">' . esc_html__('پس از پر کردن فرم،سفارش را بروزرسانی کنید.', 'woocommerce-order-tracking') . '</p>';
        echo '<p><label for="prk_woocot_shipper">' . esc_html__('انتخاب فرم رهگیری پست :', 'woocommerce-order-tracking') . '</label /><br />';
        echo '<select style="width: 100%;font-weight: 500;background-color: #dce5fb;" id="prk_woocot_shipper" name="prk_woocot_shipper">';
        echo '<option value="">' . esc_html__('هیچکدام', 'woocommerce-order-tracking') . '</option>';

        foreach ($shippers as $key => $value) {
            if (!is_int($key) && !empty($key)) {
                $selected = ($prk_woocot_shipper === $key) ? 'selected ' : '';

                echo '<option ' . $selected . 'value="' . $key . '">' . esc_html($value['name']) . '</option>';
            }
        }

        echo '</select></p>';
        echo '<p><label for="prk_woocot_number">' . esc_html__('درج کد رهگیری :', 'woocommerce-order-tracking') . '</label>';
        echo '<input style="width: 100%;background: #dce5fb;" type="text" id="prk_woocot_number" name="prk_woocot_number" value="' . esc_attr($prk_woocot_number) . '" /></p>';
        echo '<p><label for="prk_woocot_transport_type">' . esc_html__('نوع سیستم حمل و نقل :', 'woocommerce-order-tracking') . '</label>';
        echo '<input style="width: 100%;background: #dce5fb;" type="text" id="prk_woocot_transport_type" name="prk_woocot_transport_type" value="' . esc_attr($prk_woocot_transport_type) . '" /></p>';
        echo '<p><label for="prk_woocot_postage_date">' . esc_html__('تاریخ ارسال :', 'woocommerce-order-tracking') . '</label>';
        echo '<input style="width: 100%;background: #dce5fb;" type="text" id="prk_woocot_postage_date" name="prk_woocot_postage_date" value="' . esc_attr($prk_woocot_postage_date) . '" /></p>';
        echo '</div>';
        echo '
		<script>
		jQuery(document).ready(function($) {
			$("#prk_woocot_postage_date").persianDatepicker({
			initialValue: false,
			   cellWidth: 32,
				cellHeight: 30,
				fontSize: 14,
			});
		  });
		  </script>
		';
    }

    public function get_shippers()
    {
        $shippers = [
            'post' => ['name' => 'پست'],
            'tipax' => ['name' => 'تیپاکس']
        ];

        return apply_filters('prk_woocot_shippers', $shippers);
    }

    /**
     * Saves order tracking meta.
     *
     * Hooked into `save_post` action hook.
     *
     * @param int $post_ID
     */
    public function save_meta_box($order_ID, $post = null, $update = null)
    {
        $order = wc_get_order($order_ID);

        if (!$order) {
            return;
        }

        remove_action( 'save_post', array($this,'save_meta_box'));

        $new_order_status = !empty(PRKSMSAppClass::prk_opt('prk_order_status_after_save_tracking_post'))
            ? PRKSMSAppClass::prk_opt('prk_order_status_after_save_tracking_post')
            : 'completed';

        if (isset($_POST['prk_woocot_order_picked_up']) && $_POST['prk_woocot_order_picked_up'] === 'on') {

            if (!empty($order) && $order->get_status() !== $new_order_status && $this->check_valid_set_tracking_post_info($order_ID)) {
                $old_order_status = $order->get_status();
                $order = $this->update_meta_box($order);
                $order->set_status($new_order_status);
                if ($this->is_hpos_enabled()) {
                    remove_action('woocommerce_order_status_changed', 'prkSMSWoocommerceOrder');
                    if (get_post_meta($order->get_id(), 'prk_woocot_order_picked_up', true) === 'yes') {
                        prkSMSWoocommerceOrder($order->get_id(), $old_order_status, $new_order_status);
                    }
                }
            }
            elseif ($order->get_status() === $new_order_status) {
                $order = $this->update_meta_box($order);
            } else {
                $order->update_meta_data('prk_woocot_order_picked_up', 'no');
            }

        } else {
            $order->update_meta_data('prk_woocot_order_picked_up', 'no');
        }

        $order->save();
        add_action( 'save_post', array($this,'save_meta_box'),10,3);
    }

    function check_valid_set_tracking_post_info($order_id)
    {
        // دسترسی درست برای سفارش
        if (!current_user_can('edit_shop_order', $order_id)) {
            return false;
        }

        // اینجا فقط فیلدهای رهگیری را چک کن
        if (
            empty($_POST['prk_woocot_shipper']) ||
            empty($_POST['prk_woocot_number']) ||
            empty($_POST['prk_woocot_transport_type']) ||
            empty($_POST['prk_woocot_postage_date'])
        ) {
            return false;
        }

        return true;
    }

    function update_meta_box($order)
    {
        if (!$this->check_valid_set_tracking_post_info($order->get_id())) {
            return;
        }

        $prk_woocot_shipper = isset($_POST['prk_woocot_shipper']) ? sanitize_text_field($_POST['prk_woocot_shipper']) : '';
        $prk_woocot_number = isset($_POST['prk_woocot_number']) ? sanitize_text_field($_POST['prk_woocot_number']) : '';
        $prk_woocot_transport_type = isset($_POST['prk_woocot_transport_type']) ? sanitize_text_field($_POST['prk_woocot_transport_type']) : '';
        $prk_woocot_postage_date = isset($_POST['prk_woocot_postage_date']) ? sanitize_text_field($_POST['prk_woocot_postage_date']) : '';

        $order->update_meta_data('prk_woocot_transport_type', $prk_woocot_transport_type);
        $order->update_meta_data('prk_woocot_postage_date', $prk_woocot_postage_date);
        $order->update_meta_data('prk_woocot_shipper', $prk_woocot_shipper);
        $order->update_meta_data('prk_woocot_number', $prk_woocot_number);
        $order->update_meta_data('prk_woocot_order_picked_up', 'yes');

        return $order;
    }

    /**
     * Admin notice template
     *
     * Hooked into 'admin_notices' action.
     */
    public function admin_notice()
    {
        if (get_transient('prk_woocot_error')) {
            echo '<div class="updated error notice is-dismissible">';
            echo '<p>' . esc_html__('Invalid / Missing tracking number or tracking shipper', 'woocommerce-order-tracking') . '.</p>';
            echo '</div>';

            delete_transient('prk_woocot_error');
        }
    }

    /**
     * Hides `prk_woocot_*` custom fields.
     *
     * Hooked into `is_protected_meta` filter hook.
     *
     * @param bool $protected
     * @param int $meta_key
     * @return bool
     */
    public function protect_meta($protected, $meta_key)
    {
        if ('prk_woocot_shipper' === $meta_key || 'prk_woocot_number' === $meta_key || 'prk_woocot_transport_type' === $meta_key || 'prk_woocot_postage_date' === $meta_key || 'prk_woocot_order_picked_up' === $meta_key) {
            return true;
        }

        return $protected;
    }

    /**
     * Displays shipping information.
     *
     * Hooked into `woocommerce_view_order` action hook.
     * Hooked into `woocommerce_email_before_order_table` action hook.
     *
     * @param object $order
     */
    public function information_display($order) {

        // WC_Order object
        if (is_a($order, 'WC_Order')) {
            $order_obj = $order;
        } else {
            // order id
            $order_id  = is_numeric($order) ? absint($order) : 0;
            $order_obj = $order_id ? wc_get_order($order_id) : null;
        }

        if (!$order_obj) return;

        $shippers = $this->get_shippers();

        $prk_woocot_shipper = $order_obj->get_meta('prk_woocot_shipper', true);
        $prk_woocot_number  = $order_obj->get_meta('prk_woocot_number', true);

        if (!empty($prk_woocot_shipper) && !empty($prk_woocot_number) && array_key_exists($prk_woocot_shipper, $shippers)) {

            $html_name = sprintf(
                esc_html__('ارسال شده با %s', 'woocommerce-order-tracking'),
                esc_html($shippers[$prk_woocot_shipper]['name'])
            ) . '<br />';

            $html_code  = sprintf(
                esc_html__('کد رهگیری پستی: %s', 'woocommerce-order-tracking'),
                esc_html($prk_woocot_number)
            ) . '<br />';

            echo apply_filters(
                'prk_woocot_information_display',
                $html_name,
                $html_code,
                $order_obj,
                $prk_woocot_shipper,
                $prk_woocot_number
            );
        }
    }
}

/**
 * Main function.
 *
 * Avoids the use of a global..
 *
 * @return object Plugin Instance
 */
function prk_woocommerce_order_tracking()
{
    return PRK_Woocommerce_Order_Tracking::get_instance();
}

prk_woocommerce_order_tracking();
