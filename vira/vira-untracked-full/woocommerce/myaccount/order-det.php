<?php
// Function that output order details
function display_order_details() {
    // Exit if Order number not submitted
    if ( ! isset( $_POST['order_number'] ) )
        return; // Exit

    if( $_POST['order_number'] > 0 )
        $order_id = sanitize_text_field( $_POST['order_number'] );
    else
        return; // Exit

    ## $order = wc_get_order( $order_id ); // Not really needed in this case

    echo '<h3>THE ORDER META DATA (Using the array syntax notation):</h3>
        <p>';

    $billing_first_name = get_post_meta( $order_id, '_billing_first_name', true );
    if( ! empty( $billing_first_name ) )
        echo 'Billing first name: ' . $billing_first_name . '<br>';

    $billing_last_name = get_post_meta( $order_id, '_billing_last_name', true );
    if( ! empty( $billing_last_name ) )
        echo 'Billing last name: ' . $billing_last_name . '<br>';

    $billing_address_index = get_post_meta( $order_id, '_billing_address_index', true );
    if( ! empty( $billing_address_index ) )
        echo 'Billing details: ' . $billing_address_index . '<br>';

    $shipping_address_index = get_post_meta( $order_id, '_shipping_address_index', true );
    if( ! empty( $shipping_address_index ) )
        echo 'Shipping details: ' . $shipping_address_index;

    echo '</p><br>
    - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br><br>';

}

// Shotcode that display the form and output order details once submitted
add_shortcode( 'order_details', 'form_get_order_details' );
function form_get_order_details(){
    ob_start(); // Buffering data

    ?>
    <form action="" method="post">
        <label for="order_number">Order number</label><br>
        <input type="text" name="order_number" size="30"><br><br>
        <input type="submit" id="submit" value="Find and output"><br>
    </form>
    <?php

    display_order_details();

    return ob_get_clean(); // Output data from buffer
}
 ?>
