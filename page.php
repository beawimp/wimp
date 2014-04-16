<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package wimp
 */
global $wp;
get_header(); ?>

	<section class="main-body" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php if ( is_page( 'job-board' ) && isset( $wp->query_vars['pagename'] ) && $wp->query_vars['pagename'] == 'job-board' ) : ?>
				<a href="http://beawimp.org/job-board/add/" class="btn btn-primary pull-right" style="margin-top:23px;">Post a Job - $25 Limited Time Only</a>
				<h1>WIMP Job Board</h1>

				<div class="jb-banner"><a href="http://beawimp.org/job-board/">View Jobs</a> <a href="http://beawimp.org/job-board/add/">Post A Job</a> <a href="http://beawimp.org/job-board/advanced-search/">Advanced Search</a></div>

				<h2 class="subtitle">Browse Jobs by Category</h2>
				<div class="row grid-squares">
					<div class="box-square"><a href="http://beawimp.org/job-board/category/design/">Design</a></div>
					<div class="box-square"><a href="http://beawimp.org/job-board/category/programing/">Programming</a></div>
					<div class="box-square last"><a href="http://beawimp.org/job-board/category/business-management/">Business/Management</a></div>
					<div class="box-square"><a href="http://beawimp.org/job-board/category/sales-business-dev/">Sales/Business Dev</a></div>
					<div class="box-square"><a href="http://beawimp.org/job-board/category/education/">Education</a></div>
					<div class="box-square last"><a href="http://beawimp.org/job-board/category/other/">Other</a></div>
				</div>

				<h2 class="subtitle">Search Job Listings</h2>

			<?php elseif ( is_page( 'job-board' ) ) : ?>
				<h1>WIMP Job Board</h1>

				<div class="jb-banner"><a href="http://beawimp.org/job-board/">View Jobs</a> <a href="http://beawimp.org/job-board/add/">Post A Job</a> <a href="http://beawimp.org/job-board/advanced-search/">Advanced Search</a></div>
			<?php endif; ?>
			<?php get_template_part( 'content', get_post_type() ); ?>

		<?php endwhile; ?>

	</section>

	<?php
		if ( is_page( 'job-board' ) ) {
			get_sidebar( 'job-board' );
		} else {
			get_sidebar();
		}
	?>

<?php get_footer(); ?>
