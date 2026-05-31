<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}
function urbantaxi_get_page_id_by_title($pagename, $post_type){
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => 1,
        'title' => $pagename
    );

    $query = new WP_Query( $args );

    $page_id = '';
    if (isset($query->post->ID)) {
        $page_id = $query->post->ID;
    }

    return $page_id;
}

function urbantaxi_after_import_setup() {
     // for deleting location default posts start
    $settings = get_option('mptbm_general_settings');

    if (!is_array($settings)) {
        $settings = [];
    }

    $settings['enable_view_search_result_page'] = 'slider-booking-form';
    $settings['enable_return_in_different_date'] = 'yes';
    $settings['enable_filter_via_features'] = 'yes';
    $settings['show_summary_mobile'] = 'yes';

    update_option('mptbm_general_settings', $settings);

    $terms = get_terms([
        'taxonomy' => 'locations',
        'hide_empty' => false,
        'name' => ['Chittagong', 'Dhaka', 'Rajshahi', 'Sylhet'],
    ]);

    if (!is_wp_error($terms) && !empty($terms)) {
        foreach ($terms as $term) {
            wp_delete_term($term->term_id, 'locations');
        }
    }
    // for deleting location default posts end     
    $post_id = urbantaxi_get_page_id_by_title( 'Hello world!', 'post' );
    if ($post_id) {
        wp_delete_post( $post_id );
    }

    $home_page_id = urbantaxi_get_page_id_by_title( 'Home', 'page' );

    set_theme_mod( 'urbantaxi_preloader_hide', true );
    set_theme_mod( 'urbantaxi_loader_background_widget', get_template_directory_uri() . '/assets/images/loader.gif' );

    if ( $home_page_id && ! is_wp_error( $home_page_id ) ) {
        update_option( 'page_on_front', $home_page_id );
        update_option( 'show_on_front', 'page' );
    }

    $header_id = urbantaxi_get_page_id_by_title( 'Header', 'elementskit_template' );
    if ( ! $header_id ) {
        return;
    }

    $menu = wp_get_nav_menu_object( 'A Primary Menu' );
    if ( ! $menu ) {
        return;
    }

    $post_id = $header_id;
    $menu_id = (string) $menu->term_id;

    $raw = get_post_meta( $post_id, '_elementor_data', true );
    if ( empty( $raw ) ) {
        return;
    }

    $data = json_decode( wp_unslash( $raw ), true );
    if ( ! is_array( $data ) ) {
        return;
    }

    $update_menu = function ( &$elements ) use ( &$update_menu, $menu_id ) {
        foreach ( $elements as &$el ) {

            if ( isset( $el['settings']['menu_id'] ) ) {
                $el['settings']['menu_id'] = $menu_id;
            }

            if ( ! empty( $el['elements'] ) && is_array( $el['elements'] ) ) {
                $update_menu( $el['elements'] );
            }
        }
    };
    
    $update_menu( $data );

    update_post_meta(
        $post_id,
        '_elementor_data',
        wp_slash( wp_json_encode( $data ) )
    );

    if ( function_exists( 'wp_cache_flush' ) ) {
        wp_cache_flush();
    }

    if ( did_action( 'elementor/loaded' ) && class_exists( '\Elementor\Plugin' ) ) {
        \Elementor\Plugin::$instance->files_manager->clear_cache();
    }

    flush_rewrite_rules( false );

    if ( function_exists( 'wp_clean_themes_cache' ) ) {
        wp_clean_themes_cache();
    }

    // Get the latest Pre-defined Extra Services post and assign its ID to all mptbm_rent posts.
    $extra_service = get_posts( array(
        'post_type'      => 'mptbm_extra_services',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    if ( ! empty( $extra_service ) ) {
        $extra_service_id = $extra_service[0]->ID;

        $rent_posts = get_posts( array(
            'post_type'      => 'mptbm_rent',
            'posts_per_page' => -1,
            'post_status'    => 'any',
            'fields'         => 'ids',
        ) );

        foreach ( $rent_posts as $rent_post_id ) {
            update_post_meta( $rent_post_id, 'mptbm_extra_services_id', $extra_service_id );
        }
    }


    global $wpdb;

    $fields = array(
        array(
                'type' => 'dropdown',
                'label' => 'City / Location',
                'key' => 'city_location',
                'show_frontend' => true,
                'default_value' => '0',
                'options' => array(
                        array('label' => 'Los Angeles', 'value' => '10'),
                        array('label' => 'Las Vegas', 'value' => '20'),
                        array('label' => 'Dallas', 'value' => '30'),
                        array('label' => 'Charlotte', 'value' => '40'),
                ),
        ),
        array(
                'type' => 'dropdown',
                'label' => 'Vehicle Type',
                'key' => 'vehicle_type',
                'show_frontend' => true,
                'default_value' => '0',
                'options' => array(
                        array('label' => 'Mini', 'value' => '10'),
                        array('label' => 'Sedan', 'value' => '20'),
                        array('label' => 'Luxury', 'value' => '30'),
                        array('label' => 'SUV', 'value' => '40'),
                ),
        ),
        array(
                'type' => 'number',
                'label' => 'Average Ride Per Hours',
                'key' => 'average_ride_per_hours',
                'show_frontend' => true,
                'default_value' => '0',
                'min' => '0',
                'max' => '100',
        ),
        array(
                'type' => 'number',
                'label' => 'Average Ride Per $',
                'key' => 'average_ride_per',
                'show_frontend' => true,
                'default_value' => '0',
                'min' => '0',
                'max' => '100',
        ),
        array(
                'type' => 'number',
                'label' => 'Platform Commission %',
                'key' => 'platform_commission',
                'show_frontend' => false,
                'default_value' => '20',
                'min' => '0',
                'max' => '100',
        ),
        array(
                'type' => 'formula',
                'label' => 'Platform Commission',
                'key' => 'commission_amount',
                'show_frontend' => true,
                'summary_only' => true,
                'default_value' => '0',
                'formula' => '{average_ride_per_hours}*{average_ride_per}*{platform_commission}/100',
        ),
        array(
                'type' => 'formula',
                'label' => 'Formula',
                'key' => 'urbantaxi_formula',
                'show_frontend' => false,
                'summary_only' => false, // this IS the total
                'default_value' => '0',
                'formula' => '{average_ride_per_hours}*{average_ride_per}*(100-{platform_commission})/100',
        ),
    );

    $settings = array(
            'summary_label' => 'Total Summary',
            'text_color' => '#111827',
    );

    $now = current_time('mysql');

    $wpdb->insert(
            $wpdb->prefix . 'cost_calculators',
            array(
                    'title' => 'Taxi Details',
                    'description' => '',
                    'fields' => wp_json_encode($fields),
                    'settings' => wp_json_encode($settings),
                    'created_at' => $now,
                    'updated_at' => $now,
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s')
    );
}

add_action( 'ocdi/after_import', 'urbantaxi_after_import_setup' );

add_action( 'ocdi/before_widgets_import', 'urbantaxi_before_widgets_import' );

function urbantaxi_before_widgets_import() {
    // Verify user has permission to manage options
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $sidebars_widgets = get_option( 'sidebars_widgets' );
    if ( isset( $sidebars_widgets['blog-sidebar'] ) ) {
        $sidebars_widgets['blog-sidebar'] = array();
        update_option( 'sidebars_widgets', $sidebars_widgets );
    }
};

function urbantaxi_before_content_import( $selected_import ) {
    // Verify user has permission to manage options
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( 'Urbantaxi Import' === $selected_import['import_file_name'] ) {

        update_option('elementor_unfiltered_files_upload', true);
        
        $opt = get_option('elementor_cpt_support', []);

        $needed = ['post', 'page', 'service', 'project'];
        $updated = array_unique(array_merge($opt, $needed));
        
        update_option('elementor_cpt_support', $updated);


        set_theme_mod('urbantaxi_404_heading', '404' );
        set_theme_mod('urbantaxi_404_image', get_template_directory_uri().'/assets/images/404.png' );
        set_theme_mod('urbantaxi_404_text', 'We’re sorry — something has gone wrong on our end.' );
        set_theme_mod('urbantaxi_404_button_text', 'Back To Home' );

        $global_settings_arr =  include get_template_directory() . '/inc/global-settings.php';

        if (function_exists('urbantaxi_get_page_id_by_title')) {
            
            $elementor_kit_id = urbantaxi_get_page_id_by_title('Default Kit', 'elementor_library');
        
            if ( $elementor_kit_id && ! is_wp_error( $elementor_kit_id ) ) {
        
                update_post_meta($elementor_kit_id, '_elementor_page_settings', $global_settings_arr);
                update_post_meta($elementor_kit_id, '_elementor_edit_mode', 'builder');
                update_post_meta($elementor_kit_id, '_elementor_template_type', 'kit');
            }
        }

        if( current_user_can('manage_options') ){
            if( class_exists('HelperProviderUC') && class_exists('HelperUC') ) {
                $webAPI = new UniteCreatorWebAPI(); // this class is in the plugin
                
                $addons = [
                    [
                        "name" => "nav_menu",
                        "cat"  => "Menu Widgets",
                        "type" => "elementor",
                        "from_manager" => "true"
                    ],
                    [
                        "name" => "timer_countdown",
                        "cat"  => "Marketing Widgets",
                        "type" => "elementor",
                        "from_manager" => "true"
                    ]
                ];
                
                foreach ( $addons as $addon ) {
                    $response = $webAPI->installCatalogAddonFromData( $addon );
                }
            }
        }
    }
}
add_action( 'ocdi/before_content_import', 'urbantaxi_before_content_import' );

function urbantaxi_import_files() {

    // Verify user has permission to manage options
    if ( ! current_user_can( 'manage_options' ) ) {
        return [];
    }

    return [
        [
            'import_file_name'             => 'Urbantaxi Import',
            'categories'                   => [],
            'import_file_url'            => Urbantaxi_SERVER_URL . 'theme-data/urbantaxi-theme-content.xml',
            'import_widget_file_url'     => Urbantaxi_SERVER_URL . 'theme-data/urbantaxi-widgets.wie',            
            'import_customizer_file_url' => '',
            'import_redux'           => [],
            'import_preview_image_url'     => get_template_directory_uri() . '/screenshot.png',
            'preview_url'                  => 'https://vwthemesdemo.com/urbantaxi/',
        ],
    ];
}
add_filter( 'ocdi/import_files', 'urbantaxi_import_files' );

function urbantaxi_register_plugins( $plugins ) {

    // Verify user has permission to install plugins
    if ( ! current_user_can( 'install_plugins' ) ) {
        return $plugins;
    }
 
    // Required: List of plugins used by all theme demos.
    $theme_plugins = [
        [
            'name'     => 'Elementor',
            'slug'     => 'elementor',
            'required' => false,
            'preselected' => true,
        ],[
            'name'     => 'ElementsKit Lite',
            'slug'     => 'elementskit-lite',
            'required' => false,
            'preselected' => true,
        ],[
            'name'        => 'Ultimate Addons For Elementor',
            'slug'        => 'header-footer-elementor',
            'required' => false,
            'preselected' => true,
        ],[
            'name'        => 'PowerPack Elementor Addons',
            'slug'        => 'powerpack-lite-for-elementor',
            'required' => false,
            'preselected' => true,
        ],[
            'name'        => 'Unlimited Elements for Elementor',
            'slug'        => 'unlimited-elements-for-elementor',
            'required' => false,
            'preselected' => true,
        ],[
            'name'        => 'Contact Form 7',
            'slug'        => 'contact-form-7',
            'required' => false,
            'preselected' => true,
        ],[
            'name'        => 'Font Awesome',
            'slug'        => 'font-awesome',
            'required' => false,
            'preselected' => true,
        ],[
            'name'        => 'SVG Support',
            'slug'        => 'svg-support',
            'required' => false,
            'preselected' => true,
        ],[
            'name'        => 'Kirki Customizer Framework',
            'slug'        => 'kirki',
            'required' => false,
            'preselected' => true,
        ],[
            'name'        => 'WooCommerce',
            'slug'        => 'woocommerce',
            'required' => false,
            'preselected' => true,
        ],[
            'name'        => 'E-cab Taxi Booking Manager for Woocommerce',
            'slug'        => 'ecab-taxi-booking-manager',
            'required' => false,
            'preselected' => true,
        ],[
            'name'        => 'Urbantaxi Core',
            'slug'        => 'urbantaxi-core',
            'source'        => Urbantaxi_SERVER_URL . 'plugins/urbantaxi-core.zip',
            'required' => false,
            'preselected' => true,
        ],
    ];
 
    return array_merge( $plugins, $theme_plugins );
}
add_filter( 'ocdi/register_plugins', 'urbantaxi_register_plugins' );