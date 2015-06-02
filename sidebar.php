<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package wimp
 */
?>
<section class="sidebar hidden-sm hidden-xs">
	<?php if ( ! wmd_is_wimp_plus_member() ) : ?>
		<aside class="widget">
			<?php
			if ( is_user_logged_in() ) {
				$url = wmd_get_membership_url();
			} else {
				$url = home_url( '/membership/' );
			}
			?>
			<a href="<?php echo esc_url( $url ); ?>" style="margin-top:20px;display:block;">
				<img src="http://beawimp.org/wp-content/uploads/2015/05/cta_button.png"
				     title="WIMP+ Membership - Serious perks for serious Wimps"
				     alt="WIMP+ Membership - Serious perks for serious Wimps"
					 width="261"
					 height="135">
			</a>
		</aside>
	<?php endif; ?>
	<aside class="widget">
		<?php if ( ! is_user_logged_in() ) : ?>
			<h3 class="title"><a href="<?php echo esc_url( home_url( '/joining-wimp' ) ); ?>">Be A Wimp</a></h3>
			<p><a href="<?php echo esc_url( home_url( '/members/sign-up/' ) ); ?>">Sign Up</a></p>
		<?php else : ?>
			<h3 class="title"><a href="<?php echo esc_url( home_url( '/members/' ) ); ?>">I'm a Wimp</a></h3>
			<?php if ( wmd_is_wimp_plus_member() ) : ?>
				<p><a href="<?php echo esc_url( home_url( '/wimp-member-perks/' ) ); ?>">View WIMP+ Perks</a></p>
			<?php endif; ?>
			<p><a href="<?php echo esc_url( home_url( '/members/activity/' ) ); ?>">View Member Activity</a></p>
			<p><a href="<?php echo esc_url( home_url( '/discussions/' ) ); ?>">Start a Discussion</a></p>
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