<?php
/**
 * CMB2 tab — Header.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Header settings tab.
 */
function homesea_theme_cmb2_header(): void {
	$cmb = homesea_theme_new_settings_tab(
		'header',
		__( 'Configuración del Header', 'homesea_theme' ),
		__( 'Header', 'homesea_theme' )
	);

	if ( null === $cmb ) {
		return;
	}

	$text_fields = array(
		'logo_first' => array( 'name' => __( 'Logo — primera parte', 'homesea_theme' ), 'default' => 'villa' ),
		'logo_second' => array( 'name' => __( 'Logo — segunda parte', 'homesea_theme' ), 'default' => 'HERMOSA' ),
		'cta_label'  => array( 'name' => __( 'CTA label', 'homesea_theme' ), 'default' => 'Reserva una visita' ),
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
			'name'         => __( 'CTA URL', 'homesea_theme' ),
			'id'           => 'cta_url',
			'type'         => 'text_url',
			'default'      => '#contacto',
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$group_id = $cmb->add_field(
		array(
			'name'         => __( 'Navegación', 'homesea_theme' ),
			'id'           => 'nav',
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
			'name'            => __( 'Label', 'homesea_theme' ),
			'id'              => 'label',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name' => __( 'URL', 'homesea_theme' ),
			'id'   => 'url',
			'type' => 'text_url',
		)
	);
}
