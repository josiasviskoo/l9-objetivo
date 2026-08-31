<?php
/**
 * Seção Hero da home - slider de banners gerenciado pelo CPT
 * objetivo_banner (Aparência → wp-admin → Banners da Home). Cada slide é só
 * imagem: a imagem destacada é a versão desktop e o meta "_mobile_image" é a
 * versão mobile (opcional - cai para a desktop se não for definida).
 */
$banners = objetivo_get_items( 'objetivo_banner' );
if ( ! $banners ) {
	return;
}
?>
<section class="hero-slider" id="hero-slider">
	<div class="hero-slides">
		<?php foreach ( $banners as $i => $banner ) :
			$desktop_img = get_the_post_thumbnail_url( $banner, 'objetivo-banner' );
			$mobile_id   = (int) get_post_meta( $banner->ID, '_mobile_image', true );
			$mobile_img  = $mobile_id ? wp_get_attachment_image_url( $mobile_id, 'objetivo-banner-mobile' ) : $desktop_img;
			?>
			<div class="hero-slide<?php echo 0 === $i ? ' is-active' : ''; ?>">
				<?php if ( $desktop_img ) : ?>
					<div class="hero-slide-bg hero-slide-bg-desktop" style="background-image:url('<?php echo esc_url( $desktop_img ); ?>');"></div>
				<?php endif; ?>
				<?php if ( $mobile_img ) : ?>
					<div class="hero-slide-bg hero-slide-bg-mobile" style="background-image:url('<?php echo esc_url( $mobile_img ); ?>');"></div>
				<?php endif; ?>
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
