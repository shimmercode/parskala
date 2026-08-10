<?php
// شرایط ارسال کالا

function special_sendproduct(){
   $special_sendproduct = '';
   $send_box_single = get_post_meta(get_the_ID(), 'special_send_box_single', true );

   if ( isset(prk_option('send_box_icon')['url']) && !empty( prk_option('send_box_icon')['url'] ) ){
     $image_icon = '<img src="'.prk_option('send_box_icon')['url'].'" alt="sendbox product">';
   }else{
     $image_icon ='<img src="'.get_template_directory_uri().'/assets/img/plus-icon.svg" alt="sendbox product">';
   }
   
   do_action('prk_add_before_send_product');
   if ( prk_special_send_box() == '1' && $send_box_single == 'no' && !empty(prk_send_box_group()) ) {
   ?>

   <div class="special_send_box">

    <div class="special_header">
      <a href="<?php echo prk_send_box_url();?>">
        <?= $image_icon ?>
        <span><?php echo prk_send_box_text();?> <i class="ri-arrow-left-s-line"></i> </span>
      </a>
    </div>

    <?php if (prk_send_box_group()): ?>
      <div class="special_content_box">
       <ul>
         <?php foreach (prk_send_box_group() as $item): ?>
         <a href="<?php echo $item['send_box_url'];?> "><li><?php echo $item['send_box_text'];?></li></a>
         <?php endforeach; ?>
       </ul>
      </div>
   <?php endif; ?>
   </div>

   <?php
    return $special_sendproduct;
   }
}
