<?php

class repeater_services_item extends \Elementor\Widget_Base {

	public function get_name() {
		return 'repeater_services_items';
	}

	public function get_title() {
		return __( 'آیتم خدمات', 'prk' );
	}

  public function get_icon() {
    return 'eicon-navigation-horizontal';
  }

  public function get_categories() {
    return [ 'prk-category' ];
  }

  protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'خدمات', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title', [
				'label' => esc_html__( 'عنوان آیتم', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'پارس پی' , 'plugin-name' ),
			]
		);


    $repeater->add_control(
			'list_url', [
				'label' => esc_html__( 'لینک آیتم', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '#' , 'plugin-name' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_color',
			[
				'label' => esc_html__( 'رنگ پس زمینه آیتم', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#F2166D',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}'
				],
			]
		);

		$img_carousel = get_parent_theme_file_uri('/assets/img/ser-item.png' );
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

		$this->add_control(
			'list',
			[
				'label' => esc_html__( 'لیست سرویس ها', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => esc_html__( 'پارس پی', 'plugin-name' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'setting_sections',
			[
				'label' => esc_html__( 'پیکربندی آیتم ها', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
    $this->add_control(
      'list_more', [
        'label' => esc_html__( 'فعال سازی آیتم های بیشتر', 'plugin-name' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'default' => 'yes',
      ]
    );
    $this->add_control(
      'list_urlـmore', [
        'label' => esc_html__( 'لینک آیتم های بیشتر', 'plugin-name' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__( '#' , 'plugin-name' ),
        'label_block' => true,
      ]
    );
  	$this->add_control(
  		'border_carousel',
  					[
  					'label' => esc_html__( 'انحنا دور سکشن', 'plugin-name' ),
  					'type' => \Elementor\Controls_Manager::TEXT,
  					'default' => '11px',
  						'selectors' => [
  						'{{WRAPPER}} .services-items .item_90s' => 'border-radius: {{VALUE}}',
  						],
  					]
  	);

    $this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

?>

		<?Php if ( $settings['list'] ):
      $counter = 0;
      $list_more = $settings['list_more'];
      $list_urlـmore = $settings['list_urlـmore'];

      if ($list_more == 'yes'){
        $columns = '8';
      }else {
        $columns = '7';
      }
      ?>

			<div class="services-items" style="display: grid;grid-template-columns: repeat(<?php echo $columns;?>, 1fr);">

       <!-- آیتم های بنر -->
       <?php foreach ( $settings['list'] as $item):$counter ++;?>

         <div conut="<?php echo $counter;?>" class="ser-item">

           <div class="item_90s elementor-repeater-item-<?php echo esc_attr( $item['_id'] );?>">

             <div class="img-services">
              <img src="<?php echo $item['list_img']['url'];?>">
             </div>

              <div class="title-services">
                <a href="<?php echo $item['list_url'];?>">
                 <h4><?php echo $item['list_title'];?></h4>
                </a>
              </div>

            </div>

         </div>
        <?php

        if ( $list_more && $counter == 7 ) {

          echo '<a href="'.$list_urlـmore.'">
          <div class="ser-item load_more"><span><i>.</i><i>.</i><i>.</i><em>بیشتر مشاهده کنید</em></span></div>
          </a>';
          break;
        }

        ?>

       <?php endforeach; ?>

      </div>

    <?php endif;?>

<?php
		}

}
