<?php
/**
 * Theme supports, menus, widgets e enqueue de assets.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function objetivo_setup() {
	load_theme_textdomain( 'objetivo', OBJETIVO_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	// Logo com altura fixa (96px, 2x o tamanho exibido no header) e largura
	// livre - evita distorcer logos mais compridas/estreitas ao redimensionar
	// para caber na altura padrão do cabeçalho (ver .logo img em style-main.css).
	add_theme_support( 'custom-logo', array(
		'height'      => 96,
		'width'       => 400,
		'flex-height' => false,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
		'navigation-widgets',
	) );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );

	set_post_thumbnail_size( 640, 480, true );
	add_image_size( 'objetivo-card', 640, 400, true );
	add_image_size( 'objetivo-hero', 900, 1000, true );
	// Formato vertical (3:4) para os cards de "Navegue pelo seu segmento" -
	// o gradiente de cor de cada segmento fica na base do card, então a
	// imagem funciona melhor alta/vertical (retrato) do que larga.
	add_image_size( 'objetivo-segmento', 480, 640, true );
	// Dimensão única para todas as fotos do blog/notícias (cards e capa do
	// post): crop centralizado em 1920x1080, sempre a mesma proporção 16:9
	// nos cards, na listagem e na página do artigo. Corte real (não é
	// "sem cortar") - por isso, ao subir a foto, enquadre com margem de
	// segurança (elementos importantes centralizados, longe das bordas)
	// para nada essencial ficar de fora do corte 16:9.
	add_image_size( 'objetivo-post-cover', 1920, 1080, true );
	// crop = false: só redimensiona (sem cortar) - o banner precisa mostrar a
	// imagem inteira, nunca uma versão mascarada/cortada dela.
	add_image_size( 'objetivo-banner', 1920, 800, false );
	add_image_size( 'objetivo-banner-mobile', 960, 1280, false );

	// O rodapé não tem locations próprias: ele reaproveita o mesmo menu
	// "primary" (ver footer.php), assim a estrutura do topo e do rodapé
	// nunca ficam fora de sincronia - o admin edita só o menu "Principal".
	register_nav_menus( array(
		'primary' => __( 'Principal (cabeçalho e rodapé)', 'objetivo' ),
		'topbar'  => __( 'Barra superior', 'objetivo' ),
	) );
}
add_action( 'after_setup_theme', 'objetivo_setup' );

/**
 * Destaque de item de menu via hífens: em Aparência → Menus, o admin digita
 * o rótulo do item como "--Exame de Bolsas--" e o tema exibe só "Exame de
 * Bolsas" (sem os hifens), marcando o <li> com a classe "menu-item-destaque"
 * (ver .menu-item-destaque em style-main.css). Funciona em qualquer
 * wp_nav_menu() do tema - principal, rodapé, topbar.
 */
function objetivo_highlight_menu_items( $items ) {
	foreach ( $items as $item ) {
		if ( preg_match( '/^--(.+)--$/', trim( $item->title ), $matches ) ) {
			$item->title      = trim( $matches[1] );
			$item->classes[]  = 'menu-item-destaque';
		}
	}
	return $items;
}
add_filter( 'wp_nav_menu_objects', 'objetivo_highlight_menu_items' );

/**
 * Larguras de conteúdo usadas por embeds/oEmbed.
 */
function objetivo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'objetivo_content_width', 1260 );
}
add_action( 'after_setup_theme', 'objetivo_content_width', 0 );

/**
 * Widget areas - usadas como reforço opcional em páginas genéricas/blog.
 */
function objetivo_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Barra lateral do Blog', 'objetivo' ),
		'id'            => 'sidebar-blog',
		'description'   => __( 'Aparece em páginas de artigo e listagem do blog.', 'objetivo' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'objetivo_widgets_init' );

/**
 * Assets (CSS/JS).
 */
function objetivo_enqueue_assets() {
	wp_enqueue_style(
		'objetivo-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'objetivo-main',
		OBJETIVO_THEME_URI . '/assets/css/style-main.css',
		array( 'objetivo-fonts' ),
		OBJETIVO_THEME_VERSION
	);

	wp_enqueue_script(
		'objetivo-main',
		OBJETIVO_THEME_URI . '/assets/js/main.js',
		array(),
		OBJETIVO_THEME_VERSION,
		true
	);

	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
// Prioridade 20: garante que nosso CSS seja enfileirado (e impresso) depois
// do CSS padrão do WooCommerce (prioridade 10), para que nossas cores/estilos
// de marca vençam a cascata sem precisar de !important em tudo.
add_action( 'wp_enqueue_scripts', 'objetivo_enqueue_assets', 20 );

/**
 * Helper: emite um bloco de texto vindo do Customizer permitindo <em>/<strong>
 * para destaque de palavra (usado em títulos "Sistema de Ensino
 * <em>Objetivo</em>" e em parágrafos com termos em negrito).
 */
function objetivo_kses_em( $text ) {
	return wp_kses( $text, array( 'em' => array(), 'strong' => array(), 'br' => array() ) );
}

/**
 * Helper: URL de imagem padrão do tema (fallback quando o CPT não tem
 * imagem destacada definida - nunca deveria acontecer após o seed, mas
 * evita <img src=""> quebrado se o admin remover a imagem).
 */
function objetivo_theme_image( $filename ) {
	return OBJETIVO_THEME_URI . '/assets/img/' . ltrim( $filename, '/' );
}

/**
 * Destaca a última palavra de um título em <em> (dourado/azul via CSS),
 * reproduzindo o padrão "Educação <em>Infantil</em>" do layout aprovado
 * sem exigir um campo de meta extra para marcar manualmente o destaque.
 */
function objetivo_highlight_last_word( $text ) {
	$text = trim( wp_strip_all_tags( $text ) );
	$pos  = strrpos( $text, ' ' );
	if ( false === $pos ) {
		return '<em>' . esc_html( $text ) . '</em>';
	}
	return esc_html( substr( $text, 0, $pos ) ) . ' <em>' . esc_html( substr( $text, $pos + 1 ) ) . '</em>';
}

/**
 * URL da página "Blog" (identificada pelo modelo de página, não pelo slug,
 * para continuar funcionando mesmo se o admin renomear a página).
 */
function objetivo_get_blog_page_url() {
	static $url = null;
	if ( null !== $url ) {
		return $url;
	}
	$pages = get_posts( array(
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'meta_key'       => '_wp_page_template',
		'meta_value'     => 'template-blog.php',
	) );
	$url = $pages ? get_permalink( $pages[0] ) : '#';
	return $url;
}

/**
 * Gradientes de marca usados como fundo para posts sem imagem destacada -
 * cicla pelas cores do sistema para dar variedade visual sem exigir que
 * toda notícia tenha foto.
 */
function objetivo_post_gradient( $index ) {
	$gradients = array(
		'linear-gradient(135deg,#0d2346,#1a4fac)',
		'linear-gradient(135deg,#1a4fac,#1e8dc1)',
		'linear-gradient(135deg,#27ae60,#2ecc71)',
		'linear-gradient(135deg,#8e44ad,#9b59b6)',
		'linear-gradient(135deg,#e67e22,#f39c12)',
		'linear-gradient(135deg,#c0392b,#e74c3c)',
	);
	return $gradients[ $index % count( $gradients ) ];
}
