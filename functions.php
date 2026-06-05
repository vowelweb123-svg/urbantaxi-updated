<?php
/**
 * Urbantaxi functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Urbantaxi
 */

if (!defined('ABSPATH')) {
	exit;
}
/**
 * Enqueue RTL stylesheet for right-to-left language support
 *
 * @since 1.0.0
 * @return void
 */
function urbantaxi_enqueue_rtl_styles()
{
	if (is_rtl()) {
		wp_enqueue_style(
			'urbantaxi-style-rtl',
			get_template_directory_uri() . '/assets/css/style-rtl.css',
		['urbantaxi-style'],
			wp_get_theme()->get('Version')
		);
	}
}
add_action('wp_enqueue_scripts', 'urbantaxi_enqueue_rtl_styles');


if (!defined('Urbantaxi_SERVER_URL')) {
	define('Urbantaxi_SERVER_URL', 'https://vwthemesdemo.com/themeforest/urbantaxi/');
}

/**
 * Enqueue admin styles for theme installation page
 *
 * Loads custom CSS for the theme installation admin page.
 *
 * @since 1.0.0
 * @param string $hook The current admin page hook
 * @return void
 */
function urbantaxi_installation_admin_scripts($hook)
{

	wp_enqueue_style(
		'urbantaxi-installation-admin-style',
		get_template_directory_uri() . '/assets/css/admin-installation.css',
	[],
		wp_get_theme()->get('Version')
	);

	$load_admin_uploader = ('appearance_page_urbantaxi-dashboard' === $hook);

	if (!$load_admin_uploader && in_array($hook, ['post.php', 'post-new.php'], true)) {
		$screen = function_exists('get_current_screen') ? get_current_screen() : null;

		if ($screen && 'service' === $screen->post_type) {
			$load_admin_uploader = true;
		}
	}

	if (!$load_admin_uploader) {
		return;
	}

	wp_enqueue_media();

	wp_enqueue_script(
		'urbantaxi-awscript',
		get_template_directory_uri() . '/assets/js/admin_script.js',
		['jquery'],
		file_exists(get_template_directory() . '/assets/js/admin_script.js') ? filemtime(get_template_directory() . '/assets/js/admin_script.js') : wp_get_theme()->get('Version'),
		true
	);
}

