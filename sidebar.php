<?php
/**
* This template displaying right sidebar.
*
* Displays on widgets.
* If no active widgets are in this footer sidebar, display the default widgets.
*
* @subpackage Travel Advisor
* @since      Travel Advisor 1.0
*/ ?>
<aside id="travel-advisor-sidebar-right">
		<?php if ( is_active_sidebar( 'travel-advisor-sidebar-right' ) ) :
			dynamic_sidebar( 'travel-advisor-sidebar-right' );
		else :
			the_widget( 'WP_Widget_Search' );
			the_widget( 'WP_Widget_Categories' );
			the_widget( 'Travel_Advisor_Recent_Post_Widget' );
			the_widget( 'WP_Widget_Archives' );
			the_widget( 'WP_Widget_Tag_Cloud' );
		endif; ?>
</aside><!-- #travel-advisor-sidebar-right -->