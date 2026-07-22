/**
 * Filtro por categoria do bloco "Novidades do Objetivo" na home. Os posts
 * já são reais (WordPress), então isso só mostra/esconde no cliente — a
 * listagem completa com paginação real fica na página com o modelo "Blog".
 */
( function () {
	'use strict';

	var buttons = document.querySelectorAll( '.blog-filter-btn' );
	var posts = document.querySelectorAll( '#blog-grid .blog-post' );

	if ( ! buttons.length || ! posts.length ) {
		return;
	}

	buttons.forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			var cat = btn.getAttribute( 'data-cat' );

			posts.forEach( function ( post ) {
				var show = 'todos' === cat || post.getAttribute( 'data-cat' ) === cat;
				post.style.display = show ? '' : 'none';
			} );

			buttons.forEach( function ( b ) {
				b.classList.remove( 'active' );
			} );
			btn.classList.add( 'active' );
		} );
	} );
} )();
