<?php
/**
 * "Nossa História" em tela cheia - uma seção de 100vh por marco do CPT
 * objetivo_timeline (mesmos posts da seção compacta da home, ver
 * template-parts/front/timeline.php). Destino do botão "Ver história
 * completa" (template-sobre.php).
 *
 * Cada marco é administrável em wp-admin → Nossa História (Timeline):
 * título, descrição (resumo), categoria/ano (caixa "Detalhes") e, opcional,
 * Imagem Destacada - se definida, substitui o fundo em degradê pela foto.
 */
$items = objetivo_get_items( 'objetivo_timeline' );
if ( ! $items ) {
	return;
}
$total = count( $items );
?>
<div class="historia-fullscreen">
	<?php if ( $total > 1 ) : ?>
		<nav class="hist-dots" aria-label="<?php esc_attr_e( 'Navegar pelos marcos da história', 'objetivo' ); ?>">
			<?php foreach ( $items as $i => $item ) : ?>
				<button type="button" class="hist-dot<?php echo 0 === $i ? ' is-active' : ''; ?>" data-target="#hist-<?php echo esc_attr( $item->ID ); ?>">
					<span class="hist-dot-year"><?php echo esc_html( get_post_meta( $item->ID, '_dot_label', true ) ); ?></span>
					<span class="hist-dot-mark"></span>
				</button>
			<?php endforeach; ?>
		</nav>
	<?php endif; ?>

	<?php foreach ( $items as $i => $item ) :
		$era       = get_post_meta( $item->ID, '_era_label', true );
		$year      = get_post_meta( $item->ID, '_dot_label', true );
		$highlight = (bool) get_post_meta( $item->ID, '_is_highlight', true );
		$thumb     = get_the_post_thumbnail_url( $item, 'full' );
		$next      = isset( $items[ $i + 1 ] ) ? $items[ $i + 1 ] : null;
		?>
		<section id="hist-<?php echo esc_attr( $item->ID ); ?>" class="hist-screen<?php echo $highlight ? ' hist-screen-highlight' : ''; ?>">
			<div class="hist-bg<?php echo $thumb ? '' : ' hist-bg-v' . esc_attr( $i % 4 ); ?>"<?php if ( $thumb ) : ?> style="background-image:url('<?php echo esc_url( $thumb ); ?>');"<?php endif; ?>></div>
			<?php if ( $year ) : ?>
				<span class="hist-year-decor" aria-hidden="true"><?php echo esc_html( $year ); ?></span>
			<?php endif; ?>
			<div class="hist-content">
				<?php if ( $era || $year ) : ?>
					<p class="hist-era">
						<?php echo esc_html( $era ); ?>
						<?php if ( $year ) : ?><span><?php echo esc_html( $year ); ?></span><?php endif; ?>
					</p>
				<?php endif; ?>
				<h2 class="hist-title"><?php echo esc_html( get_the_title( $item ) ); ?></h2>
				<?php if ( get_the_excerpt( $item ) ) : ?>
					<p class="hist-desc"><?php echo esc_html( get_the_excerpt( $item ) ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( $next ) : ?>
				<a href="#hist-<?php echo esc_attr( $next->ID ); ?>" class="hist-next" aria-label="<?php esc_attr_e( 'Próximo marco', 'objetivo' ); ?>">↓</a>
			<?php endif; ?>
		</section>
	<?php endforeach; ?>
</div>
