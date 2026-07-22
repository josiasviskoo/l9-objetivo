<?php
/**
 * Template Name: Blog
 *
 * Listagem completa e paginada de posts, com filtro por categoria via link
 * (?blog_cat=slug) — destino do "Ver todas"/"Ver todos os artigos" da home.
 */
get_header();

$categories   = get_categories( array( 'hide_empty' => true ) );
$current_cat  = '';
if ( isset( $_GET['blog_cat'] ) ) {
	$maybe_cat = sanitize_title( wp_unslash( $_GET['blog_cat'] ) );
	foreach ( $categories as $cat ) {
		if ( $cat->slug === $maybe_cat ) {
			$current_cat = $maybe_cat;
			break;
		}
	}
}

$paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
$query = new WP_Query( array_filter( array(
	'post_type'      => 'post',
	'paged'          => $paged,
	'category_name'  => $current_cat,
) ) );
?>

<main id="content">
	<section class="page-hero">
		<div class="container">
			<h1><?php the_title(); ?></h1>
		</div>
	</section>

	<div class="container page-content">
		<?php if ( $categories ) : ?>
			<div class="blog-filters" style="margin-bottom:2.5rem;">
				<a href="<?php echo esc_url( remove_query_arg( 'blog_cat' ) ); ?>" class="blog-filter-btn<?php echo '' === $current_cat ? ' active' : ''; ?>"><?php esc_html_e( 'Todos', 'objetivo' ); ?></a>
				<?php foreach ( $categories as $cat ) : ?>
					<a href="<?php echo esc_url( add_query_arg( 'blog_cat', $cat->slug, remove_query_arg( 'blog_cat' ) ) ); ?>" class="blog-filter-btn<?php echo $current_cat === $cat->slug ? ' active' : ''; ?>"><?php echo esc_html( $cat->name ); ?></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $query->have_posts() ) : ?>
			<div class="blog-grid blog-grid-listing">
				<?php
				$i = 0;
				while ( $query->have_posts() ) :
					$query->the_post();
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
					<?php
					$i++;
				endwhile;
				?>
			</div>

			<div class="pagination">
				<?php
				echo wp_kses_post( paginate_links( array(
					'total'   => $query->max_num_pages,
					'current' => $paged,
					'mid_size' => 2,
					'prev_text' => '←',
					'next_text' => '→',
				) ) );
				?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( 'Nenhum artigo encontrado nesta categoria.', 'objetivo' ); ?></p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</main>

<?php get_footer(); ?>
