<?php

/* template name: تمپلت داشبورد دکان */
if( class_exists('Dokan_Pro') ){

	get_header('dokan');

	?>
	
	<main id="main" class="prk-main-content-dokan-dashboard">
	<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
	
					<?php the_content(); ?>
	
		<?php endwhile;  ?>
	<?php endif;  ?>
	</main>
	
	<?php get_footer('dokan'); 
}else{
?>

<?php get_header();?>



			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		


				
				<?php the_content();?>
				

		

			<?php endwhile;?>
			<?php endif; ?>



		<?php get_footer();?>

<?php

}

