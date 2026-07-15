<?php
/**
 * CMB2 tab — Projects.
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
		'eyebrow' => array( 'name' => __( 'Eyebrow', 'homesea_theme' ), 'default' => 'Desarrollos selectos' ),
		'title'   => array( 'name' => __( 'Título', 'homesea_theme' ), 'default' => 'Proyectos recientes' ),
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
			'name'         => __( 'Proyectos', 'homesea_theme' ),
			'id'           => 'items',
			'type'         => 'group',
			'repeatable'   => true,
			'options'      => array(
				'group_title'   => __( 'Proyecto {#}', 'homesea_theme' ),
				'add_button'    => __( 'Agregar proyecto', 'homesea_theme' ),
				'remove_button' => __( 'Eliminar', 'homesea_theme' ),
				'sortable'      => true,
			),
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'         => __( 'Imagen', 'homesea_theme' ),
			'id'           => 'image_url',
			'type'         => 'file',
			'options'      => array( 'url' => true ),
			'text'         => array( 'add_upload_file_text' => __( 'Adicionar imagen', 'homesea_theme' ) ),
			'query_args'   => array( 'type' => array( 'image/jpeg', 'image/png', 'image/webp' ) ),
			'preview_size' => array( 300, 300 ),
		)
	);

	$group_text_fields = array(
		'image_alt'     => __( 'Alt de imagen', 'homesea_theme' ),
		'badge'         => __( 'Badge', 'homesea_theme' ),
		'badge_variant' => __( 'Variante del badge', 'homesea_theme' ),
		'title'         => __( 'Título', 'homesea_theme' ),
		'location'      => __( 'Ubicación', 'homesea_theme' ),
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

	$cmb->add_group_field(
		$group_id,
		array(
			'name' => __( 'URL', 'homesea_theme' ),
			'id'   => 'url',
			'type' => 'text_url',
		)
	);
}
