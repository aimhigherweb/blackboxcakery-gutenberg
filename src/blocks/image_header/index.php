<?php
/**
 * Image Header Block
 *
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
function image_header_register_block() {
    // Enqueue block editor JS
    wp_register_script(
        'image_header/editor-scripts',
        plugins_url( '/../../../build/index.js', __FILE__ ),
        [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components']
    );

    register_block_type('aimhigher/image-header', array(
        'editor_script' => 'image_header/editor-scripts', 
    ));
}

// Hook the enqueue functions into the editor
add_action( 'init', 'image_header_register_block' );