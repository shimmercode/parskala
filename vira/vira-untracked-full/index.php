<?php get_header();

if ( empty( is_active_sidebar('sideby-post-widget') ) ) {
  $class_shop = 'fullw';
}else {
  $class_shop = '';
}
?>

    <div class="clomens">

      <?php if (is_active_sidebar('sideby-post-widget')): ?>

        <aside id="side-bar"  class="side-posts">

          <?php dynamic_sidebar('sideby-post-widget');?>

        </aside>

      <?php endif; ?>

      <main class="left-posts <?= $class_shop; ?>">

        <div class="head-indexs">

          <div class="adress-index">
            <?php echo get_hansel_and_gretel_breadcrumbs(); ?>
          </div>

        </div>

        <div id="main-post" class="sec-posts-index">

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <article class="item-index archive">

          <div class="item-thumb-index">

            <a href="<?php the_permalink();?>">
              <?php the_post_thumbnail('blog-size');?>
            </a>

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

            <a href="<?php the_permalink();?>"><h2><?php the_title();?></h2></a>
            <span class="line-item-index"></span>
            <p><?php echo wp_trim_words(get_the_content(),20,'...') ;?></p>

            <div class="info-author">
              <span class="name-author"><?php the_author();?></span>
              <span class="icon-author"><i class="fal fa-clock"></i></span>
              <span class="date-author"><?php the_time('Y/m/d');?></span>
            </div>

          </div>

        </article>

        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>
         <?php echo prk_numeric_posts_nav();?>
        <?php else:?>

          <div class="woocommerce-notices-wrapper">

            <div class="woocommerce-info"><?php _e('No content found!' , 'parskala');?></div>

          </div>



        <?php endif; ?>

        </div>

      </main>


      </div>


<?php get_footer();?>
