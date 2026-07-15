<?php
/**
 * REST API — GET /wp-json/theme/v1/site
 *
 * Assembles nested Casa Noble JSON from CMB2 options (flat keys + groups),
 * falling back to defaults when options are empty.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once HOMESEA_THEME_DIR . '/inc/api/site-defaults.php';

/**
 * Register site endpoint.
 */
function homesea_theme_register_rest_routes(): void {
	register_rest_route(
		'theme/v1',
		'/site',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => 'homesea_theme_rest_site_payload',
			'permission_callback' => '__return_true',
		)
	);
}
add_action( 'rest_api_init', 'homesea_theme_register_rest_routes' );

/**
 * Text option or default when empty string / null / false.
 *
 * @param string $section Section slug.
 * @param string $key     Field id.
 * @param mixed  $default Default.
 * @return mixed
 */
function homesea_theme_opt( string $section, string $key, mixed $default = '' ): mixed {
	$value = homesea_theme_get_option( $section, $key, null );

	if ( null === $value || false === $value || '' === $value ) {
		return $default;
	}

	return $value;
}

/**
 * Sanitize URL allowing in-page anchors (#contacto).
 *
 * @param mixed $value Raw URL.
 */
function homesea_theme_safe_url( mixed $value ): string {
	$url = trim( (string) $value );

	if ( '' === $url ) {
		return '';
	}

	if ( str_starts_with( $url, '#' ) ) {
		return sanitize_text_field( $url );
	}

	return esc_url_raw( $url );
}

/**
 * Normalize CMB2 file / URL field.
 *
 * @param mixed $value Raw value.
 */
function homesea_theme_file_url( mixed $value ): string {
	if ( is_array( $value ) && isset( $value['url'] ) ) {
		return esc_url_raw( (string) $value['url'] );
	}

	if ( is_numeric( $value ) ) {
		$url = wp_get_attachment_url( (int) $value );

		return $url ? esc_url_raw( $url ) : '';
	}

	if ( is_string( $value ) && '' !== $value ) {
		return esc_url_raw( $value );
	}

	return '';
}

/**
 * Normalize link groups {label,url}[,icon].
 *
 * @param mixed $items Raw.
 * @param bool  $with_icon Include icon.
 * @return array<int, array<string, string>>
 */
function homesea_theme_normalize_links( mixed $items, bool $with_icon = false ): array {
	if ( ! is_array( $items ) ) {
		return array();
	}

	$out = array();

	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}

		$label = isset( $item['label'] ) ? sanitize_text_field( (string) $item['label'] ) : '';
		$url   = isset( $item['url'] ) ? homesea_theme_safe_url( $item['url'] ) : '';

		if ( '' === $label && '' === $url ) {
			continue;
		}

		$row = array(
			'label' => $label,
			'url'   => $url,
		);

		if ( $with_icon ) {
			$icon = (string) ( $item['icon'] ?? '' );
			$row['icon'] = function_exists( 'homesea_theme_sanitize_footer_social_icon' )
				? homesea_theme_sanitize_footer_social_icon( $icon )
				: sanitize_text_field( $icon );
		}

		$out[] = $row;
	}

	return $out;
}

/**
 * Value/label pairs (search types).
 *
 * @param mixed $items Raw.
 * @return array<int, array{value: string, label: string}>
 */
function homesea_theme_normalize_value_label( mixed $items ): array {
	if ( ! is_array( $items ) ) {
		return array();
	}

	$out = array();

	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}

		$value = sanitize_text_field( (string) ( $item['value'] ?? '' ) );
		$label = sanitize_text_field( (string) ( $item['label'] ?? '' ) );

		if ( '' === $value && '' === $label ) {
			continue;
		}

		$out[] = array(
			'value' => $value,
			'label' => $label,
		);
	}

	return $out;
}

/**
 * Build header slice.
 *
 * @param array<string, mixed> $defaults Defaults.
 * @return array<string, mixed>
 */
