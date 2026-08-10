<?php
/**
 * Vira Theme Main Index Template
 *
 * Required by WordPress for standalone theme recognition.
 *
 * @package Vira
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Direct access not allowed.
}

get_header(); ?>

<main id="main" class="vira-main-content" role="main">
    <div class="vira-container">
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
                            <div class="post-meta">
                                <span class="post-date"><i class="xts-i-calendar"></i> <?php echo esc_html( vira_to_persian_num( get_the_date() ) ); ?></span>
                                <span class="post-author"><i class="xts-i-user"></i> <?php echo esc_html( get_the_author() ); ?></span>
                            </div>
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php echo esc_url( get_permalink() ); ?>" class="vira-read-more-btn">
                                ادامه مطلب &larr;
                            </a>
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
                <h2>مطلبی یافت نشد</h2>
                <p>متأسفانه هیچ محتوایی مطابق با درخواست شما پیدا نشد. لطفاً از نوار جستجو استفاده کنید.</p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
