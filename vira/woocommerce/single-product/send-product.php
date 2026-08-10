<?php
// send product
function product_sendes(){
  $sendes_peoduct = '';
  global $product;
  $product_sendes = prk_option('single_product_sendes');
  $date_send_pro = get_post_meta(get_the_ID(), 'date_send_pro', true );

  $send_img = get_parent_theme_file_uri('assets/img/date-send.svg' );
  $logo_uploaded = prk_option('product_sendes_img');
  if(isset($logo_uploaded['url']) && $logo_uploaded['url'] != '') { $send_img = $logo_uploaded['url']; }

  if ($product_sendes){
    if ($product->is_in_stock()){
      if ($date_send_pro){
      echo '<span class="date-send-pro">';
      echo '<cite>';
      echo '<i>';
      echo _e('Ready to send' , 'vira');
      echo '</i>';
      echo '<span class="sends-date">';
      echo _e(' تحویل تا ' , 'vira');
      echo  $date_send_pro;
      echo _e(' روز کاری ' , 'vira');
      echo '</span>';
      echo '</cite>';
      echo '<div class="send-img"><img src="'.$send_img.'" alt="date send" width="132" height="77"></div>';
      echo '</span>';
      }
    }
  }
  return $sendes_peoduct;
}
