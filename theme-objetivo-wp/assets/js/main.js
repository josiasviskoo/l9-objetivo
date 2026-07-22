/**
 * Menu mobile (hambúrguer) + timeline interativa "Nossa História".
 * Puro JS, sem dependência de jQuery.
 */
( function () {
	'use strict';

	/* ---- Menu mobile ------------------------------------------------- */
	var toggle = document.querySelector( '.nav-toggle' );
	var nav = document.getElementById( 'nav-wrap' );

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

	/* ---- Dropdown do menu principal ------------------------------------
	 * :hover puro fecha o submenu assim que o ponteiro sai do <li>, o que
	 * é rápido demais em movimentos diagonais até o dropdown. Aqui damos
	 * uma folga de 400ms antes de fechar, cancelada se o mouse voltar.
	 */
	document.querySelectorAll( '.primary-menu li.menu-item-has-children' ).forEach( function ( item ) {
		var closeTimer;

		item.addEventListener( 'mouseenter', function () {
			clearTimeout( closeTimer );
			item.classList.add( 'is-open' );
		} );

		item.addEventListener( 'mouseleave', function () {
			closeTimer = setTimeout( function () {
				item.classList.remove( 'is-open' );
			}, 400 );
		} );
	} );

	/* ---- Slider de banners da home ------------------------------------- */
	var slider = document.getElementById( 'hero-slider' );

	if ( slider ) {
		var slides = slider.querySelectorAll( '.hero-slide' );
		var dots = slider.querySelectorAll( '.hero-slider-dot' );
		var prevBtn = slider.querySelector( '.hero-slider-prev' );
		var nextBtn = slider.querySelector( '.hero-slider-next' );
		var current = 0;
		var autoplayTimer;

		var goTo = function ( index ) {
			current = ( index + slides.length ) % slides.length;
			slides.forEach( function ( slide, i ) {
				slide.classList.toggle( 'is-active', i === current );
			} );
			dots.forEach( function ( dot, i ) {
				dot.classList.toggle( 'is-active', i === current );
			} );
		};

		var startAutoplay = function () {
			clearInterval( autoplayTimer );
			if ( slides.length > 1 ) {
				autoplayTimer = setInterval( function () {
					goTo( current + 1 );
				}, 6000 );
			}
		};

		if ( prevBtn ) {
			prevBtn.addEventListener( 'click', function () {
				goTo( current - 1 );
				startAutoplay();
			} );
		}

		if ( nextBtn ) {
			nextBtn.addEventListener( 'click', function () {
				goTo( current + 1 );
				startAutoplay();
			} );
		}

		dots.forEach( function ( dot ) {
			dot.addEventListener( 'click', function () {
				goTo( parseInt( dot.getAttribute( 'data-index' ), 10 ) );
				startAutoplay();
			} );
		} );

		slider.addEventListener( 'mouseenter', function () {
			clearInterval( autoplayTimer );
		} );
		slider.addEventListener( 'mouseleave', startAutoplay );

		startAutoplay();
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
