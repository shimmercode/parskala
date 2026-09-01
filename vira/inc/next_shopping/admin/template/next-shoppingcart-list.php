<?php
$postPerPage = 20;//post p page
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$offset = ($paged - 1) * $paged;
$total = count($DB->get_all());
$items_per_page = 25;
$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
$offset = ( $page * $items_per_page ) - $items_per_page;
$shopping_list = $DB->get_per_page($offset , $items_per_page);
?>
<table id="customers" class="wp-list-table widefat fixed striped table-view-list posts">
    <thead>
    <tr>
        <th class="manage-column column-name "><?php _e('نام محصول',NEXT_SHOPPING_LIST);?></th>
        <th class="manage-column column-price "><?php _e('قیمت محصول',NEXT_SHOPPING_LIST);?></th>
        <th class="manage-column column-name "><?php _e('ایمیل کاربر',NEXT_SHOPPING_LIST);?></th>
        <th id="small-width" class="manage-column "><?php _e('تنظیمات',NEXT_SHOPPING_LIST);?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    //    $shopping_list = $DB->get_all();
    foreach ($shopping_list as $each){
        ?>
        <tr>
            <td class="name column-name column-primary">
                <?php $url = admin_url("post.php?post=".$each->product_id."&action=edit"); ?>
                <a href="<?php echo $url;?>">
                    <?php esc_html_e($each->product_name,NEXT_SHOPPING_LIST ) ; ?>
                </a>
            </td>
            <td class="price column-price"><?php esc_html_e(number_format(floatval($each->product_price)) ,NEXT_SHOPPING_LIST); echo " ".get_woocommerce_currency_symbol();?></td>
            <td class="name column-name column-primary">
                <?php
                esc_html_e($each->user_name,NEXT_SHOPPING_LIST);
                ?>
            </td>
            <td ><a href="<?php echo get_permalink($each->product_id); ?>" class="gf_dashboard_button button" target="_blank"><?php _e('نمایش محصول',NEXT_SHOPPING_LIST);?></a> </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
<br>
<div class="pagination">
    <?php
    echo paginate_links( array(
        'base' => add_query_arg( 'cpage', '%#%' ),
        'format' => '',
        'prev_text' => __('&laquo;'),
        'next_text' => __('&raquo;'),
        'total' => ceil($total / $items_per_page),
        'current' => $page
    ));

    ?>
</div>