<?php
/**
* Travel Advisor functions and definitions
* Sets up the theme and provides some helper functions, which are used in the
* theme as custom template tags. Others are attached to action
* hook in WordPress to change core functionality.
* Functions that are not pluggable (not wrapped in function_exists()) are
* instead attached to a filter or action hook.
* For more information on hooks, actions, and filters, @link http://codex.wordpress.org/Plugin_API
* @subpackage Travel Advisor
* @since Travel Advisor 1.0 
*/
function travel_advisor_setup() {
	/* This theme styles the visual editor with editor-style.css to match the theme style. */
	add_editor_style();
	/* Enable support for Post Formats. */
	add_theme_support( 'post-formats', array( 
		'aside',
		'gallery',
		'link',
		'image',
		'quote',
		'status',
		'video',
		'audio',
		'chat',
	) );
	/* This theme allows users to set a custom background */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	/* Add default posts and comments RSS feed links to head */
	add_theme_support( 'automatic-feed-links' );
	/* This theme does not use a hard-coded <title> tag in the document head */
	add_theme_support( 'title-tag' );
	/* This theme available for translation */
	load_theme_textdomain( 'travel-advisor', get_template_directory() . '/languages' );
	/* This theme allows users to set a custom background for body */
	add_theme_support( 'custom-background',	array(
		'default-color' => 'fff',
		'default-image' => '',
	) );
	/* This theme allows users to set a custom header */
	add_theme_support( 'custom-header',  array(
		'default-text-color' => 'f16f1e',
	) );

	add_theme_support( 'custom-logo', array(
		'height'      => 71,
		'width'       => 70,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );
	/* This theme uses wp_nav_menu() in one locations. */
	register_nav_menus( array(
		'travel_advisor_header' => __( 'Primary Menu', 'travel-advisor' )
	) );
	/* This theme uses post thumbnails */
	add_theme_support( 'post-thumbnails' );
	/* Size for featured */
	add_image_size( 'homepage-thumb', 840, 9999 );
	/* Size for slider */
	add_image_size( 'thumbb-slider', 9999, 663 );
	/* Size featured for sidebar */
	add_image_size( 'travel_advisor_recent_post_widget', 80, 80, array( 'center', 'center' ) );
	/* Add support for featured content */
	if ( ! isset( $content_width ) ) :
		$content_width = 840;
	endif;
	/* Enable support for custom logo. */
	add_theme_support( 'custom-logo', array(
		'height'      => 70,
		'width'       => 70,
		'flex-height' => true,
	) );

}

function travel_advisor_customize_register( $wp_customize ) {
	if ( ! function_exists( 'the_custom_logo' ) ) :
		$wp_customize->add_setting( 'logo_img_header',
			array(
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'logo_img_header',
				array(
					'label'    => __( 'Upload a Logo Image for Header', 'travel-advisor'),
					'section'  => 'title_tagline',
					'settings' => 'logo_img_header',
				)
			)
		);
	endif;
	$wp_customize->add_setting( 'logo_img_footer',
		array(
			'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'logo_img_footer',
			array(
				'label'    => __( 'Upload a Logo Image for Footer', 'travel-advisor'),
				'section'  => 'title_tagline',
				'settings' => 'logo_img_footer',
			)
		)
	);
}

/* It displays the logo */
if ( ! function_exists( 'travel_advisor_the_custom_logo' ) ) :
	function travel_advisor_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) : ?>
				<?php the_custom_logo(); ?>
		<?php endif;
	}
endif;

/* Post sorting function. */
function travel_advisor_init() {
	$order    = isset( $_POST['travel_advisor_sort'] ) ? $_POST['travel_advisor_sort'] :
			( isset( $_COOKIE['travel_advisor_sort'] ) ? $_COOKIE['travel_advisor_sort'] : '' );
	$per_page = isset( $_POST['travel_advisor_items'] ) ? $_POST['travel_advisor_items'] :
			( isset( $_COOKIE['travel_advisor_items'] ) ? $_COOKIE['travel_advisor_items'] : '' );
	$expire   = apply_filters( 'post_password_expires', time() + 10 * DAY_IN_SECONDS );
	$secure   = ( 'https' === parse_url( home_url(), PHP_URL_SCHEME ) );
	if ( isset( $_POST['travel_advisor_sort']  ) ) :
		setcookie( 'travel_advisor_sort', $order, $expire, COOKIEPATH, COOKIE_DOMAIN, $secure );
	endif;
	if ( isset( $_POST['travel_advisor_items']  ) ) :
		setcookie( 'travel_advisor_items', $per_page, $expire, COOKIEPATH, COOKIE_DOMAIN, $secure );
	endif;
}

