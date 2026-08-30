<?php
class officals_carosel_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'officals_carosel';
	}

	public function get_title() {
		return 'کاروسل شگفت انگیز ها ورژن 1';
	}

	public function get_icon() {
		return 'eicon-product-info';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {

   // شروع کنترل های اصلی
	 $this->start_controls_section(
			'text',
			[
				'label' => 'پیشنهاد شگفت انگیز',
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
				 'showـbtnـcart',
				 [
						'label' => __( 'نمایش دکمه افزودن به سبد خرید', 'PRK' ),
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
				 'showـtimer',
				 [
						'label' => __( 'نمایش تایمر معکوس', 'PRK' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'default' => 'no',

				 ]
		);
    $this->add_control(
       's-off-link',
       [
           'label' => __( 'لینک پیشنهاد شگفت انگیز', 'PRK' ),
           'type' => \Elementor\Controls_Manager::URL,
           'multiple' => true,
   				'default' => [
   		        'url' => '#',
   		        'is_external' => true,
   		        'nofollow' => true,
           ],
       ]
    );

		$this->end_controls_section();
    // پایان سکشن کنترل های اصلی

		// شروع سکشن کنترل اسلایدر
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
    // پایان سکشن کنترل اسلایدر


   // شروع تب استایل
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'استایل سکشن', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'carusel_style',
			[
				'label' => __( 'سبک نمایشی کاروسل باکس', 'parskala' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => __( 'پیشفرض', 'parskala' ),
					'style1' => __( 'سبک 1', 'parskala' ),
					'style2' => __( 'سبک 2', 'parskala' ),
				],
			]
		);
		$this->add_control(
			'title_section',
			[
				'label' => __( 'عنوان سکشن', 'parskala' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'carusel_style' => 'style1',
				],
			]
		);
		$this->add_control(
			'bg_back1',
			[
				'label' => esc_html__( 'تصویر پترن پس زمینه', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'selectors' => [
					'{{WRAPPER}} .officol' => 'background-image: url({{URL}})',
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
    		 's-off',
    		 [
    			 'label' => __( 'تصویر پیشنهاد', 'PRK' ),
    			 'type' => \Elementor\Controls_Manager::MEDIA,
					 'default' => [
							 'url' =>  parskala_URI .'/assets/img/offical.png',
						 ],
    		 ]
    	 );

       $themeـdisplay = prk_option('theme-style');
			 if($themeـdisplay == 'digikala'){
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
							'{{WRAPPER}} .col-off' => 'border-radius: {{VALUE}}px',
						],
	 				]
	 	);

		$this->end_controls_section();
    // پایان تب استایل

	$this->start_controls_section(
		'item_special',
		[
			'label' => 'استایل آیتم محصول',
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		]
	);
	$this->add_control(
		'list_title_color',
		[
			'label' => 'رنگ عنوان',
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} div.index-title-pro h2' => 'color: {{VALUE}} !important',
			],
		]
	);
	$this->add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'label' => esc_html__( 'تایپوگرافی عنوان', 'plugin-name' ),
			'name' => 'content_typography',
			'selector' => '{{WRAPPER}}  .index-title-pro h2',
		]
	);
	$this->add_control(
		'text_align',
		[
			'label' => esc_html__( 'تراز عنوان', 'textdomain' ),
			'type' => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'left' => [
					'title' => esc_html__( 'چپ', 'textdomain' ),
					'icon' => 'eicon-text-align-left',
				],
				'center' => [
					'title' => esc_html__( 'وسط', 'textdomain' ),
					'icon' => 'eicon-text-align-center',
				],
				'right' => [
					'title' => esc_html__( 'راست', 'textdomain' ),
					'icon' => 'eicon-text-align-right',
				],
			],
			'default' => 'right',
			'toggle' => true,
			'selectors' => [
				'{{WRAPPER}} .off-product .index-title-pro h2' => 'text-align: {{VALUE}};',
			],
		]
	);
	$this->add_group_control(
		\Elementor\Group_Control_Border::get_type(),
		[
			'name' => 'border',
			'label' => esc_html__( 'حاشیه دور آیتم', 'textdomain' ),
			'selector' => '{{WRAPPER}} .off-product',
		]
	);
	$this->add_control(
		'padding_item',
		[
			'label' => esc_html__( 'فاصله داخلی آیتم (padding)', 'textdomain' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
			'selectors' => [
				'{{WRAPPER}} .off-product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
			],
		]
	);
	$this->add_control(
		'border_radius',
		[
			'label' => esc_html__( 'انحنای آیتم', 'textdomain' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 1000,
					'step' => 1,
				],
				'%' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'default' => [
				'unit' => 'px',
				'size' => 11,
			],
			'selectors' => [
				'{{WRAPPER}} .off-product' => 'border-radius: {{SIZE}}{{UNIT}} !important;',
			],
		]
	);
	$this->add_control(
		'nmargin_item',
		[
			'label' => esc_html__( 'فاصله بین آیتم ها', 'plugin-name' ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'min' => 1,
			'step' => 1,
			'default' => 15,

		]
);
	$this->add_control(
		'custom_box_shadows',
		[
			'label' => esc_html__( 'سایه دهی آیتم', 'textdomain' ),
			'type' => \Elementor\Controls_Manager::BOX_SHADOW,
			'selectors' => [
				'{{WRAPPER}} .off-product'  => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}} ;',
			],
		]
	);


	$this->end_controls_section();
	
	// پایان تب استایل

	}

	protected function render() {

    $themeـdisplay = prk_option('theme-style');
		$template = get_bloginfo('template_url');
		$slider_class = slider_RandomString();
		// ساخت متغییر های فیلد
    $settings = $this->get_settings_for_display();


		$showcart = $settings['showـbtnـcart'];
		$showـtimer = $settings['showـtimer'];
	
		$margins   = $settings['nmargin_item'] ? $settings['nmargin_item'] : '15' ;
		$category_urlviewall =  $settings['s-off-link']['url'];
		$nav = $settings['nav'] ? $settings['nav'] : 'false';
		$loop = $settings['loop'] ? $settings['loop'] : 'false';
		$Paddings = 0;
		
		$margins_mob = 3;

    // داینامیک کردن اتریبیوتیک
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



		 if ( mobile_cheker() || tablet_cheker() ) {
			 $class_dev = 'verticaler';
			 $class_section = 'carousel_lister';
			 $class_offer = 'carousel_lister';
	     $json_settings = '';
	   }else {
			 $class_dev = '';
	     $class_section = '';
			 $class_offer = 'article-off';
			 $json_settings = json_encode($settings_slider);

	   }
 ?>

<!-- سکشن پیشنهادات شگفت انگیز-->
<section class="<?php echo $class_dev;?> col-off v1 <?= $settings['carusel_style'] ?>">
    <?php if ($settings['carusel_style'] == 'style1' ):?>

	<div class="box__shaped-title">
		<svg xmlns="http://www.w3.org/2000/svg" width="231" height="75" viewBox="0 0 231 75" fill="none">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M0 0C31.5006 0.949537 50.52 17.872 56.1955 26.4544L55.986 25.8011L82.4924 58.631C99.3032 79.4521 131.038 79.4521 147.849 58.6309L174.356 25.8011L174.146 26.4544C179.822 17.872 198.844 0.949537 230.349 0H0Z" fill="#fff"></path>
		</svg>

		<?php if ( !empty($settings['title_section']) ){
           echo '<h2 class="title__text">'.$settings['title_section'].'</h2>';
		}?>

	</div>

    <?php endif;?>
  <div class="<?php echo $class_section;?> officol orginal">

		<!-- المان سمت راست-->
	 <div class="right-off">
	    <div class="img-off">
	      <img src="<?php echo $settings['s-off']['url'];?>">
	    </div>

	<?php if ( !empty( $settings['s-off-link']['url'] ) ):?>
      <a class="btn btn-sm btn-outline-light" href="<?php echo $settings['s-off-link']['url'];?>">
				<?php _e('viwe all' , 'parskala');?>
			  <i class="ri-arrow-left-fill ms-2"></i>
	  </a>
	<?php endif;?>
    </div>
      <!-- عنصر سمت چپ شروع کاروسل -->
      <div class="left-off">

				<!-- حلقه محصولات -->
        <div class="<?php echo $class_offer;?>" settings-slider='<?php echo $json_settings; ?>'>

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
																	 if (isset($arms["tax_query"]) && is_array($arms["tax_query"])) {

																		 $arms["tax_query"][] = ["taxonomy" => "city_categories", "field" => "id", "terms" => $city_categories];
																	 } else {
																		 $arms["tax_query"] = ["relation" => "AND", ["taxonomy" => "city_categories", "field" => "id", "terms" => $city_categories]];
																	 }
																 }
														 }
				$pd_query = new WP_Query( $arms );

					 // اگر پست داشت
					 if ( $pd_query ->have_posts() ) :

           // حلقه بساز
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
							 $imager  = wc_placeholder_img_src();

							 ?>

								  <!-- شروع حلقه محصول -->
									<article class="off-product item-hover">

										<?php if ($product_label): ?>
			 							 <div class="custom_label"><span><?php echo $product_label;?></span></div>
			 						 <?php endif; ?>

										<a href="<?php the_permalink();?>">

											<?php echo pr_img(); ?>
											<div class="shadow-product h-[0px] w-[180px] duration-500 group-hover:mt-[28px] group-hover:h-[20px] group-hover:rotate-1"></div>

											<?php
												if ($settings['prk_swatches_list'] && prk_option('show_swatches_archive') ) {
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

										 <!--add cart-->
										 <?php if ($showcart == 'yes'): ?>

											 <div class="lists_add_to_cart">
												 <?php echo do_shortcode("[ajax_cart_item]");?>
											 </div>

										 <?php endif; ?>


										 <?php if ($showـtimer == 'yes'):?>

												 <?php if ($date_to): ?>

														 <div class="prk-tim">
													     <div <?php if(empty('digikala' == $themeـdisplay)){echo 'id="prk-timers"';}else{echo 'id="timers"';};?> class="timers-<?php echo $timer_id;?>"></div>
				                       <i class="fi fi-rr-time-past"></i>
														 </div>

														 <script type="text/javascript">
															  var dateEnd = new Date((<?php echo $date_to; ?>) * 1000);
															  new TimezZ('.timers-<?php echo $timer_id;?>', {
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
	 												<div class="timers expired block"></div>
                          <?php endif; ?>

										 <?php endif; ?>

									</article>


              <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php endif;?>


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
		<!-- در صورت نبودن محصول در لیست -->
		<?php if ( ! $pd_query ->have_posts() ): ?>
			<div class="no-products">
				 <i class="ri-timer-line"></i>
				 <span>محصولی در لیست شگفت انگیز ها موجود نیست !</span>
			</div>
		<?php endif; ?>

  </div>
</section>

		<?php
	}

	protected function _content_template() {}

}
