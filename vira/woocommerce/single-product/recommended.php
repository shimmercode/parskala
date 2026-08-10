<?Php

// count recommended
function count_recommended(){

    $recommended = '';
    if(!empty($count_recommended = get_post_meta( get_the_ID() , 'count_recommended', true)) ){
     if( $count_recommended >= 2 ){
       $count_recommended-- ;
    ?>
     <div class="guaranteed_product">
       <i class="ri-thumb-up-fill"></i>
       <p><?php echo __('بیش از', 'parskala') ?> <?php echo $count_recommended; ?> <?php echo __('نفر از خریداران این', 'parskala') ?>
          <?php echo __('محصول را پیشنهاد داده‌اند.', 'parskala') ?>
       </p>
       <div class="ri-information-line toplips-icon">
        <span class="tooltiptext">خریداران کالا با انتخاب یکی از گزینه‌های پیشنهاد یا عدم پیشنهاد، تجربه خرید خود را با کاربران به اشتراک می‌گذارند.</span>
       </div>
     </div>
    <?php
      }
    }
    return $recommended;
}
