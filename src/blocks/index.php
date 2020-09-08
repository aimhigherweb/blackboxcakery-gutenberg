<?php
/**
 * Register Custom Blocks
 *
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
function aimhigher_register_block() {
    // automatically load dependencies and version
    $asset_file = include( plugin_dir_path( __FILE__ ) . '/../../build/index.asset.php');

    // Enqueue block editor JS
    wp_register_script(
        'aimhigher/editor-scripts',
        plugins_url( '/../../build/index.js', __FILE__ ),
        $asset_file['dependencies'],
        $asset_file['version']
    );

    register_block_type('aimhigher/testimonials', array(
        'editor_script' => 'aimhigher/editor-scripts', 
    ));

    register_block_type('aimhigher/order-form', array(
        'editor_script' => 'aimhigher/editor-scripts', 
        'render_callback' => 'order_form_dynamic_render_callback'
    ));

    function order_form_dynamic_render_callback() {
        return include( plugin_dir_path( __FILE__ ) . 'order_form/form.php');
    }
}

// Hook the enqueue functions into the editor
add_action( 'init', 'aimhigher_register_block' );