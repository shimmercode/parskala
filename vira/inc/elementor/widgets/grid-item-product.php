<?php
class grid_item_product extends \Elementor\Widget_Base {


	public function get_name() {
		return 'grid_item_products';
	}

	public function get_title() {
		return 'سکشن محصولات لیستی';
	}

	public function get_icon() {
		return 'eicon-posts-masonry';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'text',
			[
				'label' => 'سکشن محصولات لیستی',
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
				'label' => 'ایکن',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'default' => 'flaticon-discount-bag',
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

		$this->end_controls_section();

		$this->start_controls_section(
		 'slider_special',
		 [
			 'label' => 'پیکربندی سکشن',
			 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
		 ]
		);
        $this->add_control(
          'section_general',
                [
                'label' => esc_html__( 'تک سکشن عمومی', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                ]
        );

        $this->add_control(
		 			'color_back1',
		 			[
		 				'label' => __( 'رنگ پس زمینه آیتم ها', 'plugin-domain' ),
		 				'type' => \Elementor\Controls_Manager::COLOR,
		 				'selectors' => [
		 					'{{WRAPPER}} .main_grid_product .grid_item .post_grid' => 'background-color: {{VALUE}}',
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
                  '{{WRAPPER}} .lists_product' => 'border: {{VALUE}}',
                  ],
                ]
        );


        $this->add_control(
          'color_titles',
          [
            'label' => __( 'رنگ عناوین سکشن', 'plugin-domain' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
              '{{WRAPPER}} .mcarousel_product_head h4' => 'color: {{VALUE}}',
              '{{WRAPPER}} .grid_product .mcarousel_product_head a' => 'color: {{VALUE}}',
              '{{WRAPPER}} .mcarousel_product_head span' => 'color: {{VALUE}}',
              '{{WRAPPER}} .grid_product h4' => 'color: {{VALUE}}',
              '{{WRAPPER}} .grid_product .grid_item del .woocommerce-Price-amount' => 'color: {{VALUE}}',
              '{{WRAPPER}} .grid_product .grid_item .index-prices-pro bdi' => 'color: {{VALUE}}',
              '{{WRAPPER}} .grid_product .grid_item .index-prices-pro em' => 'color: {{VALUE}}',
              '{{WRAPPER}} .grid_product .grid_item .index-prices-pro .woocommerce-Price-currencySymbol' => 'color: {{VALUE}} !important',

            ],
          ]
        );

		$this->end_controls_section();

	}

	protected function render() {

	  $themeـdisplay = prk_option('theme-style');
		$settings = $this->get_settings_for_display();

		$border = $settings['border_width'];
	 if (! $border){
		if ('parskala' == $themeـdisplay){
			$border = '15';
		}else {
			$border = '8';
		}
	 }
    $section_general =   $settings['section_general'];
		$carousel_title = $settings['carousel_title'];
    $carousel_url =   $settings['carousel_url'];
		$carousel_icon =   $settings['carousel_icon'];





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

   if ($pd_query ->have_posts()) {
	   	$classes_empty = '';
   }else {
   		$classes_empty = 'center_flexed';
   }

    if ($section_general) {
      $classes = 'mcarousel_product';
    }else {
      $classes = 'mgrid_product';
    }
		?>

    <section class="<?php echo $classes;?> grid_product <?php echo $classes_empty;?>">
      <?php if ( $pd_query ->have_posts() ) :?>
        <div class="mcarousel_product_head">
          <h4>
						<?php if ($carousel_icon){
            echo '<i class="'.$carousel_icon.'"></i>';
						}?>
						<?php echo $carousel_title;?>
					</h4>
          <a class="product-item-link" href="<?php echo $carousel_url;?>">مشاهده محصول<i class="ri-arrow-left-line"></i></a>
        </div>

        <div class="main_grid_product">
          <?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post();
					global $woocommerce, $product;
					$price = get_post_meta( get_the_ID(), '_regular_price', true);
					$sale = get_post_meta( get_the_ID(), '_sale_price', true);
					?>
            <article class="grid_item">

              <div class="posts_grid">

								<a class="post_grid" href="<?php the_permalink();?>">

                <div class="grid_item_rtl">
                  <!--thumbnail-->
                <?php echo get_the_post_thumbnail(get_the_ID(), 'woocommerce_thumbnail', array( 'class' => 'center' ) ); ?>

                </div>


                <div class="grid_item_ltr">


	                  <!--title-->
	                  <h4><?php the_title();?></h4>

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
							 </a>
              </div>

            </article>
        <?php endwhile; ?>
       <?php wp_reset_postdata(); ?>
        </div>

      <?php endif;?>

			<!-- در صورت نبودن محصول در لیست -->
			<?php if ( ! $pd_query ->have_posts() ): ?>
				<div class="no-products white_p">
					 <i class="ri-timer-line"></i>
					 <span>محصولی در لیست شگفت انگیز ها موجود نیست !</span>
				</div>
			<?php endif; ?>

    </section>


		<?php

	}

	protected function _content_template() {}

}
