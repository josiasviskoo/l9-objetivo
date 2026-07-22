<?php
/**
 * Arquivo de categoria/tag/data (ex.: /categoria/noticias/) — usa o mesmo
 * grid visual do template-blog.php.
 */
get_header();
?>

<main id="content">
	<section class="page-hero">
		<div class="container">
			<h1><?php the_archive_title(); ?></h1>
			<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
		</div>
	</section>

	<div class="container page-content">
		<?php if ( have_posts() ) : ?>
			<div class="blog-grid blog-grid-listing">
				<?php
				$i = 0;
				while ( have_posts() ) :
					the_post();
					$cats     = get_the_category();
					$cat_name = $cats ? $cats[0]->name : '';
					$img      = get_the_post_thumbnail_url( get_the_ID(), 'objetivo-card' );
					$bg       = $img ? "url('" . esc_url( $img ) . "')," : '';
					?>
					<a class="blog-post" href="<?php the_permalink(); ?>">
						<div class="blog-post-img" style="background: <?php echo esc_attr( $bg . objetivo_post_gradient( $i ) ); ?>; background-size:cover; background-position:center;">
							<?php if ( $cat_name ) : ?><span class="blog-post-tag"><?php echo esc_html( $cat_name ); ?></span><?php endif; ?>
						</div>
						<div class="blog-post-body">
							<div class="blog-post-date"><?php the_date(); ?></div>
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
			<p><?php esc_html_e( 'Nenhum conteúdo encontrado.', 'objetivo' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>
