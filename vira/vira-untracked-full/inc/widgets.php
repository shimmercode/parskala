<?php


/*
   ================================
          register widget
   ================================
*/
function register_footer_widget(){
register_sidebar(array(
		'name' => 'نوار فوتر',
		'id' => 'footer-widget',
		'before_widget' => '<div class="foot-box">',
		'after_widget' => '</div>',
		'before_title' => '<span class="foot-title">',
		'after_title' => '</span>'

	));
}

add_action('widgets_init','register_footer_widget');
/*
   ================================
          social widget
   ================================
*/

class register_footer_social extends WP_Widget {
  function __construct() {
    parent::__construct( false, 'ایکن شبکه های اجتماعی-خبرنامه فوترPRK' );
  }
  function widget( $args, $instance ) {
    ?>
	<?php

		  $socialsـtrue = prk_option('socials_true');

			$socialsـicon1 = prk_option('socials_icon1');
			$socialsـicon2 = prk_option('socials_icon2');
			$socialsـicon3 = prk_option('socials_icon3');
			$socialsـicon4 = prk_option('socials_icon4');
			$socialsـicon5 = prk_option('socials_icon5');
      $socialsـicon6 = prk_option('socials_icon6');

			$socials_url1 = prk_option('socials_url1');
			$socials_url2 = prk_option('socials_url2');
			$socials_url3 = prk_option('socials_url3');
			$socials_url4 = prk_option('socials_url4');
			$socials_url5 = prk_option('socials_url5');
			$socials_url6 = prk_option('socials_url6');
	?>
	  <?php if ($socialsـtrue):?>
    <div class="foot-box mailbox">
      <span class="foot-title"><?php echo $instance['title_social'] ;?></span>
       <div class="social-foot">
         <span class="icon-social">
          <a href="<?php echo $socials_url1;?>" target="_blank" rel="nofollow"><i class="<?php echo $socialsـicon1;?>"></i></a>
          <a href="<?php echo $socials_url2;?>" target="_blank" rel="nofollow"><i class="<?php echo $socialsـicon2;?>"></i></a>
           <a href="<?php echo $socials_url3;?>" target="_blank" rel="nofollow"><i class="<?php echo $socialsـicon3;?>"></i></a>
            <a href="<?php echo $socials_url4;?>" target="_blank" rel="nofollow"><i class="<?php echo $socialsـicon4;?>"></i></a>
            <a href="<?php echo $socials_url5;?>" target="_blank" rel="nofollow"><i class="<?php echo $socialsـicon5;?>"></i></a>
            <a href="<?php echo $socials_url6;?>" target="_blank" rel="nofollow"><i class="<?php echo $socialsـicon6;?>"></i></a>
         </span>
       </div>


  <?php

   if (in_array( prk_option('footer_letter_prk'),['1','',null] ) ): ?>

    <span class="foot-title mail"><?php echo $instance['title_email'] ;?></span>

    <?php if (prk_option('footer_letter')):?>

      <?php echo do_shortcode(prk_option('footer_letter')); ?>

    <?php else:?>

    	<form class="mail-foot">
    		<input type="email" name="email" value="" placeholder="آدرس ایمیل خود را وارد کنید">
    		<button type="submit">ثبت</button>
    	</form>

    <?php endif;?>

  <?php endif;?>
    </div>



<?php endif;?>
    <?php

 }
 public function form( $instance ) {
   $title_social = ! empty( $instance['title_social'] ) ? $instance['title_social'] : "عنوان";
   $title_email = ! empty( $instance['title_email'] ) ? $instance['title_email'] : "عنوان باکس خبرنامه";

 ?>
 <style>
   .widget-box .link_in{
     padding: 8px 5px !important;
     margin: 8px 0 !important;
     border: 1px solid #3582c4 !important;
   }
 </style>
 <div class="widget-box">
 <label for="">عنوان : </label>
 <input class="widefat" type="text"  name="<?php echo $this->get_field_name('title_social'); ?>" value="<?php echo $title_social; ?>">
 <label for="">عنوان باکس خبرنامه :</label>
<input class="widefat" type="text"  name="<?php echo $this->get_field_name('title_email'); ?>" value="<?php echo $title_email; ?>">
<p>ویرایش در پنل تنظیمات قالب -> پاورقی -> شبکه های اجتماعی</p>

 </div>
 <?php
 }
 function update( $new_instance, $old_instance ) {
  $instance = $old_instance;
  $instance['title_social'] = ( $new_instance['title_social'] );
  $instance['title_email'] = ( $new_instance['title_email'] );
  $instance['instagram_link'] = ( $new_instance['instagram_link'] );
  $instance['twitter_link'] = ( $new_instance['twitter_link'] );
  $instance['linkedin_link'] = ( $new_instance['linkedin_link'] );
  $instance['facebook_link'] = ( $new_instance['facebook_link'] );
  return $instance;
}}







