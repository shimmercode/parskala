<?php

/**
 * To overwrite this template create a file name after-add-btn.php
 * and put it in your active-theme-folder/woocommerce folder
 */


  if (prk_option('like_icon_after')){
    $like_icon_after = prk_option('like_icon_after');
  }else {
    $like_icon_after = 'ri-heart-3-fill';
  }
?>
<i style="color:#ec0000ba;" class="<?php echo $like_icon_after ;?> btns after"></i>
