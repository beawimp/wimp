<?php

// Load our Meetup plugin
if ( ! class_exists( 'WIMP_Meetup' ) ) {
	require_once( 'includes/meetup/class.meetup.php' );

	require_once( 'post-type/events.php' );
}

// Load any post types
include( 'post-type/live-stream.php' );

// Load our theme settings :3
include( 'includes/theme-settings.php' );

// BuddyPress Functions
// include( 'includes/buddypress.php' );

// Load our shortcodes
include( 'includes/shortcodes.php' );

