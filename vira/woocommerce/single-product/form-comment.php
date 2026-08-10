<script src="<?php bloginfo('template_url'); ?>/assets/js/nouislider.min.js"></script>
<link href="<?php bloginfo('template_url'); ?>/assets/css/lunches/nouislider.min.css" rel="stylesheet">

<?php

$display_advanced_review = prk_option('display_advanced_review');

?>
<style media="screen">
	body .product-tooltips{
		display: none !important;
	}
</style>

<div id="review_form_wrapper">

<?php if (prk_option('display_advanced_review') == 'on' ):?>
<div class="main-thumbnail-ratings-title">

	<div class="thumbnail-product-review">

		<?php the_post_thumbnail( "shop_single" ) ?>
  <?php  $product_pro_name = get_post_meta( $post->ID, 'en_pro_name', true );?>
	</div>

	<div class="title-product-and-rtaing-options">

		<div class="title-product-review"><?php the_title()?>
   <span class="en_name_pro"><?php echo $product_pro_name;?></span>
		</div>

		<?php

		 $comment_recommend = prk_option('comment_recommend');
		 $global_option_ratings = prk_option( "global_options_ratings_review");

         $meta = get_post_meta( get_the_ID(), 'prk_product_options', true );
		 $option_ratings = $des_review = "";
		 if(isset($meta) && !empty($meta)){
		
			if ( isset( $meta['options_ratings_review'] ) )		$option_ratings   	    = $meta['options_ratings_review'];
			if ( isset( $meta['des_review'] ) )		$des_review   	    = $meta['des_review'];
		 }


		if( !empty( $global_option_ratings || $option_ratings) ){

			echo '<div class="prk-main-ratings-opitons">';

if ($option_ratings ) {
	foreach( $option_ratings as $item ) { ?>


			<div class="container-option-ratings" >

				<span class="prk-title-ratings-review"><?php echo $item['title']; ?></span>

				<div class="prk-main-nouislider">

					<div class="prk-nouislider"><div id="<?php echo $item['slug'] ?>"></div></div>

          <div class="l-left">
						<span class="tag-rating-review-product tag-<?php echo $item['slug'] ?>" number-label="1" >خیلی بد</span>
						<span class="tag-rating-review-product tag-<?php echo $item['slug'] ?>" number-label="2" >بد</span>
						<span class="tag-rating-review-product tag-<?php echo $item['slug'] ?>" style="display:block" number-label="3" >معمولی</span>
						<span class="tag-rating-review-product tag-<?php echo $item['slug'] ?>" number-label="4" >خوب</span>
						<span class="tag-rating-review-product tag-<?php echo $item['slug'] ?>" number-label="5" >عالی</span>
  				</div>

				</div>
			</div>


		<script>
			var <?php echo $item['slug'] ?> = document.getElementById('<?php echo $item['slug'] ?>');
			noUiSlider.create(<?php echo $item['slug'] ?>, {
						direction: 'rtl',
						connect: [true, false],
						start: 3,
						step: 1,
						format: {
							to: (v) => parseFloat(v).toFixed(0),
							from: (v) => parseFloat(v).toFixed(0)
						},
						range: {
							min: 1,
							max: 5
						}
			});

			<?php echo $item['slug'] ?>.noUiSlider.on('update', function( value ){
				console.log(value[0]);
				jQuery(".<?php echo $item['slug'] ?>").val(value[0]);
				jQuery(".tag-<?php echo $item['slug'] ?>").hide(0);
				jQuery(".tag-<?php echo $item['slug'] ?>[number-label=" + value[0] + "]").show(0);
			});

		</script>

	<?php }
}elseif ($global_option_ratings) {
		foreach( $global_option_ratings as $item ) {
			 ?>


				<div class="container-option-ratings" >

					<span class="capisa-title-ratings-review"><?php echo $item['title']; ?></span>

					<div class="capisa-main-nouislider">

						<div class="prk-nouislider"><div id="<?php echo $item['slug'] ?>"></div></div>

	          <div class="l-left">
							<span class="tag-rating-review-product tag-<?php echo $item['slug'] ?>" number-label="1" >خیلی بد</span>
							<span class="tag-rating-review-product tag-<?php echo $item['slug'] ?>" number-label="2" >بد</span>
							<span class="tag-rating-review-product tag-<?php echo $item['slug'] ?>" style="display:block" number-label="3" >معمولی</span>
							<span class="tag-rating-review-product tag-<?php echo $item['slug'] ?>" number-label="4" >خوب</span>
							<span class="tag-rating-review-product tag-<?php echo $item['slug'] ?>" number-label="5" >عالی</span>
	  				</div>

					</div>
				</div>


			<script>
				var <?php echo $item['slug'] ?> = document.getElementById('<?php echo $item['slug'] ?>');
				noUiSlider.create(<?php echo $item['slug'] ?>, {
							direction: 'rtl',
							connect: [true, false],
							start: 3,
							step: 1,
							format: {
								to: (v) => parseFloat(v).toFixed(0),
								from: (v) => parseFloat(v).toFixed(0)
							},
							range: {
								min: 1,
								max: 5
							}
				});

				<?php echo $item['slug'] ?>.noUiSlider.on('update', function( value ){
					console.log(value[0]);
					jQuery(".<?php echo $item['slug'] ?>").val(value[0]);
					jQuery(".tag-<?php echo $item['slug'] ?>").hide(0);
					jQuery(".tag-<?php echo $item['slug'] ?>[number-label=" + value[0] + "]").show(0);
				});

			</script>

		<?php }
	}

			echo '</div>';
		}
		?>
	</div>

