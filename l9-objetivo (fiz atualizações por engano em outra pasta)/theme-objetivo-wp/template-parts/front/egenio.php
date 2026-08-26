<?php
/**
 * Seção "e-GENIO".
 */
?>
<section class="egenio">
	<div class="container">
		<div class="egenio-inner">
			<div class="egenio-visual">
				<div class="egenio-phone">
					<div class="egenio-phone-icon">💻</div>
					<h3><?php echo esc_html( objetivo_opt( 'egenio', 'phone_title' ) ); ?></h3>
					<p><?php echo esc_html( objetivo_opt( 'egenio', 'phone_subtitle' ) ); ?></p>
					<div class="egenio-features">
						<?php for ( $i = 1; $i <= 4; $i++ ) :
							$feature = objetivo_opt( 'egenio', "feature_{$i}" );
							if ( ! $feature ) {
								continue;
							}
							?>
							<div class="egenio-feat"><?php echo esc_html( $feature ); ?></div>
						<?php endfor; ?>
					</div>
				</div>
			</div>
			<div>
				<p class="section-label"><?php echo esc_html( objetivo_opt( 'egenio', 'label' ) ); ?></p>
				<h2 class="section-title"><?php echo objetivo_kses_em( objetivo_opt( 'egenio', 'title' ) ); ?></h2>
				<p class="section-desc" style="max-width:100%;"><?php echo esc_html( objetivo_opt( 'egenio', 'desc_1' ) ); ?></p>
				<br />
				<p class="section-desc" style="max-width:100%; font-size:.92rem;"><?php echo esc_html( objetivo_opt( 'egenio', 'desc_2' ) ); ?></p>
				<br />
				<a href="<?php echo esc_url( objetivo_opt( 'egenio', 'btn_url' ) ); ?>" class="btn-primary" style="background:var(--navy); color:var(--white); display:inline-block; margin-top:.5rem;"><?php echo esc_html( objetivo_opt( 'egenio', 'btn_label' ) ); ?></a>
			</div>
		</div>
	</div>
</section>
