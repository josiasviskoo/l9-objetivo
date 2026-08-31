<?php
/**
 * Cria, dinamicamente, um Modelo de Página (Atributos da página → Modelo)
 * para cada item do CPT objetivo_segmento - o mesmo CPT usado na seção
 * "Navegue pelo seu segmento" da home, que já tem cor/ícone/rótulo geridos
 * em Segmentos por Cor no wp-admin. Não são arquivos físicos: o modelo
 * "aparece" na lista porque é injetado via theme_page_templates, e ao
 * escolher um deles a página renderiza normalmente (page.php) com uma
 * faixa fina no topo do header, na cor daquele segmento - sinalizando ao
 * visitante em qual ecossistema (Educação Infantil, Fundamental etc.) ele
 * está navegando. Como a lista vem do CPT, renomear/criar/excluir um
 * segmento em Segmentos por Cor atualiza os modelos disponíveis
 * automaticamente, sem precisar editar código.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Padrão do "arquivo" de modelo virtual: segmento-{ID do post do CPT}.php.
 */
function objetivo_segmento_template_slug( $segmento_id ) {
	return 'segmento-' . (int) $segmento_id . '.php';
}

/**
 * Injeta um modelo por segmento cadastrado na lista de "Atributos da
 * página → Modelo", com o próprio nome do segmento como rótulo.
 */
function objetivo_segmento_page_templates( $post_templates, $theme, $post, $post_type ) {
	if ( 'page' !== $post_type ) {
		return $post_templates;
	}

	foreach ( objetivo_get_items( 'objetivo_segmento' ) as $segmento ) {
		$post_templates[ objetivo_segmento_template_slug( $segmento->ID ) ] = get_the_title( $segmento );
	}

	return $post_templates;
}
add_filter( 'theme_page_templates', 'objetivo_segmento_page_templates', 10, 4 );

/**
 * Os modelos acima não existem como arquivo no tema - quando uma página usa
 * um deles, renderiza com o page.php normal (banner + conteúdo do editor).
 * A faixa de cor é adicionada à parte, pelo header (ver
 * objetivo_get_current_segmento() logo abaixo).
 */
function objetivo_segmento_template_include( $template ) {
	if ( ! is_page() ) {
		return $template;
	}

	$slug = get_page_template_slug( get_queried_object_id() );
	if ( $slug && preg_match( '/^segmento-\d+\.php$/', $slug ) ) {
		$page_template = locate_template( 'page.php' );
		if ( $page_template ) {
			return $page_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'objetivo_segmento_template_include' );

/**
 * Segmento vinculado à página atual (se houver), usado pelo header para
 * desenhar a faixa colorida. Resolve primeiro pelo Modelo de Página
 * (segmento-{ID}.php); se a página não usa nenhum desses modelos, cai para
 * o meta "_objetivo_segmento_id" - compatibilidade com páginas vinculadas
 * pelo seletor manual que existia antes deste recurso virar Modelo de
 * Página. Retorna null fora de páginas ou sem vínculo.
 */
function objetivo_get_current_segmento() {
	if ( ! is_page() ) {
		return null;
	}

	$post_id     = get_queried_object_id();
	$segmento_id = 0;

	$template_slug = get_page_template_slug( $post_id );
	if ( $template_slug && preg_match( '/^segmento-(\d+)\.php$/', $template_slug, $matches ) ) {
		$segmento_id = (int) $matches[1];
	}

	if ( ! $segmento_id ) {
		$segmento_id = (int) get_post_meta( $post_id, '_objetivo_segmento_id', true );
	}

	if ( ! $segmento_id ) {
		return null;
	}

	$segmento = get_post( $segmento_id );
	if ( ! $segmento || 'objetivo_segmento' !== $segmento->post_type || 'publish' !== $segmento->post_status ) {
		return null;
	}

	return $segmento;
}
