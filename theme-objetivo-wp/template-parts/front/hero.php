<?php
/**
 * Seção Hero da home.
 */
$img1 = objetivo_opt( 'hero', 'image_1' );
$img2 = objetivo_opt( 'hero', 'image_2' );
?>
<section class="hero">
	<div class="hero-bg-pattern"></div>

	<div class="hero-content">
		<div class="hero-text">
			<span class="hero-tag"><?php echo esc_html( objetivo_opt( 'hero', 'tag' ) ); ?></span>
			<h1 class="hero-title"><?php echo objetivo_kses_em( objetivo_opt( 'hero', 'title' ) ); ?></h1>
			<p class="hero-sub"><?php echo esc_html( objetivo_opt( 'hero', 'subtitle' ) ); ?></p>
			<div class="hero-actions">
				<a href="<?php echo esc_url( objetivo_opt( 'hero', 'btn_primary_url' ) ); ?>" class="btn-primary"><?php echo esc_html( objetivo_opt( 'hero', 'btn_primary_label' ) ); ?></a>
				<a href="<?php echo esc_url( objetivo_opt( 'hero', 'btn_outline_url' ) ); ?>" class="btn-outline"><?php echo esc_html( objetivo_opt( 'hero', 'btn_outline_label' ) ); ?></a>
			</div>
		</div>
		<?php if ( $img1 || $img2 ) : ?>
			<div class="hero-images-grid">
				<?php if ( $img1 ) : ?><img src="<?php echo esc_url( $img1 ); ?>" alt="<?php esc_attr_e( 'Objetivo São Carlos', 'objetivo' ); ?>" /><?php endif; ?>
				<?php if ( $img2 ) : ?><img src="<?php echo esc_url( $img2 ); ?>" alt="<?php esc_attr_e( 'Objetivo São Carlos', 'objetivo' ); ?>" style="transform: translateY(2rem);" /><?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
