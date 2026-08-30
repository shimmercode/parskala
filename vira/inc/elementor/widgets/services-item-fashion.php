<?php

class services_item_fashoin extends \Elementor\Widget_Base {

	public function get_name() {
		return 'services_items_fashoin';
	}

	public function get_title() {
		return __( 'سرویس آیتم فشن', 'prk' );
	}

  public function get_icon() {
    return 'eicon-sitemap';
  }

  public function get_categories() {
    return [ 'prk-category' ];
  }

  protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'آیتم سرویس ها', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title', [
				'label' => esc_html__( 'عنوان آیتم', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'پارس' , 'plugin-name' ),
			]
		);

    $repeater->add_control(
      'list_des', [
        'label' => esc_html__( 'توضیح کوتاه آیتم', 'plugin-name' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'label_block' => 'true',
        'default' => esc_html__( 'پشتیبانی ۲۴ ساعته' , 'plugin-name' ),
      ]
    );

    $repeater->add_control(
      'list_icon', [
        'label' => esc_html__( 'آیکن آیتم', 'plugin-name' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'label_block' => 'true',
        'default' => esc_html__( 'ri-money-dollar-circle-fill' , 'plugin-name' ),
        'description' => 'دریافت ایکن از سایت <a href="https://remixicon.com/" target="_blank">Remixicon</a>',
      ]
    );

		$repeater->add_control(
			'list_url', [
				'label' => esc_html__( 'لینک آیتم', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '#' , 'plugin-name' ),
			]
		);

		$repeater->add_control(
			'list_backer',
			[
				'label' => esc_html__( 'رنگ پس زمینه آیتم', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'list_article',
			[
				'label' => esc_html__( 'لیست اسلاید ها', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => esc_html__( 'پارس', 'plugin-name' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'setting_sections',
			[
				'label' => esc_html__( 'پیکربندی اسلایدر ها', 'plugin-name' ),
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
							'{{WRAPPER}} .services_item' => 'border-radius: {{VALUE}}',
							],
						]
		);

    $this->end_controls_section();


	}


	protected function render() {
		$settings = $this->get_settings_for_display();
    $list_article = $settings['list_article'];

?>
  <?php if ($list_article): ?>

    <div class="services_box prk_fashon">

      <?php foreach ($list_article as $item): ?>

        <article class="services_itemer noselect  elementor-repeater-item-<?php echo esc_attr( $item['_id'] );?>">

				  <div class="flexed">
					  <div class="ld_right">
					   <i class="<?php echo $item['list_icon'];?>"></i>
	          </div>
						<div class="ld_left">
		          <h4><?php echo $item['list_title'];?></h4>
		          <span><?php echo $item['list_des'];?></span>
	        	</div>
          </div>

				</article>

      <?php endforeach; ?>

    </div>

  <?php endif; ?>


<?php
		}

}
