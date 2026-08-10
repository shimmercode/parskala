<?php

// Remove breadcrumbs from shop & categories
add_filter( 'woocommerce_before_main_content', 'remove_breadcrumbs');
function remove_breadcrumbs() {
    if(!is_product()) {
        remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
    }
}



  add_action( 'prk_before_shop_page','woocommerce_breadcrumb');



function prk_before_shop_page_woocomerce(){

  $product_count = prk_option('archive_product_product_count');
  $offer = $catchild_true = $offer_text = $backcolor = $product_count = "";

  if (is_product_category()){

    $term = get_queried_object();
    $children = get_terms( $term->taxonomy, array(
        'parent'    => $term->term_id,
        'hide_empty' => false
    ) );

    $wenderfol = get_parent_theme_file_uri('assets/img/wenderfol.svg');
    $meta = get_term_meta( $term->term_id, 'prk_taxonomy_options', true );

    if(isset($meta) && !empty($meta)){
        if (isset($meta['offer']))		$offer    = $meta['offer'];
        if (isset($meta['catchild-true']))	$catchild_true    = $meta['catchild-true'];
        if (isset($meta['offer_text']))		$offer_text    = $meta['offer_text'];
    }

  }


    if ( $offer == '1' ) {
      $offer_class = ' offer';
    }else {
      $offer_class = '';
    }

  // change akax page
  echo '<div id="prk_content">';


  if ( is_product_category() && $offer == '1' ){

    echo '<div class="wenderfol_archive">';
    echo '<div class="continer">';

      echo '<span class="wenderfol_img">';

        echo '<img src="' .esc_url($wenderfol). '" alt="promotion">';

      echo '</span>';

    echo '<span class="vanderfol_title">'.$offer_text.'</span>';

    echo '</div></div>';

  }
   
  $balance_side = prk_option('max_continer')['width'] < '1400' ? ' balance_shop' : '';
 

  echo '<div class="constiky'.$offer_class. ''. $balance_side.'">';

  if (is_product_category() || is_shop()){

   

      $terms = get_terms([
          'taxonomy' => 'product_cat',
          'hide_empty' => false,
          'parent' => get_queried_object_id()
      ]);

      $settings_slider =  array(
        'loop'     => 'false',
        'nav'      => 'false',
        'autoplay' => 'false',
        'delay'    =>  300,
        'item'     => 7,
        'margins'  => 4,

      );

      $json_settings = json_encode($settings_slider);

      if (mobile_cheker() || tablet_cheker()) {
  			$class_dev = 'verticaler';
  			$class_section = 'carousel_lister';
  			$json_settings = '';
  		}else {
  			$class_dev = '';
  			$class_section = 'carousel-items';
  			$json_settings = json_encode($settings_slider);
  		}

        if ( (prk_option('archive_product_subcategories_order') == 'top_sidebar' || prk_option('archive_product_subcategories_order') == '') ){

            echo prk_subcategories_product();
        
        }
      
    }



   // get sidebar shop
   if ( is_active_sidebar('sideby-pro-widget') && prk_option('active_side_shop') == 1 ) {

     if ( !mobile_cheker() && !tablet_cheker() ) {
        echo '<div id="sides" class="sides '.$offer_class.'">';

          dynamic_sidebar('sideby-pro-widget');

        echo '</div>';
     }
  }

   if ( empty( is_active_sidebar('sideby-pro-widget') ) || empty( prk_option('active_side_shop') )  ) {
     $class_shop = 'fullw';
   }else {
     $class_shop = '';
   }
  // start main item products
  echo '<main class="left-store '.$class_shop.'">';

  if (  prk_option('archive_product_subcategories_order') == 'next_sidebar' ){

    echo prk_subcategories_product();

  }

}

 add_action('prk_before_shop_page','prk_before_shop_page_woocomerce');