</div>

<?php endif;?>
<?php


$comment_text = prk_option('comment_text');

?>

			<div id="review_form" class="<?php echo $class = $comment_text != '' ? 'by-des-review' : ''; ?>">
				<?php
				if( $des_review){
				echo '<div class="des-insert-reveiw product-content-onliner">'.$des_review.'</div>';
			}else{
				echo '<div class="des-insert-reveiw product-content-onliner">'.$comment_text.'</div>';
			}
				//global $product, $post;

				$commenter    = wp_get_current_commenter();
				$comment_form = array(
					/* translators: %s is product title */
					//'title_reply'         => have_comments() ? esc_html__( 'Add a review', 'woocommerce' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ),
					'title_reply'         => '',
					/* translators: %s is product title */
					'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
					'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
					'title_reply_after'   => '</span>',
					'comment_notes_after' => '',
					'label_submit'        => esc_html__( 'Submit', 'woocommerce' ),
					'logged_in_as'        => '',
					'comment_field'       => '',
				);






				$name_email_required = (bool) get_option( 'require_name_email', 1 );
				$fields              = array(
					'author' => array(
						'label'    => __( 'Name', 'woocommerce' ),
						'type'     => 'text',
						'value'    => $commenter['comment_author'],
						'required' => $name_email_required,
					),
					'email' => array(
						'label'    => __( 'Email', 'woocommerce' ),
						'type'     => 'email',
						'value'    => $commenter['comment_author_email'],
						'required' => $name_email_required,
					),
				);





				$comment_form['fields'] = array();

				$comment_form['fields']['start-main-defaults-fields'] = '<div class="parskala-half-input">';

				foreach ( $fields as $key => $field ) {
					$field_html  = '<p class="parskala-input-comment-form comment-form-' . esc_attr( $key ) . '">';
					$field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

					if ( $field['required'] ) {
						$field_html .= '&nbsp;<span class="required">*</span>';
					}

					$field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

					$comment_form['fields'][ $key ] = $field_html;

				}

				$comment_form['fields']['end-main-defaults-fields'] = '</div>';

				$account_page_url = wc_get_page_permalink( 'myaccount' );
				if ( $account_page_url ) {
					/* translators: %s opening and closing link tags respectively */
					$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
				}

			if ( $display_advanced_review == 'on'  ){

				$comment_form['comment_field'] .= '<p class="parskala-input-comment-form comment-form-title">';
				$comment_form['comment_field'] .= '<label for="comment-form-title">' . __( 'Title of your comment (required)', 'parskala' );
				$comment_form['comment_field'] .= '&nbsp;<span class="required">*</span>';
				$comment_form['comment_field'] .= '</label><input id="comment-form-title" name="comment-form-title" type="text" value="" size="30" required /></p>';


				$comment_form['comment_field'] .= '<div class="parskala-half-input">';

				$comment_form['comment_field'] .= '<p class="parskala-input-comment-form comment-form-advantages"><span class="add_text_to_field add_text_to_field_advantages">+</span>';
				$comment_form['comment_field'] .= '<label for="comment-form-advantages">' . __( 'Strengths', 'parskala' );
				$comment_form['comment_field'] .= '</label><input id="comment-form-advantages" type="text" value="" size="30" /></p>';

				$comment_form['comment_field'] .= '<p class="parskala-input-comment-form comment-form-disadvantage"><span class="add_text_to_field add_text_to_field_disadvantage">+</span>';
				$comment_form['comment_field'] .= '<label for="comment-form-disadvantage">' . __( 'weak points', 'parskala' );
				$comment_form['comment_field'] .= '</label><input id="comment-form-disadvantage" type="text" value="" size="30" /></p>';

				$comment_form['comment_field'] .= '</div>';

			}

				if ( wc_review_ratings_enabled() ) {
					$comment_form['comment_field'] .= '<div class="flexed"><div class="comment-form-rating"><select name="rating" id="rating" required>
						<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
						<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
						<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
						<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
						<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
						<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
					</select></div>';
				}




			$comment_form['comment_field'] .= '<p class="parskala-input-comment-form comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label></div><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';


			if ( $display_advanced_review == 'on' && $comment_recommend == '1' ){

				$comment_form['comment_field'] .= '<div class="parskala-recommend-product-reveiw">';
				$comment_form['comment_field'] .= '<span>' . esc_html__( 'آیا خرید این محصول را به دوستانتان پیشنهاد می کنید؟', 'parskala' ) . '</span>';
				$comment_form['comment_field'] .= '<label for="recommended"><input id="recommended" type="radio" value="recommended" name="recommend" > ' . esc_html__( 'پیشنهاد می‌کنم', 'parskala' ) . '</label>';
				$comment_form['comment_field'] .= '<label for="not_recommended"><input id="not_recommended" type="radio" value="not_recommended" name="recommend" > ' . esc_html__( 'خیر ، پیشنهاد نمی‌کنم', 'parskala' ) . '</label>';
				$comment_form['comment_field'] .= '<label for="no_idea"><input id="no_idea" type="radio" value="no_idea" name="recommend" > ' . esc_html__( 'نظری ندارم', 'parskala' ) . '</label>';

				$comment_form['comment_field'] .= '</div>';
			}

			if( !empty($global_option_ratings || $option_ratings) ){

				if ($option_ratings) {
					foreach( $option_ratings as $item ){
						$comment_form['comment_field'] .= '<input name="optionRatings['.$item['slug'].']" class="'.$item['slug'].'" type="hidden" value="3" >';
					}

				}else if ($global_option_ratings){
					foreach( $global_option_ratings as $item ){
						$comment_form['comment_field'] .= '<input name="optionRatings['.$item['slug'].']" class="'.$item['slug'].'" type="hidden" value="3" >';
					}
				}

			}

        comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );

				?>

			</div>
		<span class="go-back">
    <a href="<?php the_permalink();?>"><?php _e('Cancellation and return', 'parskala');?></a>
		</span>
		</div>



