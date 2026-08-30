<?php

class carousel_items_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'carousel_items';
	}

	public function get_title() {
		return __( 'کاروسل آیتم ها', 'prk' );
	}

  public function get_icon() {
    return 'eicon-animation';
  }

  public function get_categories() {
    return [ 'prk-category' ];
  }

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'کاروسل آیتم ها', 'prk' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
				 'head_carousel',
				 [
						'label' => __( 'نمایش عنوان کاروسل', 'prk' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'default' => 'yes',

				 ]
			);
    $this->add_control(
			'title_section', [
				'label' => __( 'عنوان', 'prk' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'برند های ویژه' , 'prk' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'title_icon',
			[
				'label' => ' ایکن <a href="https://materialdesignicons.com" target="_blank">دریافت ایکن از این سایت</a>',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'ایکن',
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'list_title', [
				'label' => __( 'عنوان', 'prk' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'کارت گرافیک' , 'prk' ),
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
		$this->add_control(
 			'color_back1',
 			[
 				'label' => __( 'رنگ اصلی پس زمینه', 'plugin-domain' ),
 				'type' => \Elementor\Controls_Manager::COLOR,
 				'default' => '#f0f0f1',
 				'selectors' => [
 					'{{WRAPPER}} .carousel-item' => 'background-color: {{VALUE}}',
 				],
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
		$this->add_control(
			'border_item',
						[
						'label' => esc_html__( 'انحنا دور آیتم ها', 'plugin-name' ),
						'type' => \Elementor\Controls_Manager::NUMBER,
						'min' => 1,
						'step' => 1,
						'default' => '8',
							'selectors' => [
							'{{WRAPPER}} .right-product .carousel-item' => 'border-radius: {{VALUE}}px',
							],
						]
		);
		$this->add_control(
			'border_color',
						[
						'label' => esc_html__( 'رنگ دور انحنا', 'plugin-name' ),
						'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
							'{{WRAPPER}} .right-product .carousel-item' => 'border-color: {{VALUE}}',
							],
						]
		);
		$this->end_controls_section();
	}

	protected function render() {
        $margin = 12;
		$settings = $this->get_settings_for_display();
		$settings_slider =  array(
			'loop' => $settings['loop'],
			'nav' => $settings['nav'],
			'autoplay' => $settings['autoplay'],
			'delay' => $settings['delay'],
			'item' => $settings['item'],
			'margins' => $margin,

		);
		$json_settings = json_encode($settings_slider);

		if (mobile_cheker() || tablet_cheker()) {
			$class_dev = 'verticaler';
			$class_section = 'carousel_lister';
			$json_settings = '';
		}else {
			$class_dev = '';
			$class_section = 'carousel-items';
			$json_settings = json_encode($settings_slider);
		}

		if ( $settings['list'] ):?>

      <section class="col-product <?php echo $class_dev;?>">

       <div class="right-product brand items">
        <?Php if ( $settings['head_carousel'] ):?>
				 <div class="head-product">
	 			<h3>
	 				<span class="titles-pro">
	 				<span class="<?php echo $settings['title_icon'];?> icon-carosel"></span>
	 				<span><?php echo $settings['title_section'];?></span>
	 			</span>
	 		</h3>
	 			</div>
			<?php endif;?>
          <div  class="<?php echo $class_section;?>" settings-slider='<?php echo $json_settings; ?>'>
            <?php
	         	foreach (  $settings['list'] as $item ):?>
                <div class="carousel-item">
              <a href="<?php echo $item['list_link'];?>"><img src="<?php echo $item['list_image']['url'];?>" alt="">
              <span class="title-item"><?php echo $item['list_title'];?></span>
							</a>

                </div>
		        <?php endforeach;?>
          </div>

       </div>
    </section>

		<?php endif;?>

    <?php
	}

	protected function _content_template() {}
}
