<?php

/**
 * Returns information on a meetup group
 * @param  string $group_urlname REQUIRED The url or slug of a meetup group, one or more separated by commas, includes no slashes
 * @param  string $group_id      		  One or more separated by commas
 * @param  string $category_id   		  Only return groups in the specified category. (one category allowed)
 * @param  string $member_id     		  One or more separated by commas, for groups this member belongs to
 * @param  string $organizer_id  		  One or more organizer IDs, separated by commas
 * @param  string $topic         		  Only return groups in the specified topic (one topic allowed)
 * @param  string $zip           		  A valid US zip code, limits the returned groups to those within radius miles
 * @return OBJECT
 *        
 * @version 0.1
 * @since   0.1.20140120
 */
function wimp_get_groups( $group_urlname, $desc = true, $group_id = '', $category_id = '', $member_id = '', $organizer_id = '', $topic = '', $zip = '' ) {
	global $wimp_meetup;


	$parameters['group_urlname'] = sanitize_title_with_dashes( $group_urlname );
	
	$parameters['desc'] = ( $desc === false ) ? 'false' : 'true';

	if ( ! empty( $group_id ) ) 
		$parameters['group_id'] = absint( $group_id );

	if ( ! empty( $category_id ) )
		$parameters['category_id'] = absint( $category_id );

	if ( ! empty( $member_id ) )
		$parameters['member_id'] = absint( $member_id );

	if ( ! empty( $organizer_id ) )
		$parameters['organizer_id'] = absint( $organizer_id );

	if ( ! empty( $topic ) )
		$parameters['topic'] = sanitize_text_field( $topic );

	if ( ! empty( $zip ) )
		$parameters['zip'] = absint( $zip );


	//return $wimp_meetup->get_groups( $parameters, $group_urlname );
}


/**
 * Returns event information from the Meetup API
 * @param  array   $options The list of options to be returned from a Meetup account. http://www.meetup.com/meetup_api/console/?path=/2/events
 * @param  integer $limit   Limit the number of events to be returned. 0 Is all.
 * @return Object
 *
 * @version 0.1
 * @since   0.1.20140120
 */
function wimp_get_events( $options, $limit = 0 ) {
	global $wimp_meetup;

	if ( ! is_array( $options ) )
		return 'You must provide your Meetup options as an array!';

	$parameters = $wimp_meetup->sanitize_options( $options );
	$results = $wimp_meetup->get_events( $parameters, $parameters['status'] );

	// Check if we returned an error...
	if ( ! is_array( $results ) )
		return $results;

	// Some times we want to limit our results. Instead of creating a new query,
	// We'll limit the cached results on output.
	if ( $limit !== 0 ) {
		for ( $i = 0; $i <= $limit - 1; $i++ ) {
			$new_results[ $i ] = $results[ $i ];
		}
		$results = $new_results;

	}

	return $results;
}