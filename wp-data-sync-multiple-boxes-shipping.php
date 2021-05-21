<?php
/**
 * Plugin Name: WP Data Sync for WooCommerce Multiple Boxes Product Shipping
 * Plugin URI:  https://wpdatasync.com/products/
 * Description: Integrates WooCommerce Multiple Boxes Product Shipping with WP Data Sync
 * Version:     2.0.0
 * Author:      WP Data Sync
 * Author URI:  https://wpdatasync.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-data-sync-multiple-boxes
 * Domain Path: /languages
 * Package:     WP_DataSync
*/

namespace WP_DataSync\Multiple_Boxes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Runs after all other WP data is processed.
 * We use a priority of 999 to insure this runs after WooCommerce.
 */

add_action( 'wp_data_sync_integration_wc_multiple_boxes', function( $product_id, $boxes ) {

	$the_boxes = [];

	foreach( $boxes as $box ) {

		$values = array_values( $box );
		$box    = implode( ',', $values );

		$the_boxes[] = $box;

	}

	$the_boxes = implode( '|', $the_boxes );

	update_post_meta( $product_id, '_wc_multibox_additional_box', $the_boxes, FALSE );

}, 999, 2 );
