<?php
$wcqv_plugin_dir_url  = parskala_URI.'/inc/woo-quick-view/';
if (!defined( 'ABSPATH')) exit;
class wcqv_frontend{
	
	public $wcqv_plugin_dir_url;
    public $wcqv_options;
    public $wcqv_style;

	function __construct($wcqv_plugin_dir_url){
        // var_dump(2);
		// die;
		$this->wcqv_plugin_dir_url = $wcqv_plugin_dir_url;
		$this->wcqv_options = get_option('wcqv_options');
  		$this->wcqv_style   = get_option('wcqv_style');

		add_action( 'wp_enqueue_scripts', array($this,'wcqv_load_assets'));

		
		add_action( 'woocommerce_after_shop_loop_item', array($this,'quick_add2cart_button'),1 );
	
		
		add_action( 'woocommerce_before_shop_loop_item', array($this,'prk_woocommerce_before_shop_loop_item'),1 );
		add_action( 'woocommerce_after_shop_loop_item', array($this,'prk_woocommerce_after_shop_loop_item'),1 );

		add_action( 'prk_el_woocommerce_before_shop_loop_item', array($this,'prk_woocommerce_before_shop_loop_item'),1 );
		add_action( 'prk_el_woocommerce_after_shop_loop_item', array($this,'prk_woocommerce_after_shop_loop_item'),1 );	

		add_action( 'wp_ajax_wcqv_get_product', array($this,'wcqv_get_product') );
        add_action( 'wp_ajax_nopriv_wcqv_get_product', array($this,'wcqv_get_product') );


        // add_action( 'wcqv_product_data', 'woocommerce_template_single_price');
        add_action( 'wcqv_product_data', 'woocommerce_template_single_add_to_cart');
        add_action( 'wcqv_product_data', 'woocommerce_template_single_meta' );
		add_filter( 'add_to_cart_bottom', array($this,'quick_add2cart_button_el'),10,2);
 
	}
    
	public function wcqv_load_assets(){
        
        wp_enqueue_style  ( 'wcqv_remodal_default_css',    $this->wcqv_plugin_dir_url.'css/style.css');
		wp_register_script( 'wcqv_frontend_js', $this->wcqv_plugin_dir_url.'js/frontend.js',array('jquery'),'1.0', true);
		$frontend_data = array(

		'wcqv_nonce'          => wp_create_nonce('wcqv_nonce'),
		'ajaxurl'             => admin_url( 'admin-ajax.php' ),
		'wcqv_plugin_dir_url' => $this->wcqv_plugin_dir_url
 

		);

		wp_localize_script( 'wcqv_frontend_js', 'wcqv_frontend_obj', $frontend_data );
		wp_enqueue_script ( 'jquery' );
		wp_enqueue_script ( 'wcqv_frontend_js' );

	

		global $woocommerce;
 
		 
		
		wp_enqueue_script( 'wc-add-to-cart-variation' );
		wp_enqueue_script('thickbox');

 
	   

         
	}





	public function quick_add2cart_button() {
		global $post, $product;

		if ( ! $product instanceof \WC_Product ) {
			return;
		}

		// تنظیمات با دیفالت
		$add_to_cart_enabled = prk_option('archive_product_add_to_cart');
		$btn_mode            = prk_option('archive_product_add_to_cart_type');
		$icon_class          = prk_option('archive_product_add_to_cart_icon') ?: 'prk-shopping-cart';
		$icon_text           = prk_option('archive_product_add_to_cart_text') ?: 'افزودن به سبد';

		// اگر دکمه از تنظیمات خاموشه، خروج
		if ( $add_to_cart_enabled !== '1' && $add_to_cart_enabled !== '' ) {
			return;
		}

		// فقط وقتی موجود و قابل خرید باشه نمایش بده
		if ( ! $product->is_in_stock() || ! $product->is_purchasable() ) {
			return;
		}

		// رندر دکمه
		if ( $btn_mode === 'icon' || empty($btn_mode) ) {
			echo '<a data-product-id="' . esc_attr($post->ID) . '" class="quick_add2cart button"><span><i class="' . esc_attr($icon_class) . '"></i></span></a>';
		} else {
			echo '<a data-product-id="' . esc_attr($post->ID) . '" class="quick_add2cart text"><span>' . esc_html($icon_text) . '</span></a>';
		}
	}


	// elementor btn cart
	public function quick_add2cart_button_el($cart_text,$type_add_to_cart){

		global $post;

		if($type_add_to_cart == 'text'){
			return $cart_text;

		}
		return '<a data-product-id="'.$post->ID.'"class="quick_add2cart button" ><span> <i class="prk-shopping-cart"></i> </span></a>';

		


	}


	public function prk_woocommerce_before_shop_loop_item(){

		global $post;

		?>

		 <div class="product-box-inner">
		 <div class="info-product">

		<?php
	}

	function prk_woocommerce_after_shop_loop_item(){
		
		global $post;
		?>

		  </div>
	  
		   <div class="variable-cart-product add2cart--wrapper">

		     <button class="back-to-product"><i class="prk-arrow-right-1"></i></button>

             <?= prk_loading_modern() ?>

		    <div class = "wcqv_contend"></div>

		   </div>
	  
		 </div>

		<?php
	}



	public function wcqv_get_product(){

		global $woocommerce;

		$suffix      = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$lightbox_en = get_option( 'woocommerce_enable_lightbox' ) == 'yes' ? true : false;

		
		global $post;
		$product_id = $_POST['product_id'];
		if(intval($product_id)){

			 wp( 'p=' . $product_id . '&post_type=product' );
 	         ob_start();
 	

		 	while ( have_posts() ) : the_post(); ?>
	 	    <script>
		 	  
		 	    var wc_add_to_cart_variation_params = {"ajax_url":"\/wp-admin\/admin-ajax.php"};     
	            jQuery.getScript("<?php echo $woocommerce->plugin_url(); ?>/assets/js/frontend/add-to-cart-variation.min.js");
	 	    </script>
			
 	        <div class="product">  

 	                <div id="product-<?php the_ID(); ?>" <?php post_class('product'); ?> >  
 	                        <?php do_action('wcqv_show_product_sale_flash'); ?> 

                               
	 	                        <div class="summary entry-summary scrollable">
	 	                                <div class="summary-content">   
	                                       <?php

	                                        do_action( 'wcqv_product_data' );

	                                        ?>
	 	                                </div>
	 	                        </div>
	 	                         <div class="scrollbar_bg"></div>
 
 	                </div> 
 	        </div>
 	       
 	        <?php endwhile;

 	        echo  ob_get_clean();
 	
 	        exit();
            
			
	    }
	}
	
}
new wcqv_frontend($wcqv_plugin_dir_url);

add_filter('post_class', function($classes, $class, $product_id) {
    if( is_shop() || is_product_category() ) {
        //only add these classes if we're on a product category page.
        $classes = array_merge(['prob-item'], $classes);
    }
    return $classes;
},10,3);

?>