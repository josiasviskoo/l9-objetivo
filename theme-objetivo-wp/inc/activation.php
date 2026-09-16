<?php
/**
 * Ao ativar o tema, popula (uma única vez) os CPTs, categorias, páginas,
 * produtos WooCommerce de exemplo e o menu principal com o mesmo conteúdo
 * do layout aprovado em layout-apresentado/. Assim o site nasce idêntico à
 * referência e, a partir daí, tudo é editável pelo wp-admin.
 *
 * Idempotente: guarda a flag `objetivo_seeded_default_content` para nunca
 * duplicar conteúdo em reativações.
 *
 * IMPORTANTE: o seed não roda direto em `after_switch_theme` porque esse
 * hook dispara antes de `init` - ou seja, antes dos nossos CPTs e das
 * taxonomias do WooCommerce (product_cat, product_type) serem registrados.
 * Em vez disso, `after_switch_theme` só liga uma flag, e o seed de fato
 * roda no próximo `init` (prioridade 20, depois do WooCommerce registrar
 * tudo em prioridade padrão).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function objetivo_schedule_activation_seed() {
	if ( ! get_option( 'objetivo_seeded_default_content' ) ) {
		update_option( 'objetivo_do_seed', 1 );
	}
}
add_action( 'after_switch_theme', 'objetivo_schedule_activation_seed' );

function objetivo_maybe_run_activation_seed() {
	if ( ! get_option( 'objetivo_do_seed' ) || get_option( 'objetivo_seeded_default_content' ) ) {
		return;
	}

	objetivo_seed_cpt_content();
	objetivo_seed_blog_content();
	$sobre_id = objetivo_seed_sobre_page();
	$blog_id  = objetivo_seed_blog_page();
	objetivo_seed_menu( $sobre_id, $blog_id );

	if ( objetivo_is_woocommerce_active() ) {
		objetivo_seed_woocommerce_products();
	}

	delete_option( 'objetivo_do_seed' );
	update_option( 'objetivo_seeded_default_content', 1 );
}
add_action( 'init', 'objetivo_maybe_run_activation_seed', 20 );

/**
 * Correção pontual: antes de objetivo_insert_seed_item() checar duplicata
 * (ver commit), reseeds parciais (ex.: media_sideload_image travando por
 * imagem externa) podiam rodar objetivo_seed_cpt_content() mais de uma vez
 * e duplicar os cards. Roda uma vez, junta os posts com título repetido em
 * cada CPT (e nos produtos do WooCommerce, mesmo problema) e manda os
 * excedentes pra lixeira (mantém o mais antigo).
 *
 * v2: passou a cobrir também o post type 'product' - v1 só olhava os CPTs
 * do tema e deixou produtos duplicados (ex.: "Acampamento de Férias NR"
 * repetido no grid da loja) passar batido em sites onde v1 já tinha rodado.
 */
function objetivo_dedupe_seed_cpts() {
	if ( get_option( 'objetivo_deduped_seed_cpts_v2' ) ) {
		return;
	}

	$post_types = array_keys( objetivo_cpt_definitions() );
	if ( objetivo_is_woocommerce_active() ) {
		$post_types[] = 'product';
	}

	foreach ( $post_types as $post_type ) {
		$posts = get_posts( array(
			'post_type'      => $post_type,
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
			'orderby'        => 'ID',
			'order'          => 'ASC',
			'fields'         => 'ids',
		) );

		$seen_titles = array();
		foreach ( $posts as $post_id ) {
			$title = get_the_title( $post_id );
			if ( isset( $seen_titles[ $title ] ) ) {
				wp_trash_post( $post_id );
			} else {
				$seen_titles[ $title ] = $post_id;
			}
		}
	}

	update_option( 'objetivo_deduped_seed_cpts_v2', 1 );
}
add_action( 'init', 'objetivo_dedupe_seed_cpts', 21 );

/**
 * Sideload de uma imagem (por URL local do tema ou externa) para dentro da
 * Biblioteca de Mídia, definida como imagem destacada do post informado.
 */
/**
 * get_page_by_title() foi descontinuada no core (WP 6.2+) - este helper faz
 * a mesma checagem de "já existe post com este título" via WP_Query, que é
 * a substituição recomendada pelo próprio WordPress.
 */
function objetivo_find_post_by_title( $title, $post_type ) {
	$found = get_posts( array(
		'post_type'      => $post_type,
		'title'          => $title,
		'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
		'posts_per_page' => 1,
		'fields'         => 'ids',
	) );
	return $found ? (int) $found[0] : 0;
}

function objetivo_sideload_featured_image( $image_url, $post_id, $desc = '' ) {
	if ( ! function_exists( 'media_sideload_image' ) ) {
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
	}
	$attachment_id = media_sideload_image( $image_url, $post_id, $desc, 'id' );
	if ( ! is_wp_error( $attachment_id ) ) {
		set_post_thumbnail( $post_id, $attachment_id );
	}
}

