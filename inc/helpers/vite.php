<?php
/**
 * Vite helpers: HMR detection and manifest reading.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Public Vite URL used by the browser (HMR).
 * Prefers env; otherwise derives host from the current request + VITE_PORT.
 */
function homesea_theme_vite_public_url(): string {
	$url = getenv( 'VITE_DEV_SERVER_URL' );

	if ( ! is_string( $url ) || '' === $url ) {
		$url = defined( 'VITE_DEV_SERVER_URL' ) ? (string) VITE_DEV_SERVER_URL : '';
	}

	if ( '' !== $url ) {
		return untrailingslashit( $url );
	}

	$host = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( (string) $_SERVER['HTTP_HOST'] ) ) : 'localhost';
	$host = preg_replace( '/:\d+$/', '', $host ) ?: 'localhost';
	$port = getenv( 'VITE_PORT' );

	if ( ! is_string( $port ) || '' === $port ) {
		$port = '7552';
	}

	$scheme = is_ssl() ? 'https' : 'http';

	return untrailingslashit( sprintf( '%s://%s:%s', $scheme, $host, $port ) );
}

/**
 * Internal Vite URL used by PHP (container network).
 */
function homesea_theme_vite_internal_url(): string {
	$url = getenv( 'VITE_DEV_SERVER_INTERNAL' );

	if ( ! is_string( $url ) || '' === $url ) {
		$url = defined( 'VITE_DEV_SERVER_INTERNAL' ) ? (string) VITE_DEV_SERVER_INTERNAL : 'http://vite:5173';
	}

	return untrailingslashit( $url );
}

/**
 * Whether the Vite dev server is reachable from PHP.
 */
function homesea_theme_is_vite_running(): bool {
	$internal = homesea_theme_vite_internal_url();
	$response = wp_remote_get(
		$internal . '/@vite/client',
		array(
			'timeout'   => 1,
			'sslverify' => false,
		)
	);

	if ( is_wp_error( $response ) ) {
		return false;
	}

	$code = (int) wp_remote_retrieve_response_code( $response );

	return $code >= 200 && $code < 400;
}

/**
 * Load Vite manifest.json from dist/.
 *
 * @return array<string, mixed>|null
 */
function homesea_theme_get_vite_manifest(): ?array {
	$manifest_path = HOMESEA_THEME_DIR . '/dist/.vite/manifest.json';

	if ( ! file_exists( $manifest_path ) ) {
		$manifest_path = HOMESEA_THEME_DIR . '/dist/manifest.json';
	}

	if ( ! file_exists( $manifest_path ) ) {
		return null;
	}

	$content = file_get_contents( $manifest_path );

	if ( false === $content ) {
		return null;
	}

	$data = json_decode( $content, true );

	return is_array( $data ) ? $data : null;
}