/* Adds Contact_Widget. */
class Travel_Advisor_Contact_Widget extends WP_Widget {
	/* Register Contact Widget with WordPress. */
	function __construct() {
		parent::__construct(
			'travel_advisor_contact_widget', /* Base ID */
			__( 'Travel Advisor Contact Widget', 'travel-advisor' ), /* Name */
			array( 'description' => __( 'Travel Advisor Contact Widget', 'travel-advisor' ), ) /* Args */
		);
	}
	/* Front-end display of contact widget. */
	public function widget( $args, $instance ) {
		$title        = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Contacts', 'travel-advisor' );
		$title_phone  = ! empty( $instance['title_phone'] ) ? $instance[ 'title_phone' ] : '';
		$phone_1      = ! empty( $instance['phone_1'] ) ? $instance['phone_1'] : '';
		$phone_2      = ! empty( $instance['phone_2'] ) ? $instance['phone_2'] : '';
		$title_email  = ! empty( $instance['title_email'] ) ? $instance['title_email'] : '';
		$email_1      = ! empty( $instance['email_1'] ) ? $instance['email_1'] : '';
		$email_2      = ! empty( $instance['email_2'] ) ? $instance['email_2'] : '';
		$title_adress = ! empty( $instance['title_adress'] ) ? $instance['title_adress'] : '';
		$adress       = ! empty( $instance['adress'] ) ? $instance['adress'] : '';
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) :
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		endif;
		if ( ! empty ( $phone_1 ) || ! empty ( $phone_2 ) || ! empty ( $email_1 ) || ! empty ( $email_2 ) || ! empty ( $adress ) ) : ?>
			<div class="contacts_content">
				<?php if ( ! empty ( $phone_1 ) || ! empty ( $phone_2 ) ) : ?>
					<div class="title-phone">
						<?php echo $title_phone; ?>
					</div>
				<?php endif; ?>
				<?php if ( ! empty ( $phone_1 ) ) : ?>
					<div class="phone-1">
						<?php echo $phone_1; ?>
					</div>
				<?php endif; ?>
				<?php if ( ! empty ( $phone_2 ) ) : ?>
					<div class="phone-2">
						<?php echo $phone_2; ?>
					</div>
				<?php endif; ?>
				<?php if ( ! empty ( $email_1 ) || ! empty ( $email_2 ) ) : ?>
					<div class="title-email">
						<?php echo $title_email; ?>
					</div>
				<?php endif; ?>
				<?php if ( ! empty ( $email_1 ) ) : ?>
					<div class="email-1">
						<?php echo $email_1; ?>
					</div>
				<?php endif; ?>
				<?php if ( ! empty ( $email_2 ) ) : ?>
					<div class="email-2">
						<?php echo $email_2; ?>
					</div>
				<?php endif; ?>
				<?php if ( ! empty ( $adress ) ) : ?>
					<div class="title-adress">
						<?php echo $title_adress ; ?>
					</div>
					<div class="adress">
						<?php echo $adress ; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php else : ?>
			<h5>
				<?php _e( 'You need to enter contact information', 'travel-advisor' ); ?>
			</h5>
		<?php endif;
		echo $args['after_widget'];
	}
	/* Back-end contact widget form. */
	public function form( $instance ) {
		$title          = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Contacts', 'travel-advisor' );
		$title_phone    = ! empty( $instance['title_phone'] ) ? $instance['title_phone'] : __( 'phone number', 'travel-advisor' );
		$phone_1        = ! empty( $instance['phone_1'] ) ? $instance['phone_1'] : '';
		$phone_2        = ! empty( $instance['phone_2'] ) ? $instance['phone_2'] : '';
		$title_email    = ! empty( $instance['title_email'] ) ? $instance['title_email'] : __( 'email address', 'travel-advisor' );
		$email_1        = ! empty( $instance['email_1'] ) ? $instance['email_1'] : '';
		$email_2        = ! empty( $instance['email_2'] ) ? $instance['email_2'] : '';
		$title_adress   = ! empty( $instance['title_adress'] ) ? $instance['title_adress'] : __( 'address', 'travel-advisor' );
		$adress         = ! empty( $instance['adress'] ) ? $instance['adress'] : '';
		$email_error_1  = ! empty( $instance['email_error_1'] ) ? $instance['email_error_1'] : '';
		$email_error_2  = ! empty( $instance['email_error_2'] ) ? $instance['email_error_2'] : '';
		$phone_error_1  = ! empty( $instance['phone_error_1'] ) ? $instance['phone_error_1'] : '';
		$phone_error_2  = ! empty( $instance['phone_error_2'] ) ? $instance['phone_error_2'] : ''; ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title', 'travel-advisor' ); ?>:
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title_phone' ); ?>">
				<?php _e( 'Phone field title', 'travel-advisor' ); ?>:
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title_phone' ); ?>" name="<?php echo $this->get_field_name( 'title_phone' ); ?>" type="text" value="<?php echo esc_attr( $title_phone ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'phone_1' ); ?>">
				<?php _e( 'Field for the phone number', 'travel-advisor' ); ?>:
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'phone_1' ); ?>" name="<?php echo $this->get_field_name( 'phone_1' ); ?>" type="text" value="<?php echo esc_attr( $phone_1 ); ?>">
			<?php if ($phone_error_1 != '' ) :
				echo '<strong class="error" style="color: red">'.$phone_error_1 . '</strong>';
			endif; ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'phone_2' ); ?>">
				<?php _e( 'Field for the phone number', 'travel-advisor' ); ?>:
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'phone_2' ); ?>" name="<?php echo $this->get_field_name( 'phone_2' ); ?>" type="text" value="<?php echo esc_attr( $phone_2 ); ?>">
			<?php if ($phone_error_2 != '' ) :
				echo '<strong class="error" style="color: red">'.$phone_error_2 . '</strong>';
			endif; ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title_email' ); ?>">
				<?php _e( 'E-mail field title', 'travel-advisor' ); ?>:
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title_email' ); ?>" name="<?php echo $this->get_field_name( 'title_email' ); ?>" type="text" value="<?php echo esc_attr( $title_email ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'email_1' ); ?>">
				<?php _e( 'Field for an email', 'travel-advisor' ); ?>:
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'email_1' ); ?> " name="<?php echo $this->get_field_name( 'email_1' ); ?>" type="text" value="<?php echo esc_attr( $email_1 ); ?>">
			<?php if ($email_error_1 != '' ) :
				echo '<strong class="error" style="color: red">'.$email_error_1 . '</strong>';
			endif; ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'email_2' ); ?>">
				<?php _e( 'Field for an email', 'travel-advisor' ); ?>:
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'email_2' ); ?>" name="<?php echo $this->get_field_name( 'email_2' ); ?>" type="text" value="<?php echo esc_attr( $email_2 ); ?>">
			<?php if ($email_error_2 != '' ) :
				echo '<strong class="error" style="color: red">'.$email_error_2 . '</strong>';
			endif; ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title_adress' ); ?>">
				<?php _e( 'Address field title', 'travel-advisor' ); ?>:
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title_adress' ); ?>" name="<?php echo $this->get_field_name( 'title_adress' ); ?>" type="text" value="<?php echo esc_attr( $title_adress ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'adress' ); ?>">
				<?php _e( 'Address field', 'travel-advisor' ); ?>:
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'adress' ); ?>" name="<?php echo $this->get_field_name( 'adress' ); ?>" type="text" value="<?php echo esc_attr( $adress ); ?>">
		</p>
	<?php }

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']        = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['title_phone']  = ( ! empty( $new_instance['title_phone'] ) ) ? strip_tags( $new_instance['title_phone'] ) : '';
		if ( ! empty( $new_instance['phone_1'] ) ) :
			if ( ! preg_match( "/^[0-9-]+$/", trim( $new_instance['phone_1'] ) ) ) :
				$instance['phone_error_1'] = __( 'You entered an invalid phone number', 'travel-advisor' );
				$instance['phone_1']       = '';
			else :
				$phone_1             = trim( $new_instance['phone_1'] );
				$instance['phone_1'] = $phone_1;
			endif;
		endif;
		if ( ! empty( $new_instance['phone_2'] ) ) :
			if ( ! preg_match( "/^[0-9-]+$/", trim( $new_instance['phone_2'] ) ) ) :
				$instance['phone_error_2'] = __( 'You entered an invalid phone number', 'travel-advisor' );
				$instance['phone_2']       = '';
			else :
				$phone_2             = trim( $new_instance['phone_2'] );
				$instance['phone_2'] = $phone_2;
			endif;
		endif;
		$instance['title_email']  = ( ! empty( $new_instance['title_email'] ) ) ? strip_tags( $new_instance['title_email'] ) : '';
		if ( ! empty( $new_instance['email_1'] ) ) :
			if ( ! preg_match( "/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim( $new_instance['email_1'] ) ) ) :
				$instance['email_error_1'] = __( 'You entered an invalid email address', 'travel-advisor' );
				$instance['email_1']       = '';
			else :
				$email_1             = trim( $new_instance['email_1'] );
				$instance['email_1'] = $email_1;
			endif;
		endif;
		if ( ! empty( $new_instance['email_2'] ) ) :
			if ( ! preg_match( "/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim( $new_instance['email_2'] ) ) ) :
				$instance['email_error_2'] = __( 'You entered an invalid email address', 'travel-advisor' );
				$instance['email_2']       = '';
			else :
				$email_2             = trim( $new_instance['email_2'] );
				$instance['email_2'] = $email_2;
			endif;
		endif;
		$instance['title_adress'] = ( ! empty( $new_instance['title_adress'] ) ) ? strip_tags( $new_instance['title_adress'] ) : '';
		$instance['adress']       = ( ! empty( $new_instance['adress'] ) ) ? strip_tags( $new_instance['adress'] ) : '';
		return $instance;
	}/* end update */
}/* end .contact_Widget */

/* Add Widget Resent_posts. */
class Travel_Advisor_Recent_Post_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'travel_advisor_recent_post_widget',
			__( 'Travel Advisor Recent Posts Widget', 'travel-advisor' ),
			array( 'description' => __( 'Travel Advisor Recent Posts Widget', 'travel-advisor' ), )
		);
	}
	/* Front-end display of resent_posts widget. */
	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		$title  = ! empty( $instance['title'] ) ? $instance['title'] : __( 'recent posts', 'travel-advisor' );
		$number = ! empty( $instance['number'] ) ? $instance['number'] : 3;
		if ( ! empty( $title ) ) :
			echo $before_title . $title . $after_title;
		endif;
			$widget_recent_posts = new WP_Query( array(
				'posts_per_page'      => $number,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
			) ); ?>
			<ul>
				<?php if ( $widget_recent_posts->have_posts() ) :
					while ( $widget_recent_posts->have_posts() ) :
						$widget_recent_posts->the_post(); ?>
						<li>
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="travel-advisor-recent-thumbnail">
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
										<?php the_post_thumbnail( 'travel_advisor_recent_post_widget' ); ?>
										<div class="recent-thumbnail-lupa"></div>
									</a>
								</div>
							<?php endif; ?>
							<div class="travel-adviso-recent-descript">
								<div id="post- <?php the_ID();?> " class="recent-title">
									<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
										<?php the_title(); ?>
									</a>
								</div>
								<div class="travel-advisor-date">
									<span class="travel-advisor-recent-date">
										<?php printf( __( '%s ago', 'travel-advisor' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
									</span>
								</div>
							</div>
							<div class="clear"></div>
						</li>
					<?php endwhile;
				else : ?>
					<p>
						<?php _e( 'No posts yet', 'travel-advisor' ); ?>...
					</p>
				<?php endif;
				wp_reset_postdata(); ?>
			</ul>
		<?php echo $after_widget;
	}
	/* Back-end resent_posts widget form. */
	function form( $instance ) {
		$defaults  = array( 
			'title'     => '',
			'number'    => 3,
			'show_date' => '',
		);
		$instance  = wp_parse_args( ( array ) $instance, $defaults );
		$title     = $instance['title'];
		$number    = $instance['number']; ?>
		<p>
			<label for="category_widget_widget_recent_posts_title">
				<?php _e( 'Title', 'travel-advisor' ); ?>:
			</label>
			<input type="text" class="widefat" id="category_widget_widget_recent_posts_title" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="category_widget_widget_recent_posts_number">
				<?php _e( 'Number of posts to show', 'travel-advisor' ); ?>:
			</label>
			<input type="text" id="category_widget_widget_recent_posts_number" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo esc_attr( $number ); ?>" size="3" />
		</p>
	<?php }

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']  = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
		return $instance;
	}
}/* end resent posts widget*/

