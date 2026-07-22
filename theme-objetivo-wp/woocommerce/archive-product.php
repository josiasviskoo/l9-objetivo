<?php
/**
 * Loja "Objetivo Shop" — mantém o loop nativo do WooCommerce (hooks de
 * ordenação, paginação, notices, filtros de plugins continuam funcionando)
 * mas envolve tudo com o hero e o grid de cards do layout aprovado.
 *
 * Baseado no archive-product.php do plugin WooCommerce; customizações
 * marcadas com comentário "Objetivo:".
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

// Objetivo: hero da loja, com título/subtítulo editáveis no Customizer.
?>
<section class="shop-hero">
	<div class="container">
		<h1><?php echo objetivo_kses_em( objetivo_opt( 'shop', 'title' ) ); ?></h1>
		<p><?php echo esc_html( objetivo_opt( 'shop', 'subtitle' ) ); ?></p>
	</div>
</section>

<?php
/**
 * Hook: woocommerce_before_main_content.
 * Objetivo: substituímos woocommerce_output_content_wrapper() (ver
 * inc/woocommerce.php) por <main class="shop-container"><div class="container">,
 * então não abrimos wrapper manualmente aqui — evita <main> aninhado.
 */
do_action( 'woocommerce_before_main_content' );

if ( apply_filters( 'woocommerce_show_page_title', true ) ) {
	// Objetivo: título já está no hero acima, mantemos só a descrição da categoria (se houver).
	do_action( 'woocommerce_archive_description' );
}

if ( woocommerce_product_loop() ) {

	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();
			do_action( 'woocommerce_shop_loop' );
			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	do_action( 'woocommerce_after_shop_loop' );
} else {
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 */
do_action( 'woocommerce_after_main_content' );
?>

<?php get_footer( 'shop' ); ?>
