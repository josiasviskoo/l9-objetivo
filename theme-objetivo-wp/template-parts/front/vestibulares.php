<?php
/**
 * Seção "Prepare-se para as maiores provas".
 */
$items = objetivo_get_items( 'objetivo_vestibular' );
?>
<section class="vestibulares">
	<div class="container">
		<div class="vestibulares-inner">
			<div class="vest-text">
				<p class="section-label"><?php echo esc_html( objetivo_opt( 'sec_vest', 'label' ) ); ?></p>
				<h2 class="section-title"><?php echo objetivo_kses_em( objetivo_opt( 'sec_vest', 'title' ) ); ?></h2>
				<p class="section-desc"><?php echo esc_html( objetivo_opt( 'sec_vest', 'desc' ) ); ?></p>
				<a href="<?php echo esc_url( objetivo_opt( 'sec_vest', 'btn_url' ) ); ?>" class="btn-primary"><?php echo esc_html( objetivo_opt( 'sec_vest', 'btn_label' ) ); ?></a>
			</div>
			<?php if ( $items ) : ?>
				<div class="vest-cards">
					<?php foreach ( $items as $item ) :
						$url = get_post_meta( $item->ID, '_objetivo_url', true );
						?>
						<a class="vest-card" href="<?php echo esc_url( $url ? $url : '#' ); ?>">
							<div class="vest-card-icon"><?php echo esc_html( get_post_meta( $item->ID, '_icon_emoji', true ) ); ?></div>
							<h4><?php echo esc_html( get_the_title( $item ) ); ?></h4>
							<p><?php echo esc_html( get_the_excerpt( $item ) ); ?></p>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
