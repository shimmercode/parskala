<?php
class products_special_momentary_Widget extends \Elementor\Widget_Base{


	public function get_name() {
		return 'products_special_momentary';
	}

	public function get_title() {
		return 'پیشنهاد لحظه ای';
	}

	public function get_icon() {
		return 'eicon-product-upsell';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'text',
			[
				'label' => 'پیشنهاد لحظه ای',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'title-pro',
			[
				'label' => 'عنوان',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'عنوان',
				'default' => 'محصولات فروش ویژه',
			]
		);

		// حلقه دسته بندی های محصولات
		$options = array();
		$args = array(
		'hide_empty' => false,
		);
		$categories =  $categories = get_categories(array('taxonomy'=> 'product_cat'));
		foreach ( $categories as $key => $category ) {$options[$category->term_id] = $category->name;}

		$prod_cata = array();
		$categories = get_terms("product_cat");
		if ( !empty( $categories ) && !is_wp_error( $categories ) ){
			foreach ( $categories as $category ) {
				$prod_cata[ $category->term_id ] = $category->name;
			}
		}


			$prod_taga = array();
			$tags = get_terms("product_tag");
			if ( !empty( $tags ) && !is_wp_error( $tags ) ){
				foreach ( $tags as $tag ) {
					$prod_taga[ $tag->term_id ] = $tag->name;
				}
			}



			$prod_brand = array();
			$brands = get_terms("brand");
			if ( !empty( $brands ) && !is_wp_error( $brands ) ){
				foreach ( $brands as $brand ) {
					$prod_brand[ $brand->term_id ] = $brand->name;
				}
			}


			$this->add_control(
				'prod_sort',
				[
					'label' => __( 'مرتب سازی محصولات', 'parskala' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'latest',
					'options' => [
						'latest'  => __( 'آخرین محصولات', 'parskala' ),
						'random' => __( 'محصولات تصادفی', 'parskala' ),
						'viewed' => __( 'پربازدید ترین محصولات', 'parskala' ),
						'saled' => __( 'محصولات پر فروش', 'parskala' ),
						'price-desc'  => __( 'قیمت از نزولی', 'parskala' ),
						'price-asc'  => __( 'قیمت از صعودی', 'parskala' ),
						'coming_soon' => __( 'محصولات به زودی', 'parskala' ),
						'discounted' => __( 'محصولات تخفیف خورده', 'parskala' ),
						'rand_discounted' => __( 'محصولات تخفیف خورده تصادفی', 'parskala' ),
						'special' => __( 'محصولات شگفت انگیز', 'parskala' ),
						'rand_special' => __( 'محصولات شگفت انگیز تصادفی', 'parskala' ),
						'menu_order' => __( 'برطبق عنوان', 'parskala' ),
					],
				]
			);

			$this->add_control(
				'out_prod',
				[
					'label' => __( 'نمایش محصولات موجود در انبار', 'parskala' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'روشن', 'parskala' ),
					'label_off' => __( 'خاموش', 'parskala' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$this->add_control(
				'prod_filter',
				[
					'label' => __( 'فیلتر محصول', 'parskala' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'category',
					'options' => [
						'category'  => __( 'دسته محصوالت', 'parskala' ),
						'tag' => __( 'برچسب محصولات', 'parskala' ),
						'brand' => __( 'برند محصولات', 'parskala' ),
						'pro_id' => __( 'انتخاب دستی محصولات', 'parskala' ),
					],
				]
			);


			$this->add_control(
				'product_cat',
				[
					'label' => __( 'دسته بندی محصولات', 'parskala' ),
					'description' => __( 'برچسب های خالی (بدون محصول) نمایش داده نمی شوند', 'parskala' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'multiple' => true,
					'options' => $prod_cata,
					'condition' => [
											'prod_filter' => 'category',
									],
				]
			);
			$this->add_control(
				'product_tag',
				[
					'label' => __( 'فیلتر بر اساس تگ', 'parskala' ),
					'description' => __( 'برچسب های خالی (بدون محصول) نمایش داده نمی شوند', 'parskala' ),
					'label_block' => true,
					'type' => \Elementor\Controls_Manager::TEXT,
					'placeholder' => __( 'Tag(s) ID', 'parskala' ),
					'condition' => [
						'prod_filter' => 'tag',
					],
				]
			);
			$this->add_control(
				'product_brand',
				[
					'label' => __( 'فیلتر بر اساس برند', 'parskala' ),
					'description' => __( 'فیلتر و نمایش محصول بر اساس برند', 'parskala' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'multiple' => true,
					'options' => $prod_brand,
					'condition' => [
						'prod_filter' => 'brand',
					],
				]
			);
			$this->add_control(
				'product_id',
				[
					'label' => __( 'شناسه محصولات', 'parskala' ),
					'description' => __( 'ایدی محصولات رو با , جدا کنید مثلا: 10,20,310', 'parskala' ),
					'label_block' => true,
					'type' => \Elementor\Controls_Manager::TEXT,
					'placeholder' => __( 'آیدی محصول', 'parskala' ),
					'condition' => [
						'prod_filter' => 'pro_id',
					],
				]
			);
		$this->add_control(
			'ptotalcount',
			[
				'label' => __( 'تعداد محصولات', 'parskala' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 200,
				'step' => 1,
				'default' => 8,
			]
		);
		$this->add_control(
				 'show_btn_cart',
				 [
						'label' => 'نمایش دکمه افزودن به سبد خرید',
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'default' => 'false',

				 ]
			);
			$this->add_control(
				'prk_swatches_list',
				[
					'label' => 'نمایش ایکن متغیر ها',
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'بله', 'your-plugin' ),
					'label_off' => __( 'خیر', 'your-plugin' ),
					'return_value' => 'true',
					'default' => 'true',
				]
			);

      $this->add_control(
  				 'show_timer',
  				 [
  						'label' => __( 'نمایش تایمر معکوس', 'PRK' ),
  						'type' => \Elementor\Controls_Manager::SWITCHER,
              'return_value' => 'yes',
  						'default' => 'yes',

  				 ]
  		);

		  $this->add_control(
			'prk_show_unavailable_text',
			[
				'label' => 'نمایش لیبل ناموجود',
				'description' => 'نمایش لیبل ناموجود برای محصولات ناموجود',
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'بله', 'your-plugin' ),
				'label_off' => __( 'خیر', 'your-plugin' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
	
		$this->add_control(
			'prk_unavailable_text',
			[
				'label' => __( 'متن لیبل ناموجود', 'parskala' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'ناموجود', 'parskala' ),
				'default' => __( 'ناموجود', 'parskala' ),
				'condition' => [
					'prk_show_unavailable_text' => 'true',
				],
			]
		);


	 $this->end_controls_section();



	 // شروع تب استایل
	  $this->start_controls_section(
	 	 'section_style',
	 	 [
	 		 'label' => esc_html__( 'استایل سکشن', 'plugin-name' ),
	 		 'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	 	 ]
	  );

		$this->add_control(
 			 'section_old_style',
 			 [
 				 'label' => 'استایل قدیمی',
 				 'type' => \Elementor\Controls_Manager::SWITCHER,
 				 'label_on' => __( 'فعال', 'your-plugin' ),
 				 'label_off' => __( 'غیر فعال', 'your-plugin' ),
 				 'return_value' => 'true',
 				 'default' => 'false',
 			 ]
 		 );

	  $this->add_control(
	 	 'color_back',
	 	 [
	 		 'label' => __( 'رنگ اصلی پس زمینه', 'plugin-domain' ),
	 		 'type' => \Elementor\Controls_Manager::COLOR,
	 		 'default' => '#ef5662',
	 		 'selectors' => [
	 			 '{{WRAPPER}} .col-product.wee' => 'background-color: {{VALUE}}',
	 		 ],
	 	 ]
	  );
		$this->add_control(
		 'color_titles',
		 [
			 'label' => __( 'رنگ عناوین', 'plugin-domain' ),
			 'type' => \Elementor\Controls_Manager::COLOR,
			 'selectors' => [
				 '{{WRAPPER}} .col-product.wee .head-hani h2' => 'color: {{VALUE}}',
				 '{{WRAPPER}} .col-product.wee .wee_title' => 'color: {{VALUE}}',
				 '{{WRAPPER}} .col-product.wee .breadcrumb a' => 'color: {{VALUE}} !important',
				 '{{WRAPPER}} .product_wee del .woocommerce-Price-amount' => 'color: {{VALUE}}',
				 '{{WRAPPER}} .product_wee .index-prices-pro bdi' => 'color: {{VALUE}}',
				 '{{WRAPPER}} .product_wee .index-prices-pro em' => 'color: {{VALUE}}',
				 '{{WRAPPER}} .product_wee .index-prices-pro .woocommerce-Price-currencySymbol' => 'color: {{VALUE}} !important',
				 '{{WRAPPER}} .product_wee .prk_timer span' => 'color: {{VALUE}} !important',
				 '{{WRAPPER}} .product_wee .prk_timer #timerm span .number' => 'color: {{VALUE}} !important',
			 ],
		 ]
		);
		$this->add_control(
	 	 'color_back_tumbnail',
	 	 [
	 		 'label' => __( 'رنگ اصلی پس تصویر محصول', 'plugin-domain' ),
	 		 'type' => \Elementor\Controls_Manager::COLOR,
	 		 'selectors' => [
	 			 '{{WRAPPER}} .col-product.wee' => 'background-color: {{VALUE}}',
	 		 ],
	 	 ]
	  );
		$this->add_control(
	 	 'color_border',
	 	 [
	 		 'label' => __( 'رنگ دور حاشیه', 'plugin-domain' ),
	 		 'type' => \Elementor\Controls_Manager::COLOR,
	 		 'selectors' => [
	 			 'body {{WRAPPER}} .col-product.wee' => 'border-color: {{VALUE}} ',
	 		 ],
	 	 ]
	  );
		$this->add_control(
		 'color_back_image',
		 [
			 'label' => __( 'رنگ حاله پشت تصویر', 'plugin-domain' ),
			 'type' => \Elementor\Controls_Manager::COLOR,
			 'selectors' => [
				 'body {{WRAPPER}} .col-product.wee .product_wee .wee_tumbnail::before' => 'background: {{VALUE}} !important',
			 ],
		 ]
		);

	 		$theme_display = prk_option('theme-style');
	 		if($theme_display == 'digikala'){
	 			$border_count = '8';
	 		}else{
	 			$border_count = '11';
	 		}
			$this->add_control(
		 			 'border',
		 			 [
		 				 'label' => esc_html__( 'انحنا دور سکشن', 'plugin-name' ),
		 				 'type' => \Elementor\Controls_Manager::NUMBER,
		 				 'min' => 1,
		 				 'step' => 1,
		 				 'default' => $border_count,
		 				 'selectors' => [
		 					 '{{WRAPPER}} .col-product.wee' => 'border-radius: {{VALUE}}px',
		 				 ],
		 			 ]
		  );


	  $this->end_controls_section();
	  // پایان تب استایل

	}

	protected function render() {

  $settings  = $this->get_settings_for_display();
	$random_id = slider_RandomString();

	$title_pro =  $settings['title-pro'];
  $show_timer =   $settings['show_timer'];
  $show_btn_cart =   $settings['show_btn_cart'];
  $old_style =   $settings['section_old_style'];


  if ($old_style == 'true') {
  	$classes_general = 'old_ver';
  }else {
  	$classes_general = '';
  }






												 $prod_sort = $settings['prod_sort'];
										 		$prod_filter = $settings['prod_filter'];
										 		$product_cat = $settings['product_cat'];
										 		$product_tag = $settings['product_tag'];
												$product_brand = $settings['product_brand'];




											 $view_all_link = '';
									 			if($prod_sort != 'special' && $prod_sort != 'rand_special') {
									 			switch ($prod_sort) {
									 				case 'latest':
									 					$arms = array(
									 					'posts_per_page' => $settings['ptotalcount'],
									 					'post_type' => 'product',
									 					'post_status' => 'publish',
									 					'order' => 'DESC'  );
									 					break;
									 				case 'menu_order':
									 					$arms = array(
									 					'posts_per_page' => $settings['ptotalcount'],
									 					'post_type' => 'product',
									 					'post_status' => 'publish',
									 					'orderby' => 'menu_order title',
									 					'order' => 'ASC'  );
									 					break;
									 				case 'saled':
									 					$arms = array(
									 					'posts_per_page' => $settings['ptotalcount'],
									 					'post_type' => 'product',
									 					'post_status' => 'publish',
									 					'meta_key' => 'total_sales',
									                     'orderby' => 'meta_value_num',
									                     'order' => 'DESC'  );
									 					break;
									 				case 'discounted':
									 					$arms = array(
									 						'posts_per_page'    => $settings['ptotalcount'],
									 						'post_status'       => 'publish',
									 						'order' => 'DESC',
									 						'post_type'         => 'product',
									 						'post__in'          => array_merge( array( 0 ), wc_get_product_ids_on_sale() )
									 					);
									 					break;
									 				case 'coming_soon':
									 					$arms = array(
									 						'posts_per_page' => $settings['ptotalcount'],
									 						'post_type' => 'product',
									 						'post_status' => 'publish',
									 						'meta_key' => 'prk_coming',
									 						'meta_value' => 'yes',
									 						'order' => 'DESC'
														 );
									 					break;
									 				case 'rand_discounted':
									 					$arms = array(
									 						'posts_per_page'    => $settings['ptotalcount'],
									 						'post_status'       => 'publish',
									 						'orderby'        	=> 'rand',
									 						'post_type'         => 'product',
									 						'post__in'          => array_merge( array( 0 ), wc_get_product_ids_on_sale() )
									 					);
									 					break;
									 				case 'viewed':
									 					$arms = array(
									 					'posts_per_page' => $settings['ptotalcount'],
									 					'post_type' => 'product',
									 					'post_status' => 'publish',
														'order'            => 'DESC',
												    'suppress_filters' => false,  //required param
												    'orderby'          => 'post_views',  //required param
														);
									 					break;
									 				case 'price-desc':
									 					$arms = array(
									 					'posts_per_page' => $settings['ptotalcount'],
									 					'post_type' => 'product',
									 					'post_status' => 'publish',
									 					'orderby'        => 'meta_value_num',
									 					'meta_key'       => '_price',
									 					'order'          => 'DESC');
									 					break;
									 				case 'price-asc':
									 					$arms = array(
									 					'posts_per_page' => $settings['ptotalcount'],
									 					'post_type' => 'product',
									 					'post_status' => 'publish',
									 					'orderby'        => 'meta_value_num',
									 					'meta_key'       => '_price',
									 					'order'          => 'ASC');
									 					break;
									 				case 'random':
									 					$arms = array(
									 					'posts_per_page' => $settings['ptotalcount'],
									 					'post_type' => 'product',
									 					'post_status' => 'publish',
									 					'orderby'        => 'rand'  );
									 					break;
									 				default:
									 				$arms = array(
									 					'posts_per_page' => $settings['ptotalcount'],
									 					'post_type' => 'product',
									 					'post_status' => 'publish',
														'meta_key' => 'onsales_round',
														'meta_value' => 'yes',
									 				 );
									 				}
									 				if ( $prod_filter ) {
									 					if ( $prod_filter == 'category' && !empty($product_cat) ) {
									 						$arms['tax_query'] = array(
									 							array(
									 							'taxonomy' => 'product_cat',
									 							'field' => 'term_id',
									 							'terms' => $product_cat
									 							)
									 						);
									 						$view_all_link = prk_get_term_links( 'product_cat', $product_cat );
									 					} elseif ( $prod_filter == 'tag' && !empty($product_tag) ) {
									 						$arms['tax_query'] = array(
									 							array(
									 							'taxonomy' => 'product_tag',
									 							'field' => 'term_id',
									 							'terms' => $product_tag
									 							)
									 						);
									 						$view_all_link = prk_get_term_links( 'product_tag', $product_tag );
									 					} elseif ( $prod_filter == 'brand' && !empty($product_brand) ) {
									 						$arms['tax_query'] = array(
									 							array(
									 							'taxonomy' => 'brand',
									 							'field' => 'term_id',
									 							'terms' => $product_brand
									 							)
									 						);
									 						$view_all_link = prk_get_term_links( 'brand' , $product_brand );
									 					}elseif ( $prod_filter == 'pro_id' && !empty($product_id) ) {
															$arms['tax_query'] = array(
									 							array(
															    'post__in' => array( $product_id),
									 							)
									 						);
									 					}
									 				}
									 			} elseif ( $prod_sort == 'special' || $prod_sort == 'rand_special') {


													$arms = array (
															'posts_per_page' => $settings['ptotalcount'],
															'post_type' => 'product',
															'post_status' => 'publish',
															'meta_key' => 'onsales_round',
															'meta_value' => 'yes',

													);


									 					if ( !empty($prod_filter) && (!empty($product_cat) || !empty($product_tag) || !empty($product_brand)) ) {
									 					if ( $prod_filter == 'category' && !empty($product_cat) ) {
									 						$arms['tax_query'] = array(

									 						array(
									 						'taxonomy' => 'product_cat',
									 						'field' => 'term_id',
									 						'terms' => $product_cat
									 						)
									 					);
									 					} elseif ( $prod_filter == 'tag' && !empty($product_tag) ) {
									 						$arms['tax_query'] = array(

									 						array(
									 						'taxonomy' => 'product_tag',
									 							'field' => 'term_id',
									 							'terms' => $product_tag
									 						)
									 					);
									 					} elseif ( $prod_filter == 'brand' && !empty($product_brand) ) {
									 						$arms['tax_query'] = array(

									 							array(
									 							'taxonomy' => 'brand',
									 								'field' => 'term_id',
									 								'terms' => $product_brand
									 							)
									 						);
									 					}
									 				}

													if ( $prod_sort == 'special' ) {
														$args['order'] = 'DESC';
													} elseif ( $prod_sort == 'rand_special') {
														$args['orderby'] = 'rand';
													}

									 			}

									 			if('yes' === $settings['out_prod'] ){
									 				$arms['meta_query'] = array(
									 						'relation' => 'AND',
									 						array(
									 							'key' => '_stock_status',
									 							'value' => 'instock'
									 						),
									 					);
									 			}

									 			$arms[] = array(
									 				'fields'                    => 'ids',
									 				'no_found_rows'             => true,
									 				'update_post_term_cache'    => false
									 			);

												if(isset($_COOKIE['prskalaSearchCity']) && !empty(($_COOKIE['prskalaSearchCity']))){
													 $city_categories=explode(',', $_COOKIE['prskalaSearchCity']);
													 if (!empty($city_categories) && $city_categories !== 0) {
														 if (isset($arms["tax_query"]) && is_array($arms["tax_query"])) {

															 $arms["tax_query"][] = ["taxonomy" => "city_categories", "field" => "id", "terms" => $city_categories];
														 } else {
															 $arms["tax_query"] = ["relation" => "AND", ["taxonomy" => "city_categories", "field" => "id", "terms" => $city_categories]];
														 }
													 }
											 }

	$pd_query = new WP_Query( $arms );


?>

<section class="col-product wee <?php echo $classes_general;?>">

    <div class="head-hani" >
      <h2><?php echo $title_pro;?></h2>
			<div class="sec_progress_wrapper">
				<div class="sec_progress_bar sec_progress_<?php echo $random_id;?>"></div>
			</div>
    </div>

   <div class="clear"></div>

      <div id="cat_slider<?php echo $random_id;?>" class="hanis">



	     <?php if ( $pd_query ->have_posts() ) : ?>

	        <?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post();
					global $woocommerce , $product;
					$img_up_pro = get_post_meta(get_the_ID(),'img_up_pro',true);
					$currency = get_woocommerce_currency_symbol();
					$price = get_post_meta( get_the_ID(), '_regular_price', true);
					$sale = get_post_meta( get_the_ID(), '_sale_price', true);
					$date_to = get_post_meta( get_the_ID(), '_sale_price_dates_to', true);
					$progress_sales = get_post_meta(get_the_ID(), 'progress_sales', true );
					$timer_id = generateRandomString();
					$thumber = get_the_post_thumbnail();
					$imager  = wc_placeholder_img_src();
					$post_id = 	$product->get_id();
					$parent_id = wp_get_post_parent_id( $post_id );
					$product_label = get_post_meta(get_the_ID(), 'prk_product_label', true );





					 ?>

	          <article class="product_wee lists_section_product">
							<?php if ($product_label): ?>
								<div class="custom_label"><span><?php echo $product_label;?></span></div>
							<?php endif; ?>

							<a href="<?php the_permalink();?>">

							<div class="wee_tumbnail">

								<?php echo pr_img(); ?>
								<div class="shadow-product h-[0px] w-[180px] duration-500 group-hover:mt-[28px] group-hover:h-[20px] group-hover:rotate-1"></div>

							</div>

							<div class="wee_breadcrumb">

								<?php breadcrumb_product();?>

							</div>

							<?php
								if ($settings['prk_swatches_list'] && prk_option('show_swatches_archive') ) {
									echo do_shortcode("[prk_swatches_list]");
								}
							?>

							<div class="wee_title">

								<?php the_title();?>

							</div>
						</a>

							<div class="wee_countdown">
								<?php if ($show_timer == 'yes'):?>

										<?php if ($date_to): ?>

												<div class="prk_timer">
													<div id="timerm" class="timer-<?php echo $timer_id;?>"></div>
												</div>

												<script type="text/javascript">
													 var dateEnd = new Date((<?php echo $date_to; ?>) * 1000);
													 new TimezZ('.timer-<?php echo $timer_id;?>', {
													 date: dateEnd,
													 template: '<span><span class="number">NUMBER</span><span class="dot">:</span><span class="letter">LETTER</span></span>',
													 text: {
													 days: 'روز',
													 hours: 'ساعت',
													 minutes: 'دقیقه',
													 seconds: 'ثانیه',
														}
													 });
												</script>

										<?php else: ?>
											<div class="timer expired"></div>
										<?php endif; ?>

								<?php endif; ?>
							</div>

							<!--price-->
							<div class="flexed_between center">


								<!--price-->
								<div class="index-prices-pro">

									<div class="price_onsale_ar">

											 <?php
											 
											 if ( $product->is_in_stock() && $price|| $product->is_type( 'variable' )) {
												echo $product->get_price_html();
													}elseif($product->is_in_stock()){
														echo '<p class="call_pro">'.prk_option('single_product_text_price').'</p>';
												}elseif($settings['prk_show_unavailable_text']){
													echo '<p class="call_pro">'.$settings['prk_unavailable_text'].'</p>';
											}

											 ?>

									</div>
								</div>


									<?php
                   if ($show_btn_cart == 'yes') {
										echo '<div class="lists_add_to_cart">';
                   	  echo do_shortcode("[ajax_cart_item]");
										echo '</div>';
                   }
									 ?>


							</div>

	          </article>

	         <?php endwhile; ?>

	       <?php wp_reset_postdata(); ?>
	     <?php else:?>
	       <p><?php _e('No products available !' , 'parskala');?></p>
	   <?php endif;?>

    </div>

</section>
<script type="text/javascript">

			jQuery(document).ready(function($) {


				jQuery("#cat_slider<?php echo $random_id;?>").owlCarousel({
					start: 1,
					margin:5,
					lazyLoad : true,
					rtl: true,
					dots: false,
					nav: false,
					navText: ["",""],
					loop: true,
					autoplay:true,
					autoplayHoverPause:true,
					touchDrag:false,
					autoplayTimeout: 5000,
					responsiveClass:true,
					onInitialize : initProgressBar,
					onTranslate: resetProgressBar,
					onTranslated: startProgressBar,
					responsiveBaseElement:"#cat_slider<?php echo $random_id;?>",
							responsive:{
								0:{
									items:1,
								},
								480:{
									items:1,
								},
								600:{
									items:1,
								},
								1000:{
									items:1,
								},
								1200:{
									items: 1,
								}
							},
				});

				function resetProgressBar() {
					jQuery(".sec_progress_<?php echo $random_id;?>").css({
						width: 0,
						transition: "width 0ms"
					});
				}
				jQuery(".sec_progress_<?php echo $random_id;?>").animate({
					width: '100%',
				}, 5000);

				function initProgressBar(){

				}
				function startProgressBar() {
					jQuery(".sec_progress_<?php echo $random_id;?>").css({
						width: "100%",
						transition: "width 5000ms"
					});
				}


			});

</script>
		<?php

	}

	protected function _content_template() {

	}

}
