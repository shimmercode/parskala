<?php

/**
 *  Advanced next shopping system parskala
 *
 * @package      Advanced next shopping
 * @Author      Hosein Esmalian
 * @link        http://parskalas.ir
 */

namespace Next_Shopping_List\Includes\Init;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Constant_Name
 * @package Next_Shopping_List\Includes\Init
 */
class Constant_Name {
    public static function define_constant() {

        if (!defined('NEXT_SHOPPING_LIST')) {
            define('NEXT_SHOPPING_LIST', 'next-shopping-list');
        }
        if (!defined('NEXT_SHOPPING_LIST_PATH')) {
            define('NEXT_SHOPPING_LIST_PATH', parskala_TEMPLATEPATH .'/inc/next_shopping/' );
        }

        if ( ! defined( 'NEXT_SHOPPING_LIST_ADMIN' ) ) {
            define( 'NEXT_SHOPPING_LIST_ADMIN', trailingslashit( NEXT_SHOPPING_LIST_PATH  ).'admin' );
        }
        if ( ! defined( 'NEXT_SHOPPING_LIST_ADMIN_TPL' ) ) {
            define( 'NEXT_SHOPPING_LIST_ADMIN_TPL', trailingslashit( NEXT_SHOPPING_LIST_ADMIN  ) . 'template');
        }


        if (!defined('NEXT_SHOPPING_LIST_INC')) {
            define('NEXT_SHOPPING_LIST_INC', trailingslashit(NEXT_SHOPPING_LIST_PATH . 'includes'));
        }
        if (!defined('NEXT_SHOPPING_LIST_PUB_PATH')) {
            define('NEXT_SHOPPING_LIST_PUB_PATH', trailingslashit(NEXT_SHOPPING_LIST_PATH . 'publicfiles'));
        }
        if (!defined('NEXT_SHOPPING_LIST_PUB_TPL_PATH')) {
            define('NEXT_SHOPPING_LIST_PUB_TPL_PATH', trailingslashit(NEXT_SHOPPING_LIST_PUB_PATH . 'template'));
        }

        if (!defined('NEXT_SHOPPING_LIST_LOGS')) {
            define('NEXT_SHOPPING_LIST_LOGS', trailingslashit(NEXT_SHOPPING_LIST_PATH . 'logs'));
        }

        if (!defined('NEXT_SHOPPING_LIST_TABLE')) {
            define('NEXT_SHOPPING_LIST_TABLE', 'next_shopping_list');
        }
    }
}
