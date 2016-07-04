<?php
/**
 * This template displaying footer-sidebar.
 * Displays on widgets.
 * If no active widgets are in this footer sidebar, hide it completely.
 *
 * @subpackage Travel Advisor
 * @since      Travel Advisor 1.0
 */ ?>
<div class='travel-advisor-sidebar-footer'>
	<?php if ( is_active_sidebar( 'travel-advisor-sidebar-footer' ) ) : ?> 
		<div id="travel-advisor-sidebar-footer" class="sidebar"> 
			<?php dynamic_sidebar( 'travel-advisor-sidebar-footer' ); ?>
		</div> 
	<?php endif; ?>
</div><!-- .travel-advisor-sidebar-footer -->