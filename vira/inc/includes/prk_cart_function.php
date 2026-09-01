<?php

function cw_discount() {

   global $woocommerce;
   $cw_discount = 0;
   foreach ( $woocommerce->cart->get_cart() as $cw_cart_key => $values) {
       $_product = $values['data'];
       if ( $_product->is_on_sale() && $_product->get_sale_price() ) {
            $regular_price = $_product->get_regular_price();
            $sale_price = $_product->get_sale_price();
            $discount = ($regular_price - $sale_price) * $values['quantity'];
            $cw_discount += $discount;
        }
   }
   if ( $cw_discount > 0 ) {
    echo '<tr class="cart-discount">
      <th>'. __( 'Discount on goods', 'parskala' ) .'</th>

        <td data-title=" '. __( 'Discount on goods', 'parskala' ) .' ">'
        . wc_price( $cw_discount + $woocommerce->cart->discount_cart ) .'</td>
      </tr>';

    }
}

add_action( 'woocommerce_cart_totals_before_order_total', 'cw_discount',1,1);
add_shortcode('prk_order_total', 'cw_discount');

remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
add_action( 'woocommerce_cart_is_empty', 'custom_empty_cart_message', 10 );

function custom_empty_cart_message() {
  ?>

    <div class="prk_empty_cart">
      <div class="prk_empty_cart_detales">
        <div class="empty_cart_icon">
          <i class="prk-emoji-sad empty_cart"></i>
        </div>

        <p class="cart-empty">
          <?php echo wp_kses_post( apply_filters( 'wc_empty_cart_message', __('Your cart is empty. Go to the following pages to see more products', 'parskala' ) ) );?>
        </p>

        <div class="page_shoper">
           <ul>
             <li> <a href="<?php echo get_bloginfo('url');?>"><?php _e('home page' , 'parskala');?></a> </li>
             <li> <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') );?>sit-wishlist"><?php _e('my interests' , 'parskala');?></a> </li>
           </ul>
        </div>

      </div>

  <?php
}

function prk_add_total_order_in_order_before_submit(){
?>
<div class="prk-order-total">
<span class="order-reviws-title"><?php esc_html_e( 'Total', 'woocommerce' ); ?></span>
<span class="order-reviws-total"><?php wc_cart_totals_order_total_html(); ?></span>
</div>
<?php
}
add_action('woocommerce_review_order_before_submit','prk_add_total_order_in_order_before_submit',1,1);

add_filter( 'woocommerce_checkout_fields' , 'quadlayers_remove_checkout_fields' );

function quadlayers_remove_checkout_fields( $fields ) {

unset($fields['billing']['billing_company']);
unset($fields['billing']['billing_address_2']);
return $fields;

}
