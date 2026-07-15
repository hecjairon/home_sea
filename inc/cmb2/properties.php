<?php
/**
 * CMB2 tab — Properties (section settings; items from selected CPT propiedad).
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Properties settings tab.
 */
function homesea_theme_cmb2_properties(): void {
	$cmb = homesea_theme_new_settings_tab(
		'properties',
		__( 'Propiedades', 'homesea_theme' ),
		__( 'Propiedades', 'homesea_theme' )
	);

	if ( null === $cmb ) {
		return;
	}

	$text_fields = array(
		'eyebrow'       => array( 'name' => __( 'Eyebrow', 'homesea_theme' ), 'default' => 'Colección curada' ),
		'title'         => array( 'name' => __( 'Título', 'homesea_theme' ), 'default' => 'Propiedades destacadas' ),
		'catalog_label' => array( 'name' => __( 'Catálogo — label', 'homesea_theme' ), 'default' => 'Ver catálogo completo' ),
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

	$cmb->add_field(
		array(
			'name'         => __( 'Catálogo — URL', 'homesea_theme' ),
			'id'           => 'catalog_url',
			'type'         => 'text_url',
			'default'      => function_exists( 'homesea_theme_propiedad_archive_url' )
				? homesea_theme_propiedad_archive_url()
				: home_url( '/propiedades/' ),
			'desc'         => __( 'Por defecto apunta al archivo /propiedades/.', 'homesea_theme' ),
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$group_id = $cmb->add_field(
		array(
			'name'         => __( 'Propiedades', 'homesea_theme' ),
			'desc'         => __( 'Elige las propiedades del CPT para el listado home. El label de cada opción es el título del post. Puedes repetir la misma propiedad en varias filas. El orden de las filas define el orden del listado.', 'homesea_theme' ),
			'id'           => 'home_properties',
			'type'         => 'group',
			'repeatable'   => true,
			'options'      => array(
				'group_title'   => __( 'Propiedad {#}', 'homesea_theme' ),
				'add_button'    => __( 'Añadir propiedad al listado', 'homesea_theme' ),
				'remove_button' => __( 'Eliminar', 'homesea_theme' ),
				'sortable'      => true,
			),
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Propiedad', 'homesea_theme' ),
			'id'              => 'propiedad_id',
			'type'            => 'select',
			'options_cb'      => 'homesea_theme_propiedad_select_options',
			'sanitization_cb' => 'homesea_theme_sanitize_propiedad_id',
		)
	);
}
