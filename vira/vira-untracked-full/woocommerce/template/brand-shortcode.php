<?php

// brand page

add_shortcode( 'prk-barnds', 'prk_brand_shortcode' );

function prk_brand_shortcode(){
global $product , $post;

$terms = get_terms([
    'taxonomy' => 'brand',
    'hide_empty' => false,
]);

  ?>
  <div class="prk_brand_page">

  <div class="brands-search">
    <form class="form_search_brndpage" action="<?php bloginfo('url');?>" method="get">
      <div class="searchpartdiv">
        <i class="prk-search-normal-1"></i>
        <input id="text_search_brands" class="input_field searchcity-input" type="text" name="s" oninput="ajax_brands_search();" value="" autocomplete="off" placeholder="جستجو در برندها">
      </div>
    </form>
  </div>
  <?php

  if ($terms) {
    echo '<div class="brands-boxed searched"></div>';
    echo '<div class="brands-boxed main">';

      foreach ($terms as $term) {

        $meta = get_term_meta( $term->term_id, 'product_brand_options', true );
        $brand_image = '';
        if (isset($meta['brand_image']))		$brand_image    = $meta['brand_image']['url'];

        $term_link = get_term_link($term, 'brand');



        if ($brand_image) {
            $thumbnail = '<img class="brand_logo" src="'.$brand_image.'" alt="brand-logo">';
        }else{
            $thumbnail = wc_placeholder_img();
        }

           echo '<article class="brand-item">';

              echo '<a href="'.$term_link.'">';

                echo $thumbnail;

                echo '<h5>'.$term->name.'</h5>';

              echo '</a>';

           echo '</article>';

      }
    echo '</div>';

  }
?>
</div>
<script>
var access_do_ajaxs_ask_brand = true;
function ajax_brands_search(){
    var length_texts = jQuery('#text_search_brands').val().length;
    if ( length_texts >= 4 && access_do_ajaxs_ask_brand ) {

      access_do_ajaxs_ask_brand = false;
        jQuery.ajax({
          type: "GET",
          url: vira_values.ajax_url ,
          data:  {
            action: 'prk_ajax_compare_brands',
            s: jQuery('#text_search_brands').val(),
            post_type: 'product',
            },
          success: function(msg1){
            jQuery('.brands-boxed.main').hide(0);
            jQuery('.brands-boxed.searched').html(msg1);
            jQuery('.brands-boxed.searched').addClass('active');

            access_do_ajaxs_ask_brand = true;
            console.log('SEARCH SUCCESS!');
          }
        });
    } else {
      jQuery('.brands-boxed.main').show(0);
      jQuery('.brands-boxed.searched').removeClass('active');
      jQuery('.brands-boxed.searched').html('');

    }
  }
</script>

<?php


}



// ajax product search compare
add_action('wp_ajax_nopriv_prk_ajax_compare_brands', 'prk_ajax_compare_brands', 999);
add_action('wp_ajax_prk_ajax_compare_brands', 'prk_ajax_compare_brands', 999);
function prk_ajax_compare_brands(){

  global $post,$product;

	$keyword = trim(esc_attr($_GET['s']));

  $brand = get_term_by('name',$keyword,'brand');
  $args = array(
    'taxonomy'               => 'brand',
    'name__like' => $keyword  ,
    'orderby'                => 'name',
    'order'                  => 'ASC',
    'hide_empty'             => false,
);
$the_query = new WP_Term_Query($args);

   if($the_query){
   foreach ($the_query->get_terms() as $term) {

     $meta = get_term_meta( $term->term_id, 'product_brand_options', true );
     $brand_image = '';
     if (isset($meta['brand_image']))		$brand_image    = $meta['brand_image']['url'];

     $term_link = get_term_link($term, 'brand');



     if ($brand_image) {
         $thumbnail = '<img class="brand_logo" src="'.$brand_image.'" alt="brand-logo">';
     }else{
         $thumbnail = wc_placeholder_img();
     }

        echo '<article class="brand-item">';

           echo '<a href="'.$term_link.'">';

             echo $thumbnail;

             echo '<h5>'.$term->name.'</h5>';

           echo '</a>';

        echo '</article>';

   }
 }else {
   echo 'موجود نیست !';
 }

	do_action('prk_after_result_search_ajax_brands', $keyword);

  $title_question = 'موضوع پرسش شما چیست؟';

	exit();
}