function homesea_theme_rest_header( array $defaults ): array {
	$nav = homesea_theme_normalize_links( homesea_theme_get_option( 'header', 'nav', array() ) );

	if ( empty( $nav ) ) {
		$nav = $defaults['nav'];
	}

	return array(
		'logo_text_parts' => array(
			'first'  => sanitize_text_field( (string) homesea_theme_opt( 'header', 'logo_first', $defaults['logo_text_parts']['first'] ) ),
			'second' => sanitize_text_field( (string) homesea_theme_opt( 'header', 'logo_second', $defaults['logo_text_parts']['second'] ) ),
		),
		'nav'       => $nav,
		'cta_label' => sanitize_text_field( (string) homesea_theme_opt( 'header', 'cta_label', $defaults['cta_label'] ) ),
		'cta_url'   => homesea_theme_safe_url( homesea_theme_opt( 'header', 'cta_url', $defaults['cta_url'] ) ),
	);
}

/**
 * Build hero slice.
 *
 * @param array<string, mixed> $defaults Defaults.
 * @return array<string, mixed>
 */
function homesea_theme_rest_hero( array $defaults ): array {
	$image = homesea_theme_file_url( homesea_theme_get_option( 'hero', 'image_url', '' ) );
	$types = homesea_theme_normalize_value_label( homesea_theme_get_option( 'hero', 'search_types', array() ) );

	if ( empty( $types ) ) {
		$types = $defaults['search']['types'];
	}

	return array(
		'image_url'       => '' !== $image ? $image : (string) $defaults['image_url'],
		'image_alt'       => sanitize_text_field( (string) homesea_theme_opt( 'hero', 'image_alt', $defaults['image_alt'] ) ),
		'eyebrow'         => sanitize_text_field( (string) homesea_theme_opt( 'hero', 'eyebrow', $defaults['eyebrow'] ) ),
		'title'           => sanitize_text_field( (string) homesea_theme_opt( 'hero', 'title', $defaults['title'] ) ),
		'subtitle'        => sanitize_textarea_field( (string) homesea_theme_opt( 'hero', 'subtitle', $defaults['subtitle'] ) ),
		'primary_label'   => sanitize_text_field( (string) homesea_theme_opt( 'hero', 'primary_label', $defaults['primary_label'] ) ),
		'primary_url'     => homesea_theme_safe_url( homesea_theme_opt( 'hero', 'primary_url', $defaults['primary_url'] ) ),
		'secondary_label' => sanitize_text_field( (string) homesea_theme_opt( 'hero', 'secondary_label', $defaults['secondary_label'] ) ),
		'secondary_url'   => homesea_theme_safe_url( homesea_theme_opt( 'hero', 'secondary_url', $defaults['secondary_url'] ) ),
		'search'          => array(
			'title'        => sanitize_text_field( (string) homesea_theme_opt( 'hero', 'search_title', $defaults['search']['title'] ) ),
			'description'  => sanitize_text_field( (string) homesea_theme_opt( 'hero', 'search_description', $defaults['search']['description'] ) ),
			'types'        => $types,
			'submit_label' => sanitize_text_field( (string) homesea_theme_opt( 'hero', 'search_submit_label', $defaults['search']['submit_label'] ) ),
		),
	);
}

/**
 * Normalize Stats icon to a known key.
 */
function homesea_theme_rest_stats_icon( mixed $icon ): string {
	if ( function_exists( 'homesea_theme_sanitize_stats_icon' ) ) {
		return homesea_theme_sanitize_stats_icon( $icon );
	}

	$key     = sanitize_text_field( (string) $icon );
	$allowed = array( 'home', 'users', 'clock', 'star' );

	return in_array( $key, $allowed, true ) ? $key : 'home';
}

/**
 * Build stats slice.
 *
 * @param array<string, mixed> $defaults Defaults.
 * @return array<string, mixed>
 */
function homesea_theme_rest_stats( array $defaults ): array {
	$raw   = homesea_theme_get_option( 'stats', 'items', array() );
	$items = array();

	if ( is_array( $raw ) ) {
		foreach ( $raw as $index => $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}

			$label = sanitize_text_field( (string) ( $item['label'] ?? '' ) );
			if ( '' === $label ) {
				continue;
			}

			$icon  = homesea_theme_rest_stats_icon( $item['icon'] ?? 'home' );
			$id    = sanitize_title( $label );
			$value = sanitize_text_field( (string) ( $item['value'] ?? '' ) );

			if ( '' === $id ) {
				$id = 'stat-' . ( (int) $index + 1 );
			}

			$items[] = array(
				'id'    => $id,
				'label' => $label,
				'value' => $value,
				'icon'  => $icon,
			);
		}
	}

	return array(
		'items' => empty( $items ) ? $defaults['items'] : $items,
	);
}

