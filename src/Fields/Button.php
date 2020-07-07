<?php

namespace SolidPress\Fields;

use SolidPress\Core\Field;

/**
 * Button custom field type
 *
 * A custom field type used for set up of link buttons
 */
class Button extends Field {
	public $defaults = [
		'type' => 'group',
		'layout' => 'table',
	];

	public function __construct($label, $args = []) {
		parent::__construct($label, $args);

		$this->args['sub_fields'] = [
			'content' => new Text('Conteúdo'),
			'url' => new URL('URL'),
			'new_window' => new Boolean('Open in new window?'),
		];
	}
}