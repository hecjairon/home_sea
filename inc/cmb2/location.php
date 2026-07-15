<?php
/**
 * CMB2 tab — Location.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Location settings tab.
 */
function homesea_theme_cmb2_location(): void {
	$cmb = homesea_theme_new_settings_tab(
		'location',
		__( 'Ubicación', 'homesea_theme' ),
		__( 'Ubicación', 'homesea_theme' )
	);

	if ( null === $cmb ) {
		return;
	}

	$cmb->add_field(
		array(
			'name'            => __( 'Título', 'homesea_theme' ),
			'id'              => 'title',
			'type'            => 'text',
			'default'         => 'Oficina Marbella — Costa del Sol',
			'sanitization_cb' => 'sanitize_text_field',
			'show_in_rest'    => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_field(
		array(
			'name'            => __( 'Dirección', 'homesea_theme' ),
			'id'              => 'address',
			'type'            => 'textarea_small',
			'default'         => 'Paseo Marítimo 42, Planta 2 · 29600 Marbella, Málaga',
			'sanitization_cb' => 'sanitize_textarea_field',
			'show_in_rest'    => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_field(
		array(
			'name'         => __( 'URL de Google Maps', 'homesea_theme' ),
			'id'           => 'maps_url',
			'type'         => 'text_url',
			'default'      => 'https://maps.google.com/?q=Paseo+Maritimo+42+Marbella',
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_field(
		array(
			'name'            => __( 'CTA label', 'homesea_theme' ),
			'id'              => 'cta_label',
			'type'            => 'text',
			'default'         => 'Cómo llegar',
			'sanitization_cb' => 'sanitize_text_field',
			'show_in_rest'    => WP_REST_Server::READABLE,
		)
	);
}
