<?php
/**
 * Banner Block
 *
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
function banner_register_block() {
    // Enqueue block editor JS
    wp_register_script(
        'banner/editor-scripts',
        plugins_url( '/../../../build/index.js', __FILE__ ),
        [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components']
    );

    register_block_type('aimhigher/banner', array(
        'editor_script' => 'banner/editor-scripts', 
    ));
}

// Hook the enqueue functions into the editor
add_action( 'init', 'banner_register_block' );