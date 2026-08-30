<?php

// پیش بارگیری سکشن فروشنده
function element_preloder(){

  $element_preloder = '';
  $seller_preloader = prk_option('single_product_seller_preloader');
  if ($seller_preloader && is_product()) {
  ?>
  <div class="timeline-item">

     <div class="animated-background main_preload">
       <div class="background-masker header-top"></div>
     </div>

     <div class="animated-background foot_preload">
       <div class="background-masker header-top"></div>
     </div>

  </div>

  <script>

  </script>
  <?php


  return $element_preloder;

  }

}
