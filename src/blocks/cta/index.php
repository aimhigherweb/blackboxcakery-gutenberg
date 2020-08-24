<?php
/**
 * CTA Block
 *
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
function cta_register_block() {
    // Enqueue block editor JS
    wp_register_script(
        'cta/editor-scripts',
        plugins_url( '/../../../build/index.js', __FILE__ ),
        [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components']
    );

    register_block_type('aimhigher/cta', array(
        'editor_script' => 'cta/editor-scripts', 
    ));
}

// Hook the enqueue functions into the editor
add_action( 'init', 'cta_register_block' );