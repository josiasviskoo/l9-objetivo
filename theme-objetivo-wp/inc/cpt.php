<?php
/**
 * Registra os 6 Custom Post Types que tornam editável todo o conteúdo
 * repetível da home (cards de Ensino, Motivos, Selos, Segmentos, Timeline e
 * Vestibulares) — sem depender de nenhum plugin de campos.
 *
 * Cada item da config vira um CPT (via loop genérico) + um meta box (via
 * objetivo_register_cpt_meta_box(), de inc/meta-boxes.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fonte única de verdade: labels do CPT + campos meta extras de cada bloco.
 */
function objetivo_cpt_definitions() {
	return array(
		'objetivo_ensino'      => array(
			'singular'    => __( 'Card de Ensino', 'objetivo' ),
			'plural'      => __( 'Sistema de Ensino', 'objetivo' ),
			'menu_icon'   => 'dashicons-welcome-learn-more',
			'description' => __( 'Cards da seção "Conheça o Sistema de Ensino Objetivo" na home.', 'objetivo' ),
			'fields'      => array(
				array( 'key' => '_badge_label', 'label' => __( 'Rótulo do selo (badge sobre a imagem)', 'objetivo' ), 'type' => 'text', 'placeholder' => 'Educação Infantil' ),
				array( 'key' => '_objetivo_url', 'label' => __( 'Link "Saiba mais"', 'objetivo' ), 'type' => 'url' ),
			),
		),
		'objetivo_motivo'      => array(
			'singular'    => __( 'Motivo', 'objetivo' ),
			'plural'      => __( 'Motivos para Estudar', 'objetivo' ),
			'menu_icon'   => 'dashicons-awards',
			'description' => __( 'Itens da lista "Motivos para estudar no Objetivo".', 'objetivo' ),
			'fields'      => array(
				array( 'key' => '_icon_emoji', 'label' => __( 'Ícone (emoji)', 'objetivo' ), 'type' => 'text', 'placeholder' => '🥇' ),
			),
		),
		'objetivo_selo'        => array(
			'singular'    => __( 'Selo / Prêmio', 'objetivo' ),
			'plural'      => __( 'Selos e Prêmios', 'objetivo' ),
			'menu_icon'   => 'dashicons-star-filled',
			'description' => __( 'Cards de selos e prêmios ao lado da lista de Motivos.', 'objetivo' ),
			'fields'      => array(
				array( 'key' => '_icon_emoji', 'label' => __( 'Ícone (emoji) — usado se não houver imagem', 'objetivo' ), 'type' => 'text', 'placeholder' => '📍' ),
				array( 'key' => '_is_dark', 'label' => __( 'Estilo escuro', 'objetivo' ), 'type' => 'checkbox', 'description' => __( 'Usa o card azul-marinho (ex.: "Unidade de São Carlos").', 'objetivo' ) ),
				array( 'key' => '_objetivo_url', 'label' => __( 'Link (opcional)', 'objetivo' ), 'type' => 'url' ),
			),
		),
		'objetivo_segmento'    => array(
			'singular'    => __( 'Segmento', 'objetivo' ),
			'plural'      => __( 'Segmentos por Cor', 'objetivo' ),
			'menu_icon'   => 'dashicons-networking',
			'description' => __( 'Banners coloridos da seção "Navegue pelo seu segmento".', 'objetivo' ),
			'fields'      => array(
				array( 'key' => '_icon_emoji', 'label' => __( 'Ícone (emoji)', 'objetivo' ), 'type' => 'text', 'placeholder' => '🌱' ),
				array( 'key' => '_badge_label', 'label' => __( 'Rótulo do segmento', 'objetivo' ), 'type' => 'text', 'placeholder' => 'Seg. Verde' ),
				array( 'key' => '_color_from', 'label' => __( 'Cor do gradiente (início)', 'objetivo' ), 'type' => 'color', 'placeholder' => '#27ae60' ),
				array( 'key' => '_color_to', 'label' => __( 'Cor do gradiente (fim)', 'objetivo' ), 'type' => 'color', 'placeholder' => '#2ecc71' ),
				array( 'key' => '_objetivo_url', 'label' => __( 'Link "Ver conteúdos"', 'objetivo' ), 'type' => 'url' ),
			),
		),
		'objetivo_timeline'    => array(
			'singular'    => __( 'Marco da Timeline', 'objetivo' ),
			'plural'      => __( 'Nossa História (Timeline)', 'objetivo' ),
			'menu_icon'   => 'dashicons-clock',
			'description' => __( 'Marcos exibidos na timeline interativa "Nossa História".', 'objetivo' ),
			'fields'      => array(
				array( 'key' => '_era_label', 'label' => __( 'Categoria do marco', 'objetivo' ), 'type' => 'text', 'placeholder' => 'Fundação' ),
				array( 'key' => '_dot_label', 'label' => __( 'Rótulo curto na bolinha', 'objetivo' ), 'type' => 'text', 'placeholder' => 'INÍCIO' ),
				array( 'key' => '_is_highlight', 'label' => __( 'Destacar como marco atual', 'objetivo' ), 'type' => 'checkbox', 'description' => __( 'Usa o estilo dourado ("HOJE").', 'objetivo' ) ),
			),
		),
		'objetivo_vestibular'  => array(
			'singular'    => __( 'Card de Vestibular', 'objetivo' ),
			'plural'      => __( 'Cards de Vestibulares', 'objetivo' ),
			'menu_icon'   => 'dashicons-welcome-write-blog',
			'description' => __( 'Cards da seção "Prepare-se para as maiores provas".', 'objetivo' ),
			'fields'      => array(
				array( 'key' => '_icon_emoji', 'label' => __( 'Ícone (emoji)', 'objetivo' ), 'type' => 'text', 'placeholder' => '📝' ),
				array( 'key' => '_objetivo_url', 'label' => __( 'Link', 'objetivo' ), 'type' => 'url' ),
			),
		),
	);
}

