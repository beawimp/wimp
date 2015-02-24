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
	<aside class="widget">
		<?php if ( ! $user_ID ) : ?>
			<h3 class="title"><a href="<?php echo esc_url( home_url( '/members/sign-up/' ) ); ?>">Be A Wimp</a></h3>
			<p><a href="<?php echo esc_url( home_url( '/members/sign-up/' ) ); ?>">Sign Up</a></p>
		<?php else : ?>
			<h3 class="title"><a href="<?php echo esc_url( home_url( '/members/' ) ); ?>">I'm A Wimp!</a></h3>
			<p><a href="<?php echo esc_url( home_url( '/members/activity/' ) ); ?>">View Member Activity</a></p>
		<?php endif; ?>
		<p><a href="<?php echo esc_url( home_url( '/events/' ) ); ?>">Come to a Meetup</a></p>
	</aside>
	<aside class="widget">
		<h3 class="title"><a href="<?php echo esc_url( home_url( '/jobs/' ) ); ?>">Find Work</a></h3>
		<p><a href="<?php echo esc_url( home_url( '/jobs/' ) ); ?>">Job Board</a></p>
		<p><a href="<?php echo esc_url( home_url( '/wimp-referral-program/' ) ); ?>">Referral Program</a></p>
	</aside>
	<aside class="widget">
		<h3 class="title"><a href="<?php echo esc_url( home_url( '/jobs/' ) ); ?>">Find A Wimp</a></h3>
		<p><a href="<?php echo esc_url( home_url( '/jobs/add/' ) ); ?>">Post A Job</a></p>
		<p><a href="<?php echo esc_url( home_url( '/wimp-referral-questionnaire/' ) ); ?>">Get Referrals</a></p>
	</aside>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</section>