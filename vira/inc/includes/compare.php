<?php


function misha_loadmore_ajax_handler(){


	global $post;


	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );



$args = array(
	'post_type' => 'product',
	'posts_per_page' => $args['posts_per_page'],
	'post__not_in' => $args['post__not_in'],

);
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';
	// it is always better to use WP_Query but not here
	$myposts = get_posts( $args );



foreach ( $myposts as $post ) : setup_postdata( $post ); ?>

									<li>
										<a href="<?php echo $compare_short .'?products='.$_POST['products'].','.$post->ID; ?>" >
											<?php the_post_thumbnail('shop_catalog'); ?>
											<h2><?php the_title(); ?></h2>
										</a>
									</li>
<?php endforeach;
wp_reset_postdata();
	die; // here we exit the script and even no wp_reset_query() required!
}



add_action('wp_ajax_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}
