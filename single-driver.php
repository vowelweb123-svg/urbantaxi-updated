<?php
/**
 * The template for displaying all single driver
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Urbantaxi
 */
if (!defined('ABSPATH')) {
    exit;
}

get_header();

$args = [
    'order' => 'ASC',
    'post_type' => 'driver',
    'posts_per_page' => -1
];
$new = new WP_Query($args);
?>

<div class="title-banner-image-box text-lg-start text-center position-relative">
    <div class="container title-banner-heading-box">
        <?php if (get_theme_mod('urbantaxi_header_page_title', true)): ?>
        <h1>
            <?php the_title(); ?>
        </h1>
        <?php endif; ?>
        <?php if (get_theme_mod('urbantaxi_header_breadcrumb', true)): ?>
        <div class="crumb-box">
            <?php urbantaxi_the_breadcrumb(); ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="taxi-service-bg-text-box">
        <p>
            <?php echo esc_html(get_theme_mod('urbantaxi_header_taxi_title', 'TAXI driver')); ?>
        </p>
    </div>
</div>

<div id="content" class="urbantaxi-single-driver-box">
    <div class="container">
        <div class="row urbantaxi-single-driver-inner-box">
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                <div class="urbantaxi-driver-image-box">
                    <?php if (has_post_thumbnail() && get_theme_mod(' urbantaxi_single_post_featured_image', true)) { ?>
                        <div class="post-thumbnail post-img position-relative">
                            <?php the_post_thumbnail('post-thumbnail', array(
                                'loading' => 'lazy',
                                'class' => 'post-thumbnail'
                            )); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12 mt-md-0 mt-4">
                <div class="post-content pt-3 mt-3">
                    <?php $driver_designation = get_post_meta( get_the_ID(), 'driver_designation_text', true ); ?>
                    <?php if ( ! empty( $driver_designation ) ) : ?>
                        <p class="driver-designation"><?php echo esc_html( $driver_designation ); ?></p>
                    <?php endif; ?>
                    <p class="driver-title"><?php the_title(); ?></p>
                    <?php the_content(); ?>
                </div>
            </div>
            <?php wp_link_pages(
                [
                    'before' => '<div class="urbantaxi-pagination">',
                    'after' => '</div>',
                    'link_before' => '<span>',
                    'link_after' => '</span>'
                ]
            ); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>