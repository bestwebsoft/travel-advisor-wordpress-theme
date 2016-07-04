<?php
/**
 * The footer template
 *
 * @subpackage Travel Advisor
 * @since Travel Advisor 1.0
 */ ?>
			</div>
			<div class="clear"></div>
			<footer>
				<div class="header-footer">
					<div class="travel-advisor-container">
						<div class="travel-advisor-logo-footer">
							<?php $logo_footer = get_theme_mod( 'logo_img_footer' );
							if ( ! empty( $logo_footer ) ) : ?>
								<div id="travel-advisor-suitcase">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
										<img src="<?php echo esc_url( $logo_footer ); ?>" alt="logo"/>
									</a>
								</div>
							<?php endif; ?>
							<h2>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
									<?php bloginfo( 'name' ); ?>
								</a>
							</h2>
							<div class="clear"></div>
						</div><!-- .travel-advisor-logo-footer -->
						<div id="travel-advisor-send">
							<?php if ( class_exists( 'Sbscrbr_Widget' ) ) :
								the_widget(
									'Sbscrbr_Widget',
									array(
										'widget_placeholder'  => __( 'type your email', 'travel-advisor' ),
										'widget_form_label'   => '<p class="subscribe">' . __( 'subscribe our news', 'travel-advisor' ) . ': </p>',
										'widget_button_label' => __( 'send', 'travel-advisor' ),
									),
									array(
										'widget_id' => rand( 100, 200 ),
									) );
							endif; ?>
						</div><!-- travel_advisor_send -->
						<div class="clear"></div>
					</div><!-- .travel-advisor-container -->
				</div><!-- .top_bottom-->
				<div class="get">
					<div class="travel-advisor-container">
						<?php get_sidebar( 'footer' ); ?>
					</div>
				</div><!-- .get -->
				<div class="clear"></div>
				<div class="travel-advisor-copyright">
					<div class="travel-advisor-container">
						<p class="copy">
							&copy; <?php echo date( 'Y' ); ?> <?php echo wp_get_theme()->get( 'Name' ); ?>
						</p><!-- .copy -->
						<p class="author-them">
							<?php _e( 'Powered by', 'travel-advisor' ); ?>
							<a href="<?php echo esc_url( wp_get_theme()->get( 'AuthorURI' ) ); ?>">BestWebLayout</a> <?php _e( 'and', 'travel-advisor' ); ?>
							<a href="<?php echo esc_url( 'http://wordpress.org/' ); ?>">WordPress</a>
						</p>
						<button class="arrow" onclick="up();">
							<i class="fa fa-angle-up"></i>
						</button>
						<div class="clear"></div>
					</div><!-- .travel-advisor-container -->
				</div><!-- .bottom_bottom -->
			</footer>
		</div><!-- end #wrapper -->
		<?php wp_footer (); ?>
	</body>
</html>