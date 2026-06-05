<?php
/**
 * The template for displaying all single transportation
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Urbantaxi
 */
if (!defined('ABSPATH')) {
    exit;
}

global $wp_query, $post;

$slug = sanitize_text_field(get_query_var('name'));
if (empty($slug)) {
    $slug = sanitize_text_field(get_query_var('pagename'));
}

$post_obj = $slug ? get_page_by_path($slug, OBJECT, 'mptbm_rent') : null;

if ($post_obj) {

    $post = $post_obj;
    $GLOBALS['post'] = $post_obj;

    $wp_query->post = $post_obj;
    $wp_query->posts = [$post_obj];
    $wp_query->queried_object = $post_obj;
    $wp_query->queried_object_id = $post_obj->ID;

    $wp_query->is_404 = false;
    $wp_query->is_single = true;
    $wp_query->is_singular = true;
    $wp_query->found_posts = 1;
    $wp_query->post_count = 1;

    status_header(200);

    setup_postdata($post_obj);

    add_filter('pre_get_document_title', function () use ($post_obj) {
        return $post_obj->post_title;
    });

    add_filter('aioseo_title', function () use ($post_obj) {
        return $post_obj->post_title;
    });
}

get_header(); ?>

<div class="title-banner-image-box text-lg-start text-center position-relative">
    <div class="container title-banner-heading-box">
        <?php if (get_theme_mod('urbantaxi_header_page_title', true)): ?>
        <?php echo "<h1>Single Transportation</h1>"; ?>
        <?php endif; ?>
        <?php if (get_theme_mod('urbantaxi_header_breadcrumb', true)): ?>
        <div class="crumb-box">
            <?php urbantaxi_the_breadcrumb(); ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="taxi-service-bg-text-box">
        <p>
            <?php echo esc_html(get_theme_mod('urbantaxi_header_taxi_title', 'TAXI SERVICE')); ?>
        </p>
    </div>
</div>

