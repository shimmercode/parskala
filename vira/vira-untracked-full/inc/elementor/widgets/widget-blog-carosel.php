<?php
class blog_carosel_Widget extends \Elementor\Widget_Base {


	public function get_name() {
		return 'blog-carosel';
	}

	public function get_title() {
		return 'کاروسل نوشته ها';
	}

	public function get_icon() {
		return 'eicon-posts-carousel';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'text',
			[
				'label' => 'کاروسل نوشته ها',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title_section',
			[
				'label' => 'عنوان',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'عنوان',
        'default' => __( 'آخرین های وبلاگ' , 'prk' ),
			]
		);
		$this->add_control(
			'title_icon',
			[
				'label' => 'ایکن',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => 'ایکن',
				'default' => 'mdi mdi-watch-variant',
			]
		);
    $options = array();

$args = array(
    'hide_empty' => false,
);

$categories =  $categories = get_categories(array('taxonomy'=> 'category'));
foreach ( $categories as $key => $category ) {
    $options[$category->term_id] = $category->name;
}
$this->add_control(
    'category',
    [
        'label' => __( 'دسته', 'prk' ),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'options' => $options,
    ]
);
$this->add_control(
    'categoryـurl',
    [
        'label' => __( 'لینک دسته', 'plugin-domain' ),
        'type' => \Elementor\Controls_Manager::URL,
        'multiple' => true,
				'default' => [
		        'url' => '#',
					],
    ]
  );
$this->add_control(
  'order-post',
  [
    'label' => 'مرتب سازی',
    'type' => \Elementor\Controls_Manager::SELECT,
    'default' => 'DESC',
    'options' => [
          'ASC'  => __( 'صعودی', 'prk' ),
          'DESC' => __( 'نزولی', 'prk' )
       ],
  ]
);

    		$this->add_control(
    			'count-post',
    			[
    				'label' => __( 'تعداد نوشته', 'prk' ),
    				'type' => \Elementor\Controls_Manager::NUMBER,
    				'min' => 1,
    				'max' => 100,
    				'step' => 1,
    				'default' => 8,
    			]
    		);

        $this->add_control(
             'show-content-post',
             [
                'label' => __( 'خلاصه نوشته ها', 'prk' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

             ]
          );

		$this->end_controls_section();
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
					'default' => 'false',
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
						'default' => 'false',
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
		'item',
				[
					'label' => esc_html__( 'تعداد ایتم ها', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 3,
					'max' => 8,
					'step' => 1,
					'default' => 4,
				]
);
		$this->add_control(
		'item_moboile',
				[
					'label' => esc_html__( 'تعداد ایتم ها در موبایل', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 3,
					'max' => 8,
					'step' => 1,
					'default' => 4,
				]
		);
		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$settings_slider =  array(
			'loop' => $settings['loop'],
			'nav' => $settings['nav'],
			'autoplay' => $settings['autoplay'],
			'delay' => $settings['delay'],
			'item' => $settings['item'],
		);
		$json_settings = json_encode($settings_slider);
		?>
    <section class="col-product">
       <div class="right-product tab1">

				 <div class="head-product">
				<h3>
					<span class="titles-pro">
					<span class="<?php echo $settings['title_icon'];?> icon-carosel"></span>

					<span><?php echo $settings['title_section'];?></span>
				</span>
				<a class="view-all" href="<?php echo $settings['categoryـurl']['url'];?>"><?php _e('viwe all' , 'parskala');?></a>
			</h3>
				</div>

      <div class="article-off" settings-slider='<?php echo $json_settings; ?>'>
        <?php
        $order_post = $settings['order-post'];
        $count_post = $settings['count-post'];
        $category =  $settings['category'];
             $arms = array(
                 'post_type' => 'post',
                 'posts_per_page' => $count_post,
                 'post_status' => 'publish',
                 'order' => $order_post,
             );
						 						 if  ($category ){
						 							 $arms['tax_query'] =array(
						 								 array(
						 										 'taxonomy'  => 'category',
						 										 'field'     => 'id',
						 										 'terms'     => $category,
						 									 ),
						 							 );
						 						 }
						 						 else {
						 							 $arms['tax_query'] =array();
						 						};
             $pd_query = new WP_Query( $arms ); ?>
             <?php if ( $pd_query ->have_posts() ) : ?>
               <?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post(); ?>
                 <article  class="item-index home-blog">
                  <div class="item-thumb-index">
                    <?php prk_po_img();?>
                    <div class="hover-item-index"></div>
                    <div class="h-i-index">
                     <span class="cat-name-index">
						             <?php $categories = get_the_category();
						               if ( ! empty( $categories ) ) {
						                   echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
						                }?>
										 </span>
                    <span class="icon-comment-index">
                      <cite><?php comments_number(); ?></cite>
                      <i class="fal fa-comment-alt-lines"></i>
                    </span>
                      </div>
                  </div>
                  <div class="title-item-index">
                   <a href="<?php the_permalink();?>"><h2><?php echo wp_trim_words(get_the_title(),11,'...') ;?></h2></a>
                   <span class="line-item-index"></span>
                   <?php if ($settings['show-content-post']):?>
                      <p><?php echo wp_trim_words(get_the_content(),13,'...') ;?></p>
                    <?php endif;?>

                  </div>
                 </article>
                <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      <?php else:?>
        <p>پستی موجود نیست !</p>
          <?php endif;?>
      </div>
    </section>
		<?php

	}

	protected function _content_template() {}

}
