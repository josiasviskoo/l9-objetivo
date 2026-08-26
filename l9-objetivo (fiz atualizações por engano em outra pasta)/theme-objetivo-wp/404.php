<?php
/**
 * Página 404.
 */
get_header();
?>

<main id="content">
	<section class="page-hero">
		<div class="container">
			<h1><?php esc_html_e( 'Página não encontrada', 'objetivo' ); ?></h1>
		</div>
	</section>

	<div class="container page-content" style="text-align:center;">
		<p style="font-size:1.05rem;color:var(--muted);max-width:520px;margin:0 auto 2rem;">
			<?php esc_html_e( 'O conteúdo que você procura não existe ou foi movido. Use a busca abaixo ou volte para a home.', 'objetivo' ); ?>
		</p>
		<?php get_search_form(); ?>
		<p style="margin-top:2rem;">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary" style="background:var(--navy);color:var(--white);"><?php esc_html_e( 'Voltar para a Home', 'objetivo' ); ?></a>
		</p>
	</div>
</main>

<?php get_footer(); ?>
