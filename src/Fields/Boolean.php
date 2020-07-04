<?php
namespace SolidPress\Fields;

use SolidPress\Core\Field;

/**
 * Boolean field type
 *
 * @param string $message Text shown along side the checkbox
 *
 * @see https://www.advancedcustomfields.com/resources/true-false/
 */
class Boolean extends Field {
	public $defaults = ['type' => 'true_false'];
}
