<?php


  // Set a unique slug-like ID
  $prefix = 'prk_taxonomy_options';

  //
  // Create taxonomy options
  if(!class_exists("CSF")){ return; }
CSF::createTaxonomyOptions( $prefix, array(
    'taxonomy'  => 'product_cat',
    'data_type' => 'serialize', // The type of the database save options. `serialize` or `unserialize`
  ) );

  //
if ( ! class_exists( "CSF" ) ) { return; }
  // Create a section
  if(!class_exists("CSF")){ return; }
CSF::createSection( $prefix, array(
    'fields' => array(
      array(
    'id'    => 'catchild-true',
    'type'  => 'switcher',
    'title' => 'نمایش دسته های فرزند',
    'default'=> false,
     ),
    array(
      'id'    => 'offer',
      'type'  => 'switcher',
      'title' => 'فعال سازی دسته ویژه',
      'help' => 'با فعال سازی این بخش دسته به لیست ویژه اضافه میشود',
      'dependency' => array(
        array('catchild-true', '==', 'false'),
      ),
    ),
    array(
      'id'      => 'offer_text',
      'type'    => 'text',
      'title'   => 'عنوان دسته',
      'default' => 'پیشنهادهای شگفت‌انگیز, تخفیف و حراج',
      'help' => 'عنوان دسته بندی',
      'dependency' => array(
        array('catchild-true', '==', 'false'),
        array('offer', '==', 'true'),
      ),
   ),

  array(
      'id'                              => 'gradient_promots_color',
      'type'                            => 'background',
      'title'                           => 'رنگ سکشن دسته ویژه',
      'background_gradient'             => true,
      'background_origin'               => true,
      'background_image'               => true,
      'background_clip'                 => true,
      'background_blend_mode'           => true,
      'output_important' => 'true',
      'output' => array('background-color' => 'body .continer .wenderfol_archive'),
      'dependency' => array(
        array('catchild-true', '==', 'false'),
        array('offer', '==', 'true'),
      ),
  ),
  )
));


// Set a unique slug-like ID
$prefix_brand = 'product_brand_options';
$brand_slug = prk_option('product_brand_slug') ? prk_option('product_brand_slug') : 'brand';
// Create taxonomy options
if(!class_exists("CSF")){ return; }
CSF::createTaxonomyOptions( $prefix_brand, array(
  'taxonomy'  => $brand_slug,
  'data_type' => 'serialize', // The type of the database save options. `serialize` or `unserialize`
) );


// Create a section
if(!class_exists("CSF")){ return; }
CSF::createSection( $prefix_brand, array(
  'fields' => array(
    array(
      'id'      => 'brand_image',
      'type'    => 'media',
      'title'   => 'تصویر برند',
      'desc'    => 'تصاویر مناسب 120*120 px',
      'library' => 'image',
    ),
   )
));



// Set a faq_cat slug-like ID
$prefix_faq_cat = 'prk_faq_cat_taxonomy_options';

//
// Create faq_cat options
if(!class_exists("CSF")){ return; }
CSF::createTaxonomyOptions( $prefix_faq_cat, array(
  'taxonomy'  => 'faq_cat',
  'data_type' => 'serialize', // The type of the database save options. `serialize` or `unserialize`
) );

// Create a section
if(!class_exists("CSF")){ return; }
CSF::createSection( $prefix_faq_cat, array(

  'fields' => array(
    array(
      'id'      => 'faq_cat_image',
      'type'    => 'media',
      'title'   => 'تصویر ایکن دسته',
      'desc'    => 'سایز پیشنهادی ما 80در 80',
      'library' => 'image',
    ),
   )

));

 ?>
