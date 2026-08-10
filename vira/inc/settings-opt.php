<?php

function dina_product_attributes_array() {

    if ( ! function_exists( 'wc_get_attribute_taxonomies' ) ) {
        return;
    }
    $attributes = array();

    foreach ( wc_get_attribute_taxonomies() as $attribute ) {
        $attributes[ 'pa_' . $attribute->attribute_name ] = $attribute->attribute_label;
    }

    return $attributes;
}

$PRKSMSApp_url = admin_url('admin.php?page=PRKSMSApp-setting');


// This is your option name where all the Redux data is stored.
$prefix = "prk_option";

$theme = wp_get_theme(); // For use with some settings. Not necessary.
// get all header and footer
$header_posts = get_posts([
    'post_type' => 'header',
    'post_status' => 'publish',
    'numberposts' => -1
]);
$headers = array();
foreach ($header_posts as $key => $value) {
    if (empty($value->post_title)) {
        $headers[$value->ID] = 'بدون عنوان';
    } else {
        $headers[$value->ID] = $value->post_title;
    }
}
$page_posts = get_posts([
    'post_type' => 'page',
    'post_status' => 'publish',
    'numberposts' => -1
]);

$page = array();
foreach ($page_posts as $key => $value) {
    if (empty($value->post_title)) {
        $pages[$value->ID] = 'بدون عنوان';
    } else {
        $pages[$value->ID] = $value->post_title;
    }
}

$footer_posts = get_posts([
    'post_type' => 'footer',
    'post_status' => 'publish',
    'numberposts' => -1
]);
$footers = array();
foreach ($footer_posts as $key => $value) {
    if (empty($value->post_title)) {
        $footers[$value->ID] = 'بدون عنوان';
    } else {
        $footers[$value->ID] = $value->post_title;
    }
}


// Create options
if(!class_exists("CSF")){ return; }
CSF::createOptions($prefix, array(

    // framework title
    'framework_title' => 'قالب ویرا (Vira)',
    'framework_class' => 'prk_head',

    // menu settings
    'menu_title' => 'تنظیمات پوسته',
    'menu_slug' => 'theme-options',
    'menu_capability' => 'manage_options',
    'menu_icon' => null,
    'menu_position' => null,
    'menu_hidden' => false,
    'menu_type'   => 'submenu',
    'menu_parent' => 'prk-theme',
    // menu extras
    'show_bar_menu' => true,
    'show_sub_menu' => true,
    'show_in_network' => true,
    'show_in_customizer' => true,

    'show_reset_all' => true,
    'show_reset_section' => false,
    'show_footer' => true,
    'show_all_options' => true,
    'show_form_warning' => true,
    'sticky_header' => true,
    'save_defaults' => true,
    'ajax_save' => true,

    // admin bar menu settings
    'admin_bar_menu_icon' => 'dashicons dashicons-laptop',
    'admin_bar_menu_priority' => 80,

    // footer
    'footer_text' => '',
    'footer_after' => '',
    'footer_credit' => '',


    // contextual help
    'contextual_help' => array(),
    'contextual_help_sidebar' => 'true',

    // typography options
    'enqueue_webfont' => false,
    'async_webfont' => false,

    // others
    'output_css' => true,

    // theme and wrapper classname
    'nav' => 'normal',
    'theme' => 'dark',
    'class' => 'prk_theme_style',

));




#General Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('عمومی', 'prk'),
    'id' => 'prk_general',
    'customizer_width' => '400px',
    'icon' => 'ri-sound-module-line',
    'fields' => array(

        array(
            'id' => 'favicon',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر فیوآیکون', 'prk'),
        ),
        array(
            'id' => 'favicon_retina',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر رتینا فیوآیکون', 'prk')
        ),
        array(
            'id' => 'prk_preloader',
            'type' => 'switcher',
            'title' => esc_html__('فعال کردن بارگیری صفحه', 'prk'),
            'subtitle' => esc_html__('فعال سازی پیش بارگیری صفحه.', 'prk'),
            'text_width' => 80,
            'default' => false
        ),
        array(
            'id' => 'preloader_type',
            'type' => 'select',
            'title' => esc_html__('انتخاب نوع بارگیری صفحه', 'prk'),
            'subtitle' => esc_html__('نوع پیش بارگیری صفحه را انتخاب کنید', 'prk'),
            'default' => 'Circle-dotted',
            'options' => array(
                'Circle-dotted' => esc_html__('دایره ای', 'prk'),
                'dotted' => esc_html__('نقطه ای', 'prk'),
                'rotating' => esc_html__('چرخشی', 'prk'),
                'tow-rotating' => esc_html__('دو چرخشی', 'prk'),
            ),
            'dependency' => array('prk_preloader', '==', 'true'),
            'select2' => array('allowClear' => false)
        ),
        array(
            'id' => 'prk_preloader_back',
            'type' => 'color',
            'title' => esc_html__('رنگ پس زمینه پیش بارگیری', 'prk'),
            'validate' => 'color',
            'default' => '#fff',
            'transparent' => false,
            'dependency' => array(
                array('prk_preloader', '==', 'true'),
            ),
        ),
        array(
            'id' => 'prk_preloader_color',
            'type' => 'color',
            'title' => esc_html__('رنگ پیش بارگذار', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            'dependency' => array(
                array('prk_preloader', '==', 'true'),
            ),
        ),
        array(
         'id'    => 'prk_preloader_img',
         'type'  => 'media',
         'title' => esc_html__('تصویر پیش بارگذار', 'prk'),
         'dependency' => array(
            array('prk_preloader', '==', 'true'),
         ),
       ),
       array(
           'id' => 'prk_preloader_img_size',
           'type' => 'dimensions',
           'units' => array('px',),
           'output_prefix' => 'max',
           'title' => esc_html__('اندازه تصویر پیش بارگذار', 'prk'),
           'desc' => esc_html__('درصورتی که قصد دارید سایز واندازه پیش بارگذار  را تغییر دهید', 'prk'),
           'output' => array('#prk-preload-logo img'),
           'output_important' => 'true',
           'dependency' => array('prk_preloader', '==', 'true'),
       ),
       array(
           'id' => 'prk_preloader_img_margin',
           'type' => 'spacing',
           'output' => array('#prk-preload-logo img'),
           'output_mode' => 'margin', // or margin, relative
           'output_important' => 'true',
           'units' => array('px'),
           'units_extended' => 'false',
           'title' => __('فاصله تصویر پیش بارگذار', 'redux-framework-demo'),
           'dependency' => array('prk_preloader', '==', 'true'),
       ),
        array(
            'id' => 'google_api_key',
            'type' => 'text',
            'title' => esc_html__('Google API Key', 'prk'),
            'subtitle' => esc_html__('Enter here the secret api key you have created on Google APIs', 'prk')
        ),

        array(
          'type' => 'backup',
        ),

    )
));

#top-bar Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('نوار اعلان', 'prk'),
    'id' => 'prk_topbar',
    'customizer_width' => '400px',
    'icon' => 'ri-notification-3-line',
    'fields' => array(
        array(
            'id' => 'prk_topbar_true',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نوار اعلان', 'prk'),
            'desc' => esc_html__('تنظیمات نوار اعلان در ایجا قرار دارد', 'prk'),

            'default' => false
        ),

        array(
            'id' => 'prk_chose_topbar',
            'type' => 'select',
            'title' => esc_html__('انتخاب نوع نوار اعلان', 'prk'),
            'default' => 'default',
            'options' => array(
                'default' => esc_html__('متنی', 'prk'),
                'gif' => esc_html__('گیف یا تصویر', 'prk'),
            ),
            'dependency' => array(
                array('prk_topbar_true', '==', 'true'),
            ),
        ),

        array(
         'id'    => 'prk_top_gif_img',
         'type'  => 'text',
         'title' => esc_html__('تصویر ، گیف', 'prk'),
         'desc' => esc_html__('آدرس تصویر یا گیف ( سایز پیشنهادی ۱۵۲۰x۵۵px )', 'prk'),
         'dependency' => array(
             array('prk_chose_topbar', '==', 'gif'),
             array('prk_topbar_true', '==', 'true'),
         ),
       ),
       array(
        'id'    => 'prk_top_gif_img_mob',
        'type'  => 'text',
        'title' => esc_html__('تصویر ، گیف در حالت تبلت/موبایل', 'prk'),
        'desc' => esc_html__(' آدرس تصویر یا گیف ( سایز پیشنهادی 720x96px ) ', 'prk'),
        'dependency' => array(
            array('prk_chose_topbar', '==', 'gif'),
            array('prk_topbar_true', '==', 'true'),
        ),
      ),
        array(
            'id' => 'prk_top_gif_url',
            'type' => 'text',
            'title' => esc_html__('لینک', 'prk'),
            'default' => '#',
            'dependency' => array(
                array('prk_chose_topbar', '==', 'gif'),
                array('prk_topbar_true', '==', 'true'),
            ),
        ),
        array(
            'id' => 'prk_topbar_stikey',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('چسبان', 'prk'),
            'desc' => esc_html__('نمایش چسبان نوار اعلان', 'prk'),
            'dependency' => array(
                array('prk_topbar_true', '==', 'true'),
            ),
            'default' => false
        ),
        array(
            'id' => 'gust_home_top',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش فقط در صفحه اصلی', 'prk'),
            'default' => false,
            'dependency' => array(
                array('prk_topbar_true', '==', 'true'),
            ),
        ),

        array(
            'id' => 'gust_top_desctop',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش فقط در pc', 'prk'),
            'default' => false,
            'dependency' => array(
                array('prk_topbar_true', '==', 'true'),
            ),
        ),

        array(
            'id' => 'prk_topbar_text',
            'type' => 'text',
            'title' => esc_html__('متن نوار اعلان', 'prk'),
            'desc' => esc_html__('متن اصلی نوار اعلان', 'prk'),
            'default' => 'این یک متن تستی در نوار اعلان صفحه میباشد‌!',
            'dependency' => array(
                array('prk_chose_topbar', '==', 'default'),
                array('prk_topbar_true', '==', 'true'),
            ),
            'select2' => array('allowClear' => false)
        ),
        array(
            'id' => 'prk_topbar_text_color',
            'type' => 'color',
            'title' => esc_html__('رنگ متن اصلی', 'prk'),
            'desc' => esc_html__('انتخاب رنگ متن اصلی نوار اعلان', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            'default' => '#fdfdfd',
            'dependency' => array(
                array('prk_chose_topbar', '==', 'default'),
                array('prk_topbar_true', '==', 'true'),
            ),
            'select2' => array('allowClear' => false)
        ),
        array(
            'id' => 'prk_topbar_text_center',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('وسط چین', 'prk'),
            'desc' => esc_html__('وسطچین کردن متن عنوان نوار اعلان', 'prk'),
            'dependency' => array(
                array('prk_chose_topbar', '==', 'default'),
                array('prk_topbar_true', '==', 'true'),
            ),
            'default' => false
        ),

        array(
            'id' => 'prk_topbar_bg_color',
            'type' => 'color',
            'title' => esc_html__('رنگ پس زمینه', 'prk'),
            'desc' => esc_html__('انتخاب رنگ پس زمینه نوار اعلان', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            'default' => '#EF394E',
            'dependency' => array(
                array('prk_chose_topbar', '==', 'default'),
                array('prk_topbar_true', '==', 'true'),
            ),
            'select2' => array('allowClear' => false)
        ),
        array(
            'id' => 'prk_topbar_bg_img',
            'type' => 'media',
            'title' => esc_html__('تصویر پس زمینه', 'prk'),
            'desc' => esc_html__('اپلود تصویز پس زمینه در صورت عدم انتخاب رنگ پس زمینه', 'prk'),
            'operator' => 'and',
            'dependency' => array(
                array('prk_chose_topbar', '==', 'default'),
                array('prk_topbar_true', '==', 'true'),
            ),
            'select2' => array('allowClear' => false)
        ),
        array(
            'id' => 'prk_topbar_close',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش دکمه بستن اعلان', 'prk'),
            'default' => true,
            'dependency' => array(
                array('prk_chose_topbar', '==', 'default'),
                array('prk_topbar_true', '==', 'true'),
            ),
            'select2' => array('allowClear' => false)
        ),
        array(
            'id' => 'prk_topbar_blink',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش دکمه نوار اعلان', 'prk'),
            'default' => false,
            'dependency' => array(
                array('prk_chose_topbar', '==', 'default'),
                array('prk_topbar_true', '==', 'true'),
            ),
            'select2' => array('allowClear' => false)
        ),
        array(
            'id' => 'prk_topbar_blink_text',
            'type' => 'text',
            'title' => esc_html__('متن دکمه', 'prk'),
            'desc' => esc_html__('متن دکمه نوار اعلان', 'prk'),
            'default' => 'خرید فقط از راستچین',
            'dependency' => array(
                array('prk_chose_topbar', '==', 'default'),
                array('prk_topbar_true', '==', 'true'),
            ),
            'select2' => array('allowClear' => false)
        ),
        array(
            'id' => 'prk_topbar_blink_url',
            'type' => 'text',
            'title' => esc_html__('لینک دکمه', 'prk'),
            'desc' => esc_html__('لینک دکمه نوار اعلان', 'prk'),
            'default' => '#',
            'dependency' => array(
                array('prk_chose_topbar', '==', 'default'),
                array('prk_topbar_true', '==', 'true'),
            ),
        ),
        array(
            'id' => 'prk_topbar_blink_color',
            'type' => 'color',
            'title' => esc_html__('رنگ دکمه', 'prk'),
            'desc' => esc_html__('انتخاب رنگ دکمه نوار اعلان', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            'default' => '#EF394E',
            'dependency' => array(
                array('prk_chose_topbar', '==', 'default'),
                array('prk_topbar_true', '==', 'true'),
            ),
        ),
        array(
            'id' => 'prk_topbar_blink_bg_color',
            'type' => 'color',
            'title' => esc_html__('رنگ پس زمینه دکمه', 'prk'),
            'desc' => esc_html__('انتخاب رنگ پس زمینه دکمه نوار اعلان', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            'default' => '#fff',
            'dependency' => array(
                array('prk_chose_topbar', '==', 'default'),
                array('prk_topbar_true', '==', 'true'),
            ),
        ),

    )
));

#styles Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('سبک ها', 'prk'),
    'id' => 'styles',
    'icon' => 'ri-paint-line',
));

