<?php
/**
 * Plugin Name: WordPress Admin Edit Post Breadcrumbs.
 * Version: 1.0
 * Plugin URI: https://github.com/marconmartins/fdl-edit-post-breadcrumbs
 * Description: Add breadcrumbs with edit links to the WordPress admin edit post screen.
 * Author: marcomartins
 * Author URI: http://fimdalinha.com
 * Text Domain: fdl-wpadmin-edit-post-breadcrumbs
 * Domain Path: /languages/
 * License: GPL v2 or later
 */


/**
 * Add breadcrumbs with edit links to the admin post edit screen.
 *
 * @param  WP_Post $post The post currently being edited.
 * @return void
 */
function fdl_wpadmin_edit_post_breadcrumbs( $post ) {

	$breadcrumbs = array();
	$output      = '';
	$ancestors   = get_post_ancestors( $post );

	foreach ( array_reverse( $ancestors ) as $ancestor ) {
		$breadcrumbs[] = '<a href="' . get_edit_post_link( $post ) . '">' . get_the_title( $ancestor ) . '</a>';
	}

	// Join the ancestor edit links and the current page title into breadcrumb links.
	if ( count( $breadcrumbs ) > 0 ) {

		$breadcrumbs[] = $post->post_title;

		$output .= '<div class="fdl-wpadmin-edit-post-breadcrumbs">';
		$output .= __( 'Path:', 'fdl-wpadmin-edit-post-breadcrumbs' ) . ' ' . implode( ' &raquo; ', $breadcrumbs ) . '<br><br>';
		$output .= '</div>';
	}

	/**
	 * Filter the breadcrumbs html output.
	 *
	 * @param string  $output    The breadcrumb links in HTML.
	 * @param array   $ancestors Array of IDs or empty if no ancestors are found. The
	 *                           direct parent is returned as the first value in
	 *                           the array. The highest level ancestor is returned
	 *                           as the last value in the array.
	 * @param WP_Post $post      The Post being edited.
	 */
	$output = apply_filters( 'fdl_wpadmin_edit_post_breadcrumbs_output', $output, $ancestors, $post );

	echo $output;

}
add_action( 'edit_form_top', 'fdl_wpadmin_edit_post_breadcrumbs' );
