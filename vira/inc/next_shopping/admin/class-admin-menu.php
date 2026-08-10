<?php
namespace Next_Shopping_List\Admin;


use Next_Shopping_List\Includes\Interfaces\prk_Action_Hook_Interfaces;
use Next_Shopping_List\Includes\Init\Db;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Admin_Menu.
 * create admin menu property
 * @package Next_Shopping_List\Admin
 */
class Admin_Menu  implements prk_Action_Hook_Interfaces {

    /**
     * constructor.
     * call method to start creating admin menu
     */
    public function __construct() {
        $this->register_add_action();
    }

    /**
     * create admin_menu
     */
    public function register_add_action() {
        add_action( 'admin_menu', array( $this, 'add_admin_menu_page' ) );
    }

    /**
     * admin sub menu.
     */
    public function add_admin_menu_page() {
        add_submenu_page(
            'edit.php?post_type=product',
            __( 'لیست خرید آینده'),
            __( 'لیست خرید آینده' ),
            'manage_woocommerce',
            'next_shopping_card_url',
            array($this,'shopping_cart_panel_handler')
        );
    }

    /**
     * sub menu handler.
     */
    public function shopping_cart_panel_handler() {
        $DB = new Db();
        include NEXT_SHOPPING_LIST_ADMIN_TPL .'/admin-panel.php' ;
    }


}
