<?php
namespace AppleMapsForWordpress\Gutenberg;
use AppleMapsForWordpress\Core as Core;

/**
 * Default setup routine
 *
 * @return void
 */
function setup() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	// Gutenberg Editor assets.
	add_action( 'enqueue_block_editor_assets', $n('enqueue_ad_block_editor_assets' ) );
	// Gutenberg Front End Assets.
	add_action( 'enqueue_block_assets', $n('enqueue_ad_block_assets' ) );
}


/**
 * Enqueue the block's assets for the editor.
 *
 * `wp-blocks`: includes block type registration and related functions.
 * `wp-element`: includes the WordPress Element abstraction for describing the structure of your blocks.
 * `wp-i18n`: To internationalize the block's text.
 *
 * @since 1.0.0
 */
function enqueue_ad_block_editor_assets() {
	wp_enqueue_script( 'mapkitjs', 'https://cdn.apple-mapkit.com/mk/5.x.x/mapkit.js', [], false );
	wp_enqueue_script(
		'apple-maps-wordpress-blocks', // Handle.
		Core\script_url( 'gutenberg', 'gutenberg' ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ) // Dependencies, defined above.
	);

	// Localize the script so we can have access to the settings.
	$settings = get_option( 'amfwp_settings', [] );
	wp_localize_script( 'apple-maps-wordpress-blocks', 'AMFWP', [ 'settings' => $settings ] );

	// Styles.
//	wp_enqueue_style(
//		'map-block-editor', // Handle.
//		plugins_url( 'assets/css/blocks.editor.css', dirname( __FILE__ ) ), // Block editor CSS.
//		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
//		filemtime( plugin_dir_path( dirname( __FILE__ ) ) . '/assets/css/blocks.editor.css' ) // filemtime — Gets file modification time.
//	);
}

function enqueue_ad_block_assets() { }
