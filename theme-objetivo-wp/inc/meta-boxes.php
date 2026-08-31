<?php
/**
 * Meta box genérico orientado a config - evita repetir boilerplate de
 * add_meta_box()/save_post para cada um dos 6 Custom Post Types do tema.
 *
 * Uso: objetivo_register_cpt_meta_box( 'objetivo_ensino', $fields, 'Detalhes do card' );
 * onde $fields é um array de:
 *   [ 'key' => '_meta_key', 'label' => 'Rótulo', 'type' => 'text|textarea|checkbox|color|url|number|date|image', 'placeholder' => '...', 'help' => '...' ]
 *
 * O tipo 'image' guarda o ID do anexo (Biblioteca de Mídia) e usa o media
 * uploader nativo do WordPress - ver objetivo_enqueue_image_field_assets().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function objetivo_register_cpt_meta_box( $post_type, $fields, $title = '' ) {
	add_action(
		'add_meta_boxes',
		function () use ( $post_type, $fields, $title ) {
			add_meta_box(
				'objetivo_' . $post_type . '_fields',
				$title ? $title : __( 'Detalhes', 'objetivo' ),
				'objetivo_render_meta_box',
				$post_type,
				'normal',
				'high',
				array(
					'fields'    => $fields,
					'post_type' => $post_type,
				)
			);
		}
	);

	add_action(
		'save_post_' . $post_type,
		function ( $post_id ) use ( $fields, $post_type ) {
			objetivo_save_meta_box( $post_id, $fields, $post_type );
		}
	);

	$has_image_field = false;
	foreach ( $fields as $field ) {
		if ( 'image' === $field['type'] ) {
			$has_image_field = true;
			break;
		}
	}
	if ( $has_image_field ) {
		add_action(
			'admin_enqueue_scripts',
			function ( $hook ) use ( $post_type ) {
				if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
					return;
				}
				$screen = get_current_screen();
				if ( ! $screen || $post_type !== $screen->post_type ) {
					return;
				}
				objetivo_enqueue_image_field_assets();
			}
		);
	}
}

/**
 * Media uploader nativo para os campos do tipo 'image' - carregado só nas
 * telas de edição dos CPTs que de fato têm algum campo desse tipo.
 */
function objetivo_enqueue_image_field_assets() {
	wp_enqueue_media();
	wp_add_inline_script(
		'media-editor',
		"(function($){
			$(document).on('click', '.objetivo-image-field-select', function(e){
				e.preventDefault();
				var wrap = $(this).closest('.objetivo-image-field');
				var input = wrap.find('input[type=hidden]');
				var preview = wrap.find('.objetivo-image-field-preview');
				var removeBtn = wrap.find('.objetivo-image-field-remove');
				var frame = wp.media({
					title: '" . esc_js( __( 'Selecionar imagem', 'objetivo' ) ) . "',
					multiple: false,
					library: { type: 'image' }
				});
				frame.on('select', function(){
					var attachment = frame.state().get('selection').first().toJSON();
					input.val(attachment.id).trigger('change');
					var src = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;
					preview.html('<img src=\"' + src + '\" style=\"max-width:240px;height:auto;display:block;margin-bottom:.6rem;\">');
					removeBtn.show();
				});
				frame.open();
			});
			$(document).on('click', '.objetivo-image-field-remove', function(e){
				e.preventDefault();
				var wrap = $(this).closest('.objetivo-image-field');
				wrap.find('input[type=hidden]').val('').trigger('change');
				wrap.find('.objetivo-image-field-preview').empty();
				$(this).hide();
			});
		})(jQuery);"
	);
}

