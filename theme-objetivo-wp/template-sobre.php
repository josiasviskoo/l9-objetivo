<?php
/**
 * Template Name: Nossa História
 *
 * Página institucional com a timeline em tela cheia (uma seção de 100vh
 * por marco) - destino do botão "Ver história completa" na home. Abre
 * direto na primeira tela do CPT objetivo_timeline, sem o banner genérico
 * de título, para manter a imersão; conteúdo extra digitado no editor da
 * página (se houver) continua aparecendo antes das telas.
 */
get_header();
?>

<main id="content">
	<?php while ( have_posts() ) : the_post();
		if ( objetivo_is_built_with_elementor() ) {
			the_content();
		} elseif ( get_the_content() ) { ?>
			<div class="container page-content">
				<?php the_content(); ?>
			</div>
		<?php }
	endwhile; ?>

	<?php get_template_part( 'template-parts/front/historia-fullscreen' ); ?>
</main>

<?php get_footer(); ?>
