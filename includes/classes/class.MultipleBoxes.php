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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MultipleBoxes {

	/**
	 * @var int
	 */

	private $product_id;

	/**
	 * @var array
	 */

	private $values;

	/**
	 * @var array
	 */

	private $boxes = [];

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
	 * @param $product_id int
	 * @param $values     array
	 */

	public function set_properties( $product_id, $values ) {

		$this->product_id = $product_id;
		$this->values     = $values;

	}

	/**
	 * Has boxes.
	 *
	 * @return bool
	 */

	public function has_boxes() {

		if ( is_array( $this->values ) ) {
			return TRUE;
		}

		return FALSE;

	}

	/**
	 * Set boxes.
	 */

	public function set_boxes() {

		foreach ( $this->values as $key => $value ) {
			array_push( $this->boxes[$key], $value );
		}

	}

	/**
	 * Get values.
	 *
	 * @param $value
	 * @param $key
	 *
	 * @return array
	 */

	public function get_box_values( $value, $key ) {
		return isset( $this->boxes[$key] ) ? $this->boxes[$key] : [];
	}

	/**
	 * Save data.
	 */

	public function save() {

		add_filter( 'woocommerce_multiple_box_shipping_get_post_value', [ $this, 'get_box_values' ], 10, 2 );

		$multibox_products = IgniteWoo_MultiBox_Products::instance();
		$multibox_products->save_shipping_meta( $this->product_id );

	}

}