/* Adds Widget RSS_posts. */
class Travel_Advisor_RSS_Widget extends WP_Widget {
	/* Register RSS_posts widget with WordPress. */
	function __construct() {
		parent::__construct(
			'travel_advisor_rss_widget', /* Base ID */
			__( 'Travel Advisor RSS Widget', 'travel-advisor' ), /* Name */
			array( 'description' => __( 'Travel Advisor RSS Widget', 'travel-advisor' ) ) /* Args */
		);
	}
	/* Front-end display of RSS_posts widget. */
	public function widget( $args, $instance ) {
		global $post, $posts;
		$title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$count_post = ! empty( $instance['count_post'] ) ? $instance['count_post'] : 2;
		$first_img  = '';
		echo $args['before_widget']; ?>
		<h4 class="widget-title">
			<?php echo $title; ?>
		</h4>
		<?php $widget_recent_posts = new WP_Query( array(
			'posts_per_page'      => $count_post,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		) ); ?>
		<ul>
			<?php add_filter( 'excerpt_length', 'travel_advisor_excerpt_length' );
			if ( $widget_recent_posts->have_posts() ):
				while ( $widget_recent_posts->have_posts() ):
					$widget_recent_posts->the_post(); ?>
					<li>
						<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
							<div class="travel-advisor-widget-title-post">
								<a href="<?php the_permalink(); ?>">
									<?php the_title(); ?>
								</a>
							</div>
						</div>
							<?php the_excerpt(); ?>
						<div class="travel-advisor-rss-posted">
							<?php printf( __( '%s ago', 'travel-advisor' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
						</div>
					</li>
				<?php endwhile;
			endif;
			remove_filter( 'excerpt_length', 'travel_advisor_excerpt_length' ); ?>
			<br clear="left"/>
		</ul>
		<?php echo $args['after_widget'];
	}
	/* Back-end widget RSS_posts form. */
	public function form( $instance ) {
		$title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$count_post = ! empty( $instance['count_post'] ) ? $instance['count_post'] : 3; ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title', 'travel-advisor' ); echo ' : '; ?>
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count_post' ); ?>">
				<?php _e( 'Count Recent Posts', 'travel-advisor' ); echo ' : '; ?>
			</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'count_post' ); ?>" name="<?php echo $this->get_field_name( 'count_post' ); ?>" type="text" value="<?php echo esc_attr( $count_post ); ?>">
		</p>
	<?php }

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']      = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count_post'] = ( ! empty( $new_instance['count_post'] ) ) ? strip_tags( $new_instance['count_post'] ) : '';
		return $instance;
	}
} /* end .Resent_RSS_Widget */

