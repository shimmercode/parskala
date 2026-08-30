<?php


final class Elementor_prk_Extension {


	const VERSION = '1.0.0';


	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	const MINIMUM_PHP_VERSION = '7.0';

	private static $_instance = null;


	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	public function __construct() {

		add_action( 'after_setup_theme', [ $this, 'on_plugins_loaded' ] );

	}

	public function i18n() {

		load_plugin_textdomain( 'elementor-test-extension' );

	}


	public function on_plugins_loaded() {

		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}

	}

	public function is_compatible() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {

			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		return true;

	}


	public function init() {

		$this->i18n();

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );

	}

	public function init_widgets() {
    $checker = new mob_cheker;
		// اپلود فایل های ابزارک
		require_once( __DIR__ . '/widgets/widget-slider-main.php' );
		require_once( __DIR__ . '/widgets/widget-slider.php' );
		require_once( __DIR__ . '/widgets/widget-slider-image.php' );
		require_once( __DIR__ . '/widgets/widget-product-Multi-line.php' );
		require_once( __DIR__ . '/widgets/widget-product-off-carosel.php' );
		require_once( __DIR__ . '/widgets/widget-product-off-carosel-ver2.php' );
		require_once( __DIR__ . '/widgets/widget-product-off-carosel-v2.php' );
		require_once( __DIR__ . '/widgets/Widget-products-expected.php' );
		require_once( __DIR__ . '/widgets/widget-product-off-carosel-mobit.php' );
		require_once( __DIR__ . '/widgets/list-sections-item-product-cat.php' );
		require_once( __DIR__ . '/widgets/widget-product-carosel.php' );
		require_once( __DIR__ . '/widgets/Widget-products-special-momentary.php' );
		require_once( __DIR__ . '/widgets/widget-categorys-item.php' );
		require_once( __DIR__ . '/widgets/widget-banner-ads.php' );
		require_once( __DIR__ . '/widgets/widget-carousel-brands.php' );
		require_once( __DIR__ . '/widgets/widget-carousel-items.php' );
		require_once( __DIR__ . '/widgets/widget-blog-carosel.php' );
		require_once( __DIR__ . '/widgets/widget-news-carosel.php' );
		require_once( __DIR__ . '/widgets/widget-blog-sidebar.php' );
        require_once( __DIR__ . '/widgets/widget-products.php' );
        require_once( __DIR__ . '/widgets/slider-products.php' );
		require_once( __DIR__ . '/widgets/article-products.php' );
		require_once( __DIR__ . '/widgets/services-item.php' );
		require_once( __DIR__ . '/widgets/services-link.php' );
		require_once( __DIR__ . '/widgets/carousel-offer.php' );
		require_once( __DIR__ . '/widgets/mini-offer-product.php' );
		require_once( __DIR__ . '/widgets/m-carousel-product.php' );
		require_once( __DIR__ . '/widgets/item-category.php' );
		require_once( __DIR__ . '/widgets/promotions-slider-product.php' );
		require_once( __DIR__ . '/widgets/lists-section-product.php' );
		require_once( __DIR__ . '/widgets/dynamic-banner.php' );
		require_once( __DIR__ . '/widgets/ser-item.php' );
		require_once( __DIR__ . '/widgets/grid-item-product.php' );
		require_once( __DIR__ . '/widgets/mcarousel-post.php' );
        require_once( __DIR__ . '/widgets/widget-product-carosel-fasoin.php' );
		require_once( __DIR__ . '/widgets/widget-product-off-carosel-fashoin.php' );
		require_once( __DIR__ . '/widgets/services-item-fashion.php' );
		require_once( __DIR__ . '/widgets/feautures-icon-slider.php' );
		require_once( __DIR__ . '/widgets/widget-prob-banner.php' );
		require_once( __DIR__ . '/widgets/widget-slider-3d.php' );
		// require mobile widgets
		require_once( __DIR__ . '/widgets/article-slider.php' );
		require_once( __DIR__ . '/widgets/box-icon-slider.php' );
		require_once( __DIR__ . '/widgets/mobile-grad-category.php' );
		require_once( __DIR__ . '/widgets/widget-description-box.php' );
		require_once( __DIR__ . '/widgets/widget-khadamat-items.php' );
		require_once( __DIR__ . '/widgets/widget-product-carosel-game.php' );
		require_once( __DIR__ . '/widgets/list-sections-item.php' );

		// require blog widgets 
		require_once( __DIR__ . '/widgets/image-box-post.php' );
		require_once( __DIR__ . '/widgets/widget-post.php' );


		//  کلاس های ابزارک
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \slider_main_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \sldiers_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \sldier_image_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \sldier_3d_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \officals_carosel_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \product_Multi_line_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \officals_carosel_Widget_ver2() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \officals_carosel_Widget_v2() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \products_special_momentary_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \categorys_list_item() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \banner_ads_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \carousel_brands_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \carousel_items_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \prk_list_sections_item_product_cat() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \blog_carosel_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \news_carosel_Widget() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \product_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \blog_sidebar_Widget() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \mini_offer() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \carousel_offer() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \products_expected_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \item_category() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \mcarousel_product() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \lists_section_product() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \dynamic_banner() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \repeater_services_item() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \grid_item_product() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \mcarousel_post() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \news_description_box() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \khadamat_items_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \swip_icon_feautures_slider() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \game_product_carosel_Widget() );	
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \promo_banner_Widget() );	
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \prk_list_sections_item() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \officals_carosel_Widget_mobit() );		

		// classes mobile widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \swip_article_slider() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \swip_icon_box_slider() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \mobile_grad_category() );

		// classes blog widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \image_box_post() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \widget_post_class() );

    // if fashon style
		if ( 'prk-fashion' == theme_style() ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \product_carosel_Widget_fashoin() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \officals_carosel_Widget_fashoin() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \services_item_fashoin() );
		}

		// if havent fashon style
		if ( empty('prk-fashion' == theme_style())  ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \product_carosel_Widget() );
		}

		// نمایش فقط در دسکتاپ
		if (! $checker->isMobile() && ! $checker->isTablet() ) {

			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \swip_slider_products() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \swip_article_products() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \services_item() );
	        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \services_link() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \promotions_slider() );
	  }

	}


  public function init_controls() {

  	}


	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-test-extension' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-test-extension' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-test-extension' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-test-extension' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

}

