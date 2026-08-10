<?php
class officals_carosel_Widget_ver2 extends \Elementor\Widget_Base {


	public function get_name() {
		return 'officals_caroselـver2';
	}

	public function get_title() {
		return 'کاروسل تخفیف های ویژه';
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {

		 // شروع سکشن کنتزل های اصلی
		 $this->start_controls_section(
					'text',
					[
						'label' => 'کاروسل تخفیف های ویژه',
						'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
					]
		 );
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
					'label' => __( 'مرتب سازی محصولات', 'dina-kala' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'latest',
					'options' => [
						'latest'  => __( 'آخرین محصولات', 'dina-kala' ),
						'random' => __( 'محصولات تصادفی', 'dina-kala' ),
						'viewed' => __( 'پربازدید ترین محصولات', 'dina-kala' ),
						'saled' => __( 'محصولات پر فروش', 'dina-kala' ),
						'price-desc'  => __( 'قیمت از نزولی', 'dina-kala' ),
						'price-asc'  => __( 'قیمت از صعودی', 'dina-kala' ),
						'coming_soon' => __( 'محصولات به زودی', 'dina-kala' ),
						'discounted' => __( 'محصولات تخفیف خورده', 'dina-kala' ),
						'rand_discounted' => __( 'محصولات تخفیف خورده تصادفی', 'dina-kala' ),
						'special' => __( 'محصولات شگفت انگیز', 'dina-kala' ),
						'rand_special' => __( 'محصولات شگفت انگیز تصادفی', 'dina-kala' ),
						'menu_order' => __( 'برطبق عنوان', 'dina-kala' ),
					],
				]
			);

			$this->add_control(
				'out_prod',
				[
					'label' => __( 'برچسب های خالی (بدون محصول) نمایش داده نمی شوند', 'dina-kala' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'روشن', 'dina-kala' ),
					'label_off' => __( 'خاموش', 'dina-kala' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$this->add_control(
				'prod_filter',
				[
					'label' => __( 'فیلتر محصول', 'dina-kala' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'category',
					'options' => [
						'category'  => __( 'دسته محصوالت', 'dina-kala' ),
						'tag' => __( 'برچسب محصولات', 'dina-kala' ),
						'brand' => __( 'برند محصولات', 'dina-kala' ),
						'pro_id' => __( 'انتخاب دستی محصولات', 'dina-kala' ),
					],
				]
			);


			$this->add_control(
				'product_cat',
				[
					'label' => __( 'دسته بندی محصولات', 'dina-kala' ),
					'description' => __( 'برچسب های خالی (بدون محصول) نمایش داده نمی شوند', 'dina-kala' ),
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
					'label' => __( 'فیلتر بر اساس تگ', 'dina-kala' ),
					'description' => __( 'برچسب های خالی (بدون محصول) نمایش داده نمی شوند', 'dina-kala' ),
					'label_block' => true,
					'type' => \Elementor\Controls_Manager::TEXT,
					'placeholder' => __( 'Tag(s) ID', 'dina-kala' ),
					'condition' => [
						'prod_filter' => 'tag',
					],
				]
			);
			$this->add_control(
				'product_brand',
				[
					'label' => __( 'فیلتر بر اساس برند', 'dina-kala' ),
					'description' => __( 'فیلتر و نمایش محصول بر اساس برند', 'dina-kala' ),
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
					'label' => __( 'شناسه محصولات', 'dina-kala' ),
					'description' => __( 'ایدی محصولات رو با , جدا کنید مثلا: 10,20,310', 'dina-kala' ),
					'label_block' => true,
					'type' => \Elementor\Controls_Manager::TEXT,
					'placeholder' => __( 'آیدی محصول', 'dina-kala' ),
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
				 'showـbtnـcart',
				 [
						'label' => __( 'نمایش دکمه افزودن به سبد خرید', 'PRK' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'default' => 'no',

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
				'btnـcart_style',
				[
					'label' => esc_html__( 'استایل دکمه', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'icon',
							'options' => [
								'icon'  => esc_html__( 'ایکن', 'plugin-name' ),
								'text' => esc_html__( 'متن', 'plugin-name' ),
					],
				 ]
		 );

		 $this->add_control(
						'showـtimer',
						[
							 'label' => __( 'نمایش تایمر معکوس', 'PRK' ),
							 'type' => \Elementor\Controls_Manager::SWITCHER,
							 'default' => 'no',

						]
		 );

		 $this->add_control(
					 'text_btn',
					 [
					 'type' => \Elementor\Controls_Manager::TEXT,
							'label' => __( 'عنوان تخفیف', 'PRK' ),
							'default' => 'کالاهای سوپرمارکتی',

					 ]
		 );

		 $this->add_control(
					'text_icon',
					[
						 'label' => __( 'ایکن عنوان', 'PRK' ),
						 'type' => \Elementor\Controls_Manager::TEXT,
						 'default' => 'far fa-chair-office',

					]
		 );

		 $this->add_control(
					'text2_onsale',
					[
						 'label' => __( 'متن دوم تخفیف', 'PRK' ),
						 'type' => \Elementor\Controls_Manager::TEXT,
						 'default' => 'تـــخــفـــیــف تــا',

					]
		 );

		 $this->add_control(
					'text_onsale',
					[
						 'label' => __( 'درصد تخفیف', 'PRK' ),
						 'type' => \Elementor\Controls_Manager::TEXT,
						 'default' => '۵۰٪',

					]
		 );

		 $this->add_control(
				 'text_btn_view',
				 [
						'label' => __( 'متن دکمه', 'PRK' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => 'مشاهده همه پیشنهاد ها',

				 ]
		 );
		 $this->add_control(
		     'url_btn',
		     [
		         'label' => __( 'لینک دکمه', 'PRK' ),
		         'type' => \Elementor\Controls_Manager::URL,
		         'multiple' => true,
		 				'default' => [
		 		        'url' => '#',
		 		        'is_external' => true,
		 		        'nofollow' => true,
		         ],
		     ]
		 );
		 $this->add_control(
	 	    'category_url_viewall',
	 	    [
	 	        'label' => __( 'لینک مشاهده همه', 'plugin-domain' ),
	 	        'type' => \Elementor\Controls_Manager::URL,
	 	        'multiple' => true,

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
     // پایان سکشن کنترل های اصلی


		 // شروع سکشن کنترل های کاروسل
		$this->start_controls_section(
		 'slider_special',
		 [
			 'label' => 'پیکربندی اسلایدر',
			 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
		 ]
		);

		$this->add_control(
				'loop',
				[
					'label' => 'حلقه نامحدود',
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'بله', 'your-plugin' ),
					'label_off' => __( 'خیر', 'your-plugin' ),
					'return_value' => 'true',
					'default' => 'false',
				]
			);

			$this->add_control(
					'nav',
					[
						'label' => 'پیکان ها',
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => __( 'بله', 'your-plugin' ),
						'label_off' => __( 'خیر', 'your-plugin' ),
						'return_value' => 'true',
						'default' => 'false',
					]
				);
				$this->add_control(
						'autoplay',
						[
							'label' => 'نمایش خودکار',
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'label_on' => __( 'بله', 'your-plugin' ),
							'label_off' => __( 'خیر', 'your-plugin' ),
							'return_value' => 'true',
							'default' => 'false',
						]
					);
				$this->add_control(
						'delay',
						[
							'label' => esc_html__( 'سرعت پخش', 'plugin-name' ),
							'type' => \Elementor\Controls_Manager::NUMBER,
							'min' => 100,
							'step' => 5,
							'default' => 3000,
						]
		    );
				$this->add_control(
					'item',
							[
								'label' => esc_html__( 'تعداد ایتم ها', 'plugin-name' ),
								'type' => \Elementor\Controls_Manager::NUMBER,
								'min' => 3,
								'max' => 8,
								'step' => 1,
								'default' => 4,
							]
		    );
				$this->add_control(
					 'show_view_item',
					 [
							'label' => __( 'نمایش آیتم مشاهده همه', 'PRK' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'default' => 'yes',

					 ]
				);


		    $this->end_controls_section();
				// پایان سکشن کنترل های کاروسل


				// شروع تب استایل
				$this->start_controls_section(
					'section_style',
					[
						'label' => esc_html__( 'استایل سکشن', 'plugin-name' ),
						'tab' => \Elementor\Controls_Manager::TAB_STYLE,
					]
				);

				$this->add_control(
							 's-off',
							 [
								 'label' => __( 'تصویر پیشنهاد', 'PRK' ),
								 'type' => \Elementor\Controls_Manager::MEDIA,
								 'selectors' => [
									 '{{WRAPPER}} .col-off' => 'background-image: url({{URL}})',
								 ],
							 ]
				 );
				 $this->add_control(
					 'color_back1',
					 [
						 'label' => __( 'رنگ اصلی پس زمینه', 'plugin-domain' ),
						 'type' => \Elementor\Controls_Manager::COLOR,
						 'default' => '#ef5662',
						 'selectors' => [
							 '{{WRAPPER}} .col-off' => 'background-color: {{VALUE}}',
						 ],
					 ]
				 );
				$this->add_control(
							'border',
							[
								'label' => esc_html__( 'انحنا دور سکشن', 'plugin-name' ),
								'type' => \Elementor\Controls_Manager::NUMBER,
								'min' => 1,
								'step' => 1,
								'default' => 8,
								'selectors' => [
									'{{WRAPPER}} .col-off' => 'border-radius: {{VALUE}}px',
								],
							]
				);

				$this->end_controls_section();
				 // پایان تب استایل
	}

	protected function render() {


		$themeـdisplay = prk_option('theme-style');
		$slider_id = slider_RandomString();
		$template = get_bloginfo('template_url');

		// متغییر های فیلدها
		$settings       =  $this->get_settings_for_display();
		$btnـcart_style =  $settings['btnـcart_style'];
		$showـtimer     =  $settings['showـtimer'];
		$cart           =  $settings['showـbtnـcart'];


    $text_icon      =  $settings['text_icon'];
    $text_btn      =  $settings['text_btn'];
    $text_btn_view      =  $settings['text_btn_view'];
		$text_onsale      =  $settings['text_onsale'];
		$text2_onsale      =  $settings['text2_onsale'];

		$category_urlviewall =  $settings['category_url_viewall']['url'];
		$url_btn =  $settings['url_btn']['url'];
		$Paddings = 0;
		$margins   = 7;
		$margins_mob = 3;
    // متغییرهای داینامیک کاروسل
		$settings_slider =  array(
		 'loop' => $settings['loop'],
		 'nav' => $settings['nav'],
			'autoplay' => $settings['autoplay'],
		 'delay' => $settings['delay'],
		 'item' => $settings['item'],
		 'Paddings' => $Paddings,
		 'margins' => $margins,
		 'margins_mob' => $margins_mob,
	 );
	 $json_settings = json_encode($settings_slider);


		?>

    <section class="col-off ver2">

      <div class="continer">

        <div class="carousel-panel">

					<!-- عنصر سمت راست-->
		      <div class="right-panel">
		        <span class="title-panel">
						   <i class="<?php echo $text_icon;?>"></i>
						<?php echo $text_btn;?>
					  </span>
					  <div class="on-sale-panel">
					     <span class="onsale-offer"><?php echo $text2_onsale;?></span>
					     <span class="onsale-off"><?php echo $text_onsale;?></span>
					  </div>
					  <a class="btn-panel" href="<?php echo $url_btn;?>"><?php echo $text_btn_view;?></a>
		      </div>

        <!-- عنصر سمت چپ -->
        <div class="left-panel">

        <div class="article-off" settings-slider='<?php echo $json_settings; ?>'>

					<?php


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
																		 if (is_array($arms["tax_query"])) {
																			 $arms["tax_query"][] = ["taxonomy" => "city_categories", "field" => "id", "terms" => $city_categories];
																		 } else {
																			 $arms["tax_query"] = ["relation" => "AND", ["taxonomy" => "city_categories", "field" => "id", "terms" => $city_categories]];
																		 }
																	 }
															 }

	          $pd_query = new WP_Query( $arms );

               // اگر محصولی بود !
							 if ( $pd_query ->have_posts() ) :

								// بیا و حلقه کن
	              while ( $pd_query ->have_posts() ) : $pd_query ->the_post();

		              global $woocommerce , $product;
		              $img_up_pro = get_post_meta(get_the_ID(),'img_up_pro',true);
									$currency = get_woocommerce_currency_symbol();
									$price = get_post_meta( get_the_ID(), '_regular_price', true);
									$sale = get_post_meta( get_the_ID(), '_sale_price', true);
									$date_to = get_post_meta( get_the_ID(), '_sale_price_dates_to', true);
									$progress_sales = get_post_meta(get_the_ID(), 'progress_sales', true );
									$product_label = get_post_meta(get_the_ID(), 'prk_product_label', true );
									$timer_id = generateRandomString();
									$thumber = get_the_post_thumbnail();
									$imager  = wc_placeholder_img_src();?>

									<article class="off-product" >

										<?php if ($product_label): ?>
											<div class="custom_label"><span><?php echo $product_label;?></span></div>
										<?php endif; ?>

											<a href="<?php the_permalink();?>">

                        <!--thumbnail-->
							   				<?php echo pr_img(); ?>

												<?php
													if (!empty($settings['show_swatches_archive']) && prk_option('show_swatches_archive')) {
														echo do_shortcode("[prk_swatches_list]");
													}
												?>

                        <!--title-->
											  <div class="index-title-pro">
												  <h2><?php echo wp_trim_words(get_the_title(),12,'...') ;?></h2>
											  </div>

		                  </a>

						  <?php
 											 echo '<div class="index-prices-pro">';

 												 if ( $product->is_in_stock() ) {

 													 echo '<div class="price_onsale_ar">';

													  if ( $product->is_in_stock() && $price || $product->is_type( 'variable' ) ) {
														echo $product->get_price_html();
															}elseif( $product->is_in_stock()  ){
																echo '<p class="call_pro">'.prk_option('single_product_text_price').'</p>';
														}


 													 echo '</div>';

 												 }else{
													  echo '<div class="price_onsale_ar">';
													 		if($settings['prk_show_unavailable_text']){
															echo '<p class="call_pro">'.$settings['prk_unavailable_text'].'</p>';
													     }
													  echo '</div>';
												 }
 												echo '</div>';
 											 ?>


										<!-- نمایش دکمه افزودن به سبد خرید-->
										<?php if($cart == 'yes'):?>

											<?php if( 'icon' == $btnـcart_style):?>
												<div class="add-to-cart offer <?Php if ('icon' == $btnـcart_style){ echo 'icon'; }?>">
													<div class="add-to-carter">
													 <?php echo do_shortcode("[ajax_cart]"); ?>
													</div>
												</div>
										  <?php else:?>
												<div class="product-cart">
												 <?php echo do_shortcode("[ajax_cart_ver2]");?>
												</div>
										 <?php endif;?>

									 <?php endif;?>

				            <!-- نمایش تایمر معکوس-->
										<?php if ($showـtimer == 'yes' && $date_to):?>

											<div class="prk-tim">
											<div <?php if(empty('digikala' == $themeـdisplay)){echo 'id="prk-timers"';}else{echo 'id="timers"';};?> class="timers-<?php echo $timer_id;?>"></div>
											<i class="fi fi-rr-time-past"></i>
											</div>

											<script type="text/javascript">
													 var dateEnd = new Date((<?php echo $date_to; ?>) * 1000);
													 new TimezZ('.timers-<?php echo $timer_id;?>', {
													 date: dateEnd,
													 template: '<span><span  class="number">NUMBER</span><span class="dot">:</span><span class="letter">LETTER</span></span>',
													 text: {
													 days: 'روز',
													 hours: 'ساعت',
													 minutes: 'دقیقه',
													 seconds: 'ثانیه',
														 }
													 });
											</script>

										  <?php else: ?>

											<div class="timers expired block"></div>

										  <?php endif; ?>

									</article>
              <?php endwhile; ?>
              <?php wp_reset_postdata(); ?>
						<?php endif; ?>

						<!-- المان مشاهده بیشتر -->
	 				 <?php if ($pd_query ->have_posts() && $settings['show_view_item'] == 'yes' && $settings['autoplay'] == '' ): ?>
	 				   <div class="off-product mories">
	 					   <a href="<?php echo $category_urlviewall; ?>">
	 					     <div class="w-categorys-link">
	 					       <i class="ri-arrow-left-line"></i>
	 								 <span>مشاهده همه</span>
	 					     </div>
	 						</a>
	 				   </div>
	          <?php endif; ?>

			      </div>
          </div>


        </div>


			</div>
    </section>
		<?php

	}

	protected function _content_template() {}

}
