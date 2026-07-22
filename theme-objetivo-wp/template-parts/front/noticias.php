<?php
/**
 * Seção "Últimas Notícias" — 3 posts reais mais recentes (o primeiro em
 * destaque), com fallback de gradiente quando não há imagem destacada.
 */
$posts = get_posts( array(
	'post_type'      => 'post',
	'posts_per_page' => 3,
) );
if ( ! $posts ) {
	return;
}
?>
<section class="noticias">
	<div class="container">
		<div class="noticias-header">
			<div>
				<p class="section-label"><?php echo esc_html( objetivo_opt( 'sec_noticias', 'label' ) ); ?></p>
				<h2 class="section-title"><?php echo objetivo_kses_em( objetivo_opt( 'sec_noticias', 'title' ) ); ?></h2>
			</div>
			<a class="noticias-link" href="<?php echo esc_url( objetivo_get_blog_page_url() ); ?>"><?php echo esc_html( objetivo_opt( 'sec_noticias', 'ver_todas_label' ) ); ?> →</a>
		</div>
		<div class="noticias-grid">
			<?php foreach ( $posts as $i => $post ) :
				setup_postdata( $post );
				$img       = get_the_post_thumbnail_url( $post, 'objetivo-card' );
				$bg        = $img ? "url('" . esc_url( $img ) . "')," : '';
				$cats      = get_the_category( $post->ID );
				$cat_name  = $cats ? $cats[0]->name : '';
				?>
				<a class="noticia-card<?php echo 0 === $i ? ' featured' : ''; ?>" href="<?php echo esc_url( get_permalink( $post ) ); ?>">
					<div class="noticia-img" style="background: <?php echo esc_attr( $bg . objetivo_post_gradient( $i ) ); ?>; background-size:cover; background-position:center;">
						<?php if ( $cat_name ) : ?><span class="noticia-tag"><?php echo esc_html( $cat_name ); ?></span><?php endif; ?>
					</div>
					<div class="noticia-body">
						<div class="noticia-date">📅 <?php echo esc_html( get_the_date( 'Y', $post ) ); ?><?php echo 0 === $i ? ' · ' . esc_html__( 'Destaque', 'objetivo' ) : ''; ?></div>
						<h3 class="noticia-title"><?php echo esc_html( get_the_title( $post ) ); ?></h3>
						<span class="noticia-read"><?php esc_html_e( 'Leia mais', 'objetivo' ); ?> →</span>
					</div>
				</a>
			<?php endforeach; wp_reset_postdata(); ?>
		</div>
	</div>
</section>
