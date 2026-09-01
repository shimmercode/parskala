<?php
class banner_ads_Widget extends \Elementor\Widget_Base {


	public function get_name() {
		return 'banner-ads';
	}

	public function get_title() {
		return 'تبلیغات بنری';
	}

	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'text',
			[
				'label' => 'تبلیغات بنری',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

    $this->add_control(
    			'banner_list',
    			[
    				'label' => __( 'ستون ها', 'plugin-domain' ),
    				'type' => \Elementor\Controls_Manager::SELECT,
    				'default' => 'banner_2',
    				'options' => [
    					'banner_1'  => __( '1', 'plugin-domain' ),
    					'banner_2' => __( '2-2', 'plugin-domain' ),
							'banner_3' => __( '3-3-3', 'plugin-domain' ),
    					'banner_4' => __( '1-1-1-1', 'plugin-domain' ),
    				],
    			]
    );

$this->add_control(
    's-link-1',
    [
        'label' => __( 'لینک بنر 1', 'plugin-domain' ),
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
			 'label' => __( 'انتخاب عکس', 'plugin-domain' ),
			 'type' => \Elementor\Controls_Manager::MEDIA,
		 ]
	 );

	 $this->add_control(
	     's-link-2',
	     [
	         'label' => __( 'لینک بنر 2', 'plugin-domain' ),
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
	 			 'label' => __( 'انتخاب عکس', 'plugin-domain' ),
	 			 'type' => \Elementor\Controls_Manager::MEDIA,
	 		 ]
	 	 );

		 $this->add_control(
		     's-link-3',
		     [
		         'label' => __( 'لینک بنر 3', 'plugin-domain' ),
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
		 			 'label' => __( 'انتخاب عکس', 'plugin-domain' ),
		 			 'type' => \Elementor\Controls_Manager::MEDIA,
		 		 ]
		 	 );

			 $this->add_control(
			     's-link-4',
			     [
			         'label' => __( 'لینک بنر 4', 'plugin-domain' ),
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
			 			 'label' => __( 'انتخاب عکس', 'plugin-domain' ),
			 			 'type' => \Elementor\Controls_Manager::MEDIA,
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
	 						'{{WRAPPER}} .banners' => 'border-radius: {{VALUE}}px',
	 						'{{WRAPPER}} .slide-bottom img' => 'border-radius: {{VALUE}}px',
	 						'{{WRAPPER}} .slide-top img' => 'border-radius: {{VALUE}}px'
	 					],
	 				]
	 		);
			$this->add_control(
				'mousemove_3d',
				[
					'label' => __( 'هاور سه بعدی', 'parskala' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'روشن', 'parskala' ),
					'label_off' => __( 'خاموش', 'parskala' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$this->add_control(
				'shine_hover',
				[
					'label' => __( 'هاور شاین', 'parskala' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'روشن', 'parskala' ),
					'label_off' => __( 'خاموش', 'parskala' ),
					'return_value' => 'true',
				]
			);


		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if ($settings['mousemove_3d'] == 'yes') {
			?>
			<script>
			jQuery(document).ready(function(){
				jQuery("body").addClass("mousemove_3d");
			});
			</script>
			<?php
			$class_over = ' prk_3d_mousemove';
		}else {
			$class_over = '';
		}

		$shine_hover = $settings['shine_hover'] == 'true' ? 'shine': '';


		?>

    <section class="col-banner<?= $class_over .' '. $shine_hover ?>">
    <?php if ( 'banner_1' ==  $settings['banner_list']):?>
			<!-- تک ستونه-->
			<?php if ($settings['s-image-1']['url']):?>
      <div class="banners list1">
       <a href="<?php echo $settings['s-link-1']['url'];?>"><img src="<?php echo $settings['s-image-1']['url'];?>" alt=""></a>
      </div>
    <?php endif;?>
    <?php if ($settings['s-image-2']['url']):?>
      <div class="banners list1">
    <a href="<?php echo $settings['s-link-2']['url'];?>"><img src="<?php echo $settings['s-image-2']['url'];?>" alt=""></a>
      </div>
      <?php endif;?>
      <?php if ($settings['s-image-3']['url']):?>
      <div class="banners list1">
    <a href="<?php echo $settings['s-link-3']['url'];?>"><img src="<?php echo $settings['s-image-3']['url'];?>" alt=""></a>
      </div>
      <?php endif;?>
      <?php if ($settings['s-image-4']['url']):?>
      <div class="banners list1">
    <a href="<?php echo $settings['s-link-4']['url'];?>"> <img src="<?php echo $settings['s-image-4']['url'];?>" alt=""></a>
      </div>
      <?php endif;?>
		  <?php else:?>
			<?php if ( 'banner_2' ==  $settings['banner_list']):?>
				<!-- دو ستونه-->
				<?php if ($settings['s-image-1']['url']):?>
	      <div class="banners list2">
	       <a href="<?php echo $settings['s-link-1']['url'];?>"><img src="<?php echo $settings['s-image-1']['url'];?>" alt=""></a>
	      </div>
	    <?php endif;?>
	    <?php if ($settings['s-image-2']['url']):?>
	      <div class="banners list2">
	    <a href="<?php echo $settings['s-link-2']['url'];?>"><img src="<?php echo $settings['s-image-2']['url'];?>" alt=""></a>
	      </div>
	      <?php endif;?>
	      <?php if ($settings['s-image-3']['url']):?>
	      <div class="banners list2">
	    <a href="<?php echo $settings['s-link-3']['url'];?>"><img src="<?php echo $settings['s-image-3']['url'];?>" alt=""></a>
	      </div>
	      <?php endif;?>
	      <?php if ($settings['s-image-4']['url']):?>
	      <div class="banners list2">
	    <a href="<?php echo $settings['s-link-4']['url'];?>"> <img src="<?php echo $settings['s-image-4']['url'];?>" alt=""></a>
	      </div>
	      <?php endif;?>
			<?php else:?>
				<?php if ( 'banner_3' ==  $settings['banner_list']):?>

					<!-- چهار ستونه-->
					<?php if ($settings['s-image-1']['url']):?>
						<div class="banners list3">
						 <a href="<?php echo $settings['s-link-1']['url'];?>"><img src="<?php echo $settings['s-image-1']['url'];?>" alt=""></a>
						</div>
				  <?php endif;?>

					<?php if ($settings['s-image-2']['url']):?>
						<div class="banners list3">
					    <a href="<?php echo $settings['s-link-2']['url'];?>"><img src="<?php echo $settings['s-image-2']['url'];?>" alt=""></a>
						</div>
					<?php endif;?>

					<?php if ($settings['s-image-3']['url']):?>
						<div class="banners list3">
					    <a href="<?php echo $settings['s-link-3']['url'];?>"><img src="<?php echo $settings['s-image-3']['url'];?>" alt=""></a>
						</div>
					<?php endif;?>

					<?php if ($settings['s-image-4']['url']):?>
						<div class="banners list3">
				     	<a href="<?php echo $settings['s-link-4']['url'];?>"> <img src="<?php echo $settings['s-image-4']['url'];?>" alt=""></a>
						</div>
					<?php endif;?>

				<?php endif;?>

				<?php if ( 'banner_4' ==  $settings['banner_list']):?>

					<!-- چهار ستونه-->
					<?php if ($settings['s-image-1']['url']):?>
						<div class="banners list4">
						 <a href="<?php echo $settings['s-link-1']['url'];?>"><img src="<?php echo $settings['s-image-1']['url'];?>" alt=""></a>
						</div>
				  <?php endif;?>

					<?php if ($settings['s-image-2']['url']):?>
						<div class="banners list4">
					    <a href="<?php echo $settings['s-link-2']['url'];?>"><img src="<?php echo $settings['s-image-2']['url'];?>" alt=""></a>
						</div>
					<?php endif;?>

					<?php if ($settings['s-image-3']['url']):?>
						<div class="banners list4">
					    <a href="<?php echo $settings['s-link-3']['url'];?>"><img src="<?php echo $settings['s-image-3']['url'];?>" alt=""></a>
						</div>
					<?php endif;?>

					<?php if ($settings['s-image-4']['url']):?>
						<div class="banners list4">
				     	<a href="<?php echo $settings['s-link-4']['url'];?>"> <img src="<?php echo $settings['s-image-4']['url'];?>" alt=""></a>
						</div>
					<?php endif;?>

				<?php endif;?>

				<?php endif;?>
			<?php endif;?>
    </section>

		<?php

	}

	protected function _content_template() {}

}
