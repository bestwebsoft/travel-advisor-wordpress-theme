<?php
/**
 * This template displaying posts
 *
 * @subpackage Travel Advisor
 * @since      Travel Advisor 1.0
 */
get_header(); ?>
<main>
	<div class="travel-advisor-container">
		<div id="travel-advisor-content">
			<div id="travel-advisor-post-content">
				<?php if ( have_posts() ) :
					the_post(); ?>
					<article id='post-<?php the_ID(); ?>' <?php post_class(); ?>>
						<h2 class="travel-advisor-entry-title">
							<?php the_title(); ?>
							<?php edit_post_link( '<i class="fa fa-pencil-square-o"></i>' ); ?>
						</h2>
						<div class="clear"></div>
						<div class="travel-advisor-meta">
							<span class="travel-advisor-posted">
								<?php _e( 'posted by', 'travel-advisor' );
								echo "&nbsp";
								the_author_posts_link();
								echo "&nbsp";
								printf( __( '%s ago', 'travel-advisor' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
							</span>
							<span class="travel-advisor-com">
								<i class="fa fa-comment"></i>
								<?php comments_number( '0', '1', '%' ); ?>
							</span>
						</div><!-- .travel-advisor-meta -->
						<div class="clear"></div>
						<!--echo content-->
						<div class="travel-advisor-entry-content">
							<?php if ( has_post_thumbnail() ) :
								the_post_thumbnail( 'homepage-thumb' );
							endif;
								the_content();
								wp_link_pages( array(
									'before' 		=> '<div class="page-links"><span class="page-links-title">' . __( 'Pages', 'travel-advisor' ) . ':' . '</span>', 
									'after' 		=> '</div>', 
									'link_before' 	=> '<span>', 
									'link_after' 	=> '</span>' 
				 				) ); ?>
						</div> <!-- .travel-advisor-entry-content -->
						<!-- tag list -->
						<?php if ( get_the_tag_list() ) :
							echo get_the_tag_list( '<p class="travel-advisor-tag">' . __( 'Tags', 'travel-advisor' ) . ': ',', ','</p>' );
						endif;
						/* category list */
						if ( get_the_category_list() ) : ?>
							<p class="travel-advisor-categories">
								<?php _e( 'Categories', 'travel-advisor' ); echo ': ';
								the_category( ', ' ); ?>
							</p>
						<?php endif; ?>
					</article>
					<?php comments_template();
				endif; ?>
				<div class="travel-advisor-post-pagination">
					<span class="travel-advisor-nav-previous">
						<?php previous_post_link( '%link', '<i class="fa fa-chevron-left"></i>&nbsp;&nbsp;' . __( 'Previous post', 'travel-advisor' ) ); ?>
					</span>
					<span class="travel-advisor-nav-next">
						<?php next_post_link( '%link', __( 'Next post ', 'travel-advisor' ) . '&nbsp;&nbsp;<i class="fa fa-chevron-right"></i>' ); ?>
					</span>
					<div class="clear"></div>
				</div><!-- .travel-advisor-post-pagination -->
			</div><!--end #travel_advisor_post_content-->
		</div><!--end #travel_advisor_content-->
		<?php get_sidebar(); ?>
		<div class="clear"></div>
	</div><!--end .travel-advisor-container-->
</main>
<div class="clear"></div>
<?php get_footer(); ?>