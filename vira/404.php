<?php get_header();?>

<div class="error-404">

  <h2><?php _e('The tab you were looking for could not be found!' , 'parskala');?></h2>

  <span><a href="<?php bloginfo('url');?>"><?php _e('homepage' , 'parskala');?></a></span>

  <img src="<?php bloginfo('template_url');?>/assets/img/404.png" alt="error-404">
  

</div>

<?php get_footer();?>
