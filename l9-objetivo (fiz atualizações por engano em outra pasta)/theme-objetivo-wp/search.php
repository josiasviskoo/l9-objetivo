<?php
/**
 * Resultados de busca.
 */
get_header();
?>

<main id="content">
	<section class="page-hero">
		<div class="container">
			<h1>
				<?php
				printf(
					/* translators: %s: search query, already escaped by get_search_query() */
					esc_html__( 'Resultados para: %s', 'objetivo' ),
					'<span>' . get_search_query() . '</span>'
				);
				?>
			</h1>
		</div>
	</section>

	<div class="container page-content">
		<?php if ( have_posts() ) : ?>
			<div class="blog-grid blog-grid-listing">
				<?php
				$i = 0;
				while ( have_posts() ) :
					the_post();
					$img = get_the_post_thumbnail_url( get_the_ID(), 'objetivo-card' );
					$bg  = $img ? "url('" . esc_url( $img ) . "')," : '';
					?>
					<a class="blog-post" href="<?php the_permalink(); ?>">
						<div class="blog-post-img" style="background: <?php echo esc_attr( $bg . objetivo_post_gradient( $i ) ); ?>; background-size:cover; background-position:center;"></div>
						<div class="blog-post-body">
							<h4><?php the_title(); ?></h4>
							<p><?php echo esc_html( get_the_excerpt() ); ?></p>
							<span class="blog-post-read"><?php esc_html_e( 'Ler mais', 'objetivo' ); ?> →</span>
						</div>
					</a>
					<?php $i++; endwhile; ?>
			</div>
			<div class="pagination">
				<?php the_posts_pagination( array( 'prev_text' => '←', 'next_text' => '→' ) ); ?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( 'Nenhum resultado encontrado. Tente outros termos.', 'objetivo' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>
