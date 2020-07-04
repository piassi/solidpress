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
			$this->args['fields'],
			$this->args['key']
		);

		acf_add_local_field_group($args);
	}
}
