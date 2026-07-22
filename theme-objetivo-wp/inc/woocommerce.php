<?php
/**
 * Integração com o WooCommerce: a aba "Shop" do layout aprovado vira a loja
 * de excursões/eventos. O tema declara suporte ao WooCommerce, adiciona uma
 * aba nativa de produto "Detalhes do Evento" (data, local, vagas — sem
 * precisar de ACF) e assume o controle total do CSS da loja.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function objetivo_is_woocommerce_active() {
	return class_exists( 'WooCommerce' );
}

function objetivo_woocommerce_theme_support() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'objetivo_woocommerce_theme_support' );

/**
 * Mantemos a folha de estilos padrão do WooCommerce carregada (ela cuida da
 * estrutura responsiva de carrinho/checkout) e sobrepomos só a aparência
 * (cores, tipografia, botões) em assets/css/style-main.css, que carrega
 * depois — evita reconstruir do zero o CSS estrutural do WooCommerce.
 */

/**
 * Avisa no admin se o WooCommerce não estiver ativo — a aba Shop depende
 * dele para gerenciar os eventos/excursões.
 */
function objetivo_woocommerce_admin_notice() {
	if ( objetivo_is_woocommerce_active() || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p>' .
		esc_html__( 'O tema Objetivo foi feito para funcionar com o plugin WooCommerce ativo — ele gerencia a aba "Shop" de excursões e eventos. Instale e ative o WooCommerce para liberar a loja.', 'objetivo' ) .
		'</p></div>';
}
add_action( 'admin_notices', 'objetivo_woocommerce_admin_notice' );

/**
 * Marca o item de menu que aponta para a Loja com uma classe própria, para
 * o CSS destacar o link "Shop" em dourado com ícone, como no layout aprovado.
 */
function objetivo_nav_menu_shop_class( $classes, $item, $args ) {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $classes;
	}
	if ( objetivo_is_woocommerce_active() && function_exists( 'wc_get_page_id' ) ) {
		$shop_id = wc_get_page_id( 'shop' );
		if ( $shop_id > 0 && (int) $item->object_id === $shop_id ) {
			$classes[] = 'menu-item-shop';
		}
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'objetivo_nav_menu_shop_class', 10, 3 );

if ( objetivo_is_woocommerce_active() ) {

	/**
	 * Aba de produto "Detalhes do Evento".
	 */
	function objetivo_event_product_tab( $tabs ) {
		$tabs['objetivo_event'] = array(
			'label'    => __( 'Detalhes do Evento', 'objetivo' ),
			'target'   => 'objetivo_event_data',
			'priority' => 21,
			'class'    => array(),
		);
		return $tabs;
	}
	add_filter( 'woocommerce_product_data_tabs', 'objetivo_event_product_tab' );

	function objetivo_event_product_panel() {
		echo '<div id="objetivo_event_data" class="panel woocommerce_options_panel">';

		woocommerce_wp_text_input( array(
			'id'          => '_objetivo_event_date',
			'label'       => __( 'Data do evento', 'objetivo' ),
			'placeholder' => __( 'Ex.: 15 a 20 de Julho, 2027', 'objetivo' ),
			'desc_tip'    => true,
			'description' => __( 'Texto livre exibido com o ícone de calendário no card e na página do produto.', 'objetivo' ),
		) );

		woocommerce_wp_text_input( array(
			'id'          => '_objetivo_event_location',
			'label'       => __( 'Local de saída/encontro', 'objetivo' ),
			'desc_tip'    => true,
			'description' => __( 'Ex.: Portaria do colégio, às 7h.', 'objetivo' ),
		) );

		woocommerce_wp_text_input( array(
			'id'                => '_objetivo_event_spots',
			'label'             => __( 'Vagas disponíveis', 'objetivo' ),
			'type'              => 'number',
			'custom_attributes' => array(
				'step' => '1',
				'min'  => '0',
			),
		) );

		echo '</div>';
	}
	add_action( 'woocommerce_product_data_panels', 'objetivo_event_product_panel' );

	function objetivo_save_event_product_meta( $post_id ) {
		if ( isset( $_POST['_objetivo_event_date'] ) ) {
			update_post_meta( $post_id, '_objetivo_event_date', sanitize_text_field( wp_unslash( $_POST['_objetivo_event_date'] ) ) );
		}
		if ( isset( $_POST['_objetivo_event_location'] ) ) {
			update_post_meta( $post_id, '_objetivo_event_location', sanitize_text_field( wp_unslash( $_POST['_objetivo_event_location'] ) ) );
		}
		if ( isset( $_POST['_objetivo_event_spots'] ) ) {
			update_post_meta( $post_id, '_objetivo_event_spots', absint( wp_unslash( $_POST['_objetivo_event_spots'] ) ) );
		}
	}
	add_action( 'woocommerce_process_product_meta', 'objetivo_save_event_product_meta' );

	/**
	 * Mostra data/local/vagas no produto individual, logo abaixo do título.
	 */
	function objetivo_show_event_details_single() {
		global $product;
		if ( ! $product ) {
			return;
		}
		$meta = objetivo_get_event_meta( $product->get_id() );
		if ( ! $meta['date'] && ! $meta['location'] && ! $meta['spots'] ) {
			return;
		}
		echo '<div class="objetivo-event-meta">';
		if ( $meta['date'] ) {
			echo '<span class="objetivo-event-date">📅 ' . esc_html( $meta['date'] ) . '</span>';
		}
		if ( $meta['location'] ) {
			echo '<span class="objetivo-event-location">📍 ' . esc_html( $meta['location'] ) . '</span>';
		}
		if ( $meta['spots'] ) {
			echo '<span class="objetivo-event-spots">🎟️ ' . esc_html( $meta['spots'] ) . ' ' . esc_html__( 'vagas', 'objetivo' ) . '</span>';
		}
		echo '</div>';
	}
	add_action( 'woocommerce_single_product_summary', 'objetivo_show_event_details_single', 6 );

	/**
	 * Remove os breadcrumbs padrão da loja — o hero customizado do
	 * archive-product.php já cumpre esse papel visualmente.
	 */
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

	/**
	 * Troca o wrapper padrão do WooCommerce (<div id="primary"><main id="main">)
	 * pelo nosso <main class="shop-container">, usado tanto na loja quanto na
	 * página de produto individual, carrinho, checkout e minha conta — sem
	 * isso, os hooks woocommerce_before/after_main_content (chamados pelos
	 * templates do WooCommerce, inclusive o archive-product.php deste tema)
	 * abririam um <main> aninhado dentro do nosso.
	 *
	 * .shop-container já define a mesma largura/padding de .container (ver
	 * style-main.css) — não aninhar um <div class="container"> aqui dentro,
	 * senão o padding/max-width dobra e o conteúdo da loja fica mais
	 * estreito que o resto do site.
	 */
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	add_action( 'woocommerce_before_main_content', 'objetivo_woocommerce_wrapper_start', 10 );
	add_action( 'woocommerce_after_main_content', 'objetivo_woocommerce_wrapper_end', 10 );

	function objetivo_woocommerce_wrapper_start() {
		echo '<main id="content" class="shop-container">';
	}

	function objetivo_woocommerce_wrapper_end() {
		echo '</main>';
	}

	/**
	 * "Comprar" no lugar do texto padrão "Adicionar ao carrinho", como no
	 * layout aprovado — mantendo o link/AJAX nativo do WooCommerce.
	 */
	function objetivo_add_to_cart_text( $text, $product = null ) {
		return __( 'Comprar', 'objetivo' );
	}
	add_filter( 'woocommerce_product_add_to_cart_text', 'objetivo_add_to_cart_text', 10, 2 );
	add_filter( 'woocommerce_product_single_add_to_cart_text', 'objetivo_add_to_cart_text', 10, 2 );
}

/**
 * Helper: lê os 3 campos de "Detalhes do Evento" de um produto de uma vez.
 * Retorna array vazio (chaves com string vazia) se WooCommerce não estiver
 * ativo ou o produto não tiver esses metadados.
 */
function objetivo_get_event_meta( $product_id ) {
	return array(
		'date'     => get_post_meta( $product_id, '_objetivo_event_date', true ),
		'location' => get_post_meta( $product_id, '_objetivo_event_location', true ),
		'spots'    => get_post_meta( $product_id, '_objetivo_event_spots', true ),
	);
}
