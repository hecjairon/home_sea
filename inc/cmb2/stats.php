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
	return homesea_theme_icons_map( array( 'home', 'users', 'clock', 'star' ) );
}

/**
 * CMB2 select options for Stats icons (text labels; UI shows images via admin JS).
 *
 * @return array<string, string>
 */
function homesea_theme_stats_icon_options(): array {
	return homesea_theme_icon_select_options_from( homesea_theme_stats_icons() );
}

/**
 * Sanitize Stats icon to a known key.
 *
 * @param mixed $value Raw value.
 */
function homesea_theme_sanitize_stats_icon( mixed $value ): string {
	return homesea_theme_sanitize_icon_key( $value, homesea_theme_stats_icons(), 'home' );
}

/**
 * Enqueue icon select assets on the Stats settings page.
 *
 * @param string $hook Current admin page hook.
 */
function homesea_theme_stats_admin_assets( string $hook ): void {
	unset( $hook );
	homesea_theme_enqueue_icon_select_for_page(
		'homesea_theme_stats_settings',
		homesea_theme_stats_icons()
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
			'name'            => __( 'Label', 'homesea_theme' ),
			'id'              => 'label',
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

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Número', 'homesea_theme' ),
			'id'              => 'value',
			'type'            => 'text_small',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);
}
