<?php

$url_pages ='';
global $product;
$Conditionsـpage = prk_option('Conditions_page');
if ($Conditionsـpage ){
 $arms = array(
    'post_type' => 'page',
    'posts_per_page' => '1',
    'post_status' => 'publish',
    'post__in' => array($Conditionsـpage),
);
$pd_query = new WP_Query( $arms ); ?>
<?php if ( $pd_query ->have_posts() ) : ?>
  <?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post(); ?>
      <?php
       $url_pages = get_the_permalink();?>
  <?php endwhile; ?>
  <?php wp_reset_postdata(); ?>
  <?php endif;?>

<?php }

$logo = '';
$logo_uploaded = prk_option('logo');
if(isset($logo_uploaded['url']) && $logo_uploaded['url'] != '') { $logo = $logo_uploaded['url']; }
 ?>
<div class="prk-sms-loginform">
  <div class="modal micromodal-slide" id="loginmodal" aria-hidden="true">
    <div class="modal__overlay" data-micromodal-close>
      <div  class="modal__container" style="width: 31%;max-width: 500px;position: relative;">
        <div class="prk-header-login">

       <button data-micromodal-close="modalvidoe" class="close-box"></button>
       </div>

  <section class="prk-loginbox">
    <div class="header-loginbox">

      <!-- لوگو مدال -->
     <div class="logo-loginbox">
       <a href="<?php bloginfo('url');?>">
       <?php echo prk_logo_sms_form_def(); ?>
       </a>
     </div>

    </div>
  <?php do_shortcode('[prk_auth_sms]');?>
  <div class="footer-loginbox">
    <p class="copyright-login-footer">
  با ورود و یا ثبت نام در سایت شما <a class="linkp" href="<?php echo $url_pages;?>" target="_blank">شرایط و قوانین</a> استفاده از سرویس های سایت و <a href="#" target="_blank">قوانین حریم خصوصی</a> آن را می&zwnj;پذیرید.	</p>
  </div>
  </section>



      </div>
    </div>
  </div>
</div>
