<?php

	add_action('woocommerce_single_product_summary', function(){
		prk_dokan::prk_remove_class_action('woocommerce_after_single_product_summary', 'Dokan_SPMV_Products', 'show_vendor_comparison', 1);
		
		prk_dokan::prk_remove_class_action('woocommerce_product_tabs', 'Dokan_SPMV_Products', 'show_vendor_comparison_inside_tab');
        prk_dokan::prk_remove_class_action('woocommerce_order_details_after_order_table', 'Dokan_SPMV_Products', 'generate_support_button_customer_order_page',11);


        $enable_option = dokan_get_option( 'enable_pricing', 'dokan_spmv', 'off' );
        $display_position = dokan_get_option( 'available_vendor_list_position', 'dokan_spmv', 'below_tabs' );

        if (  $enable_option == 'off' ) {
            return;
        }

		if ( 'below_tabs' == $display_position ) {
          if ( mobile_cheker() || tablet_cheker() ) {
            add_action( 'woocommerce_after_single_product_summary', 'prk_show_vendor_comparison_mobile' , 1 );
					}else {
						add_action( 'woocommerce_after_single_product_summary', 'prk_show_vendor_comparison' , 1 );
					}

        } else if ( 'inside_tabs' == $display_position ) {


        } else if ( 'after_tabs' == $display_position  ) {
					if ( mobile_cheker() || tablet_cheker() ) {
						add_action( 'woocommerce_after_single_product_summary', 'prk_show_vendor_comparison_mobile' , 12 );
					}else {
						add_action( 'woocommerce_after_single_product_summary', 'prk_show_vendor_comparison' , 12 );
					}


        }


	}, 1);


