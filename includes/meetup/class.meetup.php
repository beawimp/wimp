<?php

/**
 * The Meetup API class
 *
 * This class will interface with Meetup and pull any events needed.
 * At this moment, this is only a GET request. But a full REST implementation will be setup.
 *
 * @version  0.1
 * @since    1.0a-12012013
 */

/**
 * Load our admin settings
 */
require_once( 'admin.meetup.php' );


class WIMP_Meetup {

	/**
	 * Set the base URL for the Meetup API
	 * @var string
	 *
	 * @version  0.1
	 * @since    1.0a-12012013
	 */
	protected $base_url = 'https://api.meetup.com';


	/**
	 * Set some default parameters such as enabling a signed API key signature (http://www.meetup.com/meetup_api/auth/#keysign)
	 * @var array
	 *
	 * @since  1.0a-12012013
	 */
	protected $defaults = array(
		'sign' => 'true',
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
	 * @since    1.0a-12012013
	 */
	public function __construct( $api_key = array() ) {

		// If we decide to save our API key into the database, we can leave the parameter empty
		if ( empty( $api_key ) ) {
			$api_key = array(
				'key' => get_option( 'wimp_meetup_api' ),
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
	 * @since    1.0a-12012013
	 */
	public function get_groups( $parameters = array() ) {
		return $this->fetch( '/2/groups', $parameters );
	}


	/**
	 * Request all events for a group or groups
	 * 
	 * @param  array  $parameters Pass an array of options. Refer to the docs for more info - http://www.meetup.com/meetup_api/docs/2/events/
	 * @return object
	 *
	 * @version  0.1
	 * @since    1.0a-12012013
	 */
	public function get_events( $parameters = array() ) {
		return $this->fetch( '/2/events', $parameters );
	}
	
	
	/**
	 * The GET operator
	 * This method will run the queries on the Meetup API and return any data if it exists.
	 * 
	 * @param  string REQUIRED $path       Should be hardcoded from the request methods.
	 * @param  array  		   $parameters The array of parameters to pass to the Meetup API method
	 * @return Object
	 *
	 * @version  0.1
	 * @since    1.0a-12012013
	 */
	public function fetch( $path, $parameters = array() ) {
		$parameters = wp_parse_args( $parameters, $this->defaults );
		
		// First we'll check that the path being sent is valid.
		if ( preg_match_all( '/:([a-z]+)/', $path, $matches ) ) {
			
			foreach ( $matches[0] as $i => $match ) {
			
				if ( isset( $parameters[ $matches[1][ $i ] ] ) ) {
					$path = str_replace( $match, $parameters[ $matches[1][ $i ] ], $path );
					unset( $parameters[ $matches[1][ $i ] ] );
				} else {
					throw new Exception( "Missing parameter '$matches{[1]}[ $i ]' for path '$path'.");
				}

			}

		}

		// Put together our URL for the API request
		$url = $this->base_url . $path . '?' . http_build_query( $parameters );

		// Fetch the actual data and return it into the $data variable
		$data = wp_remote_get( $url );

		// We'll also return the message status and return an error if such one exists.
		$error_msg = wp_remote_retrieve_response_message( $data );
		
		// Spit out the error if something went wrong.
		if ( isset( $error_msg ) && $error_msg !== 'OK' )
			return $error_msg;
		
		// return the body and decode the JSON data into a PHP object
		return json_decode( $data['body'] );
	}
}