add_action(
	'admin_enqueue_scripts',
	'urbantaxi_installation_admin_scripts'
);
if (!function_exists('urbantaxi_enqueue_scripts')) {

	function urbantaxi_enqueue_scripts()
	{

		wp_enqueue_style(
			'bootstrap-min-css',
			get_template_directory_uri() . '/assets/css/bootstrap.min.css',
		[],
			wp_get_theme()->get('Version')
		);

		wp_enqueue_style(
			'fontawesome-css',
			get_template_directory_uri() . '/assets/css/fontawesome-all.css',
		[],
			wp_get_theme()->get('Version')
		);
 
		wp_enqueue_style(
			'aos-css',
			get_template_directory_uri() . '/assets/css/aos.css',
		[],
			wp_get_theme()->get('Version')
		);

		wp_enqueue_style(
			'urbantaxi-style',
			get_stylesheet_uri(),
		[],
			wp_get_theme()->get('Version')
		);

		wp_enqueue_style(
			'urbantaxi-responsive-css',
			get_template_directory_uri() . '/assets/css/responsive.css',
		[],
			wp_get_theme()->get('Version')
		);

		wp_enqueue_script(
			'urbantaxi-navigation',
			get_template_directory_uri() . '/assets/js/navigation.js',
		['jquery'],
			wp_get_theme()->get('Version'),
			true
		);

		wp_enqueue_script(
			'urbantaxi-script',
			get_template_directory_uri() . '/assets/js/script.js',
		['jquery'],
			wp_get_theme()->get('Version'),
			true
		);

		wp_enqueue_script(
			'aos',
			get_template_directory_uri() . '/assets/js/aos.js',
		[],
			wp_get_theme()->get('Version'),
			true
		);

		wp_enqueue_script(
			'urbantaxi-customscripts',
			get_template_directory_uri() . '/assets/js/custom.js',
		['jquery', 'aos'],
			wp_get_theme()->get('Version'),
			true
		);

		wp_enqueue_script(
			'smooth-scroll',
			get_template_directory_uri() . '/assets/js/SmoothScroll.js',
		['jquery'],
			wp_get_theme()->get('Version'),
			true
		);

		wp_enqueue_script(
			'bootstrap-js',
			get_template_directory_uri() . '/assets/js/bootstrap.min.js',
		['jquery'],
			wp_get_theme()->get('Version'),
			true
		);

		wp_enqueue_style(
			'animate-css',
			get_template_directory_uri() . '/assets/css/animate.css',
		[],
			wp_get_theme()->get('Version')
		);

		wp_enqueue_script(
			'wow-js',
			get_template_directory_uri() . '/assets/js/wow.js',
		['jquery'],
			wp_get_theme()->get('Version'),
			true
		);

		wp_enqueue_script(
			'urbantaxi-transport-select',
			get_template_directory_uri() . '/assets/js/transport-select.js',
		['jquery'],
			wp_get_theme()->get('Version'),
			true
		);

		/* ===== Custom color CSS ===== */

		require get_parent_theme_file_path(
			'/includes/color-setting/custom-color-control.php'
		);

		if (!empty($urbantaxi_theme_custom_setting_css)) {

			wp_add_inline_style(
				'urbantaxi-style',
				wp_strip_all_tags(
				$urbantaxi_theme_custom_setting_css
			)
			);
		}

		/* ===== Root variables ===== */

		$css = ':root {';

		$css .= '--urbantaxi-primary-theme-color:' .
			esc_attr(
			get_theme_mod(
			'urbantaxi_first_theme_color',
			'#FDC702'
		)
		) . ';';

		$css .= '--urbantaxi-secondary-theme-color:' .
			esc_attr(
			get_theme_mod(
			'urbantaxi_second_theme_color',
			'#FFFFFF'
		)
		) . ';';

		$css .= '--urbantaxi-tertiary-theme-color:' .
			esc_attr(
			get_theme_mod(
			'urbantaxi_third_theme_color',
			'#0B0B0B'
		)
		) . ';';

		$css .= '--urbantaxi-quaternary-theme-color:' .
			esc_attr(
			get_theme_mod(
			'urbantaxi_fourth_theme_color',
			'#111317'
		)
		) . ';';

		$css .= '}';


		/* ===== Logo size ===== */

		if (function_exists('urbantaxi_get_logo_dimensions')) {

			$img = urbantaxi_get_logo_dimensions();

			if ($img) {

				$css .= "
				.custom-logo{
					height:{$img['height']}px;
					width:{$img['width']}px;
					max-height:{$img['max_h']}px;
					max-width:{$img['max_w']}px;
				}";
			}
		}

		wp_add_inline_style(
			'urbantaxi-style',
			$css
		);


		if (is_singular()) {
			wp_enqueue_script('comment-reply');
		}


		/* ===== Header image css ===== */

		$css = '';

		if (get_header_image()) {

			$css .= '
			.title-banner-image-box{
				background-image:url(' . esc_url(get_header_image()) . ');
				background-position:center;
				background-size:cover;
				height: 250px;
				display:flex;
				align-items:center;
				background: #0F1011;
			}';
		}


		$loader = get_theme_mod(
			'urbantaxi_loader_background_widget',
			false
		);

		if ($loader) {

			$css .= '
			.preloader{
				background-image:url(' .
				esc_url($loader) .
				');
			}';
		}

		wp_add_inline_style(
			'urbantaxi-style',
			$css
		);

	}

	add_action('wp_enqueue_scripts', 'urbantaxi_enqueue_scripts');

}

/**
 * urbantaxi preloader
 *
 *
 * @since 1.0.0
 * @return void
 */

add_action('wp_body_open', 'urbantaxi_output_loader');
function urbantaxi_output_loader(){

	// If preloader is disabled, stop
	$urbantaxi_preloader_hide = get_theme_mod('urbantaxi_preloader_hide', false);
	// loader image from customizer (fallback to theme default)
	$urbantaxi_custom_preloader = get_theme_mod('urbantaxi_loader_background_widget', get_template_directory_uri() . '/assets/images/loader.gif');

	if (!$urbantaxi_preloader_hide) {
		return;
	}

	// Debug: when WP_DEBUG is true, emit an HTML comment with current preloader settings
	if (defined('WP_DEBUG') && WP_DEBUG) {
		error_log(
			'urbantaxi_preloader_hide: ' . print_r($urbantaxi_preloader_hide, true) .
			' | loader: ' . print_r($urbantaxi_custom_preloader, true)
		);
	}
?>

<div id="urbantaxi-preloader" class="loader" aria-hidden="true">
	<div class="demo">
		<span class="preloader" <?php echo ($urbantaxi_custom_preloader ? ' style="background-image: url(' .
			esc_url($urbantaxi_custom_preloader) . ');"' : '' ); ?>></span>
	</div>
</div>

<?php }

/* Setup theme */
if (!function_exists('urbantaxi_after_setup_theme')) {

	/**
	 * Setup theme defaults and registers support for various WordPress features
	 *
	 * Sets up theme textdomain, content width, navigation menus, theme supports,
	 * custom logo, custom header, and HTML5 support. This function is hooked into
	 * after_setup_theme to run after the theme is loaded.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function urbantaxi_after_setup_theme(){

		load_theme_textdomain('urbantaxi', get_template_directory() . '/languages');

		global $content_width;
		if (!isset($content_width)) {
			$content_width = 900;
		}

		register_nav_menus([

			'main-menu' => esc_html__('Main Menu', 'urbantaxi'),

			'footer-menu' => esc_html__('Footer Menu', 'urbantaxi'),

			'top-menu' => esc_html__('Top Bar Menu', 'urbantaxi'),

			'mobile-menu' => esc_html__('Mobile Menu', 'urbantaxi'),

		]);

		add_theme_support('responsive-embeds');
		add_theme_support('woocommerce');
		add_theme_support('align-wide');
		add_theme_support('align-full');
		add_theme_support('title-tag');
		add_theme_support('automatic-feed-links');
		add_theme_support('wp-block-styles');
		add_theme_support('post-thumbnails');
		add_theme_support('editor-styles');
		// Enqueue editor styles.
		add_editor_style('style.css');

		add_theme_support('custom-background', [
			'default-color' => 'FDC702'
		]);

		add_theme_support('custom-logo', [
			'height' => 150,
			'width' => 300,
		]);

		add_theme_support('custom-header', [
			'default-image' => get_parent_theme_file_uri('/assets/images/default-header-image.png'),
			'width' => 1920,
			'flex-width' => true,
			'height' => 400,
			'flex-height' => true,
			'header-text' => false,
		]);

		register_default_headers([
			'default-image' => [
				'url' => '%s/assets/images/default-header-image.png',
				'thumbnail_url' => '%s/assets/images/default-header-image.png',
				'description' => __('Default Header Image', 'urbantaxi'),
			],
		]);

		add_theme_support('html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		]);

		add_editor_style(['/assets/css/editor-style.css']);

	}

	add_action('after_setup_theme', 'urbantaxi_after_setup_theme');

}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function urbantaxi_content_width(){
	$GLOBALS['content_width'] = apply_filters('urbantaxi_content_width', 1360);
}
add_action('after_setup_theme', 'urbantaxi_content_width', 0);

/**
 * Register custom block styles.
 *
 * @since 1.0.0
 * @return void
 */
function urbantaxi_register_block_styles(){
	if (!function_exists('register_block_style')) {
		return;
	}

	register_block_style('core/button', [
		'name' => 'urbantaxi-primary',
		'label' => esc_html__('Urbantaxi Primary', 'urbantaxi'),
	]);
}
add_action('init', 'urbantaxi_register_block_styles');

/**
 * Register custom block patterns.
 *
 * @since 1.0.0
 * @return void
 */
function urbantaxi_register_block_patterns(){
	if (!function_exists('register_block_pattern')) {
		return;
	}

	if (function_exists('register_block_pattern_category')) {
		register_block_pattern_category('urbantaxi', [
			'label' => esc_html__('Urbantaxi', 'urbantaxi'),
		]);
	}

	register_block_pattern('urbantaxi/hero-cta', [
		'title' => esc_html__('Hero CTA', 'urbantaxi'),
		'description' => esc_html__('A simple hero section with a call to action button.', 'urbantaxi'),
		'categories' => ['urbantaxi', 'featured'],
		'content' => '<!-- wp:cover {"overlayColor":"black","minHeight":420,"align":"full"} -->
<div class="wp-block-cover alignfull" style="min-height:420px"><span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim-60 has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":1} -->
<h1 class="has-text-align-center">' . esc_html__('Reliable rides for every journey', 'urbantaxi') . '</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . esc_html__('Book safe, comfortable, and on-time taxi services with Urbantaxi.', 'urbantaxi') . '</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-urbantaxi-primary"} -->
<div class="wp-block-button is-style-urbantaxi-primary"><a class="wp-block-button__link wp-element-button" href="#">' . esc_html__('Book Now', 'urbantaxi') . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->',
	]);
}
add_action('init', 'urbantaxi_register_block_patterns');

/* Get post comments */
if (!function_exists('urbantaxi_comment')):
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
	function urbantaxi_comment($comment, $args, $depth){

		if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type): ?>

			<li id="comment-<?php comment_ID(); ?>" <?php comment_class('media'); ?>>
				<div class="comment-body">
					<?php
						esc_html_e('Pingback:', 'urbantaxi');
						wp_kses_post(comment_author_link());
						edit_comment_link(esc_html__('Edit', 'urbantaxi'), '<span class="edit-link">', '</span>');
					?>
				</div>

				<?php else: ?>

			<li id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>
				<article id="div-comment-<?php comment_ID(); ?>" class="comment-body media">
					<a class="pull-left" href="#">
						<?php
							if (0 != $args['avatar_size']) {
								echo get_avatar($comment, $args['avatar_size']);
							}
						?>
					</a>
					<div class="media-body">
						<div class="media-body-wrap card">
							<div class="card-header">
								<h5 class="mt-0">
									<?php
									printf(
										'<cite class="fn">%s</cite>',
										wp_kses_post(get_comment_author_link())
									); ?>
								</h5>
								<div class="comment-meta">
									<a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
										<time datetime="<?php comment_time('c'); ?>">
											<?php /* translators: %s: Date */printf(esc_html__('%1$s at %2$s', 'urbantaxi'), esc_html(get_comment_date()), esc_html(get_comment_time())); ?>
										</time>
									</a>
									<?php edit_comment_link(__('Edit', 'urbantaxi'), '<span class="edit-link">', '</span>'); ?>
								</div>
							</div>

							<?php if ('0' == $comment->comment_approved): ?>
							<p class="comment-awaiting-moderation">
								<?php esc_html_e('Your comment is awaiting moderation.', 'urbantaxi'); ?>
							</p>
							<?php endif; ?>

							<div class="comment-content card-block">
								<?php comment_text(); ?>
							</div>

							<?php comment_reply_link(
								array_merge(
									$args, [
										'add_below' => 'div-comment',
										'depth' => $depth,
										'max_depth' => $args['max_depth'],
										'before' => '<footer class="reply comment-reply card-footer">',
										'after' => '</footer><!-- .reply -->'
									]
								)
							); ?>
						</div>
					</div>
				</article>

				<?php
		endif;
	}
endif; // ends check for urbantaxi_comment()

	if (!function_exists('urbantaxi_widgets_init')) {

		/**
		 * Register widget areas
		 *
		 * Registers multiple sidebars including main sidebar, page sidebar, search sidebar,
		 * blog sidebar, project sidebar, service sidebar, and four footer widget areas.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		function urbantaxi_widgets_init()
		{

			register_sidebar([

				'name' => esc_html__('Sidebar', 'urbantaxi'),
				'id' => 'blog-sidebar',
				'description' => esc_html__('This sidebar will be shown next to the content.', 'urbantaxi'),
				'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="title">',
				'after_title' => '</h4>'

			]);

			register_sidebar([

				'name' => esc_html__('Blog Pages Sidebar', 'urbantaxi'),
				'id' => 'urbantaxi-sidebar',
				'description' => esc_html__('This sidebar will be shown next to the content.', 'urbantaxi'),
				'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="title">',
				'after_title' => '</h4>'

			]);

			register_sidebar([

				'name' => esc_html__('Single Blog Page Sidebar', 'urbantaxi'),
				'id' => 'single-blog-sidebar',
				'description' => esc_html__('This sidebar will be shown next to the content.', 'urbantaxi'),
				'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="title">',
				'after_title' => '</h4>'

			]);

			register_sidebar([

				'name' => esc_html__('Service Page Sidebar', 'urbantaxi'),
				'id' => 'service-sidebar',
				'description' => esc_html__('This sidebar will be shown next to the content.', 'urbantaxi'),
				'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="title">',
				'after_title' => '</h4>'

			]);


			register_sidebar([

				'name' => esc_html__('Footer sidebar 1', 'urbantaxi'),
				'id' => 'footer1-sidebar',
				'description' => esc_html__('It appears in the footer 1.', 'urbantaxi'),
				'before_widget' => '<aside id="%1$s" class="%2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h4 class="title">',
				'after_title' => '</h4>'

			]);

			register_sidebar([

				'name' => esc_html__('Footer sidebar 2', 'urbantaxi'),
				'id' => 'footer2-sidebar',
				'description' => esc_html__('It appears in the footer 2.', 'urbantaxi'),
				'before_widget' => '<aside id="%1$s" class="%2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h4 class="title">',
				'after_title' => '</h4>'

			]);

			register_sidebar([

				'name' => esc_html__('Footer sidebar 3', 'urbantaxi'),
				'id' => 'footer3-sidebar',
				'description' => esc_html__('It appears in the footer 3.', 'urbantaxi'),
				'before_widget' => '<aside id="%1$s" class="%2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h4 class="title">',
				'after_title' => '</h4>'

			]);

			register_sidebar([

				'name' => esc_html__('Footer sidebar 4', 'urbantaxi'),
				'id' => 'footer4-sidebar',
				'description' => esc_html__('It appears in the footer 4.', 'urbantaxi'),
				'before_widget' => '<aside id="%1$s" class="%2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h4 class="title">',
				'after_title' => '</h4>'

			]);

		}

		add_action('widgets_init', 'urbantaxi_widgets_init');

	}
/**
 * Generate breadcrumb navigation
 *
 * Displays hierarchical breadcrumb navigation based on current page context.
 * Handles home, category, single posts, pages, authors, archives, taxonomies, 
 * 404 pages, and search results.
 *
 * @since 1.0.0
 * @return void
 */
// breadcrumbs
function urbantaxi_the_breadcrumb(){

	if (is_home() || is_front_page()) {
		return;
	}

	/* Home */
	echo '<a href="' . esc_url(home_url('/')) . '">';
	echo esc_html__('Home', 'urbantaxi');
	echo '</a>';

	/* 404 Page */
	if (is_404()) {

		echo ' <span class="sep">/</span> ';
		echo '<span>' . esc_html__('404 Not Found', 'urbantaxi') . '</span>';

	}

	/* Category */
	elseif (is_category()) {

		$category = get_queried_object();

		echo ' <span class="sep">/</span> ';
		echo '<span>' . esc_html($category->name) . '</span>';

	}

	/* Single Post */
	elseif (is_single()) {

		$categories = get_the_category();

		if (!empty($categories)) {

			$category = $categories[0];

			echo ' <span class="sep">/</span> ';
			echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">';
			echo esc_html($category->name);
			echo '</a>';
		}

		echo ' <span class="sep">/</span> ';
		echo '<span>' . esc_html(get_the_title()) . '</span>';

	}

	/* Page */
	elseif (is_page()) {

		echo ' <span class="sep">/</span> ';
		echo '<span>' . esc_html(get_the_title()) . '</span>';

	}

	/* Author */
	elseif (is_author()) {

		echo ' <span class="sep">/</span> ';
		echo '<span>' . esc_html(get_the_author()) . '</span>';

	}

	/* Tag */
	elseif (is_tag()) {

		echo ' <span class="sep">/</span> ';
		echo '<span>' . esc_html(single_tag_title('', false)) . '</span>';

	}

	/* Day Archive */
	elseif (is_day()) {

		echo ' <span class="sep">/</span> ';
		echo '<span>' . esc_html(get_the_date()) . '</span>';

	}

	/* Month Archive */
	elseif (is_month()) {

		echo ' <span class="sep">/</span> ';
		echo '<span>' . esc_html(get_the_date('F Y')) . '</span>';

	}

	/* Year Archive */
	elseif (is_year()) {

		echo ' <span class="sep">/</span> ';
		echo '<span>' . esc_html(get_the_date('Y')) . '</span>';

	}

	/* Taxonomy */
	elseif (is_tax()) {

		echo ' <span class="sep">/</span> ';
		echo '<span>' . esc_html(single_term_title('', false)) . '</span>';

	}

	/* Search */
	elseif (is_search()) {

		echo ' <span class="sep">/</span> ';
		echo '<span>' . esc_html__('Search Results', 'urbantaxi') . '</span>';

	}

	/* Post Type Archive */
	elseif (is_post_type_archive()) {

		echo ' <span class="sep">/</span> ';
		echo '<span>' . esc_html(post_type_archive_title('', false)) . '</span>';

	}

	/* Generic Archive */
	elseif (is_archive()) {

		echo ' <span class="sep">/</span> ';
		echo '<span>' . esc_html__('Archives', 'urbantaxi') . '</span>';

	}
}

/**
 * Change number or products per row to 4
 */
add_filter('loop_shop_columns', 'urbantaxi_loop_columns', 999);
if (!function_exists('urbantaxi_loop_columns')) {
	/**
	 * Set number of WooCommerce product columns per row
	 *
	 * @since 1.0.0
	 * @return int Number of columns (default: 4)
	 */
	function urbantaxi_loop_columns(){
		return absint(get_theme_mod('urbantaxi_products_per_row', 4));
	}
}

/**
 * Set number of WooCommerce products per page
 *
 * @since 1.0.0
 * @param int $cols Number of products per page
 * @return int Filtered number of products per page (default: 8)
 */
//Change number of products that are displayed per page (shop page)
add_filter('loop_shop_per_page', 'urbantaxi_products_per_page');
function urbantaxi_products_per_page($cols){
	return absint(get_theme_mod('urbantaxi_products_per_page', 8));
}

add_filter('woocommerce_prevent_automatic_wizard_redirect', '__return_true');
/**
 * Sanitize phone number input
 * 
 * @param string $phone Phone number to sanitize
 * @return string Sanitized phone number with only digits and + sign
 */
function urbantaxi_sanitize_phone_number($phone){
	// First sanitize as text field to remove any dangerous content
	$phone = sanitize_text_field($phone);
	// Then keep only digits and + sign for international format
	return preg_replace('/[^\d+]/', '', $phone);
}

/**
 * Load theme settings and required files
 *
 * Includes TGM Plugin Activation and customizer settings files.
 *
 * @since 1.0.0
 * @return void
 */
function urbantaxi_enqueue_setting(){
	require get_template_directory() . '/includes/tgm/tgm.php';
	require get_template_directory() . '/includes/customizer.php';
}
add_action('after_setup_theme', 'urbantaxi_enqueue_setting');

// Require the one click demo import file
require get_template_directory() . '/inc/one-click-demo-import.php';

/**
 * Load custom single service template for service post type
 *
 * @since 1.0.0
 * @param string $single_template Path to single template file
 * @return string Path to the appropriate single template
 */
// single service
function urbantaxi_single_service($single_template){
	global $post;
	if ($post->post_type == 'service') {
		$single_template = get_theme_file_path('/single-service.php');
	}
	return $single_template;
}
add_filter('single_template', 'urbantaxi_single_service');

// single driver
function urbantaxi_single_driver($single_template){
	global $post;
	if ($post->post_type == 'driver') {
		$single_template = get_theme_file_path('/single-driver.php');
	}
	return $single_template;
}
add_filter('single_template', 'urbantaxi_single_driver');

/**
 * Increase AJAX timeout for One Click Demo Import
 *
 * @since 1.0.0
 * @return int Timeout in seconds (180)
 */
function urbantaxi_change_time_of_single_ajax_call(){
	return 180;
}
add_filter('ocdi/time_for_one_ajax_call', 'urbantaxi_change_time_of_single_ajax_call');

/**
 * Handle plugin activation actions
 *
 * Disables the Header Footer Elementor onboarding wizard when plugin is activated.
 *
 * @since 1.0.0
 * @param string $plugin The plugin basename
 * @return void
 */
function urbantaxi_activation($plugin){
	if ('header-footer-elementor/header-footer-elementor.php' === $plugin) {
		delete_option('hfe_start_onboarding');
		update_option('hfe_onboarding_triggered', 'yes');
	}

	if ('one-click-demo-import/one-click-demo-import.php' === $plugin) {
		set_transient('urbantaxi_ocdi_do_activation_redirect', 1, 30);
	}
}
add_action('activated_plugin', 'urbantaxi_activation');


/**
 * Handle plugin activation redirection
 *
 * Redirect to one click demo import when plugin is activated.
 *
 * @since 1.0.0
 * @param string $plugin The plugin basename
 * @return void
 */
function urbantaxi_maybe_redirect_to_ocdi(){
	// Only redirect in admin, not during Ajax, and if transient exists.
	if (!is_admin() || defined('DOING_AJAX') && DOING_AJAX) {
		return;
	}

	if (!current_user_can('manage_options')) {
		return;
	}

	if (get_transient('urbantaxi_ocdi_do_activation_redirect')) {
		delete_transient('urbantaxi_ocdi_do_activation_redirect');

		// target page for One Click Demo Import plugin
		$target = admin_url('admin.php?page=one-click-demo-import');

		// Fallback: if headers already sent or target is not available, skip.
		wp_safe_redirect($target);
		exit;
	}
}
add_action('admin_init', 'urbantaxi_maybe_redirect_to_ocdi');

/**
 * Disable Header Footer Elementor onboarding on admin initialization
 *
 * Runs only once (guarded by an option flag) so it does not write to the
 * database on every admin page load, which would interfere with WP Reset.
 *
 * @since 1.0.0
 * @return void
 */
function urbantaxi_admin_init(){
	if ( get_option( 'urbantaxi_hfe_onboarding_done' ) ) {
		return;
	}
	delete_option( 'hfe_start_onboarding' );
	update_option( 'hfe_onboarding_triggered', 'yes' );
	update_option( 'urbantaxi_hfe_onboarding_done', 'yes' );
}
add_action('admin_init', 'urbantaxi_admin_init', 1);

/**
 * Include Theme Dashboard Settings
 */
require get_template_directory() . '/inc/dashboard-settings/settings.php';

/**
 * Modify posts per page for archive and search pages
 *
 * Sets the number of posts to display on archive and search result pages.
 *
 * @since 1.0.0
 * @param WP_Query $query The WordPress Query object
 * @return void
 */
// pagination
function urbantaxi_archive_posts_per_page($query){
	if (!is_admin() && $query->is_main_query() && (is_archive() || is_search())) {
		$posts_per_page = absint(get_option('posts_per_page', 10));
		$query->set('posts_per_page', $posts_per_page > 0 ? $posts_per_page : 10);
	}
}
add_action('pre_get_posts', 'urbantaxi_archive_posts_per_page');

/**
 * Render appropriate sidebar for search pages
 *
 * Displays the search sidebar if active, otherwise falls back to default sidebar.
 *
 * @since 1.0.0
 * @return void
 */
function urbantaxi_render_sidebar(){
	if (is_active_sidebar('blog-sidebar')) {
		dynamic_sidebar('blog-sidebar');
	}
	else {
		dynamic_sidebar('urbantaxi-sidebar');
	}
}

/**
 * Enqueue customizer control styles
 */
function urbantaxi_customizer_styles(){

	wp_enqueue_style(
		'urbantaxi-customizer-controls',
		get_template_directory_uri() . '/assets/css/customize-controls.css',
	[],
		wp_get_theme()->get('Version')
	);
}
add_action('customize_controls_print_styles', 'urbantaxi_customizer_styles');

/**
 * Add class to body if data is imported
 *
 *
 * @since 1.0.0
 * @return void
 */
function urbantaxi_add_custom_body_class($classes){

	$home_page_id = urbantaxi_get_page_id_by_title('Home', 'page');

	if ($home_page_id && !is_wp_error($home_page_id)) {
		$classes[] = 'urbantaxi-imported';
	}
	return $classes;
}
add_filter('body_class', 'urbantaxi_add_custom_body_class');


/**
 * Display admin notice for One Click Demo Importer plugin
 *
 * Prompts users to install or activate the One Click Demo Importer plugin
 * if it is not already active.
 *
 * @since 1.0.0
 * @return void
 */

add_action('admin_notices', 'urbantaxi_one_click_demo_importer_admin_notice');
function urbantaxi_one_click_demo_importer_admin_notice(){

	// If plugin is already ACTIVE, stop
	if (class_exists('OCDI_Plugin')) {
		return;
	}

	// Check if plugin files exist (installed but inactive)
	$plugin_file = WP_PLUGIN_DIR . '/one-click-demo-import/one-click-demo-import.php';
	$is_installed = file_exists($plugin_file);

	if ($is_installed) {
		// Activate URL
		$action_url = wp_nonce_url(
			self_admin_url(
			'plugins.php?action=activate&plugin=one-click-demo-import/one-click-demo-import.php'
		),
			'activate-plugin_one-click-demo-import/one-click-demo-import.php'
		);
	}
	else {
		// Install URL
		$action_url = wp_nonce_url(
			self_admin_url(
			'update.php?action=install-plugin&plugin=one-click-demo-import'
		),
			'install-plugin_one-click-demo-import'
		);
	} ?>

	<div class="notice notice-warning is-dismissible d-flex one-click-importer-banner-outer-box">
		<div class="one-click-importer-banner-box">
			<h2>
				<?php echo esc_html__( 'Thanks for Choosing Urbantaxi!', 'urbantaxi' ); ?>
			</h2>
			<p>
				<?php echo esc_html__( 'To get the best experience with Urbantaxi and unlock all demo layouts,widgets, and urbantaxi-focused features, please install and activate the required core plugins.', 'urbantaxi' ); ?>
			</p>
			<?php if ($is_installed): ?>
			<p><a href="<?php echo esc_url($action_url); ?>" class="button button-primary">
					<?php echo esc_html__( 'Activate Plugin', 'urbantaxi' ); ?>
				</a></p>
			<?php else: ?>
			<p><a href="<?php echo esc_url($action_url); ?>" class="button button-primary">
					<?php echo esc_html__( 'Install Core Plugin', 'urbantaxi' ); ?>
				</a></p>
			<?php endif; ?>
		</div>
		<div class="one-click-importer-image-box">
			<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/importer-image.png'); ?>"
				alt="<?php esc_attr_e( 'importer-image', 'urbantaxi' ); ?>">
		</div>
	</div>

<?php }
// for ecab booking demo import issue start
if (!function_exists('skip_ecab_taxi_setup_wizard')) {
	function skip_ecab_taxi_setup_wizard($plugin)
	{
		if ($plugin === 'ecab-taxi-booking-manager/MPTBM_Plugin.php') {
			update_option('mptbm_quick_setup_done', 'yes');
		}
	}
	add_action('activated_plugin', 'skip_ecab_taxi_setup_wizard', 10, 1);
}
// for ecab booking demo import issue end

// for deleting default posts in taxi plugin
add_action('ocdi/after_import', 'urbantaxi_delete_plugin_demo_posts');
function urbantaxi_delete_plugin_demo_posts() {

	$titles_to_delete = [
		'Fiat Panda',
		'Mercedes-Benz E220',
		'Ford Tourneo',
		'Cadillac Escalade SUV',
		'Hummer New York Limousine',
		'Cadillac Escalade Limousine',
		'BMW 5 Series',
	];

	// Once the flag is set the posts have already been deleted; bail out
	// immediately without touching the database on every page load.
	if ( get_option( 'mptbm_demo_deleted' ) ) {
		return;
	}

	$posts = get_posts([
		'post_type' => 'mptbm_rent',
		'posts_per_page' => -1,
		'post_status' => 'any',
		'no_found_rows' => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
	]);

	foreach ($posts as $post) {
		if (in_array(trim($post->post_title), $titles_to_delete, true)) {
			wp_delete_post($post->ID, true);
		}
	}

	update_option('mptbm_demo_deleted', true);
}
// posts per page 
function urbantaxi_change_archive_posts_per_page($query){

	if (!is_admin() && $query->is_main_query() && ($query->is_category() || $query->is_tag())) {
		$posts_per_page = absint(get_option('posts_per_page', 10));
		$query->set('posts_per_page', $posts_per_page > 0 ? $posts_per_page : 10);
	}
}
add_action('pre_get_posts', 'urbantaxi_change_archive_posts_per_page');
