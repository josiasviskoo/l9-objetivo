<?php
/**
 * Faixa de estatísticas logo abaixo do Hero.
 */
?>
<div class="stats-bar">
	<div class="stats-inner">
		<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
			<div class="stat-item">
				<div class="stat-num"><?php echo esc_html( objetivo_opt( 'stats', "stat{$i}_num" ) ); ?></div>
				<div class="stat-label"><?php echo esc_html( objetivo_opt( 'stats', "stat{$i}_label" ) ); ?></div>
			</div>
		<?php endfor; ?>
	</div>
</div>
