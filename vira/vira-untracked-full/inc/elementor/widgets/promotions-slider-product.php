<?php

class promotions_slider extends \Elementor\Widget_Base {

	public function get_name() {
		return 'promotions_sliders';
	}

	public function get_title() {
		return __( 'اسلایدر محصولات ویژه', 'prk' );
	}

  public function get_icon() {
    return 'eicon-headphones';
  }

  public function get_categories() {
    return [ 'prk-category' ];
  }

  protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'اسلاید  محصولات ویژه', 'plugin-name' ),
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

    		// شروع سکشن کنترل اسلایدر
    		$this->start_controls_section(
    		 'slider_special',
    		 [
    			 'label' => 'پیکربندی اسلایدر',
    			 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
    		 ]
    		);
				$this->add_control(
        			'sec_title_promotes',
        			[
        				'label' => __( 'عنوان سکشن', 'PRK' ),
								'description' => __( 'اندازه مناسب تصویر 190 در 42px  میباشد.', 'PRK' ),
        				'type' => \Elementor\Controls_Manager::TEXT,
        				'default' => 'شگفت انگیزها',
        			]
        );
				$this->add_control(
			     		 'sec_img_promotes',
			     		 [
			     			 'label' => __( 'تصویر عنوان سکشن', 'PRK' ),
			     			 'type' => \Elementor\Controls_Manager::MEDIA,
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
    							'{{WRAPPER}} .promotion_produt' => 'border-radius: {{VALUE}}px',
    						],
    	 				]
    	 	);

    		$this->end_controls_section();
        // پایان تب استایل
	}

	protected function render() {

    $themeـdisplay = prk_option('theme-style');

		// ساخت متغییر های فیلد
    $settings = $this->get_settings_for_display();


    $title_promotes =  $settings['sec_title_promotes'];
		$img_promotes =  $settings['sec_img_promotes'];
		$cat_link =  $settings['s-off-link']['url'];
 
    // داینامیک کردن اتریبیوتیک
		$settings_slider =  array(
      'autoplay' => $settings['autoplay'],
		);
		$json_settings = json_encode($settings_slider);


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

	 if ( $pd_query ->have_posts() ) {
	 	$class_have = '';
	}else {
		$class_have = 'empty_product';
	}
   ?>


		<div class="promotion_produt <?= $class_have?>">

    <?php if ( $pd_query ->have_posts() ) :?>

        <!-- اسلاید ها -->
        <div class="swiper-container swiper_promotion_produt" settings-slider='<?php echo $json_settings; ?>'>
          <span class="offer_titles">
           <?php if ($img_promotes['url']): ?>
            <img src="<?php echo $img_promotes['url'];?>" alt="promotion">
						<?php else: ?>
							<i><?php echo $title_promotes;?></i>
           <?php endif; ?>
					</span>
          <div class="swiper-wrapper">

            <?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post();
             global $woocommerce , $product;
             $timer_id = generateRandomString();
             $price = get_post_meta( get_the_ID(), '_regular_price', true);
             $sale = get_post_meta( get_the_ID(), '_sale_price', true);
             $date_to = get_post_meta( get_the_ID(), '_sale_price_dates_to', true);
             ?>


              <div class="swiper-slide promotion_item" data-swiper-autoplay="2500">

                <div class="promotion_item_right">

                  <a href="<?php the_permalink();?>">
                    <!-- قیمت -->
                    <div class="viewe_single_price item_price">


										 <?php
											 echo '<div class="index-prices-pro">';

												 if ( $product->is_in_stock() ) {

													 echo '<div class="price_onsale_ar">';

													 if ( $product->is_in_stock() && $price|| $product->is_type( 'variable' )) {
														echo $product->get_price_html();
															}elseif($product->is_in_stock()){
																echo '<p class="call_pro">'.prk_option('single_product_text_price').'</p>';
														}elseif($settings['prk_show_unavailable_text']){
															echo '<p class="call_pro">'.$settings['prk_unavailable_text'].'</p>';
													}

													 echo '</div>';

												 }
												echo '</div>';
											 ?>

                    </div>

                    <!-- عنوان -->
                    <div class="item_title">
                      <h4> <?php the_title();?></h4>
                    </div>

                    <!-- ویژگی ها -->
                    <div class="item_atribiotic">

                      <?php echo costom_attributes(); ?>

                    </div>

                    <!-- تایمر -->
                    <div class="item_timer">

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

											 if ($date){ ?>

                        <span class="item_time_left">زمان باقی مانده تا اتمام تخفیف</span>
                        <div class="prk-tim block">
                          <div id="prk-timers" class="timers-<?php echo $timer_id;?>"></div>
                          <i class="fi fi-rr-time-past"></i>
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

                    </div>

                  </a>
                </div>

                <div class="promotion_item_left">
									<?php
										if ($settings['prk_swatches_list'] && prk_option('show_swatches_archive') ) {
											echo do_shortcode("[prk_swatches_list]");
										}
									?>

                  <a href="<?php the_permalink();?>">

                  <div class="item_thumbnail">

                     <?php echo pr_img(); ?>

                  </div>

                    </a>

                </div>

            </div>



            <?php endwhile; ?>


          </div>

      </div>

      <!--دکمه های تکرار شونده اسلایدر -->
      <div class="swiper-container swiper_item_promotion_produt">

        <div class="swiper-wrapper">

          <?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post();?>


            <div class="swiper-slide">

              <span>
                <?php
                    $title = get_the_title();
                    echo shorten_string($title, 9);
                ?>
              </span>

            </div>

          <?php endwhile; ?>

          <?php wp_reset_postdata(); ?>

          <span class="go_more_link">

            <a href="<?= $cat_link;?>" target="_blank">
               مشاهده همه محصولات شگفت انگیز
            </a>

          </span>

        </div>

		</div>
  <?php endif;?>

	<!-- در صورت نبودن محصول در لیست -->
	<?php if ( ! $pd_query ->have_posts() ): ?>
		<div class="no-products white_p">
			 <i class="ri-timer-line"></i>
			 <span>محصولی در لیست شگفت انگیز ها موجود نیست !</span>
		</div>
	<?php endif; ?>
		</div>



   <script>

   jQuery(function (){

        // تنظیمات دکمه اسلاید ویژه
        var sliderThumbs = new Swiper('.swiper_item_promotion_produt', {


            direction: 'vertical',
            slidesPerView: 9,
            slideToClickedSlide: true,
            spaceBetween: 0,
            freeMode: true,


        });



        // تنظیمات اسلاید ویژه
        var settings = JSON.parse(jQuery('.swiper_promotion_produt').attr("settings-slider"));
        var sliderImages = new Swiper('.swiper_promotion_produt', {

            lazy: true,
            effect: 'fade',
            spaceBetween: 0,
            autoplay: settings.autoplay == "true" ? true : false,
            thumbs: {
              swiper: sliderThumbs
            },
            mousewheel: {
            invert: false,
            },

            breakpoints: {
              990: {
                mousewheel: false,
              },
              0: { // при 768px и выше
                mousewheel: false,
              }
            }
        });


   });

   </script>

<?php
		}

}
