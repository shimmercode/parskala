<?php 
class iWC_Orderby_Stock_Status
{
    public function __construct()
    {
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins') )) ) {
            add_filter('posts_clauses', array($this, 'order_by_stock_status'), 2000);
        }
    }

    public function order_by_stock_status($posts_clauses)
    {
        global $wpdb;
        if (!is_page() && !is_single() && !is_admin() && is_woocommerce() && is_archive() ) {
            $posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
            $posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
            $posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
        }
        return $posts_clauses;
    }
}
new iWC_Orderby_Stock_Status;