// قلاب اندازی قبل از قلاب اصلی  صفحه فروشگاه
function prk_before2_main_content(){


  $classes = 'prk-product-archive-con';
  $classes .= (  prk_option( 'prk_shop_ajax_add' ) ? ' ajax-prod' : '');
  $classes .= (  prk_option( 'prk_shop_ajax_add' ) &&  prk_option( 'ajax_prod_auto' )  ? ' ajax-prod-auto' : '');
  $ajax_prod_auto = (  prk_option( 'prk_shop_ajax_add' ) &&  prk_option( 'ajax_prod_auto' )  ? ' data-auto-ajax-load="100"' : ' data-auto-ajax-load="false"');
  $ajax_prod_history = (  prk_option( 'prk_shop_ajax_add' ) &&  prk_option( 'ajax_prod_history' )  ? ' data-ajax-prod-history="push"' : ' data-ajax-prod-history="false"');

  echo '<div class="left-index '.$classes.'" '.$ajax_prod_auto . $ajax_prod_history.'>';


  // sort by filter pc
  if ( empty(mobile_cheker()) && empty(tablet_cheker()) ) {
    echo '<div class="prk-head-shop">';

     echo '<div class="flexed">';
       prK_orderby_filter();
       pr_count_pages();
     echo '</div>';

    echo '</div>';
  }

  // head shop page mobile
  if ( mobile_cheker() || tablet_cheker() ) {

    // sort by filter pc
    echo '<div class="prk-head-shop-mobile">';

     echo '<div class="flexed title_shop">';

       woocommerce_page_title();
       pr_count_pages();

     echo '</div>';

     echo '<div class="box-filter-shop">';
      prK_sidebarshop_mobile();
      prK_orderby_filter_mobile();
     echo '</div>';

    echo '</div>';

  }
}
add_filter('prk_shop_before_main_content','prk_before2_main_content');



// after shop page
add_filter('prk_after_shop_page','prk_after_shop_page_woocomerce',9);
function prk_after_shop_page_woocomerce(){

  // 1) همیشه با ترتیب درست ببند
  echo '</main>';           // بستن <main>
  echo '</div>';            // بستن .constiky

  // 2) توضیحات دسته/تگ/برند فقط اگر صفحه اول باشیم
  $brand_slug = prk_option('product_brand_slug') ? prk_option('product_brand_slug') : 'brand';
  if ( is_tax( array( 'product_cat','product_tag', $brand_slug ) ) && get_query_var('paged') == 0 ) {

      $order_typle_des = ( prk_option('archive_product_description_order') == 'next_sidebar' )
                         ? ' next_sidebar_order' : ' bottom_sidebar_order';

      $show_title = ( prk_option('show_title_cat_archive') == '1' || prk_option('show_title_cat_archive') == '' );
      $description = wc_format_content( term_description() ); // ممکنه خالی باشه

      // فقط اگر چیزی برای نمایش داشته باشیم، wrapper باز کنیم
      if ( $show_title || !empty($description) ) {
          echo '<div class="footer-description-shop'.$order_typle_des.'">';

          if ( $show_title ) {
              echo '<h1 class="title-category">'. single_cat_title('', false) .'</h1>';
          }

          if ( !empty($description) ) {
              echo $description;
              echo '<a href="#" class="mask-handler"><span class="show-more">نمایش بیشتر</span><span class="show-less">- بستن</span></a>';
          }

          // هر خروجی اضافی مربوط به توضیحات را همینجا بزن
          do_action('prk_after_des_shop');

          echo '</div>'; // بستن footer-description-shop
      }
  }

  // 3) در نهایت همیشه prk_content را ببند
  echo '</div>'; // بستن #prk_content
}



// add_action('prk_after_shop_page','woocommerce_taxonomy_archive_description',10);



// add_filter('prk_after_shop_page','inner_product_content_shop',11);
function inner_product_content_shop(){

  $description = wc_format_content( term_description() );
  if ( $description && is_tax( array( 'product_cat', 'product_tag', 'brand' ) ) && get_query_var( 'paged' ) == 0 ) {
    echo '<a href="#" class="mask-handler"><span class="show-more">نمایش بیشتر</span><span class="show-less">- بستن</span></a>';


    do_action('prk_after_des_shop');
    
    echo '</div>';
  }

  echo '</div>';

  if ( prk_option('archive_product_description_order') == 'next_sidebar' ){
    // بسته شدن عنصر والد آیتم محصولات فروشگاه
    echo '</div>';
    echo '</main>';
  }

}



