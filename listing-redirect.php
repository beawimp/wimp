<?php
/**
 * Template Name: Member Listing Redirect
 *
 * Used for redirecting a specific user to their listing.
 */

$post = wmd_get_listing_by_user_id( bp_displayed_user_id() );

wp_redirect( get_permalink( $post->ID ) );
exit();