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
	add_theme_support( 'custom-logo', array(
		'height'      => 96,
		'width'       => 96,
		'flex-height' => true,
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

	register_nav_menus( array(
		'primary'            => __( 'Principal (cabeçalho)', 'objetivo' ),
		'topbar'              => __( 'Barra superior', 'objetivo' ),
		'footer-ensino'       => __( 'Rodapé — Ensino', 'objetivo' ),
		'footer-vestibulares' => __( 'Rodapé — Vestibulares', 'objetivo' ),
	) );
}
add_action( 'after_setup_theme', 'objetivo_setup' );

/**
 * Larguras de conteúdo usadas por embeds/oEmbed.
 */
function objetivo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'objetivo_content_width', 1260 );
}
add_action( 'after_setup_theme', 'objetivo_content_width', 0 );

/**
 * Widget areas — usadas como reforço opcional em páginas genéricas/blog.
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

	if ( is_front_page() ) {
		wp_enqueue_script(
			'objetivo-blog-filter',
			OBJETIVO_THEME_URI . '/assets/js/blog-filter.js',
			array(),
			OBJETIVO_THEME_VERSION,
			true
		);
	}

	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
// Prioridade 20: garante que nosso CSS seja enfileirado (e impresso) depois
// do CSS padrão do WooCommerce (prioridade 10), para que nossas cores/estilos
// de marca vençam a cascata sem precisar de !important em tudo.
add_action( 'wp_enqueue_scripts', 'objetivo_enqueue_assets', 20 );

/**
 * Helper: emite um bloco de texto vindo do Customizer permitindo <em> para
 * destaque de palavra (usado em títulos "Sistema de Ensino <em>Objetivo</em>").
 */
function objetivo_kses_em( $text ) {
	return wp_kses( $text, array( 'em' => array(), 'br' => array() ) );
}

/**
 * Helper: URL de imagem padrão do tema (fallback quando o CPT não tem
 * imagem destacada definida — nunca deveria acontecer após o seed, mas
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
 * Gradientes de marca usados como fundo para posts sem imagem destacada —
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
