<?php
$tabsـtrue = prk_option('tabs_true');

$footer_logo = prk_option('footer_logo') ? prk_option('footer_logo') : '';
if ( class_exists( 'WooCommerce' ) ) {
  if ( $tabsـtrue || is_product() ) {
    $copyright_calsses = 'navier';
  }else {
    $copyright_calsses = '';
  }
}

if ( is_front_page() ) {
  $tag_name = 'h1';
}else {
  $tag_name = 'span';
}



?>

<?php if ( prk_option('footer_style_type') == 'default' ):?>

<div class="main-footer">

  <div class="continer">


    <div class="info-boxer">
     <?php if ( $footer_logo ): ?>
       <div class="logo-box">

        <a href="<?php bloginfo('url');?>"><?php echo prk_logo_footer();?></a>
       </div>
     <?php endif; ?>


      <?php if ( prk_footer_tops() ):?>

        <div class="jump-box">

          <a href="#tops">

            <span><?php _e('Back to top' , 'parskala');?></span>
            <i class="prk-arrow-down-1"></i>

          </a>

        </div>

      <?php endif;?>

      <div class="tell-box">

        <?php if (prk_footer_tell()):?>

          <span class="boxer-tells">
            <span class="text-number"><?php echo prk_option('tell_foot_title') ? prk_option('tell_foot_title') : 'شماره تماس:';?></span>
            <span class="one-number"><?php echo prk_footer_tell();?></span>
          </span>

          <?php if ( prk_footer_email()):?>

            <span class="line-tell">|</span>

          <?php endif;?>

        <?php endif;?>

        <?php if (prk_footer_email()):?>

          <span class="boxer-tells">
            <span class="text-number"><?php _e('email address:' , 'parskala');?></span>
            <span class="tow-number"><?php echo prk_footer_email();?></span>
          </span>

          <?php if (prk_footer_calls()):?>
            <span class="line-tell">|</span>
          <?php endif;?>

        <?php endif;?>

        <?php if (prk_footer_calls()):?>

          <span class="support"><?php echo prk_footer_calls();?></span>

        <?php endif;?>

      </div>

      <div class="clear"> </div>



    </div>

    <?php dynamic_sidebar('footer-widget');?>

    <?php if (prk_about_true() || prk_enmad_true()):?>

    <div class="foot-core">

      <?php if (prk_about_title()):?>

        <div class="foot-box text">

        <<?= $tag_name?> class="foot-title"><?php echo prk_about_title();?></<?= $tag_name?>>

        <p><?php echo esc_html( prk_about_des() ) ;?></p>
         <a href="#" class="foot mask-handler"><span class="show-more">نمایش بیشتر</span><span class="show-less">- بستن</span></a>
        </div>


      <?php endif; ?>

      <?php if ( prk_enmad_true() == '1' && prk_enmad_group_box() ): ?>
        <div class="foot-box enmads">
          <?php foreach (prk_enmad_group_box() as $item): ?>
            <article class="codes">
              <?php echo $item['enmad_code'];?>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <?php endif;?>

    <div class="clear"></div>
    <span class="line-foot"></span>

    <div class="copy-right-foot <?php echo $copyright_calsses;?>">
      <span ><?php echo prk_footer_copyright();?></span>
      <span class="latin_copyright"><?php echo prk_footer_copyright_latin();?></span>
    </div>

  </div>

</div>

<?php else:?>

 
 <?php  get_template_part('/inc/template/footer/mobit-footer'); ?>


<?php endif;?>