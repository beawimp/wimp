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
	define( 'THEME_VERSION', '0.2' );


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
	 * Custom template tags for this theme.
	 */
	require get_template_directory() . '/includes/template-tags.php';


	/**
	 * Custom functions that act independently of the theme templates.
	 */
	require get_template_directory() . '/includes/extras.php';


	/**
	 * Load Jetpack compatibility file.
	 * Disable for now until we are ready for Infinite Scroll.
	 */
	// require get_template_directory() . '/includes/jetpack.php';

