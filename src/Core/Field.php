<?php

namespace SolidPress\Core;

/**
 * Creates a new interface to ACF Field
 *
 * This class must be extended and files must be in /SolidPress/Core/Fields directory
 *
 * @param string key Unique identifier for the field. Must begin with 'field_'
 * @param string label Visible when editing the field value
 * @param string name Used to save and load data. Single word, no spaces. Underscores and dashes allowed
 * @param string parent Instructions for authors. Shown when submitting data
 * @param string instructions Instructions for authors. Shown when submitting data
 * @param int required Whether or not the field value is required. Defaults to 0
 * @param array conditional_logic Conditionally hide or show this field based on other field's values
 * @param array wrapper An array of attributes (width, class and id) given to the field element
 * @param string default_value A default value used by ACF if no value has yet been saved
 *
 * @see https://www.advancedcustomfields.com/resources/register-fields-via-php/
 */
abstract class Field {
	public $args = [];
	public $defaults = [];

	public function __construct(string $label, array $args = []) {
		$args['label'] = $label;
		$this->args = array_merge($args, $this->defaults);
	}

	/**
	 * Get field args that will be used in acf_add_local_field_group function.
	 *
	 * @param string $group_key - field group key, will be prepended to field key.
	 * @param string $field_name - field name prefixed by field group key will be used as key.
	 * @return array
	 */
	public function get_args(string $group_key, string $field_name): array {
		$this->args['name'] = $field_name;
		$this->args['key'] = $group_key . '_' . $field_name;

		$args = $this->args;

		if (isset($this->args['sub_fields']) && $this->args['sub_fields']) {
			$args['sub_fields'] = Field::get_fields_args(
				$this->args['sub_fields'],
				$this->args['key']
			);
		}

		if (isset($this->args['layouts']) && $this->args['layouts']) {
			$args['layouts'] = Field::get_fields_args(
				$this->args['layouts'],
				$this->args['key']
			);
		}

		return (array) $args;
	}

	/**
	 * Get args from multiple Field instances in array.
	 *
	 * @param array $fields - must contain Field instances.
	 * @param string $parent_key
	 * @return array
	 */
	public static function get_fields_args(
		array $fields,
		string $parent_key
	): array {
		$fields_args = [];

		foreach ($fields as $field_name => $field) {
			$fields_args[] = $field->get_args($parent_key, $field_name);
		}

		return $fields_args;
	}

	public function get_value(string $field_key, array $parent)
	{
		return get_field($field_key);
	}
}
