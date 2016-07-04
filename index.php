<?php
/**
 * The main template file
 * The template used to display the home page.
 *
 * @subpackage Travel Advisor
 * @since      Travel Advisor 1.0
 */
get_header();
global $query_string;
$order                = isset( $_POST['travel_advisor_sort'] ) ? $_POST['travel_advisor_sort'] : ( isset( $_COOKIE['travel_advisor_sort'] ) ? $_COOKIE['travel_advisor_sort'] : '' );
$per_page             = isset( $_POST['travel_advisor_items'] ) ? $_POST['travel_advisor_items'] : ( isset( $_COOKIE['travel_advisor_items'] ) ? $_COOKIE['travel_advisor_items'] : '' );
$expire               = apply_filters( 'post_password_expires', time() + 10 * DAY_IN_SECONDS );
$secure               = ( 'https' === parse_url( home_url(), PHP_URL_SCHEME ) );
if ( $order == "title" ) :
	$travel_advisor_query = new WP_Query( $query_string . '&order=ASC&orderby=' . $order . '&posts_per_page=' . $per_page );
else :
	$travel_advisor_query = new WP_Query( $query_string . '&orderby=' . $order . '&posts_per_page=' . $per_page );
endif;
$current_count        = $travel_advisor_query->post_count;
$all_count            = $travel_advisor_query->found_posts;
if ( $current_count > $all_count ) :
	$current_count = $all_count;
endif; ?>
<main>
	<div class="travel-advisor-container">
		<div id="travel-advisor-content">
			<div id="travel-advisor-post-content">
				<div id="travel-advisor-form-header">
					<div class="travel-advisor-header-posts-area">
						<span class="travel-advisor-count">
							<?php if ( $per_page == -1 ) :
								echo $all_count . "&nbsp";
								printf( _n( 'post', 'posts', $all_count, 'travel-advisor' ), $all_count );
							elseif ( $per_page == '' ) :
								echo $current_count . "&nbsp"; _e( 'posts found', 'travel-advisor' );
							else : 
								echo $per_page . "&nbsp"; _e( 'posts found', 'travel-advisor' );
							endif; ?>
						</span>
					</div><!-- .travel-advisor-header-posts-area -->
					<div class="travel-advisor-header-select-header">
						<div class="dropdown" id="sort">
							<form method="post" action="" id="order">
								<div class="selecter">
									<select name="travel_advisor_sort" class="styled" id="travel_advisor_sort">
										<option value="date" <?php selected( $order == "date" ); ?>>
											<?php _e( 'sort by date', 'travel-advisor' ); ?>
										</option>
										<option value="title" <?php selected( $order == "title" ); ?>>
											<?php _e( 'sort by title', 'travel-advisor' ); ?>
										</option>
									</select><!-- .travel_advisor_sort -->
								</div><!-- .selecter -->
							</form><!-- #order -->
						</div><!-- .dropdown -->
						<div class="dropdown" id="show">
							<form method="post" action="" id="per_page">
								<div class="selecter">
									<select name="travel_advisor_items" class="styled" id="travel_advisor_items" >
										<option value="" <?php selected( $per_page == '' ); ?>>
											<?php _e( 'number of items', 'travel-advisor' ); ?>
										</option>
										<option value="9" <?php selected( $per_page == '9' ); ?>>
											<?php printf( __( 'show %d items', 'travel-advisor' ), 9 ); ?>
										</option>
										<option value="5" <?php if ( $per_page == '5' ) echo 'selected=selected'; ?>>
											<?php printf( __( 'show %d items', 'travel-advisor' ), 5 ); ?>
										</option>
										<option value="-1" <?php if ( $per_page == '-1' ) echo 'selected=selected'; ?>>
											<?php printf( __( 'show all items', 'travel-advisor' ) ); ?>
										</option>
									</select><!-- #travel_advisor_items -->
								</div><!-- .selecter -->
							</form><!-- #per_page -->
						</div><!-- .dropdown -->
					</div>
					<div class="clear"></div>
				</div><!-- #travel_advisor_form_header -->
				<?php if ( $travel_advisor_query->have_posts() ) :
					while ( $travel_advisor_query->have_posts() ) :
						$travel_advisor_query->the_post(); ?>
							<article id='post-<?php echo $post->ID; ?>' <?php post_class(); ?>>
								<!-- display post title -->
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
										echo '&nbsp';
										the_author_posts_link();
										echo '&nbsp';
										printf( __( '%s ago', 'travel-advisor' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
									</span>
									<span class="travel-advisor-com">
										<i class="fa fa-comment"></i>
										<?php comments_number( '0', '1', '%' ); ?>
									</span>
								</div><!-- .travel-advisor-meta -->
								<div class="clear"></div>
								<div class="travel-advisor-entry-content">
									<div class="clear"></div>
									<?php if ( is_search() ) :
										the_excerpt();
									else :
										if ( has_post_thumbnail() ) : ?>
											<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
												<?php the_post_thumbnail( 'homepage-thumb' ); ?>
											</a>
										<?php endif;
										the_content();
										wp_link_pages( array(
											'before' 		=> '<div class="page-links"><span class="page-links-title">' . __( 'Pages', 'travel-advisor' ) . ':' . '</span>',
											'after' 		=> '</div>',
											'link_before' 	=> '<span>',
											'link_after' 	=> '</span>',
						 				) );
									endif; ?>
								<div class="clear"></div>
								</div><!-- .travel-advisor-entry-content -->
								<div class="clear"></div>
								<?php echo travel_advisor_excerpt_more( $more ); ?>
							</article><!--end article-->
					<?php endwhile;
				else : ?> <!-- have_posts() -->
					<p>
						<?php _e( 'Sorry, no posts matched your criteria', 'travel-advisor' ); ?>.
					</p>
				<?php endif; ?>
				<div class="travel-advisor-pagination">
					<?php travel_advisor_pagination( $travel_advisor_query->max_num_pages ); ?>
				</div><!-- .travel-advisor-pagination -->
			</div><!--end #post_content-->
		</div><!--end #content-->
		<?php wp_reset_postdata();
		get_sidebar(); ?>
		<div class="clear"></div>
	</div><!--end travel-advisor-container-->
	<div class="clear"></div>
</main>
<?php get_footer();