<?php

global $post, $product, $current_user;
$product_id = get_the_ID();



// تنظیمات کلی قالب
$product_whislist = prk_option('single_product_whislist');
$product_share = prk_option('single_product_share');
$product_vidoe = prk_option('single_product_vidoe');
$general_product_compare = prk_option('single_product_compare');
$product_compare = prk_option('single_product_compare_btn');
$prk_chartp = prk_option('single_product_prk_chartp');
$product_ask = prk_option('single_product_ask');
$compare_page = prk_option('compare_page');
$themeـstyle = prk_option('theme-style');

// تنظیمات سفارشی محصول
$meta_opt = $vidoe_aparats = $vidoe_upload = "";
$meta_opt = get_post_meta( get_the_ID(), 'prk_product_options', true );

if(isset($meta_opt) && !empty($meta_opt)){
  if ( isset( $meta_opt['vidoe_upload']['url'] ) )		$vidoe_upload   	    = $meta_opt['vidoe_upload']['url'];
  if ( isset( $meta_opt['vidoe_aparats'] ) )		      $vidoe_aparats   	    = $meta_opt['vidoe_aparats'];
}



if (is_user_logged_in()) {

  $userid = get_current_user_id();
  $notify_product = new NotifyProductActivity($product_id,$userid);
  $notify_product_instock = $notify_product->check_instock_subscribed($userid);
  $notify_product_amazing = $notify_product->check_amazing_subscribed($userid);

  if ($notify_product_instock || $notify_product_amazing) {
    $active_icon = 'prk-notification-bing';
    $class_done = 'done';
  }else {
    $active_icon = 'prk-notification';
    $class_done = '';
  }
}else {
  $active_icon = 'prk-notification';
}
// فراخانی برگه مقایسه محصول
$compare_short ="";
 $arms = array(
    'post_type' => 'page',
    'posts_per_page' => '1',
    'post_status' => 'publish',
    'post__in' => array($compare_page),
);
$pd_query = new WP_Query( $arms );

if ( $pd_query ->have_posts() ) {
  while ( $pd_query ->have_posts() ) {
    $pd_query ->the_post();
    $compare_short = get_permalink() ;
  }
  wp_reset_postdata();
}


if (prk_option('share_icon')){
  $share_icon = prk_option('share_icon');
}else {
  $share_icon = 'ri-share-fill';
}



if (prk_option('compare_icon')){
  $compare_icon = prk_option('compare_icon');
}else {
  $compare_icon = 'ri-qr-scan-fill btns';
}

if (prk_option('chart_icon')){
  $chart_icon = prk_option('chart_icon');
}else {
  $chart_icon = 'ri-line-chart-fill';
}

if (prk_option('video_icon')){
  $video_icon = prk_option('video_icon');
}else {
  $video_icon = 'ri-movie-fill';
}
if (prk_option('ques_icon')){
  $ques_icon = prk_option('ques_icon');
}else {
  $ques_icon = 'ri-questionnaire-fill';
}

if (is_user_logged_in()) {
  $data_target = 'data-remodal-target="notifyproduct"';
}else {
  $data_target = 'data-custom-open="loginmodal"';
}


function prk_check_product_type(){
  global $post, $product, $current_user;
  $product_id = get_the_ID();
    if($product->is_type('simple')){
        return 'simple';
    }elseif($product->is_type('variable')){
        return 'variable';
    }
}

function prk_check_in_stock(){
  global $post, $product, $current_user;
  $product_id = get_the_ID();
   return (get_post_meta($product_id, '_stock_status', true ) == 'instock' || $product->is_in_stock() )? true:false;
}

function prk_check_amazing(){
  global $post, $product, $current_user;
  $product_id = get_the_ID();
    if((get_post_meta($product_id, 'onsales_round', true ) == 'yes')){
        if(prk_check_product_type()=='variable') {
            $variation_ids = $product->get_children();
            foreach($variation_ids as $variation_id){
                $sale_price = get_post_meta( $variation_id, '_sale_price', true );
                if($sale_price !=''){
                    return true;
                }
            }
        }elseif(prk_check_product_type()=='simple'){
            $sale_price = get_post_meta($product_id, '_sale_price', true );
            if($sale_price !=''){
                return true;
            }
        }
    }

    return false;

}

 ?>

