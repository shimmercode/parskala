



    <div class="prk-next-shoppingcart-card-body woocommerce-cart-form cart-order-user">

        <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">

            <tbody>
            <?php

            $user_id = get_current_user_id() ;
            $list = $db->get_users_next_shoppingcart($user_id);
            foreach ($list as $item){
                $thumbnail = get_the_post_thumbnail_url(esc_html($item->product_id),150);
                if (!$thumbnail){ $thumbnail = wc_placeholder_img_src( 150 ) ;}
                $product_price = esc_html($item->product_price);
                $product_id = esc_html($item->product_id);
                $product = wc_get_product( $product_id );
                $product_name = esc_html($product->get_name());
                $permalink =  $url = get_permalink( $product_id ) ;
                $onsales_round = get_post_meta($product_id, 'onsales_round', true );
                // تنظیمات گارانتی
                $general_show_granti = prk_option('single_product_Warranty');
                $granti_show = get_post_meta($product_id, 'product_granti_show', true );
                $granti_text = general_granty_value();
                if (prk_option('gard_icon')) {
                  $gard_icon = prk_option('gard_icon');
                }else {
                  $gard_icon = 'ri-shield-check-line';
                }
                ?>
                <tr class="woocommerce-cart-form__cart-item cart_item">



                    <td class="product-thumbnail">

                        <a href="<?php echo $permalink;?> ">
                            <img width="247" height="296" src="<?php echo esc_url($thumbnail);?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" loading="lazy">
                        </a>
                        <a class="Delete-product card-btn remove" data-product_id="<?php echo $product_id;?>">×</a>
                        <?php
                        if ($onsales_round) {

            							echo '<span class="onsale prs" >پیشنهاد ویژه !</span>';

            						}elseif ($product->is_on_sale()) {

                          echo '<span class="onsale prs" >فروش ویژه !</span>';

            						}
                         ?>
                    </td>

                    <td class="product-name" data-title="<?php _e('محصول',NEXT_SHOPPING_LIST);?>">
                        <a class="product_name" href="<?php echo $permalink;?>"><?php echo $product_name;?></a>
                        <?php
                        if ($general_show_granti && $granti_show == null) {
            							echo '<div class="granti_cart">';
            							echo '<i class="icon '.$gard_icon.'"></i>';
            							echo '<span class="granti_text">'.$granti_text.'</span>';
            							echo '</div>';
            						}
                         ?>
                         <div class="flexd">

                           <div class="prk-next-shoppingcart-card-grp-btn">
                               <a class="add-to-shopping-cart" data-product_id = "<?php echo $product_id; ?>" >
                                   <i class="Icon-Action-MovetoCart"></i><?php _e('افزودن به سبد');?>
                               </a>
                           </div>

                           <div class="prk-next-shoppingcart-card-grp-btn delete_product">
                             <a class="Delete-product remove_add" data-product_id="<?php echo $product_id;?>">
                               <i class="trash-image"></i>
                               حذف</a>
                           </div>

                         </div>
                    </td>

                    <td class="product-subtotal" data-title="<?php _e('قیمت',NEXT_SHOPPING_LIST);?>">
                        <span class="woocommerce-Price-amount amount">
                            <bdi>
                                <?php echo number_format(floatval($product_price));?>
                                <span class="woocommerce-Price-currencySymbol"><?php echo get_woocommerce_currency_symbol();?></span>
                            </bdi>
                        </span>

                    </td>

                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>

    <div class="cart-collaterals collateral-order-user">
      <div class="add_to_cart_all_main">
        <strong>لیست خرید بعدی چیست؟</strong>
        <p>شما می&zwnj;توانید محصولاتی که به سبد خرید خود افزوده&zwnj;اید و فعلا قصد خرید آن&zwnj;ها را ندارید، در لیست خرید بعدی قرار داده و هر زمان مایل بودید آن&zwnj;ها را به سبد خرید اضافه کرده و خرید آن&zwnj;ها را تکمیل کنید.</p>
        <div class="count_add_next_cart"> <i><?php echo count($list);?> کالا </i>در سبد خرید بعدی شماست</div>
        <div class="add-all-to-shoppingcart" id="add-all-product"><i class="Icon-Action-MovetoCart"></i>افزودن همه به سبد خرید</div>
      </div>
    </div>
