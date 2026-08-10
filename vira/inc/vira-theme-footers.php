<?php

/**
 * Static Cart sidebar
 */
add_action('nasa_static_content', 'elessi_static_cart_sidebar', 10);

if (!function_exists('elessi_static_cart_sidebar')  ) :
    function elessi_static_cart_sidebar() {

        $opnened_miny_cart_product = prk_option('opnened_mini_cart') ? prk_option('opnened_mini_cart') : '1';
        
       

        
        $nasa_cart_style = (!mobile_cheker() && !tablet_cheker()) ? 'prk-static-sidebar ' : 'prk-static-sidebar ';
        $nasa_cart_style .=  'style-1';
        
        ?>
        
        <div id="cart-sidebar" class="<?php echo esc_attr($nasa_cart_style); ?>">
            
            <div class="header-carter">
                  <span><?php _e('You have selected these products', 'parskala'); ?><em class="em-plus cart-counter"><?= elessi_mini_coun_cart(); ?></em></span>
                  <a href="javascript:void(0);" class="close-box prk-sidebar-close" title="<?php esc_attr_e('Close', 'elessi-theme'); ?>" rel="nofollow"></a>

            </div>
                
       
            <div class="widget_shopping_cart_content">
            <?php echo woocommerce_mini_cart();?>
            </div>
            
           

        </div>

        <?php
      

    }
endif;


/**
 * Footer run static content
 */
add_action('wp_footer', 'elessi_run_static_content', 9);
if (!function_exists('elessi_run_static_content')) :
    function elessi_run_static_content() {
        do_action('nasa_before_static_content');
        do_action('nasa_static_content');
        do_action('nasa_after_static_content');
    }
endif;






// Refresh the cart fragments.
if ( class_exists( 'woocommerce' ) ) {

    // add_filter( 'woocommerce_add_to_cart_fragments', 'wc_refresh_mini_cart_count'  );
}

add_action('nasa_static_content', 'elessi_static_config_info', 21);
if (!function_exists('elessi_static_config_info')) :
    function elessi_static_config_info() {

        /**
         * Event After add to cart
         */
        $after_add_to_cart =  'sidebar';
        echo '<!-- Event After Add To Cart -->';
        echo '<input type="hidden" name="nasa-event-after-add-to-cart" value="' . esc_attr($after_add_to_cart) . '" />';

        ?>
        <!-- Confirm text - Value to 0 in Quantity - Cart Sidebar -->
        <input type="hidden" name="nasa_change_value_0" value="<?php echo esc_attr__('Are you sure you want to remove it?', 'elessi-theme'); ?>" />
        <?php

    }
endif;


function fake_purchase_control(){
    $fake_purchase_cocke = !empty(prk_option('fake_purchase_cocke')) ? prk_option('fake_purchase_cocke') : '3';
    if(!isset($_COOKIE['customers_purchase_recently_viewed']) || (isset($_COOKIE['customers_purchase_recently_viewed']) && !$_COOKIE['customers_purchase_recently_viewed'])){
        setcookie('customers_purchase_recently_viewed', 1, time() + ($fake_purchase_cocke * 3600), "/"); // 86400 = 1 day
    }else{
        add_filter( 'fake_purchase_per_time', function(){
            return true;
        });
    }

}


// add_action('init', 'fake_purchase_control');



/**
 * enqueue scripts
 */
