<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package wimp
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function wimp_page_menu_args( $args ) {
	$args['show_home'] = true;

	return $args;
}
add_filter( 'wp_page_menu_args', 'wimp_page_menu_args' );


/**
 * Adds custom classes to the array of body classes.
 */
function wimp_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() )
		$classes[] = 'group-blog';

	return $classes;
}
add_filter( 'body_class', 'wimp_body_classes' );


/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function wimp_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( absint( $id ) ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'wimp_enhanced_image_navigation', 10, 2 );


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function wimp_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'wimp' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'wimp_wp_title', 10, 2 );

/**
 * For caching needs, we'll strip query strings
 *
 * @param string $src
 *
 * @return mixed
 */
function wimp_remove_query_strings( $src ) {
	if ( ! is_admin() ) {
		$parts = explode( '?ver', $src );
		$src   = $parts[0];
	}

	return $src;
}
add_filter( 'script_loader_src', 'wimp_remove_query_strings', 15, 1 );
add_filter( 'style_loader_src', 'wimp_remove_query_strings', 15, 1 );


function wimp_login_style() {
	?>
	<style type="text/css">
		html, body.login {
			background:#fff;
		}
		#login h1 a {
			background:url( '<?php echo esc_url( get_stylesheet_directory_uri() . '/images/wimp-logo.png?v=20150301' ); ?>' ) 0 0 no-repeat;
			width:347px;
			height:124px;
			display:block;
			font: ~"0/0" a;
			color: transparent;
			text-shadow: none;
			background-color: transparent;
			border: 0;
		}
		#loginform {
			background-color:#f5f5f5;
		}
	</style>
	<?php
}
add_action( 'login_enqueue_scripts', 'wimp_login_style' );