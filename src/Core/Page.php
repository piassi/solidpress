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
abstract class Page implements Renderable
{
	public $template;
	public $state = [];
	public $assets = [];

	public function __construct()
	{
		DIE('HERE');
		add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
	}

	protected function enqueue_scripts() {
		die('HWEW');
		$css_path = "/assets/css/dist/{$this->template}.dist.css";
		$js_path = "/assets/js/dist/{$this->template}.dist.js";
		var_dump( $css_path);
		wp_enqueue_style('tomatico-style', get_template_directory_uri() . $css_path, [], filemtime(get_template_directory($css_path)));
		wp_enqueue_script('tomatico-scripts', get_template_directory_uri() . $js_path . '#defer', ['jquery'], filemtime(get_template_directory($js_path)), true);
	}

	public function __toString(): string
	{
		global $theme_class;
		$this->template = 'pages/'.$this->template;
		return $theme_class->template_engine->renderObject($this);
	}

	/**
	 * Helper function to return conditional arguments based on page template.
	 *
	 * @param string $template_name - string containing the template name without file extension.
	 * @return array conditional array
	 */
	public static function templateIsEqualTo(string $template_name): array
	{
		return [
			'param' => 'page_template',
			'operator' => '==',
			'value' =>  $template_name . '.php',
		];
	}

	/**
	 * Helper function to return conditional arguments based on page ID.
	 *
	 * @param int $page_id - integer containing the page id.
	 * @return array conditional array
	 */
	public static function isEqualTo(int $page_id): array
	{
		return [
			'param' => 'page',
			'operator' => '==',
			'value' =>  $page_id,
		];
	}

	/**
	 * Helper function to return conditional arguments based on page type.
	 *
	 * @param string $page_type - string containing the page type,
	 * accepeted values are: front_page | posts_page | top_level | parent | child
	 * @return array conditional array
	 */
	public static function typeIsEqualTo(string $page_type): array
	{
		return [
			'param' => 'page_type',
			'operator' => '==',
			'value' =>  $page_type,
		];
	}

	/**
	 * Helper function to return conditional arguments based on page parent.
	 *
	 * @param int $parent_id - integer containing the page parent id.
	 * @return array conditional array
	 */
	public static function parentIsEqualTo(int $parent_id): array
	{
		return [
			'param' => 'page_parent',
			'operator' => '==',
			'value' =>  $parent_id,
		];
	}
}