function objetivo_render_meta_box( $post, $box ) {
	$fields    = $box['args']['fields'];
	$post_type = $box['args']['post_type'];

	wp_nonce_field( 'objetivo_save_' . $post_type, 'objetivo_meta_nonce' );

	echo '<table class="form-table" role="presentation"><tbody>';
	foreach ( $fields as $field ) {
		$value = get_post_meta( $post->ID, $field['key'], true );
		echo '<tr>';
		echo '<th scope="row"><label for="' . esc_attr( $field['key'] ) . '">' . esc_html( $field['label'] ) . '</label></th>';
		echo '<td>';

		switch ( $field['type'] ) {
			case 'textarea':
				printf(
					'<textarea style="width:100%%;" rows="3" name="%1$s" id="%1$s" placeholder="%2$s">%3$s</textarea>',
					esc_attr( $field['key'] ),
					esc_attr( $field['placeholder'] ?? '' ),
					esc_textarea( $value )
				);
				break;

			case 'checkbox':
				printf(
					'<label><input type="checkbox" name="%1$s" id="%1$s" value="1" %2$s> %3$s</label>',
					esc_attr( $field['key'] ),
					checked( $value, '1', false ),
					esc_html( $field['description'] ?? '' )
				);
				break;

			case 'color':
				printf(
					'<input type="text" name="%1$s" id="%1$s" value="%2$s" placeholder="#1a4fac" style="width:120px;">',
					esc_attr( $field['key'] ),
					esc_attr( $value )
				);
				break;

			case 'url':
				printf(
					'<input type="url" style="width:100%%;" name="%1$s" id="%1$s" value="%2$s" placeholder="%3$s">',
					esc_attr( $field['key'] ),
					esc_attr( $value ),
					esc_attr( $field['placeholder'] ?? 'https://' )
				);
				break;

			case 'image':
				$attachment_id = (int) $value;
				$image_url     = $attachment_id ? wp_get_attachment_image_url( $attachment_id, 'medium' ) : '';
				printf(
					'<div class="objetivo-image-field">
						<input type="hidden" name="%1$s" id="%1$s" value="%2$s">
						<div class="objetivo-image-field-preview">%3$s</div>
						<button type="button" class="button objetivo-image-field-select">%4$s</button>
						<button type="button" class="button objetivo-image-field-remove" style="%5$s">%6$s</button>
					</div>',
					esc_attr( $field['key'] ),
					esc_attr( $attachment_id ),
					$image_url ? '<img src="' . esc_url( $image_url ) . '" style="max-width:240px;height:auto;display:block;margin-bottom:.6rem;">' : '',
					esc_html__( 'Selecionar imagem', 'objetivo' ),
					$attachment_id ? '' : 'display:none;',
					esc_html__( 'Remover imagem', 'objetivo' )
				);
				break;

			case 'number':
				printf(
					'<input type="number" name="%1$s" id="%1$s" value="%2$s">',
					esc_attr( $field['key'] ),
					esc_attr( $value )
				);
				break;

			case 'date':
				printf(
					'<input type="date" name="%1$s" id="%1$s" value="%2$s">',
					esc_attr( $field['key'] ),
					esc_attr( $value )
				);
				break;

			default:
				printf(
					'<input type="text" style="width:100%%;" name="%1$s" id="%1$s" value="%2$s" placeholder="%3$s">',
					esc_attr( $field['key'] ),
					esc_attr( $value ),
					esc_attr( $field['placeholder'] ?? '' )
				);
		}

		if ( ! empty( $field['help'] ) ) {
			echo '<p class="description">' . esc_html( $field['help'] ) . '</p>';
		}

		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

function objetivo_save_meta_box( $post_id, $fields, $post_type ) {
	if ( ! isset( $_POST['objetivo_meta_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['objetivo_meta_nonce'] ) ), 'objetivo_save_' . $post_type )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( $fields as $field ) {
		$key = $field['key'];

		if ( 'checkbox' === $field['type'] ) {
			update_post_meta( $post_id, $key, isset( $_POST[ $key ] ) ? '1' : '' );
			continue;
		}

		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}

		$raw = wp_unslash( $_POST[ $key ] );

		switch ( $field['type'] ) {
			case 'textarea':
				$clean = sanitize_textarea_field( $raw );
				break;
			case 'url':
				$clean = esc_url_raw( $raw );
				break;
			case 'color':
				$clean = sanitize_hex_color( $raw );
				break;
			case 'number':
				$clean = intval( $raw );
				break;
			case 'date':
				$clean = sanitize_text_field( $raw );
				break;
			case 'image':
				$clean = absint( $raw );
				break;
			default:
				$clean = sanitize_text_field( $raw );
		}

		if ( 'image' === $field['type'] && ! $clean ) {
			delete_post_meta( $post_id, $key );
			continue;
		}

		update_post_meta( $post_id, $key, $clean );
	}
}
