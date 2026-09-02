<?php

  $archive_name = prk_option('post_archive_name');
  $archive_bio = prk_option('post_archive_bio');
  $archive_pcontent = prk_option('post_archive_pcontent');
  $archive_author = prk_option('post_archive_author');
  $archive_date = prk_option('post_archive_date');

  if ( empty( is_active_sidebar('sideby-post-widget') ) ) {
    $class_shop = 'fullw';
  }else {
    $class_shop = '';
  }

  get_header();?>

  <div class="clomens">

    <?php if (is_active_sidebar('sideby-post-widget')): ?>

      <aside id="side-bar"  class="side-posts">

        <?php dynamic_sidebar('sideby-post-widget');?>

      </aside>

    <?php endif; ?>

    <main class="left-posts <?= $class_shop; ?>">



    <div id="main-post" class="sec-posts-index">

      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <article class="item-index archive">

          <div class="item-thumb-index">

            <?php the_post_thumbnail( 'blog-size', array( 'sizes' => '(max-width:320px) 320px, (max-width:320px) 320px, 320px' ) );?>
            <div class="hover-item-index"></div>

            <div class="h-i-index">
              <span class="icon-info-index"><i class="fal fa-clipboard-list-check"></i></span>
              <span class="icon-comment-index">
                <cite><?php comments_number(); ?></cite>
                <i class="fal fa-comment-alt-lines"></i>
              </span>
            </div>

          </div>

          <div class="title-item-index">

            <a href="<?php the_permalink();?>"><h2><?php echo wp_trim_words(get_the_title(),12,'...') ;?></h2></a>

            <span class="line-item-index"></span>

            <?php if ($archive_pcontent):?>

              <p><?php echo wp_trim_words(get_the_content(),20,'...') ;?></p>

            <?php endif;?>

            <div class="info-author">

              <?php if ($archive_author):?>

                <span class="name-author"><?php the_author();?></span>

              <?php endif;?>

              <?php if($archive_date):?>

                <span class="icon-author"><i class="fal fa-clock"></i></span>
                <span class="date-author"><?php the_time('Y/m/d');?></span>

              <?php endif;?>

            </div>

          </div>

        </article>

      <?php endwhile; ?>
      
      <?php wp_reset_postdata(); ?>
      <?php echo prk_numeric_posts_nav();?>

      <?php endif; ?>

    </div>

    </main>

  </div>


<?php get_footer();?>
