<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<form method="get" id="searchform" class="searchform" action="<?php echo esc_url(home_url('/')); ?>">
	<label for="search" class="screen-reader-text"><?php esc_html_e('Search for:', 'urbantaxi'); ?></label>
	<input placeholder="<?php esc_attr_e('Search Here...', 'urbantaxi'); ?>" type="search" name="s" id="search" value="<?php the_search_query(); ?>" />
	<input type="submit" class="search-submit" value="<?php esc_attr_e('Search', 'urbantaxi');?>" />
</form>