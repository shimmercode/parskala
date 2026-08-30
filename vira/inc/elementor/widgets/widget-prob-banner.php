<?php
class promo_banner_Widget extends \Elementor\Widget_Base {


	public function get_name() {
		return 'promo-banner';
	}

	public function get_title() {
		return 'تصویر بنر باکس';
	}

	public function get_icon() {
		return 'eicon-image-box';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'text',
			[
				'label' => 'تصویر باکس prk',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			's-link',
			[
				'label' => __( 'لینک بنر ', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'multiple' => true,
						'default' => [
						'url' => '#',
						'is_external' => true,
						'nofollow' => true,
				],
			]
		);

		$this->add_control(
				's-image',
				[
					'label' => __( 'انتخاب عکس', 'plugin-domain' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
				]
		);

		$this->add_control(
			's-text',
			[
				'label' => __( 'عنوان', 'parskala' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'عنوان باکس', 'parskala' ),

			]
		);

		$this->add_control(
			'height',
			[
				'label' => esc_html__( 'height', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 370,
				],
				'selectors' => [
					'{{WRAPPER}} .banner-image' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'text_back',
			[
				'label' => esc_html__( 'رنگ پس زمینه عنوان', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => __( '#b8997a' ),
				'selectors' => [
					'{{WRAPPER}} .promo-banner .wrapper-content-banner' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'رنگ عنوان', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => __( '#fff' ),
				'selectors' => [
					'{{WRAPPER}} .promo-banner .banner-title' => 'color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

        $promo_text = $settings['s-text'];
		$promo_image = $settings['s-image']['url'];
		$promo_link = $settings['s-link']['url'];
		?>
        <div class="promo-banner-wrapper">
          
		<div class="promo-banner banner-hover-zoom">
			<a href="<?php echo $promo_link?>">
				<div class="main-wrapp-img">
					<div class="banner-image lazyloaded" style="background-image: url(&quot;<?php echo $promo_image?>&quot;);" data-back="<?php echo $promo_image?>"></div>
				</div>

				<div class="wrapper-content-banner wd-fill wd-items-bottom wd-justify-right">
					<div class="content-banner text-center">
						<div class="banner-title-wrap banner-title-default">
							<h2 class="banner-title wd-fontsize-l" data-elementor-setting-key="title"><?php echo $promo_text?></h2>
						</div>
					</div>
				</div>
			</a>
		</div>

		</div>
		<?php

	}

	protected function _content_template() {}

}
