<?php


if (!function_exists('add_action'))
{
    echo "<h3>an error occured! You may not be able to access this plugin via direct URL...</h3>";
    exit();
}
else if (!defined('ABSPATH'))
{
    echo "<h3>an error occured! You may not be able to access this plugin via direct URL...</h3>";
    exit();
}
/**/

/*Fetch Products*/
add_action( 'wp_ajax_prk_ajax_product_list', 'prk_ajax_product_list' );
add_action( 'wp_ajax_nopriv_prk_ajax_product_list', 'prk_ajax_product_list' );
    
if (!function_exists('prk_ajax_product_list')){

    function prk_ajax_product_list() {

     
        $eventHandler = sanitize_text_field($_POST['eventH']);

        $number = sanitize_text_field($_POST['number']);
         $number = intval($number);
        $offset=0;
        if($eventHandler=='scroll' || $eventHandler=='scroll_no_tab'){
            $offset = sanitize_text_field($_POST['offset']);
             $offset = (intval($offset)*$number)+1;
        }
       
        $stock = sanitize_text_field($_POST['stock']);
        $type = sanitize_text_field($_POST['type']);

        $taxonomy = 'product_cat';

        if(!empty($_POST['group']) && !empty($_POST['group_ids'])){
        
                $taxonomyIds = $_POST['group_ids'];
                switch(sanitize_text_field($_POST['group'])){
                    case 'category':
                        $taxonomy = 'product_cat';
                        break;
                    case 'tag':
                        $taxonomy = 'product_tag';
                        break;
                    case 'brand':
                        $taxonomy = 'product_brand';
                        break;
                }

        }
      
      

        if($eventHandler != 'scroll_no_tab'){
        $cat = sanitize_text_field($_POST['cat']);
        $taxonomyIds = $cat;
        $seeallcat = sanitize_text_field($_POST['seeallcat']);
        $auth = sanitize_text_field($_POST['auth']);
        $seeallcat_bgcolor = sanitize_text_field($_POST['seeallcat_bgcolor']);
        $seeallcat_bgwalp = sanitize_text_field($_POST['seeallcat_bgwalp']);
        $seeallcat_link = sanitize_url($_POST['seeallcat_link']);
        $seeallcat_link_ext = sanitize_text_field($_POST['seeallcat_link_ext']);
        $seeallcat_link_follow = sanitize_text_field($_POST['seeallcat_link_follow']);
        $seeallcat_title = sanitize_text_field($_POST['seeallcat_title']);
        $seeallcat_titlecolor = sanitize_text_field($_POST['seeallcat_titlecolor']);
        
        if($seeallcat == 'yes'){

            switch($seeallcat_link){
                case '':
                    $seeallcat_link = '#';
                    break;
                default:
                    $seeallcat_link = $seeallcat_link;
                    break;
            }
            switch($seeallcat_link_ext){
                case 'on':
                    $seeallcat_link_ext = '_blank';
                    break;
                default:
                    $seeallcat_link_ext = '_self';
                    break;
            }
            switch($seeallcat_link_follow){
                case 'on':
                    $seeallcat_link_follow = 'nofollow';
                    break;
                default:
                    $seeallcat_link_follow = 'follow';
                    break;
            }
            switch($seeallcat_bgcolor){
                case '':
                    $seeallcat_bgcolor = '#00000000';
                    break;
                default:
                    $seeallcat_bgwalp = '#';
                    break;
            }
            switch($seeallcat_titlecolor){
                case '':
                    $seeallcat_titlecolor = "#000";
                    break;
            }
        }
    }

        $product_ids = $meta_key = $order = $orderby = $meta_query = '';
        switch ($type) {
            case 'featured':
                $product_ids = wc_get_featured_product_ids();
                break;
            case 'sale':
                $product_ids = wc_get_product_ids_on_sale();
                break;
            case 'bestsellings':
            case 'saled':
                $meta_key = 'total_sales';
                $order = 'DESC';
                $orderby = 'meta_value_num';
                break;
            case 'lowsellings':
                $meta_key = 'total_sales';
                $order = 'ASC';
                $orderby = 'meta_value_num';
                break;
            case 'lastedited':
                $orderby = 'modified';
                break;
            case 'olds':
                $order = 'ASC';
                break;
            case 'news':
            case 'latest':
            $order = 'DESC';
            $orderby = 'date';

            break;
            case 'rand':
            case 'random':
                $orderby = 'rand';
                break;
            default:
                $product_ids = '';
                break;
        }

        switch ($stock){
            case 'only_instocks':
            case 'yes':
                $meta_query = array(
                    array(
                        'key' => '_stock_status',
                        'value' => 'instock',
                        'compare' => '=',
                    ),
                );
                break;
            case 'only_not_instocks':
                $meta_query = array(
                    array(
                        'key' => '_stock_status',
                        'value' => 'outofstock',
                        'compare' => '=',
                    ),
                );
                break;
        }

        if (!empty($taxonomyIds)){//Cats
            $tax_query = array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $taxonomyIds,
                    'operator' => 'IN'
                ),
            );
        }else $tax_query = '';



        ob_start(); //start the output buffering

        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $number,
            'post__in'=> $product_ids,
            'meta_key' => $meta_key,
            'order' => $order,
			'orderby'  => $orderby,
            'tax_query' => $tax_query,
            'meta_query' => $meta_query,
            'offset' => $offset,
        );
        
                
        //start the loop on products
        $auth = 1;
        if ($auth == '1'){//show only to logged in users

        
        $loop = new WP_Query( $args );

        while ( $loop->have_posts()) {

            $loop->the_post();
            global $product;
            $product_label = get_post_meta(get_the_ID(), 'prk_product_label', true );
            $price = get_post_meta( get_the_ID(), '_regular_price', true);

            ?> 
            
            
            
            <article class="item-pro">

<?php if ($product_label): ?>
    <div class="custom_label"><span><?php echo $product_label;?></span></div>
<?php endif; ?>

 <a href="<?php the_permalink();?>">

        <!--thumbnail-->
        <?php echo pr_img(); ?>

   <div class="index-title-pro">
      <h2><?php echo wp_trim_words(get_the_title(),12,'...') ;?></h2>
   </div>

        <?php
          echo '<div class="index-prices-pro">';

              if ( $product->is_in_stock() ) {

                  echo '<div class="price_onsale_ar">';

                             if ($price || $product->is_type( 'variable' )) {
                                 echo $product->get_price_html();
                             }else{
                                 echo '<p class="call_pro">', _e('call' , 'parskala'). '</p>';
                             }

                  echo '</div>';

              }
             echo '</div>';
          ?>

                <?php if( $product->is_purchasable() && $product->is_in_stock()):?>


                        <div class="lists_add_to_cart">
                            <?php echo do_shortcode("[ajax_cart_item]");?>
                        </div>

               

             <?php endif;?>


   </a>
</article>
<?php 
         
            
        }
        if($eventHandler != 'scroll_no_tab'){

        if ($seeallcat == 'yes'){ ?> 
            <div class="off-product mories">
                                 <a href="<?php echo $seeallcat_link; ?>" target="<?=$seeallcat_link_ext;?>" rel="<?=$seeallcat_link_follow?>">
         
         
                                 <div class='seealcat-inner w-categorys-link' style='background-color:<?=$seeallcat_bgcolor?>; background-image: url(<?=$seeallcat_bgwalp?>);'><i class="ri-arrow-left-line"></i><p style='color:<?=$seeallcat_titlecolor;?>'> 
                                           <span><?=$seeallcat_title; ?></span></p></div>
                                
                                    
                                  </a>
                             </div>
                     <?php  }
        }
        wp_reset_postdata();
            

        }else {
            ?> <div class="prk-ajax-mssg">برای مشاهده این محصولات ابتدا وارد شوید</div> <?php
        }
        
        //render the output
        $content = ob_get_contents();
	    ob_end_clean();
	        
 	    echo $content;
       
        wp_die();
    }

}
/**/
//close the PHP tag to reduce the blank spaces


add_action('wp_head', 'defajaxurl'); //define ajaxurl on the front
function defajaxurl(){

    echo '<script type="text/javascript"> var ajaxurl = "' . admin_url('admin-ajax.php') . '"; </script>';
}


?>