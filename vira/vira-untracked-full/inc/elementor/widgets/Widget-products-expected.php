<?php
class products_expected_Widget extends \Elementor\Widget_Base{


	public function get_name() {
		return 'products_expected';
	}

	public function get_title() {
		return 'انتظار انگیز';
	}

	public function get_icon() {
		return 'eicon-clock-o';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'text',
			[
				'label' => 'انتظار انگیز',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'عنوان', 'parskala' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'انتظار انگیز', 'parskala' ),
			]
		);
		$this->add_control(
			'color_title_sec',
			[
				'label' => __( 'رنگ عنوان', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .titles-pro' => 'color: {{VALUE}}',
					'{{WRAPPER}} .titles-pro::after' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'color_border_sec',
			[
				'label' => __( 'رنگ خط عنوان', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#0E193569',
				'selectors' => [
					'{{WRAPPER}} .head-product' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'color_fill_box',
			[
				'label' => __( 'رنگ ایکن باکس', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#666666',
				'selectors' => [
					'{{WRAPPER}} .head-product' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'label_discount',
			[
				'label' => __( 'مقدار درصد', 'parskala' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '50 درصد', 'parskala' ),
			]
		);
		$this->add_control(
			'sub_title',
			[
				'label' => __( 'عنوان انتظار انگیز', 'parskala' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '50 درصد تخفیف ویژه', 'parskala' ),
			]
		);
		$this->add_control(
			'sub_dec',
			[
				'label' => __( 'توضیح کوتاه', 'parskala' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'با 50 درصد تخفیف ویژه محصول مدنظرتان را خریداری کنید', 'parskala' ),
			]
		);

		$this->add_control(
			'due_date_done',
			[
				'label' => esc_html__( 'تاریخ پایان شگفت انگیز', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,

			]
		);
		$this->add_control(
			'color_texts_box',
			[
				'label' => __( 'رنگ کلی متون محتوا ', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#0E1935',
				'selectors' => [
					'{{WRAPPER}} .main-expected .onsale-label span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .main-expected .onsel-title' => 'color: {{VALUE}}',
					'{{WRAPPER}} .main-expected p.onsel-des' => 'color: {{VALUE}}',
					'{{WRAPPER}} .countdown-item.expected .countzarin-col .countdown-unit .number' => 'color: {{VALUE}}',
					'{{WRAPPER}} .countdown-item.expected .countzarin-col .countdown-unit .letter-text' => 'color: {{VALUE}}',
					'{{WRAPPER}} .countdown-item.expected .countzarin-col .countdown-unit' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'color_back_box',
			[
				'label' => __( 'رنگ پس زمینه محتوا', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#DFE1E8',
				'selectors' => [
					'{{WRAPPER}} .col-product.expected' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .countdown-item.expected .countzarin-col .countdown-unit' => 'background: {{VALUE}}',
				],
			]
		);

	 $this->end_controls_section();



	 // شروع تب استایل
	  $this->start_controls_section(
	 	 'section_style',
	 	 [
	 		 'label' => esc_html__( 'استایل سکشن', 'plugin-name' ),
	 		 'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	 	 ]
	  );

	  $this->add_control(
	 	 'color_back',
	 	 [
	 		 'label' => __( 'رنگ اصلی پس زمینه', 'plugin-domain' ),
	 		 'type' => \Elementor\Controls_Manager::COLOR,
	 		 'default' => '#ef5662',
	 		 'selectors' => [
	 			 '{{WRAPPER}} .col-product.wee' => 'background-color: {{VALUE}}',
	 		 ],
	 	 ]
	  );
		$this->add_control(
		 'color_titles',
		 [
			 'label' => __( 'رنگ عناوین', 'plugin-domain' ),
			 'type' => \Elementor\Controls_Manager::COLOR,
			 'selectors' => [
				 '{{WRAPPER}} .col-product.wee .head-hani h2' => 'color: {{VALUE}}',
				 '{{WRAPPER}} .col-product.wee .wee_title' => 'color: {{VALUE}}',
				 '{{WRAPPER}} .col-product.wee .breadcrumb a' => 'color: {{VALUE}} !important',
				 '{{WRAPPER}} .product_wee del .woocommerce-Price-amount' => 'color: {{VALUE}}',
				 '{{WRAPPER}} .product_wee .index-prices-pro bdi' => 'color: {{VALUE}}',
				 '{{WRAPPER}} .product_wee .index-prices-pro em' => 'color: {{VALUE}}',
				 '{{WRAPPER}} .product_wee .index-prices-pro .woocommerce-Price-currencySymbol' => 'color: {{VALUE}} !important',
				 '{{WRAPPER}} .product_wee .prk_timer span' => 'color: {{VALUE}} !important',
				 '{{WRAPPER}} .product_wee .prk_timer #timerm span .number' => 'color: {{VALUE}} !important',
			 ],
		 ]
		);

		$this->add_control(
		 'color_back_image',
		 [
			 'label' => __( 'رنگ حاله پشت تصویر', 'plugin-domain' ),
			 'type' => \Elementor\Controls_Manager::COLOR,
			 'selectors' => [
				 'body {{WRAPPER}} .col-product.wee .product_wee .wee_tumbnail::before' => 'background: {{VALUE}} !important',
			 ],
		 ]
		);

	 		$theme_display = prk_option('theme-style');
	 		if($theme_display == 'digikala'){
	 			$border_count = '8';
	 		}else{
	 			$border_count = '11';
	 		}
			$this->add_control(
		 			 'border',
		 			 [
		 				 'label' => esc_html__( 'انحنا دور سکشن', 'plugin-name' ),
		 				 'type' => \Elementor\Controls_Manager::NUMBER,
		 				 'min' => 1,
		 				 'step' => 1,
		 				 'default' => $border_count,
		 				 'selectors' => [
		 					 '{{WRAPPER}} .col-product.expected' => 'border-radius: {{VALUE}}px',
		 				 ],
		 			 ]
		  );


	  $this->end_controls_section();
	  
	  // پایان تب استایل

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$title_section =  $settings['title'];
		$RandomString = generateRandomString();
		$due_date = strtotime( $this->get_settings( 'due_date_done' ) );
			?>

			  <section class="col-product expected">

			  <div class="head-product">
		

			 			<h3>
			 				<span class="titles-pro ">
					 			<div class="title-tab-prk">
									<div class="item-icon-title">
				 				       <span><?= $title_section ?></span>
									</div>
							   </div>
			 		  	</span>
						</h3>

				</div>

				<div class="main-expected flex-column">

                  <div class="onsale-label">
					<span><?= $settings['label_discount'] ?></span>
				  </div>

				  <div class="expected-icon">
				    <svg xmlns="http://www.w3.org/2000/svg" width="144" height="102" viewBox="0 0 144 102" fill="none"><path d="M71.6385 0.601763V101.378L16.8558 79.826V44.9095L46.1133 44.4279L71.6385 0.601763ZM71.6385 -0.000244141L16.8558 16.9764L71.6385 -0.000244141Z" fill="url(#paint0_linear_2954_101003)"></path><path d="M46.1138 44.5483L72.0001 -0.000244141L16.8562 16.9764L0 45.2707L46.1138 44.5483Z" fill="url(#paint1_linear_2954_101003)"></path><path d="M71.6387 -0.000244141V101.378L126.421 79.826V44.9095L97.8862 44.5483L72.1203 0.120156L71.6387 -0.000244141Z" fill="url(#paint2_linear_2954_101003)"></path><path d="M97.8862 44.5483L71.9999 -0.000244141L127.144 16.9764L144 45.2707L97.8862 44.5483Z" fill="url(#paint3_linear_2954_101003)"></path><defs><linearGradient id="paint0_linear_2954_101003" x1="44.2471" y1="-0.000244141" x2="44.2471" y2="101.378" gradientUnits="userSpaceOnUse"><stop stop-color="#9A9FA8"></stop><stop offset="1" stop-color="#5B5D61"></stop></linearGradient><linearGradient id="paint1_linear_2954_101003" x1="36" y1="-0.000244141" x2="36" y2="45.2707" gradientUnits="userSpaceOnUse"><stop stop-color="#EAECEF"></stop><stop offset="1" stop-color="#BABEC4"></stop></linearGradient><linearGradient id="paint2_linear_2954_101003" x1="99.03" y1="-0.000244141" x2="99.03" y2="101.378" gradientUnits="userSpaceOnUse"><stop stop-color="#ACB1BC"></stop><stop offset="1" stop-color="#78797B"></stop></linearGradient><linearGradient id="paint3_linear_2954_101003" x1="108" y1="-0.000244141" x2="108" y2="45.2707" gradientUnits="userSpaceOnUse"><stop stop-color="#EAECEF"></stop><stop offset="1" stop-color="#BABEC4"></stop></linearGradient></defs></svg>
				  </div>

				  <div class="onsel-title"><?= $settings['sub_title'] ?></div>
				  <p class="onsel-des"><?= $settings['sub_dec'] ?></p>

			     <div class="prk-tim block expected <?= $RandomString ?> countdown-item"></div>
			     <script type="text/javascript">
					var expected_dateEnd = new Date((<?php echo $due_date; ?>) * 1000);
					new TimezZ('.expected.<?= $RandomString ?>', {
					date: expected_dateEnd,
					template: '<span class="countzarin-col"><span class="countdown-unit"><span  class="number">NUMBER</span><span class="letter-text">LETTER</span></span></span>',
					text: {
					days: 'روز',
					hours: 'ساعت',
					minutes: 'دقیقه',
					seconds: 'ثانیه',
						}
					});
			     </script>

				 <div class="expected-arrow">
				   <svg xmlns="http://www.w3.org/2000/svg" width="45" height="140" viewBox="0 0 45 140" fill="none"><path fill-rule="evenodd" clip="" -="" rule="evenodd" d="M0 140C0.57537 120.855 10.8319 109.295 16.0337 105.846L15.6377 105.973L35.1078 90.2093C47.9605 79.8034 47.9605 60.2008 35.1078 49.7948L15.6377 34.031L16.0337 34.1584C10.8319 30.7085 0.575365 19.1474 -6.11963e-06 -0.000564575L0 140Z" fill="#dfe1e8"></path></svg>
				 </div>

				</div>
				
			  </section>

			<?php

	}

	protected function _content_template() {

	}

}
