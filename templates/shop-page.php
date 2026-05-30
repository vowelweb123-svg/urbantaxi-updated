<?php

/* Template Name: Shop Template */
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

<div id="content">
    <div class="container">
        <div class="row">
            <div class="">
                <?php
                while (have_posts()):
                the_post();
                get_template_part('template-parts/content', 'page');

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
    </div>
</div>

<?php get_footer(); ?>