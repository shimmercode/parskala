<?php

/**
 *  Advanced ajax search system parskala
 *
 * @package      ajax search
 * @Author      Hosein Esmalian
 * @link        http://parskalas.ir
 */


add_shortcode('prk_search', function($attr){

  $img_banner_search = '';
  $search_placeholder = prk_option('search_placeholder') ? prk_option('search_placeholder') : __('Quick search','parskala');
  $repeater = prk_option('better_seardched');
  $img_banner_search = prk_option('img_banner_search');
  $url_banner_search = prk_option('url_banner_search');
  $themeـstyle = prk_option('theme-style');
  $checker = new mob_cheker;

    $_placeholder = $search_placeholder;

  ob_start();

  $unic_id = generateRandomString();

  $attr = shortcode_atts( array(
  	'class' => 'search_input',
  	'id' => '',
  	'placeholder' => $search_placeholder,
  ), $attr );


if (prk_option('header_style_type') == 'style_2' ){
  $header_type = 'header_2';
}else{
  $header_type = 'header_def';
}

?>

  
  <!-- فرم جستجو پیشرفته -->
	<form id="<?php echo $attr['id']; ?>" class="form_search desktop <?= $header_type ?> <?php echo $attr['class']; if($themeـstyle == 'parskala'){echo ' parskala';}else{echo ' prk-plus';} ?> search-section" action="<?php bloginfo('url'); ?>" method="get" >
  <?php
    if(prk_option('header_style_type') == 'style_2'){
      wp_dropdown_categories(array(
        'taxonomy' => 'product_cat',
        'name' => 'product_cat',
        'show_option_all' => 'انتخاب دسته بندی',
        'hide_empty' => 0,
        'hierarchical' => 1,
        'selected' => isset($_GET['product_cat']) ? $_GET['product_cat'] : 0,
        'value_field' => 'slug',
        'class' => 'postform',
        'id' => 'searchform_cat',
     ));
    }
  ?>
  
  <input class="prk_input_serach" autocomplete="off" oninput="ajax_search()" value="<?php echo (!empty($_GET['s']) ? $_GET['s']:''); ?>" type="text" name="s" id="txt_search" placeholder="<?php echo $_placeholder; ?>">
	  <input type="hidden" value="product" name="post_type" >
	 
    <button type="submit" id="submit_search" value=""> <i class="prk-search-normal-1"></i> </button>
	  <div class="clear"></div>

		<div class="main_results_ajax_search" style="display: none;" >
      <span class="prk_close_search_box"><i class="ri-arrow-right-line"></i></span>
      <span class="prk_close_search_result"><i class="ri-close-circle-fill"></i></span>
       <div class="products_resulter">

       </div>

       <!-- تصویر بنر جستجو-->
      <?php if ( $img_banner_search['url'] ):?>
        <div class="search_image">
          <a href="<?php echo $url_banner_search;?>">
            <img src="<?php echo $img_banner_search['url'];?>" alt="جستجو">
          </a>
        </div>
      <?php endif;?>
      
       <!-- جستجوی پر طرفدار-->
       <?php if($repeater) {
				  echo '<div class="promote_searchs">';
			    echo '<span><i class="prk-trend-up"></i> '.__('Popular search','parskala').'</span>';
					echo '<ul class="search-result-tags">';

					foreach($repeater as $item) {

						 $bloginfo = get_bloginfo('url');
							echo '<li>';
							echo '<a href="'.$bloginfo.'/?s='.$item['searched_title'].'&post_type=product" class="search-result-tag">'.$item['searched_title'].' <i class="ri-arrow-left-s-line"></i></a>';
              echo '</li>';

					}
					echo '</ul></div>';
			 }?>



    </div>


	</form>

  <?php if ( prk_option('prk_modern_mobile') && ! 'digikala' == theme_style() && mobile_cheker() || tablet_cheker() ): ?>
    <!-- فرم جستجو پیشرفته -->
  	<form id="<?php echo $attr['id']; ?>" class="form_search  <?php echo $attr['class']; if($themeـstyle == 'parskala'){echo ' parskala';}else{echo ' prk-plus';} ?> search-section" action="<?php bloginfo('url'); ?>" method="get" >
  	  <input class="prk_input_serach" autocomplete="off" oninput="ajax_search()" value="<?php echo @$_GET['s']; ?>" type="text" name="s" id="txt_search" placeholder="<?php echo $_placeholder; ?>">
  	  <input type="hidden" value="product" name="post_type" >
  	  <div class="clear"></div>

  		<div class="main_results_ajax_search" style="display: none;" >


        <span class="prk_close_search_result"><i class="ri-close-circle-fill"></i></span>

         <div class="products_resulter">

         </div>


      </div>


  	</form>
  <?php endif; ?>

	<script>

	var access_do_ajax = true;

	function ajax_search(){

			var length_text = jQuery('.prk_input_serach').val().length;
      if ( length_text >= 1) {
        jQuery('.prk_close_search_result').show();

      }else {
        jQuery('.prk_close_search_result').hide();
        jQuery('#submit_search i').show();
      }
			if ( length_text >= 4 && access_do_ajax ) {

				access_do_ajax = false;

				jQuery('.main_results_ajax_search').show(0);
        // var productCat = jQuery('.form_search #productcat');
					jQuery.ajax({
						type: "GET",
						url: parskala_values.ajax_url ,
						data:  {
							action: 'ajax_search_onliner',
              product_cat: jQuery('.form_search #searchform_cat').find(":selected").val(),
							s: jQuery('.prk_input_serach').val(),
							post_type: 'product'
							},
						success: function(msg){
              jQuery('.search_image').hide(150);
							jQuery('.main_results_ajax_search').show(0);
							jQuery('.main_results_ajax_search .products_resulter').html(msg);

							access_do_ajax = true;
							console.log('SEARCH SUCCESS!');
						}
					});

			} else {

        jQuery('.search_image').show(100);
				jQuery('.main_results_ajax_search .products_resulter').html('');

			}

		}

	</script>


		<?php


return ob_get_clean();
});




