<?Php



// costom attributes

function costom_attributes(){
global $post;
global $product;
$costom_attributes = '';

$product_attributes = prk_option('single_product_attributes');
$attr_count = prk_option('product_attributes_count');
$product_attributes_title = prk_option('product_attributes_title') ? prk_option('product_attributes_title') : 'ویژگی های محصول';
$p_featured_attributes = get_post_meta( get_the_ID(), 'prk_product_featured_attributes', true );


if ( empty($p_featured_attributes) ) {



if ( $product_attributes){
  $i = 0;
  $is_variation = $product->is_type('variation');
  $attributes = $is_variation ? wc_get_product($product->get_parent_id())->get_attributes() : $product->get_attributes();
    if (is_array($attributes) && count($attributes)) {

       echo '<div class="meta-additional"><span class="atri-single">'.$product_attributes_title.'</span>';
       echo '<span class="short-attributes"><ul class="">';


       foreach ($attributes as $attribute) {
         if($i >= $attr_count) {break;}else{
          if (!is_object($attribute) || !$attribute->get_visible() ) {
              continue;
          }
        }

        $i++;



          echo '<li class="woocommerce-product-attributes-item"><span class="item__label">' . wc_attribute_label($attribute->get_name()) . ' </span>';

          $values = array();
          if ($attribute->is_taxonomy()) {
              $attribute_taxonomy = $attribute->get_taxonomy_object();
              $attribute_values = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'all'));

              foreach ($attribute_values as $attribute_value) {
                  $value_name = esc_html($attribute_value->name);
                  if ($attribute_taxonomy->attribute_public) {
                      $values[] = '<a href="' . esc_url(get_term_link($attribute_value->term_id, $attribute->get_name())) . '" rel="tag">' . $value_name . '</a>';
                  } else {
                      $values[] = $value_name;
                  }
              }
          } else {
              $values = $attribute->get_options();
              foreach ($values as &$value) {
                  $value = make_clickable(esc_html($value));
              }
          }

          if ($i > 4) {
  ?>

  <?php
          }
          echo '<span class="item__value">: ' . apply_filters('woocommerce_attribute', wptexturize(implode(', ', $values)), $attribute, $values) . '</span>';
          echo '</li>';

      }


      echo '</ul></span>';
      if ($i > 4){
        echo '    <div class="show-mores">
            <span>+ اطلاعات بیشتر</span>
            </div>
            <script>
                jQuery(document).ready(function($){
                $(".short-attributes").addClass("disbled");

                var opens = 1;
                $(".show-mores").click(function(){
                  if ( opens == 1 ){
                    $(".short-attributes.disbled").css("max-height", "100%");
                    $(".short-attributes.disbled").css("min-height", "audio");
                    $(".show-mores span").text(" - نمایش کمتر");
                    opens = 0;
                  }else{
                    $(".short-attributes.disbled").css("max-height", "98px");
                    $(".short-attributes.disbled").css("overflow", "hidden");
                    $(".show-mores span").text(" + نمایش بیشتر");
                    opens = 1;
                  }

                });

                });

            </script>
            ';


      }
      echo '</div>';
  }

  }



  }else {

    echo '<div class="meta-additional"><span class="atri-single">'.$product_attributes_title.'</span>';
    echo '<span class="short-attributes"><ul class="">';
    $i = 0;


    foreach ($p_featured_attributes as $value) {

      echo '<li class="woocommerce-product-attributes-item"> <span class="item__label">'.$value['title'].'</span> <span class="item__label">'.$value['value'].'</span></li>';
      $i++;

      if($i >= $attr_count) {
        break;
      }
    }

    echo '</ul></span>';
    if ($i > 4){
      echo '    <div class="show-mores">
          <span>+ اطلاعات بیشتر</span>
          </div>
          <script>
              jQuery(document).ready(function($){
              $(".short-attributes").addClass("disbled");

              var opens = 1;
              $(".show-mores").click(function(){
                if ( opens == 1 ){
                  $(".short-attributes.disbled").css("max-height", "100%");
                  $(".short-attributes.disbled").css("min-height", "audio");
                  $(".show-mores span").text(" - نمایش کمتر");
                  opens = 0;
                }else{
                  $(".short-attributes.disbled").css("max-height", "98px");
                  $(".short-attributes.disbled").css("overflow", "hidden");
                  $(".show-mores span").text(" + نمایش بیشتر");
                  opens = 1;
                }

              });

              });

          </script>
          ';


    }
    echo '</div>';

  }

  return $costom_attributes;
}
