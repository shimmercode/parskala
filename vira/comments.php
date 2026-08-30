<?php
/**
 * Vira Theme Comments & Reviews Template
 *
 * @package Vira
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( post_password_required() ) {
    return;
}
?>
<div id="comments" class="vira-comments-area">
    <?php if ( have_comments() ) : ?>
        <h3 class="comments-title">
            <?php
            $vira_comment_count = get_comments_number();
            if ( '1' === $vira_comment_count ) {
                echo '۱ نظر و دیدگاه';
            } else {
                echo esc_html( vira_to_persian_num( $vira_comment_count ) ) . ' نظر و دیدگاه ثبت شده';
            }
            ?>
        </h3>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 48,
            ) );
            ?>
        </ol>

        <?php
        the_comments_pagination( array(
            'prev_text' => '« دیدگاه‌های قبلی',
            'next_text' => 'دیدگاه‌های بعدی »',
        ) );
    endif;

    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
        <p class="no-comments">بخش دیدگاه‌ها برای این صفحه بسته شده است.</p>
        <?php
    endif;

    comment_form( array(
        'title_reply'          => 'دیدگاه خود را ثبت کنید',
        'title_reply_to'       => 'پاسخ به %s',
        'cancel_reply_link'    => 'انصراف از پاسخ',
        'label_submit'         => 'ارسال دیدگاه',
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">متن دیدگاه <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="5" required></textarea></p>',
    ) );
    ?>
</div>