<!-- دکمه های ناوبری -->
<?php if ( prk_option('prk_modern_mobile') && mobile_cheker() || tablet_cheker() ): ?>

  <div class="product-more-icon-dates">

    <ul>

      <?php
      if( $product->is_type('variable') && $prk_chartp  ) {
       $product_childs = $product->get_children();
       foreach($product_childs as $product_child ){
         if ( get_post_meta($product_child,'date_and_price_chart',true) ) {
           echo '<li class="action"><a href="#" onclick="get_price_chart_product('.$product->get_id().');" data-remodal-target="modalchartprice">
            <i class="prk-diagram"></i>
            <span class="product-more-icon-text">نمودار قیمت</span>
           </a></li>';
           break;
         }
       }
     }
       if( $product->is_type('simple') && get_post_meta($product->get_id(),'_simplePriceChart',true) && $prk_chartp )
       echo '<li class="action">
       <a onclick="get_price_chart_product('.$product->get_id().');" data-remodal-target="modalchartprice" >
       <i class="prk-diagram"></i>
       <span class="product-more-icon-text">نمودار قیمت</span>
       </a></li>';

       ?>

       <?php if (prk_option('show_wolfnotify') &&  !$product->is_type('grouped')): ?>
         <?php if ( !prk_check_in_stock() || !prk_check_amazing() ): ?>
          <li class="action">
             <a <?= $data_target?>>
               <i class="<?= $active_icon?> <?=$class_done?> btns"></i>
               <span class="product-more-icon-text">مرا اگاه کن</span>
             </a>
           </li>
         <?php endif; ?>
       <?php endif; ?>

       <!--compre-btn-->
       <?php
        if ($compare_page && $product_compare && $general_product_compare) {
         global $yith_woocompare;
         ?>
         <li>
          <a href="<?php echo $compare_short ?>?products=<?php echo get_the_ID(); ?>" class="compare-buttons" rel="nofollow">
          <i class="prk-slider-vertical"></i>
          <span class="product-more-icon-text">مقایسه محصول</span>
          </a>
         </li>
       <?php
       }
       ?>

       <?php if ($product_share):?>
        <li class="action">
        	<a data-remodal-target="modalshare">
            <i class="flaticon-share right2 fsize23"></i>
            <span class="product-more-icon-text">به اشتراک گذاری</span>
          </a>
        </li>
      <?php endif;?>



      <!--vidoe-btn-->
      <?php if ($product_vidoe && $vidoe_upload || $vidoe_aparats ):?>
      <li class="action">
       <a data-remodal-target="modalvidoe">
           <i class="<?php echo $video_icon;?> btns"></i>
           <span class="tooltiptext">ویدیو</span>
       </a>
      </li>
     <?php endif;?>



    </ul>
  </div>

  <?php endif; ?>

  <!-- دکمه های ناوبری -->
<?php if (prk_option('prk_modern_mobile') == 1 ): ?>

  <?php if ( !mobile_cheker() && !tablet_cheker() ): ?>
    <div class="btns-pro-slider">
      <?php

      if ($product_whislist) {

        if (is_user_logged_in()){
        echo '<div class="btns-pro">';
        echo sit_after_add_to_cart_btn();
        echo '<span class="tooltiptext">افزودن به علاقه مندی ها</span>';
        echo '</div>';
        }else{
          echo '<div data-custom-open="loginmodal" class="btns-pro">';
          echo '<i class="prk-heart btns"></i>';
          echo '<span class="tooltiptext">افزودن به علاقه مندی ها</span>';
          echo '</div>';
        }

      }

       ?>

     <?php if ($product_share):?>
    	<a data-remodal-target="modalshare"><div class="btns-pro" >
        <i class="<?php echo $share_icon;?> btns"></i>
        <span class="tooltiptext">اشتراک گذاری</span></div>
      </a>
    <?php endif;?>

   <?php if (prk_option('show_wolfnotify') &&  !$product->is_type('grouped')): ?>
     <?php if ( !prk_check_in_stock() || !prk_check_amazing() ): ?>

       <a <?= $data_target?>>
         <div class="btns-pro">
           <i class="<?= $active_icon?> <?=$class_done?> btns"></i>
           <span class="tooltiptext">مرا اگاه کن</span>
         </div>
       </a>

     <?php endif; ?>
   <?php endif; ?>


    <!--compre-btn-->
    <?php
     if ($compare_page && $product_compare && $general_product_compare) {
      global $yith_woocompare;
      ?>
      <div class="btns-pro compares">
       <a href="<?php echo $compare_short ?>?products=<?php echo get_the_ID(); ?>" class="compare-buttons" rel="nofollow">
       <i class="<?php echo $compare_icon;?> btns"></i>
      <span class="tooltiptext">مقایسه</span>
       </a>
      </div>
    <?php
    }
    ?>

    <?php
    if( $product->is_type('variable') && $prk_chartp  ) {
     $product_childs = $product->get_children();
     foreach($product_childs as $product_child ){
       if ( get_post_meta($product_child,'date_and_price_chart',true) ) {
         echo '<div class="btns-pro"><span onclick="get_price_chart_product('.$product->get_id().');" class="product_details_icon chart_price" data-remodal-target="modalchartprice">
          <i class="'.$chart_icon.' btns"></i>
          <span class="tooltiptext">نمودار قیمت</span>
         </span></div>';
         break;
       }
     }
    }

    if( $product->is_type('simple') && get_post_meta($product->get_id(),'_simplePriceChart',true) && $prk_chartp )
    echo '<div class="btns-pro">
    <span onclick="get_price_chart_product('.$product->get_id().');" class="product_details_icon chart_price" data-remodal-target="modalchartprice" >
    <i class="'.$chart_icon.' btns"></i>
    <span class="tooltiptext">نمودار قیمت</span>
    </span></div>';
    ?>

   <!--vidoe-btn-->
   <?php if ($product_vidoe && $vidoe_upload || $vidoe_aparats ):?>
    <a data-remodal-target="modalvidoe">
      <div class="btns-pro">
        <i class="<?php echo $video_icon;?> btns"></i>
        <span class="tooltiptext">ویدیو</span>
      </div>
    </a>
  <?php endif;?>



    </div>

