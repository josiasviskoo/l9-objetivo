<?php
/**
 * Post individual do blog.
 */
get_header();
?>

<main id="content">
	<?php while ( have_posts() ) : the_post(); ?>
		<section class="page-hero page-hero-post">
			<div class="container">
				<?php
				$cats = get_the_category();
				if ( $cats ) :
					?>
					<p class="post-cat"><?php echo esc_html( $cats[0]->name ); ?></p>
				<?php endif; ?>
				<h1><?php the_title(); ?></h1>
				<p class="post-meta"><?php the_date(); ?> <?php the_author(); ?></p>
			</div>
		</section>

		<div class="container page-content single-post-content">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="single-post-thumb">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<?php the_content(); ?>

			<?php
			wp_link_pages( array(
				'before' => '<nav class="page-links">' . esc_html__( 'Páginas:', 'objetivo' ),
				'after'  => '</nav>',
			) );
			?>

			<div class="post-tags">
				<?php the_tags( '<span class="tag">', '</span> <span class="tag">', '</span>' ); ?>
			</div>

			<?php if ( comments_open() || get_comments_number() ) : ?>
				<?php comments_template(); ?>
			<?php endif; ?>
		</div>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
