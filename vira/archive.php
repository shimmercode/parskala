<?php
/**
 * Vira Theme Archive Template
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
        <header class="vira-archive-header">
            <?php
            the_archive_title( '<h1 class="archive-title">', '</h1>' );
            the_archive_description( '<div class="archive-description">', '</div>' );
            ?>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="vira-posts-grid">
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'vira-post-card' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-thumbnail-wrapper">
                                <a href="<?php echo esc_url( get_permalink() ); ?>">
                                    <?php the_post_thumbnail( 'medium_large', array( 'class' => 'post-thumb-img' ) ); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="post-content">
                            <h2 class="post-title">
                                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php echo esc_url( get_permalink() ); ?>" class="vira-read-more-btn">ادامه مطلب &larr;</a>
                        </div>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>

            <div class="vira-pagination">
                <?php
                the_posts_pagination( array(
                    'prev_text' => '« قبلی',
                    'next_text' => 'بعدی »',
                ) );
                ?>
            </div>
        <?php else : ?>
            <div class="vira-no-posts-found">
                <h2>هیچ محتوایی در این بخش یافت نشد</h2>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
