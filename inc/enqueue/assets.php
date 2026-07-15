<?php
/**
 * Enqueue theme assets (Vite HMR or dist manifest).
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue frontend scripts and styles.
 */
function homesea_theme_enqueue_assets(): void {
	$handle = 'homesea_theme-app';

	if ( homesea_theme_is_vite_running() ) {
		$public = homesea_theme_vite_public_url();

		wp_enqueue_script(
			'homesea_theme-vite-client',
			$public . '/@vite/client',
			array(),
			null,
			array(
				'in_footer' => true,
			)
		);

		wp_enqueue_script(
			$handle,
			$public . '/src/main.jsx',
			array( 'homesea_theme-vite-client' ),
			null,
			array(
				'in_footer' => true,
			)
		);

		homesea_theme_script_type_module( array( 'homesea_theme-vite-client', $handle ) );

		// Preamble must appear as type="module" before Vite client (wp_footer priority 1).
		add_action(
			'wp_footer',
			static function () use ( $public ): void {
				$refresh = esc_url( $public . '/@react-refresh' );
				echo '<script type="module">' . "\n";
				echo 'import RefreshRuntime from "' . $refresh . '";' . "\n";
				echo 'RefreshRuntime.injectIntoGlobalHook(window);' . "\n";
				echo 'window.$RefreshReg$ = () => {};' . "\n";
				echo 'window.$RefreshSig$ = () => (type) => type;' . "\n";
				echo 'window.__vite_plugin_react_preamble_installed__ = true;' . "\n";
				echo '</script>' . "\n";
			},
			1
		);
	} else {
		$manifest = homesea_theme_get_vite_manifest();

		if ( null === $manifest || ! isset( $manifest['src/main.jsx'] ) ) {
			return;
		}

		$entry = $manifest['src/main.jsx'];
		$dist  = trailingslashit( HOMESEA_THEME_URI ) . 'dist/';

		if ( ! empty( $entry['css'] ) && is_array( $entry['css'] ) ) {
			foreach ( $entry['css'] as $index => $css_file ) {
				wp_enqueue_style(
					'homesea_theme-app-' . $index,
					$dist . ltrim( (string) $css_file, '/' ),
					array(),
					HOMESEA_THEME_VERSION
				);
			}
		}

		if ( ! empty( $entry['file'] ) ) {
			wp_enqueue_script(
				$handle,
				$dist . ltrim( (string) $entry['file'], '/' ),
				array(),
				HOMESEA_THEME_VERSION,
				array(
					'in_footer' => true,
				)
			);

			homesea_theme_script_type_module( array( $handle ) );
		}
	}

	$view         = 'home';
	$propiedad    = null;
	$proyecto     = null;
	$collection   = array();
	$prop_catalog = function_exists( 'homesea_theme_propiedad_archive_url' )
		? homesea_theme_propiedad_archive_url()
		: home_url( '/propiedades/' );
	$proj_catalog = function_exists( 'homesea_theme_proyecto_archive_url' )
		? homesea_theme_proyecto_archive_url()
		: home_url( '/proyectos/' );

	if ( is_singular( 'propiedad' ) && function_exists( 'homesea_theme_propiedad_to_detail' ) ) {
		$post = get_queried_object();
		if ( ! $post instanceof WP_Post ) {
			$post = get_post();
		}
		if ( $post instanceof WP_Post && 'propiedad' === $post->post_type ) {
			$view      = 'propiedad';
			$propiedad = homesea_theme_propiedad_to_detail( $post );
		}
	} elseif ( is_post_type_archive( 'propiedad' ) && function_exists( 'homesea_theme_query_propiedad_collection' ) ) {
		$view       = 'propiedades-collection';
		$collection = homesea_theme_query_propiedad_collection();
	} elseif ( is_singular( 'proyecto' ) && function_exists( 'homesea_theme_proyecto_to_detail' ) ) {
		$post = get_queried_object();
		if ( ! $post instanceof WP_Post ) {
			$post = get_post();
		}
		if ( $post instanceof WP_Post && 'proyecto' === $post->post_type ) {
			$view     = 'proyecto';
			$proyecto = homesea_theme_proyecto_to_detail( $post );
		}
	} elseif ( is_post_type_archive( 'proyecto' ) && function_exists( 'homesea_theme_query_proyecto_collection' ) ) {
		$view       = 'proyectos-collection';
		$collection = homesea_theme_query_proyecto_collection();
	}

	wp_localize_script(
		$handle,
		'homeSeaThemeData',
		array(
			'apiUrl'                 => homesea_theme_rest_url( 'theme/v1/site' ),
			'nonce'                  => wp_create_nonce( 'wp_rest' ),
			'homeUrl'                => esc_url_raw( home_url( '/' ) ),
			'collectionUrl'          => esc_url_raw( $prop_catalog ),
			'projectsCollectionUrl'  => esc_url_raw( $proj_catalog ),
			'themeUri'               => esc_url_raw( HOMESEA_THEME_URI ),
			'view'                   => $view,
			'propiedad'              => $propiedad,
			'proyecto'               => $proyecto,
			'collection'             => $collection,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'homesea_theme_enqueue_assets' );

/**
 * Force type="module" on Vite-related script tags.
 *
 * @param string[] $handles Script handles.
 */
function homesea_theme_script_type_module( array $handles ): void {
	add_filter(
		'script_loader_tag',
		static function ( string $tag, string $handle, string $src ) use ( $handles ): string {
			if ( ! in_array( $handle, $handles, true ) ) {
				return $tag;
			}

			return sprintf(
				'<script type="module" crossorigin src="%s" id="%s-js"></script>' . "\n",
				esc_url( $src ),
				esc_attr( $handle )
			);
		},
		10,
		3
	);
}
