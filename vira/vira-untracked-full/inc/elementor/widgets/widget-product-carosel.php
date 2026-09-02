<?php
class product_carosel_Widget extends \Elementor\Widget_Base {


	public function get_name() {
		return 'product-carosel';
	}

	public function get_title() {
		return 'کاروسل محصولات';
	}

	public function get_icon() {
		return 'eicon-product-images';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'text',
			[
				'label' => 'کاروسل محصولات',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,

			]
		);

		$this->add_control(
			'title_section',
			[
				'label' => 'عنوان',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'عنوان',
				'default' => 'عنوان',
			]
		);
		$this->add_control(
				 'title_border',
				 [
						'label' => __( 'نمایش زیر عنوان', 'parskala' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'default' => 'yes',

				 ]
			);
		$this->add_control(
			'title_icon',
			[
				'label' => ' ایکن <a href="https://materialdesignicons.com" target="_blank">دریافت ایکن از این سایت</a>',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'ایکن',
			]
		);
$options = array();



$categories =  $categories = get_categories(array('taxonomy'=> 'product_cat'));
foreach ( $categories as $key => $category ) {
    $options[$category->term_id] = $category->name;

}

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

					$this->add_control( //Header
						'header_enabled',
						[
							'label' => esc_html__('فعال سازی دسته بندی مجزا', 'wooslider-bymdez'),
							'description' => esc_html__('فعال سازی امکان ساخت دسته بندی مجزا برای سکشن محصولات', 'wooslider-bymdez'),
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'label_on' => esc_html__( 'فعال سا زی', 'wooslider-bymdez' ),
							'label_off' => esc_html__( 'غیرفعال سازی', 'wooslider-bymdez' ),
							'return_value' => 'yes',
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
					'loadmore_ajax',
					[
						'label' => __( 'بارگذاری ایجکسی', 'parskala' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => __( 'روشن', 'parskala' ),
						'label_off' => __( 'خاموش', 'parskala' ),
						'return_value' => 'yes',
					]
				);


					$this->add_control(
						'prod_show_dd_cart',
						[
							'label' => __( 'نمایش دکمه سبد خرید', 'PRK' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'return_value' => 'true',
							'default' => 'true',
						]
				);
$this->add_control(
	'type_add_to_cart',
	[
		'label' => __( 'نوع دکمه سبدخرید', 'parskala' ),
		'type' => \Elementor\Controls_Manager::SELECT,
		'default' => 'icon',
		'options' => [
			'icon' => 'ایکن',
			'text' => 'متنی',
		],
		'condition' => [
			'prod_show_dd_cart' => 'true',
		],
	]
);
				$this->add_control(
					'type_add_to_cart_text',
					[
						'label' => __( 'متن دکمه افزودن به سبد خرید', 'parskala' ),
						'label_block' => true,
						'default' => 'افزودن به سبد',
						'type' => \Elementor\Controls_Manager::TEXT,
						'condition' => [
							'type_add_to_cart' => 'text',
						],
					]
				);

				$this->add_control(
					'type_add_to_cart_icon',
					[
						'label' => __( 'ایکن سبدخرید', 'parskala' ),
						'label_block' => true,
						'default' => 'prk-shopping-cart',
						'type' => \Elementor\Controls_Manager::TEXT,
						'condition' => [
							'type_add_to_cart' => 'icon',
						],
					]
				);

				$this->add_control(
					'back_cart_icon',
					[
						'label' => 'رنگ پس زمینه دکمه سبدخرید',
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .prob-item .quick_add2cart' => 'background: {{VALUE}} !important',
						],
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
			'carusel_style',
			[
				'label' => __( 'سبک نمایشی کاروسل باکس', 'parskala' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => __( 'پیشفرض', 'parskala' ),
					'style1' => __( 'سبک 1', 'parskala' ),
					'style2' => __( 'سبک 2', 'parskala' ),
					'style3' => __( 'سبک 3', 'parskala' ),
					'style4' => __( 'سبک 4', 'parskala' ),
				],
			]
		);
		$this->add_control(
			'due_date_done',
			[
				'label' => esc_html__( 'تاریخ پایان شگفت انگیز', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,

			]
		);
		$this->add_control(
			'due_date_done_text',
			[
				'label' => __( 'متن لیبل زمان باقی مانده', 'parskala' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'زمان باقی مانده', 'parskala' ),
			]
		);
		$this->add_control(
			'prk_show_back_image',
			[
				'label' => 'نمایش حاله پس زمینه تصویر ایتم محصول',
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'بله', 'your-plugin' ),
				'label_off' => __( 'خیر', 'your-plugin' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'prk_show_title',
			[
				'label' => 'نمایش عنوان سکشن',
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'بله', 'your-plugin' ),
				'label_off' => __( 'خیر', 'your-plugin' ),
				'return_value' => 'true',
				'default' => 'true',
				
			]
		);
		
		$this->add_control(
			'color_title',
			[
				'label' => __( 'رنگ عنوان سکشن', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .head-product h3 span' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .titles-pro::after' => 'background: {{VALUE}} !important',
				],
				'condition' => [
					'prk_show_title' => 'true',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'تایپوگرافی عنوان', 'plugin-name' ),
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}}  .head-product h3',
				'condition' => [
					'prk_show_title' => 'true',
				],
			]
		);
		$this->add_control(
			'prk_show_back_color',
			[
				'label' => 'افزودن پس زمینه به سکشن',
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'بله', 'your-plugin' ),
				'label_off' => __( 'خیر', 'your-plugin' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'   => 'uael_feeds_on_hover',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .right-product',
			
			]
		);
		

		$this->add_control(
			'border_sec',
			[
				'label' => esc_html__( 'انحنا دور سکشن', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'step' => 1,
			   'default' => 8,
			   'selectors' => [
				   '{{WRAPPER}} .right-product' => 'border-radius: {{VALUE}}px',
			   ],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .right-product',
			]
		);
		$this->add_control(
				'border_item',
				[
					'label' => esc_html__( 'انحنا دور ایتم ها', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 1,
					'step' => 1,
					'default' => 11,
					'selectors' => [
						'{{WRAPPER}} .item-pro' => 'border-radius: {{VALUE}}px',
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
			'prk_show_salses',
			[
				'label' => 'نمایش درصد فروش رفته',
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'بله', 'your-plugin' ),
				'label_off' => __( 'خیر', 'your-plugin' ),
				'return_value' => 'true',
			]
		);
		$this->add_control(
			'custom_box_shadows',
			[
				'label' => esc_html__( 'سایه دهی باکس', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::BOX_SHADOW,
				'default' => [
					'horizontal' => 0,
					'vertical' => 0,
					'blur' => 0,
					'spread' => 0,
					'color' => 'rgba(0, 0, 0, 0)',
				],
				'selectors' => [
					'{{WRAPPER}} .right-product'  => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}} ;',
				],
			]
		);


	
		$this->end_controls_section();

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
				'selector' => '{{WRAPPER}}  div.index-title-pro h2',
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
					'{{WRAPPER}} div.index-title-pro h2' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border_item',
				'label' => esc_html__( 'حاشیه دور آیتم', 'textdomain' ),
				'selector' => '{{WRAPPER}} .col-product .item-pro',
			]
		);
		$this->add_control(
			'padding_item',
			[
				'label' => esc_html__( 'فاصله داخلی آیتم (padding)', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .col-product .item-pro' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
					'{{WRAPPER}} .col-product .item-pro' => 'border-radius: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);
		$this->add_control(
			'custom_item_shadow',
			[
				'label' => esc_html__( 'سایه دهی آیتم', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::BOX_SHADOW,
				'selectors' => [
					'{{WRAPPER}} .col-product .item-pro'  => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}} ;',
				],
				'default' =>
				[
					'horizontal' => 0,
					'vertical' => 0,
					'blur' => 0,
					'spread' => 0,
					'color' => 'rgba(0, 0, 0, 0)'
				]
			]
		);


		$this->end_controls_section();
		
		// پایان تب استایل

		  /*HEADER*/
		  $this->start_controls_section(
			'header',
			[
				'label' => esc_html__( 'سکشن تب دسته بندی مجزا', 'wooslider-bymdez' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' 	=> ['header_enabled' => 'yes'],
			]
		);

		$this->add_control( //Just Refresh the frame
            'refresh_frame4',
            [
                'label' => esc_html__('آپدیت فریم', 'wooslider-bymdez'),
                'description' => esc_html__('هیچ تأثیری روی عملکرد وجود ندارد، فقط نمای زنده را تازه کنید', 'wooslider-bymdez'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'refresh', 'wooslider-bymdez' ),
				'label_off' => esc_html__( 'refresh', 'wooslider-bymdez' ),
				'return_value' => 'yes',
				'default' => 'no',
            ]
        );

        $this->add_control(//def alignment of header elements
			'header_elems_align',
			[
				'label' => esc_html__( 'تزار کردن دکمه های دسته بندی', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'center'              => esc_html__('وسط', 'wooslider-bymdez'),
                    'right'              => esc_html__('راست', 'wooslider-bymdez'),
					'left'          =>	esc_html__('چپ', 'wooslider-bymdez'),
				],
                'default' => 'right',
			]
		);

        $this->add_control( //back to first slide after ajax
            'header_backtofirst_ajax',
            [
                'label' => esc_html__('بازگشت به اسلاید اول بعد از آژاکس', 'wooslider-bymdez'),
                'description' => esc_html__('پس از تغییر دسته، به اسلاید اول می پرد', 'wooslider-bymdez'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'روشن', 'wooslider-bymdez' ),
				'label_off' => esc_html__( 'خاموش', 'wooslider-bymdez' ),
				'return_value' => 'yes',
				'default' => 'yes',
            ]
        );
    
		$repeater = new \Elementor\Repeater();

        $repeater->add_control(//header make title
            'header_elems_maketitle',
            [
                'label' => esc_html__('سبک عنوان', 'wooslider-bymdez'),
                'description' => esc_html__('این بخش در آپدیت های بعدی توسعه خواهد شد !', 'wooslider-bymdez'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'نمایش', 'wooslider-bymdez' ),
				'label_off' => esc_html__( 'مخفی', 'wooslider-bymdez' ),
				'return_value' => 'yes',
				'default' => 'no',
            ]
        );

        $repeater->add_control(//header make title theme
			'header_elems_maketitle_theme',
			[
				'label' => esc_html__( 'سبک دکمه ها', 'wooslider-bymdez' ),
				'description' => esc_html__('این قسمت فعلا بصورت دیفالت تنظیم شده در آپدیت های بعدی سبک های جدید توسعه خواهد شد.', 'wooslider-bymdez'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'theme-1'              =>   esc_html__('Theme-1', 'wooslider-bymdez'),
                    'theme-2'              =>   esc_html__('Theme-2', 'wooslider-bymdez'),
					'theme-3'              =>	esc_html__('Theme-3', 'wooslider-bymdez'),
                    'theme-4'              =>	esc_html__('Theme-4', 'wooslider-bymdez'),
                    'theme-5'              =>	esc_html__('Theme-5', 'wooslider-bymdez'),
                    'theme-6'              =>	esc_html__('Theme-6', 'wooslider-bymdez'),
                    'none'                 =>	esc_html__('none', 'wooslider-bymdez'),
				],
                'condition' 	=> ['header_elems_maketitle' => 'yes'],
                'default' => 'theme-1',
			]
		);

		$repeater->add_control(//add or remove header elems
			'header_elems_title', [
				'label' => esc_html__( 'عنوان دکمه', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'دسته بندی اول' , 'wooslider-bymdez' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'header_ajax_cats',
			[
				'label'       => esc_html__( 'دسته بندی', 'wooslider-bymdez' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'description' => esc_html__( 'انتخاب دسته بندی اسلایدر', 'wooslider-bymdez' ),
				'label_block' => true,
				'multiple'    => false,
				'options'     => $this->get_terms_mdz( 'product_cat' ),
				'default'     => '',
			]
		);

        $repeater->add_control( //ajax max number
			'header_products_number',
			[
				'label' 		=> esc_html__( 'تعداد نمایش محصول در حلقه', 'wooslider-bymdez' ),
				'type'			=> \Elementor\Controls_Manager::NUMBER,
				'return_value' 	=> 'true',
				'default' 		=> 15,
			]
		);

        $repeater->add_control(//def source of ajax products
			'header_products_src',
			[
				'label' => esc_html__( 'بر اساس', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'label_block'	=>  'true',
				'options' => [
					'news'              => esc_html__('جدیدترین', 'wooslider-bymdez'),
                    'olds'              => esc_html__('قدیمی ترین', 'wooslider-bymdez'),
					'featured'          =>	esc_html__('برترین', 'wooslider-bymdez'),
					'sale'              =>	esc_html__('تخفیف خورده', 'wooslider-bymdez'),
					'bestsellings'		=>	esc_html__('بیشترین فروش', 'wooslider-bymdez'),
                    'lowsellings'		=>	esc_html__('کمترین فروش', 'wooslider-bymdez'),
                    'lastedited'		=>	esc_html__('آخرین تغییر', 'wooslider-bymdez'),
                    'rand'		        =>	esc_html__('تصادفی', 'wooslider-bymdez'),
				],
                'default' => 'news',
			]
		);

        $repeater->add_control(//Ajax stock ? in_stock
			'header_products_stock',
			[
				'label' => esc_html__( 'نمایش بر اساس نوع موجودی', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'label_block'	=>  'true',
				'options' => [
					'all'                        => esc_html__('همه', 'wooslider-bymdez'),
                    'only_instocks'              => esc_html__('فقط محصولات موجود', 'wooslider-bymdez'),
					'only_not_instocks'          =>	esc_html__('فقط موجود نیست', 'wooslider-bymdez'),
				],
                'default' => 'only_instocks',
			]
		);

        $repeater->add_control(//header icons show?
			'header_icons_type',
			[
				'label' => esc_html__( 'نمایش ایکن', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
                    'none'              => esc_html__('بدون ایکن', 'wooslider-bymdez'),
                    'elem_icons'        => esc_html__('انتخاب از المنتور', 'wooslider-bymdez'),
                    'custom_icons'      => esc_html__('بارگذاری ایکن', 'wooslider-bymdez'),
				],
                'default' => 'none'
			]
		);

        $repeater->add_control(//sefl elem icons selector
			'header_icons_select',
			[
				'label' => esc_html__( 'انتخاب ایکن', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::ICONS,
                'condition' 	=> ['header_icons_type' => 'elem_icons'],
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

        $repeater->add_control(//sefl elem icons color
			'header_icons_color',
			[
				'label' => esc_html__( 'رنگ ایکن', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'condition' 	=> ['header_icons_type' => 'elem_icons'],
				'default' => '#000',
			]
		);

        $repeater->add_control(//custom icon img selector
			'header_iconscustom_select',
			[
				'type' => \Elementor\Controls_Manager::MEDIA,
				'label' => esc_html__( 'بازگذاری ایکن سفارشی', 'wooslider-bymdez' ),
                'description'   =>  esc_html__( 'فرمت های ترجیحی: svg & webp', 'wooslider-bymdez' ),
                'condition'  => ['header_icons_type' => 'custom_icons'],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
			]
		);

        $repeater->add_control( //custom icon img width
			'header_iconscustom_width',
			[
				'label' 		=> esc_html__( 'عرض', 'wooslider-bymdez' ),
				'type'			=> \Elementor\Controls_Manager::NUMBER,
                'description'   =>  esc_html__( 'با px', 'wooslider-bymdez' ),
                'condition'  => ['header_icons_type' => 'custom_icons'],
				'return_value' 	=> 'true',
				'default' 		=> 45,
			]
		);

        $repeater->add_control(//text and icon alignment
			'header_texticon_alginment',
			[
				'label' => esc_html__( 'موقعیت نمایش ایکن', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'label_block'	=>  'true',
				'options' => [
                    'dir1'                 => esc_html__('default', 'wooslider-bymdez'),
                    'dir2'                 => esc_html__('نماد سمت چپ متن سمت راست', 'wooslider-bymdez'),
                    'dir3'                 => esc_html__('نماد بالا-متن پایین', 'wooslider-bymdez'),
                    'dir4'                 => esc_html__('نماد پایین متن به بالا', 'wooslider-bymdez'),
				],
                'default' => 'dir1',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'header_icons_type',
                            'operator' => '===',
                            'value' => 'elem_icons'
                        ],
                        [
                            'name' => 'header_icons_type',
                            'operator' => '===',
                            'value' => 'custom_icons'
                        ]
                    ]
                ]
			]
		);

        $repeater->add_control(//ajax btn text color
			'header_text_color',
			[
				'label' => esc_html__( 'رنک عنوان', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
			]
		);

        $repeater->add_control( //header allcats btn
            'header_allcats_show',
            [
                'label' => esc_html__('نمایش آیتم مشاهده همه', 'wooslider-bymdez'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'نمایش', 'wooslider-bymdez' ),
				'label_off' => esc_html__( 'مخفی', 'wooslider-bymdez' ),
				'return_value' => 'yes',
				'default' => 'no',
            ]
        );

        $repeater->add_control(//header see all cats title
			'header_allcats_title', [
				'label' => esc_html__( 'عنوان آیتم', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'condition' 	=> ['header_allcats_show' => 'yes'],
				'default' => esc_html__( 'مشاهده همه' , 'wooslider-bymdez' ),
				'label_block' => true,
			]
		);
        $repeater->add_control(//header see all cats title color
			'header_allcats_titlecolor',
			[
				'label' => esc_html__( 'رنگ عنوان آیتم', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'condition' 	=> ['header_allcats_show' => 'yes'],
                'default' => '#000',
			]
		);

        $repeater->add_control(//header see all cats background
			'header_allcats_backtype',
			[
				'label' => esc_html__( 'انتخاب بکگراند آیتم', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'condition' 	=> ['header_allcats_show' => 'yes'],
				'options' => [
                    'color'             => esc_html__('color', 'wooslider-bymdez'),
                    'wallpaper'        => esc_html__('picture', 'wooslider-bymdez'),
				],
                'default' => 'color'
			]
		);

        $repeater->add_control(//header see all cats background color
			'header_allcats_backcolor',
			[
				'label' => esc_html__( 'رنگ بکگراند', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'header_allcats_show',
                            'operator' => '===',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'header_allcats_backtype',
                            'operator' => '===',
                            'value' => 'color'
                        ]
                    ]
                ],
                'default' => '#fff',
			]
		);

        $repeater->add_control(//header see all cats background pic
			'header_allcats_backimg',
			[
				'type' => \Elementor\Controls_Manager::MEDIA,
				'label' => esc_html__( 'انتخاب تصویر', 'wooslider-bymdez' ),
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'header_allcats_show',
                            'operator' => '===',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'header_allcats_backtype',
                            'operator' => '===',
                            'value' => 'wallpaper'
                        ]
                    ]
                ],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
			]
		);

        $repeater->add_control(
			'header_allcats_url',
			[
				'label' => esc_html__( 'لینک مشاهده همه', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::URL,
                'condition' 	=> ['header_allcats_show' => 'yes'],
				'placeholder' => esc_html__( 'https://your-site.com/category/test', 'wooslider-bymdez' ),
			]
		);

        $repeater->add_control( //header bg changer on or?
            'header_bgchanger',
            [
                'label' => esc_html__('رنگ دکمه انتخاب شده', 'wooslider-bymdez'),
                'description' => esc_html__('انتخاب رنگ دسته انتخاب شده', 'wooslider-bymdez'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'فعال', 'wooslider-bymdez' ),
				'label_off' => esc_html__( 'غیرفعال', 'wooslider-bymdez' ),
				'return_value' => 'yes',
				'default' => 'yes',
            ]
        );

        $repeater->add_control(//header see all cats title color
			'header_bgchanger_color',
			[
				'label' => esc_html__( 'انتخاب رنگ', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'condition' 	=> ['header_bgchanger' => 'yes'],
                'default' => '#52ff68',
			]
		);
		$repeater->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .item-icon-title',
			]
		);

		$this->add_control(//the main repeater
			'header_elements',
			[
				'label' => esc_html__( 'دکمه های اسلایدر', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'header_elems_title' => "1 دسته بندی",
                        'header_icons_type' => 'elem_icons',
                        'header_icons_select' => [
                            'value' => 'fas fa-heart',
                            'library' => 'solid',
                        ],
					],
                    [
						'header_elems_title' => "دسته بندی 2",
                        'header_icons_type' => 'elem_icons',
                        'header_icons_select' => [
                            'value' => 'fas fa-star',
                            'library' => 'solid',
                        ],
                        'header_texticon_alginment' => 'dir3',
					],
                    [
						'header_elems_title' => "دسته بندی 3",
                        'header_icons_type' => 'elem_icons',
                        'header_icons_select' => [
                            'value' => 'fas fa-heart',
                            'library' => 'solid',
                        ],
                        'header_texticon_alginment' => 'dir2',
					],
				],
			]
		);

		$this->end_controls_section();

		


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
						   'default' => 'true',
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
					   'max' => 12,
					   'step' => 1,
					   'default' => 5,
				   ]
	   );
   
		   $this->add_control(
				'show_view_item',
				[
					   'label' => __( 'نمایش آیتم مشاهده همه', 'PRK' ),
					   'description' => esc_html__('با فعال سازی این بخش آیتم دکمه مشاهده همه در انتهای اسلایدر محصولات نمایش داده میشود.', 'wooslider-bymdez'),
					   'type' => \Elementor\Controls_Manager::SWITCHER,
					   'return_value' => 'yes',
					   'condition' 	=> [
						'header_enabled!' => 'yes',

					],

   
				]
		   );

		   $this->add_control(//header see all cats title
			'header_allcats_title', [
				'label' => esc_html__( 'عنوان آیتم', 'wooslider-bymdez' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'condition' 	=> ['show_view_item' => 'yes','header_enabled!' => 'yes',],
				'default' => esc_html__( 'مشاهده همه' , 'wooslider-bymdez' ),
			]
		);
		$this->add_control(
		'category_url_viewall',
		[
			'label' => __( 'لینک مشاهده همه', 'plugin-domain' ),
			'type' => \Elementor\Controls_Manager::URL,
			'multiple' => true,
			'condition' 	=> ['show_view_item' => 'yes','header_enabled!' => 'yes',],
		]
	);

	$this->add_control(
		'category_url_view_more',
		[
			'label' => __( 'نمایش دکمه نمایش همه', 'parskala' ),
			'description' => esc_html__('این دکمه در بالای سکشن روبه روی عنوان نمایش داده میشود.', 'wooslider-bymdez'),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => __( 'روشن', 'parskala' ),
			'label_off' => __( 'خاموش', 'parskala' ),
			'return_value' => 'true',
			'default' => 'false',
			'condition' 	=> [
				'show_view_item!' => 'yes',
				'header_enabled!' => 'yes',
			],
		]
	);
	$this->add_control(
		'category_url',
		[
			'label' => __( 'لینک دسته', 'plugin-domain' ),
			'type' => \Elementor\Controls_Manager::URL,
			'multiple' => true,
			'condition' 	=> [
				'show_view_item!' => 'yes',
				'category_url_view_more' => 'true',
				'header_enabled!' => 'yes',
		],
		]
	);
   
	   
   
		   $this->end_controls_section();

	}

	protected function render() {

	   $theme_display = prk_option('theme-style');
	 
		$settings = $this->get_settings_for_display();
		$slider_class = slider_RandomString();
		$title_icon = $settings['title_icon'];

		$title_border =  $settings['title_border'];
		$category_url = $settings['category_url']['url'] ?? '';
		$category_url_view_more = $settings['category_url_view_more'] ?? '';

		if ($settings['header_enabled']) {
			if (isset($settings['header_elements'][0]['header_allcats_url']['url'])) {
				$category_urlviewall = esc_attr($settings['header_elements'][0]['header_allcats_url']['url']);
			} else {
				$category_urlviewall = '#'; // مقدار پیش‌فرض
			}
		} else {
			$category_urlviewall = !empty($settings['category_url_viewall']['url']) ? $settings['category_url_viewall']['url'] : '#';
		}

		if($settings['header_enabled']){
			$category_allcatstitle = esc_attr($settings['header_elements'][0]['header_allcats_title']);
		}else{
			$category_allcatstitle =  $settings['header_allcats_title'];

		}

		$margins   = $settings['nmargin_item'] ? $settings['nmargin_item'] : '15' ;
		
		$settings_slider =  array(
			'loop' => $settings['loop'],
			'nav' => $settings['nav'],
			'autoplay' => $settings['autoplay'],
			'delay' => $settings['delay'],
			'item' => $settings['item'],
			'margins' => $margins,
		);
		if ($title_border ==! 'yes') {
			$title_class = 'hide';
		}else {
			$title_class = '';
		}
		$json_settings = json_encode($settings_slider);


    if ( mobile_cheker() || tablet_cheker() ) {
 		 $class_dev = 'verticaler';
 		 $class_section = 'carousel_lister';
 		 // $class_item = 'article-off';
      $json_settings = '';
    }else {
 		 $class_dev = '';
      $class_section = 'article-off';

	  if($settings['loadmore_ajax'] == 'yes' && $settings['show_view_item']!='yes'){
		$class_section = 'article-off loadmore_ajax';
	  }
 		 // $class_item = 'article-off';
 		 $json_settings = json_encode($settings_slider);

    }
	
	if ( $settings['prk_show_back_color'] == 'yes' ){
		$class_typer = 'have_back';
	}else{
		$class_typer = '';
	}

	if ($settings['prk_show_back_image']){
		$show_back_image = 'prk_show_back_image';
	}else{
		$show_back_image = '';
	}
	if ($settings['prk_show_salses'] == 'true' ){
		$show_salsess = 'show_salsess';
	}else{
		$show_salsess = '';
	}


	$due_date = strtotime( $this->get_settings( 'due_date_done' ) );
	$prod_sort = $settings['prod_sort'];
	$prod_filter = $settings['prod_filter'];
	$product_cat = $settings['product_cat'];
	$product_tag = $settings['product_tag'];
	$show_dd_cart =   $settings['prod_show_dd_cart'];
    $product_brand = $settings['product_brand'];
	$product_id = isset($settings['product_id']) ? explode(",", $settings['product_id']) : [];

	
	switch($prod_filter){
		case 'category':
			$group = $settings['product_cat'];
			break;
		case 'tag':
			$group = explode(",",$settings['product_tag']);
			break;
		case 'brand':
			$group = $settings['product_brand'];
			break;
		case 'pro_id':
			$group = $product_id;
			break;

	}

	$opt_carousel = json_encode(['group'=>$group,'type'=>$prod_filter,'instock'=>$settings['out_prod'],'sortby'=>$prod_sort,'number'=>$settings['ptotalcount']]);

	// $product_cat = $settings['product_cat'];
	if($settings['header_enabled']){
		$product_cat = [esc_attr($settings['header_elements'][0]['header_ajax_cats'])];
		$tab_id=$product_cat[0];

	}else{
		$tab_id="";
	$product_cat = $settings['product_cat'];
	}
	if($settings['header_enabled']){
      $header_tab = "have_header_cat";
	}else{
	  $header_tab = "";
	}
		?>
    <section  class="col-product <?= $settings['carusel_style'] ?>" opt_carousel='<?=$opt_carousel; ?>'>

       <div class="right-product tab1 <?= $class_typer ?> <?= $show_salsess;?>">

             <?php if ( $settings['prk_show_title'] == 'true' ):?>

				 <div class="head-product <?php echo $title_class;?> <?= $header_tab?>">
				 <div class="prks-tabs-loader">
					<span class="ajax-loader"></span>
				 </div>
			 			<h3 class="<?= $settings['carusel_style'] == 'style2' || $settings['carusel_style'] == 'style3'  ? 'flexed' : '' ?>">
			 				<span class="titles-pro <?php echo $title_class;?>">
					 			<?php if ($title_icon):?>
									<span class="<?php echo $title_icon ?> icon-carosel"></span>
								<?php endif;?>
								<div class="title-tab-prk">
									<div class="item-icon-title">
				 				<span><?php echo $settings['title_section'];?></span>
									</div>
							   </div>
			 		  	</span>
						<?php if ($category_url_view_more == 'true' && $category_url): ?>
			 		   	<a class="view-all" href="<?php echo $category_url;?>"><?php _e('view all' , 'parskala');?></a>
						<?php endif; ?>

						<?php if ($due_date):?>

							<div class="flexed salse-time">	
								<?php if ($settings['due_date_done_text']):?>
									<span class="titme-sale-out"><?= $settings['due_date_done_text'] ?></span>
								<?php endif?>

								<div class="countdown-item-carosel counet-<?= $slider_class;?>"></div>
								<i class="prk-timer-1"></i>
							</div>

							<script type="text/javascript">
								var dateEnd = new Date((<?php echo $due_date; ?>) * 1000);
								new TimezZ('.countdown-item-carosel.counet-<?= $slider_class;?>', {
								date: dateEnd,
								template: '<span class="countzarin-col"><span class="countdown-unit"> <span  class="number">NUMBER</span></span><span class="dot">:</span></span>',
								text: {
								days: 'روز',
								hours: 'ساعت',
								minutes: 'دقیقه',
								seconds: 'ثانیه',
									}
								});
							</script>

					<?php endif; ?>

			 		</h3>

					<?php	if($settings['header_enabled']){ ?>
					  <!-- header buttons -->
					  <div class="prk-ajax-list-header-wrapper widget-tabs">
					<?php
					
							
					     //start rendering HEADER elements
						 foreach ( $settings['header_elements'] as $index => $item ) {
							switch($settings['header_elements'][$index]['header_texticon_alginment']){//prepare header text & icon alignment
								case 'dir1':
									$header_txticon_align = 'prk-texticon-wrapeer1';
									break;
								case 'dir2':
									$header_txticon_align = 'prk-texticon-wrapeer2';
									break;
								case 'dir3':
									$header_txticon_align = 'prk-texticon-wrapeer3';
									break;
								case 'dir4':
									$header_txticon_align = 'prk-texticon-wrapeer4';
									break;
							}
							// $auth = '1';
							// if ($settings['showonly_tologgedin'] == 'yes' && !is_user_logged_in()){
							// 	$auth = '0';
							// }

							?>
							<div cat="<?php echo esc_attr($settings['header_elements'][$index]['header_ajax_cats'])?>" number="<?php echo esc_attr($settings['header_elements'][$index]['header_products_number']) ?>" stock="<?php echo esc_attr($settings['header_elements'][$index]['header_products_stock']) ?>" type="<?php echo esc_attr($settings['header_elements'][$index]['header_products_src']) ?>" seeallcat="<?php echo esc_attr($settings['header_elements'][$index]['header_allcats_show']) ?>" <?php if($settings['header_elements'][$index]['header_allcats_backtype'] == 'color'){
								echo esc_attr('seeallcat_bgcolor='.$settings['header_elements'][$index]['header_allcats_backcolor']);
							}else if($settings['header_elements'][$index]['header_allcats_backtype'] == 'wallpaper') { echo esc_attr('seeallcat_bgwalp='.$settings['header_elements'][$index]['header_allcats_backimg']['url']);}?> seeallcat_title="<?php echo esc_attr($settings['header_elements'][$index]['header_allcats_title'])?>"
							seeallcat_titlecolor="<?php echo esc_attr($settings['header_elements'][$index]['header_allcats_titlecolor'])?>" seeallcat_link="<?php echo esc_attr($settings['header_elements'][$index]['header_allcats_url']['url'])?>" seeallcat_link_ext="<?php echo esc_attr($settings['header_elements'][$index]['header_allcats_url']['is_external'])?>" seeallcat_link_follow="<?php echo esc_attr($settings['header_elements'][$index]['header_allcats_url']['nofollow'])?>"  bgchanger_color="<?php echo esc_attr($settings['header_elements'][$index]['header_bgchanger_color']) ?>" class="title-tab-prk prk-header-divs <?php echo($index==0 ? "prk-header-divs-active":"") ?> tab-item" <?php if($settings['header_elements'][$index]['header_elems_maketitle'] == 'yes'){echo 'no-btn'.' title-theme='.$settings['header_elements'][$index]['header_elems_maketitle_theme'];} ?>>
							
							<div class="<?php echo esc_attr($header_txticon_align); ?> item-icon-title">
							
							<?php if($settings['header_elements'][$index]['header_icons_type'] == 'elem_icons'){
							?><i style="color: <?php echo esc_attr($settings['header_elements'][$index]['header_icons_color']) ?> ;" class="<?php echo esc_attr($settings['header_elements'][$index]['header_icons_select']['value'])?>"></i> <?php
							}else if($settings['header_elements'][$index]['header_icons_type'] == 'custom_icons'){
								?><img style="width:<?php echo esc_attr($settings['header_elements'][$index]['header_iconscustom_width']) ?>px; height: auto;" src="<?php echo esc_attr($settings['header_elements'][$index]['header_iconscustom_select']['url']) ?>" alt="..."><?php
							}?>
							<span bgchanger="<?php echo esc_attr($settings['header_elements'][$index]['header_bgchanger']) ?>" style="color:<?php echo esc_attr($settings['header_elements'][$index]['header_text_color']); ?> ;"><?php echo esc_html($settings['header_elements'][$index]['header_elems_title']); ?></span>
			
							</div>
							</div> 
							<?php
						}

					?>
					  </div>
					  <?php } ?>
	 			</div>
				<?php endif;?>

    <div class="items-pro" >
		
      <div class="<?php echo $class_section;?>" tab-id="<?=$tab_id;?>" settings-slider='<?php echo $json_settings; ?>'>
        <?php


									

											if($settings['header_enabled']){
												$product_cat = [esc_attr($settings['header_elements'][0]['header_ajax_cats'])];

											}else{
												$product_cat = $settings['product_cat'];
											}

											// var_dump($product_cat);
											// die;


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
														$arms['post__in'] = $product_id;
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

										if ( taxonomy_exists( 'city_categories' ) && ! empty( $_COOKIE['prskalaSearchCity'] ) ) {

											$city_categories = array_filter(
												array_map(
													'absint',
													explode( ',', wp_unslash( $_COOKIE['prskalaSearchCity'] ) )
												)
											);

											if ( ! empty( $city_categories ) ) {

												if ( ! isset( $arms['tax_query'] ) || ! is_array( $arms['tax_query'] ) ) {
													$arms['tax_query'] = [];
												}

												if ( ! empty( $arms['tax_query'] ) && ! isset( $arms['tax_query']['relation'] ) ) {
													$arms['tax_query']['relation'] = 'AND';
												}

												$arms['tax_query'][] = [
													'taxonomy' => 'city_categories',
													'field'    => 'term_id',
													'terms'    => $city_categories,
													'operator' => 'IN',
												];
											}
										}

             $pd_query = new WP_Query( $arms );
             if ($pd_query ->have_posts()) {
             	$cate_empty = '';
						}else {
							$cate_empty = 'cate_empty';
						}

						  ?>
             <?php if ( $pd_query ->have_posts() ) : ?>

               <?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post(); ?>
								 <?php
 								global $product , $post;
								$entire_sales = '';
 								$currency = get_woocommerce_currency_symbol();
 								$price = get_post_meta( get_the_ID(), '_regular_price', true);
 								$sale = get_post_meta( get_the_ID(), '_sale_price', true);
 								$img_up_pro = get_post_meta(get_the_ID(),'img_up_pro',true);
								$product_label = get_post_meta(get_the_ID(), 'prk_product_label', true );
								$progress_sales = get_post_meta(get_the_ID(), 'progress_sales', true );
								$_progress_sales = $progress_sales ? $progress_sales : '1';
								if ($_progress_sales == '1'){
									$entire_sales = 'el_none';
								}
								$thumber = get_the_post_thumbnail();
								$imager  = wc_placeholder_img_src();
 								?>
 								<article class="item-pro <?= $show_back_image ?> prob-item prob-item item-hover">
								 <?php do_action('prk_el_woocommerce_before_shop_loop_item') ;?>

									<?php if ($product_label): ?>
										<div class="custom_label"><span><?php echo $product_label;?></span></div>
									<?php endif; ?>

 								    <a href="<?php the_permalink();?>">

											<!--thumbnail-->
											<?php echo pr_img(); ?>

											<div class="shadow-product h-[0px] w-[180px] duration-500 group-hover:mt-[28px] group-hover:h-[20px] group-hover:rotate-1"></div>

 								      <div class="index-title-pro">
 								         <h2><?php echo wp_trim_words(get_the_title(),12,'...') ;?></h2>
 								      </div>

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
											<?php if ($show_dd_cart == 'true'): ?>

												<?php

													$type_add_to_cart = $settings['type_add_to_cart'];
													$type_add_to_cart_text = $settings['type_add_to_cart_icon'] ? $settings['type_add_to_cart_icon'] : 'prk-shopping-cart' ;
													$type_add_to_cart_text = $settings['type_add_to_cart_text'] ? $settings['type_add_to_cart_text'] : 'افزودن به سبد' ;

													$cart_text = '<a data-product-id="'.get_the_ID().'" class="quick_add2cart text" ><span>'.$type_add_to_cart_text.'</span></a>';

													echo apply_filters('add_to_cart_bottom',$cart_text,$type_add_to_cart);
												
												?>

											<?php endif; ?>

                                                
												 <?php if ($_progress_sales && $settings['prk_show_salses'] == 'true' ):?>

													<div class="progress-main <?= $entire_sales ?>">
													<span class="progress-area-label"><?= $_progress_sales ?> فروش رفته</span>
													<div class="progress-area" title="<?= $_progress_sales ?> فروش رفته">
														<div class="progress-bar" style="width:<?= $_progress_sales ?>;"></div>
													</div>
													</div>
												 <?php endif;?>




 								      </a>
									   <?php do_action('prk_el_woocommerce_after_shop_loop_item') ;?>
 								</article>

                <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
          <?php endif;?>

					<!-- المان مشاهده بیشتر -->
 				 <?php if ( $settings['show_view_item'] == 'yes' && $settings['autoplay'] == '' ): ?>
 				   <div class="off-product item-pro mories <?php echo $cate_empty;?>">
 					   <a href="<?php echo $category_urlviewall; ?>">
 					     <div class="w-categorys-link">
 					       <i class="ri-arrow-left-line"></i>
 								 <span> <?php echo $category_allcatstitle; ?> </span>
 					     </div>
 						</a>
 				   </div>
          <?php endif; ?>

      </div>
	  <?php if ($settings['carusel_style'] == 'style3') {
               echo "<i class='prk-arrow-down-1 arrow-style3-down'></i>";
	   }?>
	</div>


			</div>
    </section>
		<?php

	}
	protected function get_terms_mdz( $taxonomy, $top_level_only = false, $with_empty = true ) {

		$list = [];

		if ( $with_empty ) {
			$list[''] = __( 'انتخاب کنید', 'wooslider-bymdez' );
		}

		if ( ! taxonomy_exists( $taxonomy ) ) {
			return $list;
		}

		$args = [
			'taxonomy'   => $taxonomy,
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
		];

		if ( $top_level_only ) {
			$args['parent'] = 0;
		}

		$terms = get_terms( $args );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return $list;
		}

		foreach ( $terms as $term ) {
			$list[ (string) $term->term_id ] = $term->name . ' (id - ' . $term->term_id . ')';
		}

		return $list;
	}


	protected function _content_template() {}

}
