<?php
	/**
	 * The template for displaying the footer.
	 *
	 * Contains the closing of the id=main div and all content after
	 *
	 * @package wimp
	 */
?>

				<footer class="main-footer" role="contentinfo">
					<nav class="footer-nav">
						<?php wp_nav_menu( array(
							'theme_location' => 'footer',
							'container'		 => '',
							'menu_class'	 => 'nav',
						) ); ?>
					</nav>
					<div class="social-media-links">
						<ul class="nav">
							<li><a href="https://www.facebook.com/groups/northbaywebpros/" class="facebook">Facebook</a></li>
							<li><a href="https://twitter.com/beawimp" class="twitter">Twitter</a></li>
							<li><a href="<?php bloginfo( 'atom_url' ); ?>" class="rss">RSS</a></li>
							<li><a href="http://www.meetup.com/beawimp/" class="meetup">Meetup</a></li>
						</ul>
					</div>
					<div class="copyright">
						<p>Copyright &copy; 2011 - <?php echo date( 'Y' ); ?> Web and Interactive Media Professionals. All Rights Reserved.</p>
					</div>
				</footer>
			</section>
		</section>

		<?php wp_footer(); ?>

	</body>
</html>