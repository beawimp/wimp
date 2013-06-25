<?php
	/**
	 * Custom functions that act independently of the theme templates
	 *
	 * Eventually, some of the functionality here could be replaced by core features
	 *
	 * @package WIMP
	 * @author Cole Geissinger <cole@beawimp.org>
	 *
	 * @version 1.0
	 * @since   2.0
	 */


	/**
	 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
	 * @param  Array $args The array of options used in the wp_page_menu_args() filter
	 * @return Array
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	function wimp_page_menu_args( $args ) {

		$args['show_home'] = true;

		return $args;

	}
	add_filter( 'wp_page_menu_args', 'wimp_page_menu_args' );


	/**
	 * Adds custom classes to the array of body classes.
	 * @param  Array $classes The array of body classes
	 * @return Array
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	function wimp_body_classes( $classes ) {

		// Adds a class of group-blog to blogs with more than 1 published author
		if ( is_multi_author() )
			$classes[] = 'group-blog';

		return $classes;

	}
	add_filter( 'body_class', 'wimp_body_classes' );


	/**
	 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
	 * @param  String  $url The URL to the next or previous image on attachment pages
	 * @param  Integer $id  The post ID
	 * @return String
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	function wimp_enhanced_image_navigation( $url, $id ) {

		if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
			return $url;

		$image = get_post( $id );

		if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
			$url .= '#main';

		return $url;

	}
	add_filter( 'attachment_link', 'wimp_enhanced_image_navigation', 10, 2 );


	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 * @param  String $title The title of the page
	 * @param  String $sep   The seperator character used in the title
	 * @return String
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	function wimp_wp_title( $title, $sep ) {

		global $page, $paged;

		if ( is_feed() )
			return $title;

		// Add the blog name
		$title .= get_bloginfo( 'name' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );

		if ( $site_description && ( is_home() || is_front_page() ) )
			$title .= " $sep $site_description";

		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			$title .= " $sep " . sprintf( __( 'Page %s', 'wimp' ), max( $paged, $page ) );

		return $title;

	}
	add_filter( 'wp_title', 'wimp_wp_title', 10, 2 );
