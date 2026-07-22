<?php
/**
 * CMB2 tab — Process.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icons available in the Process module — repositorio UI central.
 *
 * @return array<string, array{label: string, url: string}>
 */
function homesea_theme_process_icons(): array {
	return homesea_theme_ui_icons();
}

/**
 * CMB2 select options for Process icons.
 *
 * @return array<string, string>
 */
function homesea_theme_process_icon_options(): array {
	return homesea_theme_ui_icon_options();
}

/**
 * Sanitize Process icon key.
 *
 * @param mixed $value Raw value.
 */
function homesea_theme_sanitize_process_icon( mixed $value ): string {
	return homesea_theme_sanitize_icon_key( $value, homesea_theme_ui_icons(), 'search' );
}

/**
 * Enqueue icon select assets on the Process settings page.
 *
 * @param string $hook Current admin page hook.
 */
function homesea_theme_process_admin_assets( string $hook ): void {
	unset( $hook );
	homesea_theme_enqueue_ui_icon_select( 'homesea_theme_process_settings' );
}
add_action( 'admin_enqueue_scripts', 'homesea_theme_process_admin_assets' );

/**
 * Register Process settings tab.
 */
function homesea_theme_cmb2_process(): void {
	$cmb = homesea_theme_new_settings_tab(
		'process',
		__( 'Proceso', 'homesea_theme' ),
		__( 'Proceso', 'homesea_theme' )
	);

	if ( null === $cmb ) {
		return;
	}

	$text_fields = array(
		'eyebrow' => array( 'name' => __( 'Eyebrow', 'homesea_theme' ), 'default' => 'Simple y transparente' ),
		'title'   => array( 'name' => __( 'Título', 'homesea_theme' ), 'default' => 'Tu camino hacia el hogar ideal' ),
	);

	foreach ( $text_fields as $id => $cfg ) {
		$cmb->add_field(
			array(
				'name'            => $cfg['name'],
				'id'              => $id,
				'type'            => 'text',
				'default'         => $cfg['default'],
				'sanitization_cb' => 'sanitize_text_field',
				'show_in_rest'    => WP_REST_Server::READABLE,
			)
		);
	}

	$group_id = $cmb->add_field(
		array(
			'name'         => __( 'Pasos', 'homesea_theme' ),
			'id'           => 'steps',
			'type'         => 'group',
			'repeatable'   => true,
			'options'      => array(
				'group_title'   => __( 'Paso {#}', 'homesea_theme' ),
				'add_button'    => __( 'Agregar paso', 'homesea_theme' ),
				'remove_button' => __( 'Eliminar', 'homesea_theme' ),
				'sortable'      => true,
			),
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Número', 'homesea_theme' ),
			'id'              => 'number',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Título', 'homesea_theme' ),
			'id'              => 'title',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Descripción', 'homesea_theme' ),
			'id'              => 'description',
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
			'options_cb'      => 'homesea_theme_process_icon_options',
			'sanitization_cb' => 'homesea_theme_sanitize_process_icon',
			'attributes'      => array(
				'class' => 'cmb2_select homesea-icon-select',
			),
		)
	);
}
