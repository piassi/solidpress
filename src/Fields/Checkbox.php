<?php
namespace SolidPress\Fields;

use SolidPress\Core\Field;

/**
 * Checkbox field type
 *
 * @param array choices Array of choices where the item['key'] is used as value and the value is used as label.
 * @param string layout Specify the layout of the checkbox inputs between 'vertical' and 'horizontal'. Defaults to 'vertical'.
 * @param bool allow_custom Whether to allow custom options to be added by the user. Default false.
 * @param bool save_custom Whether to allow custom options to be saved to the field choices. Default false.
 * @param bool toggle Adds a "Toggle all" checkbox to the list. Default false.
 * @param string return_format Specify how the value is formatted when loaded. Choices of 'value', 'label' or 'array'. Default 'value'.
 *
 * @see https://www.advancedcustomfields.com/resources/checkbox/
 */
class Checkbox extends Field {
	public $defaults = ['type' => 'checkbox'];
}
