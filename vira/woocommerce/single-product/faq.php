<?php
$url_pages ='';
global $product;
$Conditionsـpage = prk_option('Conditions_page');
if ($Conditionsـpage ){
 $arms = array(
    'post_type' => 'page',
    'posts_per_page' => '1',
    'post_status' => 'publish',
    'post__in' => array($Conditionsـpage),
);
$pd_query = new WP_Query( $arms ); ?>
<?php if ( $pd_query ->have_posts() ) : ?>
  <?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post(); ?>
      <?php
       $url_pages = get_the_permalink();?>
  <?php endwhile; ?>
  <?php wp_reset_postdata(); ?>
  <?php endif;?>

<?php }
?>

<div class="flexed">
<div class="parskala-content-faq">
    <ul class="parskala-faqs">


    <?php
        global $post;

        $myposts = get_posts( array(
            'posts_per_page' => -1,
            'post_type'         => 'product-faq',
            'post_parent'       => $product->get_id()
        ) );

        if ( $myposts ) {
            foreach ( $myposts as $post ) :
                setup_postdata( $post ); ?>
                <li>
                    <div class="content-faq-product"><?php the_content(); ?></div>
                <?php
                $args = array(
                    'status'  => 'approve',
                    'number'  => '5',
                    'post_id' => $post->ID, // use post_id, not post_ID
                );
                $comments = get_comments( $args );
                if( ! empty($comments) ){
                    echo '<ol>';
                        foreach ( $comments as $comment ) :
                            echo '<li><span class="rep-text">'.__('پاسخ', 'parskala').'</span> '.$comment->comment_content.'<br><em>'.$comment->comment_author.'</em><span class="date-reply">' .esc_html( get_comment_date( wc_date_format() ) ).'</span></li>';
                        endforeach;
                    echo '</ol>';
                }

                ?>
                <span class="show-replay-question show"><?php _e('ثبت پاسخ جدید', 'parskala'); ?> <i class="fi fi-rr-angle-small-left"></i> </span>
                <div class="parskala-textarea-replay">

                    <span class="tilte-replay-question"><?php _e('به این پرسش پاسخ دهید*', 'parskala'); ?></span>
                    <div class="cover-loading-replay"></div>

                    <textarea class="replay-user"></textarea>

                    <div class="term-replay-button">

                        <span class="remove-replay-question"><?php _e('انصراف', 'parskala'); ?></span>
                        <span class="button-replay-question" postID="<?php echo $post->ID; ?>"><?php _e('ثبت پاسخ', 'parskala'); ?></span>
                    </div>

                </div>

                </li>
            <?php
            endforeach;
            wp_reset_postdata();
        }else {
          ?>
          <div class="Blank-QA">
            <i class="flaticon-question-7"></i>
            <p><?php _e('No questions and answers have been recorded.', 'parskala'); ?></p>
          </div>

          <?php
        }
        ?>

    </ul>
</div>

<div class="parskala-side-faq">
    <p><?php _e('Express your question about this product', 'parskala'); ?></p>
    <?php if (is_user_logged_in()):?>

     <span class="show-insert-question show" data-remodal-target="modal-question"><?php _e('Register question', 'parskala'); ?></span>
    <?php else:?>
     <span class="show-insert-question show" data-custom-open="loginmodal"><?php _e('Register question', 'parskala'); ?></span>
    <?php endif;?>

    <div class="remodal question_modal  remodal-md" id="modal-question"  data-remodal-options="hashTracking: false"  data-remodal-id="modal-question">

        <div class="cover-loading-question"></div>


        <div class="remodal-header">
          <span class="title-feed">پرسش خود را درباره این کالا ثبت کنید</span>
          <button data-remodal-action="close" class="remodal-close"></button>
        </div>

        <textarea class="question-user"></textarea>
        <span data-remodal-action="close" class="button-insert-question"><?php _e('Register question', 'parskala'); ?></span>
        <p class="sec-pages">ثبت پاسخ به معنی موافقت باقوانین انتشار <a href="<?php echo $url_pages;?>" target="_blank"><?php bloginfo('name');?></a> است.</p>
    </div>
</div>

</div>
<script>


    jQuery(document).ready(function($){


        $('.show-replay-question').on('click',function(){
            $('.parskala-textarea-replay').removeClass('show');
            $('.show-replay-question').addClass('show');
            $(this).parent('li').find('.parskala-textarea-replay').toggleClass('show');
            $(this).toggleClass('show');
        });
        $('.remove-replay-question').on('click',function(){
            $(this).parent().parent().toggleClass('show');
            $(this).parent().parent().parent().find('.show-replay-question').toggleClass('show');
        });



        $(document.body).on('click', '.parskala-textarea-replay.show .button-replay-question', function() {

          var button_replay = $(this);
           if ( button_replay.parent().parent().find('.replay-user').val() == '' ) {
               alert('<?php _e('لطفا پاسخ خود را درج نمائید.', 'parskala'); ?>');
               return;
           }

            $.post(parskala_values.ajax_url,
            {
                action: "inset_replay_question_product",
                post_id: button_replay.attr('postID'),
                content: button_replay.parent().parent().find('.replay-user').val()
            },
            function(data, status){
                alert(data);
                button_replay.parent().parent().find('.replay-user').val('');
                button_replay.parent().parent().toggleClass('show');
                button_replay.parent().parent().parent().find('.show-replay-question').toggleClass('show');
                button_replay.parent().parent().find('.cover-loading-replay').hide(0);
            });

        });


        $('.button-insert-question').click(function(){

            $('.cover-loading-question').show(0);

            $.post(parskala_values.ajax_url,
            {
                action: "inset_question_product",
                product_id: "<?php echo $product->get_id(); ?>",
                content: $('.question-user').val(),
            },
            function(data, status){
                alert(data);
                $('.question-user').val('');
                $('.feed.micromodal-slide').removeClass('is-open');
                $(".body").css("overflow", "unset");
                $(".body").css("height", "unset");
                $('.cover-loading-question').hide(0);
            });
        });

    });
</script>
