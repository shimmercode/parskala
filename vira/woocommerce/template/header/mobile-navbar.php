<?php
if ( prk_option('modern_mobile_second_toolbar') && !empty(prk_option('prk_toolbar_seconds_menu')) ) {
  $have_second = ' havsecond';
}else {
  $have_second = '';
}

if ( class_exists( 'WooCommerce' ) ) {
  if ( is_product() ) {
    echo '<div class="show-navbar"><i class="prk-textalign-left"></i></div>';
    $in_product = ' inproduct';
    $noindex = ' noindex';
  }else {
    $in_product = '';
    $noindex = '';
  }
}
?>

<!-- socials box -->
<?php if (prk_option('prk_socials_box') && !empty(prk_option('prk_socials_item')) ): ?>
<ul class="socials-box">
<?php foreach (prk_option('prk_socials_item') as $key => $item):?>

 <li>
   <a href="<?= $item['url']?>"> <i <?php if($item['color']) echo 'style="color:'.$item['color'].'"'; ?> class="<?= $item['icon']?>"></i> </a>
 </li>

<?php endforeach;?>
</ul>
<?php endif;?>

<!-- mobile navbar -->
<?php if (prk_option('modern_mobile_toolbar') && !empty(prk_option('prk_toolbar_menu')) ):

if ( is_cart() && !WC()->cart->is_empty() ) {
  return;
}

?>
<div class="mobile-navbar-menu<?= $have_second?><?= $noindex?>">


    <!-- general navbar -->
    <nav class="mobile-bottom-navabr<?= $in_product?>">
      <?php foreach (prk_option('prk_toolbar_menu') as $key => $item):

        // check active link
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $class_active='';
        if($item['url']==rtrim($actual_link,'/')){
          $class_active='1';
        }

       if(preg_match('/^(ftp|http|https):\/\/[^ "]+\/(ptest|my-account|cart)?\/?/',$item['url'],$matches)){
         $pluser = '';
         $data_open = '';
         $href = $item['url'];
         if($matches[2]=='my-account'){

           $class_url = 'account1';
          if ( ! is_user_logged_in() && empty(prk_option('header_account_type') == 'link') ) {
            $href = '#';
            $data_open = 'data-custom-open="loginmodal"';
          }else {
            $href = $item['url'];
          }
          if ( is_user_logged_in() ) {
            $pluser = '<span class="bold-check ri-check-line"></span>';
          }

         }elseif($matches[2]=='cart'){

          $pluser = '<span class="cart-count"></span>';
           $class_url = 'cart1';

         }

       }

       ?>

      <div class="mobile-bottom-navitem <?php echo $class_url ?>">
       <a href="<?php echo  $href ? $href :  home_url();?>" <?= $data_open?>>
         <i <?php if($item['color']) echo 'style="color:'.$item['color'].'"'; ?> class="<?= $item['icon'].''.$class_active;?>"><?= $pluser?></i>
           <?php if ($item['show_text' == '1']): ?>
             <span><?= $item['text']?></span>
           <?php endif; ?>
       </a>
      </div>

      <?php endforeach; ?>

     </nav>

   <?php if (prk_option('modern_mobile_second_toolbar') && !empty(prk_option('prk_toolbar_seconds_menu')) ): ?>

     <!-- general navbar -->
     <nav class="mobile-bottom-navabr second">
       <?php foreach (prk_option('prk_toolbar_seconds_menu') as $key => $item):

        if ($item['type'] == 'paged') {
          $type_menu = 'button-native-navabr';
        }else {
          $type_menu = 'mobile-bottom-navitem';
        }

        ?>

    <div class="<?= $type_menu?>">
    <a <?php if($item['back'] && $item['type'] == 'paged'){echo 'style="background-color:'.$item['back'].'"';} ?> href="<?= $item['url']?>">
      <?php if ($item['type'] == 'paged'): ?>

        <?php if ($item['show_text' == '1']): ?>
          <span><?= $item['text']?></span>
        <?php endif; ?>
        <i <?php if($item['color']) echo 'style="color:'.$item['color'].'"'; ?> class="<?= $item['icon']?>"></i>
      <?php else: ?>
        <i <?php if($item['color']) echo 'style="color:'.$item['color'].'"'; ?> class="<?= $item['icon']?>"></i>
        <?php if ($item['show_text'] == '1'): ?>
          <span><?= $item['text']?></span>
        <?php endif; ?>
      <?php endif; ?>

     </a>
    </div>




    <?php endforeach; ?>

   </nav>

  <?php endif; ?>

</div>

<?php endif; ?>
<!-- second navbar menu -->