function register_widget_foot() {
  register_widget( 'register_footer_social' );
 }
add_action( 'widgets_init', 'register_widget_foot' );






class register_space_prk extends WP_Widget {
  function __construct() {
    parent::__construct( false, 'PRK فاصله بین ستون ها' );
  }
  function widget( $args, $instance ) {
    ?>
    <div class="foot-box space_prk">
     </div>

    <?php
 }
}

function register_space_prk() {
  register_widget( 'register_space_prk' );
 }
add_action( 'widgets_init', 'register_space_prk' );






/*
   ================================
            text widget
   ================================
*/

class register_footer_text extends WP_Widget {
  function __construct() {
    parent::__construct( false, 'PRK متن ساده' );
  }
  function widget( $args, $instance ) {
    ?>
    <div class="foot-box text">
   <span class="foot-title"><?php echo $instance['title_text'] ;?></span>
  <p>
   <?php echo  $instance['textarea_text'] ;?>
  </p>
     </div>

    <?php
 }
 public function form( $instance ) {
   $title_text = ! empty( $instance['title_text'] ) ? $instance['title_text'] : "عنوان";
   $textarea_text = ! empty( $instance['textarea_text'] ) ? $instance['textarea_text'] : "متن مورد نظر در اینجا درج شود";

 ?>
 <label for="">عنوان : </label>
 <input class="widefat" type="text"  name="<?php echo $this->get_field_name('title_text'); ?>" value="<?php echo $title_text; ?>">
 <label for="">متن :</label>
  <textarea name="<?php echo $this->get_field_name('textarea_text'); ?>"><?php echo $textarea_text; ?></textarea>
 <?php
 }
function update( $new_instance, $old_instance ) {
$instance = $old_instance;
$instance['title_text'] = ( $new_instance['title_text'] );
$instance['textarea_text'] = ( $new_instance['textarea_text'] );
return $instance;
}}

function register_footer_text() {
  register_widget( 'register_footer_text' );
 }
add_action( 'widgets_init', 'register_footer_text' );
/*
   ================================
            apps widget
   ================================
*/

