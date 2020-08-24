<?php
/**
 * Embed Captions Block
 *
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
function embed_captions_register_block() {
    // Enqueue block editor JS
    wp_register_script(
        'embed_captions/editor-scripts',
        plugins_url( '/../../../build/index.js', __FILE__ ),
        [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components']
    );

    register_block_type('aimhigher/embed-captions', array(
        'editor_script' => 'embed_captions/editor-scripts', 
    ));
}

// Hook the enqueue functions into the editor
add_action( 'init', 'embed_captions_register_block' );