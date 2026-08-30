<?php

class prk_list_sections_item_product_cat extends \Elementor\Widget_Base {

	public function get_name() {
		return 'prk_list_sections_item_pcat';
	}

	public function get_title() {
		return __( 'لیست دسته بندی های ووکامرس', 'prk' );
	}

  public function get_icon() {
    return 'eicon-product-categories';
  }

  public function get_categories() {
    return [ 'prk-category' ];
  }

  protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'آیتم ها', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'prk_show_title',
			[
				'label' => 'نمایش عنوان سکشن',
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'بله', 'your-plugin' ),
				'label_off' => __( 'خیر', 'your-plugin' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);

		$this->add_control(
			'list_title_color',
			[
				'label' => 'رنگ عنوان',
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .category-grid-item .wd-entities-title' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'label' => esc_html__( 'حاشیه دور', 'textdomain' ),
				'selector' => '{{WRAPPER}} .item-brands.category-grid-item',
			]
		);
		$this->add_control(
			'padding_item',
			[
				'label' => esc_html__( 'فاصله داخلی (padding)', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .item-brands.category-grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'انحنای آیتم ها', 'textdomain' ),
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
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .item-brands.category-grid-item' => 'border-radius: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);
		$this->add_control(
			'custom_box_shadow',
			[
				'label' => esc_html__( 'سایه دهی آیتم ها', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::BOX_SHADOW,
				'selectors' => [
					'{{WRAPPER}} .item-brands.category-grid-item'  => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}} ;',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'تایپوگرافی عنوان', 'plugin-name' ),
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}}  .category-grid-item .wd-entities-title',
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
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'   => 'section_back',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .body .right-product',
			
			]
		);
		$this->add_control(
			'section_border_radius',
			[
				'label' => esc_html__( 'انحنا دور سکشن', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'step' => 1,
			   'default' => 8,
			   'selectors' => [
				   '{{WRAPPER}} .col-product' => 'border-radius: {{VALUE}}px',
			   ],
			]
		);
		$this->add_control(
			'custom_box_shadows',
			[
				'label' => esc_html__( 'سایه دهی سکشن', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::BOX_SHADOW,
				'selectors' => [
					'{{WRAPPER}} .col-product'  => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}} ;',
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
						   'default' => 'false',
					   ]
				   );

					$this->add_control(
						'nav_style',
						[
							'label' => __( 'مدل پیکان', 'parskala' ),
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => [
								'circle' => 'دایره',
								'square' => 'مربعی',
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
						'margin_item',
						[
							'label' => esc_html__( 'فاصله بین آیتم ها', 'plugin-name' ),
							'type' => \Elementor\Controls_Manager::NUMBER,
							'min' => 1,
							'step' => 1,
							'default' => 15,
	
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

						$this->end_controls_section();
						

	}


	protected function render() {

		$settings = wp_parse_args($this->get_settings_for_display(), [
			'prk_show_title' => 'true',
			'loop'           => 'false',
			'nav'            => 'false',
			'autoplay'       => 'false',
			'delay'          => 3000,
			'item'           => 4,
			'margin_item'    => 15,
		]);

		$settings_slider = [
			'loop'     => $settings['loop'],
			'nav'      => $settings['nav'],
			'autoplay' => $settings['autoplay'],
			'delay'    => $settings['delay'],
			'item'     => $settings['item'],
			'margins'  => $settings['margin_item'],
		];

		$terms = get_terms([
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
		]);

		if (is_wp_error($terms) || empty($terms)) {
			$terms = [];
		}
	
		$json_settings = json_encode($settings_slider);
?>
<section class="col-product">

	<div class="right-product product-categoris have_back">

	    <?php if ( $settings['prk_show_title'] == 'true' ):?>
			<div class="head-product">
				<h3>
					<span class="titles-pro">
						<span>دسته بندیـــ محصولات</span>
					</span>

				</h3>
			</div>
		<?php endif;?>	

			<div class="article-off" settings-slider='<?php echo $json_settings; ?>'>

           <?php foreach ($terms as $term):

			$thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);

			?>


				<div class="item-brands category-grid-item">

					<div class="category-image-wrapp">

						<a href="<?= get_term_link($term, 'product_cat') ?>" class="category-image">
							<?php 

								if ($thumbnail_id){
									echo  wp_get_attachment_image($thumbnail_id, 'woocommerce_thumbnail', false, ['class' => 'img-fluid']);
								}
								else{
									echo prod_defualt_thumb();
								}
							?>
						</a>
							
					</div>

		            <div class="hover-mask">

						<h3 class="wd-entities-title">
							<?= $term->name ?>
						</h3>

						<div class="more-categroyis">
							<a href="<?= get_term_link($term, 'product_cat') ?>"><?= $term->count ?> محصول</a>
						</div>

					</div>

			    
				</div>
			
			<?php endforeach ?>
			
			</div>


	</div>

</section>

<?php
    }

}
