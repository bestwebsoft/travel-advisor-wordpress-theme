<?php
/**
 * This template displaying comments blog
 *
 * @subpackage Travel Advisor
 * @since      Travel Advisor 1.0
 */
if ( post_password_required() )
	return;
if ( have_comments() ) : ?>
	<div id="travel-advisor-comments" class="comments-area">
		<!-- title array comments -->
		<h3 class="travel-advisor-comments-title">
			<?php _e( 'comments', 'travel-advisor' ); ?>
			<span class="travel-advisor-counts-comments">
				(
					<?php comments_number( '0', '1', '%' ); ?>
				)
			</span>
		</h3>
		<ol class="travel-advisor-comment-list">
			<?php wp_list_comments( array(
				'style'       => 'ol',
				'callback'    => 'travel_advisor_comment',
				'short_ping'  => true,
				'avatar_size' => 80,
			) ); ?>
		</ol><!-- .comment-list -->
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav class="travel-advisor-comment-navigation" role="navigation">
				<div class="travel-advisor-nav-previous alignleft">
					<?php previous_comments_link( '&larr; ' . __( 'Previous comments', 'travel-advisor' ) ); ?>
				</div>
				<div class="travel-advisor-nav-next alignright">
					<?php next_comments_link( __( 'Next Comments', 'travel-advisor' ) . ' &rarr;' ); ?>
				</div>
				<div class="clear"></div>
			</nav><!-- .comment-navigation -->
		<?php endif;
		if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="travel-advisor-no-comments">
				<?php _e( 'Comments are closed' , 'travel-advisor' ); echo '. '; ?>
			</p>
		<?php endif; ?>
	</div><!-- #travel_advisor_comments -->
<?php endif; /* have_comments() */
comment_form( array(
	'label_submit'  => __( 'Leave a comment', 'travel-advisor' ),
	'title_reply'   => __( 'Leave a comment', 'travel-advisor' ),
	'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder=" ' . __( 'Your message', 'travel-advisor' ) . ' "></textarea></p>',
) );
if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>