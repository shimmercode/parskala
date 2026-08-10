<?php
/**
 * The template to display the reviewers meta data (name, verified owner, review date)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review-meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

$display_advanced_review = prk_option('display_advanced_review');

defined( 'ABSPATH' ) || exit;

global $comment;
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

if ( '0' === $comment->comment_approved ) { ?>

	<p class="meta">
		<em class="woocommerce-review__awaiting-approval">
			<?php esc_html_e( 'Your review is awaiting approval', 'woocommerce' ); ?>
		</em>
	</p>

<?php }

else {

  $title = get_comment_meta( $comment->comment_ID, 'comment-title', true );
  $advantages = get_comment_meta( $comment->comment_ID, 'advantages', true );
  $disadvantage = get_comment_meta( $comment->comment_ID, 'disadvantage', true );
?>


	<?php if( $title && $display_advanced_review == 'on' ){ ?><h5 class="title_comment"><?php echo $title; ?></h5><?php } ?>
	<p class="meta">
		<strong class="woocommerce-review__author"> <?php _e('توسط', 'vira'); echo ' '; comment_author(); ?> </strong>
		<span class="woocommerce-review__dash"> <?php _e('در تاریخ', 'vira'); ?> </span> <time class="woocommerce-review__published-date" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>"><?php echo esc_html( get_comment_date( wc_date_format() ) ); ?></time>

	<?php
	if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
		echo '<em class="woocommerce-review__verified verified">' . esc_attr__( 'خریدار این محصول', 'vira' ) . '</em> ';
	}
	?>
	</p>

<?php
}
?>
<?php
$title = get_comment_meta( $comment->comment_ID, 'comment-title', true );
$advantages = get_comment_meta( $comment->comment_ID, 'advantages', true );
$disadvantage = get_comment_meta( $comment->comment_ID, 'disadvantage', true );
 if( ( $advantages || $disadvantage ) && $display_advanced_review == 'on'  ){  ?>
	<div class="main_disadvantage_advantages">
		<?php
		if( $advantages ){
		?>
		<div class="main_advantages">

			<span><?php _e('نقاط قوت', 'vira'); ?></span>

			<ul>

				<?php
					foreach($advantages as $advantage) echo '<li>'.$advantage.'</li>';
				?>

			</ul>

		</div>
		<?php } ?>
		<?php
		if( $disadvantage ){
		?>
		<div class="main_disadvantage">

			<span><?php _e('نقاط ضعف', 'vira'); ?></span>

			<ul>

				<?php
					foreach($disadvantage as $disadvantag) echo '<li>'.$disadvantag.'</li>';
				?>

			</ul>

		</div>
		<?php } ?>
	</div>
<?php } ?>
