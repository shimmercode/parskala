<?php
class image_box_post extends \Elementor\Widget_Base {


	public function get_name() {
		return 'image_posts';
	}

	public function get_title() {
		return 'باکس پست تکی';
	}

	public function get_icon() {
		return 'eicon-posts-group';
	}

	public function get_categories() {
		return [ 'prk-blog-category' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'text',
			[
				'label' => 'تصویر باکس نوشته',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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

    $posts =  get_posts([
		'post_type' => 'post',
		'post_status' => 'publish',
		'numberposts' => -1
	]);

    foreach ( $posts as $key => $post ) {
        $options[$post->ID] = $post->post_title;
    }

    $this->add_control(
        'category',
        [
            'label' => __( 'انتخاب نوشته', 'prk' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'multiple' => true,
            'options' => $options,
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
 		$this->add_control(
 			'color_title',
 			[
 				'label' => __( 'رنگ عنوان', 'plugin-domain' ),
 				'type' => \Elementor\Controls_Manager::COLOR,
 				'selectors' => [
 					'{{WRAPPER}} .prk-image-box-post .image-box-post-title a' => 'color: {{VALUE}}',
 				],
 			]
 		);

		 $this->add_control(
			'show_author',
			[
				'label' => __( 'نمایش منتشر کننده', 'parskala' ),
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
			'show_comment',
			[
				'label' => __( 'نمایش تعداد کامنت', 'parskala' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'multiple' => true,
				'label_on' => __( 'نمایش', 'parskala' ),
				'label_off' => __( 'مخفی', 'parskala' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
 		$this->add_control(
 			'color_comment',
 			[
 				'label' => __( 'رنگ تعداد کامنت', 'plugin-domain' ),
 				'type' => \Elementor\Controls_Manager::COLOR,
 				'selectors' => [
 					'{{WRAPPER}} .meta-item.comment' => 'color: {{VALUE}}',
 				],
 			]
 		);
		 $this->add_control(
			'width',
			[
				'label' => esc_html__( 'ارتفاع باکس', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'step' => 1,
						'max' => 100000,
					],

				],
				'default' => [
					'unit' => 'px',
					'size' => 220,
				],
				'selectors' => [
					'{{WRAPPER}} .prk-image-box-post' => 'height: {{SIZE}}{{UNIT}};',
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
 							'{{WRAPPER}} .prk-image-box-post' => 'border-radius: {{VALUE}}px',
 						],
 	 				]
 	 	);
		  $this->add_control(
			'custom_box_shadows',
			[
				'label' => esc_html__( 'سایه دهی باکس', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::BOX_SHADOW,
				'default' => [
					'horizontal' => -1,
					'vertical' => 1,
					'blur' => 15,
					'spread' => 0,
					'color' => 'rgba(0, 0, 0, 0.09)',
				],
				'selectors' => [
					'{{WRAPPER}} .prk-image-box-post'  => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}} ;',
				],
			]
		);
		  $this->add_control(
			'show_animations',
			[
				'label' => __( 'انیمیشن هاور', 'parskala' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'multiple' => true,
				'label_on' => __( 'فعال', 'parskala' ),
				'label_off' => __( 'غیرفعال', 'parskala' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
 	  $this->end_controls_section();
     // پایان تب استایل

	 
	 

	}

	protected function render() {
		
	$settings = $this->get_settings_for_display();

	$category = $settings['category'];

    $arms = array(
     'post_type' => 'post',
	'showposts' => 1 ,
	'post_status' => 'publish',
	'post__in' => array($category),
     );



     $pd_query = new WP_Query( $arms );

		?>

        <?php if ( $pd_query ->have_posts() ) : ?>

		
					<?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post(); ?>
				
						<div class="prk-image-box-post">
							<div class="post-content-box <?= $settings['show_animations'] ? 'have_animations' : '' ?>">

							<div class="post_tumbnail">

								<?php prk_img_full_size(); ?>
								<div class="tw-rounded-b liniear-gr"></div>
								<div class="flexed-clomen">
									<div class="flexed meta-items">
                                        <?php if ( $settings['show_author'] == 'true' ):?>
										<span class="meta-item author"><i class="ri-user-3-line"></i> <?php the_author();?></span>
                                        <?php endif;?>

										<?php if ( $settings['show_comment'] == 'true' ):?>
										<span class="meta-item comment"><i class="ri-chat-1-line"></i> <?php comments_number(); ?></span>
										<?php endif;?>
									</div>

									<?php if ( $settings['show_title'] == 'true' ):?>
										<div class="image-box-post-title">
											<a href="<?php the_permalink();?>">
											<?php the_title();?>
											</a>
										</div>
									<?php endif;?>

								</div>

							</div>
							</div>

						</div>

					<?php endwhile; ?>

			

					<?php wp_reset_postdata(); ?>


			<?php endif;?>


   

		<?php

	}

	protected function _content_template() {}

}
