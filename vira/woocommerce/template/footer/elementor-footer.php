<?php
 $choice_footer = prk_option('choice_footer');

 $arms = array(
    'post_type' => 'footer',
    'posts_per_page' => '1',
    'post_status' => 'publish',
    'post__in' => array($choice_footer),
);
$pd_query = new WP_Query( $arms ); ?>
<?php if ( $pd_query ->have_posts() ) : ?>
  <?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post(); ?>
    <?php the_content();?>
  <?php endwhile; ?>
  <?php wp_reset_postdata(); ?>
  <?php endif;?>
