<?php

class swip_icon_feautures_slider extends \Elementor\Widget_Base {

	public function get_name() {
		return 'icon_feautures_slider';
	}

	public function get_title() {
		return __( 'باکس ایکن محتوا2', 'prk' );
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
				'label' => esc_html__( 'باکس ها', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title', [
				'label' => esc_html__( 'عنوان', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( ' بازگشت وجه و گارانتی محصولات' , 'plugin-name' ),
			]
		);


    $repeater->add_control(
			'list_icon',
			[
				'label' => esc_html__( 'ایکن باکس', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
		    'default' => esc_html__( 'ri-shield-keyhole-line' , 'plugin-name' ),
			]
		);
		$repeater->add_control(
			'list_url', [
				'label' => esc_html__( 'لینک باکس', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '#' , 'plugin-name' ),
			]
		);
		$this->add_control(
			'list_article',
			[
				'label' => esc_html__( 'لیست باکس ها', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => esc_html__( 'پرداخت در محل', 'plugin-name' ),
						'list_title' => esc_html__( 'پرداخت در محل برای تهران', 'plugin-name' ),

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
 				'label' => esc_html__( 'استایل باکس', 'plugin-name' ),
 				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
 			]
 		);
		$img_carousel = get_parent_theme_file_uri('/assets/img/icon-min.png' );
		$this->add_control(
				'list_img',
				[
					'label' => esc_html__( 'تصویر کاروسل', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
							'url' => $img_carousel,
						],
				]
		);
 		$this->add_control(
 			'color_title',
 			[
 				'label' => __( 'رنگ عنوان باکس', 'plugin-domain' ),
 				'type' => \Elementor\Controls_Manager::COLOR,
 				'default' => '#162C5B',
 				'selectors' => [
 					'{{WRAPPER}} .article_mobile_box .prk-data-box-icon p' => 'color: {{VALUE}}',
 				],
 			]
 		);

		$this->add_control(
			'color_subtitle',
			[
				'label' => __( 'رنگ توضیحات باکس', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#8995A6',
				'selectors' => [
					'{{WRAPPER}} .article_mobile_box .prk-data-box-icon span' => 'color: {{VALUE}}',
				],
			]
		);


 	  $this->end_controls_section();
     // پایان تب استایل

	}


	protected function render() {
		$settings = $this->get_settings_for_display();
		$auto_played = $settings['auto_played'];
		$list_img = $settings['list_img']['url'] ? $settings['list_img']['url']  : $img_carousel;

?>
		<?Php if ( $settings['list_article'] ):?>

  <div class="feautures__wrapper">

		<div class="feautures__logo">
		   <img src="<?= $list_img ?> " alt="">
		 </div>

		<div class="article_mobile_box feautures">

			<div class="swiper-box-slider feautures__items">

				<div class="swiper-wrapper">

					<?php foreach (  $settings['list_article'] as $item ):?>

            <div class="swiper-slide box-icon elementor-repeater-item-<?php echo esc_attr( $item['_id'] );?>">

				<article class="box_article_item">

                    <div class="prk-image-box-icon">
			                 <i class="<?php echo $item['list_icon'];?>"></i>
                    </div>

                    <?php if ( !empty($item['list_title']) ): ?>

						<div class="prk-data-box-icon">
							<p><?php echo $item['list_title'];?></p>
						</div>

					<?php endif; ?>


					</article>

            </div>

					<?php endforeach;?>

				</div>


			</div>

		</div>

	</div>
		<script>
			jQuery(document).ready(function(){
				var swiper = new Swiper('.swiper-box-slider.feautures__items', {
          spaceBetween: 10,

					<?php if ($auto_played == 'yes')
					{?>
						autoplay: {
						delay: 3500,
						disableOnInteraction: false,
						},

          <?php
				}?>
				breakpoints: {
					1200: {
						slidesPerView: 4,
						spaceBetween: 10,
					},
					992: {
						slidesPerView: 1,
						spaceBetween: 10,
					},
					576: {
						slidesPerView: 1,
						spaceBetween: 10,
					},
					480: {
						slidesPerView: 1,
						spaceBetween: 8,
					},
				},

				});
			});
		</script>

    <?php endif;?>

<?php
		}

}
