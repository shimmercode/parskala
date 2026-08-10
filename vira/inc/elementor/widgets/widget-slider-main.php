<?php
class slider_main_Widget extends \Elementor\Widget_Base {


	public function get_name() {
		return 'slider-main';
	}

	public function get_title() {
		return 'اسلایدر اصلی';
	}

	public function get_icon() {
		return 'eicon-slides';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {

		// شروع سکشن فیلد های اصلی
		$this->start_controls_section(
			'text',
			[
				'label' => 'اسلایدر اصلی',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			  's-link-1',
			  [
			      'label' => __( 'لینک اسلایدر 1', 'prk' ),
			      'type' => \Elementor\Controls_Manager::URL,
			      'multiple' => true,
						'default' => [
				        'url' => '#',
				        'is_external' => true,
				        'nofollow' => true,
			      ],
			  ]
		);

		$this->add_control(
				 's-image-1',
				 [
					 'label' => __( 'انتخاب عکس', 'prk' ),
					 'type' => \Elementor\Controls_Manager::MEDIA,
					 'default' => [
						 'url' => \Elementor\Utils::get_placeholder_image_src(),
						 ],
				 ]
		);
	  $this->add_control(
	     's-link-2',
	     [
	         'label' => __( 'لینک اسلایدر 2', 'prk' ),
	         'type' => \Elementor\Controls_Manager::URL,
	         'multiple' => true,
	 				'default' => [
	 		        'url' => '#',
	 		        'is_external' => true,
	 		        'nofollow' => true,
	         ],
	     ]
	  );
	  $this->add_control(
	 		 's-image-2',
	 		 [
	 			 'label' => __( 'انتخاب عکس', 'prk' ),
	 			 'type' => \Elementor\Controls_Manager::MEDIA,
	 		 ]
	 	);
	  $this->add_control(
	     's-link-3',
	     [
	         'label' => __( 'لینک اسلایدر 3', 'prk' ),
	         'type' => \Elementor\Controls_Manager::URL,
	         'multiple' => true,
	 				'default' => [
	 		        'url' => '#',
	 		        'is_external' => true,
	 		        'nofollow' => true,
	         ],
	     ]
	  );
	  $this->add_control(
	 		 's-image-3',
	 		 [
	 			 'label' => __( 'انتخاب عکس', 'prk' ),
	 			 'type' => \Elementor\Controls_Manager::MEDIA,
	 		 ]
	 	);

	  $this->add_control(
	     's-link-4',
	     [
	         'label' => __( 'لینک اسلایدر 4', 'prk' ),
	         'type' => \Elementor\Controls_Manager::URL,
	         'multiple' => true,
	 				'default' => [
	 		        'url' => '#',
	 		        'is_external' => true,
	 		        'nofollow' => true,
	         ],
	     ]
	  );
	  $this->add_control(
	 		 's-image-4',
	 		 [
	 			 'label' => __( 'انتخاب عکس', 'prk' ),
	 			 'type' => \Elementor\Controls_Manager::MEDIA,
	 		 ]
	  );
	  $this->add_control(
	     'right-link-1',
	     [
	         'label' => __( 'لینک بنر کناری 1', 'prk' ),
	         'type' => \Elementor\Controls_Manager::URL,
	         'multiple' => true,
	 				'default' => [
	 		        'url' => '#',
	 		        'is_external' => true,
	 		        'nofollow' => true,
	         ],
	     ]
	  );
	  $this->add_control(
	 		 'right-image-1',
	 		 [
	 			 'label' => __( 'انتخاب عکس', 'prk' ),
	 			 'type' => \Elementor\Controls_Manager::MEDIA,
				 'default' => [
					 'url' => \Elementor\Utils::get_placeholder_image_src(),
					 ],
	 		 ]
	  );

	  $this->add_control(
			 'right-link-2',
			 [
					 'label' => __( 'لینک بنر کناری 2', 'prk' ),
					 'type' => \Elementor\Controls_Manager::URL,
					 'multiple' => true,
					'default' => [
							'url' => '#',
							'is_external' => true,
							'nofollow' => true,
					 ],
			 ]
	  );
		$this->add_control(
			 'right-image-2',
			 [
				 'label' => __( 'انتخاب عکس', 'prk' ),
				 'type' => \Elementor\Controls_Manager::MEDIA,
				 'default' => [
           'url' => \Elementor\Utils::get_placeholder_image_src(),
          ],
			 ]
		);

		$this->end_controls_section();
    // پایان سکشن فیلد های اصلی

		// شروع سکشن کنترل اسلایدر ها
		$this->start_controls_section(
		 'slider_special',
		 [
			 'label' => 'پیکربندی اسلایدر',
			 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
		 ]
		);

		$this->add_control(
				'loop',
				[
					'label' => 'حلقه نامحدود',
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'بله', 'your-plugin' ),
					'label_off' => __( 'خیر', 'your-plugin' ),
					'return_value' => 'true',
					'default' => 'true',
				]
			);
		$this->add_control(
				'nav',
				[
					'label' => 'پیکان ها',
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'بله', 'your-plugin' ),
					'label_off' => __( 'خیر', 'your-plugin' ),
					'return_value' => 'true',
					'default' => 'true',
				]
			);

		$this->add_control(
			'dots',
					[
						'label' => esc_html__( 'نمایش نقطه ها', 'plugin-name' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'return_value' => 'true',
						'default' => 'true',
					]
    );
		$this->add_control(
				'autoplay',
				[
					'label' => 'نمایش خودکار',
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'بله', 'your-plugin' ),
					'label_off' => __( 'خیر', 'your-plugin' ),
					'return_value' => 'true',
					'default' => 'false',
				]
			);

		$this->add_control(
			'delay',
			[
				'label' => esc_html__( 'سرعت پخش', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'step' => 5,
				'default' => 3000,
			]
		);
		$this->add_control(
				'border',
				[
					'label' => esc_html__( 'انحنا دور سکشن(فقط عدد)', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 1,
					'step' => 1,
					'default' => '8',
					'selectors' => [
						'{{WRAPPER}} .slider-right' => 'border-radius: {{VALUE}}px',
						'{{WRAPPER}} .slide-bottom img' => 'border-radius: {{VALUE}}px',
						'{{WRAPPER}} .slide-top img' => 'border-radius: {{VALUE}}px'
					],
				]
		);

		$this->end_controls_section();
    // پایان سکشن کنترل اسلایدر ها
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$settings_slider =  array(
			'loop' => $settings['loop'] ? $settings['loop'] : 'false',
			'nav' => $settings['nav'] ? $settings['nav'] : 'false',
			'dots' => $settings['dots'] ? $settings['dots'] : 'false',
			'autoplay' => $settings['autoplay'] ? $settings['autoplay'] : 'false',
			'delay' => $settings['delay'] ? $settings['delay'] : 'false',
		);
		$json_settings = json_encode($settings_slider);


		 // تنظیمات سکشن دانلود اپ
	   $app_icon = get_parent_theme_file_uri('assets/img/icon-app.svg' );
		 $appsـtrue = prk_option('appsـtrue');
		 $apps_text = prk_option('apps_text');
		 $apps_btn = prk_option('apps_btn');
		 $appsـbtn_url = prk_option('appsـbtn_url');
		 $apps_pic = prk_option('apps_pic');
	   if(isset($apps_pic['url']) && $apps_pic['url'] != '') { $app_icon = $apps_pic['url']; }

		?>

		<section class="col-slider">



			 <!-- بنر سمت راست-->
			<div class="slider-right">

			  <div class="slide-carousel" settings-slider='<?php echo $json_settings;?>'>

					<?php if ($settings['s-image-1']['url']):?>
					  <div class="slide-pre">
					    <a href="<?php echo $settings['s-link-1']['url'];?>"><img src="<?php echo $settings['s-image-1']['url'];?>" alt=""></a>
					  </div>
			    <?php endif;?>

				  <?php if ($settings['s-image-2']['url']):?>
				   <div class="slide-pre">
				     <a href="<?php echo $settings['s-link-2']['url'];?>"><img src="<?php echo $settings['s-image-2']['url'];?>" alt=""></a>
				   </div>
				  <?php endif;?>

					<?php if ($settings['s-image-3']['url']):?>
					  <div class="slide-pre">
				      <a href="<?php echo $settings['s-link-3']['url'];?>"><img src="<?php echo $settings['s-image-3']['url'];?>" alt=""></a>
					  </div>
				  <?php endif;?>

			   <?php if ($settings['s-image-4']['url']):?>
			     <div class="slide-pre">
			       <a href="<?php echo $settings['s-link-4']['url'];?>"><img src="<?php echo $settings['s-image-4']['url']; ?>" alt=""></a>
			     </div>
				 <?php endif;?>

			  </div>

			</div>

			<!-- بنر سمت چپ-->
			<div class="slider-left">

				 <div class="slide-top">
				   <a href="<?php echo $settings['right-link-1']['url']; ?>"><img src="<?php echo $settings['right-image-1']['url']; ?>" alt=""></a>
				 </div>

				 <div class="slide-bottom">
			     <a href="<?php echo $settings['right-link-2']['url']; ?>"><img src="<?php echo $settings['right-image-2']['url']; ?>" alt=""></a>
				 </div>

			</div>

	  </section>

<?php

	}

	protected function _content_template() {}

}
