<?php
/**
 * Template genérico de página: banner de marca + conteúdo do editor.
 * Cobre as páginas que o admin cria a partir dos itens de menu do
 * protótipo (Sobre o Objetivo, Proposta Pedagógica, Convênios, etc.).
 */
get_header();
?>

<main id="content">
	<?php while ( have_posts() ) : the_post(); ?>
		<section class="page-hero">
			<div class="container">
				<h1><?php the_title(); ?></h1>
			</div>
		</section>
		<div class="container page-content">
			<?php the_content(); ?>
			<?php
			wp_link_pages( array(
				'before' => '<nav class="page-links">' . esc_html__( 'Páginas:', 'objetivo' ),
				'after'  => '</nav>',
			) );
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</div>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
