<?php


add_action('wp_head', 'prk_infinite_scroll_header_function');

function prk_infinite_scroll_header_function()
{

  if( prk_option('ajax_prod_auto') == '1' && ( is_shop() || is_product_category() ) )
  {

    update_option('posts_per_page',12,'yes');

    $image_url = get_parent_theme_file_uri('assets/img/loader.gif' );
    $logo_uploaded = prk_option('ajax_prod_auto_image_url');

    if(isset($logo_uploaded['url']) && $logo_uploaded['url'] != '') { $image_url = $logo_uploaded['url']; }

?>

    <script type="text/javascript">

    var next_Selector = '.next' ;

    var item_Selector = '.product' ;

    var content_Selector = '.prk-product-archive-con' ;

    var image_loader = '<?php echo $image_url; ?>' ;

    </script>
    <style>
      .woocommerce-pagination{
         display: none;
      }

    </style>
<?php

    wp_enqueue_script("scroll-js",THEME_ASSETS_URI.'js/wo_infinite_scroll.js',array('jquery'),'',true);

    wp_localize_script("scroll-js","infi_scrol_ajaxurl",array('ajaxurl'=> admin_url('admin-ajax.php')) );


  }else {

    ?>

        <script type="text/javascript">

        function prk_ajax_load_product(){
        }

        </script>

    <?php
  }

}
