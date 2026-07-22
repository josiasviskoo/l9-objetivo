<?php
/**
 * Customizer orientado a config: cada seção/campo abaixo vira
 * automaticamente uma add_section()/add_setting()/add_control(), evitando
 * repetir boilerplate para as dezenas de textos globais do layout (contato,
 * hero, estatísticas, textos de cada seção, rodapé, etc).
 *
 * Os "default" abaixo reproduzem o texto exato do layout aprovado — o site
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
				'whatsapp_display' => array( 'label' => __( 'WhatsApp (texto exibido)', 'objetivo' ), 'type' => 'text', 'default' => 'WhatsApp: (16) 3362-2600' ),
				'whatsapp_number'  => array( 'label' => __( 'WhatsApp (número com DDI, ex: 551633622600)', 'objetivo' ), 'type' => 'text', 'default' => '551633622600' ),
				'address_label'    => array( 'label' => __( 'Endereço/unidade (texto exibido)', 'objetivo' ), 'type' => 'text', 'default' => 'Unidade de São Carlos/SP' ),
				'atendimento_url'  => array( 'label' => __( 'Link "Atendimento"', 'objetivo' ), 'type' => 'url', 'default' => '#' ),
				'topbar_cta_label' => array( 'label' => __( 'Botão da barra superior (texto)', 'objetivo' ), 'type' => 'text', 'default' => 'Conheça o Objetivo' ),
				'topbar_cta_url'   => array( 'label' => __( 'Botão da barra superior (link)', 'objetivo' ), 'type' => 'url', 'default' => '#' ),
			),
		),
		'header'       => array(
			'title'  => __( 'Cabeçalho', 'objetivo' ),
			'fields' => array(
				'financeiro_url'      => array( 'label' => __( 'Link "Financeiro" (deixe em branco para ocultar o botão)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
				'area_restrita_url'   => array( 'label' => __( 'Link "Área Restrita" (deixe em branco para ocultar o botão)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
			),
		),
		'hero'         => array(
			'title'  => __( 'Hero (topo da home)', 'objetivo' ),
			'fields' => array(
				'tag'              => array( 'label' => __( 'Selo acima do título', 'objetivo' ), 'type' => 'text', 'default' => '✦ Matrículas Abertas 2027' ),
				'title'            => array( 'label' => __( 'Título (use <em>palavra</em> para destaque dourado e <br> para quebra de linha)', 'objetivo' ), 'type' => 'textarea', 'default' => 'Educação que<br>forma <em>campeões</em><br>e futuros líderes' ),
				'subtitle'         => array( 'label' => __( 'Subtítulo', 'objetivo' ), 'type' => 'textarea', 'default' => 'Da Educação Infantil ao Pré-Vestibular, o Objetivo oferece uma trajetória completa, construída sobre 60 anos de resultados comprovados e uma proposta pedagógica que transforma vidas.' ),
				'btn_primary_label' => array( 'label' => __( 'Botão principal (texto)', 'objetivo' ), 'type' => 'text', 'default' => 'Agende uma Visita' ),
				'btn_primary_url'   => array( 'label' => __( 'Botão principal (link)', 'objetivo' ), 'type' => 'url', 'default' => '#' ),
				'btn_outline_label' => array( 'label' => __( 'Botão secundário (texto)', 'objetivo' ), 'type' => 'text', 'default' => 'Conheça o Objetivo' ),
				'btn_outline_url'   => array( 'label' => __( 'Botão secundário (link)', 'objetivo' ), 'type' => 'url', 'default' => '#' ),
				'image_1'          => array( 'label' => __( 'Imagem 1', 'objetivo' ), 'type' => 'image', 'default' => 'https://www.objetivo.br/assets/img/photo/img-home-educacao-infantil.jpg' ),
				'image_2'          => array( 'label' => __( 'Imagem 2', 'objetivo' ), 'type' => 'image', 'default' => 'https://www.objetivo.br/assets/img/photo/img-home-ensino-fundamental.jpg' ),
			),
		),
		'stats'        => array(
			'title'  => __( 'Estatísticas', 'objetivo' ),
			'fields' => array(
				'stat1_num'   => array( 'label' => __( 'Estatística 1 — número', 'objetivo' ), 'type' => 'text', 'default' => '17.100+' ),
				'stat1_label' => array( 'label' => __( 'Estatística 1 — rótulo', 'objetivo' ), 'type' => 'text', 'default' => 'Medalhas em olimpíadas' ),
				'stat2_num'   => array( 'label' => __( 'Estatística 2 — número', 'objetivo' ), 'type' => 'text', 'default' => '1º' ),
				'stat2_label' => array( 'label' => __( 'Estatística 2 — rótulo', 'objetivo' ), 'type' => 'text', 'default' => 'Lugar no ENEM – SP' ),
				'stat3_num'   => array( 'label' => __( 'Estatística 3 — número', 'objetivo' ), 'type' => 'text', 'default' => '9×' ),
				'stat3_label' => array( 'label' => __( 'Estatística 3 — rótulo', 'objetivo' ), 'type' => 'text', 'default' => 'Melhor de São Paulo' ),
				'stat4_num'   => array( 'label' => __( 'Estatística 4 — número', 'objetivo' ), 'type' => 'text', 'default' => '100%' ),
				'stat4_label' => array( 'label' => __( 'Estatística 4 — rótulo', 'objetivo' ), 'type' => 'text', 'default' => 'Dedicação ao aluno' ),
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
		'egenio'       => array(
			'title'  => __( 'Seção: e-GENIO', 'objetivo' ),
			'fields' => array(
				'label'    => array( 'label' => __( 'Rótulo pequeno', 'objetivo' ), 'type' => 'text', 'default' => 'Tecnologia educacional' ),
				'title'    => array( 'label' => __( 'Título', 'objetivo' ), 'type' => 'textarea', 'default' => 'O <em>e-GENIO</em>: sua escola<br>também no digital' ),
				'desc_1'   => array( 'label' => __( 'Parágrafo 1', 'objetivo' ), 'type' => 'textarea', 'default' => 'A plataforma e-GENIO é o ambiente digital do Objetivo, um espaço integrado onde alunos acessam conteúdos, tarefas e resultados, e os responsáveis acompanham a evolução escolar em tempo real.' ),
				'desc_2'   => array( 'label' => __( 'Parágrafo 2', 'objetivo' ), 'type' => 'textarea', 'default' => 'Com recursos modernos e interface intuitiva, o e-GENIO une a excelência do ensino presencial à praticidade do digital, garantindo continuidade e engajamento no aprendizado.' ),
				'phone_title'    => array( 'label' => __( 'Cartão — título', 'objetivo' ), 'type' => 'text', 'default' => 'e-GENIO' ),
				'phone_subtitle' => array( 'label' => __( 'Cartão — subtítulo', 'objetivo' ), 'type' => 'textarea', 'default' => 'A plataforma digital do Objetivo para alunos, pais e educadores' ),
				'feature_1' => array( 'label' => __( 'Recurso 1', 'objetivo' ), 'type' => 'text', 'default' => '📖 Conteúdos e aulas digitais' ),
				'feature_2' => array( 'label' => __( 'Recurso 2', 'objetivo' ), 'type' => 'text', 'default' => '📊 Acompanhamento de desempenho' ),
				'feature_3' => array( 'label' => __( 'Recurso 3', 'objetivo' ), 'type' => 'text', 'default' => '👨‍👩‍👧 Portal para responsáveis' ),
				'feature_4' => array( 'label' => __( 'Recurso 4', 'objetivo' ), 'type' => 'text', 'default' => '🔔 Comunicados e avisos' ),
				'btn_label' => array( 'label' => __( 'Botão (texto)', 'objetivo' ), 'type' => 'text', 'default' => 'Conheça o e-GENIO' ),
				'btn_url'   => array( 'label' => __( 'Botão (link)', 'objetivo' ), 'type' => 'url', 'default' => '#' ),
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
				'cta_url'   => array( 'label' => __( 'Botão "Ver história completa" (link — crie a página com o modelo "Nossa História")', 'objetivo' ), 'type' => 'url', 'default' => '#' ),
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
		'convenio'      => array(
			'title'  => __( 'Faixa: Convênio', 'objetivo' ),
			'fields' => array(
				'label' => array( 'label' => __( 'Texto', 'objetivo' ), 'type' => 'text', 'default' => 'Seja uma Escola Conveniada do Sistema de Ensino Objetivo. Saiba mais' ),
				'url'   => array( 'label' => __( 'Link', 'objetivo' ), 'type' => 'url', 'default' => '#' ),
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
				'instagram_url' => array( 'label' => __( 'Instagram (deixe em branco para ocultar o ícone)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
				'facebook_url'  => array( 'label' => __( 'Facebook (deixe em branco para ocultar o ícone)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
				'youtube_url'   => array( 'label' => __( 'YouTube (deixe em branco para ocultar o ícone)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
				'linkedin_url'  => array( 'label' => __( 'LinkedIn (deixe em branco para ocultar o ícone)', 'objetivo' ), 'type' => 'url', 'default' => '' ),
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
