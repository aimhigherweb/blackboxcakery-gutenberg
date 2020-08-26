<?php
/**
 * Order Form Block
 *
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
function order_form_register_block() {
    // Enqueue block editor JS
    wp_register_script(
        'order_form/editor-scripts',
        plugins_url( '/../../../build/index.js', __FILE__ ),
        [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components']
    );

    register_block_type('aimhigher/order-form', array(
        'editor_script' => 'order_form/editor-scripts', 
    ));
}

// Hook the enqueue functions into the editor
add_action( 'init', 'order_form_register_block' );