function objetivo_insert_seed_item( $post_type, $title, $excerpt, $meta = array(), $order = 0, $image_url = '' ) {
	$existing_id = objetivo_find_post_by_title( $title, $post_type );
	if ( $existing_id ) {
		return $existing_id;
	}

	$post_id = wp_insert_post( array(
		'post_type'    => $post_type,
		'post_title'   => $title,
		'post_excerpt' => $excerpt,
		'post_content' => $excerpt,
		'post_status'  => 'publish',
		'menu_order'   => $order,
	) );

	if ( is_wp_error( $post_id ) || ! $post_id ) {
		return 0;
	}

	foreach ( $meta as $key => $value ) {
		update_post_meta( $post_id, $key, $value );
	}

	if ( $image_url ) {
		objetivo_sideload_featured_image( $image_url, $post_id, $title );
	}

	return $post_id;
}

/**
 * Marcos da linha do tempo "Nossa História" - CPT objetivo_timeline,
 * compartilhado pela seção da home (template-parts/front/timeline.php) e
 * pela página "Nossa História" (template-sobre.php). O rótulo curto de
 * cada bolinha (_dot_label) é o ano do marco, não uma palavra genérica -
 * ver objetivo_migrate_timeline_years() para a correção nos sites onde o
 * seed antigo (INÍCIO/AVANÇO/INOVAÇÃO/HOJE) já rodou.
 */
function objetivo_seed_timeline_content() {
	$timeline = array(
		array( 'Fundação', '1981', 'Fundação do Curso Pré-Vestibular', 'Início das atividades na Rua Bento Carlos. Logo depois, a unidade se mudou para a Rua 7 de Setembro e, posteriormente, para o endereço atual. Mesmo durante os períodos de reestruturação, as atividades jamais foram interrompidas.', false ),
		array( 'Expansão', '1981', 'Início do Ensino Médio', 'No mesmo ano, começou o funcionamento do Ensino Médio (1º, 2º e 3º ano), com a unidade funcionando perto da antiga FADISC - pioneirismo em estrutura de laboratórios de Física, Química e Biologia, além de um laboratório de Informática, novidade importante para a época.', false ),
		array( 'Expansão', '1999', 'Fundação da unidade Objetivo Jesuíno', 'Expansão da estrutura física com a criação de uma nova unidade.', false ),
		array( 'Crescimento', '2002', 'Fundação do Objetivo Júnior', 'A unidade atendia do Infantil até o 9º ano. Com o crescimento, houve a separação: o Fundamental II passou a funcionar no Objetivo Jesuíno, com a mudança do Objetivo Júnior para essa nova estrutura.', false ),
		array( 'Expansão', '2019', 'Objetivo Júnior - Unidade II', 'Fundação da segunda unidade do Objetivo Júnior, com início de funcionamento em 2020.', false ),
		array( 'Expansão', '2019', 'Objetivo Júnior Infantil', 'Fundação da unidade dedicada à Educação Infantil, com início de funcionamento em 2021.', false ),
		array( 'Presente', '2026', 'Objetivo São Carlos em constante crescimento', 'Mais de quatro décadas de história formando gerações, com unidades que atendem desde a Educação Infantil até o Pré-Vestibular. Com expansão contínua, investimentos em estrutura, revitalização dos espaços e compromisso com a excelência acadêmica, o Objetivo São Carlos mantém sua tradição de ensino forte, consolidando-se como referência na cidade.', true ),
	);
	foreach ( $timeline as $i => $item ) {
		list( $era, $dot, $title, $desc, $highlight ) = $item;
		objetivo_insert_seed_item( 'objetivo_timeline', $title, $desc, array(
			'_era_label'    => $era,
			'_dot_label'    => $dot,
			'_is_highlight' => $highlight ? '1' : '',
		), $i );
	}
}

/**
 * Correção pontual: a primeira versão do seed populava a linha do tempo
 * com 4 marcos genéricos (bolinhas INÍCIO/AVANÇO/INOVAÇÃO/HOJE) em vez dos
 * marcos reais do material enviado pelo cliente (ver Conteúdo das
 * Páginas/DOC/Aba site_ Sobre.docx). Em sites onde esse seed antigo já
 * rodou, os posts do CPT objetivo_timeline já existem no banco - só trocar
 * o array acima não muda o que já foi salvo. Aqui a gente manda os marcos
 * antigos pra lixeira e roda o seed de novo com o conteúdo real (7 marcos,
 * bolinha com o ano).
 */
function objetivo_migrate_timeline_years() {
	if ( get_option( 'objetivo_migrated_timeline_years_v1' ) ) {
		return;
	}

	$old_dot_labels = array( 'INÍCIO', 'AVANÇO', 'INOVAÇÃO', 'HOJE' );
	$all_items      = get_posts( array(
		'post_type'      => 'objetivo_timeline',
		'posts_per_page' => -1,
		'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
		'fields'         => 'ids',
	) );

	$has_old_content = false;
	foreach ( $all_items as $post_id ) {
		if ( in_array( get_post_meta( $post_id, '_dot_label', true ), $old_dot_labels, true ) ) {
			$has_old_content = true;
			break;
		}
	}

	if ( $has_old_content ) {
		foreach ( $all_items as $post_id ) {
			wp_trash_post( $post_id );
		}
		objetivo_seed_timeline_content();
	}

	update_option( 'objetivo_migrated_timeline_years_v1', 1 );
}
add_action( 'init', 'objetivo_migrate_timeline_years', 22 );

