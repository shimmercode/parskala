<?php
//
if (class_exists( 'WooCommerce' )){

?>

<?php if ( empty(mobile_cheker() ) && empty( tablet_cheker() ) && is_front_page() || is_product() ): ?>

  <?php if ( prk_header_btn_sticky() ): ?>

    <?php if ( mobile_cheker() || tablet_cheker() ): ?>
      <a class="prk_open_mini_cart" href="<?php echo wc_get_cart_url(); ?>">
        <em class="mini_cart_counter"><?php PRK_cart_count(); ?></em>
        <i class="prk-shopping-cart"></i>
      </a>
    <?php else: ?>
      <div class="prk_open_mini_cart">
        <em class="mini_cart_counter"><?php PRK_cart_count(); ?></em>
        <i class="prk-shopping-cart"></i>
      </div>
    <?php endif; ?>

  <?php endif; ?>

<?php endif; ?>

<script type="text/javascript">

// دکمه باز کردن مینی سبد خرید
jQuery("div.prk_open_mini_cart").on("click", function () {
  jQuery("#cart-sidebar").addClass("nasa-active");
  jQuery(".prk_open_mini_cart").addClass("close");
  jQuery("html").addClass("inner_hidden");
  jQuery(".navigation-overlay").fadeIn(100);
});

</script>


<div id="cart_content_modal">
  <div class="prk-carts">
    <div class="header-carter">
      <button class="close-box cart_modal"></button>
      <span><?php _e('You have selected these products', 'parskala'); ?><em class="em-plus"><?= elessi_mini_coun_cart(); ?></em></span>
    </div>
    <div class="main-cart">
      <?php echo woocommerce_mini_cart();?>
    </div>
  </div>
</div>

<script type="text/javascript">
// mini cart modal
jQuery(".cart-modal").on("click", function () {
  if ( ! jQuery('body').hasClass('elementor-editor-active') ) {
    jQuery("#cart-sidebar").addClass("nasa-active");
    jQuery(".prk_open_mini_cart").addClass("close");
    jQuery("html").addClass("inner_hidden");
    jQuery(".navigation-overlay").fadeIn(100);
  }
});

// close mini cart modal
jQuery(".close-box.cart_modal").on("click", function () {

  jQuery("#cart-sidebar").removeClass("nasa-active");
  jQuery(".prk_open_mini_cart").removeClass("close");
  jQuery("html").removeClass("inner_hidden");
  jQuery(".navigation-overlay").fadeOut(100);

});

</script>



<?php

}
