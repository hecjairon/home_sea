<?php
/**
 * CMB2 tab — About / Nosotros.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icons available in the About module.
 *
 * @return array<string, array{label: string, url: string}>
 */
function homesea_theme_about_icons(): array {
	return homesea_theme_icons_map(
		array(
			'heart',
			'globe',
			'shield',
			'building',
			'home',
			'users',
			'star',
			'clock',
			'key',
			'map-pin',
			'check',
			'award',
			'sparkles',
			'phone',
			'handshake',
			'leaf',
		)
	);
}

/**
 * CMB2 select options for About icons.
 *
 * @return array<string, string>
 */
function homesea_theme_about_icon_options(): array {
	return homesea_theme_icon_select_options_from( homesea_theme_about_icons() );
}

/**
 * Sanitize About icon key.
 *
 * @param mixed $value Raw value.
 */
function homesea_theme_sanitize_about_icon( mixed $value ): string {
	return homesea_theme_sanitize_icon_key( $value, homesea_theme_about_icons(), 'heart' );
}

/**
 * Enqueue icon select assets on the About settings page.
 *
 * @param string $hook Current admin page hook.
 */
function homesea_theme_about_admin_assets( string $hook ): void {
	unset( $hook );
	homesea_theme_enqueue_icon_select_for_page(
		'homesea_theme_about_settings',
		homesea_theme_about_icons()
	);
}
add_action( 'admin_enqueue_scripts', 'homesea_theme_about_admin_assets' );

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
		'title'   => array( 'name' => __( 'Título', 'homesea_theme' ), 'default' => '¿Por qué Villa Hermosa?' ),
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
			'type'            => 'select',
			'options_cb'      => 'homesea_theme_about_icon_options',
			'sanitization_cb' => 'homesea_theme_sanitize_about_icon',
			'attributes'      => array(
				'class' => 'cmb2_select homesea-icon-select',
			),
		)
	);
}
