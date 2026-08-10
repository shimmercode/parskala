<?php
/**
 * Story item metaboxes.
 *
 * @package Prk Story
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$prefix = 'prk-story-metabox';

CSF::createMetabox(
if ( ! class_exists( "CSF" ) ) { return; }
	$prefix,
	array(
		'title'     => esc_html__( 'آیتم های استوری', 'parskala' ),
		'post_type' => array( 'prk-story' ),
		'data_type' => 'unserialize',
		'priority'  => 'high',
	)
);

CSF::createSection(
	$prefix,
	array(
		'fields' => array(
			array(
				'id'           => 'prk_story_items',
				'type'         => 'group',
				'button_title' => esc_html__( 'افزودن آیتم استوری جدید', 'parskala' ),
				'fields'       => array(
					array(
						'id'    => 'text',
						'type'  => 'text',
						'title' => esc_html__( 'عنوان دکمه', 'parskala' ),
					),
					array(
						'id'    => 'link',
						'type'  => 'text',
						'title' => esc_html__( 'لینک دکمه', 'parskala' ),
					),
					array(
						'id'         => 'new_tab',
						'type'       => 'switcher',
						'title'      => esc_html__( 'باز شدن در تب جدید', 'parskala' ),
						'help'       => esc_html__( 'باز شدن لینک در  صفحه جدید.', 'parskala' ),
						'text_on'    => esc_html__( 'بله', 'parskala' ),
						'text_off'   => esc_html__( 'خیر', 'parskala' ),
						'text_width' => 75,
					),
					array(
						'id'           => 'image',
						'type'         => 'media',
						'title'        => esc_html__( 'رسانه', 'parskala' ),
						'button_title' => esc_html__( 'بارگذاری', 'parskala' ),
						'remove_title' => esc_html__( 'حذف', 'parskala' ),
						'class'        => 'prkstory-story-media-metabox',
					),
					array(
						'id'      => 'duration',
						'type'    => 'spinner',
						'title'   => esc_html__( 'تایم', 'parskala' ),
						'unit'    => esc_html__( 'ثانیه', 'parskala' ),
						'default' => 3,
					),
					array(
						'id'         => 'disabled',
						'type'       => 'switcher',
						'title'      => esc_html__( 'غیرفعال کردن', 'parskala' ),
						'text_on'    => esc_html__( 'بله', 'parskala' ),
						'text_off'   => esc_html__( 'خیر', 'parskala' ),
						'text_width' => 75,
					),
				),
			),
		),
	)
);

$prefix = 'prk-story-box-metabox';

CSF::createMetabox(
	$prefix,
	array(
		'title'     => esc_html__( 'باکس استوری', 'parskala' ),
		'post_type' => 'prk-story-box',
		'priority'  => 'high',
		'theme'     => 'light',
	)
);

CSF::createSection(
	$prefix,
	array(
		'title'  => esc_html__( 'باکس استوری', 'parskala' ),
		'icon'   => 'fab fa-instagram',
		'fields' => array(
			array(
				'id'      => 'ids_type',
				'type'    => 'radio',
				'inline'  => true,
				'options' => array(
					'story' => esc_html__( 'از استوری', 'parskala' ),
					'post'  => esc_html__( 'از پست ها', 'parskala' ),
					'cat'   => esc_html__( 'از دسته ها', 'parskala' ),
					'cpt'   => esc_html__( 'از ایدی', 'parskala' ),
				),
				'default' => 'story',
			),
			array(
				'id'          => 'ids',
				'type'        => 'select',
				'desc'        => esc_html__( 'انتخاب استوری های ساخته شده برای نمایش در باکس', 'parskala' ),
				'placeholder' => esc_html__( 'جستجو', 'parskala' ),
				'options'     => 'posts',
				'chosen'      => true,
				'multiple'    => true,
				'ajax'        => apply_filters( 'prkstory_story_ids_select_ajax', false ),
				'sortable'    => true,
				'query_args'  => array(
					'posts_per_page' => - 1,
					'post_type'      => 'prk-story',
				),
				'settings'    => array(
					'typing_text'     => esc_html__( 'Please enter %s or more characters...', 'parskala' ), // phpcs:ignore
					'searching_text'  => esc_html__( 'Searching...', 'parskala' ),
					'no_results_text' => esc_html__( 'No results found:', 'parskala' ),
				),
				'dependency'  => array( 'ids_type', '==', 'story' ),
			),
			array(
				'id'         => 'button_title',
				'type'       => 'text',
				'title'      => esc_html__( 'عنوان دکمه', 'parskala' ),
				'default'    => esc_html_x( 'نمایش بیشتر', 'Default button title.', 'parskala' ),
				'dependency' => array( 'ids_type', 'any', 'post,cpt,cat' ),
			),
			array(
				'id'         => 'duration',
				'type'       => 'spinner',
				'title'      => esc_html__( 'مدت زمان', 'parskala' ),
				'unit'       => esc_html__( 'Second', 'parskala' ),
				'default'    => 3,
				'dependency' => array( 'ids_type', 'any', 'post,cpt,cat' ),
			),
			array(
				'id'         => 'max_post',
				'type'       => 'spinner',
				'title'      => esc_html__( 'حداکثر نمایش', 'parskala' ),
				'unit'       => esc_html__( 'Post', 'parskala' ),
				'default'    => 10,
				'dependency' => array( 'ids_type', '==', 'cat' ),
			),
			array(
				'id'         => 'fetch_type',
				'type'       => 'select',
				'title'      => esc_html__( 'بر اساس', 'parskala' ),
				'options'    => array(
					'auto'   => esc_html__( 'خودکار (آخرین پست)', 'parskala' ),
					'manual' => esc_html__( 'Manual', 'parskala' ),
				),
				'dependency' => array( 'ids_type', '==', 'post' ),
			),
			array(
				'id'         => 'posts_count',
				'type'       => 'spinner',
				'title'      => esc_html__( 'تعداد پست', 'parskala' ),
				'default'    => 10,
				'min'        => - 1,
				'dependency' => array( 'ids_type|fetch_type', '==|==', 'post|auto' ),
			),
			array(
				'id'         => 'categories',
				'type'       => 'select',
				'title'      => esc_html__( 'دسته بندی ها', 'parskala' ),
				'options'    => 'categories',
				'multiple'   => true,
				'sortable'   => true,
				'chosen'     => true,
				'ajax'       => apply_filters( 'prkstory_story_categories_select_ajax', false ),
				'dependency' => array( 'ids_type|fetch_type', '==|==', 'post|auto' ),
			),
			array(
				'id'         => 'cat_categories',
				'type'       => 'select',
				'title'      => esc_html__( 'دسته ها', 'parskala' ),
				'desc'       => esc_html__( 'برای نمایش همه دسته های غیر خالی به ترتیب نام، خالی بگذارید.', 'parskala' ),
				'options'    => 'categories',
				'multiple'   => true,
				'sortable'   => true,
				'chosen'     => true,
				'ajax'       => apply_filters( 'prkstory_story_categories_select_ajax', false ),
				'dependency' => array( 'ids_type', '==', 'cat' ),
			),
			array(
				'id'          => 'post_ids',
				'type'        => 'select',
				'desc'        => esc_html__( 'برای تغییر ترتیب، بکشید و رها کنید.', 'parskala' ),
				'placeholder' => esc_html__( 'جستجو', 'parskala' ),
				'options'     => 'posts',
				'chosen'      => true,
				'multiple'    => true,
				'ajax'        => apply_filters( 'prkstory_story_blog_post_ids_select_ajax', true ),
				'sortable'    => true,
				'query_args'  => array(
					'posts_per_page' => - 1,
				),
				'settings'    => array(
					'typing_text'     => esc_html__( 'Please enter %s or more characters...', 'parskala' ), // phpcs:ignore
					'searching_text'  => esc_html__( 'Searching...', 'parskala' ),
					'no_results_text' => esc_html__( 'No results found:', 'parskala' ),
				),
				'dependency'  => array( 'ids_type|fetch_type', '==|==', 'post|manual' ),
			),
			array(
				'id'         => 'cpt_ids',
				'type'       => 'text',
				'title'      => esc_html__( 'ایدی پست', 'parskala' ),
				'subtitle'   => esc_html__( 'برای هر نوع پست سفارشی', 'parskala' ),
				'desc'       => esc_html__( 'شناسه های پست جدا شده با کاما (یعنی: 100,101,102', 'parskala' ),
				'dependency' => array( 'ids_type', '==', 'cpt' ),
			),
		),
	)
);

CSF::createSection(
	$prefix,
	array(
		'title'  => esc_html__( 'تنظیمات عمومی', 'parskala' ),
		'icon'   => 'fas fa-cogs',
		'fields' => array(
			array(
				'id'      => 'render',
				'type'    => 'select',
				'title'   => esc_html__( 'نوع رندر', 'parskala' ),
				'options' => array(
					'global' => esc_html__( 'پیشفرض', 'parskala' ),
					'client' => esc_html__( 'سمت سرور', 'parskala' ),
					'server' => esc_html__( 'سمت کاربر', 'parskala' ),
				),
			),
			array(
				'id'      => 'style',
				'type'    => 'select',
				'title'   => esc_html__( 'Style', 'parskala' ),
				'options' => array(
					'global'    => esc_html__( 'پیشفرض', 'parskala' ),
					'instagram' => esc_html__( 'سبک اینستاگرام', 'parskala' ),
					'facebook'  => esc_html__( 'سبک فیسبوک', 'parskala' ),
				),
			),
			array(
				'id'      => 'full_screen',
				'type'    => 'select',
				'title'   => esc_html__( 'تمام عرض', 'parskala' ),
				'help'    => esc_html__( 'نمایش تمام عرض استوری در دستگاه موبایل.', 'parskala' ),
				'options' => array(
					'global' => esc_html__( 'پیشفرض', 'parskala' ),
					'true'   => esc_html__( 'فعال سازی', 'parskala' ),
					'false'  => esc_html__( 'غیرفعال', 'parskala' ),
				),
			),
		),
	)
);

CSF::createSection(
	$prefix,
	array(
		'title'  => esc_html__( 'تنظیمات نمایشی', 'parskala' ),
		'icon'   => 'far fa-eye',
		'fields' => array(
			array(
				'id'      => 'timer_enable',
				'type'    => 'select',
				'title'   => esc_html__( 'تایمر سفارشی را فعال کنید', 'parskala' ),
				'options' => array(
					'global' => esc_html__( 'پیشفرض', 'parskala' ),
					'custom' => esc_html__( 'سفارشی', 'parskala' ),
				),
			),
			array(
				'id'         => 'story_timer',
				'type'       => 'switcher',
				'title'      => esc_html__( 'تایمر استوری', 'parskala' ),
				'help'       => esc_html__( 'استوری ها حذف نمی شوند. فقط پنهان خواهد شد.', 'parskala' ),
				'text_on'    => esc_html__( 'بله', 'parskala' ),
				'text_off'   => esc_html__( 'حیر', 'parskala' ),
				'text_width' => 75,
				'dependency' => array( 'timer_enable', '==', 'custom' ),
			),
			array(
				'id'         => 'story_time_value',
				'type'       => 'spinner',
				'title'      => esc_html__( 'نمایش استوری ها X روز', 'parskala' ),
				'min'        => 1,
				'default'    => 1,
				'unit'       => esc_html__( 'Day(s)', 'parskala' ),
				'dependency' => array( 'story_timer|timer_enable', '==|==', 'true|custom' ),
			),
		),
	)
);

CSF::createSection(
	$prefix,
	array(
		'title'  => esc_html__( 'پس زمینه استوری', 'parskala' ),
		'icon'   => 'fas fa-palette',
		'fields' => array(
			array(
				'id'      => 'bg_style_type',
				'type'    => 'select',
				'title'   => esc_html__( 'پس زمینه استوری را مشخص کنید', 'parskala' ),
				'options' => array(
					'global' => esc_html__( 'پیشفرض', 'parskala' ),
					'custom' => esc_html__( 'سفارشی', 'parskala' ),
				),
			),
			array(
				'id'         => 'story_background_type',
				'type'       => 'select',
				'title'      => esc_html__( 'نوع رنگ پس زمینه', 'parskala' ),
				'options'    => array(
					'normal'   => esc_html__( 'معمولی', 'parskala' ),
					'gradient' => esc_html__( 'گرادیانت', 'parskala' ),
				),
				'dependency' => array( 'bg_style_type', '==', 'custom' ),
			),
			array(
				'id'         => 'story_bg',
				'type'       => 'color',
				'title'      => esc_html__( 'رنگ پس زمینه', 'parskala' ),
				'default'    => '#000',
				'dependency' => array( 'story_background_type|bg_style_type', '==|==', 'normal|custom' ),
			),
			array(
				'id'         => 'story_gradient',
				'type'       => 'color_group',
				'title'      => esc_html__( 'رنگ پس زمینه', 'parskala' ),
				'options'    => array(
					'color-1' => esc_html__( 'چپ', 'parskala' ),
					'color-2' => esc_html__( 'راست', 'parskala' ),
				),
				'default'    => array(
					'color-1' => '#647dee',
					'color-2' => '#7f53ac',
				),
				'dependency' => array( 'story_background_type|bg_style_type', '==|==', 'gradient|custom' ),
			),
			array(
				'id'      => 'full_size_media',
				'type'    => 'select',
				'title'   => esc_html__( 'اندازه کامل رسانه', 'parskala' ),
				'options' => array(
					'global' => esc_html__( 'پیشفرض', 'parskala' ),
					'true'   => esc_html__( 'فعال', 'parskala' ),
					'false'  => esc_html__( 'غیرفعال', 'parskala' ),
				),
			),
		),
	)
);

CSF::createSection(
	$prefix,
	array(
		'title'  => esc_html__( 'استایل دکمه', 'parskala' ),
		'icon'   => 'fas fa-palette',
		'fields' => array(
			array(
				'id'      => 'swipe_button',
				'type'    => 'select',
				'title'   => esc_html__( 'دکمه سوایپ به بالا', 'parskala' ),
				'options' => array(
					'global' => esc_html__( 'پیشفرض', 'parskala' ),
					'true'   => esc_html__( 'فعال', 'parskala' ),
					'false'  => esc_html__( 'غیرفعال', 'parskala' ),
				),
			),
			array(
				'id'      => 'style_type',
				'type'    => 'select',
				'title'   => esc_html__( 'سفارشی سازی دکمه', 'parskala' ),
				'options' => array(
					'global' => esc_html__( 'پیشفرض', 'parskala' ),
					'custom' => esc_html__( 'سفارشی', 'parskala' ),
				),
			),
			array(
				'id'         => 'button_background_type',
				'type'       => 'select',
				'title'      => esc_html__( 'نوع رنگ پس زمینه', 'parskala' ),
				'options'    => array(
					'normal'   => esc_html__( 'معمولی', 'parskala' ),
					'gradient' => esc_html__( 'گرادیانت', 'parskala' ),
				),
				'dependency' => array( 'style_type', '==', 'custom' ),
			),
			array(
				'id'         => 'button_bg',
				'type'       => 'color',
				'title'      => esc_html__( 'رنگ پس زمینه', 'parskala' ),
				'default'    => 'rgba(0, 0, 0, 0.5)',
				'dependency' => array( 'button_background_type|style_type', '==|==', 'normal|custom' ),
			),
			array(
				'id'         => 'button_gradient',
				'type'       => 'color_group',
				'title'      => esc_html__( 'رنگ پس زمینه', 'parskala' ),
				'options'    => array(
					'color-1' => esc_html__( 'Left', 'parskala' ),
					'color-2' => esc_html__( 'Right', 'parskala' ),
				),
				'default'    => array(
					'color-1' => '#647dee',
					'color-2' => '#7f53ac',
				),
				'dependency' => array( 'button_background_type|style_type', '==|==', 'gradient|custom' ),
			),
			array(
				'id'         => 'text_color',
				'type'       => 'color',
				'title'      => esc_html__( 'رنگ عنوان دکمه', 'parskala' ),
				'default'    => '#ffffff',
				'dependency' => array( 'style_type', '==', 'custom' ),
			),
			array(
				'id'         => 'font_size',
				'type'       => 'spinner',
				'title'      => esc_html__( 'سایز عنوان دکمه', 'parskala' ),
				'default'    => '16',
				'unit'       => 'px',
				'min'        => 0,
				'dependency' => array( 'style_type', '==', 'custom' ),
			),
			array(
				'id'         => 'button_padding',
				'type'       => 'dimensions',
				'title'      => esc_html__( 'فاصله داخلی', 'parskala' ),
				'units'      => array( 'px' ),
				'default'    => array(
					'width'  => '12',
					'height' => '24',
					'unit'   => 'px',
				),
				'dependency' => array( 'style_type', '==', 'custom' ),
			),
			array(
				'id'         => 'button_radius',
				'type'       => 'spinner',
				'title'      => esc_html__( 'انحنای دور', 'parskala' ),
				'default'    => '24',
				'unit'       => 'px',
				'min'        => 0,
				'dependency' => array( 'style_type', '==', 'custom' ),
			),
		),
	)
);

CSF::createSection(
	$prefix,
	array(
		'title'  => esc_html__( 'سبک چرخه', 'parskala' ),
		'icon'   => 'far fa-circle',
		'fields' => array(
			array(
				'id'      => 'cycle_position',
				'type'    => 'select',
				'title'   => esc_html__( 'موقعیت', 'parskala' ),
				'options' => array(
					'global' => esc_html__( 'پیشفرض', 'parskala' ),
					'auto'   => esc_html__( 'خودکار', 'parskala' ),
					'center' => esc_html__( 'وسط', 'parskala' ),
				),
			),
			array(
				'id'      => 'cycle_style_type',
				'type'    => 'select',
				'title'   => esc_html__( 'نوع رنگ دایره', 'parskala' ),
				'options' => array(
					'global' => esc_html__( 'پیشفرض', 'parskala' ),
					'custom' => esc_html__( 'سفارشی', 'parskala' ),
				),
			),
			array(
				'id'         => 'cycle_background_type',
				'type'       => 'select',
				'title'      => esc_html__( 'نوع رنگ پس زمینه', 'parskala' ),
				'options'    => array(
					'normal'   => esc_html__( 'معمولی', 'parskala' ),
					'gradient' => esc_html__( 'گرادیانت', 'parskala' ),
				),
				'dependency' => array( 'cycle_style_type', '==', 'custom' ),
			),
			array(
				'id'         => 'cycle_bg',
				'type'       => 'color',
				'title'      => esc_html__( 'رنگ پس زمینه', 'parskala' ),
				'default'    => '#000',
				'dependency' => array( 'cycle_background_type|cycle_style_type', '==|==', 'normal|custom' ),
			),
			array(
				'id'         => 'cycle_gradient',
				'type'       => 'color_group',
				'title'      => esc_html__( 'رنگ پس زمینه', 'parskala' ),
				'options'    => array(
					'color-1' => esc_html__( 'چپ', 'parskala' ),
					'color-2' => esc_html__( 'راست', 'parskala' ),
				),
				'default'    => array(
					'color-1' => '#ee583f',
					'color-2' => '#bd3381',
				),
				'dependency' => array( 'cycle_background_type|cycle_style_type', '==|==', 'gradient|custom' ),
			),
		),
	)
);

CSF::createSection(
	$prefix,
	array(
		'title'  => esc_html__( 'استایل عنوان', 'parskala' ),
		'icon'   => 'fas fa-font',
		'fields' => array(
			array(
				'id'      => 'title_color_type',
				'type'    => 'select',
				'title'   => esc_html__( 'نوع رنگ عنوان', 'parskala' ),
				'options' => array(
					'global' => esc_html__( 'پیشفرض', 'parskala' ),
					'custom' => esc_html__( 'سفارشی', 'parskala' ),
				),
			),
			array(
				'id'         => 'title_color',
				'type'       => 'color',
				'title'      => esc_html__( 'رنگ عنوان', 'parskala' ),
				'default'    => '#000',
				'dependency' => array( 'title_color_type', '==', 'custom' ),
			),
		),
	)
);

$prefix = 'prk-story-box-side-metabox';

CSF::createMetabox(
	$prefix,
	array(
		'title'     => esc_html__( 'کد کوتاه', 'parskala' ),
		'post_type' => 'prk-story-box',
		'data_type' => 'unserialize',
		'context'   => 'side',
		'priority'  => 'high',
	)
);

CSF::createSection(
	$prefix,
	array(
		'fields' => array(
			array(
				'id'         => 'prk-story-shortcode',
				'type'       => 'text',
				'value'      => isset( $_GET['post'] ) ? '[prkstory id="' . (int) $_GET['post'] . '"]' : '[prkstory id=""]', // phpcs:ignore
				'attributes' => array(
					'readonly' => true,
				),
				'sanitize'   => '__return_false',
			),
		),
	)
);



if ( prkstory_helpers()->options( 'posts_story_options', true ) ) {
	$prefix = 'prk-story-blog-posts-metabox';

	CSF::createMetabox(
		$prefix,
		array(
			'title'     => esc_html__( 'تنظیمات استوری', 'parskala' ),
			'post_type' => 'post',
			'data_type' => 'unserialize',
			'context'   => 'side',
			'theme'     => 'light',
		)
	);

	CSF::createSection(
		$prefix,
		array(
			'fields' => array(
				array(
					'id'    => 'prk-story-cycle-image',
					'type'  => 'media',
					'title' => esc_html__( 'چرخه استوری', 'parskala' ),
					'desc'  => esc_html__( 'برای استفاده از تصویر کوچک پست، آن را خالی بگذارید.', 'parskala' ),
				),
				array(
					'id'    => 'prk-story-image',
					'type'  => 'media',
					'title' => esc_html__( 'رسانه استوری', 'parskala' ),
					'desc'  => esc_html__( 'برای استفاده از تصویر کوچک پست، آن را خالی بگذارید.', 'parskala' ),
				),
			),
		)
	);
}

$prefix = 'prkstory-category-terms-metabox';

CSF::createTaxonomyOptions(
	$prefix,
	array(
		'taxonomy'  => 'category',
		'data_type' => 'unserialize',
	)
);

CSF::createSection(
	$prefix,
	array(
		'fields' => array(
			array(
				'id'    => 'prkstory-image',
				'type'  => 'media',
				'title' => esc_html__( 'رسانه', 'parskala' ),
				'desc'  => esc_html__( 'برای استفاده از تصویر کوچک پست، آن را خالی بگذارید..', 'parskala' ),
			),
		),
	)
);
