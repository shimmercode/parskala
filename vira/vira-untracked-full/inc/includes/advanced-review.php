<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


function get_average_option_rating( $product_id , $key ){

  global $wpdb;
  // var_dump($wpdb->commentmeta);
  // die;
  $count = $wpdb->get_var(
      $wpdb->prepare(
          "SELECT count(meta_value)
          FROM $wpdb->commentmeta
          INNER JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
          WHERE comment_post_ID = %d AND meta_key = %s ",
          $product_id, $key

      )
  );

    if ( $count ) {
        $ratings = $wpdb->get_var(
            $wpdb->prepare(
                "
            SELECT SUM(meta_value) FROM $wpdb->commentmeta
            LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
            WHERE meta_key = '%s'
            AND comment_post_ID = %d
            AND comment_approved = '1'
            AND meta_value > 0
                ",
                $key,
                $product_id
            )
        );
        $average = number_format( $ratings / $count, 1, '.', '' );
    } else {
        $average = 0;
    }

    return $average;

}

$display_advanced_review = prk_option('display_advanced_review');




if ($display_advanced_review === NULL) {
	define('display_advanced_review', 'off');
} else {
	define('display_advanced_review', $display_advanced_review);
}


remove_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar', 10 );


add_action( 'comment_post', function ( $comment_id ){

	if( !empty($_POST['optionRatings']) ){
		foreach($_POST['optionRatings'] as $key => $value ){
			update_comment_meta( $comment_id, $key, $value );
		}
	}

	if ( $display_advanced_review == 'off' ) return;

    if( isset( $_POST['recommend'] ) ) update_comment_meta( $comment_id, 'recommend', esc_attr( $_POST['recommend'] ) );
    if( isset( $_POST['comment-form-title'] ) != '' ) update_comment_meta( $comment_id, 'comment-title', esc_attr( $_POST['comment-form-title'] ) );
    if( isset( $_POST['advantages'] ) ) update_comment_meta( $comment_id, 'advantages',  $_POST['advantages'] );
    if( isset( $_POST['disadvantage'] ) ) update_comment_meta( $comment_id, 'disadvantage',  $_POST['disadvantage'] );
});


add_action( 'woocommerce_review_before_comment_text', function ( $comment ){

 $display_advanced_review = prk_option('display_advanced_review');

	if ( $display_advanced_review == 'off' ) return;

	$recommend = get_comment_meta( $comment->comment_ID, 'recommend', true );

	if(!empty($recommend)){

        if($recommend == "recommended"){
            $rec_label = __('خرید این محصول را توصیه می‌کنم', 'prk');

			echo '<em class="prk_review_tag_recommend prk_reveiw_'.$recommend.'" >
			<span class="dashicons dashicons-thumbs-up"></span>
			'.$rec_label.'
			</em>';

        }elseif($recommend =="no_idea"){

            $rec_label = __('?! در مورد خرید این محصول مطمئن نیستم', 'prk');

			echo '<em class="prk_review_tag_recommend prk_reveiw_'.$recommend.'" >

			'.$rec_label.'
			</em>';


        }elseif($recommend =="not_recommended"){

            $rec_label = __('خرید این محصول را توصیه نمی‌کنم', 'prk');


			echo '<em class="prk_review_tag_recommend prk_reveiw_'.$recommend.'" >
			<span class="dashicons dashicons-thumbs-down"></span>
			'.$rec_label.'
			</em>';

        }
	}

}, 11);
