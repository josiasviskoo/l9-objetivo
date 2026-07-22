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

<div class="topbar">
	<div class="topbar-inner">
		<div class="topbar-left">
			<a href="tel:<?php echo esc_attr( objetivo_opt( 'contato', 'phone_tel' ) ); ?>">
				<svg viewBox="0 0 24 24"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
				<?php echo esc_html( objetivo_opt( 'contato', 'phone_display' ) ); ?>
			</a>
			<a href="https://wa.me/<?php echo esc_attr( objetivo_opt( 'contato', 'whatsapp_number' ) ); ?>" target="_blank" rel="noopener noreferrer">
				<svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.063.526 4.009 1.449 5.71L.099 23.14c-.099.411.265.774.677.677l5.431-1.35A11.93 11.93 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.79 9.79 0 01-5.002-1.369l-.358-.213-3.72.924.94-3.625-.234-.371A9.794 9.794 0 012.182 12C2.182 6.589 6.589 2.182 12 2.182S21.818 6.589 21.818 12 17.411 21.818 12 21.818z"/></svg>
				<?php echo esc_html( objetivo_opt( 'contato', 'whatsapp_display' ) ); ?>
			</a>
			<a href="#">📍 <?php echo esc_html( objetivo_opt( 'contato', 'address_label' ) ); ?></a>
		</div>
		<div class="topbar-right">
			<a href="<?php echo esc_url( objetivo_opt( 'contato', 'atendimento_url' ) ); ?>"><?php esc_html_e( 'Atendimento', 'objetivo' ); ?></a>
			<?php if ( has_nav_menu( 'topbar' ) ) : ?>
				<?php wp_nav_menu( array( 'theme_location' => 'topbar', 'container' => false, 'menu_class' => 'topbar-menu', 'depth' => 1 ) ); ?>
			<?php endif; ?>
			<a href="<?php echo esc_url( objetivo_opt( 'contato', 'topbar_cta_url' ) ); ?>" class="topbar-cta"><?php echo esc_html( objetivo_opt( 'contato', 'topbar_cta_label' ) ); ?></a>
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

			<?php
			$financeiro_url     = objetivo_opt( 'header', 'financeiro_url' );
			$area_restrita_url  = objetivo_opt( 'header', 'area_restrita_url' );
			if ( $financeiro_url || $area_restrita_url ) :
				?>
				<div class="header-actions">
					<?php if ( $financeiro_url ) : ?>
						<a href="<?php echo esc_url( $financeiro_url ); ?>" class="btn-area-restrita btn-financeiro"><?php esc_html_e( 'Financeiro', 'objetivo' ); ?></a>
					<?php endif; ?>
					<?php if ( $area_restrita_url ) : ?>
						<a href="<?php echo esc_url( $area_restrita_url ); ?>" class="btn-area-restrita"><?php esc_html_e( 'Área Restrita', 'objetivo' ); ?></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</header>
