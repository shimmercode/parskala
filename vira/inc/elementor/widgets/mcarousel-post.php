<?php
class mcarousel_post extends \Elementor\Widget_Base {


	public function get_name() {
		return 'mcarousel_posts';
	}

	public function get_title() {
		return 'کاروسل نوشته ها مدرن';
	}

	public function get_icon() {
		return 'eicon-posts-group';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'text',
			[
				'label' => 'کاروسل نوشته ها',
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
        'default' => __( 'آخرین های وبلاگ' , 'prk' ),
			]
		);
		$this->add_control(
			'carousel_icon',
			[
				'label' => 'ایکن',
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
        'carousel_url',
        [
            'label' => __( 'لینک دسته', 'plugin-domain' ),
            'type' => \Elementor\Controls_Manager::URL,
            'multiple' => true,
    				'default' => [
    		        'url' => '#',
    					],
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
 			'color_back',
 			[
 				'label' => __( 'رنگ اصلی پس زمینه', 'plugin-domain' ),
 				'type' => \Elementor\Controls_Manager::COLOR,
 				'selectors' => [
 					'{{WRAPPER}} .mcarousel_product' => 'background-color: {{VALUE}}',
 				],
 			]
 		);
    $this->add_control(
 			'color_back_item',
 			[
 				'label' => __( 'رنگ پس زمینه آیتم ها', 'plugin-domain' ),
 				'type' => \Elementor\Controls_Manager::COLOR,
 				'selectors' => [
 					'{{WRAPPER}} .mcarousel_product.modern_blog .post-content' => 'background-color: {{VALUE}}',
 				],
 			]
 		);
    $this->add_control(
      'color_titles',
      [
        'label' => __( 'رنگ عناوین', 'plugin-domain' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .mcarousel_product .mcarousel_product_head h4' => 'color: {{VALUE}}',
          '{{WRAPPER}} .mcarousel_product .mcarousel_product_head a' => 'color: {{VALUE}}',
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
 							'{{WRAPPER}} .mcarousel_product' => 'border-radius: {{VALUE}}px',
 						],
 	 				]
 	 	);
		  $this->add_control(
			'sec_style',
			[
				'label' => __( 'سبک سکشن نوشته ها', 'parskala' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => true,
				'options' => [
					'defualt' => 'دایره',
					'imager' => 'مربعی',
				],
				'default' => 'defualt',

			]
		);
 	  $this->end_controls_section();
     // پایان تب استایل

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
		'nav_style',
		[
			'label' => __( 'مدل پیکان', 'parskala' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'multiple' => true,
			'options' => [
				'circle' => 'دایره',
				'Square' => 'مربعی',
			],
			'default' => 'circle',
			'condition' => [
				'nav' => 'true',
			],
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
      'item_moboile',
      		[
      			'label' => esc_html__( 'تعداد ایتم ها در موبایل', 'plugin-name' ),
      			'type' => \Elementor\Controls_Manager::NUMBER,
      			'min' => 3,
      			'max' => 8,
      			'step' => 1,
      			'default' => 4,
      		]
    );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
    $carousel_title = $settings['carousel_title'];
    $carousel_icon = $settings['carousel_icon'];
		$carousel_url = $settings['carousel_url']['url'];
    $nav = $settings['nav'];
		$settings_slider =  array(
			'loop' => $settings['loop'],

			'autoplay' => $settings['autoplay'],
			'delay' => $settings['delay'],
			'item' => $settings['item'],
		);
		$json_settings = json_encode($settings_slider);

    $order_post = $settings['order-post'];
    $count_post = $settings['count-post'];
    $category =   $settings['category'];

    if ( isset($settings['color_back']) ) {
		$color_back = $settings['color_back'];
	} else {
		$color_back = ''; // مقدار پیش‌فرض یا مقدار مناسب دیگر
	}

	$sec_style =  $settings['sec_style'];

    if ($color_back) {
      $classes = 'carusel_padding';
    }else {
      $classes = '';
    }
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

    <section class="mcarousel_product modern_blog <?php echo $classes;?> <?= $settings['nav_style'] == 'Square' ? 'nav_Square' : ''; ?>">

      <div class="mcarousel_product_head">

        <h4>
          <?php if ($carousel_icon){
          echo '<i class="'.$carousel_icon.'"></i>';
          }?>
          <?php echo $carousel_title;?>
        </h4>
        <a class="product-item-link" href="<?php echo $carousel_url;?>">مشاهده بیشتر<i class="ri-arrow-left-line"></i></a>
      </div>

        <?php if ( $pd_query ->have_posts() ) : ?>

			<?php if ( $sec_style == 'defualt' ) : ?>
				<div class="swiper post-carousel-swiper-slider ">
				<div class="swiper-wrapper">

					<?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post(); ?>
					<div class="swiper-slide">
						<article  class="post-content">
						<a href="<?php the_permalink();?>">

						<div class="post_tumbnail">

							<?php prk_po_img(); ?>

						</div>

						<div class="post_title">

							<?php the_title();?>

						</div>

						</a>
						</article>
					</div>
					<?php endwhile; ?>

					<?php wp_reset_postdata(); ?>

				</div>
				<?php if ($nav): ?>
				<!-- If we need navigation buttons -->
				<div class="swiper-button-prev mpostcarusel_nav"></div>
				<div class="swiper-button-next mpostcarusel_nav"></div>
				<?php endif; ?>
				</div>
			<?php else :?>

				<div class="swiper post-carousel-swiper-slider box-imager">
				<div class="swiper-wrapper">

					<?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post(); ?>
					<div class="swiper-slide">
						<article  class="post-content-box have_animations">
							<a href="<?php the_permalink();?>">
								<div class="post_tumbnail">
									<?php prk_po_img(); ?>
									<div class="tw-rounded-b liniear-gr"></div>
									<div class="post_title"><?php the_title();?></div>
								</div>
							</a>
						</article>
					</div>
					<?php endwhile; ?>

					<?php wp_reset_postdata(); ?>

				</div>
				<?php if ($nav): ?>
				<!-- If we need navigation buttons -->
				<div class="swiper-button-prev mpostcarusel_nav"></div>
				<div class="swiper-button-next mpostcarusel_nav"></div>
				<?php endif; ?>
				</div>

			<?php endif;?>

        <?php endif;?>

    </section>

		<?php

	}

	protected function _content_template() {}

}
