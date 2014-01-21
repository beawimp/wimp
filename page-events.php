<?php
/**
 * The template for displaying events.
 * Template Name: Events
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

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article class="event-description">
				<?php get_template_part( 'content', 'page' ); ?>
			</article>
		<?php endwhile; endif; ?>
			
		<h2 class="events-headline">Upcoming Events</h2>
		<ul class="events-wrapper">
			<?php
				$upcoming_query = array(
					'group_urlname' => 'beawimp',
					'status' => 'upcoming',
				);
				wimp_list_events( $upcoming_query );
			?>
		</ul>
		
		<h2 class="events-headline">Past Events</h2>
		<ul class="events-wrapper past">
			<?php 
				$past_query = array(
					'group_urlname' => 'beawimp',
					'status' => 'past',
					'desc' => 'true',
				);
				wimp_list_events( $past_query, 5 );
			?>
		</ul>

	</section>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