/**
 * Build properties slice (items from selected CPT propiedad posts).
 *
 * @param array<string, mixed> $defaults Defaults.
 * @return array<string, mixed>
 */
function homesea_theme_rest_properties( array $defaults ): array {
	$raw = homesea_theme_get_option( 'properties', 'home_properties', array() );
	$ids = function_exists( 'homesea_theme_normalize_home_property_ids' )
		? homesea_theme_normalize_home_property_ids( $raw )
		: array();

	$items = array();

	if ( function_exists( 'homesea_theme_query_propiedad_items' ) ) {
		$items = homesea_theme_query_propiedad_items( $ids, 6 );
	}

	$catalog_url = homesea_theme_opt( 'properties', 'catalog_url', $defaults['catalog_url'] );
	$catalog_url = homesea_theme_safe_url( $catalog_url );
	if ( ( '' === $catalog_url || '#' === $catalog_url ) && function_exists( 'homesea_theme_propiedad_archive_url' ) ) {
		$catalog_url = homesea_theme_propiedad_archive_url();
	}

	return array(
		'eyebrow'       => sanitize_text_field( (string) homesea_theme_opt( 'properties', 'eyebrow', $defaults['eyebrow'] ) ),
		'title'         => sanitize_text_field( (string) homesea_theme_opt( 'properties', 'title', $defaults['title'] ) ),
		'catalog_label' => sanitize_text_field( (string) homesea_theme_opt( 'properties', 'catalog_label', $defaults['catalog_label'] ) ),
		'catalog_url'   => $catalog_url,
		'items'         => empty( $items ) ? $defaults['items'] : $items,
	);
}

/**
 * Build about slice.
 *
 * @param array<string, mixed> $defaults Defaults.
 * @return array<string, mixed>
 */
function homesea_theme_rest_about( array $defaults ): array {
	$raw   = homesea_theme_get_option( 'about', 'items', array() );
	$items = array();

	if ( is_array( $raw ) ) {
		foreach ( $raw as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}

			$title = sanitize_text_field( (string) ( $item['title'] ?? '' ) );
			if ( '' === $title ) {
				continue;
			}

			$icon = function_exists( 'homesea_theme_sanitize_about_icon' )
				? homesea_theme_sanitize_about_icon( $item['icon'] ?? 'heart' )
				: sanitize_text_field( (string) ( $item['icon'] ?? 'heart' ) );

			$items[] = array(
				'title'       => $title,
				'description' => sanitize_textarea_field( (string) ( $item['description'] ?? '' ) ),
				'icon'        => $icon,
			);
		}
	}

	return array(
		'eyebrow' => sanitize_text_field( (string) homesea_theme_opt( 'about', 'eyebrow', $defaults['eyebrow'] ) ),
		'title'   => sanitize_text_field( (string) homesea_theme_opt( 'about', 'title', $defaults['title'] ) ),
		'body'    => sanitize_textarea_field( (string) homesea_theme_opt( 'about', 'body', $defaults['body'] ) ),
		'items'   => empty( $items ) ? $defaults['items'] : $items,
	);
}

/**
 * Build projects slice (items from selected CPT proyecto posts).
 *
 * @param array<string, mixed> $defaults Defaults.
 * @return array<string, mixed>
 */
