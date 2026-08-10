<?php

# create menus



register_nav_menus(
  array(
  'mega-menu' => __( 'منو هدر' ),
  'mobile-menu' => __( 'منو موبایل' ),
  )
);


$menu_counter = 0;
add_filter('nav_menu_item_id','change_nav_menu_id',10,2);
function change_nav_menu_id($current_id,$item_details){
global $menu_counter;
return 'navi';
}
