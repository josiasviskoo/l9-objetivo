<?php
/**
 * Seção "Teste Vocacional" - substitui o antigo e-GENIO (produto
 * descontinuado). Sem CPT: só texto do Customizer (sec_teste_vocacional) +
 * um botão que leva ao Teste Vocacional real, hospedado no subdomínio
 * ov.objetivo.br (sistema à parte, fora deste tema - por isso o link é
 * externo em vez de um post_type interno).
 */
$btn_url = objetivo_opt( 'sec_teste_vocacional', 'btn_url' );
?>
<section class="vocacional">
	<div class="container">
		<div class="vocacional-inner">
			<h2 class="vocacional-title"><?php echo objetivo_kses_em( objetivo_opt( 'sec_teste_vocacional', 'title' ) ); ?></h2>
			<p class="vocacional-desc"><?php echo objetivo_kses_em( objetivo_opt( 'sec_teste_vocacional', 'desc' ) ); ?></p>
			<a href="<?php echo esc_url( $btn_url ); ?>" class="btn-primary vocacional-btn" target="_blank" rel="noopener"><?php echo esc_html( objetivo_opt( 'sec_teste_vocacional', 'btn_label' ) ); ?> →</a>
		</div>
	</div>
</section>