function objetivo_register_cpts() {
	foreach ( objetivo_cpt_definitions() as $post_type => $def ) {
		register_post_type(
			$post_type,
			array(
				'labels'             => array(
					'name'               => $def['plural'],
					'singular_name'      => $def['singular'],
					'add_new_item'       => sprintf( __( 'Adicionar %s', 'objetivo' ), $def['singular'] ),
					'edit_item'          => sprintf( __( 'Editar %s', 'objetivo' ), $def['singular'] ),
					'new_item'           => sprintf( __( 'Novo %s', 'objetivo' ), $def['singular'] ),
					'view_item'          => sprintf( __( 'Ver %s', 'objetivo' ), $def['singular'] ),
					'all_items'          => $def['plural'],
					'search_items'       => sprintf( __( 'Buscar %s', 'objetivo' ), $def['plural'] ),
					'not_found'          => __( 'Nenhum item encontrado.', 'objetivo' ),
					'not_found_in_trash' => __( 'Nenhum item na lixeira.', 'objetivo' ),
				),
				'description'         => $def['description'],
				'public'               => false,
				'show_ui'              => true,
				'show_in_menu'         => true,
				'show_in_rest'         => true,
				'menu_icon'            => $def['menu_icon'],
				'menu_position'        => 25,
				'capability_type'      => 'post',
				'hierarchical'         => false,
				'has_archive'          => false,
				'publicly_queryable'   => false,
				'exclude_from_search'  => true,
				'supports'             => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			)
		);

		objetivo_register_cpt_meta_box( $post_type, $def['fields'], __( 'Detalhes', 'objetivo' ) . ' — ' . $def['singular'] );
	}
}
add_action( 'init', 'objetivo_register_cpts' );

/**
 * Ordena as listagens desses CPTs no admin por menu_order (permite
 * reordenar via "Atributos de página" sem precisar de plugin de drag&drop).
 */
function objetivo_cpt_admin_order( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	$post_type = $query->get( 'post_type' );
	if ( array_key_exists( $post_type, objetivo_cpt_definitions() ) ) {
		$query->set( 'orderby', 'menu_order title' );
		$query->set( 'order', 'ASC' );
	}
}
add_action( 'pre_get_posts', 'objetivo_cpt_admin_order' );

/**
 * Helper de consulta: retorna os posts publicados de um dos CPTs do tema,
 * já ordenados por menu_order — usado pelos template-parts da home.
 */
function objetivo_get_items( $post_type, $limit = -1 ) {
	return get_posts(
		array(
			'post_type'      => $post_type,
			'posts_per_page' => $limit,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'post_status'    => 'publish',
		)
	);
}
