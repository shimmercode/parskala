<?php
function prk_sale_off_shortcode() {
  global $product;
  global $woocommerce;
  $currency = get_woocommerce_currency_symbol();
  $price = get_post_meta( get_the_ID(), '_regular_price', true);
  $sale = get_post_meta( get_the_ID(), '_sale_price', true);
  if ( ! $product->is_on_sale() ) return;
  if ( $product->is_type( 'simple' ) ) {
     $max_percentage = ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100;
  } elseif ( $product->is_type( 'variable' ) ) {
     $max_percentage = 0;
     foreach ( $product->get_children() as $child_id ) {
        $variation = wc_get_product( $child_id );
        $price = $variation->get_regular_price();
        $sale = $variation->get_sale_price();
        if ( $price != 0 &&  $sale  ){ $percentage = ( $price - $sale ) / $price * 100;

        if ( $percentage > $max_percentage ) {
           $max_percentage = $percentage;
        }
     }
     }
  }
  if ( $max_percentage > 0 ) echo "<span class='index-discount-pro'><p class='sale-off-pro'>" . round($max_percentage) . "%</p></span>";
}
// Register shortcode
add_shortcode('sale_off', 'prk_sale_off_shortcode');




function prk_attributes_shortcode() {
  global $product;
  $has_row    = false;
  $attributes = $product->get_attributes();

  ob_start();
  echo '<span class="atri-single">ویژگی های محصول</span>';
  ?>
  <div class="product_attributes">

  	<?php foreach ( $attributes as $attribute ) :

  		if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) )
  			continue;

  		$values = wc_get_product_terms( $product->get_id(), $attribute['name'], array( 'fields' => 'names' ) );
  		$att_val = apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

  		if( empty( $att_val ) )
  			continue;

  		$has_row = true;
  		?>

  	<div class="col">
  		<div class="att_label"><?php echo  wc_attribute_label( $attribute['name']) ,':'; ?></div>
  		<div class="att_value"><?php echo $att_val; ?></div><!-- .att_value -->
  	</div><!-- .col -->

  	<?php endforeach; ?>

  </div><!-- .product_attributes -->

  <?php
  if ( $has_row ) {
  	echo ob_get_clean();
  } else {
  	ob_end_clean();
  }
}
// Register shortcode
add_shortcode('attributes', 'prk_attributes_shortcode');


function prk_ajax_cart_shortcode() {
  global $product;
  $template = get_bloginfo('template_url');
  echo sprintf( '<a  href="%s" data-quantity="1" class="%s" %s><i class="fal fa-plus"></i><span class="text-cart">%s</span><img class="loader-cart" src=""></a>',
      esc_url( $product->add_to_cart_url() ),
      esc_attr( implode( ' ', array_filter( array(
          'button', 'product_type_' . $product->get_type(),
          $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
          $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
      ) ) ) ),
      wc_implode_html_attributes( array(
          'data-product_id'  => $product->get_id(),
          'data-product_sku' => $product->get_sku(),
          'aria-label'       => $product->add_to_cart_description(),
          'rel'              => 'nofollow',
      ) ),
      esc_html( $product->add_to_cart_text() )
  );
}
// Register shortcode
add_shortcode('ajax_cart', 'prk_ajax_cart_shortcode');

function prk_ajax_cart_ver_2_shortcode() {
  global $product;


  if ( ! $product->is_in_stock() ) {
    return;
  }

  $template = get_bloginfo('template_url');
  echo sprintf( '<a  href="%s" data-quantity="1" class="%s" %s><span class="text-cart-ver2">%s</span></a>',
      esc_url( $product->add_to_cart_url() ),
      esc_attr( implode( ' ', array_filter( array(
          'button', 'product_type_' . $product->get_type(),
          $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
          $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
      ) ) ) ),
      wc_implode_html_attributes( array(
          'data-product_id'  => $product->get_id(),
          'data-product_sku' => $product->get_sku(),
          'aria-label'       => $product->add_to_cart_description(),
          'rel'              => 'nofollow',
      ) ),
      esc_html( $product->add_to_cart_text() )
  );
}
// Register shortcode
add_shortcode('ajax_cart_ver2', 'prk_ajax_cart_ver_2_shortcode');

function prk_ajax_cart_item() {
  global $product;

  if ( ! $product->is_in_stock() ) {
    return;
  }

  echo sprintf(
    '<a data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="افزودن به سبد خرید" aria-label="افزودن به سبد خرید"  href="%s" data-quantity="1" class="%s" %s>
    <i class="prk-shopping-cart"></i>
    </a>',
      esc_url( $product->add_to_cart_url() ),
      esc_attr( implode( ' ', array_filter( array(
          'button', 'product_type_' . $product->get_type(),
          $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
          $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
      ) ) ) ),

      wc_implode_html_attributes( array(
          'data-product_id'  => $product->get_id(),
          'data-product_sku' => $product->get_sku(),
          'aria-label'       => $product->add_to_cart_description(),
          'rel'              => 'nofollow',
      ) ),

      esc_html( $product->add_to_cart_text() )
  );
}
// Register shortcode
add_shortcode('ajax_cart_item', 'prk_ajax_cart_item');
