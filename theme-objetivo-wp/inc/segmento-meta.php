<?php
/**
 * Vincula uma Página (post type nativo) a um dos itens do CPT
 * objetivo_segmento — o mesmo CPT usado na seção "Navegue pelo seu
 * segmento" da home, que já tem cor/ícone/rótulo geridos em
 * Segmentos por Cor no wp-admin. Ao selecionar aqui, o header mostra uma
 * faixa com a cor daquele segmento sempre que a página estiver ativa,
 * sinalizando ao visitante em qual ecossistema (Educação Infantil,
 * Fundamental, etc.) ele está navegando.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function objetivo_add_segmento_meta_box() {
	add_meta_box(
		'objetivo_page_segmento',
		__( 'Segmento (faixa colorida no menu)', 'objetivo' ),
		'objetivo_render_segmento_meta_box',
		'page',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'objetivo_add_segmento_meta_box' );

function objetivo_render_segmento_meta_box( $post ) {
	wp_nonce_field( 'objetivo_save_segmento', 'objetivo_segmento_nonce' );

	$selected  = get_post_meta( $post->ID, '_objetivo_segmento_id', true );
	$segmentos = objetivo_get_items( 'objetivo_segmento' );

	if ( ! $segmentos ) {
		echo '<p>' . esc_html__( 'Nenhum segmento cadastrado ainda. Crie em Segmentos por Cor.', 'objetivo' ) . '</p>';
		return;
	}

	echo '<select name="_objetivo_segmento_id" id="_objetivo_segmento_id" style="width:100%;">';
	echo '<option value="">' . esc_html__( '— Nenhum —', 'objetivo' ) . '</option>';
	foreach ( $segmentos as $segmento ) {
		printf(
			'<option value="%1$d" %2$s>%3$s</option>',
			(int) $segmento->ID,
			selected( $selected, (string) $segmento->ID, false ),
			esc_html( get_the_title( $segmento ) )
		);
	}
	echo '</select>';
	echo '<p class="description">' . esc_html__( 'Indica qual segmento (cor) esta página representa. O menu mostra uma faixa com essa cor enquanto o visitante está nela.', 'objetivo' ) . '</p>';
}

function objetivo_save_segmento_meta( $post_id ) {
	if ( ! isset( $_POST['objetivo_segmento_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['objetivo_segmento_nonce'] ) ), 'objetivo_save_segmento' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['_objetivo_segmento_id'] ) ) {
		update_post_meta( $post_id, '_objetivo_segmento_id', absint( $_POST['_objetivo_segmento_id'] ) );
	}
}
add_action( 'save_post_page', 'objetivo_save_segmento_meta' );

/**
 * Segmento vinculado à página atual (se houver), usado pelo header para
 * desenhar a faixa colorida. Retorna null fora de páginas ou sem vínculo.
 */
function objetivo_get_current_segmento() {
	if ( ! is_page() ) {
		return null;
	}

	$segmento_id = get_post_meta( get_queried_object_id(), '_objetivo_segmento_id', true );
	if ( ! $segmento_id ) {
		return null;
	}

	$segmento = get_post( $segmento_id );
	if ( ! $segmento || 'objetivo_segmento' !== $segmento->post_type || 'publish' !== $segmento->post_status ) {
		return null;
	}

	return $segmento;
}
