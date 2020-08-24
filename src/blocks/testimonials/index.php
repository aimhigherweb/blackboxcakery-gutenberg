<?php
/**
 * Testimonials Block
 *
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
function testimonials_register_block() {
    // Enqueue block editor JS
    wp_register_script(
        'testimonials/editor-scripts',
        plugins_url( '/../../../build/index.js', __FILE__ ),
        [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components']
    );

    register_block_type('aimhigher/testimonials', array(
        'editor_script' => 'testimonials/editor-scripts', 
    ));
}

// Hook the enqueue functions into the editor
add_action( 'init', 'testimonials_register_block' );