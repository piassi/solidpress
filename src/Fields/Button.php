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

	public function __construct($args) {
		parent::__construct($args);

		$this->args['sub_fields'] = [
			'label' => new Text('Label'),
			'url' => new URL('URL'),
			'new_window' => new Boolean('Open in new window?'),
			'scroll' => new Boolean('Scroll'),
		];
	}
}