/**
 * Correção pontual: o seed antigo criava um card de selo "Unidade de São
 * Carlos/SP" na seção Motivos/Selos da home. Com o site passando a
 * representar várias unidades, esse card isolado não faz mais sentido ali
 * - foi removido do seed, e aqui a gente manda pra lixeira o que já tiver
 * sido criado em sites onde o seed antigo já rodou.
 */
function objetivo_migrate_remove_unidade_sc_selo() {
	if ( get_option( 'objetivo_migrated_remove_unidade_sc_selo_v1' ) ) {
		return;
	}

	$post_id = objetivo_find_post_by_title( 'Unidade de São Carlos/SP', 'objetivo_selo' );
	if ( $post_id ) {
		wp_trash_post( $post_id );
	}

	update_option( 'objetivo_migrated_remove_unidade_sc_selo_v1', 1 );
}
add_action( 'init', 'objetivo_migrate_remove_unidade_sc_selo', 22 );

/**
 * Correção pontual: o produto "e-GENIO" não existe mais - a seção da home
 * foi substituída por "Teste Vocacional" (ver
 * template-parts/front/teste-vocacional.php) e o item "e-GENIO" do submenu
 * "Objetivo" (renomeado para "Objetivo São Carlos") precisa virar "Teste
 * Vocacional", apontando para o subdomínio ov.objetivo.br. Só trocar os
 * valores em objetivo_seed_menu() não muda o menu "Principal" em sites onde
 * o seed antigo já rodou - aqui a gente renomeia os itens existentes.
 */
function objetivo_migrate_teste_vocacional_menu() {
	if ( get_option( 'objetivo_migrated_teste_vocacional_menu_v1' ) ) {
		return;
	}

	$menu = wp_get_nav_menu_object( 'Principal' );
	if ( $menu ) {
		$items = wp_get_nav_menu_items( $menu->term_id );
		foreach ( (array) $items as $item ) {
			if ( 'Objetivo' === $item->title && 0 === (int) $item->menu_item_parent ) {
				wp_update_nav_menu_item( $menu->term_id, $item->ID, array(
					'menu-item-title'  => 'Objetivo São Carlos',
					'menu-item-url'    => $item->url,
					'menu-item-status' => 'publish',
				) );
			} elseif ( 'e-GENIO' === $item->title ) {
				wp_update_nav_menu_item( $menu->term_id, $item->ID, array(
					'menu-item-title'     => 'Teste Vocacional',
					'menu-item-url'       => 'https://ov.objetivo.br/',
					'menu-item-parent-id' => $item->menu_item_parent,
					'menu-item-status'    => 'publish',
				) );
			}
		}
	}

	update_option( 'objetivo_migrated_teste_vocacional_menu_v1', 1 );
}
add_action( 'init', 'objetivo_migrate_teste_vocacional_menu', 22 );

/**
 * Correção pontual: os cards de "Prepare-se para as maiores provas" (CPT
 * objetivo_vestibular), o botão "Fique por Dentro", "Agende uma Visita",
 * "Desafio: Fund. e Médio" e os itens de menu correspondentes apontavam
 * para "#" - clicáveis, mas sem página de destino. Cria as páginas (ver
 * objetivo_seed_vestibulares_pages(), definida mais abaixo) e atualiza o
 * que já tiver sido semeado/criado em sites onde o seed antigo já rodou -
 * só trocar os valores no seed não muda posts/itens de menu existentes.
 */
function objetivo_migrate_fix_vestibular_matriculas_links() {
	if ( get_option( 'objetivo_migrated_fix_vestibular_matriculas_links_v1' ) ) {
		return;
	}

	$vest_pages        = objetivo_seed_vestibulares_pages();
	$vest_url_by_title = array(
		'Resoluções Comentadas' => ! empty( $vest_pages['resolucoes-comentadas'] ) ? get_permalink( $vest_pages['resolucoes-comentadas'] ) : '',
		'Simulados'             => ! empty( $vest_pages['simulados'] ) ? get_permalink( $vest_pages['simulados'] ) : '',
		'Aprovações'            => ! empty( $vest_pages['aprovacoes'] ) ? get_permalink( $vest_pages['aprovacoes'] ) : '',
		'Concurso de Bolsas'    => ! empty( $vest_pages['concurso-de-bolsas'] ) ? get_permalink( $vest_pages['concurso-de-bolsas'] ) : '',
	);
	foreach ( $vest_url_by_title as $title => $url ) {
		if ( ! $url ) {
			continue;
		}
		$post_id = objetivo_find_post_by_title( $title, 'objetivo_vestibular' );
		if ( $post_id ) {
			update_post_meta( $post_id, '_objetivo_url', $url );
		}
	}

	$menu_url_by_title = array(
		'Resoluções Comentadas'            => '/resolucoes-comentadas',
		'Simulados'                        => '/simulados',
		'Fique por Dentro'                 => '/fique-por-dentro',
		'Aprovações'                       => '/aprovacoes',
		'Agende uma Visita'                => 'https://wa.me/551633622600',
		'Desafio: Fundamental e Médio'     => '/desafio',
		'Concurso de Bolsas: Pré-Vestibular' => '/concurso-de-bolsas',
	);
	$menu = wp_get_nav_menu_object( 'Principal' );
	if ( $menu ) {
		$items = wp_get_nav_menu_items( $menu->term_id );
		foreach ( (array) $items as $item ) {
			if ( isset( $menu_url_by_title[ $item->title ] ) ) {
				wp_update_nav_menu_item( $menu->term_id, $item->ID, array(
					'menu-item-title'     => $item->title,
					'menu-item-url'       => $menu_url_by_title[ $item->title ],
					'menu-item-parent-id' => $item->menu_item_parent,
					'menu-item-status'    => 'publish',
				) );
			}
		}
	}

	update_option( 'objetivo_migrated_fix_vestibular_matriculas_links_v1', 1 );
}
add_action( 'init', 'objetivo_migrate_fix_vestibular_matriculas_links', 22 );

