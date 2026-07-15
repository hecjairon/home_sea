<?php
/**
 * CMB2 tab — Contact.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Contact settings tab.
 */
function homesea_theme_cmb2_contact(): void {
	$cmb = homesea_theme_new_settings_tab(
		'contact',
		__( 'Contacto', 'homesea_theme' ),
		__( 'Contacto', 'homesea_theme' )
	);

	if ( null === $cmb ) {
		return;
	}

	$text_fields = array(
		'eyebrow'      => array( 'name' => __( 'Eyebrow', 'homesea_theme' ), 'default' => 'Contacto' ),
		'title'        => array( 'name' => __( 'Título', 'homesea_theme' ), 'default' => 'Cuéntanos qué buscas' ),
		'phone'        => array( 'name' => __( 'Teléfono', 'homesea_theme' ), 'default' => '+34 952 123 456' ),
		'submit_label' => array( 'name' => __( 'Botón enviar', 'homesea_theme' ), 'default' => 'Quiero que me contacten' ),
		'label_nombre' => array( 'name' => __( 'Label — nombre', 'homesea_theme' ), 'default' => 'Nombre' ),
		'ph_nombre'    => array( 'name' => __( 'Placeholder — nombre', 'homesea_theme' ), 'default' => 'Tu nombre completo' ),
		'err_nombre'   => array( 'name' => __( 'Error — nombre', 'homesea_theme' ), 'default' => 'El nombre es obligatorio.' ),
		'label_correo' => array( 'name' => __( 'Label — correo', 'homesea_theme' ), 'default' => 'Correo' ),
		'ph_correo'    => array( 'name' => __( 'Placeholder — correo', 'homesea_theme' ), 'default' => 'tu@email.com' ),
		'err_correo'   => array( 'name' => __( 'Error — correo', 'homesea_theme' ), 'default' => 'El correo es obligatorio.' ),
		'err_correo_invalid' => array( 'name' => __( 'Error — correo inválido', 'homesea_theme' ), 'default' => 'Introduce un correo válido.' ),
		'label_telefono' => array( 'name' => __( 'Label — teléfono', 'homesea_theme' ), 'default' => 'Teléfono' ),
		'ph_telefono'  => array( 'name' => __( 'Placeholder — teléfono', 'homesea_theme' ), 'default' => '+34 600 000 000' ),
		'err_telefono' => array( 'name' => __( 'Error — teléfono', 'homesea_theme' ), 'default' => 'El teléfono es obligatorio.' ),
		'label_mensaje' => array( 'name' => __( 'Label — mensaje', 'homesea_theme' ), 'default' => 'Mensaje' ),
		'ph_mensaje'   => array( 'name' => __( 'Placeholder — mensaje', 'homesea_theme' ), 'default' => 'Cuéntanos qué tipo de propiedad mediterránea buscas...' ),
		'success_title' => array( 'name' => __( 'Éxito — título', 'homesea_theme' ), 'default' => '¡Mensaje enviado!' ),
		'success_message' => array( 'name' => __( 'Éxito — mensaje', 'homesea_theme' ), 'default' => 'Un asesor de Casa Noble te contactará en menos de 24 horas.' ),
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
			'default'         => 'Completa el formulario y un asesor de Casa Noble te contactará en menos de 24 horas. Sin compromiso, con la calidez que nos caracteriza.',
			'sanitization_cb' => 'sanitize_textarea_field',
			'show_in_rest'    => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_field(
		array(
			'name'            => __( 'Email', 'homesea_theme' ),
			'id'              => 'email',
			'type'            => 'text_email',
			'default'         => 'hola@casanoble.es',
			'sanitization_cb' => 'sanitize_email',
			'show_in_rest'    => WP_REST_Server::READABLE,
		)
	);

	$cmb->add_field(
		array(
			'name' => __( 'Contact Form 7', 'homesea_theme' ),
			'desc' => __( 'El formulario React envía a CF7 vía REST. Si el ID está vacío, el theme crea «Contacto Casa Noble». Con Flamingo activo, los mensajes se guardan en la base de datos.', 'homesea_theme' ),
			'id'   => 'cf7_heading',
			'type' => 'title',
		)
	);

	$cmb->add_field(
		array(
			'name'            => __( 'CF7 — ID del formulario', 'homesea_theme' ),
			'id'              => 'cf7_id',
			'type'            => 'text_small',
			'default'         => '',
			'attributes'      => array(
				'type' => 'number',
				'min'  => '0',
			),
			'sanitization_cb' => 'absint',
			'show_in_rest'    => WP_REST_Server::READABLE,
		)
	);

	$field_names = array(
		'cf7_field_nombre'   => array( 'name' => __( 'CF7 — nombre del campo Nombre', 'homesea_theme' ), 'default' => 'your-name' ),
		'cf7_field_correo'   => array( 'name' => __( 'CF7 — nombre del campo Correo', 'homesea_theme' ), 'default' => 'your-email' ),
		'cf7_field_telefono' => array( 'name' => __( 'CF7 — nombre del campo Teléfono', 'homesea_theme' ), 'default' => 'your-phone' ),
		'cf7_field_mensaje'  => array( 'name' => __( 'CF7 — nombre del campo Mensaje', 'homesea_theme' ), 'default' => 'your-message' ),
	);

	foreach ( $field_names as $id => $cfg ) {
		$cmb->add_field(
			array(
				'name'            => $cfg['name'],
				'id'              => $id,
				'type'            => 'text_small',
				'default'         => $cfg['default'],
				'sanitization_cb' => 'sanitize_key',
				'show_in_rest'    => WP_REST_Server::READABLE,
			)
		);
	}

	$cmb->add_field(
		array(
			'name'            => __( 'Error — envío', 'homesea_theme' ),
			'id'              => 'err_submit',
			'type'            => 'text',
			'default'         => 'No se pudo enviar el mensaje. Inténtalo de nuevo.',
			'sanitization_cb' => 'sanitize_text_field',
			'show_in_rest'    => WP_REST_Server::READABLE,
		)
	);
}
