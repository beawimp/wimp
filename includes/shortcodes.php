<?php

/**
 * Contains all of our shortcodes yo!
 */

if ( class_exists( 'WIMP_Meetup' ) ) {
	function wimp_get_meetup( $atts ) {
		date_default_timezone_set( 'America/Los_Angeles' );

		extract( shortcode_atts( array(
			'status' => 'upcoming',
			'limit' => 1
		), $atts ) );

		$options = array(
			'group_urlname' => 'beawimp',
			'status' => $status,
		);
		$events = wimp_get_events( $options, $limit );

		if ( ! empty( $events ) ) {
			foreach ( $events as $event ) {
				$output = '<article class="featured-meetup">
					<header class="meetup-header">
						<h2 class="title">Next Featured Meetup</h2>
						<h3 class="subtitle"><a href="' . esc_url( $event->event_url ) . '" target="_blank">' . esc_html( $event->name ) . '</a></h3>
						<p class="meetup-meta">' . date( 'l, F jS, Y', substr( $event->time, 0, -3 ) ) . ' | ' . date( 'g:i A', substr( $event->time, 0, -3 ) ) . ' | <a href="' . esc_url( $event->event_url ) . '">RSVPS: ' . intval( $event->yes_rsvp_count ) . '</a></p>
					</header>
				</article>';
			}
		} else {
			$output = '<article class="featured-meetup">
				<header class="meetup-header">
					<h2 class="title">No Scheduled Meetups!</h2>
					<p>Check out our <a href="/events/">previous events</a> while we schedule our next meetup!</p>
				</header>
			</article>';
		}

		return $output;
	}
	add_shortcode( 'meetup', 'wimp_get_meetup' );
}