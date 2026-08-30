<?php

/**
 * CUSTOM COMMENT WALKER
 * A custom walker for comments, based on the walker in Twenty Nineteen.
 *
 * @since Twenty Twenty 1.0
 */
class TwentyTwenty_Walker_Comment extends Walker_Comment {

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @since Twenty Twenty 1.0
	 *
	 * @see wp_list_comments()
	 * @see https://developer.wordpress.org/reference/functions/get_comment_author_url/
	 * @see https://developer.wordpress.org/reference/functions/get_comment_author/
	 * @see https://developer.wordpress.org/reference/functions/get_avatar/
	 * @see https://developer.wordpress.org/reference/functions/get_comment_reply_link/
	 * @see https://developer.wordpress.org/reference/functions/get_edit_comment_link/
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {

		$tag =  'li';

		?>
		<<?= $tag ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>

			<div id="div-comment-<?php comment_ID(); ?>" class="comment-meta">

                <cite class="comment-author vcard">
                    <?php
                    $comment_author_url = get_comment_author_url( $comment );
                    $avatar             = get_avatar( $comment, $args['avatar_size'] );
                    if (  $args['avatar_size'] ) {
                        echo wp_kses_post( $avatar );
                    }

        

                    if ( ! empty( $comment_author_url ) ) {
                        echo '</a>';
                    }

                    ?>
                    <?php echo get_comment_author_link();?>
                </cite>

                <span class="separator"></span>
                
                <span class="comment-date">
                    <?php
                    /* translators: 1: Comment date, 2: Comment time. */
                    $comment_timestamp = sprintf( __( '%1$s at %2$s', 'twentytwenty' ), get_comment_date( '', $comment ), get_comment_time() );

                    printf(
                        '<a href="%s"><time datetime="%s" title="%s">%s</time></a>',
                        esc_url( get_comment_link( $comment, $args ) ),
                        get_comment_time( 'c' ),
                        esc_attr( $comment_timestamp ),
                        esc_html( $comment_timestamp )
                    );

                    if ( get_edit_comment_link() ) {
                        printf(
                            ' <span aria-hidden="true">•</span> <a class="comment-edit-link" href="%s">%s</a>',
                            esc_url( get_edit_comment_link() ),
                            __( 'Edit', 'twentytwenty' )
                        );
                    }
                    ?>
                </span>



				<?php
                    $comment_reply_link = get_comment_reply_link(
                        array_merge(
                            $args,
                            array(
                                'add_below' => 'div-comment',
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth'],
                                'before'    => '<span class="comment-reply">',
                                'after'     => '</span>',
                            )
                        )
                    );
				?>


				<?php
                    if ( $comment_reply_link ) {
                        echo $comment_reply_link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Link is escaped in https://developer.wordpress.org/reference/functions/get_comment_reply_link/
                    }
				?>


                

                    </div><!-- .comment-body -->


            
            <div class="comment-content entry-content">

                <?php

                echo '<p class="post-comment-text">';
                comment_text();
                echo '</p> ';
                if ( '0' === $comment->comment_approved ) {
                    ?>
                    <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentytwenty' ); ?></p>
                    <?php
                }

                ?>

            </div><!-- .comment-content -->

		<?php
	}
}
