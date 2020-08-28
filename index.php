<?php

/**
 * Plugin Name: Black Box Cakery Custom Gutenberg Blocks
 * Version: 1.0.0
 * Plugin URI: https://github.com/aimhigherweb/blackboxcakery-gutenberg
 * Author: AimHigher Web Design
 * Author URI: https://aimhigherweb.design
 *
 */


	require_once(__DIR__ . '/src/blocks/testimonials/index.php');
	require_once(__DIR__ . '/functions/acf.php');
	require_once(__DIR__ . '/functions/rest.php');
	require_once(__DIR__ . '/functions/product_fields.php');
	require_once(__DIR__ . '/functions/cake_order.php');

	add_action( 'enqueue_block_editor_assets', 'aimhigher_gutenberg_styles' );

	function aimhigher_gutenberg_styles() {
		// Load the theme styles within Gutenberg.
		wp_enqueue_style( 'aimhigher-gutenberg', plugins_url( '/build/css/styles.css', __FILE__ ), false );
	}

	function add_scripts() {
		wp_register_script('order_form_script', plugins_url('src/js/order_form.js', __FILE__));

		wp_enqueue_script('order_form_script');
	}

	add_action('wp_enqueue_scripts', 'add_scripts');

	// Add custom image size
	add_image_size( 'cake_image', 600, 375 );

?>