<?php
add_action('edit_form_after_title', function($post){

    global $typenow;
    if( in_array($typenow, array('product-better') ) ){ ?>
<br>
        <div id="titlediv">
          <div id="titlewrap">
            <br>
            <input value="<?php echo get_post_meta($post->ID, 'shop_price', true); ?>" placeholder="قیمت" type="text" name="shop_price" size="10"  id="title" spellcheck="true" autocomplete="off">
          </div>
        </div>
      <div id="titlediv">
    		<div id="titlewrap">
          <br>
    			<input value="<?php echo get_post_meta($post->ID, 'shop_name', true); ?>" placeholder="نام فروشگاه" type="text" name="shop_name" size="10"  id="title" spellcheck="true" autocomplete="off">
    		</div>
    	</div>

      <div id="titlediv">
        <div id="titlewrap">
          <br>
          <input value="<?php echo get_post_meta($post->ID, 'shop_city', true); ?>" placeholder="مکان فروشگاه" type="text" name="shop_city" size="10"  id="title" spellcheck="true" autocomplete="off">
        </div>
      </div>

	<div id="titlediv">
		<div id="titlewrap">
      <br>
			<input value="<?php echo get_post_meta($post->ID, 'website_url', true); ?>" placeholder="آدرس اینترنتی فروشگاه" type="text" name="website_url" size="10"  id="title" spellcheck="true" autocomplete="off">
		</div>
	</div>

<?php }
});



function subbetter_product_meta_product( $post_id, $post, $update ) {
    $post_type = get_post_type($post_id);
    if ( "product-better" != $post_type ) return;
    if ( isset( $_POST['shop_price'] ) ) {
        update_post_meta( $post_id, 'shop_price', sanitize_text_field( $_POST['shop_price'] ) );
        update_post_meta( $post_id, 'product_shop_price', sanitize_text_field( $_POST['shop_price'] ) );
    }
    if ( isset( $_POST['website_url'] ) ) {
        update_post_meta( $post_id, 'website_url', sanitize_text_field( $_POST['website_url'] ) );
        update_post_meta( $post_id, 'product_website_url', sanitize_text_field( $_POST['website_url'] ) );
    }
    if ( isset( $_POST['shop_name'] ) ) {
        update_post_meta( $post_id, 'shop_name', sanitize_text_field( $_POST['shop_name'] ) );
        update_post_meta( $post_id, 'product_shop_name', sanitize_text_field( $_POST['shop_name'] ) );
    }
    if ( isset( $_POST['shop_city'] ) ) {
        update_post_meta( $post_id, 'shop_city', sanitize_text_field( $_POST['shop_city'] ) );
        update_post_meta( $post_id, 'product_shop_city', sanitize_text_field( $_POST['shop_city'] ) );
    }
}
add_action( 'save_post', 'subbetter_product_meta_product', 10, 3 );
