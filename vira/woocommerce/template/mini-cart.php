<span class="cart-btn"><i class="fal fa-shopping-cart"></i> <em><?php herowp_cart_count(); ?></em>
  <div class="mini-cart-user">
   <span class="head-mini">
    <i class="count-mini"><?php herowp_cart_count(); ?><?php _e('products' , 'vira');?></i>
    <a class="cart-mini" href="<?php echo wc_get_cart_url(); ?>"><?php _e('view cart' , 'vira');?></a>
   </span>
    <?php  herowp_cart_mini(); ?>
  </div>
</span>
