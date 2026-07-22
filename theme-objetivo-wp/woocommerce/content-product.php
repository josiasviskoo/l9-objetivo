<?php
/**
 * Card de produto (excursão/evento) — fiel ao shop.html: imagem, data do
 * evento, título, resumo, preço e botão "Comprar" (add-to-cart real via
 * woocommerce_template_loop_add_to_cart(), com suporte a AJAX).
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$event = objetivo_get_event_meta( $product->get_id() );
?>
<li <?php wc_product_class( 'product-card', $product ); ?>>
	<a href="<?php the_permalink(); ?>" class="product-card-media">
		<?php echo wp_kses_post( $product->get_image( 'objetivo-card' ) ); ?>
	</a>
	<div class="product-content">
		<?php if ( $event['date'] ) : ?>
			<div class="product-date">📅 <?php echo esc_html( $event['date'] ); ?></div>
		<?php endif; ?>

		<h3 class="product-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<div class="product-desc">
			<?php
			$excerpt = $product->get_short_description();
			echo esc_html( wp_trim_words( $excerpt ? $excerpt : $product->get_description(), 26 ) );
			?>
		</div>

		<div class="product-footer">
			<div class="product-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
			<?php woocommerce_template_loop_add_to_cart(); ?>
		</div>
	</div>
</li>
