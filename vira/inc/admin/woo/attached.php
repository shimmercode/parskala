<?php


 /*
   ================================
        Post Thumbnails Support
   ================================
*/
add_theme_support( 'post-thumbnails' );
add_image_size( 'blog-size', 460, 460, true );
add_image_size( 'img-logo', 200, 100, true );

if ( prk_option( 'custom_post_thumb' ) ) {
    $width = prk_option( 'post_thumb_width' );
    $height = prk_option( 'post_thumb_height' );
    add_image_size('dpost_thumbnail', $width, $height, true);
}

function prk_po_img(){

    if ( has_post_thumbnail() ) {
        if( prk_option( 'custom_post_thumb' ) ) {
            the_post_thumbnail('dpost_thumbnail');
        } else {
            the_post_thumbnail('woocommerce_thumbnail');
        }
    } else {
        prod_defualt_thumb();
    }

}
function prk_img_full_size(){

  if ( has_post_thumbnail() ) {
     the_post_thumbnail();
  } else {
      prod_defualt_thumb();
  }

}



// include mobile function
if ( prk_option('prk_modern_mobile') && mobile_cheker() || tablet_cheker() ) {

  require_once get_theme_file_path( '/inc/includes/mobile-functions.php' );
  
}


add_action( 'init','prk_add_search_mobile_page');
function prk_add_search_mobile_page(){

    $post_title = 'جستجو';
    $post_id    = post_exists( $post_title );
    $post_content = '[prk_search_mobile]';

    if( !$post_id && prk_option('modern_mobile_toolbar') == '1' ){
        $data = array(
           'post_type'   => 'page',
           'post_title'  => $post_title,
           'post_name' => 'search',
           'post_content' => $post_content, 
           'post_status' => 'publish',
           'post_author'  => get_current_user_id(),
        );
        $post_id = wp_insert_post( $data );
  
  }

}

add_filter( 'woocommerce_account_menu_items', 'rename_menu_items' );
function rename_menu_items( $items ) {

    $items['customer-logout']    = 'خروج';

    return $items;
}


/*
   ================================
        Woocommerce Support
   ================================
*/

function prk_woocommerce_support() {
  add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

add_action( 'after_setup_theme', 'prk_woocommerce_support' );

function remove_image_zoom_support() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'after_setup_theme', 'remove_image_zoom_support', 100 );

//Remove woocommerce_sale_flash completely
add_action('woocommerce_sale_flash', 'woo_custom_hide_sales_flash');
function woo_custom_hide_sales_flash(){
  return false;
}


  /* woo ok */
  remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
  // add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 26 );
  remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
  remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
  add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 20 );
  remove_action('woocommerce_single_product_summary','woocommerce_template_single_rating',10);



add_filter( 'woocommerce_product_tabs', 'wpkomak_rename_tabs', 98 );
	     function wpkomak_rename_tabs( $tabs ) {

	     $tabs['additional_information']['title'] = __( 'توضیحات تکمیلی' );
	     return $tabs;

	    }

// Register prk_taxonomy_brand
add_action( 'init', 'prk_taxonomy_brand',0 );
function prk_taxonomy_brand()  {

$brand_slug = prk_option('product_brand_slug') ? prk_option('product_brand_slug') : 'brand';

$labels = array(
    'name'                       => __(prk_option('product_brand_name')?prk_option('product_brand_name'):'برند', 'parskala'),
    'singular_name'              => __( $brand_slug , 'parskala'),
    'menu_name'                  => __('برند محصول', 'parskala'),
    'all_items'                  => __('برند ها', 'parskala'),
    'parent_item'                => __('Parent brand', 'parskala'),
    'parent_item_colon'          => __('Parent brand', 'parskala'),
    'new_item_name'              => __('برند جدید', 'parskala'),
    'add_new_item'               => __('افزودن برند', 'parskala'),
    'edit_item'                  => __('ویرایش برند', 'parskala'),
    'update_item'                => __('بروز رسانی برند', 'parskala'),
    'separate_items_with_commas' => __('Separate brands with commas', 'parskala'),
    'search_items'               => __('جستجو', 'parskala'),
    'add_or_remove_items'        => __('حدف همه', 'parskala'),

    'choose_from_most_used'      => __('Choose from most used brand', 'parskala'),
);


$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
    'query_var'                  => true,
	  'rewrite'                    => array( 'slug' => $brand_slug ),
    
    // 📌 فعال‌سازی REST API
    'show_in_rest'               => true,
    'rest_base'                  => $brand_slug,
    'rest_controller_class'      => 'WP_REST_Terms_Controller',
    
);
register_taxonomy( $brand_slug , 'product', $args );

register_taxonomy_for_object_type( $brand_slug , 'product' );
}



add_filter( 'woocommerce_product_data_tabs', 'add_my_custom_product_data_tabs1' );
function add_my_custom_product_data_tabs1( $product_data_tabs ) {
	$product_data_tabs['my-custom-tab'] = array(
		'label' => __( 'متفرقه', 'my_text_domain' ),
		'target' => 'my_customs_product_data',
	);
	return $product_data_tabs;
}

