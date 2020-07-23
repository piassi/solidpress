<?php

namespace SolidPress\Core;

use SolidPress\Core\TemplateEngine;
use SolidPress\Interfaces\Renderable;

/**
 * Template engine that uses native wordpress functions
 * to render SolidPress Renderable Objects.
 */
class WPTemplate extends TemplateEngine
{
	/**
	 * Search for template file full path
	 *
	 * @param string $template - template relative to theme root path
	 * @return string template full path
	 */
	public function get_template_path(string $template): string
	{
		return locate_template(
			$template . '.php',
			false,
			false
		);
	}

	/**
	 * Render template file
	 *
	 * @param string $template - template relative to theme root path
	 * @param array $props - template props
	 * @return void
	 */
	public function render(string $template, array $props = []): void
	{
		if ($props && is_array($props)) {
			extract($props);
		}

		$template_file = $this->get_template_path($template);

		if (!$template_file) {
			throw new \Error("Template '{$template}' not found!");
		}

		include $template_file;
	}

	/**
	 * Rende template to string
	 *
	 * @param string $template - template relative to theme root path
	 * @param array $props - template props
	 * @return string
	 */
	public function render_to_string(
		string $template,
		array $params = []
	): string {
		ob_start();
		$this->render($template, $params);
		return ob_get_clean();
	}

	/**
	 * Render SolidPress renderable object
	 *
	 * @param Renderable $renderable - Object that implements Renderable interface
	 * @return string - Parsed template with props
	 */
	public function render_object(Renderable $renderable): string
	{
		ob_start();
		$this->render($renderable->template, $renderable->props);
		return ob_get_clean();
	}
}