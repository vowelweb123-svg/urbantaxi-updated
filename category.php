<?php
/**
 * The template for displaying tag pages
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
    <div class="row">
      <div class="col-lg-12">
        <?php if (get_theme_mod('urbantaxi_header_page_title', true)): ?>
          <?php the_archive_title('<h1>', '</h1>') ?>
        <?php endif; ?>
        <?php if (get_theme_mod('urbantaxi_header_breadcrumb', true)): ?>
        <div class="crumb-box">
          <?php urbantaxi_the_breadcrumb(); ?>
        </div>
        <?php endif; ?>

      
      </div>
    </div>
  </div>
  <div class="taxi-service-bg-text-box">
    <p>
      <?php echo esc_html(get_theme_mod('urbantaxi_header_taxi_title', 'TAXI SERVICE')); ?>
    </p>
  </div>
</div>

<div id="content">
  <div class="container">
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
            } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>