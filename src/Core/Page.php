<?php

namespace SolidPress\Core;

use SolidPress\Interfaces\Renderable;

/**
 *
 * Creates a new page.
 *
 * This class must be extended and files must be in /src/Pages directory.
 *
 * In order to render the page you must echo an instance of this class.
 *
 * Example:
 * echo new Site\Pages\SamplePage();
 *
 */
abstract class Page implements Renderable {
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

	/**
	 * Helper function to return conditional arguments based on page template.
	 *
	 * @param string $template_name - string containing the template name without file extension.
	 * @return array conditional array
	 */
	public static function template_is_equal_to(string $template_name): array {
		return [
			'param' => 'page_template',
			'operator' => '==',
			'value' => $template_name . '.php',
		];
	}

	/**
	 * Helper function to return conditional arguments based on page ID.
	 *
	 * @param int $page_id - integer containing the page id.
	 * @return array conditional array
	 */
	public static function is_equal_to(int $page_id): array {
		return [
			'param' => 'page',
			'operator' => '==',
			'value' => $page_id,
		];
	}

	/**
	 * Helper function to return conditional arguments based on page type.
	 *
	 * @param string $page_type - string containing the page type,
	 * accepeted values are: front_page | posts_page | top_level | parent | child
	 * @return array conditional array
	 */
	public static function type_is_equal_to(string $page_type): array {
		return [
			'param' => 'page_type',
			'operator' => '==',
			'value' => $page_type,
		];
	}

	/**
	 * Helper function to return conditional arguments based on page parent.
	 *
	 * @param int $parent_id - integer containing the page parent id.
	 * @return array conditional array
	 */
	public static function parent_is_equal_to(int $parent_id): array {
		return [
			'param' => 'page_parent',
			'operator' => '==',
			'value' => $parent_id,
		];
	}
}
