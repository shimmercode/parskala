<?php

class categorys_list_item extends \Elementor\Widget_Base {

	public function get_name() {
		return 'categorys_list';
	}

	public function get_title() {
		return __( 'دسته های ویژه', 'prk' );
	}


  	public function get_icon() {
  		return 'eicon-icon-box';
  	}

  	public function get_categories() {
  		return [ 'prk-category' ];
  	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'ویرایش دسته ها', 'prk' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

    $this->add_control(
      'categorys_title', [
        'label' => __( 'عنوان', 'prk' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' =>  'بیش از ۴،۰۰۰،۰۰۰ کالا در دسته‌بندی‌های مختلف',
      ]
    );

    $repeater->add_control(
      'list_link2', [
        'label' => __( 'لینک', 'prk' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __( '#' , 'prk' ),
      ]
    );

    $repeater->add_control(
			'list_icon', [
				'label' => __( 'ایکن', 'prk' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'far fa-laptop' , 'prk' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_title', [
				'label' => __( 'عنوان', 'prk' ),
         'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'کالای دیجیتال' , 'prk' ),
				'label_block' => true,
			]
		);

    $repeater->add_control(
      'list_count',[
        'label' => __( 'تعداد محصولات', 'prk' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 1,
        'max' => 10000,
        'step' => 1,
        'default' => 99,
      ]
    );

		$this->add_control(
			'list',
			[
				'label' => __( 'لیست دسته', 'prk' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => __( 'Title #1', 'prk' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
        'list_count' => '{{{ list_count }}}',
			]
		);
		$this->add_control(
			'colors',
			[
				'label' => __( 'رنگ جامع', 'PRK' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ef394e',
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
							'{{WRAPPER}} .back-cat' => 'border-radius: {{VALUE}}px',
							],
						]
		);
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( $settings['list'] ):?>
		 <section class="category-pro">
       <div class="back-cat">
      <div class="s-center">
      <h3>
				<span class="head-cat"><?php echo $settings['categorys_title'];?></span>
			</h3>

       <div class="sec-cat">
      <?php foreach (  $settings['list'] as $item ):?>
      <article class="item-cat">
        <a href="<?php echo $item['list_link2'];?>">
        <i  class="<?php echo $item['list_icon'];?>"></i>
        <span class="title-cat"><?php echo $item['list_title'];?></span>
        <span  class="promotion-cat">+ <?php echo $item['list_count'];?><?php _e('kala' , 'parskala');?></span>
        </a>
      </article>
			<?php endforeach;?>
      </div>
      </div>
      </div>
    </section>

    <?php endif;?>
<?php
	}
    protected function _content_template() {}

  }
