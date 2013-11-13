<?php

	/**
	 * wimp functions and definitions
	 *
	 * @package wimp
	 */

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	if ( ! isset( $content_width ) )
		$content_width = 869; /* pixels */


	/**
	 * Theme version... yup. Meow.
	 */
	$theme_version = '1.0a-11032013';


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
		}
	endif; // wimp_setup
	add_action( 'after_setup_theme', 'wimp_setup' );


	/**
	 * Add our themes css styles and scripts.
	 * @return [type] [description]
	 */
	function wimp_theme_resources() {
		global $theme_version;

		wp_enqueue_style( 'wimp-google-font', 'http://fonts.googleapis.com/css?family=Quicksand:300,400,700' );
		wp_enqueue_style( 'wimp-styles', get_stylesheet_directory_uri() . '/css/app.css' );

		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'wimp-bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap/bootstrap.min.js', array( 'jquery' ), $theme_version, true );

	}
	add_action( 'wp_enqueue_scripts', 'wimp_theme_resources' );


	/**
	 * Register widgetized area and update sidebar with default widgets
	 */
	function wimp_widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Sidebar', 'wimp' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
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
	 */
	require get_template_directory() . '/includes/jetpack.php';
