<?php

namespace SolidPress\Core;

use SolidPress\Core\TemplateEngine;
use SolidPress\Interfaces\Renderable;

class WPTemplate extends TemplateEngine {
	public function get_template_path(string $template): string {
		return $template . '.php';
	}

	public function render(string $template, array $params = []): void {
		if ($params && is_array($params)) {
			extract($params);
		}

		$template_file = locate_template(
			$this->get_template_path($template),
			false,
			false
		);

		if (!$template_file) {
			throw new \Error("Template '{$template}' not found!");
		}

		include $template_file;
	}

	public function render_to_string(
		string $template,
		array $params = []
	): string {
		ob_start();
		$this->render($template, $params);
		return ob_get_clean();
	}

	public function render_object(Renderable $renderable): string {
		ob_start();
		$this->render($renderable->template, $renderable->props);
		return ob_get_clean();
	}
}
