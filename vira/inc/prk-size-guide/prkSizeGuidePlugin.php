<?php


class prkSizeGuidePlugin {

	protected $active = true;

	/**
	 * Initiate object
	 */

	public function __construct() {
		add_action( 'admin_init', array( $this, 'activationWooCommerceCheck' ) );

		$this->setupConsts();
		$this->loadFiles();

		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'descLinks' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'registerAdminAssets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'registerAssets' ) );

		// textdomain
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
	}

	/**
	 * Load plugin text domain
	 */
	public function load_textdomain() {

		$locale    = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
		$locale    = apply_filters( 'prk_sizeguide_locale', $locale );

		// wp lang dir
		$lang_file = trailingslashit( WP_LANG_DIR ) . "plugins/prk-size-guide-$locale.mo";
		$loaded = load_textdomain( 'prk-sgp', $lang_file );

		// plugin lang dir
		if ( ! $loaded ) {
			$lang_file = dirname( __FILE__ ) . "/lang/prk-size-guide-$locale.mo";
			load_textdomain( 'prk-sgp', $lang_file );
		}

	}

	/**
	 * WooCommmerce Active?
	 * @return bool
	 */

	public static function hasWooCommerce() {
		return class_exists( 'WooCommerce' );
	}

	/**
	 * Setup constants
	 */

	protected function setupConsts() {
		// define( 'PRK_SIZEGUIDE_DIR', get_template_directory().'/inc/prk-size-guide');
		// define( 'PRK_SIZEGUIDE_URI', get_template_directory_uri().'/inc/prk-size-guide');
		// define( 'PRK_SIZEGUIDE_ASSETS', PRK_SIZEGUIDE_URI . '/assets' );
	}

	/**
	 * Check if we have WooCommerce
	 */

	public function activationWooCommerceCheck() {
		if ( ! self::hasWooCommerce() ) {
			add_action( 'admin_notices', array( $this, 'showWooCommerceNotice' ) );
		}
	}

	public function showWooCommerceNotice() {
		echo '<div class="prk-notice error">
                	<p><strong>' . __( 'PARSKALA Size Guide Plugin', 'prk-sgp' ) . '</strong> &#8211; ' . __( 'WooCommerce Plugin must be installed and activated in order to use this plugin.', 'prk-sgp' ) . '</p>
                </div>';
	}

	/**
	 * Load files
	 */

	protected function loadFiles() {
		require_once dirname( __FILE__ ) . '/prkSizeGuideCPT.php';
		require_once dirname( __FILE__ ) . '/prkSizeGuideDisplay.php';
		require_once dirname( __FILE__ ) . '/prkSizeGuideCategories.php';
		require_once dirname( __FILE__ ) . '/prkSizeGuideTable.php';
		// require_once dirname( __FILE__ ) . '/prkSizeGuideSettings.php';
        require_once dirname( __FILE__ ) . '/integrations/prkSizeGuideProductCsvImport.php';
		require_once dirname( __FILE__ ) . '/prkSizeGuideTags.php';

	}

	/**
	 * Add plugin links
	 */

	public function descLinks( $links ) {

		return array_merge( array(
			'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=size_guide_tab' ) . '">' . __( 'Settings', 'prk-sgp' ) . '</a>'
		), $links );

	}

	/**
	 * Add assets for admin
	 */

	public function registerAdminAssets( $hook ) {
		$screen = get_current_screen();
		if ( $screen && $screen->id == 'prk_size_guide' ) {
			wp_enqueue_style( 'prk_jquery_edittable', PRK_SIZEGUIDE_ASSETS . 'css/jquery.edittable.min.css' );
			wp_enqueue_script( 'prk_jquery_edittable', PRK_SIZEGUIDE_ASSETS . 'js/jquery.edittable.min.js', array( 'jquery' ) );
			wp_enqueue_style( 'prk_size_admin_style', PRK_SIZEGUIDE_ASSETS . 'css/admin.css' );
		}
		// var_dump(PRK_SIZEGUIDE_ASSETS);die;
        wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'prk.sg.admin.js', PRK_SIZEGUIDE_ASSETS . 'js/prk.sg.admin.js', array('jquery', 'wp-color-picker') );
		wp_enqueue_style( 'prk.sizeguide.icon.css', PRK_SIZEGUIDE_ASSETS . 'css/prk.sizeguide.icon.css' );
		wp_enqueue_style( 'prk.sizeguide.fontawesome.css', PRK_SIZEGUIDE_ASSETS . 'css/font-awesome.min.css' );
		wp_enqueue_style( 'prk.sizeguide.fontawesome.iconfield.css', PRK_SIZEGUIDE_ASSETS . 'css/fa-icon-field.css' );

	}

	public function registerAssets() {
		wp_enqueue_style( 'prk.sizeguide.css', PRK_SIZEGUIDE_ASSETS . 'css/prk.sizeguide.css' );
		if ( get_option( 'prk_option' )['wc_size_guide_style'] ) {
			$sg_style = get_option( 'prk_option' )['wc_size_guide_style'];
		} else {
			$sg_style = apply_filters( 'prk_sizeguide_styles', array(
				PRK_SIZEGUIDE_ASSETS . 'css/prk.sizeguide.style1.css' => __( 'Minimalistic', 'prk-sgp' ),
				PRK_SIZEGUIDE_ASSETS . 'css/prk.sizeguide.style2.css' => __( 'Classic', 'prk-sgp' ),
				PRK_SIZEGUIDE_ASSETS . 'css/prk.sizeguide.style3.css' => __( 'Modern', 'prk-sgp' )
			) );
			$sg_style = key( $sg_style );

		}

		wp_enqueue_style( 'prk.sizeguide.style.css', apply_filters('prk_size_guide_option_wc_size_guide_style', $sg_style));
		wp_enqueue_style( 'magnific.popup.css', PRK_SIZEGUIDE_ASSETS . 'css/magnific.popup.css' );
		wp_enqueue_script( 'magnific.popup.js', PRK_SIZEGUIDE_ASSETS . 'js/magnific.popup.js', array( 'jquery' ) );
		wp_enqueue_script( 'prk.sg.front.js', PRK_SIZEGUIDE_ASSETS . 'js/prk.sg.front.js', array( 'jquery' ) );
        wp_enqueue_style( 'prk.sizeguide.icon.css', PRK_SIZEGUIDE_ASSETS . 'css/prk.sizeguide.icon.css' );
        wp_enqueue_style( 'prk.sizeguide.fontawesome.css', PRK_SIZEGUIDE_ASSETS . 'css/font-awesome.min.css' );
        wp_enqueue_style( 'prk.sizeguide.fontawesome.iconfield.css', PRK_SIZEGUIDE_ASSETS . 'css/fa-icon-field.css' );

	}

}

new prkSizeGuidePlugin();
