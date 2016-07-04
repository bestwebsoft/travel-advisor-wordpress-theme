<?php
/**
* This template displaying search result
*
* @subpackage Travel Advisor
* @since      Travel Advisor 1.0
*/
get_header(); ?>
<main>
	<div class="travel-advisor-container">
		<div id="travel-advisor-content">
			<div id="travel-advisor-post-content">
				<h1 class="travel-advisor-search-results">
					<?php printf( __( 'search results for: %s', 'travel-advisor' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?>
				</h1>
				<?php if ( have_posts() ) :
					while ( have_posts() ) :
						the_post(); ?>
							<article id='post-<?php the_ID(); ?>' <?php post_class(); ?>>
								<h2 class="travel-advisor-entry-title">
									<a href="<?php the_permalink(); ?>" rel="bookmark">
										<?php the_title(); ?>
									</a>
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
								<div class="travel-advisor-entry-content">
									<?php if ( has_post_thumbnail() ) : ?>
										<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
											<?php the_post_thumbnail( 'homepage-thumb' ); ?>
										</a>
									<?php endif;
									the_excerpt();
									wp_link_pages( array(
										'before' 		=> '<div class="page-links"><span class="page-links-title">' . __( 'Pages', 'travel-advisor' ) . ':' . '</span>',
										'after' 		=> '</div>',
										'link_before' 	=> '<span>',
										'link_after' 	=> '</span>',
					 				) ); ?>
								</div> <!--end .travel-advisor-entry-content-->
								<?php echo travel_advisor_excerpt_more( $more ); ?>
							</article><!--end #article-->
					<?php endwhile;
				else : ?>
					<p>
						<?php _e( 'Sorry, no posts matched your criteria', 'travel-advisor' ); ?>.
					</p>
				<?php endif; ?>
				<div class="travel-advisor-pagination">
					<?php the_posts_pagination( array(
						'prev_text'          => '<i class="fa fa-angle-left"></i>',
						'next_text'          => '<i class="fa fa-angle-right"></i>',
						'end_size'           => 1,
						'mid_size'           => 1,
						'before_page_number' => '',
						'screen_reader_text' => '',
					) ); ?>
				</div><!-- .travel-advisor-pagination -->
			</div><!--end #travel_advisor_post_content-->
		</div><!--end #travel_advisor_content-->
		<?php get_sidebar(); ?>	
		<div class="clear"></div>
	</div><!--end travel_advisor_container-->
	<div class="clear"></div>
</main>
<?php get_footer(); ?>