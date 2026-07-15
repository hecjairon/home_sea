<?php
/**
 * Shared theme icon catalog + admin icon select enqueue.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Full icon catalog (key => label). SVG files live in assets/icons/{key}.svg.
 *
 * @return array<string, string>
 */
function homesea_theme_icon_catalog(): array {
	return array(
		'heart'      => __( 'Corazón', 'homesea_theme' ),
		'globe'      => __( 'Globo', 'homesea_theme' ),
		'shield'     => __( 'Escudo', 'homesea_theme' ),
		'building'   => __( 'Edificio', 'homesea_theme' ),
		'home'       => __( 'Casa', 'homesea_theme' ),
		'users'      => __( 'Usuarios', 'homesea_theme' ),
		'clock'      => __( 'Reloj', 'homesea_theme' ),
		'star'       => __( 'Estrella', 'homesea_theme' ),
		'key'        => __( 'Llave', 'homesea_theme' ),
		'map-pin'    => __( 'Ubicación', 'homesea_theme' ),
		'check'      => __( 'Check', 'homesea_theme' ),
		'award'      => __( 'Premio', 'homesea_theme' ),
		'sparkles'   => __( 'Brillo', 'homesea_theme' ),
		'phone'      => __( 'Teléfono', 'homesea_theme' ),
		'handshake'  => __( 'Acuerdo', 'homesea_theme' ),
		'leaf'       => __( 'Hoja', 'homesea_theme' ),
		'search'     => __( 'Buscar', 'homesea_theme' ),
		'eye'        => __( 'Ver', 'homesea_theme' ),
		'card'       => __( 'Tarjeta', 'homesea_theme' ),
		'document'   => __( 'Documento', 'homesea_theme' ),
		'smile'      => __( 'Sonrisa', 'homesea_theme' ),
		'instagram'  => __( 'Instagram', 'homesea_theme' ),
		'linkedin'   => __( 'LinkedIn', 'homesea_theme' ),
		'facebook'   => __( 'Facebook', 'homesea_theme' ),
		'twitter'    => __( 'X / Twitter', 'homesea_theme' ),
		'youtube'    => __( 'YouTube', 'homesea_theme' ),
		'whatsapp'   => __( 'WhatsApp', 'homesea_theme' ),
	);
}

/**
 * Icons map with label + URL for a list of keys.
 *
 * @param array<int, string>|null $keys Keys to include (null = all).
 * @return array<string, array{label: string, url: string}>
 */
function homesea_theme_icons_map( ?array $keys = null ): array {
	$catalog = homesea_theme_icon_catalog();
	$base    = trailingslashit( HOMESEA_THEME_URI ) . 'assets/icons/';
	$map     = array();

	$use_keys = null === $keys ? array_keys( $catalog ) : $keys;

	foreach ( $use_keys as $key ) {
		if ( ! isset( $catalog[ $key ] ) ) {
			continue;
		}
		$map[ $key ] = array(
			'label' => $catalog[ $key ],
			'url'   => $base . $key . '.svg',
		);
	}

	return $map;
}

/**
 * CMB2 select options from an icons map.
 *
 * @param array<string, array{label: string, url: string}> $icons Icons map.
 * @return array<string, string>
 */
function homesea_theme_icon_select_options_from( array $icons ): array {
	$options = array();

	foreach ( $icons as $key => $icon ) {
		$options[ $key ] = $icon['label'];
	}

	return $options;
}

/**
 * Sanitize icon key against an icons map (fallback = first key or provided).
 *
 * @param mixed                                             $value    Raw.
 * @param array<string, array{label: string, url: string}> $icons    Allowed.
 * @param string                                            $fallback Fallback key.
 */
function homesea_theme_sanitize_icon_key( mixed $value, array $icons, string $fallback = '' ): string {
	$key = sanitize_text_field( (string) $value );

	if ( array_key_exists( $key, $icons ) ) {
		return $key;
	}

	if ( '' !== $fallback && array_key_exists( $fallback, $icons ) ) {
		return $fallback;
	}

	$keys = array_keys( $icons );

	return $keys[0] ?? '';
}

/**
 * Enqueue icon-select UI on a theme settings page.
 *
 * @param string                                            $page_slug Settings page slug.
 * @param array<string, array{label: string, url: string}> $icons     Icons for localization.
 */
function homesea_theme_enqueue_icon_select_for_page( string $page_slug, array $icons ): void {
	$page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	if ( $page_slug !== $page ) {
		return;
	}

	$css = HOMESEA_THEME_DIR . '/assets/admin/icon-select.css';
	$js  = HOMESEA_THEME_DIR . '/assets/admin/icon-select.js';

	if ( ! file_exists( $css ) || ! file_exists( $js ) ) {
		return;
	}

	wp_enqueue_style(
		'homesea-icon-select',
		HOMESEA_THEME_URI . '/assets/admin/icon-select.css',
		array(),
		(string) filemtime( $css )
	);

	wp_enqueue_script(
		'homesea-icon-select',
		HOMESEA_THEME_URI . '/assets/admin/icon-select.js',
		array( 'jquery' ),
		(string) filemtime( $js ),
		true
	);

	$localized = array();

	foreach ( $icons as $key => $icon ) {
		$localized[ $key ] = array(
			'label' => $icon['label'],
			'url'   => esc_url_raw( $icon['url'] ),
		);
	}

	wp_localize_script(
		'homesea-icon-select',
		'homeseaIconSelect',
		array(
			'icons' => $localized,
		)
	);
}
