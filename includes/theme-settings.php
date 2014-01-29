<?php

	/**
	 * wimp functions and definitions
	 *
	 * @package wimp
	 * @since 0.1.20140120
	 */

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	if ( ! isset( $content_width ) )
		$content_width = 869; /* pixels */


	/**
	 * Theme version... yup. Meow.
	 */
	define( 'THEME_VERSION', '0.1.20140120' );


	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 */
	if ( ! function_exists( 'wimp_setup' ) ) :
		function wimp_setup() {

			/**
			 * Include our Twitter Bootstrap Walker class.
			 */
			include_once( 'bootstrap-nav-walker.php' );

			/**
			 * Add default posts and comments RSS feed links to head
			 */
			add_theme_support( 'automatic-feed-links' );


			/**
			 * Enable support for Post Thumbnails on posts and pages
			 *
			 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
			 */
			add_theme_support( 'post-thumbnails' );


			/**
			 * Adding some custom post image sizes :)
			 */
			if ( function_exists( 'add_image_size' ) ) { 
				add_image_size( 'featured-post', 408, 305, true );
				add_image_size( 'secondary-post', 408, 248, true );
			}


			/**
			 * This theme uses wp_nav_menu() in one location.
			 */
			register_nav_menus( array(
				'primary' => __( 'Primary Menu', 'wimp' ),
				'footer'  => __( 'Footer Menu', 'wimp' ),
			) );

			/**
			 * Remove the admin tool bar for all but admins
			 */
			if ( ! current_user_can( 'activate_plugins' ) && ! is_admin() ) {
				show_admin_bar( false );
			}
		}
	endif; // wimp_setup
	add_action( 'after_setup_theme', 'wimp_setup' );


	/**
	 * Add our themes css styles and scripts.
	 * @return void
	 *
	 * @version 0.1
	 * @since 0.1.20140120
	 */
	function wimp_theme_resources() {
		wp_enqueue_style( 'wimp-google-font', 'http://fonts.googleapis.com/css?family=Quicksand:300,400,700' );
		wp_enqueue_style( 'wimp-styles', get_stylesheet_directory_uri() . '/css/app.min.css', null, THEME_VERSION );

		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js', null, THEME_VERSION );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'wimp-scripts', get_stylesheet_directory_uri() . '/js/build/app.min.js', array( 'jquery' ), THEME_VERSION, false );

	}
	add_action( 'wp_enqueue_scripts', 'wimp_theme_resources' );


	/**
	 * Register widgetized area and update sidebar with default widgets
	 */
	function wimp_widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Sidebar', 'wimp' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		) );
	}
	add_action( 'widgets_init', 'wimp_widgets_init' );


	function wimp_login_forms() {
		global $current_user, $user_ID, $user_identity;
		get_currentuserinfo();

		if ( ! $user_ID ) : ?>
			<div class="logins">
				<div class="row-fluid">
					<form method="post" action="<?php echo esc_url( home_url( '/wp-login.php?wpe-login=wimp' ) ); ?>" class="login-forms form-inline" name="loginform">
						<input type="text" name="log" id="user_login" placeholder="username" tabindex="11" value="<?php echo esc_attr( stripslashes( $user_login ) ); ?>">
						<input type="password" name="pwd" id="user_pass" placeholder="password" tabindex="12">
						<input type="submit" name="wp-submit" value="Log In" class="btn btn-default" tabindex="13">
						<input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url() ); ?>" />
						<input type="hidden" name="user-cookie" value="1" />
					</form>
					<div class="login-meta">
						<a href="<?php echo esc_url( home_url( '/wp-login.php?action=lostpassword' ) ); ?>">Forgot Password</a> <span>|</span> <a href="<?php echo esc_url( home_url( '/members/sign-up/' ) ); ?>">Be a WIMP</a>
					</div>
				</div>
			</div>
		<?php else : ?>
			<div class="logins text-right">
				<div class="row-fluid">
					<p class="logged-in"><span class="name">Welcome, <a href="<?php echo bp_loggedin_user_domain(); ?>"><?php echo esc_html( $current_user->display_name ); ?></a>! <a href="<?php echo bp_loggedin_user_domain(); ?>"><?php echo bp_core_fetch_avatar( array( 'item_id' => $current_user->ID, 'type' => 'thumb', 'width' => 26, 'height' => 26 ) ); ?></a></span> <span>&nbsp;|&nbsp;</span> <span class="signout"><a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="signout">sign out</a></span></p>
				</div>
			</div>
		<?php endif;
	}


	/**
	 * Custom template tags for this theme.
	 */
	require get_template_directory() . '/includes/template-tags.php';


	/**
	 * Custom functions that act independently of the theme templates.
	 */
	require get_template_directory() . '/includes/extras.php';


	/**
	 * Load Jetpack compatibility file.
	 */
	require get_template_directory() . '/includes/jetpack.php';

