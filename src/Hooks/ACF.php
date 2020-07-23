<?php

namespace SolidPress\Hooks;

use SolidPress\Core\Hook;
use SolidPress\Models\Image;

/**
 * ACF specific hooks
 */
class ACF extends Hook {
	/**
	 * Add actions
	 */
	public function __construct() {
		$this->add_action( 'acf/format_value/type=image', 'image_format_value', 20, 3 );
	}

	/**
	 * Hook into image acf field to return Image model instance
	 *
	 * @param array  $value - acf original value.
	 * @param [type] $post_id - post id.
	 * @param [type] $field - field.
	 * @return Image|array
	 */
	public function image_format_value( $value, $post_id, $field ) {
		return is_array( $value ) ? Image::fromACF( $value ) : $value;
	}
}