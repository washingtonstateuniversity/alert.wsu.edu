<?php

add_action( 'wp_enqueue_scripts', 'wsu_alert_enqueue_scripts' );

function wsu_alert_enqueue_scripts() {
	wp_enqueue_script( 'wsu-alert-accordion', get_stylesheet_directory_uri() . '/js/accordion.js', array( 'jquery' ), spine_get_script_version(), true );
}