/* Excerpt_length for Resent_posts_Widget */
function travel_advisor_excerpt_length( $length ) {
	return 12;
}

/* Excerpt_length for slider */
function travel_advisor_slider_excerpt_length( $length ) {
	return 28;
}

function travel_advisor_slider_words_limit( $count, $after, $title ) {
	$title = strip_shortcodes( $title );
	$title = strip_tags( $title, '<p>' );
	if ( mb_strlen( $title ) > $count ) :
		$title = mb_substr( $title,0,$count );
	else :
		$after = '';
	endif;
	echo $title . $after;
}

/* Excerpt_more for slider */
function travel_advisor_slider_excerpt_more( $more ) {
	return '';
}

/* Register two widget areas */
function travel_advisor_register_sidebars_widgets() {
	register_sidebar( array(
		'id'            => 'travel-advisor-sidebar-right',
		'name'          => __( 'Sidebar right', 'travel-advisor' ),
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'travel-advisor' ),
		'before_widget' => '<div id="%1$s" class="side widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'id'            => 'travel-advisor-sidebar-footer',
		'name'          => __( 'Sidebar footer', 'travel-advisor' ),
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'travel-advisor' ),
		'before_widget' => '<li id="%1$s" class="foot widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_widget( 'Travel_Advisor_Contact_Widget' );
	register_widget( 'Travel_Advisor_Recent_Post_Widget' );
	register_widget( 'Travel_Advisor_RSS_Widget' );
}

