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
						<ul class="nav">
							<li><a href="#">Press Kit</a></li>
							<li><a href="#">Terms of Use</a></li>
							<li><a href="#">Supporters</a></li>
							<li><a href="#">Donations</a></li>
							<li><a href="#">Contact</a></li>
						</ul>
					</nav>
					<div class="social-media-links">
						<ul class="nav">
							<li><a href="#">Facebook</a></li>
							<li><a href="#">Twitter</a></li>
							<li><a href="#">RSS</a></li>
							<li><a href="#">Meetup</a></li>
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