add_action( 'woocommerce_product_data_panels', 'add_my_customs_product_data_fields1' );
function add_my_customs_product_data_fields1() {
	global $woocommerce, $post;

  $product_id = $post->ID;
	?>
	<!-- id below must match target registered in above add_my_custom_product_data_tab function -->
	<div id="my_customs_product_data" class="panel woocommerce_options_panel">
		<?php
    // پیشنهادات شگفت انگیز
    woocommerce_wp_checkbox( array(
      'id'            => 'onsales_round',
      'label'         => __( 'پیشنهادات شگفت انگیز', 'my_text_domain' ),
      'description'   => __( 'درصورت فعال سازی این گزینه محصول به لیست محصولات شگفت انگیز اضافه میشود', 'my_text_domain' ),
      'desc_tip'    	=> false,
    ) );

    // محصول غیر اصل
		woocommerce_wp_checkbox( array(
      'class'            => 'checkbox product_facke_brand_show',
			'id'            => 'product_facke_brand_show',
			'label'         => __( 'محصول غیر اصل', 'my_text_domain' ),
      'description'   => __( 'بله', 'my_text_domain' ),
			'desc_tip'    	=> false,
		) );
    woocommerce_wp_text_input( array(
      'class'         => 'product_facke_brand_text',
      'id'            => 'product_facke_brand_text',
      'label'         => __( 'متن محصول غیر اصل', 'my_text_domain' ),
      'description'   => __( 'متن محصول غیر اصل', 'my_text_domain' ),
      'value'       => product_facke_value(),
      'desc_tip'    	=> true,
    ) );



    // امکان بازگشت محصول
    woocommerce_wp_checkbox( array(
      'class' => 'checkbox',
      'id'            => 'special_send_box_single',
      'label'         => __( 'حذف سکشن شرایط ارسال کالا', 'my_text_domain' ),
      'cbvalue'  		=> 'yes',
      'desc_tip'    	=> true,
    ) );
    // امکان بازگشت محصول
    woocommerce_wp_checkbox( array(
      'class' => 'checkbox product_return_show',
      'id'            => 'product_return_show',
      'label'         => __( 'امکان بازگشت محصول', 'my_text_domain' ),
      'description'   => __( 'محصول امکان بازگشت', 'my_text_domain' ),
      'desc_tip'    	=> true,
    ) );
    woocommerce_wp_text_input( array(
      'class' => 'product_return_text',
      'id'            => 'product_return_text',
      'label'         => __( 'متن امکان بازگشت محصول', 'my_text_domain' ),
      'description'   => __( 'متن امکان بازگشت محصول را تنظیم کنید.', 'my_text_domain' ),
      'cbvalue'       => __( 'مکان برگشت کالا در گروه ساعت هوشمند با دلیل "انصراف از خرید" تنها در صورتی مورد قبول است که پلمب کالا باز نشده باشد.', 'my_text_domain' ),
      'desc_tip'    	=> true,
      'value'         =>  product_return_value(),
      'type'              => 'text',
    ) );

   // گارانتی محصول
   if(general_granty_show())
    woocommerce_wp_checkbox( array(
      'class'            => 'checkbox product_granti_show',
      'id'            => 'product_granti_show',
      'label'         => __( 'فاقد گارانتی', 'my_text_domain' ),
      'description'   => __( 'حذف گارانتی برای این محصول ؟', 'my_text_domain' ),
      'desc_tip'    	=> false,
    ) );
     if(general_granty_show())
    woocommerce_wp_text_input( array(
      'class'            => 'product_granti_text',
      'id'            => 'product_granti_text',
      'label'         => __( 'متن گارانتی محصول', 'my_text_domain' ),
      'description'   => __( 'در صورت خالی گذاشتن گارانتی پیشفرض نمایش داده میشود.', 'my_text_domain' ),
      'desc_tip'    	=> true,
      'value'         => general_granty_value(),
    ) );

    // ضمانت اصالت محصول
    if(general_orginal_show())
    woocommerce_wp_checkbox( array(
      'class'            => 'checkbox product_Original_show',
      'id'            => 'product_Original_show',
      'label'         => __( 'فاقد ضمانت محصول', 'my_text_domain' ),
      'description'   => __( 'حذف ضمانت کالا برای این محصول ؟', 'my_text_domain' ),
      'desc_tip'    	=> false,
    ) );
    if(general_orginal_show())
    woocommerce_wp_text_input( array(
      'class'            => 'product_Original_text',
      'id'            => 'product_Original_text',
      'label'         => __( 'متن ضمانت اصالت محصول', 'my_text_domain' ),
      'description'   => __( 'در صورت خالی گذاشتن متن پیشفرض ضمانت اصالت نمایش داده میشود.', 'my_text_domain' ),
      'desc_tip'    	=> true,
      'value'         => general_orginal_value(),
    ) );

    // هشدار سامانه همتا
    woocommerce_wp_checkbox( array(
      'class'            => 'checkbox product_hamta_show',
      'id'            => 'product_hamta_show',
      'label'         => __( 'هشدار سامانه همتا', 'my_text_domain' ),
      'description'   => __( 'پیام هشدار سامانه همتا قابل تنظیم در تنظیمات پوسته', 'my_text_domain' ),
      'desc_tip'    	=> true,
    ) );
    woocommerce_wp_textarea_input( array(
      'class'            => 'product_hamta_text',
      'id'            => 'product_hamta_text',
      'label'         => __( 'متن هشدار سامانه همتا', 'my_text_domain' ),
      'description'   => __( 'متن هشدار سامانه همتا', 'my_text_domain' ),
      'desc_tip'    	=> true,
      'value'         => general_hamta_value(),
    ) );


    woocommerce_wp_text_input( array(
        'id'                => 'progress_sales',
        'label'             => __( 'درصد فروش رفته', 'woocommerce' ),
        'placeholder'       => 'رقم درصد را وارد کنید',
    ) );
    woocommerce_wp_text_input( array(
        'id'                => 'prk_add_to_cart_label',
        'label'             => __( 'متن دکمه افزودن به سبد خرید', 'woocommerce' ),
    ) );
    woocommerce_wp_text_input( array(
        'id'                => 'prk_product_label',
        'label'             => __( 'لیبل سفارشی', 'woocommerce' ),
    ) );
		?>
    <script>



    jQuery(function($){

        // باز شدن آپلود مدیا و درج در فیلد تصویر دوم شاخص محصول
        $('body').on('click', '.aw_img_up_pro', function(e){
            e.preventDefault();

            var button = $(this),
            aw_uploader = wp.media({
                title: 'انتخاب',
                library : {
                    uploadedTo : wp.media.view.settings.post.id,
                    type : ''
                },
                button: {
                    text: 'درج'
                },
                multiple: false
            }).on('select', function() {
                var attachment = aw_uploader.state().get('selection').first().toJSON();
                $('#img_up_pro').val(attachment.url);
            })
            .open();
        });

          // چک باکس محصول غیر اصل
          if($('#product_facke_brand_show').is(":checked")) {
              $(".product_facke_brand_text_field").show();
          }else{
              $(".product_facke_brand_text_field").hide();
          }
          // SHOW/HIDE ELEMENTS VIA CHECKBOX STATUS
          $('[id="product_facke_brand_show"]').change(function()
          {
            if ($(this).is(':checked'))
                $(".product_facke_brand_text_field").fadeIn();
            else
                $(".product_facke_brand_text_field").fadeOut();
          });

          // چک باکس بازگشت محصول
          if($('#product_return_show').is(":checked")) {
              $(".product_return_text_field").show();
          }else{
              $(".product_return_text_field").hide();
          }
          // SHOW/HIDE ELEMENTS VIA CHECKBOX STATUS
          $('[id="product_return_show"]').change(function()
          {
            if ($(this).is(':checked'))
                $(".product_return_text_field").fadeIn();
            else
                $(".product_return_text_field").fadeOut();
          });

            // چک باکس گارانتی محصول
            if($('#product_granti_show').is(":checked")) {
                $(".product_granti_text_field").hide();
            }else{
                $(".product_granti_text_field").show();
            }
            // SHOW/HIDE ELEMENTS VIA CHECKBOX STATUS
            $('[id="product_granti_show"]').change(function()
            {
              if ($(this).is(':checked'))
                  $(".product_granti_text_field").fadeOut();
              else
                  $(".product_granti_text_field").fadeIn();
            });

              // چک باکس اصالت محصول
              if($('#product_Original_show').is(":checked")) {
                  $(".product_Original_text_field").hide();
              }else{
                  $(".product_Original_text_field").show();
              }
              // SHOW/HIDE ELEMENTS VIA CHECKBOX STATUS
              $('[id="product_Original_show"]').change(function()
              {
                if ($(this).is(':checked'))
                    $(".product_Original_text_field").fadeOut();
                else
                    $(".product_Original_text_field").fadeIn();
              });

              // چک باکس سامانه همتا
              if($('#product_hamta_show').is(":checked")) {
                  $(".product_hamta_text_field").show();
              }else{
                  $(".product_hamta_text_field").hide();
              }
              // SHOW/HIDE ELEMENTS VIA CHECKBOX STATUS
              $('[id="product_hamta_show"]').change(function()
              {
                if ($(this).is(':checked'))
                    $(".product_hamta_text_field").fadeIn();
                else
                    $(".product_hamta_text_field").fadeOut();
              });

    });

    </script>
	</div>
	<?php
}

// متن پیشفرض محصول غیر اصل
function product_facke_value() {

    $def_date = '';
    if (empty(get_post_meta(get_the_ID(), 'product_facke_brand_text', true ))) {
       $def_date = 'این محصول به وسیله تولید کننده اصلی(برند) تولید نشده است.';
    }else {
       $def_date = get_post_meta(get_the_ID(), 'product_facke_brand_text', true );
    }
    return $def_date;

}

// متن پیشفرض امکان بازگشت
function product_return_value() {

    $def_date = '';
    if (empty(get_post_meta(get_the_ID(), 'product_return_text', true ))) {
       $def_date = 'امکان برگشت کالا با دلیل "انصراف از خرید" تنها در صورتی مورد قبول است که پلمب کالا باز نشده باشد.';
    }else {
       $def_date = get_post_meta(get_the_ID(), 'product_return_text', true );
    }
    return $def_date;

}

// متن پیشفرض گارانتی محصول
function general_granty_value() {

    $granty_value = '';
    $general_granty = prk_option('single_texts_Warrantyss');
    if ( empty( get_post_meta(get_the_ID(), 'product_granti_text', true) ) ) {
       $granty_value = $general_granty;
    }elseif( !empty( get_post_meta(get_the_ID(), 'product_granti_text', true) ) ){
       $granty_value = get_post_meta(get_the_ID(), 'product_granti_text', true );
    }else {
      $granty_value = '';
    }
    return $granty_value;

}

// متن پیشفرض ضمانت محصول
function general_orginal_value() {

    $orginal_value = '';
    $general_orginal = prk_option('single_product_bail_text');
    if (empty(get_post_meta(get_the_ID(), 'product_Original_text', true ))) {
       $orginal_value = $general_orginal;
    }else{
       $orginal_value = get_post_meta(get_the_ID(), 'product_Original_text', true );
    }
    return $orginal_value;

}

// متن پیشفرض هشدار سامانه همتا
function general_hamta_value() {

    $hamta_value = '';
    $general_hamta = prk_option('single_hamta_text');
    if (empty(get_post_meta(get_the_ID(), 'product_hamta_text', true ))) {
       $hamta_value = $general_hamta;
    }else{
       $hamta_value = get_post_meta(get_the_ID(), 'product_hamta_text', true );
    }
    return $hamta_value;

}

