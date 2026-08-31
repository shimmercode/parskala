<?php

  get_header();
  $settings = get_option( 'prk_option' );
  $description = wc_format_content( term_description() );
  if ( empty( is_active_sidebar('sideby-post-widget') ) ) {
    $class_shop = 'fullw';
  }else {
    $class_shop = '';
  }

 ?>

  <div class="clomens category-page">

    <div class="adress-index">
        <?php echo get_hansel_and_gretel_breadcrumbs(); ?>
    </div>

    <?php if (is_active_sidebar('sideby-post-widget')): ?>

      <aside id="side-bar"  class="side-posts">

        <?php dynamic_sidebar('sideby-post-widget');?>

      </aside>

    <?php endif; ?>

    <main class="left-posts <?= $class_shop; ?>">
      
    <?php if ( ( $settings['post_archive_name'] || $settings['post_archive_bio'] ) && (prk_option('archive_post_subcategories_order') == 'top_page' || prk_option('archive_post_subcategories_order') == '') ):?>

      <div class="footer-description-shop">


        <?php

          if ( $settings['post_archive_name'] ) {
              echo '<h1 class="title-category">';

              echo single_cat_title();

              echo '</h1>';

          }

          if ( $description && $settings['post_archive_bio'] ) {

            echo '<div class="term-description">';

            echo $description;

            echo '</div>';
            echo '<a href="#" class="mask-handler"><span class="show-more">نمایش بیشتر</span><span class="show-less">- بستن</span></a>';

           
          }

        ?>

      </div>

    <?php endif;?>



      <div class="prk-main-post-item style1 style-grid" style="grid-template-columns: repeat(<?= $settings['grid_column_items_post'] ? $settings['grid_column_items_post'] : '4'  ?>, 1fr);">

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <?php

            $reading_time = get_post_meta( get_the_ID(), 'reading_time', true ) ? get_post_meta( get_the_ID(), 'reading_time', true ) : '3 دقیقه زمان مطالعه' ;
						$categories = get_the_category();
							if ( ! empty( $categories ) ) {
								$cate_label = '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
							}
						$avatar = get_avatar( get_the_author_meta( 'ID' ), 32 );
					?>

          <div class="prk-post-item">
				
						
							<div class="post-item-image">
                 <?php prk_img_full_size();?>	

                 <?php if ( $settings['show_cat_post'] == '1'  ):?>
								   <span class="post-item-category"><?= $cate_label ?></span>
								  <?php endif;?>

							</div>

              <?php if ( $settings['post_archive_time_reading'] == '1'):?>
                <span class="reading-time"><i class="ri-timer-line"></i> <?= $reading_time ?></span>
							<?php endif;?>

							<h2 class="post-item-title">
									<a href="<?php the_permalink();?>">
										<?php the_title();?>
									</a>
							</h2>
							
							<?php if ( $settings['post_archive_pcontent'] == '1' ):?>
								<p class="post-item-content"><?php echo wp_trim_words(get_the_content(),13,'...') ;?></p>
							<?php endif;?>
							
							
							<?php if ( $settings['post_archive_show_view'] == '1' || $settings['post_archive_author'] == '1'  ):?>

                <div class="flexed post-item-footer">

                  <?php if ( $settings['post_archive_author'] == '1' ):?>

                    <div class="flexed">

                      <?= $avatar; ?>

                      <div class="flexed-clomen"> <span><?php the_author();?></span>
                      <?php if ( $settings['post_archive_date'] == '1' ):?>
                        <i><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) ." ". __('قبل','parskala'); ?></i>
                        <?php endif;?>
                     </div>

                    </div>

                  <?php endif;?>


                  <?php if ( $settings['post_archive_show_view'] == '1'  ):?>
                    <a class="view-more" href="<?php the_permalink();?>"> <i class="prk-arrow-left"></i> </a>
                  <?php endif;?>

                </div>

            <?php endif;?>
										
					</div>

        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>

        <?php endif; ?>

      </div>


      <?php if ( ($settings['post_archive_name'] || $settings['post_archive_bio'] ) && ( prk_option('archive_post_subcategories_order') == 'down_page' ) ):?>

        <div class="footer-description-shop down-el">


          <?php

            if ( $settings['post_archive_name'] ) {
                echo '<h1 class="title-category">';

                echo single_cat_title();

                echo '</h1>';

            }

            if ( $description && $settings['post_archive_bio'] ) {

              echo '<div class="term-description">';

              echo $description;

              echo '</div>';
              echo '<a href="#" class="mask-handler"><span class="show-more">نمایش بیشتر</span><span class="show-less">- بستن</span></a>';

            
            }

          ?>

        </div>

    <?php endif;?>

    <?php echo prk_numeric_posts_nav();?>


    </main>

  </div>

<?php get_footer();?>
