/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 *
 * @package WIMP
 * @author Cole Geissinger <cole@beawimp.org>
 *
 * @version 1.0
 * @since   2.0
 */
( function() {
	var container = document.getElementById( 'site-navigation' );
	var button    = container.getElementsByTagName( 'h1' )[0];
	var menu      = container.getElementsByTagName( 'ul' )[0];

	if ( undefined === button || undefined === menu ) {
		return false;
	}

	button.onclick = function() {
		if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
			menu.className = 'nav-menu';
		}

		if ( -1 !== button.className.indexOf( 'toggled-on' ) ) {
			button.className = button.className.replace( ' toggled-on', '' );
			menu.className = menu.className.replace( ' toggled-on', '' );
			container.className = container.className.replace( 'main-small-navigation', 'navigation-main' );
		} else {
			button.className += ' toggled-on';
			menu.className += ' toggled-on';
			container.className = container.className.replace( 'navigation-main', 'main-small-navigation' );
		}
	};

	// Hide menu toggle button if menu is empty.
	if ( ! menu.childNodes.length ) {
		button.style.display = 'none';
	}
} )();