<?php
/*
Theme Designed By: Hossein Esmaliyan
Email: masirwp@info.icom
Demo Website: masirwp.com
Author Website: masirwp.com
*/
   //Views
   function getPostViews( $postID ) {

      $count_key = 'post_views_count';
      $count = get_post_meta($postID, $count_key, true);

      if( $count=='' ) {
      delete_post_meta($postID, $count_key);
      add_post_meta($postID, $count_key, '0');

      return 0;
      }

      return number_format($count);
   }

   // function to count views.
   function setPostViews( $postID ) {


      $user = wp_get_current_user();

      if ( ( in_array( 'author', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) || in_array( 'editor', (array) $user->roles ) || in_array( 'contributor', (array) $user->roles ) || in_array( 'shop_manager', (array) $user->roles ) )  )
         return;

      $count_key = 'post_views_count';
      $count = get_post_meta( $postID, $count_key, true );

      if( $count == '' ) {

         $count = 0;
         delete_post_meta( $postID, $count_key );
         add_post_meta( $postID, $count_key, '0' );

      } else {

         $count++;
         update_post_meta( $postID, $count_key, $count );

      }
   }

   ?>
