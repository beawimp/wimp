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
	<aside class="widget">
		<h3 class="title">Affiliates</h3>
		<p>WIMP recommends A Small Orange for Web Hosting</p>
		<a href="http://asmallorange.com/webhosting/RT/?a_aid=beawimp&amp;a_aid=beawimp&amp;a_bid=e945d0d1" target="_top">
			<img src="https://affiliates.asmallorange.com/accounts/default1/banners/ASO-Banners_DD_250x250.gif" alt="" title="" width="250" height="250" />
		</a>
		<img style="border:0" src="https://affiliates.asmallorange.com/scripts/imp.php?a_aid=beawimp&amp;a_bid=e945d0d1" width="1" height="1" alt="" />
	</aside>
</section>