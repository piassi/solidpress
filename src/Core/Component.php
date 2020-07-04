<?php

namespace SolidPress\Core;

use SolidPress\Interfaces\Renderable;

abstract class Component implements Renderable {
	public $template;
	public $props = [];

	public function __construct($props = []) {
		$this->props = array_merge($this->get_props(), $props);
	}

	public function __toString(): string {
		try {
			global $theme_class;
			return $theme_class->template_engine->render_object($this);
		} catch (\Throwable $e) {
			return $e->getMessage();
		}
	}

	public function get_props(): array {
		return [];
	}
}
