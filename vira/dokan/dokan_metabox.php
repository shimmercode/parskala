<?php

/*

* اضافه کردن یوزمتای اختصاصی به فروشنده های دکان

*/

add_action( 'dokan_seller_meta_fields', 'my_show_extra_profile_fields' );
function my_show_extra_profile_fields( $user ) { ?>

<?php if ( ! current_user_can( 'manage_woocommerce' ) ) {
        return;
  }
  if ( ! user_can( $user, 'dokandar' ) ) {
        return;
  }
    // امتیازات فروشنده
    $vendor_id = get_post_field( 'post_author', get_the_id() );
    $vendor = new WP_User($vendor_id);
    $store_info  = dokan_get_store_info( $vendor_id );
    $store_name  = $store_info['store_name'];

    $stills_types = get_user_meta( $user->ID, 'stills_types', true );
  	$consent = ! empty( get_user_meta( $user->ID, 'dokan_consent', true ) ) ? get_user_meta( $user->ID, 'dokan_consent', true ) : 96;
    $supply = ! empty( get_user_meta( $user->ID, 'dokan_supply', true ) ) ? get_user_meta( $user->ID, 'dokan_supply', true ) : 89;
    $Commitmentـsend = ! empty( get_user_meta( $user->ID, 'dokan_Commitment', true ) ) ? get_user_meta( $user->ID, 'dokan_Commitment', true ) : 91;
    $Noـreference = ! empty( get_user_meta( $user->ID, 'dokan_reference', true ) ) ? get_user_meta( $user->ID, 'dokan_reference', true ) : 87;

    $text_sends = ! empty( get_user_meta( $user->ID, 'dokan_text_sends', true ) ) ? get_user_meta( $user->ID, 'dokan_text_sends', true ) :'این کالا در انبار '.$store_name.' موجود و آماده پردازش است و توسط پیک '.$store_name.' در بازه انتخابی ارسال خواهد شد.';
 ?>
     <!-- رضایت کالا -->
     <tr>
        <th><?php esc_html_e( 'رضایت کالا', 'vira' ); ?></th>
          <td>
            <input type="number" name="consent" max="100" class="regular-text" value="<?php echo esc_attr($consent); ?>"/>
            <p class="description"><?php esc_html_e( 'از ۱ تا ۱۰۰ یک امتیاز درج کنید.', 'vira' ); ?></p>
          </td>
     </tr>

     <!--تامین به موقع -->
     <tr>
        <th><?php esc_html_e( 'تامین به موقع ', 'vira' ); ?></th>
          <td>
            <input type="number" name="supply" max="100" class="regular-text" value="<?php echo esc_attr($supply); ?>"/>
            <p class="description"><?php esc_html_e( 'از ۱ تا ۱۰۰ یک امتیاز درج کنید.', 'vira' ); ?></p>
          </td>
     </tr>

     <!-- تعهد ارسال -->
     <tr>
        <th><?php esc_html_e( 'تعهد ارسال', 'vira' ); ?></th>
          <td>
            <input type="number" name="Commitment" max="100" class="regular-text" value="<?php echo esc_attr($Commitmentـsend); ?>"/>
            <p class="description"><?php esc_html_e( 'از ۱ تا ۱۰۰ یک امتیاز درج کنید.', 'vira' ); ?></p>
          </td>
     </tr>

     <!-- بدون مرجوعی -->
     <tr>
        <th><?php esc_html_e( 'بدون مرجوعی', 'vira' ); ?></th>
          <td>
            <input type="number" name="reference" max="100" class="regular-text" value="<?php echo esc_attr($Noـreference); ?>"/>
            <p class="description"><?php esc_html_e( 'از ۱ تا ۱۰۰ یک امتیاز درج کنید.', 'vira' ); ?></p>
          </td>
     </tr>

     <!-- عملکرد فروشنده -->
     <tr>
       <th><?php esc_html_e( 'عملکرد فروشنده', 'vira' ); ?></th>
        <td>
          <select id="stills_types" name="stills_types">
              <?php foreach ( dokan_stills_types() as $key => $value ) : ?>
                <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $stills_types, $key ); ?>> <?php echo esc_attr( $value ); ?></option>
              <?php endforeach; ?>
          </select>
          <p class="description"><?php esc_html_e( 'عملکرد فروشنده را تعیین کنید', 'vira' ); ?></p>
       </td>
    </tr>

    <!-- متن ارسال فروشنده -->
    <tr>
       <th><?php esc_html_e( 'متن ارسال فروشنده ', 'vira' ); ?></th>
         <td>
           <textarea rows="5" cols="30" name="textsender" class="regular-text"><?php echo esc_attr($text_sends); ?></textarea>
             <p class="description"><?php esc_html_e( 'متن ارسال فروشنده را درج کنید.', 'vira' ); ?></p>
         </td>
    </tr>
  <?php
 }


// my_save_extra_profile_fields
add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update','my_save_extra_profile_fields' );
function my_save_extra_profile_fields( $user_id ) {

if ( ! current_user_can( 'manage_woocommerce' ) ) {
        return;
  }

update_usermeta( $user_id, 'dokan_consent', $_POST['consent'] );
update_usermeta( $user_id, 'dokan_supply', $_POST['supply'] );
update_usermeta( $user_id, 'stills_types', $_POST['stills_types'] );

update_usermeta( $user_id, 'dokan_Commitment', $_POST['Commitment'] );
update_usermeta( $user_id, 'dokan_reference', $_POST['reference'] );
update_usermeta( $user_id, 'dokan_text_sends', $_POST['textsender'] );
}


// stills options

function dokan_stills_types() {
    return apply_filters(
        'dokan_stills_types', [
            'great'       => __( 'عالی', 'vira' ),
            'very_good' => __( 'خیلی خوب', 'vira' ),
            'good' => __( 'خوب', 'vira' ),
            'medium' => __( 'متوسط', 'vira' ),
            'baad' => __( 'ضعیف', 'vira' ),
        ]
    );
}