class register_footer_apps extends WP_Widget {
  function __construct() {
    parent::__construct( false, 'PRK باکس دانلود اپلیکیشن' );
  }
  function widget( $args, $instance ) {

	  	$app_logo = get_parent_theme_file_uri('assets/img/icon/favicon.png' );

		  $application_logo = prk_option('application_logo');
		  if(isset($application_logo['url']) && $application_logo['url'] != '') { $app_logo = $application_logo['url']; }

			$application_name = prk_option('application_name');
			$application_url = prk_option('application_url');

			$application_pic1 = prk_option('application_pic1');
			if(isset($application_pic1['url']) && $application_pic1['url'] != '') { $pic1 = $application_pic1['url']; }
			$application_pic2 = prk_option('application_pic2');
			if(isset($application_pic2['url']) && $application_pic2['url'] != '') { $pic2 = $application_pic2['url']; }
			$application_pic3 = prk_option('application_pic3');
			if(isset($application_pic3['url']) && $application_pic3['url'] != '') { $pic3 = $application_pic3['url']; }
			$application_pic4 = prk_option('application_pic4');
			if(isset($application_pic4['url']) && $application_pic4['url'] != '') { $pic4 = $application_pic4['url']; }

			$application_url1 = prk_option('application_url1');
			$application_url2 = prk_option('application_url2');
			$application_url3 = prk_option('application_url3');
			$application_url4 = prk_option('application_url4');

		 ?>
     <?php if (prk_option('application_true')):?>
    <div class="clear"></div>
    <div class="foot-dn-app">
    <div class="dn-box">
			<a href="<?php echo $application_url;?>">
    <div class="dn-link">
     <img src="<?php echo esc_url($app_logo); ?>" alt="Download app">
     <span class="name-app"><?php echo $application_name;?></span>
    </div>
		</a>
    <div class="imgs-dn">

    <?php if ($pic1): ?>
    <a href="<?php echo$application_url1 ;?>">
      <div class="img-dn-link">
        <img src="<?php echo esc_url($pic1); ?>" alt="Download app">
      </div>
    </a>
     <?php endif; ?>

     <?php if ($pic2): ?>
		 <a href="<?php echo$application_url2 ;?>">
      <div class="img-dn-link">
        <img src="<?php echo esc_url($pic2); ?>" alt="Download app">
      </div>
      </a>
    <?php endif; ?>

    <?php if ($pic3): ?>
		<a href="<?php echo$application_url3 ;?>">
      <div class="img-dn-link">
        <img src="<?php echo esc_url($pic3); ?>" alt="Download app">
      </div>
    </a>
    <?php endif; ?>


   <?php if ($pic4): ?>
  	  <a href="<?php echo$application_url4 ;?>">
        <div class="img-dn-link">
          <img src="<?php echo esc_url($pic4); ?>" alt="Download app">
        </div>
      </a>
    <?php endif; ?>

    <?php if ( prk_option('info_dnapp') ): ?>
     <div class="info-all-dn-link">
       <a href="<?php echo prk_option('info_dnapp_url');?>">
       <?php echo prk_option('info_dnapp');?><i class="ri-arrow-drop-left-line"></i>
       </a>
     </div>
    <?php endif; ?>


    </div>
    </div>
       </div>
		 <?php endif;?>
    <?php
 }
 public function form( $instance ) {

 ?>
 <p>ویرایش در پنل تنظیمات قالب فوتر -> باکس اپلیکیشن</p>
 <?php
 }


}
function register_footer_apps() {
  register_widget( 'register_footer_apps' );
 }
add_action( 'widgets_init', 'register_footer_apps' );

/*
   ================================
          register posts widget
   ================================
*/
function register_sidebar_post_widget(){
register_sidebar(array(
		'name' => 'نوار سایدبار پست',
		'id' => 'sideby-post-widget',
		'before_widget' => '<div class="widget side-box-post">',
		'after_widget' => '</div>',
		'before_title' => '<span class="side-title-post">',
		'after_title' => '</span>'
	));
}

add_action('widgets_init','register_sidebar_post_widget');


/*
   ================================
          register posts widget
   ================================
*/
function register_section_main_widget(){
  register_sidebar(array(
      'name' => 'نوار بدنه',
      'id' => 'section-main-widget',
      'before_widget' => '<div class="widget main-section">',
      'after_widget' => '</div>',
    ));
  }
  
  add_action('widgets_init','register_section_main_widget');
 
  
/*
   ================================
            search posts widget
   ================================
*/

