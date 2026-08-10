<?php

// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

    //
    // Create a widget 1
    //
    CSF::createWidget( 'csf_widget_example_1', array(
      'title'       => 'کاروسل محصولات تکی',
      'classname'   => 'csf-widget-classname',
      'description' => 'کاروسل چند منظوره محصولات prk',
      'fields'      => array(
        // array(
        //   'id'      => 'title_widget',
        //   'type'    => 'text',
        //   'default'    => 'عنوان ابزاک',
        //   'title'   => 'عنوان',
        //   'dependency' => array('opt-switcher', '==', 'true'),
        // ),
        // Select with multiple and sortable AJAX search Categories
        array(
          'id'          => 'prod_sort',
          'type'        => 'select',
          'title'       => 'مرتب سازی محصولات',
          'placeholder' => 'مرتب سازی',
          'default' => 'latest',
					'options' => [
						'latest'  => __( 'آخرین محصولات', 'parskala' ),
						'random' => __( 'محصولات تصادفی', 'parskala' ),
						'viewed' => __( 'پربازدید ترین محصولات', 'parskala' ),
						'saled' => __( 'محصولات پر فروش', 'parskala' ),
						'price-desc'  => __( 'قیمت از نزولی', 'parskala' ),
						'price-asc'  => __( 'قیمت از صعودی', 'parskala' ),
						'coming_soon' => __( 'محصولات به زودی', 'parskala' ),
						'discounted' => __( 'محصولات تخفیف خورده', 'parskala' ),
						'rand_discounted' => __( 'محصولات تخفیف خورده تصادفی', 'parskala' ),
						'special' => __( 'محصولات شگفت انگیز', 'parskala' ),
						'rand_special' => __( 'محصولات شگفت انگیز تصادفی', 'parskala' ),
						'menu_order' => __( 'برطبق عنوان', 'parskala' ),
					],
        ),
        array(
          'id'      => 'out_prod',
          'type'    => 'switcher',
          'title'   => 'نمایش محصولات موجود در انبار',
          'default' => 'false',
        ),
        array(
          'id'          => 'prod_filter',
          'type'        => 'select',
          'title'       => 'فیلتر محصول',
					'default' => 'category',
					'options' => [
						'category'  => __( 'دسته محصوالت', 'parskala' ),
						'tag' => __( 'برچسب محصولات', 'parskala' ),
						'brand' => __( 'برند محصولات', 'parskala' ),
						'pro_id' => __( 'انتخاب دستی محصولات', 'parskala' ),
					],
        ),

        array(
          'id'          => 'product_cat',
          'type'        => 'select',
          'chosen'      => true,
          'ajax'        => true,
          'multiple'    => true,
          'sortable'    => true,
          'title'       => 'دسته بندی محصولات',
          'options'     => 'categories',
          'query_args'  => array(
            'taxonomy'  => 'product_cat',
          ),
          'dependency' => array('prod_filter', '==', 'category'),
        ),

        array(
          'id'          => 'product_brand',
          'type'        => 'select',
          'chosen'      => true,
          'ajax'        => true,
          'multiple'    => true,
          'sortable'    => true,
          'title'       => 'فیلتر بر اساس برند',
          'options'     => 'categories',
          'query_args'  => array(
            'taxonomy'  => 'brand',
          ),
          'dependency' => array('prod_filter', '==', 'brand'),
        ),

        array(
          'id'          => 'product_tag',
          'type'        => 'select',
          'chosen'      => true,
          'ajax'        => true,
          'multiple'    => true,
          'sortable'    => true,
          'options'     => 'categories',
          'query_args'  => array(
            'taxonomy'  => 'product_tag',
          ),
          'title'       => 'فیلتر بر اساس تگ',
					'description' => __( 'برچسب های خالی (بدون محصول) نمایش داده نمی شوند', 'parskala' ),
          'dependency' => array('prod_filter', '==', 'tag'),
        ),

        array(
          'id'          => 'product_id',
          'type'        => 'select',
          'title'       => 'انتخاب دستی محصولات',
          'chosen'      => true,
          'multiple'    => true,
          'sortable'    => true,
          'ajax'        => true,
          'options'     => 'posts',
          'query_args'  => array(
            'post_type' => 'product',
          ),
          'dependency' => array('prod_filter', '==', 'pro_id'),
        ),


        array(
          'id'      => 'ptotalcount',
          'type'    => 'number',
          'title'   => 'تعداد محصولات',
          'default' => '8',
        ),

        // slider settings
        array(
          'type'    => 'heading',
          'content' => 'پیکربندی اسلایدر',
        ),
        array(
          'id'         => 'loop', // field id
          'type'       => 'switcher',
          'title'      => 'نمایش بینهایت',
          'default'    => true,
        ),
        array(
          'id'         => 'nav', // field id
          'type'       => 'switcher',
          'title'      => 'نمایش پیکان ها',
          'default'    => true,
        ),
        array(
          'id'         => 'dots', // field id
          'type'       => 'switcher',
          'title'      => 'نمایش نقطه ها',
          'default'    => true,
        ),
        array(
          'id'         => 'autoplay', // field id
          'type'       => 'switcher',
          'title'      => 'نمایش خودکار',
          'default'    => true,
        ),
        array(
          'id'         => 'delay', // field id
          'type'       => 'number',
          'title'      => 'سرعت (میلی ثانیه)',
          'default'    => '3000',
        ),

      )
    ) );
  
    //
    // Front-end display of widget example 1
    // Attention: This function named considering above widget base id.
    //
    if( ! function_exists( 'csf_widget_example_1' ) ) {
      function csf_widget_example_1( $args, $instance ) {

        $settings_slider =  array(
          'item'     => '1',
          'loop'     => $instance['loop'] == '1' ? 'true' : 'false',
          'nav'      => $instance['nav'] == '1' ? 'true' : 'false',
          'autoplay' => $instance['autoplay'] == '1' ? 'true' : 'false',
          'delay'    => $instance['delay'],
          'dots'     => $instance['dots'] == '1' ? 'true' : 'false',
          'margins'  => '5',
        );

        $json_instance = json_encode($settings_slider);

        $prod_sort = $instance['prod_sort'];
        $prod_filter = $instance['prod_filter'];
        $product_cat = $instance['product_cat'];
        $product_tag = $instance['product_tag'];
        $product_brand = $instance['product_brand'];
        $product_id = $instance['product_id'];



      
      if($prod_sort != 'special' && $prod_sort != 'rand_special') {
      switch ($prod_sort) {
        case 'latest':
          $arms = array(
          'posts_per_page' => $instance['ptotalcount'],
          'post_type' => 'product',
          'post_status' => 'publish',
          'order' => 'DESC'  );
          break;
        case 'menu_order':
          $arms = array(
          'posts_per_page' => $instance['ptotalcount'],
          'post_type' => 'product',
          'post_status' => 'publish',
          'orderby' => 'menu_order title',
          'order' => 'ASC'  );
          break;
        case 'saled':
          $arms = array(
          'posts_per_page' => $instance['ptotalcount'],
          'post_type' => 'product',
          'post_status' => 'publish',
          'meta_key' => 'total_sales',
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC'  );
          break;
        case 'discounted':
          $arms = array(
            'posts_per_page'    => $instance['ptotalcount'],
            'post_status'       => 'publish',
            'order' => 'DESC',
            'post_type'         => 'product',
            'post__in'          => array_merge( array( 0 ), wc_get_product_ids_on_sale() )
          );
          break;
        case 'coming_soon':
          $arms = array(
            'posts_per_page' => $instance['ptotalcount'],
            'post_type' => 'product',
            'post_status' => 'publish',
            'meta_key' => 'prk_coming',
            'meta_value' => 'yes',
            'order' => 'DESC'
          );
          break;
        case 'rand_discounted':
          $arms = array(
            'posts_per_page'    => $instance['ptotalcount'],
            'post_status'       => 'publish',
            'orderby'        	=> 'rand',
            'post_type'         => 'product',
            'post__in'          => array_merge( array( 0 ), wc_get_product_ids_on_sale() )
          );
          break;
        case 'viewed':
          $arms = array(
          'posts_per_page' => $instance['ptotalcount'],
          'post_type' => 'product',
          'post_status' => 'publish',
         'order'            => 'DESC',
         'suppress_filters' => false,  //required param
         'orderby'          => 'post_views',  //required param
         );
          break;
        case 'price-desc':
          $arms = array(
          'posts_per_page' => $instance['ptotalcount'],
          'post_type' => 'product',
          'post_status' => 'publish',
          'orderby'        => 'meta_value_num',
          'meta_key'       => '_price',
          'order'          => 'DESC');
          break;
        case 'price-asc':
          $arms = array(
          'posts_per_page' => $instance['ptotalcount'],
          'post_type' => 'product',
          'post_status' => 'publish',
          'orderby'        => 'meta_value_num',
          'meta_key'       => '_price',
          'order'          => 'ASC');
          break;
        case 'random':
          $arms = array(
          'posts_per_page' => $instance['ptotalcount'],
          'post_type' => 'product',
          'post_status' => 'publish',
          'orderby'        => 'rand'  );
          break;
        default:
        $arms = array(
          'posts_per_page' => $instance['ptotalcount'],
          'post_type' => 'product',
          'post_status' => 'publish',
         'meta_key' => 'onsales_round',
         'meta_value' => 'yes',
         );
        }
        if ( $prod_filter ) {
          if ( $prod_filter == 'category' && !empty($product_cat) ) {
            $arms['tax_query'] = array(
              array(
              'taxonomy' => 'product_cat',
              'field' => 'term_id',
              'terms' => $product_cat
              )
            );
            $view_all_link = prk_get_term_links( 'product_cat', $product_cat );
          } elseif ( $prod_filter == 'tag' && !empty($product_tag) ) {
            $arms['tax_query'] = array(
              array(
              'taxonomy' => 'product_tag',
              'field' => 'term_id',
              'terms' => $product_tag
              )
            );
            $view_all_link = prk_get_term_links( 'product_tag', $product_tag );
          } elseif ( $prod_filter == 'brand' && !empty($product_brand) ) {
            $arms['tax_query'] = array(
              array(
              'taxonomy' => 'brand',
              'field' => 'term_id',
              'terms' => $product_brand
              )
            );
            $view_all_link = prk_get_term_links( 'brand' , $product_brand );
          }elseif ( $prod_filter == 'pro_id' && !empty($product_id) ) {
            $arms['post__in'] = $product_id;
           }
        }
      } elseif ( $prod_sort == 'special' || $prod_sort == 'rand_special') {


       $arms = array (
           'posts_per_page' => $instance['ptotalcount'],
           'post_type' => 'product',
           'post_status' => 'publish',
           'meta_key' => 'onsales_round',
           'meta_value' => 'yes',

       );


          if ( !empty($prod_filter) && (!empty($product_cat) || !empty($product_tag) || !empty($product_brand)) ) {
          if ( $prod_filter == 'category' && !empty($product_cat) ) {
            $arms['tax_query'] = array(

            array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $product_cat
            )
          );
          } elseif ( $prod_filter == 'tag' && !empty($product_tag) ) {
            $arms['tax_query'] = array(

            array(
            'taxonomy' => 'product_tag',
              'field' => 'term_id',
              'terms' => $product_tag
            )
          );
          } elseif ( $prod_filter == 'brand' && !empty($product_brand) ) {
            $arms['tax_query'] = array(

              array(
              'taxonomy' => 'brand',
                'field' => 'term_id',
                'terms' => $product_brand
              )
            );
          }
        }

       if ( $prod_sort == 'special' ) {
         $args['order'] = 'DESC';
       } elseif ( $prod_sort == 'rand_special') {
         $args['orderby'] = 'rand';
       }

      }

      if('1' === $instance['out_prod'] ){
        $arms['meta_query'] = array(
            'relation' => 'AND',
            array(
              'key' => '_stock_status',
              'value' => 'instock'
            ),
          );
      }

      $arms[] = array(
        'fields'                    => 'ids',
        'no_found_rows'             => true,
        'update_post_term_cache'    => false
      );

     if(isset($_COOKIE['prskalaSearchCity']) && !empty(($_COOKIE['prskalaSearchCity']))){
        $city_categories=explode(',', $_COOKIE['prskalaSearchCity']);
        if (!empty($city_categories) && $city_categories !== 0) {
          if (isset($arms["tax_query"]) && is_array($arms["tax_query"])) {

            $arms["tax_query"][] = ["taxonomy" => "city_categories", "field" => "id", "terms" => $city_categories];
          } else {
            $arms["tax_query"] = ["relation" => "AND", ["taxonomy" => "city_categories", "field" => "id", "terms" => $city_categories]];
          }
        }
    }
    $pd_query = new WP_Query( $arms );

        echo '<div class="widget side-box-post">';
        
  
        if ( ! empty( $instance['title_carousel'] ) ) {
          echo $args['before_title'] . apply_filters( 'title_widget', $instance['title_widget'] ) . $args['after_title'];
        }
        
        ?>
		

           <?php if ( $pd_query ->have_posts() ) : ?>
            <div class="article-off"  settings-slider='<?php echo $json_instance; ?>'>

            <?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post();
                global $product;
                $entire_sales = '';
                $currency = get_woocommerce_currency_symbol();
                $price = get_post_meta( get_the_ID(), '_regular_price', true);
                $sale = get_post_meta( get_the_ID(), '_sale_price', true);
                $img_up_pro = get_post_meta(get_the_ID(),'img_up_pro',true);
                $product_label = get_post_meta(get_the_ID(), 'prk_product_label', true );
                $progress_sales = get_post_meta(get_the_ID(), 'progress_sales', true );
                $_progress_sales = $progress_sales ? $progress_sales : '1';
                if ($_progress_sales == '1'){
                    $entire_sales = 'el_none';
                }
            ?>
            <article class="item-pro prob-item">
            <?php do_action('prk_el_woocommerce_before_shop_loop_item') ;?>

            <?php if ($product_label): ?>
										<div class="custom_label"><span><?php echo $product_label;?></span></div>
									<?php endif; ?>

 								    <a href="<?php the_permalink();?>">

											<!--thumbnail-->
											<?php echo pr_img(); ?>

 								      <div class="index-title-pro">
 								         <h2><?php echo wp_trim_words(get_the_title(),12,'...') ;?></h2>
 								      </div>

											<?php
 											 echo '<div class="index-prices-pro">';

 												 if ( $product->is_in_stock() ) {

 													 echo '<div class="price_onsale_ar">';

													  if ( $product->is_in_stock() && $price || $product->is_type( 'variable' ) ) {
 																	echo $product->get_price_html();
															}elseif( $product->is_in_stock()  ){
																echo '<p class="call_pro">'.prk_option('single_product_text_price').'</p>';
 																}


 													 echo '</div>';

 												 }else{
													  echo '<div class="price_onsale_ar">';
													 	
															echo '<p class="call_pro">تماس بگیرید</p>';
													   
													  echo '</div>';
 												 }
 												echo '</div>';
 											 ?>

											<!--add cart-->

												<?php

													$type_add_to_cart = 'icon';
													$type_add_to_cart_text =  'prk-shopping-cart' ;
													$type_add_to_cart_text =  'افزودن به سبد' ;

													$cart_text = '<a data-product-id="'.$post->ID.'" class="quick_add2cart text" ><span>'.$type_add_to_cart_text.'</span></a>';

													echo apply_filters('add_to_cart_bottom',$cart_text,$type_add_to_cart);
												
												?>

 								      </a>
									   <?php do_action('prk_el_woocommerce_after_shop_loop_item') ;?>
 								</article>

                    <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
            </div>
            <?php endif;?>

          

        <?php
  
        

        echo '</div>';


      }
    }
  
  }