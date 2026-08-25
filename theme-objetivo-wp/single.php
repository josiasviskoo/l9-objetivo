<?php
/**
 * Post individual do blog.
 */
get_header();
?>

<main id="content">
	<?php while ( have_posts() ) : the_post(); ?>
		<section class="page-hero page-hero-post<?php echo has_post_thumbnail() ? ' has-cover' : ''; ?>">
			<div class="container">
				<div class="article-meta">
					<?php
					$cats = get_the_category();
					if ( $cats ) :
						?>
						<span class="post-cat"><?php echo esc_html( $cats[0]->name ); ?></span>
					<?php endif; ?>
					<span class="post-meta"><?php the_date(); ?> · <?php the_author(); ?></span>
				</div>
				<h1><?php the_title(); ?></h1>
			</div>
		</section>

		<div class="container single-post-content">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="article-cover">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<div class="article-body">
				<?php the_content(); ?>

				<?php
				wp_link_pages( array(
					'before' => '<nav class="page-links">' . esc_html__( 'Páginas:', 'objetivo' ),
					'after'  => '</nav>',
				) );
				?>

				<?php if ( get_the_tags() ) : ?>
					<div class="post-tags">
						<?php the_tags( '<span class="tag">', '</span> <span class="tag">', '</span>' ); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( comments_open() || get_comments_number() ) : ?>
				<?php comments_template(); ?>
			<?php endif; ?>
		</div>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
