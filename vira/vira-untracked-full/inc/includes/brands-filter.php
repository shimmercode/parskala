<?php
/*
Theme Designed By: hosein esma
packege:
Author
*/
   // Exit if accessed directly
   if (!defined('ABSPATH') ) {
      exit;
   }

	 add_filter( 'woocommerce_structured_data_product', 'prk_woocommerce_structured_data_product_offer', 10, 2 );

	 function prk_woocommerce_structured_data_product_offer( $markup, $product ) {

      $brand_slug = prk_option('product_brand_slug') ? prk_option('product_brand_slug') : 'brand';

	     $terms = get_the_terms( get_the_ID(),  $brand_slug );

	     if( !empty($terms) ) {
	         $term = array_pop($terms);

	         $markup[ $brand_slug ] = array(
	             '@type'  => $brand_slug,
	             'name'   => $term -> name,
	         );

	         return $markup;
	     }
	 }


   // Creating the widget
   class prk_brand_filter_widget extends WP_Widget {

      function __construct() {

         parent::__construct(

         // Base ID of your widget
         'woocommerce-widget-layered-nav_brand',

         // Widget name will appear in UI
         __('فیلتر بر اساس برند محصول prk', 'parskala'),

         // Widget description
         array( 'description' => __('فیلتر بر اساس برند محصول prk', 'parskala'), )

         );

      }

      //Creating widget front-end
      public function widget( $args, $instance ) {


         if( ( is_shop() || is_product_taxonomy() ) ) {

            $current_products = $this->current_products_query();


            $result_brands = $this->get_products_brands( $current_products );

            $title = apply_filters( 'widget_title', $instance['title'] );
            $show_brand_logo = isset( $instance['show_brand_logo'] ) ? $instance['show_brand_logo'] : '';

            // before and after widget arguments are defined by themes
            echo $args['before_widget'];

            if ( ! empty( $title ) )
               echo $args['before_title'] . $title . $args['after_title'];

            // This is where you run the code and display the output
            $filter_brand = isset( $_GET['filter_brand'] ) ? explode( ',', $_GET['filter_brand'] ) : array();
            ?>
            <?php $prod_brand = array();
            $brands = get_terms("brand");
            if ( !empty( $result_brands ) && !is_wp_error( $result_brands ) ){

            ?>

            <ul class="woocommerce-widget-layered-nav-list">

               <?php

               foreach ( $result_brands as $brand ) {
                  $brand = get_term( $brand );

									$meta = get_term_meta( $brand->term_id, 'filter_brand_options', true );
					        if (isset($meta['brand_image']))		$brand_image    = $meta['brand_image']['url'];
									$class_active = 'woocommerce-widget-layered-nav-list__item--chosen chosen';
                  ?>
                      <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term <?php echo in_array( $brand->term_id, $filter_brand ) ? $class_active : ''; ?>">
                        <a rel="nofollow" href="<?php echo esc_attr( $this->get_link( $brand->term_id ) ); ?>">
                        <?php
                           // echo '<img src="'.$brand_image.'" alt="'.$brand -> name.'" title="'.$brand -> name.'" class="filter-brand-logo">';

                           echo $brand->name;
                           ?>
                        </a>
                     </li>
               <?php } ?>

            </ul>

            <?php } else {
               __('برندی موجود نیست !', 'parskala');
            } ?>
         <?php
            echo $args['after_widget'];

         }

      }

      // Widget Backend
      public function form( $instance ) {

         $title        = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : __('فیلتر بر اساس برند:', 'parskala');
         $show_brand_logo = isset( $instance['show_brand_logo'] ) ? $instance['show_brand_logo'] : '';

         // Widget admin form
         ?>
         <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'عنوان', 'parskala' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
         </p>

         <!-- <p>
            <label for="<?php echo $this->get_field_id( 'show_brand_logo' ); ?>">
            <input type="checkbox" id="<?php echo $this->get_field_id( 'show_brand_logo' ); ?>" value="true" name="<?php echo $this->get_field_name( 'show_brand_logo' ); ?>" <?php checked( $show_brand_logo, 'true' ); ?> />
            <?php _e('Show brand logo', 'parskala') ?>
            </label>
         </p> -->

      <?php
      }

      // Updating widget replacing old instances with new
      public function update( $new_instance, $old_instance ) {

         $instance = array();

         $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
         $instance['show_brand_logo'] = sanitize_text_field( $new_instance['show_brand_logo'] );

         return $instance;

      }

      private function get_link( $brand_id ) {
         $base_link            = prk_shop_page_link( true );
         $link                 = remove_query_arg( 'filter_brand', $base_link );
         $current_filter_brand = isset( $_GET['filter_brand'] ) ? explode( ',', $_GET['filter_brand'] ) : array();
         $option_is_set        = in_array( $brand_id, $current_filter_brand );

         if ( ! in_array( $brand_id, $current_filter_brand ) ) {
            $current_filter_brand[] = $brand_id;
         }

         foreach ( $current_filter_brand as $key => $value ) {
            if ( $option_is_set && $value == $brand_id ) {
               unset( $current_filter_brand[ $key ] );
            }
         }

         if ( $current_filter_brand ) {
            asort( $current_filter_brand );
            $link = add_query_arg( 'filter_brand', implode( ',', $current_filter_brand ), $link );
         }

         $link = str_replace( '%2C', ',', $link );
         return $link;
      }

      private function current_products_query() {

         $brand_slug = prk_option('product_brand_slug') ? prk_option('product_brand_slug') : 'brand';
         $args = array(
            'posts_per_page' => -1,
            'post_type'      => 'product',
            'tax_query'      => array(
               array(
                  'taxonomy' => $brand_slug,
                  'operator' => 'EXISTS',
               ),
            ),
            'fields'         => 'ids',
         );

         $cat = get_queried_object();
         if ( is_a( $cat, 'WP_Term' ) ) {
            $cat_id              = $cat->term_id;
            $cat_id_array        = get_term_children( $cat_id, $cat->taxonomy );
            $cat_id_array[]      = $cat_id;
            $args['tax_query'][] = array(
               'taxonomy' => $cat->taxonomy,
               'field'    => 'term_id',
               'terms'    => $cat_id_array,
            );
         }


            $args['meta_query'] = array(
               array(
                  'key'     => '_stock_status',
                  'value'   => 'outofstock',
                  'compare' => 'NOT IN',
               ),
            );


         $wp_query = new WP_Query( $args );
         wp_reset_postdata();

         return $wp_query->posts;
      }

      private function get_products_brands( $product_ids ) {

         $brand_slug = prk_option('product_brand_slug') ? prk_option('product_brand_slug') : 'brand';
         $brand_taxonomy =  $brand_slug;
         $product_ids = implode( ',', array_map( 'intval', $product_ids ) );

         global $wpdb;
         if(!empty($product_ids)){
            $brand_ids = $wpdb->get_col(
               "SELECT DISTINCT t.term_id
               FROM {$wpdb->prefix}terms AS t
               INNER JOIN {$wpdb->prefix}term_taxonomy AS tt
               ON t.term_id = tt.term_id
               INNER JOIN {$wpdb->prefix}term_relationships AS tr
               ON tr.term_taxonomy_id = tt.term_taxonomy_id
               WHERE tt.taxonomy = '$brand_taxonomy'
               AND tr.object_id IN ($product_ids)
            "
            );

         }

         return !empty( $brand_ids ) ? $brand_ids : false;


      }

   }

   // Register and load the widget
   function pars_brand_filter_load_widget() {
      register_widget( 'prk_brand_filter_widget' );
   }
   add_action( 'widgets_init', 'pars_brand_filter_load_widget' );
