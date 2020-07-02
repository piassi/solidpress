<?php

namespace SolidPress\Core;

class Theme
{
	/**
	 * Template engine
	 *
	 * @var TemplateEngine
	 */
	public $template_engine;

	public function __construct(TemplateEngine $template_engine)
	{
		$this->template_engine = $template_engine;
		$this->load_registrable_classes();
		new TemplateEnqueues();
	}

	/**
	 * Create new theme with WPTemplate template engine.
	 *
	 * @return Theme
	 */
	public static function create_wp_theme(): Theme
	{
		return new Theme(
			new WPTemplate()
		);
	}

	/**
	 * Search in folders for classes that implements Registrable interface,
	 * creates a new instance of those classes and calls the register method.
	 *
	 * @return void
	 */
	protected function load_registrable_classes(): void
	{
		$namespaces = [
			'FieldsGroups',
			'Options',
			'Taxonomies',
			'PostTypes',
			'Hooks',
		];

		foreach ($namespaces as $namespace) {
			$namespace_dir = get_template_directory() . '/logic//' . $namespace;

			foreach (scandir($namespace_dir, 1) as $file) {
				if (strpos($file, '.php') === false) {
					continue;
				}

				$class_name_array = explode('.php', $file);
				$class_name = array_shift($class_name_array);
				$class_namespaced = 'Site\\' . $namespace . '\\' . $class_name;
				$class_instance = new $class_namespaced();
				$class_instance->register();
			}
		}
	}
}
