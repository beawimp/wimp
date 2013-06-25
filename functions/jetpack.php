<?php
	/**
	 * Jetpack Compatibility File
	 * See: http://jetpack.me/
	 *
	 * @package WIMP
	 * @author Cole Geissinger <cole@beawimp.org>
	 *
	 * @version 1.0
	 * @since   2.0
	 */

	/**
	 * Add theme support for Infinite Scroll. @link http://jetpack.me/support/infinite-scroll/
	 * @return void
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	function wimp_jetpack_setup() {
		add_theme_support( 'infinite-scroll', array(
			'container' => 'content',
			'footer'    => 'page',
		) );
	}
	add_action( 'after_setup_theme', 'wimp_jetpack_setup' );
