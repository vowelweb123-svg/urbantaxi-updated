<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Urbantaxi 
 */
if (!defined('ABSPATH')) {
  exit;
}
?>
<?php
$urbantaxi_archive_year = get_the_time('Y');
$urbantaxi_archive_month = get_the_time('m');
$urbantaxi_archive_day = get_the_time('d');
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post-single'); ?>>
  <?php if (has_post_thumbnail() && get_theme_mod(' urbantaxi_single_post_featured_image', true)) { ?>
  <div class="post-thumbnail post-img">
    <?php the_post_thumbnail(''); ?>
  </div>
  <?php
}?>
  <div class="post-info my-2 pt-4">
    <?php if (get_theme_mod('urbantaxi_single_post_author_hide', true)): ?>
    <div class="entry-author"><img class="single-author-image"
        src="<?php echo esc_url(get_avatar_url(get_the_author_meta('ID'))); ?>"><a
        href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
        <?php the_author(); ?><span class="screen-reader-text">
          <?php the_author(); ?>
        </span>
      </a></div>
    <?php endif; ?>
    <?php if (get_theme_mod('urbantaxi_single_post_comment_hide', true)): ?>
    <span class="custom-post-comment-box"><i
        class="me-1 <?php echo esc_attr(get_theme_mod('urbantaxi_post_comment_icon_changer', 'fa-solid fa-comment-dots')); ?>"></i><span
        class="entry-comments">
        <?php comments_number(__('0 Comments', 'urbantaxi'), __('0 Comments', 'urbantaxi'), __('% Comments', 'urbantaxi')); ?>
      </span></span>
    <?php endif; ?>
    <?php if (get_theme_mod('urbantaxi_single_post_date_hide', true)): ?>
    <span class="entry-date"><i
        class="<?php echo esc_attr(get_theme_mod('urbantaxi_post_date_icon_changer', 'fa fa-calendar')); ?>"></i><a
        href="<?php echo esc_url(get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d'))); ?>">
        <?php echo esc_html(get_the_date('d/m/Y')); ?>
      </a></span>
    <?php endif; ?>
  </div>
  <div class="post-content">
    <h5>
      <?php the_title(); ?>
    </h5>
    <p>
      <?php the_content(); ?>
    </p>

    <?php if (get_theme_mod('urbantaxi_single_post_tag', true)): ?>
    <?php the_tags('<div class="post-tags"><strong>' . esc_html__('Tags:', 'urbantaxi') . '</strong> ', ', ', '</div>'); ?>
    <?php endif; ?>
    <?php if (get_theme_mod('urbantaxi_single_post_category', true)): ?>
    <div class="single-post-category mt-3">
      <span class="category">
        <?php esc_html_e('Categories:', 'urbantaxi'); ?>
      </span>
      <?php the_category(); ?>
    </div>
    <?php endif; ?>
  </div>
</div>