add_action( 'woocommerce_admin_process_product_object', 'my_admin_process_product_object' );
function my_admin_process_product_object( $product ) {

  // defualt
  update_post_meta($product->get_id(), 'product_facke_brand_show', 'no' );
  update_post_meta($product->get_id(), 'product_return_show', 'no' );
  update_post_meta($product->get_id(), 'special_send_box_single', 'no' );
  update_post_meta($product->get_id(), 'product_granti_show', 'no' );
  update_post_meta($product->get_id(), 'product_Original_show', 'no' );
  update_post_meta($product->get_id(), 'onsales_round', 'no' );
  update_post_meta($product->get_id(), 'product_hamta_show', 'no' );
  
    // ذخیره فیلد محصول غیر اصل
    if( isset ($_POST['product_facke_brand_show']) )
    update_post_meta($product->get_id(), 'product_facke_brand_show',  wc_clean( wp_unslash( $_POST['product_facke_brand_show'] ) ) );

    if( isset ($_POST['product_facke_brand_text']) )
    update_post_meta($product->get_id(), 'product_facke_brand_text',  wc_clean( wp_unslash( $_POST['product_facke_brand_text'] ) ) );

    // ذخیره فیلد امکان بازگشت
    if( isset ($_POST['product_return_show']) )
    update_post_meta($product->get_id(), 'product_return_show',  wc_clean( wp_unslash( $_POST['product_return_show'] ) ) );
    if( isset ($_POST['product_return_text']) )
    update_post_meta($product->get_id(), 'product_return_text',  wc_clean( wp_unslash( $_POST['product_return_text'] ) ) );

    // ذخیره فیلد گارانتی محصول
    if( isset ($_POST['product_granti_show']) )
    update_post_meta($product->get_id(), 'product_granti_show',  wc_clean( wp_unslash( $_POST['product_granti_show'] ) ) );

    if( isset ($_POST['product_granti_text']) )
    update_post_meta($product->get_id(), 'product_granti_text',  wc_clean( wp_unslash( $_POST['product_granti_text'] ) ) );

    // ذخیره فیلد اصالت محصول
    if( isset ($_POST['product_Original_show']) )
    update_post_meta($product->get_id(), 'product_Original_show',  wc_clean( wp_unslash( $_POST['product_Original_show'] ) ) );
    if( isset ($_POST['product_Original_text']) )
    update_post_meta($product->get_id(), 'product_Original_text',  wc_clean( wp_unslash( $_POST['product_Original_text'] ) ) );

    // ذخیره فیلد سامانه همتا
    if( isset ($_POST['product_hamta_show']) )
    update_post_meta($product->get_id(), 'product_hamta_show',  wc_clean( wp_unslash( $_POST['product_hamta_show'] ) ) );
    if( isset ($_POST['product_hamta_text']) )
    update_post_meta($product->get_id(), 'product_hamta_text',  wc_clean( wp_unslash( $_POST['product_hamta_text'] ) ) );

    // ذخیره شرایط ارسال کالا
    if( isset ($_POST['special_send_box_single']) )
    update_post_meta($product->get_id(), 'special_send_box_single',  wc_clean( wp_unslash( $_POST['special_send_box_single'] ) ) );

    // ذخیره فیلد تصویر دوم شاخص محصول
    if( isset ($_POST['img_up_pro']) )
    update_post_meta($product->get_id(), 'img_up_pro',  wc_clean( wp_unslash( $_POST['img_up_pro'] ) ) );

    // ذخیره فیلد فیلدهای تاریخ ارسال پیشنهاد شگفت انگیز و درصد فروش رفته
    if( isset ($_POST['onsales_round']) )
    update_post_meta($product->get_id(), 'onsales_round',  wc_clean( wp_unslash( $_POST['onsales_round'] ) ) );
    if( isset ($_POST['progress_sales']) )
    update_post_meta($product->get_id(), 'progress_sales',  wc_clean( wp_unslash( $_POST['progress_sales'] ) ) );

   //افزودن به سبد خرید
   if( isset ($_POST['prk_add_to_cart_label']) )
   update_post_meta($product->get_id(), 'prk_add_to_cart_label',  wc_clean( wp_unslash( $_POST['prk_add_to_cart_label'] ) ) );

   //لیبل سفارشی
   if( isset ($_POST['prk_product_label']) )
   update_post_meta($product->get_id(), 'prk_product_label',  wc_clean( wp_unslash( $_POST['prk_product_label'] ) ) );
}

if ( prk_option('cattributes_product_tabs') == 1 ) {
  add_filter( 'woocommerce_product_tabs', 'additional_information_remove_product_tabs', 9999 );
  add_filter( 'woocommerce_product_tabs', 'woo_cattributes_product_tabs' );
}


// حذف مشخصات درصورت نیاز
function additional_information_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );
    return $tabs;
}


function woo_cattributes_product_tabs( $tabs ) {
  $title_cattributes_tab = prk_option('title_cattributes_product_tabs') ? prk_option('title_cattributes_product_tabs') : __('Specifications','parskala');

    // Adds the cattributes products tab
    $tabs['cattributes_products_tab'] = array(
        'title'     => __( $title_cattributes_tab, 'woocommerce' ),
        'priority'  => 10,
        'callback'  => 'woo_cattributes_products_tab_content'
    );

    return $tabs;
}

// add cattributes Tab contents

function woo_cattributes_products_tab_content() {

  $p_featured_attributes = get_post_meta( get_the_ID(), 'prk_product_featured_attributes', true );
  if ($p_featured_attributes) {
  ?>
  <table class="woocommerce-product-attributes shop_attributes">
    <tbody>

      <?php foreach ($p_featured_attributes as $value): ?>
        <tr class="woocommerce-product-attributes-item">
      		<th class="woocommerce-product-attributes-item__label"><?php echo $value['title'];?></th>
      		<td class="woocommerce-product-attributes-item__value"><p><?php echo $value['value'];?></p></td>
      	</tr>
      <?php endforeach; ?>

    </tbody>
  </table>
  <?php
  }
}

// فرخوانی اکشن ها در استایل های مختلف --- سبک پارس کالا و پارس پلاس
add_action('init', 'parskala_theme_filter_set');
function parskala_theme_filter_set(){
    if  ( empty(prk_option( 'theme-style' ) == 'digikala') ){
      add_filter( 'woocommerce_add_to_cart_fragments', 'prk_products_cart_ajax_ver2' );
    }
}

// فرخوانی اکشن ها در استایل های مختلف --- سبک دیحی کالا
add_action('init', 'digikala_theme_filter_set');
function digikala_theme_filter_set(){
    if  ( prk_option( 'theme-style' ) == 'digikala'){
        add_filter( 'woocommerce_add_to_cart_fragments', 'prk_products_cart_ajax' );
    }
}



// تغییر ایجکسی تعداد محصول سبد خرید
add_filter( 'woocommerce_add_to_cart_fragments', 'prk_cart_count_fragments_ver2', 10, 1 );
function prk_cart_count_fragments_ver2( $fragments ) {
   $carter = WC()->cart->is_empty();
   if (! $carter ) {
     $classes = 'em-plus';
   }

	$fragments['em.mini_cart_counter'] = '<em class="mini_cart_counter '.$classes.'">' . WC()->cart->get_cart_contents_count() . '</em>';
	return $fragments;
}

// تغییر ایجکسی تعداد محصول سبد خرید
add_filter( 'woocommerce_add_to_cart_fragments', 'prk_cart_count_fragments_pluser', 10, 1 );
function prk_cart_count_fragments_pluser( $fragments ) {
   $carter = WC()->cart->is_empty();
   if (! $carter ) {
     $classes = 'pluser';
   }

	$fragments['span.cart-count'] = '<span class="cart-count '.$classes.'"></span>';
	return $fragments;
}


/*
   ========================================
        Show cart contents Ajaxify digikala style
   ========================================
*/

function prk_products_cart_ajax( $fragments ) {

	ob_start();
	?>

  <span class="cart-btn">
    <i class="shopping-cart"></i>
    <em class="mini_cart_counter"><?php PRK_cart_count(); ?></em>
    <div class="mini-cart-user">

      <span class="head-mini">
        <i class="count-mini"><?php PRK_cart_count(); ?> محصولات</i>
        <a class="cart-mini" href="<?php echo wc_get_cart_url(); ?>"><?php _e('View cart' , 'parskala');?><i class="ri-arrow-drop-left-line"></i></a>
      </span>
      <?php echo woocommerce_mini_cart();?>

    </div>
  </span>
	<?php
	$fragments['.cart-btn'] = ob_get_clean();
	return $fragments;
}


/*
   ========================================
        Show cart contents Ajaxify parskala style
   ========================================
*/

function prk_products_cart_ajax_ver2( $fragments ) {
	ob_start();
  ?>

  <div class="prk-carts">

    <div class="header-carter">

      <button class="close-box cart_modal"></button>
      <span><?php _e('You have selected these products', 'parskala'); ?><em class="em-plus"><?php PRK_cart_count(); ?></em></span>

    </div>

      <div class="main-cart">
        <?php echo woocommerce_mini_cart();?>
      </div>

  </div>
<script>
// close mini cart modal
jQuery(".close-box.cart_modal").on("click", function () {

  jQuery("#cart_content_modal").removeClass("toggle");
  jQuery(".prk_open_mini_cart").removeClass("close");
  jQuery("html").removeClass("inner_hidden");
  jQuery(".navigation-overlay").fadeOut(100);

});

</script>
	<?php $fragments['div.prk-carts'] = ob_get_clean();
  	return $fragments;

}











//add postmeta recommended
add_action( 'comment_post', 'add_postmeta_recommended', 99, 2);
function add_postmeta_recommended($comment_id, $comment_object){
  $comment = get_comment( $comment_id );
  $comment_post_id = $comment->comment_post_ID ;
  $recommend = get_comment_meta( $comment_id, 'recommend', true );
  if($recommend == 'recommended'){
    $count = get_post_meta($comment_post_id , 'count_recommended', true);
    if(empty($count)){
      update_post_meta($comment_post_id, 'count_recommended', 1);
    }else{
      $count++;
      update_post_meta($comment_post_id, 'count_recommended', $count);
    }
  }
};

add_filter('woocommerce_available_variation', function($available_variations, \WC_Product_Variable $variable, \WC_Product_Variation $variation) {
    $available_variations['price_html'] = '<span class="cart-pro price">' .$variation->get_price_html() . '</span>';
    return $available_variations;
}, 10, 3);


  // جابجایی سکشن محصولات مربتط در دموهای قالب
  add_action('init', 'display_related_filter_set');
  function display_related_filter_set(){
      if  ( empty(prk_option( 'theme-style' ) == 'prk-fashion' ) && prk_option('show_related') == '9' ){
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
        add_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 9);
      }
  }



  // Ordering products based on the selected values
  function filter_woocommerce_get_catalog_ordering_args( $args, $orderby, $order ) {
      switch( $orderby ) {
          case 'availability':
              $args['orderby']  = 'meta_value_num';
              $args['order']    = 'DESC';
              $args['meta_key'] = '_stock';
              break;
      }

      return $args;
  }
  add_filter( 'woocommerce_get_catalog_ordering_args', 'filter_woocommerce_get_catalog_ordering_args', 10, 3 );

  // Orderby setting
  function filter_orderby( $orderby ) {
      $orderby['availability'] = __( 'محصولات موجود', 'woocommerce' );
      return $orderby;
  }
  add_filter( 'woocommerce_default_catalog_orderby_options', 'filter_orderby', 10, 1 );
  add_filter( 'woocommerce_catalog_orderby', 'filter_orderby', 10, 1 );


  // فیلد سفارشی کد ملی
    add_filter('woocommerce_checkout_fields', 'custom_woocommerce_billing_fields', 1.1);
    add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 1, 1 );

    add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );
  
    function custom_woocommerce_billing_fields($fields)
    {
      if ( prk_option('opti_checkout_ncode') == '1' ) {
        $required_class = true;
      }else {
        $required_class = false;
      }
        $fields['billing']['billing_ncode'] = array(
            'label' =>'کد ملی',
            'placeholder' =>'کد ملی',
            'required' => $required_class,
            'clear' => false,
            'type' => 'number',

        );

        return $fields;
    }


