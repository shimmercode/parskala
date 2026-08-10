<?php
class blog_sidebar_Widget extends \Elementor\Widget_Base {


	public function get_name() {
		return 'blog-sidebar';
	}

	public function get_title() {
		return 'پست های فهرست وار';
	}

	public function get_icon() {
		return 'eicon-toggle';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'text',
			[
				'label' => 'پست های فهرست وار',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title_section',
			[
				'label' => 'عنوان',
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
        'default' => __( 'پربازدید ترین مطالب ...' , 'prk' ),
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
    				'min' => 3,
    				'max' => 10,
    				'step' => 1,
    				'default' => 3,
    			]
    		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$title_section =  $settings['title_section'];

		?>
    <section class="col-product">
       <div class="right-product tab1">
				 <span class="title-psidebar">
        <a><?php echo $title_section;?></a>
				 </span>
      <div class="post-didebars">
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
                 <article class="item-pside">
                         <div class="img-pside">
                                <?php the_post_thumbnail();?>
                         </div>

												 <div class="title-pside">
                          <a href="<?php the_permalink();?>" target="_blank"><h2><?php the_title();?></h2></a>
													 <a class="see-more-pside" href="<?php the_permalink();?>" target="_blank">مشاهده بیشتر</a>
													 <cite><?php comments_number(); ?></cite>
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
