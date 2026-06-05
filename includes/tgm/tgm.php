<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
	
require get_template_directory() . '/includes/tgm/class-tgm-plugin-activation.php';

/**
 * Recommended plugins.
 */
function urbantaxi_register_recommended_plugins() {
	
	$plugins = array(
		array(
			'name'             => __( 'One Click Demo Import', 'urbantaxi' ),
			'slug'             => 'one-click-demo-import',
			'required'         => true,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'ElementsKit Lite', 'urbantaxi' ),
			'slug'             => 'elementskit-lite',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'Elementor', 'urbantaxi' ),
			'slug'             => 'elementor',
			'required'         => false,
			'force_activation' => false,
		), 
		array(
			'name'             => __( 'Ultimate Addons For Elementor', 'urbantaxi' ),
			'slug'             => 'header-footer-elementor',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'Unlimited Elements for Elementor', 'urbantaxi' ),
			'slug'             => 'unlimited-elements-for-elementor',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'Contact Form 7', 'urbantaxi' ),
			'slug'             => 'contact-form-7',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'PowerPack Elementor Addons', 'urbantaxi' ),
			'slug'             => 'powerpack-lite-for-elementor',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'Font Awesome', 'urbantaxi' ),
			'slug'             => 'font-awesome',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name' 				=> __( 'SVG Support', 'urbantaxi' ),
			'slug' 				=> 'svg-support',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'             => __( 'Kirki Customizer Framework', 'urbantaxi' ),
			'slug'             => 'kirki',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name'              => __( 'WooCommerce', 'urbantaxi' ),
            'slug'              => 'woocommerce',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'E-cab Taxi Booking Manager for Woocommerce', 'urbantaxi' ),
            'slug'              => 'ecab-taxi-booking-manager',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'Urbantaxi Core', 'urbantaxi' ),
            'slug'              => 'urbantaxi-core',
            'source'            => Urbantaxi_SERVER_URL . 'plugins/urbantaxi-core.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
	);
	
	$config = array();
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'urbantaxi_register_recommended_plugins' );
