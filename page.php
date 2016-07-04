<?php
 /**
 * This template displaying pages
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
							</div> <!--end .travel-advisor-entry-content-->
						</article><!--end #article-->
						<?php comments_template();
				endif; ?>
			</div><!--end #travel_advisor_post_content-->
		</div><!--end #travel_advisor_content-->
		<?php get_sidebar(); ?>
		<div class="clear"></div>
	</div><!--end travel-advisor-container-->
</main>
<?php get_footer(); ?>