function homesea_theme_rest_projects( array $defaults ): array {
	$raw = homesea_theme_get_option( 'projects', 'home_projects', array() );
	$ids = function_exists( 'homesea_theme_normalize_home_project_ids' )
		? homesea_theme_normalize_home_project_ids( $raw )
		: array();

	$items = array();

	if ( function_exists( 'homesea_theme_query_proyecto_items' ) ) {
		$items = homesea_theme_query_proyecto_items( $ids, 6 );
	}

	$catalog_url = homesea_theme_opt( 'projects', 'catalog_url', $defaults['catalog_url'] ?? '' );
	$catalog_url = homesea_theme_safe_url( $catalog_url );
	if ( ( '' === $catalog_url || '#' === $catalog_url ) && function_exists( 'homesea_theme_proyecto_archive_url' ) ) {
		$catalog_url = homesea_theme_proyecto_archive_url();
	}

	return array(
		'eyebrow'       => sanitize_text_field( (string) homesea_theme_opt( 'projects', 'eyebrow', $defaults['eyebrow'] ) ),
		'title'         => sanitize_text_field( (string) homesea_theme_opt( 'projects', 'title', $defaults['title'] ) ),
		'catalog_label' => sanitize_text_field( (string) homesea_theme_opt( 'projects', 'catalog_label', $defaults['catalog_label'] ?? 'Ver todos los proyectos' ) ),
		'catalog_url'   => $catalog_url,
		'items'         => empty( $items ) ? $defaults['items'] : $items,
	);
}

/**
 * Build testimonials slice.
 *
 * @param array<string, mixed> $defaults Defaults.
 * @return array<string, mixed>
 */
function homesea_theme_rest_testimonials( array $defaults ): array {
	$raw   = homesea_theme_get_option( 'testimonials', 'items', array() );
	$items = array();

	if ( is_array( $raw ) ) {
		foreach ( $raw as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}

			$quote = sanitize_textarea_field( (string) ( $item['quote'] ?? '' ) );
			$name  = sanitize_text_field( (string) ( $item['name'] ?? '' ) );

			if ( '' === $quote && '' === $name ) {
				continue;
			}

			$items[] = array(
				'quote'      => $quote,
				'name'       => $name,
				'location'   => sanitize_text_field( (string) ( $item['location'] ?? '' ) ),
				'avatar_url' => homesea_theme_file_url( $item['avatar_url'] ?? '' ),
				'rating'     => (int) ( $item['rating'] ?? 5 ),
			);
		}
	}

	return array(
		'eyebrow' => sanitize_text_field( (string) homesea_theme_opt( 'testimonials', 'eyebrow', $defaults['eyebrow'] ) ),
		'title'   => sanitize_text_field( (string) homesea_theme_opt( 'testimonials', 'title', $defaults['title'] ) ),
		'items'   => empty( $items ) ? $defaults['items'] : $items,
	);
}

/**
 * Build process slice.
 *
 * @param array<string, mixed> $defaults Defaults.
 * @return array<string, mixed>
 */
function homesea_theme_rest_process( array $defaults ): array {
	$raw   = homesea_theme_get_option( 'process', 'steps', array() );
	$steps = array();

	if ( is_array( $raw ) ) {
		foreach ( $raw as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}

			$title = sanitize_text_field( (string) ( $item['title'] ?? '' ) );
			if ( '' === $title ) {
				continue;
			}

			$icon = function_exists( 'homesea_theme_sanitize_process_icon' )
				? homesea_theme_sanitize_process_icon( $item['icon'] ?? 'search' )
				: sanitize_text_field( (string) ( $item['icon'] ?? 'search' ) );

			$steps[] = array(
				'number'      => sanitize_text_field( (string) ( $item['number'] ?? '' ) ),
				'title'       => $title,
				'description' => sanitize_text_field( (string) ( $item['description'] ?? '' ) ),
				'icon'        => $icon,
			);
		}
	}

	return array(
		'eyebrow' => sanitize_text_field( (string) homesea_theme_opt( 'process', 'eyebrow', $defaults['eyebrow'] ) ),
		'title'   => sanitize_text_field( (string) homesea_theme_opt( 'process', 'title', $defaults['title'] ) ),
		'steps'   => empty( $steps ) ? $defaults['steps'] : $steps,
	);
}

/**
 * Build location slice.
 *
 * @param array<string, mixed> $defaults Defaults.
 * @return array<string, mixed>
 */
function homesea_theme_rest_location( array $defaults ): array {
	return array(
		'title'     => sanitize_text_field( (string) homesea_theme_opt( 'location', 'title', $defaults['title'] ) ),
		'address'   => sanitize_textarea_field( (string) homesea_theme_opt( 'location', 'address', $defaults['address'] ) ),
		'maps_url'  => homesea_theme_safe_url( homesea_theme_opt( 'location', 'maps_url', $defaults['maps_url'] ) ),
		'cta_label' => sanitize_text_field( (string) homesea_theme_opt( 'location', 'cta_label', $defaults['cta_label'] ) ),
	);
}

