<?php
add_filter('woocommerce_output_related_products_args', 'prk_custom_related_products_args');
	function prk_custom_related_products_args($args){


			$args['posts_per_page'] =  prk_option('posts_per_page_related_product', 10);

		return $args;
	}


add_filter( 'woocommerce_related_products', 'prk_related_products_by_title', 9999, 3 );

function prk_related_products_by_title( $related_posts, $product_id, $args ) {


// get all product cats for the current post
$categories = get_the_terms( $product_id, 'product_cat' );

// wrapper to hide any errors from top level categories or products without category
if ( $categories  ) :

    // loop through each cat
    foreach($categories as $category) :
      // get the children (if any) of the current cat
      $children = get_categories( array ('taxonomy' => 'product_cat', 'parent' => $category->term_id ));

      if ( count($children) == 0 ) {
          // if no children, then echo the category name.
          $product_cat_id = $category->term_id;
		  break;
      }
    endforeach;

endif;

	if(!empty($product_cat_id)){

			$related_posts = get_posts( array(
					'posts_per_page' => prk_option('posts_per_page_related_product', 10),
				 'exclude' => array( $product_id ),
				 'orderby' => 'rand',
				 'post_type' => 'product',
				 'fields' => 'ids',
				 'tax_query' => array(
						 array(
								 'taxonomy' => 'product_cat',
								 'field' => 'id',
								 'terms' => array($product_cat_id)
						 ),
				 ),

			));

	}
	return $related_posts;

}
