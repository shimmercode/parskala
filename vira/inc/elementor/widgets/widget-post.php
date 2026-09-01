<?php
class widget_post_class extends \Elementor\Widget_Base {


	public function get_name() {
		return 'widget_post';
	}

	public function get_title() {
		return 'سکشن نوشته پارس کالا';
	}

	public function get_icon() {
		return 'eicon-posts-group';
	}

	public function get_categories() {
		return [ 'prk-blog-category' ];
	}

	protected function register_controls() {

        // 
		$this->start_controls_section(
			'title_sec',
			[
				'label' => 'پیکربندی عنوان',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_title_sec',
			[
				'label' => __( 'نمایش عنوان سکشن', 'parskala' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'multiple' => true,
				'label_on' => __( 'نمایش', 'parskala' ),
				'label_off' => __( 'مخفی', 'parskala' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
		$this->add_control(
			'title_sec_text',
			[
				'label' => 'عنوان لیبل',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'default' => 'آخرین های وبلاگ',

			]
		);

 		$this->add_control(
 			'color_title_sec',
 			[
 				'label' => __( 'رنگ عنوان', 'plugin-domain' ),
 				'type' => \Elementor\Controls_Manager::COLOR,
 				'selectors' => [
 					'{{WRAPPER}} .mcarousel_product_head h4' => 'color: {{VALUE}}',
 				],
 			]
 		);

		 $this->add_control(
			'icon_title_sec',
			[
				'label' => 'ایکن عنوان',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'ایکن',
				'default' => 'prk-notification-status',
				'description' => 'دریافت فونت ایکن از سایت .<a href="https://remixicon.com/" target="_blank">remixicon</a> یا <a href="http://parskalas.com/icon/iconpars.html" target="_blank">فونت های اختصاصی پارس کالا</a>',

			]
		);
		 $this->add_control(
			'color_icon_title_sec',
			[
				'label' => __( 'رنگ ایکن عنوان', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mcarousel_product_head h4 i' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'show_more_blog',
			[
				'label' => __( 'نمایش دکمه مشاهده همه', 'parskala' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'multiple' => true,
				'label_on' => __( 'نمایش', 'parskala' ),
				'label_off' => __( 'مخفی', 'parskala' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
		$this->add_control(
			'show_more_blog_text',
			[
				'label' => 'عنوان لیبل مشاهده همه',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'ایکن',
				'default' => 'مشاهده بیشتر',

			]
		);
		$this->add_control(
			'show_more_blog_url',
			[
				'label' => 'لینک مشاهده همه',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'ایکن',
				'default' => 'مشاهده بیشتر',

			]
		);
		$this->add_control(
			'color_more_blog',
			[
				'label' => __( 'رنگ مشاهدهه مه', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mcarousel_product_head a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'margin',
			[
				'label' => esc_html__( 'فاصله گذاری خارجی', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .mcarousel_product_head ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'text',
			[
				'label' => 'سکشن نوشته پست',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'sec_icon',
			[
				'label' => 'ایکن',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'ایکن',
				'default' => 'prk-notification-status',
			]
		);
		$this->add_control(
			'sec_title',
			[
				'label' => 'عنوان',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'ایکن',
				'default' => 'prk-notification-status',
			]
		);

		$options = array();

		$args = array(
			'hide_empty' => false,
		);
	
		$categories =  $categories = get_categories(array('taxonomy'=> 'category'));
		foreach ( $categories as $key => $category ) {
			$options[$category->term_id] = $category->name;
		}
		$this->add_control(
			'category',
			[
				'label' => __( 'دسته', 'prk' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $options,
			]
		);

		$this->add_control(
			'order-post',
			[
			'label' => 'مرتب سازی',
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => 'DESC',
			'options' => [
					'ASC'  => __( 'صعودی', 'prk' ),
					'DESC' => __( 'نزولی', 'prk' )
				],
			]
		);

		$this->add_control(
			'count-post',
			[
				'label' => __( 'تعداد نوشته', 'prk' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 10,
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
			'show_cat_post',
			[
				'label' => __( 'نمایش دسته بندی آیتم', 'parskala' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'multiple' => true,
				'label_on' => __( 'نمایش', 'parskala' ),
				'label_off' => __( 'مخفی', 'parskala' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);

 		$this->add_control(
 			'bcolor_cat_post',
 			[
 				'label' => __( 'رنگ پس زمینه لیبل دسته بندی', 'plugin-domain' ),
 				'type' => \Elementor\Controls_Manager::COLOR,
 				'selectors' => [
 					'{{WRAPPER}} .post-item-category' => 'background-color: {{VALUE}}',
 				],
 			]
 		);

		 $this->add_control(
			'color_cat_post',
			[
				'label' => __( 'رنگ لیبل دسته بندی', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .post-item-category a' => 'color: {{VALUE}}',
				],
			]
		);

		 $this->add_control(
			'show_title',
			[
				'label' => __( 'نمایش عنوان', 'parskala' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'multiple' => true,
				'label_on' => __( 'نمایش', 'parskala' ),
				'label_off' => __( 'مخفی', 'parskala' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
		$this->add_group_control(

			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'تایپوگرافی عنوان', 'plugin-name' ),
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}}  .prk-main-post-item .prk-post-item .post-item-title',
			]
		);

 		$this->add_control(
 			'color_title',
 			[
 				'label' => __( 'رنگ عنوان', 'plugin-domain' ),
 				'type' => \Elementor\Controls_Manager::COLOR,
 				'selectors' => [
 					'{{WRAPPER}} .prk-main-post-item .prk-post-item .post-item-title a' => 'color: {{VALUE}}',
 				],
 			]
 		);
		 $this->add_control(
			'show_desc_content',
			[
				'label' => __( 'نمایش توضیحات کوتاه نوشته', 'parskala' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'multiple' => true,
				'label_on' => __( 'نمایش', 'parskala' ),
				'label_off' => __( 'مخفی', 'parskala' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
		 $this->add_control(
			'show_read_content',
			[
				'label' => __( 'نمایش زمان مطالعه', 'parskala' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'multiple' => true,
				'label_on' => __( 'نمایش', 'parskala' ),
				'label_off' => __( 'مخفی', 'parskala' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
		 $this->add_control(
			'show_author',
			[
				'label' => __( 'نمایش ادمین', 'parskala' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'multiple' => true,
				'label_on' => __( 'نمایش', 'parskala' ),
				'label_off' => __( 'مخفی', 'parskala' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
 		$this->add_control(
 			'color_author',
 			[
 				'label' => __( 'رنگ نام ادمین', 'plugin-domain' ),
 				'type' => \Elementor\Controls_Manager::COLOR,
 				'selectors' => [
 					'{{WRAPPER}} .meta-item.author' => 'color: {{VALUE}}',
 				],
 			]
 		);
		 $this->add_control(
			'show_view',
			[
				'label' => __( 'نمایش دکمه خواندن', 'parskala' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'multiple' => true,
				'label_on' => __( 'نمایش', 'parskala' ),
				'label_off' => __( 'مخفی', 'parskala' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
 		$this->add_control(
 			'bcolor_view',
 			[
 				'label' => __( 'رنگ پس زمینه دکمه خواندن', 'plugin-domain' ),
 				'type' => \Elementor\Controls_Manager::COLOR,
 				'selectors' => [
 					'{{WRAPPER}} .prk-main-post-item .prk-post-item .post-item-footer a.view-more' => 'background-color: {{VALUE}}',
 				],
 			]
 		);
		 $this->add_control(
			'view_icon',
			[
				'label' => 'ایکن دکمه خواندن',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'ایکن',
				'default' => 'prk-arrow-left',
				'description' => 'دریافت فونت ایکن از سایت .<a href="https://remixicon.com/" target="_blank">remixicon</a> یا <a href="http://parskalas.com/icon/iconpars.html" target="_blank">فونت های اختصاصی پارس کالا</a>',

			]
		);
		 $this->add_control(
			'color_view',
			[
				'label' => __( 'رنگ دکمه', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .prk-main-post-item .prk-post-item .post-item-footer a.view-more' => 'color: {{VALUE}}',
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
 						'default' => 11,
 						'selectors' => [
 							'{{WRAPPER}} .prk-main-post-item .prk-post-item' => 'border-radius: {{VALUE}}px',
 						],
 	 				]
 	 	);
		  $this->add_control(
			'grid_column_items',
			[
				'label' => esc_html__( 'تعداد آیتم سکشن', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'step' => 1,
				'max' => 5,
			   'default' => 4,
			   'selectors' => [
				   '{{WRAPPER}} .prk-main-post-item' => 'grid-template-columns: repeat({{VALUE}},1fr);',
			   ],
			]
			);
			$this->add_control(
				'grid_gap_items',
				[
					'label' => esc_html__( 'فاصله بین آیتم ها', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 1,
					'step' => 1,
					'max' => 100,
				   'default' => 32,
				   'selectors' => [
					   '{{WRAPPER}} .prk-main-post-item' => 'gap:{{VALUE}}px',
				   ],
				]
				);
		  $this->add_control(
			'custom_box_shadows',
			[
				'label' => esc_html__( 'سایه دهی آیتم', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::BOX_SHADOW,
				'default' => [
					'horizontal' => -1,
					'vertical' => 1,
					'blur' => 15,
					'spread' => 0,
					'color' => 'rgba(0, 0, 0, 0.09)',
				],
				'selectors' => [
					'{{WRAPPER}} .prk-main-post-item .prk-post-item'  => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}} ;',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'حاشیه دور آیتم', 'textdomain' ),
				'selector' => '{{WRAPPER}} .prk-main-post-item .prk-post-item',
			]
		);

 	  $this->end_controls_section();
     // پایان تب استایل
	 $this->start_controls_section(
		'hover_section_style',
		[
			'label' => esc_html__( 'هاور سکشن', 'plugin-name' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		]
	);

	 $this->add_control(
	   'custom_box_shadows_hover',
	   [
		   'label' => esc_html__( 'سایه دهی آیتم', 'textdomain' ),
		   'type' => \Elementor\Controls_Manager::BOX_SHADOW,
		   'default' => [
			   'horizontal' => -5,
			   'vertical' => 2,
			   'blur' => 13,
			   'spread' => 0,
			   'color' => 'rgba(0,0,0,.05)',
		   ],
		   'selectors' => [
			   '{{WRAPPER}} .prk-main-post-item .prk-post-item:hover'  => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}} ;',
		   ],
	   ]
   );
   $this->add_group_control(
	   \Elementor\Group_Control_Border::get_type(),
	   [
		   'name' => 'border_hover',
		   'label' => esc_html__( 'حاشیه دور آیتم', 'textdomain' ),
		   'selector' => '{{WRAPPER}} .prk-main-post-item .prk-post-item:hover',
	   ]
   );

   $this->add_control(
	'bcolor_sec_hover',
	[
		'label' => __( 'رنگ حاشیه دور', 'plugin-domain' ),
		'type' => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .prk-main-post-item .prk-post-item:hover' => 'background: linear-gradient(white,#fff) padding-box,linear-gradient(180deg,{{VALUE}} 0,#fff 100%) border-box',
		],
	]
	);

  $this->end_controls_section();




	 
	 

	}

	protected function render() {

	$settings = $this->get_settings_for_display();

	$category = $settings['category'];
    $order_post = $settings['order-post'];
    $count_post = $settings['count-post'];


	$carousel_icon = $settings['icon_title_sec'] ? '<i class="'.$settings['icon_title_sec'].'"></i>' : '';
	$carousel_text = $settings['title_sec_text'];
	$carousel_url = $settings['show_more_blog_url'];
    $arms = array(
		'post_type' => 'post',
		'posts_per_page' => $count_post,
		'post_status' => 'publish',
		'order' => $order_post,
		);
		
		if  ($category ){
		  $arms['tax_query'] =array(
			array(
				'taxonomy'  => 'category',
				'field'     => 'id',
				'terms'     => $category,
			  ),
		  );
		}

     $pd_query = new WP_Query( $arms );

		?>

        <?php if ( $pd_query ->have_posts() ) :
		
			$reading_time = get_post_meta( get_the_ID(), 'reading_time', true ) ? get_post_meta( get_the_ID(), 'reading_time', true ) : '3 دقیقه زمان مطالعه' ;

			?>

			<?php if ( $settings['show_cat_post'] == 'true' ):?>

				<div class="mcarousel_product_head flexed style1">

					<h4>
					
						<?= $carousel_icon ?>
						<?= $carousel_text ?>
					</h4>

					<?php if ( $settings['show_more_blog'] == 'true' ):?>
				    	<a class="product-item-link" href="<?php echo $carousel_url;?>"><?= $settings['show_more_blog_text'] ?><i class="ri-arrow-left-line"></i></a>
					<?php endif;?>
			
				</div>

			<?php endif;?>

			<div class="prk-main-post-item style1 style-grid">

				<?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post(); ?>

				    <?php
						$categories = get_the_category();
							if ( ! empty( $categories ) ) {
								$cate_label = '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
							}
						$avatar = get_avatar( get_the_author_meta( 'ID' ), 32 );
					?>


					<div class="prk-post-item">
				
						
							<div class="post-item-image">
								<?php prk_img_full_size();?>

								<?php if ( $settings['show_cat_post'] == 'true' ):?>
								<span class="post-item-category"><?= $cate_label ?></span>
								<?php endif;?>
							</div>

							<?php if ( $settings['show_read_content'] == 'true' ):?>
								<span class="reading-time"><i class="ri-timer-line"></i> <?= $reading_time ?></span>
							<?php endif;?>

							<?php if ( $settings['show_title'] == 'true' ):?>
								<h2 class="post-item-title">
									<a href="<?php the_permalink();?>">
										<?php the_title();?>
									</a>
								</h2>
								
							<?php endif;?>

							<?php if ( $settings['show_desc_content'] == 'true' ):?>
								<p class="post-item-content"><?php echo wp_trim_words(get_the_content(),13,'...') ;?></p>
							<?php endif;?>

							<?php if ( $settings['show_view'] == 'true' || $settings['show_author'] == 'true'  ):?>

								<div class="flexed post-item-footer">

									<?php if ( $settings['show_author'] == 'true' ):?>
										<div class="flexed">
											<?= $avatar; ?>
											<div class="flexed-clomen"> <span><?php the_author();?></span>
											<i><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) ." ". __('قبل','parskala'); ?></i>
										</div>
										</div>
									<?php endif;?>

									<?php if ( $settings['show_view'] == 'true' ):?>
										<a class="view-more" href="<?php the_permalink();?>"> <i class="<?= $settings['view_icon'] ?>"></i> </a>
									<?php endif;?>

								</div>
							<?php endif;?>
			
					</div>
					

				<?php endwhile; ?>

		

			   <?php wp_reset_postdata(); ?>

			</div>

		<?php endif;?>


   

		<?php

	}

	protected function _content_template() {}

}
