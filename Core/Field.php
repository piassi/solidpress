<?php

namespace SolidPress\Core;

/**
 * Creates a new interface to ACF Field
 *
 * This class must be extended and files must be in /SolidPress/Core/Fields directory.
 */
abstract class Field
{
	public $args = [];
	public $defaults = [];

	public function __construct(string $label, array $args = [])
	{
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
	public function get_args(string $group_key, string $field_name): array
	{
		$this->args['name'] = $field_name;
		$this->args['key'] = $group_key . '_' . $field_name;

		$args = $this->args;

		if (isset($this->args['sub_fields']) && $this->args['sub_fields']) {
			$args['sub_fields'] = Field::get_fields_args($this->args['sub_fields'], $this->args['key']);
		}

		if (isset($this->args['layouts']) && $this->args['layouts']) {
			$args['layouts'] = Field::get_fields_args($this->args['layouts'], $this->args['key']);
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
	public static function get_fields_args(array $fields, string $parent_key): array
	{
		$fields_args = [];

		foreach ($fields as $field_name => $field) {
			$fields_args[] = $field->get_args($parent_key, $field_name);
		}

		return $fields_args;
	}
}