// حذف هوک های پیشفرض ایتم های محصولات
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description' );
remove_action( 'woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_catalog_ordering', 30 );

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item',  'woocommerce_template_loop_product_link_close', 5 );

//Show Product Category Description
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description' );

// اضافه کردن عنوان شگفت انگیزها و شمارنده
add_action('woocommerce_shop_loop_item_title', 'prk_onsale_loop_product', 8 );
function prk_onsale_loop_product() {
  
    pr_onsale_head();

    $product_label = get_post_meta(get_the_ID(), 'prk_product_label', true );
    if ($product_label){
       echo '<div class="custom_label"><span>'.$product_label.'</span></div>';
    }
      
    
}


// remove def thumbnail woocommerce loop
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'prk_thumbnail_loop_product', 9 );

function prk_thumbnail_loop_product() {
  global $product;

  if ( ! $product ) {
    pr_img();
    return;
  }

  echo '<a href="' . esc_url( get_permalink( $product->get_id() ) ) . '" class="block" aria-label="' . esc_attr( $product->get_name() ) . '">';
    pr_img();
  echo '</a>';
}

// remove def title woocommerce loop
remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title', 10 );
add_action('woocommerce_shop_loop_item_title', 'prk_title_loop_product', 10 );
function prk_title_loop_product() {
    echo '<div class="index-title-pro archive">';
     echo '<h2 class="woocommerce-loop-product_title"><a href="'.get_the_permalink().'">' . get_the_title() . '</a></h2>';
    echo '</div>';
}

// add stock after title woocommerce loop
add_action('woocommerce_shop_loop_item_title', 'prk_stock_loop_product', 11 );
function prk_stock_loop_product() {

 echo '<div class="flexed stock_box">';

   pr_stock();

    if (prk_option('product_rate')) {
      pr_star();
    }


  echo '</div>';

}

// add costom price in product loop
add_action('woocommerce_after_shop_loop_item_title','prk_price_loop_product',98);

function prk_price_loop_product(){

  global $post, $product;
  global $woocommerce;
  $price = get_post_meta( get_the_ID(), '_regular_price', true);

  //price
  echo '<div class="index-prices-pro">';
  echo '<div class="price_onsale_ar">';

  if ( $product->is_in_stock() && $price|| $product->is_type( 'variable' )) {

    echo $product->get_price_html();

  }elseif($product->is_in_stock()){

        echo '<p class="call_pro">'.prk_option('single_product_text_price').'</p>';
        
  } else {
        // محصول ناموجود یا غیرقابل خرید
        echo '<div class="price_onsale_ar">';
        echo '<p class="call_pro">' . esc_html__('ناموجود', 'parskala') . '</p>';
        echo '</div>';
    }

      echo '</div>';

      echo '</div>';
      
    }






// // add costom price in product loop
// if ( prk_option('archive_product_add_to_cart') ) {

//   add_action('woocommerce_after_shop_loop_item_title','prk_add_cart_loop_product',99);
  
// }


// function prk_add_cart_loop_product(){
//   echo '<div class="lists_add_to_cart">';
//   echo do_shortcode("[ajax_cart_item]");
//   echo '</div>';

// }


// add author and add to card loop
add_action('woocommerce_after_shop_loop_item_title','prk_author_loop_product',12);
function prk_author_loop_product(){
  pr_author();
}


