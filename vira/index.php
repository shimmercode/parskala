<?php
/**
 * Vira Theme Main Index Template (Rich Iranian E-Commerce Storefront Layout)
 *
 * Displays a stunning, production-ready online shopping homepage when on the front page,
 * or standard product/blog loops otherwise.
 *
 * @package Vira
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Direct access not allowed.
}

get_header(); ?>

<main id="main" class="vira-main-content" role="main">
    <?php if ( is_front_page() || is_home() ) : ?>
        <!-- ==========================================================================
             VIRA IRANIAN E-COMMERCE HOMEPAGE SHOWCASE
             ========================================================================== -->
        <div class="vira-home-showcase">
            <!-- 1. Product Stories / Highlights Row ([VIRA-02]) -->
            <section class="vira-section vira-stories-section" style="background: #ffffff; padding: 20px 0; border-bottom: 1px solid #f1f5f9;">
                <div class="vira-container">
                    <div class="vira-section-header" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                        <h2 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;"><i class="xts-i-play" style="color: #ef394e;"></i> استوری‌های ویژه ویرا</h2>
                        <span style="font-size: 12px; color: #64748b;">پیشنهادهای ۲۴ ساعته</span>
                    </div>
                    <div class="vira-stories-circles" style="display: flex; gap: 20px; overflow-x: auto; padding-bottom: 10px;">
                        <?php
                        $story_titles = array( 'تخفیف ویژه موبایل', 'لپ‌تاپ‌های گیمینگ', 'ساعت‌های هوشمند', 'پوشاک فصل جدید', 'لوازم خانگی برقی', 'هدفون و ایرپاد', 'کنسول بازی' );
                        foreach ( $story_titles as $idx => $st_title ) :
                            ?>
                            <div class="story-circle-item" style="text-align: center; flex: 0 0 76px; cursor: pointer;">
                                <div style="width: 68px; height: 68px; border-radius: 50%; padding: 3px; background: linear-gradient(45deg, #ef394e, #ff8c00); margin: 0 auto 8px; display: flex; align-items: center; justify-content: center;">
                                    <div style="width: 100%; height: 100%; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; overflow: hidden; font-weight: bold; color: #ef394e; font-size: 18px;">
                                        <?php echo esc_html( $idx + 1 ); ?>
                                    </div>
                                </div>
                                <span style="font-size: 11px; color: #334155; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo esc_html( $st_title ); ?></span>
                            </div>
                            <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            </section>

            <!-- 2. Hero Banner & Promo Grid -->
            <section class="vira-section vira-hero-section" style="padding: 24px 0;">
                <div class="vira-container">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; align-items: stretch;">
                        <div class="hero-banner-main" style="background: linear-gradient(135deg, #1e293b, #0f172a); border-radius: 16px; padding: 40px; color: #fff; display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden; min-height: 280px;">
                            <span style="background: #ef394e; color: #fff; font-size: 12px; font-weight: bold; padding: 4px 12px; border-radius: 20px; width: fit-content; margin-bottom: 14px;">جشنواره فصل جدید ویرا</span>
                            <h1 style="font-size: 28px; font-weight: 800; margin: 0 0 12px 0; line-height: 1.4;">جدیدترین گجت‌های هوشمند<br />با گارانتی رسمی ۱۸ ماهه</h1>
                            <p style="font-size: 14px; opacity: 0.8; margin: 0 0 24px 0; max-width: 400px;">تا ۴۰٪ تخفیف ویژه به همراه امکان خرید اقساطی ۴ مرحله‌ای بدون کارمزد با اسنپ‌پی</p>
                            <div>
                                <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '#' ); ?>" class="button" style="background: #ef394e; color: #fff; padding: 12px 28px; border-radius: 10px; font-weight: bold; display: inline-block;">مشاهده تخفیف‌ها</a>
                            </div>
                        </div>
                        <div class="hero-promo-side" style="display: flex; flex-direction: column; gap: 20px;">
                            <div style="flex: 1; background: #fff1f2; border: 1px solid #fecdd3; border-radius: 16px; padding: 24px; display: flex; flex-direction: column; justify-content: center;">
                                <span style="font-size: 12px; font-weight: bold; color: #ef394e;">ارسال سریع و رایگان</span>
                                <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 6px 0;">تحویل ۳ ساعته در تهران</h3>
                                <p style="font-size: 12px; color: #64748b; margin: 0;">خرید بالای ۱,۵۰۰,۰۰۰ تومان</p>
                            </div>
                            <div style="flex: 1; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 16px; padding: 24px; display: flex; flex-direction: column; justify-content: center;">
                                <span style="font-size: 12px; font-weight: bold; color: #00a651;">ضمانت بازگشت وجه</span>
                                <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 6px 0;">۷ روز مهلت تست کالا</h3>
                                <p style="font-size: 12px; color: #64748b; margin: 0;">تعویض بی‌قید و شرط در صورت خرابی</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 3. Daily Flash Sale / Amazing Deals Carousel ([VIRA-11]) -->
            <section class="vira-section vira-flashsale-section" style="background: #ef394e; padding: 28px 0; margin: 20px 0;">
                <div class="vira-container">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; color: #fff;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <h2 style="font-size: 20px; font-weight: 800; margin: 0; color: #fff;">پیشنهاد شگفت‌انگیز روز</h2>
                            <span style="background: rgba(255,255,255,0.2); font-size: 12px; padding: 4px 10px; border-radius: 12px;">تخفیف محدود</span>
                        </div>
                        <div class="vira-timer" style="display: flex; align-items: center; gap: 8px; font-weight: bold; font-size: 14px;">
                            <span>زمان باقی‌مانده:</span>
                            <span style="background: #fff; color: #ef394e; padding: 4px 8px; border-radius: 6px;">۰۸</span>:
                            <span style="background: #fff; color: #ef394e; padding: 4px 8px; border-radius: 6px;">۴۵</span>:
                            <span style="background: #fff; color: #ef394e; padding: 4px 8px; border-radius: 6px;">۱۲</span>
                        </div>
                    </div>

                    <div class="vira-products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 16px;">
                        <?php
                        if ( class_exists( 'WooCommerce' ) ) {
                            $args = array(
                                'post_type'      => 'product',
                                'posts_per_page' => 4,
                                'post_status'    => 'publish',
                            );
                            $loop = new \WP_Query( $args );
                            if ( $loop->have_posts() ) {
                                while ( $loop->have_posts() ) {
                                    $loop->the_post();
                                    wc_get_template_part( 'content', 'product-vira' );
                                }
                                wp_reset_postdata();
                            } else {
                                echo '<p style="color: #fff; font-size: 14px;">محصولی در بخش فروش ویژه یافت نشد.</p>';
                            }
                        } else {
                            echo '<p style="color: #fff;">لطفاً افزونه ووکامرس را فعال نمایید.</p>';
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- 4. Featured Category / Store Catalog Showcase -->
            <section class="vira-section vira-catalog-section" style="padding: 30px 0;">
                <div class="vira-container">
                    <div class="vira-section-header" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; border-bottom: 2px solid #ef394e; padding-bottom: 12px;">
                        <h2 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0;">جدیدترین و پرفروش‌ترین کالاها</h2>
                        <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '#' ); ?>" style="font-size: 13px; color: #ef394e; font-weight: bold;">مشاهده همه کالاها &larr;</a>
                    </div>

                    <div class="vira-products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 16px;">
                        <?php
                        if ( class_exists( 'WooCommerce' ) ) {
                            $args2 = array(
                                'post_type'      => 'product',
                                'posts_per_page' => 8,
                                'post_status'    => 'publish',
                                'orderby'        => 'date',
                                'order'          => 'DESC',
                            );
                            $loop2 = new \WP_Query( $args2 );
                            if ( $loop2->have_posts() ) {
                                while ( $loop2->have_posts() ) {
                                    $loop2->the_post();
                                    wc_get_template_part( 'content', 'product-vira' );
                                }
                                wp_reset_postdata();
                            }
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>
    <?php else : ?>
        <!-- ==========================================================================
             STANDARD BLOG OR CATEGORY LOOP
             ========================================================================== -->
        <div class="vira-container" style="padding: 30px 0;">
            <?php if ( have_posts() ) : ?>
                <div class="vira-posts-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'vira-post-card' ); ?> style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; padding: 20px;">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="post-thumbnail-wrapper" style="margin-bottom: 16px;">
                                    <a href="<?php echo esc_url( get_permalink() ); ?>">
                                        <?php the_post_thumbnail( 'medium_large', array( 'class' => 'post-thumb-img', 'style' => 'width:100%; height:200px; object-fit:cover; border-radius:12px;' ) ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="post-content">
                                <h2 class="post-title" style="font-size: 18px; margin: 0 0 10px 0;">
                                    <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="post-meta" style="font-size: 12px; color: #64748b; margin-bottom: 12px; display: flex; gap: 16px;">
                                    <span class="post-date"><i class="xts-i-calendar"></i> <?php echo esc_html( vira_to_persian_num( get_the_date() ) ); ?></span>
                                    <span class="post-author"><i class="xts-i-user"></i> <?php echo esc_html( get_the_author() ); ?></span>
                                </div>
                                <div class="post-excerpt" style="font-size: 13px; color: #475569; line-height: 1.7; margin-bottom: 16px;">
                                    <?php the_excerpt(); ?>
                                </div>
                                <a href="<?php echo esc_url( get_permalink() ); ?>" class="vira-read-more-btn" style="color: #ef394e; font-weight: bold; font-size: 13px;">
                                    ادامه مطلب &larr;
                                </a>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    ?>
                </div>

                <div class="vira-pagination" style="margin-top: 30px; text-align: center;">
                    <?php
                    the_posts_pagination( array(
                        'prev_text' => '« قبلی',
                        'next_text' => 'بعدی »',
                    ) );
                    ?>
                </div>
            <?php else : ?>
                <div class="vira-no-posts-found" style="text-align: center; padding: 60px 0;">
                    <h2>مطلبی یافت نشد</h2>
                    <p style="color: #64748b;">متأسفانه هیچ محتوایی مطابق با درخواست شما پیدا نشد. لطفاً از نوار جستجو استفاده کنید.</p>
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>

<?php
get_footer();
