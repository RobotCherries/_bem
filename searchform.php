<?php
/**
 * Custom _bem search form
 *
 * @package _bem
 */

?>
<form role="search" method="get" id="searchform" class="_search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text _search-form__label" for="s"><?php echo esc_html__( 'Search for:', '_bem' ); ?></label>
	<input class="_search-form__query" type="search" value="<?php echo get_search_query( ); ?>" name="s" id="s" placeholder="<?php echo esc_html__( 'Search for', '_bem' ); ?>" />
	<button class="_search-form__submit" type="submit" id="searchsubmit"><?php echo esc_attr_x( 'Search', 'submit button' ); ?></button>
</form>