Elementor_prk_Extension::instance();


function prk_add_elementor_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'prk-category',
		[
			'title' => __( 'عناصر اصلی پارس کالا', 'plugin-name' ),
			'icon' => 'fa fa-plug',
		]
	);

	$elements_manager->add_category(
		'prk-mobile-category',
		[
			'title' => __( 'عناصر نسخه موبایل پارس کالا', 'plugin-name' ),
			'icon' => 'fa fa-plug',
		]
	);
	$elements_manager->add_category(
		'prk-blog-category',
		[
			'title' => __( 'عناصر وبلاگ پارس کالا', 'plugin-name' ),
			'icon' => 'fa fa-plug',
		]
	);

?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/fonts/dana/dana-config.css" type="text/css">
<style media="screen">

	#elementor-panel-category-prk-category .elementor-element{
		position: relative;
	}
	#elementor-panel-category-prk-category .elementor-element::before{
		position: absolute;
		content: 'PRK';
		background: linear-gradient(90deg,#faa927,#ef5662);
		right: 0%;
		top: 0%;
		border-radius: 0 0 0 18px;
		font-family: prk-font;
		padding: 3px 6px 4px 7px;
		color: #fff;
		font-weight: 600;
		line-height: 18px;
		border: 0;
		overflow: hidden;
		font-size: 12px;
	}
	#elementor-panel-category-general .elementor-element .title,.elementor-panel-category-title{
		font-family: prk-font !important;
	}
	#elementor-panel-category-general .elementor-element .title{
		font-size: 11px !important;
	}
</style>
<?php
}
add_action( 'elementor/elements/categories_registered', 'prk_add_elementor_widget_categories' );