add_shortcode('prk_search_mobile', function($attr){

  if ( prk_option('prk_modern_mobile') && mobile_cheker() || tablet_cheker() ) {

  $search_placeholder = prk_option('search_placeholder') ? prk_option('search_placeholder') : __('Quick search','parskala');
  $repeater = prk_option('better_seardched');
  $img_banner_search = prk_option('img_banner_search');
  $url_banner_search = prk_option('url_banner_search');
  $themeـstyle = prk_option('theme-style');

    $_placeholder = $search_placeholder;

  ob_start();

  $unic_id = generateRandomString();

  $attr = shortcode_atts( array(
  	'class' => 'search_input',
  	'id' => '',
  	'placeholder' => $search_placeholder,
  ), $attr );

  ?>

	</form>

    <!-- فرم جستجو پیشرفته -->
  	<form id="<?php echo $attr['id']; ?>" class="form_search mobile <?php echo $attr['class']; if($themeـstyle == 'parskala'){echo ' parskala';}else{echo ' prk-plus';} ?> search-section" action="<?php bloginfo('url'); ?>" method="get" >
  	  <input class="prk_input_serach" autocomplete="off" oninput="ajax_search()" value="<?php echo @$_GET['s']; ?>" type="text" name="s" id="txt_search" placeholder="<?php echo $_placeholder; ?>">
      <span type="submit" id="submited_search" value=""> <i class="prk-search-normal-1"></i> </span>
      <input type="hidden" value="product" name="post_type" >
  	  <div class="clear"></div>

  		<div class="main_results_ajax_search">


        <span class="prk_close_search_result"><i class="ri-close-circle-fill"></i></span>

         <div class="products_resulter">

         </div>


      </div>

  	</form>

    <div class="prk_search_alert">
        <i class="prk-box-search"></i>
        <p>محصول مورد نظر خود را جستجو کنید.</p>
    </div>

	<script>

	var access_do_ajax = true;
  var parskala_values = {"ajax_url":"<?php echo admin_url( 'admin-ajax.php' ); ?>","elementor_editor":"disable"};
	function ajax_search(){

			var length_text = jQuery('.prk_input_serach').val().length;
      if ( length_text >= 1) {
        jQuery('.prk_close_search_result').show();

      }else {
        jQuery('.prk_close_search_result').hide();
        jQuery('#submit_search i').show();
      }
			if ( length_text >= 4 && access_do_ajax ) {

				access_do_ajax = false;

				jQuery('.main_results_ajax_search').show(0);
        // var productCat = jQuery('.form_search #productcat');

					jQuery.ajax({
						type: "GET",
						url: parskala_values.ajax_url ,
						data:  {
							action: 'ajax_search_onliner',
              product_cat: jQuery('.form_search #searchform_cat').find(":selected").val(),
							s: jQuery('.prk_input_serach').val(),
             
							post_type: 'product'
							},
						success: function(msg){
              jQuery('.search_image').hide(150);
							jQuery('.main_results_ajax_search').show(0);
							jQuery('.main_results_ajax_search .products_resulter').html(msg);

							access_do_ajax = true;
							console.log('SEARCH SUCCESS!');
						}
					});

			} else {

        jQuery('.search_image').show(100);
				jQuery('.main_results_ajax_search .products_resulter').html('');

			}

		}

	</script>


		<?php

    }
return ob_get_clean();
});

