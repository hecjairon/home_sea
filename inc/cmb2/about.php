<?php
/**
 * CMB2 tab — About.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register About settings tab.
 */
function homesea_theme_cmb2_about(): void {
	$cmb = homesea_theme_new_settings_tab(
		'about',
		__( 'Nosotros', 'homesea_theme' ),
		__( 'Nosotros', 'homesea_theme' )
	);

	if ( null === $cmb ) {
		return;
	}

	$text_fields = array(
		'eyebrow' => array( 'name' => __( 'Eyebrow', 'homesea_theme' ), 'default' => 'Nuestra esencia' ),
		'title'   => array( 'name' => __( 'Título', 'homesea_theme' ), 'default' => '¿Por qué Casa Noble?' ),
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
			'name'            => __( 'Cuerpo', 'homesea_theme' ),
			'id'              => 'body',
			'type'            => 'textarea',
			'default'         => 'No vendemos metros cuadrados: acompañamos decisiones de vida con la calidez de quien conoce cada rincón del Mediterráneo.',
			'sanitization_cb' => 'sanitize_textarea_field',
			'show_in_rest'    => WP_REST_Server::READABLE,
		)
	);

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
			'type'            => 'textarea_small',
			'sanitization_cb' => 'sanitize_textarea_field',
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Icono', 'homesea_theme' ),
			'id'              => 'icon',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);
}
