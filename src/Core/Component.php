<?php

namespace SolidPress\Core;

use SolidPress\Interfaces\Renderable;

abstract class Component implements Renderable
{
	public $template;
	public $state = [];
	public $assets = [];

	public function __construct($args = [])
	{
		$this->state = array_merge($this->state, $args);
	}

	public function __toString(): string
	{
		global $theme_class;
		return $theme_class->template_engine->renderObject($this);
	}
}
