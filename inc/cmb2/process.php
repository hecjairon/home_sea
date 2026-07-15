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

	$group_text_fields = array(
		'number'      => __( 'Número', 'homesea_theme' ),
		'title'       => __( 'Título', 'homesea_theme' ),
		'description' => __( 'Descripción', 'homesea_theme' ),
		'icon'        => __( 'Icono', 'homesea_theme' ),
	);

	foreach ( $group_text_fields as $id => $name ) {
		$cmb->add_group_field(
			$group_id,
			array(
				'name'            => $name,
				'id'              => $id,
				'type'            => 'text',
				'sanitization_cb' => 'sanitize_text_field',
			)
		);
	}
}