<?php endif; ?>

<?php else:?>

  <div class="btns-pro-slider">
    <?php

    if ($product_whislist) {

      if (is_user_logged_in()){
      echo '<div class="btns-pro">';
      echo sit_after_add_to_cart_btn();
      echo '<span class="tooltiptext">افزودن به علاقه مندی ها</span>';
      echo '</div>';
      }else{
        echo '<div data-custom-open="loginmodal" class="btns-pro">';
        echo '<i class="prk-heart btns"></i>';
        echo '<span class="tooltiptext">افزودن به علاقه مندی ها</span>';
        echo '</div>';
      }

    }

     ?>

   <?php if ($product_share):?>
  	<a data-remodal-target="modalshare"><div class="btns-pro" >
      <i class="<?php echo $share_icon;?> btns"></i>
      <span class="tooltiptext">اشتراک گذاری</span></div>
    </a>
  <?php endif;?>




  <!--compre-btn-->
  <?php
   if ($compare_page && $product_compare && $general_product_compare) {
    global $yith_woocompare;
    ?>
    <div class="btns-pro compares">
     <a href="<?php echo $compare_short ?>?products=<?php echo get_the_ID(); ?>" class="compare-buttons" rel="nofollow">
     <i class="<?php echo $compare_icon;?> btns"></i>
    <span class="tooltiptext">مقایسه</span>
     </a>
    </div>
  <?php
  }
  ?>

  <?php
  if( $product->is_type('variable') && $prk_chartp  ) {
   $product_childs = $product->get_children();
   foreach($product_childs as $product_child ){
     if ( get_post_meta($product_child,'date_and_price_chart',true) ) {
       echo '<div class="btns-pro"><span onclick="get_price_chart_product('.$product->get_id().');" class="product_details_icon chart_price" data-remodal-target="modalchartprice">
        <i class="'.$chart_icon.' btns"></i>
        <span class="tooltiptext">نمودار قیمت</span>
       </span></div>';
       break;
     }
   }
  }

  if( $product->is_type('simple') && get_post_meta($product->get_id(),'_simplePriceChart',true) && $prk_chartp )
  echo '<div class="btns-pro">
  <span onclick="get_price_chart_product('.$product->get_id().');" class="product_details_icon chart_price" data-remodal-target="modalchartprice" >
  <i class="'.$chart_icon.' btns"></i>
  <span class="tooltiptext">نمودار قیمت</span>
  </span></div>';
  ?>

 <!--vidoe-btn-->
 <?php if ($product_vidoe && $vidoe_upload || $vidoe_aparats ):?>
  <a data-remodal-target="modalvidoe">
    <div class="btns-pro">
      <i class="<?php echo $video_icon;?> btns"></i>
      <span class="tooltiptext">ویدیو</span>
    </div>
  </a>
<?php endif;?>

  </div>

<?php endif; ?>
