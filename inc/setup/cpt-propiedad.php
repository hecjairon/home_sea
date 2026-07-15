<?php
/**
 * Custom post type — Propiedad.
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
function homesea_theme_propiedad_post_type(): string {
	return 'propiedad';
}

/**
 * Default badge color (terracotta).
 */
function homesea_theme_propiedad_default_badge_color(): string {
	return '#C45C26';
}

/**
 * Register CPT propiedad.
 */
function homesea_theme_register_cpt_propiedad(): void {
	$labels = array(
		'name'               => __( 'Propiedades', 'homesea_theme' ),
		'singular_name'      => __( 'Propiedad', 'homesea_theme' ),
		'add_new'            => __( 'Añadir nueva', 'homesea_theme' ),
		'add_new_item'       => __( 'Añadir propiedad', 'homesea_theme' ),
		'edit_item'          => __( 'Editar propiedad', 'homesea_theme' ),
		'new_item'           => __( 'Nueva propiedad', 'homesea_theme' ),
		'view_item'          => __( 'Ver propiedad', 'homesea_theme' ),
		'search_items'       => __( 'Buscar propiedades', 'homesea_theme' ),
		'not_found'          => __( 'No se encontraron propiedades', 'homesea_theme' ),
		'not_found_in_trash' => __( 'No hay propiedades en la papelera', 'homesea_theme' ),
		'menu_name'          => __( 'Propiedades', 'homesea_theme' ),
		'all_items'          => __( 'Todas las propiedades', 'homesea_theme' ),
	);

	register_post_type(
		homesea_theme_propiedad_post_type(),
		array(
			'labels'              => $labels,
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => false,
			'has_archive'         => 'propiedades',
			'exclude_from_search' => false,
			'hierarchical'        => false,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-building',
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'rewrite'             => array(
				'slug'       => 'propiedad',
				'with_front' => false,
			),
			'capability_type'     => 'post',
		)
	);
}
add_action( 'init', 'homesea_theme_register_cpt_propiedad' );

/**
 * Flush rewrite rules when the theme is activated.
 */
function homesea_theme_propiedad_flush_rewrites(): void {
	homesea_theme_register_cpt_propiedad();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'homesea_theme_propiedad_flush_rewrites' );

/**
 * One-time rewrite flush after CPT / editor changes.
 */
function homesea_theme_propiedad_maybe_flush_rewrites(): void {
	$flag = 'homesea_theme_propiedad_rewrite_flushed_v3';

	if ( get_option( $flag ) ) {
		return;
	}

	homesea_theme_register_cpt_propiedad();
	flush_rewrite_rules( false );
	update_option( $flag, '1', false );
}
add_action( 'init', 'homesea_theme_propiedad_maybe_flush_rewrites', 20 );

/**
 * Remove "Add Media" from the propiedad editor (images use CMB2 gallery).
 */
function homesea_theme_propiedad_disable_editor_media(): void {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

	if ( ! $screen || homesea_theme_propiedad_post_type() !== $screen->post_type ) {
		return;
	}

	remove_action( 'media_buttons', 'media_buttons' );
}
add_action( 'admin_head', 'homesea_theme_propiedad_disable_editor_media' );

/**
 * Archive URL for the propiedad collection.
 */
function homesea_theme_propiedad_archive_url(): string {
	$url = get_post_type_archive_link( homesea_theme_propiedad_post_type() );

	return $url ? esc_url_raw( (string) $url ) : esc_url_raw( home_url( '/propiedades/' ) );
}

/**
 * Resolve badge color hex from post meta (supports legacy badge_variant).
 *
 * @param int $post_id Post ID.
 */
function homesea_theme_propiedad_badge_color( int $post_id ): string {
	$color = sanitize_hex_color( (string) get_post_meta( $post_id, 'badge_color', true ) );

	if ( $color ) {
		return $color;
	}

	$legacy = sanitize_text_field( (string) get_post_meta( $post_id, 'badge_variant', true ) );
	$map    = array(
		'terracotta' => '#C45C26',
		'gold'       => '#C9A227',
		'navy'       => '#1B2A4A',
	);

	return $map[ $legacy ] ?? homesea_theme_propiedad_default_badge_color();
}

