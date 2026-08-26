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
				<a href="<?php echo esc_url( objetivo_opt( 'matriculas', 'btn1_url' ) ); ?>" class="btn-navy"><?php echo esc_html( objetivo_opt( 'matriculas', 'btn1_label' ) ); ?></a>
				<a href="<?php echo esc_url( objetivo_opt( 'matriculas', 'btn2_url' ) ); ?>" class="btn-navy" style="background:#fff;color:var(--navy);"><?php echo esc_html( objetivo_opt( 'matriculas', 'btn2_label' ) ); ?></a>
			</div>
		</div>
	</div>
</section>