#styles typography
CSF::createSection($prefix, array(
    'title' => esc_html__('ظاهر قالب', 'prk'),
    'id' => 'theme-display',
    'parent' => 'styles', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'theme-style',
            'title' => 'سبک نمایش قالب',
            'desc' => 'انتخاب سبک نمایش قالب',
            'type' => 'select',
            'default' => 'parskala',
            'options' => array(
                'parskala' => esc_html__('قالب ویرا (Vira)', 'prk'),
                'prk-plus' => esc_html__('پارس پلاس', 'prk'),
                'prk-fashion' => esc_html__('پارس فشن', 'prk'),
                'digikala' => esc_html__('دیجی کالا', 'prk'),
            )
        ),

        array(
            'id' => 'header_style_type',
            'type' => 'image_select',
            'title' => esc_html__('استایل هدر', 'prk'),
            'default' => 'default',
            'options'   => array(
                'style_2'   => get_template_directory_uri().'/assets/img/options/style2-header.png',
                'default'   => get_template_directory_uri().'/assets/img/options/def-header.png',
                'mobit'   => get_template_directory_uri().'/assets/img/options/mobit-header.png',
              ),
            'select2' => array('allowClear' => false),
            'dependency' => array('theme-style', '!=', 'digikala'),
        ),
        
        array(
            'id' => 'header_gradient_general_color',
            'type' => 'background',
            'title' => 'رنگ گرادیانت هدر',
            'background_gradient' => true,
            'background_origin' => true,
            'background_image' => false,
            'background_clip' => true,
            'background_blend_mode' => true,
            'output' => array('background-color' => 'body .header-mobiter header'),
            'output_important' => 'true',
            'dependency' => array('header_style_type', '==', 'mobit'),
        ),

        array(
            'id' => 'site_continer',
            'type' => 'dimensions',
            'units' => array('px','%'),
            'title' => esc_html__('اندازه عرض سایت', 'prk'),
            'desc' => esc_html__('رقم اندازه سایت را متناسب با طراحی خود  وارد نمایید', 'prk'),
            'subtitle' => esc_html__('اندازه این عرض فقط در صفحات داخلی غیر از صفحه اصلی اعمال میشود !', 'prk'),
            'height' => 'false',
            'output' => array('body .continer'),

        ),
        array(
            'id' => 'site_continer_product',
            'type' => 'dimensions',
            'units' => array('px','%'),
            'title' => esc_html__('اندازه عرض صفحه محصول', 'prk'),
            'desc' => esc_html__('رقم اندازه سایت را متناسب با طراحی خود  وارد نمایید', 'prk'),
            'height' => 'false',

        ),

        array(
            'id' => 'max_continer',
            'type' => 'dimensions',
            'output_prefix' => 'max',
            'units' => array( 'px'),
            'title' => esc_html__('حداکثر اندازه عرض سایت', 'prk'),
            'subtitle' => esc_html__('اندازه این عرض فقط در صفحات داخلی غیر از صفحه اصلی اعمال میشود !', 'prk'),
            'height' => 'false',
            'output' => array('body .continer'),
        ),
        array(
            'id' => 'max_continer_product',
            'type' => 'dimensions',
            'output_prefix' => 'max',
            'units' => array('px'),
            'title' => esc_html__('حداکثر اندازه سایز صفحه محصول', 'prk'),
            'height' => 'false',
            'output' => array('body.product-single .continer'),
        ),

    )
));
#styles typography
CSF::createSection($prefix, array(
    'title' => esc_html__('تایپوگرافی', 'prk'),
    'id' => 'typography',
    'parent' => 'styles', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'fonts',
            'title' => 'فونت',
            'desc' => 'انتخاب فونت اصلی سایت',
            'type' => 'select',
            'default' => 'IRANSans',
            'options' => array(
                'IRANSans' => esc_html__('ایران سنس', 'prk'),
                'IRANyekan_bakh' => esc_html__('یکان بخ', 'prk'),
                'IRANyekan' => esc_html__('یکان', 'prk'),
                'dana' => esc_html__('دانا', 'prk'),
                'kalemeh' => esc_html__('کلمه', 'prk'),
            )
        ),
        array(
            'id' => 'fonts_admin',
            'title' => 'فونت پنل مدیریت',
            'desc' => 'انتخاب فونت پنل مدیریت',
            'type' => 'select',
            'default' => 'iransans',
            'options' => array(
                'iranyekan' => esc_html__('IRANYEKAN', 'prk'),
                'iransans' => esc_html__('IRANSANS', 'prk'),
            )
        ),

        array(
            'id' => 'select_numer_count',
            'type' => 'select',
            'title' => esc_html__('نوع نمایش اعداد سایت', 'prk'),
            'default' => 'munen',
            'options' => array(
                'numfa' => esc_html__('فارسی', 'prk'),
                'munen' => esc_html__('لاتین', 'prk'),
            ),

          ),
        array(
            'id' => 'custom_font',
            'type' => 'switcher',
            'title' => esc_html__('استفاده از فونت سفارشی', 'prk'),
            'desc' => esc_html__('توسط این گزینه می توانید از فونت سفارشی خودتان استفاده نمایید.', 'prk'),
            'default' => false,
        ),
        // A Heading
        array(
          'type'    => 'heading',
          'content' => 'بارگذاری وزن نرمال فونت',
          'dependency' => array(
              array('custom_font', '==', 'true'),
          ),
        ),
        array(
         'id'    => 'theme_font_woff2',
         'type'  => 'upload',
         'title' => 'فونت WOFF2',
         'dependency' => array(
             array('custom_font', '==', 'true'),
         ),
        ),
        array(
         'id'    => 'theme_font_woff',
         'type'  => 'upload',
         'title' => 'فونت WOFF',
         'dependency' => array(
             array('custom_font', '==', 'true'),
         ),
        ),
        array(
         'id'    => 'theme_font_ttf',
         'type'  => 'upload',
         'title' => 'فونت TTF',
         'dependency' => array(
             array('custom_font', '==', 'true'),
         ),
        ),
        array(
         'id'    => 'theme_font_eot',
         'type'  => 'upload',
         'title' => 'فونت EOT',
         'dependency' => array(
             array('custom_font', '==', 'true'),
         ),
        ),
        array(
         'id'    => 'theme_font_svg',
         'type'  => 'upload',
         'title' => 'فونت SVG',
         'dependency' => array(
             array('custom_font', '==', 'true'),
         ),
        ),

        // A Heading
        array(
          'type'    => 'heading',
          'content' => 'بارگذاری وزن بولد',
          'dependency' => array(
              array('custom_font', '==', 'true'),
          ),
        ),
        array(
            'id' => 'custom_bold_font',
            'type' => 'switcher',
            'title' => esc_html__('بارگذاری وزن بولد', 'prk'),
            'desc' => esc_html__('با فعالسازی این گزینه می توانید وزن بولد و توپر فونت را آپلود نمایید.', 'prk'),
            'default' => false,
            'dependency' => array(
                array('custom_font', '==', 'true'),
            ),
        ),
        array(
         'id'    => 'theme_font_bold_woff2',
         'type'  => 'upload',
         'title' => 'فونت WOFF2',
         'dependency' => array(
           array('custom_font', '==', 'true'),
           array('custom_bold_font', '==', 'true'),
         ),
        ),
        array(
         'id'    => 'theme_font_bold_woff',
         'type'  => 'upload',
         'title' => 'فونت WOFF',
         'dependency' => array(
           array('custom_font', '==', 'true'),
           array('custom_bold_font', '==', 'true'),
         ),
        ),
        array(
         'id'    => 'theme_font_bold_ttf',
         'type'  => 'upload',
         'title' => 'فونت TTF',
         'dependency' => array(
           array('custom_font', '==', 'true'),
           array('custom_bold_font', '==', 'true'),
         ),
        ),
        array(
         'id'    => 'theme_font_bold_eot',
         'type'  => 'upload',
         'title' => 'فونت EOT',
         'dependency' => array(
           array('custom_font', '==', 'true'),
           array('custom_bold_font', '==', 'true'),
         ),
        ),
        array(
         'id'    => 'theme_font_bold_svg',
         'type'  => 'upload',
         'title' => 'فونت SVG',
         'dependency' => array(
             array('custom_font', '==', 'true'),
             array('custom_bold_font', '==', 'true'),
         ),
        ),

        array(
            'id' => 'prk_topbar_heading_texed',
            'type' => 'typography',
            'title' => esc_html__('متن عنوان نوار اعلان', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => false,
            'output' => array('body #topbars .topbar-text p'),
            'units' => 'px',
        ),
        array(
            'id' => 'menu_heading',
            'type' => 'typography',
            'title' => esc_html__('فونت عنوان منوهای اصلی', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => false,
            'output' => array('.top-nav .dropdown > li > a'),
            'units' => 'px',
            'subtitle' => esc_html__('فونت عنوان های منو ', 'parskala'),
        ),
        array(
            'id' => 'menu_heading_categoris',
            'type' => 'typography',
            'title' => esc_html__('فونت عنوان منو دسته بندی ها', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => false,
            'output' => array('.top-nav .dropdown > li.categoryser > a'),
            'units' => 'px',
            'subtitle' => esc_html__('فونت عنوان اول (دسته بندی)', 'parskala'),
        ),
        array(
            'id' => 'menu_heading_categoris_sub_title_1',
            'type' => 'typography',
            'title' => esc_html__('فونت عناوین زیر دسته ها (دسته بندی)', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => false,
            'output' => array('.top-nav .sub-menu:nth-child(2) > li > a'),
            'units' => 'px',
        ),
        array(
            'id' => 'menu_heading_megamenu_sub_title_1',
            'type' => 'typography',
            'title' => esc_html__('فونت عناوین مگامنو', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => false,
            'output' => array('.top-nav .mega-menus .sub-menu:nth-child(2) li a '),
            'units' => 'px',
        ),
        array(
            'id' => 'heading_search',
            'type' => 'typography',
            'title' => esc_html__('فونت جاگذار باکس جستجو', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output' => array('.desktop .prk_input_serach::placeholder'),
            'units' => 'px',
        ),
        array(
            'id' => 'heading_account_text',
            'type' => 'typography',
            'title' => esc_html__('فونت عنوان ورود ثبت نام', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output' => array('.account-text'),
            'units' => 'px',
        ),
        array(
            'id' => 'heading_account_icon_before',
            'type' => 'typography',
            'title' => esc_html__('اندازه فونت ایکن ورود/ثبت نام', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'subtitle' => esc_html__('قبل از ورود کاربر', 'parskala'),
            'output' => array('.account.noselect span.account-icon i'),
            'units' => 'px',
        ),
        array(
            'id' => 'heading_card_icon',
            'type' => 'typography',
            'title' => esc_html__('اندازه فونت ایکن سبد خرید', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output' => array('body.desctop  span.cart-btn i'),
            'units' => 'px',
        ),

        // سکشن شگفت انگیزها ورژن 2
        array(
            'id' => 'section_product_off_title_v2',
            'type' => 'typography',
            'title' => esc_html__('عنوان سکشن محصولات شگفت انگیز v2', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output' => array('.col-off.v2 .product-title'),
            'units' => 'px',
        ),
        array(
            'id' => 'section_product_price_v2',
            'type' => 'typography',
            'title' => esc_html__('قیمت اصلی سکشن محصولات شگف انگیز v2', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'output' => array('.col-off.v2 .off-product .index-prices-pro div del,.col-off.v2 .off-product .index-prices-pro div del span.sale_price'),
            'output_important' => 'true',
            'units' => 'px',
        ),
        array(
            'id' => 'section_product_off_price_sale_v2',
            'type' => 'typography',
            'title' => esc_html__('قیمت تخفیف خورده سکشن محصولات شگفت انگیز v2', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output' => array('.col-off.v2 .off-product .index-prices-pro div.price_onsale_ar span.price_sale'),
            'output_important' => 'true',
            'units' => 'px',
        ),
        array(
            'id' => 'section_product_off_timer_v2',
            'type' => 'typography',
            'title' => esc_html__('فونت تایمر سکشن محصولات شگفت انگیز v2', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output' => array('.col-off.v1 .off-product #prk-timers,.col-off.v2 .prk-tim i'),
            'output_important' => 'true',
            'units' => 'px',
        ),

        // سکشن شگفت انگیزها ورژن1
        array(
            'id' => 'section_product_off_title_v1',
            'type' => 'typography',
            'title' => esc_html__('عنوان سکشن محصولات شگفت انگیز v1', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output' => array('.col-off.v1 .index-title-pro h2'),
            'output_important' => 'true',
            'units' => 'px',
        ),
        array(
            'id' => 'section_product_price_v1',
            'type' => 'typography',
            'title' => esc_html__('قیمت اصلی سکشن محصولات شگف انگیز v1', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'output_important' => 'true',
            'output' => array('.col-off.v1 .off-product .index-prices-pro div del span.sale_price,.col-off.v1 .off-product .index-prices-pro div del'),
            'units' => 'px',
        ),
        array(
            'id' => 'section_product_off_price_sale_v1',
            'type' => 'typography',
            'title' => esc_html__('قیمت تخفیف خورده سکشن محصولات شگفت انگیز v1', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.col-off.v1 .off-product .index-prices-pro div.price_onsale_ar span.price_sale,.col-off.v1 .off-product .index-prices-pro div.price_onsale_ar ins span.price_sale'),
            'units' => 'px',
        ),
        array(
            'id' => 'section_product_off_timer_v1',
            'type' => 'typography',
            'title' => esc_html__('فونت تایمر سکشن محصولات شگفت انگیز v1', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.col-off.v1 .off-product #prk-timers,.col-off.v1 .prk-tim i'),
            'units' => 'px',
        ),
        // سکشن پست های مدرن
        array(
            'id' => 'section_post_title_modern',
            'type' => 'typography',
            'title' => esc_html__('عنوان سکشن پست های مدرن', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.mcarousel_product.modern_blog .post_title'),
            'units' => 'px',
        ),

        // سکشن محصولات
        array(
            'id' => 'section_product_head_title',
            'type' => 'typography',
            'title' => esc_html__('عنوان سکشن محصولات', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.right-product .head-product h3'),
            'units' => 'px',
        ),
        array(
            'id' => 'section_product_title',
            'type' => 'typography',
            'title' => esc_html__('عنوان آیتم سکشن محصولات', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.right-product .item-pro .index-title-pro h2'),
            'units' => 'px',
        ),
        array(
            'id' => 'section_product_price',
            'type' => 'typography',
            'title' => esc_html__('قیمت اصلی آیتم سکشن محصولات', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'output_important' => 'true',
            'output' => array('.right-product .item-pro .index-prices-pro div del span.sale_price,.right-product .item-pro .index-prices-pro div del'),
            'units' => 'px',
        ),
        array(
            'id' => 'section_product_price_sale',
            'type' => 'typography',
            'title' => esc_html__('قیمت تخفیف خورده آیتم سکشن محصولات', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.right-product .item-pro .index-prices-pro div.price_onsale_ar span.price,.right-product .item-pro .index-prices-pro div.price_onsale_ar ins span.price_sale'),
            'units' => 'px',
        ),
        // صفحه محصول
        array(
            'id' => 'single_product_title',
            'type' => 'typography',
            'title' => esc_html__('عنوان محصول', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'desc' => esc_html__('عنوان محصول در صفحه محصول', 'parskala'),
            'output' => array('.woocommerce div.product .product_title'),
            'units' => 'px',
        ),
        array(
            'id' => 'single_product_title_latin',
            'type' => 'typography',
            'title' => esc_html__('عنوان انگلیسی', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'desc' => esc_html__('عنوان انگلیسی در صفحه محصول', 'parskala'),
            'output' => array('.des-info .product-en span.en_name_pro'),
            'units' => 'px',
        ),
        array(
            'id' => 'single_product_title_seler',
            'type' => 'typography',
            'title' => esc_html__('عنوان باکس فروشنده', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.product-seller-info .product-seller-row .product-seller-row-detail .product-seller-row-detail-title'),
            'units' => 'px',
        ),
        array(
            'id' => 'single_product_icon_seler',
            'type' => 'typography',
            'title' => esc_html__('آیکن باکس فروشنده محصول', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.product-seller-info .product-seller-row .product-seller-row-icon i'),
            'units' => 'px',
        ),
        array(
            'id' => 'single_product_add_to_cart_title',
            'type' => 'typography',
            'title' => esc_html__('عنوان اضافه کردن به سبد خرید در صفحه محصول', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.woocommerce div.product form.cart .button'),
            'units' => 'px',
        ),
        array(
            'id' => 'single_product_attributes_titles',
            'type' => 'typography',
            'title' => esc_html__('عنوان متن ویژگی های محصول در صفحه محصول', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.product-single .atri-single'),
            'units' => 'px',
        ),
        array(
            'id' => 'single_product_attributes_texts',
            'type' => 'typography',
            'title' => esc_html__('متن ویژگی های محصول در صفحه محصول', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.product-single .meta-additional ul li'),
            'units' => 'px',
        ),
        array(
            'id' => 'single_product_services_texts',
            'type' => 'typography',
            'title' => esc_html__('متن سرویس های صفحه محصول', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.product-single .servis-single span'),
            'units' => 'px',
        ),
        array(
            'id' => 'single_product_releted_product_texts',
            'type' => 'typography',
            'title' => esc_html__('عنوان سکشن محصولات مرتبط', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.product-single .head-product h3'),
            'units' => 'px',
        ),

        array(
            'id' => 'single_product_ws_tabs_icon',
            'type' => 'typography',
            'title' => esc_html__('ایکن عناوین تب محصول', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.woocommerce div.product .woocommerce-tabs ul.tabs li.description_tab a::before'),
            'units' => 'px',
        ),
        array(
            'id' => 'single_product_ws_tabs_texts',
            'type' => 'typography',
            'title' => esc_html__('متن عناوین تب محصول', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.woocommerce div.product .woocommerce-tabs ul.tabs li a'),
            'units' => 'px',
        ),
        array(
            'id' => 'footer_connect_texts',
            'type' => 'typography',
            'title' => esc_html__('متن عناوین راه های ارتباطی فوتر', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.text-number, .support, .one-number, .tow-number'),
            'units' => 'px',
        ),
        array(
            'id' => 'footer_title_menu',
            'type' => 'typography',
            'title' => esc_html__('عنوان فهرست های فوتر', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.foot-box .foot-title'),
            'units' => 'px',
        ),
        array(
            'id' => 'footer_text_menu',
            'type' => 'typography',
            'title' => esc_html__('متون فهرست های راهبردی', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.footer-s .foot-box .menu-item a'),
            'units' => 'px',
        ),
        array(
            'id' => 'footer_text_about',
            'type' => 'typography',
            'title' => esc_html__('متن درباره ما ', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.foot-box p'),
            'units' => 'px',
        ),
        array(
            'id' => 'footer_text_copyright',
            'type' => 'typography',
            'title' => esc_html__('متن کپی رایت فوتر', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('.copy-right-foot span'),
            'units' => 'px',
        ),

        array(
            'id' => 'pragraf_text_post',
            'type' => 'typography',
            'title' => esc_html__('متن پاراگراف های نوشته و برگه', 'parskala'),
            'compiler' => true,
            'font-backup' => false,
            'font-weight' => true,
            'all_styles' => true,
            'google' => false,
            'text-align' => true,
            'font-family' => false,
            'font-style' => false,
            'subsets' => false,
            'font-size' => true,
            'line-height' => true,
            'word-spacing' => false,
            'color' => true,
            'preview' => true,
            'output_important' => 'true',
            'output' => array('body .main-cont .conts p,body .main-cont .conts div,body .main-cont .conts'),
            'units' => 'px',
        ),

    )
));

#styles colors
CSF::createSection($prefix, array(
    'title' => esc_html__('رنگ ها', 'prk'),
    'id' => 'colors',
    'parent' => 'styles', // The slug id of the parent section
    'fields' => array(

        array(
            'id' => 'gradient_general_color',
            'type' => 'background',
            'title' => 'رنگ گرادیانت سازمانی اول',
            'subtitle' => 'توجه : کلیه عناوین و المان های مهم سایت از این فیلد الگو میگیرند !',
            'desc' => 'در صورت تکی بودن رنگ سازمان هر دو فیلد های رنگ را رنگ مورد نظر خود انتخاب کنید !',
            'background_gradient' => true,
            'background_origin' => true,
            'background_image' => false,
            'background_clip' => true,
            'background_blend_mode' => true,
            'output' => gradient_general_selector(),
            'output_important' => 'true',
        ),
        array(
            'id' => 'general_color',
            'type' => 'color',
            'title' => esc_html__('رنگ سازمانی اول', 'prk'),
            'desc' => esc_html__('انتخاب رنگ سازمانی اول', 'prk'),
            'transparent' => false,
            'output' => general_selector(),
            'output_important' => 'true',
            'default' => '#EF394E',
        ),

        array(
            'id' => 'general_color2',
            'type' => 'color',
            'title' => esc_html__('رنگ سازمانی دوم', 'prk'),
            'desc' => esc_html__('انتخاب رنگ سازمانی دوم', 'prk'),
            'transparent' => false,
            'output' => general2_selector(),
            'output_important' => 'true',
            'default' => '#00bfd6',
        ),
        array(
            'id' => 'general_links',
            'type' => 'color',
            'title' => esc_html__('رنگ لینک ها', 'prk'),
            'desc' => esc_html__('انتخاب رنگ لینک ها', 'prk'),
            'transparent' => false,
            'output' => links_selector(),
            'output_important' => 'true',
            'default' => '#0071e3',
        ),

        array(
            'id' => 'header_color',
            'type' => 'color',
            'title' => esc_html__('رنگ پس زمینه هدر', 'prk'),
            'desc' => esc_html__('انتخاب رنگ پس زمینه هدر', 'prk'),
            'transparent' => false,
            'output_important' => 'true',
            'output' => array('background-color' => '.header,body .header-borner')
        ),
        array(
            'id' => 'header_text_color',
            'type' => 'color',
            'title' => esc_html__('رنگ متن هدر', 'prk'),
            'desc' => esc_html__('انتخاب رنگ متون  هدر', 'prk'),
            'output' => header_text_color(),
            'output_important' => 'true',
            'transparent' => false,
        ),
        array(
            'id' => 'header_color_cart1',
            'type' => 'color',
            'title' => esc_html__('رنگ ایکن سبدخرید', 'prk'),
            'desc' => esc_html__('انتخاب رنگ ایکن سبد خرید', 'prk'),
            'default' => '#424750',
            'validate' => 'color',
            'transparent' => false,
            'output_important' => 'true',
            'output' => array('color' => '.cart-btn i'),
        ),
        array(
            'id' => 'header_color_cart_dot',
            'type' => 'color',
            'title' => esc_html__('رنگ شمارنده ایکن سبدخرید', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            'output_important' => 'true',
            'output' => array('background' => 'body .cart-btn em'),
        ),
        array(
            'id' => 'header_color_icon_menu',
            'type' => 'color',
            'title' => esc_html__('رنگ ایکن منو در موبایل', 'prk'),
            'default' => '#545d6e',
            'validate' => 'fill',
            'transparent' => false,
            'output_important' => 'true',
            'output' => array('fill' => '#icon-menu svg path'),
        ),
        array(
            'id' => 'header_color_icon_menu_text',
            'type' => 'color',
            'title' => esc_html__('رنگ عنوان کنار ایکن منو', 'prk'),
            'default' => '#b4b4b4',
            'validate' => 'color',
            'transparent' => false,
            'output_important' => 'true',
            'output' => array('color' => 'body .menu-text'),
        ),
        array(
            'id' => 'header_color_user1',
            'type' => 'color',
            'title' => esc_html__('رنگ ایکن و عنوان حساب کاربری', 'prk'),
            'desc' => esc_html__('انتخاب رنگ ایکن و عنوان حساب کاربری', 'prk'),
            'default' => '#424750',
            'validate' => 'color',
            'transparent' => false,
            'output_important' => 'true',
            'output' => array(
                'color' => '.prk-account .prk-arrow-down-1,.account-text,.prk-account .account .fi-rr-angle-small-down,.account-icon i,.prk-plus.prk-account.logined .account-icon i,.prk-plus.prk-account .account_mobile .account-icon i,.faqs-mobile:before,.menu-text',
                'background-color' => '#pencet span'
            )
        ),
        array(
            'id' => 'header_color_call1',
            'type' => 'color',
            'title' => esc_html__('رنگ ایکن تماس فوری', 'prk'),
            'desc' => esc_html__('انتخاب  رنگ ایکن تماس فوری', 'prk'),
            'default' => '#424750',
            'validate' => 'color',
            'transparent' => false,
            'output' => array('color' => '.call-page i')
        ),
        array(
            'id' => 'header_color_call1',
            'type' => 'color',
            'title' => esc_html__('رنگ برگه مهم سایت', 'prk'),
            'desc' => esc_html__('انتخاب  رنگ برگه مهم سایت', 'prk'),
            'default' => '#444',
            'validate' => 'color',
            'transparent' => false,
            'output' => array('color' => '.page-promotes li a')
        ),
        array(
            'id' => 'menu_color',
            'type' => 'color',
            'title' => esc_html__('رنگ پس زمینه منو', 'prk'),
            'desc' => esc_html__('انتخاب رنگ پس زمینه منو', 'prk'),
            'transparent' => false,
            'output_important' => 'true',
            'output' => array('background-color' => '.menus,.top-nav')
        ),
        array(
            'id' => 'menu_sub_color',
            'type' => 'color',
            'title' => esc_html__('رنگ پس زمینه مگامنو', 'prk'),
            'transparent' => false,
            'output_important' => 'true',
            'output' => array('background-color' => '.sub-menu,.modal-menu,.prk_mega_menu > li.mega_menu_tree_level.prk-side-tab:hover .prk-tab-menu-items')
        ),
        array(
            'id' => 'menu_text_color',
            'type' => 'color',
            'title' => esc_html__('رنگ متن منو', 'prk'),
            'desc' => esc_html__('انتخاب رنگ متون  منو', 'prk'),
            'transparent' => false,
            'output_important' => 'true',
            'output' => array('color' => '.prk_mega_menu > li > a i,.prk_mega_menu > li > a,body .modal-menu .off-canvas-main .menu li > a i,.off-canvas-main li.menu-item-has-children span.toggle-submenu::after,body .modal-menu .off-canvas-main .menu ul.sub-menu span.close-submenu,.off-canvas-main .menu a,.top-nav li.categoryser:nth-child(1) a::before,.top-nav .mega-menus .sub-menu:nth-child(2) li ul li a,  .top-nav .dropdown > li > a,.top-nav .sub-menu > li > a,.top-nav .dropdown li ul li::before,.top-nav .dropdown li ul li ul li a,.top-nav div .dropdown li ul li ul li ul li a,.top-nav .dropdown li::before,.prk_mega_menu > li.clasic_menu > ul li.menu-item-has-children:after')
        ),
        array(
            'id' => 'footer_color',
            'type' => 'color',
            'title' => esc_html__('رنگ پس زمینه فوتر', 'prk'),
            'desc' => esc_html__('انتخاب رنگ پس زمینه فوتر', 'prk'),
            'transparent' => false,
            'output_important' => 'true',
            'output' => array('background-color' => '.footer-s')
        ),
        array(
            'id' => 'footer_text_color',
            'type' => 'color',
            'title' => esc_html__('رنگ متن فوتر', 'prk'),
            'desc' => esc_html__('انتخاب رنگ متون  فوتر', 'prk'),
            'transparent' => false,
            'output_important' => 'true',
            'output' => array('border-color' => '.line-foot', 'color' => '.continer .tow-number,body .main-footer .continer .foot-box.has-menu,.continer .text-number,.continer .one-number,.continer .support,.social-foot .icon-social i,.jump-box i::before,.jump-box a,.tell-box,.sec span,.foot-box .foot-title,.footer-s .foot-box .menu-item a,.foot-box .foot-title,.foot-box p,.copy-right-foot span,.main-footer .continer .foot-box.has-menu .foot-title::before')
        ),
        array(
            'id' => 'prk_addressbar',
            'type' => 'color',
            'title' => esc_html__('رنگ آدرس بار مرورگر', 'prk'),
            'desc' => esc_html__('انتخاب رنگ', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            'default' => '#ef394e',
        ),
        array(
            'id' => 'prk_body_color',
            'type' => 'color',
            'title' => esc_html__('رنگ پس زمینه سایت', 'prk'),
            'desc' => esc_html__('انتخاب رنگ', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            'output' => array('background-color' => 'body'),
            'output_important' => 'true',
            'default' => '#ffffff',
        ),
        array(
            'id' => 'prk_location_color',
            'type' => 'color',
            'title' => esc_html__('رنگ متن انتخاب مکان کاربر', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            'output_important' => 'true',
            'output' => array('color' => '.location-piker i.icon,.location-piker .location_name,.location-piker_mob')
        ),
        array(
            'id' => 'animated_color',
            'type' => 'color',
            'title' => esc_html__('رنگ پاپ آپ انیمیشن', 'prk'),
            'transparent' => false,
        ),
        array(
            'id' => 'prk_scroll_color',
            'type' => 'color',
            'title' => esc_html__('رنگ اسکرول بار مرورگر', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            'output' => array('background' => '::-webkit-scrollbar-thumb ')
        ),
        array(
            'id' => 'prk_borline_color',
            'type' => 'color',
            'title' => esc_html__('رنگ لاین بار منوها', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            'output' => array('background' => 'body .top-nav li#bor-line')
        ),
    )
));

#styles colors
CSF::createSection($prefix, array(
    'title' => esc_html__('آیکن ها', 'prk'),
    'id' => 'colors',
    'parent' => 'styles', // The slug id of the parent section
    'fields' => array(
        array(
            'type' => 'notice',
            'style' => 'warning',
            'content' => 'توجه:  با فعال سازی کتابخانه ایکن remixicon ( 5مگابایت) به حجم قالب اضافه میشود !',
        ),
        array(
            'id' => 'iconfont_selected',
            'type' => 'image_select',
            'title' => 'انتخاب فونت آیکن های سایت',
            'desc' => 'دریافت فونت ایکن از سایت .<a href="https://remixicon.com/" target="_blank">remixicon</a>  یا : <a href="http://parskalas.com/icon/iconpars.html" target="_blank">فونت های اختصاصی پارس کالا</a>',
            'multiple' => true,
            'options' => array(
                'Remix_icon' => parskala_URI . '/assets/img/options/Remix-icon.png',
                'isax_icon' => parskala_URI . '/assets/img/options/pars-icon.jpg',
            ),
            'default' => array('Remix_icon', 'isax_icon')
        ),
        array(
            'type' => 'submessage',
            'style' => 'success',
            'content' => 'ایکن های صفحه محصول',
        ),
        array(
            'id' => 'like_icon',
            'type' => 'text',
            'title' => 'افزودن به لیست علاقمندی ها',
            'default' => 'prk-heart'
        ),
        array(
            'id' => 'like_icon_after',
            'type' => 'text',
            'title' => 'بعد از افزودن به لیست علاقمندی ها',
            'default' => 'prk-heart1'
        ),
        array(
            'id' => 'share_icon',
            'type' => 'text',
            'title' => 'اشتراک گذاری محصول',
            'default' => 'prk-send-2'
        ),
        array(
            'id' => 'compare_icon',
            'type' => 'text',
            'title' => 'مقایسه محصول',
            'default' => 'prk-slider-vertical'
        ),
        array(
            'id' => 'chart_icon',
            'type' => 'text',
            'title' => 'نمودار قیمت',
            'default' => 'prk-diagram'
        ),
        array(
            'id' => 'video_icon',
            'type' => 'text',
            'title' => 'ویدیو محصول',
            'default' => 'prk-play'
        ),
        array(
            'id' => 'ques_icon',
            'type' => 'text',
            'title' => 'اطلاعات محصول',
            'default' => 'prk-message-question'
        ),
        array(
            'type' => 'submessage',
            'style' => 'success',
            'content' => 'اطلاعات فروشنده صفحه محصول',
        ),
        array(
            'id' => 'seller_icon',
            'type' => 'text',
            'title' => 'ایکن فروشنده',
            'default' => 'prk-shop'
        ),
        array(
            'id' => 'gard_icon',
            'type' => 'text',
            'title' => 'گارانتی محصول',
            'default' => 'prk-shield-tick'
        ),
        array(
            'id' => 'zemanat_icon',
            'type' => 'text',
            'title' => 'ضمانت محصول',
            'default' => 'prk-percentage-circle'
        ),
        array(
            'id' => 'stok_icon',
            'type' => 'text',
            'title' => 'ارسال توسط فروشگاه',
            'default' => ''
        ),
    )
));

#Header Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی قالب موبایل', 'prk'),
    'id' => 'prk-mobile-theme',
    'icon' => 'ri-bar-chart-horizontal-line',
));
#Header search
CSF::createSection($prefix, array(
    'title' => esc_html__('عمومی', 'prk'),
    'id' => 'prk-mobile-general',
    'parent' => 'prk-mobile-theme', // The slug id of the parent section

    'fields' => array(
        array(
            'id' => 'prk_modern_mobile',
            'type' => 'switcher',
            'title' => esc_html__('فعال سازی نسخه اختصاصی موبایل', 'prk'),
            'subtitle' => 'دقت داشته باشید که قالب اختصاصی موبایل در سبک دیجی کالا نمایش داده نمیشود و ابزارک نوار چسبان پیشفرض موبایل نیز غیر فعال میشود.',
            'default' => false,
        ),

        array(
            'id' => 'modern_mobile_fixed_header',
            'type' => 'switcher',
            'title' => esc_html__('هدر چسبان موبایل', 'prk'),
            'dependency' => array('prk_modern_mobile', '==', 'true'),
            'default' => true,
        ),

        array(
            'id' => 'modern_mobile_icon',
            'type' => 'switcher',
            'title' => esc_html__('فعال سازی ایکن سمت چپ هدر', 'prk'),
            'dependency' => array('prk_modern_mobile', '==', 'true'),
            'default' => true,
        ),
        array(
            'id' => 'modern_mobile_icon_text',
            'type' => 'text',
            'title' => esc_html__('ایکن سمت چپ', 'your-textdomain-here'),
            'dependency' => array(
                array('prk_modern_mobile', '==', 'true'),
                array('modern_mobile_icon', '==', 'true'),
            ),
            'default' => 'prk-call-calling',
        ),
        array(
            'id' => 'modern_mobile_left_icon_url',
            'type' => 'text',
            'title' => esc_html__('لینک ایکن', 'your-textdomain-here'),
            'dependency' => array('prk_modern_mobile', '==', 'true'),
            'default' => 'tel:02191306517',
            'dependency' => array(
                array('prk_modern_mobile', '==', 'true'),
                array('modern_mobile_icon', '==', 'true'),
            ),
        ),
        array(
            'id' => 'modern_mobile_toolbar',
            'type' => 'switcher',
            'title' => esc_html__('نمایش منوی چسبان اول', 'prk'),
            'default' => true,
            'dependency' => array(
                array('prk_modern_mobile', '==', 'true'),
            ),
        ),
        array(
        'type'    => 'submessage',
        'style'   => 'success',
          'content' => 'کد کوتاه جهت اضافه کردن جستجو در موبایل: [prk_search_mobile]',
          'dependency' => array(
              array('prk_modern_mobile', '==', 'true'),
              array('modern_mobile_toolbar', '==', 'true'),
          ),
        ),
        array(
            'id' => 'prk_toolbar_menu',
            'type' => 'group',
            'title' => 'منوی چسبان اول',
            'max' => '5',
            'dependency' => array(
                array('prk_modern_mobile', '==', 'true'),
                array('modern_mobile_toolbar', '==', 'true'),
            ),
            'fields' => array(
                array(
                    'id' => 'text',
                    'type' => 'text',
                    'title' => esc_html__('عنوان', 'your-textdomain-here'),
                    'dependency' => array(
                        array('show_text', '==', 'true'),
                    ),
                ),
                array(
                    'id' => 'show_text',
                    'type' => 'switcher',
                    'title' => esc_html__('نمایش عنوان', 'prk'),
                    'default' => true,
                ),

                array(
                    'id' => 'icon',
                    'type' => 'text',
                    'title' => esc_html__('ایکن', 'your-textdomain-here'),
                ),
                array(
                    'id' => 'url',
                    'type' => 'text',
                    'title' => esc_html__('لینک', 'your-textdomain-here'),
                ),
                array(
                    'id' => 'color',
                    'type' => 'color',
                    'title' => esc_html__('رنگ ایکن', 'your-textdomain-here'),
                ),
            ),
            'default' => array(
                array(
                    'icon' => 'prk-home',
                    'text' => 'خانه',
                    'url' => home_url(),
                    'show_text' => true,
                ),
                array(
                  'icon' => 'prk-search-normal-1',
                  'text' => 'جستجو',
                  'url' => home_url().'/search',
                  'show_text' => true,
                ),
                array(
                  'icon' => 'prk-category1',
                  'text' => 'دسته بندیها',
                  'url' => home_url().'/shop',
                  'color' => '#08c96f',
                  'show_text' => true,
                ),
                array(
                  'icon' => 'prk-shopping-cart',
                  'text' => 'سبد خرید',
                  'url' => home_url().'/cart',
                  'show_text' => true,
                ),
                array(
                  'icon' => 'prk-user',
                  'text' => 'حساب کاربری',
                  'url' => home_url().'/my-account',
                  'show_text' => true,
                ),
            )
        ),

        array(
            'id' => 'modern_mobile_second_toolbar',
            'type' => 'switcher',
            'title' => esc_html__('نمایش منوی چسبان دوم', 'prk'),
            'default' => true,
            'dependency' => array(
              array('prk_modern_mobile', '==', 'true'),
              array('modern_mobile_toolbar', '==', 'true'),
          ),
        ),
        array(
            'id' => 'prk_toolbar_seconds_menu',
            'type' => 'group',
            'title' => 'منوی چسبان دوم',
            'max' => '6',
            // 'subtitle' => esc_html__('در حد', 'your-textdomain-here'),
            'dependency' => array(
                array('prk_modern_mobile', '==', 'true'),
                array('modern_mobile_toolbar', '==', 'true'),
                array('modern_mobile_second_toolbar', '==', 'true'),
            ),
            'fields' => array(
                array(
                    'id' => 'text',
                    'type' => 'text',
                    'title' => esc_html__('عنوان', 'your-textdomain-here'),
                    'dependency' => array(
                        array('show_text', '==', 'true'),
                    ),
                ),
                array(
                    'id' => 'show_text',
                    'type' => 'switcher',
                    'title' => esc_html__('نمایش عنوان', 'prk'),
                    'default' => true,
                ),
                array(
                    'id' => 'icon',
                    'type' => 'text',
                    'title' => esc_html__('ایکن', 'your-textdomain-here'),
                ),
                array(
                    'id' => 'url',
                    'type' => 'text',
                    'title' => esc_html__('لینک', 'your-textdomain-here'),
                ),
                array(
                    'id' => 'color',
                    'type' => 'color',
                    'title' => esc_html__('رنگ ایکن', 'your-textdomain-here'),
                ),
                array(
                    'id'          => 'type',
                    'type'        => 'select',
                    'title'       => 'مدل',
                    'options'     => array(
                      'iconed'  => 'ایکنی',
                      'paged'  => 'برگه ای',
                    ),
                    'default'     => 'iconed'
                ),
                array(
                    'id' => 'back',
                    'type' => 'color',
                    'title' => esc_html__('رنگ پس زمینه', 'your-textdomain-here'),
                    'default'     => '#f30a4926',
                    'dependency' => array(
                        array('type', '==', 'paged'),
                    ),
                ),
            ),
            'default' => array(
                array(
                    'icon' => 'prk-ticket-discount',
                    'text' => 'فروش ویژه',
                    'color' => '#f30a49',
                    'type' => 'paged',
                    'back' => '#f30a4926',
                    'show_text' => true,
                ),
                array(
                  'icon' => 'prk-shop',
                  'text' => 'فروشگاه',
                  'url' => home_url().'/shop',
                  'show_text' => true,
                ),
                array(
                  'icon' => 'prk-document',
                  'text' => 'مقاله',
                  'url' => home_url().'/blog',
                  'show_text' => true,
                ),
                array(
                  'icon' => 'prk-call',
                  'text' => 'تماس با ما',
                  'url' => 'tel:02191306517',
                  'show_text' => true,
                ),
            )
        ),

        array(
            'id' => 'modern_mobile_toolbar_blur',
            'type' => 'switcher',
            'title' => esc_html__('استایل بلوری منوی چسبان موبایل', 'prk'),
            'default' => false,
            'dependency' => array(
                array('prk_modern_mobile', '==', 'true'),
                array('modern_mobile_toolbar', '==', 'true'),
            ),
        ),
        array(
            'id' => 'prk_socials_box',
            'type' => 'switcher',
            'title' => esc_html__('نمایش باکس شبکه های اجتماعی', 'prk'),
            'default' => true,
            'dependency' => array(
              array('prk_modern_mobile', '==', 'true'),
          ),
        ),
        array(
            'id' => 'prk_socials_item',
            'type' => 'group',
            'title' => 'آیتم های شبکه اجتماعی',
            'max' => '5',
            'dependency' => array(
                array('prk_modern_mobile', '==', 'true'),
                array('prk_socials_box', '==', 'true'),
            ),
            'fields' => array(
                array(
                    'id' => 'text',
                    'type' => 'text',
                    'title' => esc_html__('عنوان', 'your-textdomain-here'),
                ),
                array(
                    'id' => 'icon',
                    'type' => 'text',
                    'title' => esc_html__('ایکن', 'your-textdomain-here'),
                ),
                array(
                    'id' => 'url',
                    'type' => 'text',
                    'title' => esc_html__('لینک', 'your-textdomain-here'),
                ),
                array(
                    'id' => 'color',
                    'type' => 'color',
                    'title' => esc_html__('رنگ ایکن', 'your-textdomain-here'),
                ),
            ),
            'default' => array(
                array(
                  'icon' => 'prk-eitaa',
                  'text' => 'ایتا',
                  'url' => '#',
                ),
                array(
                  'icon' => 'prk-bale',
                  'text' => 'بله',
                  'url' => '#',
                ),
                array(
                  'icon' => 'prk-soroush',
                  'url' => '#',
                  'text' => 'سروش',
                ),
                array(
                  'icon' => 'prk-aparat',
                  'text' => 'آپارات',
                  'url' => '#',
                ),
                array(
                  'icon' => 'prk-gap',
                  'url' => '#',
                  'text' => 'گپ',
                ),
            )
        ),
        array(
            'id' => 'mobile-header-backcolor',
            'type' => 'color',
            'default' => '#fff',
            'title' => esc_html__('رنگ پس زمینه هدر/منو', 'prk'),
            'transparent' => false,
            'output' => array('background-color' => 'body .mobile-header,.socials-box,.modal-menu,.mobile-bottom-navabr','border-color' =>'.mobile-bottom-navabr'),
            'dependency' => array(
                array('prk_modern_mobile', '==', 'true'),
                array('modern_mobile_toolbar', '==', 'true'),
            ),
        ),
        array(
            'id' => 'mobile-header-color-icons',
            'type' => 'color',
            'default' => '#162C5B',
            'title' => esc_html__('رنگ ایکن ها هدر/من', 'prk'),
            'transparent' => false,
            'output' => array('color' => 'body .modal-menu.modern-menu .off-canvas-main .menu li > a i,body header.modern .modal-menu .off-canvas-main .menu li > a,body .mobile-header .call-page i,.socials-box li i','fill' => '.mobile-header #icon-menu svg path'),
            'dependency' => array(
                array('prk_modern_mobile', '==', 'true'),
                array('modern_mobile_toolbar', '==', 'true'),
            ),
        ),
        array(
            'id' => 'mobile-header-color-texts',
            'type' => 'color',
            'default' => '#666666',
            'title' => esc_html__('رنگ عناوین هدر/من', 'prk'),
            'transparent' => false,
            'output' => array('color' => 'body .mobile-bottom-navitem span'),
            'dependency' => array(
                array('prk_modern_mobile', '==', 'true'),
                array('modern_mobile_toolbar', '==', 'true'),
            ),
        ),
        array(
            'id'    => 'mobile-header-typography-texts',
            'type'  => 'typography',
            'title' => 'سایز عناوین منوبار',
            'output_important' => 'true',
            'output'  => '.mobile-bottom-navitem i',
        ),

    )
));




#Header Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('هدر', 'prk'),
    'id' => 'header',
    'icon' => 'ri-layout-top-2-line',
));
#Header main
CSF::createSection($prefix, array(
    'title' => esc_html__('عمومی', 'prk'),
    'parent' => 'header', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'header_type',
            'type' => 'select',
            'title' => esc_html__('نوع هدر', 'prk'),
            'default' => 'default',
            'options' => array(
                'default' => esc_html__('پیشفرض قالب', 'prk'),
                'elementor' => esc_html__('المنتور', 'prk'),
                'disable' => esc_html__('غیرفعال', 'prk'),
            ),
            'select2' => array('allowClear' => false)
        ),


        array(
            'id' => 'fixed_header_mobit',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('هدر چسبان', 'prk'),
            'default' => false,
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('header_style_type', '==', 'mobit'),
            ),
        ),  

        array(
            'id' => 'choice_header',
            'type' => 'select',
            'title' => esc_html__('انتخاب هدر', 'prk'),
            'desc' => esc_html__('نوع هدر سایت را مشخص کنید', 'prk'),
            'dependency' => array('header_type', '==', 'elementor'),
            'ajax' => true,
            'options' => 'posts',
            'query_args' => array(
                'post_type' => 'header'
            )
        ),

        array(
            'id' => 'rgbaback_line_true',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش لاین ار جی بی ای', 'prk'),
            'default' => false,
            'dependency' => array('header_type', '==', 'default'),
        ),

        array(
            'id' => 'promote_true',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش صفحه مهم سایت', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش لینک صفحه مهم ', 'prk'),
            'default' => false,
            'dependency' => array('header_type', '==', 'default'),
        ),
        array(
            'id' => 'promote_link_type',
            'type' => 'select',
            'title' => esc_html__('مدل دکمه', 'prk'),
            'desc' => esc_html__('انتخاب نوع دکمه حساب کاربری', 'prk'),
            'default' => 'link',
            'options' => array(
                'link' => esc_html__('منو', 'prk'),
                'button' => esc_html__('دکمه ای', 'prk'),
            ),
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('promote_true', '==', 'true'),
            ),
        ),
        array(
            'id' => 'promote_page_icon',
            'type' => 'text',
            'title' => esc_html__('ایکن دکمه', 'prk'),
            'default' => 'prk-ticket-discount',
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('promote_true', '==', 'true'),
                array('promote_link_type', '==', 'button'),
            ),
        ),
        array(
            'id' => 'promote_page_icon_color',
            'type' => 'color',
            'title' => esc_html__('رنگ ایکن', 'prk'),
            'transparent' => false,
            'default' => '#f30a4952',
            'output' => array('color' => 'body .page-promotes.button_box i'),
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('promote_true', '==', 'true'),
                array('promote_link_type', '==', 'button'),
            ),
        ),
        array(
            'id' => 'promote_page_backcolor',
            'type' => 'color',
            'default' => '#f30a4926',
            'title' => esc_html__('رنگ پس زمینه دکمه', 'prk'),
            'transparent' => false,
            'output' => array('background-color' => 'body .page-promotes.button_box li'),
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('promote_true', '==', 'true'),
                array('promote_link_type', '==', 'button'),
            ),
        ),
        array(
            'id' => 'promote_page_title',
            'type' => 'text',
            'title' => esc_html__('عنوان صفحه', 'prk'),
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('promote_true', '==', 'true'),
            ),
        ),
        array(
            'id' => 'promote_page',
            'type' => 'text',
            'title' => esc_html__('لینک صفحه مهم', 'prk'),
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('promote_true', '==', 'true'),
            ),
        ),


        // array(
        //     'id' => 'promote_true2',
        //     'type' => 'switcher',
        //     'text_width' => 80,
        //     'title' => esc_html__('نمایش صفحه مهم سایت2', 'prk'),
        //     'subtitle' => esc_html__('فعال سازی و نمایش لینک صفحه مهم ', 'prk'),
        //     'default' => false,
        //     'dependency' => array('header_type', '==', 'default'),
        // ),
        // array(
        //     'id' => 'promote_link_type2',
        //     'type' => 'select',
        //     'title' => esc_html__('مدل دکمه2', 'prk'),
        //     'desc' => esc_html__('انتخاب نوع دکمه حساب کاربری', 'prk'),
        //     'default' => 'link',
        //     'options' => array(
        //         'link' => esc_html__('منو', 'prk'),
        //         'button' => esc_html__('دکمه ای', 'prk'),
        //     ),
        //     'dependency' => array(
        //         array('header_type', '==', 'default'),
        //         array('promote_true2', '==', 'true'),
        //     ),
        // ),
        // array(
        //     'id' => 'promote_page_icon2',
        //     'type' => 'text',
        //     'title' => esc_html__('ایکن دکمه2', 'prk'),
        //     'default' => 'prk-box-search',
        //     'dependency' => array(
        //         array('header_type', '==', 'default'),
        //         array('promote_true2', '==', 'true'),
        //         array('promote_link_type2', '==', 'button'),
        //     ),
        // ),
        // array(
        //     'id' => 'promote_page_icon_color2',
        //     'type' => 'color',
        //     'title' => esc_html__('رنگ ایکن2', 'prk'),
        //     'transparent' => false,
        //     'default' => '#094aef',
        //     'output' => array('color' => 'body .page-promotes.button_box .page-promotes-item2 i,.page-promotes.button_box li.page-promotes-item2 a'),
        //     'dependency' => array(
        //         array('header_type', '==', 'default'),
        //         array('promote_true2', '==', 'true'),
        //         array('promote_link_type2', '==', 'button'),
        //     ),
        // ),
        // array(
        //     'id' => 'promote_page_backcolor2',
        //     'type' => 'color',
        //     'default' => 'rgba(10,58,243,0.13)',
        //     'title' => esc_html__('رنگ پس زمینه دکمه2', 'prk'),
        //     'transparent' => false,
        //     'output' => array('background-color' => 'body .page-promotes.button_box li.page-promotes-item2'),
        //     'dependency' => array(
        //         array('header_type', '==', 'default'),
        //         array('promote_true2', '==', 'true'),
        //         array('promote_link_type2', '==', 'button'),
        //     ),
        // ),
        // array(
        //     'id' => 'promote_page_title2',
        //     'type' => 'text',
        //     'title' => esc_html__('عنوان صفحه2', 'prk'),
        //     'default' => 'پیگیری سفارش',
        //     'dependency' => array(
        //         array('header_type', '==', 'default'),
        //         array('promote_true2', '==', 'true'),
        //     ),
        // ),
        // array(
        //     'id' => 'promote_page2',
        //     'type' => 'text',
        //     'default' => home_url().'/my-account/ordertrak/',
        //     'title' => esc_html__('لینک صفحه مهم2', 'prk'),
        //     'dependency' => array(
        //         array('header_type', '==', 'default'),
        //         array('promote_true2', '==', 'true'),
        //     ),
        // ),



        array(
            'id' => 'get_location',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('فیلتر محصول بر اساس مکان کاربر', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش فیلتر محصول بر اساس مکان کاربر', 'prk'),
            'default' => true,
            'dependency' => array('header_type', '==', 'default'),
        ),
        array(
            'id' => 'call_true',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش ایکن تماس', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش ایکن تماس(دمو پارس مدرن)', 'prk'),
            'default' => true,
            'dependency' => array('header_type', '==', 'default'),
        ),
        array(
            'id' => 'call_page',
            'type' => 'text',
            'title' => esc_html__('برگه تماس', 'prk'),
            'subtitle' => esc_html__('انتخاب برگه تماس(دمو پارس کالا-مدرن-پلاس)', 'prk'),
            'default' => 'shop',
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('call_true', '==', 'true'),
            ),
        ),
        array(
            'id' => 'call_icon',
            'type' => 'text',
            'title' => esc_html__('ایکن دکمه تماس', 'prk'),
            'default' => 'flaticon-question-6',
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('call_true', '==', 'true'),
            ),
        ),
        array(
            'id' => 'header_sticky_menu',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('منوی چسبان', 'prk'),
            'desc' => esc_html__('فعال و غیر فعال کردن منوی سربرگ چسبان', 'prk'),
            'default' => true,
            'dependency' => array('header_type', '==', 'default'),
        ),
        array(
            'id' => 'logo',
            'type' => 'media',
            'operator' => 'and',
            'width' => '200px',
            'height' => '100px',
            'title' => esc_html__('تصویر لوگوی دسکتاپ', 'prk'),
            'dependency' => array('header_type', '==', 'default'),
        ),
        array(
            'id' => 'logo_animated',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('انیمیشن لوگو', 'prk'),
            'dependency' => array('header_type', '==', 'default'),
        ),  
        array(
            'id' => 'logo_mobile',
            'type' => 'media',
            'operator' => 'and',
            'width' => '200px',
            'height' => '100px',
            'title' => esc_html__('تصویر لوگوی موبایل', 'prk'),
            'desc' => 'درصورت خالی بودن این فیلد لوگوی دسکتاپ نمایش داده میشود',
            'dependency' => array('header_type', '==', 'default'),
        ),
        array(
            'id' => 'logo_menu',
            'type' => 'media',
            'title' => esc_html__('تصویر لوگو در منوی موبایل', 'prk'),
            'desc' => esc_html__('این تصویر در منو موبایل نمایش داده میشود در صورت خالی بودن این فیلد تصویر اصلی لوگو نمایش داده میشود', 'prk'),
            'dependency' => array('header_type', '==', 'default'),
        ),
        array(
            'id' => 'logo_size_s',
            'type' => 'dimensions',
            'units' => array('px',),
            'title' => esc_html__('اندازه لوگو', 'prk'),
            'desc' => esc_html__('درصورتی که قصد دارید سایز واندازه لوگو را تغییر دهید', 'prk'),
            'output' => array('header .logo img'),
            'output_important' => 'true',
            'dependency' => array('header_type', '==', 'default'),
        ),
        array(
            'id' => 'logo_size',
            'type' => 'dimensions',
            'units' => array('px',),
            'output_prefix' => 'max',
            'title' => esc_html__('حداثکر اندازه لوگو', 'prk'),
            'desc' => esc_html__('درصورتی که قصد دارید سایز واندازه لوگو را تغییر دهید', 'prk'),
            'output' => array('header .logo img'),
            'output_important' => 'true',
            'dependency' => array('header_type', '==', 'default'),
        ),
        array(
            'id' => 'logo_margin',
            'type' => 'spacing',
            'output' => array('.header.desctop .logo img'),
            'output_mode' => 'margin', // or margin, relative
            'output_important' => 'true',
            'units' => array('px'),
            'units_extended' => 'false',
            'title' => __('فاصله گذاری لوگو در دسکتاپ', 'redux-framework-demo'),
            'subtitle' => __('تعیین فاصله دلخواه جهت نمایش هرچه بهتر لوگو', 'redux-framework-demo'),
            'dependency' => array('header_type', '==', 'default'),
        ),
        array(
            'id' => 'logo_margin_mob',
            'type' => 'spacing',
            'output' => array('.header.mobile .logo img'),
            'output_mode' => 'margin', // or margin, relative
            'output_important' => 'true',
            'units' => array('px'),
            'units_extended' => 'false',
            'title' => __('فاصله گذاری لوگو در موبایل', 'redux-framework-demo'),
            'subtitle' => __('تعیین فاصله دلخواه جهت نمایش هرچه بهتر لوگو', 'redux-framework-demo'),
            'dependency' => array('header_type', '==', 'default'),
        ),
        array(
            'id' => 'prk_text_icon_menu',
            'type' => 'switcher',
            'title' => esc_html__('نمایش عنوان ایکن منو موبایل', 'prk'),
            'default' => true,
            'dependency' => array(
                array('header_type', '==', 'default'),
            ),
        ),
        array(
          'id'         => 'menu_mobile_model',
          'type'       => 'button_set',
          'title'      => 'مدل لود منوی موبایل',
          'dependency' => array(
              array('header_type', '==', 'default'),
          ),
          'options'    => array(
            'modern' => 'مدرن',
            'digikala'  => 'دیجیکالا',
          ),
          'default'    => 'modern'
        ),
        array(
            'id' => 'header_account',
            'type' => 'switcher',
            'title' => esc_html__('دکمه حساب کاربری', 'prk'),
            'desc' => esc_html__('نمایش / غیر فعال سازی دکمه حساب کاربری', 'prk'),
            'default' => true,
            'dependency' => array(
                array('header_type', '==', 'default'),
            ),
        ),
        array(
            'id'      => 'prk_account_bg_border',
            'type'    => 'slider',
            'title'   => 'حاشیه دور دکمه',
            'min'     => 0,
            'step'    => 1,
            'unit'    => 'px',
            'default' => 11,
            'output' => array('border-radius' => 'body .account'),
            'output_important' => 'true',
            'dependency' => array(
                array('header_type', '==', 'default'),
            ),
          ),
        array(
            'id' => 'prk_account_bg_backcolor',
            'type' => 'color',
            'title' => esc_html__('رنگ پس زمینه', 'prk'),
            'transparent' => false,
            'output' => array('background' => 'body .account'),
            'dependency' => array('header_search_true', '==', 'true'),
            'dependency' => array(
                array('header_type', '==', 'default'),
            ),
        ),
        array(
            'id' => 'header_icon_users_before',
            'type' => 'text',
            'title' => esc_html__('ایکن دکمه حساب کاربری قبل از ورود', 'prk'),
            'default' => 'flaticon-user-8',
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('header_account', '==', 'true'),
            ),
        ),
        array(
            'id' => 'header_icon_users_after',
            'type' => 'text',
            'title' => esc_html__('ایکن دکمه حساب کاربری بعد از ورود', 'prk'),
            'default' => 'flaticon-user-8',
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('header_account', '==', 'true'),
            ),
        ),
        array(
            'id' => 'header_account_type',
            'type' => 'select',
            'title' => esc_html__('نوع دکمه حساب کاربری', 'prk'),
            'desc' => esc_html__('انتخاب نوع دکمه حساب کاربری', 'prk'),
            'default' => 'dropdown',
            'options' => array(
                'dropdown' => esc_html__('منو بازشو', 'prk'),
                'link' => esc_html__('لینک', 'prk'),
            ),
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('header_account', '==', 'true'),
            ),
        ),
        array(
            'id' => 'header_account_text_before_login',
            'type' => 'text',
            'title' => esc_html__('متن دکمه حساب کاربری قبل از ورود', 'prk'),
            'default' => 'ورود/ثبت نام',
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('header_account', '==', 'true'),
            ),
        ),
        array(
            'id' => 'header_minicart',
            'type' => 'switcher',
            'title' => esc_html__('دکمه سبد خرید', 'prk'),
            'desc' => esc_html__('نمایش / غیر فعال سازی دکمه سبد خرید', 'prk'),
            'default' => true,
            'dependency' => array(
                array('header_type', '==', 'default'),
            ),
        ),
        // array(
        //     'id' => 'opnened_mini_cart',
        //     'type' => 'switcher',
        //     'text_width' => 80,
        //     'title' => esc_html__('باز شدن سبد خرید از کنار', 'prk'),
        //     'subtitle' => esc_html__('باز شدن سبد خرید از کنار بعد از افزوده شدن محصول به سبد خرید.', 'prk'),
        //     'default' => true,
        //     'dependency' => array(
        //         array('header_type', '==', 'default'),
        //         array('header_minicart', '==', 'true'),
        //     ),
        // ),
        array(
            'id' => 'header_btn_sticky',
            'type' => 'switcher',
            'title' => esc_html__('دکمه سبد خرید شناور', 'prk'),
            'desc' => esc_html__('نمایش / غیر فعال سازی دکمه سبد خرید شناور ', 'prk'),
            'default' => false,
            'dependency' => array(
                array('header_type', '==', 'default'),
            ),
        ),

        array(
            'id'         => 'headers_minicart_type',
            'type'       => 'button_set',
            'title'      => 'مدل ایکن سبدخرید',
            array('header_type', '==', 'default'),
            array('header_minicart', '==', 'true'),
            'options'    => array(
              'icon' => 'آیکن',
              'image'  => 'تصویر',
            ),
            'default'    => 'icon'
        ),

        array(
            'id' => 'headers_minicart_icon',
            'type' => 'text',
            'title' => esc_html__('ایکن دکمه سبد خرید', 'prk'),
            'default' => 'prk-shopping-cart',
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('header_minicart', '==', 'true'),
                array('headers_minicart_type', '==', 'icon'),
            ),
        ),

        array(
            'id' => 'headers_minicart_img',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر دکمه سبد خرید', 'prk'),
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('header_minicart', '==', 'true'),
                array('headers_minicart_type', '==', 'image'),
            ),
        ),

        array(
            'id' => 'header_minicart_type',
            'type' => 'select',
            'title' => esc_html__('نوع دکمه دکمه سبد خرید', 'prk'),
            'desc' => esc_html__('انتخاب نوع دکمه سبد خرید', 'prk'),
            'default' => 'dropdown',
            'options' => array(
                'dropdown' => esc_html__('منو بازشو (پاپ آپ)', 'prk'),
                'link' => esc_html__('لینک', 'prk'),
            ),
            'dependency' => array(
                array('header_type', '==', 'default'),
                array('header_minicart', '==', 'true'),
            ),
        ),


    ),
));

#Header search
CSF::createSection($prefix, array(
    'title' => esc_html__('جستجو', 'prk'),
    'id' => 'header_search',
    'parent' => 'header', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'header_search_true',
            'type' => 'switcher',
            'title' => esc_html__('نمایش و مخفی کردن جستجو', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'prk_style_search_viewed',
            'type' => 'select',
            'title' => esc_html__('سبک نمایش محصولات جستجو شده', 'prk'),
            'default' => 'carousel',
            'options' => array(
                'lists' => esc_html__('لیستی', 'prk'),
                'carousel' => esc_html__('کاروسل', 'prk'),
            ),
            'dependency' => array(
                array('header_search_true', '==', 'true'),
            ),
        ),
        array(
            'id'      => 'prk_search_bg_border',
            'type'    => 'slider',
            'title'   => 'حاشیه دور فرم جستجو',
            'min'     => 0,
            'step'    => 1,
            'unit'    => 'px',
            'default' => 11,
            'output' => array('border-radius' => '.search-section select#cat,.form_search #submit_search,.search-section'),
            'output_important' => 'true',
          ),
        array(
            'id' => 'prk_search_bg_backcolor',
            'type' => 'color',
            'title' => esc_html__('رنگ پس زمینه', 'prk'),
            'desc' => esc_html__('انتخاب رنگ پس زمینه جسجتو', 'prk'),
            'transparent' => false,
            'output' => array('background' => 'body .desktop  .search-section, .desktop .main_results_ajax_search'),
            'dependency' => array('header_search_true', '==', 'true'),
        ),
        array(
            'id' => 'prk_header_search_bg_color',
            'type' => 'color',
            'title' => esc_html__('رنگ متن جستجو', 'parskala'),
            'transparent' => false,
            'output' => array('color' => 'body .desktop .prk_input_serach::placeholder'),
            'dependency' => array('header_search_true', '==', 'true'),
        ),
        array(
            'id' => 'prk_header_search_result_color',
            'type' => 'color',
            'title' => esc_html__('رنگ متن محصولات جستجو شده ', 'parskala'),
            'transparent' => false,
            'output_important' => 'true',

            'output' => array('color' => 'body .desktop  .prk_input_serach::placeholder,.search-result-tags a,body .header-mobiter .promote_searchs span,.product_seached .product_s_title,.not_resulted',
            'border-color' => '.search-result-tags a'
            ),
            'dependency' => array('header_search_true', '==', 'true'),
        ),
        array(
            'id' => 'prk_header_search_bg_color_submit',
            'type' => 'color',
            'title' => esc_html__('رنگ دکمه جستجو', 'parskala'),
            'transparent' => false,
            'output' => array('background' => 'body .form_search.header_2.search_input.search-section button#submit_search'),
            'output_important' => 'true',
            'dependency' => array('header_search_true', '==', 'true'),
        ),
        array(
            'id' => 'search_placeholder',
            'type' => 'text',
            'title' => esc_html__('متن داخل جستجو', 'prk'),
            'default' => 'جستجو در هزاران محصول ...',
            'dependency' => array('header_search_true', '==', 'true'),
        ),
        array(
            'id' => 'better_seardched',
            'type' => 'group',
            'title' => 'جستجوهای پر طرفدار',
            'subtitle' => esc_html__('تعیین جستجوهای پرطرفدار', 'your-textdomain-here'),
            'dependency' => array('header_search_true', '==', 'true'),
            'fields' => array(
                array(
                    'id' => 'searched_title',
                    'type' => 'text',
                    'title' => esc_html__('عنوان', 'your-textdomain-here'),
                    'placeholder' => esc_html__('عنوان جستجو', 'your-textdomain-here'),
                ),
            ),
            'default' => array(
                array(
                    'searched_title' => 'گوشی و موبایل',
                ),
                array(
                    'searched_title' => 'آیفون',
                ),
                array(
                    'searched_title' => 'اپل واچ',
                )
            )
        ),

        array(
            'id' => 'img_banner_search',
            'type' => 'media',
            'title' => esc_html__('تصویر بنر', 'parskala'),
            'desc' => esc_html__('تصویر بنر کادر جستجو', 'prk'),
            'dependency' => array('header_search_true', '==', 'true'),
        ),
        array(
            'id' => 'url_banner_search',
            'type' => 'text',
            'title' => esc_html__('لینک بنر', 'prk'),
            'desc' => esc_html__('لینک بنر کادر جستجو', 'prk'),
            'dependency' => array('header_search_true', '==', 'true'),
            'default' => '#'
        ),
    )
));

#Header search
CSF::createSection($prefix, array(
    'title' => esc_html__('فیلتر شهر محصولات', 'prk'),
    'parent' => 'header', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'prk_filter_location',
            'type' => 'switcher',
            'title' => esc_html__('فعال سازی فیلتر', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'filter_location_btn_title',
            'type' => 'text',
            'title' => esc_html__('عنوان دکمه فیلتر', 'prk'),
            'dependency' => array('prk_filter_location', '==', 'true'),
            'default' => 'انتخاب مکان'
        ),
        array(
            'id' => 'filter_location_btn_subtitle',
            'type' => 'text',
            'title' => esc_html__('زیرعنوان دکمه فیلتر', 'prk'),
            'dependency' => array('prk_filter_location', '==', 'true'),
            'default' => 'فیلتر شهر'
        ),
        array(
            'id' => 'prk_filter_location_pop_title',
            'type' => 'text',
            'title' => esc_html__('عنوان پاپ آپ فیلتر', 'prk'),
            'dependency' => array('prk_filter_location', '==', 'true'),
            'default' => 'فیلتر بر اساس شهر محصول'
        ),
        array(
            'id' => 'prk_filter_location_search_title',
            'type' => 'text',
            'title' => esc_html__('متن جایگذار فیلتر جستجو', 'prk'),
            'dependency' => array('prk_filter_location', '==', 'true'),
            'default' => 'جستجو در شهرها'
        ),
        array(
            'id' => 'prk_filter_location_allcity',
            'type' => 'text',
            'title' => esc_html__('دکمه برگشت به فرم', 'prk'),
            'dependency' => array('prk_filter_location', '==', 'true'),
            'default' => 'همه شهرها'
        ),
        array(
            'id' => 'prk_filter_location_sallcity',
            'type' => 'text',
            'title' => esc_html__('دکمه انتخاب همه ', 'prk'),
            'dependency' => array('prk_filter_location', '==', 'true'),
            'default' => 'همه شهرهای'
        ),
        array(
            'id' => 'prk_filter_location_selectcity',
            'type' => 'text',
            'title' => esc_html__('متن اخطار انتخاب', 'prk'),
            'dependency' => array('prk_filter_location', '==', 'true'),
            'default' => 'حداقل یک شهر را انتخاب کنید'
        ),
    )
));

#Header mega menu
CSF::createSection($prefix, array(
    'title' => esc_html__('تنظیمات منو', 'prk'),
    'parent' => 'header', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'blacki_trure',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش حاله پشت زمینه', 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'prk_borline_menu',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش خط لاینی', 'prk'),
            'default' => true,
        ), 
        array(
            'id' => 'prk_hover_menu_item',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش هاور منو ایتم ها', 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'call_true1',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش ایکن تماس', 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'call_page1_title',
            'type' => 'text',
            'title' => esc_html__('عنوان شماره تماس', 'prk'),
            'default' => 'سوالی دارید؟ تماس بگیرید',
            'dependency' => array(
                array('call_true1', '==', 'true'),
            ),
        ),
        array(
            'id' => 'call_page1_pish',
            'type' => 'text',
            'title' => esc_html__('پیش شماره تماس', 'prk'),
            'default' => '021',
            'dependency' => array(
                array('call_true1', '==', 'true'),
            ),
        ),
        array(
            'id' => 'call_pagee1',
            'type' => 'text',
            'title' => esc_html__('شماره تماس', 'prk'),
            'default' => '-913087786',
            'dependency' => array(
                array('call_true1', '==', 'true'),
            ),
        ),
        array(
            'id' => 'call_icon1',
            'type' => 'text',
            'title' => esc_html__('ایکن دکمه تماس', 'prk'),
            'default' => 'prk-call-calling',
            'dependency' => array(
                array('call_true1', '==', 'true'),
            ),
        ),
        array(
            'id' => 'tab_side_sub_menu',
            'type' => 'dimensions',
            'title' => __('تنظیم عرض سایدبار تب منو', 'prk'),
            'min'     => 0,
            'max'     => 100,
            'height' => 'false',
            'step'    => 1,
            'default' => '15',
            'output' => array('.prk_mega_menu > li.mega_menu_tree_level.prk-side-tab > .prk-tab-menu-items > ul'),
            'output_mode' => 'width', // or margin, relative
            'output_important' => 'true',

        ), 
        array(
            'id' => 'tab_sub_menud',
            'type' => 'dimensions',
            'title' => __('تنظیم عرض تب منو', 'prk'),
            'min'     => 0,
            'max'     => 100,
            'height' => 'false',
            'step'    => 1,
            'default' => '85',
            'output' => array('.prk_mega_menu > li.mega_menu_tree_level.prk-side-tab > .prk-tab-menu-items > ul > li > ul'),
            'output_mode' => 'width', // or margin, relative
            'output_important' => 'true',

        ), 

    )
));


CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی پیامک پارس کالا', 'prk'),
    'id' => 'general_sms',
    'icon' => 'ri-mastodon-line',
    'fields' => array(

        // A Heading
        array(
          'type'    => 'heading',
          'content' => 'فرم ورود/عضویت',
        ),
       


        array(
            'id' => 'chose_form_login',
            'type' => 'select',
            'title' => esc_html__('انتخاب فرم ورود/ عضویت', 'prk'),
            'subtitle' => esc_html__('', 'prk'),
            'options' => array(
                'default_form' => esc_html__('فرم ورود/عضویت پیشفرض ووکامرس', 'prk'),
                'sms_form' => esc_html__('فرم ورود/عضویت پیامکی', 'prk'),
            ),
            'default' => 'default_form',
        ),


        array(
            'id' => 'prk_login_form_default_role',
            'type' => 'select',
            'title' => esc_html__('نقش پیش فرض عضویت کاربر', 'prk'),
            'subtitle' => esc_html__('', 'prk'),
            'options' => array(
                'customer' => esc_html__('مشتری', 'prk'),
                'subscriber' => esc_html__('مشترک', 'prk'),
            ),
            'default' => 'customer',
        ),

        array(
            'id' => 'pre_user_rej_name',
            'type' => 'text',
            'title' => esc_html__('نام پیشفرض کاربر ثبت نام کننده', 'prk'),
            'default' => esc_html__('کاربر گرامی', 'prk'),
            'dependency' => array(
                'chose_form_login', '==', 'sms_form'
            ),
        ),


       

        // A Heading
        array(
          'type'    => 'heading',
          'content' => 'اطلاعات سامانه پیامکی',
        ),
        array(
            'id' => 'chose_panel_sms',
            'type' => 'select',
            'title' => esc_html__('انتخاب سامانه', 'prk'),
            'subtitle' => esc_html__('', 'prk'),
            'options' => array(
                'melipayamak'  => esc_html__('ملی پیامک', 'prk'),
                'farazsms'     => esc_html__('ippanel (فرازSMS قدیمی ,..)', 'prk'),
                'iranpayamak'  => esc_html__('فراز SMS جدید / ایران پیامک', 'prk'),
                'kavenegar'    => esc_html__('کاوه نگار', 'prk'),
                'smsir'        => esc_html__('SMS.IR', 'prk'),
                'Mediana'      => esc_html__('مدیانا', 'prk'),
                'msgway'       => esc_html__('راه پیام', 'prk'),
            ),
            'default' => 'melipayamak',
            // 'dependency' => array(
            //       array('chose_form_login', '==', 'sms_form'),
            //       array('prk_notify_product', '==', 'true'),
            //   ),
        ),
        // // A Notice
        // array(
        //   'type'     => 'callback',
        //   'function' => 'prk_callback_helper_sms',
        //   'dependency' => array(
        //         array('chose_panel_sms', '==', 'farazsms'),
        //     ),
        // ),

        array(
            'id' => 'gateway_sms_username',
            'type' => 'text',
            'title' => esc_html__('نام کاربری', 'prk'),
            'subtitle' => esc_html__('نام کاربری سامانه پیامکی خود را وارد نمایید', 'prk'),
            'dependency' => array(
                // ['chose_form_login', '==', 'sms_form'],
                // ['prk_notify_product', '==', 'true'],
                ['chose_panel_sms', '!=', 'kavenegar'],
                ['chose_panel_sms', '!=', 'smsir'],
                ['chose_panel_sms', '!=', 'Mediana'],
                ['chose_panel_sms', '!=', 'iranpayamak'],
                ['chose_panel_sms', '!=', 'msgway']
            ),
        ),
        array(
            'id' => 'gateway_sms_password',
            'type' => 'text',
            'title' => esc_html__('رمز عبور', 'prk'),
            'subtitle' => esc_html__('رمز عبور سامانه پیامکی خود را وارد نمایید', 'prk'),
            'dependency' => array(
                // ['chose_form_login', '==', 'sms_form'],
                // ['prk_notify_product', '==', 'true'],
                ['chose_panel_sms', '!=', 'kavenegar'],
                ['chose_panel_sms', '!=', 'smsir'],
                ['chose_panel_sms', '!=', 'Mediana'],
                ['chose_panel_sms', '!=', 'iranpayamak'],
                ['chose_panel_sms', '!=', 'msgway']
            ),
        ),
        array(
            'type'       => 'notice',
            'style'      => 'info',
            'content'    => __('اگر سامانه پیامکی شما فراز SMS / ایپی‌پنل است، در صورت نداشتن خط خدماتی اختصاصی، می‌توانید خط خدماتی اشتراکی <strong>3000505</strong> را به عنوان خط ارسال کننده پیامک وارد کنید.', 'prk'),
            'dependency' => array('chose_panel_sms', '==', 'farazsms|iranpayamak'),
        ),

        array(
            'type'       => 'notice',
            'style'      => 'info',
            'content'    => __('اگر سامانه پیامکی شما ملی پیامک است و خط خدماتی اختصاصی ندارید، پیشنهاد می‌شود شماره ارسال کننده <strong>9999178495</strong> را وارد کنید.', 'prk'),
            'dependency' => array('chose_panel_sms', '==', 'melipayamak'),
        ),

        array(
            'id'    => 'gateway_sms_panel_number',
            'type'  => 'text',
            'title' => __('خط ارسال کننده پیامک', 'prk'),
        ),

        array(
            'id' => 'gateway_sms_panel_api_key',
            'type' => 'text',
            'title' => __('API کلید', 'prk'),
            'subtitle' => __('', 'prk'),
            'dependency' => array(
                // ['chose_form_login', '==', 'sms_form'],
                // ['prk_notify_product', '==', 'true'],
                // ['chose_panel_sms', '!=', 'melipayamak'],
                // ['chose_panel_sms', '!=', 'farazsms'],
            )
        ),

        array(
            'id' => 'prk_sms_info_admin',
            'type' => 'text',
            'title' => __('شماره موبایل مدیر کل سایت', 'prk'),
            'subtitle' => __('جهت اطلاع رسانی پیامکی مواردی که فقط به مدیران ارسال می شود', 'prk'),
        ),

        array(
            'id' => 'prk_sms_phonebook_id',
            'type' => 'text',
            'title' => __('کد دفترچه تلفن خبرنامه', 'prk'),
            'subtitle' => __('اگر سامانه پیامکی شما از سیستم دفترچه تلفن پشتیبانی می‌کند، کد دفترچه تلفنی که در پنل ساخته‌اید را اینجا وارد کنید. به‌عنوان مثال برای ذخیره‌سازی خودکار شماره موبایل‌های ثبت‌نامی در فرم خبرنامه پیامکی.', 'prk'),
        ),

        array(
            'id' => 'gateway_sms_count_number',
            'type' => 'slider',
            'title' => __('تعداد عدد کد', 'prk'),
            'subtitle' => __('این تعداد کدی هست که پیامک می شود.', 'prk'),
            'default' => 4,
            'min' => 1,
            'step' => 1,
            'max' => 10,
            'display_value' => 'text',
            'dependency' => array('chose_form_login', '==', 'sms_form'),
        ),
        array(
            'id' => 'gateway_sms_count_number_expire_time',
            'type' => 'slider',
            'title' => __('زمان انقضاء کد', 'prk'),
            'default' => 120,
            'min' => 1,
            'step' => 1,
            'max' => 1000,
            'display_value' => 'text',
            'dependency' => array('chose_form_login', '==', 'sms_form'),
        ),
        array(
            'id' => 'gateway_expire_Session',
            'type' => 'slider',
            'title' => __('سشن لاگین ماندن کاربر', 'prk'),
            'default' => 2,
            'min' => 1,
            'step' => 1,
            'max' => 30,
            'display_value' => 'text',
            'dependency' => array('chose_form_login', '==', 'sms_form'),
        ),        
        array(
            'id' => 'login_method',
            'type' => 'select',
            'title' => esc_html__('روش ورود', 'prk'),
            'subtitle' => esc_html__('انتخاب روش ورود و ثبت نام کاربر', 'prk'),
            'default' => 'mobile',
            'options' => array(
                'mobile' => esc_html__('شماره همراه', 'prk'),
                'email' => esc_html__('ایمیل', 'prk'),
                'both' => esc_html__('هردو', 'prk'),
            ),
            'dependency' => array('chose_form_login', '==', 'sms_form'),
        ),
        array('id' => 'email_otp_title',
        'type' => 'text',
        'title' => esc_html__('عنوان ایمیل تایید', 'prk'),
        'default' => 'ایمیل تایید',
        'dependency' => array('login_method', '!=', 'mobile'),
         ),
        array(
            'id' => 'email_otp_content',
            'type' => 'textarea',
            'title' => esc_html__('متن پیش فرض ایمیل اعتبارسنجی', 'prk'),
            'subtitle' => esc_html__('متن پیش فرض ایمیل اعتبارسنجی', 'prk'),
            'default' => __('کاربر عزیز ، کد تایید ایمیل شما {code} میباشد.', 'my_text_domain'),
            'desc'  =>__('متغییر کد تایید {code} ایمیل.', 'my_text_domain'),
            'dependency' => array('login_method', '!=', 'mobile'),
        ),
        array(
            'id' => 'login_process',
            'type' => 'select',
            'title' => esc_html__('فرایند ورود', 'prk'),
            'subtitle' => esc_html__('انتخاب فرایند ورود کابر', 'prk'),
            'default' => 'otp',
            'options' => array(
                'otp' => esc_html__('احراز هویت یکبارمصرف', 'prk'),
                'pass' => esc_html__('رمز عبور', 'prk'),
                'pass_without_email_otp' => esc_html__('رمز عبور (بدون احراز هویت اولیه ایمیل)', 'prk'),
                'both' => esc_html__('هردو', 'prk'),
            ),
            'dependency' => array('chose_form_login', '==', 'sms_form'),
        ),
        // Heading
        array(
        'type'    => 'heading',
        'content' => __('تنظیمات ورود/عضویت پیامکی (OTP)', 'prk'),
        ),

array(
  'type'    => 'content',
  'content' => '<div style="padding:10px 0 0 0;line-height:1;font-size:13px;color: #f93939;">
    برای فعال‌سازی ورود/عضویت با شماره موبایل، ابتدا باید الگوی پترن پیامک را در سامانه پیامکی خود تنظیم کنید.
  </div>',
),

        // لینک به پترن
        array(
        'type'    => 'notice',
        'class'   => 'pattern-notice',
        'style'   => 'info',
        'content' => '<a href="'.$PRKSMSApp_url.'#otpPattern" target="_blank" style="display:inline-block;padding:6px 12px;background:#2271b1;color:#fff;border-radius:4px;text-decoration:none;">تنظیم الگوی پترن پیامک ورود/عضویت</a>',
        ),

        // نمایش شورتکد
        array(
        'id'       => 'prk_auth_sms_shortcode',
        'type'     => 'content',
        'title'    => __('شورتکد ورود/عضویت پیامکی', 'prk'),
        'content'  => '<code style="background:#f1f1f1;padding:5px 10px;border-radius:4px;display:inline-block;">[prk_auth_sms]</code>',
        'subtitle' => __('از این شورتکد می‌توانید در برگه‌ها یا بخش‌های خاص سایت برای نمایش فرم ورود/عضویت پیامکی استفاده کنید.', 'prk'),
        ),


         // A Heading
        array(
          'type'    => 'heading',
          'content' => 'موجود شد اطلاع بده',
        ),

        array(
            'id' => 'prk_notify_product',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('سیستم اطلاع رسانی', 'prk'),
            'subtitle' => esc_html__('فعال سازی سیستم اختصاصی موجود شد اطلاع بده.'),
            'default' => false,
        ),
        array(
            'id' => 'gateway_sms_pattern_code_instock_product',
            'type' => 'text',
            'class' => 'hidden',
            'title' => esc_html__('کد پترن موجود شدن محصول', 'prk'),
            'dependency' => array(
                'prk_notify_product', '==', 'true'
            ),
        ),
        array(
            'id' => 'gateway_sms_pattern_code_amazing_product',
            'type' => 'text',
            'class' => 'hidden',
            'title' => esc_html__('کد پترن شگفت انگیز شدن محصول', 'prk'),
            'dependency' => array(
                'prk_notify_product', '==', 'true'
            ),
        ),


        array(
        'type'    => 'subheading',
        'content' => 'تنظیمات دیگر ',
        ),
        array(
            'id' => 'gateway_sms_pattern_code',
            'type' => 'text',
            'class' => 'hidden',
            'title' => esc_html__('کد پترن لاگین', 'prk'),
            'dependency' => array(
                'chose_form_login', '==', 'sms_form'
            ),
        ),

        array(
            'id' => 'prk_order_status_after_save_tracking_post',
            'type' => 'select',
            'title' => esc_html__('وضعیت سفارش بعد از ثبت کد رهگیری پستی', 'prk'),
            'subtitle' => esc_html__('', 'prk'),
            'options' => array(
                'completed' => esc_html__('تکمیل شده', 'prk'),
                'shipped' => esc_html__('ارسال شده', 'prk'),
            ),
            'default' => 'completed',
        ),

        // 
        array(
        'type'    => 'subheading',
        'content' => 'استایل فرم پاپ اپ ورود عضویت',
        ),

                array(
            'id' => 'form_login_style',
            'type' => 'image_select',
            'class' => 'form_login_style',
            'title' => esc_html__('استایل فرم ورود پیامکی', 'prk'),
            'default' => 'default',
            'options'   => array(
                'default'   => get_template_directory_uri().'/assets/img/options/form-login1.png',
                'style_2'   => get_template_directory_uri().'/assets/img/options/form-login2.png',
              ),
            'select2' => array('allowClear' => false),
            'dependency' => array('chose_form_login', '==', 'sms_form'),
        ),
        array(
            'id' => 'logo_sms_form_def',
            'type' => 'media',
            'operator' => 'and',
            'width' => '200px',
            'height' => '100px',
            'title' => esc_html__('تصویر لوگوی فرم پیامکی', 'prk'),
            'desc' => 'درصورت خالی بودن این فیلد لوگوی دسکتاپ نمایش داده میشود',
            'dependency' => array(
                array('chose_form_login', '==', 'sms_form'),
                array('form_login_style', '==', 'default'),
            ),
        ),
        array(
            'id' => 'logo_sms_form_style_2',
            'type' => 'media',
            'operator' => 'and',
            'width' => '200px',
            'height' => '100px',
            'title' => esc_html__('تصویر لوگوی فرم سبک دوم', 'prk'),
            'desc' => 'درصورت خالی بودن این فیلد لوگوی دسکتاپ نمایش داده میشود',
            'dependency' => array(
                array('chose_form_login', '==', 'sms_form'),
                array('form_login_style', '==', 'style_2'),
            ),
        ),
        array(
            'id'                              => 'gradient_sms_form_style_2_color',
            'type'                            => 'background',
            'title'                           => 'تنظیم پس زمینه فرم سبک دوم',
            'background_gradient'             => true,
            'background_origin'               => true,
            'background_image'               => true,
            'background_clip'                 => true,
            'background_blend_mode'           => true,
            'output_important' => 'true',
            'output' => array('background' => 'body .style_2.prk-sms-loginform .modal__container .rtl-sec-login'),
            'dependency' => array(
                array('chose_form_login', '==', 'sms_form'),
                array('form_login_style', '==', 'style_2'),
            ),
          ),
        array(
        'id'       => 'logo_sms_form',
        'type'     => 'number',
        'title'    => 'Border Radius',
        'subtitle' => 'میزان گردی گوشه‌های پاپ‌آپ ورود/عضویت را مشخص کنید',
        'desc'     => 'مقدار را بر حسب پیکسل وارد کنید.',
        'unit'     => 'px',
        'output'   => array(
            'border-radius' => 'body .prk-sms-loginform .modal__container',
        ),
        'output_important' => true,
        'default'  => 16,
        ),
    )
));




// ========== گارد امنیتی (OTP Firewall) ==========
// تب مادر گارد امنیتی (اگر از قبل ساختی فقط title را بروز کن)
CSF::createSection($prefix, array(
  'id'    => 'prk_otp_firewall',
  'icon'  => 'ri-shield-keyhole-line',
  'title' => 'گارد امنیتی (OTP) <span class="prk-badge-beta">نسخهٔ آزمایشی</span>',
  'fields'=> array(), // تب‌های فرزند پایین تعریف می‌شن
));

// استایل ساده برای بَج نسخه آزمایشی (یک‌بار در پنل ادمین)
add_action('admin_head', function () {
  echo '<style>
    .prk-badge-beta{
        display: inline-block;
        margin-right: 10px;
        padding: 0px 7px;
        border-radius: 999px;
        line-height: 26px;
        background: #996fe7;
        color: #fff;
        font-size: 9px;
        vertical-align: middle;
    }
  </style>';
});


// تب: تنظیمات IP/شماره/کوکی
CSF::createSection($prefix, array(
  'parent' => 'prk_otp_firewall',
  'title'  => 'تنظیمات امنیتی',
  'fields' => array(
    // — کلیات
    array(
      'type'     => 'heading',
      'content'  => 'تنظیمات کلی',
      'subtitle' => 'این بخش در حال حاضر «نسخهٔ آزمایشی» است.',
    ),
    array(
      'id'       => 'otp_fw_enable',
      'type'     => 'switcher',
      'title'    => 'فعال‌سازی گارد امنیتی',
      'subtitle' => 'با روشن‌بودن این گزینه، محدودیت‌ها و لیست‌های مسدودسازی اعمال می‌شوند.',
      'default'  => true,
    ),
    array(
      'id'            => 'otp_fw_log_retention_days',
      'type'          => 'slider',
      'title'         => 'مدت نگه‌داری لاگ‌ها (روز)',
      'subtitle'      => 'تعداد روزهایی که رخدادهای امنیتی نگه‌داری شوند.',
      'default'       => 30,
      'min'           => 1,
      'max'           => 180,
      'step'          => 1,
      'display_value' => 'text',
      'unit'          => 'روز',
    ),

    // — تنظیمات IP
    array(
      'type'    => 'heading',
      'content' => 'محدودیت‌ها بر اساس IP',
    ),
    array(
      'id'       => 'otp_fw_ip_daily_limit',
      'type'     => 'number',
      'title'    => 'حداکثر درخواست روزانه برای هر IP',
      'subtitle' => 'هر IP در بازهٔ ۲۴ ساعته حداکثر چند بار می‌تواند کد ورود دریافت کند؟',
      'default'  => 100,
      'unit'     => 'بار',
    ),
    array(
      'id'       => 'otp_fw_ip_burst_limit',
      'type'     => 'number',
      'title'    => 'حداکثر درخواست‌های پیاپی (Burst)',
      'subtitle' => 'اگر تعداد درخواست‌های پشت‌سرهم در بازهٔ زیر از این مقدار بیشتر شود، IP موقتاً مسدود می‌شود.',
      'default'  => 4,
      'unit'     => 'بار',
    ),
    array(
      'id'       => 'otp_fw_ip_burst_window_minutes',
      'type'     => 'number',
      'title'    => 'طول بازهٔ Burst (به دقیقه)',
      'default'  => 1,
      'unit'     => 'دقیقه',
    ),
    array(
      'id'       => 'otp_fw_ip_temp_block_minutes',
      'type'     => 'number',
      'title'    => 'مدت مسدودسازی موقت IP (دقیقه)',
      'default'  => 120,
      'unit'     => 'دقیقه',
    ),
    array(
      'id'       => 'otp_fw_ip_perm_threshold',
      'type'     => 'number',
      'title'    => 'آستانهٔ مسدودسازی دائمی IP',
      'subtitle' => 'مثلاً اگر تعداد تخلفات/بلاک‌های موقت به این عدد برسد، IP به‌صورت دائمی مسدود شود.',
      'default'  => 10,
      'unit'     => 'بار',
    ),
    array(
      'id'         => 'otp_fw_ip_whitelist',
      'type'       => 'textarea',
      'title'      => 'لیست سفید IP',
      'subtitle'   => 'هر خط یک IP یا بازه به صورت CIDR (مثال: 192.168.1.0/24).',
      'attributes' => array('rows' => 3, 'dir' => 'ltr'),
    ),
    array(
      'id'         => 'otp_fw_ip_blacklist',
      'type'       => 'textarea',
      'title'      => 'لیست سیاه IP (مسدود دائمی)',
      'subtitle'   => 'هر خط یک IP یا CIDR. این موارد همیشه مسدود هستند.',
      'attributes' => array('rows' => 3, 'dir' => 'ltr'),
    ),

    // — تنظیمات شماره موبایل
    array(
      'type'    => 'heading',
      'content' => 'محدودیت‌ها بر اساس شماره موبایل',
    ),
    array(
      'id'       => 'otp_fw_msisdn_request_daily_limit',
      'type'     => 'number',
      'title'    => 'حداکثر درخواست روزانه برای هر شماره',
      'default'  => 10,
      'unit'     => 'بار',
    ),
    array(
      'id'       => 'otp_fw_msisdn_attempt_limit',
      'type'     => 'number',
      'title'    => 'حداکثر دفعات وارد کردن کد تأیید',
      'subtitle' => 'اگر چندبار پشت‌سرهم کد اشتباه وارد شود، شماره موقتاً مسدود می‌شود.',
      'default'  => 6,
      'unit'     => 'بار',
    ),
    array(
      'id'       => 'otp_fw_msisdn_temp_block_minutes',
      'type'     => 'number',
      'title'    => 'مدت مسدودسازی موقت شماره (دقیقه)',
      'default'  => 60,
      'unit'     => 'دقیقه',
    ),
    array(
      'id'       => 'otp_fw_msisdn_perm_threshold',
      'type'     => 'number',
      'title'    => 'آستانهٔ مسدودسازی دائمی شماره',
      'subtitle' => 'مثلاً پس از ۳ بار مسدودسازی موقت، دائمی شود.',
      'default'  => 3,
      'unit'     => 'بار',
    ),
    array(
      'id'         => 'otp_fw_msisdn_whitelist',
      'type'       => 'textarea',
      'title'      => 'لیست سفید شماره‌ها',
      'subtitle'   => 'هر خط یک شماره. ورودی 09/98/+98 هم پذیرفته می‌شود (نرمال‌سازی انجام می‌گردد).',
      'attributes' => array('rows' => 3, 'dir' => 'ltr'),
    ),
    array(
      'id'         => 'otp_fw_msisdn_blacklist',
      'type'       => 'textarea',
      'title'      => 'لیست سیاه شماره‌ها (مسدود دائمی)',
      'subtitle'   => 'هر خط یک شماره. این شماره‌ها همیشه مسدود خواهند بود.',
      'attributes' => array('rows' => 3, 'dir' => 'ltr'),
    ),

    // — اثرانگشت/کوکی
    array(
      'type'    => 'heading',
      'content' => 'اثر انگشت (Cookie/Fingerprint)',
    ),
    array(
      'id'       => 'otp_fw_cookie_fingerprint',
      'type'     => 'switcher',
      'title'    => 'فعال‌سازی محدودیت بر اساس کوکی/اثر انگشت',
      'subtitle' => 'برای ربات‌هایی که IP عوض می‌کنند مفید است.',
      'default'  => true,
    ),
    array(
      'id'         => 'otp_fw_cookie_daily_limit',
      'type'       => 'number',
      'title'      => 'حداکثر درخواست روزانه برای هر دستگاه',
      'default'    => 20,
      'unit'       => 'بار',
      'dependency' => array('otp_fw_cookie_fingerprint', '==', 'true'),
    ),
    array(
      'id'         => 'otp_fw_cookie_ttl_days',
      'type'       => 'number',
      'title'      => 'مدت نگه‌داری کوکی (روز)',
      'default'    => 7,
      'unit'       => 'روز',
      'dependency' => array('otp_fw_cookie_fingerprint', '==', 'true'),
    ),
  ),
));

CSF::createSection($prefix, array(
  'parent' => 'prk_otp_firewall',
  'title'  => 'بلاک لیست شماره‌ها',
  'fields' => array(
    array(
      'id'                   => 'otp_fw_blocklist_msisdn_items',
      'type'                 => 'group',
      'title'                => 'آیتم‌های مسدودسازی شماره موبایل',
      'accordion_title_by'   => array('msisdn','label'),
      'buttons'              => array('add' => 'افزودن شماره', 'remove' => 'حذف', 'clone' => 'تکثیر'),
      'fields'               => array(
        array(
          'id'        => 'msisdn',
          'type'      => 'text',
          'title'     => 'شماره موبایل',
          'subtitle'  => 'فرمت پیشنهادی: 9xxxxxxxxx (ورودی با 09/98/+98 هم پذیرفته می‌شود).',
          'attributes'=> array('dir'=>'ltr','placeholder'=>'9xxxxxxxxx'),
          'sanitize'  => 'prk_sanitize_msisdn',
        ),
        array('id'=>'label','type'=>'text','title'=>'برچسب/یادداشت'),
        array('id'=>'is_temp','type'=>'switcher','title'=>'مسدود موقت؟','default'=>false),
        array(
          'id'=>'temp_minutes','type'=>'number','title'=>'مدت مسدود موقت (دقیقه)',
          'default'=>60,'unit'=>'دقیقه','dependency'=>array('is_temp','==','true')
        ),
        array('id'=>'is_perm','type'=>'switcher','title'=>'مسدود دائمی؟','default'=>false),
        array('id'=>'hits','type'=>'number','title'=>'تعداد تکرار/برخورد','default'=>0,'min'=>0),
        array('id'=>'created_by','type'=>'text','title'=>'ثبت توسط'),
        array('id'=>'created_at','type'=>'text','title'=>'تاریخ ثبت'),
      ),
    ),
  ),
));

CSF::createSection($prefix, array(
  'parent' => 'prk_otp_firewall',
  'title'  => 'بلاک لیست IPها',
  'fields' => array(
    array(
      'id'                 => 'otp_fw_blocklist_ip_items',
      'type'               => 'group',
      'title'              => 'آیتم‌های مسدودسازی IP',
      'accordion_title_by' => array('ip','label'),
      'buttons'            => array('add'=>'افزودن IP','remove'=>'حذف','clone'=>'تکثیر'),
      'fields'             => array(
        array(
          'id'        => 'ip',
          'type'      => 'text',
          'title'     => 'IP / CIDR',
          'subtitle'  => 'مثال: 37.18.25.115 یا 192.168.1.0/24',
          'attributes'=> array('dir'=>'ltr','placeholder'=>'x.x.x.x یا x.x.x.x/nn'),
          'sanitize'  => 'prk_sanitize_ip_or_cidr',
        ),
        array(
          'id'=>'label','type'=>'text','title'=>'برچسب/یادداشت',
          'attributes'=>array('placeholder'=>'مثلاً «بات‌نت»، «کاربر خاطی» و ...'),
        ),
        array('id'=>'is_temp','type'=>'switcher','title'=>'مسدود موقت؟','default'=>false),
        array(
          'id'=>'temp_minutes','type'=>'number','title'=>'مدت مسدود موقت (دقیقه)',
          'default'=>120,'unit'=>'دقیقه','dependency'=>array('is_temp','==','true')
        ),
        array('id'=>'is_perm','type'=>'switcher','title'=>'مسدود دائمی؟','default'=>false),
        array('id'=>'hits','type'=>'number','title'=>'تعداد تکرار/برخورد','subtitle'=>'فقط جهت نمایش/مدیریت دستی','default'=>0,'min'=>0),
        array('id'=>'created_by','type'=>'text','title'=>'ثبت توسط','attributes'=>array('placeholder'=>'نام ادمین یا سیستم')),
        array('id'=>'created_at','type'=>'text','title'=>'تاریخ ثبت','attributes'=>array('placeholder'=>'yyyy-mm-dd hh:mm')),
      ),
    ),
  ),
));




#story settings
CSF::createSection($prefix, array(
    'title'      => esc_html__('پیکربندی استوری پارس کالا', 'parskala'),
    'id'         => 'story_settings',
  	'menu_slug'  =>'story_settings_s',
  	'menu_type'  => 'menu',
    'icon'       => 'ri-instagram-line',
));


CSF::createSection(
	$prefix,
	array(
		'parent' => 'story_settings', // The slug id of the parent section
		'title'  => esc_html__( 'عمومی', 'parskala' ),
		'icon'   => 'fas fa-cogs',
		'fields' => array(

      array(
        'id'    => 'prk_story_Activation',
        'type'  => 'switcher',
        'title' => esc_html__( 'فعال سازی استوری ساز', 'parskala' ),
        'default' => 'true',
      ),

			array(
				'id'      => 'render',
				'type'    => 'select',
				'title'   => esc_html__( 'نوع رندر', 'parskala' ),
				'options' => array(
					'client' => esc_html__( 'سمت سرور', 'parskala' ),
					'server' => esc_html__( 'سمت کاربر', 'parskala' ),
				),
				'default' => 'client',
        'dependency' => array('prk_story_Activation', '==', 'true'),
			),
			array(
				'id'      => 'style',
				'type'    => 'select',
				'title'   => esc_html__( 'سبک نمایش استوری', 'parskala' ),
				'options' => array(
					'instagram' => esc_html__( 'سبک اینستاگرام', 'parskala' ),
					'facebook'  => esc_html__( 'سبک فیسبوک', 'parskala' ),
				),
				'default' => 'snapgram',
        'dependency' => array('prk_story_Activation', '==', 'true'),
			),

			array(
				'id'    => 'full_screen',
				'type'  => 'switcher',
				'title' => esc_html__( 'تمام عرض', 'parskala' ),
				'desc'  => esc_html__( 'نمایش تمام عرض استوری در دستگاه موبایل', 'parskala' ),
        'dependency' => array('prk_story_Activation', '==', 'true'),
			),
			array(
				'id'    => 'video_silent',
				'type'  => 'switcher',
				'title' => esc_html__( 'شروع ویدیو بصورت بی صدا', 'parskala' ),
        'dependency' => array('prk_story_Activation', '==', 'true'),
			),
		),
	)
);

#story settings
require_once get_template_directory().'/inc/parskala-story/admin/options.php';


#factor settings
CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی فاکتور پارس کالا', 'prk'),
    'id' => 'factor_settings',
    'icon' => 'ri-printer-line',
));

#compare-product Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('مشخصات کلی', 'prk'),
    'parent' => 'factor_settings', // The slug id of the parent section
    'fields' => array(
      array(
          'id' => 'factor_pars',
          'type' => 'switcher',
          'text_width' => 80,
          'title' => esc_html__('فعال سازی فاکتور ساز ', 'prk'),
          'default' => true,
      ),
        array(
            'id' => 'f_name',
            'type' => 'text',
            'title' => esc_html__('نام فروشگاه', 'prk'),
            'subtitle' => esc_html__('درج نام فروشگاه در برگه فاکتور'),
            'default' => get_bloginfo('name'),
            'dependency' => array('factor_pars', '==', 'true'),
        ),
        array(
            'id' => 'fsub_name',
            'type' => 'text',
            'title' => esc_html__('لیبل سفارشی قبل از نام فروشگاه', 'prk'),
            'subtitle' => esc_html__('بطور مثال فروش نیابتی'),
            'default' => '',
            'dependency' => array('factor_pars', '==', 'true'),
        ),
        array(
            'id' => 'f_logo',
            'type' => 'media',
            'title' => esc_html__('لوگو فروشگاه', 'prk'),
            'subtitle' => esc_html__('درصورت خالی بودن این فیلد ، لوگو عمومی فروشگاه نمایش داه میشود'),
            'dependency' => array('factor_pars', '==', 'true'),
        ),
        array(
            'id' => 'f_states',
            'type' => 'text',
            'title' => esc_html__('استان', 'prk'),
            'subtitle' => esc_html__('استان فروشگاه'),
            'dependency' => array('factor_pars', '==', 'true'),
        ),
        array(
            'id' => 'f_citys',
            'type' => 'text',
            'title' => esc_html__('شهر', 'prk'),
            'subtitle' => esc_html__('شهر فروشگاه'),
            'dependency' => array('factor_pars', '==', 'true'),
        ),
        array(
            'id' => 'f_address',
            'type' => 'textarea',
            'title' => esc_html__('آدرس', 'prk'),
            'subtitle' => esc_html__('آدرس فروشگاه خود را وارد نمایید'),
            'dependency' => array('factor_pars', '==', 'true'),
        ),
        array(
            'id' => 'f_zipcode',
            'type' => 'text',
            'title' => esc_html__('کد پستی', 'prk'),
            'subtitle' => esc_html__('کدپستی فروشگاه'),
            'dependency' => array('factor_pars', '==', 'true'),
        ),
        array(
            'id' => 'f_company_email',
            'type' => 'text',
            'title' => esc_html__('ایمیل فروشگاه', 'prk'),
            'subtitle' => esc_html__('ایمیل فروشگاه'),
            'dependency' => array('factor_pars', '==', 'true'),
        ),
        array(
            'id' => 'f_company_number',
            'type' => 'text',
            'title' => esc_html__('شماره تلفن', 'prk'),
            'subtitle' => esc_html__('شماره تلفن فروشگاه'),
            'dependency' => array('factor_pars', '==', 'true'),
        ),
        array(
            'id' => 'f_company_code',
            'type' => 'text',
            'title' => esc_html__('کد اقتصادی', 'prk'),
            'subtitle' => esc_html__('کد اقتصادی فروشگاه'),
            'dependency' => array('factor_pars', '==', 'true'),
        ),
        array(
            'id' => 'f_codesabt',
            'type' => 'text',
            'title' => esc_html__('شماره ثبت', 'prk'),
            'subtitle' => esc_html__('شماره ثبت فروشگاه'),
            'dependency' => array('factor_pars', '==', 'true'),
        ),
    )
));

# bill Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('تنظیمات فاکتور', 'prk'),
    'parent' => 'factor_settings', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'f_size',
            'type' => 'select',
            'title' => esc_html__('سایز صفحه فاکتور', 'prk'),
            'subtitle' => esc_html__('تعیین سایز صفحه فاکتور'),
            'default' => 'A4',
            'options' => array(
                'A4' => esc_html__('A4', 'prk'),
                'A5' => esc_html__('A5', 'prk'),
            ),
        ),
        array(
            'id' => 'f_show_logo',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش لوگو', 'prk'),
            'subtitle' => esc_html__('نمایش لوگو فروشگاه'),
            'default' => true,
        ),
        array(
            'id' => 'prk_billing_ncode_factor',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش کد ملی مشتری', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'prk_billing_customer_note',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش یاداشت مشتری', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'prk_ncode_factor_meta',
            'type' => 'text',
            'title' => esc_html__('متای کد ملی', 'prk'),
            'default' => esc_html__('billing_ncode'),
        ),

        array(
            'id' => 'prk_address_factor_meta',
            'type' => 'text',
            'title' => esc_html__('متای نشانی (آدرس خریدار) ', 'prk'),
            'default' => esc_html__('billing_address_1'),
        ),
        array(
            'id' => 'f_preview',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('پیشنمایش', 'prk'),
            'subtitle' => esc_html__('پیشنمایش فاکتور قبل از چاپ'),
            'default' => true,
        ),
        array(
            'id' => 'f_thankyou_link',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('دکمه دریافت فاکتور', 'prk'),
            'subtitle' => esc_html__('نمایش دکمه دریافت فاکتور در صفحه تشکر'),
            'default' => true,
        ),
        array(
            'id' => 'f_imgproduct',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('تصویر', 'prk'),
            'subtitle' => esc_html__('نمایش تصویر شاخص محصول'),
            'default' => true,
        ),
        array(
            'id' => 'f_getfactor',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('صدور فاکتور', 'prk'),
            'subtitle' => esc_html__('نمایش صدور فاکتور در برگه تصویه حساب'),
            'default' => true,
        ),
        array(
            'id' => 'f_barcode',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('بارکد', 'prk'),
            'subtitle' => esc_html__('نمایش بارکد فاکتور'),
            'default' => true,
        ),
        array(
            'id' => 'f_title',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('عنوان فاکتور', 'prk'),
            'subtitle' => esc_html__('نمایش عنوان فاکتور'),
            'default' => true,
        ),
        array(
            'id' => 'f_costom_title',
            'type' => 'text',
            'title' => esc_html__('عنوان جایگزین فاکتور', 'prk'),
            'subtitle' => esc_html__('درصورت غیر فعال بودن عنوان فاکتور این عنوان نمایش داده میشود !'),
            'dependency' => array('f_title', '==', false),
        ),
        array(
            'id' => 'f_Letters',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('جمع کل به حروف', 'prk'),
            'subtitle' => esc_html__('نمایش جمع کل به حروف'),
        ),
        array(
            'id' => 'f_discount_percent',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش درصد تخفیف', 'prk'),
        ),
    )
));


#compare-product Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('تنظیمات برچسب', 'prk'),
    'parent' => 'factor_settings', // The slug id of the parent section
    'fields' => array(

        array(
            'id' => 'label_logo',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش لوگو', 'prk'),
            'subtitle' => esc_html__('نمایش لوگو در برچسب'),
            'default' => true,
        ),
        array(
            'id' => 'label_address',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش آدرس', 'prk'),
            'subtitle' => esc_html__('نمایش آدرس فروشگاه در برچسب'),
            'default' => true,
        ),
        array(
            'id' => 'label_website',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش آدرس وبسایت', 'prk'),
            'subtitle' => esc_html__('نمایش آدرس وبسایت فروشگاه در برچسب'),
            'default' => true,
        ),
        array(
            'id' => 'prk_address_label_meta',
            'type' => 'text',
            'title' => esc_html__('متای نشانی (آدرس خریدار) ', 'prk'),
            'default' => esc_html__('billing_address_1'),
        ),
        array(
            'id' => 'label_Pmethod',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش روش پرداخت', 'prk'),
            'subtitle' => esc_html__('نمایش روش پرداخت در برچسب'),
            'default' => true,
        ),
        array(
            'id' => 'label_send_order',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش هزینه حمل و نقل', 'prk'),
            'subtitle' => esc_html__('نمایش هزینه حمل و نقل در برچسب'),
            'default' => true,
        ),
        array(
            'id' => 'label_order_number',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش شماره سفارش', 'prk'),
            'subtitle' => esc_html__('نمایش شماره سفارش در برچسب'),
            'default' => true,
        ),
        array(
            'id' => 'label_date_print',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش تاریخ چاپ', 'prk'),
            'subtitle' => esc_html__('نمایش تاریخ چاپ برچسب'),
            'default' => false,
        ),
        array(
            'id' => 'prk_billing_customer_note_label',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش یاداشت مشتری', 'prk'),
            'default' => true,
        ),
    )
));

#factor footer
CSF::createSection($prefix, array(
    'title' => esc_html__('پا نوشت فاکتور', 'prk'),
    'parent' => 'factor_settings', // The slug id of the parent section
    'fields' => array(

        array(
            'id' => 'f_note_footer',
            'type' => 'wp_editor',
            'title' => esc_html__('متن پانوشت سفارشی', 'prk'),
            'default' => esc_html__('یاداشت سفارش: این سفارش جهت تست فاکتور قالب پارس کالا ثبت شده است و به راحتی در تنظیمات قالب قابل تغییر است.'),
        ),
        array(
            'id' => 'f_show_sign',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('مهر و امضای فاکتور', 'prk'),
            'subtitle' => esc_html__('نمایش مهر و امضای فاکتور'),
        ),
        array(
            'id' => 'f_seller_stamp',
            'type' => 'media',
            'title' => esc_html__('تصویر مهر فروشگاه', 'prk'),
            'dependency' => array('f_show_sign', '==', 'true'),
        ),
        array(
            'id' => 'f_seller_sgn',
            'type' => 'text',
            'title' => esc_html__('عنوان مهر و امضای فروشنده', 'prk'),
            'default' => esc_html__('مهر و امضای فروشگاه'),
            'dependency' => array('f_show_sign', '==', 'true'),
        ),
        array(
            'id' => 'f_order_sgn',
            'type' => 'text',
            'title' => esc_html__('عنوان مهر و امضای خریدار', 'prk'),
            'default' => esc_html__('مهر و امضای خریدار'),
            'dependency' => array('f_show_sign', '==', 'true'),
        ),
    )
));


# bill Settings
// چک کردن افزونه دکان
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
$active_dokan = is_plugin_active('dokan-lite/dokan.php');

if ($active_dokan) {
    CSF::createSection($prefix, array(
        'title' => esc_html__('همگام سازی دکان', 'prk'),
        'parent' => 'factor_settings', // The slug id of the parent section
        'fields' => array(
            array(
                'id' => 'dokan_info',
                'type' => 'switcher',
                'text_width' => 80,
                'title' => esc_html__('نمایش اطلاعات دکان', 'prk'),
                'subtitle' => esc_html__('نمایش اطلاعات فروشنده دکان در فاکتور'),
            ),
        )
    ));

}


$home = get_bloginfo('url');
#sliders Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی صفحه محصول', 'prk'),
    'id' => 'single_product',
    'icon' => 'ri-profile-line',
));


#single-product Settings
CSF::createSection($prefix, array(

    'title' => esc_html__('عمومی', 'prk'),
    'parent' => 'single_product', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'style_product_page',
            'type' => 'select',
            'title' => esc_html__('سبک صفحه محصول', 'prk'),
            'default' => 'default',
            'options' => array(
                'default' => esc_html__('پیشفرض', 'prk'),
                'mobit' => esc_html__('سبک 2', 'prk'),
                // 'style_3' => esc_html__('سبک 3', 'prk'),
            ),
        ),


        array(
            'id' => 'show_sticky_add',
            'type' => 'switcher',
            'text_width' => 80,
            'default' => false,
            'title' => esc_html__('نمایش نوار چسبان خرید محصول ', 'prk'),
            'subtitle' => esc_html__('نمایش نوار چسبان خرید محصول در پایین صفحه محصول', 'prk'),
        ),

        array(
            'id' => 'show_breadcrumb_product',
            'type' => 'switcher',
            'text_width' => 80,
            'default' => true,
            'title' => esc_html__('نمایش راهنمای کوتاه محصول', 'prk'),
        ), 
        array(
            'id' => 'show_variation_stock',
            'type' => 'switcher',
            'text_width' => 80,
            'default' => true,
            'title' => esc_html__('نمایش تعداد موجودی انبار محصول متغیر', 'prk'),
        ),    
        array(
            'id' => 'show_sticky_add_blur',
            'type' => 'switcher',
            'text_width' => 80,
            'default' => false,
            'title' => esc_html__('استایل بلوری ', 'prk'),
            'dependency' => array('show_sticky_add', '==', 'true'),
        ),
        array(
            'id'      => 'show_sticky_add_width',
            'type'    => 'slider',
            'title'   => 'عرض نوار چسبان',
            'min'     => 85,
            'step'    => 1,
            'unit'    => '%',
            'default' => 100,
            'output' => array('width' => '.prk-sticky-add-cart'),
            'output_important' => 'true',
            'dependency' => array(
                array('show_sticky_add', '==', 'true'),
            ),
          ),


        array(
            'id' => 'prk_increase_max_variation_wc',
            'type' => 'number',
            'title' => esc_html__('حداکثر تعداد متغیرها', 'prk'),
            'default' => 50,
        ),

      array(
          'id' => 'prk_show_prod_up_date',
          'type' => 'switcher',
          'text_width' => 80,
          'default' => false,
          'title' => esc_html__('نمایش تاریخ به روزرسانی محصول', 'prk'),
          'subtitle' => esc_html__('نمایش تاریخ به روزرسانی محصول در صفحه محصول', 'prk'),
      ),

        array(
            'id'       => 'prk_tab_content_styles',
            'type'     => 'select',
            'title'    => esc_html__('سبک نمایشی تب اطلاعات محصول در موبایل', 'prk'),
            'options'  => array(
                'mobile_tab' => esc_html__( 'پاپ اپ مدرن', 'prk' ),
                'default' => esc_html__( 'پیشفرض', 'prk' ),
            ),
            'default'  => 'mobile_tab',
        ),

      array(
          'id' => 'show_wolfnotify',
          'type' => 'text',
          'type' => 'switcher',
          'text_width' => 80,
          'default' => true,
          'title' => esc_html__('فعال سازی مرا آگاه کن', 'prk'),
          'subtitle' => esc_html__('فعال سازی از موجود شدن محصول', 'prk'),
      ),

      array(
        'id' => 'show_wolfnotify_title_op',
        'type' => 'subheading',
        'title' => esc_html__('تنظیمات ایمیل مرا اگاه کن', 'prk'),
        'dependency' => array('show_wolfnotify', '==', 'true'),
        ),
        array(
            'id' => 'show_wolfnotify_title_email',
            'type' => 'text',
            'title' => esc_html__('عنوان ایمیل ارسال کننده برای کاربر', 'prk'),
            'default' => __('محصول مورد نظر شما موجود شد.', 'my_text_domain'),
            'dependency' => array('show_wolfnotify', '==', 'true'),
        ),
        array(
            'id' => 'show_wolfnotify_content_email',
            'type' => 'textarea',
            'title' => esc_html__('متن پیش فرض ایمیل اطلاع رسانی از موجود شدن محصول', 'prk'),
            'default' => __('کاربر عزیز محصول {productname} موجود شد.', 'my_text_domain'),
            'desc'  =>__('متغیر عنوان محصول {productname} میباشد.', 'my_text_domain'),
            'dependency' => array('show_wolfnotify', '==', 'true'),
        ),
        array(
            'id' => 'single_product_text_price',
            'type' => 'text',
            'title' => esc_html__('برچسب قیمت خالی', 'prk'),
            'subtitle' => esc_html__('متن نمایشی در صورت عدم درج قیمت محصول', 'prk'),
            'default' => 'تماس بگیرید',
        ),
        array(
            'id' => 'prk_zoom_image',
            'type' => 'text',
            'type' => 'switcher',
            'text_width' => 80,
            'default' => true,
            'title' => esc_html__('زوم تصاویر', 'prk'),
            'subtitle' => esc_html__('فعال  سازی زوم تصویر شاص محصول', 'prk'),
        ),
        array(
            'id' => 'feed_product',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش بازخورد کالا', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش بازخورد کالا', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'better_product',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش گزارش قیمت محصول', 'prk'),
            'subtitle' => esc_html__('فعال سازی و گزارش قیمت محصول', 'prk'),
            'default' => true,
        ),

        array(
            'id' => 'ajax_add',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('افزودن به سبد خرید ایجکسی', 'prk'),
            'subtitle' => esc_html__('محصول به صورت آجاکس به سبد خرید اضافه خواهد شد (بدون بارگذاری مجدد صفحه)', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'ajax_added_cart_text',
            'type' => 'text',
            'title' => esc_html__('متن پاپ آپ بعد افزودن به سبد خرید', 'prk'),
            'default' => 'محصول مورد نظر به سبد خرید اضافه شد',
            'dependency' => array('ajax_add', '==', 'true'),
        ),
        array(
          'id'       => 'ajax_added_cart_model',
          'type'     => 'select',
          'title'    => esc_html__('مدل پاپ آپ افزودن به سبد خرید', 'prk'),
          'options'  => array(
            'modern' => esc_html__( 'مدرن', 'prk' ),
            'default' => esc_html__( 'پیشفرض', 'prk' ),
          ),
          'default'  => 'modern',
        ),
        array(
            'id' => 'ajax_cart_confirm_text',
            'type' => 'text',
            'title' => esc_html__('متن دکمه هدایت به سبدخرید', 'prk'),
            'default' => 'سبدخرید',
            'dependency' => array(
              array('ajax_added_cart_model', '==', 'modern'),
              array('ajax_add', '==', 'true'),
            ),
        ),
        array(
            'id' => 'ajax_cart_cancel_text',
            'type' => 'text',
            'title' => esc_html__('متن دکمه بستن پاپ آپ', 'prk'),
            'default' => 'ادامه خرید',
            'dependency' => array(
              array('ajax_added_cart_model', '==', 'modern'),
              array('ajax_add', '==', 'true'),
            ),
        ),


        array(
            'id' => 'single_product_seller',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش تب فروشنده', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش تب فروشنده', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_product_seller_preloader',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش پیش بارگذاری', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش پیش بارگذاری صفحه فروشنده', 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'single_product_Warranty',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش تب گارانتی', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش تب گارانتی محصول', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_texts_Warrantyss',
            'type' => 'text',
            'title' => esc_html__('متن پیشفرض گارانتی محصول', 'prk'),
            'subtitle' => esc_html__('متن نمایشی گارانتی محصول', 'prk'),
            'default' => 'گارانتی 18 ماهه ' . get_bloginfo('name'),
            'dependency' => array('single_product_Warranty', '==', 'true'),
        ),
        array(
            'id' => 'single_product_stock',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش تب موجود در انبار', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش تب موجود در انبار', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_product_bail',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش تب ضمانت اصالت کالا', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش تب ضمانت اصالت کالا محصول', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_product_bail_text',
            'type' => 'text',
            'title' => esc_html__('متن پیشفرض ضمانت اصالت کالا', 'prk'),
            'subtitle' => esc_html__('متن ضمانت اصالت کالا محصول', 'prk'),
            'default' => 'ضمانت اصالت کالا',
            'dependency' => array('single_product_bail', '==', 'true'),
        ),
        array(
            'id' => 'quantity_product',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش باکس اضافه کردن تعداد محصول به سبد خرید', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_hamta_show',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش هشدار سامانه همتا', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_hamta_text',
            'type' => 'textarea',
            'title' => esc_html__('متن پیشفرض هشدار سامانه همتا', 'prk'),
            'subtitle' => esc_html__('متن پیشفرض هشدار سامانه همتا', 'prk'),
            'default' => __('هشدار سامانه همتا: حتما در زمان تحویل دستگاه، به کمک کد فعال‌سازی چاپ شده روی جعبه یا کارت گارانتی، دستگاه را از طریق #7777*، برای سیم‌کارت خود فعال‌سازی کنید. آموزش تصویری در آدرس اینترنتی hmti.ir/05', 'my_text_domain'),
            'dependency' => array('single_product_bail', '==', 'true'),
        ),
        array(
            'id' => 'single_product_send',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش تب ارسال ', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش تب ارسال محصول', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_product_send_title',
            'type' => 'text',
            'title' => esc_html__('متن توضیح ارسال', 'prk'),
            'default' => 'ارسال توسط ' . get_bloginfo('name'),
            'dependency' => array('single_product_send', '==', 'true'),
        ),
        array(
            'id' => 'single_product_send_text',
            'type' => 'wp_editor',
            'title' => esc_html__('متن توضیح ارسال', 'prk'),
            'default' => ' این کالا پس از مدت زمان مشخص شده توسط فروشنده در انبار ' . get_bloginfo('name') . ' تامین و آماده پردازش می‌گردد و توسط پیک  در بازه انتخابی ارسال خواهد شد. ',
            'dependency' => array('single_product_send', '==', 'true'),
        ),
        array(
            'id' => 'posts_per_page_related_product',
            'type' => 'slider',
            'title' => esc_html__('تعداد نمایش محصولات مرتبط', 'prk'),
            'desc' => esc_html__('تعداد حداکثر نمایش محصولات مرتبط', 'prk'),
            "default" => 10,
            "min" => 1,
            "step" => 1,
            "max" => 100,
        ),
        array(
            'id' => 'out_stock_related_product',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش محصولات (موجود در انبار) در سکشن محصولات مرتبط', 'prk'),
            'subtitle' => esc_html__('با فعال کردن این گزینه تنها محصولاتی که (موجودی انبار) دارند در سکشن محصولات مرتبط نمایش داده میشوند.', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'small_title_show_product',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش عنوان توضیحات کوتاه', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'prk_tag_product_viewed1',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش تگ محصول', 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'sub_title_show_product',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش نام محصول در تب های صفحه محصول', 'prk'),
            'default' => true,
        ),
        array(
            'type'    => 'heading',
            'content' => 'تب های اطلاعات محصول',
        ),
        
        array(
            'id'          => 'information_product_title',
            'type'        => 'text',
            'title' => esc_html__('عنوان تب مشحخصات', 'prk'),
            'default' => 'مشخصات',
          ),
        array(
    			'id'       => 'display_advanced_review',
    			'type'     => 'select',
    			'title'    => esc_html__('نظرات پیشرفته', 'prk'),
    			'subtitle' => esc_html__( '', 'prk' ),
    			'options'  => array(
    				'on' => esc_html__( 'روشن', 'prk' ),
    				'off' => esc_html__( 'خاموش', 'prk' ),
    			),
    			'default'  => 'on',
    		),

        array(
            'id' => 'global_options_ratings_review',
            'type' => 'group',
            'title' => 'آپشن های امتیازدهی نقد و بررسی.',
            'dependency' => array('display_advanced_review', '==', 'on'),
            'fields' => array(
                array(
                  'id'          => 'title',
                  'type'        => 'text',
                  'title' => esc_html__('تیتر امتیازدهی', 'prk'),
                  'placeholder' => esc_html__('تیتر آپشن امتیاز دهی در نقد و بررسی را وارد نمائید.', 'prk'),
                ),
                array(
                  'id'          => 'slug',
                  'type'        => 'text',
                  'title' => esc_html__('نامک انگلیسی', 'prk'),
                  'subtitle' => esc_html__('یک نامک انگلیسی و غیر تکراری وارد نمائید. تا حد امکان بعد از استفاده کاربران از این آپشن امتیاز دهی از تغییر این نامک جدا خودداری نمائید. برای درج کارکترها فقط از حروف انگلیسی و کارکتر _ استفاده کنید مثال: price_rate', 'prk'),
                ),
            ),
            'default' => array(
                array(
                    'title' => 'کیفیت ساخت',
                    'slug' => 'Quality_rate',
                ),
                array(
                    'title' => 'ارزش خرید به نسبت قیمت',
                    'slug' => 'price_rate',
                ),
                array(
                    'title' => 'امکانات و قابلیت ها',
                    'slug' => 'Property_rate',
                ),
                array(
                    'title' => 'سهولت استفاده',
                    'slug' => 'ease_rate',
                ),
            ),
        ),
        array(
            'id' => 'comment_recommend',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('پیشنهاد محصول', 'prk'),
            'subtitle' => esc_html__('نمایش فرم پیشنهاد محصول', 'prk'),
            'default' => false,
            'dependency' => array('display_advanced_review', '==', 'on'),
        ),
        array(
            'id' => 'comment_text',
            'type' => 'wp_editor',
            'title' => esc_html__('متن شرایط دیدگاه', 'prk'),
            'default' => 'لطفا پیش از ارسال نظر، خلاصه قوانین زیر را مطالعه کنید: فارسی بنویسید و از کیبورد فارسی استفاده کنید. بهتر است از فضای خالی (Space) بیش‌از‌حدِ معمول، شکلک یا ایموجی استفاده نکنید و از کشیدن حروف یا کلمات با صفحه‌کلید بپرهیزید. نظرات خود را براساس تجربه و استفاده‌ی عملی و با دقت به نکات فنی ارسال کنید؛ بدون تعصب به محصول خاص، مزایا و معایب را بازگو کنید و بهتر است از ارسال نظرات چندکلمه‌‌ای خودداری کنید. بهتر است در نظرات خود از تمرکز روی عناصر متغیر مثل قیمت، پرهیز کنید. به کاربران و سایر اشخاص احترام بگذارید. پیام‌هایی که شامل محتوای توهین‌آمیز و کلمات نامناسب باشند، حذف می‌شوند. از ارسال لینک‌های سایت‌های دیگر و ارایه‌ی اطلاعات شخصی خودتان مثل شماره تماس، ایمیل و آی‌دی شبکه‌های اجتماعی پرهیز کنید. با توجه به ساختار بخش نظرات، از پرسیدن سوال یا درخواست راهنمایی در این بخش خودداری کرده و سوالات خود را در بخش «پرسش و پاسخ» مطرح کنید. هرگونه نقد و نظر در خصوص سایت فروشگاه ما، خدمات و درخواست کالا را با ایمیل info@yourdomain.com یا با شماره‌ی ۰۰۰۰ - ۰۲۱ در میان بگذارید و از نوشتن آن‌ها در بخش نظرات خودداری کنید.',
            'dependency' => array('display_advanced_review', '==', 'on'),
        ),
        array(
            'id' => 'single_product_faq',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('پرسش و پاسخ محصول', 'prk'),
            'subtitle' => esc_html__('فعال سازی تب پرسش و پاسخ محصول', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_product_attributes',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش ویژگی ', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش ویژگی کوتاه محصول', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'product_attributes_title',
            'type' => 'text',
            'text_width' => 80,
            'title' => esc_html__('عنوان ویژگی های کوتاه محصول', 'prk'),
            'default' => 'ویژگی های محصول',
        ),
        array(
            'id' => 'product_attributes_count',
            'type' => 'slider',
            'title' => esc_html__('تعداد ویژگی های کوتاه', 'prk'),
            'desc' => esc_html__('حداکثر تعداد نمایش ویژگی های کوتاه محصول', 'prk'),
            "default" => 6,
            "min" => 1,
            "step" => 1,
            "max" => 50,
        ),

        array(
            'id' => 'cattributes_product_tabs',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش ویژگی های کوتاه سفارشی در تب مشخصات محصول', 'prk'),
            'desc' => esc_html__('نمایش و جایگزین کردن ویژگی های کوتاه سفارشی بجای ویژگی های محصول ، دقت کنید که با فعال سازی این بخش تنها ویژگی های کوتاهسفارشی نمایش داده میشود !', 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'title_cattributes_product_tabs',
            'type' => 'text',
            'text_width' => 80,
            'title' => esc_html__('متن تب ویژگی های سفارشی', 'prk'),
            'default' => 'مشخصات',
            'dependency' => array('cattributes_product_tabs', '==', 'true'),
        ),
        array(
            'id' => 'title_cattributes_product_content',
            'type' => 'text',
            'text_width' => 80,
            'title' => esc_html__('عنوان بالای ویژگی سفارشی ', 'prk'),
            'default' => 'مشخصات کالا',
            'dependency' => array('cattributes_product_tabs', '==', 'true'),
        ),

        array(
            'id' => 'show_related',
            'type' => 'select',
            'title' => esc_html__('مکان نمایش محصولات مرتبط', 'prk'),
            'subtitle' => esc_html__('مکان نمایش سکشن محصولات مرتبط را تایین کنید', 'prk'),
            'default' => '9',
            'options' => array(
                '9' => esc_html__('قبل توضیحات', 'prk'),
                '20' => esc_html__('بعد توضیحات', 'prk'),
            )
        ),
        array(
            'id' => 'single_product_orginal',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش برچسب غیر اصل', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش برچسب غیر اصل محصول', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_product_orginal',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش پیشفرض محصول غیر اصل', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش پیشفرض محصول غیر اصل', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_product_sku',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش شناسه', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش شناسه محصول', 'prk'),
            'default' => true,
        ),

        array(
            'id' => 'product_brand',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('فعال سازی برند', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش برند محصول', 'prk'),
            'default' => true,
        ),

        array(
            'id' => 'single_product_brand',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش برند', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش برند محصول', 'prk'),
            'default' => true,
            'dependency' => array('product_brand', '==', 'true'),
        ),
        array(
            'id' => 'show_brand_product',
            'type' => 'switcher',
            'text_width' => 80,
            'default' => true,
            'title' => esc_html__('نمایش لوگوی برند صفحه محصول', 'prk'),
        ),
        array(
            'id' => 'product_brand_slug',
            'type' => 'text',
            'text_width' => 80,
            'title' => esc_html__('نامک برند', 'prk'),
            'subtitle' => esc_html__('دقت بفرمایید که با تغییر نامک برند ، برندهای ساخته شده از قبل حذف خواهند شد.', 'prk'),
            'default' => 'brand',
            'dependency' => array('product_brand', '==', 'true'),

        ),
        array(
            'id' => 'product_brand_name',
            'type' => 'text',
            'text_width' => 80,
            'title' => esc_html__('عنوان لیبل برند', 'prk'),
            'subtitle' => esc_html__('لیبل سفارشی برند', 'prk'),
            'default' => 'برند',
            'dependency' => array('product_brand', '==', 'true'),

        ),

        array(
            'id' => 'single_product_sendes',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش بخش آماده ارسال', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش بخش آماده ارسال محصول', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'product_sendes_img',
            'type' => 'media',
            'operator' => 'and',
            'width' => '200px',
            'height' => '100px',
            'title' => esc_html__('تصویر سرویس', 'prk'),
            'dependency' => array('single_product_sendes', '==', 'true'),
        ),
        array(
            'id' => 'single_product_services',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش سرویس ها', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش سرویس های محصول', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_product_top_bio',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش توضیحات کوتاه محصول در سکشن بالا', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش توصیحات کوتاه محصول', 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'single_product_bio',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش توضیحات کوتاه محصول', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش توصیحات کوتاه محصول', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_product_bio_img',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر توضیحات کوتاه محصول', 'prk'),
            'dependency' => array('single_product_bio', '==', 'true'),
        ),
        array(
            'id' => 'single_product_whislist',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش دکمه افزودن به علاقمندی ها', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش دکمه افزودن به لیست علاقمندی ها', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_product_share',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش دکمه اشتراک گذاری محصول', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش دکمه اشتراک گذای محصول', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_product_vidoe',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش دکمه ویدیو', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش دکمه ویدیو محصول', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_product_compare_btn',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش دکمه مقایسه', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش دکمه مقایسه محصول', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_product_prk_chartp',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش دکمه نمودار قیمت', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش دکمه نمودار قیمت', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'single_product_ask',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش دکمه سوالی دارید', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش دکمه سوالی دارید', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'special_send_box_true',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش شرایط ارسال کالا', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش سکشن شرایط ارسال کالا', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'general_send_box_text',
            'type' => 'text',
            'title' => 'عنوان شرایط ارسال',
            'default' => 'شرایط ارسال کالا',
            'dependency' => array('special_send_box_true', '==', 'true'),
        ),
        array(
            'id' => 'general_send_box_url',
            'type' => 'text',
            'title' => 'لینک شرایط ارسال',
            'default' => '#',
            'dependency' => array('special_send_box_true', '==', 'true'),
        ),
        array(
            'id' => 'special_send_box_product',
            'type' => 'group',
            'title' => 'تنظیم شرایط ارسال کالا',
            'dependency' => array('special_send_box_true', '==', 'true'),
            'fields' => array(
                array(
                    'id' => 'send_box_text',
                    'type' => 'text',
                    'title' => 'عنوان شرایط ارسال',
                ),
                array(
                    'id' => 'send_box_url',
                    'type' => 'text',
                    'title' => 'لینک شرایط ارسال',
                    'default' => '#',
                ),
            ),
            'default' => array(
                array(
                    'send_box_text' => 'ارسال از انبار تهران: 1 الی 2 روز کاری',
                    'send_box_url' => '#',
                ),
                array(
                    'send_box_text' => 'ارسال از انبار اصفهان: تحویل فوری',
                    'send_box_url' => '#',
                ),
            ),
        ),
        array(
            'id'      => 'send_box_border',
            'type'    => 'border',
            'title'   => 'تنظیم حاشیه باکس ارسال',
            'default' => array(
              'top'    => '1',
              'right'  => '1',
              'bottom' => '1',
              'left'   => '1',
              'style'  => 'solid',
              'color'  => '#e8e8e8',
              'unit'          => 'px',
            ),
            'output' => '.special_send_box',
          ),
          array(
            'id'      => 'send_box_icon',
            'type'    => 'media',
            'title'   => 'Media',
            'preview' => false,
          ),


    )
));

#my account Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی اطلاعات فروشگاه', 'prk'),
    'id' => 'prk_seller_shop_options',
    'parent' => 'single_product', // The slug id of the parent section
    'icon' => 'ri-user-line',
    'fields' => array(
    array(
        'id' => 'shop_name',
        'type' => 'text',
        'type' => 'text',
        'text_width' => 80,
        'title' => esc_html__('نام فروشگاه', 'prk'),
        'subtitle' => esc_html__('درصورت خالی بودن این قسمت عنوان پیشفرض فروشگاه نمایش داده میشود.', 'prk'),
    ),
      array(
          'id' => 'is_featured_shop',
          'type' => 'switcher',
          'title' => 'فعال سازی تیک فروشگاه برتر',
          'subtitle' => 'درصورتی این تنظیمات اعمال میشوند که افزونه دکان فعال نباشد درغیر این صورت از بخش کاربری هر فروشنده امکان فعال کردن فروشنده برتر وجود دارد.',
          'text_width' => 80,
          'default' => false,
      ),
      array(
        'id'      => 'dokan_consent',
        'type'    => 'number',
        'title'   => 'رضایت کالا',
        'default' => 96,
      ),
      array(
        'id'      => 'dokan_supply',
        'type'    => 'number',
        'title'   => 'تامین به موقع ',
        'default' => 89,
      ),     
      array(
        'id'      => 'dokan_Commitment',
        'type'    => 'number',
        'title'   => 'تعهد ارسال',
        'default' => 91,
      ),
      array(
        'id'      => 'dokan_reference',
        'type'    => 'number',
        'title'   => 'بدون مرجوعی ',
        'default' => 87,
      ),
      array(
        'id'      => 'shop_registered',
        'type'    => 'text',
        'title'   => 'شروع فروشگاه از',
        'default' => '1 سال',
      ),

      array(
        'id'          => 'stills_types',
        'type'        => 'select',
        'title'       => 'عملکرد کلی فروشگاه',
        'placeholder' => 'Select an option',
        'options'     => array(
            'great'       => __( 'عالی', 'parskala' ),
            'very_good' => __( 'خیلی خوب', 'parskala' ),
            'good' => __( 'خوب', 'parskala' ),
            'medium' => __( 'متوسط', 'parskala' ),
            'baad' => __( 'ضعیف', 'parskala' ),
        ),
        'default'     => 'great'
      ),

    )
));

