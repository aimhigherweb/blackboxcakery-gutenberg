<?php
/**
 * Grid Container Block
 *
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
function grid_container_register_block() {

    // Enqueue block editor JS
    wp_register_script(
        'grid_container/editor-scripts',
        plugins_url( '/../../../build/index.js', __FILE__ ),
        [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components']
    );

    register_block_type('aimhigher/grid-container', array(
        'editor_script' => 'grid_container/editor-scripts', 
    ));
}

// Hook the enqueue functions into the editor
add_action( 'init', 'grid_container_register_block' );