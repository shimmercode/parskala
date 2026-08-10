<?php
/**
 * Register theme options.
 *
 * @package Parskala Story
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}


$prefix = "prk_option";

if ( ! class_exists( "CSF" ) ) { return; }

CSF::createSection(
	$prefix,
	array(
		'parent' => 'story_settings', // The slug id of the parent section
		'title'  => esc_html__( 'تنظیمات نمایشی', 'prk-story' ),
		'icon'   => 'far fa-eye',
		'fields' => array(
			array(
				'id'         => 'story_timer',
				'type'       => 'switcher',
				'title'      => esc_html__( 'تایمر نمایش استوری ها', 'prk-story' ),
				'help'       => esc_html__( 'استوری ها حذف نمی شوند. فقط پنهان خواهد شد.', 'prk-story' ),
				'text_on'    => esc_html__( 'بله', 'prk-story' ),
				'text_off'   => esc_html__( 'خیر', 'prk-story' ),
				'text_width' => 75,
			),
			array(
				'id'         => 'single_stories_timer',
				'type'       => 'switcher',
				'title'      => esc_html__( 'تایمر استوری را برای استوری های تک نیز فعال کنید', 'prk-story' ),
				'text_on'    => esc_html__( 'بله', 'prk-story' ),
				'text_off'   => esc_html__( 'بله', 'prk-story' ),
				'text_width' => 75,
				'default'    => true,
				'dependency' => array( 'story_timer', '==', 'true' ),
			),
			array(
				'id'         => 'public_stories_timer',
				'type'       => 'switcher',
				'title'      => esc_html__( 'تایمر استوری را برای استوری های عمومی فعال کنید', 'prk-story' ),
				'text_on'    => esc_html__( 'بله', 'prk-story' ),
				'text_off'   => esc_html__( 'خیر', 'prk-story' ),
				'text_width' => 75,
				'default'    => true,
				'dependency' => array( 'story_timer', '==', 'true' ),
			),
			array(
				'id'         => 'story_time_value',
				'type'       => 'spinner',
				'title'      => esc_html__( 'نمایش استوری تا X دی', 'prk-story' ),
				'min'        => 1,
				'default'    => 1,
				'unit'       => esc_html__( 'Day(s)', 'prk-story' ),
				'dependency' => array( 'story_timer', '==', 'true' ),
			),
		),
	)
);


CSF::createSection(
	$prefix,
	array(
		'title'  => esc_html__( 'پس زمینه استوری', 'prk-story' ),
		'icon'   => 'far fa-window-restore',
		'parent' => 'story_settings',
		'fields' => array(
			array(
				'id'      => 'story_background_type',
				'type'    => 'select',
				'title'   => esc_html__( 'نوع رنگ پس زمینه', 'prk-story' ),
				'options' => array(
					'normal'   => esc_html__( 'معمولی', 'prk-story' ),
					'gradient' => esc_html__( 'گرادیانت', 'prk-story' ),
				),
			),
			array(
				'id'         => 'story_bg',
				'type'       => 'color',
				'title'      => esc_html__( 'رنگ پس زمینه', 'prk-story' ),
				'default'    => '#1a1a1a',
				'dependency' => array( 'story_background_type', '==', 'normal' ),
			),
			array(
				'id'         => 'story_gradient',
				'type'       => 'color_group',
				'title'      => esc_html__( 'رنگ پس زمینه', 'prk-story' ),
				'options'    => array(
					'color-1' => esc_html__( 'Left', 'prk-story' ),
					'color-2' => esc_html__( 'Right', 'prk-story' ),
				),
				'default'    => array(
					'color-1' => '#647dee',
					'color-2' => '#7f53ac',
				),
				'dependency' => array( 'story_background_type', '==', 'gradient' ),
			),
			array(
				'id'    => 'full_size_media',
				'type'  => 'switcher',
				'title' => esc_html__( 'اندازه کامل رسانه', 'prk-story' ),
			),
		),
	)
);

CSF::createSection(
	$prefix,
	array(
		'title'  => esc_html__( 'استایل دکمه', 'prk-story' ),
		'icon'   => 'fas fa-link',
		'parent' => 'story_settings',
		'fields' => array(
			array(
				'id'      => 'swipe_button',
				'type'    => 'switcher',
				'title'   => esc_html__( 'دکمه سوایپ به بالا', 'prk-story' ),
				'desc'    => esc_html__( 'این فقط برای دستگاه های لمسی در دسترس خواهد بود.', 'prk-story' ),
				'default' => false,
			),
			array(
				'id'      => 'button_background_type',
				'type'    => 'select',
				'title'   => esc_html__( 'نوع رنگ پس زمینه', 'prk-story' ),
				'options' => array(
					'normal'   => esc_html__( 'پیشفرض', 'prk-story' ),
					'gradient' => esc_html__( 'گرادیانت', 'prk-story' ),
				),
			),
			array(
				'id'         => 'button_bg',
				'type'       => 'color',
				'title'      => esc_html__( 'رنگ پس زمینه', 'prk-story' ),
				'default'    => 'rgba(0, 0, 0, 1)',
				'dependency' => array( 'button_background_type', '==', 'normal' ),
			),
			array(
				'id'         => 'button_gradient',
				'type'       => 'color_group',
				'title'      => esc_html__( 'رنگ پس زمینه', 'prk-story' ),
				'options'    => array(
					'color-1' => esc_html__( 'چپ', 'prk-story' ),
					'color-2' => esc_html__( 'راست', 'prk-story' ),
				),
				'default'    => array(
					'color-1' => '#647dee',
					'color-2' => '#7f53ac',
				),
				'dependency' => array( 'button_background_type', '==', 'gradient' ),
			),
			array(
				'id'      => 'text_color',
				'type'    => 'color',
				'title'   => esc_html__( 'رنگ دکمه', 'prk-story' ),
				'default' => '#ffffff',
			),
			array(
				'id'      => 'font_size',
				'type'    => 'spinner',
				'title'   => esc_html__( 'سایز دکمه', 'prk-story' ),
				'default' => '16',
				'unit'    => 'px',
				'min'     => 0,
			),
			array(
				'id'      => 'button_padding',
				'type'    => 'dimensions',
				'title'   => esc_html__( 'فاصله داخلی', 'prk-story' ),
				'units'   => array( 'px' ),
				'default' => array(
					'width'  => '12',
					'height' => '24',
					'unit'   => 'px',
				),
			),
			array(
				'id'      => 'button_radius',
				'type'    => 'spinner',
				'title'   => esc_html__( 'انحنای دور دکمه', 'prk-story' ),
				'default' => '5',
				'unit'    => 'px',
				'min'     => 0,
			),
		),
	)
);

CSF::createSection(
	$prefix,
	array(
		'title'  => esc_html__( 'سبک چرخه', 'prk-story' ),
		'icon'   => 'far fa-circle',
		'parent' => 'story_settings',
		'fields' => array(
			array(
				'id'      => 'cycle_position',
				'type'    => 'select',
				'title'   => esc_html__( 'موقعیت', 'prk-story' ),
				'options' => array(
					'auto'   => esc_html__( 'خودکار', 'prk-story' ),
					'center' => esc_html__( 'وسط', 'prk-story' ),
				),
				'default' => 'auto',
			),
			array(
				'id'      => 'cycle_background_type',
				'type'    => 'select',
				'title'   => esc_html__( 'نوع رنگ پس زمینه', 'prk-story' ),
				'options' => array(
					'normal'   => esc_html__( 'معمولی', 'prk-story' ),
					'gradient' => esc_html__( 'گرادیانت', 'prk-story' ),
				),
				'default' => 'gradient',
			),
			array(
				'id'         => 'cycle_bg',
				'type'       => 'color',
				'title'      => esc_html__( 'رنگ پس زمینه', 'prk-story' ),
				'default'    => '',
				'dependency' => array( 'cycle_background_type', '==', 'normal' ),
			),
			array(
				'id'         => 'cycle_gradient',
				'type'       => 'color_group',
				'title'      => esc_html__( 'رنگ پس زمینه', 'prk-story' ),
				'options'    => array(
					'color-1' => esc_html__( 'چپ', 'prk-story' ),
					'color-2' => esc_html__( 'راست', 'prk-story' ),
				),
				'default'    => array(
					'color-1' => '#ee583f',
					'color-2' => '#bd3381',
				),
				'dependency' => array( 'cycle_background_type', '==', 'gradient' ),
			),
		),
	)
);

CSF::createSection(
	$prefix,
	array(
		'title'  => esc_html__( 'استایل عنوان', 'prk-story' ),
		'icon'   => 'fas fa-font',
		'parent' => 'story_settings',
		'fields' => array(
			array(
				'id'      => 'title_color',
				'type'    => 'color',
				'title'   => esc_html__( 'رنگ عنوان', 'prk-story' ),
				'default' => '#000',
			),
		),
	)
);


CSF::createSection(
	$prefix,
	array(
		'parent' => 'story_settings', // The slug id of the parent section
		'title'  => esc_html__( 'بیشتر', 'prk-story' ),
		'icon'   => 'fas fa-cog',
		'fields' => array(

			array(
				'id'      => 'posts_story_options',
				'type'    => 'switcher',
				'title'   => esc_html__( 'تنظیمات پیشرفته نمایش پست', 'prk-story' ),
				// 'desc'    => esc_html__( 'Display story options for posts to set custom story images.', 'prk-story' ),
				'default' => true,
			),
			array(
				'id'    => 'opener',
				'type'  => 'text',
				'title' => esc_html__( 'Opener Selector', 'prk-story' ),
				'desc'  => esc_html__( 'انتخابگر css  باز کردن استوری ها .', 'prk-story' ),
			),
		),
	)
);
