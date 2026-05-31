<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Urbantaxi 
 */
if (!defined('ABSPATH')) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.2, user-scalable=yes">

	<?php if ( ! has_site_icon() ) : ?>
		<link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() . '/assets/images/favicon.png' ); ?>" />
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
if (function_exists('wp_body_open')) {
	wp_body_open();
}
else {
	do_action('wp_body_open');
}
?>
<a class="skip-link screen-reader-text" href="#content">
	<?php esc_html_e('Skip to content', 'urbantaxi'); ?>
</a>
<header id="site-navigation">
	<div class="container">
		<div class="row header-main-box">
			<div class="col-xl-2 col-lg-2 col-md-2 col-sm-11 col-9 align-self-center text-start">
				<div class="logo text-lg-start text-md-start text-start">
					<?php $has_custom_logo = has_custom_logo(); ?>
					<div class="logo-image">
						<?php
						if ($has_custom_logo) {

							echo '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name')) . '" aria-label="' . esc_attr(get_bloginfo('name')) . '">';
							the_custom_logo(); // Show uploaded logo
							echo '</a>';

						}
						?>
					</div>
					<?php 
					$display_title = get_theme_mod('urbantaxi_display_header_title', '1');
					$display_text = get_theme_mod('urbantaxi_display_header_text', '0');
					$site_name = get_bloginfo('name');
					$site_description = get_bloginfo('description');
					$fallback_title = 'Urban Taxi';
					$fallback_tagline = 'Taxi & Transportation Services';
					
					$show_title = ( $display_title === '1' || $display_title === true || $display_title === 'on' );
					$show_text = ( $display_text === '1' || $display_text === true || $display_text === 'on' || ! empty( $site_description ) );
					$force_title_fallback = ! $has_custom_logo;
					
					// Fallback if theme options not configured yet and show tagline when there is content
					if ( $show_title || $show_text || $force_title_fallback || ( empty( $display_title ) && empty( $display_text ) ) ) {
					?>
					<div class="logo-content">
						<?php
						if ( $show_title || $force_title_fallback || ( empty( $display_title ) && ! $has_custom_logo ) ) :
							$title_text = ! empty( $site_name ) ? $site_name : $fallback_title;
							/* translators: %s: site name */
							echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( $title_text ) . '" aria-label="' . esc_attr( sprintf( __( '%s - Home', 'urbantaxi' ), $title_text ) ) . '">';
							echo esc_html( $title_text );
							echo '</a>';
						endif;
						if ( $show_text ) :
							$tagline_text = ! empty( $site_description ) ? $site_description : $fallback_tagline;
							echo '<span>' . esc_html( $tagline_text ) . '</span>';
						endif;
						?>
					</div>
					<?php } ?>
				</div>
			</div>
			<div class="col-xl-8 col-lg-8 col-md-8 col-sm-1 col-3 align-self-center text-end">
				<button class="menu-toggle my-2" aria-controls="top-menu" aria-expanded="false"
					aria-label="<?php esc_attr_e('Toggle navigation menu', 'urbantaxi'); ?>" type="button">
					<i class="fa-solid fa-bars"></i>
				</button>
				<nav id="main-menu" class="close-panal"
					aria-label="<?php esc_attr_e('Main Navigation', 'urbantaxi'); ?>" role="navigation">
					<?php
					wp_nav_menu([
						'theme_location' => 'main-menu',
						'container' => false,
						'menu_id' => 'top-menu',
						'menu_class' => 'main-navigation-menu',
					]);
					?>
					<button class="close-menu my-2 p-2" type="button"
						aria-label="<?php esc_attr_e('Close navigation menu', 'urbantaxi'); ?>">
						<span aria-hidden="true">
							<i class="fa-solid fa-xmark"></i> <!-- Close -->
						</span>
					</button>
				</nav>
			</div>
		</div>
	</div>
</header>