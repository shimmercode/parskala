<?php

/*

 template name: برگه سوالات متداول

 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
global $wp;
$current_page = home_url( $wp->request );

$title_question = prk_option('title_faq_cat_box');
$subtab_question = prk_option('subtitle_faq_cat_box');
$placeholder_search = prk_option('placeholder_search_faq_cat_box');
?>

  <div id="prk_content" class="ajax_load">

	<div class="ask_top_page">

	  <div class="faq_headerbox">
      <div class="circle_btn_icon">
        <i class="ri-question-mark"></i>
      </div>

		  <h4 class="page_title"><?php echo $title_question; ?></h4>
			<p class="page_subtitle"><?php echo $subtab_question; ?></p>

		  <form class="form_search_faqpage" action="<?php echo $current_page; ?>" method="get">
		    <input id="text_search" class="input_field" type="text" name="q" oninput="ajax_faq_search();" value="" autocomplete="off" placeholder="<?php echo $placeholder_search; ?>">
				<!-- <input class="search-submit" type="submit" value="<?php echo __('جستجو','parskala') ?>"> -->
				<div class="main_result_ajax_ask_search"></div>
		  </form>

	  </div>

	</div>

<div class="general_faq_box">

  <div class="content_ask_page">
    <?php
      if(isset($_GET['cat']) || isset($_GET['question']) || isset($_GET['q'])){

    ?>

    <a href="<?php the_permalink(); ?>" class="get_back_button"><?php echo __('بازگشت','parskala') ?></a>

    <?php
      }
    ?>
    <?php
		if(isset($_GET['cat']) || isset($_GET['question']) || isset($_GET['q'])){
     $title_class = 'asked_questions_title';
		}else {
			$title_class = '';
		}
      if(isset( $_GET['cat'] )){
        $cat_id = $_GET['cat'] ;
        $args = [
          'post_type' => 'prkfaq',
          'posts_per_page' => -1,
          'tax_query' => [
            [
              'taxonomy' => 'faq_cat',
              'terms' => $cat_id,
            ],
          ],
        // Rest of your arguments
        ];
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ){
          while ( $the_query->have_posts() ){
            $the_query->the_post();
    ?>

    <div class="asked_questions_box">
      <button class="ask_accordion"><?php the_title(); ?><span class="toggle_icon"></span></button>
      <div class="panel">
        <?php the_excerpt(15); ?>
        <a href="<?php echo $current_page.'?question='.get_the_ID(); ?>" class="link_of_faq_post"><?php echo __('مشاهده توضحیات تکمیلی','parskala');?></a>
      </div>
    </div>

    <?php
    }
    wp_reset_query();
      }
      else{
        echo '<h2 class="post_title">'.__('پرسشی وجود ندارد !','parskala').'</h2>';
      }
        }elseif(isset( $_GET['question'] )){
          $post_id = $_GET['question'] ;
          $args = array(
            'p'         => $post_id,
            'post_type' => 'prkfaq'
          );
          $my_posts = new WP_Query($args);
          if ( $my_posts->have_posts() ){
            while ( $my_posts->have_posts() ){
              $my_posts->the_post();
    ?>
		<div class="post_title">
			 <?php the_title(); ?>
		</div>
             <div class="main-content-asked">

					      	<?php the_content(); ?>
              </div>
    <?php
          }
          wp_reset_query();
        }else{
          echo '<h2 class="post_title">'.__('پرسشی وجود ندارد !','parskala').'</h2>';
        }
      }elseif(isset( $_GET['q'])){
        $string_of_search = $_GET['q'];
        $args = array(
            'post_type' => 'prkfaq',
            's' => $string_of_search,
        );
        query_posts($args);
        $searh_post = new WP_Query($args);
        if ( $searh_post->have_posts() ){
          while ( $searh_post->have_posts() ){
            $searh_post->the_post();
      ?>
      <div class="asked_questions_box">
        <button class="ask_accordion"><?php the_title(); ?><span class="toggle_icon"></span></button>
        <div class="panel">
          <?php the_excerpt(15); ?>
          <a href="<?php echo $current_page.'?question='.get_the_ID(); ?>" class="link_of_faq_post"><?php echo __('مشاهده توضحیات تکمیلی','parskala');?></a>
        </div>
      </div>
      <?php
          }
          wp_reset_query();
        }else{
          echo __('نتیجه ای یافت نشد!','parskala');
        }
      }else{

				$faq_cats = prk_option('faq_cats');
				if ($faq_cats) {

    ?>

		<div class="asked_btn_icon">
			<i class="prk-element-plus"></i>
		</div>

    <span class="title_cat_box"><?php echo prk_option('title_faq_cat_box'); ?></span>
    <div class="main_box_ask_cats">

    <?php


				$counter = 0;

			if ($faq_cats) {
        foreach($faq_cats as $faq_cat){
					$term = get_term( $faq_cat['faq_category'] );

          if ( mobile_cheker() || tablet_cheker() ) {

						if( $counter == 3 ){ $counter = 0 ;}
             $mob_count = '2';
          }else {

          	if( $counter == 6 ){ $counter = 0 ;}
            $mob_count = '5';
          }

					$meta = get_term_meta( $term->term_id, 'prk_faq_cat_taxonomy_options', true );
					if ( isset( $meta['faq_cat_image'] ) )		$faq_image    = $meta['faq_cat_image']['url'];
          ?>
      <a href="<?php if($faq_cat['faq_category']){ echo $current_page.'?cat='.$faq_cat['faq_category']; }else{ echo '#';} ?>" class="link_ask_cats border_bottom <?php if($counter < $mob_count){ echo 'border_left';} ?>">
        <?php if ($faq_image): ?>

					<img src="<?php echo $faq_image; ?>">

        <?php else: ?>

					<?php echo wc_placeholder_img(); ?>

        <?php endif; ?>


        <span><?php echo $term->name; ?></span>
      </a>
    <?php
      $counter++;

        }
      }
    ?>
    </div>
    <?php
      }
		}
    ?>
  </div>



</div>

<?php
	$frequently_asked_questions = prk_option('frequently_asked_questions');
  $title_frequently_asked_questions = prk_option('title_frequently_asked_questions');
	if($frequently_asked_questions){
?>
<div class="accordion_faq_questions">

	<div class="asked_btn_icon">
		<i class="prk-element-plus"></i>
	</div>

	<span class="frequently_asked_questions_title"><?php echo $title_frequently_asked_questions ?></span>

	<?php
			$args = array(
				'post__in'         => $frequently_asked_questions,
				'post_type' => 'prkfaq'
			);
			$my_posts = new WP_Query($args);
			if ( $my_posts->have_posts() ){
				while ( $my_posts->have_posts() ){
					$my_posts->the_post();
	?>
	<div class="asked_questions_box">
		<button class="ask_accordion"><?php the_title(); ?><span class="toggle_icon"></span></button>
		<div class="panel">
			<p><?php the_excerpt(15); ?></p>
			<a href="<?php echo $current_page.'?question='.get_the_ID(); ?>" class="link_of_faq_post"><?php echo __('مشاهده توضحیات تکمیلی','parskala');?></a>
		</div>
	</div>
	<?php
			}
		}
	?>



</div>
</div>
<?php
	}
?>
    <script>
			var access_do_ajaxs_ask = true;
			function ajax_faq_search(){
					var length_texts = jQuery('#text_search').val().length;
					if ( length_texts >= 4 && access_do_ajaxs_ask ) {

						access_do_ajaxs_ask = false;
							jQuery.ajax({
								type: "GET",
								url: parskala_values.ajax_url ,
								data:  {
									action: 'prk_ajax_faq_search',
									s: jQuery('#text_search').val(),
									post_type: 'prkfaq',
									current_page: '<?php echo $current_page; ?>'
									},
								success: function(msg){
									jQuery('.main_result_ajax_ask_search').show(0);
									jQuery('.main_result_ajax_ask_search').html(msg);
									jQuery('.faq_headerbox .circle_btn_icon').html('<i class="ri-search-2-line"></i>');
									jQuery('.faq_headerbox .page_title').html('نتایج جستجو');
									jQuery('.faq_headerbox .page_subtitle').addClass('fadeOut');
									access_do_ajaxs_ask = true;
									console.log('SEARCH SUCCESS!');
								}
							});
					} else {
						jQuery('.main_result_ajax_ask_search').hide(0);
						jQuery('.main_result_ajax_ask_search').html('');
						jQuery('.faq_headerbox .circle_btn_icon').html('<i class="ri-question-mark"></i>');
						jQuery('.faq_headerbox .page_title').html('<?php echo $title_question; ?>');
						jQuery('.faq_headerbox .page_subtitle').removeClass('fadeOut');
					}
				}


    </script>

<?php
get_footer();
