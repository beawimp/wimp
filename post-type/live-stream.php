<?php

function live_stream_init() {
	register_post_type( 'live-stream', array(
		'labels'            => array(
			'name'                => __( 'Live Streams', 'wimp' ),
			'singular_name'       => __( 'Live Stream', 'wimp' ),
			'all_items'           => __( 'Live Streams', 'wimp' ),
			'new_item'            => __( 'New Live Stream', 'wimp' ),
			'add_new'             => __( 'Add New', 'wimp' ),
			'add_new_item'        => __( 'Add New Live Stream', 'wimp' ),
			'edit_item'           => __( 'Edit Live Stream', 'wimp' ),
			'view_item'           => __( 'View Live Stream', 'wimp' ),
			'search_items'        => __( 'Search Live Streams', 'wimp' ),
			'not_found'           => __( 'No Live Streams found', 'wimp' ),
			'not_found_in_trash'  => __( 'No Live Streams found in trash', 'wimp' ),
			'parent_item_colon'   => __( 'Parent Live Stream', 'wimp' ),
			'menu_name'           => __( 'Live Streams', 'wimp' ),
		),
		'public'            => true,
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'supports'          => array( 'title', 'editor' ),
		'has_archive'       => true,
		'rewrite'           => true,
		'query_var'         => true,
	) );

}
add_action( 'init', 'live_stream_init' );

function live_stream_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['live-stream'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Live Stream updated. <a target="_blank" href="%s">View Live Stream</a>', 'wimp'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'wimp'),
		3 => __('Custom field deleted.', 'wimp'),
		4 => __('Live Stream updated.', 'wimp'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Live Stream restored to revision from %s', 'wimp'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Live Stream published. <a href="%s">View Live Stream</a>', 'wimp'), esc_url( $permalink ) ),
		7 => __('Live Stream saved.', 'wimp'),
		8 => sprintf( __('Live Stream submitted. <a target="_blank" href="%s">Preview Live Stream</a>', 'wimp'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Live Stream scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Live Stream</a>', 'wimp'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Live Stream draft updated. <a target="_blank" href="%s">Preview Live Stream</a>', 'wimp'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'live_stream_updated_messages' );

