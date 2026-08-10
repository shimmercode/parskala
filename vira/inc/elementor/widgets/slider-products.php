<?php

class swip_slider_products extends \Elementor\Widget_Base {

	public function get_name() {
		return 'swiper_sliderss';
	}

	public function get_title() {
		return __( 'اسلایدر متحرک', 'prk' );
	}

  public function get_icon() {
    return 'eicon-sync';
  }

  public function get_categories() {
    return [ 'prk-category' ];
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
				'default' => esc_html__( 'مناسب برای تمامی اصناف' , 'plugin-name' ),
			]
		);

		$repeater->add_control(
			'list_name', [
				'label' => esc_html__( 'نام اسلایدر', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'هدفون گیمینگ سونی' , 'plugin-name' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'list_url', [
				'label' => esc_html__( 'لینک اسلایدر', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '#' , 'plugin-name' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'list_color',
			[
				'label' => esc_html__( 'رنگ اسلایدر', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#1C0450',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}'
				],
			]
		);
		$repeater->add_control(
			'list_color_border',
			[
				'label' => esc_html__( 'رنگ دایره محصول اسلایدر', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#F1A207',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .img-product .dots' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .img-product .dots::before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .img-product .dots::after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .img-product .dots i::before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .img-product .dots i::after' => 'background-color: {{VALUE}}',
				],
			]
		);
		$img_carousel = get_parent_theme_file_uri('/assets/img/patterns.png' );
		$repeater->add_control(
			'bg_back1',
			[
				'label' => esc_html__( 'تصویر پترن پس زمینه', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
						'url' => $img_carousel,
					],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-image: url({{url}})',
				],
			]
		);
    $repeater->add_control(
			'list_img',
			[
				'label' => esc_html__( 'تصویر اسلایدر', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::MEDIA,

			]
		);
		$this->add_control(
			'list',
			[
				'label' => esc_html__( 'لیست اسلاید ها', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_name' => esc_html__( 'اسلایدر#جدید', 'plugin-name' ),
					],
				],
				'title_field' => '{{{ list_name }}}',
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

		$this->add_control(
			'looped',
			[
				'label' => esc_html__( 'حلقه بینهایت', 'plugin-name' ),
				'description' => esc_html__( 'حلقه بینهایت اسلاید ها', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'true',
			]
		);
		$this->add_control(
			'border_carousel',
						[
						'label' => esc_html__( 'انحنا دور سکشن', 'plugin-name' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => '11px',
							'selectors' => [
							'{{WRAPPER}} .gallery.swiper_produt' => 'border-radius: {{VALUE}}',
							],
						]
		);
    $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$auto_played = $settings['auto_played'];
		$looped = $settings['looped'];
?>
		<?Php if ( $settings['list'] ):?>

			<div class="gallery swiper_produt">

        <div class="swiper-container gallery-slider_product">
            <div class="swiper-wrapper">

        			<?php foreach (  $settings['list'] as $item ):?>

                <div class="swiper-slide items elementor-repeater-item-<?php echo esc_attr( $item['_id'] );?>">
                  <article class="product-item">
                    <div class="img-product">
                      <span class="dots"> <i></i> </span>
                     <img src="<?php echo $item['list_img']['url'];?>">
                    </div>

                    <div class="titles-item">
                      <span class="head-title"><?php echo $item['list_title'];?></span>
                      <h4><?php echo $item['list_name'];?></h4>
                    <a class="product-item-link" href="<?php echo $item['list_url'];?>">مشاهده محصول<i class="ri-arrow-left-line"></i></a>
                    </div>
                  </article>
                </div>
        			<?php endforeach;?>

            </div>
        </div>


				<div class="swiper-container gallery-thumbsـproduct">
						<div class="swiper-wrapper">

							<?php foreach (  $settings['list'] as $item ):?>

								<div class="swiper-slide">


									<div class="item_slider">

										<img src="<?php echo $item['list_img']['url'];?>">

										<span class="slider_star color2_back">
	                    <i class="ri-star-s-fill"></i>
											<i class="ri-star-s-fill"></i>
											<i class="ri-star-s-fill"></i>
											<i class="ri-star-s-fill"></i>
											<i class="ri-star-s-fill"></i>
										</span>

									</div>


								</div>

							<?php endforeach;?>

						</div>

				</div>

				<div class="button-prev"><i class="ri-arrow-up-s-line"></i></div>
				<div class="button-next"><i class="ri-arrow-down-s-line"></i></div>
                <div class="items-pagination"></div>

          <script>
          jQuery(function () {
          var slider = new Swiper ('.gallery-slider_product', {
              slidesPerView:1,
              centeredSlides: true,
							effect: 'fade',
							<?php if ($looped == 'yes')
							{?>
	              loop: true,
	              loopedSlides: 2, //スライドの枚数と同じ値を指定
							<?php
						  }?>

							<?php if ($auto_played == 'yes')
							{?>
								autoplay: {
								delay: 2500,
								disableOnInteraction: false,
								},
		          <?php
						}?>
              pagination: {
                el: '.items-pagination',
                clickable: true,
              },
              mousewheel: {
                  invert: false,
              },
          });


          var thumbs = new Swiper ('.gallery-thumbsـproduct', {
              slidesPerView: 3,
              direction: "vertical",
              spaceBetween: 10,
              centeredSlides: true,
							<?php if ($looped == 'yes')
							{?>
	              loop: true,
	              loopedSlides: 2, //スライドの枚数と同じ値を指定
							<?php
						  }?>
              slideToClickedSlide: true,
               mousewheel: {
                  invert: false,
              },
              navigation: {
              nextEl: '.button-next',
              prevEl: '.button-prev',
          },
          });


          slider.controller.control = thumbs;
          thumbs.controller.control = slider;

          });
          </script>
      </div>

    <?php endif;?>

<?php
		}

}
