<?php
 /*
  Template Name: برگه تمام عرض
  Template Post Type:  page
*/
?>

<?php get_header();?>



      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

     
           <?php dynamic_sidebar('section-main-widget');?>

            <?php the_content();?>
         

       

      <?php endwhile;?>
      <?php endif; ?>



<?php get_footer();?>