/**
 * Correção pontual: a seção "Navegue pelo seu segmento" trocou o fundo de
 * cor sólida por uma foto vertical com overlay na cor do segmento (ver
 * template-parts/front/segmentos.php) - em sites onde o CPT
 * objetivo_segmento já foi semeado sem imagem destacada, sideload aqui a
 * mesma foto usada no seed novo (objetivo_seed_cpt_content).
 */
function objetivo_migrate_segmento_images() {
	if ( get_option( 'objetivo_migrated_segmento_images_v1' ) ) {
		return;
	}

	$images = array(
		'Educação Infantil' => 'https://www.objetivo.br/assets/img/photo/img-home-educacao-infantil.jpg',
		'Fundamental I'     => 'https://www.objetivo.br/assets/img/photo/img-home-ensino-fundamental.jpg',
		'Fundamental II'    => 'https://www.objetivo.br/assets/img/photo/img-home-ensino-fundamental.jpg',
		'Ensino Médio'      => 'https://www.objetivo.br/assets/img/photo/img-home-ensino-medio.jpg',
		'Pré-Vestibular'    => 'https://www.objetivo.br/assets/img/photo/img-home-curso-objetivo.jpg',
	);

	foreach ( $images as $title => $url ) {
		$post_id = objetivo_find_post_by_title( $title, 'objetivo_segmento' );
		if ( $post_id && ! has_post_thumbnail( $post_id ) ) {
			objetivo_sideload_featured_image( $url, $post_id, $title );
		}
	}

	update_option( 'objetivo_migrated_segmento_images_v1', 1 );
}
add_action( 'init', 'objetivo_migrate_segmento_images', 22 );

