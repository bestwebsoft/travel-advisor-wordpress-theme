<?php
/**
 * This template displaying the 404 error blog 
 *
 * @subpackage Travel Advisor
 * @since      Travel Advisor 1.0
 */
get_header(); ?>
<main>
	<div class="travel-advisor-container">
		<div id="travel-advisor-content">
			<div id="travel-advisor-post-content">
				<article class="error-404 not-found">
					<h2 class="travel-advisor-entry-title">
						<?php _e( 'Oops! That page can not be found', 'travel-advisor' ); echo '. ' ?>
					</h2>
					<div class="clear"></div>
					<div class="travel-advisor-entry-content">
						<p>
							<?php _e( 'It looks like nothing was found at this location. Maybe try a search', 'travel-advisor' ); echo '? ' ?>
						</p>
						<?php get_search_form(); ?>
					</div><!-- .travel-advisor-entry-content -->
				</article><!-- .error-404 -->
			</div><!-- #travel_advisor_post_content -->
		</div><!--end #travel-advisor-content-->
		<?php get_sidebar(); ?>
		<div class="clear"></div>
	</div><!--end travel-advisor-container-->
</main>
<?php get_footer(); ?>