if(prk_option('opti_checkout_ncode')== '1'){
add_action('woocommerce_checkout_process', 'wh_phoneValidateCheckoutFields');
}

    function wh_phoneValidateCheckoutFields() {
        $billing_ncode = filter_input(INPUT_POST, 'billing_ncode');

     if(!preg_match('/^[0-9]{10}$/',$billing_ncode))
            wc_add_notice(__('  کدملی وارد شده کمتر از ده رقم می‌باشد, لطفا کد ملی را صحیح وارد نمایید '), 'error');

        for($i=0;$i<10;$i++)
            if(preg_match('/^'.$i.'{10}$/',$billing_ncode))
           wc_add_notice(__('  کدملی نامعتبر میباشد , لطفا کد ملی را صحیح وارد نمایید .'), 'error');
        for($i=0,$sum=0;$i<9;$i++)
            $sum+=((10-$i)*intval(substr($billing_ncode, $i,1)));
        $ret=$sum%11;
        $parity=intval(substr($billing_ncode, 9,1));
        if(($ret<2 && $ret==$parity) || ($ret>=2 && $ret==11-$parity))
            return true;
           wc_add_notice(__(' کدملی نامعتبر میباشد , لطفا کد ملی را صحیح وارد نمایید .'), 'error');

    }


    function my_custom_checkout_field_update_order_meta( $order_id ) {
        if ( ! empty( $_POST['billing_ncode'] ) ) {
            update_post_meta( $order_id, 'billing_ncode', sanitize_text_field( $_POST['billing_ncode'] ) );
        }
    }




    function my_custom_checkout_field_display_admin_order_meta($order){
      $ncode_meta = prk_option('prk_ncode_factor_meta');
      if (get_post_meta( $order->get_id(), $ncode_meta, true ) && prk_option('prk_billing_ncode_factor')) {
        echo '<p><strong>'.__('کد ملی').':</strong> <br/>' . get_post_meta( $order->get_id(), $ncode_meta, true ) . '</p>';
      }
    }

    //code melli


// اضافه کردن کلاس سفارشی به تابع نمایش قیمت در ووکامرس

add_filter( 'woocommerce_get_price_html', 'wpa83367_price_html', 100, 2 );
function wpa83367_price_html( $price, $product ){

  $cstom_calss_aria = '<del aria-hidden="true"><span class="woocommerce-Price-amount amount sale_price"><bdi>';

  return str_replace( '<del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi>',$cstom_calss_aria , $price );


}
add_filter( 'woocommerce_get_price_html', 'wpa8w3367_price_html', 100, 2 );
function wpa8w3367_price_html( $price, $product ){

  $cstom_calss = '<del><span class="woocommerce-Price-amount amount sale_price"><bdi>';

  return str_replace( '<del><span class="woocommerce-Price-amount amount"><bdi>',$cstom_calss , $price );


}

add_filter( 'woocommerce_get_price_html', 'wpa8w33f67_price_html', 100, 2 );
function wpa8w33f67_price_html( $price, $product ){

  $cstom_calss = '<ins><span class="woocommerce-Price-amount amount price_sale"><bdi>';

  return str_replace( '<ins><span class="woocommerce-Price-amount amount"><bdi>',$cstom_calss , $price );


}

add_filter( 'woocommerce_get_price_html', 'wpa8w33df67_price_html', 100, 2 );
function wpa8w33df67_price_html( $price, $product ){

  $sale = get_post_meta( get_the_ID(), '_sale_price', true);
  $cstom_calss = '<span class="woocommerce-Price-amount amount price_sale"><bdi>';

  return str_replace( '<span class="woocommerce-Price-amount amount">',$cstom_calss , $price );

}


add_filter( 'woocommerce_product_reviews_tab_title', 'bbloomer_rename_reviews_product_tab_label' );

function bbloomer_rename_reviews_product_tab_label() {

   $des_title = '';

   global $product, $post;
   $count = $product->get_review_count();
   $des_title = esc_html_e('Comments','parskala').'<i>'. $count .'</i>';

   if ( mobile_cheker() || tablet_cheker() ) {
     $des_title = '<span class="cooment_mobile_title">مفید ترین نظرات</span><a class="insert_comment_mobile" href="'.add_query_arg( 'insert-comment', '', get_the_permalink() ).'">افزودن نظر جدید +</a>';
   }
  return $des_title;
}
add_filter( 'woocommerce_product_additional_information_tab_title', 'bbloomer_rename_additional_information_product_tab_label' );

function bbloomer_rename_additional_information_product_tab_label(){
  return prk_option('information_product_title') ? prk_option('information_product_title') : __('info','parskala');
}

function add_costom_element_informationproduct_tab(){
 global $product, $post;
 if (prk_option('sub_title_show_product') == '1' ) {
    echo '<span class="title-desctop">'.get_the_title().'</span>';
 }



}
add_action('woocommerce_product_additional_information','add_costom_element_informationproduct_tab',1);



// add line progress to payment
add_action('woocommerce_before_cart','add_progess_payment',1);
add_action('woocommerce_before_checkout_form','add_progess_payment',1);
add_action('woocommerce_before_thankyou','add_progess_payment',1);
add_action('prk_woocommerce_order_confirm_before','add_progess_payment',1);
function add_progess_payment(){

  $product_styles = prk_option('checkout_product_styles');
  $logo_payment = prk_option('logo_payment');
  // page checked
  $classes = 'active';

  if ('style2' == $product_styles) {
  ?>

  <div class="payment_navigtions">

    <?php if ($logo_payment == '1' || $logo_payment == ''):?>
      <div class="payment_logo">

          <a href="<?php bloginfo('url');?>">
            <?=  prk_logo_payment_url(); ?>
          </a>

      </div>
    <?php endif;?>
    <div class="checkout-headers cart">
      <ul>

        <li class="nav <?php if ( is_cart() ) { echo $classes;}?>">
          <a href="<?php echo esc_url( wc_get_cart_url() ); ?>">
            <i class="ri-shopping-cart-line"></i><p><?php _e('cart' , 'parskala');?></p>
          </a>
        </li>



          <li class="nav <?php if ( is_checkout() && empty( is_wc_endpoint_url('order-received'))  ) { echo $classes;}?>">
            <a href="<?php echo wc_get_checkout_url();?>">
              <i class="ri-truck-line"></i><p><?php _e('Bill' , 'parskala');?></p>
            </a>
          </li>



        <li class="nav <?php if ( is_order_received_page() ) { echo $classes;}?>">
          <i class="ri-bank-card-line"></i><p><?php _e('factor' , 'parskala');?></p>
        </li>


      </ul>
    </div>

  </div>
   <?php
  }
}

if ( prk_option('myaccount_whishlist_sec') ) {
add_action('woocommerce_account_dashboard','prk_add_list_section_user',2,1);
}

function prk_add_list_section_user(){
?>

<div class="my-orders-summary profile-section">

  <div class="my-orders-summary__header profile-section__header">

    <div class="my-orders-summary__title profile-section__title">
      <div>
        <p><?php echo prk_option('myaccount_whishlist_sec_text');?></p>
      </div>
      <div class="title-border"></div>
    </div>

    <!-- <span class="my-orders-summary__more profile-section__more">
      <a class="my-orders-link" href="<?echo get_bloginfo('url');?>/my-account/orders/"><span>مشاهده همه</span>
        <i class="fa fa-chevron-left"></i>
      </a>
    </span> -->

  </div>

  <div class="my-viewed-products__main">
    <?php

    if (theme_style() == 'prk-fashion') {
      $item = '3';
    }else {
      $item = '5';
    }

    $settings_slider =  array(
			'loop' => 'false',
			'nav' => 'false',
			'autoplay' => 'false',
			'delay' => 'false',
			'item' => $item,
			'margins' => 5,
		);

		$json_settings = json_encode($settings_slider);
    $sit_wishlist_array = sit_get_wishlist_array();

    if( !$sit_wishlist_array ){
        $sit_wishlist_array = [];
    }

    $sit_loop = new WP_Query( [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post__in' => $sit_wishlist_array
    ] );

    if($sit_wishlist_array && $sit_loop->have_posts() ): ?>

     <div class="article-off" settings-slider='<?php echo $json_settings; ?>'>

      <?php while ( $sit_loop->have_posts() ) : $sit_loop->the_post(); ?>
        <?php
       global $product;
       global $woocommerce;
       $price = get_post_meta( get_the_ID(), '_regular_price', true);

       ?>
       <article class="item-pro">

           <a href="<?php the_permalink();?>">


              <?php echo pr_img(); ?>


           <div class="index-title-pro">
              <h2><?php echo wp_trim_words(get_the_title(),12,'...') ;?></h2>
           </div>

             <!--price-->
            <div class="index-prices-pro">

              <div class="price_onsale_ar">

                   <?php if ($price|| $product->is_type( 'variable' )) {
                     echo $product->get_price_html();
                   }else{
                     echo '<p class="call_pro">', _e('call' , 'parskala'). '</p>';}
                   ?>

              </div>
            </div>

             </a>
       </article>

       <?php endwhile; ?>
       </div>
    <?php wp_reset_postdata(); ?>
     <?php endif;?>
  </div>


</div>

<?php
}