function objetivo_seed_cpt_content() {
	// Banners do slider da home.
	$banners = array(
		array(
			'title' => 'Educação que forma campeões',
			'img'   => 'https://www.objetivo.br/assets/img/photo/img-home-educacao-infantil.jpg',
			'meta'  => array(),
		),
		array(
			'title' => 'Estrutura pensada para você',
			'img'   => 'https://www.objetivo.br/assets/img/photo/img-home-ensino-fundamental.jpg',
			'meta'  => array(),
		),
	);
	foreach ( $banners as $i => $banner ) {
		objetivo_insert_seed_item( 'objetivo_banner', $banner['title'], '', $banner['meta'], $i, $banner['img'] );
	}

	// Ensino.
	$ensino = array(
		array( 'Educação Infantil', 'A proposta educacional da Educação Infantil é sempre pautada pelo respeito à criança e pelo desenvolvimento integral desde os primeiros anos.', 'https://www.objetivo.br/assets/img/photo/img-home-educacao-infantil.jpg' ),
		array( 'Ensino Fundamental', 'Estimula a criatividade do aluno por meio de uma programação orientada que desenvolve habilidades cognitivas e socioemocionais.', 'https://www.objetivo.br/assets/img/photo/img-home-ensino-fundamental.jpg' ),
		array( 'Ensino Médio', 'Prepara o aluno de forma sólida para o ENEM e os principais vestibulares, com metodologia atualizada e corpo docente qualificado.', 'https://www.objetivo.br/assets/img/photo/img-home-ensino-medio.jpg' ),
		array( 'Pré-Vestibular', 'Estrutura completa para preparar o aluno para o ingresso na universidade, com resolução de provas e aprovações históricas.', 'https://www.objetivo.br/assets/img/photo/img-home-curso-objetivo.jpg' ),
	);
	foreach ( $ensino as $i => $item ) {
		list( $title, $desc, $img ) = $item;
		objetivo_insert_seed_item( 'objetivo_ensino', $title, $desc, array( '_badge_label' => $title, '_objetivo_url' => '#' ), $i, $img );
	}

	// Motivos.
	$motivos = array(
		array( '🥇', 'Mais de 17.100 medalhas e troféus em olimpíadas científicas', 'Tradição única de excelência acadêmica reconhecida em competições nacionais e internacionais.' ),
		array( '🎓', 'Aprovações nos principais vestibulares do país', 'USP, UNICAMP, FUVEST, ENEM: nossos alunos entram nas melhores universidades do Brasil.' ),
		array( '🏅', 'Primeiros lugares no ENEM em São Paulo', 'Resultado que consolida o Objetivo como referência em educação de alta performance.' ),
		array( '📚', 'Material didático em constante atualização', 'Conteúdo próprio, moderno e alinhado com as exigências dos exames atuais.' ),
		array( '👩‍🏫', 'Corpo docente em aperfeiçoamento contínuo', 'Professores qualificados e em constante capacitação para oferecer o melhor ensino.' ),
		array( '🏛️', 'Estrutura completa em nossas unidades', 'Laboratórios, bibliotecas, quadras e ambientes modernos que favorecem o aprendizado.' ),
	);
	foreach ( $motivos as $i => $item ) {
		list( $icon, $title, $desc ) = $item;
		objetivo_insert_seed_item( 'objetivo_motivo', $title, $desc, array( '_icon_emoji' => $icon ), $i );
	}

	// Selos. O card "Unidade de São Carlos/SP" foi removido daqui - com o
	// site agora representando várias unidades, esse card isolado não fazia
	// mais sentido nessa seção (ver objetivo_migrate_remove_unidade_sc_selo
	// para a limpeza em sites onde ele já tinha sido semeado).
	$selo1 = objetivo_insert_seed_item( 'objetivo_selo', '7 anos consecutivos: O Melhor de São Paulo', 'Colégio Objetivo vencedor por sete anos consecutivos do prêmio O Melhor de São Paulo na categoria Serviços.', array(), 0, objetivo_theme_image( 'selo-7-anos.png' ) );
	$selo2 = objetivo_insert_seed_item( 'objetivo_selo', '9 anos consecutivos: Curso Objetivo', 'Curso Objetivo vencedor por nove anos consecutivos do prêmio O Melhor de São Paulo na categoria Serviços.', array(), 1, objetivo_theme_image( 'selo-9-anos.png' ) );
	$selo3 = objetivo_insert_seed_item( 'objetivo_selo', '1º lugar no ENEM em São Paulo', 'O Objetivo ocupa o primeiro lugar no ENEM no Estado de São Paulo, comprovando décadas de dedicação à excelência.', array(), 2, objetivo_theme_image( 'selo-enem.png' ) );

	// Segmentos - foto vertical (formato retrato) com overlay na cor do
	// segmento; reaproveita as mesmas fotos reais já usadas no seed do
	// CPT objetivo_ensino, sideload feito por objetivo_insert_seed_item().
	$segmentos = array(
		array( 'Seg. Verde', 'Educação Infantil', 'Berçário ao Pré-escola · 0 a 5 anos', '#27ae60', '#2ecc71', 'https://www.objetivo.br/assets/img/photo/img-home-educacao-infantil.jpg' ),
		array( 'Seg. Laranja', 'Fundamental I', '1º ao 5º ano · 6 a 10 anos', '#e67e22', '#f39c12', 'https://www.objetivo.br/assets/img/photo/img-home-ensino-fundamental.jpg' ),
		array( 'Seg. Roxo', 'Fundamental II', '6º ao 9º ano · 11 a 14 anos', '#8e44ad', '#9b59b6', 'https://www.objetivo.br/assets/img/photo/img-home-ensino-fundamental.jpg' ),
		array( 'Seg. Azul', 'Ensino Médio', '1ª à 3ª série · ENEM & Vestibulares', '#1a4fac', '#1e8dc1', 'https://www.objetivo.br/assets/img/photo/img-home-ensino-medio.jpg' ),
		array( 'Seg. Vermelho', 'Pré-Vestibular', 'Aprovação nas melhores universidades', '#c0392b', '#e74c3c', 'https://www.objetivo.br/assets/img/photo/img-home-curso-objetivo.jpg' ),
	);
	foreach ( $segmentos as $i => $item ) {
		list( $badge, $title, $desc, $from, $to, $img ) = $item;
		objetivo_insert_seed_item( 'objetivo_segmento', $title, $desc, array(
			'_badge_label' => $badge,
			'_color_from'  => $from,
			'_color_to'    => $to,
			'_objetivo_url' => '#',
		), $i, $img );
	}

	// Timeline.
	objetivo_seed_timeline_content();

	// Vestibulares - cada card aponta pra sua própria página (ver
	// objetivo_seed_vestibulares_pages()), em vez do "#" de antes.
	$vest_pages = objetivo_seed_vestibulares_pages();
	$vestibular = array(
		array( '📝', 'Resoluções Comentadas', 'FUVEST, UNICAMP, ENEM e mais, resolvidas pelo nosso time de professores.', 'resolucoes-comentadas' ),
		array( '⏱️', 'Simulados', 'Treine em condições reais de prova com nossos simulados periódicos.', 'simulados' ),
		array( '🎉', 'Aprovações', 'Confira a lista histórica de alunos aprovados nas melhores universidades.', 'aprovacoes' ),
		array( '✅', 'Concurso de Bolsas', 'Inscreva-se no Concurso de Bolsas para o Pré-Vestibular Objetivo.', 'concurso-de-bolsas' ),
	);
	foreach ( $vestibular as $i => $item ) {
		list( $icon, $title, $desc, $slug ) = $item;
		$url = ! empty( $vest_pages[ $slug ] ) ? get_permalink( $vest_pages[ $slug ] ) : '#';
		objetivo_insert_seed_item( 'objetivo_vestibular', $title, $desc, array( '_icon_emoji' => $icon, '_objetivo_url' => $url ), $i );
	}
}

