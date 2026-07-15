<?php
/**
 * Contact Form 7 bridge for the React contact form.
 *
 * Ensures a CF7 form exists and exposes REST feedback config for React.
 * Messages are stored in DB via Flamingo when that plugin is active.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default logical field → CF7 field name map.
 *
 * @return array<string, string>
 */
function homesea_theme_cf7_default_field_map(): array {
	return array(
		'nombre'   => 'your-name',
		'correo'   => 'your-email',
		'telefono' => 'your-phone',
		'mensaje'  => 'your-message',
	);
}

/**
 * Whether Contact Form 7 is available.
 */
function homesea_theme_cf7_ready(): bool {
	return class_exists( 'WPCF7_ContactForm' ) && function_exists( 'wpcf7_contact_form' );
}

/**
 * Read stored contact option.
 *
 * @param string $key     Option key.
 * @param mixed  $default Default.
 * @return mixed
 */
function homesea_theme_cf7_contact_option( string $key, mixed $default = '' ): mixed {
	if ( function_exists( 'homesea_theme_get_option' ) ) {
		return homesea_theme_get_option( 'contact', $key, $default );
	}

	$options = get_option( 'homesea_theme_contact_settings', array() );

	if ( is_array( $options ) && array_key_exists( $key, $options ) && '' !== $options[ $key ] && null !== $options[ $key ] ) {
		return $options[ $key ];
	}

	return $default;
}

/**
 * Persist form id into CMB2 contact options.
 *
 * @param int $form_id Form ID.
 */
function homesea_theme_cf7_persist_form_id( int $form_id ): void {
	$options = get_option( 'homesea_theme_contact_settings', array() );
	if ( ! is_array( $options ) ) {
		$options = array();
	}

	$options['cf7_id'] = $form_id;
	// Clear legacy WPForms key if present.
	unset( $options['wpforms_id'] );

	update_option( 'homesea_theme_contact_settings', $options );
}

/**
 * CF7 form template markup for Casa Noble.
 */
function homesea_theme_cf7_form_template(): string {
	return implode(
		"\n",
		array(
			'<label> Nombre',
			'    [text* your-name autocomplete:name] </label>',
			'<label> Correo',
			'    [email* your-email autocomplete:email] </label>',
			'<label> Teléfono',
			'    [tel* your-phone autocomplete:tel] </label>',
			'<label> Mensaje',
			'    [textarea your-message] </label>',
			'[hidden your-subject "Solicitud de contacto Casa Noble"]',
			'[submit "Quiero que me contacten"]',
		)
	);
}

/**
 * Create the CF7 contact form if missing.
 *
 * @return int Form ID or 0.
 */
function homesea_theme_cf7_ensure_contact_form(): int {
	if ( ! homesea_theme_cf7_ready() ) {
		return 0;
	}

	$existing_id = absint( homesea_theme_cf7_contact_option( 'cf7_id', 0 ) );

	if ( $existing_id > 0 ) {
		$form = wpcf7_contact_form( $existing_id );
		if ( $form instanceof WPCF7_ContactForm ) {
			return $existing_id;
		}
	}

	// Prefer already-created Casa Noble form by title.
	$posts = get_posts(
		array(
			'post_type'              => 'wpcf7_contact_form',
			'post_status'            => 'publish',
			'posts_per_page'         => 50,
			'orderby'                => 'ID',
			'order'                  => 'ASC',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	foreach ( $posts as $post ) {
		if ( 'Contacto Casa Noble' === $post->post_title ) {
			homesea_theme_cf7_persist_form_id( (int) $post->ID );
			return (int) $post->ID;
		}
	}

	$contact_form = WPCF7_ContactForm::get_template(
		array(
			'title' => 'Contacto Casa Noble',
		)
	);

	$mail             = $contact_form->prop( 'mail' );
	$mail['subject']  = '[_site_title] Nueva solicitud de contacto — [your-name]';
	$mail['body']     = "De: [your-name] <[your-email]>\nTeléfono: [your-phone]\n\nMensaje:\n[your-message]\n\n--\nEsto es un aviso de que se ha enviado un formulario de contacto en tu web ([_site_title] [_site_url]).";
	$mail['recipient'] = '[_site_admin_email]';
	$mail['additional_headers'] = 'Reply-To: [your-email]';

	$contact_form->set_properties(
		array(
			'form' => homesea_theme_cf7_form_template(),
			'mail' => $mail,
		)
	);

	$saved = $contact_form->save();

	if ( ! $saved ) {
		return 0;
	}

	$form_id = absint( $contact_form->id() );
	homesea_theme_cf7_persist_form_id( $form_id );

	return $form_id;
}

/**
 * Resolve field map from CMB2 overrides + defaults.
 *
 * @return array<string, string>
 */
function homesea_theme_cf7_field_map(): array {
	$map = homesea_theme_cf7_default_field_map();

	foreach ( $map as $logical => $default_name ) {
		$raw = sanitize_key( (string) homesea_theme_cf7_contact_option( 'cf7_field_' . $logical, $default_name ) );
		// CF7 names use hyphens; sanitize_key keeps them.
		$map[ $logical ] = '' !== $raw ? $raw : $default_name;
	}

	return $map;
}

/**
 * Public CF7 config for React (embedded in site contact slice).
 *
 * @return array<string, mixed>
 */
function homesea_theme_cf7_contact_config(): array {
	$defaults = array(
		'enabled'    => false,
		'form_id'    => 0,
		'rest_url'   => '',
		'unit_tag'   => '',
		'locale'     => '',
		'version'    => '',
		'fields'     => homesea_theme_cf7_default_field_map(),
		'flamingo'   => false,
	);

	if ( ! homesea_theme_cf7_ready() ) {
		return $defaults;
	}

	$form_id = absint( homesea_theme_cf7_contact_option( 'cf7_id', 0 ) );

	if ( $form_id <= 0 ) {
		$form_id = homesea_theme_cf7_ensure_contact_form();
	}

	$form = $form_id > 0 ? wpcf7_contact_form( $form_id ) : null;

	if ( ! $form instanceof WPCF7_ContactForm ) {
		return $defaults;
	}

	$locale = method_exists( $form, 'locale' ) ? (string) $form->locale() : '';
	if ( '' === $locale ) {
		$locale = determine_locale();
	}

	return array(
		'enabled'  => true,
		'form_id'  => $form_id,
		'rest_url' => rest_url( 'contact-form-7/v1/contact-forms/' . $form_id . '/feedback' ),
		'unit_tag' => sprintf( 'wpcf7-f%d-o1', $form_id ),
		'locale'   => $locale,
		'version'  => defined( 'WPCF7_VERSION' ) ? (string) WPCF7_VERSION : '',
		'fields'   => homesea_theme_cf7_field_map(),
		'flamingo' => class_exists( 'Flamingo_Inbound_Message' ),
	);
}

/**
 * Bootstrap: ensure form exists once plugins are loaded.
 */
function homesea_theme_cf7_contact_boot(): void {
	if ( ! homesea_theme_cf7_ready() ) {
		return;
	}

	$existing_id = absint( homesea_theme_cf7_contact_option( 'cf7_id', 0 ) );
	if ( $existing_id > 0 ) {
		return;
	}

	if ( is_admin() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
		homesea_theme_cf7_ensure_contact_form();
	}
}
add_action( 'init', 'homesea_theme_cf7_contact_boot', 30 );