if ( prk_option('myaccount_whishlist_lastviewd') ) {

  add_action('woocommerce_account_dashboard','prk_add_view_product_section_user',3,1);

}

function prk_add_view_product_section_user(){
?>

<div class="my-orders-summary profile-section">

  <div class="my-orders-summary__header profile-section__header">

    <div class="my-orders-summary__title profile-section__title">
      <div>
        <p><?php echo prk_option('myaccount_lastviewd_sec_text');?></p>
      </div>
      <div class="title-border"></div>
    </div>

    <!-- <span class="my-orders-summary__more profile-section__more">
      <a class="my-orders-link" href="<?echo get_bloginfo('url');?>/my-account/orders/"><span>مشاهده همه</span>
        <i class="fa fa-chevron-left"></i>
      </a>
    </span> -->

  </div>

  <div class="my-viewed-products__main">
    <?php
    if (theme_style() == 'prk-fashion') {
      $item = '3';
    }else {
      $item = '5';
    }

    $settings_slider =  array(
			'loop' => 'false',
			'nav' => 'false',
			'autoplay' => 'false',
			'delay' => 'false',
			'item' => $item,
			'margins' => 5,
		);

		$json_settings = json_encode($settings_slider);
    $sit_wishlist_array = sit_get_wishlist_array();

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

    if ( $loop->have_posts() ): ?>

     <div class="article-off" settings-slider='<?php echo $json_settings; ?>'>

      <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <?php
       global $product;
       global $woocommerce;
       $price = get_post_meta( get_the_ID(), '_regular_price', true);

       ?>
       <article class="item-pro">

           <a href="<?php the_permalink();?>">



             <?php echo pr_img(); ?>



           <div class="index-title-pro">
              <h2><?php echo wp_trim_words(get_the_title(),12,'...') ;?></h2>
           </div>

             <!--price-->
            <div class="index-prices-pro">

              <div class="price_onsale_ar">

                   <?php if ($price|| $product->is_type( 'variable' )) {
                     echo $product->get_price_html();
                   }else{
                     echo '<p class="call_pro">', _e('call' , 'parskala'). '</p>';}
                   ?>

              </div>
            </div>

             </a>
       </article>

       <?php endwhile; ?>
       </div>
    <?php wp_reset_postdata(); ?>
     <?php endif;?>
  </div>


</div>

<?php
}




if (prk_login_before_order()) {
  add_action('template_redirect','check_if_logged_in');
}
function check_if_logged_in()
{
    $pageid = get_option( 'woocommerce_checkout_page_id' );
   if(!is_user_logged_in() && is_page($pageid))
    {
        $url = add_query_arg(
            'redirect_to',
            get_permalink($pageid),
            site_url('/my-account/') // your my acount url
        );
        wp_redirect($url);
        exit;
    }
}


if ( ! function_exists( 'prk_widget_get_current_page_url' ) ) {
	function prk_widget_get_current_page_url( $link ) {
		if ( isset( $_GET['stock_status'] ) ) {
			$link = add_query_arg( 'stock_status', wc_clean( $_GET['stock_status'] ), $link );
		}

        if ( isset( $_GET['filter_brand'] ) ) {
			$link = add_query_arg( 'filter_brand', wc_clean( $_GET['filter_brand'] ), $link );
		}

        if ( isset( $_GET['filter_cat'] ) ) {
			$link = add_query_arg( 'filter_cat', wc_clean( $_GET['filter_cat'] ), $link );
		}

		return $link;
	}

	add_filter( 'woocommerce_widget_get_current_page_url', 'prk_widget_get_current_page_url' );
}

//prk Get base shop page link
if ( ! function_exists( 'prk_shop_page_link' ) ) {
  function prk_shop_page_link( $keep_query = false, $taxonomy = '' ) {
    // Base Link decided by current page
    $link = '';

    if ( class_exists( 'Automattic\Jetpack\Constants' ) && Automattic\Jetpack\Constants::is_defined( 'SHOP_IS_ON_FRONT' ) ) {
      $link = home_url();
    } elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) || is_shop() ) {
      $link = get_permalink( wc_get_page_id( 'shop' ) );
    } elseif ( is_product_category() ) {
      $link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
    } elseif ( is_product_tag() ) {
      $link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
    } elseif ( get_queried_object() ) {
      $queried_object = get_queried_object();

      if ( property_exists( $queried_object, 'taxonomy' ) ) {
        $link = get_term_link( $queried_object->slug, $queried_object->taxonomy );
      }
    }

    if ( $keep_query ) {

      // Min/Max
      if ( isset( $_GET['min_price'] ) ) {
        $link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
      }

      if ( isset( $_GET['max_price'] ) ) {
        $link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
      }

      // Orderby
      if ( isset( $_GET['orderby'] ) ) {
        $link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
      }

      if ( isset( $_GET['stock_status'] ) ) {
        $link = add_query_arg( 'stock_status', wc_clean( $_GET['stock_status'] ), $link );
      }

            if ( isset( $_GET['filter_brand'] ) ) {
        $link = add_query_arg( 'filter_brand', wc_clean( $_GET['filter_brand'] ), $link );
      }

            if ( isset( $_GET['filter_cat'] ) ) {
        $link = add_query_arg( 'filter_cat', wc_clean( $_GET['filter_cat'] ), $link );
      }

      if ( isset( $_GET['per_row'] ) ) {
        $link = add_query_arg( 'per_row', wc_clean( $_GET['per_row'] ), $link );
      }

      if ( isset( $_GET['per_page'] ) ) {
        $link = add_query_arg( 'per_page', wc_clean( $_GET['per_page'] ), $link );
      }

      if ( isset( $_GET['shop_view'] ) ) {
        $link = add_query_arg( 'shop_view', wc_clean( $_GET['shop_view'] ), $link );
      }

      if ( isset( $_GET['shortcode'] ) ) {
        $link = add_query_arg( 'shortcode', wc_clean( $_GET['shortcode'] ), $link );
      }

      /**
       * Search Arg.
       * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
       */
      if ( get_search_query() ) {
        $link = add_query_arg( 's', rawurlencode( wp_specialchars_decode( get_search_query() ) ), $link );
      }

      // Post Type Arg
      if ( isset( $_GET['post_type'] ) ) {
        $link = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $link );

        // Prevent post type and page id when pretty permalinks are disabled.
        if ( is_shop() ) {
          $link = remove_query_arg( 'page_id', $link );
        }
      }

      // Min Rating Arg
      if ( isset( $_GET['min_rating'] ) ) {
        $link = add_query_arg( 'min_rating', wc_clean( $_GET['min_rating'] ), $link );
      }

      // All current filters
      if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
        foreach ( $_chosen_attributes as $name => $data ) {
          if ( $name === $taxonomy ) {
            continue;
          }
          $filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
          if ( ! empty( $data['terms'] ) ) {
            $link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
          }
          if ( 'or' == $data['query_type'] ) {
            $link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
          }
        }
      }
    }

    $link = apply_filters( 'prk_shop_page_link', $link, $keep_query, $taxonomy );

    if ( is_string( $link ) ) {
      return $link;
    } else {
      return '';
    }
  }
}

