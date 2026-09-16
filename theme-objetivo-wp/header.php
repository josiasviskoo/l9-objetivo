<?php
/**
 * Cabeçalho: barra superior de contato + header sticky com logo, menu
 * principal (com dropdowns) e botões de acesso restrito.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$financeiro_url    = objetivo_opt( 'header', 'financeiro_url' );
$area_restrita_url = objetivo_opt( 'header', 'area_restrita_url' );
?>
<div class="topbar">
	<div class="topbar-inner">
		<div class="topbar-right">
			<a href="<?php echo esc_url( objetivo_opt( 'contato', 'matriculas_url' ) ); ?>"><?php echo esc_html( objetivo_opt( 'contato', 'matriculas_label' ) ); ?></a>
			<?php if ( has_nav_menu( 'topbar' ) ) : ?>
				<?php wp_nav_menu( array( 'theme_location' => 'topbar', 'container' => false, 'menu_class' => 'topbar-menu', 'depth' => 1 ) ); ?>
			<?php endif; ?>
			<a href="<?php echo esc_url( objetivo_opt( 'contato', 'topbar_cta_url' ) ); ?>" class="topbar-cta"><?php echo esc_html( objetivo_opt( 'contato', 'topbar_cta_label' ) ); ?></a>
			<?php if ( $financeiro_url ) : ?>
				<a href="<?php echo esc_url( $financeiro_url ); ?>" class="btn-area-restrita btn-financeiro"><?php esc_html_e( 'Financeiro', 'objetivo' ); ?></a>
			<?php endif; ?>
			<?php if ( $area_restrita_url ) : ?>
				<a href="<?php echo esc_url( $area_restrita_url ); ?>" class="btn-area-restrita"><?php esc_html_e( 'Área Restrita', 'objetivo' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>

<header id="masthead">
	<div class="header-inner">
		<div class="logo">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php echo esc_url( objetivo_theme_image( 'logo-azul.png' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
				</a>
			<?php endif; ?>
		</div>

		<button class="nav-toggle" aria-label="<?php esc_attr_e( 'Abrir menu', 'objetivo' ); ?>" aria-expanded="false" aria-controls="nav-wrap">
			<span></span><span></span><span></span>
		</button>

		<div class="nav-wrap" id="nav-wrap">
			<nav id="primary-menu">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'primary-menu',
					'fallback_cb'    => false,
					'depth'          => 2,
				) );
				?>
			</nav>
		</div>
	</div>

	<?php
	$current_segmento = objetivo_get_current_segmento();
	if ( $current_segmento ) :
		$seg_color_from = get_post_meta( $current_segmento->ID, '_color_from', true );
		$seg_color_to   = get_post_meta( $current_segmento->ID, '_color_to', true );
		$seg_icon       = get_post_meta( $current_segmento->ID, '_icon_emoji', true );
		$seg_label      = get_post_meta( $current_segmento->ID, '_badge_label', true );
		$seg_label      = $seg_label ? $seg_label : get_the_title( $current_segmento );
		?>
		<div class="segmento-stripe" style="background: linear-gradient(90deg, <?php echo esc_attr( $seg_color_from ? $seg_color_from : 'var(--blue)' ); ?>, <?php echo esc_attr( $seg_color_to ? $seg_color_to : 'var(--sky)' ); ?>);">
			<div class="container segmento-stripe-inner">
				<?php if ( $seg_icon ) : ?><span class="segmento-stripe-icon"><?php echo esc_html( $seg_icon ); ?></span><?php endif; ?>
				<span class="segmento-stripe-label"><?php echo esc_html( $seg_label ); ?></span>
			</div>
		</div>
	<?php endif; ?>
</header>