class register_search_posts extends WP_Widget {
  function __construct() {
    parent::__construct( false, 'جستجوی نوشته ها PRK' );
  }
  function widget( $args, $instance ) {
    ?>

		<div class="widget side-box-post">
	    <span class="side-title-post"><?php echo $instance['title_search'];?></span>
	      <form class="side-form-search search-posts" action="<?php bloginfo('url'); ?>" method="get">
	        <input type="search" name="s" placeholder="جستجو برای ...">
					<input type="hidden" name="post_type" value="post" />
         <button type="submit"><i class="prk-search-normal-1"></i></button>
	      </form>
	  </div>
    <?php
 }
 public function form( $instance ) {
 $title_search = ! empty( $instance['title_search'] ) ? $instance['title_search'] : "عنوان";
 ?>
 <label for="">عنوان : </label>
 <input class="widefat" type="text"  name="<?php echo $this->get_field_name('title_search'); ?>" value="<?php echo $title_search; ?>">
  <p>قابل ویرایش در فهرست ها !</p>
 <?php
 }

function update( $new_instance, $old_instance ) {
$instance = $old_instance;
$instance['title_search'] = ( $new_instance['title_search'] );
return $instance;
}
}
function register_search_posts() {
  register_widget( 'register_search_posts' );
 }
add_action( 'widgets_init', 'register_search_posts' );
/*
   ================================
             posts widget
   ================================
*/

class register_posts extends WP_Widget {
  function __construct() {
    parent::__construct( false, 'نوشته های ابزارک PRK' );
  }
  function widget( $args, $instance ) {
    ?>
		<div class="widget side-box-post">
	    <span class="side-title-post"><?php echo $instance['title_posts'];?></span>
	      <?php

	      $args = array(
	        'post_type' => 'post',
	        'posts_per_page' => $instance['num_posts'],
					'cat' => $instance['select_posts'],

	      );

	    $the_query = new WP_Query( $args ); ?>
	    <?php if ( $the_query->have_posts() ) : ?>
	      <div class="side-rond-posts">
	          <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
	        <article class="side-item-post">
						<a href="<?php the_permalink();?>">
	        <div class="side-thumb-post">
	       <?php the_post_thumbnail();?>
	        </div>
					</a>
	        <div class="side-h2-post">
	        <a href="<?php the_permalink();?>"><h2><?php the_title();?></h2></a>
	        </div>
	        </article>
	       <?php endwhile;?>
	      </div>
	      <?php wp_reset_postdata(); ?>
	      <?php endif; ?>
	  </div>
    <?php
 }
 public function form( $instance ) {
 $title_posts = ! empty( $instance['title_posts'] ) ? $instance['title_posts'] : "عنوان";
  $num_posts = ! empty( $instance['num_posts'] ) ? $instance['num_posts'] : "6";
	$select_posts  = isset( $instance['select_posts'] ) ? absint( $instance['select_posts'] ) : 1;
 ?>
 <label for="">عنوان : </label>
 <input class="widefat" type="text"  name="<?php echo $this->get_field_name('title_posts'); ?>" value="<?php echo $title_posts; ?>">
 <label for="">تعداد نمایش پست ها :</label>
 <input class="widefat" type="number"  name="<?php echo $this->get_field_name('num_posts'); ?>" value="<?php echo $num_posts; ?>">
 <label for="">انتخاب دسته بندی: </label>
	<select class="select_posts" id="<?php echo $this->get_field_id('select_posts'); ?>" name="<?php echo $this->get_field_name('select_posts'); ?>">
			<?php
			$this->categories = get_categories();
			foreach ( $this->categories as $cat ) {
					$selected = ( $cat->term_id == esc_attr( $select_posts ) ) ? ' selected = "selected" ' : '';
					$option = '<option '.$selected .'value="' . $cat->term_id;
					$option = $option .'">';
					$option = $option .$cat->name;
					$option = $option .'</option>';
					echo $option;
			}
			?>
	</select>
 <?php
 }

function update( $new_instance, $old_instance ) {
$instance = $old_instance;
$instance['title_posts'] = ( $new_instance['title_posts'] );
$instance['num_posts'] = ( $new_instance['num_posts'] );
$instance['select_posts']   = (int) $new_instance['select_posts'];
return $instance;
}
}
function register_posts() {
  register_widget( 'register_posts' );
 }
