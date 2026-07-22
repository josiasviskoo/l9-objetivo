<?php
/**
 * Barra de convênio + rodapé (marca, colunas de menu gerenciáveis via
 * Aparência → Menus, contato e créditos).
 */
$convenio_label = objetivo_opt( 'convenio', 'label' );
?>
<?php if ( $convenio_label ) : ?>
<div class="convenio-bar">
	<a href="<?php echo esc_url( objetivo_opt( 'convenio', 'url' ) ); ?>">⭐ <?php echo esc_html( $convenio_label ); ?> →</a>
</div>
<?php endif; ?>

<footer>
	<div class="container">
		<div class="footer-top">
			<div class="footer-brand">
				<img src="<?php echo esc_url( objetivo_theme_image( 'logo-branco.png' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" style="height:44px;width:auto;margin-bottom:1.4rem;display:block;" />
				<p><?php echo esc_html( objetivo_opt( 'footer', 'brand_desc' ) ); ?></p>
				<div class="socials">
					<?php
					$socials = array(
						'instagram_url' => array( '📷', 'Instagram' ),
						'facebook_url'  => array( 'f', 'Facebook' ),
						'youtube_url'   => array( '▶', 'YouTube' ),
						'linkedin_url'  => array( 'in', 'LinkedIn' ),
					);
					foreach ( $socials as $key => $social ) :
						list( $icon, $label ) = $social;
						$url = objetivo_opt( 'footer', $key );
						if ( ! $url ) {
							continue;
						}
						?>
						<a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( $label ); ?>"><?php echo esc_html( $icon ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Ensino', 'objetivo' ); ?></h4>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer-ensino',
					'container'      => false,
					'menu_class'     => '',
					'items_wrap'     => '<ul>%3$s</ul>',
					'depth'          => 1,
					'fallback_cb'    => false,
				) );
				?>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Vestibulares', 'objetivo' ); ?></h4>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer-vestibulares',
					'container'      => false,
					'menu_class'     => '',
					'items_wrap'     => '<ul>%3$s</ul>',
					'depth'          => 1,
					'fallback_cb'    => false,
				) );
				?>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Contato', 'objetivo' ); ?></h4>
				<div class="footer-contact">
					<a href="tel:<?php echo esc_attr( objetivo_opt( 'contato', 'phone_tel' ) ); ?>"><?php echo esc_html( objetivo_opt( 'contato', 'phone_display' ) ); ?></a>
					<a href="https://wa.me/<?php echo esc_attr( objetivo_opt( 'contato', 'whatsapp_number' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( objetivo_opt( 'contato', 'whatsapp_display' ) ); ?></a>
					<a href="<?php echo esc_url( objetivo_opt( 'contato', 'atendimento_url' ) ); ?>"><?php esc_html_e( 'Central de Atendimento', 'objetivo' ); ?></a>
					<?php if ( objetivo_opt( 'header', 'area_restrita_url' ) ) : ?>
						<a href="<?php echo esc_url( objetivo_opt( 'header', 'area_restrita_url' ) ); ?>"><?php esc_html_e( 'Área Restrita', 'objetivo' ); ?></a>
					<?php endif; ?>
					<a href="#"><?php echo esc_html( objetivo_opt( 'contato', 'address_label' ) ); ?></a>
				</div>
			</div>
		</div>

		<?php
		$developed_by     = objetivo_opt( 'footer', 'developed_by' );
		$developed_by_url = objetivo_opt( 'footer', 'developed_by_url' );
		?>
		<div class="footer-bottom">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( objetivo_opt( 'footer', 'copyright' ) ); ?></span>
			<?php if ( $developed_by ) : ?>
				<span>
					<?php esc_html_e( 'Desenvolvido por', 'objetivo' ); ?>
					<?php if ( $developed_by_url ) : ?>
						<a href="<?php echo esc_url( $developed_by_url ); ?>" target="_blank" rel="noopener noreferrer" style="color:#e8a020;font-weight:700;"><?php echo esc_html( $developed_by ); ?></a>
					<?php else : ?>
						<strong style="color:#e8a020;"><?php echo esc_html( $developed_by ); ?></strong>
					<?php endif; ?>
				</span>
			<?php endif; ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
