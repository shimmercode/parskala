<?php
$prk_preloader = prk_option('prk_preloader');
$preloader_type = prk_option('preloader_type');
if ($prk_preloader):?>
<div id="loader">
 <?php if ('Circle-dotted' == $preloader_type):?>
   <?php get_template_part( '/inc/template/preloaders/circle-dotted' ); ?>
 <?php elseif('dotted' == $preloader_type):?>
    <?php get_template_part( '/inc/template/preloaders/dotted-pre' ); ?>
  <?php elseif('tow-rotating' == $preloader_type):?>
    <?php get_template_part( '/inc/template/preloaders/tow-rotating' ); ?>
  <?php elseif('rotating' == $preloader_type):?>
    <?php get_template_part( '/inc/template/preloaders/rotating' ); ?>
 <?php endif;?>
</div>
<?php endif;?>
