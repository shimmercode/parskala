<?php
 /*
  Template Name: نمایش فقط هدر
  Template Post Type:  page
*/
?>
<div class="del-footer">
<?php get_header(); ?>

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <?php the_content();?>

  <?php endwhile;?>

  <?php endif; ?>
  <div class="navigation-overlay"></div>
  


<?php get_footer(); ?>

</div>
