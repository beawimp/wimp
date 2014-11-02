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

			<?php if ( is_page( 'jobs' ) ) : ?>
				<h1>WIMP Job Board</h1>

				<div class="jb-banner"><a href="<?php echo esc_url( home_url( '/jobs/' ) ); ?>">View Jobs</a> <a href="<?php echo esc_url( home_url( '/jobs/add/' ) ); ?>">Post A Job</a> <a href="<?php echo esc_url( home_url( '/jobs/advanced-search/' ) ); ?>">Advanced Search</a></div>
				<?php if ( 'add' === get_query_var( 'job_board' ) && ! is_user_logged_in() ) :
					echo '<h1>Login Required!</h1><p>Please <a href="' . esc_url( home_url( '/members/sign-up/' ) ) . '">Sign up</a> for an account or use the login form above to add a job!</a></p>';
				else:
					get_template_part( 'content', get_post_type() );
				endif; ?>
			<?php else: ?>
				<?php get_template_part( 'content', get_post_type() ); ?>
			<?php endif; ?>



		<?php endwhile; ?>

	</section>

	<?php
		if ( is_page( 'jobs' ) ) {
			get_sidebar( 'jobs' );
		} else {
			get_sidebar();
		}
	?>

<?php get_footer(); ?>
