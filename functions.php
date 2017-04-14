<?php

add_action( 'wp_enqueue_scripts', 'wsu_alert_enqueue_scripts' );
/**
 * Enqueues the scripts used by the child theme.
 */
function wsu_alert_enqueue_scripts() {
	wp_enqueue_script( 'wsu-alert-functions', get_stylesheet_directory_uri() . '/js/functions.js', array( 'jquery' ), spine_get_child_version(), true );
}

add_filter( 'spine_child_theme_version', 'wsu_alert_theme_version' );
/**
 * Provides an updated version number to help in breaking browser cache.
 *
 * @since 0.1.0
 *
 * @return string
 */
function wsu_alert_theme_version() {
	return '0.1.1';
}

/**
 * Provides the current alert level based on whether an active post exists
 * and what its categorized alert level is.
 *
 * @since 0.1.0
 *
 * @return string
 */
function wsu_alert_level() {
	$active_alerts = wsu_alert_get_latest();

	if ( 0 === count( $active_alerts ) ) {
		return 'clear';
	}

	$first_alert = array_shift( $active_alerts );

	$categories = get_the_category( $first_alert );

	foreach ( $categories as $category ) {
		if ( in_array( $category->slug, array( 'emergency', 'warning' ), true ) ) {
			return $category->slug;
		}
	}

	return 'clear';
}

/**
 * Retrieves the latest active alert.
 *
 * @since 0.1.0
 *
 * @return array
 */
function wsu_alert_get_latest() {
	$args = array(
		'meta_key' => 'wsu_alert_status',
		'meta_value' => 'active',
		'posts_per_page' => 1,
		'fields' => 'ids',
	);
	$active_alerts = get_posts( $args );

	return $active_alerts;
}

/**
 * Displays the header title with an overall alert status based on the current
 * alert level.
 *
 * @since 0.1.0
 */
function wsu_alert_display_status_title() {
	$level = wsu_alert_level();

	if ( 'emergency' === $level ) {
		echo 'There is an active emergency';
	} elseif ( 'warning' === $level ) {
		echo 'There is an active warning';
	} else {
		echo 'There are no WSU Pullman alerts';
	}
}

add_action( 'rest_api_init', 'wsu_alert_register_rest_endpoint' );
/**
 * Registers the active alert REST API endpoint.
 *
 * @since 0.2.0
 */
function wsu_alert_register_rest_endpoint() {
	register_rest_route( 'alert/v1', '/active/', array(
		'methods' => 'GET',
		'callback' => 'wsu_alert_handle_active_endpoint',
	) );
}

/**
 * Provides an endpoint information about any active alerts.
 *
 * @since 0.2.0
 *
 * @return array
 */
function wsu_alert_handle_active_endpoint() {
	if ( 'emergency' !== wsu_alert_level() ) {
		return array(
			'status' => 'clear',
			'message' => 'There are no active emergency alerts.',
			'url' => '',
		);
	}

	$active_alerts = wsu_alert_get_latest();
	$active_alert = array_shift( $active_alerts );
	setup_postdata( $active_alert );

	$data = array(
		'status' => 'emergency',
		'message' => get_the_title( $active_alert ),
		'url' => esc_url( get_the_permalink( $active_alert ) ),
	);
	wp_reset_postdata();

	return $data;
}

add_action( 'add_meta_boxes', 'wsu_alert_add_meta_boxes', 10 );
/**
 * Adds meta boxes used to manage alerts.
 *
 * @since 0.1.0
 *
 * @param string $post_type
 */
function wsu_alert_add_meta_boxes( $post_type ) {
	if ( 'post' !== $post_type ) {
		return;
	}

	add_meta_box( 'wsu_alert_active_status', 'Alert Status', 'wsu_alert_display_alert_status', 'post', 'side', 'high' );
}

/**
 * Displays the meta box used to capture an alert's active or inactive status.
 *
 * @since 0.1.0
 *
 * @param WP_Post $post
 */
function wsu_alert_display_alert_status( $post ) {
	$alert_status = get_post_meta( $post->ID, 'wsu_alert_status', true );

	if ( ! in_array( $alert_status, array( 'active', 'inactive' ), true ) ) {
		$alert_status = 'inactive';
	}

	?>
	<label for="alert-status-select">Alert Status:</label>
	<select id="alert-status-select" name="alert_status_select">
		<option value="inactive" <?php selected( 'inactive', $alert_status ); ?>>Not Active</option>
		<option value="active" <?php selected( 'active', $alert_status ); ?>>Active</option>
	</select>
	<?php
}

add_action( 'save_post', 'wsu_alert_save_post', 10, 2 );
/**
 * Saves the active or inactive status of an alert post.
 *
 * @since 0.1.0
 *
 * @param int     $post_id
 * @param WP_Post $post
 */
function wsu_alert_save_post( $post_id, $post ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( 'auto-draft' === $post->post_status ) {
		return;
	}

	// @codingStandardsIgnoreStart
	if ( ! isset( $_POST['alert_status_select'] ) ) {
		return;
	}

	if ( in_array( $_POST['alert_status_select'], array( 'inactive', 'active' ), true ) ) {
		update_post_meta( $post_id, 'wsu_alert_status', sanitize_text_field( $_POST['alert_status_select'] ) );
	} else {
		update_post_meta( $post_id, 'wsu_alert_status', 'inactive' );
	}
	// @codingStandardsIgnoreEnd
}

add_action( 'init', 'wsu_alert_unregister_taxonomies', 12 );
/**
 * Removes support for additional taxonomies on alerts.
 *
 * This helps to keep the new alert screen free of clutter so that it's
 * easier to manage things quickly without distraction.
 *
 * @since 0.1.0
 */
function wsu_alert_unregister_taxonomies() {
	unregister_taxonomy_for_object_type( 'wsuwp_university_category', 'post' );
	unregister_taxonomy_for_object_type( 'wsuwp_university_location', 'post' );
	unregister_taxonomy_for_object_type( 'wsuwp_university_org', 'post' );
}

add_action( 'after_setup_theme', 'wsu_alert_setup_image_sizes', 9 );
/**
 * Removes support for featured images and other post thumbnails on alerts.
 *
 * This helps to keep the new alert screen free of clutter. If background
 * images are needed for other pages on the site, we'll need to selectively
 * re-enable them.
 *
 * @since 0.1.0
 */
function wsu_alert_setup_image_sizes() {
	remove_theme_support( 'post-thumbnails' );
	remove_action( 'after_setup_theme', 'Spine_Theme_Images' );
}
