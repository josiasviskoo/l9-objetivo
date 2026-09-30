<?php
/**
 * Carrossel de unidades da home, logo abaixo da seção "Motivos para
 * estudar no Objetivo". Seção estática (sem CPT) - os 6 cards abaixo são os
 * dados reais das unidades de São Carlos/SP, migrados da página estática
 * "Unidades" (Conteúdo das Páginas/HTML/unidades.html); para editar,
 * altere objetivo_unidades() em inc/setup.php (também usada no rodapé).
 *
 * Autoplay e navegação por páginas (2 cards por vez no celular, 3 no
 * desktop) via assets/js/main.js (#unidades-carousel) + breakpoint em
 * style-main.css.
 */
$unidades = objetivo_unidades();
?>
<section class="unidades-carousel" id="unidades-carousel">
	<div class="container">
		<div class="unidades-header">
			<p class="section-label" style="justify-content:center;"><?php echo esc_html( objetivo_opt( 'sec_unidades', 'label' ) ); ?></p>
			<h2 class="section-title" style="margin:0 auto .8rem;"><?php echo objetivo_kses_em( objetivo_opt( 'sec_unidades', 'title' ) ); ?></h2>
			<p class="section-desc" style="margin:0 auto;"><?php echo esc_html( objetivo_opt( 'sec_unidades', 'desc' ) ); ?></p>
		</div>

		<div class="unidades-viewport">
			<div class="unidades-track">
				<?php foreach ( $unidades as $unidade ) : ?>
					<div class="unidade-card">
						<?php if ( ! empty( $unidade['badge'] ) ) : ?>
							<span class="unidade-card-badge"><?php echo esc_html( $unidade['badge'] ); ?></span>
						<?php endif; ?>
						<h3><?php echo esc_html( $unidade['title'] ); ?></h3>
						<?php if ( ! empty( $unidade['address'] ) ) : ?>
							<p class="unidade-card-row"><span class="ico">📍</span><span><?php echo esc_html( $unidade['address'] ); ?></span></p>
						<?php endif; ?>
						<?php if ( ! empty( $unidade['phone'] ) ) : ?>
							<p class="unidade-card-row"><span class="ico">📞</span><span><?php echo esc_html( $unidade['phone'] ); ?></span></p>
						<?php endif; ?>
						<?php if ( ! empty( $unidade['url'] ) ) : ?>
							<a href="<?php echo esc_url( $unidade['url'] ); ?>" class="unidade-card-link" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Agendar Visita', 'objetivo' ); ?> →</a>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( count( $unidades ) > 1 ) : ?>
				<button type="button" class="unidades-arrow unidades-prev" aria-label="<?php esc_attr_e( 'Unidades anteriores', 'objetivo' ); ?>">‹</button>
				<button type="button" class="unidades-arrow unidades-next" aria-label="<?php esc_attr_e( 'Próximas unidades', 'objetivo' ); ?>">›</button>
			<?php endif; ?>
		</div>

		<?php if ( count( $unidades ) > 1 ) : ?>
			<div class="unidades-dots"></div>
		<?php endif; ?>
	</div>
</section>
