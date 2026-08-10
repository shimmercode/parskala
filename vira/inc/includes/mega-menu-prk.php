<?php
add_action('admin_head', 'custom_style_for_field_items_menu' );
function custom_style_for_field_items_menu(){ ?>

<style>
li.menu-item .csf-nav-menu-options .show_line_menu,
li.menu-item .csf-nav-menu-options .type_menu_for_display,
li.menu-item .csf-nav-menu-options .background_mega_menu,
li.menu-item .csf-nav-menu-options .dispaly_tabs{display:none;}

li.menu-item-depth-0 .csf-nav-menu-options .show_line_menu,
li.menu-item-depth-0 .csf-nav-menu-options .type_menu_for_display,
li.menu-item-depth-0 .csf-nav-menu-options .background_mega_menu,
li.menu-item-depth-0 .csf-nav-menu-options .dispaly_tabs{display:block;}

</style>
<?php }

class Prk_Walker_Nav_Menu extends Walker_Nav_Menu {


	static $count = 1;

	function start_lvl(  &$output, $depth = 0, $args = null  ) {

		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu prk-level-".$depth."\">\n";
	}



   //function start_el(&$output, $item, $depth, $args) {
	function start_el(&$output, $item, $depth = 0, $args = Array(), $id = 0) {



        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
		// start edit
		//$type_menu = get_post_meta ($item->ID, 'menu-item-type_menu_for_display', true );
    $menu_options = get_post_meta( $item->ID, 'prk_menu_options', true );

    $type_menu = $menu_icon_color = $menu_icon = $img_menu = $background_mega_menu = $line_menu = $mega_menu_size = $icon = $color_icon = "";

		if(isset($menu_options) && !empty($menu_options)){

			if ( isset( $menu_options['show_line_menu'] ) )	$line_menu      = $menu_options['show_line_menu'];
		  if ( isset( $menu_options['type_menu_for_display'] ) )	$type_menu      = $menu_options['type_menu_for_display'];
			if ( isset( $menu_options['background_mega_menu_size'] ) )	$mega_menu_size      = $menu_options['background_mega_menu_size'];
			if ( isset( $menu_options['menu-icon'] ) )	$icon      = $menu_options['menu-icon'];
			if ( isset( $menu_options['img_menu_icon'] ) )	$img_menu      = $menu_options['img_menu_icon']['url'];
			if ( isset( $menu_options['menu-icon-color'] ) )	$color_icon      = $menu_options['menu-icon-color'];
			if ( isset( $menu_options['background_mega_menu'] ) )	$background_mega_menu      = $menu_options['background_mega_menu']['url'];

    }

		$type_menu = $type_menu ? $type_menu : 'clasic_menu';

    if ($line_menu == '1' ) {
    	$line_men = ' line_men';
    }else {
    	$line_men = '';
    }


		if ($type_menu && $depth == '0') $classes[] = $type_menu .''. $line_men;


		if ($type_menu && $type_menu == 'mega_menu_tree_level' && $depth == '0'){

			$dispaly_tabs = $menu_options['dispaly_tabs'] ;


			$classes[] = $dispaly_tabs;
		}

		// بک گراند منوی سه سطحی

		if ( $background_mega_menu && $depth >= '0' && $type_menu == 'mega_menu_two_level' ){
			$output .= '<style>';
			$output .=	'.prk_mega_menu #menu-item-'. $item->ID . ' > ul{background-image:url('.$background_mega_menu.');min-height:'.$mega_menu_size.';}';
			$output .= '</style>';
		}



        // end edit
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';
		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'><span class="item-icon-title">';


         

				if ($color_icon) {
					$color_bron = "style='color:".$color_icon."'";
				}else {
					$color_bron = '';
				}

				if ($icon) {

					$item_output .= $icon != '' ? " <i class='{$icon}' ".$color_bron."></i> " : '' ;

				}elseif ($img_menu) {

					$item_output .= $img_menu != '' ? " <img src='".$img_menu."' alt='image-icon-menu' width='18'> " : '' ;

				}

        $item_output .= '<span class="title">'.$args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after.'</span>';
       // $item_output .= '<br /><span class="sub">' . $item->description . '</span>';
        $item_output .= '</span></a>';






        $item_output .= $args->after;



        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );


    }
}