#my account Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('استایل دهی', 'prk'),
    'id' => 'prk_styles_options',
    'parent' => 'single_product', // The slug id of the parent section
    'icon' => 'ri-user-line',
    'fields' => array(

        array(
            'id'          => 'border_radius_info_box',
            'type'        => 'number',
            'title'       => 'انحنای مرز  کارت اطلاعات محصول',
            'unit'        => 'px',
            'default'     => 11,
        ),
        array(
            'id' => 'max_continer_img_single_pro',
            'type' => 'dimensions',
            'units' => array( 'px'),
            'title' => esc_html__('حداکثر اندازه تصویر محصول', 'prk'),
            'subtitle' => esc_html__('اندازه این عرض فقط در صفحات داخلی غیر از صفحه اصلی اعمال میشود !', 'prk'),
            'height' => 'false',
            'output_important' => 'true',
            'output' => array('body.product-single.single-product .woocommerce div.product .imgs-desctop img.attachment-shop_single'),
        ),

        array(
            'id'    => 'prk_background_single_pro',
            'type'  => 'background',
            'title' => 'پس زمینه صفحه محصول',
            'output_important' => 'true',
            'output' => array('body.product-single'),
        ),

        array(
            'id' => 'gradient_info_box_product',
            'type' => 'background',
            'title' => 'رنگ پس زمینه کارت اطلاعات محصول',
            'background_gradient' => true,
            'background_origin' => true,
            'background_image' => false,
            'background_clip' => true,
            'background_blend_mode' => true,
            // 'output_important' => 'true',
            // 'output' => array( 'background-color' => '.col-single1 .des-left .ui-box,.col-single1 .des-left .tippy-content'),
        ),
        array(
            'id' => 'border_info_box_product',
            'type' => 'color',
            'title' => esc_html__('رنگ خطوط اطلاعات کارت محصول', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            // 'output_important' => 'true',
            // 'output' => array('background-color' => '.product-seller-info .product-seller-row::after','color' => '.parskala-update-price,.col-single1 .des-left .tippy-content,.product-seller-info .product-seller-row::after')
        ),
        array(
            'id' => 'color_info_box_product',
            'type' => 'color',
            'title' => esc_html__('رنگ عناوین اطلاعات کارت محصول', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            'output_important' => 'true',
            // 'output' => 
            //     array(
            //       'color' => '.woocommerce .des-left div.quantity a.plus,.woocommerce .des-left div.quantity a.minus,.woocommerce .des-left div.quantity input.qty,.stills_contienr .shop_names .name,.operation_stillses,.cart-pro bdi,.col-single1 .des-left .share-square::before,.col-single1 .des-left .ui-box,col-single1 .des-left .seller-feedback .seller-feedback-item,body .product-seller-info .product-seller-row .product-seller-row-icon i',
            //     ),
        ),
        array(
            'id' => 'back_add_cart_btn_product',
            'type' => 'background',
            'title' => 'رنگ پس زمینه دکمه افزودن به سبد خرید',
            'background_gradient' => true,
            'background_origin' => true,
            'background_image' => false,
            'background_clip' => true,
            'background_blend_mode' => true,
        ),
        array(
            'id' => 'color_add_cart_btn_product',
            'type' => 'color',
            'title' => esc_html__('رنگ عنوان دکمه افزودن به سبدخرید', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            // 'output_important' => 'true',
            // 'output' => 
            //     array(
            //       'color' => '.single_add_to_cart_button.button',
            //     ),
        ),
        array(
            'id' => 'shadow_add_cart_btn_product',
            'type' => 'color',
            'title' => esc_html__('سایه دکمه افزودن به سبدخرید', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            // 'output_important' => 'true',
            // 'output' => 
            //     array(
            //       'color' => '.single_add_to_cart_button.button',
            //     ),
        ),
    )
));


#my account Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی کاربری', 'prk'),
    'id' => 'prk_myaccount_options',
    'icon' => 'ri-user-line',
    'fields' => array(

        array(
            'id' => 'hider_header_form',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('حذف هدر', 'prk'),
            'subtitle' => esc_html__('حذف هدر در صفحه ورود/عضویت کاربر'),
            'default' => false,
        ),
        array(
            'id' => 'hider_footer_form',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('حذف فوتر', 'prk'),
            'subtitle' => esc_html__('حذف فوتر در صفحه ورود/عضویت کاربر'),
            'default' => false,
        ),
        array(
            'id' => 'logined_before_order',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('ورود اجباری', 'prk'),
            'subtitle' => esc_html__('فعال سازی ورود اجباری قبل از پرداخت صورت حساب'),
            'default' => false,
        ),

      array(
          'id' => 'Conditions_page',
          'type' => 'select',
          'title' => esc_html__('برگه شرایط و مقررات', 'prk'),
          'subtitle' => esc_html__('انتخاب برگه شرایط ومقررات فروشگاه', 'prk'),
          'chosen' => true,
          'ajax' => true,
          'options' => 'pages',
      ),
      array(
          'id' => 'prk_myaccount_downloads',
          'type' => 'switcher',
          'title' => 'فعال سازی تب دانلود ها',
          'subtitle' => esc_html__('فعال سازی تب لیست علاقمندی های کاربر', 'prk'),
          'text_width' => 80,
          'default' => true
      ),
        array(
            'id' => 'prk_myaccount_whishlist',
            'type' => 'switcher',
            'title' => 'فعال سازی تب علاقمندی ها',
            'subtitle' => esc_html__('فعال سازی تب لیست علاقمندی های کاربر', 'prk'),
            'text_width' => 80,
            'default' => false
        ),
        array(
            'id' => 'prk_myaccount_notif',
            'type' => 'switcher',
            'title' => 'فعال سازی تب اعلانات و نظرات کاربر',
            'subtitle' => esc_html__('فعال سازی تب لیست  اعلانات کاربر', 'prk'),
            'text_width' => 80,
            'default' => true
        ),

        array(
            'id' => 'myaccount_whishlist_sec',
            'type' => 'switcher',
            'title' => 'سکشن علاقمندی ها',
            'subtitle' => esc_html__('فعال سازی سکشن علاقمندی ها', 'prk'),
            'text_width' => 80,
            'default' => true
        ),
        array(
            'id' => 'myaccount_whishlist_sec_text',
            'type' => 'text',
            'title' => 'عنوان سکشن',
            'default' => 'از لیست های شما',
            'dependency' => array('myaccount_whishlist_sec', '==', 'true'),
        ),

        array(
            'id' => 'myaccount_whishlist_lastviewd',
            'type' => 'switcher',
            'title' => 'سکشن محصولات دیده شده',
            'subtitle' => esc_html__('فعال سازی سکشن محصولات دیده شده', 'prk'),
            'text_width' => 80,
            'default' => true
        ),
        array(
            'id' => 'myaccount_lastviewd_sec_text',
            'type' => 'text',
            'title' => 'عنوان سکشن',
            'default' => 'محصولات مشاهده شده اخیر',
            'dependency' => array('myaccount_whishlist_lastviewd', '==', 'true'),
        ),
    )
));

