<?php
/**
 * Seção "Navegue pelo seu segmento" - CPT objetivo_segmento. Cada card usa
 * a imagem destacada (formato vertical) como fundo, com um wash na cor do
 * segmento concentrado na base (identidade visual) e transparente no topo
 * (foto visível) - ver .segmento-overlay em style-main.css.
 */
$items = objetivo_get_items( 'objetivo_segmento' );
if ( ! $items ) {
	return;
}
?>
<section id="segmentos">
	<div class="container">
		<div style="text-align:center; margin-bottom:2.5rem;">
			<p class="section-label" style="justify-content:center;"><?php echo esc_html( objetivo_opt( 'sec_segmentos', 'label' ) ); ?></p>
			<h2 class="section-title" style="margin:0 auto .8rem;"><?php echo objetivo_kses_em( objetivo_opt( 'sec_segmentos', 'title' ) ); ?></h2>
			<p class="section-desc" style="margin:0 auto; max-width:560px;"><?php echo esc_html( objetivo_opt( 'sec_segmentos', 'desc' ) ); ?></p>
		</div>
		<div class="segmentos-grid">
			<?php foreach ( $items as $item ) :
				$from = get_post_meta( $item->ID, '_color_from', true ) ?: '#1a4fac';
				$to   = get_post_meta( $item->ID, '_color_to', true ) ?: '#1e8dc1';
				$url  = get_post_meta( $item->ID, '_objetivo_url', true );
				$img  = get_the_post_thumbnail_url( $item->ID, 'objetivo-segmento' );
				?>
				<a class="segmento-card" href="<?php echo esc_url( $url ? $url : '#' ); ?>" style="background-color: <?php echo esc_attr( $to ); ?>;<?php echo $img ? " background-image:url('" . esc_url( $img ) . "'); background-size:cover; background-position:center;" : ''; ?>">
					<div class="segmento-overlay" style="background: linear-gradient(to top, <?php echo esc_attr( $to ); ?> 0%, <?php echo esc_attr( $from ); ?>cc 45%, <?php echo esc_attr( $from ); ?>00 100%);"></div>
					<div class="segmento-content">
						<div class="segmento-badge"><?php echo esc_html( get_post_meta( $item->ID, '_badge_label', true ) ); ?></div>
						<h3><?php echo esc_html( get_the_title( $item ) ); ?></h3>
						<p><?php echo esc_html( get_the_excerpt( $item ) ); ?></p>
						<div class="segmento-cta"><?php esc_html_e( 'Ver conteúdos', 'objetivo' ); ?> <span>→</span></div>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
