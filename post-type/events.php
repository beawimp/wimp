<?php


/**
 * Displays a list of events from Meetup
 * @param  string $group_urlname REQUIRED  The url or slug of the group
 * @param  string $status        		   The status of the events you want to fetch
 * @return html
 *
 * @version 0.1
 * @since   0.2
 */
function wimp_list_events( $options, $limit = 0 ) {
	date_default_timezone_set( 'America/Los_Angeles' );

	// Get the data
	$events = wimp_get_events( $options, $limit );

	// Check if we are not returning an array. This is probably an error from the Meetup API.
	if ( ! is_array( $events ) ) {
		echo '<strong>' . esc_html( $events ) . '</strong>';
	} else {
		foreach ( $events as $event ) :
			$event_time = str_replace( '.', '', $event->time ); ?>
			<li class="event row <?php echo intval( $event->id ); ?>">
				<header class="event-header">
					<h2 class="event-title"><a href="<?php echo esc_url( $event->event_url ); ?>" target="_blank"><?php echo esc_html( $event->name ); ?></a></h2>
					<h3 class="event-date"><?php echo date( 'l, F jS, Y', str_replace( 'E+12', '00', $event_time ) ); ?> <span class="event-time"><?php echo date( 'g:i A', str_replace( 'E+12', '00', $event_time ) ); ?></span></h3>
				</header>
				<div class="event-content">
					<?php echo str_replace( '<br />', '', wp_kses_post( $event->description ) ); ?>
				</div>
				<div class="event-meta">
					<?php if ( $event->status == 'upcoming' ) : ?>
						<h2 class="event-rsvp btn btn-primary"><a href="<?php echo esc_url( $event->event_url ); ?>" target="_blank">RSVP NOW</a></h2>
						<p><a href="<?php echo esc_url( $event->event_url ); ?>" target="_blank"><?php echo intval( $event->yes_rsvp_count ); ?> attending</a></p>
					<?php elseif ( $event->status == (  'suggested' || 'proposed' ) ) : ?>
						<h2 class="event-past"><?php echo esc_html( $event->status ); ?> Meetup</h2>
						<p><a href="<?php echo esc_url( $event->event_url ); ?>" target="_blank"><?php echo intval( $event->yes_rsvp_count ); ?> RSVP</a></p>
					<?php else : ?>
						<p><a href="<?php echo esc_url( $event->event_url ); ?>" target="_blank"><?php echo intval( $event->yes_rsvp_count ); ?> RSVP</a></p>
					<?php endif; ?>

				</div>
			</li>
		<?php endforeach;
	}
}