<script>

	jQuery(document).ready(function($){

		var inputs = $('input#comment-form-advantages, input#comment-form-disadvantage');
		var inputChangeCallback = function () {
            var self = $(this);
            if (self.val().trim().length > 0) {
                self.siblings('.add_text_to_field').show();
            } else {
                self.siblings('.add_text_to_field').hide();
            }
        } ;
        inputs.each(function () {
           inputChangeCallback.bind(this)();
           $(this).on('change keyup', inputChangeCallback.bind(this));
        });







		$('.add_text_to_field_advantages').on('click', function(){

			var val_item = $(this).parent().find('input#comment-form-advantages').val();
			if( val_item.trim().length < 3 ){

				return;
			}

			$(this).parent().append(' <span class="item_added_advantages" > <input type="hidden" name="advantages[]" value="' + val_item.trim() + '" > ' + val_item.trim() + ' <span class="remove_item prk-add"></span></span> ');
			$(this).parent().find('input#comment-form-advantages').val('');

			$(this).hide(0);
		});




		$('.add_text_to_field_disadvantage').on('click', function(){

			var val_item = $(this).parent().find('input#comment-form-disadvantage').val();
			if( val_item.trim().length < 3 ){

				return;
			}

			$(this).parent().append(' <span class="item_added_disadvantage" > <input type="hidden" name="disadvantage[]" value="' + val_item.trim() + '" > ' + val_item.trim() + ' <span class="remove_item  prk-add"></span></span> ');
			$(this).parent().find('input#comment-form-disadvantage').val('');

			$(this).hide(0);
		});





		$('body').on('click', 'span.remove_item', function(){

			$(this).parent().remove();
		});




	});


</script>
