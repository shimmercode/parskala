<?php
// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

  //
  // Set a unique slug-like ID
  $prefix = 'prk_menu_options';

  CSF::createNavMenuOptions( $prefix, array(
    'data_type' => 'serialize', // The type of the database save options. `serialize` or `unserialize`
  ) );

  //
  // Create a section
  CSF::createSection( $prefix, array(
    'fields' => array(
      array(
        'id'    => 'menu-icon',
        'class'    => 'font_menu_icon',
        'type'  => 'text',
        'title' => 'آیکون',
        'desc'  => ' انتخاب ایکن در سایت<a href="https://remixicon.com/"  target="_blank"> remixicon </a>',
      ),
      array(
        'id'    => 'menu-icon-color',
        'type'  => 'color',
        'title' => 'رنگ آیکن',
        ),
        array(
        'id'      => 'img_menu_icon',
        'class'      => 'img_menu_icon',
        'type'    => 'media',
        'title'   => 'یا آپلود تصویر ایکن',
        'desc'   => 'اولویت نمایش با ایکن میباشد.',
        'library' => 'image',
      ),
      array(
        'id'          => 'type_menu_for_display',
        'class' => 'type_menu_for_display',
        'type'        => 'select',
        'placeholder' => '',
        'title'       => 'نوع نمایش',
        'options'     => array(
          'clasic_menu' => 'کلاسیک',
  				'mega_menu_two_level' => 'مگامنو',
  				'mega_menu_tree_level' => 'تب منو',
        ),
      ),
      array(
        'class' => 'dispaly_tabs',
				'id' => 'dispaly_tabs',
        'type'        => 'select',
        'placeholder' => '',
        'title'       => 'نوع نمایش تب ها',
        'dependency' => array(
          array( 'type_menu_for_display',   '==', 'mega_menu_tree_level' ),
        ),
        'options'     => array(
          'prk-side-tab' => 'تب کناری',
  				'prk-top-tab' => 'تب افقی',
        ),
      ),

      array(
          'id' => 'show_line_menu',
          'class' => 'show_line_menu',
          'type' => 'switcher',
          'title' => esc_html__('جدا کننده منو', 'prk'),
          // 'text_width' => 80,
          'default' => false
      ),

      array(
      'id'      => 'background_mega_menu',
      'type'    => 'media',
      'title'   => 'تصویر بک گراند',
      'desc'   => 'طول و عرض پیشنهادی بنر 300 px .',
      'library' => 'image',
      'dependency' => array(
        array( 'type_menu_for_display',   '==', 'mega_menu_two_level' ),
      ),
    ),
    array(
    'id'      => 'background_mega_menu_size',
    'type'    => 'text',
    'title'   => 'حداقل سایز ارتفاع مگامنو',
    'desc'   => 'این سایز در صورت اضافه کردن تصویر بک گراند فراخوان میشود.',
    'dependency' => array(
      array( 'type_menu_for_display',   '==', 'mega_menu_two_level' ),
    ),
  ),
   )
) );

}


// A Custom function for get an option
if ( ! function_exists( 'get_menu_option' ) ) {
  function get_menu_option( $option = '', $default = null ) {
    $options = get_option( 'prk_menu_options' ); // Attention: Set your unique id of the framework
    return ( isset( $options[$option] ) ) ? $options[$option] : $default;
  }
}



class Prk_Walker_Nav_Menu_mob extends Walker_Nav_Menu{

  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    if($args->walker->has_children)
    {
      $classes = ' menu-item-has-children';
    }else {
      $classes = '';
    }


    $menu_options = get_post_meta( $item->ID, 'prk_menu_options', true );

    $type_menu = $menu_icon_color = $menu_icon = $img_menu = $background_mega_menu = "";

		if(isset($menu_options) && !empty($menu_options)){

      if ( isset( $menu_options['menu-icon'] ) )	$icon      = $menu_options['menu-icon'];
			if ( isset( $menu_options['img_menu_icon'] ) )	$img_menu      = $menu_options['img_menu_icon']['url'];
      if ( isset( $menu_options['menu-icon-color'] ) )	$color_icon      = $menu_options['menu-icon-color'];

    }


    if( ! empty( $meta['menu-typer'] ) ) {
    $item->classes = ''. $meta['menu-typer'] . '' .$classes;
    }


    if( ! empty($icon) ) {

      if ( ! empty($color_icon) ) {
         $icon_color = ' style="color:'.$color_icon.'" ';
      }else {
         $icon_color = '';
      }

     $item->title = '<i class="'. $icon .'" '.$icon_color.' ></i>' . $item->title;

   }elseif( ! empty($img_menu) ) {

    $item->title = " <img src='".$img_menu."' alt='image-icon-menu' width='18'> " . $item->title;

   }




    parent::start_el( $output, $item, $depth, $args, $id );



  }
}
