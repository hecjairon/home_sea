<?php
/**
 * CMB2 tab — Testimonials.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Testimonials settings tab.
 */
function homesea_theme_cmb2_testimonials(): void {
	$cmb = homesea_theme_new_settings_tab(
		'testimonials',
		__( 'Testimonios', 'homesea_theme' ),
		__( 'Testimonios', 'homesea_theme' )
	);

	if ( null === $cmb ) {
		return;
	}

	$text_fields = array(
		'eyebrow' => array( 'name' => __( 'Eyebrow', 'homesea_theme' ), 'default' => 'Testimonios' ),
		'title'   => array( 'name' => __( 'Título', 'homesea_theme' ), 'default' => 'Historias de familias que confiaron en nosotros' ),
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
			'name'         => __( 'Testimonios', 'homesea_theme' ),
			'id'           => 'items',
			'type'         => 'group',
			'repeatable'   => true,
			'options'      => array(
				'group_title'   => __( 'Testimonio {#}', 'homesea_theme' ),
				'add_button'    => __( 'Agregar testimonio', 'homesea_theme' ),
				'remove_button' => __( 'Eliminar', 'homesea_theme' ),
				'sortable'      => true,
			),
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Cita', 'homesea_theme' ),
			'id'              => 'quote',
			'type'            => 'textarea',
			'sanitization_cb' => 'sanitize_textarea_field',
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Nombre', 'homesea_theme' ),
			'id'              => 'name',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Ubicación', 'homesea_theme' ),
			'id'              => 'location',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'         => __( 'Avatar', 'homesea_theme' ),
			'id'           => 'avatar_url',
			'type'         => 'file',
			'options'      => array( 'url' => true ),
			'text'         => array( 'add_upload_file_text' => __( 'Adicionar avatar', 'homesea_theme' ) ),
			'query_args'   => array( 'type' => array( 'image/jpeg', 'image/png', 'image/webp' ) ),
			'preview_size' => array( 100, 100 ),
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Rating', 'homesea_theme' ),
			'id'              => 'rating',
			'type'            => 'text_small',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);
}