// image thumbnail product
function pr_img() {
  global $product;
  $classes = '';
  if( prk_option( 'show_sec_img' ) ) {
      $attachment_ids = $product->get_gallery_image_ids();
      if ( is_array( $attachment_ids ) && !empty( $attachment_ids ) ) {
          $classes = 'hover-image';
      }
  }
  echo '<div class="thumb-pro '.$classes.'  duration-500  group-hover:-mt-[22px] group-hover:-rotate-1">';

    do_action( 'prk_before_shop_loop_item_img' );

    if ( has_post_thumbnail() ) {
        the_post_thumbnail('woocommerce_thumbnail');
    } else {
        prod_defualt_thumb();
    }
    if( prk_option( 'show_sec_img' ) ) {
      $first_image_url = '';
      $attachment_ids = $product->get_gallery_image_ids();
      if ( is_array( $attachment_ids ) && !empty($attachment_ids) && isset($attachment_ids[0])) {
          $first_image_url = wp_get_attachment_image_src($attachment_ids[0], 'woocommerce_thumbnail');
          if ($first_image_url ) {
            echo '<img width="'.$first_image_url[1].'" height="'.$first_image_url[2].'" src="'.$first_image_url[0].'" alt="'.get_the_title().'" class=" second-img wp-post-image">';

          }
      }
    }
    do_action( 'prk_after_shop_loop_item_img' );

  echo '</div>';
 }

 //Product Defualt Thumb Image
 function prod_defualt_thumb() {
     $defualt_thumb = prk_option('prk_defualt_thumb_pr');
     echo '<img src="'. $defualt_thumb['url'] .'" width="150" height="150" alt="'.the_title_attribute('echo=0').'" class="post-thumb">';
 }


//get star product

function pr_star(){
  $ratings_nummbercomment = '';
  global $product;
  global $post;
  if ($product->get_rating_count() > 0){
    ?>
    <div class="rating_and_nummbercomment">
      <div class="rating_product">
        <span class="average_rating"><?php echo $product->get_average_rating(); ?></span>
        <i class="ri-star-fill star"></i>
        <!-- <span class="rating_count">از <?php echo $product->get_rating_count(); ?> رای </span> -->
      </div>

    </div>
    <?php
  }
}


function pr_stock(){

  $product_stock = prk_option('archive_product_stock');
  global $product;
  if ($product_stock){

    echo '<span class="stock-archive">';

   if($product->is_type( 'variable' )){
      $variation_ids = $product->get_children();
      $product_is_instock = false;
    foreach($variation_ids as $variation_id){
      $variation = wc_get_product($variation_id);
      if( $variation->is_in_stock()){
        $product_is_instock = true;
        break;
      }
 
    }

    if($product_is_instock){
      
      echo '<span class="in-stock">

      '.__('in stock' , 'parskala').'

    </span>';
      
    }else{
      echo '<i class="share-square"></i>';

      echo '<span class="in-stock">

      '.__('Not available in stock' , 'parskala').'

     </span>';

    }

    }else{


      if ($product->is_in_stock()){

        echo '<i class="share-square"></i>';

         if (wc_get_stock_html( $product )){
          echo '<span class="stockon">' .wc_get_stock_html($product). '</span>';
        }
        else{
          echo '<span class="in-stock">

            '.__('in stock' , 'parskala').'

          </span>';
        }

      }
      else{

        echo '<i class="share-square"></i>';
        echo '<span class="in-stock">

         '.__('Not available in stock' , 'parskala').'

        </span>';

      }

    
    }

    echo '</span>';

  }

}

// head onsale product

function pr_onsale_head(){

  global $post, $product;
  $onsales_round = '';

  if ( $product -> is_type( 'variable' ) ) {
    $children_ids = $product->get_children();
    $date = '';
    foreach ( $children_ids as $children_id ) {
        if ( ! empty( $date ) )
            break;
        $child_date = get_post_meta( $children_id, '_sale_price_dates_to', true );
        if ( ! empty( $child_date ) ) {
            $date = $child_date;
        }
    }
} else {
 $date = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
}
  $sale = get_post_meta( get_the_ID(), '_sale_price', true);
  $onsales_round = get_post_meta(get_the_ID(), 'onsales_round', 'no' );
  $timer_id = generateRandomString();

  // if ($product_label){
  //   echo '<div class="custom_label"><span>'.$product_label.'</span></div>';
  // }



  if ($onsales_round == 'yes' ) {

  $onsale_title = 'پیشنهاد ویژه';

  }elseif( $product->is_on_sale() ) {

    $onsale_title = 'فروش ویژه';

  }



    if ( $onsales_round == 'yes' || $sale ){
    // sale-flash
    echo '<div class="head-archie-pro">';

    echo '<span class="onsale prs">'.$onsale_title.'</span>';

      if($date){

       ?>
       <p id="sales_timer_display" class="timer-pros1-<?php echo $timer_id;?>"></p>
       <script type="text/javascript">
         var dateEnd = new Date((<?php echo $date; ?>) * 1000);
         new TimezZ('.timer-pros1-<?php echo $timer_id;?>', {
         date: dateEnd,
         template: '<span><span class="number">NUMBER</span><span class="dot">:</span><span class="letter">LETTER</span></span>',
         text: {
         days: 'روز',
         hours: 'ساعت',
         minutes: 'دقیقه',
         seconds: 'ثانیه',
           }
         });
        </script>
       <?php
      }
      echo '</div>';
    }

 


}



