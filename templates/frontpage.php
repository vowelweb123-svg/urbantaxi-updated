<?php 

/* Template Name: Home Page Template */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
get_header(); ?>

<div id="content-home">
	<?php the_content(); ?>
</div>
<?php get_footer(); ?>