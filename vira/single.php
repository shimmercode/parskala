<?php
/**
 * Vira Theme Single Post Template
 *
 * @package Vira
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); ?>

<main id="main" class="vira-main-content" role="main">
    <div class="vira-container">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'vira-single-post-article' ); ?>>
                <header class="single-post-header">
                    <h1 class="single-post-title"><?php the_title(); ?></h1>
                    <div class="single-post-meta">
                        <span class="meta-date"><i class="xts-i-calendar"></i> <?php echo esc_html( vira_to_persian_num( get_the_date() ) ); ?></span>
                        <span class="meta-author"><i class="xts-i-user"></i> <?php echo esc_html( get_the_author() ); ?></span>
                        <span class="meta-cat"><i class="xts-i-folder"></i> <?php the_category( '، ' ); ?></span>
                    </div>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="single-post-thumbnail">
                        <?php the_post_thumbnail( 'large', array( 'class' => 'featured-img' ) ); ?>
                    </div>
                <?php endif; ?>

                <div class="single-post-content">
                    <?php
                    the_content();
                    wp_link_pages();
                    ?>
                </div>

                <footer class="single-post-footer">
                    <div class="post-tags">
                        <?php the_tags( '<span class="tags-label">برچسب‌ها: </span>', ' ' ); ?>
                    </div>
                </footer>
            </article>
            <?php
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();