add_filter( 'woocommerce_redirect_single_search_result', '__return_false' );


add_filter('posts_search', 'prk_search_by_title_only', 501, 2);

function prk_search_by_title_only( $search, $wp_query ){

    global $wpdb;

    if( empty($search) ) {
        return $search; // skip processing - no search term in query
    }

    $q = $wp_query->query_vars;

	if ( $q['post_type'] !== 'product' ) {
		return $search;
		// skip processing
	}

	if ( ! is_admin() || wp_doing_ajax() ){

		$n = !empty($q['exact']) ? '' : '%';
		$search = '';
		$searchand = '';
		foreach ((array)$q['search_terms'] as $term) {
			$term = esc_sql($wpdb->esc_like($term));
			$search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";

			// Search in SKU

				$search .= " OR (parskala_meta.meta_key='_sku' AND parskala_meta.meta_value LIKE '{$n}{$term}{$n}')";
        $search .= " OR (parskala_meta.meta_key='en_pro_name' AND parskala_meta.meta_value LIKE '{$n}{$term}{$n}')";

			$searchand = ' AND ';
		}

		if (!empty($search)) {
			$search = " AND ({$search}) ";
			if (!is_user_logged_in())
				$search .= " AND ($wpdb->posts.post_password = '') ";
		}
	}


    return $search;

}



add_filter( 'posts_join', 'searchFiltersJoin', 501, 2 );
function searchFiltersJoin( $join, $query )
    {
        global  $wpdb ;

        if ( empty($query->query_vars['post_type']) || $query->query_vars['post_type'] !== 'product' ) {
            return $join;
            // skip processing
        }


		if ( ! is_admin() || wp_doing_ajax() ){

			// Search in meta key
            if ( $query->is_search() ) {
                $join .= " INNER JOIN {$wpdb->postmeta} AS parskala_meta ON ( {$wpdb->posts}.ID = parskala_meta.post_id )";
            }


		}
        return $join;
    }




function tax_search_groupby( $groupby, $wp_query){
  global $wpdb;

    if ($wp_query->is_search() && $wp_query->query['post_type'] == 'product' )
		$groupby = "{$wpdb->posts}.ID";

  return $groupby;
}
add_filter('posts_groupby', 'tax_search_groupby', 10, 2);




// جستجوی ایجکس
if ( class_exists( 'WooCommerce' ) ) {
add_action('wp_ajax_nopriv_ajax_search_onliner', 'ajax_search_onliner', 999);
add_action('wp_ajax_ajax_search_onliner', 'ajax_search_onliner', 999);
}

