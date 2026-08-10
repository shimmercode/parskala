<?php
/**
 * The compare page template file
 *
 * @version 1.0.8
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'prk-compare', 'prk_compare' );

function prk_compare($atts){


	 ?>

<div class="prk_compare_page" style="margin-top:20px;">

<?php

$compare_page = prk_option('compare_page');

$arms = array(
	 'post_type' => 'page',
	 'posts_per_page' => '1',
	 'post_status' => 'publish',
	 'post__in' => array($compare_page),
);



$pd_query = new WP_Query( $arms ); ?>
<?php if ( $pd_query ->have_posts() ) : ?>
 <?php while ( $pd_query ->have_posts() ) : $pd_query ->the_post(); ?>
<?php $compare_short = get_permalink(); ?>
 <?php endwhile; ?>
 <?php wp_reset_postdata(); ?>
 <?php endif;


    $current_page = $compare_short;

		$all_product = @$_GET['products'];
		$array_products = explode(',', $all_product);

		$prk_compare = new prk_Products_Compare_Frontend();
		$products = $prk_compare->get_compared_products();
		global $post,$product;
		if ( $products ) {
			$counter = 0;
			echo '<ul class="main_products" id="top_products_table_compare" >';
			foreach ( $products as $post ) { setup_postdata( $post );
				$product = wc_get_product( $post );
					if ( ! prk_is_product( $product ) ) {
						continue;
					}	?>
				<li>

					<?php the_post_thumbnail('shop_catalog'); ?>
					<h2><?php echo wp_trim_words(get_the_title(),8,'...') ;?></h2>
					<?php echo wc_price( $product->get_price() ); ?>
					<a class="compare_permalink_product" href="<?php the_permalink(); ?>"><?php esc_html_e( 'مشاهده و خرید محصول', 'parskala' ); ?></a>

					<?php

					$product_ids = array();

					foreach( $array_products as $product_id ){

						if( $product_id == $post ) continue;

						$product_ids[] = $product_id;
					}

					$product_ids = @implode(',', $product_ids);
					?>


					<a class="remove_from_table_compare" href="<?php echo $compare_short;?><?php echo '?products='.$product_ids; ?>" >×</a>
				</li>
		<?php $counter++; }

     if (mobile_cheker() || tablet_cheker() ) {
      	$counter_num = '2';
		}else {
			  $counter_num = '4';
		}

		if ( $counter < $counter_num ){ ?>

			<li class="add_product_to_compare" data-remodal-target="prk-add-compare" >
				<button><?php esc_html_e( 'برای افزودن کالا به لیست مقایسه کلیک کنید', 'parskala' ); ?></button>
				<span class="add_to_compare"><?php esc_html_e( 'افزودن کالا به مقایسه', 'parskala' ); ?></span>
			</li>


		<?php }

			echo '</ul>';

		?>


						<?php
						$headers = $prk_compare->get_product_meta_headers( $products );

						foreach ( $headers as $header ) { ?>

								<h3 class="title_attribiut <?php echo $header; ?>">
									<?php
									if ( 'stock' === $header ) {
										esc_html_e( 'موجود', 'woocommerce-products-compare' );

									}

									elseif ( 'sku' === $header ) {
										esc_html_e( 'شناسه', 'woocommerce-products-compare' );

									} else {
										echo wc_attribute_label( $header );
									}
									?>
								</h3>
				<ul class="attributes_value <?php echo $header; ?>" >
								<?php foreach ( $products as $product ) {
									$product = wc_get_product( $product );

									if ( ! prk_is_product( $product ) ) {
										continue;
									}

									$post = get_post( $product->get_id() );
									$attributes = $product->get_attributes();
								?>
									<li class="product" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
										<?php
										if ( 'stock' === $header && $product->managing_stock() ) {
											$class = $product->get_availability()['class'];
											$availability = $product->get_availability()['availability'];

											echo '<span class="stock-status ' . esc_attr( $class ) . '">' . $availability . '</span>' . PHP_EOL;

										}

										elseif ( 'sku' === $header ) {
											echo $product->get_sku();

										} elseif ( array_key_exists( sanitize_title( $header ), $attributes ) ) {

											if ( $attributes[ sanitize_title( $header ) ]['is_taxonomy'] ) {

												$values = wc_get_product_terms( $product->get_id(), $attributes[ sanitize_title( $header ) ]['name'], array( 'fields' => 'names' ) );
												echo apply_filters( 'woocommerce_attribute2', wpautop( wptexturize( implode( ', ', $values ) ) ), $attributes[ sanitize_title( $header ) ], $values );
											} else {

												// Convert pipes to commas and display values.
												$values = array_map( 'trim', explode( WC_DELIMITER, $attributes[ sanitize_title( $header ) ]['value'] ) );
												echo apply_filters( 'woocommerce_attribute2', wpautop( wptexturize( implode( ', ', $values ) ) ), $attributes[ sanitize_title( $header ) ], $values );
											}
										}
										?>
									</li>
								<?php } ?>
							</ul>
						<?php } ?>



						<div class="remodal view_product prk_add_compare remodal-maxed remodal-lg remodal-is-initialized remodal-is-opened"
						 data-remodal-id="prk-add-compare" data-remodal-options="hashTracking: false" tabindex="-1">


						<div class="remodal-header">
								<span class="remodal-title">افزودن به لیست مقایسه</span>
								<button data-remodal-action="close" class="remodal-close"></button>
						</div>

                    <div class="modal-content">

										<div class="compare-search">
											<form class="form_search_faqpage" action="<?= $compare_short?>" method="get">
												<div class="searchpartdiv">
													<i class="prk-search-normal-1"></i>
													<input id="text_search_compare" class="input_field searchcity-input" type="text" name="s" oninput="ajax_compare_search();" value="" autocomplete="off" placeholder="جستجو در محصولات">
													<!-- <input class="search-submit" type="submit" value="<?php echo __('جستجو','parskala') ?>"> -->
												</div>
											</form>
										</div>

						<?php

							$first_product_id = $array_products[0];
            	$terms = get_the_terms( $first_product_id, 'product_cat' );
							$args = array(
								'post_type' => 'product',
								'posts_per_page' => 10,
                'post__not_in' => $array_products,
							);
							$query = new WP_Query( $args );

							if ( $query->have_posts() ) :
								echo '<div class="column">';
								echo '<ul class="list_products_add_to_compare searched"></div>';
								echo '<ul class="list_products_add_to_compare">';

								while ( $query->have_posts() ) : $query->the_post(); ?>

									<li>
										<a href="<?php echo $compare_short;?><?php echo '?products='.$_GET['products'].','.$post->ID; ?>" >
											<?php the_post_thumbnail(); ?>
											<h2><?php the_title(); ?></h2>
										</a>
									</li>

								<?php
								endwhile;

								echo '</ul>';

								if (  $query->max_num_pages > 1 ){ ?>

									<div class="misha_loadmore"><?php esc_html_e( 'محصولات بیشتر', 'parskala' ); ?></div>
								<?php }
                 echo '</div>';
								wp_reset_postdata();

							else :
								echo '<p>'. __('محصول دیگری برای مقایسه وجود ندارد.', 'parskala') .'</p>';
							endif;


						?>


                    </div>

										<script>
											var access_do_ajaxs_ask_compare = true;
											function ajax_compare_search(){
													var length_texts = jQuery('#text_search_compare').val().length;
													if ( length_texts >= 4 && access_do_ajaxs_ask_compare ) {

														access_do_ajaxs_ask_compare = false;
															jQuery.ajax({
																type: "GET",
																url: parskala_values.ajax_url ,
																data:  {
																	action: 'prk_ajax_compare_search',
																	s: jQuery('#text_search_compare').val(),
																	post_type: 'product',
																	data_string: "<?php echo $_GET['products']; ?>"
																	},
																success: function(msg1){
																	jQuery('.list_products_add_to_compare').hide(0);
																	jQuery('.misha_loadmore').hide(0);
																	jQuery('.list_products_add_to_compare.searched').html(msg1);
																	jQuery('.list_products_add_to_compare').addClass('active');
																	// jQuery('.faq_headerbox .circle_btn_icon').html('<i class="ri-search-2-line"></i>');
																	// jQuery('.faq_headerbox .page_title').html('نتایج جستجو');
																	// jQuery('.faq_headerbox .page_subtitle').addClass('fadeOut');
																	access_do_ajaxs_ask_compare = true;
																	console.log('SEARCH SUCCESS!');
																}
															});
													} else {
														jQuery('.list_products_add_to_compare').show(0);
														jQuery('.misha_loadmore').show(0);
														jQuery('.list_products_add_to_compare.searched').removeClass('active');
														jQuery('.list_products_add_to_compare.searched').html('');
														// jQuery('.faq_headerbox .circle_btn_icon').html('<i class="ri-question-mark"></i>');
														// jQuery('.faq_headerbox .page_title').html('<?php echo $title_question; ?>');
														// jQuery('.faq_headerbox .page_subtitle').removeClass('fadeOut');
													}
												}


											jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error

												var current_page = <?php echo get_query_var( 'paged' ) ? get_query_var('paged') : 1; ?>;
												var max_page = <?php echo $query->max_num_pages; ?>;

												$('.misha_loadmore').click(function(){

													var button = $(this),
														data = {
														'action': 'loadmore',
														'products': '<?php echo $_GET['products']; ?>',
														'query': '<?php echo json_encode( $query->query_vars ); ?>', // that's how we get params from wp_localize_script() function
														'page' : current_page
													};

													console.log(current_page);

													$.ajax({ // you can also use $.post here
														url : "<?php echo site_url() . '/wp-admin/admin-ajax.php'; ?>", // AJAX handler
														data : data,
														type : 'POST',
														beforeSend : function ( xhr ) {
															button.text('<?php esc_html_e( 'در حال بارگذاری...', 'parskala' ); ?>'); // change the button text, you can also add a preloader image
														},
														success : function( data ){
															if( data ) {
																button.text( '<?php esc_html_e( 'محصولات بیشتر', 'parskala' ); ?>' );
																$('.list_products_add_to_compare').append(data); // insert new posts
																current_page++;

																if ( current_page == max_page )
																	button.hide(); // if last page, remove the button

																// you can also fire the "post-load" event here if you use a plugin that requires it
																// $( document.body ).trigger( 'post-load' );
															} else {
																button.hide(); // if no data, remove the button as well
															}
														}
													});
												});
											});

										</script>

                </div>





		<?php } else {
			/*
        status_header( 404 );
        nocache_headers();
        include( get_query_template( '404' ) );
        die();
		*/
		?>

		<div class="empty_compare"><?php _e('محصولی برای مقایسه وجود ندارد.', 'parskala'); ?></div>

		<?php } ?>
</div>

<?php







 } ?>
