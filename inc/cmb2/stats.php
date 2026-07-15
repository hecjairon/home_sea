<?php
/**
 * CMB2 tab — Stats.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Stats settings tab.
 */
function homesea_theme_cmb2_stats(): void {
	$cmb = homesea_theme_new_settings_tab(
		'stats',
		__( 'Estadísticas', 'homesea_theme' ),
		__( 'Stats', 'homesea_theme' )
	);

	if ( null === $cmb ) {
		return;
	}

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
			'name'            => __( 'ID', 'homesea_theme' ),
			'id'              => 'item_id',
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

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Valor', 'homesea_theme' ),
			'id'              => 'value',
			'type'            => 'text_small',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Prefijo', 'homesea_theme' ),
			'id'              => 'prefix',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
		)
	);

	$cmb->add_group_field(
		$group_id,
		array(
			'name'            => __( 'Sufijo', 'homesea_theme' ),
			'id'              => 'suffix',
			'type'            => 'text',
			'sanitization_cb' => 'sanitize_text_field',
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
