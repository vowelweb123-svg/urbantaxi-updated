<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Urbantaxi
 */
if (!defined('ABSPATH')) {
  exit;
}

get_header();
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

<?php while (have_posts()):
  the_post(); ?>

<div id="content">
  <div class="container">
    <div class="row">
      <div class="post-thumbnail">
        <?php if (has_post_thumbnail()) { ?>
          <?php the_post_thumbnail('post-thumbnail', array(
            'loading' => 'lazy',
            'class' => 'post-thumbnail'
          )); ?>
        <?php } else { ?>
          <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/blank-post.png'); ?>"
            alt="<?php esc_attr_e('Post Image', 'urbantaxi'); ?>">
        <?php } ?>
      </div>

      <?php
        $post_share_url   = get_permalink();
        $post_share_title = get_the_title();
        $instagram_url = get_theme_mod('urbantaxi_instagram_url', 'https://www.instagram.com/');
        $in_share = 'https://wa.me/?text=' . rawurlencode( $post_share_title . ' ' . $post_share_url );
        $tw_share = 'https://twitter.com/intent/tweet?url=' . rawurlencode( $post_share_url ) . '&text=' . rawurlencode( $post_share_title );
        $fb_share = 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $post_share_url );
        $li_share = 'https://www.linkedin.com/shareArticle?mini=true&url=' . rawurlencode( $post_share_url ) . '&title=' . rawurlencode( $post_share_title );
      ?>
      <div class="col-lg-1 col-md-2 text-center">
        <div class="post-social-icon-box">
          <div class="post-social-icon-box-main">
            <?php if ( $instagram_url ) : ?>
            <p class=""><a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram" aria-hidden="true"></i><span class="screen-reader-text"><?php esc_html_e( 'Instagram', 'urbantaxi' ); ?></span></a></p>
            <?php endif; ?>
            <p class=""><a href="<?php echo esc_url( $tw_share ); ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-twitter" aria-hidden="true"></i><span class="screen-reader-text"><?php esc_html_e( 'Share on Twitter', 'urbantaxi' ); ?></span></a></p>
            <p class=""><a href="<?php echo esc_url( $fb_share ); ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i><span class="screen-reader-text"><?php esc_html_e( 'Share on Facebook', 'urbantaxi' ); ?></span></a></p>
            <p class=""><a href="<?php echo esc_url( $li_share ); ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-linkedin-in" aria-hidden="true"></i><span class="screen-reader-text"><?php esc_html_e( 'Share on LinkedIn', 'urbantaxi' ); ?></span></a></p>
          </div>
        </div>
      </div>

      <div class="col-lg-10 col-md-10">
        <div class="post-content ">
          <div class="post-meta-content">
            <?php if (get_theme_mod('urbantaxi_single_post_author_hide', true)): ?>
            <div class="entry-author">
              <img class="single-author-image" src="<?php echo esc_url(get_avatar_url(get_the_author_meta('ID'))); ?>"
                alt="<?php echo esc_attr(get_the_author()); ?>">
              <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                <?php the_author(); ?>
                <span class="screen-reader-text">
                  <?php the_author(); ?>
                </span>
              </a>
            </div>
            <?php endif; ?>
            <?php if (get_theme_mod('urbantaxi_single_post_comment_hide', true)): ?>
            <span class="single-post-comment-icon"><i
                class="<?php echo esc_attr(get_theme_mod('urbantaxi_post_comment_icon_changer', 'fa-solid fa-comment-dots')); ?>"></i><span
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

          <?php the_content(); ?>
        </div>
        <?php if (get_theme_mod('urbantaxi_single_post_tag', true)): ?>
          <?php the_tags('<div class="post-tags"><strong>' . esc_html__('Tags:', 'urbantaxi') . '</strong> ', ' ', '</div>'); ?>
        <?php endif; ?>
        <?php if (get_theme_mod('urbantaxi_single_post_category', true)): ?>
          <div class="single-post-category mt-3">
            <span class="category">
              <?php esc_html_e('Categories:', 'urbantaxi'); ?>
            </span>
            <?php the_category(); ?>
          </div>
        <?php endif; ?>
        <?php if (comments_open() || get_comments_number()) { ?>
        <div class="single-comment-box">
          <?php comments_template(); ?>
        </div>
        <?php
  }?>
      </div>

    </div>
  </div>
</div>

<?php
endwhile; ?>
<?php get_footer(); ?>