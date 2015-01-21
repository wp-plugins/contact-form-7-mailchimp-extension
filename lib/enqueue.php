<?php


function wpcf7_spartan_admin_enqueue_scripts () {
	global $plugin_page;

	if ( ! isset( $plugin_page ) || 'wpcf7' != $plugin_page )
		return;

	wp_enqueue_style( 'wpcf7-spartan-admin',
		wpcf7_spartan_plugin_url( '../assets/css/style-spartan.css' ),
		array(), WPCF7_SPARTAN_VERSION, 'all' );

	wp_enqueue_script( 'wpcf7-spartan-admin',
		wpcf7_spartan_plugin_url( '../assets/js/scripts-spartan.js' ),
		array( 'jquery', 'wpcf7-admin' ), WPCF7_SPARTAN_VERSION, true );


}

add_action( 'admin_print_scripts', 'wpcf7_spartan_admin_enqueue_scripts' );