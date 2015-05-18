<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package wimp
 */

/**
 * Display navigation to next/previous pages when applicable
 */
if ( ! function_exists( 'wimp_content_nav' ) ) :
	function wimp_content_nav( $nav_id ) {
		global $wp_query, $post;

		// Don't print empty markup on single pages if there's nowhere to navigate.
		if ( is_single() ) {
			$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
			$next = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous )
				return;
		}

		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
			return;

		$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

		?>
		<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
			<h1 class="sr-only"><?php _e( 'Post navigation', 'wimp' ); ?></h1>

		<?php if ( is_single() ) : // navigation links for single posts ?>

			<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'wimp' ) . '</span> %title' ); ?>
			<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'wimp' ) . '</span>' ); ?>

		<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'wimp' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'wimp' ) ); ?></div>
			<?php endif; ?>

		<?php endif; ?>

		</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
		<?php
	}
endif; // wimp_content_nav


/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
if ( ! function_exists( 'wimp_comment' ) ) :
	function wimp_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php _e( 'Pingback:', 'wimp' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'wimp' ), '<span class="edit-link">', '</span>' ); ?>
			</div>

		<?php else : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
						<?php printf( __( '%s <span class="says">says:</span>', 'wimp' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					</div><!-- .comment-author -->

					<div class="comment-metadata">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'wimp' ), get_comment_date(), get_comment_time() ); ?>
							</time>
						</a>
						<?php edit_comment_link( __( 'Edit', 'wimp' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .comment-metadata -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'wimp' ); ?></p>
					<?php endif; ?>
				</footer><!-- .comment-meta -->

				<div class="comment-content">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->

				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
			</article><!-- .comment-body -->

		<?php
		endif;
	}
endif; // ends check for wimp_comment()


/**
 * Prints the attached image with a link to the next attached image.
 */
if ( ! function_exists( 'wimp_the_attached_image' ) ) :
	function wimp_the_attached_image() {
		$post                = get_post();
		$attachment_size     = apply_filters( 'wimp_attachment_size', array( 1200, 1200 ) );
		$next_attachment_url = wp_get_attachment_url();

		/**
		 * Grab the IDs of all the image attachments in a gallery so we can get the
		 * URL of the next adjacent image in a gallery, or the first image (if
		 * we're looking at the last image in a gallery), or, in a gallery of one,
		 * just the link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => -1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID'
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id )
				$next_attachment_url = get_attachment_link( $next_id );

			// or get the URL of the first image attachment.
			else
				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}

		printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
			esc_url( $next_attachment_url ),
			the_title_attribute( array( 'echo' => false ) ),
			wp_get_attachment_image( $post->ID, $attachment_size )
		);
	}
endif;


/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
if ( ! function_exists( 'wimp_posted_on' ) ) :
	function wimp_posted_on() {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		printf( __( '<span class="posted-on">Posted on %1$s</span><span class="byline"> by %2$s</span>', 'wimp' ),
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				$time_string
			),
			sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'wimp' ), get_the_author() ) ),
				esc_html( get_the_author() )
			)
		);
	}
endif;


/**
 * Returns true if a blog has more than 1 category
 */
function wimp_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so wimp_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so wimp_categorized_blog should return false
		return false;
	}
}


/**
 * Adds the login form!
 * @return html
 */
function wimp_login_form() {
	global $current_user, $user_ID, $user_identity;
	get_currentuserinfo();

	if ( ! $user_ID ) : ?>
		<div class="logins">
			<div class="row-fluid">
				<form method="post" action="<?php echo esc_url( home_url( '/wp-login.php' ) ); ?>" class="login-forms form-inline" name="loginform">
					<input type="text" name="log" id="user_login" placeholder="username" tabindex="11" value="<?php echo ( ! empty( $user_login ) ? esc_attr( $user_login ) : '' ); ?>">
					<input type="password" name="pwd" id="user_pass" placeholder="password" tabindex="12">
					<input type="submit" name="wp-submit" value="Log In" class="btn btn-default" tabindex="13">
					<input type="hidden" name="redirect_to" value="<?php echo esc_url( get_permalink() ); ?>" />
					<input type="hidden" name="user-cookie" value="1" />
				</form>
				<div class="login-meta">
					<a href="<?php echo esc_url( home_url( '/wp-login.php?action=lostpassword' ) ); ?>">Forgot Password</a> <span>|</span> <a href="<?php echo esc_url( home_url( '/members/sign-up/' ) ); ?>">Be a WIMP</a>
				</div>
			</div>
		</div>
	<?php else : ?>
		<div class="logins text-right<?php echo ( is_user_logged_in() ) ? ' user-logged-in' : ''; ?>">
			<div class="row-fluid">
				<?php do_action( 'wimp_logged_in_notice' ); ?>
				<p class="logged-in">
					<span class="name">
						Welcome, <a href="<?php echo bp_loggedin_user_domain(); ?>"><?php echo esc_html( $current_user->display_name ); ?></a>!
						<a href="<?php echo bp_loggedin_user_domain(); ?>">
							<?php echo bp_core_fetch_avatar( array(
								'item_id' => $current_user->ID,
								'type'    => 'thumb',
								'width'   => 26,
								'height'  => 26
							) ); ?>
						</a>
					</span>
					<span>&nbsp;|&nbsp;</span>
					<span class="signout">
						<a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="signout">
							sign out
						</a>
					</span>
				</p>
			</div>
		</div>
	<?php endif;
}


