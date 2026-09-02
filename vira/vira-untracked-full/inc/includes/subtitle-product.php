<?php

add_action('edit_form_after_title', function($post){

    global $typenow;
    if( in_array($typenow, array('product') ) ){ ?>

	<div id="titlediv">
		<div id="titlewrap">
      <br>
			<input value="<?php echo get_post_meta($post->ID, 'en_pro_name', true); ?>" dir="ltr" placeholder="English Title" type="text" name="en_pro_name" size="30"  id="title" spellcheck="true" autocomplete="off">
		</div>
	</div>

<?php }
});



function saveparskala_subtitle_product_meta_product_parskala( $post_id, $post, $update ) {

    $post_type = get_post_type($post_id);

    if ( "product" != $post_type ) return;

    if ( isset( $_POST['en_pro_name'] ) ) {
        update_post_meta( $post_id, 'en_pro_name', sanitize_text_field( $_POST['en_pro_name'] ) );
        update_post_meta( $post_id, 'product_english_name', sanitize_text_field( $_POST['en_pro_name'] ) );
    }
}
add_action( 'save_post', 'saveparskala_subtitle_product_meta_product_parskala', 10, 3 );
