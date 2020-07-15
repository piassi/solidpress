<?php

namespace SolidPress\Core;

use SolidPress\Interfaces\Registrable;

/**
 * Creates a new interface to ACF Field Groups
 */
abstract class FieldsGroup implements Registrable {
	/**
	 * Field group register arguments
	 *
	 * @var array
	 */
	protected $args = [];
	protected $fields = [];


	/**
	 * Get group fields args and register them with acf_add_local_field_group function.
	 *
	 * @see https://www.advancedcustomfields.com/resources/register-fields-via-php/
	 *
	 * @return void
	 */
	public function register(): void {
		$args = $this->args;
		$args['fields'] = Field::get_fields_args(
			$this->fields,
			$this->args['key']
		);

		acf_add_local_field_group($args);
	}

	public function set_fields(array $fields): void
	{
		$this->fields = $fields;
	}

	public static function get_values(FieldsGroup $fields_group, array $fields_to_get = []): array
	{
		if(!$fields_to_get){
			$fields_to_get = array_keys($fields_group->fields);
		}

		$fields_values = [];

		foreach($fields_group->fields as $field_key => $field){
			$fields_values[$field_key] = $field->get_value($field_key, $fields_group->args) ?? [];
		}

		return $fields_values;
	}
}
