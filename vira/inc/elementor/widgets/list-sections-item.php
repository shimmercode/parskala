<?php

class prk_list_sections_item extends \Elementor\Widget_Base {

	public function get_name() {
		return 'prk_list_sections_item';
	}

	public function get_title() {
		return __( 'لیست آیتم2', 'prk' );
	}

  public function get_icon() {
    return 'eicon-photo-library';
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

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title', [
				'label' => esc_html__( 'عنوان', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'لباس ورزشی' , 'plugin-name' ),
			]
		);

		$repeater->add_control(
			'list_title_color',
			[
				'label' => 'رنگ عنوان',
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .prk_listing_item .listing_item_texts span.listing_title' => 'color: {{VALUE}} !important',
				],
			]
		);

		$repeater->add_control(
			'list_title_en', [
				'label' => esc_html__( 'عنوان انگلیسی', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'jogging suit' , 'plugin-name' ),
			]
		);

		$repeater->add_control(
			'list_title_color_en',
			[
				'label' => 'رنگ عنوان انگلیسی',
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .prk_listing_item .listing_item_texts span.listing_title_en' => 'color: {{VALUE}} !important',
				],
			]
		);

		$img_item = get_parent_theme_file_uri('/assets/img/list-item-prk.png' );
		$repeater->add_control(
				'list_img_item',
				[
					'label' => esc_html__( 'تصویر آیتم', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
							'url' => $img_item,
						],
				]
		);
		// $img_cat_bg = get_parent_theme_file_uri('/assets/img/cat-hero-bg.jpg' );

		$repeater->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => esc_html__( 'پس زمینه آیتم', 'plugin-name' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .listing_item{{CURRENT_ITEM}}',

			]
		);
		$repeater->add_control(
			'list_item_color',
			[
			'label' => esc_html__( 'رنگ پس زمینه هاور آیتم', 'plugin-name' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'default' => '#f7a351',
				'selectors' => [
					'{{WRAPPER}} .listing_item{{CURRENT_ITEM}}:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'ani_list_bg',
			[
				'label' => __( 'فعال سازی انیمیشن', 'parskala' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'روشن', 'parskala' ),
				'label_off' => __( 'خاموش', 'parskala' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$repeater->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'تایپوگرافی عنوان', 'plugin-name' ),
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .listing_item{{CURRENT_ITEM}} .listing_title',
			]
		);
		$repeater->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'تایپوگرافی عنوان انگلیسی', 'plugin-name' ),
				'name' => 'content_typography_en',
				'selector' => '{{WRAPPER}} .listing_item{{CURRENT_ITEM}} .listing_title_en',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'حاشیه دور', 'textdomain' ),
				'selector' => '{{WRAPPER}} .prk_listing_item .listing_item',
			]
		);
		$this->add_control(
			'padding_item',
			[
				'label' => esc_html__( 'فاصله داخلی (padding)', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .prk_listing_item .listing_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .prk_listing_item .listing_item' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'custom_box_shadow',
			[
				'label' => esc_html__( 'سایه دهی آیتم ها', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::BOX_SHADOW,
				'selectors' => [
					'{{SELECTOR}} .prk_listing_item .listing_item'  => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
				],
			]
		);
		$repeater->add_control(
			'list_url', [
				'label' => esc_html__( 'لینک آیتم', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '#' , 'plugin-name' ),
			]
		);
		$this->add_control(
			'list_article',
			[
				'label' => esc_html__( 'لیست آیتم ها', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => esc_html__( 'لباس ورزشی', 'plugin-name' ),
						'list_title_en' => esc_html__( 'jogging suit', 'plugin-name' ),

					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->end_controls_section();

		// $this->start_controls_section(
		// 	'setting_sections',
		// 	[
		// 		'label' => esc_html__( 'پیکربندی اسلایدر ها', 'plugin-name' ),
		// 		'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
		// 	]
		// );

		// $this->add_control(
		// 	'auto_played',
		// 	[
		// 		'label' => esc_html__( 'پخش اتوماتیک', 'plugin-name' ),
		// 		'description' => esc_html__( 'پخش اتوماتیک اسلایدها', 'plugin-name' ),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'return_value' => 'yes',
		// 		'default' => 'true',
		// 	]
		// );

    // $this->end_controls_section();

	// // شروع تب استایل
	// $this->start_controls_section(
	// 	'section_style',
	// 	[
	// 		'label' => esc_html__( 'استایل آیتم', 'plugin-name' ),
	// 		'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	// 	]
	// );

	// $this->add_control(
	// 	'color_title',
	// 	[
	// 		'label' => __( 'رنگ عنوان باکس', 'plugin-domain' ),
	// 		'type' => \Elementor\Controls_Manager::COLOR,
	// 		'default' => '#162C5B',
	// 		'selectors' => [
	// 			'{{WRAPPER}} .article_mobile_box .prk-data-box-icon p' => 'color: {{VALUE}}',
	// 		],
	// 	]
	// );

	// $this->add_control(
	// 	'color_subtitle',
	// 	[
	// 		'label' => __( 'رنگ توضیحات باکس', 'plugin-domain' ),
	// 		'type' => \Elementor\Controls_Manager::COLOR,
	// 		'default' => '#8995A6',
	// 		'selectors' => [
	// 			'{{WRAPPER}} .article_mobile_box .prk-data-box-icon span' => 'color: {{VALUE}}',
	// 		],
	// 	]
	// );


	// $this->end_controls_section();
	// // پایان تب استایل

	}


	protected function render() {
		$img_item = get_parent_theme_file_uri('/assets/img/list-item-prk.png' );
		$settings = $this->get_settings_for_display();
        $ani_list_bg = '';
?>
		<?Php if ( $settings['list_article'] ):?>

			<div class="prk_listing_grid__items">
				<?php foreach (  $settings['list_article'] as $item ):
                    
					if( isset( $item['ani_list_bg'] ) )
					$ani_list_bg = $item['ani_list_bg'] == 'yes' ? 'animations_item' : '';
					?>

					

						<div class="prk_listing_item">
						<a href="<?= $item['list_url']?>">

							<section class="listing_item <?= $ani_list_bg?> elementor-repeater-item-<?php echo esc_attr( $item['_id'] );?>">
								<div class="listing_item_img">
									<div class="listing_item_icon">
									   <svg xmlns="http://www.w3.org/2000/svg" width="43" height="39" viewBox="0 0 43 39" fill="none"><path d="M13.558 35.134C18.6585 36.8806 22.9449 39.1458 26.9847 38.6069C31.0089 38.1103 34.7999 34.8387 37.8988 30.8334C41.0111 26.857 43.4891 22.1202 42.7519 18.0319C42.0012 13.9147 38.0507 10.4036 34.3058 7.18383C30.532 3.97752 26.9213 1.0471 23.0801 0.649967C19.1964 0.237337 15.0822 2.35801 11.8336 5.13173C8.62739 7.92096 6.32927 11.3787 3.94634 15.7901C1.5479 20.2439 -0.906425 25.6378 0.824829 28.9131C2.54058 32.2308 8.44191 33.4298 13.558 35.134Z" fill="#EBEBEB"></path></svg>
									</div>
								    <img width="45" height="45" src="<?= $item['list_img_item']['url'] ?>" alt="cat5" decoding="async" loading="eager">
								</div>

								<div class="listing_item_texts">
									<span class="listing_title"><?= $item['list_title'] ?></span>
									<span class="listing_title_en"><?= $item['list_title_en'] ?></span>
								</div>

							</section>
						</a>

						</div>

					

				<?php endforeach;?>
				</div>

        <?php endif;?>

<?php
    }

}
