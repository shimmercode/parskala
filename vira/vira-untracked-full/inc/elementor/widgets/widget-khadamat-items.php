<?php

class khadamat_items_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'khadamat_items';
	}

	public function get_title() {
		return __( 'خدمات', 'prk' );
	}

  public function get_icon() {
    return 'eicon-star';
  }

  public function get_categories() {
    return [ 'prk-category' ];
  }

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'خدمات', 'prk' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'list_title', [
				'label' => __( 'عنوان', 'prk' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'بهترین قالب فروشگاهی' , 'prk' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'list_desc', [
				'label' => __( 'توضیحات کوتاه', 'prk' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'معتبرترین قالب ووکامرس - وردپرس در ایران' , 'prk' ),
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

		$this->add_control(
			'list',
			[
				'label' => esc_html__( 'لیست خدمات', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => esc_html__( 'خدمات جدید', 'plugin-name' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
		 'slider_special',
		 [
			 'label' => 'پیکربندی باکس',
			 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
							'{{WRAPPER}} ul.khadamat' => 'border-radius: {{VALUE}}px',
							],
						]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( $settings['list'] ):?>
      <ul class="khadamat">
				<?php foreach (  $settings['list'] as $item ):?>
					<li class="item_khadamat">
            <a href="<?= $item['list_link']?>"><img src="<?= $item['list_image']['url']?>"></a>
            <div class="intro-service-landing__text">
	            <h3 class="link" ><?= $item['list_title']?></h3>
	            <span class="link"><?= $item['list_desc']?></span>
					  </div>
					 </li>
	      <?php endforeach;?>
      </ul>
		 <?php endif;?>

    <?php
	}

	protected function _content_template() {}
}
