<?php
$checker = new mob_cheker;
$promote_page = prk_option('promote_page');
$page_title = prk_option('promote_page_title');
$promote_true = prk_option('promote_true');

$promote_page2 = prk_option('promote_page2');
$page_title2 = prk_option('promote_page_title2');
$promote_true2 = prk_option('promote_true2');

$menu_admin_link = '<a href="'. site_url('wp-admin/nav-menus.php').'" target="_blank">'.__('menu','parskala').'</a>' ;

 
$promote_icon = prk_option('promote_page_icon');
$promote_icon_color = prk_option('promote_page_icon_color');
$promote_page_backcolor = prk_option('promote_page_backcolor');

$promote_icon2 = prk_option('promote_page_icon2');

$prk_modern_mobile = prk_option('prk_modern_mobile');

$prk_topbar_stikey = prk_option('prk_topbar_stikey');
if ($prk_topbar_stikey) {
  $sticky_classes = 'top_stikey';
}else {
  $sticky_classes = '';
}
if ( ! prk_option('rgbaback_line_true') ) {
  $class_shadow = '';
}else {
  $class_shadow = ' none_shadow';
}
if (prk_option('promote_link_type') == 'button') {
  $class_type_btn = '';
}else {
  $class_type_btn = ' link_promot_box';
}
?>
<?php if ( !mobile_cheker() && !tablet_cheker() ): ?>

<div class="menus <?php echo $sticky_classes; echo $class_shadow;?>">
    <div class="continer">
      <nav class="top-nav<?= $class_type_btn?>">

        <?php

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

              if(jQuery("ul.sub-menu.prk-level-1").children("li.menu-item-has-children").length > 5){
                jQuery('ul.sub-menu.prk-level-1').addClass("flex-row");
              }

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

          <?php
          if ($promote_true || $promote_true2){

            if ($promote_page || $promote_page2 ){

              if (prk_option('promote_link_type') == 'link' ) {
                $class_promote = ' link_box';
              }elseif(prk_option('promote_link_type') == 'button' ) {
                $class_promote = ' button_box';
              }else {
                $class_promote = ' link_box';
              }

              // if (prk_option('promote_link_type2') == 'link' ) {
              //   $class_promote = ' link_box';
              // }elseif(prk_option('promote_link_type2') == 'button' ) {
              //   $class_promote = ' button_box';
              // }else {
              //   $class_promote = ' link_box';
              // }
             ?>

            <div class="page-promotes<?= $class_promote?>">
             <ul>

               <li class="page-promotes-item1">
                  <a href="<?php echo $promote_page;?>"><?php echo _e($page_title,'parskala');?></a>
                  <?php if ( prk_option('promote_link_type') == 'button' && $promote_icon ): ?>
                    <i class="<?= $promote_icon;?>"></i>
                  <?php endif; ?>
               </li>

             <?php if ($promote_true2 && $promote_page2): ?>
               <!-- <li class="page-promotes-item2">
                  <a href="<?php echo $promote_page2;?>"><?php echo $page_title2;?></a>
                  <?php if ( prk_option('promote_link_type2') == 'button' && $promote_icon2 ): ?>
                    <i class="<?= $promote_icon2;?>"></i>
                  <?php endif; ?>
               </li> -->
             <?php endif; ?>


             </ul>
            </div>

          <?php }

      };?>
     <?php 
      if ( prk_option('call_true1' ) ){
        if ( prk_option('promote_true') == '0' ){
        ?>
          <div class="call-to-admin-prk">
            <span class="title-call"><?= prk_option('call_page1_title') ?></span>
            <p class="number-call"><span class="pish"><?= prk_option('call_page1_pish') ?></span><?= prk_option('call_pagee1') ?></p>
            <i class="icon-call <?= prk_option('call_icon1') ?>"></i>
          </div>
        <?php
        }
      }
     ?>


      </nav>
</div>

</div>

<?php endif; ?>

<?php if ($checker->isMobile()) {

  $menu_model = prk_option( 'menu_mobile_model' );

  if ($prk_modern_mobile) {
    $header_type = ' modern-menu';
  }else {
    $header_type = '';
  }

?>

<!-- main-menu-->
<nav id="mobile-menu1" class="modal-menu <?php echo $menu_model ? $menu_model : 'modern'; echo $header_type; ?>">

  <div class="logo-mobile">
    <?php
    if ( prk_logo_menu() ){
     echo prk_logo_menu();
   }
   else {
     echo prk_logo();
   }
   ?>
  </div>

  <div class="off-canvas-main">

    <?php
        if ( has_nav_menu( 'mobile-menu' ) ) {
        $args = array(
            'theme_location'=> 'mobile-menu',
            'walker' => new Prk_Walker_Nav_Menu_mob(),
            );
        wp_nav_menu($args);
      }elseif ( has_nav_menu( 'mega-menu' ) ) {
        $args = array(
            'theme_location'=> 'mega-menu',
            'walker' => new Prk_Walker_Nav_Menu_mob(),
            );
        wp_nav_menu($args);
      }

    ?>

  </div>

</nav>

<?php } ?>
