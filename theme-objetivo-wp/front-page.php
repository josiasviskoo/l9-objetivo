<?php
/**
 * Home institucional — reproduz, seção por seção, o layout aprovado em
 * layout-apresentado/index.html. Cada template-part busca seu próprio
 * conteúdo (CPT ou Customizer) e não renderiza nada se não houver itens.
 */
get_header();
?>

<main id="content">
	<?php
	get_template_part( 'template-parts/front/hero' );
	get_template_part( 'template-parts/front/stats' );
	get_template_part( 'template-parts/front/ensino' );
	get_template_part( 'template-parts/front/motivos' );
	get_template_part( 'template-parts/front/vestibulares' );
	get_template_part( 'template-parts/front/matriculas-cta' );
	get_template_part( 'template-parts/front/egenio' );
	get_template_part( 'template-parts/front/noticias' );
	get_template_part( 'template-parts/front/segmentos' );
	get_template_part( 'template-parts/front/timeline' );
	get_template_part( 'template-parts/front/blog' );
	?>
</main>

<?php get_footer(); ?>
