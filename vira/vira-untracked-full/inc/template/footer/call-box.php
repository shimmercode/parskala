<?php

if (prk_option('caller_tabs_posi') == 'left' ) {
  $pos_class = ' left_p';
}else {
  $pos_class = ' right_p';
}
if (prk_option('tabs_true') == 1 || prk_option('prk_modern_mobile') == 1  ) {
  $tabs_adder = ' havetool';
}else {
  $tabs_adder = '';
}

?>
<?php if (prk_caller()): ?>
<div class="call_box<?= $pos_class; ?><?= $tabs_adder?>">

 <div class="call_main">
  <ul>
    <li class="call_close_mobile">بستن<i class="close-icon close_icon"></i></li>
   <?php foreach (prk_caller_repaters() as $item): ?>
    <li>
      <a class="flexd" rel="nofollow noopener" href="<?php echo $item['caller_url'];?>" target="_blank">
        <span><?php echo $item['caller_name'];?></span>
        <div style="background-color: <?php echo $item['caller_color'];?>" class="call_item_icon">
          <i class="<?php echo $item['caller_icon'];?>"></i>
        </div>
     </a>
    </li>
   <?php endforeach; ?>
  </ul>

 </div>

<div class="call_button pluser noselect">

  <div class="prk-open-caller">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
      <path fill="currentColor" d="M448 0H64C28.7 0 0 28.7 0 64v288c0 35.3 28.7 64 64 64h96v84c0 9.8 11.2 15.5 19.1 9.7L304 416h144c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64zM320 133.2c14.8 0 26.8 12 26.8 26.8s-12 26.8-26.8 26.8-26.8-12-26.8-26.8 12-26.8 26.8-26.8zm-128 0c14.8 0 26.8 12 26.8 26.8s-12 26.8-26.8 26.8-26.8-12-26.8-26.8 12-26.8 26.8-26.8zm164.2 140.9C331.3 303.3 294.8 320 256 320c-38.8 0-75.3-16.7-100.2-45.9-5.8-6.7-5-16.8 1.8-22.5 6.7-5.7 16.8-5 22.5 1.8 18.8 22 46.5 34.6 75.8 34.6 29.4 0 57-12.6 75.8-34.7 5.8-6.7 15.9-7.5 22.6-1.8 6.8 5.8 7.6 15.9 1.9 22.6z">
      </path>
    </svg>
    <span class="title_caller"><?php _e('contact us', 'parskala'); ?></span>
  </div>

  <div class="prk-close-caller">
    <i class="close-icon close_icon"></i>
  </div>

</div>

</div>
<?php endif; ?>
