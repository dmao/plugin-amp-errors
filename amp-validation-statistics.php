<?php
/**
 * Plugin Name:     Amp Validation Statistics
 * Description:     Amp Validation Statistics and template mode.
 * Version:         0.1.0
 * Author:          The WordPress Contributors
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     amp-validation-stats
 *
 * @package         create-block
 */

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function create_block_amp_validation_statistics_block_init() {
	$dir = dirname( __FILE__ );

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "create-block/amp-validation-statistics" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = require( $script_asset_path );
	wp_register_script(
		'create-block-amp-validation-statistics-block-editor',
		plugins_url( $index_js, __FILE__ ),
		array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor' ),
		$script_asset['dependencies'],
		$script_asset['version']
	);

	$editor_css = 'build/index.css';
	wp_register_style(
		'create-block-amp-validation-statistics-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'build/style-index.css';
	wp_register_style(
		'create-block-amp-validation-statistics-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type(
		'create-block/amp-validation-statistics',
		array(
			'editor_script'   => 'create-block-amp-validation-statistics-block-editor',
			'editor_style'    => 'create-block-amp-validation-statistics-block-editor',
			'style'           => 'create-block-amp-validation-statistics-block',
			'render_callback' => 'render_dynamic_block',
			'attributes'      => array(
				'ampMode'  => array(
					'type'    => 'boolean',
					'default' => false,
				),
			),
		)
	);
}
add_action( 'init', 'create_block_amp_validation_statistics_block_init' );


if ( ! function_exists( 'render_dynamic_block' ) ) {
	/**
	 * Server rendering.
	 *
	 * @param string $attr share attributes with the php.
	 */
	function render_dynamic_block( $attr ) {
		// Call the class.
		require_once 'include/class-amp-validation-statistics-server-rendering.php';

		$stats = new Amp_Validation_Statistics_Server_Rendering();
		$html  = '
			<h2>AMP validation statistics</h2>
			<p>There are <span>' . $stats->get_url_count() . '</span> validated url</p>
			<p>There are <span>' . $stats->get_error_count() . '</span> validation error</p>
		';
		if ( $attr['ampMode'] ) {
			$html .= '<p>The template mode is <span>' . $stats->get_template_mode() . '</span></p>';
		}
		return $html;
	}
}

