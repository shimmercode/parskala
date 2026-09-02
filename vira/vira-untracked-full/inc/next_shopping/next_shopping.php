<?php

/**
 *  Advanced next shopping system parskala
 *
 * @package      Advanced next shopping
 * @Author      Hosein Esmalian
 * @link        http://parskalas.ir
 */


use Next_Shopping_List\Includes\Init\Constant_Name;
use Next_Shopping_List\Includes\Init\Create_tables;
use Next_Shopping_List\Includes\Init\Ajax;
use Next_Shopping_List\Admin\Admin_Menu;
use Next_Shopping_List\Publicfiles\Cart_Page;


final class Next_Shopping_List {

    private static $instance;


    public function __construct() {
        $autoloader_path = '/inc/next_shopping/includes/class-autoloader.php';
        require_once  parskala_TEMPLATEPATH . $autoloader_path;
        Constant_Name::define_constant();
    }

    public static function instance() {
        if ( is_null( ( self::$instance ) ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function run_next_shopping_list_prk() {
        if (is_admin()){
            $Admin_Menu = new Admin_Menu();
        }

        $Cart_Page = new Cart_Page;
		$Create_tables = new Create_tables();
        $ajax = new Ajax('prk_add_to_next_shopping_action','custom_ajaxurl');

    }

}
$next_shopping_list_object = Next_Shopping_List::instance();
$next_shopping_list_object->run_next_shopping_list_prk();