#compare-product Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی مقایسه محصول', 'prk'),
    'id' => 'compare_product',
    'icon' => 'ri-scales-line',
    'fields' => array(
        array(
            'id' => 'single_product_compare',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش دکمه مقایسه', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش دکمه مقایسه محصول', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'compare_page',
            'type' => 'select',
            'title' => esc_html__('برگه مقایسه محصول', 'prk'),
            'subtitle' => esc_html__('انتخاب برگه مقایسه محصول و اضافه کردن این شرت کد : [prk-compare]', 'prk'),
            'options' => $pages,
            'dependency' => array('single_product_compare', '==', 'true'),
        ),

    )
));

#attributes settings
CSF::createSection($prefix, array(
  'title' => esc_html__('پیکربندی گروه بندی ویژگی ها', 'prk'),
  'id' => 'gAttributes_settings',
  'icon' => 'ri-printer-line',
));


CSF::createSection( $prefix, array(
    'title'      => __( 'عمومی', 'parskala' ),
    // 'desc'       => __( '', 'woocommerce-pdf-catalog' ),
    'id'         => 'general-settings',
    'parent' => 'gAttributes_settings', // The slug id of the parent section
    'fields'     => array(
        array(
            'id'       => 'prk_gattributes_enable',
            'type'     => 'switcher',
            'title'    => __( 'فعال سازی', 'parskala' ),
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
        array(
            'id'     =>'attributeValueDivider',
            'type' => 'select',
            'title' => __('کارکتر بین مقادیر', 'parskala'),
            'options' => array(
                ', ' => __('کاما', 'parskala'),
                '<br>' => __('سطر جدید', 'parskala'),
                ' | ' => __('پایپ', 'parskala'),
                ),
            'default' => ', ',
        ),
    )
) );

#prk-size-guide settings
require_once get_template_directory().'/inc/prk-size-guide/prkSizeGuideSettings.php';


#archive-product Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی صفحه فروشگاه', 'prk'),
    'id' => 'archive_product',
    'icon' => 'ri-store-3-line',

));

