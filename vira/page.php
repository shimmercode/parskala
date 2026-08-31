<?php get_header();?>

  <main class="left-cont page">

    <div class="main-cont">

      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <h1 class="title-cont">
           <?php the_title();?>
        </h1>

        <div class="conts">

          <p>
            <?php the_content();?>
          </p>

        </div>

      <?php endwhile;?>
      <?php endif; ?>

    </div>

  </main>

<?php get_footer();?>