function pr_quantity(){
  global $post, $product;
  global $woocommerce;
  ?>

  <div class="prk_cart">
    <?php echo woocommerce_quantity_input(['min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product), 'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),], $product, false); ?>
    <div class="lists_add_to_cart">
      <?php echo do_shortcode("[ajax_cart_item]");?>
    </div>
  </div>
  <?php
}

function pr_author(){

  global $post, $product;
  global $woocommerce;
  $seller_name = prk_option('archive_product_seller_name');
  $product_orginal = prk_option('archive_product_orginal');
  $Original_pro = get_post_meta(get_the_ID(),'product_facke_brand_show',true);
  $product_stock = prk_option('archive_product_stock');
  $product_thumbnail_2 = prk_option('archive_product_thumbnail_2');
  $vendor_id = get_post_field( 'post_author', get_the_id() );

  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
  $active_dokan = is_plugin_active( 'dokan-lite/dokan.php' );
  if($active_dokan){
  $vendor = new WP_User($vendor_id);
    $store_info  = dokan_get_store_info( $vendor_id );
    $store_name  = $store_info['store_name'];
    $store_url   = dokan_get_store_url( $vendor_id );
  }

// author
?>
<div class="author-Original">

  <?php if ($product_orginal):?>

    <?php if($Original_pro=="yes"):?> 

    <span class="no-Original"><?php _e('غیر اصل' , 'parskala');?></span>

    <?php endif;?>

  <?php endif;?>

  <?php if ($seller_name):?>

    <span class="author-ar"><i class="seller-store"></i> <?php _e(' فروشنده: ' , 'parskala');?>

      <?php if($active_dokan):?>

        <span class="authours-ar"><?php echo $store_name;?></span>

      <?php else:?>

        <?php echo get_the_author_meta( 'display_name');?>

      <?php endif;?>

    </span>

  <?php endif;?>

</div>

<?php
}

function pr_count_pages(){
  if (prk_option('ajax_prod_auto') == '0') {


  ?>
    <span class="prk_count_pages">
      <?php
      global $wp_query;
      $paged    = max(1, $wp_query->get('paged'));
      $per_page = $wp_query->get('posts_per_page');
      $total    = $wp_query->found_posts;
      $first    = ($per_page * $paged) - $per_page + 1;
      $last     = min($total, $wp_query->get('posts_per_page') * $paged); ?>
      <span class="show_page_count"><?php echo _e('show', 'parskala'); ?></span>
      <span class="show_page_count first"><?php echo ($first); ?></span>
      <span class="show_page_count">-</span>
      <span class="show_page_count last"><?php echo ($last); ?></span>
      <span class="show_page_count line"><?php echo _e('From  ', 'parskala'); ?></span>
      <span class="show_page_count total"><?php echo ($total); ?></span>
      <span class="show_page_count"><?php echo _e(' commodity ', 'parskala'); ?></span>
    </span>
  <?php
}else {
  ?>
  <span class="prk_count_pages">
    <?php
    global $wp_query;
    $paged    = max(1, $wp_query->get('paged'));
    $per_page = $wp_query->get('posts_per_page');
    $total    = $wp_query->found_posts;
    $first    = ($per_page * $paged) - $per_page + 1;
    $last     = min($total, $wp_query->get('posts_per_page') * $paged); ?>
    <span class="show_page_count"><?php echo _e('show', 'parskala'); ?></span>

    <span class="show_page_count total"><?php echo ($total); ?></span>

    <span class="show_page_count"><?php echo _e(' commodity ', 'parskala'); ?></span>
  </span>
  <?php
}
}


