<?php
$menu_admin_link = '<a href="'. site_url('wp-admin/nav-menus.php').'" target="_blank">'.__('menu','parskala').'</a>' ;

$hover_menu_item_class = '';
if (prk_option('prk_hover_menu_item')){
  $hover_menu_item_class = 'hover_menu_item';
}
 $walker = new Prk_Walker_Nav_Menu;
   echo '<ul class="prk_mega_menu '.$hover_menu_item_class.' ">';

    if ( has_nav_menu( 'mega-menu' ) ) {

        wp_nav_menu(
          array('container'=>'true',
          'theme_location'=> 'mega-menu','depth' => 4,
          'items_wrap' => '%3$s',
           'walker' => $walker)
          );

    }
    else{

        echo '<div class="no-main-menu">'.sprintf( __( 'Create a %s with main location to display here.', 'parskala' ), $menu_admin_link ).'</div>';

    }
 

   echo '</ul>';

   ?>
   <script>
       jQuery(document).ready(function($){

           jQuery('li.mega_menu_tree_level.prk-side-tab.menu-item-has-children > ul').wrap("<div class='prk-tab-menu-items'></div>");


           var maxHeight = 0;

           jQuery(".mega_menu_tree_level.prk-side-tab .sub-menu.prk-level-1").each(function(){
              if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
           });

           jQuery(".prk-tab-menu-items").height(maxHeight  + 30 );
           jQuery(".prk-tab-menu-items").css("display" , "none");

           jQuery('li.mega_menu_tree_level ul.prk-level-0 > li:first-child').addClass("active");

           jQuery('li.mega_menu_tree_level ul.prk-level-0 > li').mouseenter(function(){
                 jQuery(this).parent().find('li').removeClass("active");
                 jQuery(this).addClass("active");
           });

       });



   </script>

  <?php if (prk_option('prk_hover_menu_item')):?>
     <script>
       jQuery( document ).ready(function( $ ) {
           $('.prk_mega_menu').append('<div class="box-hover-menu d-none"></div>');
           $('.prk_mega_menu').children('li').on('mouseenter',function(){
               $('.box-hover-menu').removeClass('d-none');
               $('.box-hover-menu').css('width',$(this).width()+'px');
               let a,b;
               if(typeof($(this).position().left) !== undefined){
                   a=parseInt($(this).position().left);
                   if(typeof($(this).css('marginLeft')) !== undefined){
                       a+=parseInt($(this).css('marginLeft'));
                   }
                   if(typeof($(this).css('padding-left')) !== undefined){
                       a+=parseInt($(this).css('padding-left'));
                   }
                   $('.box-hover-menu').css('left',a+'px');
               }else{
                   b=parseInt($(this).position().right);
                   if(typeof($(this).css('marginRight')) !== undefined){
                       b+=parseInt($(this).css('marginRight'));
                   }
                   if(typeof($(this).css('padding-right')) !== undefined){
                       b+=parseInt($(this).css('padding-right'));
                   }
                   $('.box-hover-menu').css('right',b+'px');
               }
           });
       })
     </script>
 <?php endif;?>