#archive-product Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('عمومی', 'prk'),
    'id' => 'archive_product',
    'parent' => 'archive_product', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'prk_shop_ajax_add',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('بارگذاری آجاکسی صفحه', 'prk'),
            'subtitle' => esc_html__('صفحات پرسش متداول بصورت آجاکسی (بدون رفرش) بارگذاری میشوند.', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'ajax_prod_auto',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('بارگذاری آجاکس محصولات', 'prk'),
            'subtitle' => esc_html__('بارگذاری اتوماتیک محصولات بیشتر با رسیدن به انتهای محصولات', 'prk'),
            'default' => true,
            'dependency' => array('prk_shop_ajax_add', '==', 'true'),
        ),
  
        array(
            'id' => 'active_side_shop',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('فعال سازی سایدبار', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش سایدبار فروشگاه', 'prk'),
            'default' => true,
        ),
          array(
              'id'       => 'sort_by_stock',
              'type'     => 'select',
              'title'    => esc_html__('مرتب سازی بر اساس محصولات موجود و ناموجود', 'prk'),
              'subtitle' => esc_html__( 'اگر مایل هستید در صفحات اصلی و صفحات آرشیو محصولات ابتدا محصولات موجود و سپس محصولات ناموجود نمایش داده شوند این گزینه را فعال نمائید', 'prk' ),
              'default'  => 'default',
              'options'  => array(
                  'default' => esc_html__( 'پیشفرض', 'prk' ),
                  'instock' => esc_html__( 'از موجود تا ناموجود', 'prk' ),
            )
          ),
          array(
              'id' => 'show_sec_img',
              'type' => 'switcher',
              'text_width' => 80,
              'title' => esc_html__('نمایش تصویر دوم محصول', 'prk'),
              'subtitle' => esc_html__('نمایش تصویر دوم هنگام هاور کردن موس', 'prk'),
              'default' => true,
  
          ),
          // A Heading
          array(
            'type'    => 'heading',
            'content' => 'تنظیمات نمایش ویژگی محصول در صفحات آرشیو',
          ),
          array(
              'id' => 'show_swatches_archive',
              'type' => 'switcher',
              'text_width' => 80,
              'title' => esc_html__('نمایش فروشنده نمایش ویژگی محصول در صفحات آرشیو', 'prk'),
              'subtitle' => esc_html__('فعال سازی و نمایش فروشنده توسط این گزینه می توانید رنگبندی یا ویژگی دیگری از محصول را درصفحات آرشیو محصول نمایش دهید', 'prk'),
              'default' => true,
          ),
          array(
              'id'       => 'swatches_archive_attr',
              'type'     => 'select',
              'chosen'      => true,
              'ajax'        => true,
              'title' => __('انتخاب ویژگی ها', 'dina-kala'),
              'options'  => dina_product_attributes_array(),
              'dependency' => array(
                'show_swatches_archive', '==', 'true',
              ),
          ),
  
          array(
              'id' => 'show_swatches_archive_title',
              'type' => 'switcher',
              'text_width' => 80,
              'title' => esc_html__('نمایش عنوان ویژگی', 'prk'),
              'subtitle' => esc_html__('نمایش عنوان ویژگی هنگام هاور ماوس', 'prk'),
              'default' => true,
              'dependency' => array(
                'show_swatches_archive', '==', 'true',
              ),
          ),
          array(
              'id' => 'enable_swatches_archive_count',
              'type' => 'switcher',
              'text_width' => 80,
              'title' => esc_html__('نمایش مقادیر محدود', 'prk'),
              'subtitle' => esc_html__('با فعال شدن این گزینه می توانید تعداد مقادیر نمایش داده شده را محدود کنید', 'prk'),
              'default' => true,
              'dependency' => array(
                'show_swatches_archive', '==', 'true',
              ),
          ),
          array(
            'id'         => 'swatches_archive_count',
            'type'       => 'slider',
            'title'      => __('تعداد مقادیر قابل مشاهده'),
            'min'        => 1,
            'max'        => 60,
            'step'       => 1,
            'default'    => 4,
            'dependency' => array(
              array('enable_swatches_archive_count', '==', 'true'),
              array('show_swatches_archive', '==', 'true'),
            ),
          ),

          array(
              'id' => 'archive_product_orginal',
              'type' => 'switcher',
              'text_width' => 80,
              'title' => esc_html__('نمایش برچسب غیر اصل', 'prk'),
              'subtitle' => esc_html__('فعال سازی و نمایش برچسب غیر اصل', 'prk'),
              'default' => true,
          ),
          array(
              'id' => 'archive_product_seller_name',
              'type' => 'switcher',
              'text_width' => 80,
              'title' => esc_html__('نمایش فروشنده محصول', 'prk'),
              'subtitle' => esc_html__('فعال سازی و نمایش فروشنده محصول', 'prk'),
              'default' => true,
          ),
  
          array(
              'id' => 'archive_product_stock',
              'type' => 'switcher',
              'text_width' => 80,
              'title' => esc_html__('نمایش موجودی انبار', 'prk'),
              'subtitle' => esc_html__('فعال سازی و نمایش  موجودی انبار', 'prk'),
              'default' => true,
          ),
          array(
              'id' => 'product_rate',
              'type' => 'switcher',
              'text_width' => 80,
              'title' => esc_html__('امتیاز محصول', 'prk'),
              'subtitle' => esc_html__('فعال سازی و نمایش امتیاز محصول', 'prk'),
              'default' => true,
          ),
          array(
              'id' => 'archive_product_thumbnail_2',
              'type' => 'switcher',
              'text_width' => 80,
              'title' => esc_html__('نمایش تصویر شناور دوم', 'prk'),
              'subtitle' => esc_html__('فعال سازی و نمایش  تصویر شناور دوم', 'prk'),
              'default' => true,
          ),
          array(
              'id' => 'archive_product_add_to_cart',
              'type' => 'switcher',
              'text_width' => 80,
              'title' => esc_html__('نمایش دکمه اضافه کردن به سبد خرید', 'prk'),
              'default' => false,
          ),
          array(
              'id' => 'archive_product_add_to_cart_type',
              'type' => 'select',
              'title' => esc_html__('سبک نمایشی دکمه افزودن به سبد خرید', 'prk'),
              'options' => array(
                  'icon' => esc_html__('ایکن', 'prk'),
                  'text' => esc_html__('متنی', 'prk'),
              ),
              'default' => 'icon',
              'dependency' => array(
                  array('archive_product_add_to_cart', '==', 'true'),
                ),
          ),
          array(
              'id' => 'archive_product_add_to_cart_icon',
              'type' => 'text',
              'text_width' => 80,
              'title' => esc_html__('ایکن افزودن به سبدخرید', 'prk'),
              'desc' => 'دریافت فونت ایکن از سایت .<a href="https://remixicon.com/" target="_blank">remixicon</a> یا <a href="http://parskalas.com/icon/iconpars.html" target="_blank">فونت های اختصاصی پارس کالا</a>',
              'default' => 'prk-shopping-cart',
              'dependency' => array(
                  array('archive_product_add_to_cart', '==', 'true'),
                  array('archive_product_add_to_cart_type', '==', 'icon'),
                ),
          ),
          array(
              'id' => 'archive_product_add_to_cart_text',
              'type' => 'text',
              'text_width' => 80,
              'title' => esc_html__('متن افزودن به سبدخرید', 'prk'),
              'default' => 'افزودن به سبد',
              'dependency' => array(
                  array('archive_product_add_to_cart', '==', 'true'),
                  array('archive_product_add_to_cart_type', '==', 'text'),
                ),
          ),
          array(
              'id' => 'archive_product_add_to_cart_color',
              'type' => 'color',
              'title' => esc_html__('رنگ پس زمینه دکمه سبدخرید', 'prk'),
              'transparent' => false,
              'output' => array('color' => 'body .main-footer.mobit .dn-box .dn-link span'),
              'output_important' => 'true',
              'dependency' => array('archive_product_add_to_cart', '==', 'true'),
          ),

          array(
            'id' => 'show_title_cat_archive',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش عنوان دسته بندی محصول', 'prk'),
            'default' => true,
        ),
  
  
      )

));

CSF::createSection( $prefix, array(
    'title'      => __( 'استایل دهی', 'parskala' ),
    'parent' => 'archive_product', // The slug id of the parent section
    'fields' => array(

        array(
            'id' => 'archive_product_subcategories',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش دسته بندی فرزندی', 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'archive_show_subcategories_title',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش عنوان دسته بندی فرزندی', 'prk'),
            'default' => true,
            'dependency' => array(
                array('archive_product_subcategories', '==', 'true'),
              ),
        ),
        array(
            'id' => 'archive_product_subcategories_title',
            'type' => 'text',
            'text_width' => 80,
            'title' => esc_html__('عنوان دسته بندی فرزندی', 'prk'),
            'default' => 'دسته‌بندی‌ها',
            'dependency' => array(
                array('archive_product_subcategories', '==', 'true'),
              ),
        ),

        array(
            'id' => 'archive_product_subcategories_count',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش تعداد', 'prk'),
            'default' => true,
            'dependency' => array(
                array('archive_product_subcategories', '==', 'true'),
              ),
        ),
        array(
            'id' => 'hide_product_subcategories',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش فقط دسته های فرزندی دارای محصول', 'prk'),
            'subtitle' => esc_html__('با فعال کردن این گزینه تنها دسته های دارای محصول نمایش داده میشوند.', 'prk'),
            'default' => false,
            'dependency' => array(
                array('archive_product_subcategories', '==', 'true'),
              ),
        ),
        array(
            'id' => 'archive_product_subcategories_style',
            'type' => 'image_select',
            'class' => 'subcategories_style',
            'title' => esc_html__('استایل دسته بندی فرزندی', 'prk'),
            'default' => 'default',
            'options'   => array(
                'box'   => get_template_directory_uri().'/assets/img/options/subcategories-list-box.jpg',
                'listi'   => get_template_directory_uri().'/assets/img/options/subcategories-list-listi.jpg',
              ),
            'select2' => array('allowClear' => false),
            'dependency' => array('archive_product_subcategories', '==', 'true'),
        ),

        array(
            'id'         => 'archive_product_subcategories_order',
            'type'       => 'button_set',
            'title'      => 'جایگاه نمایش دسته بندی',
            'options'    => array(
              'top_sidebar'  => 'بالای سایدبار',
              'next_sidebar' => 'کنار سایدبار',
            ),
            'default'    => 'top_sidebar'
        ),



        array(
            'id'      => 'border_sidebar_shop',
            'type'    => 'border',
            'title'   => 'حاشیه دور دسته بندی فرزندی',
            'default' => array(
              'top'    => '1',
              'right'  => '1',
              'bottom' => '1',
              'left'   => '1',
              'style'  => 'solid',
              'color'  => '#e4e4e4',
              'unit'   => 'px',
            ),
            'output_important' => 'true',
            'output' => 'body.product-archive .subcategories-list .term',
        ),
     
        array(
            'id'     => 'bcolor_subcategories_order',
            'type'   => 'color',
            'title'  => 'رنگ پس زمینه دسته بندی فرزندی',
            'output' => array( 'background-color' => 'body.product-archive .subcategories-list .term' )
        ),

        // A Heading
        array(
            'type'    => 'heading',
            'content' => 'استایل سایدبار',
        ),

        array(
            'id'      => 'border_sidebar_shop',
            'type'    => 'border',
            'title'   => 'حاشیه دور ابزارک سایدبار',
            'default' => array(
              'top'    => '1',
              'right'  => '1',
              'bottom' => '1',
              'left'   => '1',
              'style'  => 'solid',
              'color'  => '#e4e4e4',
              'unit'   => 'px',
            ),
            'output_important' => 'true',
            'output' => 'body.product-archive .sides .widget',
        ),
        array(
            'id'          => 'border_radius_shop',
            'type'        => 'number',
            'title'       => 'انحنای مرز ابزارک سایدبار',
            'unit'        => 'px',
            'output'      => 'body.product-archive .sides .widget',
            'output_mode' => 'border-radius',
            'output_important' => 'true',
            'default'     => 11,
        ),
        array(
            'id'     => 'bcolor_sidebar_shop',
            'type'   => 'color',
            'title'  => 'رنگ پس زمینه ابزارک سایدبار',
            'output' => array( 'background-color' => 'body.product-archive .sides .widget' )
        ),

        array(
            'id'    => 'title_sidebar_shop',
            'type'  => 'typography',
            'title' => 'عنوان ابزارک سایدبار',
            'output_important' => 'true',
            'output'  => 'body.product-archive .sides .widget .widgettitle',
        ),
        // A Heading
        array(
            'type'    => 'heading',
            'content' => 'استایل آیتم محصولات',
        ),

        array(
            'id'          => 'prk_loop_style_product',
            'type'        => 'select',
            'title'       => 'Select',
            'placeholder' => 'انتخاب سبک',
            'options'     => array(
              'prk-item-style1'  => 'پیشفرض',
              'prk-item-style2'  => 'سبک مینیمال',
            ),
            'default'     => 'prk-item-style1'
        ),

        array(
            'id'      => 'prk_loop_columns_product',
            'type'    => 'slider',
            'title'   => 'تعداد محصول در هر ردیف فروشگاه',
            'min'     => 1,
            'max'     => 8,
            'step'    => 1,
            'default' => 4,
        ),

        array(
            'id'      => 'prk_products_per_page_loop',
            'type'    => 'number',
            'title'   => 'تعداد محصول در هر صفحه',
            'default' => 20,
        ),

        array(
            'id'      => 'border_p_shop',
            'type'    => 'border',
            'title'   => 'حاشیه دور سکشن آیتم',
            'default' => array(
              'top'    => '1',
              'right'  => '1',
              'bottom' => '1',
              'left'   => '1',
              'style'  => 'solid',
              'color'  => '#E4E4E4',
              'unit'   => 'px',
            ),
            'output_important' => 'true',
            'output' => 'body.product-archive .prk-head-shop',
        ),
        array(
            'id'          => 'border_radius_pshop',
            'type'        => 'number',
            'title'       => 'انحنای مرز ابزارک سایدبار',
            'unit'        => 'px',
            'output'      => 'body.product-archive .prk-head-shop',
            'output_mode' => 'border-radius',
            'output_important' => 'true',
            'default'     => 14,
        ),
        array(
            'id'     => 'bcolor_p_shop',
            'type'   => 'color',
            'title'  => 'رنگ خط بین آیتم ها',
            'default'     => 'E4E4E4',
            'output' => array( 'border-color' => 'body.product-archive ul.product-box li.product' )
        ),

        // A Heading
        array(
            'type'    => 'heading',
            'content' => 'استایل توضیحات دسته بندی',
        ),

        array(
            'id'         => 'archive_product_description_order',
            'type'       => 'button_set',
            'title'      => 'جایگاه نمایش باکس توضیحات دسته بندی محصول',
            'options'    => array(
              'bottom_sidebar'  => 'پایین سایدبار سایدبار',
              'next_sidebar' => 'کنار سایدبار',
            ),
            'default'    => 'bottom_sidebar'
        ),

        array(
            'id'      => 'border_description_shop',
            'type'    => 'border',
            'title'   => 'حاشیه دور توضیحات دسته بندی',
            'default' => array(
                'top'    => '1',
                'right'  => '1',
                'bottom' => '1',
                'left'   => '1',
                'style'  => 'solid',
                'color'  => '#e4e4e4',
                'unit'   => 'px',
            ),
            'output_important' => 'true',
            'output' => 'body.product-archive .footer-description-shop',
        ),
        array(
            'id'          => 'border_radius_description_shop',
            'type'        => 'number',
            'title'       => 'انحنای مرز توضیحات دسته بندی',
            'unit'        => 'px',
            'output'      => 'body.product-archive .footer-description-shop',
            'output_mode' => 'border-radius',
            'output_important' => 'true',
            'default'     => 11,
        ),
        array(
            'id'     => 'bcolor_sdescription_shop',
            'type'   => 'color',
            'title'  => 'رنگ پس زمینه توضیحات دسته بندی',
            'output' => array( 'background-color' => 'body.product-archive .footer-description-shop' )
        ),

        array(
            'id'    => 'title_description_shop',
            'type'  => 'typography',
            'title' => 'عنوان توضیحات دسته بندی',
            'output_important' => 'true',
            'output'  => 'body.product-archive .footer-description-shop .title-category',
        ),

    )
) );


#checkout Settings
CSF::createSection($prefix, array(
  'title' => esc_html__('پیکربندی صفحه تسویه حساب', 'prk'),
  'id' => 'checkout_product',
  'icon' => 'ri-shopping-bag-2-line',
));

CSF::createSection($prefix, array(
  'title' => esc_html__('عمومی', 'prk'),
  'parent' => 'checkout_product', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'checkout_product_styles',
            'type' => 'select',
            'title' => esc_html__('سبک نمایشی تسویه حساب', 'prk'),
            'subtitle' => esc_html__('انتخاب سبک نمایشی تسویه حساب', 'prk'),
            'options' => array(
                'default' => esc_html__('پیشفرض', 'prk'),
                'style2' => esc_html__('صورت حساب چندمرحله‌ای', 'prk'),
            ),
            'default' => 'style2',
        ),
        array(
            'id' => 'checkout_header_hide',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('حذف هدر در صفحه پرداخت', 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'checkout_footer_hide',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('حذف فوتر در صفحه پرداخت', 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'logo_payment',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش لوگو در صفحه پرداخت', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'prk_logo_payment_url',
            'type' => 'media',
            'title' => esc_html__('تصویر لوگو', 'prk'),
            'dependency' => array('logo_payment', '==', 'true'),

        ),
        array(
            'id' => 'opti_checkout_ncode',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('اجباری کردن فیلد کد ملی', 'prk'),
            'default' => false,
        ),
    )

));

CSF::createSection($prefix, array(
    'title' => esc_html__('کد پیگیری پستی', 'prk'),
    'parent' => 'checkout_product', // The slug id of the parent section
      'fields' => array(
          array(
              'id' => 'order_tracking_code',
              'type' => 'switcher',
              'text_width' => 80,
              'title' => esc_html__('کد رهگیری سفارش', 'prk'),
              'subtitle' => esc_html__('قابلیت درج کد رهگیری در صفحه مدیریت سفارش و نمایش در پنل کاربران', 'prk'),
              'default' => false,
          ),
          array(
            'id' => 'order_tracking_code_title',
            'type' => 'text',
            'title' => 'عنوان کد رهگیری',
            'default' => 'کد رهگیری',
            'dependency' => array('order_tracking_code', '==', 'true'),
            ),
    )
  
  ));

CSF::createSection($prefix, array(
'title' => esc_html__('فیلدهای صفحه پرداخت', 'prk'),
'parent' => 'checkout_product', // The slug id of the parent section
    'fields' => array(
    array(
        'id' => 'checkout_manager_form',
        'type' => 'switcher',
        'text_width' => 80,
        'title' => esc_html__('فعال سازی ویرایشگر فیلد صفحه پرداخت', 'prk'),
        'subtitle' => esc_html__('بعد از فعال سازی این دکمه و ذخیره سازی ، تنظیمات پوسته را بسته و یک بار مجددا باز کنید.', 'prk'),
        'default' => false,
    ),
        array(
            'id' => 'prk_checkout_manager_form_callback',
            'type' => 'callback',
            'function' =>'prk_checkout_manager_form_callback',

            'dependency' => array(
            array('checkout_manager_form', '==', 'true'),
        ),
        )
    )
));

