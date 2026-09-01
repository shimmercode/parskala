<?php
/**
 * To overwrite this template create a file name before-add-btn.php
 * and put it in your active-theme-folder/woocommerce folder
 */

 if (prk_option('like_icon')){
   $like_icon = prk_option('like_icon');
 }else {
   $like_icon = 'ri-heart-3-fill';
 }
?>
<i class="<?php echo $like_icon;?> btns before"></i>
