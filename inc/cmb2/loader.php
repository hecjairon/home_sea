<?php
/**
 * CMB2 theme settings — tabs (landscaper-style).
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Parent menu / tab group slug.
 */
function homesea_theme_settings_slug(): string {
	return 'homesea_theme_settings';
}

/**
 * Tab group id for CMB2 options pages.
 */
function homesea_theme_settings_tab_group(): string {
	return 'homesea_theme_settings_tabs';
}

/**
 * Option key for a settings section.
 *
 * @param string $section header|hero|stats|properties|about|values|projects|testimonials|process|location|contact|footer|seo
 */
function homesea_theme_section_option_key( string $section ): string {
	return 'homesea_theme_' . sanitize_key( $section ) . '_settings';
}

/**
 * Get a single theme option from a section options page.
 *
 * @param string $section Section slug.
 * @param string $key     Field id.
 * @param mixed  $default Default value.
 * @return mixed
 */
function homesea_theme_get_option( string $section, string $key, mixed $default = '' ): mixed {
	$option_key = homesea_theme_section_option_key( $section );

	if ( function_exists( 'cmb2_get_option' ) ) {
		$value = cmb2_get_option( $option_key, $key, null );

		if ( null !== $value && false !== $value && '' !== $value ) {
			return $value;
		}

		// Empty arrays are valid stored values for group fields.
		if ( is_array( $value ) ) {
			return $value;
		}
	}

	$options = get_option( $option_key, array() );

	if ( is_array( $options ) && array_key_exists( $key, $options ) ) {
		return $options[ $key ];
	}

	// Fallback: legacy flat option bag from earlier starter version.
	$legacy = get_option( 'homesea_theme_options', array() );

	if ( is_array( $legacy ) && array_key_exists( $key, $legacy ) ) {
		return $legacy[ $key ];
	}

	return $default;
}

/**
 * Register top-level admin menu for theme settings.
 */
function homesea_theme_register_settings_menu(): void {
	add_menu_page(
		__( 'Configuración del Theme', 'homesea_theme' ),
		__( 'Configuración Theme', 'homesea_theme' ),
		'manage_options',
		homesea_theme_settings_slug(),
		'__return_false',
		'dashicons-admin-generic',
		59
	);

	add_action(
		'admin_head',
		static function (): void {
			remove_submenu_page( homesea_theme_settings_slug(), homesea_theme_settings_slug() );
		}
	);
}
add_action( 'admin_menu', 'homesea_theme_register_settings_menu' );

/**
 * Create a CMB2 options-page box wired as a settings tab.
 *
 * @param string $section   Section slug.
 * @param string $title     Page / metabox title.
 * @param string $tab_title Tab label.
 * @return CMB2|null
 */
function homesea_theme_new_settings_tab( string $section, string $title, string $tab_title ): ?CMB2 {
	if ( ! function_exists( 'new_cmb2_box' ) ) {
		return null;
	}

	$option_key = homesea_theme_section_option_key( $section );

	return new_cmb2_box(
		array(
			'id'           => $option_key,
			'title'        => $title,
			'object_types' => array( 'options-page' ),
			'option_key'   => $option_key,
			'parent_slug'  => homesea_theme_settings_slug(),
			'tab_group'    => homesea_theme_settings_tab_group(),
			'tab_title'    => $tab_title,
			'capability'   => 'manage_options',
			'menu_title'   => $tab_title,
		)
	);
}

/**
 * Register all CMB2 settings tabs.
 */
function homesea_theme_register_cmb2(): void {
	if ( ! function_exists( 'new_cmb2_box' ) ) {
		return;
	}

	$modules = array(
		'header',
		'hero',
		'stats',
		'properties',
		'about',
		'values',
		'projects',
		'testimonials',
		'process',
		'location',
		'contact',
		'footer',
		'seo',
	);

	foreach ( $modules as $module ) {
		$path = HOMESEA_THEME_DIR . '/inc/cmb2/' . $module . '.php';

		if ( ! file_exists( $path ) ) {
			continue;
		}

		require_once $path;

		$register = 'homesea_theme_cmb2_' . $module;

		if ( function_exists( $register ) ) {
			$register();
		}
	}
}
add_action( 'cmb2_admin_init', 'homesea_theme_register_cmb2' );
