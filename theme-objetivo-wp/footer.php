<?php
/**
 * Rodapé (marca, ícones sociais, menu principal replicado, contato e
 * créditos).
 */

// Ícones sociais disponíveis - reaproveitados nas duas linhas (Objetivo e
// Objetivo Júnior). Threads é um glifo de texto ("@", igual ao ícone do
// app) em vez de SVG, pra não depender de um path complexo.
$objetivo_social_icons = array(
	'instagram' => array(
		'Instagram',
		'<svg viewBox="0 0 24 24"><path d="M12 2.2c3.2 0 3.58.01 4.85.07 1.17.05 1.97.24 2.43.4a4.9 4.9 0 011.77 1.15 4.9 4.9 0 011.15 1.77c.16.46.35 1.26.4 2.43.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.24 1.97-.4 2.43a4.9 4.9 0 01-1.15 1.77 4.9 4.9 0 01-1.77 1.15c-.46.16-1.26.35-2.43.4-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.97-.24-2.43-.4a4.9 4.9 0 01-1.77-1.15 4.9 4.9 0 01-1.15-1.77c-.16-.46-.35-1.26-.4-2.43C2.21 15.58 2.2 15.2 2.2 12s.01-3.58.07-4.85c.05-1.17.24-1.97.4-2.43A4.9 4.9 0 013.82 3l.01-.01a4.9 4.9 0 011.77-1.15c.46-.16 1.26-.35 2.43-.4C9.3 2.24 9.68 2.2 12 2.2zm0 1.8c-3.14 0-3.52.01-4.76.07-.96.04-1.48.2-1.82.33-.46.18-.79.39-1.13.73-.34.34-.55.67-.73 1.13-.13.34-.29.86-.33 1.82C3.17 8.48 3.16 8.86 3.16 12s.01 3.52.07 4.76c.04.96.2 1.48.33 1.82.18.46.39.79.73 1.13.34.34.67.55 1.13.73.34.13.86.29 1.82.33 1.24.06 1.6.07 4.76.07s3.52-.01 4.76-.07c.96-.04 1.48-.2 1.82-.33a3.1 3.1 0 001.13-.73c.34-.34.55-.67.73-1.13.13-.34.29-.86.33-1.82.06-1.24.07-1.6.07-4.76s-.01-3.52-.07-4.76c-.04-.96-.2-1.48-.33-1.82a3.1 3.1 0 00-.73-1.13 3.1 3.1 0 00-1.13-.73c-.34-.13-.86-.29-1.82-.33C15.52 4.01 15.15 4 12 4zm0 3.4a4.6 4.6 0 110 9.2 4.6 4.6 0 010-9.2zm0 1.8a2.8 2.8 0 100 5.6 2.8 2.8 0 000-5.6zm5.85-2a1.08 1.08 0 11-2.16 0 1.08 1.08 0 012.16 0z"/></svg>',
	),
	'facebook'  => array(
		'Facebook',
		'<svg viewBox="0 0 24 24"><path d="M13.5 21.9v-8.1h2.72l.4-3.16h-3.12V8.62c0-.91.25-1.53 1.56-1.53h1.67V4.26c-.29-.04-1.28-.12-2.44-.12-2.41 0-4.06 1.47-4.06 4.17v2.33H7.5v3.16h2.73v8.1h3.27z"/></svg>',
	),
	'threads'   => array(
		'Threads',
		'<span class="social-glyph" aria-hidden="true">@</span>',
	),
	'youtube'   => array(
		'YouTube',
		'<svg viewBox="0 0 24 24"><path d="M23.5 7.2s-.23-1.64-.94-2.36c-.9-.95-1.9-.94-2.36-1C16.9 3.6 12 3.6 12 3.6s-4.9 0-8.2.24c-.46.05-1.46.05-2.36 1C.63 5.56.4 7.2.4 7.2S.16 9.12.16 11.05v1.8c0 1.93.24 3.85.24 3.85s.23 1.64.94 2.36c.9.95 2.08.92 2.6 1.02 1.9.18 8.06.24 8.06.24s4.9-.01 8.2-.25c.46-.05 1.46-.05 2.36-1 .71-.72.94-2.36.94-2.36s.24-1.92.24-3.85v-1.8c0-1.93-.24-3.85-.24-3.85zM9.7 14.9V8.4l6.2 3.26-6.2 3.25z"/></svg>',
	),
	'linkedin'  => array(
		'LinkedIn',
		'<svg viewBox="0 0 24 24"><path d="M4.98 3.5a2.5 2.5 0 110 5.001 2.5 2.5 0 010-5zM3.2 9.5h3.56V21H3.2V9.5zM9.7 9.5h3.41v1.57h.05c.48-.9 1.64-1.85 3.38-1.85 3.61 0 4.28 2.32 4.28 5.35V21h-3.56v-5.5c0-1.31-.02-3-1.85-3-1.85 0-2.13 1.42-2.13 2.9V21H9.7V9.5z"/></svg>',
	),
);