add_action( 'widgets_init', 'register_posts' );
/*
   ================================
            search posts widget
   ================================
*/




function register_sidebar_pro_widget(){
register_sidebar(array(
		'name' => 'نوار سایدبار فروشگاه',
		'id' => 'sideby-pro-widget',


	));
}
add_action('widgets_init','register_sidebar_pro_widget');



class register_product_search extends WP_Widget {
  function __construct() {
    parent::__construct( false, 'جستجوی محصولات PRK' );
  }
  function widget( $args, $instance ) {
    ?>
		<li class="widget side-box-post prk_filter_woocomerce">
	    <h2 class="widgettitle"><?php echo $instance['title_product_search'];?></h2>
        <ul class="woocommerce-widget-layered-nav-list">
	      <form style="margin-top: 20px;" class="side-form-search search-products" action="<?php bloginfo('url'); ?>" method="get">
						<input type="text" name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php echo __( 'The desired product name...', 'parskala' ); ?>"  required="required"/>
	           <input type="hidden" name="post_type" value="product" />
           <button type="submit"><i class="prk-search-normal-1"></i></button>
	      </form>
        </ul>
	  </li>
    <?php
 }
 public function form( $instance ) {
 $title_search = ! empty( $instance['title_product_search'] ) ? $instance['title_product_search'] : "جستجو در تنایج";
 ?>
 <label for="">عنوان</label>
 <input class="widefat" type="text"  name="<?php echo $this->get_field_name('title_product_search'); ?>" value="<?php echo $title_product_search; ?>">
 <?php
 }

function update( $new_instance, $old_instance ) {
$instance = $old_instance;
$instance['title_product_search'] = ( $new_instance['title_product_search'] );
return $instance;
}
}
function register_product_search() {
  register_widget( 'register_product_search' );
 }
add_action( 'widgets_init', 'register_product_search' );





class register_free_orders extends WP_Widget {
  function __construct() {
    parent::__construct( false, 'سفارش های رایگان PRK' );
  }
  function widget( $args, $instance ) {
    ?>
  <div style="padding: 0;" class="widget">
   <div class="img-free">
  <img src="<?php bloginfo('template_url');?>/assets/img/free.png" alt="">
   </div>
   <div class="header-free">
    <span class="titles-free">ارسال رایگان سفارش</span>
		<span class="text-order">سفارش های بالای ۳۰۰ هزار تومانی</span>
   </div>
  </div>
    <?php
 }
 public function form( $instance ) {
 $title_search = ! empty( $instance['title_posts'] ) ? $instance['title_posts'] : "عنوان";
 ?>
 <label for="">عنوان اول</label>
 <input class="widefat" type="text"  name="<?php echo $this->get_field_name('titles_orders'); ?>" value="<?php echo $titles_orders; ?>">
 <label for="">عنوان دوم</label>
 <input class="widefat" type="text"  name="<?php echo $this->get_field_name('text_orders'); ?>" value="<?php echo $text_orders; ?>">
 <?php
 }

function update( $new_instance, $old_instance ) {
$instance = $old_instance;
$instance['titles_orders'] = ( $new_instance['titles_orders'] );
$instance['text_orders'] = ( $new_instance['text_orders'] );
return $instance;
}
}
function register_orders() {
  register_widget( 'register_free_orders' );
 }
add_action( 'widgets_init', 'register_orders' );


