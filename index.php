<?php

/**
 * Plugin Name: Black Box Cakery Custom Gutenberg Blocks
 * Version: 1.0.0
 * Plugin URI: https://github.com/aimhigherweb/blackboxcakery-gutenberg
 * Author: AimHigher Web Design
 * Author URI: https://aimhigherweb.design
 *
 */


	require_once(__DIR__ . '/src/blocks/colour_container/index.php');

	add_action( 'enqueue_block_editor_assets', 'aimhigher_gutenberg_styles' );

	function aimhigher_gutenberg_styles() {
		// Load the theme styles within Gutenberg.
		wp_enqueue_style( 'aimhigher-gutenberg', plugins_url( '/build/css/styles.css', __FILE__ ), false );
	}

?>