/**
 * Posts reais (categorias Notícias/Eventos/Resultados/Novidades) que
 * alimentam tanto o bloco "Últimas Notícias" (todos os posts) quanto o
 * "Novidades do Objetivo" da home (só os da categoria Novidades).
 */
function objetivo_seed_blog_content() {
	$categories = array(
		'noticias'   => 'Notícias',
		'eventos'    => 'Eventos',
		'resultados' => 'Resultados',
		'novidades'  => 'Novidades',
	);
	$cat_ids = array();
	foreach ( $categories as $slug => $name ) {
		$term = term_exists( $slug, 'category' );
		if ( ! $term ) {
			$term = wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
		}
		$cat_ids[ $slug ] = is_wp_error( $term ) ? 0 : (int) $term['term_id'];
	}

	$posts = array(
		array(
			'noticias',
			'Objetivo São Carlos: uma trajetória de conquistas e transformações',
			"O Colégio Objetivo São Carlos celebra uma jornada marcada por inovação pedagógica, resultados expressivos e um compromisso inabalável com a excelência educacional. Nossa instituição nunca deixou de reinventar seus métodos para acompanhar as transformações do mundo e as necessidades dos estudantes.\n\nAo longo dessa jornada, o Objetivo acumulou milhares de medalhas e troféus em olimpíadas científicas, conquistando posições de destaque no ENEM e reconhecimento pela qualidade de ensino.\n\nTemos orgulho de fazer parte da história de São Carlos, levando o método Objetivo e seus resultados comprovados para o interior do estado, formando gerações de estudantes que hoje ocupam posições de destaque nas melhores universidades e empresas do Brasil.",
		),
		array( array( 'noticias', 'novidades' ), '150 anos do Estadão e 60 anos do Objetivo: uma parceria marcada pela história', 'Duas instituições centenárias na educação e no jornalismo brasileiro celebram décadas de parceria dedicada à formação de leitores críticos e bem informados.' ),
		array( 'resultados', 'Alunos do Objetivo conquistam mais de 17.100 medalhas em olimpíadas científicas', 'O resultado consolida o Objetivo como uma das instituições mais premiadas do país em olimpíadas de conhecimento, fruto de um trabalho contínuo de incentivo à pesquisa e ao raciocínio científico.' ),
		array( 'resultados', 'Alunos conquistam medalhas na Olimpíada de Matemática', 'Mais uma turma de alunos do Objetivo São Carlos se destaca na Olimpíada Brasileira de Matemática, reforçando a tradição da escola em competições acadêmicas.' ),
		array( 'eventos', 'Aulão gratuito ENEM: inscrições abertas', 'O Objetivo São Carlos abre as inscrições para o aulão gratuito de revisão para o ENEM, aberto à comunidade e com professores especialistas em cada área do conhecimento.' ),
		array( 'eventos', 'Feira de Ciências reúne projetos inovadores', 'Alunos de todos os segmentos apresentaram projetos científicos desenvolvidos ao longo do ano na tradicional Feira de Ciências do Objetivo.' ),
		array( array( 'noticias', 'novidades' ), 'Nova parceria Objetivo & Estadão', 'A parceria amplia o acesso dos alunos a conteúdos jornalísticos de qualidade, incentivando a leitura crítica e a atualidade nos estudos.' ),
		array( 'resultados', 'Aprovações no vestibular FUVEST', 'Confira a lista de aprovados do Objetivo São Carlos na FUVEST, resultado de dedicação dos alunos e da metodologia consolidada do curso.' ),
	);

	foreach ( $posts as $i => $item ) {
		list( $cat_slugs, $title, $content ) = $item;
		if ( objetivo_find_post_by_title( $title, 'post' ) ) {
			continue;
		}
		$post_cats = array_map(
			function ( $slug ) use ( $cat_ids ) {
				return $cat_ids[ $slug ];
			},
			(array) $cat_slugs
		);
		$post_id = wp_insert_post( array(
			'post_type'    => 'post',
			'post_title'   => $title,
			'post_content' => $content,
			'post_excerpt' => wp_trim_words( $content, 24 ),
			'post_status'  => 'publish',
			'post_date'    => gmdate( 'Y-m-d H:i:s', strtotime( '-' . $i . ' days' ) ),
			'post_category' => $post_cats,
		) );
		if ( is_wp_error( $post_id ) ) {
			continue;
		}
	}
}

/**
 * Página "Nossa História" com o modelo de timeline completa.
 */
function objetivo_seed_sobre_page() {
	$existing = get_page_by_path( 'nossa-historia' );
	if ( $existing ) {
		return $existing->ID;
	}
	$page_id = wp_insert_post( array(
		'post_type'    => 'page',
		'post_title'   => 'Nossa História',
		'post_name'    => 'nossa-historia',
		'post_content' => '',
		'post_status'  => 'publish',
	) );
	if ( is_wp_error( $page_id ) || ! $page_id ) {
		return 0;
	}
	update_post_meta( $page_id, '_wp_page_template', 'template-sobre.php' );
	set_theme_mod( 'objetivo_sec_timeline_cta_url', get_permalink( $page_id ) );
	return $page_id;
}

