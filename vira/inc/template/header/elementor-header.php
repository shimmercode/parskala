<?php
 $choice_header = prk_option('choice_header');



 $arms = array(
  'post_type' => 'header',
  'posts_per_page' => '1',
  'post_status' => 'publish',
  'post__in' => array($choice_header),
);
$pd_query = new WP_Query( $arms ); ?>
<?php if ( $pd_query ->have_posts() ) : ?>
<?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post(); ?>
  <?php the_content();?>
<?php endwhile; ?>
<?php wp_reset_postdata(); ?>
<?php endif;?>


