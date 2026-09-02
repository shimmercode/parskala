<?php

// نمایش توضیحات کوتاه محصول

function exerpt_content(){
  $exerpt_content = "";
  $top_bio = prk_option('single_product_top_bio');
  global $post;
  $short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );
  if ($top_bio && $short_description)
  echo
  '<div class="excerpt_product">
    <div class="short_excerpt">
    '. $short_description.'
    </div>
  <a href="#" class="mask-handler"><span class="show-more">نمایش بیشتر</span><span class="show-less">- بستن</span></a>
  </div>';



  return $exerpt_content;

}
