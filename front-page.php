<?php
	/**
	 * The main template file.
	 *
	 * This is the most generic template file in a WordPress theme
	 * and one of the two required files for a theme (the other being style.css).
	 * It is used to display a page when nothing more specific matches a query.
	 * E.g., it puts together the home page when no home.php file exists.
	 * Learn more: http://codex.wordpress.org/Template_Hierarchy
	 *
	 * @package wimp
	 */

get_header(); ?>
	<section class="main-body">
		<div class="header-image">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/hero-image.jpg" />
		</div>
		<article class="featured-meetup">
			<header class="meetup-header">
				<h2 class="title">Next Featured Meetup</h2>
				<h3 class="subtitle">WIMP SpeedGeeking + Potluck</h3>
				<p class="meetup-meta">Wednesday, June 26th, 2013 | 7:00PM | <a href="#">RSVPS: 30</a></p>
			</header>
			<p>Never speedgeeked? It's ok. We'll teach you! In a nutshell, "SpeedGeeking" is a tongue-in-check rip off of the speed dating concept. There will be a number of presenters setup with a 5 minute presentation around the room. The group of attendees will ...</p>
		</article>
		<?php
			$blog_posts = new WP_Query( array( 'posts_per_page' => 3 ) );
			$post_count = 0; // Count our posts.
			while ( $blog_posts->have_posts() ) : $blog_posts->the_post();
				$post_count++;
				if ( $post_count == 1 ) : // Check if we are loading the first post ?>
					<article class="row-fluid latest-post">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="featured-image">
								<a href="<?php echo the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
							</div>
						<?php endif; ?>
						<div class="post-content"<?php echo ( ! has_post_thumbnail() ) ? ' class="no-feat-image"' : ''; ?>>
							<header class="post-header">
								<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p class="post-meta">By <?php the_author_posts_link(); ?> -- <?php the_time( 'D d, Y' ); ?></p>
							</header>
							<p class="post-excerpt"><?php the_excerpt(); ?></p>
							<p class="read-more"><a href="<?php the_permalink(); ?>">read more -></a></p>
						</div>
					</article>
				<?php else : // If we are not loading the first, handle the last two
					echo ( $post_count == 2 ) ? '<article class="second-post post">' : '<article class="third-post post">'; ?>
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php echo the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
						<?php endif; ?>
						<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="post-meta">By <?php the_author_posts_link(); ?> -- <?php the_time( 'D d, Y' ); ?></p>
					</article>
				<?php endif;
			endwhile;
			wp_reset_query();
		?>
	</section>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>