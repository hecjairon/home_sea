<?php
/**
 * CMB2 tab — Stats.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Available Stats icon keys mapped to label + SVG URL.
 *
 * @return array<string, array{label: string, url: string}>
 */
function homesea_theme_stats_icons(): array {
	$base = trailingslashit( HOMESEA_THEME_URI ) . 'assets/icons/';

	return array(
		'home'  => array(
			'label' => __( 'Casa', 'homesea_theme' ),
			'url'   => $base . 'home.svg',
		),
		'users' => array(
			'label' => __( 'Usuarios', 'homesea_theme' ),
			'url'   => $base . 'users.svg',
		),
		'clock' => array(
			'label' => __( 'Reloj', 'homesea_theme' ),
			'url'   => $base . 'clock.svg',
		),
		'star'  => array(
			'label' => __( 'Estrella', 'homesea_theme' ),
			'url'   => $base . 'star.svg',
		),
	);
}

/**
 * CMB2 select options for Stats icons (text labels; UI shows images via admin JS).
 *
 * @return array<string, string>
 */
function homesea_theme_stats_icon_options(): array {
	$options = array();

	foreach ( homesea_theme_stats_icons() as $key => $icon ) {
		$options[ $key ] = $icon['label'];
	}

	return $options;
}

/**
 * Sanitize Stats icon to a known key.
 *
 * @param mixed $value Raw value.
 */
function homesea_theme_sanitize_stats_icon( mixed $value ): string {
	$key = sanitize_text_field( (string) $value );

	return array_key_exists( $key, homesea_theme_stats_icons() ) ? $key : 'home';
}

/**
 * Enqueue icon select assets on the Stats settings page.
 *
 * @param string $hook Current admin page hook.
 */
function homesea_theme_stats_admin_assets( string $hook ): void {
	$page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	if ( 'homesea_theme_stats_settings' !== $page ) {
		return;
	}

	$css = HOMESEA_THEME_DIR . '/assets/admin/icon-select.css';
	$js  = HOMESEA_THEME_DIR . '/assets/admin/icon-select.js';

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

	$icons = array();

	foreach ( homesea_theme_stats_icons() as $key => $icon ) {
		$icons[ $key ] = array(
			'label' => $icon['label'],
			'url'   => esc_url_raw( $icon['url'] ),
		);
	}

	wp_localize_script(
		'homesea-icon-select',
		'homeseaIconSelect',
		array(
			'icons' => $icons,
		)
	);
}
add_action( 'admin_enqueue_scripts', 'homesea_theme_stats_admin_assets' );

/**
 * Register Stats settings tab.
 */
function homesea_theme_cmb2_stats(): void {
	$cmb = homesea_theme_new_settings_tab(
		'stats',
		__( 'Estadísticas', 'homesea_theme' ),
		__( 'Stats', 'homesea_theme' )
	);

	if ( null === $cmb ) {
		return;
	}

	$group_id = $cmb->add_field(
		array(
			'name'         => __( 'Ítems', 'homesea_theme' ),
			'id'           => 'items',
			'type'         => 'group',
			'repeatable'   => true,
			'options'      => array(
				'group_title'   => __( 'Ítem {#}', 'homesea_theme' ),
				'add_button'    => __( 'Agregar ítem', 'homesea_theme' ),
				'remove_button' => __( 'Eliminar', 'homesea_theme' ),
				'sortable'      => true,
			),
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'ID', 'homesea_theme' ),
			'id'              => 'item_id',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Label', 'homesea_theme' ),
			'id'              => 'label',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Valor', 'homesea_theme' ),
			'id'              => 'value',
			'type'            => 'text_small',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Prefijo', 'homesea_theme' ),
			'id'              => 'prefix',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Sufijo', 'homesea_theme' ),
			'id'              => 'suffix',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Icono', 'homesea_theme' ),
			'id'              => 'icon',
			'type'            => 'select',
			'options_cb'      => 'homesea_theme_stats_icon_options',
			'sanitization_cb' => 'homesea_theme_sanitize_stats_icon',
			'attributes'      => array(
				'class' => 'cmb2_select homesea-icon-select',
			),
		)
	);
}