/* Adding metabox for show img post in slider */
function travel_advisor_metabox_for_slider() {
	add_meta_box(
		'travel_advisor_checkbox_for_slider',
		__( 'Add to slider', 'travel-advisor' ),
		'travel_advisor_metabox_for_slider_callback',
		'post',
		'normal'
	);
}

/* Add and save meta for post */
function travel_advisor_save_post_meta( $post_id ) {
	global $post, $post_id;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) :
		return $post_id;
	elseif ( ! current_user_can( 'edit_post', $post_id ) ) :
		return $post_id;
	endif;
	if ( null != $post ) :
		if ( isset( $_POST['travel_advisor_add_slide'] ) && 'on' == $_POST['travel_advisor_add_slide'] && has_post_thumbnail() ) :
			update_post_meta( $post->ID, 'travel_advisor_add_slide', $_POST['travel_advisor_add_slide'] );
		else :
			update_post_meta( $post->ID, 'travel_advisor_add_slide', 'off' );
		endif;
	endif;
}

/* Customize metabox */
function travel_advisor_metabox_for_slider_callback() {
	global $post;
	$screen = get_current_screen(); ?>
	<label for='travel_advisor_add_slide'>
		<?php echo __( 'To add this post into the slider, mark it', 'travel-advisor' ); ?>
	</label>
	<input type='checkbox' name='travel_advisor_add_slide' id='travel_advisor_add_slide' value='on'
		<?php if ( 'on' == get_post_meta( $post->ID, 'travel_advisor_add_slide', true ) ) : ?>
			checked='checked'
		<?php endif; ?> />
<?php }

