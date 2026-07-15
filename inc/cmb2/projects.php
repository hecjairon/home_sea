<?php
/**
 * CMB2 tab — Projects (section settings; items from selected CPT proyecto).
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Projects settings tab.
 */
function homesea_theme_cmb2_projects(): void {
	$cmb = homesea_theme_new_settings_tab(
		'projects',
		__( 'Proyectos', 'homesea_theme' ),
		__( 'Proyectos', 'homesea_theme' )
	);

	if ( null === $cmb ) {
		return;
	}

	$text_fields = array(
		'eyebrow'       => array( 'name' => __( 'Eyebrow', 'homesea_theme' ), 'default' => 'Desarrollos selectos' ),
		'title'         => array( 'name' => __( 'Título', 'homesea_theme' ), 'default' => 'Proyectos recientes' ),
		'catalog_label' => array( 'name' => __( 'Catálogo — label', 'homesea_theme' ), 'default' => 'Ver todos los proyectos' ),
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
			'default'      => function_exists( 'homesea_theme_proyecto_archive_url' )
				? homesea_theme_proyecto_archive_url()
				: home_url( '/proyectos/' ),
			'desc'         => __( 'Por defecto apunta al archivo /proyectos/.', 'homesea_theme' ),
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$group_id = $cmb->add_field(
		array(
			'name'         => __( 'Proyectos en home', 'homesea_theme' ),
			'desc'         => __( 'Elige los proyectos del CPT para el carrusel del home. Puedes repetir el mismo proyecto. El orden de las filas define el orden del listado.', 'homesea_theme' ),
			'id'           => 'home_projects',
			'type'         => 'group',
			'repeatable'   => true,
			'options'      => array(
				'group_title'   => __( 'Proyecto {#}', 'homesea_theme' ),
				'add_button'    => __( 'Añadir proyecto al listado', 'homesea_theme' ),
				'remove_button' => __( 'Eliminar', 'homesea_theme' ),
				'sortable'      => true,
			),
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Proyecto', 'homesea_theme' ),
			'id'              => 'proyecto_id',
			'type'            => 'select',
			'options_cb'      => 'homesea_theme_proyecto_select_options',
			'sanitization_cb' => 'homesea_theme_sanitize_proyecto_id',
		)
	);
}
