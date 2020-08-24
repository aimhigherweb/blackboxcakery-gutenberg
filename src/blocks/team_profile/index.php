<?php
/**
 * Team Profile Block
 *
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
function team_profile_register_block() {
    // Enqueue block editor JS
    wp_register_script(
        'team_profile/editor-scripts',
        plugins_url( '/../../../build/index.js', __FILE__ ),
        [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components']
    );

    register_block_type('aimhigher/team-profile', array(
        'editor_script' => 'team_profile/editor-scripts', 
    ));
}

// Hook the enqueue functions into the editor
add_action( 'init', 'team_profile_register_block' );