function travel_advisor_scripts() {
	wp_enqueue_style( 'travel_advisor_carousel_style', get_template_directory_uri() . '/css/owl.carousel.css' );
	wp_enqueue_style( 'travel_advisor_font-awesome_style', get_template_directory_uri() . '/css/font-awesome.css' );
	wp_enqueue_style( 'travel_advisor_style', get_stylesheet_uri() );
	wp_enqueue_script( 'travel_advisor_selectbox_scripts', get_template_directory_uri() . '/js/jquery.selectbox-0.2.js', array( 'jquery' ) );
	wp_enqueue_script( 'travel_advisor_carousel_script', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'travel_advisor_scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ) );
}

/* Show image post-gallery on the home page as the slider */
function travel_advisor_show_gallery_image_urls( $content ) {
	if ( is_home() || is_front_page() ) :
		global $post;
		if ( ! has_shortcode( $post->post_content, 'gallery' ) ) :
			return $content;
		endif;
		$galleries = get_post_galleries_images( $post );
		$image_list = array();
		foreach ( $galleries as $key => $gallery ) {
			$image_list[ $key ] = '<div id="owl-carousel-'.get_the_ID().'" class="owl-carousel carousel">';
			foreach ( $gallery as $image ) {
				$image_list[ $key ] .= '<img src="' . $image . '" />';
			}
			$image_list[ $key ] .= '</div>';
		}
		$pattern = get_shortcode_regex();
		if ( preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches ) &&
				array_key_exists( 2, $matches )	&&
				in_array( 'gallery', $matches[2] ) ) :
			foreach ( $matches[0] as $key => $gallery_shortcode ) {
				$content = str_replace( $gallery_shortcode, $image_list[ $key ], $content );
			}
		endif;
		return $content;
	else :
		return $content;
	endif;
}

/* Function return excerpt_more as read more or show */
function travel_advisor_excerpt_more( $more ) {
	global $post;
	$str = '<div class="read-more-pages"><a class="read-more" href="'.get_the_permalink( get_the_ID() ).'">';
	if ( 'image' == get_post_format( get_the_ID() ) || 'gallery' == get_post_format( get_the_ID() ) ||
			has_shortcode( $post->post_content, 'gallery' ) ) :
		$str .=__( 'Show', 'travel-advisor' ) . '</a></div>';
	else :
		$str .=__( 'read more', 'travel-advisor' ).'</a></div>';
	endif;
	return $str;
}

