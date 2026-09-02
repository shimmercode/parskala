<?php

$place_holder_text = __('What do you think about this?','parskala');

if ( prk_option('header_account_type') == 'dropdown' ) {
  $data_link = 'data-custom-open="loginmodal"';
}else {
    $data_link = 'href="'.get_permalink( get_option('woocommerce_myaccount_page_id') ).'"';
}
  if ( post_password_required() )
      return;
  ?>

  <div class="post-comment">

  <?php if ( have_comments() ) : ?>

    <h2 class="comments-title">
      <?php $number_c =  get_comments_number();?>
        <span><i class="fal fa-comment-alt-lines"></i></span>
          <?php echo $number_c;?>
          <span><?php _e('Wrote a comment for this' , 'parskala');?></span>
    </h2>

  <?php else:
  
     $place_holder_text = __('Be the first to leave your opinion','parskala');
    ?>

    <h2 class="comments-title">
          <span><?php _e('Submit your first comment' , 'parskala');?></span>
    </h2>

  <?php endif;?>

    <?php if ( ( prk_option('comment_Rules') == '1' || prk_option('comment_Rules') == '' )  ):?>

      <div class="comment-rules">
        <?= prk_option('comment_Rules_contents') ?>
      </div>

    <?php endif;?>
  <div id="comments" class="comments-area">




  


   <?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
     <div id="respond" class="comment-respond">
     		<p class="must-log-in"><?= _e('You must write a comment','parskala') ?><a class="login_commenter" <?php echo $data_link;?> ><?= _e('log in','parskala') ?></a>.</p>	</div>
    <?php else: ?>




      <ol class="comment-list">
        <?php
        wp_list_comments( array(
            'max_depth' => '5',
            'style'     => 'ol',
            'walker'  => new TwentyTwenty_Walker_Comment(),
        ));
        ?>

      </ol>

    
    <div class="comment-forms">


      <?php
        $args = array(
          'fields' => array(
          'author' => '<div class="form-comment flexed"><span class="input-name"><span class="text-com">نام شما<i>*</i></span><input name="author" type="text" placeholder="نام شما" class="form_name"/></span>',
          'email' => '<span class="input-name in-2"><span class="text-com">ایمیل شما<i>*</i></span><input name="email" type="text" placeholder="ایمیل کاربری" class="form_name"/></span></div>',
          ),
          'comment_notes_before' => '',
          'comment_notes_after' => '',
          'comment_field' => '<p><textarea name="comment" class="text-input" placeholder=" '.$place_holder_text.' "></textarea></p>',
          'label_submit' => 'فرستان دیدگاه',
          'cancel_reply_before' =>'<span>',
          'cancel_reply_after' => '</span>',
          'cancel_reply_link' => __( 'لغو پاسخ' ),
        );

      echo comment_form($args);
      ?>



    </div>
    
    <?php endif; // If registration required and not logged in ?>

  </div><!-- #comments -->
  </div>
