<?php
/**
 * CMB2 tab — Footer.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icons available for Footer social networks.
 *
 * @return array<string, array{label: string, url: string}>
 */
function homesea_theme_footer_social_icons(): array {
	return homesea_theme_icons_map(
		array(
			'instagram',
			'linkedin',
			'facebook',
			'twitter',
			'youtube',
			'whatsapp',
		)
	);
}

/**
 * CMB2 select options for Footer social icons.
 *
 * @return array<string, string>
 */
function homesea_theme_footer_social_icon_options(): array {
	return homesea_theme_icon_select_options_from( homesea_theme_footer_social_icons() );
}

/**
 * Sanitize Footer social icon key.
 *
 * @param mixed $value Raw value.
 */
function homesea_theme_sanitize_footer_social_icon( mixed $value ): string {
	return homesea_theme_sanitize_icon_key( $value, homesea_theme_footer_social_icons(), 'instagram' );
}

/**
 * Enqueue icon select assets on the Footer settings page.
 *
 * @param string $hook Current admin page hook.
 */
function homesea_theme_footer_admin_assets( string $hook ): void {
	unset( $hook );
	homesea_theme_enqueue_icon_select_for_page(
		'homesea_theme_footer_settings',
		homesea_theme_footer_social_icons()
	);
}
add_action( 'admin_enqueue_scripts', 'homesea_theme_footer_admin_assets' );

/**
 * Register Footer settings tab.
 */
function homesea_theme_cmb2_footer(): void {
	$cmb = homesea_theme_new_settings_tab(
		'footer',
		__( 'Footer', 'homesea_theme' ),
		__( 'Footer', 'homesea_theme' )
	);

	if ( null === $cmb ) {
		return;
	}

	$text_fields = array(
		'brand'        => array( 'name' => __( 'Marca', 'homesea_theme' ), 'default' => 'Casa Noble' ),
		'brand_first'  => array( 'name' => __( 'Marca — primera parte', 'homesea_theme' ), 'default' => 'Casa' ),
		'brand_second' => array( 'name' => __( 'Marca — segunda parte', 'homesea_theme' ), 'default' => 'Noble' ),
		'copyright'    => array( 'name' => __( 'Copyright', 'homesea_theme' ), 'default' => '© 2026 Casa Noble Inmobiliaria. Todos los derechos reservados.' ),
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
			'name'            => __( 'Tagline', 'homesea_theme' ),
			'id'              => 'tagline',
			'type'            => 'textarea_small',
			'default'         => 'Tu aliado de confianza en el mercado inmobiliario mediterráneo. Desde 2008 conectando familias con hogares que tienen alma.',
			'sanitization_cb' => 'sanitize_textarea_field',
			'show_in_rest'    => WP_REST_Server::READABLE,
		)
	);

	$socials_group = $cmb->add_field(
		array(
			'name'         => __( 'Redes sociales', 'homesea_theme' ),
			'id'           => 'socials',
			'type'         => 'group',
			'repeatable'   => true,
			'options'      => array(
				'group_title'   => __( 'Red {#}', 'homesea_theme' ),
				'add_button'    => __( 'Agregar red', 'homesea_theme' ),
				'remove_button' => __( 'Eliminar', 'homesea_theme' ),
				'sortable'      => true,
			),
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_group_field(
		$socials_group,
		array(
			'name'            => __( 'Label', 'homesea_theme' ),
			'id'              => 'label',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_group_field(
		$socials_group,
		array(
			'name' => __( 'URL', 'homesea_theme' ),
			'id'   => 'url',
			'type' => 'text_url',
		)
	);

	$cmb->add_group_field(
		$socials_group,
		array(
			'name'            => __( 'Icono', 'homesea_theme' ),
			'id'              => 'icon',
			'type'            => 'select',
			'options_cb'      => 'homesea_theme_footer_social_icon_options',
			'sanitization_cb' => 'homesea_theme_sanitize_footer_social_icon',
			'attributes'      => array(
				'class' => 'cmb2_select homesea-icon-select',
			),
		)
	);

	$quick_links_group = $cmb->add_field(
		array(
			'name'         => __( 'Enlaces rápidos', 'homesea_theme' ),
			'id'           => 'quick_links',
			'type'         => 'group',
			'repeatable'   => true,
			'options'      => array(
				'group_title'   => __( 'Enlace {#}', 'homesea_theme' ),
				'add_button'    => __( 'Agregar enlace', 'homesea_theme' ),
				'remove_button' => __( 'Eliminar', 'homesea_theme' ),
				'sortable'      => true,
			),
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_group_field(
		$quick_links_group,
		array(
			'name'            => __( 'Label', 'homesea_theme' ),
			'id'              => 'label',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_group_field(
		$quick_links_group,
		array(
			'name' => __( 'URL', 'homesea_theme' ),
			'id'   => 'url',
			'type' => 'text_url',
		)
	);

	$contact_lines_group = $cmb->add_field(
		array(
			'name'         => __( 'Líneas de contacto', 'homesea_theme' ),
			'id'           => 'contact_lines',
			'type'         => 'group',
			'repeatable'   => true,
			'options'      => array(
				'group_title'   => __( 'Línea {#}', 'homesea_theme' ),
				'add_button'    => __( 'Agregar línea', 'homesea_theme' ),
				'remove_button' => __( 'Eliminar', 'homesea_theme' ),
				'sortable'      => true,
			),
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_group_field(
		$contact_lines_group,
		array(
			'name'            => __( 'Línea', 'homesea_theme' ),
			'id'              => 'line',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$legal_links_group = $cmb->add_field(
		array(
			'name'         => __( 'Enlaces legales', 'homesea_theme' ),
			'id'           => 'legal_links',
			'type'         => 'group',
			'repeatable'   => true,
			'options'      => array(
				'group_title'   => __( 'Enlace {#}', 'homesea_theme' ),
				'add_button'    => __( 'Agregar enlace', 'homesea_theme' ),
				'remove_button' => __( 'Eliminar', 'homesea_theme' ),
				'sortable'      => true,
			),
			'show_in_rest' => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_group_field(
		$legal_links_group,
		array(
			'name'            => __( 'Label', 'homesea_theme' ),
			'id'              => 'label',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_group_field(
		$legal_links_group,
		array(
			'name' => __( 'URL', 'homesea_theme' ),
			'id'   => 'url',
			'type' => 'text_url',
		)
	);
}
