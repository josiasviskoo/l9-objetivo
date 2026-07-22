<?php
/**
 * Fallback obrigatório do tema (WordPress exige index.php). Como
 * front-page.php sempre assume a página inicial, este arquivo só entra em
 * cena em contextos incomuns — mantém o mesmo grid do archive.php.
 */
get_header();
?>

<main id="content">
	<div class="container page-content" style="padding-top:3rem;">
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
							<div class="blog-post-date"><?php the_date(); ?></div>
							<h4><?php the_title(); ?></h4>
							<span class="blog-post-read"><?php esc_html_e( 'Ler mais', 'objetivo' ); ?> →</span>
						</div>
					</a>
					<?php $i++; endwhile; ?>
			</div>
			<div class="pagination">
				<?php the_posts_pagination( array( 'prev_text' => '←', 'next_text' => '→' ) ); ?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( 'Nenhum conteúdo encontrado.', 'objetivo' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>