//prk shop filter query
add_action( 'woocommerce_product_query', 'prk_shop_filter_query' );
if ( ! function_exists( 'prk_shop_filter_query' ) ) {
    function prk_shop_filter_query( $q ){
        if ( ( ( is_woocommerce() && is_archive() ) || is_shop() ) ) {

            $current_stock_status = isset( $_GET['stock_status'] ) ? explode( ',', $_GET['stock_status'] ) : array();
            $filter_brand         = isset( $_GET['filter_brand'] ) ? explode( ',', $_GET['filter_brand'] ) : array();
            $product_cat          = isset( $_GET['filter_cat'] ) ? explode( ',', $_GET['filter_cat'] ) : array();

            // --- حراج (بدون تغییر)
            if ( in_array( 'onsale', $current_stock_status ) ) {
                $product_ids_on_sale = wc_get_product_ids_on_sale();
                $q->set( 'post__in', $product_ids_on_sale );
            }

            // --- فیلتر "فقط موجود" اصلاح‌شده: ساده‌های موجود + والدِ متغیّر با حداقل یک ورییشن موجود
          if ( in_array( 'instock', $current_stock_status ) ) {
              global $wpdb;

              $lookup   = $wpdb->wc_product_meta_lookup;
              $posts    = $wpdb->posts;
              $tt       = $wpdb->term_taxonomy;
              $t        = $wpdb->terms;
              $tr       = $wpdb->term_relationships;

              // ترم نوع محصول = simple
              $simple_term_id = (int) $wpdb->get_var(
                  "SELECT term_id FROM {$t} WHERE slug = 'simple' LIMIT 1"
              );

              // 1) فقط محصولات ساده‌ی موجود (والد متغیّرها عمداً حذف می‌شوند)
              $simple_instock_ids = $wpdb->get_col(
                  "SELECT l.product_id
                  FROM {$lookup} l
                  INNER JOIN {$posts} p ON p.ID = l.product_id
                  INNER JOIN {$tr} tr ON tr.object_id = p.ID
                  INNER JOIN {$tt} tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
                  WHERE p.post_type = 'product'
                    AND p.post_status = 'publish'
                    AND l.stock_status = 'instock'
                    AND tt.taxonomy = 'product_type'
                    AND tt.term_id = {$simple_term_id}"
              );

              // 2) والدِ متغیّرهایی که حداقل یک ورییشن موجود دارند
              $variable_parent_ids = $wpdb->get_col(
                  "SELECT DISTINCT p.post_parent
                  FROM {$posts} p
                  INNER JOIN {$lookup} l ON l.product_id = p.ID
                  WHERE p.post_type = 'product_variation'
                    AND p.post_status = 'publish'
                    AND l.stock_status = 'instock'
                    AND p.post_parent > 0"
              );

              // اتحاد: ساده‌های موجود + والدهای دارای ورییشن موجود
              $instock_ids = array_unique( array_map( 'intval', array_merge( $simple_instock_ids, $variable_parent_ids ) ) );

              // تقاطع با محدودیت‌های قبلی (مثلاً حراج)
              $existing_in = $q->get( 'post__in' );
              if ( ! empty( $existing_in ) ) {
                  $instock_ids = array_values( array_intersect( $existing_in, $instock_ids ) );
              }

              if ( empty( $instock_ids ) ) {
                  $instock_ids = array( 0 ); // خروجی خالی
              }

              $q->set( 'post__in', $instock_ids );
              $q->set( 'meta_query', array() ); // جلوگیری از تداخل
          }



            // --- فیلتر برند (بدون تغییر)
            if ( ! empty( $filter_brand ) ) {
                $tax_query = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'brand',
                        'field'    => 'term_id',
                        'terms'    => $filter_brand,
                    )
                );
                $q->set( 'tax_query', $tax_query );
            }

            // --- فیلتر دسته (بدون تغییر)
            if ( ! empty( $product_cat ) ) {
                $tax_query = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'term_id',
                        'terms'    => $product_cat,
                    )
                );
                $q->set( 'tax_query', $tax_query );
            }

            // --- فیلتر شهر از کوکی (بدون تغییر)
            if ( isset( $_COOKIE['prskalaSearchCity'] ) && ! empty( $_COOKIE['prskalaSearchCity'] ) ) {
                $city_categories = explode( ',', $_COOKIE['prskalaSearchCity'] );
                if ( ! empty( $city_categories ) && $city_categories !== 0 ) {
                    if ( isset( $tax_query['tax_query'] ) && is_array( $tax_query['tax_query'] ) ) {
                        $tax_query['tax_query'][] = array(
                            'taxonomy' => 'city_categories',
                            'field'    => 'id',
                            'terms'    => $city_categories,
                        );
                    } else {
                        $tax_query['tax_query'] = array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'city_categories',
                                'field'    => 'id',
                                'terms'    => $city_categories,
                            ),
                        );
                    }
                }
                $q->set( 'tax_query', $tax_query );
            }
        }
    }
}

//ajax search faq
add_action('wp_ajax_nopriv_prk_ajax_faq_search', 'prk_ajax_faq_search', 999);
add_action('wp_ajax_prk_ajax_faq_search', 'prk_ajax_faq_search', 999);
function prk_ajax_faq_search(){

	$keyword = trim(esc_attr($_GET['s']));
  $current_page = trim(esc_attr($_GET['current_page']));

	echo '<span class="prk_close_fag_search_result"><i class="ri-close-circle-fill"></i></span>';

	$args = array(
		's'                   => $keyword,
		'posts_per_page'      => 5,
		'post_type'           => 'prkfaq',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'order'               => 'DECS',
	);
	$query = new WP_Query( $args );
	if($query->have_posts()){
			while ($query->have_posts()):
				$query->the_post();
				echo '<a class="result_post_search" href="'.$current_page.'?question='.get_the_ID().'" >'.get_the_title().'</a>';
			endwhile;
		wp_reset_postdata();
		$has_result = true;
	} else {
		echo '<span class="not_resulted">موردی یافت نشد</span>';
		$has_result = false;
	}

	do_action('prk_after_result_search_ajax', $keyword, $has_result);
  $title_question = 'موضوع پرسش شما چیست؟';
  ?>

	<script>
	jQuery('.prk_close_fag_search_result').on('click',function(){

  		jQuery('.main_result_ajax_ask_search').hide(0);
  		jQuery('#text_search').val('');
      jQuery('.faq_headerbox .circle_btn_icon').html('<i class="ri-question-mark"></i>');
      jQuery('.faq_headerbox .page_title').html('<?php echo $title_question;?>');
      jQuery('.faq_headerbox .page_subtitle').removeClass('fadeOut');

	});
	</script>

  <?php
	exit();
}


// ajax product search compare
add_action('wp_ajax_nopriv_prk_ajax_compare_search', 'prk_ajax_compare_search', 999);
add_action('wp_ajax_prk_ajax_compare_search', 'prk_ajax_compare_search', 999);
function prk_ajax_compare_search(){

  global $post,$product;

  $all_product = @$_GET['data_string'];
  $array_products = explode(',', $all_product);

	$keyword = trim(esc_attr($_GET['s']));
	$compare_short = get_permalink();
  // $current_page = trim(esc_attr($_GET['current_page']));


  $first_product_id = $array_products[0];
  $terms = get_the_terms( $first_product_id, 'product_cat' );

	$args = array(
		's'                   => $keyword,
		'post_type'           => 'product',
		'post_status'         => 'publish',
    'post__not_in' => $array_products,
		'ignore_sticky_posts' => 1,
		'order'               => 'DECS',
	);
	$query = new WP_Query( $args );
	if($query->have_posts()){
			while ($query->have_posts()):
				$query->the_post();

				?>
          <li>
    				<a href="<?php echo $compare_short;?><?php echo '?products='.$_GET['data_string'].','.$post->ID; ?>" >
              <?php the_post_thumbnail(); ?>
              <h2><?php the_title(); ?></h2>
            </a>
          </li>
				<?php

			endwhile;
		wp_reset_postdata();
		$has_result = true;
	} else {
		echo '<span class="not_resulted">موردی یافت نشد</span>';
		$has_result = false;
	}

	do_action('prk_after_result_search_ajax_compare', $keyword, $has_result);

  $title_question = 'موضوع پرسش شما چیست؟';
  ?>

	<script>
	// jQuery('.prk_close_fag_search_result').on('click',function(){
  //
  // 		jQuery('.main_result_ajax_ask_search').hide(0);
  // 		jQuery('#text_search_compare').val('');
  //     jQuery('.faq_headerbox .circle_btn_icon').html('<i class="ri-question-mark"></i>');
  //     jQuery('.faq_headerbox .page_title').html('<?php echo $title_question;?>');
  //     jQuery('.faq_headerbox .page_subtitle').removeClass('fadeOut');
  //
	// });
	</script>

  <?php
	exit();
}







// اضافه کردن فیلد شماره تلفن و کد ملی کاربر در صفحه ویرایش حساب کاربری
add_action( 'prk_before_woocommerce_edit_account_form', 'add_billing_mobile_phone_to_edit_account_form',1,1 ); // After existing fields
function add_billing_mobile_phone_to_edit_account_form() {
    $user = wp_get_current_user();
    ?>
     <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="billing_mobile_phone"><?php _e( 'شماره تلفن', 'woocommerce' ); ?>
           <span class="required">*</span>
         </label>
        <input type="text" class="woocommerce-Input woocommerce-Input--phone input-text" name="billing_mobile_phone" id="billing_mobile_phone" value="<?php echo esc_attr( $user->billing_mobile_phone ); ?>" />
    </p>
    <?php
}


 // Check and validate the mobile phone
 add_action( 'woocommerce_save_account_details_errors','billing_mobile_phone_field_validation', 20, 1 );



function billing_mobile_phone_field_validation( $args ){
    if ( isset($_POST['billing_mobile_phone']) && empty($_POST['billing_mobile_phone']) )
        $args->add( 'error', __( 'لطفا شماره تلفن خود را وارد کنید.', 'woocommerce' ),'');
}

// Save the mobile phone value to user data
add_action( 'woocommerce_save_account_details', 'my_account_saving_billing_mobile_phone', 20, 1 );
function my_account_saving_billing_mobile_phone( $user_id ) {
    if( isset($_POST['billing_mobile_phone']) && ! empty($_POST['billing_mobile_phone']) )
       update_user_meta( $user_id, 'billing_mobile_phone', sanitize_text_field($_POST['billing_mobile_phone']) );
       update_user_meta( $user_id, 'billing_phone', sanitize_text_field($_POST['billing_mobile_phone']) );

}


function add_National_code_to_edit_account_form() {
    $user = wp_get_current_user();
    ?>
     <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="billing_National_code"><?php _e( 'کد ملی', 'woocommerce' ); ?>
          <?php if (prk_option('opti_checkout_ncode') == 0): ?>
            <span class="required">*</span>
          <?php endif; ?>

        </label>
        <input type="text" class="woocommerce-Input woocommerce-Input--phone input-text" name="billing_National_code" id="billing_National_code" value="<?php echo esc_attr( $user->billing_National_code ); ?>" autocomplete="billing_ncode" />
    </p>
    <?php
}

// Check and validate the mobile phone