<div class="container-box">
    <?php if ($post_obj) :
        $passenger = get_post_meta($post_obj->ID, 'mptbm_maximum_passenger', true);
        $price_km = get_post_meta($post_obj->ID, 'mptbm_km_price', true);
        $extra_info = get_post_meta($post_obj->ID, 'mptbm_extra_info', true);
        $features = maybe_unserialize(get_post_meta($post_obj->ID, 'mptbm_features', true));
    ?>
    <div id="content" class="urbantaxi-single-transportation-box">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12">
                    <div class="urbantaxi-transportation-sidebar-com-box">
                        <?php if (!empty($features)) : ?>
                            <ul>
                                <li><span>Passengers:</span> <?php echo esc_html($passenger); ?></li>
                                <?php foreach ($features as $feature) : ?>
                                    <li>
                                        <span><?php echo esc_html($feature['label']); ?>:</span>
                                        <?php echo esc_html($feature['text']); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <div class="transportation-btn-box">
                            <?php
                            $booking_url_setting = trim( get_theme_mod( 'single_transportation_book_now_url', '' ) );
                            $booking_url = '';

                            if ( ! empty( $booking_url_setting ) ) {
                                if ( preg_match( '/^https?:\/\//i', $booking_url_setting ) || strpos( $booking_url_setting, '/' ) === 0 ) {
                                    $booking_url = esc_url( $booking_url_setting );
                                } else {
                                    $page = get_page_by_path( sanitize_title( $booking_url_setting ) );
                                    if ( $page ) {
                                        $booking_url = get_permalink( $page->ID );
                                    } else {
                                        $booking_url = esc_url( $booking_url_setting );
                                    }
                                }
                            }

                            if ( empty( $booking_url ) ) {
                                $booking_pages = get_pages(array(
                                    'meta_key' => '_wp_page_template',
                                    'meta_value' => 'booking-form.php'
                                ));
                                if ( ! empty( $booking_pages ) ) {
                                    $booking_url = get_permalink( $booking_pages[0]->ID );
                                } else {
                                    // Try to find the transport_booking page created by the plugin
                                    $transport_booking_page = get_page_by_path('booking-form');
                                    if ( $transport_booking_page ) {
                                        $booking_url = get_permalink( $transport_booking_page->ID );
                                    } else {
                                        $booking_url = home_url('/booking-form/'); // fallback assuming page slug
                                    }
                                }
                            }

                            $button_text = get_theme_mod( 'single_transportation_book_now_text', 'Book Now' );
                            $button_font_size = get_theme_mod( 'single_transportation_book_now_font_size', '16px' );
                            $button_text_color = get_theme_mod( 'single_transportation_book_now_text_color', '#000000' );
                            $button_bg_color = get_theme_mod( 'single_transportation_book_now_bg_color', '#FDC702' );
                            $button_hover_text_color = get_theme_mod( 'single_transportation_book_now_hover_text_color', '#ffffff' );
                            $button_hover_bg_color = get_theme_mod( 'single_transportation_book_now_hover_bg_color', '#000000' );
                            ?>
                            <style type="text/css">
                                .transportation-read-more-btn-custom {
                                    color: <?php echo esc_attr( $button_text_color ); ?>;
                                    background-color: <?php echo esc_attr( $button_bg_color ); ?>;
                                    font-size: <?php echo esc_attr( $button_font_size ); ?>;
                                }
                                .transportation-read-more-btn-custom:hover {
                                    color: <?php echo esc_attr( $button_hover_text_color ); ?> !important;
                                    background-color: <?php echo esc_attr( $button_hover_bg_color ); ?> !important;
                                }
                                .transportation-paragraph-text {
                                    color: <?php echo esc_attr( get_theme_mod( 'single_transportation_paragraph_color', '#333333' ) ); ?>;
                                    font-size: <?php echo esc_attr( get_theme_mod( 'single_transportation_paragraph_font_size', '16px' ) ); ?>;
                                }
                                .transportation-feature-heading {
                                    color: <?php echo esc_attr( get_theme_mod( 'single_transportation_heading_color', '#000000' ) ); ?>;
                                    font-size: <?php echo esc_attr( get_theme_mod( 'single_transportation_heading_font_size', '24px' ) ); ?>;
                                }
                                .transportation-feature-title {
                                    color: <?php echo esc_attr( get_theme_mod( 'single_transportation_feature_title_color', '#000000' ) ); ?>;
                                    font-size: <?php echo esc_attr( get_theme_mod( 'single_transportation_feature_title_font_size', '18px' ) ); ?>;
                                }
                                .transportation-feature-text {
                                    color: <?php echo esc_attr( get_theme_mod( 'single_transportation_feature_text_color', '#333333' ) ); ?>;
                                    font-size: <?php echo esc_attr( get_theme_mod( 'single_transportation_feature_text_font_size', '14px' ) ); ?>;
                                }
                            </style>
                            <a href="<?php echo esc_url( $booking_url ); ?>" class="transportation-read-more-btn transportation-read-more-btn-custom" target="_blank" rel="noopener">
                                <span class="cab-booking-btn-text"><?php echo esc_html( $button_text ); ?></span>  
                                 <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 7.08333C0 6.69212 0.317135 6.375 0.708333 6.375H16.2917C16.6829 6.375 17 6.69212 17 7.08333C17 7.47455 16.6829 7.79167 16.2917 7.79167H0.708333C0.317135 7.79167 0 7.47455 0 7.08333Z" fill="#000"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.41583 0.207464C9.69243 -0.0691546 10.1409 -0.0691546 10.4176 0.207464L16.7926 6.58247C17.0692 6.85908 17.0692 7.30759 16.7926 7.5842L10.4176 13.9592C10.1409 14.2358 9.69243 14.2358 9.41583 13.9592C9.13922 13.6826 9.13922 13.2341 9.41583 12.9575L15.29 7.08333L9.41583 1.2092C9.13922 0.932577 9.13922 0.484089 9.41583 0.207464Z" fill="#000"/>
                                </svg>                             
                            </a>
                                        
                            <div class="transportation-price-box">$<?php echo esc_html($price_km); ?><span> Per KM</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-7 col-sm-12 mt-md-0 mt-4">
                    <div class="urbantaxi-transportation-content-box">
                        <div class="urbantaxi-transportation-image-box">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cab-booking-content-box text-center">
                <div class="cab-booking-content-text text-center">
                        <p class="transportation-paragraph-text"><?php echo esc_html(get_theme_mod('single_transportation_text_one','We offer competitive and affordable taxi pricing that is thoughtfully designed to suit every budget, whether you’re traveling for daily commutes, business trips, airport transfers, or special occasions. Our goal is to make reliable transportation accessible without compromising on comfort, safety, or service quality. With a clear and straightforward fare structure, we ensure complete transparency from the moment you book your ride. You’ll always know exactly what you’re paying before your journey begins, giving you peace of mind and confidence in your travel plans.')); ?></p>

                        <p class="transportation-paragraph-text"><?php echo esc_html(get_theme_mod('single_transportation_text_two','Our pricing system is built on fairness and honesty. There are no hidden fees, unexpected surcharges, or confusing calculations. What you see is what you pay—no surge pricing during peak hours, no last-minute additions, and no unpleasant surprises at the end of your trip. We believe trust starts with transparency, and our pricing reflects that commitment.')); ?></p>
                    </div> 
                    <div class="cab-booking-features-box text-center">
                        <h4 class="transportation-feature-heading"><?php echo esc_html(get_theme_mod('single_transportation_head_title','Features Available:')); ?></h4>
                        <div class="row transportation-feature-main-box">
                            <?php 
                                $feature_title = array("Bluetooth Connectivity","Mobile Charging Port","GPS Navigation","Air Conditioning","Sanitized Interior","Comfortable Seating");
                                $feature_text = array("Seamless wireless pairing","Fast device charging","Accurate route guidance","Cool climate control","Clean hygienic cabin","Soft cushioned seats");
                            ?>
                            <?php for($i=1; $i<=6; $i++){ ?>
                                <div class="col-lg-4 col-sm-6 col-12 features-content-box">
                                     <div class="feature-icon-box">
                                        <img src="<?php echo esc_url(get_theme_mod("single_transportation_icon".$i, get_template_directory_uri() . '/assets/images/single-transportation/icon'.$i.'.png')); ?>">
                                    </div>
                                    <div class="feature-title-box">
                                        <h6 class="transportation-feature-title"><?php echo esc_html(get_theme_mod("single_transportation_title".$i, $feature_title[$i - 1])); ?></h6>
                                        <p class="transportation-feature-text"><?php echo esc_html(get_theme_mod("single_transportation_text".$i, $feature_text[$i - 1])); ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>  
            </div>  
            <p class="transportation-paragraph-text">
                <?php echo esc_html(get_theme_mod('single_transportation_text_three','We offer competitive and affordable taxi pricing that is thoughtfully designed to suit every budget, whether you’re traveling for daily commutes, business trips, airport transfers, or special occasions. Our goal is to make reliable transportation accessible without compromising on comfort, safety, or service quality. With a clear and straightforward fare structure, we ensure complete transparency from the moment you book your ride. You’ll always know exactly what you’re paying before your journey begins, giving you peace of mind and confidence in your travel plans.')); ?>
            </p>
        </div>

        <?php if ( did_action( 'elementor/loaded' ) ) {

            $template = get_page_by_path('faq-template',OBJECT,'elementor_library');

            if ( $template ) {
                echo \Elementor\Plugin::instance()
                    ->frontend
                    ->get_builder_content_for_display( $template->ID );
            }
        } ?>
    </div>
</div>  
<?php endif ?>
<?php get_footer(); ?>