/* paginate */
function travel_advisor_pagination( $max_num_pages = 1 ) {
	if ( get_query_var( 'paged' ) ) {
		$current_page = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
		$current_page = get_query_var( 'page' );
	} else {
		$current_page = 1;
	}
	$big    = 999999; /* unique number for replacement */
	$args   = array(
		'base'      => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
		'current'   => $current_page,
		'total'     => $max_num_pages,
		'show_all'  => false,
		'end_size'  => 1,
		'mid_size'  => 3,
		'prev_next' => true,
		'prev_text' => '<i class="fa fa-angle-left"></i>',
		'next_text' => '<i class="fa fa-angle-right"></i>',
	);
	$result = paginate_links( $args );
	$result = str_replace( '/page/1/', '', $result );
	echo '<div class="travel-advisor-pagination"><nav class="navigation pagination"><div class="nav-links">' . $result . '<div class="clear"></div></nav></div>';
}

/* Displays comments */
function travel_advisor_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' : ?>
			<p>
				<?php _e( 'Pingback', 'travel-advisor' ); echo ' : '; comment_author_link();
				edit_comment_link( __( 'Edit', 'travel-advisor' ), '<span class="edit-link">', '</span>' ); ?>
			</p>
		<?php break;
		default : ?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
				<div id="comment-<?php comment_ID();  ?>" class="comment-pole">
					<div class="comment-author vcard">
						<?php echo get_avatar( $comment ); ?>
					</div>
					<div class="travel-advisor-comment-container">
						<div class="comment-top">
							<div class="travel-advisor-comment-author">
								<?php echo get_comment_author_link() ?>
							</div>
							<div class="travel-advisor-comment-reply">
								<?php comment_reply_link( array_merge(
									$args,
									array(
										'depth'     => $depth,
										'max_depth' => $args['max_depth'],
									)
								) ); ?>
							</div>
						</div>
						<div class="clear"></div>
						<div class="travel-advisor-comment-content">
							<?php comment_text() ?>
						</div> 
						<div class="travel-advisor-commentmetadata">
							<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
								<?php printf( __( '%s ago', 'travel-advisor' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
							</a>
						</div>
						<?php if ( $comment->comment_approved == '0' ) : ?>
							<em><?php _e( 'Your comment is awaiting validation.' , 'travel-advisor' ); ?></em>
							<br />
						<?php endif; ?>
					</div>
				</div>
				<div class="clear"></div>
	<?php break;
	endswitch;
}

/* Display comments form */
function travel_advisor_comment_form_fields( $fields ) {
	$fields['author'] =
		'<p class="travel-advisor-comment-form-author">
			<input id="travel-advisor-author" name="author" type="text" value="" size="30" placeholder=" ' .  __( 'Username', 'travel-advisor' ) . ' " />
		</p>';
	$fields['email'] =
		'<p class="travel-advisor-comment-form-email">
			<input id="travel-advisor-email" name="email" type="text" value="" size="30" placeholder=" ' .  __( 'Your email', 'travel-advisor' ) . ' * ' . ' " />
		</p>';
	$fields['url'] =
		'<p class="travel-advisor-comment-form-url">
			<input id="travel-advisor-url" name="url" type="text" value="" size="30" placeholder=" ' .  __( 'Your website', 'travel-advisor' ) . ' " />
		</p>';
	return $fields;
}

/* Render title */
if ( ! function_exists( '_wp_render_title_tag' ) ) :
	function travel_advisor_render_title() { ?>
		<title><?php wp_title( '|', 'true', 'right' ); ?></title>
	<?php }
		add_action( 'wp_head', 'travel_advisor_render_title' );
endif;

add_action( 'after_setup_theme', 'travel_advisor_setup' );
add_action( 'customize_register', 'travel_advisor_customize_register' );
add_action( 'init', 'travel_advisor_init' );
add_action( 'widgets_init', 'travel_advisor_register_sidebars_widgets' );
add_action( 'add_meta_boxes', 'travel_advisor_metabox_for_slider' );
add_action( 'save_post', 'travel_advisor_save_post_meta' );
add_action( 'wp_enqueue_scripts', 'travel_advisor_scripts' );

add_filter( 'the_content', 'travel_advisor_show_gallery_image_urls' );
add_filter( 'excerpt_more', 'travel_advisor_excerpt_more' );
add_filter( 'comment_form_default_fields', 'travel_advisor_comment_form_fields' );