<?php


// نمایش لوگو بنر

function brandlogo_product(){
  $brandlogo = "";

  global $post;
  $brand_slug = prk_option('product_brand_slug') ? prk_option('product_brand_slug') : 'brand';
  $last_brand = $last_brands = $brand_image = '';
  $last_brands = get_the_terms( $post->ID, $brand_slug );


  if ($last_brands && (prk_option('show_brand_product') == '1'  || prk_option('show_brand_product') == '') ) {
    $last_brand = array_reverse($last_brands);
    foreach ($last_brand as $term) {
       $meta = get_term_meta( $term->term_id, 'product_brand_options', true );
       if (isset($meta['brand_image']))		$brand_image    = $meta['brand_image']['url'];
    }

    if ($brand_image) {
         echo '<img class="brand_logo" src="'.$brand_image.'" alt="brand-logo">';
    }

  }
  return $brandlogo;
}
