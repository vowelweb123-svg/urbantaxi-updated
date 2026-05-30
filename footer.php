<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Urbantaxi
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<footer class="footer-side">
  <?php if ( get_theme_mod( 'urbantaxi_show_footer_widget', true ) ) : ?>
    <div class="footer-widget">
      <div class="container">
        <?php
          // Check if any footer sidebar is active
          $urbantaxi_any_sidebar_active = false;
          for ( $urbantaxi_i = 1; $urbantaxi_i <= 4; $urbantaxi_i++ ) {
            if ( is_active_sidebar( "footer{$urbantaxi_i}-sidebar" ) ) {
              $urbantaxi_any_sidebar_active = true;
              break;
            }
          }
          // Count active for responsive column classes
          $urbantaxi_active_sidebars = 0;
          if ( $urbantaxi_any_sidebar_active ) {
            for ( $urbantaxi_i = 1; $urbantaxi_i <= 4; $urbantaxi_i++ ) {
              if ( is_active_sidebar( "footer{$urbantaxi_i}-sidebar" ) ) {
                $urbantaxi_active_sidebars++;
              }
            }
          }
          $urbantaxi_col_class = $urbantaxi_active_sidebars > 0 ? 'col-lg-' . (12 / $urbantaxi_active_sidebars) . ' col-md-6 col-sm-12' : 'col-lg-3 col-md-6 col-sm-12';
        ?>
        <div class="row">
          <?php for ( $urbantaxi_i = 1; $urbantaxi_i <= 4; $urbantaxi_i++ ) : ?>
            <div class="footer-area <?php echo esc_attr($urbantaxi_col_class); ?>">
              <?php if ( $urbantaxi_any_sidebar_active && is_active_sidebar("footer{$urbantaxi_i}-sidebar") ) : ?>
                <?php dynamic_sidebar("footer{$urbantaxi_i}-sidebar"); ?>
              <?php elseif ( ! $urbantaxi_any_sidebar_active ) : ?>
                  <?php if ( $urbantaxi_i === 1 ) : ?>
                    <aside role="complementary" aria-label="<?php echo esc_attr__( 'footer1', 'urbantaxi' ); ?>" id="Search" class="sidebar-widget">
                      <h4 class="title" ><?php esc_html_e( 'Search', 'urbantaxi' ); ?></h4>
                      <?php get_search_form(); ?>
                    </aside>

                  <?php elseif ( $urbantaxi_i === 2 ) : ?>
                      <aside role="complementary" aria-label="<?php echo esc_attr__( 'footer2', 'urbantaxi' ); ?>" id="archives" class="sidebar-widget">
                      <h4 class="title" ><?php esc_html_e( 'Archives', 'urbantaxi' ); ?></h4>
                      <ul>
                          <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
                      </ul>
                      </aside>
                  <?php elseif ( $urbantaxi_i === 3 ) : ?>
                    <aside role="complementary" aria-label="<?php echo esc_attr__( 'footer3', 'urbantaxi' ); ?>" id="meta" class="sidebar-widget">
                      <h4 class="title"><?php esc_html_e( 'Meta', 'urbantaxi' ); ?></h4>
                      <ul>
                        <?php wp_register(); ?>
                        <li><?php wp_loginout(); ?></li>
                        <?php wp_meta(); ?>
                      </ul>
                    </aside>
                  <?php elseif ( $urbantaxi_i === 4 ) : ?>
                    <aside role="complementary" aria-label="<?php echo esc_attr__( 'footer4', 'urbantaxi' ); ?>" id="categories" class="sidebar-widget">
                      <h4 class="title" ><?php esc_html_e( 'Categories', 'urbantaxi' ); ?></h4>
                      <ul>
                          <?php wp_list_categories('title_li=');  ?>  
                      </ul>
                    </aside>
                  <?php endif; ?>
              <?php endif; ?>
            </div>
          <?php endfor; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <?php if( get_theme_mod( 'urbantaxi_show_footer_copyright',true)) : ?>
    <div class="footer-copyright">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 align-self-center text-center">
            <?php if ( get_theme_mod( 'urbantaxi_copyright_enable', true ) ) : ?>

              <p>
                <?php $default_text = sprintf(
                    /* translators: %s: current year */
                    __( 'Copyright ©%s Design & Developed by', 'urbantaxi' ),
                  wp_date( 'Y' )
                );
                echo esc_html(
                    get_theme_mod(
                        'urbantaxi_copyright_text',
                        $default_text
                    )
                ); ?>
                <a href="<?php echo esc_url( get_theme_mod(
                    'urbantaxi_copyright_url',
                    'https://www.vowelweb.com/'
                  ) ); ?>" rel="nofollow">

                  <?php echo esc_html(
                      get_theme_mod(
                          'urbantaxi_copyright_author_text',
                          __( 'VowelWeb', 'urbantaxi' )
                      )
                  ); ?>
                </a>
              </p>
            <?php endif; ?>
          </div>
          <?php if(get_theme_mod('urbantaxi_footer_social_icon_hide', false )== true){ ?>
            <div class="row">
              <div class="col-12 align-self-center py-1">
                <div class="footer-links">
                  <?php 
                  $urbantaxi_settings_footer = get_theme_mod( 'urbantaxi_social_links_settings_footer' );
                  if ( is_array($urbantaxi_settings_footer) || is_object($urbantaxi_settings_footer) ){
                    foreach( $urbantaxi_settings_footer as $urbantaxi_setting_footer ) {
                      $urbantaxi_setting_footer = (array) $urbantaxi_setting_footer;
                      if ( ! empty( $urbantaxi_setting_footer['link_url'] ) && ! empty( $urbantaxi_setting_footer['link_text'] ) ) :
                  ?>
                        <a href="<?php echo esc_url( $urbantaxi_setting_footer['link_url'] ); ?>" target="_blank" rel="noopener noreferrer">
                          <i class="<?php echo esc_attr( $urbantaxi_setting_footer['link_text'] ); ?> me-2"></i>
                        </a>
                  <?php 
                      endif;
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <?php if ( get_theme_mod( 'urbantaxi_scroll_enable_setting', true ) ) : ?>
    <div class="scroll-up">
        <a href="#"
           aria-label="<?php esc_attr_e( 'Scroll to top', 'urbantaxi' ); ?>">
            <i class="fas fa-angle-double-up" aria-hidden="true"></i>
        </a>
    </div>
  <?php endif; ?>
  <?php if(get_theme_mod('urbantaxi_progress_bar', false )== true): ?>
    <div id="elemento-progress-bar" class="theme-progress-bar <?php if( get_theme_mod( 'urbantaxi_progress_bar_position','top') == 'top') { ?> top <?php } else { ?> bottom <?php } ?>"></div>
  <?php endif; ?>
  <?php if(get_theme_mod('urbantaxi_cursor_outline', false )== true): ?>
    <!-- Custom cursor -->
    <div class="cursor-point-outline"></div>
    <div class="cursor-point"></div>
    <!-- .Custom cursor -->
  <?php endif; ?>
</footer>

<?php wp_footer(); ?>

</body>
</html>