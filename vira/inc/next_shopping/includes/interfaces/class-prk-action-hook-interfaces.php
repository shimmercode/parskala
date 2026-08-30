<?php
/**
* prk_Action_Hook_Interfaces interface File
*
* This file contains prk_Action_Hook_Interfaces_Interface. If you to use add_action and remove_action in your class,
* you must use from this contract to implement it.
*
* @package    Next_Shopping_List
* @author     MWD
*/

namespace Next_Shopping_List\Includes\Interfaces;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * Interface
 * @package Next_Shopping_List\Includes\Interfaces
 */
interface prk_Action_Hook_Interfaces {

/**
* Register actions that the object needs to be subscribed to.
**/
    public function register_add_action();
}
