<?php
/**
 * Faixa "Matrículas abertas".
 */
?>
<section class="matriculas-cta">
	<div class="container">
		<div class="matriculas-inner">
			<div class="matriculas-text">
				<h2><?php echo esc_html( objetivo_opt( 'matriculas', 'title' ) ); ?></h2>
				<p><?php echo esc_html( objetivo_opt( 'matriculas', 'desc' ) ); ?></p>
			</div>
			<div style="display:flex;gap:1rem;flex-wrap:wrap;">
				<a href="<?php echo esc_url( objetivo_opt( 'matriculas', 'btn1_url' ) ); ?>" class="btn-navy" target="_blank" rel="noopener noreferrer">
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.063.526 4.009 1.449 5.71L.099 23.14c-.099.411.265.774.677.677l5.431-1.35A11.93 11.93 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.79 9.79 0 01-5.002-1.369l-.358-.213-3.72.924.94-3.625-.234-.371A9.794 9.794 0 012.182 12C2.182 6.589 6.589 2.182 12 2.182S21.818 6.589 21.818 12 17.411 21.818 12 21.818z"/></svg>
					<?php echo esc_html( objetivo_opt( 'matriculas', 'btn1_label' ) ); ?>
				</a>
				<a href="<?php echo esc_url( objetivo_opt( 'matriculas', 'btn2_url' ) ); ?>" class="btn-navy" style="background:#fff;color:var(--navy);"><?php echo esc_html( objetivo_opt( 'matriculas', 'btn2_label' ) ); ?></a>
			</div>
		</div>
	</div>
</section>
