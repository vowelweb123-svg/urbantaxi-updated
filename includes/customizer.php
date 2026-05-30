<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Generate customizer section heading with proper styling
 * 
 * @param string $text The heading text
 * @return string Sanitized HTML heading
 */
function urbantaxi_customizer_heading( $text ) {
	return '<h3 class="urbantaxi-customizer-heading">' . esc_html( $text ) . '</h3>';
}

if ( class_exists("Kirki")){

	Kirki::add_config('theme_config_id', array(
		'capability'   =>  'edit_theme_options',
		'option_type'  =>  'theme_mod',
	));


	Kirki::add_field( 'theme_config_id', [
		'label'       => esc_html__( 'Logo Size','urbantaxi' ),
		'section'     => 'title_tagline',
		'priority'    => 9,
		'type'        => 'range',
		'settings'    => 'logo_size',
		'choices' => [
			'step'             => 5,
			'min'              => 0,
			'max'              => 100,
			'aria-valuemin'    => 0,
			'aria-valuemax'    => 100,
			'aria-valuenow'    => 50,
			'aria-orientation' => 'horizontal',
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_enable_logo_text',
		'section'     => 'title_tagline',
		'default'     => urbantaxi_customizer_heading( __( 'Enable / Disable Site Title and Tagline', 'urbantaxi' ) ),
		'priority'    => 10,
	] );

  	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'urbantaxi_display_header_title',
		'label'       => esc_html__( 'Site Title Enable / Disable Button', 'urbantaxi' ),
		'section'     => 'title_tagline',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'urbantaxi' ),
			'off' => esc_html__( 'Disable', 'urbantaxi' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'urbantaxi_display_header_text',
		'label'       => esc_html__( 'Tagline Enable / Disable Button', 'urbantaxi' ),
		'section'     => 'title_tagline',
		'default'     => '0',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'urbantaxi' ),
			'off' => esc_html__( 'Disable', 'urbantaxi' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_site_tittle_font_heading',
		'section'     => 'title_tagline',
		'default'     => urbantaxi_customizer_heading( __( 'Site Title Font Size', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'urbantaxi_site_tittle_font_size',
		'type'        => 'number',
		'section'     => 'title_tagline',
		'transport' => 'auto',
		'output' => array(
			array(
				'element'  => array('.logo a'),
				'property' => 'font-size',
				'suffix' => 'px'
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_site_tagline_font_heading',
		'section'     => 'title_tagline',
		'default'     => urbantaxi_customizer_heading( __( 'Site Tagline Font Size', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'urbantaxi_site_tagline_font_size',
		'type'        => 'number',
		'section'     => 'title_tagline',
		'transport' => 'auto',
		'output' => array(
			array(
				'element'  => array('.logo span'),
				'property' => 'font-size',
				'suffix' => 'px'
			),
		),
	) );
	// Theme color

	Kirki::add_section( 'urbantaxi_theme_color_setting', array(
		'title'    => __( 'Color Option', 'urbantaxi' ),
		'priority' => 10,
	) );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'urbantaxi_first_theme_color',
		'label'       => __( 'Theme First color', 'urbantaxi'),
		'description'    => esc_html__( 'To customize the colors of the homepage, use the Elementor editor', 'urbantaxi' ),
		'section'     => 'urbantaxi_theme_color_setting',
		'type'        => 'color',
		'default'     => '#FDC702',
	) );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'urbantaxi_second_theme_color',
		'label'       => __( 'Theme Second color', 'urbantaxi'),
		'description'    => esc_html__( 'To customize the colors of the homepage, use the Elementor editor', 'urbantaxi' ),
		'section'     => 'urbantaxi_theme_color_setting',
		'type'        => 'color',
		'default'     => '#FFFFFF',
	) );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'urbantaxi_third_theme_color',
		'label'       => __( 'Theme Third color', 'urbantaxi'),
		'description'    => esc_html__( 'To customize the colors of the homepage, use the Elementor editor', 'urbantaxi' ),
		'section'     => 'urbantaxi_theme_color_setting',
		'type'        => 'color',
		'default'     => '#2B2B2B',
	) );

	// TYPOGRAPHY SETTINGS

	Kirki::add_panel( 'urbantaxi_typography_panel', array(
		'priority' => 10,
		'title'    => __( 'Typography', 'urbantaxi' ),
	) );

	//Heading 1 Section

	Kirki::add_section( 'urbantaxi_h1_typography_setting', array(
		'title'    => __( 'Heading 1', 'urbantaxi' ),
		'panel'    => 'urbantaxi_typography_panel',
		'priority' => 0,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_h1_typography_heading',
		'section'     => 'urbantaxi_h1_typography_setting',
		'default'     => urbantaxi_customizer_heading( __( 'Heading 1 Typography', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'  =>  'typography',
		'settings'  => 'urbantaxi_h1_typography_font',
		'section'   =>  'urbantaxi_h1_typography_setting',
		'default'   =>  [
			'font-family'   =>  "'Lexend'",
			'variant'       =>  '500',
			'font-size'       => '',
			'line-height'   =>  '',
			'letter-spacing'    =>  '',
			'text-transform'    =>  '',
		],
		'transport'     =>  'auto',
		'output'        =>  [
			[
				'element'   =>  array('.title-banner-image-box h1 , h1'),
				'suffix' => '!important'
			],
		],

	) );

	//Heading 2 Section

	Kirki::add_section( 'urbantaxi_h2_typography_setting', array(
		'title'    => __( 'Heading 2', 'urbantaxi' ),
		'panel'    => 'urbantaxi_typography_panel',
		'priority' => 0,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_h2_typography_heading',
		'section'     => 'urbantaxi_h2_typography_setting',
		'default'     => urbantaxi_customizer_heading( __( 'Heading 2 Typography', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'  =>  'typography',
		'settings'  => 'urbantaxi_h2_typography_font',
		'section'   =>  'urbantaxi_h2_typography_setting',
		'default'   =>  [
			'font-family'   =>  "'Lexend'",
			'font-size'       => '',
			'variant'       =>  '600',
			'line-height'   =>  '',
			'letter-spacing'    =>  '',
			'text-transform'    =>  '',
		],
		'transport'     =>  'auto',
		'output'        =>  [
			[
				'element'   =>  'h2'
			],
		],
	) );

	//Heading 3 Section

	Kirki::add_section( 'urbantaxi_h3_typography_setting', array(
		'title'    => __( 'Heading 3', 'urbantaxi' ),
		'panel'    => 'urbantaxi_typography_panel',
		'priority' => 0,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_h3_typography_heading',
		'section'     => 'urbantaxi_h3_typography_setting',
		'default'     => urbantaxi_customizer_heading( __( 'Heading 3 Typography', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'  =>  'typography',
		'settings'  => 'urbantaxi_h3_typography_font',
		'section'   =>  'urbantaxi_h3_typography_setting',
		'default'   =>  [
			'font-family'   =>  "'Lexend'",
			'variant'       =>  '600',
			'font-size'       => '',
			'line-height'   =>  '',
			'letter-spacing'    =>  '',
			'text-transform'    =>  '',
		],
		'transport'     =>  'auto',
		'output'        =>  [
			[
				'element'   =>  'h3',
				'suffix' => '!important'
			],
		],
	) );

	//Heading 4 Section

	Kirki::add_section( 'urbantaxi_h4_typography_setting', array(
		'title'    => __( 'Heading 4', 'urbantaxi' ),
		'panel'    => 'urbantaxi_typography_panel',
		'priority' => 0,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_h4_typography_heading',
		'section'     => 'urbantaxi_h4_typography_setting',
		'default'     => urbantaxi_customizer_heading( __( 'Heading 4 Typography', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'  =>  'typography',
		'settings'  => 'urbantaxi_h4_typography_font',
		'section'   =>  'urbantaxi_h4_typography_setting',
		'default'   =>  [
			'font-family'   =>  "'Lexend'",
			'variant'       =>  '600',
			'font-size'       => '',
			'line-height'   =>  '',
			'letter-spacing'    =>  '',
			'text-transform'    =>  '',
		],
		'transport'     =>  'auto',
		'output'        =>  [
			[
				'element'   =>  'h4',
				'suffix' => '!important'
			],
		],
	) );

	//Heading 5 Section

	Kirki::add_section( 'urbantaxi_h5_typography_setting', array(
		'title'    => __( 'Heading 5', 'urbantaxi' ),
		'panel'    => 'urbantaxi_typography_panel',
		'priority' => 0,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_h5_typography_heading',
		'section'     => 'urbantaxi_h5_typography_setting',
		'default'     => urbantaxi_customizer_heading( __( 'Heading 5 Typography', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'  =>  'typography',
		'settings'  => 'urbantaxi_h5_typography_font',
		'section'   =>  'urbantaxi_h5_typography_setting',
		'default'   =>  [
			'font-family'   =>  "'Lexend'",
			'variant'       =>  '600',
			'font-size'       => '',
			'line-height'   =>  '',
			'letter-spacing'    =>  '',
			'text-transform'    =>  '',
		],
		'transport'     =>  'auto',
		'output'        =>  [
			[
				'element'   =>  'h5',
				'suffix' => '!important'
			],
		],
	) );

	//Heading 6 Section

	Kirki::add_section( 'urbantaxi_h6_typography_setting', array(
		'title'    => __( 'Heading 6', 'urbantaxi' ),
		'panel'    => 'urbantaxi_typography_panel',
		'priority' => 0,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_h6_typography_heading',
		'section'     => 'urbantaxi_h6_typography_setting',
		'default'     => urbantaxi_customizer_heading( __( 'Heading 6 Typography', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'  =>  'typography',
		'settings'  => 'urbantaxi_h6_typography_font',
		'section'   =>  'urbantaxi_h6_typography_setting',
		'default'   =>  [
			'font-family'   =>  "'Lexend'",
			'variant'       =>  '700',
			'font-size'       => '',
			'line-height'   =>  '',
			'letter-spacing'    =>  '',
			'text-transform'    =>  '',
		],
		'transport'     =>  'auto',
		'output'        =>  [
			[
				'element'   =>  'h6',
				'suffix' => '!important'
			],
		],
	) );

	//body Typography

	Kirki::add_section( 'urbantaxi_body_typography_setting', array(
		'title'    => __( 'Content Typography', 'urbantaxi' ),
		'panel'    => 'urbantaxi_typography_panel',
		'priority' => 0,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_body_typography_heading',
		'section'     => 'urbantaxi_body_typography_setting',
		'default'     => urbantaxi_customizer_heading( __( 'Content  Typography', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'  =>  'typography',
		'settings'  => 'urbantaxi_body_typography_font',
		'section'   =>  'urbantaxi_body_typography_setting',
		'default'   =>  [
			'font-family'   =>  "'Lexend'",
			'variant'       =>  '',
		],
		'transport'     =>  'auto',
		'output'        =>  [
			[
				'element'   => 'body',
				'suffix' => '!important'
			],
		],
	) );

	//Theme Options Panel

	Kirki::add_panel( 'urbantaxi_theme_options_panel', array(
		'priority' => 10,
		'title'    => __( 'Theme Options', 'urbantaxi' ),
	) );

	// HEADER SECTION

	Kirki::add_section( 'urbantaxi_section_header',array(
		'title' => esc_html__( 'Header Settings', 'urbantaxi' ),
		'description'    => esc_html__( 'Here you can add header information.', 'urbantaxi' ),
		'panel' => 'urbantaxi_theme_options_panel',
		'tabs'  => [
			'menu'  => [
				'label' => esc_html__( 'Menu', 'urbantaxi' ),
			],
		],
		'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'menu',
		'settings'    => 'urbantaxi_menu_size_heading',
		'section'     => 'urbantaxi_section_header',
		'default'     => urbantaxi_customizer_heading( __( 'Menu Font Size(px)', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'urbantaxi_menu_size',
		'tab'      => 'menu',
		'label'       => __( 'Enter a value in pixels. Example:20px', 'urbantaxi' ),
		'type'        => 'text',
		'section'     => 'urbantaxi_section_header',
		'transport' => 'auto',
		'output' => array(
			array(
				'element'  => array( '#main-menu a', '#main-menu ul li a', '#main-menu li a'),
				'property' => 'font-size',
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'menu',
		'settings'    => 'urbantaxi_menu_text_transform_heading',
		'section'     => 'urbantaxi_section_header',
		'default'     => urbantaxi_customizer_heading( __( 'Menu Text Transform', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'select',
		'tab'      => 'menu',
		'settings'    => 'urbantaxi_menu_text_transform',
		'section'     => 'urbantaxi_section_header',
		'default'     => 'capitalize',
		'choices'     => [
			'none' => esc_html__( 'Normal', 'urbantaxi' ),
			'uppercase' => esc_html__( 'Uppercase', 'urbantaxi' ),
			'lowercase' => esc_html__( 'Lowercase', 'urbantaxi' ),
			'capitalize' => esc_html__( 'Capitalize', 'urbantaxi' ),
		],
		'output' => array(
			array(
				'element'  => array( '#main-menu a', '#main-menu ul li a', '#main-menu li a'),
				'property' => ' text-transform',
			),
		),
	) );

	// Kirki::add_field( 'theme_config_id', [
	// 	'type'     => 'text',
	// 	'settings' => 'urbantaxi_header_button_text',
	// 	'section'  => 'urbantaxi_section_header',
	// 	'default'  => esc_html__('Read More', 'urbantaxi'),
	// ] );

	// Kirki::add_field( 'theme_config_id', [
	// 	'type'     => 'text',
	// 	'label'       => esc_html__( 'Button Link', 'urbantaxi' ),
	// 	'tab'      => 'header',
	// 	'settings' => 'urbantaxi_header_button_link',
	// 	'section'  => 'urbantaxi_section_header',
	// 	'default'  => '',
	// 	'sanitize_callback' => 'esc_url_raw',
	// ] );
	
	//ADDITIONAL SETTINGS

	Kirki::add_section( 'urbantaxi_additional_setting', array(
		'title'          => esc_html__( 'Additional Settings', 'urbantaxi' ),
		'description'    => esc_html__( 'Additional Settings of themes', 'urbantaxi' ),
		'panel'    => 'urbantaxi_theme_options_panel',
		'priority'       => 10,
		'tabs'  => [
			'general' => [
				'label' => esc_html__( 'General', 'urbantaxi' ),
			],
			'header-image'  => [
				'label' => esc_html__( 'Header Image', 'urbantaxi' ),
			],
		],
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'urbantaxi_preloader_hide',
		'label'       => esc_html__( 'Here you can enable or disable your preloader.', 'urbantaxi' ),
		'section'     => 'urbantaxi_additional_setting',
		'default'     => true,
		'priority'    => 10,
		'tab'      => 'general',
	] );
 
	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'urbantaxi_scroll_enable_setting',
		'label'       => esc_html__( 'Here you can enable or disable your scroller.', 'urbantaxi' ),
		'section'     => 'urbantaxi_additional_setting',
		'default'     => true ,
		'priority'    => 10,
		'tab'      => 'general',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'general',
		'settings'    => 'urbantaxi_scroll_alignment_heading',
		'section'     => 'urbantaxi_additional_setting',
		'default'     => urbantaxi_customizer_heading( __( 'Scroll To Top Position', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'radio-buttonset',
		'tab'      => 'general',
		'settings'    => 'urbantaxi_scroll_alignment',
		'section'     => 'urbantaxi_additional_setting',
		'default'     => 'right',
		'choices'     => [
			'left' => esc_html__( 'left', 'urbantaxi' ),
			'center' => esc_html__( 'center', 'urbantaxi' ),
			'right' => esc_html__( 'right', 'urbantaxi' ),
		]
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'general',
		'settings'    => 'urbantaxi_scroller_border_radius_heading',
		'section'     => 'urbantaxi_additional_setting',
		'default'     => urbantaxi_customizer_heading( __( 'Scroll To Top Border Radius', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'slider',
		'tab'      => 'general',
		'settings'    => 'urbantaxi_scroller_border_radius',
		'section'     => 'urbantaxi_additional_setting',
		'default'     => '50',
		'choices'     => [
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		],
		'output' => array(
			array(
				'element'  => '.scroll-up a',
				'property' => 'border-radius',
				'units' => 'px',
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'general',
		'settings'    => 'urbantaxi_cursor_outline_heading',
		'section'     => 'urbantaxi_additional_setting',
		'default'         => urbantaxi_customizer_heading( __( 'Dot Cursor', 'urbantaxi' ) ),
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'general',
		'settings'    => 'urbantaxi_cursor_outline',
		'label'       => esc_html__( 'Enable or Disable Dot Cursor', 'urbantaxi' ),
		'section'     => 'urbantaxi_additional_setting',
		'default'     => false,
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'general',
		'settings'    => 'urbantaxi_progress_bar_heading',
		'section'     => 'urbantaxi_additional_setting',
		'default'         => urbantaxi_customizer_heading( __( 'Progress Bar', 'urbantaxi' ) ),
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'general',
		'settings'    => 'urbantaxi_progress_bar',
		'label'       => esc_html__( 'Enable or Disable Progress Bar', 'urbantaxi' ),
		'section'     => 'urbantaxi_additional_setting',
		'default'     => false,
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'general',
		'settings'    => 'urbantaxi_progress_bar_position_heading',
		'section'     => 'urbantaxi_additional_setting',
		'default'         => urbantaxi_customizer_heading( __( 'Progress Bar Position', 'urbantaxi' ) ),
		'priority'    => 10,
		'active_callback'  => [
			[
				'setting'  => 'urbantaxi_progress_bar',
				'operator' => '===',
				'value'    => true,
			],
		]
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'select',
		'tab'      => 'general',
		'settings'    => 'urbantaxi_progress_bar_position',
		'section'     => 'urbantaxi_additional_setting',
		'default'     => 'top',
		'choices'     => [
			'top' => esc_html__( 'Top', 'urbantaxi' ),
			'bottom' => esc_html__( 'Bottom', 'urbantaxi' ),
		],
		'active_callback'  => [
			[
				'setting'  => 'urbantaxi_progress_bar',
				'operator' => '===',
				'value'    => true,
			],
		]
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'general',
		'settings'    => 'urbantaxi_progress_bar_color_heading',
		'section'     => 'urbantaxi_additional_setting',
		'default'         => urbantaxi_customizer_heading( __( 'Progress Bar Color', 'urbantaxi' ) ),
		'priority'    => 10,
		'active_callback'  => [
			[
				'setting'  => 'urbantaxi_progress_bar',
				'operator' => '===',
				'value'    => true,
			],
		]
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'urbantaxi_progress_bar_color',
		'tab'      => 'general',
		'label'       => __( 'Color', 'urbantaxi' ),
		'type'        => 'color',
		'section'     => 'urbantaxi_additional_setting',
		'transport' => 'auto',
		'default'     => '#FDC702',
		'choices'     => [
			'alpha' => true,
		],
		'output' => array(
			array(
				'element'  => '#elemento-progress-bar',
				'property' => 'background-color',
			),
		),
		'active_callback'  => [
			[
				'setting'  => 'urbantaxi_progress_bar',
				'operator' => '===',
				'value'    => true,
			],
		]
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'general',
		'settings'    => 'urbantaxi_single_page_layout_heading',
		'section'     => 'urbantaxi_additional_setting',
		'default'     => urbantaxi_customizer_heading( __( 'Single Page Layout', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'select',
		'tab'      => 'general',
		'settings'    => 'urbantaxi_single_page_layout',
		'section'     => 'urbantaxi_additional_setting',
		'default'     => 'One Column',
		'choices'     => [
			'Left Sidebar' => esc_html__( 'Left Sidebar', 'urbantaxi' ),
			'Right Sidebar' => esc_html__( 'Right Sidebar', 'urbantaxi' ),
			'One Column' => esc_html__( 'One Column', 'urbantaxi' ),
		],
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'header-image',
		'settings'    => 'urbantaxi_header_background_attachment_heading',
		'section'     => 'urbantaxi_additional_setting',
		'default'     => urbantaxi_customizer_heading( __( 'Header Image Attachment', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'select',
		'tab'      => 'header-image',
		'settings'    => 'urbantaxi_header_background_attachment',
		'section'     => 'urbantaxi_additional_setting',
		'default'     => 'scroll',
		'choices'     => [
			'scroll' => esc_html__( 'Scroll', 'urbantaxi' ),
			'fixed' => esc_html__( 'Fixed', 'urbantaxi' ),
		],
		'output' => array(
			array(
				'element'  => '.title-banner-image-box',
				'property' => 'background-attachment',
			),
		),
	 ) );

	// loader change setting

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_loader_background_widget_heading',
		'section'     => 'urbantaxi_additional_setting',
		'default'     => urbantaxi_customizer_heading( __( 'Loader Widget Background', 'urbantaxi' ) ),
		'priority'    => 10,
	] );


    Kirki::add_field( 'theme_config_id',
    [
        'settings'    => 'urbantaxi_loader_background_widget',
        'type'        => 'image',
        'section'     => 'urbantaxi_additional_setting',
        'label'       => __( 'Loader Background Image', 'urbantaxi' ),
        'default'     => get_template_directory_uri() . '/assets/images/loader.gif',
        'transport'   => 'refresh',
    ]);


	// loader setting end

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'header-image',
		'settings'    => 'urbantaxi_header_image_height_heading',
		'section'     => 'urbantaxi_additional_setting',
		'default'     => urbantaxi_customizer_heading( __( 'Header Image height', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'urbantaxi_header_image_height',
		'label'       => __( 'Image Height', 'urbantaxi' ),
		'description'    => esc_html__( 'Enter a value in pixels. Example:500px', 'urbantaxi' ),
		'type'        => 'text',
		'tab'      => 'header-image',
		'default'    => [
			'desktop' => '250px',
			'tablet'  => '250px',
			'mobile'  => '250px',
		],
		'responsive' => true,
		'section'     => 'urbantaxi_additional_setting',
		'transport' => 'auto',
		'output' => array(
			array(
				'element'  => array('.title-banner-image-box'),
				'property' => 'height',
				'media_query' => [
					'desktop' => '@media (min-width: 1024px)',
					'tablet'  => '@media (min-width: 768px) and (max-width: 1023px)',
					'mobile'  => '@media (max-width: 767px)',
				],
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'header-image',
		'settings'    => 'urbantaxi_header_overlay_heading',
		'section'     => 'urbantaxi_additional_setting',
		'default'     => urbantaxi_customizer_heading( __( 'Header Image Overlay', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'header-image',
		'settings'    => 'urbantaxi_header_page_title',
		'label'       => esc_html__( 'Enable / Disable Header Image Page Title.', 'urbantaxi' ),
		'section'     => 'urbantaxi_additional_setting',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'header-image',
		'settings'    => 'urbantaxi_header_taxi_title',
		'label'       => esc_html__( 'Enable / Disable Header Image Page Background Title.', 'urbantaxi' ),
		'section'     => 'urbantaxi_additional_setting',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id',
    [
        'settings'  => 'urbantaxi_header_taxi_title',
        'type'      => 'text',
        'section'   => 'urbantaxi_additional_setting',
        'label'     => __( 'Title Banner Text', 'urbantaxi' ),
        'default'   => __( 'TAXI SERVICE', 'urbantaxi' ),
        'transport' => 'refresh',
    ] );

	Kirki::add_field( 'theme_config_id',
    [
        'settings'    => 'urbantaxi_header_taxi_right_image',
        'type'        => 'image',
        'section'     => 'urbantaxi_additional_setting',
        'label'       => __( 'Title Banner Image', 'urbantaxi' ),
        'default'     => get_template_directory_uri() . '/assets/images/urbantaxi-banner-car-image.png',
        'transport'   => 'refresh',
    ]);

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'header-image',
		'settings'    => 'urbantaxi_header_breadcrumb',
		'label'       => esc_html__( 'Enable / Disable Header Image Breadcrumb.', 'urbantaxi' ),
		'section'     => 'urbantaxi_additional_setting',
		'default'     => '1',
		'priority'    => 10,
	] );

	// POST SECTION

	Kirki::add_section( 'urbantaxi_blog_post', array(
		'title'          => esc_html__( 'Post Settings', 'urbantaxi' ),
		'description'    => esc_html__( 'Here you can add post information.', 'urbantaxi' ),
		'panel'    => 'urbantaxi_theme_options_panel',
		'tabs'  => [
			'blog-post' => [
				'label' => esc_html__( 'Blog Post', 'urbantaxi' ),
			],
			'single-post'  => [
				'label' => esc_html__( 'Single Post', 'urbantaxi' ),
			],
		],
		'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'blog-post',
		'settings'    => 'urbantaxi_enable_post_animation_heading',
		'section'     => 'urbantaxi_blog_post',
		'default'         => urbantaxi_customizer_heading( __( 'Animation', 'urbantaxi' ) ),
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'blog-post',
		'settings'    => 'urbantaxi_enable_post_animation',
		'label'       => esc_html__( 'Enable or Disable Blog Post Animation', 'urbantaxi' ),
		'section'     => 'urbantaxi_blog_post',
		'default'     => true,
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'blog-post',
		'settings'    => 'urbantaxi_post_layout_heading',
		'section'     => 'urbantaxi_blog_post',
		'default'     => urbantaxi_customizer_heading( __( 'Blog Layout', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'select',
		'tab'      => 'blog-post',
		'settings'    => 'urbantaxi_post_layout',
		'section'     => 'urbantaxi_blog_post',
		'default'     => 'Right Sidebar',
		'choices'     => [
			'Left Sidebar' => esc_html__( 'Left Sidebar', 'urbantaxi' ),
			'Right Sidebar' => esc_html__( 'Right Sidebar', 'urbantaxi' ),
			'One Column' => esc_html__( 'One Column', 'urbantaxi' ),
			'Three Columns' => esc_html__( 'Three Columns', 'urbantaxi' ),
			'Four Columns' => esc_html__( 'Four Columns', 'urbantaxi' ),
		],
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'single-post',
		'settings'    => 'urbantaxi_single_post_date_hide',
		'label'       => esc_html__( 'Enable / Disable Single Post Date', 'urbantaxi' ),
		'section'     => 'urbantaxi_blog_post',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'single-post',
		'settings'    => 'urbantaxi_single_post_author_hide',
		'label'       => esc_html__( 'Enable / Disable Single Post Author', 'urbantaxi' ),
		'section'     => 'urbantaxi_blog_post',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'single-post',
		'settings'    => 'urbantaxi_single_post_comment_hide',
		'label'       => esc_html__( 'Enable / Disable Single Post Comment', 'urbantaxi' ),
		'section'     => 'urbantaxi_blog_post',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'single-post',
		'label'       => esc_html__( 'Enable / Disable Single Post Tag', 'urbantaxi' ),
		'settings'    => 'urbantaxi_single_post_tag',
		'section'     => 'urbantaxi_blog_post',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'single-post',
		'label'       => esc_html__( 'Enable / Disable Single Post Category', 'urbantaxi' ),
		'settings'    => 'urbantaxi_single_post_category',
		'section'     => 'urbantaxi_blog_post',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'single-post',
		'settings'    => 'urbantaxi_single_post_featured_image',
		'label'       => esc_html__( 'Enable / Disable Single Post Image', 'urbantaxi' ),
		'section'     => 'urbantaxi_blog_post',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'single-post',
		'settings'    => 'urbantaxi_single_post_radius',
		'section'     => 'urbantaxi_blog_post',
		'default'     => urbantaxi_customizer_heading( __( 'Single Post Image Border Radius(px)', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'urbantaxi_single_post_border_radius',
		'label'       => __( 'Enter a value in pixels. Example:15px', 'urbantaxi' ),
		'type'        => 'text',
		'tab'      => 'single-post',
		'section'     => 'urbantaxi_blog_post',
		'transport' => 'auto',
		'output' => array(
			array(
				'element'  => array('.post-img img'),
				'property' => 'border-radius',
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'single-post',
		'settings'    => 'urbantaxi_show_related_post_heading',
		'section'     => 'urbantaxi_blog_post',
		'default'         => urbantaxi_customizer_heading( __( 'Related post', 'urbantaxi' ) ),
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'single-post',
		'settings'    => 'urbantaxi_show_related_post',
		'label'       => esc_html__( 'Enable or Disable Related post', 'urbantaxi' ),
		'section'     => 'urbantaxi_blog_post',
		'default'     => true,
		'priority'    => 10,
	] );

	// No Results Page Settings

	Kirki::add_section( 'urbantaxi_no_result_section', array(
		'title'          => esc_html__( '404 & No Results Page Settings', 'urbantaxi' ),
		'panel'    => 'urbantaxi_theme_options_panel',
		'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_page_not_found_title_heading',
		'section'     => 'urbantaxi_no_result_section',
		'default'         => urbantaxi_customizer_heading( __( '404 Page Title', 'urbantaxi' ) ),
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'urbantaxi_page_not_found_title',
		'section'  => 'urbantaxi_no_result_section',
		'default'  => esc_html__('404 Error!', 'urbantaxi'),
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_page_not_found_text_heading',
		'section'     => 'urbantaxi_no_result_section',
		'default'         => urbantaxi_customizer_heading( __( '404 Page Text', 'urbantaxi' ) ),
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'urbantaxi_page_not_found_text',
		'section'  => 'urbantaxi_no_result_section',
		'default'  => esc_html__('We’re sorry — something has gone wrong on our end.', 'urbantaxi'),
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_page_not_found_button_text_heading',
		'section'     => 'urbantaxi_no_result_section',
		'default'         => urbantaxi_customizer_heading( __( '404 Page Button Text', 'urbantaxi' ) ),
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'urbantaxi_page_not_found_button_text',
		'section'  => 'urbantaxi_no_result_section',
		'default'  => esc_html__('Back To Home', 'urbantaxi'),
	] );


	Kirki::add_field( 'theme_config_id', array(
		'type'     => 'custom',
		'settings' => 'urbantaxi_page_not_found_line_break',
		'section'  => 'urbantaxi_no_result_section',
		'default'  => '<hr>',
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_no_results_title_heading',
		'section'     => 'urbantaxi_no_result_section',
		'default'         => urbantaxi_customizer_heading( __( 'No Results Title', 'urbantaxi' ) ),
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'urbantaxi_no_results_title',
		'section'  => 'urbantaxi_no_result_section',
		'default'  => esc_html__('Nothing Found', 'urbantaxi'),
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_no_results_content_heading',
		'section'     => 'urbantaxi_no_result_section',
		'default'         => urbantaxi_customizer_heading( __( 'No Results Content', 'urbantaxi' ) ),
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'urbantaxi_no_results_content',
		'section'  => 'urbantaxi_no_result_section',
		'default'  => esc_html__('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'urbantaxi'),
	] );
	
	// FOOTER SECTION

	Kirki::add_section( 'urbantaxi_footer_section', array(
        'title'          => esc_html__( 'Footer Settings', 'urbantaxi' ),
        'description'    => esc_html__( 'Here you can change copyright text', 'urbantaxi' ),
        'panel'    => 'urbantaxi_theme_options_panel',
		'priority'       => 160,
    ) );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_show_footer_widget_heading',
		'section'     => 'urbantaxi_footer_section',
		'default'         => urbantaxi_customizer_heading( __( 'Enable / Disable', 'urbantaxi' ) ),
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'urbantaxi_show_footer_widget',
		'label'       => esc_html__( 'Footer Widget', 'urbantaxi' ),
		'section'     => 'urbantaxi_footer_section',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'urbantaxi_show_footer_copyright',
		'label'       => esc_html__( 'Footer Copyright', 'urbantaxi' ),
		'section'     => 'urbantaxi_footer_section',
		'default'     => '1',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_footer_enable_heading',
		'section'     => 'urbantaxi_footer_section',
		'default'         => urbantaxi_customizer_heading( __( 'Enable / Disable Footer Link', 'urbantaxi' ) ),
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'urbantaxi_copyright_enable',
		'label'       => esc_html__( 'Section Enable / Disable', 'urbantaxi' ),
		'section'     => 'urbantaxi_footer_section',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'urbantaxi' ),
			'off' => esc_html__( 'Disable', 'urbantaxi' ),
		],
	] );


	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'urbantaxi_copyright_text',
		'section'  => 'urbantaxi_footer_section',
		'default'  => esc_html__('Copyright ©2026 Design & Developed by', 'urbantaxi'),
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'tab'      => 'header',
		'label'    => esc_html__( 'Copyright Url', 'urbantaxi' ),
		'settings' => 'urbantaxi_copyright_url',
		'section'  => 'urbantaxi_footer_section',
		'default'  => '',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'urbantaxi_copyright_author_text',
		'section'  => 'urbantaxi_footer_section',
		'default'  => esc_html__('VowelWeb', 'urbantaxi'),
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_footer_widget_alignment_heading',
		'section'     => 'urbantaxi_footer_section',
		'default'     => urbantaxi_customizer_heading( __( 'Footer Widget Alignment', 'urbantaxi' ) ),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'select',
		'settings'    => 'urbantaxi_footer_widget_alignment',
		'section'     => 'urbantaxi_footer_section',
		'default'     =>[
			'desktop' => 'left',
			'tablet'  => 'left',
			'mobile'  => 'center',
		],
		'responsive' => true,
		'label'       => __( 'Widget Alignment', 'urbantaxi' ),
		'transport' => 'auto',
		'choices'     => [
			'center' => esc_html__( 'center', 'urbantaxi' ),
			'right' => esc_html__( 'right', 'urbantaxi' ),
			'left' => esc_html__( 'left', 'urbantaxi' ),
		],
		'output' => array(
			array(
				'element'  => '.footer-area',
				'property' => 'text-align',
				'media_query' => [
					'desktop' => '@media (min-width: 1024px)',
					'tablet'  => '@media (min-width: 768px) and (max-width: 1023px)',
					'mobile'  => '@media (max-width: 767px)',
				],
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_footer_copright_color_heading',
		'section'     => 'urbantaxi_footer_section',
		'default'         => urbantaxi_customizer_heading( __( 'Copyright Background Color', 'urbantaxi' ) ),
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'urbantaxi_footer_copright_color',
		'type'        => 'color',
		'label'       => __( 'Background Color', 'urbantaxi' ),
		'section'     => 'urbantaxi_footer_section',
		'transport' => 'auto',
		'default'     => '#FDC702',
		'choices'     => [
			'alpha' => true,
		],
		'output' => array(
			array(
				'element'  => '.footer-copyright',
				'property' => 'background',
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'urbantaxi_footer_copright_text_color_heading',
		'section'     => 'urbantaxi_footer_section',
		'default'         => urbantaxi_customizer_heading( __( 'Copyright Text Color', 'urbantaxi' ) ),
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'urbantaxi_footer_copright_text_color',
		'type'        => 'color',
		'label'       => __( 'Text Color', 'urbantaxi' ),
		'section'     => 'urbantaxi_footer_section',
		'transport' => 'auto',
		'default'     => '#ffffff',
		'choices'     => [
			'alpha' => true,
		],
		'output' => array(
			array(
				'element'  => array( '.footer-copyright a', '.footer-copyright p'),
				'property' => 'color',
			),
		),
	) );

	load_template( trailingslashit( get_template_directory() ) . '/includes/logo/logo-resizer.php' );
} else {

	if ( current_user_can( 'edit_theme_options' ) ) {
		add_action( 'customize_register', 'urbantaxi_fallback_controls' );
	}

	function urbantaxi_fallback_controls( $wp_customize ) {
		// Add a blank panel so "Theme Options" still appears in the Customizer.
		$wp_customize->add_panel( 'urbantaxi_fallback_kirki_panel_id', array(
			'title'       => __( 'Theme Options', 'urbantaxi' ),
			'description' => __( 'Urbantaxi uses the Kirki Customizer Toolkit for theme options. Kirki is not active or installed.', 'urbantaxi' ),
			'priority'    => 160,
		) );

		// Add an empty section inside the fallback panel.
		$wp_customize->add_section( 'urbantaxi_fallback_kirki_panel', array(
			'title' => __( 'Theme Options', 'urbantaxi' ),
			'panel' => 'urbantaxi_fallback_kirki_panel_id',
		) );

		// Show a simple notice with an install link.
		$install_url = esc_url( admin_url( 'plugin-install.php?s=Kirki&tab=search&type=term' ) );
		$message = sprintf(
			'<p>%s</p><p><a class="button button-primary" href="%s" target="_blank" rel="noopener">%s</a></p>',
			esc_html__( 'This theme requires the Kirki Customizer Toolkit for full Theme Options. Kirki is not installed or active.', 'urbantaxi' ),
			$install_url,
			esc_html__( 'Install Kirki', 'urbantaxi' )
		);

		$wp_customize->add_setting( 'urbantaxi_fallback_kirki_notice', array(
			'sanitize_callback' => 'wp_kses_post',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'urbantaxi_fallback_kirki_notice_control', array(
			'section'     => 'urbantaxi_fallback_kirki_panel',
			'settings'    => 'urbantaxi_fallback_kirki_notice',
			'label'       => '',
			'description' => $message,
			'type'        => 'hidden',
		) ) );
	}

}
