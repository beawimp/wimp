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

get_header(); ?>

	<section class="main-body" class="site-content" role="main">
	
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', get_post_type() ); ?>

		<?php endwhile; ?>

	</section>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