class register_pro_ads extends WP_Widget {
  function __construct() {
    parent::__construct( false, 'تبلیغات محصول PRK' );
  }
  function widget( $args, $instance ) {
    // داینامیک کردن اتریبیوتیک
  	$settings_slider =  array(
  		'loop' => 1,
  		'autoplay' => "true",
  		'delay' => 3000,
  	);
  	$json_settings = json_encode($settings_slider);

    ?>

		<div class="widget side-box-post">
			<div class="hanis" settings-slider='<?php echo $json_settings; ?>'>
				<?php
						 $arms = array(
								 'post_type' => 'product',
								 'post_status' => 'publish',
								 'tax_query'     => array(
											array(
													'taxonomy'  => 'product_cat',
													'field'     => 'id',
													'terms'     => $instance['select_pro'],

											)
									),
						 );
						 $pd_query = new WP_Query( $arms ); ?>
						 <?php if ( $pd_query ->have_posts() ) : ?>
							 <?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post(); ?>
								<?php get_template_part( '/inc/template/product-carosel' ); ?>
								<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
							<?php else:?>
				<p>محصولی موجود نیست !</p>
					<?php endif;?>
			</div>
	  </div>
    <?php
 }
 public function form( $instance ) {

	$select_posts  = isset( $instance['select_pro'] ) ? absint( $instance['select_pro'] ) : 1;
 ?>
 <label for="">انتخاب دسته بندی: </label>
	<select class="select_pro" id="<?php echo $this->get_field_id('select_pro'); ?>" name="<?php echo $this->get_field_name('select_pro'); ?>">
			<?php
			$this->categories = get_categories(array('taxonomy'=> 'product_cat'));
			foreach ( $this->categories as $cat ) {
					$selected = ( $cat->term_id == esc_attr( $select_pro ) ) ? ' selected = "selected" ' : '';
					$option = '<option '.$selected .'value="' . $cat->term_id;
					$option = $option .'">';
					$option = $option .$cat->name;
					$option = $option .'</option>';
					echo $option;
			}
			?>
	</select>
 <?php
 }

function update( $new_instance, $old_instance ) {
$instance = $old_instance;
$instance['select_pro']   = (int) $new_instance['select_pro'];
return $instance;
}
}
function register_pro() {
  register_widget( 'register_pro_ads' );
 }
// add_action( 'widgets_init', 'register_pro' );


function prk_numeric_posts_nav()
	{
	if (is_singular()) return;
	global $wp_query;
	/** Stop execution if there's only 1 page */
	if ($wp_query->max_num_pages <= 1) return;
	$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
	$max = intval($wp_query->max_num_pages);
	/** Add current page to the array */
	if ($paged >= 1) $links[] = $paged;
	/** Add the pages around the current page to the array */
	if ($paged >= 3)
		{
		$links[] = $paged - 1;
		$links[] = $paged - 2;
		}

	if (($paged + 2) <= $max)
		{
		$links[] = $paged + 2;
		$links[] = $paged + 1;
		}

	echo '<div class="blog woocommerce-pagination"><ul>' . "\n";
	/** Previous Post Link */
	if (get_previous_posts_link()) printf('<li>%s</li>' . "\n", get_previous_posts_link());
	/** Link to first page, plus ellipses if necessary */
	if (!in_array(1, $links))
		{
		$class = 1 == $paged ? ' class="current"' : '';
		printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)) , '1');
		if (!in_array(2, $links)) echo '<li>…</li>';
		}

	/** Link to current page, plus 2 pages in either direction if necessary */
	sort($links);
	foreach((array)$links as $link)
		{
		$class = $paged == $link ? ' class="current"' : '';
		printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)) , $link);
		}

	/** Link to last page, plus ellipses if necessary */
	if (!in_array($max, $links))
		{
		if (!in_array($max - 1, $links)) echo '<li>…</li>' . "\n";
		$class = $paged == $max ? ' class="current"' : '';
		printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)) , $max);
		}

	/** Next Post Link */
	if (get_next_posts_link()) printf('<li>%s</li>' . "\n", get_next_posts_link());
	echo '</ul></div>' . "\n";
	}
