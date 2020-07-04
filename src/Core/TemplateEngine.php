<?php

namespace SolidPress\Core;

use SolidPress\Interfaces\Renderable;

abstract class TemplateEngine {
	public $engine;

	abstract public function render(string $template, array $params): void;
	abstract public function render_to_string(
		string $template,
		array $params
	): string;
	abstract public function render_object(Renderable $template): string;
}
