<?php
/**
 * Theme setup.
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme supports and menus.
 */
function homesea_theme_setup(): void {
	load_theme_textdomain( 'homesea_theme', HOMESEA_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'homesea_theme' ),
			'footer'  => __( 'Footer Menu', 'homesea_theme' ),
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'homesea_theme' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here.', 'homesea_theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'after_setup_theme', 'homesea_theme_setup' );
