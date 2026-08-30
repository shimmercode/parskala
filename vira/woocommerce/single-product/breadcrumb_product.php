<?php



// آخرین دسته بندی و برند مربوط به محصول

function breadcrumb_product(){
 $breadcrumb_product = '';

 global $product;
 global $post;
 $product_brand = prk_option('single_product_brand');
 $show_breadcrumb = prk_option('show_breadcrumb_product');
 $brand_slug = prk_option('product_brand_slug') ? prk_option('product_brand_slug') : 'brand';
 // get last brands
 $last_brand = '';
 $last_brands = get_the_terms( $post->ID,  $brand_slug );
 if ($last_brands){
 $last_brand = array_reverse($last_brands);
 $name_iteam = $last_brand[0]->name;
 $brand = '<a href="'. get_term_link($last_brand[0]->slug,  $brand_slug ) .'">'.$name_iteam.'</a>';
 }

 // get last categorys
 $lastCat = $allCat = $link_cat = '';
 $allCats = get_the_terms( $post->ID, 'product_cat' );

 if ($allCats && !is_wp_error( $allCats )){
 $lastCat = array_reverse($allCats);
 $name = $lastCat[0]->name;
 $link_cat = get_term_link($lastCat[0]->slug, 'product_cat');
 $category = !is_wp_error( $link_cat ) ? '<a href="'. $link_cat .'">'.$name.'</a>' : '';
 }




if ( prk_option('show_breadcrumb_product') == '1'  || prk_option('show_breadcrumb_product') == '' ){

 
  if ('prk-fashion' == theme_style() ) {

    // echo brand & category
    if ($last_brand || $lastCat){

      echo '<div class="breadcrumb">';
      
      if ($product_brand == '1'){
        echo brandlogo_product();
      }

      if($lastCat){
        echo '<div class="last_breadcrumb">';
        echo '<i class="prk-folder-open"></i><strong>دسته بندی:</strong>';
        echo $category;
        echo '</div>';
      }

      if($last_brand && $product_brand == '1'){
        echo '<div class="last_breadcrumb">';
        echo '<i class="prk-ticket-star"></i><strong>'.prk_option('product_brand_name')?prk_option('product_brand_name'): 'برند'.':</strong>';
        echo $brand;
        echo '</div>';
      }

      if($last_brand){
        echo '<div class="last_breadcrumb">';
        echo '<i class="prk-star-1"></i><strong>امتیاز:</strong>';
        echo '<a href="">' .$product->get_rating_count(). '</a>';
        echo '</div>';
      }

      echo '</div>';
    }

  }
  else {

    // echo brand & category
    if ($last_brand || $lastCat){
      echo '<div class="breadcrumb">';
      if (($last_brand && $product_brand == '1') && $lastCat){
        echo brandlogo_product();

      echo $brand;
      echo '<i class="line-l">/</i>';
      echo $category;

      }elseif( $last_brand && $product_brand == '1' ){
      echo $brand;
      }elseif($lastCat){
      echo $category;
      }
      echo '</div>';
    }

  }

}



 return $breadcrumb_product;

}
