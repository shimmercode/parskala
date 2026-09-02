<?php

class dynamic_banner extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dynamic_banners';
	}

	public function get_title() {
		return __( 'بنر پویا', 'prk' );
	}

  public function get_icon() {
    return 'eicon-banner';
  }

  public function get_categories() {
    return [ 'prk-category' ];
  }

  protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'بنرها', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title', [
				'label' => esc_html__( 'عنوان بنر', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'ساعت هوشمند' , 'plugin-name' ),
			]
		);

		$repeater->add_control(
			'list_des', [
				'label' => esc_html__( 'توضیح بنر', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'اپل واچ سری هشت' , 'plugin-name' ),
				'label_block' => true,
			]
		);

    $repeater->add_control(
			'list_url', [
				'label' => esc_html__( 'لینک بنر', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '#' , 'plugin-name' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_color',
			[
				'label' => esc_html__( 'رنگ پس زمینه بنر', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#8E1CD3',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background: radial-gradient(198.62% 757.52% at 100% 50%, {{VALUE}} 29.21%, rgba(142, 28, 211, 0) 100%)'
				],
			]
		);

		$img_carousel = get_parent_theme_file_uri('/assets/img/applewach.png' );
		$repeater->add_control(
			'list_img',
			[
				'label' => esc_html__( 'تصویر بنر', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
						'url' => $img_carousel,
					],
			]
		);

		$this->add_control(
			'list',
			[
				'label' => esc_html__( 'لیست بنر ها', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => esc_html__( 'ساعت هوشمند', 'plugin-name' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'setting_sections',
			[
				'label' => esc_html__( 'پیکربندی بنرها', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
  	$this->add_control(
  		'border_carousel',
  					[
  					'label' => esc_html__( 'انحنا دور سکشن', 'plugin-name' ),
  					'type' => \Elementor\Controls_Manager::TEXT,
  					'default' => '11px',
  						'selectors' => [
  						'{{WRAPPER}} .daynamic_banner .daynamic_banner_item' => 'border-radius: {{VALUE}}',
  						],
  					]
  	);

    $this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

?>

		<?Php if ( $settings['list'] ):?>

			<div class="daynamic_banner">

       <!-- آیتم های بنر -->
       <?php foreach ( $settings['list'] as $item): ?>

         <div class="daynamic_banner_item elementor-repeater-item-<?php echo esc_attr( $item['_id'] );?>">

            <div class="dbanner_right">
             <h4><?php echo $item['list_title'];?></h4>
             <span><?php echo $item['list_des'];?></span>
             <a class="product-item-link" href="<?php echo $item['list_url'];?>">خرید<i class="ri-arrow-left-line"></i></a>
            </div>

            <div class="dbanner_left swiper_produt">

              <div class="img-banner">

               <img src="<?php echo $item['list_img']['url'];?>">
              </div>

            </div>

         </div>

       <?php endforeach; ?>

      </div>

    <?php endif;?>

<?php
		}

}
