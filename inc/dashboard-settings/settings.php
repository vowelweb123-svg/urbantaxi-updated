<?php
/**
 * Urbantaxi Dashboard Settings
 *
 * This file contains the main dashboard settings class for the Urbantaxi theme.
 * It provides a comprehensive admin interface for theme customization including
 * color management, general settings, and responsive banner configurations.
 *
 * @package     Urbantaxi
 * @subpackage  Admin/Settings
 * @since       1.0.0
 * @author      Urbantaxi
 * @copyright   Copyright (c) 2025, Urbantaxi
 * @license     GPL-2.0+
 * @version     1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

/**
 * Urbantaxi Dashboard Settings Class
 *
 * This class handles all theme dashboard settings functionality including:
 * - Theme color management with live preview
 * - General settings (preloader, banner configuration)
 * - Responsive banner height controls
 * - AJAX-powered save/reset functionality
 * - WordPress media library integration
 *
 * @since 1.0.0
 */
class Urbantaxi_Dashboard_Settings {
    
    /**
     * Class version
     *
     * @since 1.0.0
     * @var string
     */
    const VERSION = '1.0.0';
    
    /**
     * Constructor - Initialize the dashboard settings
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_theme_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
        add_action( 'wp_ajax_urbantaxi_save_colors', array( $this, 'save_theme_colors' ) );
        add_action( 'wp_ajax_urbantaxi_reset_colors', array( $this, 'reset_theme_colors' ) );
        add_action( 'wp_ajax_urbantaxi_save_general', array( $this, 'save_general_settings' ) );
        add_action( 'wp_ajax_urbantaxi_reset_general', array( $this, 'reset_general_settings' ) );
        add_action( 'wp_ajax_urbantaxi_save_blogs', array( $this, 'save_blogs_settings' ) );
        add_action( 'wp_ajax_urbantaxi_reset_blogs', array( $this, 'reset_blogs_settings' ) );
        add_action( 'wp_ajax_urbantaxi_save_404', array( $this, 'save_404_settings' ) );
        add_action( 'wp_ajax_urbantaxi_reset_404', array( $this, 'reset_404_settings' ) );
        add_action( 'wp_ajax_urbantaxi_save_transportation', array( $this, 'save_transportation_settings' ) );
        add_action( 'wp_ajax_urbantaxi_reset_transportation', array( $this, 'reset_transportation_settings' ) );
        add_action( 'wp_ajax_urbantaxi_save_taxonomy_location', array( $this, 'save_taxonomy_location_settings' ) );
        add_action( 'wp_ajax_urbantaxi_reset_taxonomy_location', array( $this, 'reset_taxonomy_location_settings' ) );
    }

    /**
     * Add theme settings menu to WordPress admin
     */
    public function add_theme_menu() {
        add_menu_page(
            __( 'Urbantaxi Settings', 'urbantaxi' ),
            __( 'Theme Settings', 'urbantaxi' ),
            'manage_options',
            'urbantaxi-settings',
            array( $this, 'settings_page' ),
            'dashicons-admin-generic',
            58
        );
    }

    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets( $hook ) {

        if ( 'toplevel_page_urbantaxi-settings' !== $hook ) {
            return;
        }
        wp_enqueue_media();
        wp_enqueue_script( 'jquery' );

        wp_enqueue_style(
			'urbantaxi-admin-setting-css',
			get_template_directory_uri() . '/assets/css/admin-setting.css',
			array(),
            wp_get_theme()->get( 'Version' )
		);

        wp_enqueue_script(
            'urbantaxi-admin-setting-js',
            get_template_directory_uri() . '/assets/js/urbantaxi-admin.js',
            [ 'jquery' ],
            wp_get_theme()->get( 'Version' ),
            true
        );

        wp_localize_script(
            'urbantaxi-admin-setting-js',
            'urbantaxiAdmin',
            [
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'nonces'  => [
                    'colors'  => wp_create_nonce( 'urbantaxi_colors_nonce' ),
                    'general' => wp_create_nonce( 'urbantaxi_general_nonce' ),
                    'blogs'   => wp_create_nonce( 'urbantaxi_blogs_nonce' ),
                    'error404'=> wp_create_nonce( 'urbantaxi_404_nonce' ),
                    'transportation' => wp_create_nonce( 'urbantaxi_transportation_nonce' ),
                    'taxonomy_location' => wp_create_nonce( 'urbantaxi_taxonomy_location_nonce' ),
                ],
            ]
        );
    }

    /**
     * Verify AJAX nonce posted from admin settings screen.
     *
     * @param string $action Nonce action key.
     * @return void
     */
    private function verify_ajax_nonce( $action ) {
        if ( ! isset( $_POST['nonce'] ) ) {
            wp_send_json_error( array( 'message' => esc_html__( 'Security check failed.', 'urbantaxi' ) ), 403 );
        }

        $nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );

