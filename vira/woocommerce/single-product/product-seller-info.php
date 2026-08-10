<?php

// start product seller info
function seller_info(){
  $seller_product = '';
  $vendor_ids = $vendor_id = $vendor = $store_info = $store_name = $store_url = $dokan_good = $vendor2 = "";
  global $product;
  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
  $active_dokan = is_plugin_active( 'dokan-lite/dokan.php' );

  if (check_dokan_plugin_state()){
    
    $vendor_id = get_post_field( 'post_author', get_the_id() );
    $vendor      = new WP_User($vendor_id);
    $vendor2     = dokan()->vendor->get( $vendor_id);
    $dokan_good  = $vendor2->is_featured() ? $vendor2->is_featured() : '';
    $store_info  = dokan_get_store_info( $vendor_id );
    $store_name  = $store_info['store_name'];
    $store_url   = dokan_get_store_url( $vendor_id );
    $store_profile  = dokan_get_store_info( $vendor_id );
    $udata = get_userdata( $vendor_id );

    $operation_stillses = __('Overall performance of the seller','vira');
    // stills variations
    $user_registered = human_time_diff( strtotime( $udata->user_registered ) , current_time( 'timestamp' ) );
    $stills_count = ! empty( get_user_meta( $vendor_id, 'dokan_consent', true ) ) ? prk_option('dokan_consent') : 96;
    $supply = ! empty( get_user_meta( $vendor_id, 'dokan_supply', true ) ) ? prk_option('dokan_supply') : 89;
    $Commitmentـsend = ! empty( get_user_meta( $vendor_id, 'dokan_Commitment', true ) ) ? prk_option('dokan_Commitment') : 91;
    $Noـreference = ! empty( get_user_meta( $vendor_id, 'dokan_reference', true ) ) ? prk_option('dokan_reference') : 87;
    $stills =     get_user_meta( $vendor_id, 'stills_types', true );

    $stills_name = __('great','vira');
    if ($stills == 'great'){
     $stills_name = __('great','vira');
     $stills_color = '#00a049';
    }elseif($stills == 'very_good'){
     $stills_name = __('very good','vira');
    $stills_color = '#b1b64d';
    }elseif($stills == 'good'){
     $stills_name = __('good','vira');
     $stills_color = '#b1b64d';
    }elseif($stills == 'medium'){
     $stills_name = __('medium','vira');
     $stills_color = '#b1b64d';
    }
    if ($dokan_good) {
      $good_class = 'good';
    }else {
      $good_class = '';
    }
  
    $seller_name  = $store_name;

  }elseif( prk_option('is_featured_shop') == '1' ){
    
    $operation_stillses = 'عملکرد کلی فروشگاه';


    // shop variations
    $dokan_good  = prk_option('is_featured_shop') ? prk_option('is_featured_shop') : '';
    $stills_count = ! empty( prk_option('dokan_consent') ) ? prk_option('dokan_consent') : 96;
    $supply = ! empty( prk_option('dokan_supply') ) ? prk_option('dokan_supply') : 89;
    $Commitmentـsend = ! empty( prk_option('dokan_Commitment') ) ? prk_option('dokan_Commitment') : 91;
    $Noـreference = ! empty( prk_option('dokan_reference') ) ? prk_option('dokan_reference') : 87;
    $stills =     prk_option('stills_types');
    $user_registered = prk_option('shop_registered');

    
    $stills_name = __('great','vira');
    if ($stills == 'great'){
     $stills_name = __('great','vira');
     $stills_color = '#00a049';
    }elseif($stills == 'very_good'){
     $stills_name = __('very good','vira');
    $stills_color = '#b1b64d';
    }elseif($stills == 'good'){
     $stills_name = __('good','vira');
     $stills_color = '#b1b64d';
    }elseif($stills == 'medium'){
     $stills_name = __('medium','vira');
     $stills_color = '#b1b64d';
    }
    
  }

  if ($active_dokan){
    $store_info  = dokan_get_store_info( $vendor_id );
    $store_name  = $store_info['store_name'];
    $seller_name  = $store_name;
  }elseif( !empty(prk_option('shop_name')) ){
    $seller_name  = prk_option('shop_name');
  }else{
    $seller_name  = get_bloginfo('name');
  }

  // تنظیمات گارانتی
  $general_show_granti = prk_option('single_product_Warranty');
  $granti_show = get_post_meta(get_the_ID(), 'product_granti_show', 'no' );
  $granti_text = general_granty_value();
  ///////////////

  // تنظیمات ضمانت نامه
  $general_orginal_show = prk_option('single_product_bail');
  $Original_show = get_post_meta(get_the_ID(), 'product_Original_show', true );
  $Original_text = general_orginal_value();
  ////////////////////

  // تنظیمات ارسال محصول
  $single_product_send = prk_option('single_product_send');
  $single_product_bail_text = product_send_title();

    $send_title = "";
    if ($active_dokan){
     $send_title = 'ارسال توسط '.$seller_name;
    }else{
     $send_title = $single_product_bail_text;
    }


  if ($dokan_good) {
    $good_class = 'good';
  }else {
    $good_class = '';
  }

  // ایکن فروشنده محصو

  if (prk_option('seller_icon')) {
    $seller_icon = prk_option('seller_icon');
  }else {
    $seller_icon = 'seller-store';
  }

  if (prk_option('gard_icon')) {
    $gard_icon = prk_option('gard_icon');
  }else {
    $gard_icon = 'ri-shield-check-line';
  }

  if (prk_option('zemanat_icon')) {
    $zemanat_icon = prk_option('zemanat_icon');
  }else {
    $zemanat_icon = 'ri-refresh-line';
  }

  if (prk_option('stok_icon')) {
    $stok_icon = prk_option('stok_icon');
  }else {
    $stok_icon = 'share-square';
  }






  ?>
<!-- start of product-seller-info -->
 <div class="product-seller-info">
 <div class="seller-info-changeable">




   <?php if( class_exists( 'Dokan_SPMV_Products' ) ) {
     echo '<div class="product-seller-counter">';
      
     $lists = (new Dokan_SPMV_Products)->get_other_reseller_vendors( $product->get_id() );

     echo '<span class="label">'._e ('seller','vira').'</span>';

     if ( mobile_cheker() || tablet_cheker() ) {

       if ( $lists ) { ?>
          <a href="#" data-remodal-target="modal-more-seller" class="anchor-link"><?php echo count($lists);?> <?php _e ('فروشنده دیگر','vira');?></a>
      <?php }

    }else {

      if ( $lists ) { ?>
         <a href="#servesis-single" id="vendors-count-link" class="anchor-link"><?php echo count($lists);?> <?php _e ('فروشنده دیگر','vira');?></a>
     <?php }

      }
  echo '</div>';
    }
     ?>


  <?php if(product_seller_show()):?>
    <!-- seller info -->
    <div class="product-seller-row seller_name">
      <!-- seller icon -->
      <div class="product-seller-row-icon">
        <i class="<?php echo $seller_icon;?> <?php echo $good_class;?>"></i>
      </div>
      <!-- seller detail -->
      <div id="myButton_stills" class="product-seller-row-detail">
        <!-- seller name -->
       <div class="product-seller-name mb-8">

          <?php _e($seller_name , 'vira');?>

       </div>

       <?php if($dokan_good){echo '<dpan class="good-seller">' .__('Chosen','vira'). '</dpan>';}?>

      <?php if ($active_dokan || prk_option('is_featured_shop') == '1' ):?>
       <div id="template_stills" style="display: none;" class="data-content">
          <div class="stills_contienr">
            <div class="shop_names">
              <span class="name"><?= _e('Store','vira') ?> <?php echo $seller_name;?></span>
              <p class="register_seller"><?php echo __('Membership from', 'vira');?> <?php echo $user_registered; ?> <?= _e('Before','vira') ?></p>
            </div>

            <div class="seller_stillses">
              <span style="color:<?php echo $stills_color;?>"><?php echo $stills_name;?></span>
            </div>

            <div class="operation_stillses">
              <span><?= $operation_stillses ?></span>
            </div>

            <div class="seller-feedback">

              <div class="seller-feedback-item yellow">

               <div class="circle-progress" data-percentage="<?php echo $supply;?>" >
                  <span class="progress-left"><span class="progress-bar"></span></span>
                  <span class="progress-right"><span class="progress-bar"></span></span>
                  <div class="progress-value"><div><?php echo $supply;?>%</div></div>
               </div>
               <span><?= _e('No return','vira') ?></span>

               </div>

              <div class="seller-feedback-item green">
                
                <div class="circle-progress" data-percentage="<?php echo $Commitmentـsend;?>" >
                   <span class="progress-left"><span class="progress-bar"></span></span>
                   <span class="progress-right"><span class="progress-bar"></span></span>
                   <div class="progress-value"><div><?php echo $Commitmentـsend;?>%</div></div>
                </div>
                <span><?= _e('Obligation to send','vira') ?></span>
 
                </div>

    
              <div class="seller-feedback-item red">
                
                <div class="circle-progress" data-percentage="<?php echo $Noـreference;?>" >
                   <span class="progress-left"><span class="progress-bar"></span></span>
                   <span class="progress-right"><span class="progress-bar"></span></span>
                   <div class="progress-value"><div><?php echo $Noـreference;?>%</div></div>
                </div>
                <span><?= _e('timely supply','vira') ?></span>
 
                </div>

          </div>

          </div>
      </div>

      <?php if (empty(mobile_cheker()) && empty(tablet_cheker()) ): ?>
         <script>
           jQuery(document).ready(function(){
               const template = document.getElementById("template_stills");
               tippy("#myButton_stills", {
                   content: template.innerHTML,
                   allowHTML: true,
                   theme: 'light',
                   interactive: true,
                   placement: 'right',
               });
           });
        </script>
      <?php endif; ?>
        <!-- seller rate -->
       <div class="seller-final-score-container">
         <div class="seller-rate-container">
            <span class="seller-rate fa-num"><?php echo $stills_count;?>%</span>
            <span class="label"><?= _e('Official','vira') ?></span>
            <span class="divider"></span>
            <span class="label"><?= _e('Function','vira') ?></span>
            <span style="color:<?php echo $stills_color;?>" class="seller-final-score <?php echo $good_class;?>"><?php echo $stills_name;?></span>
          </div>
       </div>
       <a href="#" class="seller-info-link"></a>
    <?php endif;?>

      </div>
    </div>
  <?php endif;?>
<!-- seller granty -->
  <?php if($general_show_granti && $granti_show == 'no'):?>
  <div class="product-seller-row centes">
    <!-- granty icon -->
   <div class="product-seller-row-icon">
     <i class=" <?php echo $gard_icon;?>"></i>
   </div>
   <!-- granty title -->
   <div class="product-seller-row-detail">
     <div class="product-seller-row-detail-title">

             <?php _e( $granti_text , 'vira');?>
     </div>
   </div>
  </div>
  <?php endif;?>

  <!-- seller zemanat -->
  <?php if($general_orginal_show && $Original_show == 'no'):?>
  <div class="product-seller-row centes">
    <!-- zemanat icon -->
   <div class="product-seller-row-icon">
    <i class=" <?php echo $zemanat_icon;?>"></i>
   </div>
   <!-- zemanat title -->
   <div class="product-seller-row-detail">
    <div class="product-seller-row-detail-title">
       <?php echo $Original_text;?> <!-- ضمانت اصالت کالا -->
    </div>
   </div>
  </div>
  <?php endif;?>

  <!-- seller sends -->
  <?php if($single_product_send):?>
    <div class="product-seller-row">
      <!-- sends icon -->
      <div class="product-seller-row-icon">
       <i class="<?php echo $stok_icon;?>"></i>
      </div>
      <!-- sends detail -->
      <div class="product-seller-row-detail">
        <a  data-remodal-target="send_modal" class="cursor">

        <div class="product-seller-row-detail-title mb-8 send-seller">
          <?php
            if(!$product->is_type( 'variable' )){

              if (wc_get_stock_html( $product )){
              echo '<span>'.wc_get_stock_html( $product ).'</span>';
              }else {
              echo 'موجود در انبار';
              }
              }
          ?>
        <i class="chevrons-right"></i>
        </div>
       </a>
        <ul><li class="pluses"><?php echo $send_title;?></li></ul>
      </div>

    </div>
  <?php endif;?>

 </div>
 </div>
  <?php
  return $seller_product;
}
