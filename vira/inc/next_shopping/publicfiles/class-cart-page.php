<?php

/**
 *  Advanced next shopping system parskala
 *
 * @package      Advanced next shopping
 * @Author      Hosein Esmalian
 * @link        http://parskalas.ir
 */


namespace Next_Shopping_List\Publicfiles;

use Next_Shopping_List\Includes\Interfaces\prk_Action_Hook_Interfaces;
use Next_Shopping_List\Includes\Init\Db;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


class Cart_Page implements prk_Action_Hook_Interfaces {

    /**
     * constructor.
     */
    public function __construct() {
        $this->register_add_action();
    }

    /**
     * fire action and filter
     */
    public function register_add_action() {
            add_filter( 'woocommerce_cart_item_subtotal', array($this,'prk_filter_woocommerce_cart_item_sum_link'), 10, 3 );
       

        add_action('woocommerce_before_cart', array($this,'prk_wc_add_tab_befor') );
        add_action('woocommerce_cart_is_empty', array($this,'wc_shopping_list_empty') );
    }


    public function prk_filter_woocommerce_cart_item_sum_link($sprintf, $cart_item, $cart_item_key){
           if (is_cart())
            return
                $sprintf .
                '<div class="prk-add-shoppingcart-container">
                <a class="prk-add-to-next-shopping-list" >
                    <i class="prk-message-add-1"></i>'.__('save to Next shopping list','parskala').'
                </a>
             </div>';

    }

    /**
     * add tabs & its details of (shoppingCart & next ShoppingCart)
     */
    public function prk_wc_add_tab_befor() {
        $domain =  get_home_url().'/cart';
        $next_domain =  get_home_url().'/cart?shoppingcart=next';
        $db = new DB();
        $user_id = get_current_user_id() ;
        $list = $db->get_users_next_shoppingcart($user_id);
        if (isset($_GET['shoppingcart']) && $_GET['shoppingcart'] == 'next') {
            echo '<div class="prk-shoppingcart-next-contain-links"> <a href="'.$domain.'"> '.__('cart', 'parskala').' </a> &nbsp;';
            echo '<a href="'. $next_domain.'" class = "active">'.__('Next shopping list','parskala').'<i> '.count($list).' </i><div class="border_solid_cart"></div> </a></div>';

            echo '<div class="prk-next-shopping-cart-tab-content" id="card-container">';
            if (count($list) == 0){
                include NEXT_SHOPPING_LIST_PUB_TPL_PATH .'empty-list.php' ;
            }else{
                include NEXT_SHOPPING_LIST_PUB_TPL_PATH .'shopping-list.php' ;
            }
            echo '</div>';// tabbed
            echo '<style>
                    .woocommerce-cart-form.prk_cart{display: none!important}
                    .cart-collaterals.prk_cart{display: none!important}
                    .cart-empty{display: none!important}
                    .return-to-shop{display: none!important}
                  </style>';
        }else{
            echo '<div class="prk-shoppingcart-next-contain-links"> <a href="'.$domain.'" class="active"> '.__('cart', 'parskala').'<i class="">'.WC()->cart->get_cart_contents_count().'</i><div class="border_solid_cart"></div> </a> &nbsp;';
            echo '<a href="'. $next_domain.'">'.__('Next shopping list', 'parskala').'<i> '.count($list).' </i></a></div>';
        }

    }

    /**
     * add tabs & its details when shopping list is empty
     */
    public function wc_shopping_list_empty(){
        //----------before
        $domain =  get_home_url().'/cart';
        $next_domain =  get_home_url().'/cart?shoppingcart=next';

        if (isset($_GET['shoppingcart']) && $_GET['shoppingcart'] == 'next'){
            echo '<div class="prk-shoppingcart-next-contain-links"> <a href="'.$domain.'"> '.__('cart', 'parskala').' </a> &nbsp;';
            echo '<a href="'. $next_domain.'" class = "active"> '.__('Next shopping list', 'parskala').' <div class="border_solid_cart"></div></a></div>';
            $db = new DB();
            $user_id = get_current_user_id() ;
            $list = $db->get_users_next_shoppingcart($user_id);
            echo '<div class="prk-next-shopping-cart-tab-content" id="card-container">';
            if (count($list) == 0){
                include NEXT_SHOPPING_LIST_PUB_TPL_PATH .'empty-list.php' ;
            }else{
                include NEXT_SHOPPING_LIST_PUB_TPL_PATH .'shopping-list.php' ;
            }
            echo '</div>';// tabbed
            echo '<style>
                    .woocommerce-cart-form.prk_cart{display: none!important;}
                    .cart-collaterals.prk_cart{display: none!important;}
                    .cart-empty{display: none!important}
                    .return-to-shop{display: none!important}
                    .prk_empty_cart .prk_empty_cart_detales{display: none!important}
                  </style>';

        }else{
            echo '<div class="prk-shoppingcart-next-contain-links"> <a href="'.$domain.'" class="active"> '.__('cart', 'parskala').' <div class="border_solid_cart"></div> </a> &nbsp;';
            echo '<a href="'. $next_domain.'"> '.__('Next shopping list', 'parskala').' </a></div>';
        }

    }


}
