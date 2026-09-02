<?php
class lists_section_product extends \Elementor\Widget_Base {


	public function get_name() {
		return 'lists_section_products';
	}

	public function get_title() {
		return 'سکشن محصولات لیستی';
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'text',
			[
				'label' => 'کاروسل محصولات مدرن',
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
			'carousel_des',
			[
				'label' => 'توضیح کوتاه',
				'type' => \Elementor\Controls_Manager::TEXT,
        'label_block' => 'true',
        'default' => 'محبوب ترین های ما',

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
				 'showـbtnـcart',
				 [
						'label' => 'نمایش دکمه افزودن به سبد خرید',
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'default' => 'false',

				 ]
			);



		$this->end_controls_section();

		$this->start_controls_section(
		 'slider_special',
		 [
			 'label' => 'پیکربندی سکشن',
			 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
		 			'color_back1',
		 			[
		 				'label' => __( 'رنگ اصلی پس زمینه', 'plugin-domain' ),
		 				'type' => \Elementor\Controls_Manager::COLOR,
		 				'default' => '#fff',
		 				'selectors' => [
		 					'{{WRAPPER}} .lists_product' => 'background-color: {{VALUE}}',
		 				],
		 			]
		 		);

        $this->add_control(
          'border_width',
                [
                'label' => esc_html__( 'انحنا دور سکشن', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '1px',
                  'selectors' => [
                  '{{WRAPPER}} .lists_product' => 'border-radius: {{VALUE}}',
                  ],
                ]
        );
        $this->add_control(
          'color_border',
          [
            'label' => __( 'رنگ دور سکشن', 'plugin-domain' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#1A0744',
            'selectors' => [
              '{{WRAPPER}} .lists_product' => 'border-color: {{VALUE}}',
            ],
          ]
        );

        $this->add_control(
          'color_titles',
          [
            'label' => __( 'رنگ عناوین سکشن', 'plugin-domain' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
              '{{WRAPPER}} .lists_product .mcarousel_product_head h4' => 'color: {{VALUE}}',
              '{{WRAPPER}} .lists_product .mcarousel_product_head span' => 'color: {{VALUE}}',
							'{{WRAPPER}} .lists_product  h2.product-title a' => 'color: {{VALUE}}',
							'{{WRAPPER}} .lists_product .product-lists-body del .woocommerce-Price-amount' => 'color: {{VALUE}}',
							'{{WRAPPER}} .lists_product .product-lists-body .index-prices-pro bdi' => 'color: {{VALUE}}',
							'{{WRAPPER}} .lists_product .product-lists-body .index-prices-pro .woocommerce-Price-currencySymbol' => 'color: {{VALUE}} !important',
            ],
          ]
        );

		$this->end_controls_section();

	}

	protected function render() {

	  $themeـdisplay = prk_option('theme-style');
		$settings = $this->get_settings_for_display();



		$border =   !empty($settings['border']) ? $settings['border'] : null;
 	 if (! $border){
 		if ('parskala' == $themeـdisplay){
 			$border = '15';
 		}else {
 			$border = '8';
 		}
 	 }

		$carousel_title = $settings['carousel_title'];
		$carousel_des = $settings['carousel_des'];
    $carousel_url =   $settings['carousel_url'];

	if ( isset($settings['color_titles']) ) {
		$color_titles = $settings['color_titles'];
	} else {
		$color_titles = []; // مقدار پیش‌فرض یا مقدار مناسب دیگر
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
															 if (is_array($arms["tax_query"])) {
																 $arms["tax_query"][] = ["taxonomy" => "city_categories", "field" => "id", "terms" => $city_categories];
															 } else {
																 $arms["tax_query"] = ["relation" => "AND", ["taxonomy" => "city_categories", "field" => "id", "terms" => $city_categories]];
															 }
														 }
												 }
    $pd_query = new WP_Query( $arms );

		?>

    <section class="lists_product">

      <div class="mcarousel_product_head">
        <h4><?php echo $carousel_title;?></h4>
        <span><?php echo $carousel_des;?></span>
      </div>



         <?php if ( $pd_query ->have_posts() ) :?>
          <div class="swiper-container lists_section_product">
            <div class="swiper-wrapper">

          <?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post();
          global $woocommerce , $product;
          $price = get_post_meta( get_the_ID(), '_regular_price', true);
          $sale = get_post_meta( get_the_ID(), '_sale_price', true);
          ?>

           <div class="swiper-slide">

               <div class="product-lists">

                   <div class="product-thumbnail <?php if ($color_titles){echo 'backcolor';}?>">
                       <a href="<?php the_permalink();?>">
                          <?php echo get_the_post_thumbnail(get_the_ID(), 'woocommerce_thumbnail', array( 'class' => 'center' ) ); ?>
                       </a>
                   </div>

                   <div class="product-lists-body">

                       <h2 class="product-title">
                           <a href="<?php the_permalink();?>"><?php the_title();?></a>
                       </h2>

											 <!--price-->
											 <div class="index-prices-pro">

												 <div class="price_onsale_ar">

															<?php if ($price|| $product->is_type( 'variable' )) {
																echo $product->get_price_html();
															}else{
																echo '<p class="call_pro">'.prk_option('single_product_text_price').'</p>';
															}
															?>

												 </div>
											 </div>

                   </div>

               </div>

           </div>

         <?php endwhile; ?>
       <?php wp_reset_postdata(); ?>


         </div>
         <div class="swiper-pagination"></div>
         <div class="button-next lists"><i class="ri-arrow-down-s-line"></i></div>
         </div>
         <?php endif;?>

				 <!-- در صورت نبودن محصول در لیست -->
			 	<?php if ( ! $pd_query ->have_posts() ): ?>
			 		<div class="no-products white_p small">
			 			 <i class="ri-timer-line"></i>
			 			 <span>محصولی در لیست شگفت انگیز ها موجود نیست !</span>
			 		</div>
			 	<?php endif; ?>



    </section>

    <script>
	jQuery(document).ready(function($){

    var thumbs_lists = new Swiper ('.lists_section_product', {
        slidesPerView: 3,
        direction: "vertical",
        spaceBetween: 5,
        centeredSlides: true,
        loop: true,
        loopedSlides: 2, //スライドの枚数と同じ値を指定
        slideToClickedSlide: true,
         mousewheel: {
            invert: false,
        },
				navigation: {
				nextEl: '.button-next.lists',
		},

    });

  });
    </script>

		<?php

	}

	protected function _content_template() {}

}
