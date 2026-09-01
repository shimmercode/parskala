<?php

  $supports_true = prk_option('supports_true');
  $supportsـarrow = prk_option('supports_arrow');
  $supportsـpage = prk_option('supports_page');
  $supportsـtext = prk_option('supports_text');
  $supportsـhead_text = prk_option('supports_head_text');

  $supportsـques1 = prk_option('supports_ques1');
  $supportsـques2 = prk_option('supports_ques2');
  $supportsـques3 = prk_option('supports_ques3');
  $supports_answer‍1 = prk_option('supports_answer‍1');
  $supports_answer‍2 = prk_option('supports_answer‍2');
  $supports_answer‍3 = prk_option('supports_answer‍3');


if ( 'right' == $supportsـarrow):?>
<style media="screen">
.support-tab,.ques-box{
  right: 15px;
}
.support-tab{
  border-radius: 20px 0px 20px 20px;
}
</style>
<?php endif;?>

<?php


 if (class_exists( 'WooCommerce' )) {

 if ($supports_true && ! is_account_page() ):?>

<div class="supp">
<a class="support-open"  onclick="support_open()">
<div class="support-tab">
<span id="support-tabs" class="support-btn"></span>
</div>
</a>

<div  id="ques-box" class="ques-box">
<div class="ques-welcoming">
<p><?php echo $supportsـhead_text;?></p>
 <a   onclick="ques_cansel()"><span class="ques-cansel"></span></a>
</div>
<div class="ques-tabs">
  <div class="accardion">
    <div class="accardion-block  grey">
        <div class="accardion-link">
            <a ><?php echo $supportsـques1;?></a>
          </div>
          <div class="accardion-lists">
            <p><?php echo prk_option('supports_answer1');?></p>
          </div>
    </div>

    <div class="accardion-block">
        <div class="accardion-link">
          <a ><?php echo $supportsـques2;?></a>
        </div>
        <div class="accardion-lists">
          <p><?php echo prk_option('supports_answer2');?></p>
        </div>
    </div>

    <div class="accardion-block">
        <div class="accardion-link grey">
            <a ><?php echo $supportsـques3;?></a>
        </div>
        <div class="accardion-lists">
          <p><?php echo prk_option('support_answer3');?></p>
        </div>
    </div>
  </div>
</div>
<div class="ques-news">

  <?php $arms = array(
      'post_type' => 'page',
      'posts_per_page' => '1',
      'post_status' => 'publish',
      'post__in' => array($supportsـpage),
  );
  $pd_query = new WP_Query( $arms ); ?>
  <?php if ( $pd_query ->have_posts() ) : ?>
    <?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post(); ?>
        <a href="<?php the_permalink();?>"><?php echo $supportsـtext;?></a>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php endif;?>
</div>
</div>
</div>

<?php
 endif;
 }
 ?>