/**
 * Página "Blog" com o modelo de listagem/filtro de posts.
 */
function objetivo_seed_blog_page() {
	$existing = get_page_by_path( 'blog' );
	if ( $existing ) {
		return $existing->ID;
	}
	$page_id = wp_insert_post( array(
		'post_type'    => 'page',
		'post_title'   => 'Blog',
		'post_name'    => 'blog',
		'post_content' => '',
		'post_status'  => 'publish',
	) );
	if ( is_wp_error( $page_id ) || ! $page_id ) {
		return 0;
	}
	update_post_meta( $page_id, '_wp_page_template', 'template-blog.php' );
	return $page_id;
}

/**
 * Cria (se ainda não existir) uma página simples com o template genérico
 * page.php - usada pelas páginas de destino dos cards de Vestibulares e do
 * botão "Desafio: Fund. e Médio", que antes apontavam para "#".
 */
function objetivo_seed_simple_page( $title, $slug, $content ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		return $existing->ID;
	}
	$page_id = wp_insert_post( array(
		'post_type'    => 'page',
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_content' => $content,
		'post_status'  => 'publish',
	) );
	return ( is_wp_error( $page_id ) || ! $page_id ) ? 0 : (int) $page_id;
}

/**
 * Páginas de destino da seção "Prepare-se para as maiores provas" (home) -
 * os 4 cards e o botão "Fique por Dentro" apontavam para "#". Retorna
 * slug => ID para quem for montar os links (seed do CPT e do menu).
 */
function objetivo_seed_vestibulares_pages() {
	$pages = array(
		'fique-por-dentro'      => array(
			'title'   => 'Fique por Dentro',
			'content' => '<p>Acompanhe de perto tudo o que você precisa saber sobre os principais vestibulares e o ENEM: resoluções comentadas, simulados periódicos e o histórico de aprovações dos alunos do Objetivo São Carlos.</p>'
				. '<ul><li><a href="/resolucoes-comentadas">Resoluções Comentadas</a></li><li><a href="/simulados">Simulados</a></li><li><a href="/aprovacoes">Aprovações</a></li><li><a href="/concurso-de-bolsas">Concurso de Bolsas</a></li></ul>',
		),
		'resolucoes-comentadas' => array(
			'title'   => 'Resoluções Comentadas',
			'content' => '<p>FUVEST, UNICAMP, ENEM e mais: as provas dos principais vestibulares do país, resolvidas e comentadas pelo nosso time de professores.</p>'
				. '<p>Em breve, novas resoluções serão publicadas nesta página.</p>',
		),
		'simulados'             => array(
			'title'   => 'Simulados',
			'content' => '<p>Treine em condições reais de prova com os simulados periódicos do Objetivo São Carlos, aplicados ao longo do ano para preparar o aluno para o dia da prova.</p>'
				. '<p>Em breve, o calendário de simulados será divulgado nesta página.</p>',
		),
		'aprovacoes'            => array(
			'title'   => 'Aprovações',
			'content' => '<p>Confira o histórico de alunos do Objetivo São Carlos aprovados nas melhores universidades do país - USP, UNICAMP, FUVEST e muito mais.</p>'
				. '<p>Em breve, a lista completa de aprovações estará disponível nesta página.</p>',
		),
		'concurso-de-bolsas'    => array(
			'title'   => 'Concurso de Bolsas',
			'content' => '<p>O Concurso de Bolsas do Objetivo São Carlos oferece descontos na mensalidade para novos alunos do 6º ano do Ensino Fundamental II e do 1º ano do Ensino Médio, de acordo com o número de acertos na prova.</p>'
				. '<p>As datas de inscrição, aulão preparatório e aplicação da prova para o próximo ano letivo serão divulgadas em breve. Para mais informações, fale com a nossa secretaria pelo WhatsApp.</p>'
				. '<p><a class="btn-navy" href="https://wa.me/551633622600" target="_blank" rel="noopener noreferrer">Falar no WhatsApp</a></p>',
		),
	);

	$ids = array();
	foreach ( $pages as $slug => $data ) {
		$ids[ $slug ] = objetivo_seed_simple_page( $data['title'], $slug, $data['content'] );
	}
	return $ids;
}

/**
 * Produtos de exemplo (excursões) no WooCommerce.
 */
