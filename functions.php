<?php

add_action( 'wp_enqueue_scripts', 'wsu_alert_enqueue_scripts' );

function wsu_alert_enqueue_scripts() {
	wp_enqueue_script( 'wsu-alert-functions', get_stylesheet_directory_uri() . '/js/functions.js', array( 'jquery' ), spine_get_script_version(), true );
	wp_enqueue_script( 'wsu-alert-tooltip', get_stylesheet_directory_uri() . '/js/dw_tooltip_c.js', array( 'jquery' ), spine_get_script_version(), true );
}