CSF::createSection($prefix, array(
  'title' => esc_html__('زمان تحویل', 'prk'),
  'parent' => 'checkout_product', // The slug id of the parent section
    'fields' => array(

      array(
          'id' => 'checkout-delivery',
          'type' => 'switcher',
          'title' => 'نمایش زمان‌ تحویل سفارش',
          'text_width' => 80,
          'default' => true
      ),
      array(
        'id'         => 'required_day_send',
        'type'       => 'switcher',
        'title'      => 'ضروری کرن انتخاب تاریخ تحویل',
        'default'    => true,
        'dependency' => array(
            array('checkout-delivery', '==', 'true'),
        ),
      ),
      array(
        'id'         => 'prk_popup_send_delivery',
        'type'       => 'switcher',
        'title'      => 'نمایش پاپ آپ فیلد تحویل سفارش در موبایل',
        'default'    => true,
        'dependency' => array(
            array('checkout-delivery', '==', 'true'),
        ),
      ),
      array(
        'id'    => 'popup_send_deliver_text',
        'type'  => 'text',
        'title' => 'عنوان دکمه پاپ آپ نمایش  فیلد',
        'default'  => 'انتخاب زمان تحویل سفارش',
        'dependency' => array(
            array('checkout-delivery', '==', 'true'),
            array('prk_popup_send_delivery', '==', 'true'),
        ),
      ),
      array(
        'id'    => 'checkout-delivery-icon-mobil',
        'type'  => 'text',
        'title' => 'ایکن کنار لیبل تحویل',
        'default'  => 'ri-truck-line',
        'dependency' => array(
            array('checkout-delivery', '==', 'true'),
            array('prk_popup_send_delivery', '==', 'true'),
        ),
      ),
      array(
        'id'    => 'checkout-delivery-label-mobil',
        'type'  => 'text',
        'title' => 'لیبل فیلد انتخاب تحویل در موبایل و تبلت',
        'default'  => 'انتخاب بازه زمانی تحویل',
        'dependency' => array(
            array('checkout-delivery', '==', 'true'),
            array('prk_popup_send_delivery', '==', 'true'),
        ),
      ),
      array(
        'id'    => 'checkout-delivery-label-pc',
        'type'  => 'text',
        'title' => 'لیبل فیلد انتخاب تحویل در pc',
        'default'  => 'انتخاب زمان تحویل',
        'dependency' => array(
            array('checkout-delivery', '==', 'true'),
        ),
      ),
      array(
        'id'          => 'delivery-dates',
  			'type'        => 'select',
  			'title'       => __('روز های تحویل'),
  			'chosen'      => true,
  			'multiple'    => true,
  			'placeholder' => __('انتخاب'),
  			'options'     => array(
  				'saturday'  => __('شنبه'),
  				'sunday'    => __('یکشنبه'),
  				'monday'    => __('دوشنبه'),
  				'tuesday'   => __('سه شنبه'),
  				'wednesday' => __('چهارشنبه'),
  				'thursday'  => __('پنجشنبه'),
  				'friday'    => __('جمعه'),
  			),
  			'default'     => array('saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday'),
  			'dependency'  => array('checkout-delivery', '==', 'true'),
      ),

      array(
        'id'         => 'delivery-min-time',
        'type'       => 'slider',
        'title'      => __('حداقل زمان تحویل'),
        'min'        => 0,
        'max'        => 60,
        'step'       => 1,
        'default'    => 4,
        'dependency' => array('checkout-delivery', '==', 'true'),
      ),
      array(
        'id'         => 'delivery-times-count',
  			'type'       => 'slider',
  			'title'      => __('شمارش پیشنهاد زمان تحویل'),
  			'min'        => 1,
  			'max'        => 8,
  			'step'       => 1,
  			'default'    => 5,
  			'dependency' => array('checkout-delivery', '==', 'true'),
      ),
      array(
        'type'    => 'heading',
        'content' => 'ساعت های تحویل سفارش',
        'dependency' => array(
            array('checkout-delivery', '==', 'true'),
        ),
      ),
      array(
        'id'         => 'show_timer_send',
        'type'       => 'switcher',
        'title'      => 'افزودن ساعت تحویل',
        'default'    => true,
        'dependency' => array(
            array('checkout-delivery', '==', 'true'),
        ),
      ),
      array(
        'id'         => 'required_timer_send',
        'type'       => 'switcher',
        'title'      => 'ضروری کرن انتخاب ساعت تحویل',
        'default'    => true,
        'dependency' => array(
            array('checkout-delivery', '==', 'true'),
            array('show_timer_send', '==', 'true'),
        ),
      ),
      array(
      'id'        => 'list_send_time_order',
      'type'      => 'group',
      'title'     => 'ساعت تحویل',
      'dependency' => array(
          array('checkout-delivery', '==', 'true'),
          array('show_timer_send', '==', 'true'),
      ),
      'fields'    => array(
          array(
            'id'    => 'time_send_order',
            'type'  => 'text',
            'title' => 'ساعت تحویل',
            'desc'  => 'ساعت ارسال سفارش را تعیین کنید مثلا: ساعت ۱۰ تا ۲۲'
          ),
       ),
      ),

   )
));

CSF::createSection($prefix, array(
  'title' => esc_html__('نقشه', 'prk'),
  'parent' => 'checkout_product', // The slug id of the parent section
    'fields' => array(

      array(
          'id' => 'checkout-map',
          'type' => 'switcher',
          'title' => 'نمایش نقشه خرید',
          'text_width' => 80,
          'default' => true
      ),

      array(
        'id'    => 'checkout-map-address',
  			'type'  => 'text',
  			'title' => __('انتخاب آدرس'),
        'desc' => __('تعیین آدرس پیشفرض نقشه در صفحه پرداخت'),
        'default' => 'Azadi Square, District 9, Tehran, بخش مرکزی شهرستان تهران, Tehran County, Iran',
  			'dependency'  => array('checkout-map', '==', 'true'),
      ),

      array(
        'id'            => 'checkout-map-details',
  			'type'          => 'map',
  			'title'         => __('نقشه'),
  			'desc'          => __('لوکیشن پیشفرض نقشه'),
  			'address_field' => 'checkout-map-address',
  			'dependency'  => array('checkout-map', '==', 'true'),
      ),

)
));

#my account Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('استایل دهی', 'prk'),
    'id' => 'prk_styles_checkout',
    'parent' => 'checkout_product', // The slug id of the parent section
    'fields' => array(
        array(
            'id'          => 'border_radius_total_box',
            'type'        => 'number',
            'title'       => 'انحنای مرز کارت اطلاعات سفارش',
            'unit'        => 'px',
            'default'     => 11,
        ),
        array(
            'id' => 'gradient_total_box_product',
            'type' => 'background',
            'title' => 'رنگ پس زمینه کارت اطلاعات سفارش',
            'background_gradient' => true,
            'background_origin' => true,
            'background_image' => false,
            'background_clip' => false,
            'background_blend_mode' => false,
        ),
        array(
            'id' => 'border_total_box_product',
            'type' => 'color',
            'title' => esc_html__('رنگ خطوط اطلاعات کارت سفارش', 'prk'),
            'validate' => 'color',
            'transparent' => false,
        ),
        array(
            'id' => 'color_total_box_product',
            'type' => 'color',
            'title' => esc_html__('رنگ عناوین اطلاعات کارت سفارش', 'prk'),
            'validate' => 'color',
            'transparent' => false,
            'output_important' => 'true',
        ),
        array(
            'id' => 'back_total_btn_product',
            'type' => 'background',
            'title' => 'رنگ پس زمینه دکمه پرداخت',
            'background_gradient' => true,
            'background_origin' => true,
            'background_image' => false,
            'background_clip' => true,
            'background_blend_mode' => true,
        ),
        array(
            'id' => 'color_total_btn_product',
            'type' => 'color',
            'title' => esc_html__('رنگ عنوان دکمه پرداخت', 'prk'),
            'validate' => 'color',
            'transparent' => false,
        ),
        array(
            'id' => 'shadow_total_btn_product',
            'type' => 'color',
            'title' => esc_html__('سایه دکمه پرداخت ', 'prk'),
            'validate' => 'color',
            'transparent' => false,
        ),
    )
));


#my ordertracker Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('سبدخرید رها شده', 'prk'),
    'id' => 'prk_reminder_cart_options',
    'icon' => 'ri-shopping-cart-line',
    'fields' => array(

        array(
            'id' => 'prk_reminder_cart_enabe',
            'type' => 'switcher',
            'title' => 'فعال سازی  یاداوری پیامکی سبدخرید رها شده',
            'subtitle' => 'فعال سازی یاداوری پیامکی سبد خریدی که پرداخت نشده',
            'text_width' => 80,
            'default' => true
        ),

        
        array(
        'id'      => 'prk_reminder_cart_send',
        'type'    => 'slider',
        'title'   => 'ساعت ارسال پیامک',
        'subtitle'   => 'مثلاً اگر ۳ وارد کنید، فقط سفارشاتی که بیش از ۳ ساعت رها شده‌اند پیامک دریافت می‌کنند.',
        'default' => 4,
        'dependency' => array(
                array('prk_reminder_cart_enabe', '==', 'true'),
        ),
        ),


        array(
            'id' => 'prk_reminder_cart_discont_enabe',
            'type' => 'switcher',
            'title' => 'تعیین کد تخفیف',
            'text_width' => 80,
            'default' => true,
            'dependency' => array(
                array('prk_reminder_cart_enabe', '==', 'true'),
            ),
        ),

        // 1) انتخاب حالت کلی: درصدی یا مبلغ ثابت
        array(
        'id'         => 'prk_reminder_cart_discont_choose',
        'type'       => 'button_set',
        'title'      => 'نوع تخفیف کد سبدِ رها‌شده',
        'options'    => array(
            'discount_fix'   => 'کد تخفیف ثابت',
            'discount_smart' => 'درصدی / خودکار',
        ),
        'dependency' => array(
            array('prk_reminder_cart_discont_enabe', '==', 'true'),
            array('prk_reminder_cart_enabe', '==', 'true'),
        ),
        'default'    => 'discount_smart',
        'text_width' => 100,
        ),

        // 2) فقط وقتی «مبلغ ثابت» انتخاب شده: کد/نام کوپن ثابت
        array(
        'id'         => 'prk_reminder_cart_discont_fix',
        'type'       => 'text',
        'title'      => 'کد کوپن',
        'subtitle'   => 'نام/کد کوپن ثابت برای سبدهای رها‌شده (مثل PRK2024). مقدار تخفیف را در تنظیمات خود کوپن تعیین کنید.',
        'dependency' => array(
            array('prk_reminder_cart_enabe', '==', 'true'),
            array('prk_reminder_cart_discont_enabe', '==', 'true'),
            array('prk_reminder_cart_discont_choose', '==', 'discount_fix'),
        ),
        ),

        // 3) فقط وقتی «درصدی/خودکار» انتخاب شده: نوع محاسبه مقدار (درصدی یا ثابت روی سبد/محصول)
        array(
        'id'         => 'prk_reminder_cart_discont',
        'type'       => 'select',
        'title'      => 'نوع محاسبه مقدار تخفیف (برای حالت درصدی/خودکار)',
        'options'    => array(
            'percent'       => 'درصدی',
            'fixed_cart'    => 'مبلغ ثابت روی سبد',
            'fixed_product' => 'مبلغ ثابت روی هر محصول',
        ),
        'dependency' => array(
            array('prk_reminder_cart_enabe', '==', 'true'),
            array('prk_reminder_cart_discont_enabe', '==', 'true'),
            array('prk_reminder_cart_discont_choose', '==', 'discount_smart'),
        ),
        'default'    => 'percent',
        ),

        // 4) فقط وقتی «درصدی/خودکار» انتخاب شده: مقدار تخفیف
        array(
        'id'          => 'prk_reminder_cart_discont_smart',
        'type'        => 'number',
        'title'       => 'مقدار تخفیف',
        'subtitle'    => 'اگر «درصدی» انتخاب شده: عددی بین ۱ تا ۱۰۰ وارد کنید. اگر «مبلغ ثابت» انتخاب شده: مبلغ را به تومان وارد کنید (مثلاً 20000).',
        'placeholder' => esc_html__('مثلاً: درصدی=10  |  مبلغ ثابت=20000', 'prk'),
        'attributes'  => array(
            'min'  => 1,
            'step' => 1,
        ),
        'dependency'  => array(
            array('prk_reminder_cart_enabe', '==', 'true'),
            array('prk_reminder_cart_discont_enabe', '==', 'true'),
            array('prk_reminder_cart_discont_choose', '==', 'discount_smart'),
        ),
        ),


       array(
        'id'      => 'prk_reminder_cart_discont_smart_min',
        'type'    => 'number',
        'title'   => 'حداقل مبلغ خرید',
        'subtitle'   => ' حداقل مقدار خرید جهت اعمال کد تخفیف (خالی گذاشتن به معنای بدون محدودیت است)',
         'dependency' => array(
                array('prk_reminder_cart_enabe', '==', 'true'),
                array('prk_reminder_cart_discont_enabe', '==', 'true'),
                array('prk_reminder_cart_discont_choose', '==', 'discount_smart')
            ),
        ),


        array(
        'id'      => 'prk_reminder_cart_discont_smart_max',
        'type'    => 'number',
        'title'   => 'حداثکر مبلغ خرید',
        'subtitle'   => ' حداکثر مقدار خرید جهت اعمال کد تخفیف (خالی گذاشتن به معنای بدون محدودیت است)',
         'dependency' => array(
                array('prk_reminder_cart_enabe', '==', 'true'),
                array('prk_reminder_cart_discont_enabe', '==', 'true'),
                array('prk_reminder_cart_discont_choose', '==', 'discount_smart')
            ),
        ),

        array(
        'id'      => 'prk_reminder_cart_exclude_sale_items',
        'type'    => 'checkbox',
        'title'   => 'به‌جز محصولات فروش ویژه',
        'subtitle'   => 'کد تخفیف فقط برای محصولات که تخفیف خورده نیستن اعمال شود؟',
        'label'   => 'فعال کن',
         'dependency' => array(
                array('prk_reminder_cart_enabe', '==', 'true'),
                array('prk_reminder_cart_discont_enabe', '==', 'true'),
                array('prk_reminder_cart_discont_choose', '==', 'discount_smart'),
        ),
        'default' => true // or false
        ),

        array(
        'id'      => 'prk_reminder_cart_limit',
        'type'    => 'number',
        'title'   => 'انقضا و حذف اتوماتیک کد تخفیف',
        'subtitle'   => ' تعیین کنید که کد تخفیف چند روز اعتبار دارد | مقدار روز به عدد تعیین کنید مثلا 2 (کد تخفیف ساخته بعد از انقضای تاریخ بصورت اتوماتیک حذف خواهد شد)',
        'placeholder' => esc_html__('مثلا 2 روز', 'prk'),
        'default' => 2,
            'dependency' => array(
                array('prk_reminder_cart_enabe', '==', 'true'),
                array('prk_reminder_cart_discont_enabe', '==', 'true'),
                array('prk_reminder_cart_discont_choose', '==', 'discount_smart'),
            ),
        ),

  

        // array(
        // 'id'      => 'prk_reminder_cart_out_of_stock',
        // 'type'    => 'checkbox',
        // 'title'   => 'ارسال پیامک هنگامی که محصول تخفیف خورده باشد',
        // 'title'   => 'درصورت فعال کردن این گزینه محصولی که در سفارش کاربر رها شده تخفیف بخورد پیامک برای ارسال خواهد شد.',
        // 'label'   => 'فعال کن',
        //  'dependency' => array(
        //         array('prk_reminder_cart_enabe', '==', 'true'),
        //  ),
        // 'default' => false // or false
        // ),

        // array(
        // 'id'      => 'prk_reminder_cart_out_of_discount',
        // 'type'    => 'checkbox',
        // 'title'   => 'ارسال پیامک هنگامی که موجودی محصول روبه اتمام است',
        // 'title'   => 'درصورت فعال کردن این گزینه محصولی که در سفارش کاربر رها شده روبه اتمام باشد  پیامک برای کاربر ارسال خواهد شد..',
        // 'label'   => 'فعال کن',
        //  'dependency' => array(
        //         array('prk_reminder_cart_enabe', '==', 'true'),
        // ),
        // 'default' => false 
        // ),

        // A Notice
        array(
        'type'    => 'notice',
        'style'   => 'info',
        'content' => '<a id="reminder_order_set" class="" href="'.$PRKSMSApp_url.'#remcartPattern"  target="_blank">تنظیم الگوی پترن پیامک</a>',
        'dependency' => array('prk_reminder_cart_enabe', '==', 'true'),
        ),

        // داخل همون آرایه fields سکشن:
        array(
        'type'       => 'content',
        'content'    => '<button id="prk-send-cart-reminder-now" class="button button-primary">ارسال دستی پیامک الان</button>
                        <span id="prk-send-cart-reminder-status" class="description" style="margin-right:10px"></span>',
        'dependency' => array(
            array('prk_reminder_cart_enabe', '==', 'true'),
        ),
        ),

    )
));

#my ordertracker Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('یاداوری نقد و بررسی محصولات', 'prk'),
    'id' => 'prk_reminder_rate_options',
    'icon' => 'ri-shopping-cart-line',
    'fields' => array(

        array(
            'id' => 'prk_reminder_rate_enabe',
            'type' => 'switcher',
            'title' => 'فعال سازی یاداوری نظرسنجی سفارش (محصولات سفارش داده شده)',
            'text_width' => 80,
            'default' => true
        ),

        
        array(
        'id'      => 'prk_reminder_rate_send',
        'type'    => 'slider',
        'title'   => 'ساعت ارسال پیامک',
        'subtitle'   => 'مثلاً اگر ۳ وارد کنید، فقط سفارشاتی که بیش از ۳ ساعت تکمیل شده اند پیامک دریافت می‌کنند.  (پیشنهاد میشود روی 36 ساعت قرار بدید)',
        'default' => 36,
        'dependency' => array(
                array('prk_reminder_rate_enabe', '==', 'true'),
        ),
        ),


        array(
        'id'         => 'prk_reminder_rate_discont_enabe',
        'type'       => 'switcher',
        'title'      => 'تعیین کد تخفیف',
        'text_width' => 80,
        'default'    => true,
        'dependency' => array(
            array('prk_reminder_rate_enabe', '==', 'true'),
        ),
        ),

        array(
        'id'         => 'prk_reminder_rate_discont_choose',
        'type'       => 'button_set',
        'title'      => 'نوع تخفیف کد یادآوریِ نظرسنجی',
        'options'    => array(
            'discount_fix'   => 'کد تخفیف ثابت',
            'discount_smart' => 'درصدی / خودکار',
        ),
        'dependency' => array(
            array('prk_reminder_rate_discont_enabe', '==', 'true'),
            array('prk_reminder_rate_enabe', '==', 'true'),
        ),
        'default'    => 'discount_smart',
        'text_width' => 100,
        ),

        array(
        'id'         => 'prk_reminder_rate_discont_fix',
        'type'       => 'text',
        'title'      => 'کد کوپن',
        'subtitle'   => 'نام/کد کوپن ثابت برای پیامک یادآوری ثبت نظر (مثل PRK2024). مقدار تخفیف را داخل تنظیمات خود کوپن تعیین کنید.',
        'dependency' => array(
            array('prk_reminder_rate_enabe', '==', 'true'),
            array('prk_reminder_rate_discont_enabe', '==', 'true'),
            array('prk_reminder_rate_discont_choose', '==', 'discount_fix'),
        ),
        ),

        array(
        'id'         => 'prk_reminder_rate_discont',
        'type'       => 'select',
        'title'      => 'نوع محاسبه مقدار تخفیف (برای حالت درصدی/خودکار)',
        'options'    => array(
            'percent'       => 'درصدی',
            'fixed_cart'    => 'مبلغ ثابت روی سبد',
            'fixed_product' => 'مبلغ ثابت روی هر محصول',
        ),
        'dependency' => array(
            array('prk_reminder_rate_enabe', '==', 'true'),
            array('prk_reminder_rate_discont_enabe', '==', 'true'),
            array('prk_reminder_rate_discont_choose', '==', 'discount_smart'),
        ),
        'default'    => 'percent',
        ),

        array(
        'id'          => 'prk_reminder_rate_discont_smart',
        'type'        => 'number',
        'title'       => 'مقدار تخفیف',
        'subtitle'    => 'اگر «درصدی» انتخاب شده: عددی بین ۱ تا ۱۰۰ وارد کنید. اگر «مبلغ ثابت» انتخاب شده: مبلغ را به تومان وارد کنید (مثلاً 20000).',
        'text_width' => 400,
        'attributes'  => array(
            'min'  => 1,
            'step' => 1,
        ),
        'dependency'  => array(
            array('prk_reminder_rate_enabe', '==', 'true'),
            array('prk_reminder_rate_discont_enabe', '==', 'true'),
            array('prk_reminder_rate_discont_choose', '==', 'discount_smart'),
        ),
        ),


       array(
        'id'      => 'prk_reminder_rate_discont_smart_min',
        'type'    => 'number',
        'title'   => 'حداقل مبلغ خرید',
        'subtitle'   => ' حداقل مقدار خرید جهت اعمال کد تخفیف (خالی گذاشتن به معنای بدون محدودیت است)',
         'dependency' => array(
                array('prk_reminder_rate_enabe', '==', 'true'),
                array('prk_reminder_rate_discont_enabe', '==', 'true'),
                array('prk_reminder_rate_discont_choose', '==', 'discount_smart')
            ),
        ),


        array(
        'id'      => 'prk_reminder_rate_discont_smart_max',
        'type'    => 'number',
        'title'   => 'حداثکر مبلغ خرید',
        'subtitle'   => ' حداکثر مقدار خرید جهت اعمال کد تخفیف (خالی گذاشتن به معنای بدون محدودیت است)',
         'dependency' => array(
                array('prk_reminder_rate_enabe', '==', 'true'),
                array('prk_reminder_rate_discont_enabe', '==', 'true'),
                array('prk_reminder_rate_discont_choose', '==', 'discount_smart')
            ),
        ),

        array(
        'id'      => 'prk_reminder_rate_exclude_sale_items',
        'type'    => 'checkbox',
        'title'   => 'به‌جز محصولات فروش ویژه',
        'subtitle'   => 'کد تخفیف فقط برای محصولات که تخفیف خورده نیستن اعمال شود؟',
        'label'   => 'فعال کن',
         'dependency' => array(
                array('prk_reminder_rate_enabe', '==', 'true'),
                array('prk_reminder_rate_discont_enabe', '==', 'true'),
                array('prk_reminder_rate_discont_choose', '==', 'discount_smart'),
        ),
        'default' => true // or false
        ),

        array(
        'id'      => 'prk_reminder_rate_limit',
        'type'    => 'number',
        'title'   => 'انقضا و حذف اتوماتیک کد تخفیف',
        'subtitle'   => ' تعیین کنید که کد تخفیف چند روز اعتبار دارد | مقدار روز به عدد تعیین کنید مثلا 2 (کد تخفیف ساخته بعد از انقضای تاریخ بصورت اتوماتیک حذف خواهد شد)',
        'placeholder' => esc_html__('مثلا 2 روز', 'prk'),
        'default' => 2,
            'dependency' => array(
                array('prk_reminder_rate_enabe', '==', 'true'),
                array('prk_reminder_rate_discont_enabe', '==', 'true'),
                array('prk_reminder_rate_discont_choose', '==', 'discount_smart'),
            ),
        ),

        
        array(
        'id'      => 'prk_reminder_rate_points',
        'type'    => 'number',
        'title'   => 'تعیین امتیاز باشگاه مشتریان',
        'subtitle'   => 'درصورتی که کاربر امتیاز و کامنت خود را ثبت کند برای بازخرید پاداش امتیاز تعلق میگیرد.',
         'dependency' => array(
            array('prk_reminder_rate_enabe', '==', 'true'),
            ),
        ),

        // A Notice
        array(
        'type'    => 'notice',
        'style'   => 'info',
        'content' => '<a id="reminder_order_set" class="" href="'.$PRKSMSApp_url.'#ratePattern"  target="_blank">تنظیم الگوی پترن پیامک</a>',
        'dependency' => array('prk_reminder_rate_enabe', '==', 'true'),
        ),

    )
));

#my ordertracker Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی پیگیری سفارش', 'prk'),
    'id' => 'prk_ordertrack_options',
    'icon' => 'ri-search-2-line',
    'fields' => array(

        array(
            'id' => 'prk_order_tracker',
            'type' => 'switcher',
            'title' => 'فعال سازی پیگیری سفارش',
            'text_width' => 80,
            'default' => true
        ),
        array(
        'type'    => 'submessage',
        'style'   => 'success',
          'content' => 'کد کوتاه جهت اضافه کردن فرم پیگیری سفارش در فرم: [prk-order-tracker]',
          'dependency' => array('prk_order_tracker', '==', 'true'),
        ),
        array(
            'id' => 'title_ordertrack',
            'type' => 'text',
            'title' => esc_html__('عنوان فرم', 'prk'),
            'default' => 'از این فرم جهت پیگیری وضعیت سفارش استفاده نمایید.',
            'dependency' => array('prk_order_tracker', '==', 'true'),
        ),

        array(
            'id' => 'order_tracker_myaccount',
            'type' => 'switcher',
            'title' => 'اضافه کردن فرم پیگیری سفارش در صفحه حساب کاربری',
            'text_width' => 80,
            'default' => true,
            'dependency' => array('prk_order_tracker', '==', 'true'),
        ),
        array(
        'type'    => 'submessage',
          'content' => 'تنظیمات جزیئات سفارش',
          'dependency' => array('prk_order_tracker', '==', 'true'),
        ),

        array(
            'id' => 'des_ordertrack',
            'type' => 'text',
            'title' => esc_html__('توضیحات', 'prk'),
            'default' => 'می‌توانید به طور دقیق مراحل پردازش و ارسال سفارش خود را پیگیری کنید.',
            'dependency' => array('prk_order_tracker', '==', 'true'),
        ),

        array(
            'id' => 'des_ordertrack_set1',
            'type' => 'text',
            'title' => esc_html__('عنوان در انتظار پرداخت', 'prk'),
            'default' => 'در صف بررسی',
            'dependency' => array('prk_order_tracker', '==', 'true'),
        ),
        array(
            'id' => 'des_ordertrack_set2',
            'type' => 'text',
            'title' => esc_html__('عنوان در انتظار بررسی', 'prk'),
            'default' => 'تایید سفارش',
            'dependency' => array('prk_order_tracker', '==', 'true'),
        ),
        array(
            'id' => 'des_ordertrack_set3',
            'type' => 'text',
            'title' => esc_html__('عنوان در حال انجام', 'prk'),
            'default' => 'آماده‌سازی سفارش',
            'dependency' => array('prk_order_tracker', '==', 'true'),
        ),
        array(
            'id' => 'des_ordertrack_set4',
            'type' => 'text',
            'title' => esc_html__('عنوان ارسال شده', 'prk'),
            'default' => 'خروج از مرکز پردازش',
            'dependency' => array('prk_order_tracker', '==', 'true'),
        ),
        array(
            'id' => 'des_ordertrack_set5',
            'type' => 'text',
            'title' => esc_html__('عنوان تکمیل شده', 'prk'),
            'default' => 'تحویل شده به مشتری',
            'dependency' => array('prk_order_tracker', '==', 'true'),
        ),
    )
));

#my ordertracker Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی سفارش', 'prk'),
    'id' => 'prk_minicart_options',
    'icon' => 'ri-shopping-cart-line',
    'fields' => array(
        array(
            'id' => 'mini_cart_notie',
            'type' => 'switcher',
            'title' => 'فعال سازی یاداشت سفارش',
            'text_width' => 80,
            'default' => true
        ),
        array(
            'id'      => 'mini_cart_title_notie',
            'type'    => 'text',
            'title'   => 'عنوان باکس یاداشت سفارش',
            'default'   => 'یاداشت سفارش',
            'dependency' => array('mini_cart_notie', '==', 'true'),
        ),

        array(
            'id' => 'mini_cart_shipping',
            'type' => 'switcher',
            'title' => 'فعال سازی حمل و نقل',
            'text_width' => 80,
            'default' => true
        ),
        array(
            'id'      => 'mini_cart_title_shipping',
            'type'    => 'text',
            'title'   => 'عنوان باکس حمل و نقل',
            'default'   => 'انتخاب آدرس حمل و نقل',
            'dependency' => array('mini_cart_shipping', '==', 'true'),
        ),


        array(
            'id' => 'mini_cart_coupon',
            'type' => 'switcher',
            'title' => 'فعال سازی کوپن',
            'text_width' => 80,
            'default' => true
        ),
        array(
            'id'      => 'mini_cart_title_coupon',
            'type'    => 'text',
            'title'   => 'عنوان باکس کوپن',
            'default'   => 'کوپن موجود را انتخاب کنید',
            'dependency' => array('mini_cart_coupon', '==', 'true'),
        ),
        array(
            'id'      => 'mini_cart_p_coupons',
            'type'    => 'textarea',
            'title'   => 'کوپن های عمومی - مینی سبد خرید (یکی در هر خط)',
            'subtitle'   => 'لطفاً کد کوپنی را که می‌خواهید در نوار کناری Mini Cart منتشر کنید (یکی در هر خط) وارد کنید.',
            'dependency' => array('mini_cart_coupon', '==', 'true'),
        ),

        array(
            'id' => 'mini_cart_total_price',
            'type' => 'switcher',
            'title' => 'نمایش قیمت کالاها',
            'text_width' => 80,
            'default' => true
        ),
        array(
            'id' => 'mini_cart_shipping_price',
            'type' => 'switcher',
            'title' => 'نمایش قیمت حمل و نقل',
            'subtitle'   => '"فعال سازی و  نمایش قیمت حمل و نقل "زیر قیمت کالاها',
            'text_width' => 80,
            'default' => true
        ),

        array(
            'id' => 'mini_cart_shipping_free',
            'type' => 'switcher',
            'title' => 'فعال سازی شمارنده قیمت تا ارسال رایگان',
            'subtitle'   => 'لازمه فعال سازی این قابلیت نصب بودن افزونه <a href="https://wordpress.org/plugins/woocommerce-advanced-free-shipping/">advanced-free-shipping</a> میباشد. <a href="#">راهنمای فعال سازی</a>',
            'text_width' => 80,
            'default' => true
        ),
        array(
            'id' => 'free_shipping_effect',
            'type' => 'switcher',
            'title' => 'فعال سازی افکت تبریک ارسال رایگان سفارش',
            'text_width' => 80,
            'default' => true
        ),
        // array(
        //     'id' => 'prk_order_tracker',
        //     'type' => 'switcher',
        //     'title' => 'فعال سازی پیگیری سفارش',
        //     'text_width' => 80,
        //     'default' => true
        // ),
        // array(
        // 'type'    => 'submessage',
        // 'style'   => 'success',
        //   'content' => 'کد کوتاه جهت اضافه کردن فرم پیگیری سفارش در فرم: [prk-order-tracker]',
        //   'dependency' => array('prk_order_tracker', '==', 'true'),
        // ),
        // array(
        //     'id' => 'title_ordertrack',
        //     'type' => 'text',
        //     'title' => esc_html__('عنوان فرم', 'prk'),
        //     'default' => 'از این فرم جهت پیگیری وضعیت سفارش استفاده نمایید.',
        //     'dependency' => array('prk_order_tracker', '==', 'true'),
        // ),

        // array(
        //     'id' => 'order_tracker_myaccount',
        //     'type' => 'switcher',
        //     'title' => 'اضافه کردن فرم پیگیری سفارش در صفحه حساب کاربری',
        //     'text_width' => 80,
        //     'default' => true,
        //     'dependency' => array('prk_order_tracker', '==', 'true'),
        // ),
        // array(
        // 'type'    => 'submessage',
        //   'content' => 'تنظیمات جزیئات سفارش',
        //   'dependency' => array('prk_order_tracker', '==', 'true'),
        // ),

        // array(
        //     'id' => 'des_ordertrack',
        //     'type' => 'text',
        //     'title' => esc_html__('توضیحات', 'prk'),
        //     'default' => 'می‌توانید به طور دقیق مراحل پردازش و ارسال سفارش خود را پیگیری کنید.',
        //     'dependency' => array('prk_order_tracker', '==', 'true'),
        // ),

        // array(
        //     'id' => 'des_ordertrack_set1',
        //     'type' => 'text',
        //     'title' => esc_html__('عنوان در انتظار پرداخت', 'prk'),
        //     'default' => 'در صف بررسی',
        //     'dependency' => array('prk_order_tracker', '==', 'true'),
        // ),
        // array(
        //     'id' => 'des_ordertrack_set2',
        //     'type' => 'text',
        //     'title' => esc_html__('عنوان در انتظار بررسی', 'prk'),
        //     'default' => 'تایید سفارش',
        //     'dependency' => array('prk_order_tracker', '==', 'true'),
        // ),
        // array(
        //     'id' => 'des_ordertrack_set3',
        //     'type' => 'text',
        //     'title' => esc_html__('عنوان در حال انجام', 'prk'),
        //     'default' => 'آماده‌سازی سفارش',
        //     'dependency' => array('prk_order_tracker', '==', 'true'),
        // ),
        // array(
        //     'id' => 'des_ordertrack_set4',
        //     'type' => 'text',
        //     'title' => esc_html__('عنوان ارسال شده', 'prk'),
        //     'default' => 'خروج از مرکز پردازش',
        //     'dependency' => array('prk_order_tracker', '==', 'true'),
        // ),
        // array(
        //     'id' => 'des_ordertrack_set5',
        //     'type' => 'text',
        //     'title' => esc_html__('عنوان تکمیل شده', 'prk'),
        //     'default' => 'تحویل شده به مشتری',
        //     'dependency' => array('prk_order_tracker', '==', 'true'),
        // ),
    )
));

#my ordertracker Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('سفارش رها شده', 'prk'),
    'id' => 'prk_reminder_order_options',
    'icon' => 'ri-shopping-cart-line',
    'fields' => array(

        array(
            'id' => 'prk_reminder_order_enabe',
            'type' => 'switcher',
            'title' => 'فعال سازی  یاداوری پیامکی سفارش رها شده',
            'title' => 'فعال سازی یاداوری پیامکی سفارش که پرداخت نشده',
            'text_width' => 80,
            'default' => true
        ),

        
        array(
        'id'      => 'prk_reminder_order_send',
        'type'    => 'slider',
        'title'   => 'ساعت ارسال پیامک',
        'subtitle'   => 'مثلاً اگر ۳ وارد کنید، فقط سفارشاتی که بیش از ۳ ساعت رها شده‌اند پیامک دریافت می‌کنند.',
        'default' => 4,
        'dependency' => array(
                array('prk_reminder_order_enabe', '==', 'true'),
        ),
        ),


        array(
            'id' => 'prk_reminder_order_discont_enabe',
            'type' => 'switcher',
            'title' => 'تعیین کد تخفیف',
            'text_width' => 80,
            'default' => true,
            'dependency' => array(
                array('prk_reminder_order_enabe', '==', 'true'),
            ),
        ),

       array(
        'id'         => 'prk_reminder_order_discont_choose',
        'type'       => 'button_set',
        'title'      => 'نوع تخفیف کد «یادآوری سفارش پرداخت‌نشده»',
        'options'    => array(
            'discount_fix'   => 'کد تخفیف ثابت',
            'discount_smart' => 'درصدی',
        ),
        'dependency' => array(
            array('prk_reminder_order_discont_enabe', '==', 'true'),
            array('prk_reminder_order_enabe', '==', 'true'),
        ),
        'default'    => 'discount_smart',
        'text_width' => 200,
        ),

        array(
        'id'         => 'prk_reminder_order_discont_fix',
        'type'       => 'text',
        'title'      => 'کد کوپن',
        'subtitle'   => 'نام/کد کوپن ثابت برای سفارش‌های پرداخت‌نشده (مثل PRK2024). مقدار و نوع تخفیف این کوپن را در خود کوپن تعریف کنید.',
        'text_width' => 300,
        'dependency' => array(
            array('prk_reminder_order_enabe', '==', 'true'),
            array('prk_reminder_order_discont_enabe', '==', 'true'),
            array('prk_reminder_order_discont_choose', '==', 'discount_fix'),
        ),
        ),

        array(
        'id'          => 'prk_reminder_order_discont',
        'type'        => 'select',
        'title'       => 'نوع محاسبه مقدار تخفیف (برای حالت درصدی/خودکار',
        'placeholder' => 'پیش‌فرض: درصدی',
        'options'     => array(
            'percent'       => 'درصدی',
            'fixed_cart'    => 'مبلغ ثابت روی سبد',
            'fixed_product' => 'مبلغ ثابت روی هر محصول',
        ),
        'dependency'  => array(
            array('prk_reminder_order_enabe', '==', 'true'),
            array('prk_reminder_order_discont_enabe', '==', 'true'),
            array('prk_reminder_order_discont_choose', '==', 'discount_smart'),
        ),
        'default'     => 'percent',
        ),

        array(
        'id'          => 'prk_reminder_order_discont_smart',
        'type'        => 'number',
        'title'       => 'مقدار تخفیف',
        'subtitle'    => 'اگر «درصدی» انتخاب شده: عددی بین ۱ تا ۱۰۰ وارد کنید. اگر «مبلغ ثابت» انتخاب شده: مبلغ را به تومان وارد کنید (مثلاً 20000).',
        'placeholder' => esc_html__('مثلاً: درصدی=10  |  مبلغ ثابت=20000', 'prk'),
        'text_width'  => 500,
        'default'     => 10,
        'attributes'  => array(
            'min'  => 1,
            'step' => 1,
        ),
        'dependency'  => array(
            array('prk_reminder_order_enabe', '==', 'true'),
            array('prk_reminder_order_discont_enabe', '==', 'true'),
            array('prk_reminder_order_discont_choose', '==', 'discount_smart'),
        ),
        ),


       array(
        'id'      => 'prk_reminder_order_discont_smart_min',
        'type'    => 'number',
        'title'   => 'حداقل مبلغ خرید',
        'subtitle'   => ' حداقل مقدار خرید جهت اعمال کد تخفیف (خالی گذاشتن به معنای بدون محدودیت است)',
        'text_width' => 500,
         'dependency' => array(
                array('prk_reminder_order_enabe', '==', 'true'),
                array('prk_reminder_order_discont_enabe', '==', 'true'),
                array('prk_reminder_order_discont_choose', '==', 'discount_smart')
            ),
        ),


        array(
        'id'      => 'prk_reminder_order_discont_smart_max',
        'type'    => 'number',
        'title'   => 'حداثکر مبلغ خرید',
        'text_width' => 500,
        'subtitle'   => ' حداکثر مقدار خرید جهت اعمال کد تخفیف (خالی گذاشتن به معنای بدون محدودیت است)',
         'dependency' => array(
                array('prk_reminder_order_enabe', '==', 'true'),
                array('prk_reminder_order_discont_enabe', '==', 'true'),
                array('prk_reminder_order_discont_choose', '==', 'discount_smart')
            ),
        ),

        array(
        'id'      => 'prk_reminder_order_exclude_sale_items',
        'type'    => 'checkbox',
        'title'   => 'به‌جز محصولات فروش ویژه',
        'subtitle'   => 'کد تخفیف فقط برای محصولات که تخفیف خورده نیستن اعمال شود؟',
        'label'   => 'فعال کن',
         'dependency' => array(
                array('prk_reminder_order_enabe', '==', 'true'),
                array('prk_reminder_order_discont_enabe', '==', 'true'),
                array('prk_reminder_order_discont_choose', '==', 'discount_smart'),
        ),
        'default' => true // or false
        ),

        array(
        'id'      => 'prk_reminder_order_limit',
        'type'    => 'number',
        'title'   => 'انقضا و حذف اتوماتیک کد تخفیف',
        'subtitle'   => ' تعیین کنید که کد تخفیف چند روز اعتبار دارد | مقدار روز به عدد تعیین کنید مثلا 2 (کد تخفیف ساخته بعد از انقضای تاریخ بصورت اتوماتیک حذف خواهد شد)',
        'placeholder' => esc_html__('مثلا 2 روز', 'prk'),
        'default' => 2,
            'dependency' => array(
                array('prk_reminder_order_enabe', '==', 'true'),
                array('prk_reminder_order_discont_enabe', '==', 'true'),
                array('prk_reminder_order_discont_choose', '==', 'discount_smart'),
            ),
        ),
        // A Notice
        array(
        'type'    => 'notice',
        'style'   => 'info',
        'content' => '<a id="reminder_order_set" class="" href="'.$PRKSMSApp_url.'#remrderPattern"  target="_blank">تنظیم الگوی پترن پیامک</a>',
        'dependency' => array('prk_reminder_order_enabe', '==', 'true'),
            
        ),

    )
));

