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
	<aside class="wimp-wiki widget">
		<h3 class="title"><a href="<?php echo esc_url( home_url( '/resources/' ) ); ?>">WIMP Wiki</a></h3>
		<p>Learn from others or contribute to the collection of knowledge yourself.</p>
	</aside>
	<aside class="community-wimp widget">
		<h3 class="title"><a href="<?php echo esc_url( home_url( '/community-wall/' ) ); ?>">Community Wall</a></h3>
		<p>Ask a person, not a search engine.</p>
	</aside>
	<aside class="find-a-wimp widget">
		<h3 class="title"><a href="<?php echo esc_url( home_url( '/jobs/' ) ); ?>">Find A Wimp</a></h3>
		<p>Hire a specialist in:</p>
		<ul>
			<li><a href="<?php echo esc_url( home_url( '/jobs/category/business-management/' ) ); ?>">Business/Management</a></li>
			<li><a href="<?php echo esc_url( home_url( '/jobs/category/design/' ) ); ?>">Design</a></li>
			<li><a href="<?php echo esc_url( home_url( '/jobs/category/education/' ) ); ?>">Education</a></li>
			<li><a href="<?php echo esc_url( home_url( '/jobs/category/programing/' ) ); ?>">Programing</a></li>
			<li><a href="<?php echo esc_url( home_url( '/jobs/category/sales-business-dev/' ) ); ?>">Sales/Business Dev</a></li>
			<li><a href="<?php echo esc_url( home_url( '/jobs/category/other/' ) ); ?>">Other</a></li>
		</ul>
	</aside>

	<?php if ( ! $user_ID ) : ?>
		<aside class="meetup widget last">
			<h3 class="title"><a href="<?php echo esc_url( home_url( '/members/sign-up/' ) ); ?>">Be A Wimp</a></h3>
			<p>Join us. It’s fun!</p>
		</aside>
	<?php endif; ?>
</section>