        if ( ! wp_verify_nonce( $nonce, $action ) ) {
            wp_send_json_error( array( 'message' => esc_html__( 'Security check failed.', 'urbantaxi' ) ), 403 );
        }
    }

    /**
     * Settings page content
     */
    public function settings_page() { ?>
        <div class="wrap urbantaxi-settings">
            <!-- Header/Navbar -->
            <div class="urbantaxi-header">
                <div class="header-content">
                    <div class="header-left">
                        <h1 class="header-title">
                            <span class="dashicons dashicons-admin-generic"></span>
                            <?php echo esc_html( 'Urbantaxi Settings', 'urbantaxi' ); ?>
                        </h1>
                        <p class="header-subtitle"><?php echo esc_html( 'Customize your theme settings and options', 'urbantaxi' ); ?></p>
                    </div>
                    <div class="header-right">
                        <div class="header-actions">
                            <button type="button" class="button button-secondary" id="reset-settings">
                                <span class="dashicons dashicons-update"></span> 
                                <?php echo esc_html( 'Reset', 'urbantaxi' ); ?>
                            </button>
                            <button type="button" class="button button-primary" id="save-settings">
                                <span class="dashicons dashicons-yes"></span> 
                                <?php echo esc_html( 'Save Changes', 'urbantaxi' ); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="urbantaxi-main">
                <!-- Sidebar -->
                <div class="urbantaxi-sidebar">
                    <nav class="settings-nav">
                        <ul class="nav-list">
                            <li class="nav-item">
                                <a href="#general" class="nav-link active" data-tab="general">
                                    <span class="dashicons dashicons-admin-settings"></span>
                                    <?php echo esc_html( 'General', 'urbantaxi' ); ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#colors" class="nav-link" data-tab="colors">
                                    <span class="dashicons dashicons-art"></span>
                                    <?php echo esc_html( 'Colors', 'urbantaxi' ); ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#error404" class="nav-link" data-tab="error404">
                                    <span class="dashicons dashicons-warning"></span>
                                    <?php echo esc_html( '404 Settings', 'urbantaxi' ); ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#transportation" class="nav-link" data-tab="transportation">
                                    <span class="dashicons dashicons-car"></span>
                                    <?php echo esc_html( 'Transportation', 'urbantaxi' ); ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#taxonomy-location" class="nav-link" data-tab="taxonomy-location">
                                    <span class="dashicons dashicons-location"></span>
                                    <?php echo esc_html( 'Locations Page', 'urbantaxi' ); ?>
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <!-- Sidebar Footer -->
                    <div class="sidebar-footer">
                        <div class="theme-info">
                            <h4><?php echo esc_html( 'Urbantaxi', 'urbantaxi' ); ?></h4>
                            <p class="version"><?php echo esc_html( 'Version 1.0.0', 'urbantaxi' ); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="urbantaxi-content">
                    <div class="content-tabs">
                        <!-- General Tab -->
                        <div id="general-tab" class="tab-content active">
                            <h2><?php echo esc_html( 'General Settings', 'urbantaxi' ); ?></h2>
                            <p><?php echo esc_html( 'Configure basic theme settings and options.', 'urbantaxi' ); ?></p>
                            
                            <form id="general-settings-form">
                                <?php wp_nonce_field( 'urbantaxi_general_nonce', 'urbantaxi_general_nonce_field' ); ?>
                                <table class="form-table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">
                                                <label for="preloader-toggle"><?php echo esc_html( 'Preloader', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <label class="toggle-switch">
                                                    <input type="checkbox" id="preloader-toggle" name="urbantaxi_preloader_hide" value="1" <?php checked( get_theme_mod( 'urbantaxi_preloader_hide', false ) ); ?> />
                                                    <span class="toggle-slider"></span>
                                                </label>
                                                <p class="description"><?php echo esc_html( 'Enable or disable the preloader animation on page load.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="banner-image-upload"><?php echo esc_html( 'Banner Background Image', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <div class="banner-image-section">
                                                    <input type="hidden" id="banner-image-upload" name="header_image" value="<?php echo esc_attr( get_theme_mod( 'header_image', '' ) ); ?>" />
                                                    <div class="banner-image-preview">
                                                        <?php 
                                                        $banner_image = get_theme_mod( 'header_image', '' );
                                                        if ( $banner_image ) {
                                                            echo '<img src="' . esc_url( $banner_image ) . '" />';
                                                        }
                                                        ?>
                                                    </div>
                                                    <button type="button" class="button upload-banner-button" data-target="banner-image-upload">
                                                        <span class="dashicons dashicons-upload"></span> 
                                                        <?php echo esc_html( 'Upload Image', 'urbantaxi' ); ?>
                                                    </button>
                                                    <button type="button" class="button remove-banner-button" data-target="banner-image-upload">
                                                        <span class="dashicons dashicons-no"></span> 
                                                        <?php echo esc_html( 'Remove Image', 'urbantaxi' ); ?>
                                                    </button>
                                                </div>
                                                <p class="description"><?php echo esc_html( 'Upload a custom background image for inner page banners. Recommended size: 1920x400px. Note: Header image is managed separately via WordPress Customizer.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="banner-height"><?php echo esc_html( 'Banner Height (px)', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <div class="responsive-inputs">
                                                    <?php 
                                                    $banner_heights = get_theme_mod( 'urbantaxi_header_image_height', array(
                                                        'mobile' => '350px',
                                                        'tablet' => '350px', 
                                                        'desktop' => '350px'
                                                    ));
                                                    if ( !is_array( $banner_heights ) ) {
                                                        $banner_heights = array(
                                                            'mobile' => '350px',
                                                            'tablet' => '350px', 
                                                            'desktop' => '350px'
                                                        );
                                                    }
                                                    ?>
                                                    <div class="responsive-input-group">
                                                        <label class="responsive-label">
                                                            <span class="dashicons dashicons-smartphone"></span>
                                                            <?php echo esc_html( 'Mobile', 'urbantaxi' ); ?>
                                                        </label>
                                                        <input type="text" id="banner-height-mobile" name="urbantaxi_header_image_height[mobile]" value="<?php echo esc_attr( $banner_heights['mobile'] ); ?>" class="small-text responsive-input" placeholder="250px" />
                                                    </div>
                                                    <div class="responsive-input-group">
                                                        <label class="responsive-label">
                                                            <span class="dashicons dashicons-tablet"></span>
                                                            <?php echo esc_html( 'Tablet', 'urbantaxi' ); ?>
                                                        </label>
                                                        <input type="text" id="banner-height-tablet" name="urbantaxi_header_image_height[tablet]" value="<?php echo esc_attr( $banner_heights['tablet'] ); ?>" class="small-text responsive-input" placeholder="300px" />
                                                    </div>
                                                    <div class="responsive-input-group">
                                                        <label class="responsive-label">
                                                            <span class="dashicons dashicons-desktop"></span>
                                                            <?php echo esc_html( 'Desktop', 'urbantaxi' ); ?>
                                                        </label>
                                                        <input type="text" id="banner-height-desktop" name="urbantaxi_header_image_height[desktop]" value="<?php echo esc_attr( $banner_heights['desktop'] ); ?>" class="small-text responsive-input" placeholder="350px" />
                                                    </div>
                                                </div>
                                                <p class="description"><?php echo esc_html( 'Set responsive heights for the banner on different device sizes (200-800px each).', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                                <div class="general-actions">
                                    <button type="button" class="button button-secondary" id="reset-general">
                                        <span class="dashicons dashicons-update"></span> 
                                        <?php echo esc_html( 'Reset to Defaults', 'urbantaxi' ); ?>
                                    </button>
                                    <button type="button" class="button button-primary" id="save-general">
                                        <span class="dashicons dashicons-yes"></span> 
                                        <?php echo esc_html( 'Save General Settings', 'urbantaxi' ); ?>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Colors Tab -->
                        <div id="colors-tab" class="tab-content">
                            <h2><?php echo esc_html( 'Color Settings', 'urbantaxi' ); ?></h2>
                            <p><?php echo esc_html( 'Configure your theme color scheme and palette.', 'urbantaxi' ); ?></p>
                            
                            <form id="theme-colors-form">
                                <?php wp_nonce_field( 'urbantaxi_colors_nonce', 'urbantaxi_colors_nonce_field' ); ?>
                                <table class="form-table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">
                                                <label for="first-theme-color"><?php echo esc_html( 'First Theme Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="first-theme-color" name="urbantaxi_first_theme_color" value="<?php echo esc_attr( get_theme_mod( 'urbantaxi_first_theme_color', '#FDC702' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Primary brand color used throughout the theme.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="second-theme-color"><?php echo esc_html( 'Second Theme Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="second-theme-color" name="urbantaxi_second_theme_color" value="<?php echo esc_attr( get_theme_mod( 'urbantaxi_second_theme_color', '#FFFFFF' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Secondary color for backgrounds and contrasts.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="third-theme-color"><?php echo esc_html( 'Third Theme Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="third-theme-color" name="urbantaxi_third_theme_color" value="<?php echo esc_attr( get_theme_mod( 'urbantaxi_third_theme_color', '#2B2B2B' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Third color for text and dark accents.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="fourth-theme-color"><?php echo esc_html( 'Fourth Theme Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="fourth-theme-color" name="urbantaxi_fourth_theme_color" value="<?php echo esc_attr( get_theme_mod( 'urbantaxi_fourth_theme_color', '#FFFDEE' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Fourth color for additional accent elements.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                                <div class="color-preview-section">
                                    <h3><?php echo esc_html( 'Color Preview', 'urbantaxi' ); ?></h3>
                                    <div class="color-preview-grid">
                                        <div class="color-swatch" data-color="first">
                                            <div class="swatch-color" id="preview-first"></div>
                                            <span class="swatch-label"><?php echo esc_html( 'First Color', 'urbantaxi' ); ?></span>
                                        </div>
                                        <div class="color-swatch" data-color="second">
                                            <div class="swatch-color" id="preview-second"></div>
                                            <span class="swatch-label"><?php echo esc_html( 'Second Color', 'urbantaxi' ); ?></span>
                                        </div>
                                        <div class="color-swatch" data-color="third">
                                            <div class="swatch-color" id="preview-third"></div>
                                            <span class="swatch-label"><?php echo esc_html( 'Third Color', 'urbantaxi' ); ?></span>
                                        </div>
                                        <div class="color-swatch" data-color="fourth">
                                            <div class="swatch-color" id="preview-fourth"></div>
                                            <span class="swatch-label"><?php echo esc_html( 'Fourth Color', 'urbantaxi' ); ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="color-actions">
                                    <button type="button" class="button button-secondary" id="reset-colors">
                                        <span class="dashicons dashicons-update"></span> 
                                        <?php echo esc_html( 'Reset to Defaults', 'urbantaxi' ); ?>
                                    </button>
                                    <button type="button" class="button button-primary" id="save-colors">
                                        <span class="dashicons dashicons-yes"></span> 
                                        <?php echo esc_html( 'Save Colors', 'urbantaxi' ); ?>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- 404 Settings Tab -->
                        <div id="error404-tab" class="tab-content">
                            <h2><?php echo esc_html( '404 Page Settings', 'urbantaxi' ); ?></h2>
                            <p><?php echo esc_html( 'Configure your 404 error page content and appearance.', 'urbantaxi' ); ?></p>
                            
                            <form id="theme-404-form">
                                <?php wp_nonce_field( 'urbantaxi_404_nonce', 'urbantaxi_404_nonce_field' ); ?>
                                <table class="form-table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">
                                                <label for="error404-heading"><?php echo esc_html( '404 Page Heading', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <textarea id="error404-heading" name="urbantaxi_404_heading" class="large-text" rows="4"><?php echo esc_textarea( get_theme_mod( 'urbantaxi_404_heading', '404' ) ); ?></textarea>
                                                <p class="description"><?php echo esc_html( 'Heading text explaining the 404 error to users.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="error404-image-upload"><?php echo esc_html( '404 Page Image', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <div class="error404-image-section banner-image-section">
                                                    <?php
                                                    $error404_image = get_theme_mod( 'urbantaxi_404_image', '' );
                                                    ?>
                                                    <input type="text" id="error404-image-upload" name="urbantaxi_404_image" value="<?php echo esc_attr( $error404_image ); ?>" class="regular-text" placeholder="<?php echo esc_html( 'Enter image URL or click upload button', 'urbantaxi' ); ?>" />
                                                    <br><br>
                                                    <button type="button" class="button upload-banner-button" data-target="error404-image-upload">
                                                        <span class="dashicons dashicons-upload"></span> 
                                                        <?php echo esc_html( 'Upload Image', 'urbantaxi' ); ?>
                                                    </button>
                                                    <button type="button" class="button remove-banner-button" data-target="error404-image-upload">
                                                        <span class="dashicons dashicons-no-alt"></span> 
                                                        <?php echo esc_html( 'Remove Image', 'urbantaxi' ); ?>
                                                    </button>
                                                    <div class="banner-image-preview">
                                                        <?php if ( $error404_image ) : ?>
                                                            <img src="<?php echo esc_url( $error404_image ); ?>" />
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <p class="description"><?php echo esc_html( 'Upload an image for your 404 error page. Recommended size: 400x300px or larger.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="error404-text"><?php echo esc_html( '404 Page Description', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <textarea id="error404-text" name="urbantaxi_404_text" class="large-text" rows="4"><?php echo esc_textarea( get_theme_mod( 'urbantaxi_404_text', 'We\'re Sorry — Something Has Gone Wrong On Our End.' ) ); ?></textarea>
                                                <p class="description"><?php echo esc_html( 'Description text explaining the 404 error to users.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="error404-button-text"><?php echo esc_html( 'Button Text', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="error404-button-text" name="urbantaxi_404_button_text" value="<?php echo esc_attr( get_theme_mod( 'urbantaxi_404_button_text', 'Back To Home' ) ); ?>" class="regular-text" />
                                                <p class="description"><?php echo esc_html( 'Text displayed on the call-to-action button.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="error404-actions">
                                    <button type="button" class="button button-secondary" id="reset-404">
                                        <span class="dashicons dashicons-update"></span> 
                                        <?php echo esc_html( 'Reset to Defaults', 'urbantaxi' ); ?>
                                    </button>
                                    <button type="button" class="button button-primary" id="save-404">
                                        <span class="dashicons dashicons-yes"></span> 
                                        <?php echo esc_html( 'Save 404 Settings', 'urbantaxi' ); ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- 404 settings -->

                        <!-- Transportation Settings Tab -->
                        <div id="transportation-tab" class="tab-content">
                            <h2><?php echo esc_html( 'Single Transportation Settings', 'urbantaxi' ); ?></h2>
                            <p><?php echo esc_html( 'Customize content for single transportation pages.', 'urbantaxi' ); ?></p>
                            
                            <form id="theme-transportation-form">
                                <?php wp_nonce_field( 'urbantaxi_transportation_nonce', 'urbantaxi_transportation_nonce_field' ); ?>
                                <table class="form-table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-text-one"><?php echo esc_html( 'First Content Block (HTML)', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <textarea id="transportation-text-one" name="single_transportation_text_one" class="large-text" rows="6"><?php echo esc_textarea( get_theme_mod( 'single_transportation_text_one', 'We offer competitive and affordable taxi pricing that is thoughtfully designed to suit every budget, whether you\'re traveling for daily commutes, business trips, airport transfers, or special occasions. Our goal is to make reliable transportation accessible without compromising on comfort, safety, or service quality. With a clear and straightforward fare structure, we ensure complete transparency from the moment you book your ride. You\'ll always know exactly what you\'re paying before your journey begins, giving you peace of mind and confidence in your travel plans.' ) ); ?></textarea>
                                                <p class="description"><?php echo esc_html( 'HTML content for the first paragraph block. Supports basic HTML tags.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-text-two"><?php echo esc_html( 'Second Content Block (HTML)', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <textarea id="transportation-text-two" name="single_transportation_text_two" class="large-text" rows="6"><?php echo esc_textarea( get_theme_mod( 'single_transportation_text_two', 'Our pricing system is built on fairness and honesty. There are no hidden fees, unexpected surcharges, or confusing calculations. What you see is what you pay—no surge pricing during peak hours, no last-minute additions, and no unpleasant surprises at the end of your trip. We believe trust starts with transparency, and our pricing reflects that commitment.' ) ); ?></textarea>
                                                <p class="description"><?php echo esc_html( 'HTML content for the second paragraph block. Supports basic HTML tags.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-head-title"><?php echo esc_html( 'Features Heading', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="transportation-head-title" name="single_transportation_head_title" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_head_title', 'Features Available:' ) ); ?>" class="regular-text" />
                                                <p class="description"><?php echo esc_html( 'Heading text for the features section.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <?php
                                        $default_feature_titles = array(
                                            'Bluetooth Connectivity',
                                            'Mobile Charging Port',
                                            'GPS Navigation',
                                            'Air Conditioning',
                                            'Sanitized Interior',
                                            'Comfortable Seating'
                                        );
                                        $default_feature_texts = array(
                                            'Seamless wireless pairing',
                                            'Fast device charging',
                                            'Accurate route guidance',
                                            'Cool climate control',
                                            'Clean hygienic cabin',
                                            'Soft cushioned seats'
                                        );

                                        for ( $feature_index = 1; $feature_index <= 6; $feature_index++ ) :
                                            $default_icon = get_template_directory_uri() . '/assets/images/single-transportation/icon' . $feature_index . '.png';
                                            $icon_key = 'single_transportation_icon' . $feature_index;
                                            $title_key = 'single_transportation_title' . $feature_index;
                                            $text_key = 'single_transportation_text' . $feature_index;
                                            $current_icon = get_theme_mod( $icon_key, $default_icon );
                                            $current_title = get_theme_mod( $title_key, $default_feature_titles[ $feature_index - 1 ] );
                                            $current_text = get_theme_mod( $text_key, $default_feature_texts[ $feature_index - 1 ] );
                                        ?>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-feature-icon-<?php echo esc_attr( $feature_index ); ?>"><?php echo esc_html( sprintf( 'Feature %d', $feature_index ) ); ?></label>
                                            </th>
                                            <td>
                                                <div class="banner-image-section">
                                                    <input type="text" id="transportation-feature-icon-<?php echo esc_attr( $feature_index ); ?>" name="<?php echo esc_attr( $icon_key ); ?>" value="<?php echo esc_attr( $current_icon ); ?>" data-default-icon="<?php echo esc_attr( $default_icon ); ?>" class="regular-text" placeholder="https://" />
                                                    <button type="button" class="button upload-banner-button" data-target="transportation-feature-icon-<?php echo esc_attr( $feature_index ); ?>">
                                                        <span class="dashicons dashicons-upload"></span>
                                                        <?php echo esc_html( 'Upload Icon', 'urbantaxi' ); ?>
                                                    </button>
                                                    <button type="button" class="button remove-banner-button" data-target="transportation-feature-icon-<?php echo esc_attr( $feature_index ); ?>">
                                                        <span class="dashicons dashicons-no"></span>
                                                        <?php echo esc_html( 'Remove Icon', 'urbantaxi' ); ?>
                                                    </button>
                                                    <div class="banner-image-preview">
                                                        <?php if ( ! empty( $current_icon ) ) : ?>
                                                            <img src="<?php echo esc_url( $current_icon ); ?>" />
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <p style="margin-top:10px;">
                                                    <label for="transportation-feature-title-<?php echo esc_attr( $feature_index ); ?>"><?php echo esc_html( 'Title', 'urbantaxi' ); ?></label><br>
                                                    <input type="text" id="transportation-feature-title-<?php echo esc_attr( $feature_index ); ?>" name="<?php echo esc_attr( $title_key ); ?>" value="<?php echo esc_attr( $current_title ); ?>" class="regular-text" />
                                                </p>
                                                <p>
                                                    <label for="transportation-feature-text-<?php echo esc_attr( $feature_index ); ?>"><?php echo esc_html( 'Text', 'urbantaxi' ); ?></label><br>
                                                    <input type="text" id="transportation-feature-text-<?php echo esc_attr( $feature_index ); ?>" name="<?php echo esc_attr( $text_key ); ?>" value="<?php echo esc_attr( $current_text ); ?>" class="regular-text" />
                                                </p>
                                            </td>
                                        </tr>
                                        <?php endfor; ?>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-text-three"><?php echo esc_html( 'Third Content Block (HTML)', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <textarea id="transportation-text-three" name="single_transportation_text_three" class="large-text" rows="6"><?php echo esc_textarea( get_theme_mod( 'single_transportation_text_three', 'We offer competitive and affordable taxi pricing that is thoughtfully designed to suit every budget, whether you\'re traveling for daily commutes, business trips, airport transfers, or special occasions. Our goal is to make reliable transportation accessible without compromising on comfort, safety, or service quality. With a clear and straightforward fare structure, we ensure complete transparency from the moment you book your ride. You\'ll always know exactly what you\'re paying before your journey begins, giving you peace of mind and confidence in your travel plans.' ) ); ?></textarea>
                                                <p class="description"><?php echo esc_html( 'HTML content for the third paragraph block. Supports basic HTML tags.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-book-now-text"><?php echo esc_html( 'Book Now Button Text', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="transportation-book-now-text" name="single_transportation_book_now_text" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_book_now_text', 'Book Now' ) ); ?>" class="regular-text" />
                                                <p class="description"><?php echo esc_html( 'Text displayed on the booking button.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-book-now-url"><?php echo esc_html( 'Book Now Button URL', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="url" id="transportation-book-now-url" name="single_transportation_book_now_url" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_book_now_url', '' ) ); ?>" class="regular-text" placeholder="https://" />
                                                <p class="description"><?php echo esc_html( 'Enter the URL that the Book Now button should open.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-paragraph-font-size"><?php echo esc_html( 'Paragraph Font Size', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="transportation-paragraph-font-size" name="single_transportation_paragraph_font_size" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_paragraph_font_size', '16px' ) ); ?>" class="regular-text" placeholder="16px" />
                                                <p class="description"><?php echo esc_html( 'Set paragraph font size for transportation content, e.g. 16px.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-paragraph-color"><?php echo esc_html( 'Paragraph Text Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="transportation-paragraph-color" name="single_transportation_paragraph_color" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_paragraph_color', '#333333' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Select the paragraph text color.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-heading-font-size"><?php echo esc_html( 'Feature Heading Font Size', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="transportation-heading-font-size" name="single_transportation_heading_font_size" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_heading_font_size', '24px' ) ); ?>" class="regular-text" placeholder="24px" />
                                                <p class="description"><?php echo esc_html( 'Set feature heading font size, e.g. 24px.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-heading-color"><?php echo esc_html( 'Feature Heading Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="transportation-heading-color" name="single_transportation_heading_color" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_heading_color', '#000000' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Select the feature heading color.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-feature-title-font-size"><?php echo esc_html( 'Feature Title Font Size', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="transportation-feature-title-font-size" name="single_transportation_feature_title_font_size" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_feature_title_font_size', '18px' ) ); ?>" class="regular-text" placeholder="18px" />
                                                <p class="description"><?php echo esc_html( 'Set the feature title font size, e.g. 18px.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-feature-title-color"><?php echo esc_html( 'Feature Title Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="transportation-feature-title-color" name="single_transportation_feature_title_color" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_feature_title_color', '#000000' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Select the feature title color.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-feature-text-font-size"><?php echo esc_html( 'Feature Text Font Size', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="transportation-feature-text-font-size" name="single_transportation_feature_text_font_size" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_feature_text_font_size', '14px' ) ); ?>" class="regular-text" placeholder="14px" />
                                                <p class="description"><?php echo esc_html( 'Set the feature text font size, e.g. 14px.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-feature-text-color"><?php echo esc_html( 'Feature Text Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="transportation-feature-text-color" name="single_transportation_feature_text_color" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_feature_text_color', '#333333' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Select the feature text color.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-book-now-font-size"><?php echo esc_html( 'Book Now Button Font Size', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="transportation-book-now-font-size" name="single_transportation_book_now_font_size" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_book_now_font_size', '16px' ) ); ?>" class="regular-text" placeholder="16px" />
                                                <p class="description"><?php echo esc_html( 'Set the button font size, e.g. 16px.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-book-now-text-color"><?php echo esc_html( 'Book Now Button Text Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="transportation-book-now-text-color" name="single_transportation_book_now_text_color" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_book_now_text_color', '#000000' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Select the text color for the Book Now button.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-book-now-bg-color"><?php echo esc_html( 'Book Now Button Background Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="transportation-book-now-bg-color" name="single_transportation_book_now_bg_color" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_book_now_bg_color', '#FDC702' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Select the background color for the Book Now button.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-book-now-hover-text-color"><?php echo esc_html( 'Book Now Button Hover Text Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="transportation-book-now-hover-text-color" name="single_transportation_book_now_hover_text_color" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_book_now_hover_text_color', '#ffffff' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Select the hover text color for the Book Now button.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="transportation-book-now-hover-bg-color"><?php echo esc_html( 'Book Now Button Hover Background Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="transportation-book-now-hover-bg-color" name="single_transportation_book_now_hover_bg_color" value="<?php echo esc_attr( get_theme_mod( 'single_transportation_book_now_hover_bg_color', '#000000' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Select the hover background color for the Book Now button.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="transportation-actions">
                                    <button type="button" class="button button-secondary" id="reset-transportation">
                                        <span class="dashicons dashicons-update"></span> 
                                        <?php echo esc_html( 'Reset to Defaults', 'urbantaxi' ); ?>
                                    </button>
                                    <button type="button" class="button button-primary" id="save-transportation">
                                        <span class="dashicons dashicons-yes"></span> 
                                        <?php echo esc_html( 'Save Transportation Settings', 'urbantaxi' ); ?>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Taxonomy Location Settings Tab -->
                        <div id="taxonomy-location-tab" class="tab-content">
                            <h2><?php echo esc_html( 'Taxonomy Location Page Settings', 'urbantaxi' ); ?></h2>
                            <p><?php echo esc_html( 'Customize typography and colors for the locations listing page.', 'urbantaxi' ); ?></p>
                            
                            <form id="theme-taxonomy-location-form">
                                <?php wp_nonce_field( 'urbantaxi_taxonomy_location_nonce', 'urbantaxi_taxonomy_location_nonce_field' ); ?>
                                <table class="form-table">
                                    <tbody>
                                        <!-- Post Title Settings -->
                                        <tr>
                                            <th colspan="2" style="padding: 15px 0;">
                                                <h3 style="margin: 0;"><?php echo esc_html( 'Post Title Settings', 'urbantaxi' ); ?></h3>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="taxonomy-location-title-font-size"><?php echo esc_html( 'Title Font Size', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="taxonomy-location-title-font-size" name="taxonomy_location_title_font_size" value="<?php echo esc_attr( get_theme_mod( 'taxonomy_location_title_font_size', '20px' ) ); ?>" class="regular-text" placeholder="20px" />
                                                <p class="description"><?php echo esc_html( 'Set the title font size, e.g. 20px.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="taxonomy-location-title-color"><?php echo esc_html( 'Title Font Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="taxonomy-location-title-color" name="taxonomy_location_title_color" value="<?php echo esc_attr( get_theme_mod( 'taxonomy_location_title_color', '#000000' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Select the title text color.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>

                                        <!-- Content/Description Settings -->
                                        <tr>
                                            <th colspan="2" style="padding: 15px 0;">
                                                <h3 style="margin: 0;"><?php echo esc_html( 'Content Settings', 'urbantaxi' ); ?></h3>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="taxonomy-location-content-font-size"><?php echo esc_html( 'Content Font Size', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="taxonomy-location-content-font-size" name="taxonomy_location_content_font_size" value="<?php echo esc_attr( get_theme_mod( 'taxonomy_location_content_font_size', '14px' ) ); ?>" class="regular-text" placeholder="14px" />
                                                <p class="description"><?php echo esc_html( 'Set the content font size, e.g. 14px.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="taxonomy-location-content-color"><?php echo esc_html( 'Content Font Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="taxonomy-location-content-color" name="taxonomy_location_content_color" value="<?php echo esc_attr( get_theme_mod( 'taxonomy_location_content_color', '#333333' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Select the content text color.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>

                                        <!-- Price Settings -->
                                        <tr>
                                            <th colspan="2" style="padding: 15px 0;">
                                                <h3 style="margin: 0;"><?php echo esc_html( 'Price Settings', 'urbantaxi' ); ?></h3>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="taxonomy-location-price-font-size"><?php echo esc_html( 'Price Font Size', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="taxonomy-location-price-font-size" name="taxonomy_location_price_font_size" value="<?php echo esc_attr( get_theme_mod( 'taxonomy_location_price_font_size', '18px' ) ); ?>" class="regular-text" placeholder="18px" />
                                                <p class="description"><?php echo esc_html( 'Set the price font size, e.g. 18px.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="taxonomy-location-price-color"><?php echo esc_html( 'Price Font Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="taxonomy-location-price-color" name="taxonomy_location_price_color" value="<?php echo esc_attr( get_theme_mod( 'taxonomy_location_price_color', '#2B2B2B' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Select the price text color.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>

                                        <!-- Book Now Button Settings -->
                                        <tr>
                                            <th colspan="2" style="padding: 15px 0;">
                                                <h3 style="margin: 0;"><?php echo esc_html( 'Book Now Button Settings', 'urbantaxi' ); ?></h3>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="taxonomy-location-button-text"><?php echo esc_html( 'Button Text', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="taxonomy-location-button-text" name="taxonomy_location_button_text" value="<?php echo esc_attr( get_theme_mod( 'taxonomy_location_button_text', 'Book Now' ) ); ?>" class="regular-text" />
                                                <p class="description"><?php echo esc_html( 'Text displayed on the booking button.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="taxonomy-location-button-url"><?php echo esc_html( 'Button URL', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="url" id="taxonomy-location-button-url" name="taxonomy_location_button_url" value="<?php echo esc_attr( get_theme_mod( 'taxonomy_location_button_url', '' ) ); ?>" class="regular-text" placeholder="https://" />
                                                <p class="description"><?php echo esc_html( 'Enter the URL that the button should open. Leave empty to use booking form.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="taxonomy-location-button-font-size"><?php echo esc_html( 'Button Font Size', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="text" id="taxonomy-location-button-font-size" name="taxonomy_location_button_font_size" value="<?php echo esc_attr( get_theme_mod( 'taxonomy_location_button_font_size', '16px' ) ); ?>" class="regular-text" placeholder="14px" />
                                                <p class="description"><?php echo esc_html( 'Set the button font size, e.g. 14px.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="taxonomy-location-button-text-color"><?php echo esc_html( 'Button Text Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="taxonomy-location-button-text-color" name="taxonomy_location_button_text_color" value="<?php echo esc_attr( get_theme_mod( 'taxonomy_location_button_text_color', '#000000' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Select the button text color.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="taxonomy-location-button-bg-color"><?php echo esc_html( 'Button Background Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="taxonomy-location-button-bg-color" name="taxonomy_location_button_bg_color" value="<?php echo esc_attr( get_theme_mod( 'taxonomy_location_button_bg_color', '#FDC702' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Select the button background color.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="taxonomy-location-button-hover-text-color"><?php echo esc_html( 'Button Hover Text Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="taxonomy-location-button-hover-text-color" name="taxonomy_location_button_hover_text_color" value="<?php echo esc_attr( get_theme_mod( 'taxonomy_location_button_hover_text_color', '#ffffff' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Select the button hover text color.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                <label for="taxonomy-location-button-hover-bg-color"><?php echo esc_html( 'Button Hover Background Color', 'urbantaxi' ); ?></label>
                                            </th>
                                            <td>
                                                <input type="color" id="taxonomy-location-button-hover-bg-color" name="taxonomy_location_button_hover_bg_color" value="<?php echo esc_attr( get_theme_mod( 'taxonomy_location_button_hover_bg_color', '#000000' ) ); ?>" class="color-picker" />
                                                <p class="description"><?php echo esc_html( 'Select the button hover background color.', 'urbantaxi' ); ?></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="taxonomy-location-actions">
                                    <button type="button" class="button button-secondary" id="reset-taxonomy-location">
                                        <span class="dashicons dashicons-update"></span> 
                                        <?php echo esc_html( 'Reset to Defaults', 'urbantaxi' ); ?>
                                    </button>
                                    <button type="button" class="button button-primary" id="save-taxonomy-location">
                                        <span class="dashicons dashicons-yes"></span> 
                                        <?php echo esc_html( 'Save Location Settings', 'urbantaxi' ); ?>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>      
    <?php }

    /**
     * Save theme colors via AJAX
     *
     * @since 1.0.0
     * @return void
     */
    public function save_theme_colors() {
        // Verify nonce for security.
        $this->verify_ajax_nonce( 'urbantaxi_colors_nonce' );
        
        // Check user permissions
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => esc_html__( 'Insufficient permissions.', 'urbantaxi' ) ) );
        }

        // Validate and sanitize color inputs
        $color_fields = array(
            'urbantaxi_first_theme_color',
            'urbantaxi_second_theme_color', 
            'urbantaxi_third_theme_color',
            'urbantaxi_fourth_theme_color'
        );
        
        $colors = array();
        foreach ( $color_fields as $field ) {
            if ( isset( $_POST[ $field ] ) ) {
                $sanitized_color = sanitize_hex_color( $_POST[ $field ] );
                if ( $sanitized_color ) {
                    $colors[ $field ] = $sanitized_color;
                }
            }
        }

        // Save validated colors
        foreach ( $colors as $key => $value ) {
            set_theme_mod( $key, $value );
        }

        wp_send_json_success( array( 'message' => esc_html__( 'Theme colors saved successfully!', 'urbantaxi' ) ) );
    }

    /**
     * Reset theme colors to defaults
     *
     * @since 1.0.0
     * @return void
     */
    public function reset_theme_colors() {
        // Verify nonce for security.
        $this->verify_ajax_nonce( 'urbantaxi_colors_nonce' );
        
        // Check user permissions
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => esc_html__( 'Insufficient permissions.', 'urbantaxi' ) ) );
        }

        // Define default colors
        $default_colors = array(
            'urbantaxi_first_theme_color' => '#FDC702',
            'urbantaxi_second_theme_color' => '#FFFFFF',
            'urbantaxi_third_theme_color' => '#2B2B2B',
            'urbantaxi_fourth_theme_color' => '#FFFDEE'
        );

        // Reset to default colors
        foreach ( $default_colors as $key => $value ) {
            set_theme_mod( $key, $value );
        }

        wp_send_json_success( array( 'message' => esc_html__( 'Theme colors reset to defaults!', 'urbantaxi' ) ) );
    }

    /**
     * Save general settings via AJAX
     */
    public function save_general_settings() {
        $this->verify_ajax_nonce( 'urbantaxi_general_nonce' );
        
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( json_encode( array( 'success' => false, 'message' => 'Insufficient permissions.' ) ) );
        }

        // Handle banner height as array
        $banner_heights = array();
        if ( isset( $_POST['urbantaxi_header_image_height'] ) && is_array( $_POST['urbantaxi_header_image_height'] ) ) {
            foreach ( $_POST['urbantaxi_header_image_height'] as $device => $height ) {
                $banner_heights[sanitize_key($device)] = $height;
            }
        }

        $settings = array(
            'urbantaxi_preloader_hide' => isset( $_POST['urbantaxi_preloader_hide'] ) && $_POST['urbantaxi_preloader_hide'] == '1' ? true : false,
            'header_image' => esc_url_raw( $_POST['header_image'] ),
            'urbantaxi_header_image_height' => $banner_heights
        );

        foreach ( $settings as $key => $value ) {
            set_theme_mod( $key, $value );
        }

        wp_send_json_success( array( 'message' => __( 'General settings saved successfully!', 'urbantaxi' ) ) );
    }

    /**
     * Reset general settings to defaults
     *
     * @since 1.0.0
     * @return void
     */
    public function reset_general_settings() {
        // Verify nonce for security.
        $this->verify_ajax_nonce( 'urbantaxi_general_nonce' );
        
        // Check user permissions
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => esc_html__( 'Insufficient permissions.', 'urbantaxi' ) ) );
        }

        // Define default settings
        $default_settings = array(
            'urbantaxi_preloader_hide' => false,
            'header_image' => '',
            'urbantaxi_header_image_height' => array(
                'mobile' => '250px',
                'tablet' => '300px',
                'desktop' => '350px'
            )
        );

        // Reset to defaults
        foreach ( $default_settings as $key => $value ) {
            set_theme_mod( $key, $value );
        }

        wp_send_json_success( array( 'message' => esc_html__( 'General settings reset to defaults!', 'urbantaxi' ) ) );
    }

    /**
     * Save 404 settings via AJAX
     *
     * @since 1.0.0
     * @return void
     */
    public function save_404_settings() {
        // Verify nonce for security.
        $this->verify_ajax_nonce( 'urbantaxi_404_nonce' );
        
        // Check user permissions
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => esc_html__( 'Insufficient permissions.', 'urbantaxi' ) ) );
        }

        // Sanitize and save 404 settings
        $settings = array(            
            'urbantaxi_404_heading' => sanitize_textarea_field( $_POST['urbantaxi_404_heading'] ),
            'urbantaxi_404_image' => esc_url_raw( $_POST['urbantaxi_404_image'] ),
            'urbantaxi_404_text' => sanitize_textarea_field( $_POST['urbantaxi_404_text'] ),
            'urbantaxi_404_button_text' => sanitize_text_field( $_POST['urbantaxi_404_button_text'] )
        );

        foreach ( $settings as $key => $value ) {
            set_theme_mod( $key, $value );
        }

        wp_send_json_success( array( 'message' => esc_html__( '404 settings saved successfully!', 'urbantaxi' ) ) );
    }

    /**
     * Reset 404 settings to defaults
     *
     * @since 1.0.0
     * @return void
     */
    public function reset_404_settings() {
        // Verify nonce for security.
        $this->verify_ajax_nonce( 'urbantaxi_404_nonce' );
        
        // Check user permissions
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => esc_html__( 'Insufficient permissions.', 'urbantaxi' ) ) );
        }

        // Define default 404 settings
        $default_settings = array(
            'urbantaxi_404_heading' => '404',
            'urbantaxi_404_image' => '',
            'urbantaxi_404_text' => 'We\'re Sorry — Something Has Gone Wrong On Our End.',
            'urbantaxi_404_button_text' => 'Back To Home'
        );

        // Reset to defaults
        foreach ( $default_settings as $key => $value ) {
            set_theme_mod( $key, $value );
        }

        wp_send_json_success( array( 'message' => esc_html__( '404 settings reset to defaults!', 'urbantaxi' ) ) );
    }

    /**
     * Save transportation settings via AJAX
     *
     * @since 1.0.0
     * @return void
     */
    public function save_transportation_settings() {
        // Verify nonce for security.
        $this->verify_ajax_nonce( 'urbantaxi_transportation_nonce' );
        
        // Check user permissions
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => esc_html__( 'Insufficient permissions.', 'urbantaxi' ) ) );
        }

        // Sanitize and save transportation settings
        $settings = array(
            'single_transportation_text_one' => wp_kses_post( wp_unslash( $_POST['single_transportation_text_one'] ?? '' ) ),
            'single_transportation_text_two' => wp_kses_post( wp_unslash( $_POST['single_transportation_text_two'] ?? '' ) ),
            'single_transportation_head_title' => sanitize_text_field( wp_unslash( $_POST['single_transportation_head_title'] ?? '' ) ),
            'single_transportation_text_three' => wp_kses_post( wp_unslash( $_POST['single_transportation_text_three'] ?? '' ) ),
            'single_transportation_book_now_text' => sanitize_text_field( wp_unslash( $_POST['single_transportation_book_now_text'] ?? '' ) ),
            'single_transportation_book_now_url' => esc_url_raw( trim( wp_unslash( $_POST['single_transportation_book_now_url'] ?? '' ) ) ),
            'single_transportation_paragraph_font_size' => sanitize_text_field( wp_unslash( $_POST['single_transportation_paragraph_font_size'] ?? '' ) ),
            'single_transportation_paragraph_color' => sanitize_hex_color( wp_unslash( $_POST['single_transportation_paragraph_color'] ?? '#333333' ) ),
            'single_transportation_heading_font_size' => sanitize_text_field( wp_unslash( $_POST['single_transportation_heading_font_size'] ?? '' ) ),
            'single_transportation_heading_color' => sanitize_hex_color( wp_unslash( $_POST['single_transportation_heading_color'] ?? '#000000' ) ),
            'single_transportation_feature_title_font_size' => sanitize_text_field( wp_unslash( $_POST['single_transportation_feature_title_font_size'] ?? '' ) ),
            'single_transportation_feature_title_color' => sanitize_hex_color( wp_unslash( $_POST['single_transportation_feature_title_color'] ?? '#000000' ) ),
            'single_transportation_feature_text_font_size' => sanitize_text_field( wp_unslash( $_POST['single_transportation_feature_text_font_size'] ?? '' ) ),
            'single_transportation_feature_text_color' => sanitize_hex_color( wp_unslash( $_POST['single_transportation_feature_text_color'] ?? '#333333' ) ),
            'single_transportation_book_now_font_size' => sanitize_text_field( wp_unslash( $_POST['single_transportation_book_now_font_size'] ?? '' ) ),
            'single_transportation_book_now_text_color' => sanitize_hex_color( wp_unslash( $_POST['single_transportation_book_now_text_color'] ?? '#000000' ) ),
            'single_transportation_book_now_bg_color' => sanitize_hex_color( wp_unslash( $_POST['single_transportation_book_now_bg_color'] ?? '#FDC702' ) ),
            'single_transportation_book_now_hover_text_color' => sanitize_hex_color( wp_unslash( $_POST['single_transportation_book_now_hover_text_color'] ?? '#ffffff' ) ),
            'single_transportation_book_now_hover_bg_color' => sanitize_hex_color( wp_unslash( $_POST['single_transportation_book_now_hover_bg_color'] ?? '#000000' ) )
        );

        $default_feature_titles = array(
            'Bluetooth Connectivity',
            'Mobile Charging Port',
            'GPS Navigation',
            'Air Conditioning',
            'Sanitized Interior',
            'Comfortable Seating'
        );
        $default_feature_texts = array(
            'Seamless wireless pairing',
            'Fast device charging',
            'Accurate route guidance',
            'Cool climate control',
            'Clean hygienic cabin',
            'Soft cushioned seats'
        );

        for ( $i = 1; $i <= 6; $i++ ) {
            $settings[ 'single_transportation_icon' . $i ] = esc_url_raw( trim( wp_unslash( $_POST[ 'single_transportation_icon' . $i ] ?? ( get_template_directory_uri() . '/assets/images/single-transportation/icon' . $i . '.png' ) ) ) );
            $settings[ 'single_transportation_title' . $i ] = sanitize_text_field( wp_unslash( $_POST[ 'single_transportation_title' . $i ] ?? $default_feature_titles[ $i - 1 ] ) );
            $settings[ 'single_transportation_text' . $i ] = sanitize_text_field( wp_unslash( $_POST[ 'single_transportation_text' . $i ] ?? $default_feature_texts[ $i - 1 ] ) );
        }

        foreach ( $settings as $key => $value ) {
            set_theme_mod( $key, $value );
        }

        wp_send_json_success( array( 'message' => esc_html__( 'Transportation settings saved successfully!', 'urbantaxi' ) ) );
    }

    /**
     * Reset transportation settings to defaults
     *
     * @since 1.0.0
     * @return void
     */
    public function reset_transportation_settings() {
        // Verify nonce for security.
        $this->verify_ajax_nonce( 'urbantaxi_transportation_nonce' );
        
        // Check user permissions
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => esc_html__( 'Insufficient permissions.', 'urbantaxi' ) ) );
        }

        // Define default transportation settings
        $default_settings = array(
            'single_transportation_text_one' => 'We offer competitive and affordable taxi pricing that is thoughtfully designed to suit every budget, whether you\'re traveling for daily commutes, business trips, airport transfers, or special occasions. Our goal is to make reliable transportation accessible without compromising on comfort, safety, or service quality. With a clear and straightforward fare structure, we ensure complete transparency from the moment you book your ride. You\'ll always know exactly what you\'re paying before your journey begins, giving you peace of mind and confidence in your travel plans.',
            'single_transportation_text_two' => 'Our pricing system is built on fairness and honesty. There are no hidden fees, unexpected surcharges, or confusing calculations. What you see is what you pay—no surge pricing during peak hours, no last-minute additions, and no unpleasant surprises at the end of your trip. We believe trust starts with transparency, and our pricing reflects that commitment.',
            'single_transportation_head_title' => 'Features Available:',
            'single_transportation_text_three' => 'We offer competitive and affordable taxi pricing that is thoughtfully designed to suit every budget, whether you\'re traveling for daily commutes, business trips, airport transfers, or special occasions. Our goal is to make reliable transportation accessible without compromising on comfort, safety, or service quality. With a clear and straightforward fare structure, we ensure complete transparency from the moment you book your ride. You\'ll always know exactly what you\'re paying before your journey begins, giving you peace of mind and confidence in your travel plans.',
            'single_transportation_book_now_text' => 'Book Now',
            'single_transportation_book_now_url' => '',
            'single_transportation_paragraph_font_size' => '16px',
            'single_transportation_paragraph_color' => '#333333',
            'single_transportation_heading_font_size' => '24px',
            'single_transportation_heading_color' => '#000000',
            'single_transportation_feature_title_font_size' => '18px',
            'single_transportation_feature_title_color' => '#000000',
            'single_transportation_feature_text_font_size' => '14px',
            'single_transportation_feature_text_color' => '#333333',
            'single_transportation_book_now_font_size' => '16px',
            'single_transportation_book_now_text_color' => '#000000',
            'single_transportation_book_now_bg_color' => '#FDC702',
            'single_transportation_book_now_hover_text_color' => '#ffffff',
            'single_transportation_book_now_hover_bg_color' => '#000000'
        );

        $default_feature_titles = array(
            'Bluetooth Connectivity',
            'Mobile Charging Port',
            'GPS Navigation',
            'Air Conditioning',
            'Sanitized Interior',
            'Comfortable Seating'
        );
        $default_feature_texts = array(
            'Seamless wireless pairing',
            'Fast device charging',
            'Accurate route guidance',
            'Cool climate control',
            'Clean hygienic cabin',
            'Soft cushioned seats'
        );

        for ( $i = 1; $i <= 6; $i++ ) {
            $default_settings[ 'single_transportation_icon' . $i ] = get_template_directory_uri() . '/assets/images/single-transportation/icon' . $i . '.png';
            $default_settings[ 'single_transportation_title' . $i ] = $default_feature_titles[ $i - 1 ];
            $default_settings[ 'single_transportation_text' . $i ] = $default_feature_texts[ $i - 1 ];
        }

        // Reset to defaults
        foreach ( $default_settings as $key => $value ) {
            set_theme_mod( $key, $value );
        }

        wp_send_json_success( array( 'message' => esc_html__( 'Transportation settings reset to defaults!', 'urbantaxi' ) ) );
    }

    /**
     * Save taxonomy location settings via AJAX
     *
     * @since 1.0.0
     * @return void
     */
    public function save_taxonomy_location_settings() {
        // Verify nonce for security.
        $this->verify_ajax_nonce( 'urbantaxi_taxonomy_location_nonce' );
        
        // Check user permissions
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => esc_html__( 'Insufficient permissions.', 'urbantaxi' ) ) );
        }

        // Sanitize and save taxonomy location settings
        $settings = array(
            'taxonomy_location_title_font_size' => sanitize_text_field( $_POST['taxonomy_location_title_font_size'] ),
            'taxonomy_location_title_color' => sanitize_hex_color( $_POST['taxonomy_location_title_color'] ),
            'taxonomy_location_content_font_size' => sanitize_text_field( $_POST['taxonomy_location_content_font_size'] ),
            'taxonomy_location_content_color' => sanitize_hex_color( $_POST['taxonomy_location_content_color'] ),
            'taxonomy_location_price_font_size' => sanitize_text_field( $_POST['taxonomy_location_price_font_size'] ),
            'taxonomy_location_price_color' => sanitize_hex_color( $_POST['taxonomy_location_price_color'] ),
            'taxonomy_location_button_text' => sanitize_text_field( $_POST['taxonomy_location_button_text'] ),
            'taxonomy_location_button_url' => esc_url_raw( trim( $_POST['taxonomy_location_button_url'] ) ),
            'taxonomy_location_button_font_size' => sanitize_text_field( $_POST['taxonomy_location_button_font_size'] ),
            'taxonomy_location_button_text_color' => sanitize_hex_color( $_POST['taxonomy_location_button_text_color'] ),
            'taxonomy_location_button_bg_color' => sanitize_hex_color( $_POST['taxonomy_location_button_bg_color'] ),
            'taxonomy_location_button_hover_text_color' => sanitize_hex_color( $_POST['taxonomy_location_button_hover_text_color'] ),
            'taxonomy_location_button_hover_bg_color' => sanitize_hex_color( $_POST['taxonomy_location_button_hover_bg_color'] )
        );

        foreach ( $settings as $key => $value ) {
            set_theme_mod( $key, $value );
        }

        wp_send_json_success( array( 'message' => esc_html__( 'Location settings saved successfully!', 'urbantaxi' ) ) );
    }

    /**
     * Reset taxonomy location settings to defaults
     *
     * @since 1.0.0
     * @return void
     */
    public function reset_taxonomy_location_settings() {
        // Verify nonce for security.
        $this->verify_ajax_nonce( 'urbantaxi_taxonomy_location_nonce' );
        
        // Check user permissions
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => esc_html__( 'Insufficient permissions.', 'urbantaxi' ) ) );
        }

        // Define default taxonomy location settings
        $default_settings = array(
            'taxonomy_location_title_font_size' => '20px',
            'taxonomy_location_title_color' => '#000000',
            'taxonomy_location_content_font_size' => '14px',
            'taxonomy_location_content_color' => '#333333',
            'taxonomy_location_price_font_size' => '18px',
            'taxonomy_location_price_color' => '#000000',
            'taxonomy_location_button_text' => 'Book Now',
            'taxonomy_location_button_url' => '',
            'taxonomy_location_button_font_size' => '14px',
            'taxonomy_location_button_text_color' => '#000000',
            'taxonomy_location_button_bg_color' => '#FDC702',
            'taxonomy_location_button_hover_text_color' => '#ffffff',
            'taxonomy_location_button_hover_bg_color' => '#000000'
        );

        // Reset to defaults
        foreach ( $default_settings as $key => $value ) {
            set_theme_mod( $key, $value );
        }

        wp_send_json_success( array( 'message' => esc_html__( 'Location settings reset to defaults!', 'urbantaxi' ) ) );
    }
}

// Initialize the dashboard settings class
// This creates a single instance of the settings class when the file is included
if ( class_exists( 'Urbantaxi_Dashboard_Settings' ) ) {
    new Urbantaxi_Dashboard_Settings();
}