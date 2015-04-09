<?php
/**
 * Template Name: Member Listing Redirect
 *
 * Used for redirecting a specific user to their listing.
 */
$post = wmd_get_listing_by_user_id( get_current_user_id() );

if ( ! isset( $post->ID ) || empty( $post->ID ) ) {
	echo '<p>Something went wrong and we couldn\'t load your listing!<br />';
	echo '<a href="' . esc_url( wmd_get_listing_manager_url() ) . '">Go back to the listing editor</a>.</p>';

	// Email us when this fails...
	$message  = "Listing redirect failed.\n\rUser ID: " . absint( get_current_user_id() );
	wp_mail( 'cole@beawimp.org', 'Listing redirect failed', $message );
	die();
}

wp_redirect( get_permalink( $post->ID ) );
exit();