function billing_National_code_field_validation( $args ){
    if ( isset($_POST['billing_National_code']) && empty($_POST['billing_National_code']) )
        $args->add( 'error', __( 'لطفا کد ملی خود را درست وارد کنید.', 'woocommerce' ),'');
}

// Save the mobile phone value to user data
if (prk_option('National_code')) {
  add_action( 'woocommerce_save_account_details', 'my_account_saving_billing_National_code', 20, 1 );
  add_action( 'prk_before_woocommerce_edit_account_form', 'add_National_code_to_edit_account_form' ); // After existing fields
}

if (prk_option('opti_checkout_ncode') == 0 && prk_option('National_code') ) {
      add_action( 'woocommerce_save_account_details_errors','billing_National_code_field_validation', 20, 1 );
}


function my_account_saving_billing_National_code( $user_id ) {
    if( isset($_POST['billing_National_code']) && ! empty($_POST['billing_National_code']) )
       update_user_meta( $user_id, 'billing_National_code', sanitize_text_field($_POST['billing_National_code']) );
       update_user_meta( $user_id, 'billing_ncode', sanitize_text_field($_POST['billing_National_code']) );
}

function custom_my_account_menu_items( $items ) {
  unset($items['downloads']);
  return $items;
}
if ( prk_option('prk_myaccount_downloads') == 0 ) {
  add_filter( 'woocommerce_account_menu_items', 'custom_my_account_menu_items' );
}




  if ( prk_option( 'show_swatches_archive', '1') == '1') {
  	add_action ( 'woocommerce_before_shop_loop_item_title', 'prk_swatches_list' );
    add_shortcode('prk_swatches_list', 'prk_swatches_list');
  }

  if ( ! function_exists( 'prk_swatches_list' ) ) {
  	function prk_swatches_list( $attribute_name = false ) {
  		global $product;

  		$id = $product->get_id();

  		if ( empty( $id ) || ! $product->is_type( 'variable' ) ) {
  			return false;
  		}

  		if ( ! $attribute_name ) {
  			$attribute_name = prk_swatches_archive_attr();
  		}

  		if ( empty( $attribute_name ) ) {
  			return false;
  		}

  		$available_variations = array();

  		if ( ! $available_variations ) {
  			$available_variations = $product->get_available_variations();
  		}

  		if ( empty( $available_variations ) ) {
  			return false;
  		}

  		$swatches_to_show = prk_get_option_variations( $attribute_name, $available_variations, false, $id );

  		if ( empty( $swatches_to_show ) ) {
  			return false;
  		}

  		$out = '';

  		$out .= '<div class="prk-archive-swatches">';

  		$index = 0;

  		foreach ( $swatches_to_show as $key => $swatch ) {
  			$style = $class = '';

  			$swatch_limit = prk_option( 'swatches_archive_count' );
  			if ( prk_option( 'enable_swatches_archive_count' ) && count( $swatches_to_show ) > (int) $swatch_limit ) {
  				if ( $index >= $swatch_limit ) {
  					$class .= ' prk-hidden';
  				}
  				if ( $index === (int) $swatch_limit ) {
  					$out .= '<div class="prk_swatches-divider">+' . ( count( $swatches_to_show ) - (int) $swatch_limit ) . '</div>';
  				}
  			}

  			$index++;

  			if ( $swatch['color'] ) {
  				$style = 'style="background-color:' . $swatch['color'] . '"';
  				$class .= ' prk-swatch-with-bg';
  				$class .= prk_option( 'swatches_circle_style' ) ? ' prk-swatche-circle' : '';
          $text_swatches = '';
  			} elseif ( $swatch['text'] ) {
                  $style = '';
  				$class .= ' prk-swatch-text';
          $text_swatches = $term->name;
  			}

  			$term = get_term_by( 'slug', $key, $attribute_name );

  			$title = prk_option('show_swatches_archive_title') ? ' <span class="tooltiptext">' .$term->name. '</span> ' : '';
  			$out .= '<div class="prk-archive-swatch' . esc_attr( $class ) . '" ' . $style. '>' . $text_swatches . $title . '</div>';
  		}

  		$out .= '</div>';

  		echo $out;

  	}
  }

  if ( ! function_exists( 'prk_swatches_archive_attr' ) ) {
  	function prk_swatches_archive_attr() {
          return prk_option( 'swatches_archive_attr' );
  	}
  }

  if ( ! function_exists( 'prk_get_option_variations' ) ) {
  	function prk_get_option_variations( $attribute_name, $available_variations, $option = false, $product_id = false ) {
  		$swatches_to_show = array();

  		//$product_image_id = get_post_thumbnail_id( $product_id );

  		foreach ( $available_variations as $key => $variation ) {
  			$option_variation = array();
  			$attr_key         = 'attribute_' . $attribute_name;
  			if ( ! isset( $variation['attributes'][ $attr_key ] ) ) {
  				return;
  			}

  			$val = $variation['attributes'][ $attr_key ];

  			// Get all variations with swatches to show by attribute name
              $swatch                   = prk_has_swatch( $product_id, $attribute_name, $val );
              $swatches_to_show[ $val ] = $swatch;
  		}

  		return $swatches_to_show;

  	}
  }

  if ( ! function_exists( 'prk_has_swatch' ) ) {
  	function prk_has_swatch( $id, $attr_name, $value ) {
  		$swatches = array();

  		$color = $image = $not_dropdown = '';

  		$term = get_term_by( 'slug', $value, $attr_name );
  		if ( is_object( $term ) ) {
  				$color     =  get_term_meta( $term->term_id,'product_'.$attr_name, true);
  		}

  		if ( $color != '' ) {
  			$swatches['color'] = $color;
  		} else {
              $swatches['text'] = true;
          }

  		return $swatches;
  	}
  }

  function jeherve_custom_image( $media, $post_id, $args ) {
      if ( $media ) {
          return $media;
      } else {
          $permalink = get_permalink( $post_id );
          $url = apply_filters( 'jetpack_photon_url', 'YOUR_LOGO_IMG_URL' );

          return array( array(
              'type'  => 'image',
              'from'  => 'custom_fallback',
              'src'   => esc_url( $url ),
              'href'  => $permalink,
          ) );
      }
  }
  add_filter( 'jetpack_images_get_images', 'jeherve_custom_image', 10, 3 );

  //Get terms link
  function prk_get_term_links( $term_tax, $term_ids ) {

      if ( is_array( $term_ids ) )
      {
          $term_tax_link = ( $term_tax == 'category' ? 'cat' : $term_tax );
          $term_tax_link = ( $term_tax == 'post_tag' ? 'tag' : $term_tax );
          if( count( $term_ids ) == 1 ) {
              $term_link = get_term_link( (int)$term_ids[0], $term_tax );
          } else {
              $term_link = get_home_url() . '/?' .$term_tax_link.'=';
              foreach( $term_ids as $id ) {
                  $term = get_term( $id, $term_tax );
                  $slug = $term->slug;
                  $term_link .= $slug . ',';
              }
          }
      } else {
  		$term_link = get_term_link( (int)$term_ids, $term_tax );
      }
      return $term_link;
  }

###############Rename persian default category to "uncategories"#################

add_action('init',function(){

	$rtl_chars_pattern = '/[\x{0590}-\x{05ff}\x{0600}-\x{06ff}]/u';

	$uncategorized_term_id = get_option( 'default_product_cat' );

	$default_category_woocommerce=get_term($uncategorized_term_id,'product_cat');

	$slug = urldecode($default_category_woocommerce->slug);
	
	if (preg_match($rtl_chars_pattern,$slug)){
		
		wp_update_term($uncategorized_term_id, 'product_cat', array(
			'slug' => 'uncategories'
		  ));

	}

});

##################################End of rename##################################


