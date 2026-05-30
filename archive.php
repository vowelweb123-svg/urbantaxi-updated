<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Urbantaxi
 */
if (!defined('ABSPATH')) {
  exit;
}

$urbantaxi_enable_animation = (bool)get_theme_mod('urbantaxi_enable_post_animation', true);

$urbantaxi_animation_class = $urbantaxi_enable_animation ? ' zoomIn wow' : '';
$urbantaxi_animation_attr = $urbantaxi_enable_animation ? 'zoomIn' : 'none';

get_header(); ?>

<div class="title-banner-image-box text-lg-start text-center position-relative">
  <div class="container title-banner-heading-box">
    <div class="row">
      <div class="col-lg-12 title-banner-bread-box">
        <?php if (get_theme_mod('urbantaxi_header_page_title', true)): ?>
        <h1>
          <?php the_archive_title(); ?>
        </h1>
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
    <?php $urbantaxi_post_layout = get_theme_mod('urbantaxi_post_layout', 'Right Sidebar');
if ($urbantaxi_post_layout == 'Right Sidebar'): ?>
    <div class="row">
      <div class="col-lg-8 col-md-6">
        <div class="row">
          <?php
  if (have_posts()):
    while (have_posts()):
      the_post(); ?>
          <div class="col-lg-6 col-md-12 col-sm-6 col-12">
            <div id="post-<?php the_ID(); ?>" <?php post_class('post-box' . esc_attr($urbantaxi_animation_class)); ?>
              data-animation="
              <?php echo esc_attr($urbantaxi_animation_attr); ?>">
              <div class="box">
                <div class="post-thumbnail">
                  <?php if (has_post_thumbnail()) { ?>
                  <?php the_post_thumbnail('post-thumbnail', array(
          'loading' => 'lazy',
          'class' => 'post-thumbnail'
        )); ?>
                  <?php
      }
      else { ?>
                  <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/blank-post.png'); ?>"
                    alt="<?php esc_attr_e('Post Image', 'urbantaxi'); ?>">
                  <?php
      }?>
                </div>
              </div>
              <div class="post-content-box text-md-start text-center">
                <h3 class="post-title"><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>">
                    <?php the_title(); ?>
                  </a></h3>
                <div class="post-content">
                  <?php echo wp_kses_post(
        wp_trim_words(get_the_content(), 15)
      ); ?>
                </div>
                <div class="post-meta-content d-flex" style="justify-content:space-between;">
                  <?php if (get_theme_mod('urbantaxi_single_post_author_hide', true)): ?>
                  <div class="entry-author"><img class="single-author-image"
                      src="<?php echo esc_url(get_avatar_url(get_the_author_meta('ID'))); ?>"><a
                      href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                      <?php the_author(); ?><span class="screen-reader-text">
                        <?php the_author(); ?>
                      </span>
                    </a></div>
                  <?php
      endif; ?>
                  <?php if (get_theme_mod('urbantaxi_single_post_comment_hide', true)): ?>
                  <span class="custom-post-comment-box"><i
                      class="<?php echo esc_attr(get_theme_mod('urbantaxi_post_comment_icon_changer', 'fa-solid fa-comment-dots')); ?>"></i><span
                      class="entry-comments">
                      <?php comments_number(__('0 Comments', 'urbantaxi'), __('0 Comments', 'urbantaxi'), __('% Comments', 'urbantaxi')); ?>
                    </span></span>
                  <?php
      endif; ?>
                  <?php if (get_theme_mod('urbantaxi_single_post_date_hide', true)): ?>
                  <span class="entry-date"><i
                      class="<?php echo esc_attr(get_theme_mod('urbantaxi_post_date_icon_changer', 'fa fa-calendar')); ?>"></i><a
                      href="<?php echo esc_url(get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d'))); ?>">
                      <?php echo esc_html(get_the_date('d/m/Y')); ?>
                    </a></span>
                  <?php
      endif; ?>
                </div>
              </div>
            </div>
          </div>
          <?php
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
            }?>
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
            } ?>
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
          <?php if (is_active_sidebar('blog-sidebar')) {
              dynamic_sidebar('blog-sidebar');
            }
            else {
              dynamic_sidebar('urbantaxi-sidebar');
            };
          ?>
        </div>
      </div>
    </div>
    <?php
    elseif ($urbantaxi_post_layout == 'Four Columns'): ?>
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