<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package wimp
 */
global $user_ID;
get_currentuserinfo();
?>
<section class="sidebar hidden-sm hidden-xs">
	<?php if ( ! $user_ID ) : ?>
		<aside class="meetup widget last">
			<h3 class="title"><a href="<?php echo esc_url( home_url( '/members/sign-up/' ) ); ?>">Be A Wimp</a></h3>
			<p>Join us. It’s fun!</p>
		</aside>
	<?php endif; ?>

	<?php dynamic_sidebar( 'job-board' ); ?>
</section>