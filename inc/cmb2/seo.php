<?php
/**
 * CMB2 tab — SEO.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register SEO settings tab.
 */
function homesea_theme_cmb2_seo(): void {
	$cmb = homesea_theme_new_settings_tab(
		'seo',
		__( 'SEO', 'homesea_theme' ),
		__( 'SEO', 'homesea_theme' )
	);

	if ( null === $cmb ) {
		return;
	}

	$cmb->add_field(
		array(
			'name'            => __( 'Meta title', 'homesea_theme' ),
			'id'              => 'title',
			'type'            => 'text',
			'default'         => 'Villa Hermosa | Inmobiliaria Premium Mediterránea — Tu hogar con alma',
			'sanitization_cb' => 'sanitize_text_field',
			'show_in_rest'    => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_field(
		array(
			'name'            => __( 'Meta description', 'homesea_theme' ),
			'id'              => 'description',
			'type'            => 'textarea_small',
			'default'         => 'Villa Hermosa: propiedades mediterráneas de lujo en la Costa del Sol, Mallorca y la Riviera. Más de 18 años conectando familias con villas, fincas y residencias con carácter y calidez.',
			'sanitization_cb' => 'sanitize_textarea_field',
			'show_in_rest'    => WP_REST_Server::READABLE,
		)
	);
}
