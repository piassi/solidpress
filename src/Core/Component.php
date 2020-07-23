<?php

namespace SolidPress\Core;

use SolidPress\Interfaces\Renderable;

abstract class Component implements Renderable
{
	public $template;
	public $props = array();

	public function __construct($props = array())
	{
		$this->props = array_merge($this->props, $props);

		$dynamic_props = $this->get_props();
		if ($dynamic_props) {
			$this->props = array_merge($this->props, $dynamic_props);
		}
	}

	public function __toString(): string
	{
		try {
			global $theme_class;
			return $theme_class->template_engine->render_object($this);
		} catch (\Throwable $e) {
			return $e->getMessage();
		}
	}

	public function get_props(): array
	{
		return array();
	}
}