<?php
/**
 * Theme bootstrap.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'HOMESEA_THEME_VERSION', '1.0.2' );
define( 'HOMESEA_THEME_DIR', get_template_directory() );
define( 'HOMESEA_THEME_URI', get_template_directory_uri() );

$homesea_theme_includes = array(
	'/inc/helpers/vite.php',
	'/inc/helpers/rest-url.php',
	'/inc/helpers/theme-icons.php',
	'/inc/setup/theme-setup.php',
	'/inc/setup/cpt-propiedad.php',
	'/inc/setup/cpt-proyecto.php',
	'/inc/setup/required-plugins.php',
	'/inc/enqueue/assets.php',
	'/inc/cmb2/loader.php',
	'/inc/helpers/cf7-contact.php',
	'/inc/api/site-endpoint.php',
);

foreach ( $homesea_theme_includes as $homesea_theme_file ) {
	$homesea_theme_path = HOMESEA_THEME_DIR . $homesea_theme_file;

	if ( file_exists( $homesea_theme_path ) ) {
		require_once $homesea_theme_path;
	}
}
