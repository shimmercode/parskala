<?php

function cpt_city_cats()
{
    $labels = ["name" => 'استان و شهر', "singular_name" =>  'استان و شهر', "menu_name" => 'استان و شهر', "all_items" =>  'استان و شهرها', "parent_item" => 'استان', "parent_item_colon" => 'استان', "new_item_name" =>'افزودن', "add_new_item" => 'افزودن', "edit_item" =>'.یرایش', "update_item" => 'بروزرسانی', "separate_items_with_commas" => __("Separate with commas", "charsoogh"), "search_items" => 'جستجو', "add_or_remove_items" =>'ازودن و یا حذف', "choose_from_most_used" => __("Choose from the most used items", "charsoogh")];
    $args = ["labels" => $labels, "hierarchical" => true, "public" => true, "show_ui" => true, "show_admin_column" => true, "show_in_nav_menus" => true, "show_tagcloud" => true];
    register_taxonomy("city_categories", ["product","header"], $args);
    register_taxonomy_for_object_type("city_categories", "product");
}
add_action("init", "cpt_city_cats");
add_meta_box('city_categoriesdiv','شهرها','post_categories_meta_box',null,'advanced','default',array( 'taxonomy' => 'city_categories', '__back_compat_meta_box' => 1 ));

$rrprefix='prskala_search';

        add_action( "wp_ajax_".$rrprefix."_getCityChildern", "so_wp_ajax_".$rrprefix."_getCityChildern");
        add_action( "wp_ajax_nopriv_".$rrprefix."_getCityChildern", "so_wp_ajax_".$rrprefix."_getCityChildern" );

        //get parent cities
        add_action( "wp_ajax_".$rrprefix."_getCities", "so_wp_ajax_".$rrprefix."_getCities");
        add_action( "wp_ajax_nopriv_".$rrprefix."_getCities", "so_wp_ajax_".$rrprefix."_getCities" );

        //search city by text
        add_action( "wp_ajax_".$rrprefix."_searchCityByName", "so_wp_ajax_".$rrprefix."_searchCityByName");
        add_action( "wp_ajax_nopriv_".$rrprefix."_searchCityByName", "so_wp_ajax_".$rrprefix."_searchCityByName" );

 function so_wp_ajax_prskala_search_getCities(){


          $cities = get_terms('city_categories', array('hide_empty' => 0, 'parent' => 0));
        echo json_encode($cities);
        wp_die();
    }
    function so_wp_ajax_prskala_search_getCityChildern(){

        $cityid=sanitize_text_field($_POST['cityid']);
     $children = get_terms('city_categories', array('hide_empty' => 0, 'parent' => $cityid));
        echo json_encode($children);
        wp_die();
    }
    function so_wp_ajax_prskala_search_searchCityByName(){


        $txt=sanitize_text_field($_POST['txt']);
     $args = array(
            "hide_empty" => false,
            "taxonomy" => "city_categories",
//        'number' => false,
            "childless" => false,
            'name__like' => $txt,
//        'posts_per_page' => -1
        );
        $res = get_terms($args);
    //var_dump($txt);
        echo json_encode($res);
        wp_die();
    }
