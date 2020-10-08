<?php
/**
 * MultipleBoxes
 *
 * Process multiple boxes data
 *
 * @since   1.0.0
 *
 * @package WP_DataSync_Multiple_Boxes
 */

namespace WP_DataSync\Multiple_Boxes\Inc;

use WP_DataSync\App\DataSync;
use IgniteWoo_MultiBox_Products;
use WC_Product;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MultipleBoxes {

	/**
	 * @var array
	 */

	private $item_data;

	/**
	 * @var int
	 */

	private $product_id;

	/**
	 * @var DataSync
	 */

	private $data_sync;

	/**
	 * @var array
	 */

	private $boxes;

	/**
	 * @var MultipleBoxes
	 */

	public static $instance;

	/**
	 * MultipleBoxes constructor.
	 */

	public function __construct() {
		self::$instance = $this;
	}

	/**
	 * @return MultipleBoxes
	 */

	public static function instance() {

		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Set object properties.
	 *
	 * @param $item_data  array
	 * @param $product_id int
	 * @param $data_sync  DataSync
	 */

	public function set_properties( $item_data, $product_id, $data_sync ) {

		$this->item_data  = $item_data;
		$this->product_id = $product_id;
		$this->data_sync  = $data_sync;

	}

	/**
	 * Has boxes.
	 *
	 * @return bool
	 */

	public function has_boxes() {

		if ( $integrations = $this->data_sync->get_integrations() ) {

			if ( isset( $integrations['multiple_boxes'] ) && is_array( $integrations['multiple_boxes'] ) ) {

				$this->boxes = $integrations['multiple_boxes'];

				return TRUE;

			}

		}

		return FALSE;

	}

	/**
	 * Get boxes.
	 *
	 * @param $value
	 *
	 * @return array [
	 *              weight => string,
	 *              length => string,
	 *              width  => string,
	 *              height => string,
	 *              price  => string
	 *          ]
	 */

	public function get_boxes( $value ) {
		return $this->boxes;
	}

	/**
	 * Save data.
	 */

	public function save() {

		$product = new WC_Product( $this->product_id );

		add_filter( 'woocommerce_multiple_box_shipping_get_post_value', [ $this, 'get_boxes' ] );

		$multibox_products = IgniteWoo_MultiBox_Products::instance();
		$multibox_products->save_shipping_meta( $this->product_id, $product->is_type( 'variable') );

	}

}
