<?php
class officals_carosel_Widget_v2 extends \Elementor\Widget_Base {

	public function get_name() {
		return 'officals_carosel_v2';
	}

	public function get_title() {
		return 'کاروسل شگفت انگیز ها v2';
	}

	public function get_icon() {
		return 'eicon-form-vertical';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {

		// شروع سکشن کنترل های اصلی
		$this->start_controls_section(
				'text',
				[
					'label' => 'پیشنهاد شگفت انگیز',
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
			 'showـtitle_p',
			 [
					'label' => __( 'نمایش عنوان محصول', 'PRK' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'default' => 'yes',

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
				'multiple' => true,
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
				 'onsale_code_p',
				 [
						'label' => __( 'درصد تخفیف چسبان', 'PRK' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'return_value' => 'true',
						'default' => 'false',
				 ]
			);

		$this->add_control(
			 'showـtimer',
			 [
					'label' => __( 'نمایش تایمر معکوس', 'PRK' ),
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


		// شروع سکشن کنترل های اسلایدر
		$this->start_controls_section(
		 'slider_special',
		 [
			 'label' => 'پیکربندی اسلایدر',
			 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
						'max' => 9,
						'step' => 1,
						'default' => 7,
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
			'offer_style',
			[
				'label' => esc_html__( 'سبک عنوان شگفت انگیز ها', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'Default',
				'options' => [
					'Default' => esc_html__( 'پیشفرض', 'textdomain' ),
					'date_offer'  => esc_html__( 'شمارنده تاریخ اتمام', 'textdomain' ),
				],
			]
		);
		$this->add_control(
			'prk_offer_title',
			[
				'label' => __( 'عنوان', 'parskala' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'تخفیفانه شگفت انگیز', 'parskala' ),
				'condition' => [
					'offer_style' => 'date_offer',
				],
			]
		);
		$this->add_control(
			'prk_offer_subtitle',
			[
				'label' => __( 'زیر عنوان', 'parskala' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'تخفیفات روزانه تا سقف 50درصد', 'parskala' ),
				'condition' => [
					'offer_style' => 'date_offer',
				],
			]
		);
		$this->add_control(
			'due_date_done',
			[
				'label' => esc_html__( 'تاریخ پایان', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
				'condition' => [
					'offer_style' => 'date_offer',
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

		 $this->add_group_control(
			
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} section.col-off',
			]
		);
	 	$this->add_control(
	     		 's-off',
	     		 [
	     			 'label' => __( 'تصویر پیشنهاد', 'PRK' ),
	     			 'type' => \Elementor\Controls_Manager::MEDIA,
	 					 'default' => [
	 							 'url' =>  parskala_URI .'/assets/img/amazingv2.png',
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
		$this->add_control(
					'border_item',
					[
						'label' => esc_html__( 'انحنا دور ایتم ها', 'plugin-name' ),
						'type' => \Elementor\Controls_Manager::NUMBER,
						'min' => 1,
						'step' => 1,
						'default' => 11,
						'selectors' => [
							'{{WRAPPER}} .col-off .off-product.news' => 'border-radius: {{VALUE}}px',
						],
					]
		);
		$this->add_control(
					'margin_item',
					[
						'label' => esc_html__( 'فاصله بین آیتم ها', 'plugin-name' ),
						'type' => \Elementor\Controls_Manager::NUMBER,
						'min' => 1,
						'step' => 1,
						'default' => 7,

					]
		);
		$this->add_control(
				'center_box',
				[
					'label' => 'وسط چین',
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'بله', 'your-plugin' ),
					'label_off' => __( 'خیر', 'your-plugin' ),
					'return_value' => 'true',
					'default' => 'false',
				]
			);



 	  $this->end_controls_section();
     // پایان تب استایل

	}

	protected function render() {
		$themeـdisplay = prk_option('theme-style');
		$template = get_bloginfo('template_url');

		$due_date = strtotime( $this->get_settings( 'due_date_done' ) );
		// $due_date_done = $due_date / DAY_IN_SECONDS;


		// متغییرهای کنترل ها
	  $settings = $this->get_settings_for_display();

		$Paddings = 0;
		$margins   = $settings['margin_item'];
		$offer_style = $settings['offer_style'];
		$margins_mob = $settings['margin_item'];
		$center_box =   $settings['center_box'];
		$showـtimer =   $settings['showـtimer'];
		$onsale_code   = $settings['onsale_code_p'];
		$showـtitle =   $settings['showـtitle_p'];
		$show_dd_cart =   $settings['prod_show_dd_cart'];
		$category_urlviewall =  $settings['s-off-link']['url'];
		$nav = $settings['nav'] ? $settings['nav'] : 'false';
    $slider_id = generateRandomString();
		// داینامیک کردن تنظیمات کاروسل
		$settings_slider =  array(
			'nav' => $settings['nav'],
	    'autoplay' => $settings['autoplay'],
			'delay' => $settings['delay'],
			'item' => $settings['item'],
			'Paddings' => $Paddings,
			'margins' => $margins,
			'margins_mob' => $margins_mob,
		);

  if ($onsale_code == 'true') {
  	$onsale_code_class = ' onsale_top';
  }else {
  	$onsale_code_class = '';
  }


   if ( mobile_cheker() || tablet_cheker() ) {
		 $class_dev = 'verticaler';
		 $class_section = 'carousel_lister';
		 // $class_item = 'article-off';
     $json_settings = '';
		 if ($center_box == 'true') {
	   	$class_center_box = ' center_box';
		}else {
			$class_center_box = '';
		}
   }else {
		 $class_dev = '';
     $class_section = 'article-off';
		 // $class_item = 'article-off';
		 $json_settings = json_encode($settings_slider);
		 if ($center_box == 'true') {
	   	$class_center_box = ' center_box';
		}else {
			$class_center_box = '';
		}


   }

?>

   <!-- شروع سکشن-->
<section class="<?php echo $class_dev;?> col-off v2">
  <div class="officol <?php echo $slider_id; echo $class_center_box;?>">

      <div class="left-off">



        <div class="<?php echo $class_section;?>" settings-slider='<?php echo $json_settings;?>'>



          <!-- عصنر سمت راست-->
                 <?php
				  if ($offer_style == 'date_offer'){
					?>
					<div class="right-off-date">

						 <div class="img-off-date">
							 <img src="<?php echo $settings['s-off']['url'];?>">
						 </div>
                         <p class="text-one"><?php echo $settings['prk_offer_title'];?></p>
						 <span class="text-two"><?php echo $settings['prk_offer_subtitle'];?></span>
						 <div class="offer-sec block countdown-item"></div>
						<script type="text/javascript">
							var dateEnd = new Date((<?php echo $due_date; ?>) * 1000);
							new TimezZ('.offer-sec.block', {
							date: dateEnd,
							template: '<span class="countzarin-col"><span class="countdown-unit "><span  class="number">NUMBER</span><span class="letter-text">LETTER</span></span></span>',
							text: {
							days: 'روز',
							hours: 'ساعت',
							minutes: 'دقیقه',
							seconds: 'ثانیه',
								}
							});
						</script>
					</div>	
					<?php
				 }else{
					?>
					<div class="right-off">
						 <div class="img-off">
							 <img src="<?php echo $settings['s-off']['url'];?>">
						 </div>
						 <div class="btn-off">
							 <a href="<?php echo $settings['s-off-link']['url'];?>">
								 <?php _e('viwe all' , 'parskala');?>
							 </a>
							 <i class="prk-arrow-left-2"></i>
						 </div>
					</div>
					<?php
				 }
				 ?>



          <?php

											$prod_sort = $settings['prod_sort'];
									 		$prod_filter = $settings['prod_filter'];
									 		$product_cat = $settings['product_cat'];
									 		$product_tag = $settings['product_tag'];
											$product_brand = $settings['product_brand'];
											$product_id = explode(",",$settings['product_id']);

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

							 while ( $pd_query ->have_posts() ) : $pd_query ->the_post();

									 global $woocommerce , $product , $post;
									 $img_up_pro = get_post_meta(get_the_ID(),'img_up_pro',true);
									 $currency = get_woocommerce_currency_symbol();
									 $price = get_post_meta( get_the_ID(), '_regular_price', true);
									 $sale = get_post_meta( get_the_ID(), '_sale_price', true);

									 $progress_sales = get_post_meta(get_the_ID(), 'progress_sales', true );
									 $product_label = get_post_meta(get_the_ID(), 'prk_product_label', true );
										$timer_id = generateRandomString();
										$thumber = get_the_post_thumbnail();
										$imager  = wc_placeholder_img_src();
										$placement = 'top';
										?>

										<article class="off-product news prob-item not-shop-page item-hover">
										<?php do_action('prk_el_woocommerce_before_shop_loop_item') ;?>
										<a href="<?= get_the_permalink();?>" >
                      <?php if ($product_label): ?>
                        <div class="custom_label"><span><?php echo $product_label;?></span></div>
                      <?php endif; ?>




												<!--thumbnail-->


													<?php echo pr_img(); ?>

                                                     <div class="shadow-product h-[0px] w-[180px] duration-500 group-hover:mt-[28px] group-hover:h-[20px] group-hover:rotate-1"></div>
                                                   <?php
													if ( prk_option('show_swatches_archive') && !empty($settings['prk_swatches_list']) ) {
															echo do_shortcode("[prk_swatches_list]");
														}
													?>
													</a>
											 <!--title-->
                       <?php if ($showـtitle == 'yes'): ?>

												 <div class="product-title">
													 <?php the_title();?>
												 </div>

												

                       <?php endif; ?>


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


                      <!-- timer-->
											<?php if ($showـtimer == 'yes'){
												if ( $product -> is_type( 'variable' ) ) {
										        $children_ids = $product->get_children();
										        $date = '';
										        foreach ( $children_ids as $children_id ) {
										            if ( ! empty( $date ) )
										                break;
										            $child_date = get_post_meta( $children_id, '_sale_price_dates_to', true );
										            if ( ! empty( $child_date ) ) {
										                $date = $child_date;
										            }
										        }
										    } else {
										        $date = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
										    }												?>
												<?php if ($date){ ?>
													<div class="prk-tim block">
													  <div <?php if(empty('digikala' == $themeـdisplay)){echo 'id="prk-timers"';}else{echo 'id="timers"';};?> class="timers-<?php echo $timer_id;?>"></div>
			                      <i class="ri-history-line"></i>
													</div>
													<script type="text/javascript">
														 var dateEnd = new Date((<?php echo $date; ?>) * 1000);
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
												<?php }else{ ?>
												<div class="timers expired block"></div>
												<?php } ?>
										  <?php } ?>


											<!--add cart-->
											<?php if ($show_dd_cart == 'true'): ?>

													<?php
                                                    
													$type_add_to_cart = $settings['type_add_to_cart'];
													$type_add_to_cart_text = $settings['type_add_to_cart'] ? $settings['type_add_to_cart'] : 'prk-shopping-cart' ;
													$type_add_to_cart_text = $settings['type_add_to_cart_text'] ? $settings['type_add_to_cart_text'] : 'افزودن به سبد' ;

													$cart_text = '<a data-product-id="'.$post->ID.'" class="quick_add2cart text" ><span>'.$type_add_to_cart_text.'</span></a>';
													
													echo apply_filters('add_to_cart_bottom',$cart_text,$type_add_to_cart);
													?>

											<?php endif; ?>
										
										<?php do_action('prk_el_woocommerce_after_shop_loop_item') ;?>
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
