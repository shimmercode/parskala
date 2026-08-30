<?php
class carousel_offer extends \Elementor\Widget_Base {


	public function get_name() {
		return 'carousel_offers';
	}

	public function get_title() {
		return 'کاروسل شگفت انگیز مدرن';
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
				'label' => 'کاروسل شگفت انگیز مدرن',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,

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
				'default' => 'flaticon-medal-3',
			]
		);
		$this->add_control(
			'carousel_des',
			[
				'label' => 'توضیحات سکشن',
				'type' => \Elementor\Controls_Manager::TEXT,
        'label_block' => 'true',
        'default' => 'یک خرید اینترنتی مطمئن، نیازمند فروشگاهی است که بتواند کالاهایی متنوع، باکیفیت و دارای قیمت مناسب را در مدت زمانی کوتاه به دست مشتریان خود برساند',

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

				$this->add_control(
		 			'color_back1',
		 			[
		 				'label' => __( 'رنگ اصلی پس زمینه', 'plugin-domain' ),
		 				'type' => \Elementor\Controls_Manager::COLOR,
		 				'default' => '#edad31',
		 				'selectors' => [
		 					'{{WRAPPER}} .carousel_offer .back_caroslel' => 'background: {{VALUE}}',
		 				],
		 			]
		 		);
				 $this->add_control(
					'color_title',
					[
						'label' => __( 'رنگ اصلی پس زمینه', 'plugin-domain' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '#1A0744',
						'selectors' => [
							'{{WRAPPER}} .carousel_offer .right_carousel h4' => 'color: {{VALUE}}',
						],
					]
				);
		$this->end_controls_section();

	}

	protected function render() {

	  $themeـdisplay = prk_option('theme-style');
		$settings = $this->get_settings_for_display();
		$slider_class = slider_RandomString();
    $show_timer =   $settings['show_timer'];
		$carousel_icon =   $settings['carousel_icon'];
		$carousel_url =   $settings['carousel_url'];
		$border =   $settings['border_carousel'];
		$nav = $settings['nav'];
		$item = $settings['item'] ? $settings['item'] : '4' ;
	 if (! $border){
		if ('parskala' == $themeـdisplay){
			$border = '15';
		}else {
			$border = '8';
		}
	 }

		$carousel_title = $settings['carousel_title'];
		$carousel_des = $settings['carousel_des'];



			$settings_slider =  array(
				'nav' =>    $settings['nav'],
				'autoplay' =>    $settings['autoplay'],
				'delay' =>    $settings['delay'],
			);
			$json_settings = json_encode($settings_slider);


		?>

    <section class="carousel_offer">

      <div class="back_caroslel">
				<div class="right_carousel">

					<h4><i class="<?php echo $carousel_icon;?>"></i><?php echo $carousel_title;?></h4>

					<p><?php echo $carousel_des;?></p>
					<a class="product-item-link" href="<?php echo $carousel_url;?>">مشاهده محصول<i class="ri-arrow-left-line"></i></a>

				</div>

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


		      <div class="left_carousel">

		        <div class="swiper product-specials-swiper-slider modern" settings-slider='<?php echo $json_settings; ?>'>

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

                       <div class="countdown-timer">

                         <?php if ($show_timer == 'yes'):?>

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

														  if ($date): ?>

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

                         <?php endif; ?>

                       </div>

                   </div>


               </div>
           </div>

         <?php endwhile; ?>
       <?php wp_reset_postdata(); ?>

					 </div>
					 <!-- If we need pagination -->
					 <div class="swiper-pagination"></div>

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
	 const settings = JSON.parse(jQuery('.product-specials-swiper-slider').attr("settings-slider"));
		const productSpecialsSwiperSlider = new Swiper(
			".product-specials-swiper-slider",
			{
				// Optional parameters
				spaceBetween: 10,
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
						spaceBetween: 10,
					},
					576: {
						slidesPerView: 3,
						spaceBetween: 10,
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
