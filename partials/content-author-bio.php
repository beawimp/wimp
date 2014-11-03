<?php

/**
 * Contains the author bio block which displays on the author archive page and the authors posts.
 */

$author = wimp_get_author_data();
?>
<div id="author-block">
	<h3 class="author-name"><?php echo esc_html( $author->display_name ); ?></h3>

	<?php if ( ! empty( $author->title ) || ! empty( $author->company ) ) : ?>
		<h4 class="author-title"><?php echo esc_html( wimp_get_author_title() ); ?></h4>
	<?php endif; ?>

	<figure class="author-avatar">
		<?php echo wp_kses_post( $author->avatar ); ?>
	</figure>
	<aside class="author-bio">
		<?php echo ( ! empty( $author->description ) ) ? wpautop( esc_html( $author->description ) ) : '<p>No bio set!</p>'; ?>

		<ul class="author-social">
			<li>
				<a href="<?php echo esc_url( $author->wimp_url ); ?>" class="icon-profile" title="WIMP Profile"></a>
			</li>

			<?php if ( ! empty( $author->facebook_url ) ) : ?>
				<li>
					<a href="<?php echo esc_url( $author->facebook_url ); ?>" class="icon-facebook" title="Facebook Profile"></a>
				</li>
			<?php endif; ?>

			<?php if ( ! empty( $author->twitter_url ) ) : ?>
				<li>
					<a href="<?php echo esc_url( $author->twitter_url ); ?>" class="icon-twitter" title="Twitter Profile"></a>
				</li>
			<?php endif; ?>

			<?php if ( ! empty( $author->linkedin_url ) ) : ?>
				<li>
					<a href="<?php echo esc_url( $author->linkedin_url ); ?>" class="icon-linkedin" title="LinkedIn Profile"></a>
				</li>
			<?php endif; ?>

			<?php if ( ! empty( $author->google_url ) ) : ?>
				<li>
					<a href="<?php echo esc_url( $author->google_url ); ?>" class="icon-googleplus" title="Google+ Profile"></a>
				</li>
			<?php endif; ?>

			<?php if ( ! empty( $author->instagram_url ) ) : ?>
				<li>
					<a href="<?php echo esc_url( $author->instagram_url ); ?>" class="icon-instagram" title="Instagram Profile"></a>
				</li>
			<?php endif; ?>
		</ul>
	</aside>
</div>