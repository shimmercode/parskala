<?php
$topbar_bg_img = '';
$prk_topbar_text_color = '#fdfdfd';
$prk_topbar_bg_color = '#EF394E';
$prk_topbar_blink_color = '#fdfdfd';
$prk_topbar_blink_bg_color = '#fff';
$prk_topbar_true = prk_option('prk_topbar_true');
$prk_topbar_true = prk_option('prk_topbar_true');
$prk_topbar_text = prk_option('prk_topbar_text');

$prk_top_gif_url = '';
$prk_chose_topbar = prk_option('prk_chose_topbar');
$prk_top_gif_img = prk_option('prk_top_gif_img');
$prk_top_gif_img_mob = prk_option('prk_top_gif_img_mob');
$prk_top_gif_url = prk_option('prk_top_gif_url');

$prk_topbar_text_color = prk_option('prk_topbar_text_color');
$prk_topbar_bg_color = prk_option('prk_topbar_bg_color');

$prk_topbar_bg_img = prk_option('prk_topbar_bg_img');
if(isset($prk_topbar_bg_img['url']) && $prk_topbar_bg_img['url'] != '') {
  $topbar_bg_img = $prk_topbar_bg_img['url'];
}
$prk_topbar_close = prk_option('prk_topbar_close');
$prk_topbar_blink = prk_option('prk_topbar_blink');
$prk_topbar_blink_text = prk_option('prk_topbar_blink_text');
$prk_topbar_blink_url = prk_option('prk_topbar_blink_url');

$prk_topbar_blink_color = prk_option('prk_topbar_blink_color');
$prk_topbar_blink_bg_color = prk_option('prk_topbar_blink_bg_color');
$prk_topbar_stikey = prk_option('prk_topbar_stikey');
if ($prk_topbar_stikey) {
  $sticky_classes = 'top_stikey';
}else {
  $sticky_classes = '';
}

$prk_topbar_stikey = prk_option('prk_topbar_text_center');
if ($prk_topbar_stikey) {
  $text_center = 'text_center';
}else {
  $text_center = '';
}

 ?>

<?php if ($prk_topbar_true):?>

  <?php if ( $prk_chose_topbar == 'gif'): ?>

    <?php if ($prk_top_gif_img_mob && mobile_cheker() || tablet_cheker() ): ?>

      <section id="topbars" class="topbars image_back">

        <a href="<?php echo $prk_top_gif_url;?>">
          <img src="<?php echo $prk_top_gif_img_mob;?>" alt="topbar">
        </a>

      </section>
      
    <?php elseif ($prk_top_gif_img): ?>

      <section id="topbars" class="topbars image_back <?php echo $sticky_classes;?>">

        <a href="<?php echo $prk_top_gif_url;?>">
          <img src="<?php echo $prk_top_gif_img;?>" alt="topbar">
        </a>

      </section>

    <?php endif; ?>

  <?php else: ?>

  <section style="background: url(<?php echo esc_url($topbar_bg_img); ?>);background-color:<?php echo $prk_topbar_bg_color;?>" id="topbars" class="topbars <?php echo $sticky_classes;?>">

    <div class="main-topbars">

       <div class="continer <?php echo $text_center;?>">
         <?php if ($prk_topbar_close):?><a class="topbar-close"><i class="fal fa-times"></i></a><?php endif;?>
       <div class="topbar-text">
       <p style="color:<?php echo $prk_topbar_text_color;?>"><?php echo $prk_topbar_text;?></p>
       </div>
       <?php if ($prk_topbar_blink):?>
       <div class="topbar-link">
      <a style="color:<?php echo $prk_topbar_blink_color; ?>;background:<?php echo $prk_topbar_blink_bg_color; ?>" href="<?php echo $prk_topbar_blink_url; ?>" target="_blank"> <?php echo $prk_topbar_blink_text;?></a>
       </div>
      <?php endif;?>
       </div>

    </div>

  </section>

  <?php endif; ?>

<?php endif;?>
