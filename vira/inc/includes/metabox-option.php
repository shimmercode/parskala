<?php

/**
 *  product post type options
 *
 * @category   settings
 * @version    1.0.0
 * @since      1.0.0
 */

$productSideMeta = 'product_side_meta';

if(!class_exists("CSF")){ return; }
CSF::createMetabox($productSideMeta, [
	'title'     => __('تنظیمات محصول', 'parskala'),
if ( ! class_exists( "CSF" ) ) { return; }
	'post_type' => 'product',
	'data_type' => 'unserialize',
	'context'   => 'side',
	'priority'  => 'high',
]);



if(!class_exists("CSF")){ return; }
CSF::createSection($productSideMeta, [
	'title'  => __('ویژگی های سفارشی', 'parskala'),
  'description'     => __('ویژگی سفارشی کوتاه (درصورت اضافه نکردن ویژگی کوتاه سفارشی،ویژگی های محصول درج خواهند شد)', 'parskala'),
	'icon'   => 'fas fa-list-ol',
	'fields' => [
		[
			'id'     => 'prk_product_featured_attributes',
			'type'   => 'group',
			'title'  => __('مقادیر', 'parskala'),
			'fields' => [
				[
					'id'    => 'title',
					'type'  => 'text',
					'title' => __('عنوان', 'parskala')
				],

				[
					'id'    => 'value',
					'type'  => 'text',
					'title' => __('مقدار', 'parskala')
				],

			],
		]
	],
]);


if(!class_exists("CSF")){ return; }
CSF::createSection($productSideMeta, [
	'title'  => __('تحویل', 'parskala'),
	'icon'   => 'fas fa-box',
	'fields' => [
		[
			'id'      => 'date_send_pro',
			'type'    => 'slider',
			'title'   => __('زمان تحویل', 'parskala'),
			'min'     => 0,
			'max'     => 60,
			'step'    => 1,
			'default' => 0,
		],
	],
]);

  $prefix = 'prk_product_options';

  // Create a metabox
  if(!class_exists("CSF")){ return; }
CSF::createMetabox( $prefix, array(
    'title'     => 'بخش اختصاصی محصول',
    'post_type' => 'product',
  ) );

  // Create a section
  if(!class_exists("CSF")){ return; }
CSF::createSection( $prefix, array(
    'title'  => 'اکاردئون',
    'fields' => array(

      // A text field
    array(
    'id'     => 'list_ac',
    'type'   => 'repeater',
    'title'  => 'اکاردئون',
    'fields' => array(

      array(
        'id'    => 'title_ac',
        'type'  => 'text',
        'title' => 'عنوان اکاردئون'
      ),
      array(
      'id'    => 'content_ac',
      'type'  => 'wp_editor',
      'title' => 'توضیحات',
      ),

    ),
  ),

    )
  ) );

  //
  // Create a section
  if(!class_exists("CSF")){ return; }
CSF::createSection( $prefix, array(
    'title'  => 'نقات ظعف و قوت',
    'fields' => array(

      // A textarea field
      array(
      'id'        => 'list_adv',
      'type'      => 'group',
      'title'     => 'نقات قوت',
      'fields'    => array(
        array(
          'id'    => 'title_adv',
          'type'  => 'text',
          'title' => 'نقطه قوت',
        ),

      ),
    ),

    array(
    'id'        => 'list_Weak',
    'type'      => 'group',
    'title'     => 'نقات ظعف',
    'fields'    => array(
      array(
        'id'    => 'title_Weak',
        'type'  => 'text',
        'title' => 'نقطه ظعف',
      ),

    ),
  ),
    )
  ) );

  if(!class_exists("CSF")){ return; }
CSF::createSection( $prefix, array(
    'title'  => 'اپلود مدیا',
    'fields' => array(

      array(
      'id'       => 'vidoe_aparats',
      'type'     => 'text',
      'title'    => 'کد اسکریپت آپارات',
      'sanitize' => false,
    ),
        array(
      'id'    => 'vidoe_upload',
      'type'  => 'media',
      'title' => 'بارگذاری مستقیم',
    ),
    )
));
if(!class_exists("CSF")){ return; }
CSF::createSection( $prefix, array(
  'title'  => 'امتیازدهی',
  'fields' => array(

    // A textarea field
    array(
    'id'        => 'ratig',
    'type'      => 'group',
    'title'     => 'امتیازدهی',
    'fields'    => array(
      array(
        'id'    => 'title_rate',
        'type'  => 'text',
        'title' => 'عنوان',
      ),
      array(
        'id'      => 'slider_rate',
        'type'    => 'slider',
        'title'   => 'رتبه',
        'min'     => 1,
        'max'     => 10,
        'step'    => 1,
        'default' => 5,
      ),

    ),
  ),

)
));
// بخش نظرات
if(!class_exists("CSF")){ return; }
CSF::createSection( $prefix, array(
  'title'  => 'بخش نظرات',
  'fields' => array(


    array(
    'id'        => 'options_ratings_review',
    'type'      => 'group',
    'title'     => 'بخش نظرات محصول',
    'fields'    => array(
      array(
        'id'    => 'title',
        'type'  => 'text',
        'title' => 'عنوان',
      ),
      array(
        'id'    => 'slug',
        'type'  => 'text',
        'title' => 'نامک',
      ),

    ),
  ),

  array(
  'id'    => 'des_review',
  'type'  => 'wp_editor',
  'title' => 'توضیحات خاص',

  ),

)));





$postSideMeta = 'post_side_meta';

if(!class_exists("CSF")){ return; }
CSF::createMetabox($postSideMeta, [
	'title'     => __('تنظیمات نوشته', 'parskala'),
	'post_type' => 'post',
	'data_type' => 'unserialize',
	'context'   => 'side',
	'priority'  => 'high',
]);


/**
 *  content post type options
 *
 * @category   settings
 * @version    1.0.0
 * @since      1.0.0
 */

if(!class_exists("CSF")){ return; }
CSF::createSection($postSideMeta, [
	'title'  => __('تنظیمات سفارشی', 'parskala'),
  // 'description'     => __('نمایش تصویرشاخص نوشته', 'parskala'),
	'icon'   => 'fas fa-list-ol',
	'fields' => [
        array(
          'id'         => 'show_thumbnail_order',
          'type'       => 'button_set',
          'title'      => 'جایگاه تصویر شاخص',
          'options'    => array(
            'top'  => 'بالای عنوان',
            'bottom' => 'پایین عنوان',
          ),
          'default'    => 'bottom'
        ),
        array(
          'id'      => 'reading_time',
          'type'    => 'text',
          'title'   => 'زمان تخمینی مطالعه',
          'default' => '3 دقیقه زمان مطالعه'
        ),
        array(
          'id'         => 'show_sidebar_1',
          'type'       => 'switcher',
          'title'      => 'نمایش سایدبار',
          'default'    => true,
          'text_on'    => 'نمایش',
          'text_off'   => 'مخفی',
          'text_width' => 70
          // 'dependency' => array( 'opt-switcher-3', '==', 'true' ) // check for true/false by field id
        ),
	],
]);