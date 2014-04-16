<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package wimp
 */

get_header(); ?>

	<section class="main-body" class="site-content" role="main">

		<div class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'wimp' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">

				<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'wimp' ); ?></p>

				<?php get_search_form(); ?>

			</div>
		</div>

	</section>

	<?php
		if ( is_page( 'job-board' ) ) {
			get_sidebar( 'job-board' );
		} else {
			get_sidebar();
		}
	?>

<?php get_footer(); ?>