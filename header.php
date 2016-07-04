<?php
/**
 * The header template
 * It contains the logo, slider and search widget
 *
 * @subpackage Travel Advisor
 * @since      Travel Advisor 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="description" content="<?php bloginfo( 'description' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="format-detection" content="telepfone=no">
		<?php wp_head(); ?>
	</head>	
	<body <?php body_class(); ?>>
		<div id="travel-advisor-wrapper">
			<header>
				<div id="travel-advisor-top">
					<div class="travel-advisor-container">
						<div class="travel-advisor-logo">
							<?php if ( function_exists( 'the_custom_logo' ) ) :
								if ( has_custom_logo() ) : ?>
									<div id="travel-advisor-suitcase">
										<?php travel_advisor_the_custom_logo(); ?>
									</div>
								<?php endif;
							else :
								$logo_header = get_theme_mod( 'logo_img_header' );
								if ( ! empty( $logo_header ) ) : ?>
									<div id="travel-advisor-suitcase">
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
											<img src="<?php echo esc_url ( $logo_header ); ?>" alt="logo"/>
										</a>
									</div>
								<?php endif;
							endif; ?>
							<h1>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
									<?php bloginfo( 'name' ); ?>
								</a>
							</h1>
							<?php $description = get_bloginfo( 'description', 'display' );
								if ( $description ) : ?>
									<h2>
										<?php echo $description; ?>
									</h2>
								<?php endif; ?>
							<div class="clear"></div>
						</div><!-- .travel-advisor-logo -->
						<div id="travel-advisor-header-search">
							<?php the_widget( 'WP_Widget_Search' ); ?>
						</div><!-- #travel_advisor_header_search -->
						<div class="clear"></div>
					</div><!-- .travel-advisor-container -->
					<div class="clear"></div>
				</div><!-- #travel_advisor_top -->
				<nav id="travel-advisor-header-menu">
					<div class="travel-advisor-container">
						<!-- battom for menu. It starts with a width of 320 -->
						<div class="travel-advisor-mobile-menu">
							<i class="fa fa-bars"></i>
							<button class="travel-advisor-mobile-menu-button">
								<i class="fa fa-sort-desc"></i>
							</button>
							<?php _e( 'menu', 'travel-advisor' ); ?>
						</div><!-- .travel-advisor-mobile-menu -->
						<?php wp_nav_menu( array(
							'theme_location' => 'travel_advisor_header',
							'menu_id'        => 'travel-advisor-header-nav'
						) ); ?>
						<div class="clear"></div>
					</div><!-- .travel-advisor-container -->
				</nav><!-- #travel_advisor_header_menu -->
				<?php global $wp_query;
					$args = array(
						'post_type'           => 'post',
						'meta_key'            => 'travel_advisor_add_slide',
						'meta_value'          => 'on',
						'posts_per_page'      => -1,
						'ignore_sticky_posts' => 1,
					); ?>
					<!-- slider -->
					<?php $wp_query = new WP_Query( $args );
					if ( $wp_query->have_posts() ) : ?>
						<div id="travel-advisor-slider-container">
							<ul id="carousel" class="owl-carousel carousel">
								<?php add_filter( 'excerpt_length', 'travel_advisor_slider_excerpt_length' );
								add_filter( 'excerpt_more', 'travel_advisor_slider_excerpt_more', 99 );
								while ( $wp_query->have_posts() ) :
									$wp_query->the_post(); ?>
									<li class="travel-advisor-slide">
										<?php if ( has_post_thumbnail() ) :
											the_post_thumbnail( 'thumbb-slider' );
										endif; ?>
										<div class="travel-advisor-container">
											<h2 class="slider-title">
												<a href="<?php the_permalink(); ?>">
													<?php travel_advisor_slider_words_limit( 16, ' ', get_the_title() ); ?>
												</a>
											</h2>
											<div class="travel-advisor-post-slider">
												<?php the_excerpt(); ?>
											</div><!-- .travel-advisor-post-slider -->
											<div class="travel-advisor-read-more">
												<a href="<?php the_permalink(); ?>">
													<?php _e( 'read more', 'travel-advisor' ); ?>
												</a>
											</div><!-- .travel-advisor-read-more -->
										</div><!-- .travel-advisor-container -->
										<div class="travel-advisor-slider-bacgr"></div>
									</li><!-- .travel-advisor-slide -->
								<?php endwhile;
								remove_filter( 'excerpt_length', 'travel_advisor_slider_excerpt_length' );
								remove_filter( 'excerpt_more', 'travel_advisor_slider_excerpt_more' ); ?>
							</ul><!--#carousel-->
						</div> <!--#travel-advisor-slider_container-->
					<?php endif; /* $wp_query->have_posts() */?>
				<?php wp_reset_postdata();
				wp_reset_query(); ?>
			</header>
			<div class="main-container">