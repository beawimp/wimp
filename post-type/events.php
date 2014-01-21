<?php


/**
 * Displays a list of events from Meetup
 * @param  string $group_urlname REQUIRED  The url or slug of the group
 * @param  string $status        		   The status of the events you want to fetch
 * @return html
 *
 * @version 0.1
 * @since   0.1.20140120
 */
function wimp_list_events( $options, $limit = 0 ) {
	// Get the data
	$events = wimp_get_events( $options, $limit );

	// Check if we are not returning an array. This is probably an error from the Meetup API.
	if ( ! is_array( $events ) ) {
		echo '<strong>' . esc_html( $events ) . '</strong>';
	} else {
		foreach ( $events as $event ) : ?>
			<li class="event row <?php echo intval( $event->id ); ?>">
				<header class="event-header">
					<h2 class="event-title"><a href="<?php echo esc_url( $event->event_url ); ?>"><?php echo esc_html( $event->name ); ?></a></h2>
					<h3 class="event-date"><?php echo date( 'D M j', $event->time ); ?> <span class="event-time"><?php echo date( 'g:i A', $event->time ); ?></span></h3>
				</header>
				<div class="event-content">
					<?php echo str_replace( '<br />', '', wp_kses_post( $event->description ) ); ?>
				</div>
				<div class="event-meta">
					<?php if ( $event->status == 'upcoming' ) : ?>
						<h2 class="event-rsvp btn btn-primary"><a href="<?php echo esc_url( $event->event_url ); ?>">RSVP NOW</a></h2>
						<p><a href="<?php echo esc_url( $event->event_url ); ?>"><?php echo intval( $event->yes_rsvp_count ); ?> attending</a></p>
					<?php elseif ( $event->status == (  'suggested' || 'proposed' ) ) : ?>
						<h2 class="event-past"><?php echo esc_html( $event->status ); ?> Meetup</h2>
						<p><a href="<?php echo esc_url( $event->event_url ); ?>"><?php echo intval( $event->yes_rsvp_count ); ?> RSVP</a></p>
					<?php else : ?>
						<p><a href="<?php echo esc_url( $event->event_url ); ?>"><?php echo intval( $event->yes_rsvp_count ); ?> RSVP</a></p>
					<?php endif; ?>

				</div>
			</li>
		<?php endforeach;
	}
}