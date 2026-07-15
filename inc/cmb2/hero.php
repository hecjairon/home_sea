<?php
/**
 * CMB2 tab — Hero.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Hero settings tab.
 */
function homesea_theme_cmb2_hero(): void {
	$cmb = homesea_theme_new_settings_tab(
		'hero',
		__( 'Configuración del Hero', 'homesea_theme' ),
		__( 'Hero', 'homesea_theme' )
	);

	if ( null === $cmb ) {
		return;
	}

	$cmb->add_field(
		array(
			'name'         => __( 'Imagen hero', 'homesea_theme' ),
			'id'           => 'image_url',
			'type'         => 'file',
			'options'      => array( 'url' => true ),
			'text'         => array( 'add_upload_file_text' => __( 'Adicionar imagen', 'homesea_theme' ) ),
			'query_args'   => array( 'type' => array( 'image/jpeg', 'image/png', 'image/webp' ) ),
			'preview_size' => array( 300, 300 ),
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$text_fields = array(
		'image_alt'           => array( 'name' => __( 'Alt de imagen', 'homesea_theme' ), 'default' => 'Villa mediterránea de lujo con piscina y jardín al atardecer' ),
		'eyebrow'             => array( 'name' => __( 'Eyebrow', 'homesea_theme' ), 'default' => 'Inmobiliaria mediterránea desde 2008' ),
		'title'               => array( 'name' => __( 'Título', 'homesea_theme' ), 'default' => 'Hogares con alma bajo el sol mediterráneo' ),
		'primary_label'       => array( 'name' => __( 'CTA primario', 'homesea_theme' ), 'default' => 'Explorar propiedades' ),
		'secondary_label'     => array( 'name' => __( 'CTA secundario', 'homesea_theme' ), 'default' => 'Hablar con un asesor' ),
		'search_title'        => array( 'name' => __( 'Buscador — título', 'homesea_theme' ), 'default' => 'Encuentra tu refugio' ),
		'search_description'  => array( 'name' => __( 'Buscador — descripción', 'homesea_theme' ), 'default' => 'Busca entre nuestra colección curada de propiedades mediterráneas' ),
		'search_submit_label' => array( 'name' => __( 'Buscador — botón', 'homesea_theme' ), 'default' => 'Buscar propiedades' ),
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
			'name'            => __( 'Subtítulo', 'homesea_theme' ),
			'id'              => 'subtitle',
			'type'            => 'textarea_small',
			'default'         => 'Villas, fincas y residencias seleccionadas con criterio en la Costa del Sol, Baleares y la Riviera. Te acompañamos con calidez en cada paso.',
			'sanitization_cb' => 'sanitize_textarea_field',
			'show_in_rest'    => WP_REST_Server::READABLE,
		)
	);

	$url_fields = array(
		'primary_url'   => array( 'name' => __( 'CTA primario URL', 'homesea_theme' ), 'default' => '#propiedades' ),
		'secondary_url' => array( 'name' => __( 'CTA secundario URL', 'homesea_theme' ), 'default' => '#contacto' ),
	);

	foreach ( $url_fields as $id => $cfg ) {
		$cmb->add_field(
			array(
				'name'         => $cfg['name'],
				'id'           => $id,
				'type'         => 'text_url',
				'default'      => $cfg['default'],
				'show_in_rest' => WP_REST_Server::READABLE,
			)
		);
	}

	$group_id = $cmb->add_field(
		array(
			'name'         => __( 'Tipos de búsqueda', 'homesea_theme' ),
			'id'           => 'search_types',
			'type'         => 'group',
			'repeatable'   => true,
			'options'      => array(
				'group_title'   => __( 'Tipo {#}', 'homesea_theme' ),
				'add_button'    => __( 'Agregar tipo', 'homesea_theme' ),
				'remove_button' => __( 'Eliminar', 'homesea_theme' ),
				'sortable'      => true,
			),
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Valor', 'homesea_theme' ),
			'id'              => 'value',
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
}
