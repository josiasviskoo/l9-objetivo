<?php
/**
 * Template Name: Nossa História
 *
 * Página institucional com a timeline interativa completa — destino do
 * botão "Ver história completa" na home.
 */
get_header();
?>

<main id="content">
	<?php while ( have_posts() ) : the_post();
		if ( objetivo_is_built_with_elementor() ) :
			the_content();
		else : ?>
			<section class="page-hero">
				<div class="container">
					<h1><?php the_title(); ?></h1>
				</div>
			</section>
			<?php if ( get_the_content() ) : ?>
				<div class="container page-content">
					<?php the_content(); ?>
				</div>
			<?php endif;
		endif;
	endwhile; ?>

	<?php get_template_part( 'template-parts/front/timeline' ); ?>
</main>

<?php get_footer(); ?>