function prK_orderby_filter() {

    ?>

   <div class="prK_orderby_filtering">
   <svg viewBox="0 0 24 24" class="svg">
      <path fill-rule="evenodd" d="M6 15.793L3.707 13.5l-1.414 1.414 4 4a1 1 0 001.414 0l4-4-1.414-1.414L8 15.793V5H6v10.793zM22 5H10v2h12V5zm0 4H12v2h10V9zm0 4h-8v2h8v-2zm-6 4h6v2h-6v-2z" clip-rule="evenodd"></path>
  </svg>
    <span class="menu_order_title"><?php _e('order by' , 'parskala'); ?>:</span>
    <ul class="prk-order-products">
    <?php

    if( isset($_GET['orderby'] ) ) {
        $orderby = $_GET['orderby'];
    } elseif( is_search() ) {
        $orderby = 'relevance';
    } else {
        $orderby = get_option( 'woocommerce_default_catalog_orderby' );
    }
    ?>

        <?php if( is_search() ){ ?>
        <li class="order-item order-relevance<?php echo ($orderby == 'relevance' ? ' is-active' : ''); ?>">
            <a rel="nofollow" href="<?php echo prk_order_get_link( 'relevance' ); ?>">
                <?php _e('پیشفرض' , 'parskala'); ?>
            </a>
        </li>

        <?php } elseif( $orderby == 'menu_order' || $orderby == '' ){ ?>
        <li class="order-item order-menu-order<?php echo ($orderby == 'menu_order' || $orderby == '' ? ' is-active' : ''); ?>">
            <a rel="nofollow" href="<?php echo prk_order_get_link( 'menu_order' ); ?>">
                <?php _e('default' , 'parskala'); ?>
            </a>
        </li>
        <?php } ?>

        <li class="order-item order-rating<?php echo ($orderby == 'rating' ? ' is-active' : ''); ?>">
            <a rel="nofollow" href="<?php echo prk_order_get_link( 'rating' ); ?>">
                <?php _e('Popular' , 'parskala'); ?>
            </a>
        </li>

        <li class="order-item order-popularity<?php echo ($orderby == 'popularity' ? ' is-active' : ''); ?>">
            <a rel="nofollow" href="<?php echo prk_order_get_link( 'popularity' ); ?>">
                <?php _e('popularity' , 'parskala'); ?>
            </a>
        </li>

        <li class="order-item order-date<?php echo ($orderby == 'date' ? ' is-active' : ''); ?>">
            <a rel="nofollow" href="<?php echo prk_order_get_link( 'date' ); ?>">
                <?php _e('newest' , 'parskala'); ?>
            </a>
        </li>

        <li class="order-item order-price<?php echo ($orderby == 'price' ? ' is-active' : ''); ?>">
            <a rel="nofollow" href="<?php echo prk_order_get_link( 'price' ); ?>">
                <?php _e('cheapest' , 'parskala'); ?>
            </a>
        </li>

        <li class="order-item order-price-desc<?php echo ($orderby == 'price-desc' ? ' is-active' : ''); ?>">
            <a rel="nofollow" href="<?php echo prk_order_get_link( 'price-desc' ); ?>">
                <?php _e('expensive' , 'parskala'); ?>
            </a>
        </li>
    </ul>
  </div>
<?php
}

