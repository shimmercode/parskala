<?php

class mobile_grad_category extends \Elementor\Widget_Base {

	public function get_name() {
		return 'grad_category ';
	}

	public function get_title() {
		return __( 'دسته بندی موبایل', 'prk' );
	}

  public function get_icon() {
    return 'eicon-handle';
  }

  public function get_categories() {
    return [ 'prk-mobile-category' ];
  }

  protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'دسته ها', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title', [
				'label' => esc_html__( 'عنوان', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'تبلت' , 'plugin-name' ),
			]
		);


		$img_carousel = get_parent_theme_file_uri('/assets/img/ipad3.png' );
    $repeater->add_control(
			'list_img',
			[
				'label' => esc_html__( 'تصویر ایکن', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
						'url' => $img_carousel,
					],
			]
		);

		$repeater->add_control(
			'list_url', [
				'label' => esc_html__( 'لینک دسته', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '#' , 'plugin-name' ),
			]
		);

		$this->add_control(
			'list_article',
			[
				'label' => esc_html__( 'لیست دسته ها', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => esc_html__( 'تبلت', 'plugin-name' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->end_controls_section();


	}


	protected function render() {
		$settings = $this->get_settings_for_display();
		$auto_played = !empty($settings['auto_played']) ? $settings['auto_played']:'';

?>
		<?Php if ( $settings['list_article'] ):?>


			<div class="prk-grad-category">
       <p>دسته بندی محصولات</p>
				<div class="prk-mobile-categories">

					<?php foreach (  $settings['list_article'] as $item ):?>

            <div class="elementor-repeater-item-<?php echo esc_attr( $item['_id'] );?>">
							<a href="<?php echo $item['list_url'];?>">
              <span>
              <img class="" src="<?php echo $item['list_img']['url'];?>" alt="box-category">
							</span>

							<h6><?php echo $item['list_title'];?></h6>
							</a>
            </div>

					<?php endforeach;?>

				</div>


			</div>



    <?php endif;?>

<?php
		}

}
