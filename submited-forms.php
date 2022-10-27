<?php
/*
 * @since             1.0.0
 * @package           Submited_Forms
 *
 * @wordpress-plugin
 * Plugin Name:       Submited forms
 * Description:       Save and show forms data
 * Version:           1.0.0
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

require plugin_dir_path( __FILE__ ) . 'includes/class-submited-forms.php';

register_activation_hook( __FILE__, function() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-submited-forms-activator.php';
	Submited_Forms_Activator::activate();
});

add_action( 'plugins_loaded', function() {
	$plugin = submited_forms();
	$plugin->run();
}, 0 );


function submited_forms() {
	return Submited_Forms::instance();
}
