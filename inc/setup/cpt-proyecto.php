<?php
/**
 * Custom post type — Proyecto.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post type slug.
 */
function homesea_theme_proyecto_post_type(): string {
	return 'proyecto';
}

/**
 * Register CPT proyecto.
 */
function homesea_theme_register_cpt_proyecto(): void {
	$labels = array(
		'name'               => __( 'Proyectos', 'homesea_theme' ),
		'singular_name'      => __( 'Proyecto', 'homesea_theme' ),
		'add_new'            => __( 'Añadir nuevo', 'homesea_theme' ),
		'add_new_item'       => __( 'Añadir proyecto', 'homesea_theme' ),
		'edit_item'          => __( 'Editar proyecto', 'homesea_theme' ),
		'new_item'           => __( 'Nuevo proyecto', 'homesea_theme' ),
		'view_item'          => __( 'Ver proyecto', 'homesea_theme' ),
		'search_items'       => __( 'Buscar proyectos', 'homesea_theme' ),
		'not_found'          => __( 'No se encontraron proyectos', 'homesea_theme' ),
		'not_found_in_trash' => __( 'No hay proyectos en la papelera', 'homesea_theme' ),
		'menu_name'          => __( 'Proyectos', 'homesea_theme' ),
		'all_items'          => __( 'Todos los proyectos', 'homesea_theme' ),
	);

	register_post_type(
		homesea_theme_proyecto_post_type(),
		array(
			'labels'              => $labels,
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => false,
			'has_archive'         => 'proyectos',
			'exclude_from_search' => false,
			'hierarchical'        => false,
			'menu_position'       => 21,
			'menu_icon'           => 'dashicons-portfolio',
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'rewrite'             => array(
				'slug'       => 'proyecto',
				'with_front' => false,
			),
			'capability_type'     => 'post',
		)
	);
}
add_action( 'init', 'homesea_theme_register_cpt_proyecto' );

/**
 * Flush rewrite rules when the theme is activated.
 */
function homesea_theme_proyecto_flush_rewrites(): void {
	homesea_theme_register_cpt_proyecto();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'homesea_theme_proyecto_flush_rewrites' );

/**
 * One-time rewrite flush after CPT registration.
 */
function homesea_theme_proyecto_maybe_flush_rewrites(): void {
	$flag = 'homesea_theme_proyecto_rewrite_flushed_v1';

	if ( get_option( $flag ) ) {
		return;
	}

	homesea_theme_register_cpt_proyecto();
	flush_rewrite_rules( false );
	update_option( $flag, '1', false );
}
add_action( 'init', 'homesea_theme_proyecto_maybe_flush_rewrites', 20 );

/**
 * Remove "Add Media" from the proyecto editor (images use CMB2 gallery).
 */
function homesea_theme_proyecto_disable_editor_media(): void {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

	if ( ! $screen || homesea_theme_proyecto_post_type() !== $screen->post_type ) {
		return;
	}

	remove_action( 'media_buttons', 'media_buttons' );
}
add_action( 'admin_head', 'homesea_theme_proyecto_disable_editor_media' );

/**
 * Archive URL for the proyecto collection.
 */
function homesea_theme_proyecto_archive_url(): string {
	$url = get_post_type_archive_link( homesea_theme_proyecto_post_type() );

	return $url ? esc_url_raw( (string) $url ) : esc_url_raw( home_url( '/proyectos/' ) );
}

/**
 * Allowed badge variants for proyecto cards.
 *
 * @return array<string, string>
 */
function homesea_theme_proyecto_badge_variants(): array {
	return array(
		'terracotta' => __( 'Terracotta', 'homesea_theme' ),
		'gold'       => __( 'Oro', 'homesea_theme' ),
		'navy'       => __( 'Navy', 'homesea_theme' ),
	);
}

/**
 * Sanitize badge variant.
 *
 * @param mixed $value Raw value.
 */
function homesea_theme_sanitize_proyecto_badge_variant( mixed $value ): string {
	$key = sanitize_text_field( (string) $value );

	return array_key_exists( $key, homesea_theme_proyecto_badge_variants() ) ? $key : 'terracotta';
}

/**
 * Register CMB2 metabox on CPT proyecto.
 */
