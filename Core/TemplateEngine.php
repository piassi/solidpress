<?php

namespace SolidPress\Core;

use SolidPress\Interfaces\Renderable;

abstract class TemplateEngine
{
	public $engine;

	abstract public function render(string $template, array $params): void;
	abstract public function renderToString(string $template, array $params): string;
	abstract public function renderObject(Renderable $template): string;
}
