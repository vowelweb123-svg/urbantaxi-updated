<?php
/**
 * The template for displaying all single service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Urbantaxi
 */
if (!defined('ABSPATH')) {
    exit;
}

$current_term = get_queried_object();
$post_id_url = '';
if ($current_term) {
    $post_id_url = $current_term->ID;
}

get_header();

$args = [
    'order' => 'ASC',
    'post_type' => 'service',
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
            <?php echo esc_html(get_theme_mod('urbantaxi_header_taxi_title', 'TAXI SERVICE')); ?>
        </p>
    </div>
</div>

<div id="content" class="urbantaxi-single-service-box mt-5">
    <div class="container">
        <div class="row mb-md-5 mb-0 pb-md-5 pb-0">
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                <div class="urbantaxi-sidebar-com-box">
                    <div class="urbantaxi-service-sidebar-box">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <?php $i = 1; ?>
                            <?php
                                while ($new->have_posts()) {
                                    $new->the_post();
                                    $number_with_zero = sprintf("%02d", $i); ?>
                                <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link <?php echo esc_attr($post_id_url == get_the_ID() ? 'active' : ''); ?>"
                                    id="pills-<?php echo esc_attr($i); ?>-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-<?php echo esc_attr($i); ?>" type="button" role="tab"
                                    aria-controls="pills-<?php echo esc_attr($i); ?>" aria-selected="<?php if ($post_id_url == get_the_ID()) {
                                        echo " true";
                                    }; ?>">
                                    <div class="service-single-body text-start d-flex">
                                        <div class="service-count-box me-2">
                                            <?php echo esc_html($number_with_zero); ?>
                                        </div> <span>
                                            <?php the_title(); ?>
                                        </span>
                                    </div>
                                </button>
                            </li>
                            <?php $i++;
                            }
                            wp_reset_postdata(); ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12 mt-md-0 mt-4">
                <div class="tab-content" id="pills-tabContent">
                    <?php $j = 1; ?>
                    <?php
                    while ($new->have_posts()) {
                        $new->the_post();
                    ?>
                    <div class="tab-pane fade <?php echo esc_attr($post_id_url == get_the_ID() ? 'show active' : ''); ?>"
                        id="pills-<?php echo esc_attr($j); ?>" role="tabpanel"
                        aria-labelledby="pills-<?php echo esc_attr($j); ?>-tab">
                        <div id="post-<?php the_ID(); ?>" <?php post_class('post-single'); ?>>
                            <?php if (has_post_thumbnail() && get_theme_mod(' urbantaxi_single_post_featured_image', true)) { ?>
                            <div class="post-thumbnail post-img position-relative">
                                <?php the_post_thumbnail('post-thumbnail', array(
                                    'loading' => 'lazy',
                                    'class' => 'post-thumbnail'
                                )); ?>

                                <div class="service-meta-image"><img src="<?php echo esc_url(get_post_meta($post->ID, 'service_meta_icon', true)); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">

                                </div>
                                <div class="service-meta-button-box">
                                    <a href="<?php echo esc_url(get_post_meta($post->ID, 'service_meta_button_url', true)); ?>"><?php echo esc_html(get_post_meta($post->ID, 'service_meta_button_text', true)); ?><i class="<?php echo esc_html(get_post_meta($post->ID, 'service_meta_button_icon_class', true)); ?>"></i></a>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="post-content mt-xl-5 mt-lg-3 mt-3">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                    <?php $j++;
                    }
                    wp_reset_postdata(); ?>
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