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


class Create_tables{

    public function __construct()
    {
        $this->next_shopping_cart_list();
    }

    public function next_shopping_cart_list()
    {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . NEXT_SHOPPING_LIST_TABLE;
        $charset_collate = $wpdb->get_charset_collate();
        $post_table = $table_prefix . 'posts';
        $user_table = $table_prefix . 'users';
        // Get users and posts tables engin to set the forign key
        $DB_table_user = $wpdb->get_row( "SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$wpdb->dbname}' AND TABLE_NAME = '{$user_table}' ");
        $DB_table_post = $wpdb->get_row( "SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$wpdb->dbname}' AND TABLE_NAME = '{$post_table}' ");

        $user_engin = ($DB_table_user->ENGINE)? $DB_table_user->ENGINE:'';
        $post_engin = ($DB_table_post->ENGINE)? $DB_table_post->ENGINE:'';
        $count_table =$wpdb->query("SELECT * FROM information_schema.tables WHERE table_schema = '{$wpdb->dbname}' AND table_name = '{$table_name}'
        LIMIT 1;");
        if($count_table < 1){
              // Create Table if not exist
             $sql = "CREATE TABLE $table_name (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT ,
            product_id bigint(20) unsigned NOT NULL ,
            user_id bigint(20) unsigned NOT NULL ,
            product_name varchar(500) DEFAULT '' NOT NULL,
            user_name varchar(500) DEFAULT '' NOT NULL,
            product_price varchar(200) DEFAULT '' NOT NULL,
            PRIMARY KEY  (id) ";
            if ( (!empty($user_engin) && !empty($user_engin)) &&  $user_engin == $post_engin ){
                $sql .= " , FOREIGN KEY  (user_id) REFERENCES " .$user_table. "(ID) ON DELETE CASCADE " .
                        " , FOREIGN KEY  (product_id) REFERENCES " .$post_table." (ID) ON DELETE CASCADE )";
                $sql .= $charset_collate .", engine = " . $user_engin . " ; ";
            }else{
                $sql .= " ) " . $charset_collate ." ; ";
            }
            
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );



    }
}
