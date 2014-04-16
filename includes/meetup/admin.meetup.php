<?php

/**
 * Sets a custom settings area for adding the Meetup API.
 *
 * @version  0.1
 * @since    0.2
 */

/**
 * Adds a new section on to Settings > General
 * This section will allow us to add the fields needed for passing our Meetup API keys and store them in the DB.
 * @return void
 *
 * @version  0.1
 * @since    0.2
 */
function wimp_meetup_init_settings() {

	// Define our settings section
	add_settings_section( 'wimp_meetup_settings_section', 'Meetup Settings', 'wimp_meetup_settings_description', 'general' );

	// Define our actual settings and asign them to the settings section
	add_settings_field( 'wimp_meetup_api', 'API Key', 'wimp_meetup_text_field', 'general', 'wimp_meetup_settings_section', array(
		'name' => 'wimp_meetup_api',
		'id'   => 'wimp_meetup_api',
	) );

	// Now we need to register our settings
	register_setting( 'general', 'wimp_meetup_api' );
}
add_action( 'admin_init', 'wimp_meetup_init_settings' );


/**
 * The callback function to the settings section set in wimp_meetup_init_settings()
 * @return string
 *
 * @version  0.1
 * @since    0.2
 */
function wimp_meetup_settings_description() {
	echo '<p>The place where all the cool kids store their Meetup API key :D</p>';
}


/**
 * A generic function that will output a text field
 * To customize, add a name and id to the add_settings_field array arguments
 * @param  array $args The arguments passed from add_settings_field()
 * @return string
 *
 * @version  0.1
 * @since    0.2
 */
function wimp_meetup_text_field( $args ) {
	$value = get_option( esc_attr( $args['name'] ) );
	echo '<input type="text" name="' . esc_attr( $args['name'] ) . '" id="' . esc_attr( $args['id'] ) . '" class="regular-text" value="' . ( ! empty( $value ) ? esc_attr( $value ) : '' ) . '" />';
}