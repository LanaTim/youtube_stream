<?php
/**
 * Plugin Name: Custom YouTube Embed
 * Plugin URI:
 * Description: An plugin to embed YouTube videos responsively.
 * Version: 1.0
 */

$functions_dir = plugin_dir_path( __FILE__ ) . 'includes/';
// Include all the various functions
include_once( $functions_dir . 'settings.php' );
include_once( $functions_dir . 'button.php' );
include_once( $functions_dir . 'view_player.php' );
