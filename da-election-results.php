<?php 
/**
 * @package da-first-plugin
 */
/*
	Plugin Name: DA Election Results
	Plugin URI: https:/davidarago.com/plugin/da-election-results
	Description:  Plugin to display election result
	Version: 1.0.0
	Author: David Arago
	Author URI: https://davidarago.com
	License: GPLV2
	Text Domain: da-election-resulsts-domain
 */
define('WP_DEBUG', true);

defined ( 'ABSPATH' ) or die();  //Makes sure that the plugin is inizialized by WP.

//Load Scripts
require_once( plugin_dir_path( __FILE__ ).'/includes/da-election-results-scripts.php' );

//Load Class
require_once( plugin_dir_path( __FILE__ ).'/includes/da-election-results-class.php' );

//Register Widget
function register_da_election_results() {
	register_widget(  'DA_Election_Results_Widget' );  //Class Name
}
//Hook in function
add_action( 'widgets_init', 'register_da_election_results' );