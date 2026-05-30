<?php get_header(); ?>

<div class="title-banner-image-box text-lg-start text-center position-relative">
    <div class="container title-banner-heading-box">
        <?php if (get_theme_mod('urbantaxi_header_page_title', true)): ?>
            
        <?php echo "<h1>Location</h1>"; ?>
        
        <?php endif; ?>
        <?php if (get_theme_mod('urbantaxi_header_breadcrumb', true)): ?>
        <div class="crumb-box">
            <?php urbantaxi_the_breadcrumb(); ?> Location
        </div>
        <?php endif; ?>
    </div>
    <div class="taxi-service-bg-text-box">
        <p>
            <?php echo esc_html(get_theme_mod('urbantaxi_header_taxi_title', 'TAXI SERVICE')); ?>
        </p>
    </div>
</div>
<div class="container">
    <div id="content" class="urbantaxi-single-location-box">
        <?php
            // Get current taxonomy term
            $term = get_queried_object();

            if ($term && !empty($term->slug)) :    

            if (have_posts()) : 
                // Get booking form URL
                $booking_url_setting = get_theme_mod('single_transportation_book_now_url', '');
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
                        $transport_booking_page = get_page_by_path('booking-form');
                        if ( $transport_booking_page ) {
                            $booking_url = get_permalink( $transport_booking_page->ID );
                        } else {
                            $booking_url = home_url('/booking-form/');
                        }
                    }
                }
                
                // Get button settings with fallback to booking URL if custom URL is empty
                $button_url = get_theme_mod( 'taxonomy_location_button_url', '' );
                if ( empty( $button_url ) ) {
                    $button_url = $booking_url;
                } else {
                    $button_url = esc_url( $button_url );
                }
                
                // Get button styling settings
                $button_text = get_theme_mod( 'taxonomy_location_button_text', 'Book Now' );
                $button_font_size = get_theme_mod( 'taxonomy_location_button_font_size', '14px' );
                $button_text_color = get_theme_mod( 'taxonomy_location_button_text_color', '#000000' );
                $button_bg_color = get_theme_mod( 'taxonomy_location_button_bg_color', '#FDC702' );
                $button_hover_text_color = get_theme_mod( 'taxonomy_location_button_hover_text_color', '#ffffff' );
                $button_hover_bg_color = get_theme_mod( 'taxonomy_location_button_hover_bg_color', '#000000' );
                
                // Add inline styles for booking buttons
                ?>
                <style type="text/css">
                    .taxonomy-location-book-btn {
                        color: <?php echo esc_attr( $button_text_color ); ?>;
                        background-color: <?php echo esc_attr( $button_bg_color ); ?>;
                        font-size: <?php echo esc_attr( $button_font_size ); ?>;
                    }
                    .taxonomy-location-book-btn:hover {
                        color: <?php echo esc_attr( $button_hover_text_color ); ?> !important;
                        background-color: <?php echo esc_attr( $button_hover_bg_color ); ?> !important;
                    }
                </style>
                <?php
            ?>

            <div class="cab-list row">

                <?php while (have_posts()) : the_post(); 
                    // Get typography settings
                    $title_font_size = get_theme_mod( 'taxonomy_location_title_font_size', '20px' );
                    $title_color = get_theme_mod( 'taxonomy_location_title_color', '#000000' );
                    $content_font_size = get_theme_mod( 'taxonomy_location_content_font_size', '14px' );
                    $content_color = get_theme_mod( 'taxonomy_location_content_color', '#333333' );
                    $price_font_size = get_theme_mod( 'taxonomy_location_price_font_size', '18px' );
                    $price_color = get_theme_mod( 'taxonomy_location_price_color', '#FDC702' );
                    ?>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="cab-item">
                            <div class="cab-item-img-box">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium'); ?>
                                <?php endif; ?>
                            </div>
                            <div class="cab-item-content-box">
                                <?php
                                    $price = get_post_meta(get_the_ID(), 'mptbm_km_price', true);
                                    $capacity = get_post_meta(get_the_ID(), 'mptbm_maximum_passenger', true);
                                    $charge = get_post_meta(get_the_ID(), 'mptbm_maximum_passenger', true);
                                    $passenger = get_post_meta(get_the_ID(), 'mptbm_maximum_passenger', true);
                                ?>

                                <h4 style="color: <?php echo esc_attr( $title_color ); ?>; font-size: <?php echo esc_attr( $title_font_size ); ?>;"><?php the_title(); ?></h4>
                                <div class="cab-item-list" style="color: <?php echo esc_attr( $content_color ); ?>; font-size: <?php echo esc_attr( $content_font_size ); ?>;">
                                    <p>Seating Capacity:<span><?php echo esc_html($passenger); ?></span></p>
                                    <p>Additional Charge/Km:<span><?php echo esc_html($passenger); ?></span></p>
                                    <p>Additional Passengers:<span><?php echo esc_html($passenger); ?></span></p>
                                </div>
                                <div class="cat-item-btn-price-box">
                                    <a href="<?php echo esc_url( $button_url ); ?>" class="taxonomy-location-book-btn" style="display: inline-block; padding: 10px 20px; text-decoration: none; border-radius: 5px; transition: all 0.3s ease;"><?php echo esc_html( $button_text ); ?></a>
                                    <p style="color: #2B2B2B; font-size: <?php echo esc_attr( $price_font_size ); ?>;">$<?php echo esc_html($price); ?><span>/Km</span> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>

            </div>

            <?php get_template_part('template-parts/pagination'); ?>

        <?php else :
                echo "<p>No cabs found in this location </p>";
            endif;

            else :
                echo "<h2>Invalid location </h2>";
            endif;
        ?>

    </div>
</div>

<?php get_footer(); ?>