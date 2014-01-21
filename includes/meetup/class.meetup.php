<?php

/**
 * The Meetup API class
 *
 * This class will interface with Meetup and pull any events needed.
 * At this moment, this is only a GET request. But a full REST implementation will be setup.
 *
 * @version  0.1
 * @since    0.1.20140120
 */

/**
 * Load our admin settings
 */
require_once( 'admin.meetup.php' );

/**
 * Load our helper functions
 */
require_once( 'helpers/helper.meetup.php' );


class WIMP_Meetup {

	/**
	 * Set the base URL for the Meetup API
	 * @var string
	 *
	 * @version  0.1
	 * @since    0.1.20140120
	 */
	protected $base_url = 'https://api.meetup.com';


	/**
	 * Set some default parameters such as enabling a signed API key signature (http://www.meetup.com/meetup_api/auth/#keysign)
	 * @var array
	 *
	 * @since  0.1.20140120
	 */
	protected $defaults = array(
		'sign' => 'true',
	);

	protected $groups_options = array();


	protected $events_options = array(
		'status',
		'rsvp',
		'group_id',
		'event_id',
		'group_urlname',
		'venue_id',
		'member_id',
		'text_format',
		'time',
		'group_domain',
		'limited_events',
		'fields',
		'page',
		'offset',
		'desc',
		'only',
		'omit',
	);


	/**
	 * The construct
	 *
	 * Pass in your Meetup API key through the class - $meetup = new WIMP_Meetup( array( 'key' => 'YOUR_API_KEY' ) );
	 * If you do not pass it, we'll assume the API key is set in the database.
	 * 
	 * @param array $api_key The API key for your Meetup account. If not passed we'll pull from the database. 
	 *
	 * @version  0.1
	 * @since    0.1.20140120
	 */
	public function __construct( $api_key = array() ) {

		// If we decide to save our API key into the database, we can leave the parameter empty
		if ( empty( $api_key ) ) {
			$api_key = array(
				'key' => sanitize_text_field( get_option( 'wimp_meetup_api' ) ),
			);
		}

		// Process the default settings here
		$this->defaults = wp_parse_args( $api_key, $this->defaults );
	}
	

	/**
	 * Request information on a group or groups
	 * 
	 * @param  array  $parameters Pass an array of options. Refer to the docs for more info - http://www.meetup.com/meetup_api/docs/2/groups/
	 * @return object
	 *
	 * @version  0.1
	 * @since    0.1.20140120
	 */
	public function get_groups( $parameters = array(), $cache_key ) {
		return $this->fetch( '/2/groups', $parameters, '-groups-' . $cache_key );
	}


	/**
	 * Request all events for a group or groups
	 * 
	 * @param  array  $parameters Pass an array of options. Refer to the docs for more info - http://www.meetup.com/meetup_api/docs/2/events/
	 * @return object
	 *
	 * @version  0.1
	 * @since    0.1.20140120
	 */
	public function get_events( $parameters = array(), $cache_key = '' ) {
		return $this->fetch( '/2/events', $parameters, '-events-' . $cache_key );
	}
	
	
	/**
	 * The GET operator
	 * This method will run the queries on the Meetup API and return any data if it exists.
	 * 
	 * @param  string REQUIRED $path        Should be hardcoded from the request methods.
	 * @param  array  		   $parameters  The array of parameters to pass to the Meetup API method
	 * @return Object
	 *
	 * @version  0.1
	 * @since    0.1.20140120
	 */
	public function fetch( $path, $parameters = array(), $cache_key ) {
		$parameters = wp_parse_args( $parameters, $this->defaults );
		
		// First we'll check that the path being sent is valid.
		if ( preg_match_all( '/:([a-z]+)/', $path, $matches ) ) {
			foreach ( $matches[0] as $i => $match ) {
				if ( isset( $parameters[ $matches[1][ $i ] ] ) ) {
					$path = str_replace( $match, $parameters[ $matches[1][ $i ] ], $path );

					unset( $parameters[ $matches[1][ $i ] ] );
				} else {
					throw new Exception( "Missing parameter '$matches{[1]}[ $i ]' for path '$path'." );
				}
			}
		}

		// Put together our URL for the API request
		$url = $this->base_url . $path . '?' . http_build_query( $parameters );

		// Check if our cache already exists
		if ( ( $data = get_transient( 'meetup-' . sanitize_title_with_dashes( $cache_key ) ) ) === false ) {

			// Fetch the actual data and return it into the $data variable
			$data = wp_remote_get( esc_url_raw( $url ) );

			// Spit out the error if something went wrong.
			if ( is_wp_error( $data ) ) 
				return 'ERROR: ' . esc_html( $data->get_error_message() );

			// Check if Meetup reported an error
			if ( isset( json_decode( $data['body'] )->code ) )
				return 'ERROR: ' . esc_html( json_decode( $data['body'] )->details );

			// Extract out the data we want
			$data = json_decode( $data['body'] )->results;

			// Cache this, sucka
			set_transient( 'meetup-' . sanitize_title_with_dashes( $cache_key ), $data, DAY_IN_SECONDS ); // Cache the upcoming events for 1 full day
		}

		// return the results
		return $data;
	}


	/**
	 * Cleans are data being passed
	 * @param  array $options The array of options to be passed for the Meetup API
	 * @return array
	 *
	 * @version 0.1
	 * @since   0.1.20140120
	 */
	public function sanitize_options( $options ) {

		$parameters = array();

		// Clean up our data
		foreach ( $options as $key => $value  ) {

			// Make sure the key passed is a valid key
			if ( in_array( $key, $this->events_options ) ) {
				$key = str_replace( '-', '_', sanitize_title_with_dashes( $key ) );
				$value = strip_tags( stripslashes( $value ) );

				$parameters[ $key ] = $value;
			}
		}

		return $parameters;
	}
}

$wimp_meetup = new Wimp_Meetup();