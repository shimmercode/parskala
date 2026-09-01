
<?php

 $seen_title = prk_option('seen_title');

      $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array(); // @codingStandardsIgnoreLine
      $viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );
      $query_args = array(
       'posts_per_page' => 5,
       'no_found_rows'  => 1,
       'post_status'    => 'publish',
       'post_type'      => 'product',
       'post__in'       => $viewed_products,
       'orderby'        => 'post__in',
      );

       $query_args['tax_query'] = array(
         array(
           'taxonomy' => 'product_visibility',
           'field'    => 'name',
           'terms'    => 'outofstock',
           'operator' => 'NOT IN',
         ),
       ); // WPCS: slow query ok.

      $loop = new WP_Query( $query_args );
      if ( $loop->have_posts() ) {
       ?>
      <div class="last_posts">
         <div class="products_seen">
           <?php echo $seen_title ?>
         </div>
         <ul class="bottom_last_posts">
           <?php
             while ( $loop->have_posts() ) { $loop->the_post();
           ?>
             <li>
               <a href="<?php echo get_the_permalink(); ?>">
                 <?php echo pr_img(); ?>
                 <p><?php echo the_title(); ?></p>
               </a>
            </li>
           <?php
               }
           ?>
         </ul>
      </div>

     <?php
   }?>
