<?php


/**
 *  Advanced next shopping system parskala
 *
 * @package      Advanced next shopping
 * @Author      Hosein Esmalian
 * @link        http://parskalas.ir
 */


namespace Next_Shopping_List\Includes\Init;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


class Db{
    /**
     * @var string table name
     */
    public $table_name;

    /**
     *  constructor.
     * fill table name
     */
    public function __construct() {
        global $table_prefix;
        $this->table_name = $table_prefix . NEXT_SHOPPING_LIST_TABLE;
    }

    /**
     * get all product
     * @return array list of product
     */
    public function get_all() {
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM {$this->table_name} ORDER BY CAST(product_price as unsigned) DESC");
        return $results;
    }

    /**
     * get all group by product
     * @return array
     */
    public function get_groupby_all() {
        global $wpdb;
        $results = $wpdb->get_results( "SELECT COUNT(*) as count,product_name FROM {$this->table_name} GROUP BY product_id DESC" );
        return $results;
    }

    /**
     * get products per page.
     * @param $offset
     * @param $items_per_page
     * @return array
     */
    public function get_per_page($offset , $items_per_page ) {
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM {$this->table_name} ORDER BY CAST(product_price as unsigned) DESC LIMIT {$items_per_page} OFFSET {$offset};" );
        return $results;
    }

    /**
     * get groupby items per page
     * @param $offset
     * @param $items_per_page
     * @return array
     */
    public function get_groupby_per_page($offset , $items_per_page ) {
        global $wpdb;
        $results = $wpdb->get_results( "SELECT COUNT(*) as count,product_name,product_id FROM {$this->table_name} GROUP BY product_id ORDER BY COUNT(*) DESC LIMIT {$items_per_page} OFFSET {$offset};" );
        return $results;
    }

    /**
     * Insert product to table
     * @param $product_id
     * @return bool
     */
    public function insert($product_id) {
        global $wpdb;

        $user = wp_get_current_user();
        $user_id = $user->ID;
        $user_login = $user->user_login;
        $email = $user->user_email;
        $user_name = empty($email) ? $user_login : $email;

        // بررسی وجود در سبد خرید
        foreach (WC()->cart->get_cart() as $item) {
            if ($item['product_id'] == $product_id) {
                $product      = wc_get_product($product_id);
                $product_name = $product->get_name();
                $product_price = $product->get_price();

                $variation_id = isset($item['variation_id']) ? $item['variation_id'] : 0;
                $variation_attributes = !empty($item['variation']) ? json_encode($item['variation']) : null;

                // جلوگیری از ثبت تکراری
                $rowcount = $wpdb->get_var($wpdb->prepare(
                    "SELECT COUNT(*) FROM {$this->table_name} WHERE product_id = %d AND user_id = %d AND variation_id = %d",
                    $product_id, $user_id, $variation_id
                ));

                if ($rowcount == 0) {
                    $wpdb->insert($this->table_name, [
                        'product_id'           => $product_id,
                        'user_id'              => $user_id,
                        'product_name'         => $product_name,
                        'user_name'            => $user_name,
                        'product_price'        => $product_price,
                        'variation_id'         => $variation_id,
                        'variation_attributes' => $variation_attributes,
                    ]);

                    return true;
                }

                return true;
            }
        }

        return false;
    }

    public function get_single_product_from_list($user_id, $product_id) {
    global $wpdb;

    return $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$this->table_name} WHERE user_id = %d AND product_id = %d LIMIT 1",
        $user_id, $product_id
    ));
}


    /**
     * get users all product.
     * get all users next shopping cart list list
     * @param $user_id
     * @return array|object|null
     */
    public function get_users_next_shoppingcart($user_id) {
        global $wpdb;
        $unsafe_query = "SELECT * FROM {$this->table_name} WHERE user_id= %d ORDER BY product_price ASC ";
        $safe_query = $wpdb->prepare( $unsafe_query , $user_id );
        return $wpdb->get_results( $safe_query );
//        $results = $wpdb->get_results( "SELECT * FROM {$this->table_name} WHERE user_id= {$user_id} ORDER BY product_price ASC " );
//        return $results;
    }

    /**
     * delete.
     * delete product from  next shopping list
     * @param $product_id
     * @param $user_id
     */
    public function delete_product($product_id, $user_id) {
        global $wpdb;
        $wpdb->delete( $this->table_name,
            array( 'product_id' => $product_id ,
                'user_id'=>$user_id) );
    }
}
