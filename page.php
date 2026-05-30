<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
<div id="content" class="">
  <div class="container">
    <?php $urbantaxi_single_page_layout = get_theme_mod('urbantaxi_single_page_layout', 'One Column');
if ($urbantaxi_single_page_layout == 'One Column'): ?>
    <?php
  while (have_posts()):
    the_post();
    get_template_part('template-parts/content', get_post_type());

    wp_link_pages(
      array(
      'before' => '<div class="urbantaxi-pagination">',
      'after' => '</div>',
      'link_before' => '<span>',
      'link_after' => '</span>'
    )
    );
    if (comments_open() || get_comments_number()) {
      comments_template();
    }
  endwhile;
?>
    <?php
elseif ($urbantaxi_single_page_layout == 'Left Sidebar'): ?>
    <div class="row">
      <div class="col-lg-4 col-md-4">
        <div class="sidebar-area">
          <?php if (is_active_sidebar('page-sidebar')) {
    dynamic_sidebar('page-sidebar');
  }
  else {
    dynamic_sidebar('urbantaxi-sidebar');
  }?>
        </div>
      </div>
      <div class="col-lg-8 col-md-8">
        <?php
  while (have_posts()):
    the_post();
    get_template_part('template-parts/content', get_post_type());

    wp_link_pages(
      array(
      'before' => '<div class="urbantaxi-pagination">',
      'after' => '</div>',
      'link_before' => '<span>',
      'link_after' => '</span>'
    )
    );
    if (comments_open() || get_comments_number()) {

      comments_template();
    }
  endwhile;
?>
      </div>
    </div>
    <?php
elseif ($urbantaxi_single_page_layout == 'Right Sidebar'): ?>
    <div class="row">
      <div class="col-lg-8 col-md-8">
        <?php
  while (have_posts()):
    the_post();
    get_template_part('template-parts/content', get_post_type());

    wp_link_pages(
      array(
      'before' => '<div class="urbantaxi-pagination">',
      'after' => '</div>',
      'link_before' => '<span>',
      'link_after' => '</span>'
    )
    );
    if (comments_open() || get_comments_number()) {

      comments_template();
    }
  endwhile;
?>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="sidebar-area">
          <?php if (is_active_sidebar('page-sidebar')) {
    dynamic_sidebar('page-sidebar');
  }
  else {
    dynamic_sidebar('urbantaxi-sidebar');
  }?>
        </div>
      </div>
    </div>
    <?php
endif; ?>
  </div>
</div>

<?php get_footer(); ?>