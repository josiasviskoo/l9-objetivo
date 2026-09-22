/**
 * "Nossa História" em tela cheia: destaca o ponto ativo na navegação lateral
 * conforme a seção visível e faz os pontos rolarem até a seção clicada.
 */
(function () {
	var dots = Array.prototype.slice.call( document.querySelectorAll( '.hist-dot' ) );
	var screens = Array.prototype.slice.call( document.querySelectorAll( '.hist-screen' ) );
	if ( ! dots.length || ! screens.length ) {
		return;
	}

	dots.forEach( function ( dot ) {
		dot.addEventListener( 'click', function () {
			var target = document.querySelector( dot.getAttribute( 'data-target' ) );
			if ( target ) {
				target.scrollIntoView( { behavior: 'smooth' } );
			}
		} );
	} );

	var setActive = function ( id ) {
		dots.forEach( function ( dot ) {
			dot.classList.toggle( 'is-active', dot.getAttribute( 'data-target' ) === '#' + id );
		} );
	};

	if ( 'IntersectionObserver' in window ) {
		var observer = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					setActive( entry.target.id );
				}
			} );
		}, { threshold: .55 } );
		screens.forEach( function ( screen ) {
			observer.observe( screen );
		} );
	} else {
		setActive( screens[ 0 ].id );
	}
})();
