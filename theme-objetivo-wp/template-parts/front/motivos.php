<?php
/**
 * Seção "Motivos para estudar no Objetivo" + coluna de Selos/Prêmios.
 */
$motivos = objetivo_get_items( 'objetivo_motivo' );
$selos   = objetivo_get_items( 'objetivo_selo' );
if ( ! $motivos && ! $selos ) {
	return;
}
?>
<section class="motivos">
	<div class="container">
		<div class="motivos-inner">
			<div>
				<p class="section-label"><?php echo esc_html( objetivo_opt( 'sec_motivos', 'label' ) ); ?></p>
				<h2 class="section-title"><?php echo objetivo_kses_em( objetivo_opt( 'sec_motivos', 'title' ) ); ?></h2>
				<ul class="motivos-list">
					<?php foreach ( $motivos as $motivo ) : ?>
						<li>
							<div class="motivo-icon"><?php echo esc_html( get_post_meta( $motivo->ID, '_icon_emoji', true ) ); ?></div>
							<div class="motivo-text">
								<h4><?php echo esc_html( get_the_title( $motivo ) ); ?></h4>
								<p><?php echo esc_html( get_the_excerpt( $motivo ) ); ?></p>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="motivos-selos">
				<?php foreach ( $selos as $selo ) :
					$is_dark = (bool) get_post_meta( $selo->ID, '_is_dark', true );
					$icon    = get_post_meta( $selo->ID, '_icon_emoji', true );
					$url     = get_post_meta( $selo->ID, '_objetivo_url', true );
					$img     = get_the_post_thumbnail_url( $selo->ID, 'thumbnail' );
					?>
					<div class="selo-card<?php echo $is_dark ? ' selo-card-dark' : ''; ?>">
						<?php if ( $img ) : ?>
							<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( get_the_title( $selo ) ); ?>" style="max-width:80px;height:auto;flex-shrink:0;" />
						<?php elseif ( $icon ) : ?>
							<div class="selo-icon"><?php echo esc_html( $icon ); ?></div>
						<?php endif; ?>
						<div>
							<h3><?php echo esc_html( get_the_title( $selo ) ); ?></h3>
							<p><?php echo esc_html( get_the_excerpt( $selo ) ); ?></p>
							<?php if ( $is_dark && $url ) : ?>
								<a href="<?php echo esc_url( $url ); ?>" class="selo-card-link"><?php esc_html_e( 'Visitar Unidade', 'objetivo' ); ?> →</a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
