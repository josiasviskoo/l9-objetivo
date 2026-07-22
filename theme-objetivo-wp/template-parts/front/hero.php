<?php
/**
 * Seção Hero da home — slider de banners gerenciado pelo CPT
 * objetivo_banner (Aparência → wp-admin → Banners da Home).
 */
$banners = objetivo_get_items( 'objetivo_banner' );
if ( ! $banners ) {
	return;
}
?>
<section class="hero-slider" id="hero-slider">
	<div class="hero-slides">
		<?php foreach ( $banners as $i => $banner ) :
			$img       = get_the_post_thumbnail_url( $banner, 'objetivo-banner' );
			$tag       = get_post_meta( $banner->ID, '_tag_label', true );
			$subtitle  = get_post_meta( $banner->ID, '_subtitle', true );
			$btn1_label = get_post_meta( $banner->ID, '_btn1_label', true );
			$btn1_url   = get_post_meta( $banner->ID, '_btn1_url', true );
			$btn2_label = get_post_meta( $banner->ID, '_btn2_label', true );
			$btn2_url   = get_post_meta( $banner->ID, '_btn2_url', true );
			?>
			<div class="hero-slide<?php echo 0 === $i ? ' is-active' : ''; ?>" <?php if ( $img ) : ?>style="background-image:url('<?php echo esc_url( $img ); ?>');"<?php endif; ?>>
				<div class="hero-bg-pattern"></div>
				<div class="hero-slide-overlay"></div>
				<div class="hero-content">
					<div class="hero-text">
						<?php if ( $tag ) : ?><span class="hero-tag"><?php echo esc_html( $tag ); ?></span><?php endif; ?>
						<h1 class="hero-title"><?php echo objetivo_highlight_last_word( get_the_title( $banner ) ); ?></h1>
						<?php if ( $subtitle ) : ?><p class="hero-sub"><?php echo esc_html( $subtitle ); ?></p><?php endif; ?>
						<?php if ( $btn1_label || $btn2_label ) : ?>
							<div class="hero-actions">
								<?php if ( $btn1_label ) : ?>
									<a href="<?php echo esc_url( $btn1_url ? $btn1_url : '#' ); ?>" class="btn-primary"><?php echo esc_html( $btn1_label ); ?></a>
								<?php endif; ?>
								<?php if ( $btn2_label ) : ?>
									<a href="<?php echo esc_url( $btn2_url ? $btn2_url : '#' ); ?>" class="btn-outline"><?php echo esc_html( $btn2_label ); ?></a>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<?php if ( count( $banners ) > 1 ) : ?>
		<button type="button" class="hero-slider-arrow hero-slider-prev" aria-label="<?php esc_attr_e( 'Banner anterior', 'objetivo' ); ?>">‹</button>
		<button type="button" class="hero-slider-arrow hero-slider-next" aria-label="<?php esc_attr_e( 'Próximo banner', 'objetivo' ); ?>">›</button>
		<div class="hero-slider-dots">
			<?php foreach ( $banners as $i => $banner ) : ?>
				<button type="button" class="hero-slider-dot<?php echo 0 === $i ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr( $i ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Ir para o banner %d', 'objetivo' ), $i + 1 ) ); ?>"></button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
