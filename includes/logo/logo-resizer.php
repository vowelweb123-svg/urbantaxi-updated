<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */


/**
 * Add support for logo dimensions retrieval
 */
function urbantaxi_get_logo_dimensions() {
	static $dimensions = null;

	if ( null !== $dimensions ) {
		return $dimensions;
	}

	$size           = absint( get_theme_mod( 'logo_size' ) );
	$custom_logo_id = absint( get_theme_mod( 'custom_logo' ) );
	$min            = 48;

	if ( ! $size || ! $custom_logo_id ) {
		return null;
	}

	$logo = wp_get_attachment_metadata( $custom_logo_id );
	if ( ! $logo ) {
		return null;
	}

	$sizes = get_theme_support( 'custom-logo' );

	$max_height = isset( $sizes[0]['height'] ) ? absint( $sizes[0]['height'] ) : absint( $logo['height'] );
	$max_width  = isset( $sizes[0]['width'] ) ? absint( $sizes[0]['width'] ) : absint( $logo['width'] );

	if ( $logo['width'] >= $logo['height'] ) {
		$output = urbantaxi_min_max(
			$logo['height'],
			$logo['width'],
			$max_height,
			$max_width,
			$size,
			$min
		);

		$dimensions = array(
			'height' => absint( $output['short'] ),
			'width'  => absint( $output['long'] ),
			'max_h'  => $max_height,
			'max_w'  => $max_width,
		);
	} else {
		$output = urbantaxi_min_max(
			$logo['width'],
			$logo['height'],
			$max_width,
			$max_height,
			$size,
			$min
		);

		$dimensions = array(
			'height' => absint( $output['long'] ),
			'width'  => absint( $output['short'] ),
			'max_h'  => $max_height,
			'max_w'  => $max_width,
		);
	}

	return $dimensions;
}

/**
 * Add support for logo resizing by filtering `get_custom_logo`
 */
function urbantaxi_customize_logo_resize( $html ) {
	// Ensure numeric values are sanitized before use in CSS
	$size = absint( get_theme_mod( 'logo_size' ) );
	$custom_logo_id = absint( get_theme_mod( 'custom_logo' ) );
	// set the short side minimum
	$min = 48;

	// don't use empty() because we can still use a 0
	if ( is_numeric( $size ) && is_numeric( $custom_logo_id ) ) {

		// we're looking for $img['width'] and $img['height'] of original image
		$logo = wp_get_attachment_metadata( $custom_logo_id );
		if ( ! $logo ) return $html;

		// get the logo support size
		$sizes = get_theme_support( 'custom-logo' );

		// Check for max height and width, default to image sizes if none set in theme
		$max['height'] = isset( $sizes[0]['height'] ) ? $sizes[0]['height'] : $logo['height'];
		$max['width'] = isset( $sizes[0]['width'] ) ? $sizes[0]['width'] : $logo['width'];

		// landscape or square
		if ( $logo['width'] >= $logo['height'] ) {
			$output = urbantaxi_min_max( $logo['height'], $logo['width'], $max['height'], $max['width'], $size, $min );
			$img = array(
				'height'	=> $output['short'],
				'width'		=> $output['long']
			);
		// portrait
		} else if ( $logo['width'] < $logo['height'] ) {
			$output = urbantaxi_min_max( $logo['width'], $logo['height'], $max['width'], $max['height'], $size, $min );
			$img = array(
				'height'	=> $output['long'],
				'width'		=> $output['short']
			);
		}

		$html = $html;
	}

	return $html;
}
add_filter( 'get_custom_logo', 'urbantaxi_customize_logo_resize' );

/* Helper function to determine the max size of the logo */
function urbantaxi_min_max( $short, $long, $short_max, $long_max, $percent, $min ){
	$ratio = ( $long / $short );
	$max['long'] = ( $long_max >= $long ) ? $long : $long_max;
	$max['short'] = ( $short_max >= ( $max['long'] / $ratio ) ) ? floor( $max['long'] / $ratio ) : $short_max;

	$ppp = ( $max['short'] - $min ) / 100;

	$size['short'] = round( $min + ( $percent * $ppp ) );
	$size['long'] = round( $size['short'] / ( $short / $long ) );

	return $size;
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function urbantaxi_customize_preview_js() {
	wp_enqueue_script( 'urbantaxi-customizer', esc_url(get_template_directory_uri()) . '/includes/logo/js/customize-preview.js', array( 'jquery', 'customize-preview' ), '201709081119', true );
}
add_action( 'customize_preview_init', 'urbantaxi_customize_preview_js' );

/**
 * JS handlers for Customizer Controls
 */
function urbantaxi_customize_controls_js() {
	wp_enqueue_script( 'urbantaxi-customizer-controls', esc_url(get_template_directory_uri()) . '/includes/logo/js/customize-controls.js', array( 'jquery', 'customize-preview' ), '201709071000', true );
}
add_action( 'customize_controls_enqueue_scripts', 'urbantaxi_customize_controls_js' );

/**
 * Testing function to remove logo_size theme mod
 */
function urbantaxi_remove_theme_mod() {

	// Capability check (only admins should reset theme mods)
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	// Validate and sanitize GET param
	if (
		isset( $_GET['remove_logo_size'] ) &&
		'true' === sanitize_text_field( wp_unslash( $_GET['remove_logo_size'] ) )
	) {
		remove_theme_mod( 'logo_size' );
	}
}
add_action( 'wp_loaded', 'urbantaxi_remove_theme_mod' );

