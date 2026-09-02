<?php

class swip_article_slider extends \Elementor\Widget_Base {

	public function get_name() {
		return 'article_slider';
	}

	public function get_title() {
		return __( 'اسلایدر تصاویر موبایل', 'prk' );
	}

  public function get_icon() {
    return 'eicon-slider-3d';
  }

  public function get_categories() {
    return [ 'prk-mobile-category' ];
  }

  protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'اسلاید ها', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title', [
				'label' => esc_html__( 'عنوان اسلایدر', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'هندزفری مدل ایرپاد پرو Anc' , 'plugin-name' ),
			]
		);
		$repeater->add_control(
			'list_url', [
				'label' => esc_html__( 'لینک اسلایدر', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '#' , 'plugin-name' ),
			]
		);

		$img_carousel = get_parent_theme_file_uri('/assets/img/article_product.png' );
    $repeater->add_control(
			'list_img',
			[
				'label' => esc_html__( 'تصویر اسلایدر', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
						'url' => $img_carousel,
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
						'list_title' => esc_html__( 'شارژر  آنکر پرو', 'plugin-name' ),
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
			'auto_played',
			[
				'label' => esc_html__( 'پخش اتوماتیک', 'plugin-name' ),
				'description' => esc_html__( 'پخش اتوماتیک اسلایدها', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'true',
			]
		);

    $this->end_controls_section();

		// شروع تب استایل
 		$this->start_controls_section(
 			'section_style',
 			[
 				'label' => esc_html__( 'استایل اسلایدر', 'plugin-name' ),
 				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
 			]
 		);
 		$this->add_control(
 			'color_title',
 			[
 				'label' => __( 'رنگ عنوان اسلاید', 'plugin-domain' ),
 				'type' => \Elementor\Controls_Manager::COLOR,
 				'default' => '#162C5B',
 				'selectors' => [
 					'{{WRAPPER}} .article_mobile_slider .article_foot h4' => 'color: {{VALUE}}',
 				],
 			]
 		);

		$this->add_control(
			'color_title_icon',
			[
				'label' => __( 'رنگ ایکن اسلاید', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#162C5B',
				'selectors' => [
					'{{WRAPPER}} .article_mobile_slider .article_foot i' => 'color: {{VALUE}}',
				],
			]
		);


 	  $this->end_controls_section();
     // پایان تب استایل

	}


	protected function render() {
		$settings = $this->get_settings_for_display();
		$auto_played = $settings['auto_played'];

?>
		<?Php if ( $settings['list_article'] ):?>

		<div class="article_mobile_slider">

			<div class="swiper-mobile-slider">

				<div class="swiper-wrapper">

					<?php foreach (  $settings['list_article'] as $item ):?>

            <div class="swiper-slide mobile elementor-repeater-item-<?php echo esc_attr( $item['_id'] );?>">

							<article class="mobile_article_item" style="margin-left: 10px;">
								<a class="mobile_article_item_link" href="<?php echo $item['list_url'];?>" target="_blank">
			            <img class="mobile_slider_image" src="<?php echo $item['list_img']['url'];?>" alt="article-slider">

									<?php if ( $item['list_title'] ): ?>
										<div class="article_foot">
											<h4><?php echo $item['list_title'];?></h4>
											<i class="prk-arrow-left"></i>
		                </div>
									<?php endif; ?>


								</a>
							</article>

            </div>

					<?php endforeach;?>

				</div>


			</div>

		</div>

		<script>
			jQuery(document).ready(function(){
				var swiper = new Swiper('.swiper-mobile-slider', {


					<?php if ($auto_played == 'yes')
					{?>
						autoplay: {
						delay: 3500,
						disableOnInteraction: false,
						},

          <?php
				}?>
				});
			});
		</script>

    <?php endif;?>

<?php
		}

}
