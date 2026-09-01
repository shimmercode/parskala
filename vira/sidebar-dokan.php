  <?php $user_id = get_current_user_id();
   global $wp;
  ?>
  <div class="sp_tool_bar <?php if ( isset( $wp->query_vars['settings'] )) echo 'prk-sidebar-settings';?>">
   <div class="sp_card_profile">
      <div class="sp_profile">
          <div class="sp_avatar">
            <?php echo get_avatar( $user_id, 60 ); ?>
          </div>
          <div class="sp_profile_title">
            <p><?php echo get_user_meta( $user_id, 'dokan_store_name', true); ?> <br></p>

          </div>

           <div class="sp_stars">
             <?php
             prk_get_rating_seller($user_id) ;
             ?>
              <p><?php _e('عضویت از', 'vira') ?> <?php
			  $udata = get_userdata( $user_id );
			  echo human_time_diff( strtotime( $udata->user_registered ) , current_time( 'timestamp' ) ); _e(' قبل ', 'vira'); ?></p>
           </div>


          <div class="sp_profile_menu">
             <a href="<?php echo dokan_get_navigation_url( 'reviews' ); ?>"><?php _e('پرسش ها', 'vira') ?>
                <i class="ri-question-answer-line" aria-hidden="true"></i>
             </a>
             <a href="<?php echo dokan_get_navigation_url( 'announcement' ); ?>"><?php _e('پیام ها', 'vira') ?>
               <i class="icon-mail-dg" aria-hidden="true"></i>
                <span class="sp_circle_number"><?php  ?></span>
             </a>
             <a href="<?php echo dokan_get_navigation_url( 'settings/store' ); ?>"><?php _e('پروفایل', 'vira') ?>
               <i class="icon-user-dg" aria-hidden="true"></i>
             </a>
          </div>
      </div>
   </div>



<?php
$cat_id = prk_option('cats-post-panel-dokan') ? prk_option('cats-post-panel-dokan') : 0;
$count =  prk_option('count-post-dokan-panel') ? prk_option('count-post-dokan-panel') : 4;
if ( $cat_id ) $category_link = get_category_link( $cat_id );
$args = array( 'posts_per_page' => $count,  'post_type' => 'post', 'category__in' => array($cat_id) );
$wp_query = new WP_Query();
$wp_query->query( $args );

if($wp_query->have_posts()):
?>


     <div class="sp_card_profile2" >
       <div class="sp_title_dashboard">
          <h1><?php _e('آخرین مطالب', 'vira') ?></h1>
          <a target="_blank" href="<?php echo esc_url( $category_link ); ?>">
             <svg enable-background="new 0 0 31.49 31.49" version="1.1" viewBox="0 0 31.49 31.49" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
               <path d="m21.205 5.007c-0.429-0.444-1.143-0.444-1.587 0-0.429 0.429-0.429 1.143 0 1.571l8.047 8.047h-26.554c-0.619 1e-3 -1.111 0.493-1.111 1.112s0.492 1.127 1.111 1.127h26.554l-8.047 8.032c-0.429 0.444-0.429 1.159 0 1.587 0.444 0.444 1.159 0.444 1.587 0l9.952-9.952c0.444-0.429 0.444-1.143 0-1.571l-9.952-9.953z">
             </svg>
          </a>
       </div>
       <div class="sp_body_dashboard">
       <ul>

<?php
while ($wp_query->have_posts()):
$wp_query->the_post();
?>

         <a href="<?php the_permalink(); ?>">
         <li>
           <?php the_post_thumbnail( 'shop_thumbnail', '' ); ?>
           <p><?php the_title(); ?></p>
         </li>
         </a>

<?php endwhile;  ?>

       </ul>
        <h1>
          <a target="_blank" href="<?php echo esc_url( $category_link ); ?>">
          <span><?php _e('مشاهده مطالب بیشتر', 'vira') ?></span>
        </a>
         </h1>
       </div>
     </div>

<?php endif;
wp_reset_query();
?>



 </div>
