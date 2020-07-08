<?php

namespace SolidPress\Hooks;

use SolidPress\Models\Image;

class ACF {
	public function __construct()
	{
		add_action('acf/format_value/type=image', [$this, 'image_format_value'], 20, 3);
	}

	public function image_format_value( $value, $post_id, $field)
	{
		return is_array($value) ? Image::fromACF($value) : $value;
	}
}