<?php
/**
 * Customizer orientado a config: cada seção/campo abaixo vira
 * automaticamente uma add_section()/add_setting()/add_control(), evitando
 * repetir boilerplate para as dezenas de textos globais do layout (contato,
 * hero, estatísticas, textos de cada seção, rodapé, etc).
 *
 * Os "default" abaixo reproduzem o texto exato do layout aprovado - o site
 * já nasce idêntico à referência e o cliente edita tudo depois pelo
 * Personalizar (Aparência → Personalizar) sem precisar de desenvolvedor.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function objetivo_customizer_definitions() {
	return array(
		'contato'      => array(
			'title'  => __( 'Contato', 'objetivo' ),
			'fields' => array(
				'phone_display'    => array( 'label' => __( 'Telefone (texto exibido)', 'objetivo' ), 'type' => 'text', 'default' => '(16) 3374-5001' ),
				'phone_tel'        => array( 'label' => __( 'Telefone (somente números, para o link tel:)', 'objetivo' ), 'type' => 'text', 'default' => '1633745001' ),
				'whatsapp_display'        => array( 'label' => __( 'WhatsApp Objetivo - unidade normal (texto exibido)', 'objetivo' ), 'type' => 'text', 'default' => 'WhatsApp Objetivo: (16) 3362-2600' ),
				'whatsapp_number'         => array( 'label' => __( 'WhatsApp Objetivo - unidade normal (número com DDI, ex: 551633622600)', 'objetivo' ), 'type' => 'text', 'default' => '551633622600' ),
				'whatsapp_junior_display' => array( 'label' => __( 'WhatsApp Objetivo Júnior (texto exibido)', 'objetivo' ), 'type' => 'text', 'default' => '' ),
				'whatsapp_junior_number'  => array( 'label' => __( 'WhatsApp Objetivo Júnior (número com DDI, ex: 551633622600)', 'objetivo' ), 'type' => 'text', 'default' => '' ),
				'address_label'    => array( 'label' => __( 'Endereço/unidade (texto exibido)', 'objetivo' ), 'type' => 'text', 'default' => 'Unidade de São Carlos/SP' ),
				'atendimento_url'  => array( 'label' => __( 'Link "Central de Atendimento" (rodapé)', 'objetivo' ), 'type' => 'url', 'default' => '#' ),
				'topbar_cta_label' => array( 'label' => __( 'Botão da barra superior (texto)', 'objetivo' ), 'type' => 'text', 'default' => 'Conheça o Objetivo' ),
				'topbar_cta_url'   => array( 'label' => __( 'Botão da barra superior (link)', 'objetivo' ), 'type' => 'url', 'default' => '#' ),
				'matriculas_label' => array( 'label' => __( 'Botão "Matrículas e Transferências" (texto)', 'objetivo' ), 'type' => 'text', 'default' => 'Matrículas e Transferências' ),
				'matriculas_url'   => array( 'label' => __( 'Botão "Matrículas e Transferências" (link - landing page do Objetivo Conecta)', 'objetivo' ), 'type' => 'url', 'default' => 'https://www.objetivosaocarlos.com.br/captacao/' ),
			),
		),
		'header'       => array(
			'title'  => __( 'Cabeçalho', 'objetivo' ),
			'fields' => array(
				'financeiro_url'      => array( 'label' => __( 'Link "Financeiro" (deixe em branco para ocultar o botão)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
				'area_restrita_url'   => array( 'label' => __( 'Link "Área Restrita" (deixe em branco para ocultar o botão)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
			),
		),
		'stats'        => array(
			'title'  => __( 'Estatísticas', 'objetivo' ),
			'fields' => array(
				'stat1_num'   => array( 'label' => __( 'Estatística 1 - número', 'objetivo' ), 'type' => 'text', 'default' => '17.100+' ),
				'stat1_label' => array( 'label' => __( 'Estatística 1 - rótulo', 'objetivo' ), 'type' => 'text', 'default' => 'Medalhas em olimpíadas' ),
				'stat2_num'   => array( 'label' => __( 'Estatística 2 - número', 'objetivo' ), 'type' => 'text', 'default' => '1º' ),
				'stat2_label' => array( 'label' => __( 'Estatística 2 - rótulo', 'objetivo' ), 'type' => 'text', 'default' => 'Lugar no ENEM – SP' ),
				'stat3_num'   => array( 'label' => __( 'Estatística 3 - número', 'objetivo' ), 'type' => 'text', 'default' => '9×' ),
				'stat3_label' => array( 'label' => __( 'Estatística 3 - rótulo', 'objetivo' ), 'type' => 'text', 'default' => 'Melhor de São Paulo' ),
				'stat4_num'   => array( 'label' => __( 'Estatística 4 - número', 'objetivo' ), 'type' => 'text', 'default' => '100%' ),
				'stat4_label' => array( 'label' => __( 'Estatística 4 - rótulo', 'objetivo' ), 'type' => 'text', 'default' => 'Dedicação ao aluno' ),
			),
		),
		'sec_ensino'   => array(
			'title'  => __( 'Seção: Sistema de Ensino', 'objetivo' ),
			'fields' => array(
				'label' => array( 'label' => __( 'Rótulo pequeno', 'objetivo' ), 'type' => 'text', 'default' => 'Sistema de Ensino' ),
				'title' => array( 'label' => __( 'Título', 'objetivo' ), 'type' => 'text', 'default' => 'Conheça o Sistema de Ensino <em>Objetivo</em>' ),
				'desc'  => array( 'label' => __( 'Descrição', 'objetivo' ), 'type' => 'textarea', 'default' => 'Da primeira infância à aprovação na universidade: uma jornada completa de aprendizado e crescimento.' ),
			),
		),
		'sec_motivos'  => array(
			'title'  => __( 'Seção: Motivos', 'objetivo' ),
			'fields' => array(
				'label' => array( 'label' => __( 'Rótulo pequeno', 'objetivo' ), 'type' => 'text', 'default' => 'Por que escolher o Objetivo' ),
				'title' => array( 'label' => __( 'Título', 'objetivo' ), 'type' => 'textarea', 'default' => 'Motivos para estudar<br>no <em>Objetivo</em>' ),
			),
		),
		'sec_unidades' => array(
			'title'  => __( 'Seção: Carrossel de Unidades', 'objetivo' ),
			'fields' => array(
				'label' => array( 'label' => __( 'Rótulo pequeno', 'objetivo' ), 'type' => 'text', 'default' => 'Objetivo São Carlos' ),
				'title' => array( 'label' => __( 'Título', 'objetivo' ), 'type' => 'text', 'default' => 'Uma unidade para cada etapa da <em>jornada</em>' ),
				'desc'  => array( 'label' => __( 'Descrição', 'objetivo' ), 'type' => 'textarea', 'default' => 'Seis unidades em São Carlos/SP, do Infantil ao Pré-Vestibular - cada uma com estrutura dedicada à sua etapa de ensino.' ),
			),
		),
		'sec_vest'     => array(
			'title'  => __( 'Seção: Vestibulares', 'objetivo' ),
			'fields' => array(
				'label'    => array( 'label' => __( 'Rótulo pequeno', 'objetivo' ), 'type' => 'text', 'default' => 'Vestibulares & ENEM' ),
				'title'    => array( 'label' => __( 'Título', 'objetivo' ), 'type' => 'textarea', 'default' => 'Prepare-se para<br>as maiores provas' ),
				'desc'     => array( 'label' => __( 'Descrição', 'objetivo' ), 'type' => 'textarea', 'default' => 'Acesse resoluções comentadas, simulados e tudo sobre os principais vestibulares do Brasil. O Objetivo coloca você à frente.' ),
				'btn_label' => array( 'label' => __( 'Botão (texto)', 'objetivo' ), 'type' => 'text', 'default' => 'Fique por Dentro' ),
				'btn_url'   => array( 'label' => __( 'Botão (link)', 'objetivo' ), 'type' => 'url', 'default' => '#' ),
			),
		),
		'matriculas'   => array(
			'title'  => __( 'Faixa: Matrículas Abertas', 'objetivo' ),
			'fields' => array(
				'title'      => array( 'label' => __( 'Título', 'objetivo' ), 'type' => 'text', 'default' => 'Matrículas abertas para 2027!' ),
				'desc'       => array( 'label' => __( 'Descrição', 'objetivo' ), 'type' => 'textarea', 'default' => 'Venha conhecer a estrutura do Objetivo e garantir a vaga do seu filho. Agende uma visita hoje mesmo.' ),
				'btn1_label' => array( 'label' => __( 'Botão 1 (texto)', 'objetivo' ), 'type' => 'text', 'default' => 'Agendar Visita' ),
				'btn1_url'   => array( 'label' => __( 'Botão 1 (link)', 'objetivo' ), 'type' => 'url', 'default' => '#' ),
				'btn2_label' => array( 'label' => __( 'Botão 2 (texto)', 'objetivo' ), 'type' => 'text', 'default' => 'Desafio – Fund. e Médio' ),
				'btn2_url'   => array( 'label' => __( 'Botão 2 (link)', 'objetivo' ), 'type' => 'url', 'default' => '#' ),
			),
		),
		'sec_teste_vocacional' => array(
			'title'  => __( 'Seção: Teste Vocacional', 'objetivo' ),
			'fields' => array(
				'title'     => array( 'label' => __( 'Título (aceita <em> para a palavra dourada e <br> para quebra de linha)', 'objetivo' ), 'type' => 'textarea', 'default' => 'Descubra sua<br><em>Vocação</em><br>Profissional' ),
				'desc'      => array( 'label' => __( 'Descrição (aceita <strong> para negrito)', 'objetivo' ), 'type' => 'textarea', 'default' => 'Orientação vocacional baseada nos modelos científicos <strong>RIASEC (Holland)</strong> e <strong>Inteligências Múltiplas (Gardner)</strong>, com apoio de inteligência artificial para uma orientação completamente personalizada.' ),
				'btn_label' => array( 'label' => __( 'Botão (texto)', 'objetivo' ), 'type' => 'text', 'default' => 'Iniciar Orientação Vocacional' ),
				'btn_url'   => array( 'label' => __( 'Botão (link)', 'objetivo' ), 'type' => 'url', 'default' => 'https://ov.objetivo.br/' ),
			),
		),
		'sec_noticias' => array(
			'title'  => __( 'Seção: Últimas Notícias', 'objetivo' ),
			'fields' => array(
				'label'          => array( 'label' => __( 'Rótulo pequeno', 'objetivo' ), 'type' => 'text', 'default' => 'Acontece no Objetivo' ),
				'title'          => array( 'label' => __( 'Título', 'objetivo' ), 'type' => 'text', 'default' => 'Últimas <em>Notícias</em>' ),
				'ver_todas_label' => array( 'label' => __( 'Link "Ver todas" (texto)', 'objetivo' ), 'type' => 'text', 'default' => 'Ver todas' ),
			),
		),
		'sec_segmentos' => array(
			'title'  => __( 'Seção: Segmentos por Cor', 'objetivo' ),
			'fields' => array(
				'label' => array( 'label' => __( 'Rótulo pequeno', 'objetivo' ), 'type' => 'text', 'default' => 'Ecossistemas por Segmento' ),
				'title' => array( 'label' => __( 'Título', 'objetivo' ), 'type' => 'text', 'default' => 'Navegue pelo seu <em>segmento</em>' ),
				'desc'  => array( 'label' => __( 'Descrição', 'objetivo' ), 'type' => 'textarea', 'default' => 'Cada etapa de ensino tem sua própria identidade visual. Clique para explorar o ecossistema de conteúdo que corresponde ao seu momento.' ),
			),
		),
		'sec_timeline'  => array(
			'title'  => __( 'Seção: Nossa História (Timeline)', 'objetivo' ),
			'fields' => array(
				'label'    => array( 'label' => __( 'Rótulo pequeno', 'objetivo' ), 'type' => 'text', 'default' => 'Nossa Trajetória' ),
				'title'    => array( 'label' => __( 'Título', 'objetivo' ), 'type' => 'text', 'default' => 'Nossa <em>História</em>' ),
				'desc'     => array( 'label' => __( 'Descrição', 'objetivo' ), 'type' => 'textarea', 'default' => 'Conheça a história de excelência e tradição do Objetivo em São Carlos.' ),
				'cta_label' => array( 'label' => __( 'Botão "Ver história completa" (texto)', 'objetivo' ), 'type' => 'text', 'default' => 'Ver história completa' ),
				'cta_url'   => array( 'label' => __( 'Botão "Ver história completa" (link - crie a página com o modelo "Nossa História")', 'objetivo' ), 'type' => 'url', 'default' => '#' ),
			),
		),
		'sec_blog'      => array(
			'title'  => __( 'Seção: Blog/Novidades', 'objetivo' ),
			'fields' => array(
				'label' => array( 'label' => __( 'Rótulo pequeno', 'objetivo' ), 'type' => 'text', 'default' => 'Blog e Notícias' ),
				'title' => array( 'label' => __( 'Título', 'objetivo' ), 'type' => 'text', 'default' => 'Novidades do <em>Objetivo</em>' ),
				'desc'  => array( 'label' => __( 'Descrição curta', 'objetivo' ), 'type' => 'textarea', 'default' => 'Fique por dentro das novidades, resultados e eventos do Objetivo São Carlos.' ),
			),
		),
		'shop'          => array(
			'title'  => __( 'Loja (Objetivo Shop)', 'objetivo' ),
			'fields' => array(
				'title'    => array( 'label' => __( 'Título do topo da loja', 'objetivo' ), 'type' => 'text', 'default' => 'Objetivo <em>Shop</em>' ),
				'subtitle' => array( 'label' => __( 'Subtítulo', 'objetivo' ), 'type' => 'textarea', 'default' => 'Adquira pacotes de excursões, passeios escolares e eventos exclusivos para nossos alunos de forma rápida e segura.' ),
			),
		),
		'footer'        => array(
			'title'  => __( 'Rodapé', 'objetivo' ),
			'fields' => array(
	'brand_desc'    => array( 'label' => __( 'Descrição da marca', 'objetivo' ), 'type' => 'textarea', 'default' => 'Transformando vidas por meio da educação de excelência, da Educação Infantil ao Pré-Vestibular.' ),
				// Linha de cima dos ícones sociais: Objetivo (unidade normal).
				'instagram_url' => array( 'label' => __( 'Objetivo - Instagram (deixe em branco para ocultar o ícone)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
				'facebook_url'  => array( 'label' => __( 'Objetivo - Facebook (deixe em branco para ocultar o ícone)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
				'threads_url'   => array( 'label' => __( 'Objetivo - Threads (deixe em branco para ocultar o ícone)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
				'youtube_url'   => array( 'label' => __( 'Objetivo - YouTube (deixe em branco para ocultar o ícone)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
				'linkedin_url'  => array( 'label' => __( 'Objetivo - LinkedIn (deixe em branco para ocultar o ícone)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
				// Linha de baixo: Objetivo Júnior (alinhada com a de cima -
				// mesma ordem Instagram/Facebook/Threads, sem YouTube/LinkedIn).
				'instagram_junior_url' => array( 'label' => __( 'Objetivo Júnior - Instagram (deixe em branco para ocultar o ícone)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
				'facebook_junior_url'  => array( 'label' => __( 'Objetivo Júnior - Facebook (deixe em branco para ocultar o ícone)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
				'threads_junior_url'   => array( 'label' => __( 'Objetivo Júnior - Threads (deixe em branco para ocultar o ícone)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
				'copyright'     => array( 'label' => __( 'Texto de copyright (o ano atual é adicionado automaticamente antes)', 'objetivo' ), 'type' => 'text', 'default' => 'Colégio e Cursinho Objetivo. Todos os direitos reservados.' ),
				'developed_by'     => array( 'label' => __( 'Desenvolvido por (nome)', 'objetivo' ), 'type' => 'text', 'default' => 'L9 Propaganda' ),
				'developed_by_url' => array( 'label' => __( 'Desenvolvido por (link)', 'objetivo' ), 'type' => 'url', 'default' => 'https://l9propaganda.com.br/' ),
			),
		),
	);
}

function objetivo_customizer_sanitizer( $type ) {
	switch ( $type ) {
		case 'url':
		case 'image':
			return 'esc_url_raw';
		case 'checkbox':
			return 'objetivo_sanitize_checkbox';
		case 'color':
			return 'sanitize_hex_color';
		case 'textarea':
		case 'text':
		default:
			return 'objetivo_sanitize_rich_text';
	}
}

function objetivo_sanitize_checkbox( $checked ) {
	return ( isset( $checked ) && true === (bool) $checked ) ? true : false;
}

function objetivo_sanitize_rich_text( $value ) {
	return wp_kses( $value, array(
		'em'     => array(),
		'br'     => array(),
		'strong' => array(),
	) );
}

function objetivo_customize_register( $wp_customize ) {
	$wp_customize->add_panel( 'objetivo_panel', array(
		'title'    => __( 'Conteúdo do site Objetivo', 'objetivo' ),
		'priority' => 30,
	) );

	$priority = 10;
	foreach ( objetivo_customizer_definitions() as $section_id => $section ) {
		$wp_customize->add_section( 'objetivo_' . $section_id, array(
			'title'    => $section['title'],
			'panel'    => 'objetivo_panel',
			'priority' => $priority,
		) );
		$priority += 10;

		foreach ( $section['fields'] as $field_key => $field ) {
			$setting_id = 'objetivo_' . $section_id . '_' . $field_key;

			$wp_customize->add_setting( $setting_id, array(
				'default'           => $field['default'] ?? '',
				'sanitize_callback' => objetivo_customizer_sanitizer( $field['type'] ),
				'transport'         => 'refresh',
			) );

			$control_args = array(
				'label'   => $field['label'],
				'section' => 'objetivo_' . $section_id,
			);

			if ( 'image' === $field['type'] ) {
				$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $setting_id, $control_args ) );
			} elseif ( 'color' === $field['type'] ) {
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting_id, $control_args ) );
			} else {
				$control_args['type'] = ( 'checkbox' === $field['type'] ) ? 'checkbox' : ( ( 'textarea' === $field['type'] ) ? 'textarea' : 'text' );
				$wp_customize->add_control( $setting_id, $control_args );
			}
		}
	}
}
add_action( 'customize_register', 'objetivo_customize_register' );

/**
 * Getter único usado em todos os templates: objetivo_opt( 'hero', 'title' ).
 * Busca o default direto da config, então nenhum template precisa repetir
 * os textos originais do layout.
 */
function objetivo_opt( $section_id, $field_key ) {
	static $defs = null;
	if ( null === $defs ) {
		$defs = objetivo_customizer_definitions();
	}
	$default = $defs[ $section_id ]['fields'][ $field_key ]['default'] ?? '';
	return get_theme_mod( 'objetivo_' . $section_id . '_' . $field_key, $default );
}
