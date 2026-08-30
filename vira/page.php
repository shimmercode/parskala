<?php
/**
 * Vira Theme Page Template
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
            <article id="page-<?php the_ID(); ?>" <?php post_class( 'vira-page-article' ); ?>>
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>
                <div class="page-content">
                    <?php
                    the_content();
                    wp_link_pages();
                    ?>
                </div>
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
