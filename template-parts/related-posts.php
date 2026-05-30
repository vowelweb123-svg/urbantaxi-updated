<?php
/**
 * Related posts based on categories and tags.
 * 
 */
if (!defined('ABSPATH')) {
  exit;
}
$urbantaxi_archive_year = get_the_time('Y');
$urbantaxi_archive_month = get_the_time('m');
$urbantaxi_archive_day = get_the_time('d');

$urbantaxi_post_args = array(
  'posts_per_page' => 3,
  'orderby' => 'rand',
  'post__not_in' => array(get_the_ID()),
);

$urbantaxi_tax_terms = wp_get_post_terms(get_the_ID(), 'category');
$urbantaxi_terms_ids = array();
foreach ($urbantaxi_tax_terms as $tax_term) {
  $urbantaxi_terms_ids[] = $tax_term->term_id;
}

$urbantaxi_post_args['category__in'] = $urbantaxi_terms_ids;

$urbantaxi_related_posts = new WP_Query($urbantaxi_post_args);

if ($urbantaxi_related_posts->have_posts()): ?>
<div class="related-post pt-5 mt-5 text-center">
  <p>
    <?php echo esc_html(get_theme_mod('urbantaxi_related_blog_post_subtitle', 'Related Post')); ?>
  </p>
  <h2>
    <?php echo esc_html(get_theme_mod('urbantaxi_related_blog_post_heading', 'Related News & Blogs')); ?>
  </h2>
  <p>
    <?php echo esc_html(get_theme_mod('urbantaxi_related_blog_post_text', 'An education platform needed to support massive traffic spikes during online sessions.')); ?>
  </p>
  <div class="row pt-5">
    <?php while ($urbantaxi_related_posts->have_posts()):
    $urbantaxi_related_posts->the_post(); ?>
    <div class="col-xl-4 col-lg-6 col-md-6 col-12">
      <div id="post-<?php the_ID(); ?>" <?php post_class('post-box '); ?>>
              <div class="box">
                <div class="post-thumbnail">        
                  <?php if (has_post_thumbnail()) { ?>
                    <?php the_post_thumbnail(' post-thumbnail', array('loading' => 'lazy',
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
    <div class="post-content-box pt-3 pb-3 text-md-start text-center">
      <h3 class="post-title m-0"><a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
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
            class="me-1 <?php echo esc_attr(get_theme_mod('urbantaxi_post_comment_icon_changer', 'fa-solid fa-comment-dots')); ?>"></i><span
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
  endwhile; ?>
</div>
</div>
<?php
endif;
wp_reset_postdata();