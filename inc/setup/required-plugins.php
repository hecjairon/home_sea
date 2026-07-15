<?php
/**
 * Install and activate required plugins on theme activation.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Required plugins (WordPress.org slugs).
 *
 * @return array<int, array{slug: string, file: string, name: string}>
 */
function homesea_theme_required_plugins(): array {
	return array(
		array(
			'slug' => 'cmb2',
			'file' => 'cmb2/init.php',
			'name' => 'CMB2',
		),
		array(
			'slug' => 'contact-form-7',
			'file' => 'contact-form-7/wp-contact-form-7.php',
			'name' => 'Contact Form 7',
		),
		array(
			'slug' => 'flamingo',
			'file' => 'flamingo/flamingo.php',
			'name' => 'Flamingo',
		),
	);
}

/**
 * Whether a plugin file is installed (active or not).
 */
function homesea_theme_plugin_is_installed( string $plugin_file ): bool {
	return file_exists( WP_PLUGIN_DIR . '/' . $plugin_file );
}

/**
 * Whether a plugin file is active.
 */
function homesea_theme_plugin_is_active( string $plugin_file ): bool {
	if ( ! function_exists( 'is_plugin_active' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	return is_plugin_active( $plugin_file );
}

/**
 * Load admin includes needed for Plugin_Upgrader.
 */
function homesea_theme_load_plugin_installer(): void {
	if ( ! function_exists( 'plugins_api' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	}
	if ( ! class_exists( 'Plugin_Upgrader' ) ) {
		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	}
	if ( ! function_exists( 'request_filesystem_credentials' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}
	if ( ! function_exists( 'get_plugin_data' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
}

/**
 * Install a plugin from wordpress.org by slug.
 *
 * @return true|WP_Error
 */
function homesea_theme_install_plugin_from_org( string $slug ) {
	homesea_theme_load_plugin_installer();

	$api = plugins_api(
		'plugin_information',
		array(
			'slug'   => $slug,
			'fields' => array(
				'sections' => false,
			),
		)
	);

	if ( is_wp_error( $api ) ) {
		return $api;
	}

	if ( empty( $api->download_link ) ) {
		return new WP_Error(
			'homesea_theme_no_download',
			sprintf(
				/* translators: %s: plugin slug */
				__( 'No se encontró el enlace de descarga para «%s».', 'homesea_theme' ),
				$slug
			)
		);
	}

	$skin     = new Automatic_Upgrader_Skin();
	$upgrader = new Plugin_Upgrader( $skin );
	$result   = $upgrader->install( $api->download_link );

	if ( is_wp_error( $result ) ) {
		return $result;
	}

	if ( true !== $result ) {
		return new WP_Error(
			'homesea_theme_install_failed',
			sprintf(
				/* translators: %s: plugin slug */
				__( 'No se pudo instalar el plugin «%s».', 'homesea_theme' ),
				$slug
			)
		);
	}

	return true;
}

/**
 * Ensure required plugins are installed and activated.
 *
 * @return array{installed: string[], activated: string[], errors: string[]}
 */
function homesea_theme_ensure_required_plugins(): array {
	$report = array(
		'installed' => array(),
		'activated' => array(),
		'errors'    => array(),
	);

	if ( ! current_user_can( 'install_plugins' ) || ! current_user_can( 'activate_plugins' ) ) {
		$report['errors'][] = __( 'No tienes permisos para instalar o activar plugins.', 'homesea_theme' );
		return $report;
	}

	homesea_theme_load_plugin_installer();

	foreach ( homesea_theme_required_plugins() as $plugin ) {
		$slug = $plugin['slug'];
		$file = $plugin['file'];
		$name = $plugin['name'];

		if ( ! homesea_theme_plugin_is_installed( $file ) ) {
			$result = homesea_theme_install_plugin_from_org( $slug );

			if ( is_wp_error( $result ) ) {
				$report['errors'][] = sprintf(
					/* translators: 1: plugin name, 2: error message */
					__( '%1$s: %2$s', 'homesea_theme' ),
					$name,
					$result->get_error_message()
				);
				continue;
			}

			$report['installed'][] = $name;
		}

		if ( ! homesea_theme_plugin_is_active( $file ) ) {
			$activate = activate_plugin( $file, '', false, true );

			if ( is_wp_error( $activate ) ) {
				$report['errors'][] = sprintf(
					/* translators: 1: plugin name, 2: error message */
					__( '%1$s (activar): %2$s', 'homesea_theme' ),
					$name,
					$activate->get_error_message()
				);
				continue;
			}

			$report['activated'][] = $name;
		}
	}

	return $report;
}

/**
 * List required plugins that are missing or inactive.
 *
 * @return array<int, array{slug: string, file: string, name: string, status: string}>
 */
function homesea_theme_missing_required_plugins(): array {
	$missing = array();

	if ( ! function_exists( 'is_plugin_active' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	foreach ( homesea_theme_required_plugins() as $plugin ) {
		if ( ! homesea_theme_plugin_is_installed( $plugin['file'] ) ) {
			$plugin['status'] = 'not_installed';
			$missing[]        = $plugin;
			continue;
		}

		if ( ! homesea_theme_plugin_is_active( $plugin['file'] ) ) {
			$plugin['status'] = 'inactive';
			$missing[]        = $plugin;
		}
	}

	return $missing;
}

/**
 * Run installer when the theme is activated.
 */
function homesea_theme_on_switch_install_plugins(): void {
	$report = homesea_theme_ensure_required_plugins();
	set_transient( 'homesea_theme_plugin_install_report', $report, MINUTE_IN_SECONDS * 5 );
}
add_action( 'after_switch_theme', 'homesea_theme_on_switch_install_plugins' );

/**
 * Admin notice after theme switch (and if plugins are still missing).
 */
function homesea_theme_required_plugins_admin_notice(): void {
	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}

	$report  = get_transient( 'homesea_theme_plugin_install_report' );
	$missing = homesea_theme_missing_required_plugins();

	if ( false !== $report ) {
		delete_transient( 'homesea_theme_plugin_install_report' );

		$parts = array();

		if ( ! empty( $report['installed'] ) ) {
			$parts[] = sprintf(
				/* translators: %s: comma-separated plugin names */
				__( 'Instalados: %s.', 'homesea_theme' ),
				implode( ', ', $report['installed'] )
			);
		}

		if ( ! empty( $report['activated'] ) ) {
			$parts[] = sprintf(
				/* translators: %s: comma-separated plugin names */
				__( 'Activados: %s.', 'homesea_theme' ),
				implode( ', ', $report['activated'] )
			);
		}

		if ( ! empty( $report['errors'] ) ) {
			printf(
				'<div class="notice notice-warning is-dismissible"><p><strong>%s</strong> %s</p><p>%s</p></div>',
				esc_html__( 'HomeSea Theme — plugins requeridos', 'homesea_theme' ),
				esc_html( implode( ' ', $parts ) ),
				esc_html( implode( ' | ', $report['errors'] ) )
			);
		} elseif ( ! empty( $parts ) ) {
			printf(
				'<div class="notice notice-success is-dismissible"><p><strong>%s</strong> %s</p></div>',
				esc_html__( 'HomeSea Theme — plugins requeridos', 'homesea_theme' ),
				esc_html( implode( ' ', $parts ) )
			);
		}
	}

	if ( empty( $missing ) ) {
		return;
	}

	$names = array_map(
		static function ( array $plugin ): string {
			return $plugin['name'];
		},
		$missing
	);

	$url = wp_nonce_url(
		add_query_arg( 'homesea_theme_install_plugins', '1', admin_url( 'themes.php' ) ),
		'homesea_theme_install_plugins'
	);

	printf(
		'<div class="notice notice-error"><p><strong>%1$s</strong> %2$s</p><p><a class="button button-primary" href="%3$s">%4$s</a></p></div>',
		esc_html__( 'HomeSea Theme necesita estos plugins:', 'homesea_theme' ),
		esc_html( implode( ', ', $names ) ),
		esc_url( $url ),
		esc_html__( 'Instalar / activar ahora', 'homesea_theme' )
	);
}
add_action( 'admin_notices', 'homesea_theme_required_plugins_admin_notice' );

/**
 * Manual install trigger from admin notice button.
 */
function homesea_theme_handle_manual_plugin_install(): void {
	if ( ! is_admin() || empty( $_GET['homesea_theme_install_plugins'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}

	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}

	check_admin_referer( 'homesea_theme_install_plugins' );

	$report = homesea_theme_ensure_required_plugins();
	set_transient( 'homesea_theme_plugin_install_report', $report, MINUTE_IN_SECONDS * 5 );

	wp_safe_redirect( remove_query_arg( array( 'homesea_theme_install_plugins', '_wpnonce' ) ) );
	exit;
}
add_action( 'admin_init', 'homesea_theme_handle_manual_plugin_install' );
