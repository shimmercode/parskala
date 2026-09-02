<?php

global $post;
  $archive_author = prk_option('post_single_author');
  $archive_date = prk_option('post_single_date');
  $ingle_tags = prk_option('post_single_tags');
  $single_categors = prk_option('post_single_categors');
  $single_comment = prk_option('post_archive_comment');

// تنظیمات صفحه پست

$thumbnail_order = get_post_meta( get_the_ID(), 'show_thumbnail_order', true ) ? get_post_meta( get_the_ID(), 'show_thumbnail_order', true ) : 'bottom' ;
$reading_time = get_post_meta( get_the_ID(), 'reading_time', true ) ? get_post_meta( get_the_ID(), 'reading_time', true ) : '3 دقیقه زمان مطالعه' ;
$show_sidebar = get_post_meta( get_the_ID(), 'show_sidebar_1', true );


// var_dump($show_sidebar);
// die;
  if ( prk_option('post_single_sidebar') == '0' || !is_active_sidebar('sideby-post-widget') ||  $show_sidebar == '0' ) {
    $class_shop = 'fullw';
  }else {
    $class_shop = '';
  }

  get_header();?>

  <div class="single-page style1">

    <?php if (prk_option('post_single_tumbnail') && $thumbnail_order == 'top' ): ?>

      <div class="humbnail-single <?= $thumbnail_order == 'top' ? 'margin-b10' : ''?>">
        <?php the_post_thumbnail(); ?>
      </div>

    <?php endif; ?>

    <div class="adress-index ad-cont">

      <?php echo get_hansel_and_gretel_breadcrumbs(); ?>

    </div>

    <?php if (  !mobile_cheker() && !tablet_cheker()  && ( prk_option('post_single_read') == '1' || prk_option('post_single_read') == '' ) && ( prk_option('post_single_sidebar') == '1' || prk_option('post_single_sidebar') == '' ) && is_active_sidebar('sideby-post-widget') && ( $show_sidebar == '1' || $show_sidebar == '') ):?>
      <div class="study-mode">
          <div class="study-mode-btn" tooltip="حالت مطالعه">
              <i class="ri-drag-move-2-fill"></i>
              <div class="study-mode-text">
                حالت مطالعه
              </div>
          </div>
      </div>
    <?php endif; ?>

     <div class="clomens">

    <main class="left-cont <?= $class_shop; ?>">



    <div class="main-cont single-post">

      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

      <div class="flexed-clomen header-content-post">

        <h1 class="title-cont">
                <?php the_title();?>
        </h1>
        <div class="flexed">

         <div class="flexed info-items">

         <?php if ($archive_author):?>
            <div class="flexed info-post author"><i class="ri-user-3-line"></i><?php the_author();?></div>
          <?php endif;?>

          <?php if ($archive_date):?>
            <div class="flexed info-post date"><i class="i-calendar-todo-line"></i>

            <?php 

            $modi_date = get_the_modified_time( 'j F Y' );
            printf( esc_html__( 'آخرین بروز رسانی: %s', 'parskala' ), $modi_date );
            
            ?>
            
          </div>
          <?php endif;?>

          <?php if ( prk_option('post_single_comment') == '1' || prk_option('post_single_comment') == '' ):?>
            <div class="flexed info-post date"><i class="ri-chat-1-line"></i><?php comments_number();?></div>
          <?php endif;?>

         </div>

         <?php if ( prk_option('post_single_time_reading') == '1' || prk_option('post_single_time_reading') == ''   ):?>
            <span class="reading-time"><i class="ri-timer-line"></i> <?= $reading_time ?></span>
         <?php endif;?>

        </div>


      </div>


      

          <?php if (prk_option('post_single_tumbnail') && $thumbnail_order == 'bottom' ): ?>

           <div class="humbnail-single">
              <?php the_post_thumbnail(); ?>
           </div>

          <?php endif; ?>

    

        <div class="conts ">

          <p>

             <?php the_content();?>

          </p>

        </div>

      <div class="tag-coment-box">

        <span class="coment-cont">

        <?php if (prk_option('post_single_comment')):?>

           <div class="flexed_start comenter">
            <i class="fal fa-comment-alt-lines"></i>
             <span><?php comments_number();?></span>
           </div>

        <?php endif;?>

           <?php if (prk_option('post_single_share')):?>

            <div class="flexed_start" data-remodal-target="smodalshare">
              <i class="ri-share-line"></i>
              <span >اشتراک گذاری</span>
            </div>

           <?php endif;?>

        </span>


        <!--مدال اشتراک گذاری-->

        <?php if (prk_option('post_single_share')):?>

          <div id="smodalshare" class="remodal remodal-xs remodal-lg modalshare remodal-maxed" data-remodal-id="smodalshare" data-remodal-options="hashTracking: false">

            <div class="remodal-header">
              <div class="remodal-title">اشتراک‌گذاری</div>
              <button data-remodal-action="close" class="remodal-close"></button>
            </div>
              <span class="text-share_modal">با استفاده از روش‌های زیر می‌توانید این صفحه را با دوستان خود به اشتراک بگذارید. </span>

              <div class="c-flex align-items-center border-top border-bottom py-3">

                        <div class="socials_btns btn-primary copy-url-btn" data-copy="<?php echo get_the_permalink();?>">کپی لینک</div>
                        <ul class="align-items-center">
                          <li class="telegram_socal"><a target="_blank" href="https://telegram.me/share/url?url=<?php the_permalink();?>" class="d-inline-flex"><i class="ri-telegram-fill"></i>تلگرام</a></li>
                          <li class="whatsapp_socal"><a target="_blank" href="https://api.whatsapp.com/send/?phone&text=<?php the_permalink();?>" class="d-inline-flex"><i class="ri-whatsapp-fill"></i>واتساپ</a></li>
                          <li class="facebook_socal"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?m2w&s=100&p[url]=<?php the_permalink();?>" class="d-inline-flex"><i class="ri-facebook-circle-fill"></i>فیسبوک</a></li>
                          <li class="twitter_socal"><a target="_blank" href="https://twitter.com/intent/tweet?url=<?php the_permalink();?>" class="d-inline-flex"><i class="ri-twitter-fill"></i>تویتر</a></li>
                        </ul>



              </div>

          </div>
      <?php endif;?>



        <?php if ($single_categors):?>

          <span class="tags-cont">
             <?php the_category('',' '); ?>
          </span>

        <?php endif;?>

        <?php if ($ingle_tags):?>

          <span class="tags-cont">
             <?php the_tags('',' '); ?>
          </span>

        <?php endif;?>

      </div>

      <?php endwhile; else : ?>

        <p><?php _e('No content found!' , 'parskala');?></p>

      <?php endif; ?>

    </div>

    <?php comments_template(); ?>

    </main>

    <?php if ( ( prk_option('post_single_sidebar') == '1' || prk_option('post_single_sidebar') == '' ) && is_active_sidebar('sideby-post-widget') && ( $show_sidebar == '1' || $show_sidebar == '') ): ?>

    <aside id="side-bar"  class="side-posts">

      <?php dynamic_sidebar('sideby-post-widget');?>

    </aside>

    <?php endif; ?>

    </div>

    
  </div>

<?php get_footer();?>
