<?php
/**
 * Lista de comentários + formulário, para posts do blog.
 */
if ( post_password_required() ) {
	return;
}
?>
<div class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
			printf(
				/* translators: %s: number of comments */
				esc_html( _n( '%s comentário', '%s comentários', get_comments_number(), 'objetivo' ) ),
				esc_html( number_format_i18n( get_comments_number() ) )
			);
			?>
		</h3>
		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
			) );
			?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Os comentários estão encerrados.', 'objetivo' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>
</div>
