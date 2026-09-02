<?php
/**
 * To overwrite this template create a file name wishlist-render.php
 * and put it in your active-theme-folder/woocommerce folder
 */


$sit_wishlist_array = $sit_wishlist_ids;

if( !$sit_wishlist_array ){
    $sit_wishlist_array = [];
}

$sit_loop = new WP_Query( [
    'post_type' => 'product',
    'posts_per_page' => -1,
    'post__in' => $sit_wishlist_array
] );


echo '<div class="sit-wishlist-wrapper">';
echo '<h2 class="wishlist-title">علاقمندی ها</h2>';

//حلقه علاقمندی ها
if($sit_wishlist_array && $sit_loop->have_posts() ):

?>
<div class="w-post-list">
    <?php  while ( $sit_loop->have_posts() ) : $sit_loop->the_post();global $product;?>
  <div class="w-post-item">
    <div class="w-list-items">

      <!-- تصویر شاخص محصول -->
      <div class="w-img-list">
       <?php echo get_the_post_thumbnail();?>
      </div>

      <!-- عنوان محصول -->
      <h4 class="w-title-list"><?php echo get_the_title();?></h4>

      <!--قیمت محصول -->
      <div class="w-price-list">
        <?php echo $product->get_price_html(); ?>
      </div>

      <!--دکمه های محصول -->
      <div class="w-item-actions">
        <?php
          echo  "<button data-nonce='".wp_create_nonce('sit-wishlist')."' type='button' data-admin-url='".admin_url( 'admin-ajax.php' )."' class='w-item-del sit-btn sit-table-remove sit-wishlist-btn sit-dashboard-btn' data-post-id='".get_the_ID(  )."' data-action='remove'><i class='del-icon'></i>حذف

          <div class='onliner_main_loading'>
            <div class='content_loading'>
              <div class='loader-wrapper'>
                      ".prk_logo()."
                      <div class='loader-bullets'>
                          <i class='loader-bullet'></i>
                          <i class='loader-bullet'></i>
                          <i class='loader-bullet'></i>
                          <i class='loader-bullet'></i>
                      </div>
                  </div>
              </div>
          </div>
          </button>";
        ?>
        <a href="<?php echo get_permalink() ?>" class="w-item-views"><i class="cart-icon"></i>مشاهده محصول</a>
      </div>

     </div>
  </div>

        <?php endwhile; wp_reset_postdata(); ?>

</div>
<?php
else:
    echo "<div class='alert alert-error'>محصولی در لیست موجود نمیباشد !</div>";
endif;
echo '</div>';
