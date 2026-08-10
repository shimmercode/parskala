<?php
$checker = new mob_cheker;
$promote_page = prk_option('promote_page');
$page_title = prk_option('promote_page_title');
$promote_true = prk_option('promote_true');
$prk_modern_mobile = prk_option('prk_modern_mobile');

$prk_topbar_stikey = prk_option('prk_topbar_stikey');
if ($prk_topbar_stikey) {
  $sticky_classes = 'top_stikey';
}else {
  $sticky_classes = '';
}

?>
<?php if ( !mobile_cheker() && !tablet_cheker() ): ?>

<div class="menus <?php echo $sticky_classes;?>">
    <div class="continer">
      <nav class="top-nav">

        <?php



          $walker = new Prk_Walker_Nav_Menu;
        	echo '<ul class="prk_mega_menu">';
        	wp_nav_menu(array('container'=>'true','theme_location'=> 'mega-menu','depth' => 4,'items_wrap' => '%3$s', 'walker' => $walker));
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


          <?php
          if ($promote_true){
          if ($promote_page ){
           ?>

          <div class="page-promotes">
           <ul>
             <li>
                <a href="<?php echo $promote_page;?>"><?php echo $page_title;?></a>
             </li>
           </ul>
          </div>
        <?php }};?>
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
