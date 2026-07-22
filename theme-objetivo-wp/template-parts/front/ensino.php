<?php
/**
 * Seção "Sistema de Ensino" — cards vindos do CPT objetivo_ensino.
 */
$items = objetivo_get_items( 'objetivo_ensino' );
if ( ! $items ) {
	return;
}
?>
<section class="ensino">
	<div class="container">
		<div class="ensino-header">
			<p class="section-label"><?php echo esc_html( objetivo_opt( 'sec_ensino', 'label' ) ); ?></p>
			<h2 class="section-title"><?php echo objetivo_kses_em( objetivo_opt( 'sec_ensino', 'title' ) ); ?></h2>
			<p class="section-desc"><?php echo esc_html( objetivo_opt( 'sec_ensino', 'desc' ) ); ?></p>
		</div>
		<div class="ensino-grid">
			<?php foreach ( $items as $item ) :
				$badge = get_post_meta( $item->ID, '_badge_label', true );
				$url   = get_post_meta( $item->ID, '_objetivo_url', true );
				$img   = get_the_post_thumbnail_url( $item->ID, 'objetivo-card' );
				?>
				<a class="ensino-card" href="<?php echo esc_url( $url ? $url : '#' ); ?>">
					<div class="ensino-card-img" <?php if ( $img ) : ?>style="background-image:url('<?php echo esc_url( $img ); ?>');"<?php endif; ?>>
						<div class="ensino-card-img-overlay"></div>
						<?php if ( $badge ) : ?><span class="ensino-card-level"><?php echo esc_html( $badge ); ?></span><?php endif; ?>
					</div>
					<div class="ensino-card-body">
						<h3 class="ensino-card-title"><?php echo objetivo_highlight_last_word( get_the_title( $item ) ); ?></h3>
						<p class="ensino-card-desc"><?php echo esc_html( get_the_excerpt( $item ) ); ?></p>
						<span class="ensino-card-link"><?php esc_html_e( 'Saiba mais', 'objetivo' ); ?></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