// Linha de cima (Objetivo, unidade normal) e linha de baixo (Objetivo
// Júnior) - mesma ordem Instagram/Facebook/Threads nas duas, sem rótulo de
// texto: o alinhamento à esquerda já deixa claro que são pares.
$objetivo_social_rows = array(
	array( 'instagram' => 'instagram_url', 'facebook' => 'facebook_url', 'threads' => 'threads_url', 'youtube' => 'youtube_url', 'linkedin' => 'linkedin_url' ),
	array( 'instagram' => 'instagram_junior_url', 'facebook' => 'facebook_junior_url', 'threads' => 'threads_junior_url' ),
);
?>

<footer>
	<div class="container">
		<div class="footer-top">
			<div class="footer-brand">
				<img src="<?php echo esc_url( objetivo_theme_image( 'logo-branco.png' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" style="height:44px;width:auto;margin-bottom:1.4rem;display:block;" />
				<p><?php echo esc_html( objetivo_opt( 'footer', 'brand_desc' ) ); ?></p>
				<div class="socials-group">
					<?php foreach ( $objetivo_social_rows as $row ) : ?>
						<div class="socials">
							<?php foreach ( $row as $network => $field_key ) :
								$url = objetivo_opt( 'footer', $field_key );
								if ( ! $url || ! isset( $objetivo_social_icons[ $network ] ) ) {
									continue;
								}
								list( $label, $icon_markup ) = $objetivo_social_icons[ $network ];
								?>
								<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr( $label ); ?>" aria-label="<?php echo esc_attr( $label ); ?>"><?php echo $icon_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG/glifo fixo definido acima, mesmo padrão dos ícones de telefone/WhatsApp em header.php. ?></a>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="footer-col footer-col-menu">
				<h4><?php esc_html_e( 'Menu', 'objetivo' ); ?></h4>
				<?php
				// Mesmo menu "Principal" do cabeçalho (theme_location "primary") -
				// qualquer alteração feita em Aparência → Menus aparece nas duas
				// listagens automaticamente, sem precisar manter um menu à parte
				// só para o rodapé.
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'footer-menu-replica',
					'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
					'depth'          => 2,
					'fallback_cb'    => false,
				) );
				?>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Contato', 'objetivo' ); ?></h4>
				<div class="footer-contact">
					<a href="tel:<?php echo esc_attr( objetivo_opt( 'contato', 'phone_tel' ) ); ?>"><?php echo esc_html( objetivo_opt( 'contato', 'phone_display' ) ); ?></a>
					<a href="https://wa.me/<?php echo esc_attr( objetivo_opt( 'contato', 'whatsapp_number' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( objetivo_opt( 'contato', 'whatsapp_display' ) ); ?></a>
					<?php if ( objetivo_opt( 'contato', 'whatsapp_junior_number' ) ) : ?>
						<a href="https://wa.me/<?php echo esc_attr( objetivo_opt( 'contato', 'whatsapp_junior_number' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( objetivo_opt( 'contato', 'whatsapp_junior_display' ) ); ?></a>
					<?php endif; ?>
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
