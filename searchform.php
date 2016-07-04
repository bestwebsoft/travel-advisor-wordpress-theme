<?php
/**
 * This template widget search
 *
 * @subpackage Travel Advisor
 * @since      Travel Advisor 1.0
 */
?>
<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<input type="search" name="s" class="input" value="<?php echo get_search_query(); ?>" 
			placeholder="<?php _e( 'Search in Blog', 'travel-advisor' ); ?>" autocomplete="off">
		<span class="travel-advisor-search-submit-icon">
			<i class="fa fa-search"></i>
		</span>
		<input type="submit" class="search-submit" value=" ">
	</div>
</form>