function ajax_search_onliner(){

	$keyword = esc_attr($_GET['s']).' ';
  $product_cat = isset($_GET['product_cat']) ? $_GET['product_cat'] : '';

	$args = array(
    'product_cat'         => $product_cat,
		's'                   => $keyword,
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		      'order'               => 'DESC', // قبلاً اشتباه 'DECS' بود
      'meta_query'          => array(
          array(
              'key'   => '_stock_status',
              'value' => 'instock',
          ),
      ),
	);
	$query = new WP_Query( $args );
  
  if ( !mobile_cheker() || !tablet_cheker() && !prk_option('prk_modern_mobile') ) {

    if (prk_option('prk_style_search_viewed') == 'lists' ){
      
      if($query->have_posts()){
        echo '<div class="product_results"><div class="article-searched-slider">';
          while ($query->have_posts()):
            $query->the_post();
            global $product;
            $price = get_post_meta( get_the_ID(), '_regular_price', true);
            ?>
              <article class="product_seached">
                <a href="<?php the_permalink();?>">
                  <div class="product_seached_image">
                  <?php echo the_post_thumbnail('small');?>
                  </div>
                <div class="flexed" style="width: 85%;">
                <div class="product_s_title">
                  <?php the_title();?>
                </div>
                <!--price-->
                <div class="index-prices-pro">
    
                  <div class="price_onsale_ar">
    
                      <?php if ($price|| $product->is_type( 'variable' )) {
                        echo $product->get_price_html();
                      }else{
                        echo '<p class="call_pro">', _e('call' , 'parskala'). '</p>';}
                      ?>
    
                  </div>
    
                </div>
                </div>
    
                </a>
    
              </article>
    
            <?php
          endwhile;
    
    
        wp_reset_postdata();
        $has_result = true;
        echo '</div></div>';
      } else {
        echo '<span class="not_resulted">'. __('موردی یافت نشد', 'parskala').'<i class="ri-emotion-sad-line"></i></span>';
        $has_result = false;
      }
    }else{

      // داینامیک کردن اتریبیوتیک
      $settings_slider =  array(
        'loop' => 'false',
        'nav' => 'true',
        'autoplay' => 'false',
        'item' => '2',
        'Paddings' => '50',
        'margins' => 8,
      );
      $json_settings = json_encode($settings_slider);
      if($query->have_posts()){
        echo '<div class="product_results"><div class="article-off" settings-slider='.$json_settings.'>';
          while ($query->have_posts()):
            $query->the_post();

            ?>
              <article class="product_seached">
                <a href="<?php the_permalink();?>">
                  <div class="thumb-off">
                    <img class="t1 shower" src="<?php echo the_post_thumbnail_url();?>" alt="">
                  </div>
                <div class="product_s_title">
                  <?php the_title();?>
                </div>
                </a>
              </article>
            <?php
          endwhile;


        wp_reset_postdata();
        $has_result = true;
        echo '</div></div>';
      } else {
        echo '<span class="not_resulted">'. __('موردی یافت نشد', 'parskala').'<i class="ri-emotion-sad-line"></i></span>';
        $has_result = false;
      }

    }
 }
 else{

    if($query->have_posts()){
      echo '<div class="product_results"><div class="article-searched-slider">';
        while ($query->have_posts()):
          $query->the_post();
          global $product;
          $price = get_post_meta( get_the_ID(), '_regular_price', true);
          ?>
            <article class="product_seached">
              <a href="<?php the_permalink();?>">
                <div class="product_seached_image">
                <?php echo the_post_thumbnail('small');?>
                </div>
              <div class="flexed" style="width: 85%;">
              <div class="product_s_title">
                <?php the_title();?>
              </div>
              <!--price-->
              <div class="index-prices-pro">
  
                <div class="price_onsale_ar">
  
                    <?php if ($price|| $product->is_type( 'variable' )) {
                      echo $product->get_price_html();
                    }else{
                      echo '<p class="call_pro">', _e('call' , 'parskala'). '</p>';}
                    ?>
  
                </div>
  
              </div>
              </div>
  
              </a>
  
            </article>
  
          <?php
        endwhile;
  
  
      wp_reset_postdata();
      $has_result = true;
      echo '</div></div>';
    } else {
      echo '<span class="not_resulted">'. __('موردی یافت نشد', 'parskala').'<i class="ri-emotion-sad-line"></i></span>';
      $has_result = false;
    }

  }




  $args = array(
      'product_cat'         => $product_cat,
      's'                   => $keyword,
      'post_type'           => 'product',
      'post_status'         => 'publish',
      'ignore_sticky_posts' => 1,
      'order'               => 'DESC', // قبلاً اشتباه 'DECS' بود
      'meta_query'          => array(
          array(
              'key'   => '_stock_status',
              'value' => 'instock',
          ),
      ),
  );
  $terms = get_terms( $args );

  if ( count($terms) ){
    echo '<div class="category_results">';
    echo '<div class="promote_searchs"><span><i class="ri-apps-2-line"></i>جستجو در دسته بندی ها</span></div>';
    foreach ($terms as $term) {

			echo '<div class="category_searechd">';

      echo '<span class="c_searched_title">'.$keyword.'</span>';
      echo '<a class="result_category_search" href="'.get_term_link($term).'" ><i class="c_in_category">در دسته</i> <span>'.$term->name.'</span></a>';

			echo '</div>';
    }
    echo '</div>';

  }

	do_action('nk_after_result_search_ajax', $keyword, $has_result);
?>

	<script>
	jQuery('.prk_close_search_result').on('click',function(){
    jQuery('.prk_close_search_result').hide();
    jQuery('.search_image').show(100);
		jQuery('.main_results_ajax_search .products_resulter').html('');
		jQuery('#txt_search').val('');
    jQuery('#submit_search i').show();
    // jQuery(".form_search #searchform_cat").removeAttr("selected");
    jQuery('.form_search #searchform_cat option').removeAttr("selected");

	});

  jQuery('.form_search #searchform_cat').on('click',function(){
    jQuery('.prk_close_search_result').hide();
    jQuery('.search_image').show(100);
		jQuery('.main_results_ajax_search .products_resulter').html('');
		jQuery('#txt_search').val('');
    jQuery('#submit_search i').show();
    

  });

	</script>

<?php
	exit();
}
