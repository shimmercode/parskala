<?php


// For displaying in Order page columns.
add_filter( 'manage_edit-shop_order_columns', 'dina_set_tracking_column' );
function dina_set_tracking_column($columns) {
    global $post;

    $columns['prk_woocot_number'] = prk_option( 'order_tracking_code_title' );

    return $columns;
}


// Add the data to the custom columns for the order post type:
    add_action( 'manage_shop_order_posts_custom_column' , 'dina_custom_shop_order_column', 10, 2 );
    function dina_custom_shop_order_column( $column, $post_id ) {
        switch ( $column ) {
            case 'prk_woocot_number' :
                echo esc_html( get_post_meta( $post_id, 'prk_woocot_number', true ) );
                break;
        }
    }




// Showing the info on My orders page

//New column on My orders page
add_filter( 'woocommerce_account_orders_columns', 'dina_add_account_orders_column', 1, 1 );
function dina_add_account_orders_column( $columns ){
    $columns['tracking-column'] = prk_option( 'order_tracking_code_title' );

    return $columns;
}

add_action( 'woocommerce_my_account_my_orders_column_tracking-column', 'dina_add_account_orders_column_rows' );
function dina_add_account_orders_column_rows( $order ) {
    // Example with a custom field
    if ( $value = $order->get_meta( 'prk_woocot_number' ) ) {
		?>
		<span class="dina-order-tracking-code">
			<span class="dina-order-tracking-text" data-toggle="tooltip" data-placement="top" title="<?php _e( 'Click to copy the code', 'parskala' ); ?>">
				<?php echo esc_html( $value ) ?>
			</span>
			<span class="link-copy"><?php _e( 'Code copied!', 'parskala' ) ?></span>
        </span>
	<?php
    }
}

// Showing tracking code on View order page and on Thank you page
add_action( 'woocommerce_thankyou', 'dina_tracking_on_thankyou_page', 2 );
add_action( 'woocommerce_view_order', 'dina_tracking_on_thankyou_page', 2 );
function dina_tracking_on_thankyou_page( $order_id ){

    $prk_order_tracking =  prk_woocommerce_order_tracking();
    $shippers     = $prk_order_tracking->get_shippers();


    $order = wc_get_order( $order_id );
    $prk_woocot_shipper = get_post_meta( $order_id, 'prk_woocot_shipper', true );

	if ( ! $order ) 
        return;

    $tracking_code = get_post_meta( $order_id, 'prk_woocot_number', true );
    $tracking_type = $order->get_meta( 'tracking_type' );

    if ( ! empty ( $tracking_code ) ) {  ?>
    <table class="woocommerce-table shop_table dina-order-tracking-code-table">
        <tbody>        
            <tr>
                <th>
                    <?php echo prk_option( 'order_tracking_code_title' ) . ': ' ?>
                </th>
                <td>
                    <span class="dina-order-tracking-code">
                        <span class="dina-order-tracking-text" data-toggle="tooltip" data-placement="top" title="<?php _e( 'Click to copy the code', 'dina-kala' ); ?>">
                             <?php echo esc_html( $tracking_code ) ?>
                        </span>
                        <span class="link-copy"><?php _e( 'Code copied!', 'parskala' ) ?></span>
                    </span>
                </td>
                <td>
                    <?= sprintf( esc_html__( 'ارسال شده با %s', 'woocommerce-order-tracking' ), esc_html( $shippers[ $prk_woocot_shipper ]['name'] ) ) ; ?>

                </td>
            </tr>
        </tbody>
    </table>
<?php }
}

add_action ( 'wp_footer', 'dina_copy_tracking_script' );
function dina_copy_tracking_script(){
	if ( is_user_logged_in() && is_account_page() ) { ?>
		<script>
			jQuery(function (e) {
			jQuery(document).on("click", ".dina-order-tracking-code", function () {
				var e = jQuery("<input>");
				jQuery("body").append(e), e.val(jQuery(this).find('.dina-order-tracking-text').html()).select(), document.execCommand("copy"), e.remove(), jQuery(this).find(".link-copy").fadeIn().delay(100).fadeOut(300)
			})
			})
		</script>
	<?php
	}
}
