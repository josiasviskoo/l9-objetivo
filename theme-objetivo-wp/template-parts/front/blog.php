<?php
/**
 * Seção "Novidades do Objetivo" — grid de posts reais com filtro de
 * categoria (assets/js/blog-filter.js) e link "Ler mais" para o permalink
 * de verdade (substitui o painel falso do protótipo).
 */
$posts = get_posts( array(
	'post_type'      => 'post',
	'posts_per_page' => 6,
) );
if ( ! $posts ) {
	return;
}
$categories = get_categories( array( 'hide_empty' => true ) );
?>
<section id="blog">
	<div class="container">
		<div class="blog-header">
			<div>
				<p class="section-label"><?php echo esc_html( objetivo_opt( 'sec_blog', 'label' ) ); ?></p>
				<h2 class="section-title" style="margin-bottom:.4rem;"><?php echo objetivo_kses_em( objetivo_opt( 'sec_blog', 'title' ) ); ?></h2>
				<p class="blog-subtitle"><?php echo esc_html( objetivo_opt( 'sec_blog', 'desc' ) ); ?></p>
			</div>
			<?php if ( $categories ) : ?>
				<div class="blog-filters">
					<button type="button" class="blog-filter-btn active" data-cat="todos"><?php esc_html_e( 'Todos', 'objetivo' ); ?></button>
					<?php foreach ( $categories as $cat ) : ?>
						<button type="button" class="blog-filter-btn" data-cat="<?php echo esc_attr( $cat->slug ); ?>"><?php echo esc_html( $cat->name ); ?></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<div id="blog-grid" class="blog-grid">
			<?php foreach ( $posts as $i => $post ) :
				setup_postdata( $post );
				$cats     = get_the_category( $post->ID );
				$cat_slug = $cats ? $cats[0]->slug : '';
				$cat_name = $cats ? $cats[0]->name : '';
				$img      = get_the_post_thumbnail_url( $post, 'objetivo-card' );
				$bg       = $img ? "url('" . esc_url( $img ) . "')," : '';
				?>
				<a class="blog-post<?php echo 0 === $i ? ' blog-post-featured' : ''; ?>" data-cat="<?php echo esc_attr( $cat_slug ); ?>" href="<?php echo esc_url( get_permalink( $post ) ); ?>">
					<div class="blog-post-img" style="background: <?php echo esc_attr( $bg . objetivo_post_gradient( $i ) ); ?>; background-size:cover; background-position:center;">
						<?php if ( $cat_name ) : ?><span class="blog-post-tag"><?php echo 0 === $i ? '📌 ' : ''; ?><?php echo esc_html( $cat_name ); ?></span><?php endif; ?>
						<?php if ( 0 === $i ) : ?>
							<div class="blog-post-overlay-text">
								<div class="blog-post-date"><?php echo esc_html( get_the_date( '', $post ) ); ?> · <?php echo esc_html( $cat_name ); ?></div>
								<h3><?php echo esc_html( get_the_title( $post ) ); ?></h3>
							</div>
						<?php endif; ?>
					</div>
					<div class="blog-post-body">
						<?php if ( 0 !== $i ) : ?>
							<div class="blog-post-date"><?php echo esc_html( get_the_date( '', $post ) ); ?></div>
							<h4><?php echo esc_html( get_the_title( $post ) ); ?></h4>
						<?php else : ?>
							<p><?php echo esc_html( get_the_excerpt( $post ) ); ?></p>
						<?php endif; ?>
						<span class="blog-post-read"><?php esc_html_e( 'Ler mais', 'objetivo' ); ?> →</span>
					</div>
				</a>
			<?php endforeach; wp_reset_postdata(); ?>
		</div>

		<div style="text-align:center;margin-top:2.5rem;">
			<a href="<?php echo esc_url( objetivo_get_blog_page_url() ); ?>" class="btn-navy"><?php esc_html_e( 'Ver todos os artigos', 'objetivo' ); ?> →</a>
		</div>
	</div>
</section>