function prk_get_other_reseller_vendors( $product_id ) {
        global $wpdb;

        if ( ! $product_id ) {
            return false;
        }

        $has_multivendor = get_post_meta( $product_id, '_has_multi_vendor', true );

        if ( empty( $has_multivendor ) ) {
            return false;
        }

        $sql     = "SELECT `product_id` FROM `{$wpdb->prefix}dokan_product_map` WHERE `map_id`= '$has_multivendor' AND `product_id` != $product_id AND `is_trash` = 0";
        $results = $wpdb->get_results( $sql );

        if ( $results ) {
            return $results;
        }

        return false;
    }


	function prk_show_vendor_comparison(){
        global $product;

        if ( ! $product ) {
            return;
        }

        $lists = prk_get_other_reseller_vendors( $product->get_id() );

        if ( $lists ) {
            ?>
            <div class="prk-dokan-other-vendor-camparison" id="prk-othervendors">
              <div class="head-product">


                <h3 class="seller-list-title">
									<span class="titles-pro">
									<span>
                    <?php echo dokan_get_option( 'available_vendor_list_title', 'dokan_spmv', __( 'Other Available Vendor', 'dokan' ) ); ?>
										</span>
										</span>
                </h3>
                  </div>
                <div class="prk-dokan-other-vendor-camparison-table sellers-box">
                  <div class="sellers-section sellers-section-main">


                    <?php foreach ( $lists as $key => $list ): ?>
                        <?php
                            $product_obj    = wc_get_product( $list->product_id );
                            $vendor_id = get_post_field( 'post_author', $product_obj->get_id() );
                            $seller_info    = dokan_get_store_info( $vendor_id );
                            $rating_count   = $product_obj->get_rating_count();
                            $review_count   = $product_obj->get_review_count();
                            $average        = $product_obj->get_average_rating();

														// stills variations
												    $stills_count = ! empty( get_user_meta( $vendor_id, 'dokan_consent', true ) ) ? get_user_meta( $vendor_id, 'dokan_consent', true ) : 96;
												    $supply = ! empty( get_user_meta( $vendor_id, 'dokan_supply', true ) ) ? get_user_meta( $vendor_id, 'dokan_supply', true ) : 89;
												    $Commitmentـsend = ! empty( get_user_meta( $vendor_id, 'dokan_Commitment', true ) ) ? get_user_meta( $vendor_id, 'dokan_Commitment', true ) : 91;
												    $Noـreference = ! empty( get_user_meta( $vendor_id, 'dokan_reference', true ) ) ? get_user_meta( $vendor_id, 'dokan_reference', true ) : 87;
												    $stills =     get_user_meta( $vendor_id, 'stills_types', true );

													$stills_name = __('great','vira');
													if ($stills == 'great'){
													 $stills_name = __('great','vira');
													 $stills_color = '#00a049';
													}elseif($stills == 'very_good'){
													 $stills_name = __('very good','vira');
													$stills_color = '#b1b64d';
													}elseif($stills == 'good'){
													 $stills_name = __('good','vira');
													 $stills_color = '#b1b64d';
													}elseif($stills == 'medium'){
													 $stills_name = __('medium','vira');
													 $stills_color = '#b1b64d';
													}

	                          if( get_user_meta( $vendor_id, 'dokan_feature_seller', true) == 'yes' ) {
														  	$good_class = 'good';
														}else {
														  	$good_class = '';
														}

                            if ( ! $product_obj->is_visible() ) {
                                continue;
                            }


														$garrantie = get_post_meta( $list->product_id, 'product_granti_text', true);
                        ?>

					<div class="sellers-section-row sellers-section-row-head <?php echo ( $list->product_id == $product->get_id() ) ? 'active-prk-dokan-other-vendor-row' : ''; ?>">

						<div class="sellers-section-cell sellers-section-cell-title">

             <p class="sellers-section-cell-title-wrapper">

              <i class="ri-store-3-line <?php echo $good_class;?>"></i>
							<span  class="container_store_name">
								 <a class="store_name" href="<?php echo dokan_get_store_url( $vendor_id ); ?>">

									 <?php echo $seller_info['store_name'];

									 if( get_user_meta( $vendor_id, 'dokan_feature_seller', true) == 'yes' ) {
										 echo ' <span class="good-seller">' .__('Chosen','vira'). '</span>';
									 }

									  ?>
								 </a>

					          <span class="seller-rate-container">
					             <span class="seller-rate fa-num"><?php echo $stills_count;?>%</span>
					             <span class="label"><?= _e ('Buyer satisfaction','vira');?></span>
					             <span class="divider"></span>
					             <span class="label"><?php _e ('Function','vira');?></span>
					             <span style="color:<?php echo $stills_color;?>" class="seller-final-score <?php echo $good_class;?>"><?php echo $stills_name;?></span>
					           </span>

							 </span>
             </p>

						</div>

            <?php if ( $product_obj->is_purchasable() && $product_obj->is_in_stock() ):?>

						<div class="sellers-section-cell sellers-section-cell-delivery now">
							<i class="ri-truck-line"></i>
							<p class="">آماده ارسال</p>
							<p class="hidden"></p>
							<div class="prk-tooltip-holder">
								<span class="prk-tooltip-sign"></span>
								<div class="prk-tooltip-container is-right">
									<div class="prk-tooltip-arrow"></div>
									<p class="prk-tooltip-text">این محصول موجود و آماده ارسال می باشد.</p>
								</div>
							</div>
						<p></p>
						</div>

						<?php endif; ?>
            <?php if ($garrantie): ?>

							<div class="sellers-section-cell sellers-section-cell-garanty">
								<i class="ri-shield-check-line"></i>
									<span>
									<?php echo $garrantie;?></span>
							</div>
          <?php endif; ?>



						<div class="sellers-section-cell sellers-section-cell-price">

							<?php echo wc_price($product_obj->get_price()); ?>

						</div>


						<div class="sellers-section-cell sellers-section-cell-buy">

							<?php //echo woocommerce_template_loop_add_to_cart( $list->product_id ); ?>
                            <?php if ( 'simple' == $product_obj->get_type() ): ?>
                                <?php
                                echo sprintf( '<a href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s" title="%s">%s</a>',
                                    esc_url( $product_obj->add_to_cart_url() ),
                                    1,
                                    esc_attr( $product_obj->get_id() ),
                                    esc_attr( $product_obj->get_sku() ),
                                    'button_border product_type_simple add_to_cart_button',
                                    __( 'Add to cart', 'dokan' ),
                                    __( 'Add to cart', 'dokan' )
                                );
                                ?>
                            <?php elseif ( 'variable' == $product_obj->get_type() ) : ?>
                                <a href="<?php echo $product_obj->get_permalink(); ?>" class="button_border product_type_variable add_to_cart_button" title="<?php _e( 'Add to cart', 'dokan' ); ?>"><?php _e( 'Add to cart', 'dokan' ); ?></a>
                            <?php endif ?>
						</div>

					</div>

                    <?php endforeach ?>

                </div>
            </div>
							</div>
            <?php
        }
    }




		function prk_show_vendor_comparison_mobile(){
	        global $product;

	        if ( ! $product ) {
	            return;
	        }

	        $lists = prk_get_other_reseller_vendors( $product->get_id() );

	        if ( $lists ) {
	            ?>

							<!-- start of quick-view-modal -->
							<div class="remodal modal-feed remodal-lg remodal-maxed modal-more-seller" data-remodal-id="modal-more-seller" data-remodal-options="hashTracking: false">

								<div class="remodal-header">
									 <span class="title-feed">
										 <?php echo dokan_get_option( 'available_vendor_list_title', 'dokan_spmv', __( 'Other Available Vendor', 'dokan' ) ); ?>
									 </span>
									 <button data-remodal-action="close" class="remodal-close"></button>
							   </div>

	                <div class="prk-dokan-other-vendor-camparison-table sellers-box">
	                  <div class="sellers-section sellers-section-main">


	                    <?php foreach ( $lists as $key => $list ): ?>
	                        <?php
	                            $product_obj    = wc_get_product( $list->product_id );
	                            $vendor_id = get_post_field( 'post_author', $product_obj->get_id() );
	                            $seller_info    = dokan_get_store_info( $vendor_id );
	                            $rating_count   = $product_obj->get_rating_count();
	                            $review_count   = $product_obj->get_review_count();
	                            $average        = $product_obj->get_average_rating();

															// stills variations
													    $stills_count = ! empty( get_user_meta( $vendor_id, 'dokan_consent', true ) ) ? get_user_meta( $vendor_id, 'dokan_consent', true ) : 96;
													    $supply = ! empty( get_user_meta( $vendor_id, 'dokan_supply', true ) ) ? get_user_meta( $vendor_id, 'dokan_supply', true ) : 89;
													    $Commitmentـsend = ! empty( get_user_meta( $vendor_id, 'dokan_Commitment', true ) ) ? get_user_meta( $vendor_id, 'dokan_Commitment', true ) : 91;
													    $Noـreference = ! empty( get_user_meta( $vendor_id, 'dokan_reference', true ) ) ? get_user_meta( $vendor_id, 'dokan_reference', true ) : 87;
													    $stills =     get_user_meta( $vendor_id, 'stills_types', true );

													    $stills_name = __('great','vira');
													    if ($stills == 'great'){
													     $stills_name = __('great','vira');
													     $stills_color = '#00a049';
													    }elseif($stills == 'very_good'){
													     $stills_name = __('very good','vira');
													    $stills_color = '#b1b64d';
													    }elseif($stills == 'good'){
													     $stills_name = __('good','vira');
													     $stills_color = '#b1b64d';
													    }elseif($stills == 'medium'){
													     $stills_name = __('medium','vira');
													     $stills_color = '#b1b64d';
													    }

		                          if( get_user_meta( $vendor_id, 'dokan_feature_seller', true) == 'yes' ) {
															  	$good_class = 'good';
															}else {
															  	$good_class = '';
															}

	                            if ( ! $product_obj->is_visible() ) {
	                                continue;
	                            }


															$garrantie = get_post_meta( $list->product_id, 'product_granti_text', true);
	                        ?>

						<div class="sellers-section-row sellers-section-row-head <?php echo ( $list->product_id == $product->get_id() ) ? 'active-prk-dokan-other-vendor-row' : ''; ?>">

							<div class="sellers-section-cell sellers-section-cell-title">

	             <p class="sellers-section-cell-title-wrapper">

	              <i class="ri-store-3-line <?php echo $good_class;?>"></i>
								<span  class="container_store_name">
									 <a class="store_name" href="<?php echo dokan_get_store_url( $vendor_id ); ?>">

										 <?php echo $seller_info['store_name'];

										 if( get_user_meta( $vendor_id, 'dokan_feature_seller', true) == 'yes' ) {
											 echo ' <span class="good-seller">' .__('Chosen','vira'). '</span>';
										 }

										  ?>
									 </a>

						          <span class="seller-rate-container">
						             <span class="seller-rate fa-num"><?php echo $stills_count;?>%</span>
						             <span class="label"><?= _e('Official') ?></span>
						             <span class="divider"></span>
						             <span class="label"><?= _e('Function') ?></span>
						             <span style="color:<?php echo $stills_color;?>" class="seller-final-score <?php echo $good_class;?>"><?php echo $stills_name;?></span>
						           </span>

								 </span>
	             </p>

							</div>

	            <?php if ( $product_obj->is_purchasable() && $product_obj->is_in_stock() ):?>

							<div class="sellers-section-cell sellers-section-cell-delivery now">
								<i class="ri-truck-line"></i>
								<p class="">آماده ارسال</p>
								<p class="hidden"></p>
								<div class="prk-tooltip-holder">
									<span class="prk-tooltip-sign"></span>
									<div class="prk-tooltip-container is-right">
										<div class="prk-tooltip-arrow"></div>
										<p class="prk-tooltip-text">این محصول موجود و آماده ارسال می باشد.</p>
									</div>
								</div>
							<p></p>
							</div>

							<?php endif; ?>
	            <?php if ($garrantie): ?>

								<div class="sellers-section-cell sellers-section-cell-garanty">
									<i class="ri-shield-check-line"></i>
										<span>
										<?php echo $garrantie;?></span>
								</div>
	          <?php endif; ?>



							<div class="sellers-section-cell sellers-section-cell-price">

								<?php echo wc_price($product_obj->get_price()); ?>

							</div>


							<div class="sellers-section-cell sellers-section-cell-buy">

								<?php //echo woocommerce_template_loop_add_to_cart( $list->product_id ); ?>
	                            <?php if ( 'simple' == $product_obj->get_type() ): ?>
	                                <?php
	                                echo sprintf( '<a href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s" title="%s">%s</a>',
	                                    esc_url( $product_obj->add_to_cart_url() ),
	                                    1,
	                                    esc_attr( $product_obj->get_id() ),
	                                    esc_attr( $product_obj->get_sku() ),
	                                    'button_border product_type_simple add_to_cart_button',
	                                    __( 'Add to cart', 'dokan' ),
	                                    __( 'Add to cart', 'dokan' )
	                                );
	                                ?>
	                            <?php elseif ( 'variable' == $product_obj->get_type() ) : ?>
	                                <a href="<?php echo $product_obj->get_permalink(); ?>" class="button_border product_type_variable add_to_cart_button" title="<?php _e( 'Add to cart', 'dokan' ); ?>"><?php _e( 'Add to cart', 'dokan' ); ?></a>
	                            <?php endif ?>
							</div>

						</div>

	                    <?php endforeach ?>

	                </div>
	            </div>

									</div>
	            <?php
	        }
	    }