add_action('wp_enqueue_scripts', 'prk_enqueue_inline_scripts', 998);
function prk_enqueue_inline_scripts() {

    $prk_option = get_option('prk_option');
    $prefix = 'parskala';

    $fake_purchase_per_time = apply_filters( 'fake_purchase_per_time', false);
    if (!isset($prk_option['fake_purchase']) || !$prk_option['fake_purchase'] || $fake_purchase_per_time) {
        return;
    }

    if ( $prk_option['fake_purchase_show_mobile'] == '1' ) {

        /**
         * Fake Purchased
         */
        if (isset($prk_option['fake_purchase']) && $prk_option['fake_purchase']) {
            if (isset($prk_option['fake_purchase_ct']) && $prk_option['fake_purchase_ct']) {
                
                $p_data = $prk_option['fake_purchase_ct'];

                if (!empty($p_data)) {
                    $array_js = array();
                    
                    foreach ($p_data as $prd) {
                        $prd = (array) $prd;
                        
                        $array_js[] = array(
                            'src_img' => $prd['img_url']['url'], 
                            'customer' => $prd['name'], 
                            'p_url' => $prd['pro_href'], 
                            'p_name' => $prd['pro_name'],
                            'Verified' => $prd['Verified_text'], 
                            'time_purchase' => $prd['day'] 
                        );
                    }
                    
                    if (!empty($array_js)) {
                        wp_enqueue_script($prefix . '-fk-purchased', THEME_ASSETS_SCRIPT_URI . '/prk-fk-purchased.js', array('jquery'), PRK_VERSION, true);
                        wp_enqueue_style('fake-purchase', parskala_URI . '/assets/css/fake-purchase.css', array(), '4.3.3', 'all');
                        wp_add_inline_script($prefix . '-fk-purchased', 'var ns_fkp_count=' . count($array_js) . '; var ns_fkp=' . json_encode($array_js), 'before');
                    }
                }
            }
        }

    }else{
                /**
         * Fake Purchased
         */
        if ( !mobile_cheker() && !tablet_cheker() ) {
            if (isset($prk_option['fake_purchase_ct']) && $prk_option['fake_purchase_ct']) {
                
                $p_data = $prk_option['fake_purchase_ct'];

                if (!empty($p_data)) {
                    $array_js = array();
                    
                    foreach ($p_data as $prd) {
                        $prd = (array) $prd;
                        
                        $array_js[] = array(
                            'src_img' => $prd['img_url']['url'], 
                            'customer' => $prd['name'], 
                            'p_url' => $prd['pro_href'], 
                            'p_name' => $prd['pro_name'],
                            'Verified' => $prd['Verified_text'],
                            'time_purchase' => $prd['day'] 
                        );
                    }
                    
                    if (!empty($array_js)) {
                        wp_enqueue_script($prefix . '-fk-purchased', THEME_ASSETS_SCRIPT_URI . '/prk-fk-purchased.js', array('jquery'), PRK_VERSION, true);
                        wp_enqueue_style('fake-purchase', parskala_URI . '/assets/css/fake-purchase.css', array(), '4.3.3', 'all');
                        wp_add_inline_script($prefix . '-fk-purchased', 'var ns_fkp_count=' . count($array_js) . '; var ns_fkp=' . json_encode($array_js), 'before');
                    }
                }
            }
        }
    }
}

/**
 * Static Compare sidebar
 */
add_action('nasa_static_content', 'elessi_fake_purchased_tmpl', 18);
if (!function_exists('elessi_fake_purchased_tmpl')) :
    function elessi_fake_purchased_tmpl() {
        $prk_option = get_option('prk_option');
        
        if ( is_product() && prk_option('show_sticky_add') == '0' ){

            if (!isset($prk_option['fake_purchase']) || !$prk_option['fake_purchase']) {
                return;
            }

         }elseif( is_product() ){
            return;
         }

        

        ?>
        <script type="text/template" id="ns-sale-notification-tml">
            <div class="wrapper-noti <?= prk_option('fake_purchase_posi') ?>">
                <div class="product-image">
                    <img alt="{{p_name}}" src="{{src_img}}" />
                </div>
                
                <div class="theme-bg"></div>

                <div class="wrapper-theme">
                
                    <div class="noti-title">
                        {{customer}}
                    </div>

                    <a class="noti-body nasa-bold" href="{{p_url}}" title="{{p_name}}" target="_blank">{{p_name}}</a>
                    
                    <div class="noti-time flexed">{{time_purchase}}<span class="verify margin-left-10 rtl-margin-left-0 rtl-margin-right-10 flexed"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="14" height="14" viewBox="0 0 32 32" fill="currentColor"><path d="M16 2.672c-7.361 0-13.328 5.967-13.328 13.328s5.968 13.328 13.328 13.328c7.361 0 13.328-5.967 13.328-13.328s-5.967-13.328-13.328-13.328zM16 28.262c-6.761 0-12.262-5.501-12.262-12.262s5.5-12.262 12.262-12.262c6.761 0 12.262 5.501 12.262 12.262s-5.5 12.262-12.262 12.262z" /><path d="M22.667 11.241l-8.559 8.299-2.998-2.998c-0.312-0.312-0.818-0.312-1.131 0s-0.312 0.818 0 1.131l3.555 3.555c0.156 0.156 0.361 0.234 0.565 0.234 0.2 0 0.401-0.075 0.556-0.225l9.124-8.848c0.317-0.308 0.325-0.814 0.018-1.131-0.309-0.318-0.814-0.325-1.131-0.018z" /></svg>{{Verified}}</span></div>
                </div>
            </div>
            
            <a href="javascript:void(0);" class="close-noti" rel="nofollow"></a>
        </script>
        <?php
    }
endif;




