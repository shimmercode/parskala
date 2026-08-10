<?php
class product_carosel_Widget_fashoin extends \Elementor\Widget_Base {


	public function get_name() {
		return 'product-carosel-fashon';
	}

	public function get_title() {
		return 'کاروسل محصولات -فشن';
	}

	public function get_icon() {
		return 'eicon-cart-solid';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'text',
			[
				'label' => 'کاروسل محصولات فشن',
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
				'default' => 'جدید ترین  کالاها',
			]
		);
		$this->add_control(
			'title_icon',
			[
				'label' => ' ایکن <a href="https://remixicon.com/" target="_blank">دریافت ایکن از این سایت</a>',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'ایکن',
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
	    'categoryـurl',
	    [
	        'label' => __( 'لینک دسته', 'plugin-domain' ),
	        'type' => \Elementor\Controls_Manager::URL,
	        'multiple' => true,
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
					'default' => 4,
				]
    );

		$this->add_control(
			'border',
						[
						'label' => esc_html__( 'انحنا دور سکشن', 'plugin-name' ),
						'type' => \Elementor\Controls_Manager::NUMBER,
						'min' => 1,
						'step' => 1,
						'default' => '8',
							'selectors' => [
							'{{WRAPPER}} .right-product' => 'border-radius: {{VALUE}}px',
							],
						]
		);

		$this->end_controls_section();

	}

	protected function render() {

	 $themeـdisplay = prk_option('theme-style');

		$settings = $this->get_settings_for_display();
		$slider_class = slider_RandomString();
		$border =   $settings['border'];
	 if (! $border){
		if ('parskala' == $themeـdisplay){
			$border = '15';
		}else {
			$border = '8';
		}
	 }
		$title_icon = $settings['title_icon'];

		$category_url_viewall =  $settings['category_url_viewall']['url'];
		$categoryـurl =  $settings['categoryـurl']['url'];
		$settings_slider =  array(
			'loop' => $settings['loop'],
			'nav' => $settings['nav'],
			'autoplay' => $settings['autoplay'],
			'delay' => $settings['delay'],
			'item' => $settings['item'],
			'margins' => 25,
		);
		$json_settings = json_encode($settings_slider);


    if ( mobile_cheker() || tablet_cheker() ) {
 		 $class_dev = 'verticaler';
 		 $class_section = 'carousel_lister';
 		 // $class_item = 'article-off';
      $json_settings = '';
    }else {
 		 $class_dev = '';
      $class_section = 'article-off';
 		 // $class_item = 'article-off';
 		 $json_settings = json_encode($settings_slider);

    }


		?>
    <section  class="col-product">

       <div class="right-product tab1">

				 <div class="head-product">
	 			<h3>
	 				<span class="titles-pro">

	 			<?php if ($title_icon):?>
					<span class="<?php echo $title_icon ?> icon-carosel"></span>
				<?php endif;?>
	 				<span><?php echo $settings['title_section'];?></span>
	 			</span>
				<?php if ($categoryـurl): ?>
	 		   	<a class="view-all" href="<?php echo $categoryـurl;?>"><?php _e('view all' , 'parskala');?></a>
				<?php endif; ?>
	 		</h3>
	 			</div>
    <div class="items-pro">
      <div class="<?php echo $class_section;?>" settings-slider='<?php echo $json_settings; ?>'>
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
             $pd_query = new WP_Query( $arms ); ?>
             <?php if ( $pd_query ->have_posts() ) : ?>

               <?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post(); ?>
								 <?php
 								global $product;
 								global $woocommerce;
								$product_label = get_post_meta(get_the_ID(), 'prk_product_label', true );
 								$price = get_post_meta( get_the_ID(), '_regular_price', true);
 								?>
 								<article class="item-pro prk_fashon">

									<?php if ($product_label): ?>
										<div class="custom_label"><span><?php echo $product_label;?></span></div>
									<?php endif; ?>

 								    <a href="<?php the_permalink();?>">

											<!--thumbnail-->
											<?php echo pr_img(); ?>

											<?php
												if ($settings['prk_swatches_list'] && prk_option('show_swatches_archive') ) {
													echo do_shortcode("[prk_swatches_list]");
												}
											?>

 								      <div class="index-title-pro">
 								         <h2><?php echo wp_trim_words(get_the_title(),12,'...') ;?></h2>
 								      </div>

											<!--price-->
	 									 <div class="index-prices-pro border-dashed-gradient">
	 										 <div class="price_onsale_ar">
 													<?php if ($price|| $product->is_type( 'variable' )) {
 														echo $product->get_price_html();
 													}elseif($product->is_in_stock()){
 														echo '<p class="call_pro">'.prk_option('single_product_text_price').'</p>';
													}elseif($settings['prk_show_unavailable_text']){
														echo '<p class="call_pro">'.$settings['prk_unavailable_text'].'</p>';
													}
												
 													?>
	 										 </div>
	 									 </div>

 								      </a>
 								</article>

                <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
          <?php endif;?>

					<!-- المان مشاهده بیشتر -->
				 <?php if ($pd_query ->have_posts() ): ?>
					 <div class="off-product mories item-pro">
						 <a href="<?php echo $category_url_viewall; ?>">
							 <div class="w-categorys-link">
								 <i class="ri-arrow-left-line"></i>
								 <span>مشاهده همه</span>
							 </div>
						</a>
					 </div>
					<?php endif; ?>

      </div>
			</div>
    </section>
		<?php

	}

	protected function _content_template() {}

}