/**
 * Flush out the transients used in wimp_categorized_blog
 * @return void
 */
function wimp_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'wimp_category_transient_flusher' );
add_action( 'save_post',     'wimp_category_transient_flusher' );


/**
 * Extends the word length for the excerpt tool. This is primarily used for the homepage. Adjusting this for another area,
 * may not be wise as it will affect the look of it.
 * @param  string $length The number of words to display
 * @return integer
 */
function wimp_increase_excerpt_length( $length ) {
	return 62;
}
add_filter( 'excerpt_length', 'wimp_increase_excerpt_length' );


/**
 * Changes the default excerpt more link [...] to an elpises ...
 * @param  string $excerpt The default excerpt more link
 * @return string
 */
function wimp_excerpt_new_more_link( $excerpt ) {
	return str_replace( '[...]', '...', $excerpt );
}
add_filter( 'wp_trim_excerpt', 'wimp_excerpt_new_more_link' );

/**
 * Returns the author meta information including BuddyPress parameters.
 *
 * @param null $author_id
 *
 * @return array|mixed
 */
function wimp_get_author_data( $author_id = null ) {
	if ( ! isset( $author_id ) || ! is_int( $author_id ) ) {
		$author_id = get_the_author_meta( 'ID' );
	}

	$author_id = (int) $author_id;

	// Make sure we returned a proper ID
	if ( 0 === $author_id ) {
		return false;
	}

	// Fetch the default Author Information
	$author = get_userdata( $author_id );

	// Remove the author login and password
	unset( $author->data->user_pass );
	unset( $author->data->user_login );

	// Prefix the BuddyPress specific information
	$author->data->avatar = bp_core_fetch_avatar( array(
		'item_id' => $author_id,
		'type'    => 'full',
	) );
	$author->data->title = bp_get_profile_field_data( array(
		'field' => 'title',
		'user_id' => $author_id,
	) );
	$author->data->company = bp_get_profile_field_data( array(
		'field' => 'company name',
		'user_id' => $author_id,
	) );
	$author->data->description = bp_get_profile_field_data( array(
		'field' => 'description',
		'user_id' => $author_id,
	) );
	$author->data->wimp_url = bp_core_get_user_domain( $author_id );
	$author->data->facebook_url = bp_get_profile_field_data( array(
		'field' => 'facebook url',
		'user_id' => $author_id,
	) );
	$author->data->twitter_url = bp_get_profile_field_data( array(
		'field' => 'twitter url',
		'user_id' => $author_id,
	) );
	$author->data->linkedin_url = bp_get_profile_field_data( array(
		'field' => 'linkedin url',
		'user_id' => $author_id,
	) );
	$author->data->google_url = bp_get_profile_field_data( array(
		'field' => 'google+ url',
		'user_id' => $author_id,
	) );
	$author->data->instagram_url = bp_get_profile_field_data( array(
		'field' => 'instagram url',
		'user_id' => $author_id,
	) );

	return $author->data;
}

/**
 * Produces the right title for the author blocks.
 * Checks if the author has a title and/or company set.
 *
 * @see   wimp_get_author_data()
 *
 * @param object $author The author object
 *
 * @return string
 */
function wimp_get_author_title( $author ) {
	if ( ! empty( $author->title ) && ! empty( $author->company ) ) {
		return $author->title . ' at ' . $author->company;
	} elseif ( ! empty( $author->title ) && empty( $author->company ) ) {
		return $author->title;
	} elseif ( empty( $author->title ) && ! empty( $author->company ) ) {
		return $author->company;
	}

	return '';
}