function objetivo_seed_woocommerce_products() {
	$term = term_exists( 'Excursões e Passeios', 'product_cat' );
	if ( ! $term ) {
		$term = wp_insert_term( 'Excursões e Passeios', 'product_cat' );
	}
	$cat_id = is_wp_error( $term ) ? 0 : (int) $term['term_id'];

	$products = array(
		array( 'Acampamento de Férias NR', 1850.00, '15 a 20 de Julho, 2027', 'Cinco dias inesquecíveis no Acampamento NR. Inclui transporte, alimentação completa, monitoria especializada e atividades ao ar livre. Exclusivo para o Ensino Fundamental II.', objetivo_theme_image( 'acampamento.jpg' ) ),
		array( 'Museu de Zoologia USP', 120.00, '12 de Agosto, 2027', 'Uma viagem pela história evolutiva da biodiversidade. Transporte, lanche da tarde e ingressos inclusos. Atividade pedagógica obrigatória para alunos do 1º ano do Ensino Médio.', objetivo_theme_image( 'museu-zoologia.jpg' ) ),
		array( 'Hopi Hari - Diversão', 290.00, '10 de Outubro, 2027', 'Comemore a semana da criança com um dia inteiro de diversão no maior parque de diversões de São Paulo. Transporte e passaporte para todas as atrações inclusos.', objetivo_theme_image( 'hopi-hari.jpg' ) ),
	);

	foreach ( $products as $item ) {
		list( $title, $price, $date, $desc, $img ) = $item;

		if ( objetivo_find_post_by_title( $title, 'product' ) ) {
			continue;
		}

		$product_id = wp_insert_post( array(
			'post_type'    => 'product',
			'post_title'   => $title,
			'post_content' => $desc,
			'post_excerpt' => $desc,
			'post_status'  => 'publish',
		) );

		if ( is_wp_error( $product_id ) || ! $product_id ) {
			continue;
		}

		wp_set_object_terms( $product_id, 'simple', 'product_type' );
		if ( $cat_id ) {
			wp_set_object_terms( $product_id, array( $cat_id ), 'product_cat' );
		}

		update_post_meta( $product_id, '_regular_price', (string) $price );
		update_post_meta( $product_id, '_price', (string) $price );
		update_post_meta( $product_id, '_manage_stock', 'no' );
		update_post_meta( $product_id, '_stock_status', 'instock' );
		update_post_meta( $product_id, '_objetivo_event_date', $date );

		objetivo_sideload_featured_image( $img, $product_id, $title );
	}
}

/**
 * Menu principal com a mesma estrutura de dropdowns do layout aprovado.
 * Itens sem página real ficam com link "#" - o admin edita o destino em
 * Aparência → Menus assim que criar as páginas correspondentes.
 */
function objetivo_seed_menu( $sobre_id, $blog_id ) {
	if ( wp_get_nav_menu_object( 'Principal' ) ) {
		return;
	}

	$menu_id = wp_create_nav_menu( 'Principal' );
	if ( is_wp_error( $menu_id ) ) {
		return;
	}

	$add_item = function ( $title, $url, $parent = 0, $page_id = 0 ) use ( $menu_id ) {
		$args = array(
			'menu-item-title'     => $title,
			'menu-item-url'       => $url,
			'menu-item-parent-id' => $parent,
			'menu-item-status'    => 'publish',
		);
		// Item ligado a uma Página real: usa o tipo "post_type" para que o
		// link acompanhe automaticamente se a página for renomeada/movida.
		if ( $page_id ) {
			$args['menu-item-object-id'] = $page_id;
			$args['menu-item-object']    = 'page';
			$args['menu-item-type']      = 'post_type';
		}
		return wp_update_nav_menu_item( $menu_id, 0, $args );
	};

	$objetivo_top = $add_item( 'Objetivo São Carlos', '#' );
	$add_item( 'Sobre o Objetivo', $sobre_id ? get_permalink( $sobre_id ) : '#', $objetivo_top, $sobre_id );
	$add_item( 'Proposta Pedagógica', '#', $objetivo_top );
	$add_item( 'Teste Vocacional', 'https://ov.objetivo.br/', $objetivo_top );
	$add_item( 'Convênios', '#', $objetivo_top );
	$add_item( 'Unidade de São Carlos/SP', '#', $objetivo_top );
	$add_item( 'Nossos Resultados', '#', $objetivo_top );

	$ensino_top = $add_item( 'Ensino', '#' );
	$add_item( 'Educação Infantil', '#', $ensino_top );
	$add_item( 'Ensino Fundamental', '#', $ensino_top );
	$add_item( 'Ensino Médio', '#', $ensino_top );
	$add_item( 'Pré-Vestibular', '#', $ensino_top );

	$vest_top = $add_item( 'Vestibulares', '#' );
	$add_item( 'Resoluções Comentadas', '/resolucoes-comentadas', $vest_top );
	$add_item( 'Simulados', '/simulados', $vest_top );
	$add_item( 'Fique por Dentro', '/fique-por-dentro', $vest_top );
	$add_item( 'Aprovações', '/aprovacoes', $vest_top );

	$matriculas_top = $add_item( 'Matrículas', '#' );
	$add_item( 'Agende uma Visita', 'https://wa.me/551633622600', $matriculas_top );
	$add_item( 'Desafio: Fundamental e Médio', '/desafio', $matriculas_top );
	$add_item( 'Concurso de Bolsas: Pré-Vestibular', '/concurso-de-bolsas', $matriculas_top );

	$add_item( 'Blog', $blog_id ? get_permalink( $blog_id ) : '#', 0, $blog_id );

	$shop_id  = ( objetivo_is_woocommerce_active() && function_exists( 'wc_get_page_id' ) ) ? (int) wc_get_page_id( 'shop' ) : 0;
	$shop_url = $shop_id > 0 ? get_permalink( $shop_id ) : '#';
	// Objetivo: liga como item "page" real (não link custom) para que o
	// filtro objetivo_nav_menu_shop_class() reconheça e destaque o item.
	$add_item( 'Shop', $shop_url, 0, $shop_id > 0 ? $shop_id : 0 );

	$locations             = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}