function homesea_theme_cmb2_proyecto_metabox(): void {
	if ( ! function_exists( 'new_cmb2_box' ) ) {
		return;
	}

	$cmb = new_cmb2_box(
		array(
			'id'           => 'homesea_theme_proyecto_details',
			'title'        => __( 'Datos del listado', 'homesea_theme' ),
			'object_types' => array( homesea_theme_proyecto_post_type() ),
			'context'      => 'normal',
			'priority'     => 'high',
		)
	);

	$cmb->add_field(
		array(
			'name'         => __( 'Galería de imágenes', 'homesea_theme' ),
			'desc'         => __( 'Imágenes del carrusel en la ficha del proyecto. La imagen destacada se usa en listados y como fondo del hero.', 'homesea_theme' ),
			'id'           => 'gallery_images',
			'type'         => 'file_list',
			'preview_size' => array( 150, 150 ),
			'query_args'   => array(
				'type' => array( 'image/jpeg', 'image/png', 'image/webp' ),
			),
			'text'         => array(
				'add_upload_files_text' => __( 'Añadir imágenes', 'homesea_theme' ),
			),
		)
	);

	$cmb->add_field(
		array(
			'name'            => __( 'Badge', 'homesea_theme' ),
			'id'              => 'badge',
			'type'            => 'text',
			'default'         => 'En construcción',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_field(
		array(
			'name'            => __( 'Variante del badge', 'homesea_theme' ),
			'id'              => 'badge_variant',
			'type'            => 'select',
			'default'         => 'terracotta',
			'options'         => homesea_theme_proyecto_badge_variants(),
			'sanitization_cb' => 'homesea_theme_sanitize_proyecto_badge_variant',
		)
	);

	$cmb->add_field(
		array(
			'name'            => __( 'Ubicación', 'homesea_theme' ),
			'id'              => 'location',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);
}
add_action( 'cmb2_admin_init', 'homesea_theme_cmb2_proyecto_metabox' );

/**
 * Resolve featured image URL for a post.
 *
 * @param int    $post_id Post ID.
 * @param string $size    Image size.
 */
function homesea_theme_proyecto_image_url( int $post_id, string $size = 'large' ): string {
	$thumb_id = (int) get_post_thumbnail_id( $post_id );

	if ( $thumb_id < 1 ) {
		return '';
	}

	$url = wp_get_attachment_image_url( $thumb_id, $size );

	if ( ! $url ) {
		$url = wp_get_attachment_url( $thumb_id );
	}

	return $url ? esc_url_raw( (string) $url ) : '';
}

/**
 * Gallery images for a proyecto (CMB2 file_list).
 *
 * @param int    $post_id Post ID.
 * @param string $size    Image size.
 * @return array<int, array{url: string, alt: string}>
 */
function homesea_theme_proyecto_gallery_images( int $post_id, string $size = 'full' ): array {
	$raw = get_post_meta( $post_id, 'gallery_images', true );

	if ( ! is_array( $raw ) || empty( $raw ) ) {
		return array();
	}

	$images      = array();
	$default_alt = sanitize_text_field( get_the_title( $post_id ) );

	foreach ( $raw as $attachment_key => $fallback_url ) {
		$attachment_id = is_numeric( $attachment_key ) ? (int) $attachment_key : 0;
		$url           = '';
		$alt           = $default_alt;

		if ( $attachment_id > 0 ) {
			$url = wp_get_attachment_image_url( $attachment_id, $size );
			if ( ! $url ) {
				$url = wp_get_attachment_url( $attachment_id );
			}
			$meta_alt = (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
			if ( '' !== $meta_alt ) {
				$alt = sanitize_text_field( $meta_alt );
			}
		} elseif ( is_string( $fallback_url ) && '' !== $fallback_url ) {
			$url = $fallback_url;
		}

		if ( ! $url ) {
			continue;
		}

		$images[] = array(
			'url' => esc_url_raw( (string) $url ),
			'alt' => $alt,
		);
	}

	return $images;
}

/**
 * Map a proyecto post to a listing card (no description / gallery).
 *
 * @param WP_Post $post Proyecto post.
 * @return array<string, mixed>
 */
function homesea_theme_proyecto_to_item( WP_Post $post ): array {
	$thumb_id  = (int) get_post_thumbnail_id( $post );
	$image_url = homesea_theme_proyecto_image_url( (int) $post->ID, 'large' );
	$image_alt = $thumb_id ? (string) get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ) : '';
	$permalink = esc_url_raw( (string) get_permalink( $post ) );

	if ( '' === $image_alt ) {
		$image_alt = get_the_title( $post );
	}

	return array(
		'id'            => (int) $post->ID,
		'title'         => sanitize_text_field( get_the_title( $post ) ),
		'image_url'     => $image_url,
		'image_alt'     => sanitize_text_field( $image_alt ),
		'badge'         => sanitize_text_field( (string) get_post_meta( $post->ID, 'badge', true ) ),
		'badge_variant' => homesea_theme_sanitize_proyecto_badge_variant( get_post_meta( $post->ID, 'badge_variant', true ) ),
		'location'      => sanitize_text_field( (string) get_post_meta( $post->ID, 'location', true ) ),
		'url'           => $permalink,
		'details_url'   => $permalink,
	);
}

/**
 * Map a proyecto post to a single-page payload.
 *
 * @param WP_Post $post Proyecto post.
 * @return array<string, mixed>
 */
function homesea_theme_proyecto_to_detail( WP_Post $post ): array {
	$item = homesea_theme_proyecto_to_item( $post );

	$content = apply_filters( 'the_content', $post->post_content );
	$full    = homesea_theme_proyecto_image_url( (int) $post->ID, 'full' );
	$gallery = homesea_theme_proyecto_gallery_images( (int) $post->ID, 'full' );

	$item['description'] = $content;
	$item['image_url']   = $full !== '' ? $full : $item['image_url'];
	$item['images']      = $gallery;

	return $item;
}

/**
 * Normalize stored home_projects option into a list of post IDs (duplicates allowed).
 *
 * @param mixed $raw Raw option value.
 * @return array<int, int>
 */
function homesea_theme_normalize_home_project_ids( mixed $raw ): array {
	if ( ! is_array( $raw ) ) {
		return array();
	}

	$ids = array();

	foreach ( $raw as $row ) {
		if ( is_array( $row ) ) {
			$id = absint( $row['proyecto_id'] ?? $row['id'] ?? 0 );
		} else {
			$id = absint( $row );
		}

		if ( $id < 1 ) {
			continue;
		}

		if ( homesea_theme_proyecto_post_type() !== get_post_type( $id ) ) {
			continue;
		}

		$ids[] = $id;
	}

	return $ids;
}

/**
 * Options for admin select: post ID => title.
 *
 * @return array<string, string>
 */
function homesea_theme_proyecto_select_options(): array {
	$posts = get_posts(
		array(
			'post_type'              => homesea_theme_proyecto_post_type(),
			'post_status'            => array( 'publish', 'draft', 'pending', 'private' ),
			'posts_per_page'         => 100,
			'orderby'                => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	$options = array(
		'' => __( '— Seleccionar proyecto —', 'homesea_theme' ),
	);

	foreach ( $posts as $post ) {
		$label = get_the_title( $post );
		if ( '' === $label ) {
			$label = sprintf(
				/* translators: %d: post ID */
				__( '(Sin título) #%d', 'homesea_theme' ),
				(int) $post->ID
			);
		}
		$options[ (string) $post->ID ] = $label;
	}

	return $options;
}

/**
 * Sanitize proyecto ID inside a group row.
 *
 * @param mixed $value Raw value.
 */
function homesea_theme_sanitize_proyecto_id( mixed $value ): string {
	$id = absint( $value );

	if ( $id < 1 ) {
		return '';
	}

	if ( homesea_theme_proyecto_post_type() !== get_post_type( $id ) ) {
		return '';
	}

	return (string) $id;
}

/**
 * Build listing items from selected IDs (order preserved; duplicates allowed).
 * Empty selection → recent published.
 *
 * @param array<int, int|string> $ids   Selected post IDs (may contain repeats).
 * @param int                    $limit Fallback query limit when none selected.
 * @return array<int, array<string, mixed>>
 */
function homesea_theme_query_proyecto_items( array $ids = array(), int $limit = 6 ): array {
	$ids = array_values(
		array_filter(
			array_map( 'absint', $ids )
		)
	);

	if ( empty( $ids ) ) {
		$limit = max( 1, min( 50, $limit ) );
		$query = new WP_Query(
			array(
				'post_type'              => homesea_theme_proyecto_post_type(),
				'post_status'            => 'publish',
				'posts_per_page'         => $limit,
				'orderby'                => array(
					'menu_order' => 'ASC',
					'title'      => 'ASC',
				),
				'no_found_rows'          => true,
				'update_post_meta_cache' => true,
				'update_post_term_cache' => false,
			)
		);

		$items = array();

		foreach ( $query->posts as $index => $post ) {
			if ( ! $post instanceof WP_Post ) {
				continue;
			}

			$item             = homesea_theme_proyecto_to_item( $post );
			$item['list_key'] = (string) $post->ID . '-' . (string) $index;
			$items[]          = $item;
		}

		return $items;
	}

	$unique_ids = array_values( array_unique( $ids ) );

	$query = new WP_Query(
		array(
			'post_type'              => homesea_theme_proyecto_post_type(),
			'post_status'            => 'publish',
			'post__in'               => $unique_ids,
			'orderby'                => 'post__in',
			'posts_per_page'         => count( $unique_ids ),
			'no_found_rows'          => true,
			'update_post_meta_cache' => true,
			'update_post_term_cache' => false,
		)
	);

	$by_id = array();

	foreach ( $query->posts as $post ) {
		if ( ! $post instanceof WP_Post ) {
			continue;
		}

		$by_id[ (int) $post->ID ] = homesea_theme_proyecto_to_item( $post );
	}

	$items = array();

	foreach ( $ids as $index => $id ) {
		if ( ! isset( $by_id[ $id ] ) ) {
			continue;
		}

		$item             = $by_id[ $id ];
		$item['list_key'] = (string) $id . '-' . (string) $index;
		$items[]          = $item;
	}

	return $items;
}

/**
 * All published proyectos for the collection archive.
 *
 * @return array<int, array<string, mixed>>
 */
function homesea_theme_query_proyecto_collection(): array {
	return homesea_theme_query_proyecto_items( array(), 100 );
}
