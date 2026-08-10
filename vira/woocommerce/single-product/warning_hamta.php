<?php

function warning_hamta(){
  $warnings = '';
  $hamta_img = get_parent_theme_file_uri('assets/img/point.png' );
  $hamta_show = get_post_meta(get_the_ID(), 'product_hamta_show', true );
  $hamta_text = get_post_meta(get_the_ID(), 'product_hamta_text', true );

  if ($hamta_show == 'yes' && $hamta_text && ( prk_option('single_hamta_show') == '1' || prk_option('single_hamta_show') == '' ) ){
    echo '<span class="hamta">';
    echo '<i class="exclamation-circle"><img src=" '.$hamta_img.'" alt="date send"></i>';
    echo '<span class="text-hamta">';
      echo _e($hamta_text , 'parskala');
    echo '</span></span>';
  }
  return $warnings;
}
