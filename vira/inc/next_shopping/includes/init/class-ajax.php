<?php

/**
 *  Advanced next shopping system parskala
 *
 * @package      Advanced next shopping
 * @Author      Hosein Esmalian
 * @link        http://parskalas.ir
 */


namespace Next_Shopping_List\Includes\Init;

use Next_Shopping_List\Includes\Interfaces\prk_Action_Hook_Interfaces;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


class Ajax implements prk_Action_Hook_Interfaces{

    /**
     * @var string action name for ajax call
     */
    public $action;
    /**
     * @var string  name for ajax url
     */
    public $ajax_url;

    /**
     * constructor.
     * @param $action_name
     * @param $ajax_url
     */
    public function __construct($action_name , $ajax_url) {
       $this->action = $action_name;
       $this->ajax_url = $ajax_url;
       $this->register_add_action();
    }

    /**
     * register actions
     */
    public function register_add_action() {

        add_action( 'wp_ajax_' . $this->action , array($this , 'handle') );
        add_action( 'wp_ajax_nopriv_' . $this->action, array($this , 'handle') );
    }


    /**
     * fire on ajax
     */
    public function handle() {
        $db = new Db();
        $result = array();
        if (is_user_logged_in()){
            if ($_POST['type'] == 'add_to_next_list'){
                if (isset( $_POST['product_id'] )){
                    $product_id =  $_POST['product_id'] ;
                    $db = new Db();
                    $insert_result = $db->insert($product_id);
                    if ($insert_result){
                        foreach( WC()->cart->get_cart() as $key=>$item){
                            if($item['product_id']==$product_id){
                                WC()->cart->remove_cart_item( $key );
                                $items = WC()->cart->get_cart();
                                echo count($items);
//                                wc_add_to_cart_message($product_id);
                                wp_die();
                            }
                        }
                    }
                }
            }

            elseif ($_POST['type'] == 'add_to_cart') {
                if (isset($_POST['product_id'])) {
                    $product_id = intval($_POST['product_id']);
                    $user_id = get_current_user_id();
                    $db = new Db();

                    // 🔍 دریافت اطلاعات کامل محصول از لیست آینده
                    $product_data = $db->get_single_product_from_list($user_id, $product_id);

                    if (!$product_data) {
                        wp_send_json_error('محصول پیدا نشد.');
                    }

                    $variation_id = !empty($product_data->variation_id) ? intval($product_data->variation_id) : 0;
                    $variation = [];

                    if (!empty($product_data->variation_attributes)) {
                        $variation = json_decode($product_data->variation_attributes, true);
                    }

                    // 🛒 افزودن به سبد خرید
                    WC()->cart->add_to_cart($product_id, 1, $variation_id, $variation);

                    // 🗑️ حذف از لیست آینده
                    $db->delete_product($product_id, $user_id);

                    // 🔄 بروزرسانی لیست باقی‌مانده
                    $list = $db->get_users_next_shoppingcart($user_id);
                    if (sizeof($list) == 0) {
                        include NEXT_SHOPPING_LIST_PUB_TPL_PATH . 'empty-list.php';
                    } else {
                        include NEXT_SHOPPING_LIST_PUB_TPL_PATH . 'shopping-list.php';
                    }

                    wp_die();
                }
            }


            elseif($_POST['type'] == 'delete_product'){
                if (isset( $_POST['product_id'] )){
                    $product_id = $_POST['product_id'] ;
                    $db = new Db();
                    $user_id = get_current_user_id() ;
                    $db->delete_product($product_id,$user_id);


                    $list = $db->get_users_next_shoppingcart($user_id);
                    if (count($list) == 0){
                        sprintf (include NEXT_SHOPPING_LIST_PUB_TPL_PATH .'empty-list.php');
                    }
                    else{
                        sprintf(include NEXT_SHOPPING_LIST_PUB_TPL_PATH .'shopping-list.php') ;
                    }
                }
            }
            elseif ($_POST['type'] == 'add_all_product'){


                $user_id = get_current_user_id() ;
                $products = $db->get_users_next_shoppingcart($user_id);
                foreach ($products as $product){
                    $product_id = esc_html($product->product_id );
                    WC()->cart->add_to_cart( $product_id );
                    $user_id = get_current_user_id() ;
                    $db->delete_product($product_id,$user_id);
                }
                sprintf (include NEXT_SHOPPING_LIST_PUB_TPL_PATH .'empty-list.php');


        }
            elseif ($_POST['type'] == 'update_next_shoppingcart_list'){
                $db = new Db();
                $user_id = get_current_user_id() ;
                $list = $db->get_users_next_shoppingcart($user_id);
                if (sizeof($list) == 0){
                    sprintf (include NEXT_SHOPPING_LIST_PUB_TPL_PATH .'empty-list.php');
                }
                else{
                    sprintf(include NEXT_SHOPPING_LIST_PUB_TPL_PATH .'shopping-list.php') ;
                }
            }
            elseif ($_POST['type'] == 'get_number_of_cart_items'){
                $items = WC()->cart->get_cart();
                echo count($items);
            }
        }
        else{
            echo -1;//redirect to login page of woocommerce in ajax successful result
        }
        wp_die();
    }

}