/**
 * Register CMB2 metabox on CPT propiedad.
 */
function homesea_theme_cmb2_propiedad_metabox(): void {
	if ( ! function_exists( 'new_cmb2_box' ) ) {
		return;
	}

	$cmb = new_cmb2_box(
		array(
			'id'           => 'homesea_theme_propiedad_details',
			'title'        => __( 'Datos del listado', 'homesea_theme' ),
			'object_types' => array( homesea_theme_propiedad_post_type() ),
			'context'      => 'normal',
			'priority'     => 'high',
		)
	);

	$cmb->add_field(
		array(
			'name'         => __( 'Galería de imágenes', 'homesea_theme' ),
			'desc'         => __( 'Imágenes del carrusel en la ficha de la propiedad. La imagen destacada se usa solo en listados.', 'homesea_theme' ),
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
			'default'         => 'En venta',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_field(
		array(
			'name'       => __( 'Color del badge', 'homesea_theme' ),
			'id'         => 'badge_color',
			'type'       => 'colorpicker',
			'default'    => homesea_theme_propiedad_default_badge_color(),
			'attributes' => array(
				'data-colorpicker' => wp_json_encode(
					array(
						'palettes' => array( '#C45C26', '#C9A227', '#1B2A4A', '#FFFFFF', '#2C3E50' ),
					)
				),
			),
		)
	);

	$cmb->add_field(
		array(
			'name'            => __( 'Precio', 'homesea_theme' ),
			'id'              => 'price',
			'type'            => 'text',
			'attributes'      => array(
				'placeholder' => '€ 1.850.000',
			),
			'sanitization_cb' => 'sanitize_text_field',
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

	$cmb->add_field(
		array(
			'name'            => __( 'Dormitorios', 'homesea_theme' ),
			'id'              => 'beds',
			'type'            => 'text_small',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_field(
		array(
			'name'            => __( 'Baños', 'homesea_theme' ),
			'id'              => 'baths',
			'type'            => 'text_small',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_field(
		array(
			'name'            => __( 'Área', 'homesea_theme' ),
			'id'              => 'area',
			'type'            => 'text',
			'attributes'      => array(
				'placeholder' => '480 m²',
			),
			'sanitization_cb' => 'sanitize_text_field',
		)
	);
}
add_action( 'cmb2_admin_init', 'homesea_theme_cmb2_propiedad_metabox' );

/**
 * Resolve featured image URL for a post.
 *
 * @param int    $post_id Post ID.
 * @param string $size    Image size.
 */
function homesea_theme_propiedad_image_url( int $post_id, string $size = 'large' ): string {
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
 * Gallery images for a propiedad (CMB2 file_list).
 *
 * @param int    $post_id Post ID.
 * @param string $size    Image size.
 * @return array<int, array{url: string, alt: string}>
 */
function homesea_theme_propiedad_gallery_images( int $post_id, string $size = 'full' ): array {
	$raw = get_post_meta( $post_id, 'gallery_images', true );

	if ( ! is_array( $raw ) || empty( $raw ) ) {
		return array();
	}

	$images  = array();
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
 * Map a propiedad post to a listing card (no description).
 *
 * @param WP_Post $post Propiedad post.
 * @return array<string, mixed>
 */
function homesea_theme_propiedad_to_item( WP_Post $post ): array {
	$thumb_id  = (int) get_post_thumbnail_id( $post );
	$image_url = homesea_theme_propiedad_image_url( (int) $post->ID, 'large' );
	$image_alt = $thumb_id ? (string) get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ) : '';

	if ( '' === $image_alt ) {
		$image_alt = get_the_title( $post );
	}

	return array(
		'id'          => (int) $post->ID,
		'title'       => sanitize_text_field( get_the_title( $post ) ),
		'image_url'   => $image_url,
		'image_alt'   => sanitize_text_field( $image_alt ),
		'badge'       => sanitize_text_field( (string) get_post_meta( $post->ID, 'badge', true ) ),
		'badge_color' => homesea_theme_propiedad_badge_color( (int) $post->ID ),
		'price'       => sanitize_text_field( (string) get_post_meta( $post->ID, 'price', true ) ),
		'location'    => sanitize_text_field( (string) get_post_meta( $post->ID, 'location', true ) ),
		'beds'        => (int) get_post_meta( $post->ID, 'beds', true ),
		'baths'       => (int) get_post_meta( $post->ID, 'baths', true ),
		'area'        => sanitize_text_field( (string) get_post_meta( $post->ID, 'area', true ) ),
		'details_url' => esc_url_raw( (string) get_permalink( $post ) ),
	);
}

/**
 * Map a propiedad post to a single-page payload (includes description).
 *
 * @param WP_Post $post Propiedad post.
 * @return array<string, mixed>
 */
function homesea_theme_propiedad_to_detail( WP_Post $post ): array {
	$item = homesea_theme_propiedad_to_item( $post );

	$content = $post->post_content;
	$content = apply_filters( 'the_content', $content );

	$full    = homesea_theme_propiedad_image_url( (int) $post->ID, 'full' );
	$gallery = homesea_theme_propiedad_gallery_images( (int) $post->ID, 'full' );

	$item['description'] = $content;
	$item['image_url']   = $full !== '' ? $full : $item['image_url'];
	$item['images']      = $gallery;

	return $item;
}

/**
 * Normalize stored home_properties option into a list of post IDs (duplicates allowed).
 * Supports group rows `{ propiedad_id }` and flat ID lists.
 *
 * @param mixed $raw Raw option value.
 * @return array<int, int>
 */
function homesea_theme_normalize_home_property_ids( mixed $raw ): array {
	if ( ! is_array( $raw ) ) {
		return array();
	}

	$ids = array();

	foreach ( $raw as $row ) {
		if ( is_array( $row ) ) {
			$id = absint( $row['propiedad_id'] ?? $row['id'] ?? 0 );
		} else {
			$id = absint( $row );
		}

		if ( $id < 1 ) {
			continue;
		}

		if ( homesea_theme_propiedad_post_type() !== get_post_type( $id ) ) {
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
function homesea_theme_propiedad_select_options(): array {
	$posts = get_posts(
		array(
			'post_type'              => homesea_theme_propiedad_post_type(),
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
		'' => __( '— Seleccionar propiedad —', 'homesea_theme' ),
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
 * Sanitize propiedad ID inside a group row.
 *
 * @param mixed $value Raw value.
 */
function homesea_theme_sanitize_propiedad_id( mixed $value ): string {
	$id = absint( $value );

	if ( $id < 1 ) {
		return '';
	}

	if ( homesea_theme_propiedad_post_type() !== get_post_type( $id ) ) {
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
function homesea_theme_query_propiedad_items( array $ids = array(), int $limit = 6 ): array {
	$ids = array_values(
		array_filter(
			array_map( 'absint', $ids )
		)
	);

	if ( empty( $ids ) ) {
		$limit = max( 1, min( 50, $limit ) );
		$query = new WP_Query(
			array(
				'post_type'              => homesea_theme_propiedad_post_type(),
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

			$item = homesea_theme_propiedad_to_item( $post );

			if ( '' === $item['image_url'] && '' === $item['price'] ) {
				continue;
			}

			$item['list_key'] = (string) $post->ID . '-' . (string) $index;
			$items[]          = $item;
		}

		return $items;
	}

	$unique_ids = array_values( array_unique( $ids ) );

	$query = new WP_Query(
		array(
			'post_type'              => homesea_theme_propiedad_post_type(),
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

		$item = homesea_theme_propiedad_to_item( $post );

		if ( '' === $item['image_url'] && '' === $item['price'] ) {
			continue;
		}

		$by_id[ (int) $post->ID ] = $item;
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
 * All published propiedades for the collection archive.
 *
 * @return array<int, array<string, mixed>>
 */
function homesea_theme_query_propiedad_collection(): array {
	return homesea_theme_query_propiedad_items( array(), 100 );
}
