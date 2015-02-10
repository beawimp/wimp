<?php

/**
 * wimp functions and definitions
 *
 * @package wimp
 * @since 0.2
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 869; /* pixels */


/**
 * Theme version... yup. Meow.
 */
define( 'THEME_VERSION', '0.3' );


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
if ( ! function_exists( 'wimp_setup' ) ) :
	function wimp_setup() {

		/**
		 * Include our Twitter Bootstrap Walker class.
		 */
		include_once( 'bootstrap-nav-walker.php' );

		/**
		 * Add default posts and comments RSS feed links to head
		 */
		add_theme_support( 'automatic-feed-links' );


		/**
		 * Enable support for Post Thumbnails on posts and pages
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );


		/**
		 * Adding some custom post image sizes :)
		 */
		if ( function_exists( 'add_image_size' ) ) {
			add_image_size( 'featured-post', 408, 305, true );
			add_image_size( 'secondary-post', 408, 248, true );
		}


		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'wimp' ),
			'footer'  => __( 'Footer Menu', 'wimp' ),
		) );

		/**
		 * Remove the admin tool bar for all but admins
		 */
		if ( ! current_user_can( 'activate_plugins' ) && ! is_admin() ) {
			show_admin_bar( false );
		}
	}
endif; // wimp_setup
add_action( 'after_setup_theme', 'wimp_setup' );


/**
 * Add our themes css styles and scripts.
 * @return void
 *
 * @version 0.1
 * @since 0.2
 */
function wimp_theme_resources() {
	// Load only on the front-end
	if ( ! is_admin() ) {
		wp_enqueue_style( 'wimp-google-font', 'http://fonts.googleapis.com/css?family=Lustria|Duru+Sans|Quicksand:300,400,700' );
		wp_enqueue_style( 'wimp-styles', get_stylesheet_directory_uri() . '/css/app.min.css', null, THEME_VERSION );

		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js', null, THEME_VERSION );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'wimp-scripts', get_stylesheet_directory_uri() . '/js/build/app.min.js', array( 'jquery' ), THEME_VERSION, false );
	}
}
add_action( 'wp_enqueue_scripts', 'wimp_theme_resources' );


/**
 * Register widgetized area and update sidebar with default widgets
 */
function wimp_widgets_init() {
	// Main Sidebar
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'wimp' ),
		'id'            => 'sidebar-1',
		'description' 	=> 'Default Sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	// Job Board
	register_sidebar( array(
	    'name'          => 'Job Board',
		'id'            => 'job-board',
		'description'   => 'This sidebar is used on only the Job Board pages.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>'
	) );
}
add_action( 'widgets_init', 'wimp_widgets_init' );

/**
 * Allows us to process a template part into a variable.
 * This is useful if you need to filter a template part into the content or a variable
 *
 * @param string $template_name The template naem
 * @param string $part_name     The template part name
 *
 * @return string
 */
function wimp_load_template_part( $template_name, $part_name = null ) {
	ob_start();
	get_template_part( $template_name, $part_name );
	$template = ob_get_contents();
	ob_end_clean();

	return $template;
}

/**
 * Filter the author blocks onto singular posts
 *
 * @param string $content The content being loaded into the_content
 *
 * @return string
 */
function wimp_add_author_blocks( $content ) {
	if ( is_single() && 'live-stream' !== get_post_type() ) {
		$content .= wimp_load_template_part( 'partials/content', 'author-bio' );
	}

	return $content;
}
add_filter( 'the_content', 'wimp_add_author_blocks', 10 );

/**
 * Remove the Publish and Move to Trash buttons for authors only.
 */
function wimp_remove_post_crud_options_for_authors() {
	if ( ! function_exists( 'EditFlow' ) ) {
		return;
	}

	if ( ! EditFlow()->custom_status->is_whitelisted_page() ) {
		return;
	}

	// Only hide the publish button from authors
	$current_user = wp_get_current_user();
	if ( 'author' !== $current_user->roles[0] ) {
		return;
	}
	?>
	<style>
		#major-publishing-actions {
			display: none;
		}
	</style>
	<script>
		( function( $ ) {
			$( window ).ready( function() {
				$( document.getElementById( 'major-publishing-actions' ) ).remove();
			});
		} )( jQuery );
	</script>
	<?php
}
add_action( 'admin_head', 'wimp_remove_post_crud_options_for_authors' );

/**
 * Limit post statuses for authors.
 *
 * @param  array $custom_statuses The existing custom status objects
 *
 * @return array $custom_statuses Our possibly modified set of custom statuses
 */
function wimp_limit_post_status_for_author( $custom_statuses ) {
	$current_user = wp_get_current_user();

	switch( $current_user->roles[0] ) {
		case 'author':
			$permitted_statuses = array(
				'pitch',
				'in-progress',
			);

			// Remove the custom status if it's not white-listed
			foreach( $custom_statuses as $key => $custom_status ) {
				if ( ! in_array( $custom_status->slug, $permitted_statuses ) ) {
					unset( $custom_statuses[ $key ] );
				}
			}
			break;
	}
	return $custom_statuses;
}
add_filter( 'ef_custom_status_list', 'wimp_limit_post_status_for_author' );

function wimp_live_stream( $atts, $content = null ) {
	// Attributes
	$values = shortcode_atts(
	array(
		'video_id' => 0,
	), $atts );

	if ( 0 === $values['video_id'] ) {
		// Get the latest post
		$args = array(
			'post_type'              => 'live-stream',
			'post_status'            => 'publish',
			'posts_per_page'         => -1,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		);
		$post_query = new WP_Query( $args );

		$post = $post_query->posts[0];
	} else {
		$post = get_post( (int) $values['video_id'] );
	}

	if ( ! $post ) {
		return 'Post Not Found!';
	}

	ob_start();
	?>
	<h3><?php echo esc_html( $post->post_title ); ?></h3>
	<p>Date: <?php echo date( 'D M j, Y', strtotime( $post->post_date ) ); ?> @ 7pm-9pm PST</p>
	<?php
	echo do_shortcode( wpautop( $post->post_content ) );
	echo '<p><a href="' . esc_url( get_post_type_archive_link( 'live-stream' ) ) . '" class="button" style="padding:5px;">View Previous Live Streams!</a>';
	return ob_get_clean();
}
add_shortcode( 'live-stream', 'wimp_live_stream' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/includes/extras.php';