if( ! function_exists( 'remove_class_filter' ) ){
  /**
   * Remove Class Filter Without Access to Class Object
   *
   * @param string $tag         Filter to remove
   * @param string $class_name  Class name for the filter's callback
   * @param string $method_name Method name for the filter's callback
   * @param int    $priority    Priority of the filter (default 10)
   *
   * @return bool Whether the function is removed.
   */
  function remove_class_filter( $tag = 'wc_memberships_my_memberships_column_names', $class_name = 'WC_Memberships_Integration_Subscriptions_Frontend', $method_name = 'my_memberships_subscriptions_columns', $priority = 10 ) {
    global $wp_filter;
    // Check that filter actually exists first
    if ( ! isset( $wp_filter[ $tag ] ) ) {
      return FALSE;
    }
    /**
     * If filter config is an object, means we're using WordPress 4.7+ and the config is no longer
     * a simple array, rather it is an object that implements the ArrayAccess interface.
     *
     * To be backwards compatible, we set $callbacks equal to the correct array as a reference (so $wp_filter is updated)
     *
     * @see https://make.wordpress.org/core/2016/09/08/wp_hook-next-generation-actions-and-filters/
     */
    if ( is_object( $wp_filter[ $tag ] ) && isset( $wp_filter[ $tag ]->callbacks ) ) {
      // Create $fob object from filter tag, to use below
      $fob       = $wp_filter[ $tag ];
      $callbacks = &$wp_filter[ $tag ]->callbacks;
    } else {
      $callbacks = &$wp_filter[ $tag ];
    }
    // Exit if there aren't any callbacks for specified priority
    if ( ! isset( $callbacks[ $priority ] ) || empty( $callbacks[ $priority ] ) ) {
      return FALSE;
    }
    // Loop through each filter for the specified priority, looking for our class & method
    foreach ( (array) $callbacks[ $priority ] as $filter_id => $filter ) {
      // Filter should always be an array - array( $this, 'method' ), if not goto next
      if ( ! isset( $filter['function'] ) || ! is_array( $filter['function'] ) ) {
        continue;
      }
      // If first value in array is not an object, it can't be a class
      if ( ! is_object( $filter['function'][0] ) ) {
        continue;
      }
      // Method doesn't match the one we're looking for, goto next
      if ( $filter['function'][1] !== $method_name ) {
        continue;
      }
      // Method matched, now let's check the Class
      if ( get_class( $filter['function'][0] ) === $class_name ) {
        // WordPress 4.7+ use core remove_filter() since we found the class object
        if ( isset( $fob ) ) {
          // Handles removing filter, reseting callback priority keys mid-iteration, etc.
          $fob->remove_filter( $tag, $filter['function'], $priority );
        } else {
          // Use legacy removal process (pre 4.7)
          unset( $callbacks[ $priority ][ $filter_id ] );
          // and if it was the only filter in that priority, unset that priority
          if ( empty( $callbacks[ $priority ] ) ) {
            unset( $callbacks[ $priority ] );
          }
          // and if the only filter for that tag, set the tag to an empty array
          if ( empty( $callbacks ) ) {
            $callbacks = array();
          }
          // Remove this filter from merged_filters, which specifies if filters have been sorted
          unset( $GLOBALS['merged_filters'][ $tag ] );
        }
        return TRUE;
      }
    }
    return FALSE;
  }
  }
  /**
  * Make sure the function does not exist before defining it
  */
  if( ! function_exists( 'prk_remove_class_action') ){
    /**
     * Remove Class Action Without Access to Class Object
     *
     * @param string $tag         Action to remove
     * @param string $class_name  Class name for the action's callback
     * @param string $method_name Method name for the action's callback
     * @param int    $priority    Priority of the action (default 10)
     *
     * @return bool               Whether the function is removed.
     */
    function prk_remove_class_action( $tag = 'wc_memberships_my_memberships_column_membership-next-bill-on', $class_name = 'WC_Memberships_Integration_Subscriptions_Frontend', $method_name = 'output_subscription_columns', $priority = 10 ) {
      remove_class_filter( $tag, $class_name, $method_name, $priority );
    }
  }



################################checkout manager ##########################

// add_filter( 'woocommerce_default_address_fields', 'checkout_fields_setting_checkout_address_fields' );
function checkout_fields_setting_checkout_address_fields( $fields ) {
	
	$prk_checkout_fields_setting = get_option( 'prk_option' );
	
	if($prk_checkout_fields_setting){
		
		if($prk_checkout_fields_setting['opti_checkout_name'] == '1'){
			$fields['first_name']['required']   = false;
		}else{
			$fields['first_name']['required']   = true;
		}
		
		if($prk_checkout_fields_setting['opti_checkout_last_name'] == '1'){
			$fields['last_name']['required']   = false;
		}else{
			$fields['last_name']['required']   = true;
		}
		
		if($prk_checkout_fields_setting['opti_checkout_address1'] == '1'){
			$fields['address_1']['required']   = false;
		}else{
			$fields['address_1']['required']   = true;
		}
		
		if($prk_checkout_fields_setting['opti_checkout_city'] == '1'){
			$fields['city']['required']   = false;
		}else{
			$fields['city']['required']   = true;
		}
		
		if($prk_checkout_fields_setting['opti_checkout_state'] == '1'){
			$fields['state']['required']   = false;
		}else{
			$fields['state']['required']   = true;
		}
		
		if($prk_checkout_fields_setting['opti_checkout_postcode'] == '1'){
			$fields['postcode']['required']   = false;
		}else{
			$fields['postcode']['required']   = true;
		}
	}
	
    return $fields;
}


// add_filter( 'woocommerce_billing_fields', 'adjust_requirement_of_checkout_contact_fields');
function adjust_requirement_of_checkout_contact_fields( $fields ) {
	
	$prk_checkout_fields_setting = get_option( 'prk_option' );
	
	if($prk_checkout_fields_setting){
	
		if($prk_checkout_fields_setting['opti_checkout_phone'] == '1'){
			$fields['billing_phone']['required']   = false;
		}else{
			$fields['billing_phone']['required']   = true;
		}
	
		if($prk_checkout_fields_setting['opti_checkout_email'] == '1'){
			$fields['billing_email']['required']   = false;
		}else{
			$fields['billing_email']['required']   = true;
		}

 

	}
	
    return $fields;
}

################################END##########################################



//prk_sticky_add_to_cart
if ( !(mobile_cheker() || tablet_cheker()) ){
add_action( 'woocommerce_after_main_content', 'prk_sticky_add_to_cart' );
}
function prk_sticky_add_to_cart() {
    global $product;

    if ( ! is_singular('product') || ! $product instanceof WC_Product ) {
        return;
    }

    // کاتالوگ‌مد و قیمت صفر رو عمداً مثل قبل کنار گذاشتم؛ اگر لازم بود برگردون.
    $sticky_add_blur = prk_option('show_sticky_add_blur') == '1' ? 'blure_wite' : '';

    if ( ( $product->is_purchasable() || $product->is_type('external') ) && $product->is_in_stock() && prk_option('show_sticky_add') ) : ?>
        <div class="prk-sticky-add-cart <?= esc_attr( $sticky_add_blur ); ?>">
            <div class="continer flexed">

                <div class="prk-sticky-thumb">
                    <?php
                    // --- SAFE THUMB RENDER ---
                    $thumb_id = (int) $product->get_image_id();
                    if ( $thumb_id ) {
                        // خروجی استاندارد وردپرس با سایز thumbnail
                        echo wp_get_attachment_image( $thumb_id, 'thumbnail', false, array(
                            'class' => 'wp-post-image',
                            'alt'   => esc_attr( $product->get_name() ),
                        ) );
                    } else {
                        // اگر دوست داری همون تابع خودت صدا بخوره، با گارد:
                        if ( function_exists('prod_default_thumb') ) {
                            prod_default_thumb();
                        } else {
                            // فالبک استاندارد ووکامرس
                            $ph = wc_placeholder_img_src( 'thumbnail' );
                            echo '<img src="' . esc_url( $ph ) . '" alt="' . esc_attr( $product->get_name() ) . '" class="wp-post-image" />';
                        }
                    }
                    ?>
                </div>

                <div class="prk-sticky-title">
                    <?= esc_html( $product->get_title() ); ?>

                    <div class="prk-sticky-price mobit">
                        <div class="index-prices-pro">
                            <div class="price_onsale_ar">
                                <?php woocommerce_template_single_price(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ( $product->is_type('simple') ) : ?>
                    <div class="prk-sticky-add">
                        <div class="index-prices-pro">
                            <div class="price_onsale_ar">
                                <?php do_action( 'prk_woocommerce_add_to_cart_form' ); ?>
                            </div>
                        </div>
                    </div>

                <?php elseif ( $product->is_type('variable') ) : ?>
                    <div class="prk-sticky-add">
                        <span class="button alt go-to-add">
                            <?php _e( 'انتخاب گزینه' , 'parskala' ); ?>
                        </span>
                    </div>

                <?php elseif ( $product->is_type('external') ) : ?>
                    <div class="prk-sticky-add">
                        <?php woocommerce_external_add_to_cart(); ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    <?php
    endif;
}




add_action('prk_woocommerce_add_to_cart_form',function(){
  global $product;
  $StockQ = $product->get_stock_quantity();
  $checker = new mob_cheker;
  $signle_cart_text = get_post_meta(get_the_ID(), 'prk_add_to_cart_label', true );
  $general_cart_text = prk_option('prk_single_product_text_cart');
  $opnened_miny_cart = prk_option('opnened_miny_cart');
  if ($opnened_miny_cart) {
    $class_opened = "opnened_mcart";
  }else {
    $class_opened = "";
  }
?>
  <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>

	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

<?php if ( $product->is_purchasable() && $product->is_in_stock() ):?>

		<?php	do_action( 'woocommerce_before_add_to_cart_quantity' );

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			)
		);
		do_action( 'woocommerce_after_add_to_cart_quantity' );?>

<?php endif;?>

<?php if ( $product->is_purchasable() && $product->is_in_stock() ) :?>

	<button type="submit" name="add-to-cart"

  value="<?php echo esc_attr( $product->get_id() ); ?>"
  class="single_add_to_cart_button button alt <?php echo $class_opened;  if ( $product->is_sold_individually( )|| ($StockQ==1) ){ echo 'maxw';};?>">

  <?php

     if ( ! empty($signle_cart_text) ) {

       echo esc_html( $signle_cart_text );

     }
     elseif( ! empty($general_cart_text) ) {

       echo esc_html( $general_cart_text );

     }
     else {

       echo esc_html( $product->single_add_to_cart_text() );

     }





  ?>

  </button>

<?php endif;?>

<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	</form>
  <?php
},10,7);


// add_filter('post_class', function($classes, $class) {

//   if( is_shop() || is_product_category() ) {
//     $style_class = prk_option('prk_loop_style_product');
//     $classes = array_merge([$style_class], $classes);
//   }
//   return $classes;
// },10,3);


add_filter( 'loop_shop_per_page', 'prk_bbloomer_redefine_products_per_page', 9999 );
 
function prk_bbloomer_redefine_products_per_page( $per_page ) {
   $per_page = prk_option('prk_products_per_page_loop') ? prk_option('prk_products_per_page_loop') : '20';
   return $per_page;
}