#checkout Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('تبلیغات فروشگاه', 'prk'),
    'id' => 'purchase_heading',
    'icon' => 'ri-shopping-bag-3-line',
    'fields' => array(

        // A Heading
        array(
            'type'    => 'heading',
            'style'   => 'success',
            'content' => 'نوتیفیکشن فیک خریدار محصول از سایت',
        ),

        array(
            'id' => 'fake_purchase',
            'type' => 'switcher',
            'title' => 'فعال سازی',
            'text_width' => 80,
            'default' => true
        ),
        array(
            'id' => 'fake_purchase_show_mobile',
            'type' => 'switcher',
            'title' => 'نمایش در دیوایس موبایل و تبلت',
            'subtitle' => 'پیشنهاد میشود این المان تنها در pc نمایش داده شود.',
            'text_width' => 80,
            'default' => false
        ),
        array(
            'id'        => 'fake_purchase_ct',
            'type'      => 'group',
            'title'     => 'لیست فیک خریداران محصول از سایت',
            'fields'    => array(
              array(
                'id'    => 'name',
                'type'  => 'text',
                'title' => 'عنوان خریدار',
              ),
              array(
                'id'    => 'pro_name',
                'type'  => 'text',
                'title' => 'عنوان محصول',
              ),
              array(
                'id' => 'img_url',
                'type' => 'media',
                'operator' => 'and',
                'title' => esc_html__('تصویر محصول', 'prk'),
            ),
            array(
                'id'    => 'pro_href',
                'type'  => 'text',
                'title' => 'لینک محصول',
              ),
              array(
                'id'    => 'day',
                'type'  => 'text',
                'title' => 'تاریخ خرید',
                'subtitle' => 'مثلا 5 ساعت پیش ، تنها رقم تاریخ را بنویسید',
              ),
              array(
                'id'    => 'Verified_text',
                'type'  => 'text',
                'title' => 'متن تایید شد',
                'default' => 'تایید شده',
              ),
            ),
            // 'default'   => array(
            //   array(
            //     'opt-text'     => 'This is text default 1',
            //     'opt-color'    => '#ffbc00',
            //     'opt-switcher' => true,
            //   ),
            //   array(
            //     'opt-text'     => 'This is text default 2',
            //     'opt-color'    => '#000',
            //     'opt-switcher' => false,
            //   ),
            // ),
        ),
        array(
            'id'         => 'fake_purchase_posi',
            'type'       => 'button_set',
            'title'      => 'جهت المان',
            'dependency' => array('fake_purchase', '==', 'true'),
            'options'    => array(
              'tip-right'  => 'راست',
              'tip-left' => 'چپ',
            ),
            'default'    => 'tip-right'
          ),

          array(
            'id'      => 'fake_purchase_cocke',
            'type'    => 'slider',
            'title'   => 'تعداد ساعت نمایش در روز',
            'subtitle'   => 'بطور مثال اگر عدد 3 را انتخاب کردید، پاپ خریداران در لود اول تنها یک بار نمایش داده میشود و بعد از 3 ساعت نیز یک بار نمایش داده میشود!',
            'min'     => 1,
            'max'     => 24,
            'step'    => 1,
            'default' => 12,
          ),
    )
  ));

#faq Settings prk
CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی صفحه پرسش متداول', 'prk'),
    'id' => 'ask_general_settings',
    'icon' => 'ri-chat-quote-line',
    'fields' => array(

        // array(
        //     'id' => 'title_frequently_asked_questions',
        //     'type' => 'switcher',
        //     'text_width' => 80,
        //     'title' => esc_html__('فعال سازی', 'prk'),
        //     'subtitle' => esc_html__('فعال سازی و نمایش  صفحه پ', 'prk'),
        //     'default' => true,
        // ),
        array(
            'id' => 'prk_faq_ajax_add',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('بارگذاری آجاکسی صفحه', 'prk'),
            'subtitle' => esc_html__('صفحات پرسش متداول بصورت آجاکسی (بدون رفرش) بارگذاری میشوند.', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'prk_search_ajax_box',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('جستجو', 'prk'),
            'subtitle' => esc_html__('فعال سازی باکس جستجوی پرسش.', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'title_faq_cat_box',
            'type' => 'text',
            'title' => esc_html__('عنوان جستجوی پرسش ها', 'prk'),
            'default' => 'موضوع پرسش شما چیست؟',
        ),
        array(
            'id' => 'subtitle_faq_cat_box',
            'type' => 'text',
            'title' => esc_html__('زیر عنوان جستجوی پرسش ها', 'prk'),
            'default' => 'موضوع موردنظرتان را جستجو کرده یا از دسته‌بندی زیر انتخاب کنید',
        ),
        array(
            'id' => 'placeholder_search_faq_cat_box',
            'type' => 'text',
            'title' => esc_html__('متن جانگه دار جستجوی پرسش ها', 'prk'),
            'default' => 'جستجوی موضوع',
        ),
        array(
          'id'                              => 'gradient_faq_color',
          'type'                            => 'background',
          'title'                           => 'پس زمینه سفارشی بخش جستجوی پرسش',
          'background_gradient'             => true,
          'background_origin'               => true,
          'background_image'               => true,
          'background_clip'                 => true,
          'background_blend_mode'           => true,
          'output_important' => 'true',
          'output' => array('background' => 'body .ask_top_page'),
        ),
        array(
            'id' => 'faq_cats',
            'type' => 'group',
            'title' => 'دسته بندی پرسش متداول',
            'subtitle' => esc_html__('در مرحله اول میبایستی : از بخش -> پرسش های متداول -> دسته های مورد نیاز خود را اضافه و در این قسمت تایین میکنید که کدام یک از آن ها نمایش داده شوند.', 'your-textdomain-here'),
            'fields' => array(
                array(
                  'id'          => 'faq_category',
                  'type'        => 'select',
                  'title' => esc_html__('دسته بندی ها', 'prk'),
                  'placeholder' => esc_html__('انتخاب دسته مورد نظر', 'prk'),
                  'chosen'      => true,
                  'options'     => 'categories',
                  'query_args'  => array(
                    'taxonomy'  => 'faq_cat'
                  )
                ),

            ),

        ),

        array(
            'id' => 'title_frequently_asked_questions',
            'type' => 'text',
            'title' => esc_html__('عنوان بخش پرسش های پر تکرار', 'prk'),
            'default' => 'پرتکرارترین پرسش‌ها',
        ),

        // Select with AJAX search CPT (custom post type) Posts
        array(
          'id'          => 'frequently_asked_questions',
          'type'        => 'select',
          'multiple'    => true,
          'title'       => 'پر تکرارترین پرسش ها',
          'subtitle' => esc_html__('این سوالات در تمام صفحات تکرار میشود.'),
          'placeholder' => 'انتخاب کنید',
          'chosen'      => true,
          'ajax'        => true,
          'options'     => 'posts',
          'query_args'  => array(
            'post_type' => 'prkfaq'
          )
        ),

    )
));


// archive-post Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی نوشته ها', 'prk'),
    'id' => 'post_settings',
    'icon' => 'ri-booklet-line',
));

// post-archive Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('آرشیو نوشته ها', 'prk'),
    'id' => 'post_archive',
    'parent' => 'post_settings', // The slug id of the parent section
    'fields' => array(
      array(
          'id' => 'custom_post_thumb',
          'type' => 'switcher',
          'text_width' => 80,
          'title' => esc_html__('اندازه سفارشی برای تصاویر بندانگشتی نوشته ها', 'prk'),
          'subtitle' => esc_html__('نیاز به بازسازی تصاویر بندانگشتی توسط افزونه (regenerate thumbnails) می باشد', 'prk'),
          'default' => false,
      ),
      array(
          'id' => 'post_thumb_width',
          'type' => 'text',
          'text_width' => 80,
          'title' => esc_html__('پهنا', 'prk'),
          'default' => '300',
          'dependency' => array('custom_post_thumb', '==', 'true'),

      ),
      array(
          'id' => 'post_thumb_height',
          'type' => 'text',
          'text_width' => 80,
          'title' => esc_html__('ارتفاع', 'prk'),
          'default' => '300',
          'dependency' => array('custom_post_thumb', '==', 'true'),
      ),
        array(
            'id' => 'post_archive_name',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('عنوان برگه دسته بندی', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش برگه عنوان دسته بندی', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'post_archive_bio',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('توضیحات برگه دسته بندی', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش توضیحات برگه دسته بندی', 'prk'),
            'default' => true,
        ),

        array(
            'id'         => 'archive_post_subcategories_order',
            'type'       => 'button_set',
            'title'      => 'جایگاه نمایش دسته بندی',
            'options'    => array(
              'top_page'  => 'بالای صفحه',
              'down_page' => 'پایین صفحه',
            ),
            'default'    => 'top_page',
            'dependency' => array('post_archive_name', '==', 'true'),
        ),

        array(
            'id'          => 'grid_column_items_post',
            'type'        => 'slider',
            'title'       => 'تعداد آیتم کارت نوشته',
            'min'     => 1,
            'max'     => 6,
            'step'    => 1,
            'default' => 4,
          ),

        array(
            'id' => 'show_cat_post',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('دسته بندی نوشته', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش دسته بندی نوشته نوشته ', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'post_archive_pcontent',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('خلاصه نوشته', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش خلاصه نوشته ', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'post_archive_author',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نویسنده', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش نویسنده', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'post_archive_show_view',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('دکمه نمایش بیشتر', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش دکمه نمابش بیشتر', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'post_archive_date',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('تاریخ', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش تاریخ نوشته', 'prk'),
            'default' => true,
        ),

        array(
            'id' => 'post_archive_time_reading',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('زمان مطالعه', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش زمان تقریبی مطالعه نوشته', 'prk'),
            'default' => true,
        ),
    )
));

#post-single Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('صفحه نوشته', 'prk'),
    'parent' => 'post_settings', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'post_single_sidebar',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش سایدبار', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'post_single_author',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نویسنده', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش نویسنده نوشته', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'post_single_tumbnail',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('تصویر شاخص', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش تصویر شاخص نوشته', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'site_post_single_tumbnail',
            'type' => 'dimensions',
            'units' => array('px','%'),
            'title' => esc_html__('اندازه ارتفاع تصویر شاخص', 'prk'),
            'desc' => esc_html__('رقم اندازه تصویر شاخص را متناسب با طراحی خود  وارد نمایید', 'prk'),
            'output' => array('body .humbnail-single img'),
        ),
        array(
            'id' => 'post_single_date',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('تاریخ', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش تاریخ نوشته', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'post_single_comment',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('تعداد دیدگاه', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش تعداد دیدگاه ثبت شده', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'post_single_time_reading',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('زمان مطالعه', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش زمان تقریبی مطالعه نوشته', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'post_single_categors',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('دسته بندی ها', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش دسته بندی های نوشته', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'post_single_tags',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('برچسب ها', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش برچسب های نوشته', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'post_single_share',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('به اشتراک گذاری', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش به اشتراک گذاری نوشته', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'post_single_read',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('حالت مطالعه', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش حالت مطالعه', 'prk'),
            'default' => true,
        ),

        // A Heading
        array(
            'type'    => 'heading',
            'content' => 'استایل بخش دیدگاه',
        ),

        array(
            'id' => 'comment_Rules',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('نمایش قوانین دیدگاه', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش حالت مطالعه', 'prk'),
            'default' => true,
        ),

        array(
            'id' => 'comment_Rules_contents',
            'type' => 'wp_editor',
            'title' => esc_html__('متن قوانین دیدگاه', 'prk'),
            'default' => '
            <ol>
                <li>دیدگاه های فینگلیش تایید نخواهند شد.</li>
                <li>دیدگاه های نامرتبط به مطلب تایید نخواهد شد.</li>
                <li>از درج دیدگاه های تکراری پرهیز نمایید.</li>
             </ol>
            ',
            'dependency' => array('comment_Rules', '==', 'true'),
        ),

        array(
            'id'      => 'border_comment_Rules',
            'type'    => 'border',
            'title'   => 'حاشیه دور دسته بندی فرزندی',
            'default' => array(
              'top'    => '1',
              'right'  => '1',
              'bottom' => '1',
              'left'   => '1',
              'style'  => 'solid',
              'color'  => 'rgba(89,214,235,.1)',
              'unit'   => 'px',
            ),
            'output_important' => 'true',
            'output' => 'body .post-comment .comment-rules',
            'dependency' => array('comment_Rules', '==', 'true'),
        ),
        array(
            'id'                              => 'background_comment_Rules',
            'type'                            => 'background',
            'title'                           => 'Background',
            'background_gradient'             => true,
            'background_origin'               => true,
            'background_clip'                 => true,
            'background_blend_mode'           => true,
            'output_important' => 'true',
            'output' => 'body .post-comment .comment-rules',
          ),
        array(
            'id'     => 'color_comment_Rules_text',
            'type'   => 'color',
            'title'  => 'رنگ متن محتوای قوانین',
            'output' => array( 'color' => 'body .post-comment .comment-rules' ),
            'dependency' => array('comment_Rules', '==', 'true'),
        ),

               // A Heading
        array(
            'type'    => 'heading',
            'content' => 'استایل بخش سایدبار نوشته',
        ),

        array(
            'id'      => 'border_sidebar_single_post',
            'type'    => 'border',
            'title'   => 'حاشیه دور ابزارک سایدبار',
            'default' => array(
                'top'    => '1',
                'right'  => '1',
                'bottom' => '1',
                'left'   => '1',
                'style'  => 'solid',
                'color'  => '#e4e4e4',
                'unit'   => 'px',
            ),
            'output_important' => 'true',
            'output' => 'body.single-post .side-box-post',
        ),
        array(
            'id'          => 'border_radius_single_post',
            'type'        => 'number',
            'title'       => 'انحنای مرز ابزارک سایدبار',
            'unit'        => 'px',
            'output'      => 'body.single-post .side-box-post',
            'output_mode' => 'border-radius',
            'output_important' => 'true',
            'default'     => 11,
        ),
        array(
            'id'     => 'bcolor_sidebar_single_post',
            'type'   => 'color',
            'title'  => 'رنگ پس زمینه ابزارک سایدبار',
            'output' => array( 'background-color' => 'body.single-post .side-box-post' )
        ),

        array(
            'id'    => 'title_sidebar_single_post',
            'type'  => 'typography',
            'title' => 'عنوان ابزارک سایدبار',
            'output_important' => 'true',
            'output'  => 'body.side-title-post .side-title-post',
        ),

        
    )
));


#services Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی سرویس ها', 'prk'),
    'id' => 'services_settings_general',
    'icon' => 'ri-profile-line',
));


CSF::createSection($prefix, array(
    'title' => esc_html__('سرویس های سایت', 'prk'),
    'id' => 'services_settings',
    'icon' => 'ri-customer-service-2-line',
    'parent' => 'services_settings_general', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'services_1',
            'type' => 'text',
            'title' => esc_html__('خدمات ۱', 'prk'),
            'subtitle' => esc_html__('عنوان خدمات ۱', 'prk'),
            'default' => 'تحویل اکسپرس',
        ),
        array(
            'id' => 'subservices_1',
            'type' => 'text',
            'title' => esc_html__('زیرعنوان خدمات ۱', 'prk'),
        ),
        array(
            'id' => 'services_1_url',
            'type' => 'text',
            'title' => esc_html__('خدمات ۱', 'prk'),
            'subtitle' => esc_html__('لینک خدمات ۱', 'prk'),
            'default' => '#',
        ),
        array(
            'id' => 'services_1_pic',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر خدمات ۱', 'prk'),
        ),

        array(
            'id' => 'services_2',
            'type' => 'text',
            'title' => esc_html__('خدمات ۲', 'prk'),
            'subtitle' => esc_html__('عنوان خدمات ۲', 'prk'),
            'default' => 'پشتیبانی ۲۴ ساعته',
        ),
        array(
            'id' => 'subservices_2',
            'type' => 'text',
            'title' => esc_html__('زیرعنوان خدمات 2', 'prk'),
        ),
        array(
            'id' => 'services_2_url',
            'type' => 'text',
            'title' => esc_html__('لینک خدمات ۲', 'prk'),
            'subtitle' => esc_html__('لینک خدمات ۱', 'prk'),
            'default' => '#',
        ),
        array(
            'id' => 'services_2_pic',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر خدمات ۲', 'prk'),
        ),

        array(
            'id' => 'services_3',
            'type' => 'text',
            'title' => esc_html__('خدمات ۳', 'prk'),
            'subtitle' => esc_html__('عنوان خدمات ۲', 'prk'),
            'default' => 'پرداخت در محل',
        ),
        array(
            'id' => 'subservices_3',
            'type' => 'text',
            'title' => esc_html__('زیرعنوان خدمات 3', 'prk'),
        ),
        array(
            'id' => 'services_3_url',
            'type' => 'text',
            'title' => esc_html__('لینک خدمات ۳', 'prk'),
            'subtitle' => esc_html__('لینک خدمات ۱', 'prk'),
            'default' => '#',
        ),
        array(
            'id' => 'services_3_pic',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر خدمات ۳', 'prk'),
        ),

        array(
            'id' => 'services_4',
            'type' => 'text',
            'title' => esc_html__('خدمات ۴', 'prk'),
            'subtitle' => esc_html__('عنوان خدمات ۲', 'prk'),
            'default' => '۷ روز ضمانت بازگشت کالا',
        ),
        array(
            'id' => 'subservices_4',
            'type' => 'text',
            'title' => esc_html__('زیرعنوان خدمات 4', 'prk'),
        ),
        array(
            'id' => 'services_4_url',
            'type' => 'text',
            'title' => esc_html__('لینک خدمات ۴', 'prk'),
            'subtitle' => esc_html__('لینک خدمات ۱', 'prk'),
            'default' => '#',
        ),
        array(
            'id' => 'services_4_pic',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر خدمات ۴', 'prk'),
        ),

        array(
            'id' => 'services_5',
            'type' => 'text',
            'title' => esc_html__('خدمات ۵', 'prk'),
            'subtitle' => esc_html__('عنوان خدمات ۵', 'prk'),
            'default' => 'ضمانت اصل بودن کالا',
        ),
        array(
            'id' => 'subservices_5',
            'type' => 'text',
            'title' => esc_html__('زیرعنوان خدمات 5', 'prk'),
        ),
        array(
            'id' => 'services_5_url',
            'type' => 'text',
            'title' => esc_html__('لینک خدمات ۵', 'prk'),
            'subtitle' => esc_html__('لینک خدمات ۵', 'prk'),
            'default' => '#',
        ),
        array(
            'id' => 'services_5_pic',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر خدمات ۵', 'prk'),
        ),
    )
));

CSF::createSection($prefix, array(
    'title' => esc_html__('سرویس های صفحه محصول', 'prk'),
    'id' => 'services_singles',
    'parent' => 'services_settings_general', // The slug id of the parent section
    'icon' => 'ri-service-line',
    'fields' => array(
        array(
            'id' => 'services_sngl_1',
            'type' => 'text',
            'title' => esc_html__('خدمات ۱', 'prk'),
            'subtitle' => esc_html__('عنوان خدمات ۱', 'prk'),
            'default' => 'تحویل اکسپرس',
        ),
        array(
            'id' => 'subservices_1',
            'type' => 'text',
            'title' => esc_html__('زیرعنوان خدمات ۱', 'prk'),
        ),
        array(
            'id' => 'services_sngl_1_url',
            'type' => 'text',
            'title' => esc_html__('خدمات ۱', 'prk'),
            'subtitle' => esc_html__('لینک خدمات ۱', 'prk'),
            'default' => '#',
        ),
        array(
            'id' => 'services_sngl_1_pic',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر خدمات ۱', 'prk'),
        ),

        array(
            'id' => 'services_sngl_2',
            'type' => 'text',
            'title' => esc_html__('خدمات ۲', 'prk'),
            'subtitle' => esc_html__('عنوان خدمات ۲', 'prk'),
            'default' => 'پشتیبانی ۲۴ ساعته',
        ),
        array(
            'id' => 'subservices_2',
            'type' => 'text',
            'title' => esc_html__('زیرعنوان خدمات 2', 'prk'),
        ),
        array(
            'id' => 'services_sngl_2_url',
            'type' => 'text',
            'title' => esc_html__('لینک خدمات ۲', 'prk'),
            'subtitle' => esc_html__('لینک خدمات ۱', 'prk'),
            'default' => '#',
        ),
        array(
            'id' => 'services_sngl_2_pic',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر خدمات ۲', 'prk'),
        ),

        array(
            'id' => 'services_sngl_3',
            'type' => 'text',
            'title' => esc_html__('خدمات ۳', 'prk'),
            'subtitle' => esc_html__('عنوان خدمات ۲', 'prk'),
            'default' => 'پرداخت در محل',
        ),
        array(
            'id' => 'subservices_3',
            'type' => 'text',
            'title' => esc_html__('زیرعنوان خدمات 3', 'prk'),
        ),
        array(
            'id' => 'services_sngl_3_url',
            'type' => 'text',
            'title' => esc_html__('لینک خدمات ۳', 'prk'),
            'subtitle' => esc_html__('لینک خدمات ۱', 'prk'),
            'default' => '#',
        ),
        array(
            'id' => 'services_sngl_3_pic',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر خدمات ۳', 'prk'),
        ),

        array(
            'id' => 'services_sngl_4',
            'type' => 'text',
            'title' => esc_html__('خدمات ۴', 'prk'),
            'subtitle' => esc_html__('عنوان خدمات ۲', 'prk'),
            'default' => '۷ روز ضمانت بازگشت کالا',
        ),
        array(
            'id' => 'subservices_4',
            'type' => 'text',
            'title' => esc_html__('زیرعنوان خدمات 4', 'prk'),
        ),
        array(
            'id' => 'services_sngl_4_url',
            'type' => 'text',
            'title' => esc_html__('لینک خدمات ۴', 'prk'),
            'subtitle' => esc_html__('لینک خدمات ۱', 'prk'),
            'default' => '#',
        ),
        array(
            'id' => 'services_sngl_4_pic',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر خدمات ۴', 'prk'),
        ),

        array(
            'id' => 'services_sngl_5',
            'type' => 'text',
            'title' => esc_html__('خدمات ۵', 'prk'),
            'subtitle' => esc_html__('عنوان خدمات ۵', 'prk'),
            'default' => 'ضمانت اصل بودن کالا',
        ),
        array(
            'id' => 'subservices_5',
            'type' => 'text',
            'title' => esc_html__('زیرعنوان خدمات 5', 'prk'),
        ),
        array(
            'id' => 'services_sngl_5_url',
            'type' => 'text',
            'title' => esc_html__('لینک خدمات ۵', 'prk'),
            'subtitle' => esc_html__('لینک خدمات ۵', 'prk'),
            'default' => '#',
        ),
        array(
            'id' => 'services_sngl_5_pic',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر خدمات ۵', 'prk'),
        ),
    )
));


#services Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی دکان', 'prk'),
    'id' => 'dokan_settings_general',
    'icon' => 'ri-store-2-line',
));

if (class_exists('Dokan_Pro')){
   $dokan_desc = '';
}else{
   $dokan_desc = 'پیش نیاز فعال شدن نسخه حرفه ای داشبورد نصب بودن افزونه "دکان پرو" میباشد ، افزونه دکان پرو در سایت شما نصب نمیباشد !';
}

if ( ! class_exists('Dokan_Pro') ){
    $dokan_active_class = 'disbale_Section';
    $Dokan_Pro_active_exists =  array(
        'type'    => 'notice',
        'style'   => 'warning',
        'class' => 'not-active-dokan',
        'content' => 'افزونه دکان پرو در سایت شما نصب نمیباشد ، لطفا نسخه حرفه ای آن را در لینک ذیل تهیه کنید <a href="https://www.rtl-theme.com/dokan-pro-wordpress-plugin/" target="_blank">دریافت از راستچین</a>',
    );
}else{
    $dokan_active_class = '';
    $Dokan_Pro_active_exists =  array(
        'type'    => 'notice',
        'style'   => 'success',
        'content' => 'افزونه دکان پرو با موفقیت نصب شده است !',
    );
}

