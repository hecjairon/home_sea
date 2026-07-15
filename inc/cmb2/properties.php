<?php
/**
 * CMB2 tab — Properties.
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
			'default'      => '#',
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$group_id = $cmb->add_field(
		array(
			'name'         => __( 'Propiedades', 'homesea_theme' ),
			'id'           => 'items',
			'type'         => 'group',
			'repeatable'   => true,
			'options'      => array(
				'group_title'   => __( 'Propiedad {#}', 'homesea_theme' ),
				'add_button'    => __( 'Agregar propiedad', 'homesea_theme' ),
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
		'price'         => __( 'Precio', 'homesea_theme' ),
		'location'      => __( 'Ubicación', 'homesea_theme' ),
		'beds'          => __( 'Dormitorios', 'homesea_theme' ),
		'baths'         => __( 'Baños', 'homesea_theme' ),
		'area'          => __( 'Área', 'homesea_theme' ),
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
			'name' => __( 'URL de detalle', 'homesea_theme' ),
			'id'   => 'details_url',
			'type' => 'text_url',
		)
	);
}
