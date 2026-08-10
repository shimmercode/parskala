<?php

class sldier_3d_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'sldier_3d';
	}

	public function get_title() {
		return __( 'اسلایدر سه بعدی', 'prk' );
	}

  public function get_icon() {
    return 'eicon-image-rollover';
  }

  public function get_categories() {
    return [ 'prk-category' ];
  }

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'اسلایدر سه بعدی', 'prk' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'list_title', [
				'label' => __( 'عنوان', 'prk' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'اسلایدر اول' , 'prk' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'list_link', [
				'label' => __( 'لینک', 'prk' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '#' , 'prk' ),
			]
		);
		$repeater->add_control(
			'shape_color1',
			[
				'label' => esc_html__( 'رنگ پترن اول', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
			]
		);
		$repeater->add_control(
			'shape_color2',
			[
				'label' => esc_html__( 'رنگ پترن دوم', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
			]
		);
		$repeater->add_control(
			'list_image',
			[
				'label' => __( 'انتخاب تصویر', 'prk' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
			]
		);
		$repeater->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'large',
			]
		);
		$this->add_control(
			'list',
			[
				'label' => __( 'لیست برند', 'prk' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => __( 'کارت گرافیک', 'prk' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
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
					'default' => 'true',
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
			'dots',
					[
						'label' => esc_html__( 'نمایش نقطه ها', 'plugin-name' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'return_value' => 'true',
						'default' => 'true',
					]
        );
		$this->add_control(
			'dots_style',
					[
						'label' => esc_html__( 'طرح نقطه ها', 'plugin-name' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'return_value' => 'true',
						'default' => 'default',
						'condition' => [
							'dots' => 'true',
						],
						'options' => [
							'default' => 'پیشفرض',
							'style1' => 'سبک 1',
							'style2' => 'سبک 2',
							'style3' => 'سبک 3',
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
				'border',
				[
					'label' => esc_html__( 'انحنا دور سکشن(فقط عدد)', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 0,
					'step' => 1,
					'default' => '24',
					'selectors' => [
						'{{WRAPPER}} .slider-home-three-item .shape-2' => 'border-radius: {{VALUE}}px',
						'{{WRAPPER}} .slider-home-three-item .shape-1' => '-moz-border-radius: {{VALUE}}px',
						'{{WRAPPER}} .slider-home-three-item img' => '-webkit-border-radius: {{VALUE}}px',
					],
				]
		);

		$this->end_controls_section();

	}

	protected function render() {
    $settings = $this->get_settings_for_display();



	if ( $settings['list'] ):?>

		<div class="slider-home-three">


			<div class="slider-home-three-wrapper position-relative">



					<div class="swiper swiper-home-three <?= $settings['nav_style'] == 'Square' ? 'nav_Square' : ''; ?>">

						<div class="swiper-wrapper">

							<?php foreach (  $settings['list'] as $item ):?>

							<div class="swiper-slide elementor-repeater-item-<?php echo esc_attr( $item['_id'] );?>">
							<div class="slider-home-three-item position-relative">
								<?php if ($item['shape_color1']){
									echo '<span class="shape-1 position-absolute" style="background-color: '.$item['shape_color1'].'"></span>';
								}?>
								<?php if ($item['shape_color2']){
									echo '<span class="shape-2 position-absolute" style="background-color: '.$item['shape_color2'].'"></span>';
								}?>

								<a href="<?php echo $item['list_link'];?>">
									<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($item, 'shop_catalog', 'list_image');?>
								</a>

							   </div>

							</div>


							<?php endforeach;?>


						</div>

					<div class="swiper-button-prev"></div>
					<div class="swiper-button-next"></div>
					<div class="swiper-pagination"></div>
				</div>

			</div>


		</div>

<script>

       
function init801eea6() {
    
    // Swiper Home Three
	new Swiper(".swiper-home-three", {
		slidesPerView: 1,
		spaceBetween: 0,
		pagination: {
		el: ".swiper-pagination",
		type: "bullets",
		clickable: true,
		},
		autoplay: {
		delay: 5000,
		},
		effect: "fade",
		fadeEffect: {
		crossFade: true,
		},
		loop: true,
		navigation: {
		nextEl: ".swiper-button-next",
		prevEl: ".swiper-button-prev",
		},
	});

	}
	if (window.Swiper) {
		// Swiper library already loaded, initialize Swiper instance
		init801eea6();
	} else {
		// Swiper library not yet loaded, wait for it to load
		window.addEventListener("load", function() {
			init801eea6();
		});
	}
    

</script>


		<?php endif;?>

    <?php
	}

	protected function _content_template() {}
}