// filter by order mobile
function prK_orderby_filter_mobile() {

    ?>
    <span class="filter_by_botton show_sortby"><i class="ri-sort-desc"></i>مرتب سازی</span>
    <div id="filter-sidebar-mobile" class="remodals tabs_content_product mob_tab_filter_sortby remodal-full content_filter">
      <div class="remodal-header">
          <div class="title">مرتب سازی</div>
          <button data-remodal-action="close" class="remodal-back-tabs close_sortby">
            <i class="ri-close-line"></i>
          </button>
      </div>

       <div class="prK_orderby_mobile">

        <ul class="prk-order-products">
        <?php

        if( isset($_GET['orderby'] ) ) {
            $orderby = $_GET['orderby'];
        } elseif( is_search() ) {
            $orderby = 'relevance';
        } else {
            $orderby = get_option( 'woocommerce_default_catalog_orderby' );
        }
        ?>

            <?php if( is_search() ){ ?>
            <li class="order-item order-relevance<?php echo ($orderby == 'relevance' ? ' is-active' : ''); ?>">
                <a rel="nofollow" href="<?php echo prk_order_get_link( 'relevance' ); ?>">
                    <?php _e('پیشفرض' , 'parskala'); ?>
                </a>
            </li>

            <?php } elseif( $orderby == 'menu_order' || $orderby == '' ){ ?>
              <li class="order-item order-menu-order<?php echo ($orderby == 'menu_order' || $orderby == '' ? ' is-active' : ''); ?>">
            <a rel="nofollow" href="<?php echo prk_order_get_link( 'menu_order' ); ?>">
                <?php _e('default' , 'parskala'); ?>
            </a>
        </li>
        <?php } ?>

        <li class="order-item order-rating<?php echo ($orderby == 'rating' ? ' is-active' : ''); ?>">
            <a rel="nofollow" href="<?php echo prk_order_get_link( 'rating' ); ?>">
                <?php _e('Popular' , 'parskala'); ?>
            </a>
        </li>

        <li class="order-item order-popularity<?php echo ($orderby == 'popularity' ? ' is-active' : ''); ?>">
            <a rel="nofollow" href="<?php echo prk_order_get_link( 'popularity' ); ?>">
                <?php _e('popularity' , 'parskala'); ?>
            </a>
        </li>

        <li class="order-item order-date<?php echo ($orderby == 'date' ? ' is-active' : ''); ?>">
            <a rel="nofollow" href="<?php echo prk_order_get_link( 'date' ); ?>">
                <?php _e('newest' , 'parskala'); ?>
            </a>
        </li>

        <li class="order-item order-price<?php echo ($orderby == 'price' ? ' is-active' : ''); ?>">
            <a rel="nofollow" href="<?php echo prk_order_get_link( 'price' ); ?>">
                <?php _e('cheapest' , 'parskala'); ?>
            </a>
        </li>

        <li class="order-item order-price-desc<?php echo ($orderby == 'price-desc' ? ' is-active' : ''); ?>">
            <a rel="nofollow" href="<?php echo prk_order_get_link( 'price-desc' ); ?>">
                <?php _e('expensive' , 'parskala'); ?>
            </a>
        </li>
        </ul>

      </div>
    </div>
<?php
}


function prK_sidebarshop_mobile(){

  if ( is_active_sidebar('sideby-pro-widget') ) {

    if ( empty(is_active_sidebar('sideby-pro-widget')) ) {
      $class_shop = 'fullw';
    }else {
      $class_shop = '';
    }
    ?>

    <span class="filter_by_botton show_sidebar <?php echo $class_shop;?>" ><i class="ri-filter-off-line"></i>فیلتر کردن</span>
    <div id="filter-sidebar-mobile" class="remodals tabs_content_product mob_tab_filter_sidebar remodal-full content_filter" >

      <div class="remodal-header">
          <div class="title"><?php echo woocommerce_page_title();?></div>
          <button  class="remodal-back-tabs filter_sides_close">
            <i class="ri-close-line"></i>
          </button>
      </div>
     <?php

     // get sidebar shop
     echo '<div id="sides" class="sides">';

      dynamic_sidebar('sideby-pro-widget');

     echo '</div>';

     ?>

    </div>

    <?php
  }
}

//prk_order_get_link
function prk_order_get_link( $order_type ) {
    $base_link            = prk_shop_page_link( true );
    $link                 = remove_query_arg( 'orderby', $base_link );

    if( $order_type != 'menu_order' ) {
        $link = add_query_arg( 'orderby', $order_type, $link );
        $link = str_replace( '%2C', ',', $link );
    }

    return $link;
}




