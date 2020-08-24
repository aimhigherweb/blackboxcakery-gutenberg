<?php
/**
 * Image Container Block
 *
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
function image_container_register_block() {

    // Enqueue block editor JS
    wp_register_script(
        'image_container/editor-scripts',
        plugins_url( '/../../../build/index.js', __FILE__ ),
        [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components']
    );

    register_block_type('aimhigher/image-container', array(
        'editor_script' => 'image_container/editor-scripts', 
    ));
}

// Hook the enqueue functions into the editor
add_action( 'init', 'image_container_register_block' );