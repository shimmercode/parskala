<?php
if ( ! class_exists( "CSF" ) ) { return; }



#attributes settings
CSF::createSection($prefix, array(
	'title' => esc_html__('پیکربندی راهنمای سایزبندی تصاویر', 'prk'),
	'id' => 'sizeguide_settings',
	'icon' => 'ri-questionnaire-line',
  ));

  CSF::createSection( $prefix, array(
	  'title'      => __( 'عمومی', 'parskala' ),
	  // 'desc'       => __( '', 'woocommerce-pdf-catalog' ),
	  'id'         => 'general-settings',
	  'parent' => 'sizeguide_settings', // The slug id of the parent section
	  'fields'     => array(
		array(
				  'title'    => __( 'استایل دکمه', 'prk-sgp' ),
				  'id'      => 'wc_size_guide_style',
				  'type'    => 'select',
				  'class'   => 'chosen_select',
				  'css'     => 'min-width:300px;',
				  'default' => PRK_SIZEGUIDE_ASSETS . 'css/prk.sizeguide.style1.css',
				  'options' =>  array(
					  PRK_SIZEGUIDE_ASSETS . 'css/prk.sizeguide.style1.css' => __( 'استایل 1', 'prk-sgp' ),
				  ),
			  ),

			  // array(
				//   'title'    => __( 'نوع باز شدن', 'prk-sgp' ),
				//   'id'      => 'wc_size_guide_button_style',
				//   'type'    => 'select',
				//   'class'   => 'chosen_select',
				//   'css'     => 'min-width:300px;',
				//   'std'     => 'prk-trigger-button',
				//   'default' => 'prk-trigger-button',
				//   'options' => array(
				// 	  'prk-trigger-link'   => __( 'لینک', 'prk-sgp' ),
				// 	  'prk-trigger-button' => __( 'دکمه', 'prk-sgp' ),
				//   ),
			  // ),
			  array(
				  'title'    => __( 'عدم نمایش', 'prk-sgp' ),
				  'desc'    => __( 'عدم نمایش راهنمای سایزبندی برای محصولات ناموجود', 'prk-sgp' ),
				  'id'      => 'wc_size_guide_hide',
				  'type'    => 'checkbox',
				  //'class' => 'chosen_select', // #429: Custom theme button issue
				  'css'     => 'min-width:300px;',
				  'std'     => 'no',
				  'default' => 'no'
			  ),
			  array(
				  'title'    => __( 'محل نمایش دکمه:', 'prk-sgp' ),
				  'id'      => 'wc_size_guide_button_position',
				  'type'    => 'select',
				  'class'   => 'chosen_select',
				  'css'     => 'min-width:300px;',
				  'std'     => 'prk-position-summary',
				  'default' => 'prk-position-summary',
				  'options' => array(
					  'prk-position-summary'     => __( 'نمایش قبل از باکس فروشنده', 'prk-sgp' ),
					  'prk-position-add-to-cart' => __( 'نمایش بعد از باکس فروشنده', 'prk-sgp' ),
					  'prk-position-info'        => __( 'نمایش بعد از اطلاعات محصول', 'prk-sgp' ),
					  // 'prk-position-tab'         => __( 'Make it a tab', 'prk-sgp' ),
					  'prk-position-shortcode'   => __( 'نمایش در شرت کد [prk_size_guide]', 'prk-sgp' ),
				  ),
			  ),
			  // array(
				//   'title'        => __( 'Button/link hook priority', 'prk-sgp' ),
				//   'desc'        => __( 'Priority of the action that outputs the button/link. Using this you can adjust the position.', 'prk-sgp' ),
				//   'id'          => 'wc_size_guide_button_priority',
				//   'css'         => 'max-width:60px;',
				//   'type'        => 'number',
				//   'default'     => 60,
				//   'std'         => 60,
				//   'placeholder' => 60,
			  // ),
			  array(
				  'title'    => __( 'جدول چندگانه', 'prk-sgp' ),
				  'desc'    => __( 'این فیلد را علامت بزنید تا جدول راهنمای اندازه چندگانه به عنوان برگه نشان داده شود', 'prk-sgp' ),
				  'id'      => 'wc_size_guide_tab_multiple_table',
				  'type'    => 'checkbox',
				  'css'     => 'min-width:300px;',
				  'std'     => 'no',
				  'default' => 'no'
			  ),
			  array(
				  'title'    => __( 'لیبل دکمه', 'prk-sgp' ),
				  'id'      => 'wc_size_guide_button_label',
				  'type'    => 'text',
				  'default' => 'راهنمای سایز',
				  'std'     => 'راهنمای سایز',
				  //'placeholder' => 'Size Guide'
			  ),
			  // array(
				//   'title'    => __( 'Button/link align', 'prk-sgp' ),
				//   'id'      => 'wc_size_guide_button_align',
				//   'type'    => 'select',
				//   'class'   => 'chosen_select',
				//   'css'     => 'min-width:300px;',
				//   'std'     => 'prk-align-left',
				//   'default' => 'prk-align-left',
				//   'options' => array(
				// 	  'left'  => __( 'Left', 'prk-sgp' ),
				// 	  'right' => __( 'Right', 'prk-sgp' ),
				//   ),
			  // ),
			  // array(
				//   'title'    => __( 'Button/link clearing', 'prk-sgp' ),
				//   'desc'    => __( 'Allow floating elements on the sides of the link/button?', 'prk-sgp' ),
				//   'id'      => 'wc_size_guide_button_clear',
				//   'type'    => 'checkbox',
				//   'class'   => 'chosen_select',
				//   'css'     => 'min-width:300px;',
				//   'std'     => 'no',
				//   'default' => 'no'
			  // ),
			  // array(
				//   'title'    => __( 'کلاس سفارشی', 'prk-sgp' ),
				//   'desc'    => __( 'افزودن کلا', 'prk-sgp' ),
				//   'id'      => 'wc_size_guide_button_class',
				//   'type'    => 'text',
				//   'default' => 'button_sg',
				//   'std'     => 'button_sg',
				//   //'placeholder' => 'button_sg'
			  // ),
			  // array(
				//   'title'    => __( 'Button icon', 'prk-sgp' ),
				//   'desc'    => __( 'Icon to accompany text in button, type: icon_sg', 'prk-sgp' ),
				//   'id'      => 'wc_size_guide_button_icon',
				//   'type'    => 'text',
			  // ),
			  // array(
				//   'title'        => __( 'Margin left', 'prk-sgp' ),
				//   'desc'        => __( 'Enter the left margin of the link/button', 'prk-sgp' ),
				//   'id'          => 'wc_size_guide_button_margin_left',
				//   'css'         => 'max-width:60px;',
				//   'type'        => 'number',
				//   'default'     => 0,
				//   'placeholder' => 0,
			  // ),
			  // array(
				//   'title'        => __( 'Margin top', 'prk-sgp' ),
				//   'desc'        => __( 'Enter the top margin of the link/button', 'prk-sgp' ),
				//   'id'          => 'wc_size_guide_button_margin_top',
				//   'css'         => 'max-width:60px;',
				//   'type'        => 'number',
				//   'default'     => 0,
				//   'placeholder' => 0,
			  // ),
			  // array(
				//   'title'        => __( 'Margin right', 'prk-sgp' ),
				//   'desc'        => __( 'Enter the right margin of the link/button', 'prk-sgp' ),
				//   'id'          => 'wc_size_guide_button_margin_right',
				//   'css'         => 'max-width:60px;',
				//   'type'        => 'number',
				//   'default'     => 0,
				//   'placeholder' => 0,
			  // ),
			  // array(
				//   'title'        => __( 'Margin bottom', 'prk-sgp' ),
				//   'desc'        => __( 'Enter the bottom margin of the link/button', 'prk-sgp' ),
				//   'id'          => 'wc_size_guide_button_margin_bottom',
				//   'css'         => 'max-width:60px;',
				//   'type'        => 'number',
				//   'default'     => 0,
				//   'placeholder' => 0,
			  // ),
			  // array(
				//   'title'    => __( 'Popup overlay color', 'prk-sgp' ),
				//   'desc'    => __( 'Click to pick the color of the popup background overlay', 'prk-sgp' ),
				//   'id'      => 'wc_size_guide_overlay_color',
				//   'css'     => 'max-width:70px;',
				//   'type'    => 'color',
				//   'default' => '000000',
			  // ),
			  // array(
				//   'title'        => __( 'Padding left', 'prk-sgp' ),
				//   'desc'        => __( 'Enter the left padding of the content in the popup window', 'prk-sgp' ),
				//   'id'          => 'wc_size_guide_modal_padding_left',
				//   'css'         => 'max-width:60px;',
				//   'type'        => 'number',
				//   'default'     => 0,
				//   'placeholder' => 0,
			  // ),
			  // array(
				//   'title'        => __( 'Padding top', 'prk-sgp' ),
				//   'desc'        => __( 'Enter the top padding of the content in the popup window', 'prk-sgp' ),
				//   'id'          => 'wc_size_guide_modal_padding_top',
				//   'css'         => 'max-width:60px;',
				//   'type'        => 'number',
				//   'default'     => 0,
				//   'placeholder' => 0,
			  // ),
			  // array(
				//   'title'        => __( 'Padding right', 'prk-sgp' ),
				//   'desc'        => __( 'Enter the right padding of the content in the popup window', 'prk-sgp' ),
				//   'id'          => 'wc_size_guide_modal_padding_right',
				//   'css'         => 'max-width:60px;',
				//   'type'        => 'number',
				//   'default'     => 0,
				//   'placeholder' => 0,
			  // ),
			  // array(
				//   'title'        => __( 'Padding bottom', 'prk-sgp' ),
				//   'desc'        => __( 'Enter the bottom padding of the content in the popup window', 'prk-sgp' ),
				//   'id'          => 'wc_size_guide_modal_padding_bottom',
				//   'css'         => 'max-width:60px;',
				//   'type'        => 'number',
				//   'default'     => 0,
				//   'placeholder' => 0,
			  // ),
				//
			  // array(
				//   'title'    => __( 'Table hover', 'prk-sgp' ),
				//   'desc'    => __( 'Do you want to use hover effect on tables?', 'prk-sgp' ),
				//   'id'      => 'wc_size_guide_hovers_on_tables',
				//   'type'    => 'checkbox',
				//   'default' => true,
			  // ),
				//
			  // array(
				//   'title' => __( 'Background for hovers line', 'prk-sgp' ),
				//   'desc' => __( 'Set background color for hover lines', 'prk-sgp' ),
				//   'id'   => 'wc_size_guide_lines_hover_color',
				//   'css'     => 'max-width:70px;',
				//   'type' => 'color',
				//   'default' => '#999999',
			  // ),
				//
			  // array(
				//   'title' => __( 'Background for active cell on hover', 'prk-sgp' ),
				//   'desc' => __( 'Set background color for hover lines', 'prk-sgp' ),
				//   'id'   => 'wc_size_guide_active_hover_color',
				//   'css'     => 'max-width:70px;',
				//   'type' => 'color',
				//   'default' => '#2C72AD',
			  // ),
				//
			  // array(
				//   'title'    => __( 'Responsible tables', 'prk-sgp' ),
				//   'desc'    => __( 'This option disables responsive view of tables', 'prk-sgp' ),
				//   'id'      => 'wc_size_guide_display_mobile_table',
				//   'css'     => 'max-width:200px',
				//   'type'    => 'select',
				//   'options' => array(
				// 	  'prk-size-guide--Responsive'    => __( 'Responsive', 'prk-sgp' ),
				// 	  'prk-size-guide--NonResponsive' => __( 'Non responsive', 'prk-sgp' ),
				//   ),
			  // ),
	  )
  ) );
