<?php 
/**
 * This page will contain useful functions
 * 
 */

// return wishlist array
function sit_get_wishlist_array(){
    $key = SIT_USER_META_KEY;
    $wishlist_array = [];


    if(is_user_logged_in()){
        
        $saved_array = get_user_meta( get_current_user_id(), $key, true );

        if( $saved_array ){
            $wishlist_array = $saved_array;
        }

    }else{

        if(isset($_COOKIE[$key])) {
            // if cookie set

            $wishlist_string = $_COOKIE[$key];
            $wishlist_array = explode(",",$wishlist_string);

            $formatted_wishlist_array = [];

            foreach( $wishlist_array as $item_id ){
                $formatted_wishlist_array[] = intval($item_id);
            }

            $wishlist_array = $formatted_wishlist_array;
        }
    }

    return $wishlist_array;
    
}

function sit_set_wishlist_array($wishlist_array){
    $key = SIT_USER_META_KEY;

    if( is_user_logged_in(  ) ){
        update_user_meta( get_current_user_id(  ) , $key, $wishlist_array);
    }else{
        $wishlist_string = implode(',', $wishlist_array);
        setcookie($key, $wishlist_string , time() + (86400 * 30), "/"); // 86400 = 1 day
    }

    return true;
}

// check is item already in wishlist
function sit_is_item_in_wishlist($id){
    $item_in_wishlist = false;

    $wishlist_array =  sit_get_wishlist_array();

    if( $wishlist_array && in_array($id, $wishlist_array) ){
        $item_in_wishlist = true;
    }

    return $item_in_wishlist;
}