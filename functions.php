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


	// Set some variables
	$wimp_theme_functions_uri = get_template_directory() . '/functions/';


	/**
	 * Load our theme functions
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	require $wimp_theme_functions_uri . 'theme-functions.php';


	/**
	 * Implement the Custom Header feature.
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	//require $wimp_theme_functions_uri . 'custom-header.php';

	/**
	 * Custom template tags for this theme.
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	require $wimp_theme_functions_uri . 'template-tags.php';

	/**
	 * Custom functions that act independently of the theme templates.
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	require $wimp_theme_functions_uri . 'extras.php';

	/**
	 * Customizer additions.
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	require $wimp_theme_functions_uri . 'customizer.php';


	/**
	 * Load Jetpack compatibility file.
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	require $wimp_theme_functions_uri . 'jetpack.php';

