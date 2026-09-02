<?php





add_filter( 'woocommerce_format_sale_price', 'prk_dcwd_sale_price', 10, 3 );

function prk_dcwd_sale_price( $price, $regular_price, $sale_price ) {

    // بررسی اینکه قیمت معمولی 0 نباشد
    if ((int)$regular_price != 0) {
        @$percentage = round( ( ( (int)$regular_price - (int)$sale_price ) / (int)$regular_price ) * 100 );
    } else {
        $percentage = 0; // مقدار پیش‌فرض در صورت نبود قیمت معمولی
    }

    // بررسی اینکه درصد تخفیف بزرگتر یا مساوی 1 باشد
    if($percentage >= 1) {
        $nk_discount_percentage = '<del aria-hidden="true"><span class="index-discount-pro">٪<p>' . $percentage . '</p></span>';
        return str_replace('<del aria-hidden="true">', $nk_discount_percentage, $price);
    } else {
        return $price;
    }

}


//Hide Price Range for WooCommerce Variable Products
add_filter( 'woocommerce_variable_sale_price_html', 'prk_lw_variable_product_price', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'prk_lw_variable_product_price', 10, 2 );

function prk_lw_variable_product_price( $v_price, $v_product ) {

// Product Price
$prod_prices = array( $v_product->get_variation_price( 'min', true ),
                            $v_product->get_variation_price( 'max', true ) );
$prod_price = $prod_prices[0]!==$prod_prices[1] ? sprintf(__('%1$s', 'woocommerce'),
                       wc_price( $prod_prices[0] ) ) : wc_price( $prod_prices[0] );

// Regular Price
$regular_prices = array( $v_product->get_variation_regular_price( 'min', true ),
                          $v_product->get_variation_regular_price( 'max', true ) );
sort( $regular_prices );
$regular_price = $regular_prices[0]!==$regular_prices[1] ? sprintf(__('%1$s','woocommerce')
                      , wc_price( $regular_prices[0] ) ) : wc_price( $regular_prices[0] );

	if ( $prod_price !== $regular_price ) {
		// Variables initialisation
		$variation_min_reg_price = $v_product->get_variation_regular_price('min', true);
		$variation_min_sale_price = $v_product->get_variation_sale_price('min', true);
		$percentage_min = '';


		$percentage_min = round( ( ( $variation_min_reg_price -  $variation_min_sale_price ) / $variation_min_reg_price ) * 100 );


		if ( ($variation_min_reg_price != $variation_min_sale_price) ) {
		$prod_price = '<del><span class="index-discount-pro">٪<p>'.$percentage_min.'</p></span>' . wc_price($variation_min_reg_price) . '</del> <ins>' .
		     wc_price($variation_min_sale_price) . '</ins>';
		}

		return $prod_price;
	}else {
		return $v_price;
	}
}