CSF::createSection($prefix, array(
    'title' => esc_html__('عمومی', 'prk'),
    'parent' => 'dokan_settings_general', // The slug id of the parent section
    'class' => $dokan_active_class,
    'fields' => array(
       
        $Dokan_Pro_active_exists,
        array(
            'id' => 'dokan_pro_active',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('فعال سازی صفحه داشبورد حرفه ای دکان', 'prk'),
            'subtitle' => esc_html__($dokan_desc , 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'title_dash_page_dokan',
            'type' => 'text',
            'title' => esc_html__('عنوان پنل فروشندگان', 'prk'),
            'default' => 'مرکز فروشندگان',
        ),
        array(
            'id' => 'dash_page_logo',
            'type' => 'media',
            'operator' => 'and',
            'width' => '200px',
            'height' => '100px',
            'title' => esc_html__('تصویر لوگوی پنل', 'prk'),
        ),

        array(
            'id' => 'message_disable_seller',
            'type' => 'wp_editor',
            'title' => esc_html__('پیام غیر فعال بودن فروشنده', 'prk'),
            'subtitle' => esc_html__('هنگامی که وضعیت حساب کاربر فروشنده غیر فعال باشد این پیام را مشاهده خواهد کرد.', 'prk'),
            'default' => 'شما در صف انتظار تایید توسط مدیر سایت هستید. پس از تایید اطلاع رسانی خواهد شد.',
        ),
        array(
            'id' => 'des_more_disable_seller',
            'type' => 'text',
            'title' => esc_html__('لینک برای توضیحات بیشتر', 'prk'),
            'subtitle' => esc_html__('در صورتی که نیاز میباشد کاربر را برای توضیحات بیشتر یا درج اطلاعات خاصی مثل آپلود مدارک راهنمایی کنید لینک صفحه را در این فیلد وارد کنید', 'prk'),
        ),
        array(
            'id' => 'des_more_disable_seller_btn',
            'type' => 'text',
            'title' => esc_html__('متن دکمه', 'prk'),
            'subtitle' => esc_html__('در صورتی که در فیلد بالا لینک درج کرده اید میتوانید برای آن متن دلخواه خود را وارد کنید.', 'prk'),
            'default' => 'اطلاعات بیشتر',
        ),
        array(
            'id' => 'dash_page_banner',
            'type' => 'media',
            'operator' => 'and',
            'width' => '200px',
            'height' => '100px',
            'title' => esc_html__('بنر پیشخوان', 'prk'),
        ),
        array(
            'id' => 'dash_page_banner_banner',
            'type' => 'text',
            'title' => esc_html__('لینک بنر پیشخوان', 'prk'),
        ),
        array(
            'id' => 'count-post-dokan-panel',
            'type' => 'text',
            'title' => esc_html__('تعداد نمایش پست ها', 'prk'),
            'default' => '4',
        ),
        // Select with CPT (custom post type) categories
        array(
          'id'          => 'cats-post-panel-dokan',
          'type'        => 'select',
          'title'       => 'دسته های پست های سایدبار',
          'placeholder' => 'انتخاب دسته',
          'options'     => 'categories',
          'query_args'  => array(
            'taxonomy'  => 'category',
          ),
        ),

        array(
            'id' => 'dash_page_logo_foot',
            'type' => 'media',
            'operator' => 'and',
            'width' => '200px',
            'height' => '100px',
            'title' => esc_html__('تصویر لوگوی فوتر', 'prk'),
        ),
        array(
            'id' => 'menu-items-footer-panel-dokan',
            'type' => 'group',
            'title' => 'آیتم های فوتر پنل',
            'fields' => array(
                array(
                    'id' => 'title',
                    'type' => 'text',
                    'title' => 'عنوان',
                ),
                array(
                    'id' => 'url',
                    'type' => 'text',
                    'title' => 'لینک',
                    'default' => '',
                ),
                array(
                    'id' => 'icon',
                    'type' => 'text',
                    'title' => 'ایکن',
                ),
            ),
            'default' => array(
                array(
                    'title' => 'ارتباط با مرکز فروشندگان پارس کالا',
                    'url' => 'https://www.rtl-theme.com/parskala-wordpress-theme/',
                ),
                array(
                    'title' => '021000000',
                    'url' => 'tel:021000000',
                    'icon' => 'ri-phone-line',
                ),
                array(
                    'title' => 'تماس با پشتیبانی فروشندگان',
                    'url' => 'https://www.rtl-theme.com/parskala-wordpress-theme/',
                ),
            ),
        ),
        array(
            'id' => 'copyright-en-panel-dokan',
            'type' => 'wp_editor',
            'title' => esc_html__('متن لاتین کپی رایت', 'prk'),
            'default' => 'تمامی حقوق متعلق به پارس کالا میباشد.',
        ),
        array(
            'id' => 'copyright-panel-dokan',
            'type' => 'wp_editor',
            'title' => esc_html__('متن کپی رایت', 'prk'),
            'default' => 'Copyright © 2006 - 2022 masirwp.com',
        ),
    )
));



#footer Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('فوتر', 'prk'),
    'id' => 'footer',
    'icon' => 'ri-layout-bottom-2-line',
));
#footer main
CSF::createSection($prefix, array(
    'title' => esc_html__('عمومی', 'prk'),
    'id' => 'footer_general',
    'parent' => 'footer', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'footer_type',
            'type' => 'select',
            'title' => esc_html__('نوع فوتر', 'prk'),
            'default' => 'default',
            'options' => array(
                'default' => esc_html__('پیشفرض قالب', 'prk'),
                'elementor' => esc_html__('المنتور', 'prk'),
                'disable' => esc_html__('غیرفعال', 'prk'),
            ),
            'select2' => array('allowClear' => false)
        ),

        array(
            'id' => 'footer_style_type',
            'type' => 'image_select',
            'class' => 'footer_style_type',
            'title' => esc_html__('استایل فوتر', 'prk'),
            'default' => 'default',
            'options'   => array(
                'default'   => get_template_directory_uri().'/assets/img/options/footer-pars.png',
                'mobit'   => get_template_directory_uri().'/assets/img/options/footer-mobit.png',
              ),
            'select2' => array('allowClear' => false),
            'dependency' => array('footer_type', '==', 'default'),
        ),
        array(
            'id' => 'footer_services_mobit',
            'type' => 'group',
            'title' => 'سرویس های فوتر',
            'dependency' => array(
                array('footer_type', '==', 'default'),
                array('footer_style_type', '==', 'mobit'),
            ),
            'fields' => array(
                array(
                    'id' => 'title',
                    'type' => 'text',
                    'title' => esc_html__('عنوان', 'your-textdomain-here'),
                    'placeholder' => esc_html__('عنوان سرویس', 'your-textdomain-here'),
                ),
                array(
                    'id' => 'url',
                    'type' => 'text',
                    'title' => esc_html__('لینک', 'your-textdomain-here'),
                    'default' => '#',
                ),
                array(
                    'id' => 'image',
                    'type' => 'media',
                    'operator' => 'and',
                    'title' => esc_html__('تصویر', 'your-textdomain-here'),
                ),
            ),
        ),
        array(
            'id' => 'choice_footer',
            'type' => 'select',
            'title' => esc_html__('انتخاب فوتر', 'prk'),
            'desc' => esc_html__('فوتر طراحی شده با المنتور را انتخاب کنید', 'prk'),
            'dependency' => array('footer_type', '==', 'elementor'),
            'ajax' => true,
            'options' => 'posts',
            'query_args' => array(
                'post_type' => 'footer'
            )
        ),
        array(
            'id' => 'seen_true',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('سکشن کالاهای دیده شده', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش سکشن کالاهای دیده شده', 'prk'),
            'default' => false,
            'dependency' => array('footer_type', '==', 'default'),
        ),
        array(
            'id' => 'seen_title',
            'type' => 'text',
            'title' => esc_html__('عنوان سکشن کالاهای دیده شده', 'prk'),
            'default' => 'کالاهایی که دیده ایید',
            'dependency' => array('seen_true', '==', 'true'),
        ),
        array(
            'id' => 'footer_logo',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر لوگو فوتر', 'prk'),
            'dependency' => array('footer_type', '==', 'default'),
        ),

        array(
            'id' => 'footer_tops',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('دکمه بازگشت به بالا', 'prk'),
            'subtitle' => esc_html__('فعال سازی و نمایش دکمه بازگشت به بالا', 'prk'),
            'default' => true,
            'dependency' => array('footer_type', '==', 'default'),
        ),
        array(
            'id' => 'footer_letter_prk',
            'type' => 'switcher',
            'default' => true,
            'title' => esc_html__('فعال سازی خبرنامه', 'prk'),
            'desc' => esc_html__('فعال سازی خبرنامه ایمیلی پارس کالا در فوتر', 'prk'),
            'dependency' => array('footer_type', '==', 'default'),
        ),
        array(
            'id' => 'footer_letter',
            'type' => 'text',
            'title' => esc_html__('کد کوتاه خبرنامه', 'prk'),
            'desc' => esc_html__('کد کوتاه خبرنامه یا شرت کد خبرنامه', 'prk'),
            'dependency' => array(
                array('footer_type', '==', 'default'),
                array('footer_letter_prk', '==', 'true'),
            ),
        ),
        array(
            'id' => 'footer_calls',
            'type' => 'text',
            'title' => esc_html__(' متن تماس ', 'prk'),
            'desc' => esc_html__('متن تماس فروشگاه', 'prk'),
            'default' => 'هفت روز هفته ، 24 ساعت شبانه‌روز پاسخگوی شما هستیم.',
            'dependency' => array('footer_type', '==', 'default'),
        ),
        array(
            'id' => 'tell_foot_title',
            'type' => 'text',
            'title' => esc_html__('عنوان تلفن فروشگاه ', 'prk'),
            'default' => 'شماره تماس:',
            'dependency' => array('footer_type', '==', 'default'),
        ),
        array(
            'id' => 'footer_tell',
            'type' => 'text',
            'title' => esc_html__(' تلفن فروشگاه ', 'prk'),
            'desc' => esc_html__('شماره تلفن فروشگاه', 'prk'),
            'default' => '061-535-10225',
            'dependency' => array('footer_type', '==', 'default'),
        ),
        array(
            'id' => 'footer_email',
            'type' => 'text',
            'title' => esc_html__('ایمیل فروشگاه ', 'prk'),
            'desc' => esc_html__('آدرس ایمیل فروشگاه', 'prk'),
            'default' => 'info@parskala.com',
            'dependency' => array('footer_type', '==', 'default'),
        ),
        array(
            'id' => 'footer_copyright',
            'type' => 'text',
            'title' => esc_html__(' کپی‌رایت', 'prk'),
            'desc' => esc_html__('متن کپی رایت فروشگاه', 'prk'),
            'default' => 'استفاده از مطالب
             اینترنتی پارس کالا فقط برای مقاصد غیرتجاری و با ذکر منبع بلامانع است. کلیه حقوق این سایت متعلق به پارس کالا می‌باشد',
            'dependency' => array('footer_type', '==', 'default'),
        ),
        array(
            'id' => 'footer_copyright_latin',
            'type' => 'text',
            'title' => esc_html__(' کپی‌رایت لاتین', 'prk'),
            'desc' => esc_html__('متن لاتین کپی رایت فروشگاه', 'prk'),
            'default' => 'Copyright © 2006 - 2018 masirwp.com',
            'dependency' => array('footer_type', '==', 'default'),
        ),
    )
));
#footer application
CSF::createSection($prefix, array(
    'title' => esc_html__('باکس اپلیکیشن', 'prk'),
    'id' => 'footer_application',
    'parent' => 'footer', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'application_true',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('باکس دانلود اپلیکیشن', 'prk'),
            'subtitle' => esc_html__('فعال سازی باکس دانلود اپلیکیشن', 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'application_true_bg_backcolor',
            'type' => 'color',
            'title' => esc_html__('رنگ پس زمینه باکس', 'prk'),
            'transparent' => false,
            'output' => array('background' => 'body .foot-dn-app .dn-box'),
            'dependency' => array('application_true', '==', 'true'),
            'output_important' => 'true',
        ),
        array(
            'id' => 'application_true_color',
            'type' => 'color',
            'title' => esc_html__('رنگ متن دانلود', 'prk'),
            'transparent' => false,
            'output' => array('color' => 'body .main-footer.mobit .dn-box .dn-link span'),
            'output_important' => 'true',
            'dependency' => array('application_true', '==', 'true'),
        ),
        array(
            'id' => 'application_logo',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('تصویر لوگو اپلیکیشن', 'prk'),
            'dependency' => array('application_true', '==', 'true'),
        ),
        array(
            'id' => 'application_name',
            'type' => 'text',
            'title' => esc_html__('متن دانلود اپلیکشن', 'prk'),
            'desc' => esc_html__('متن نمایشی دانلود اپلیکیشن', 'prk'),
            'default' => 'دانلود اپلیکیشن پارس کالا',
            'dependency' => array('application_true', '==', 'true'),
        ),
        array(
            'id' => 'application_url',
            'type' => 'text',
            'title' => esc_html__('لینک متن', 'prk'),
            'desc' => esc_html__('لینک متن دانلود اپلیکیشن', 'prk'),
            'default' => '#',
            'dependency' => array('application_true', '==', 'true'),
        ),
        array(
            'id' => 'application_pic1',
            'type' => 'media',
            'title' => esc_html__('تصویر اپلیکیشن ۱ ', 'prk'),
            'default'  => array( 'url' => get_template_directory_uri()."/assets/img/dn-app1.svg" ),
            'dependency' => array('application_true', '==', 'true'),
        ),
        array(
            'id' => 'application_url1',
            'type' => 'text',
            'title' => esc_html__('لینک اپلیکیشن ۱', 'prk'),
            'desc' => esc_html__('لینک اپلیکیشن ۱', 'prk'),
            'default' => '#',
            'dependency' => array('application_true', '==', 'true'),
        ),

        array(
            'id' => 'application_pic2',
            'type' => 'media',
            'default'  => array( 'url' => get_template_directory_uri()."/assets/img/dn-app2.svg" ),
            'title' => esc_html__('تصویر اپلیکیشن ۲', 'prk'),
            'dependency' => array('application_true', '==', 'true'),
        ),
        array(
            'id' => 'application_url2',
            'type' => 'text',
            'title' => esc_html__('لینک اپلیکیشن ۲', 'prk'),
            'desc' => esc_html__('لینک اپلیکیشن ۲', 'prk'),
            'default' => '#',
            'dependency' => array('application_true', '==', 'true'),
        ),

        array(
            'id' => 'application_pic3',
            'type' => 'media',
            'default'  => array( 'url' => get_template_directory_uri()."/assets/img/dn-app3.png" ),
            'title' => esc_html__('تصویر اپلیکیشن ۳', 'prk'),
            'dependency' => array('application_true', '==', 'true'),
        ),
        array(
            'id' => 'application_url3',
            'type' => 'text',
            'title' => esc_html__('لینک اپلیکیشن ۳', 'prk'),
            'desc' => esc_html__('لینک اپلیکیشن ۳', 'prk'),
            'default' => '#',
            'dependency' => array('application_true', '==', 'true'),
        ),

        array(
            'id' => 'application_pic4',
            'type' => 'media',
            'default'  => array( 'url' => get_template_directory_uri()."/assets/img/dn-app4.svg" ),
            'title' => esc_html__('تصویر اپلیکیشن ۴', 'prk'),
            'dependency' => array('application_true', '==', 'true'),
        ),
        array(
            'id' => 'application_url4',
            'type' => 'text',
            'title' => esc_html__('لینک اپلیکیشن ۴', 'prk'),
            'desc' => esc_html__('لینک اپلیکیشن ۴', 'prk'),
            'default' => '#',
            'dependency' => array('application_true', '==', 'true'),
        ),
        array(
            'id' => 'info_dnapp',
            'type' => 'text',
            'title' => esc_html__('عنوان زیر باکس', 'prk'),
            'default' => '',
            'dependency' => array('application_true', '==', 'true'),
        ),
        array(
            'id' => 'info_dnapp_url',
            'type' => 'text',
            'title' => esc_html__('لینک عنوان زیرباکس', 'prk'),
            'default' => '',
            'dependency' => array('application_true', '==', 'true'),
        ),
    )
));
#footer socials
CSF::createSection($prefix, array(
    'title' => esc_html__('شبکه های اجتماعی', 'prk'),
    'id' => 'footer_socials',
    'parent' => 'footer', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'socials_true',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('شبکه های اجتماعی', 'prk'),
            'subtitle' => esc_html__('فعال سازی باکس شبکه های اجتماعی', 'prk'),
            'default' => true,
        ),

        array(
            'id' => 'socials_icon1',
            'type' => 'text',
            'title' => 'فونت ایکن شبکه اجتماعی 1',
            'desc' => 'دریافت فونت ایکن از سایت .<a href="https://remixicon.com/" target="_blank">remixicon</a> یا <a href="http://parskalas.com/icon/iconpars.html" target="_blank">فونت های اختصاصی پارس کالا</a>',
            'default' => 'prk-bale',
            'dependency' => array('socials_true', '==', 'true'),
        ),
        array(
            'id' => 'socials_url1',
            'type' => 'text',
            'title' => esc_html__('لینک شبکه اجتماعی 1', 'prk'),
            'default' => '#',
            'dependency' => array('socials_true', '==', 'true'),
        ),

        array(
            'id' => 'socials_icon2',
            'type' => 'text',
            'title' => 'فونت ایکن شبکه اجتماعی ۲',
            'desc' => 'دریافت فونت ایکن از سایت .<a href="https://remixicon.com/" target="_blank">remixicon</a> یا <a href="http://parskalas.com/icon/iconpars.html" target="_blank">فونت های اختصاصی پارس کالا</a>',
            'default' => 'prk-soroush',
            'dependency' => array('socials_true', '==', 'true'),
        ),
        array(
            'id' => 'socials_url2',
            'type' => 'text',
            'title' => esc_html__('لینک شبکه اجتماعی ۲', 'prk'),
            'default' => '#',
            'dependency' => array('socials_true', '==', 'true'),
        ),

        array(
            'id' => 'socials_icon3',
            'type' => 'text',
            'title' => 'فونت ایکن شبکه اجتماعی ۳',
            'desc' => 'دریافت فونت ایکن از سایت .<a href="https://remixicon.com/" target="_blank">remixicon</a> یا <a href="http://parskalas.com/icon/iconpars.html" target="_blank">فونت های اختصاصی پارس کالا</a>',
            'default' => 'prk-eitaa',
            'dependency' => array('socials_true', '==', 'true'),
        ),
        array(
            'id' => 'socials_url3',
            'type' => 'text',
            'title' => esc_html__('لینک شبکه اجتماعی ۳', 'prk'),
            'default' => '#',
            'dependency' => array('socials_true', '==', 'true'),
        ),
        array(
            'id' => 'socials_icon4',
            'type' => 'text',
            'title' => 'فونت ایکن شبکه اجتماعی ۴',
            'desc' => 'دریافت فونت ایکن از سایت .<a href="https://remixicon.com/" target="_blank">remixicon</a> یا <a href="http://parskalas.com/icon/iconpars.html" target="_blank">فونت های اختصاصی پارس کالا</a>',
            'default' => 'prk-aparat',
            'dependency' => array('socials_true', '==', 'true'),
        ),
        array(
            'id' => 'socials_url4',
            'type' => 'text',
            'title' => esc_html__('لینک شبکه اجتماعی ۴', 'prk'),
            'default' => '#',
            'dependency' => array('socials_true', '==', 'true'),
        ),
        array(
            'id' => 'socials_icon5',
            'type' => 'text',
            'title' => 'فونت ایکن شبکه اجتماعی 5',
            'default' => 'prk-gap',
            'desc' => 'دریافت فونت ایکن از سایت .<a href="https://remixicon.com/" target="_blank">remixicon</a> یا <a href="http://parskalas.com/icon/iconpars.html" target="_blank">فونت های اختصاصی پارس کالا</a>',
            'dependency' => array('socials_true', '==', 'true'),
        ),
        array(
            'id' => 'socials_url5',
            'type' => 'text',
            'title' => esc_html__('لینک شبکه اجتماعی 5', 'prk'),
            'default' => '#',
            'dependency' => array('socials_true', '==', 'true'),
        ),
        array(
            'id' => 'socials_icon6',
            'type' => 'text',
            'title' => 'فونت ایکن شبکه اجتماعی 6',
            'default' => 'prk-rubika',
            'desc' => 'دریافت فونت ایکن از سایت .<a href="https://remixicon.com/" target="_blank">remixicon</a> یا <a href="http://parskalas.com/icon/iconpars.html" target="_blank">فونت های اختصاصی پارس کالا</a>',
            'dependency' => array('socials_true', '==', 'true'),
        ),
        array(
            'id' => 'socials_url6',
            'type' => 'text',
            'title' => esc_html__('لینک شبکه اجتماعی 6', 'prk'),
            'dependency' => array('socials_true', '==', 'true'),
        ),

    )
));
CSF::createSection($prefix, array(
    'title' => esc_html__('درباره ما/کد نمادها', 'prk'),
    'id' => 'product_seen',
    'parent' => 'footer', // The slug id of the parent section
    'fields' => array(
        array(
            'id' => 'about_true',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('فعال سازی', 'prk'),
            'subtitle' => esc_html__('فعال سازی بخش درباره ما', 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'about_title',
            'type' => 'text',
            'operator' => 'and',
            'title' => esc_html__('عنوان', 'prk'),
            'dependency' => array('about_true', '==', 'true'),
        ),
        array(
            'id' => 'about_des',
            'type' => 'textarea',
            'operator' => 'and',
            'sanitize' => false,
            'title' => esc_html__('متن درباره ما', 'prk'),
            'dependency' => array('about_true', '==', 'true'),
        ),
        array(
            'id' => 'enmad_true',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('فعال سازی', 'prk'),
            'subtitle' => esc_html__('فعال سازی بخش نماد اعتمادها', 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'enmad_group_box',
            'type' => 'group',
            'sanitize' => false,
            'title' => 'تعریف کد اینماد',
            'dependency' => array('enmad_true', '==', 'true'),
            'fields' => array(
                array(
                    'id' => 'enmad_code',
                    'type' => 'code_editor',
                    'title' => 'Code Editor without sanitize',
                    'sanitize' => false,
                    'height' => '80px',
                    'title' => esc_html__('کد اینماد یا سایر کدها', 'prk'),
                    'subtitle' => esc_html__('کد دریافت شده رو مستقیما در این بخش درج کنید', 'prk'),
                ),
            ),
        ),

    )


));

#Navigation Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی ناوبری', 'prk'),
    'id' => 'Navigation',
    'icon' => 'ri-smartphone-line'
));
#Navigation supports
CSF::createSection($prefix, array(
    'title' => esc_html__('ناوبری سوالی دارید', 'prk'),
    'id' => 'Navigation_supports',
    'parent' => 'Navigation',
    'fields' => array(
        array(
            'id' => 'supports_true',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('فعال سازی', 'prk'),
            'subtitle' => esc_html__('فعال سازی ناوبری سوالی دارید', 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'supports_arrow',
            'type' => 'select',
            'title' => esc_html__('جهت ناوبری', 'prk'),
            'subtitle' => esc_html__('انتخاب جهت ناوبری سوالی دارید', 'prk'),
            'default' => 'left',
            'options' => array(
                'left' => esc_html__('چپ', 'prk'),
                'right' => esc_html__('راست', 'prk'),
            ),
            'dependency' => array('supports_true', '==', 'true'),
        ),
        array(
            'id' => 'supports_page',
            'type' => 'select',
            'title' => esc_html__('برگه سوالی دارید', 'prk'),
            'subtitle' => esc_html__('انتخاب برگه ناوبری سوالی دارید', 'prk'),
            'options' => $pages,
            'dependency' => array('supports_true', '==', 'true'),
        ),
        array(
            'id' => 'supports_text',
            'type' => 'text',
            'title' => esc_html__('متن لینک', 'prk'),
            'subtitle' => esc_html__('متن لینک ناوبری سوالی دارید', 'prk'),
            'default' => 'جواب سوالاتتون رو پیدا نکردید ؟',
            'dependency' => array('supports_true', '==', 'true'),
        ),
        array(
            'id' => 'supports_head_text',
            'type' => 'text',
            'title' => esc_html__('متن عنوان', 'prk'),
            'subtitle' => esc_html__('متن عنوان باکس سوالی دارید', 'prk'),
            'default' => 'جواب سوال‌هاتون رو می‌تونید در زیر پیدا کنید. در غیر اینصورت از ما بپرسید، ما همیشه به سوالاتتون جواب می‌دهیم.',
            'dependency' => array('supports_true', '==', 'true'),
        ),
        array(
            'id' => 'supports_ques1',
            'type' => 'text',
            'title' => esc_html__('سوال اول', 'prk'),
            'subtitle' => esc_html__('متن سوال اول', 'prk'),
            'default' => 'شرایط کسب امتیاز از طریق ثبت نظر چیست؟ ',
            'dependency' => array('supports_true', '==', 'true'),
        ),
        array(
            'id' =>"supports_answer1",
            'type' => 'text',
            'title' => esc_html__('جواب اول', 'prk'),
            'subtitle' => esc_html__('متن جواب اول', 'prk'),
            'default' => 'شما می توانید پس از دریافت سفارش، نظر خود را در رابطه با محصول خریداری شده در پارس کالا بنویسید. پس از تایید نظر شما توسط کارشناسان پارس کالا، امتیاز برای شما ثبت می‌شود.تا قبل از تایید نظر امتیاز شما در قسمت تاریخچه بخش امتیازات در صف نمایش داده میشود.',
            'dependency' => array('supports_true', '==', 'true'),
        ),

        array(
            'id' => 'supports_ques2',
            'type' => 'text',
            'title' => esc_html__('سوال دوم', 'prk'),
            'subtitle' => esc_html__('متن سوال دوم', 'prk'),
            'default' => 'چرا بایستی در حساب کاربری شماره کارت ثبت کنم؟',
            'dependency' => array('supports_true', '==', 'true'),
        ),
        array(
            'id' => 'supports_answer2',
            'type' => 'text',
            'title' => esc_html__('جواب دوم', 'prk'),
            'subtitle' => esc_html__('متن جواب دوم', 'prk'),
            'default' => 'در صورتی که از خرید خود منصرف شوید پارس کالا در کمترین زمان ممکن مبلغ را به شماره کارت شما برگشت می دهد. مهم است که شماره کارت به نام مالک حساب کاربری ثبت داشته باشید',
            'dependency' => array('supports_true', '==', 'true'),
        ),

        array(
            'id' => 'supports_ques3',
            'type' => 'text',
            'title' => esc_html__('سوال سوم', 'prk'),
            'subtitle' => esc_html__('متن سوال سوم', 'prk'),
            'default' => 'چرا بایستی در حساب کاربری آدرس ایمیل ثبت کنم؟',
            'dependency' => array('supports_true', '==', 'true'),
        ),
        array(
            'id' => 'support_answer3',
            'type' => 'text',
            'title' => esc_html__('جواب سوم', 'prk'),
            'subtitle' => esc_html__('متن جواب سوم', 'prk'),
            'default' => 'کلیه مکاتبات پارس کالا با آدرس ایمیل شما انجام می شود.',
            'dependency' => array('supports_true', '==', 'true'),
        ),

    )
));
#Navigation tabs
CSF::createSection($prefix, array(
    'title' => esc_html__('ابزارک پایین موبایل', 'prk'),
    'id' => 'Navigation_tabs',
    'parent' => 'Navigation',
    'fields' => array(
        array(
            'id' => 'tabs_true',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('فعال سازی', 'prk'),
            'subtitle' => esc_html__('فعال سازی ابزارک پایین موبایل', 'prk'),
            'default' => true,
        ),
        array(
            'id' => 'tabs_style',
            'type' => 'select',
            'title' => esc_html__('انتخاب سبک ', 'prk'),
            'subtitle' => esc_html__('انتخاب سبک نمایشی ابزارک پایین', 'prk'),
            'default' => 'navbar1',
            'options' => array(
                'navbar1' => esc_html__('سبک ۱', 'prk'),
            ),
            'dependency' => array('tabs_true', '==', 'true'),
        ),
        array(
            'id' => 'text_mob_menu1',
            'type' => 'text',
            'default' => 'خانه',
            'title' => esc_html__('عنوان اول', 'prk'),
            'dependency' => array('tabs_style', '==', 'navbar1'),
        ),
        array(
            'id' => 'icon_mob_menu1',
            'type' => 'text',
            'default' => 'prk-home-2',
            'title' => esc_html__('ایکن اول', 'prk'),
            'dependency' => array('tabs_style', '==', 'navbar1'),
            'desc' => 'دریافت فونت ایکن از سایت .<a href="https://remixicon.com/" target="_blank">remixicon</a>.',
        ),
        array(
            'id' => 'url_mob_menu1',
            'type' => 'text',
            'default' => $home,
            'title' => esc_html__('لینک اول', 'prk'),
            'dependency' => array('tabs_style', '==', 'navbar1'),
        ),
        array(
            'id' => 'text_mob_menu2',
            'type' => 'text',
            'default' => 'دسته ها',
            'title' => esc_html__('عنوان دوم', 'prk'),
            'dependency' => array('tabs_style', '==', 'navbar1'),
        ),
        array(
            'id' => 'icon_mob_menu2',
            'type' => 'text',
            'default' => 'prk-category-2',
            'title' => esc_html__('ایکن دوم', 'prk'),
            'dependency' => array('tabs_style', '==', 'navbar1'),
            'desc' => 'دریافت فونت ایکن از سایت .<a href="https://remixicon.com/" target="_blank">remixicon</a>.',
        ),
        array(
            'id' => 'url_mob_menu2',
            'type' => 'text',
            'default' => $home.'/shop/',
            'title' => esc_html__('لینک دوم', 'prk'),
            'dependency' => array('tabs_style', '==', 'navbar1'),
        ),
        array(
            'id' => 'text_mob_menu3',
            'type' => 'text',
            'default' => 'علاقه مندی ها',
            'title' => esc_html__('عنوان سوم', 'prk'),
            'dependency' => array('tabs_style', '==', 'navbar1'),
        ),
        array(
            'id' => 'icon_mob_menu3',
            'type' => 'text',
            'default' => 'prk-heart',
            'title' => esc_html__('ایکن سوم', 'prk'),
            'dependency' => array('tabs_style', '==', 'navbar1'),
            'desc' => 'دریافت فونت ایکن از سایت .<a href="https://remixicon.com/" target="_blank">remixicon</a>.',
        ),
        array(
            'id' => 'url_mob_menu3',
            'type' => 'text',
            'default' => $home.'/my-account/sit-wishlist/',
            'title' => esc_html__('لینک سوم', 'prk'),
            'dependency' => array('tabs_style', '==', 'navbar1'),
        ),
        array(
            'id' => 'text_mob_menu4',
            'type' => 'text',
            'default' => 'حساب کاربری',
            'title' => esc_html__('عنوان چهارم', 'prk'),
            'dependency' => array('tabs_style', '==', 'navbar1'),
        ),
        array(
            'id' => 'icon_mob_menu4',
            'type' => 'text',
            'default' => 'prk-user',
            'title' => esc_html__('ایکن چهارم', 'prk'),
            'dependency' => array('tabs_style', '==', 'navbar1'),
            'desc' => 'دریافت فونت ایکن از سایت .<a href="https://remixicon.com/" target="_blank">remixicon</a>.',
        ),
        array(
            'id' => 'url_mob_menu4',
            'type' => 'text',
            'default' => $home.'/my-account/',
            'title' => esc_html__('لینک چهارم', 'prk'),
            'dependency' => array('tabs_style', '==', 'navbar1'),
        ),
    )
));
CSF::createSection($prefix, array(
    'title' => esc_html__('باکس دانلود اپلیکیشن موبایل', 'prk'),
    'id' => 'mobile_apps',
    'parent' => 'Navigation',
    'fields' => array(
        array(
            'id' => 'apps_true',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('فعال سازی', 'prk'),
            'subtitle' => esc_html__('فعال سازی باکس دانلود اپلیکیشن', 'prk'),
            'default' => false,
        ),
        array(
            'id' => 'apps_text',
            'type' => 'text',
            'title' => esc_html__('متن باکس', 'prk'),
            'desc' => esc_html__('متن باکس دانلود اپلیکیشن', 'prk'),
            'default' => 'کارایی بهتر در اپلیکیشن',
            'dependency' => array('apps_true', '==', 'true'),
        ),
        array(
            'id' => 'apps_pic',
            'type' => 'media',
            'operator' => 'and',
            'title' => esc_html__('انتخاب ایکن', 'prk'),
            'dependency' => array('apps_true', '==', 'true'),
        ),
        array(
            'id' => 'apps_btn',
            'type' => 'text',
            'operator' => 'and',
            'default' => 'نصب',
            'title' => esc_html__('متن دکمه', 'prk'),
            'dependency' => array('apps_true', '==', 'true'),
        ),
        array(
            'id' => 'apps_btn_url',
            'type' => 'text',
            'title' => esc_html__('لینک دکمه', 'prk'),
            'desc' => esc_html__('لینک دکمه باکس دانلود اپلیکیشن', 'prk'),
            'default' => '#',
            'dependency' => array('apps_true', '==', 'true'),
        ),
    )
));

#Navigation tabs
CSF::createSection($prefix, array(
    'title' => esc_html__('ابزارک تماس با ما', 'prk'),
    'id' => 'Navigation_caller',
    'parent' => 'Navigation',
    'fields' => array(
        array(
            'id' => 'caller_tabs_true',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => esc_html__('فعال سازی', 'prk'),
            'subtitle' => esc_html__('فعال سازی ابزارک تماس با ما', 'prk'),
            'default' => true,
        ),

        array(
          'id'         => 'caller_tabs_posi',
          'type'       => 'button_set',
          'title'      => 'جهت دکمه',
          'dependency' => array('caller_tabs_true', '==', 'true'),
          'options'    => array(
            'left' => 'چپ',
            'right'  => 'راست',
          ),
          'default'    => 'right'
        ),
        array(
            'id' => 'caller_repaters',
            'type' => 'group',
            'title' => 'راه های ارتباطی',
            'dependency' => array('caller_tabs_true', '==', 'true'),
            'fields' => array(
                array(
                    'id' => 'caller_name',
                    'type' => 'text',
                    'title' => 'عنوان',
                ),
                array(
                    'id' => 'caller_url',
                    'type' => 'text',
                    'title' => 'لینک',
                    'default' => '#',
                ),
                array(
                    'id' => 'caller_icon',
                    'type' => 'text',
                    'title' => 'ایکن',
                    'default' => '#',
                    'desc' => 'دریافت فونت ایکن از سایت .<a href="https://remixicon.com/" target="_blank">remixicon</a>  یا : <a href="http://parskalas.com/icon/iconpars.html" target="_blank">فونت های اختصاصی پارس کالا</a>',
                ),
                array(
                    'id' => 'caller_color',
                    'type' => 'color',
                    'title' => 'رنگ',
                    'default' => '#25D366',
                ),
            ),
            'default' => array(

                array(
                    'caller_name' => 'تماس با فروشگاه',
                    'caller_url' => 'tel:09120000000',
                    'caller_icon' => 'ri-phone-line',
                    'caller_color' => '#25D366',
                ),
                array(
                    'caller_name' => 'تماس با پشتیبان فروش',
                    'caller_url' => 'tel:09120000000',
                    'caller_icon' => 'ri-smartphone-line',
                    'caller_color' => '#FFA500',
                ),
                array(
                    'caller_name' => 'ارتباط از طریق واتساپ',
                    'caller_url' => 'https://wa.me/09120000000/',
                    'caller_icon' => 'ri-whatsapp-line',
                    'caller_color' => '#25D366',
                ),
                array(
                    'caller_name' => 'ارتباط از طریق تلگرام',
                    'caller_url' => 'https://t.me/rtltheme',
                    'caller_icon' => 'ri-telegram-line',
                    'caller_color' => '#20AFDE',
                ),
                array(
                    'caller_name' => 'ارتباط از طریق اینستاگرام',
                    'caller_url' => 'https://www.instagram.com/rtltheme',
                    'caller_icon' => 'ri-instagram-line',
                    'caller_color' => '#cd3051',
                ),
            ),
        ),
    )
));

#other Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('لودر ایجکسی پارس کالا', 'prk'),
    'id' => 'prk_ajax_loader_options',
    'icon' => 'ri-loader-2-line',
    'fields' => array(
        // A Notice
        array(
            'type'    => 'notice',
            'style'   => 'warning',
            'content' => 'سیستم لود ایجکسی "لود بدون بارگذاری صفحات قالب" بصورت آزمایشی توسعه و پیاده سازی شده است !',
        ),
        array(
            'id' => 'wpjsloader_activate',
            'type' => 'switcher',
            'title' => 'فعال سازی سیسستم',
            'subtitle' => esc_html__('بعد از فعال سازی این بخش به تمامی لینک های سایت شما به صورت درخواست ایجکس از نوع GET لود می شود.', 'prk'),
            'text_width' => 80,
            'default' => false
        ),
        array(
            'id' => 'wpjsloader_exc_par_css',
            'type' => 'switcher',
            'title' => 'اعمال در حین اسکرول کاربر',
            'subtitle' => esc_html__('نکته: با فعالسازی گزینه بالا هر زمانی که کاربر صفحه را اسکرول می کند، تابع JS مربوط به اعمال لینک های به صورت ایجکسی مجددا اجرا خواهد شد ، نکته: فعالسازی این گزینه ممکن است در دستگاه های موبایل قدیمی با CPU ضعیف همانند مدل های قدیمی گوشی های اندرویدی، موجب ایجاد لگ و کندی در حین اسکرول کاربر شود.', 'prk'),
            'text_width' => 80,
            'default' => false,
            'dependency' => array('wpjsloader_activate', '==', 'true'),
        ),
        array(
            'id' => 'wpjsloader_exc_class',
            'type' => 'textarea',
            'title' => esc_html__('مستثنی کردن تگ a با ویژگی ها (Attributes)', 'prk'),
            'desc'  => 'نکته: تمامی تگ های a را با ویژگی های تعریف شده توسط شما نادیده می گیرد نکته: اگر می خواهید یک تگ a را با استفاده از مقدار آیدی (id) آن مستثنی کنید از همین بخش استفاده کنید',
            'placeholder'  =>__('هر ویژگی را توسط نشانه `|` از یکدیگر جدا کنید. مثال: data-svg|id=&quot;wd-cart-btn&quot;|rel=&quot;nofollow&quot;', 'my_text_domain'),
            'dependency' => array('wpjsloader_activate', '==', 'true'),
        ),
        array(
            'id' => 'wpjsloader_line',
            'type' => 'switcher',
            'title' => 'فعال کردن پیش بارگذاری لاینی',
            'text_width' => 80,
            'default' => true,
            'dependency' => array('wpjsloader_activate', '==', 'true'),
        ),
        array(
            'id'    => 'wpjsloader_nprogress',
            'type'  => 'color',
            'title' => 'رنگ لاین پیش بارگذار',
            'output' => array( 'background' => 'body #nprogress .bar', 'border-top-color' => 'body #nprogress .spinner'  ),
            'output_important' => 'true',
            'dependency' => array(
                array('wpjsloader_activate', '==', 'true'),
                array('wpjsloader_line', '==', 'true'),
            ),
        ),
        array(
            'id' => 'wpjsloader_logo',
            'type' => 'switcher',
            'title' => 'فعال کردن پیش بارگذاری لوگو',
            'text_width' => 80,
            'default' => false,
            'dependency' => array('wpjsloader_activate', '==', 'true'),
        ),
    )
));

$prk_national_guard_settings = parskala_TEMPLATEPATH . '/inc/modules/national-guard/settings.php';
if ( file_exists( $prk_national_guard_settings ) ) {
    require_once $prk_national_guard_settings;
}

#other Settings
CSF::createSection($prefix, array(
    'title' => esc_html__('پیکربندی های دیگر', 'prk'),
    'id' => 'prk_other_options',
    'icon' => 'ri-settings-4-line',
    'fields' => array(
        array(
            'id' => 'prk_dis_widget_editor',
            'type' => 'switcher',
            'title' => 'فعال سازی ابزارک قدیمی',
            'subtitle' => esc_html__('فعال سازی ابزارک های پیشین وردپرس و حذف گوتنبرگ (پیشنهاد میشود این گزینه فعال باشد !)', 'prk'),
            'text_width' => 80,

            'default' => true
        ),
        array(
            'id' => 'prk_defualt_thumb_pr',
            'type' => 'media',
            'title' => esc_html__('تصویر بندانگشتی پیش فرض', 'prk'),
            'default'  => array( 'url' => get_template_directory_uri()."/assets/img/cover-thumbnail.svg" ),
            'subtitle' => esc_html__('اگر محصول شما دارای تصویر شاخص نباشد این تصویر نمایش داده می شود.'),
        ),
        array(
            'id' => 'prk_ajax_loader_logo',
            'type' => 'media',
            'title' => esc_html__('تصویر لوگو پیش بارگذار عملکرد ایجکسی', 'prk'),
        ),
        array(
          'id'       => 'custom_css',
          'type'     => 'code_editor',
          'title'    => 'CSS Editor',
          'settings' => array(
            'theme'  => 'mbo',
            'mode'   => 'css',
          ),
        ),
        array(
        'id'       => 'footer_codes',
        'type'     => 'code_editor',
        'title'    => 'Javascript Editor',
        'settings' => array(
          'theme'  => 'monokai',
          'mode'   => 'javascript',
        ),
      ),

    )
));

#vip config Settings
do_action('prk_vip_customize_config_hook');

// A Custom function for get an option
if (!function_exists('prk_option')) {
    function prk_option($option = '', $default = null)
    {
        $options = get_option('prk_option'); // Attention: Set your unique id of the framework
        return (isset($options[$option])) ? $options[$option] : $default;
    }
}

if (!function_exists('your_prefix_enqueue_fa5')) {
    function your_prefix_enqueue_fa5()
    {
        wp_enqueue_style('fa5', get_template_directory_uri() . '/assets/fonts/font/flaticon.css', array(), '5.13.0', 'all');
        wp_enqueue_style('fa5-v4-shims', get_template_directory_uri() . '/assets/fonts/ri-fonts/remixicon.css', array(), '5.13.0', 'all');
    }

    add_action('wp_enqueue_scripts', 'your_prefix_enqueue_fa5');
}

// A Callback function
function prk_callback_helper_sms() {

  echo "<div class='csf-notice csf-notice-warning'><h4>دقت کنید که متغیر کد ورود/عضویت پترن در الگو باید %code% باشد.</h4>
  <img src='".parskala_IMG."options/ippane-patten-helper.JPG' width='700'>
  </div>";

}

// A Callback function
function prk_callback_helper_mobile_face() {
  ?>
  <div class='csf-notice csf-notice-warning'><h4>راهنما:</h4>
  دقت داشته باشید که قالب اختصاصی موبایل در سبک دیجی کالا نمایش داده نمیشود
  </div>;
  <?php
}

function wp_allow_svg_mime_type( $mimes ) {
    $mimes[ 'svg' ] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'wp_allow_svg_mime_type' );


//prk_js_footer_codes
if( ! empty( prk_option( 'footer_codes' ) ) ) {
    add_action( 'wp_footer', 'prk_js_footer_codes' );
}
function prk_js_footer_codes() {
 echo '<script type="text/javascript">';
    print_r( prk_option( 'footer_codes' ) ) . "\n";
 echo '</script>';
}
//Disable the gutenberg block editor
if ( prk_option( 'prk_dis_widget_editor' ) ) {
    // Disables the block editor from managing widgets in the Gutenberg plugin.
    add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
    // Disables the block editor from managing widgets.
    add_filter( 'use_widgets_block_editor', '__return_false' );
}
function shorten_string($string, $wordsreturned)
{
  $retval = $string;
  $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $string);
  $string = str_replace("\n", " ", $string);
  $array = explode(" ", $string);
  if (count($array)<=$wordsreturned)
  {
    $retval = $string;
  }
  else
  {
    array_splice($array, $wordsreturned);
    $retval = implode(" ", $array)."";
  }
  return $retval;
}


// قبل از ذخیره: فارسی‌سازی/تکمیل فیلدهای گروپ
add_filter('pre_update_option_prk_option', ['PRK_OTP_Firewall','filter_before_save'], 10, 2);

// بعد از ذخیره: سینک بلاک‌های موقت با UI
add_action('update_option_prk_option', ['PRK_OTP_Firewall','on_options_update'], 10, 3);

function prk_checkout_manager_form_callback(){
    do_action('prk_woo_checkout_custom_fields');
}


add_action('wp_ajax_prk_manual_cart_reminder', function () {
    if ( ! current_user_can('manage_woocommerce') && ! current_user_can('manage_options') ) {
        wp_send_json_error(['message' => 'شما دسترسی لازم را ندارید.']);
    }
    check_admin_referer('prk_manual_cart_reminder', 'nonce');

    if ( ! function_exists('prk_check_abandoned_cart_for_all_users') ) {
        wp_send_json_error(['message' => 'فانکشن ارسال سبد رها شده یافت نشد.']);
    }

    $sent = prk_check_abandoned_cart_for_all_users(true); // FORCE
    wp_send_json_success([
        'sent'    => intval($sent),
        'message' => $sent ? "پیامک برای {$sent} کاربر ارسال شد." : 'سبدی برای ارسال یافت نشد.'
    ]);
});


// functions.php یا فایل ادمین‌ات:
add_action('admin_enqueue_scripts', function($hook){
    // اگر خواستی محدودش کنی به صفحه تنظیمات CSF خودت، اینجا با $hook یا get_current_screen()->id شرط بذار
    wp_register_script(
        'prk-admin-cart-reminder',
        get_template_directory_uri() . '/app/Admin/assets/js/prk-admin-cart-reminder.js',
        array('jquery'),
        '1.0.0',
        true
    );

    wp_localize_script('prk-admin-cart-reminder', 'PRK_CART_REMINDER', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('prk_manual_cart_reminder')
    ));

    wp_enqueue_script('prk-admin-cart-reminder');
});