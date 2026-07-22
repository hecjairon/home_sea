<?php
/**
 * CMB2 tab — Valores (icon + label).
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icons for Valores — repositorio UI central.
 *
 * @return array<string, array{label: string, url: string}>
 */
function homesea_theme_values_icons(): array {
	return homesea_theme_ui_icons();
}

/**
 * CMB2 select options for Valores icons.
 *
 * @return array<string, string>
 */
function homesea_theme_values_icon_options(): array {
	return homesea_theme_ui_icon_options();
}

/**
 * Sanitize Valores icon key.
 *
 * @param mixed $value Raw value.
 */
function homesea_theme_sanitize_values_icon( mixed $value ): string {
	return homesea_theme_sanitize_icon_key( $value, homesea_theme_ui_icons(), 'clock' );
}

/**
 * Enqueue icon select on the Valores settings page.
 *
 * @param string $hook Current admin page hook.
 */
function homesea_theme_values_admin_assets( string $hook ): void {
	unset( $hook );
	homesea_theme_enqueue_ui_icon_select( 'homesea_theme_values_settings' );
}
add_action( 'admin_enqueue_scripts', 'homesea_theme_values_admin_assets' );

/**
 * Register Valores settings tab.
 */
function homesea_theme_cmb2_values(): void {
	$cmb = homesea_theme_new_settings_tab(
		'values',
		__( 'Valores', 'homesea_theme' ),
		__( 'Valores', 'homesea_theme' )
	);

	if ( null === $cmb ) {
		return;
	}

	$cmb->add_field(
		array(
			'name'            => __( 'Título', 'homesea_theme' ),
			'id'              => 'title',
			'type'            => 'text',
			'default'         => 'Nuestros valores:',
			'sanitization_cb' => 'sanitize_text_field',
			'show_in_rest'    => WP_REST_Server::READABLE,
		)
	);

	$group_id = $cmb->add_field(
		array(
			'name'         => __( 'Valores', 'homesea_theme' ),
			'desc'         => __( 'Cada fila: icono + texto (layout tipo brochure).', 'homesea_theme' ),
			'id'           => 'items',
			'type'         => 'group',
			'repeatable'   => true,
			'options'      => array(
				'group_title'   => __( 'Valor {#}', 'homesea_theme' ),
				'add_button'    => __( 'Agregar valor', 'homesea_theme' ),
				'remove_button' => __( 'Eliminar', 'homesea_theme' ),
				'sortable'      => true,
			),
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Icono', 'homesea_theme' ),
			'id'              => 'icon',
			'type'            => 'select',
			'options_cb'      => 'homesea_theme_values_icon_options',
			'sanitization_cb' => 'homesea_theme_sanitize_values_icon',
			'attributes'      => array(
				'class' => 'cmb2_select homesea-icon-select',
			),
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Texto', 'homesea_theme' ),
			'id'              => 'label',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);
}
