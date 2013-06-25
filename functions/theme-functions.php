<?php
	/**
	 * WIMP functions and definitions
	 *
	 * @package WIMP
	 * @author Cole Geissinger <cole@beawimp.org>
	 *
	 * @version 1.0
	 * @since   2.0
	 */


	// Set the theme version variable
	$wimp_theme_version = '2.0';


	/**
	 * Set the content width based on the theme's design and stylesheet.
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	if ( ! isset( $content_width ) )
		$content_width = 640; /* pixels */

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	if ( ! function_exists( 'wimp_setup' ) ) :
		function wimp_setup() {

			// Add default posts and comments RSS feed links to head
			add_theme_support( 'automatic-feed-links' );

			// Enable support for Post Thumbnails on posts and pages @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
			// add_theme_support( 'post-thumbnails' );

			// Add our WordPress Menus
			register_nav_menus( array(
				'primary' => __( 'Primary Menu', 'wimp' ),
			) );

			// Enable support for Post Formats
			add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
		}
	endif;
	add_action( 'after_setup_theme', 'wimp_setup' );


	/**
	 * Register widgetized area and update sidebar with default widgets
	 * @return void
	 *
	 * @version 1.0
	 * @since   2.0
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
	 * Enqueue scripts and styles
	 * @return void
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	function wimp_scripts() {
		global $wimp_theme_version;

		// Load our stylesheets
		wp_enqueue_style( 'wimp-style', get_template_directory_uri() . '/css/app.css', null, $wimp_theme_version );

		// Load our Scripts
		wp_enqueue_script( 'wimp-navigation', get_template_directory_uri() . '/js/navigation.js', array(), $wimp_theme_version, true );
		wp_enqueue_script( 'wimp-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), $wimp_theme_version, true );

		// Load only when viewing single.php & comments are enabled and threaded comments is enabled
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		// Load only when viewing single.php & the attachment file is an image
		if ( is_singular() && wp_attachment_is_image() )
			wp_enqueue_script( 'wimp-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), $wimp_theme_version );
	}
	add_action( 'wp_enqueue_scripts', 'wimp_scripts' );