/**
 * Build contact slice.
 *
 * @param array<string, mixed> $defaults Defaults.
 * @return array<string, mixed>
 */
function homesea_theme_rest_contact( array $defaults ): array {
	$fl  = $defaults['form_labels'];
	$cf7 = function_exists( 'homesea_theme_cf7_contact_config' )
		? homesea_theme_cf7_contact_config()
		: array(
			'enabled'  => false,
			'form_id'  => 0,
			'rest_url' => '',
			'unit_tag' => '',
			'locale'   => '',
			'version'  => '',
			'fields'   => array(
				'nombre'   => 'your-name',
				'correo'   => 'your-email',
				'telefono' => 'your-phone',
				'mensaje'  => 'your-message',
			),
			'flamingo' => false,
		);

	return array(
		'eyebrow'      => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'eyebrow', $defaults['eyebrow'] ) ),
		'title'        => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'title', $defaults['title'] ) ),
		'body'         => sanitize_textarea_field( (string) homesea_theme_opt( 'contact', 'body', $defaults['body'] ) ),
		'phone'        => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'phone', $defaults['phone'] ) ),
		'email'        => sanitize_email( (string) homesea_theme_opt( 'contact', 'email', $defaults['email'] ) ),
		'submit_label' => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'submit_label', $defaults['submit_label'] ) ),
		'cf7'          => array(
			'enabled'  => ! empty( $cf7['enabled'] ),
			'form_id'  => absint( $cf7['form_id'] ?? 0 ),
			'rest_url' => esc_url_raw( (string) ( $cf7['rest_url'] ?? '' ) ),
			'unit_tag' => sanitize_text_field( (string) ( $cf7['unit_tag'] ?? '' ) ),
			'locale'   => sanitize_text_field( (string) ( $cf7['locale'] ?? '' ) ),
			'version'  => sanitize_text_field( (string) ( $cf7['version'] ?? '' ) ),
			'fields'   => array(
				'nombre'   => sanitize_key( (string) ( $cf7['fields']['nombre'] ?? 'your-name' ) ),
				'correo'   => sanitize_key( (string) ( $cf7['fields']['correo'] ?? 'your-email' ) ),
				'telefono' => sanitize_key( (string) ( $cf7['fields']['telefono'] ?? 'your-phone' ) ),
				'mensaje'  => sanitize_key( (string) ( $cf7['fields']['mensaje'] ?? 'your-message' ) ),
			),
			'flamingo' => ! empty( $cf7['flamingo'] ),
		),
		'form_labels'  => array(
			'nombre'               => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'label_nombre', $fl['nombre'] ) ),
			'nombre_placeholder'   => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'ph_nombre', $fl['nombre_placeholder'] ) ),
			'nombre_error'         => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'err_nombre', $fl['nombre_error'] ) ),
			'correo'               => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'label_correo', $fl['correo'] ) ),
			'correo_placeholder'   => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'ph_correo', $fl['correo_placeholder'] ) ),
			'correo_error'         => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'err_correo', $fl['correo_error'] ) ),
			'correo_invalid'       => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'err_correo_invalid', $fl['correo_invalid'] ) ),
			'telefono'             => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'label_telefono', $fl['telefono'] ) ),
			'telefono_placeholder' => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'ph_telefono', $fl['telefono_placeholder'] ) ),
			'telefono_error'       => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'err_telefono', $fl['telefono_error'] ) ),
			'mensaje'              => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'label_mensaje', $fl['mensaje'] ) ),
			'mensaje_placeholder'  => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'ph_mensaje', $fl['mensaje_placeholder'] ) ),
			'phone_label'          => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'label_telefono', $fl['phone_label'] ) ),
			'email_label'          => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'label_correo', $fl['email_label'] ) ),
			'success_title'        => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'success_title', $fl['success_title'] ) ),
			'success_message'      => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'success_message', $fl['success_message'] ) ),
			'submit_error'         => sanitize_text_field( (string) homesea_theme_opt( 'contact', 'err_submit', $fl['submit_error'] ?? 'No se pudo enviar el mensaje. Inténtalo de nuevo.' ) ),
		),
	);
}

