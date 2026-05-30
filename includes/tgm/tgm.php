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
			'name'              => __( 'Urbantaxi Heading Style Widget', 'urbantaxi' ),
            'slug'              => 'heading-style-widget',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/heading-style-widget.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'Cost Calculator Core', 'urbantaxi' ),
            'slug'              => 'cost-calculator-core',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/cost-calculator-core.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'Urbantaxi Animated Heading', 'urbantaxi' ),
            'slug'              => 'urbantaxi-animated-heading',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/urbantaxi-animated-heading.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'UrbanTaxi Book Seat Widget', 'urbantaxi' ),
            'slug'              => 'urbantaxi-book-seat-widget',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/urbantaxi-book-seat-widget.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'Urban Taxi Cab Booking Slider Widget', 'urbantaxi' ),
            'slug'              => 'urban-taxi-cab-booking-slider',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/urban-taxi-cab-booking-slider.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'Urban Taxi Cab Filter Widget', 'urbantaxi' ),
            'slug'              => 'urban-taxi-cab-filter-widget',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/urban-taxi-cab-filter-widget.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'Urban Taxi Client Testimonial', 'urbantaxi' ),
            'slug'              => 'urban-taxi-client-testimonial',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/urban-taxi-client-testimonial.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'Urbantaxi Custom Post Type', 'urbantaxi' ),
            'slug'              => 'urbantaxi-custom-post-type',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/urbantaxi-custom-post-type.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'UrbanTaxi Hero Slider Widget', 'urbantaxi' ),
            'slug'              => 'urbantaxi-hero-slider',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/urbantaxi-hero-slider-widget.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'UrbanTaxi Our Blog Widget', 'urbantaxi' ),
            'slug'              => 'urbantaxi-our-blog-widget',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/urbantaxi-our-blog-widget.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'UrbanTaxi Service Cards Widget', 'urbantaxi' ),
            'slug'              => 'urbantaxi-service-cards-widget',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/urbantaxi-service-cards-widget.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'UrbanTaxi Smart Animations', 'urbantaxi' ),
            'slug'              => 'urbantaxi-smart-animations',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/urbantaxi-smart-animations.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'UrbanTaxi Sticky Mission', 'urbantaxi' ),
            'slug'              => 'urbantaxi-sticky-mission',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/urbantaxi-sticky-mission.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'UrbanTaxi Taxonomy Widget', 'urbantaxi' ),
            'slug'              => 'urbantaxi-taxonomy-widget',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/urbantaxi-taxonomy-widget.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'UrbanTaxi Timeline Widget', 'urbantaxi' ),
            'slug'              => 'urbantaxi-timeline-widget',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/urbantaxi-timeline-widget.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
		array(
			'name'              => __( 'UrbanTaxi Team Widget', 'urbantaxi' ),
            'slug'              => 'urbantaxi-team-widget',
            'source'            => Urbantaxi_SERVER_URL . '/plugins/urbantaxi-team-widget.zip',
			'required' 			=> false,
			'force_activation' 	=> false,
		),
	);
	
	$config = array();
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'urbantaxi_register_recommended_plugins' );
