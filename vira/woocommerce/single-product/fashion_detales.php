<?php


function prk_fashion_detales(){

  $prk_fashion_detales = '';

  // تنظیمات گارانتی
  $general_show_granti = prk_option('single_product_Warranty');
  $granti_show = get_post_meta(get_the_ID(), 'product_granti_show', true );
  $granti_text = general_granty_value();
  $product_share = prk_option('single_product_share');
  $product_vidoe = prk_option('single_product_vidoe');
  // تنظیمات سفارشی محصول
    $meta_opt = $vidoe_aparats = $vidoe_upload = "";
    $meta_opt = get_post_meta( get_the_ID(), 'prk_product_options', true );
    
    if(isset($meta_opt) && !empty($meta_opt)){
    if ( isset( $meta_opt['vidoe_upload']['url'] ) )		$vidoe_upload   	    = $meta_opt['vidoe_upload']['url'];
    if ( isset( $meta_opt['vidoe_aparats'] ) )		      $vidoe_aparats   	    = $meta_opt['vidoe_aparats'];
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

  if (prk_option('like_icon')){
    $like_icon = prk_option('like_icon');
  }else {
    $like_icon = 'ri-heart-3-fill';
  }

  ?>
  <div class="left_details">

    <?php if($general_show_granti && $granti_show == 'no'):?>
      <div class="granty_text"><i class="ri-shield-check-line"></i> <?php echo $granti_text;?></div>
    <?Php endif;?>

   <?php if (prk_option('single_product_whislist') == 1 || prk_option('single_product_share') == 1 ): ?>

    <div class="details_actions">

      <?php if (prk_option('single_product_share') == 1 ): ?>

      <button data-remodal-target="modalshare" type="button" class="btn_share_prk">
          <i class="flaticon-share"></i>
          <span>دوستاتو باخبر کن</span>
      </button>

      <?php endif; ?>

      <?php

      if (prk_option('single_product_whislist') == 1 ) {

          if (is_user_logged_in()){
          echo '<div class="btns-pro">';
          echo sit_after_add_to_cart_btn();

          echo '</div>';
          }else{
            echo '<div data-custom-open="loginmodal" class="btns-pro">';
            echo '<i class="'.$like_icon.' btns"></i>';

            echo '</div>';
          }
      }

       ?>

      <!--vidoe-btn-->
      <?php if ($product_vidoe && $vidoe_upload || $vidoe_aparats ):?>
        <a data-remodal-target="modalvidoe">
          <div class="btns-pro">
            <i class="<?php echo $video_icon;?> btns"></i>
            <span class="tooltiptext"><?php esc_html_e('video','vira');?></span>
          </div>
        </a>
      <?php endif;?>

    </div>
    
   <?php endif; ?>
  </div>

  <?php
  return $prk_fashion_detales;
}
