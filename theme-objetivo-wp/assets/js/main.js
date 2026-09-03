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

	/* ---- Carrossel de unidades ------------------------------------------
	 * Mostra 2 cards por página no celular e 3 no desktop (mesmo breakpoint
	 * de 760px usado em style-main.css para a largura dos cards). Rola por
	 * página inteira via scrollTo nativo (scroll-snap cuida do alinhamento
	 * e também permite arrastar/deslizar manualmente).
	 */
	var unidadesCarousel = document.getElementById( 'unidades-carousel' );

	if ( unidadesCarousel ) {
		var unidadesTrack = unidadesCarousel.querySelector( '.unidades-track' );
		var unidadesCards = unidadesTrack ? unidadesTrack.children : [];
		var unidadesPrevBtn = unidadesCarousel.querySelector( '.unidades-prev' );
		var unidadesNextBtn = unidadesCarousel.querySelector( '.unidades-next' );
		var unidadesDotsWrap = unidadesCarousel.querySelector( '.unidades-dots' );
		var unidadesMobileQuery = window.matchMedia( '(max-width: 760px)' );
		var unidadesPage = 0;
		var unidadesAutoplayTimer;
		var unidadesResizeTimer;

		var unidadesItemsPerView = function () {
			return unidadesMobileQuery.matches ? 2 : 3;
		};

		var unidadesPageCount = function () {
			return Math.max( 1, Math.ceil( unidadesCards.length / unidadesItemsPerView() ) );
		};

		var unidadesUpdateDots = function () {
			if ( ! unidadesDotsWrap ) {
				return;
			}
			unidadesDotsWrap.querySelectorAll( '.unidades-dot' ).forEach( function ( dot, i ) {
				dot.classList.toggle( 'is-active', i === unidadesPage );
			} );
		};

		var unidadesRenderDots = function () {
			var pageCount = unidadesPageCount();
			unidadesCarousel.classList.toggle( 'is-single-page', pageCount <= 1 );

			if ( ! unidadesDotsWrap ) {
				return;
			}
			unidadesDotsWrap.innerHTML = '';
			for ( var i = 0; i < pageCount; i++ ) {
				var dot = document.createElement( 'button' );
				dot.type = 'button';
				dot.className = 'unidades-dot' + ( 0 === i ? ' is-active' : '' );
				dot.setAttribute( 'aria-label', 'Ir para a página ' + ( i + 1 ) );
				( function ( index ) {
					dot.addEventListener( 'click', function () {
						unidadesGoTo( index );
						unidadesStartAutoplay();
					} );
				} )( i );
				unidadesDotsWrap.appendChild( dot );
			}
		};

		var unidadesGoTo = function ( index ) {
			var pageCount = unidadesPageCount();
			unidadesPage = ( index + pageCount ) % pageCount;
			unidadesTrack.scrollTo( { left: unidadesTrack.clientWidth * unidadesPage, behavior: 'smooth' } );
			unidadesUpdateDots();
		};

		var unidadesStartAutoplay = function () {
			clearInterval( unidadesAutoplayTimer );
			if ( unidadesPageCount() > 1 ) {
				unidadesAutoplayTimer = setInterval( function () {
					unidadesGoTo( unidadesPage + 1 );
				}, 4500 );
			}
		};

		if ( unidadesPrevBtn ) {
			unidadesPrevBtn.addEventListener( 'click', function () {
				unidadesGoTo( unidadesPage - 1 );
				unidadesStartAutoplay();
			} );
		}

		if ( unidadesNextBtn ) {
			unidadesNextBtn.addEventListener( 'click', function () {
				unidadesGoTo( unidadesPage + 1 );
				unidadesStartAutoplay();
			} );
		}

		unidadesCarousel.addEventListener( 'mouseenter', function () {
			clearInterval( unidadesAutoplayTimer );
		} );
		unidadesCarousel.addEventListener( 'mouseleave', unidadesStartAutoplay );

		window.addEventListener( 'resize', function () {
			clearTimeout( unidadesResizeTimer );
			unidadesResizeTimer = setTimeout( function () {
				unidadesPage = 0;
				unidadesTrack.scrollTo( { left: 0 } );
				unidadesRenderDots();
				unidadesStartAutoplay();
			}, 200 );
		} );

		unidadesRenderDots();
		unidadesStartAutoplay();
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
