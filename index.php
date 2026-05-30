<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
      <?php esc_html_e('Blog', 'urbantaxi'); ?>
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
    <?php $urbantaxi_post_layout = get_theme_mod('urbantaxi_post_layout', 'Right Sidebar');
if ($urbantaxi_post_layout == 'Right Sidebar'): ?>
    <div class="row">
      <div class="col-lg-8 col-md-6">
        <div class="row">
          <?php
  if (have_posts()):

    while (have_posts()):

      the_post();
      get_template_part('template-parts/content');

    endwhile;

  else:

    get_template_part('no-results');

  endif;

  get_template_part('template-parts/pagination');
?>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="urbantaxi-sidebar-com-box">
          <div class="post-social-icon-box">
            <?php if (is_active_sidebar('blog-sidebar')) {
              dynamic_sidebar('blog-sidebar');
            }
            else {
              dynamic_sidebar('urbantaxi-sidebar');
            }?>
          </div>
        </div>
      </div>
    </div>
    <?php
    elseif ($urbantaxi_post_layout == 'Left Sidebar'): ?>
    <div class="row">
      <div class="col-lg-4 col-md-6">
        <div class="urbantaxi-sidebar-com-box">
          <div class="post-social-icon-box">
            <?php if (is_active_sidebar('blog-sidebar')) {
              dynamic_sidebar('blog-sidebar');
            }
            else {
              dynamic_sidebar('urbantaxi-sidebar');
            } ?>
          </div>
        </div>
      </div>
      <div class="col-lg-8 col-md-6">
        <div class="row">
          <?php
  if (have_posts()):

    while (have_posts()):

      the_post();
      get_template_part('template-parts/content');

    endwhile;

  else:

    get_template_part('no-results');

  endif;

  get_template_part('template-parts/pagination');
?>
        </div>
      </div>
    </div>
    <?php
elseif ($urbantaxi_post_layout == 'One Column'): ?>
    <div class="row">
      <?php
  if (have_posts()):

    while (have_posts()):

      the_post();
      get_template_part('template-parts/content');

    endwhile;

  else:

    get_template_part('no-results');

  endif;

  get_template_part('template-parts/pagination');
?>
    </div>
    <?php
elseif ($urbantaxi_post_layout == 'Three Columns'): ?>
    <div class="row">
      <div class="col-lg-4 col-md-6">
        <div class="urbantaxi-sidebar-com-box">
          <div class="post-social-icon-box">
            <?php if (is_active_sidebar('blog-sidebar')) {
              dynamic_sidebar('blog-sidebar');
            }
            else {
              dynamic_sidebar('urbantaxi-sidebar');
            }?>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="row">
          <?php
  if (have_posts()):

    while (have_posts()):

      the_post();
      get_template_part('template-parts/content');

    endwhile;

  else:

    get_template_part('no-results');

  endif;

  get_template_part('template-parts/pagination');
?>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="sidebar-area">
          <?php
  if (is_active_sidebar('blog-sidebar')) {
    dynamic_sidebar('blog-sidebar');
  }
  else {
    dynamic_sidebar('urbantaxi-sidebar');
  }
?>
        </div>
      </div>
    </div>
    <?php
elseif ($urbantaxi_post_layout == 'Four Columns'): ?>
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="urbantaxi-sidebar-com-box">
          <div class="post-social-icon-box">
            <?php if (is_active_sidebar('blog-sidebar')) {
              dynamic_sidebar('blog-sidebar');
            }
            else {
              dynamic_sidebar('urbantaxi-sidebar');
            }?>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-3">
        <div class="row">
          <?php
  if (have_posts()):

    while (have_posts()):

      the_post();
      get_template_part('template-parts/content');

    endwhile;

  else:

    get_template_part('no-results');

  endif;

  get_template_part('template-parts/pagination');
?>
        </div>
      </div>
      <div class="col-lg-3 col-md-3">
        <div class="sidebar-area">
          <?php if (is_active_sidebar('blog-sidebar')) {
    dynamic_sidebar('blog-sidebar');
  }
  else {
    dynamic_sidebar('urbantaxi-sidebar');
  }?>
        </div>
      </div>
      <div class="col-lg-3 col-md-3">
        <div class="sidebar-area sidebar-three">
          <?php
  if (is_active_sidebar('blog-sidebar')) {
    dynamic_sidebar('blog-sidebar');
  }
  else {
    dynamic_sidebar('urbantaxi-sidebar');
  }
?>
        </div>
      </div>
    </div>
    <?php
endif; ?>
  </div>
</div>

<?php get_footer(); ?>