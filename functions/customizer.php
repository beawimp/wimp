<?php
	/**
	 * WIMP Theme Customizer
	 *
	 * @package WIMP
	 * @author Cole Geissinger <cole@beawimp.org>
	 *
	 * @version 1.0
	 * @since   2.0
	 */


	/**
	 * Add postMessage support for site title and description for the Theme Customizer.
	 *
	 * @param  Object $wp_customize Theme Customizer object.
	 * @return void
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	function wimp_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}
	add_action( 'customize_register', 'wimp_customize_register' );


	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 * @return void
	 *
	 * @version 1.0
	 * @since   2.0
	 */
	function wimp_customize_preview_js() {
		wp_enqueue_script( 'wimp_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
	}
	add_action( 'customize_preview_init', 'wimp_customize_preview_js' );
