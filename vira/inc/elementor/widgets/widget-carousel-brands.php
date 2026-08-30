<?php

class carousel_brands_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'carousel_brands';
	}

	public function get_title() {
		return __( 'کاروسل آیتم ها', 'prk' );
	}

  public function get_icon() {
    return 'eicon-rating';
  }

  public function get_categories() {
    return [ 'prk-category' ];
  }

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'کاروسل ایتم', 'prk' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

    $this->add_control(
			'title_section', [
				'label' => __( 'عنوان آیتم', 'prk' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'برند های ویژه' , 'prk' ),
				'label_block' => true,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'حاشیه دور سکشن', 'textdomain' ),
				'selector' => '{{WRAPPER}} .right-product.brand',
			]
		);
		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'انحنای سکشن', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
			
				'selectors' => [
					'{{WRAPPER}} .right-product.brand' => 'border-radius: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);
		$this->add_control(
			'custom_box_shadow',
			[
				'label' => esc_html__( 'سایه دهی سکشن', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::BOX_SHADOW,
				'default' => [
					'horizontal' => 0,
					'vertical' => 0,
					'blur' => 0,
					'spread' => 0,
					'color' => 'rgba(0,0,0,0.0)',
				],
				'selectors' => [
					'{{WRAPPER}} .right-product.brand'  => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}} ;',
				],
			]
		);
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title_shows',
			[
				'label' => 'نمایش عنوان',
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'بله', 'your-plugin' ),
				'label_off' => __( 'خیر', 'your-plugin' ),
				'return_value' => 'true',
			]
		);
		$repeater->add_control(
			'list_title', [
				'label' => __( 'عنوان', 'prk' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'اپل آيفون' , 'prk' ),
				'label_block' => true,
				'condition' => [
					'list_title_shows' => 'true',
				],
			]
		);
		
		$this->add_control(
			'title_icon',
			[
				'label' => 'ایکن',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'ایکن',
				'default' => 'mdi mdi-watch-variant',
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

		$this->add_control(
			'list',
			[
				'label' => __( 'لیست آیتم', 'prk' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => __( 'اپل', 'prk' ),
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
			'width',
			[
				'label' => esc_html__( 'اندازه تصویر آیتم', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 65,
				],
				'selectors' => [
					'{{WRAPPER}} .item-brands' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'hide_head',
						[
						'label' => esc_html__( 'حذف عنوان سکشن', 'plugin-name' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						]
		);
		$this->end_controls_section();

	}

	protected function render() {


  	if (mobile_cheker() || tablet_cheker()) {
			$class_dev = 'carousel-item';
			$class_section = 'carousel_lister';
		}else {
			$class_dev = 'item-brands';
			$class_section = 'article-off align-center';
		}

		$settings = $this->get_settings_for_display();
		$hide_head = $settings['hide_head'];
		$settings_slider =  array(
			'loop' => $settings['loop'],
			'nav' => $settings['nav'],
			'autoplay' => $settings['autoplay'],
			'delay' => $settings['delay'],
			'item' => $settings['item'],
		);
		if ($hide_head == 'yes') {
			$classes = 'nogeneral';
		}else {
			$classes = '';
		}
		$json_settings = json_encode($settings_slider);
		
		?>

		<?php if ( $settings['list'] ):?>

      <section class="col-product item-box">

       <div class="right-product brand <?php echo $classes;?>">
         <?php if (! $hide_head == 'yes'): ?>
					 <div class="head-product">
			 		   <h3>
			 				<span class="titles-pro">
			 				<span class="<?php echo $settings['title_icon'];?> icon-carosel"></span>
			 				<span><?php echo $settings['title_section'];?></span>
			 			</span>

			 	  	</h3>
		 			</div>
				 <?php endif; ?>

            <div  class="<?php echo $class_section;?> <?= $settings['nav_style'] == 'Square' ? 'nav_Square' : ''; ?>" settings-slider='<?php echo $json_settings; ?>'>
              <?php
		         	foreach (  $settings['list'] as $item ):?>
                  <div class="<?php echo $class_dev;?>">
                <a href="<?php echo $item['list_link'];?>"><img src="<?php echo $item['list_image']['url'];?>" alt=""></a>
               <?php
			     if (!empty($item['list_title']) && $item['list_title_shows'] == 'true' ){
                    echo '<span class="brand-item-title">'.$item['list_title'].'</span>';
			     }
			   ?>

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
