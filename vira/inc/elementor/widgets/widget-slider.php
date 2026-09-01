<?php

class sldiers_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'sldiers';
	}

	public function get_title() {
		return __( 'اسلایدر اختصاصی', 'prk' );
	}

  public function get_icon() {
    return 'eicon-hotspot';
  }

  public function get_categories() {
    return [ 'prk-category' ];
  }

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'اسلایدر اختصاصی', 'prk' ),
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
					'default' => '8',
					'selectors' => [
						'{{WRAPPER}} .slider-right.ver1 img' => 'border-radius: {{VALUE}}px',
						'{{WRAPPER}} .slider-right.ver1' => '-moz-border-radius: {{VALUE}}px',
						'{{WRAPPER}} .slider-right.ver1' => '-webkit-border-radius: {{VALUE}}px',
					],
				]
		);

		$this->end_controls_section();

	}

	protected function render() {
    $settings = $this->get_settings_for_display();




	$settings_slider =  array(
		'loop' => $settings['loop'] ? $settings['loop'] : 'false',
		'nav' => $settings['nav'] ? $settings['nav'] : 'false',
		'dots' => $settings['dots'] ? $settings['dots'] : 'false',
	    'autoplay' => $settings['autoplay'] ? $settings['autoplay'] : 'false',
		'delay' => $settings['delay'] ? $settings['delay'] : 'false',
	);
	$json_settings = json_encode($settings_slider);



		if ( $settings['list'] ):?>

     <div class="main-slider-box">


      <div class="slider-right ver1 <?=  $settings['dots_style'] ?>">



            <div class="slide-carousel <?= $settings['nav_style'] == 'Square' ? 'nav_Square' : ''; ?>" settings-slider='<?php echo $json_settings;?>'>
	
              <?php foreach (  $settings['list'] as $item ): ?>

                <div class="slide-pre">

									<a href="<?php echo $item['list_link'];?>">
										<?php	echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($item, 'shop_catalog', 'list_image');?>
								  </a>

				</div>


              <?php endforeach;?>



          </div>

       </div>

       <?php if ( $settings['dots_style'] == 'style2' ):?>

		<div class="victor-style2">
				<svg xmlns="http://www.w3.org/2000/svg" width="231" height="75" viewBox="0 0 231 75" fill="none">
					<path clip-rule="evenodd" d="M0 0C31.5006 0.949537 50.52 17.872 56.1955 26.4544L55.986 25.8011L82.4924 58.631C99.3032 79.4521 131.038 79.4521 147.849 58.6309L174.356 25.8011L174.146 26.4544C179.822 17.872 198.844 0.949537 230.349 0H0Z"></path>
				</svg>
		</div>

		<?php endif; ?>

		<?php if ( $settings['dots_style'] == 'style3' ):?>

			<div class="victor-style3">
				<svg xmlns="http://www.w3.org/2000/svg" width="167" height="48" viewBox="0 0 167 48" fill="none"><path d="M9.45585 0C4.50967 0 0.5 4.00967 0.5 8.95585C0.5 13.0893 3.3288 16.6858 7.34586 17.6596L10.289 18.3731C14.4779 19.3886 17.875 22.4432 19.3282 26.5011L23.4667 38.0573C25.6024 44.0208 31.254 48 37.5885 48L132.494 48C138.942 48 144.668 43.8795 146.717 37.7659L149.9 28.268C151.236 24.2785 154.205 21.0445 158.066 19.3716L161.363 17.9425C164.785 16.4597 167 13.0864 167 9.35697C167 4.18926 162.811 0 157.643 0L9.45585 0Z" fill="white"></path></svg>
			</div>

		<?php endif; ?>

		</div>




		<?php endif;?>

    <?php
	}

	protected function _content_template() {}
}
