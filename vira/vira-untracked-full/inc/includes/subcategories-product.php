<?php
defined('ABSPATH') || exit('No Access!');

function prk_subcategories_product(){
    $shempty_subcategories = prk_option('hide_product_subcategories') == '1' ? prk_option('hide_product_subcategories') : false;

$terms = get_terms([
    'taxonomy' => 'product_cat',
    'hide_empty' => $shempty_subcategories,
    'parent' => get_queried_object_id()
]);
$count = count($terms);
$i = 0;
?>
<?php if (is_array($terms) && $count && ( prk_option('archive_product_subcategories') == '1' || prk_option('archive_product_subcategories') == '' )): ?>

    <div class="subcategories-list <?= prk_option('archive_product_subcategories_style') ?>">

        <?php if ( (prk_option('archive_product_subcategories_title') || prk_option('archive_product_subcategories_title') ==null) && (prk_option('archive_show_subcategories_title') == '1' || prk_option('archive_show_subcategories_title') == '') ):?>
          <div class="categories-title"><?= prk_option('archive_product_subcategories_title') == null ? 'دسته‌بندی‌ها' : prk_option('archive_product_subcategories_title');  ?></div>
        <?php endif;?>

        <div class="row">
            <?php foreach ($terms as $term): ?>
                <?php
                $defualt_thumb = prk_option('prk_defualt_thumb_pr');
                $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                ?>
                <div class="item item-<?php echo $i; ?>">
                    <a href="<?php echo get_term_link($term, 'product_cat'); ?>" class="term term-<?php echo $term->term_id; ?>">
                        <?php
                            if ($thumbnail_id){
                                echo  wp_get_attachment_image($thumbnail_id, 'woocommerce_thumbnail', false, ['class' => 'img-fluid']);
                            }elseif($defualt_thumb['url']){
                                echo prod_defualt_thumb();
                            }
                            else{
                                echo wc_placeholder_img();
                            }
                        ?>
                        <h2 class="term-name"><?= $term->name ?></h2>

                        <?php if ( prk_option('archive_product_subcategories_count') == '1' || prk_option('archive_product_subcategories_count') == '' ): ?>

                           <span class="term-count"><?php echo number_format($term->count); ?></span>

                        <?php endif;?>
  
                    </a>
                </div>
                <?php if ($i == 6 && $count > 7): ?>
                    <div class="item others-categories">
                        <a href="#" class="term">
                            <div class="count">+<?php echo $count - 7; ?></div>
                            <div class="term-name">دسته‌بندی دیگر</div>
                        </a>
                    </div>
                <?php endif; ?>
                <?php $i++; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif;

}