/**
 * Menu mobile (hambúrguer) + timeline interativa "Nossa História".
 * Puro JS, sem dependência de jQuery.
 */
( function () {
	'use strict';

	/* ---- Menu mobile ------------------------------------------------- */
	var toggle = document.querySelector( '.nav-toggle' );
	var nav = document.getElementById( 'primary-menu' );

	if ( toggle && nav ) {
		toggle.addEventListener( 'click', function () {
			var isOpen = nav.classList.toggle( 'is-open' );
			toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		} );

		document.addEventListener( 'click', function ( event ) {
			if ( ! nav.classList.contains( 'is-open' ) ) {
				return;
			}
			if ( ! nav.contains( event.target ) && ! toggle.contains( event.target ) ) {
				nav.classList.remove( 'is-open' );
				toggle.setAttribute( 'aria-expanded', 'false' );
			}
		} );
	}

	/* ---- Timeline interativa ------------------------------------------
	 * Generaliza o comportamento do protótipo estático (que tinha 4
	 * marcos fixos tl1..tl4) para qualquer quantidade de posts do CPT
	 * objetivo_timeline, casando bolinha e card pelo mesmo data-id.
	 */
	var dots = document.querySelectorAll( '.tl-dot' );

	dots.forEach( function ( dot ) {
		var activate = function () {
			var id = dot.getAttribute( 'data-id' );
			var card = document.getElementById( id );
			if ( ! card ) {
				return;
			}
			var wasActive = card.classList.contains( 'active' );

			document.querySelectorAll( '.tl-dot' ).forEach( function ( d ) {
				d.classList.remove( 'active' );
			} );
			document.querySelectorAll( '.tl-card' ).forEach( function ( c ) {
				c.classList.remove( 'active' );
			} );

			if ( ! wasActive ) {
				dot.classList.add( 'active' );
				card.classList.add( 'active' );
			}
		};

		dot.addEventListener( 'click', activate );
		dot.addEventListener( 'keydown', function ( event ) {
			if ( 'Enter' === event.key || ' ' === event.key ) {
				event.preventDefault();
				activate();
			}
		} );
	} );

	document.querySelectorAll( '.tl-card' ).forEach( function ( card ) {
		card.addEventListener( 'click', function () {
			var id = card.getAttribute( 'data-id' );
			var dot = document.querySelector( '.tl-dot[data-id="' + id + '"]' );
			if ( dot ) {
				dot.click();
			}
		} );
	} );
} )();
