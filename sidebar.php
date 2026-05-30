<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Urbantaxi
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="sidebar-area">
  <?php if ( ! dynamic_sidebar( 'urbantaxi-sidebar' ) ) : ?>
    <div role="complementary" aria-label="<?php echo esc_attr__( 'sidebar1', 'urbantaxi' ); ?>" id="Search" class="sidebar-widget">
      <h4 class="title" ><?php esc_html_e( 'Search', 'urbantaxi' ); ?></h4>
      <?php get_search_form(); ?>
    </div>
    <div role="complementary" aria-label="<?php echo esc_attr__( 'sidebar2', 'urbantaxi' ); ?>" id="archives" class="sidebar-widget">
      <h4 class="title" ><?php esc_html_e( 'Archives', 'urbantaxi' ); ?></h4>
      <ul>
          <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
      </ul>
    </div>
    <div role="complementary" aria-label="<?php echo esc_attr__( 'sidebar3', 'urbantaxi' ); ?>" id="meta" class="sidebar-widget">
      <h4 class="title"><?php esc_html_e( 'Meta', 'urbantaxi' ); ?></h4>
      <ul>
        <?php wp_register(); ?>
        <li><?php wp_loginout(); ?></li>
        <?php wp_meta(); ?>
      </ul>
    </div>
    <div role="complementary" aria-label="<?php echo esc_attr__( 'sidebar4', 'urbantaxi' ); ?>" id="tag-urbantaxi" class="sidebar-widget">
      <h4 class="title" ><?php esc_html_e( 'Tag Urbantaxi', 'urbantaxi' ); ?></h4>
      <?php wp_tag_urbantaxi(); ?>
    </div>
  <?php endif; // end sidebar widget area ?>
</div>