<?php
$prefix = "prk_option";


CSF::createSection( $prefix, array(
    'title'      => __( 'عمومی', 'parskala' ),
    // 'desc'       => __( '', 'woocommerce-pdf-catalog' ),
    'id'         => 'general-settings',
    'parent' => 'gAttributes_settings', // The slug id of the parent section
    'fields'     => array(
        array(
            'id'       => 'enable',
            'type'     => 'switcher',
            'title'    => __( 'فعال سازی', 'parskala' ),
if ( ! class_exists( "CSF" ) ) { return; }
            'subtitle' => __( 'فعال سازی گروه بندی ویژگی ها.', 'parskala' ),
            'default' => 1
        ),

        array(
            'id'       => 'enableAttributeGroupCategories',
            'type'     => 'switcher',
            'title'    => __( 'فعال سازی دسته بندی گروه بندی', 'parskala' ),
            'subtitle' => __( 'امکان دسته بندی گروه بندی ویژگی ها.', 'parskala' ),
            'default' => 1
        ),
        array(
            'id'       => 'multipleAttributesInGroups',
            'type'     => 'switcher',
            'title'    => __( 'ویژگی های چندگانه', 'parskala' ),
            'subtitle' => __( 'به ویژگی‌ها اجازه دهید در چندین گروه ویژگی باشند.به عنوان مثال. ویژگی رنگ می تواند در بیش از 1 گروه ویژگی باشد!', 'parskala' ),
            'default' => 0
        ),
        array(
            'id'       => 'showWeight',
            'type'     => 'switcher',
            'title'    => __( 'نمایش وزن محصول', 'parskala' ),
            'default' => 1
        ),
        array(
            'id'       => 'showDimensions',
            'type'     => 'switcher',
            'title'    => __( 'نمایش ابعاد محصول', 'parskala' ),
            'default' => 1
        ),
        array(
            'id'       => 'moreText',
            'type'     => 'text',
            'title'    => __('عنوان بقیه ویژگی ها', 'parskala'),
            'default'  => __( 'مشخصات دیگر', 'parskala'),
        ),
    )
) );

// CSF::createSection( $prefix, array(
//     'title'      => __( 'Styling', 'parskala' ),
//     // 'desc'       => __( '', 'parskala' ),
//     'id'         => 'styling-settings',
//     'parent' => 'gAttributes_settings', // The slug id of the parent section
//     'fields'     => array(
//         array(
//             'id'       => 'layout',
//             'type'     => 'image_select',
//             'title'    => __( 'Select Layout', 'parskala' ),
//             'options'  => array(
//                 // '1'      => get_template_directory_uri() . '/inc/woocommerce-group-attributes/admin/img/1.jpg',
//                 '1'      => get_template_directory_uri().'/inc/woocommerce-group-attributes/admin/img/2.jpg',
//                 // '3'      => get_template_directory_uri().'/inc/woocommerce-group-attributes/admin/img/3.jpg',
//                 // '4'      => get_template_directory_uri().'/inc/woocommerce-group-attributes/admin/img/4.jpg',
//             ),
//             'default' => '1'
//         ),
//         array(
//             'id'       => 'layout4Columns',
//             'type'     => 'spinner',
//             'title'    => __( 'Columns', 'wordpress-store-locator' ),
//             'subtitle'     => __( 'Columns of attribute groups for layout 4.'),
//             'min'      => '1',
//             'step'     => '1',
//             'max'      => '12',
//             'default'  => '3',
//             'required' => array('layout','equals','4'),
//         ),
//         array(
//             'id'       => 'enableAccordion',
//             'type'     => 'switcher',
//             'title'    => __( 'Enable Accordion', 'parskala' ),
//             'subtitle' => __( 'Attribute Groups will be hidden in accordions.', 'parskala' ),
//             'default'  => '0',
//         ),
//         array(
//             'id'     =>'attributeValueDivider',
//             'type' => 'select',
//             'title' => __('Attribute Value Divider', 'parskala'),
//             'options' => array(
//                 ', ' => __('Comma', 'parskala'),
//                 '<br>' => __('New Line', 'parskala'),
//                 ' | ' => __('Pipe', 'parskala'),
//                 ),
//             'default' => ', ',
//         ),
//         array(
//             'id'     =>'oddBackgroundColor',
//             'type' => 'color',
//             'title' => __('Odd Background Color', 'parskala'),
//             'validate' => 'color',
//             'default' => '#FFFFFF',
//         ),
//         array(
//             'id'     =>'oddTextColor',
//             'type' => 'color',
//             'title' => __('Odd Text Color', 'parskala'),
//             'validate' => 'color',
//             'default' => '#000000',
//         ),
//         array(
//             'id'     =>'evenBackgroundColor',
//             'type' => 'color',
//             'title' => __('Even Background color', 'parskala'),
//             'validate' => 'color',
//             'default' => '#EAEAEA',
//         ),
//         array(
//             'id'     =>'evenTextColor',
//             'type' => 'color',
//             'title' => __('Even Text color', 'parskala'),
//             'validate' => 'color',
//             'default' => '#000000',
//         ),
//     )
// ) );
//
// CSF::createSection( $prefix, array(
//     'title'      => __( 'Advanced settings', 'parskala' ),
//     'desc'       => __( 'Custom stylesheet / javascript.', 'parskala' ),
//     'id'         => 'advanced',
//     'parent' => 'gAttributes_settings', // The slug id of the parent section
//     'fields'     => array(
//         array(
//             'id'       => 'performanceOnlyWooPages',
//             'type'     => 'switcher',
//             'title'    => __('Performance: Scripts & Stylings', 'woocommerce-attribute-images' ),
//             'subtitle' => __('Only execute CSS & JS Files on product pages.', 'woocommerce-attribute-images' ),
//             'default'  => '1',
//             'required' => array('enable','equals','1'),
//         ),
//         array(
//             'id'       => 'customCSS',
//             'type'     => 'code_editor',
//             'title'    => __( 'Custom CSS', 'parskala' ),
//             'subtitle' => __( 'Add some stylesheet if you want.', 'parskala' ),
//             'settings'=>array(
//                 'mode'     => 'css',
//                 'theme' => 'mbo'
//
//             )
//         ),
//         array(
//             'id'       => 'customJS',
//             'type'     => 'code_editor',
//             'title'    => __( 'Custom JS', 'parskala' ),
//             'subtitle' => __( 'Add some javascript if you want.', 'parskala' ),
//             'settings'=>array(
//                 'mode'     => 'javascript',
//                 'theme' => 'mbo'
//
//             )
//         ),
//     )
// ));


/*
 * <--- END SECTIONS
 */
