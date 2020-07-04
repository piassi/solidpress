<?php

namespace SolidPress\Core;

use SolidPress\Interfaces\Registrable;

/**
 * Creates a new interface to acf options page.
 *
 * This class must be extended and files must be in /Site/Options directory.
 */
abstract class OptionsPage implements Registrable {
	/**
	 * ACF acf_add_options_page args
	 *
	 * @see https://www.advancedcustomfields.com/resources/acf_add_options_page/#parameters
	 *
	 * @var array
	 */
	protected $args = [];

	/**
	 * Register new ACF options page.
	 *
	 * @see https://www.advancedcustomfields.com/resources/acf_add_options_page/
	 *
	 * @return void
	 */
	public function register(): void {
		acf_add_options_page($this->args);
	}

	/**
	 * Helper function to return conditional arguments based on options page.
	 *
	 * @param string $options_page - string containing the options_page.
	 * @return array conditional array
	 */
	public static function is_equal_to(string $options_page): array {
		return [
			'param' => 'options_page',
			'operator' => '==',
			'value' => $options_page,
		];
	}
}
