<?php
class officals_carosel_Widget_mobit extends \Elementor\Widget_Base {


	public function get_name() {
		return 'officals_carosel_mobit';
	}

	public function get_title() {
		return 'کاروسل شگفت انگیز مبیت';
	}

	public function get_icon() {
		return 'eicon-posts-carousel';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'text',
			[
				'label' => 'عنوان تب',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,

			]
		);	

		$this->add_group_control(
			
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .carousel_offer_mobit_title',
			]
		);
		$this->add_control(
			'carousel_title',
			[
				'label' => 'عنوان',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'عنوان',
				'default' => 'عنوان',
			]
		);
		$this->add_control(
			'carousel_icon',
			[
				'label' => 'ایکن عنوان',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'عنوان',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => 'لیبل عنوان',
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .carousel_offer_mobit_title h2',
			]
		);
		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'رنگ عنوان', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carousel_offer_mobit_title h2' => 'color: {{VALUE}}',
					'{{WRAPPER}} .carousel_offer_mobit_title h2 i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'carousel_url',
			[
				'label' => 'لینک دسته',
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => 'true',
				'default' => '#',

			]
		);
		$this->add_control(
			'link_color',
			[
				'label' => esc_html__( 'رنگ متن مشاهده همه', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carousel_offer_mobit_title a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .carousel_offer_mobit_title a i' => 'color: {{VALUE}}',
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
			'due_date_done_color',
			[
				'label' => esc_html__( 'رنگ متن شمارنده', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .countdown-item.mobit .countzarin-col .countdown-unit .number' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'general_tab',
			[
				'label' => 'کاروسل شگفت انگیز مبیت',
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
			'prk_show_footer_card',
			[
				'label' => 'نمایش فوتر آیتم',
				'description' => 'نمایش لیبل ناموجود برای محصولات ناموجود',
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'بله', 'your-plugin' ),
				'label_off' => __( 'خیر', 'your-plugin' ),
				'return_value' => 'true',
				'default' => 'true',
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
      					'default' => 5,
      				]
        );

      	$this->add_control(
      		'border_carousel',
      					[
      					'label' => esc_html__( 'انحنا دور سکشن', 'plugin-name' ),
      					'type' => \Elementor\Controls_Manager::TEXT,
      					'default' => '2px 63px 2px 2px',
      						'selectors' => [
      						'{{WRAPPER}} .back_caroslel' => 'border-radius: {{VALUE}}',
      						],
      					]
      	);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$due_date = strtotime( $this->get_settings( 'due_date_done' ) );

		$slider_class = slider_RandomString();
        $show_timer =   $settings['show_timer'];
		$carousel_icon =   $settings['carousel_icon'];
		$carousel_url =   $settings['carousel_url'];
		$border =   $settings['border_carousel'];
		$nav = $settings['nav'];
		$item = $settings['item'] ? $settings['item'] : '4' ;


		$carousel_title = $settings['carousel_title'];



		$settings_slider =  array(
			'nav' =>    $settings['nav'],
			'autoplay' =>    $settings['autoplay'],
			'delay' =>    $settings['delay'],
		);
		$json_settings = json_encode($settings_slider);


	?>

    <section class="carousel_offer_mobit">

      <div class="carousel_offer_mobit_title">

       <h2><?php if ($carousel_icon){ echo '<i class="'.$carousel_icon.'"></i>'; } ?> <?= $carousel_title;?></h2>

        <?php if ($due_date):?>

			<div class="countdown-item mobit counet-<?= $slider_class;?>"></div>
			<script type="text/javascript">
				var dateEnd = new Date((<?php echo $due_date; ?>) * 1000);
				new TimezZ('.countdown-item.mobit.counet-<?= $slider_class;?>', {
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

	   <a href="<?= $carousel_url;?>">مشاهده همه <i class="ri-arrow-left-s-line"></i></a>

	  </div>
      <div class="back_carosel">


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

           // اگر پست داشت
           if ( $pd_query ->have_posts() ) :
           ?>


		      <div class="main_carousel">

		        <div class="swiper mobit product-specials-swiper-slider" settings-slider='<?php echo $json_settings; ?>'>

		          <div class="swiper-wrapper">
					 <?php
            while ( $pd_query ->have_posts() ) : $pd_query ->the_post();

              global $woocommerce , $product;
              $img_up_pro = get_post_meta(get_the_ID(),'img_up_pro',true);
              $currency = get_woocommerce_currency_symbol();
              $price = get_post_meta( get_the_ID(), '_regular_price', true);
              $sale = get_post_meta( get_the_ID(), '_sale_price', true);
              $date_to = get_post_meta( get_the_ID(), '_sale_price_dates_to', true);
              $progress_sales = get_post_meta(get_the_ID(), 'progress_sales', true );
			  $onsales_round = get_post_meta(get_the_ID(), 'onsales_round', true );
              $timer_id = generateRandomString();
              $thumber = get_the_post_thumbnail();
              $imager  = wc_placeholder_img_src();
              $post_id = 	$product->get_id();
              $parent_id = wp_get_post_parent_id( $post_id );
              ?>

           <div class="swiper-slide">
               <div class="product-card">
                   <div class="product-thumbnail">
                       <a href="<?php the_permalink();?>">

							<?php echo pr_img(); ?>


                       </a>
                   </div>
					<?php
						if ($settings['prk_swatches_list']) {
							echo do_shortcode("[prk_swatches_list]");
						}
					?>
					<?php

					 if ( $onsales_round == 'yes' ){
                     echo '<i class="onsales_round_icon">
					    <svg
						version="1.1"
						width="259.20001pt"
						height="259.20001pt"
						id="svg6"
						viewBox="0 0 259.20001 259.20001"
						sodipodi:docname="MOBIT   ICON.cdr"
						xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
						xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
						xmlns="http://www.w3.org/2000/svg"
						xmlns:svg="http://www.w3.org/2000/svg">
						<defs
							id="defs10" />
						<sodipodi:namedview
							id="namedview8"
							pagecolor="#ffffff"
							bordercolor="#000000"
							borderopacity="0.25"
							inkscape:showpageshadow="2"
							inkscape:pageopacity="0.0"
							inkscape:pagecheckerboard="0"
							inkscape:deskcolor="#d1d1d1"
							inkscape:document-units="pt" />
						<path
							d="m 129.7054,259.3709 c 106.9137,0 129.2631,-23.0399 129.2541,-129.3603 C 258.9504,22.3211 236.8941,1.026 129.7054,0.723 23.5047,0.4208 0.6073,23.5033 0.4213,130.0106 0.2317,237.1685 22.5049,259.3709 129.7054,259.3709 Z M 81.1769,36.1864 c -35.4725,4.2144 -42.6574,14.367 -46.3038,49.9257 -3.1474,30.6992 -2.808,64.0259 0.5871,93.7072 3.9666,34.6604 15.5011,41.4016 51.6486,45.1796 29.9135,3.1265 62.1442,2.6248 92.0269,-0.734 35.0851,-3.9422 41.995,-16.7414 45.43,-50.3648 3.1048,-30.4153 2.8816,-64.0904 -0.5507,-93.983 -3.9631,-34.5616 -17.1841,-41.3219 -51.7158,-44.8639 -30.5368,-3.1356 -61.1045,-2.4298 -91.1223,1.1332 z"
							style="fill:#ff6a6a;fill-rule:evenodd"
							id="path2" />
						<path
							d="m 167.5687,91.7902 v 0 c 6.3436,6.3436 6.3444,16.7235 9e-4,23.067 l -53.6166,53.6166 c -6.3436,6.3436 -16.7234,6.3427 -23.067,-9e-4 v 0 c -6.3436,-6.3435 -6.3436,-16.7234 0,-23.067 l 53.6157,-53.6157 c 6.3436,-6.3435 16.7234,-6.3435 23.067,0 z m -3.3302,57.4072 c 8.7113,0 15.7725,7.0612 15.7725,15.7724 0,8.7112 -7.0612,15.7725 -15.7725,15.7725 -8.7112,0 -15.7724,-7.0613 -15.7724,-15.7725 0,-8.7112 7.0612,-15.7724 15.7724,-15.7724 z M 95.1405,79.3479 c 8.7112,0 15.7724,7.0613 15.7724,15.7725 0,8.7112 -7.0612,15.7724 -15.7724,15.7724 -8.7113,0 -15.7725,-7.0612 -15.7725,-15.7724 0,-8.7112 7.0612,-15.7725 15.7725,-15.7725 z"
							style="fill:#ff6a6a;fill-rule:evenodd"
							id="path4" />
						</svg>

					 </i>';
					}

					?>
                   <div class="product-card-body">
                       <h2 class="product-title">
                           <a href="<?php the_permalink();?>"><?php the_title();?></a>
                       </h2>

                   </div>

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

                   <?php if ( $settings['prk_show_footer_card'] ):?>

                   <div class="product-card-footer">
                       <div
                           class="product-dates">
                           <div class="product-actions">
                               <ul>
                                   <li>
                                     <?php echo do_shortcode("[ajax_cart_item]");?>
                                   </li>
                                   <li>
                                     <a  href="#" class="Quickview"
                                         product-id= "<?php if($parent_id){ echo $parent_id ;}else {echo $post_id;} ; ?>"
                                         data-bs-toggle="tooltip"
                                         data-bs-placement="top" title=""
                                         data-bs-original-title="مشاهده سریع"
                                         aria-label="مشاهده سریع"
                                         data-remodal-target="quick-view-modal">
                                      <i class="prk-search-normal-1"></i>
                                      </a>

                                   </li>
                                   <li>
                                      <?php echo do_shortcode("[wishlist_cart_btn_item]");?>
                                   </li>
                               </ul>
                           </div>
                           <div class="product-rating fa-num">
                             <i class="ri-star-fill star"></i>
                             <strong><?php echo $product->get_average_rating(); ?></strong>
                             <span>(<?php echo $product->get_rating_count(); ?>) </span>
                           </div>
                       </div>
					   <?php
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
								}
                        ?>
					   <?php if ($show_timer == 'yes'  ):?>

                       <div class="countdown-timer">


 
								<?php if ($date): ?>
									<i class="prk-timer-1"></i>
                                 <div class="prk_timer">
                                   <div id="timerm" class="timer-<?php echo $timer_id;?>"></div>
                                 </div>

                                 <script type="text/javascript">
                                    var dateEnd = new Date((<?php echo $date; ?>) * 1000);
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


                       </div>
					   <?php endif; ?>

                   </div>
				<?php endif; ?>

               </div>
           </div>

         <?php endwhile; ?>
       <?php wp_reset_postdata(); ?>

					 </div>


					 <?php if ($nav): ?>
					 <!-- If we need navigation buttons -->
					 <div class="swiper-button-prev specials_nav"></div>
					 <div class="swiper-button-next specials_nav"></div>
					 <?php endif; ?>

				 </div>

			 </div>

     <?php endif;?>
		 <!-- در صورت نبودن محصول در لیست -->
		 <?php if ( ! $pd_query ->have_posts() ): ?>
			 <div class="no-products">
					<i class="ri-timer-line"></i>
					<span>محصولی در لیست شگفت انگیز ها موجود نیست !</span>
			 </div>
		 <?php endif; ?>

     </div>

    </section>

    <script>
 jQuery(document).ready(function(){
	 const settings = JSON.parse(jQuery('.product-specials-swiper-slider.mobit').attr("settings-slider"));
		const productSpecialsSwiperSlider = new Swiper(
			".product-specials-swiper-slider.mobit",
			{
				// Optional parameters
				spaceBetween: 15,
				autoplay: settings.autoplay == "true" ? true : false,

				// If we need pagination
				pagination: {
					el: ".swiper-pagination",
					clickable: true,
					dynamicBullets: true,
				},

				// Navigation arrows

				navigation: {
					nextEl: ".swiper-button-next.specials_nav",
					prevEl: ".swiper-button-prev.specials_nav",
				},

				breakpoints: {
					1200: {
						slidesPerView: <?= $item?>,
					},
					992: {
						slidesPerView: 3,
						spaceBetween: 15,
					},
					576: {
						slidesPerView: 3,
						spaceBetween: 15,
					},
					480: {
						slidesPerView: 2,
						spaceBetween: 8,
					},
				},
			}
		);

  });
    </script>

		<?php

	}

	protected function _content_template() {}

}