/**
 * Build footer slice.
 *
 * @param array<string, mixed> $defaults Defaults.
 * @return array<string, mixed>
 */
function homesea_theme_rest_footer( array $defaults ): array {
	$socials = homesea_theme_normalize_links( homesea_theme_get_option( 'footer', 'socials', array() ), true );
	$quick   = homesea_theme_normalize_links( homesea_theme_get_option( 'footer', 'quick_links', array() ) );
	$legal   = homesea_theme_normalize_links( homesea_theme_get_option( 'footer', 'legal_links', array() ) );

	$lines_raw = homesea_theme_get_option( 'footer', 'contact_lines', array() );
	$lines     = array();

	if ( is_array( $lines_raw ) ) {
		foreach ( $lines_raw as $row ) {
			if ( is_array( $row ) ) {
				$line = sanitize_text_field( (string) ( $row['line'] ?? '' ) );
			} else {
				$line = sanitize_text_field( (string) $row );
			}

			if ( '' !== $line ) {
				$lines[] = $line;
			}
		}
	}

	return array(
		'brand'         => sanitize_text_field( (string) homesea_theme_opt( 'footer', 'brand', $defaults['brand'] ) ),
		'brand_parts'   => array(
			'first'  => sanitize_text_field( (string) homesea_theme_opt( 'footer', 'brand_first', $defaults['brand_parts']['first'] ) ),
			'second' => sanitize_text_field( (string) homesea_theme_opt( 'footer', 'brand_second', $defaults['brand_parts']['second'] ) ),
		),
		'tagline'       => sanitize_textarea_field( (string) homesea_theme_opt( 'footer', 'tagline', $defaults['tagline'] ) ),
		'socials'       => empty( $socials ) ? $defaults['socials'] : $socials,
		'quick_links'   => empty( $quick ) ? $defaults['quick_links'] : $quick,
		'contact_lines' => empty( $lines ) ? $defaults['contact_lines'] : $lines,
		'legal_links'   => empty( $legal ) ? $defaults['legal_links'] : $legal,
		'copyright'     => sanitize_text_field( (string) homesea_theme_opt( 'footer', 'copyright', $defaults['copyright'] ) ),
	);
}

/**
 * Build SEO slice.
 *
 * @param array<string, mixed> $defaults Defaults.
 * @return array<string, mixed>
 */
function homesea_theme_rest_seo( array $defaults ): array {
	return array(
		'title'       => sanitize_text_field( (string) homesea_theme_opt( 'seo', 'title', $defaults['title'] ) ),
		'description' => sanitize_textarea_field( (string) homesea_theme_opt( 'seo', 'description', $defaults['description'] ) ),
	);
}

/**
 * Build public site JSON for React.
 *
 * @return WP_REST_Response
 */
function homesea_theme_rest_site_payload(): WP_REST_Response {
	$defaults = homesea_theme_site_defaults();

	$payload = array(
		'header'       => homesea_theme_rest_header( $defaults['header'] ),
		'hero'         => homesea_theme_rest_hero( $defaults['hero'] ),
		'stats'        => homesea_theme_rest_stats( $defaults['stats'] ),
		'properties'   => homesea_theme_rest_properties( $defaults['properties'] ),
		'about'        => homesea_theme_rest_about( $defaults['about'] ),
		'projects'     => homesea_theme_rest_projects( $defaults['projects'] ),
		'testimonials' => homesea_theme_rest_testimonials( $defaults['testimonials'] ),
		'process'      => homesea_theme_rest_process( $defaults['process'] ),
		'location'     => homesea_theme_rest_location( $defaults['location'] ),
		'contact'      => homesea_theme_rest_contact( $defaults['contact'] ),
		'footer'       => homesea_theme_rest_footer( $defaults['footer'] ),
		'seo'          => homesea_theme_rest_seo( $defaults['seo'] ),
	);

	$response = new WP_REST_Response( $payload, 200 );
	$response->set_headers(
		array(
			'Cache-Control' => 'public, max-age=60',
		)
	);

	return $response;
}
