<?php
/**
 * Timeline interativa "Nossa História" — marcos do CPT objetivo_timeline.
 * O JS (assets/js/main.js) generaliza o comportamento por data-id, então
 * funciona com qualquer quantidade de marcos cadastrados.
 */
$items = objetivo_get_items( 'objetivo_timeline' );
if ( ! $items ) {
	return;
}
?>
<section id="timeline">
	<div class="container">
		<div style="text-align:center; margin-bottom:3.5rem;">
			<p class="section-label" style="justify-content:center;"><?php echo esc_html( objetivo_opt( 'sec_timeline', 'label' ) ); ?></p>
			<h2 class="section-title" style="margin:0 auto .8rem;"><?php echo objetivo_kses_em( objetivo_opt( 'sec_timeline', 'title' ) ); ?></h2>
			<p class="section-desc" style="margin:0 auto;"><?php echo esc_html( objetivo_opt( 'sec_timeline', 'desc' ) ); ?></p>
		</div>

		<div class="timeline-wrap">
			<div class="timeline-dots">
				<?php foreach ( $items as $i => $item ) :
					$highlight = (bool) get_post_meta( $item->ID, '_is_highlight', true );
					$id        = 'tl-' . $item->ID;
					?>
					<div class="tl-dot<?php echo 0 === $i ? ' active' : ''; ?><?php echo $highlight ? ' tl-dot-highlight' : ''; ?>" data-id="<?php echo esc_attr( $id ); ?>" role="button" tabindex="0">
						<span><?php echo esc_html( get_post_meta( $item->ID, '_dot_label', true ) ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="timeline-cards">
				<?php foreach ( $items as $i => $item ) :
					$highlight = (bool) get_post_meta( $item->ID, '_is_highlight', true );
					$id        = 'tl-' . $item->ID;
					?>
					<div id="<?php echo esc_attr( $id ); ?>" class="tl-card<?php echo 0 === $i ? ' active' : ''; ?><?php echo $highlight ? ' tl-card-highlight' : ''; ?>" data-id="<?php echo esc_attr( $id ); ?>">
						<div class="tl-card-head">
							<div>
								<div class="tl-era"><?php echo esc_html( get_post_meta( $item->ID, '_era_label', true ) ); ?></div>
								<h4><?php echo esc_html( get_the_title( $item ) ); ?></h4>
							</div>
							<span class="tl-arrow">›</span>
						</div>
						<div class="tl-body">
							<p><?php echo esc_html( get_the_excerpt( $item ) ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<?php $cta_url = objetivo_opt( 'sec_timeline', 'cta_url' ); ?>
		<div style="text-align:center; margin-top:3rem;">
			<a href="<?php echo esc_url( $cta_url ? $cta_url : '#' ); ?>" class="btn-navy"><?php echo esc_html( objetivo_opt( 'sec_timeline', 'cta_label' ) ); ?> →</a>
		</div>
	</div>
</section>
