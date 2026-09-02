<?php

class item_category extends \Elementor\Widget_Base {

	public function get_name() {
		return 'item_categorys';
	}

	public function get_title() {
		return __( 'آیتم دسته بندی ها', 'prk' );
	}

  public function get_icon() {
    return 'eicon-gallery-grid';
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
				'label' => esc_html__( 'عنوان آیتم', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'کالای دیجیتال' , 'plugin-name' ),
			]
		);

    $img_carousel = get_parent_theme_file_uri('/assets/img/1-cat.png' );
    $repeater->add_control(
			'list_img',
			[
				'label' => esc_html__( 'تصویر آیتم', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
						'url' => $img_carousel,
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
			'lists_title',
			[
				'label' => esc_html__( 'عنوان سکشن', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'دسته بندی های پارس کالا',
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
						'list_title' => esc_html__( 'کالای دیجیتال', 'plugin-name' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->end_controls_section();

    $this->start_controls_section(
		 'slider_special',
		 [
			 'label' => 'پیکربندی آیتم',
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
      						'{{WRAPPER}} .categorys_item article' => 'border-radius: {{VALUE}}',
      						],
      					]
      	);

				$this->add_control(
		 			'color_back1',
		 			[
		 				'label' => __( 'رنگ اصلی پس زمینه', 'plugin-domain' ),
		 				'type' => \Elementor\Controls_Manager::COLOR,
		 				'selectors' => [
		 					'{{WRAPPER}} .categorys_item article' => 'background-color: {{VALUE}}',
		 				],
		 			]
		 		);

		$this->end_controls_section();
	}


	protected function render() {
		$settings = $this->get_settings_for_display();
    $list_article = $settings['list_article'];
    $lists_title = $settings['lists_title'];

		if (mobile_cheker() || tablet_cheker()) {
			$class_dev = 'verticaler';
			$class_section = 'carousel_lister';
		}else {
			$class_dev = '';
			$class_section = '';
		}

?>
  <?php if ($list_article): ?>

  <section class="promotion-categories <?php echo $class_dev;?>">
		<div class="head-product">
	 		<h3>
		 		<span class="titles-pro">
	        <span><?php echo $lists_title;?></span>
		 		</span>
			</h3>
	 	</div>
    <div class="categorys_item <?php echo $class_section;?>">
      <?php foreach ($list_article as $item): ?>

        <article class="promotion_term elementor-repeater-item-<?php echo esc_attr( $item['_id'] );?>">

          <a href="<?php echo $item['list_url'];?>">

            <img class="promotion_img" src="<?php echo $item['list_img']['url'];?>" alt="promotion-categories">
			<h4 class="promotion_name <?php echo (!empty($item['list_backer']) ? 'white_color' : ''); ?>">
			<?php echo esc_html($item['list_title'] ?? ''); ?>
			</h4>
          </a>

        </article>

      <?php endforeach; ?>

    </div>

  </section>

  <?php endif; ?>


<?php
		}

}
