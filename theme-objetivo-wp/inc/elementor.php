<?php
/**
 * Compatibilidade com Elementor: quando uma página é editada com o
 * Elementor, os templates do tema (page.php, template-sobre.php) pulam o
 * banner "page-hero" e o wrapper `.container` — senão o layout do Elementor
 * (sobretudo seções full-width) fica preso dentro da largura/gap do tema.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function objetivo_is_built_with_elementor( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	return $post_id && 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true );
}
