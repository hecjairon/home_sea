<?php
/**
 * REST URL helpers (compatible with hosts without pretty /wp-json/ rewrites).
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build a public REST URL using ?rest_route= (works without mod_rewrite WordPress rules).
 *
 * Shared hosts (e.g. HostGator + NFD/EPC .htaccess) often lack the "# BEGIN WordPress"
 * block, so /wp-json/... returns 404 while index.php?rest_route=/... works.
 *
 * @param string $route Route path, e.g. 'theme/v1/site' or '/theme/v1/site'.
 */
function homesea_theme_rest_url( string $route ): string {
	$route = '/' . ltrim( $route, '/' );

	return esc_url_raw(
		add_query_arg(
			'rest_route',
			$route,
			home_url( '/' )
		)
	);
}
