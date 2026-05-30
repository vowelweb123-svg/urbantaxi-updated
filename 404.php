<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Urbantaxi 
 */
if (!defined('ABSPATH')) {
  exit;
}
get_header(); ?>

<div class="title-banner-image-box text-lg-start text-center position-relative">
  <div class="container title-banner-heading-box">
    <?php if (get_theme_mod('urbantaxi_header_page_title', true)): ?>
    <h1>
      <?php echo esc_html(get_theme_mod('urbantaxi_page_not_found_title', __('404 Error!', 'urbantaxi'))); ?>
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

<div id="content">
  <div class="container">
    <div class="text-center not-found-content row g-4 justify-content-center position-relative">
      <h2 class="error-page-heading">
        <?php echo esc_html(get_theme_mod('urbantaxi_404_heading', '404')); ?>
      </h2>
      <img
        src="<?php echo esc_url(get_theme_mod('urbantaxi_404_image', get_template_directory_uri() . '/assets/images/404.png')); ?>"
        alt="<?php esc_attr_e('404 Error', 'urbantaxi'); ?>">
      <p>
        <?php echo esc_html(get_theme_mod('urbantaxi_404_text', 'We’re sorry — something has gone wrong on our end.')); ?>
      </p>
      <div class="error-btn">
        <a href="<?php echo esc_url(home_url('/')); ?>">
          <?php echo esc_html(get_theme_mod('urbantaxi_404_button_text', 'Back To Home')); ?>
        </a>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>