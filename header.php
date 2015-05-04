<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package wimp
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width">
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<link rel="shortcut icon" href="<?php echo esc_url( get_stylesheet_directory_uri() . '/favicon.png' ); ?>" />

		<?php wp_head(); ?>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-47611761-1', 'beawimp.org');
			ga('send', 'pageview');
		</script>
	</head>

	<body <?php body_class(); ?>>
		<!--[if lt IE 8]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser and is not supported. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
		<section class="top-header-wrapper">
			<div class="container">
				<div class="row">
					<aside class="slogan hidden-sm hidden-xs">
						<p><?php echo bloginfo( 'description' ); ?></p>
					</aside>
					<?php echo wimp_login_form(); ?>
				</div>
			</div>
		</section>
		<section class="header-wrapper container">
			<div class="row">
				<header role="banner" class="main-header">
					<div class="logo">
						<a href="<?php echo esc_url( home_url() ); ?>">WIMP | Web and Interactive Media Professionals</a>
					</div>
					<nav class="navbar navbar-default" role="navigation">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#wimp-nav">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="collapse navbar-collapse" id="wimp-nav">
							<?php wp_nav_menu( array(
								'theme_location' => 'primary',
								'container'		 => '',
								'menu_class'	 => 'nav navbar-nav',
								'walker'		 => new Bootstrap_Walker_Nav_Menu(),
							) ); ?>
						</div>
					</nav>
				</header>
			</div>
		</section>
		<section class="main container">
			<section class="row main-wrapper">