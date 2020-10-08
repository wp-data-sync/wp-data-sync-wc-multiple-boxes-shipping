<?php
/**
 * Plugin Name: WP Data Sync for WooCommerce Multiple Boxes Product Shipping
 * Plugin URI:  https://wpdatasync.com/products/
 * Description: Integrates WooCommerce Multiple Boxes Product Shipping with WP Data Sync
 * Version:     1.0.0
 * Author:      WP Data Sync
 * Author URI:  https://wpdatasync.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-data-sync-multiple-boxes
 * Domain Path: /languages
 *
 * WC requires at least: 3.0
 * WC tested up to: 4.5.2
 *
 * Package:     WP_DataSync_Multiple_Boxes
*/

namespace WP_DataSync\Multiple_Boxes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WP_DATA_SYNC_MB_VERSION', '1.0.0' );

foreach ( glob( plugin_dir_path( __FILE__ ) . 'includes/**/*.php' ) as $file ) {
	require_once $file;
}

add_action( 'wp_data_sync_item_request', function( $item_data, $product_id, $data_sync ) {

	if ( class_exists('IgniteWoo_MultiBox_Products') ) {

		$multiple_boxes = Inc\MultipleBoxes::instance();
		$multiple_boxes->set_properties( $item_data, $product_id, $data_sync );

		if ( $multiple_boxes->has_boxes() ) {
			$multiple_boxes->save();
		}

	}

}, 10, 3 );
