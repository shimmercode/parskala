<?php
/*
Theme
Email:
Author
*/
   // Exit if accessed directly
   if (!defined('ABSPATH') ) {
      exit;
   }

   // Creating the widget
   class prk_onsale_stock_widget extends WP_Widget {

      function __construct() {

         parent::__construct(

         // Base ID of your widget
         'woocommerce-widget-layered-on_stock',

         // Widget name will appear in UI
         __('فیلتر فقط محصولات موجود prk', 'pars-kala'),

         // Widget description
         array( 'description' => __('فیلتر و نمایش فقط محصولات موجود prk', 'pars-kala'), )

         );

      }

      function get_link( $status ) {
         $base_link            = prk_shop_page_link( true );
         $link                 = remove_query_arg( 'stock_status', $base_link );
         $current_stock_status = isset( $_GET['stock_status'] ) ? explode( ',', $_GET['stock_status'] ) : array();
         $option_is_set        = in_array( $status, $current_stock_status );

         if ( ! in_array( $status, $current_stock_status ) ) {
            $current_stock_status[] = $status;
         }

         foreach ( $current_stock_status as $key => $value ) {
            if ( $option_is_set && $value === $status ) {
               unset( $current_stock_status[ $key ] );
            }
         }

         if ( $current_stock_status ) {
            asort( $current_stock_status );
            $link = add_query_arg( 'stock_status', implode( ',', $current_stock_status ), $link );
         }

         $link = str_replace( '%2C', ',', $link );
         return $link;
      }

      // Creating widget front-end
      public function widget( $args, $instance ) {

         if( is_shop() || is_product_taxonomy() ) {


            $show_instock = isset( $instance['show_instock'] ) ? $instance['show_instock'] : '';


            // before and after widget arguments are defined by themes
            echo $args['before_widget'];




            // This is where you run the code and display the output
            $current_stock_status = isset( $_GET['stock_status'] ) ? explode( ',', $_GET['stock_status'] ) : array();
         ?>

            <ul class="woocommerce-widget-layered-nav-list not_titled">


               <?php if( $show_instock ){ ?>
               <?php $this->get_link( 'instock' );
                $class_active = 'woocommerce-widget-layered-nav-list__item--chosen chosen';

               ?>
               <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term <?php echo in_array( 'instock', $current_stock_status ) ? $class_active : ''; ?>">
                  <a rel="nofollow" href="<?php echo esc_attr( $this->get_link( 'instock' ) ); ?>">
                     <?php echo $instance['text_instock']; ?>
                  </a>
               </li>
               <?php } ?>

            </ul>

         <?php
            echo $args['after_widget'];
         }

      }


      // Widget Backend
      public function form( $instance ) {

         $text_instock        = isset( $instance['text_instock'] ) ? esc_attr( $instance['text_instock'] ) : __('نمایش کالاهای موجود:', 'pars-kala');
         $show_instock = isset( $instance['show_instock'] ) ? $instance['show_instock'] : '';

         // Widget admin form
         ?>

         <p>
            <label for="<?php echo $this->get_field_id( 'text instock' ); ?>"><?php _e( 'عنوان', 'parskala' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'text_instock' ); ?>" name="<?php echo $this->get_field_name( 'text_instock' ); ?>" type="text" value="<?php echo esc_attr( $text_instock ); ?>" />
         </p>

         <p>
            <label for="<?php echo $this->get_field_id( 'show_instock' ); ?>">
            <input type="checkbox" id="<?php echo $this->get_field_id( 'show_instock' ); ?>" value="true" name="<?php echo $this->get_field_name( 'show_instock' ); ?>" <?php checked( $show_instock, 'true' ); ?> />
            <?php _e('نمایش فقط محصولات موجود', 'parskala') ?>
            </label>
         </p>

      <?php
      }

      // Updating widget replacing old instances with new
      public function update( $new_instance, $old_instance ) {

         $instance = array();
         $instance['text_instock'] = ( ! empty( $new_instance['text_instock'] ) ) ? strip_tags( $new_instance['text_instock'] ) : '';
         $instance['show_instock'] = sanitize_text_field( $new_instance['show_instock'] );
         return $instance;

      }

   }

   // Register and load the widget
   function pars_onsale_stock_load_widget() {
      register_widget( 'prk_onsale_stock_widget' );
   }
   add_action( 'widgets_init', 'pars_onsale_stock_load_widget' );
