<?php
defined( 'ABSPATH' ) || exit;
if(defined( 'ACTIVE_TEMPLATE_WOOCOMMERCE' )){
?>
  <div class="sp_top_panel">
    <h1><?php echo __( 'comments', 'parskala' ) ?></h1>
  </div>
<?php
}
// GET CURRENT USER
global $post;
do_action('woocommerce_before_comments');
$current_user = wp_get_current_user();
// echo 'Username: ' . $current_user->user_login . '<br />';
// echo 'User email: ' . $current_user->user_email . '<br />';
// echo 'User first name: ' . $current_user->user_firstname . '<br />';
// echo 'User last name: ' . $current_user->user_lastname . '<br />';
// echo 'User display name: ' . $current_user->display_name . '<br />';
// echo 'User ID: ' . $current_user->ID;

$args = array(
  'user_id' => $current_user->ID,
// use user_id
);
$comments = get_comments( $args );

?>
<div class="box_comments">
  <ul class="list_of_comments">

  <?php
  if($comments){
    foreach ( $comments as $comment ) :
      //print_r($comment);

      $status = wp_get_comment_status( $comment->comment_ID );

    ?>
    <li class="comment <?php echo $status;?>">
      <div class="comments_contienr">
      <div class="comment_thumb">  <?php echo get_the_post_thumbnail($comment->comment_post_ID );?></div>
        <div class="comment_box">
          <div class="name_content_product">
            <a href="<?php echo get_permalink( $comment->comment_post_ID ) ?>" target="_blank" class="product_link"><?php echo get_the_title( $comment->comment_post_ID ) ?></a>
            <a style=" <?php if($status == 'unapproved'){ echo 'color: #ff637d !important;border-color:#ff637d !important';};?>"href="<?php echo get_permalink( $comment->comment_post_ID ) ?>#comment-<?php echo $comment->comment_ID; ?>" target="_blank" class="product_comment_link">
             <?php if($status == 'approved'){ echo 'تایید شده'; }elseif($status == 'unapproved'){ echo 'تایید نشده'; }?>
              </a>
          </div>
          <div class="date_and_comment_link_box">
            <p class="content_comment"><?php echo $comment->comment_content; ?></p>
          </div>
      </div>
      </div>
    </li>
    <?php
      endforeach;
    }else{
      echo "<p class='no_announcement'>";

        _e( 'There are no comments!', 'parskala' );
      
      echo "</p>";
     
    }
    ?>
  </ul>
</div>
<?php
defined( 'ABSPATH' ) || exit;
