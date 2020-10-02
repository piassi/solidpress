<?php

namespace SolidPress\Core;

use Error;

class Theme {
	/**
	 * TempalteEngine instance
	 *
	 * @var TemplateEngine
	 */
	public $template_engine;

	/**
	 * Theme namespace
	 *
	 * @var string
	 */
	public $namespace;

	/**
	 * Theme base_folder
	 *
	 * @var string
	 */
	public $base_folder;

	/**
	 * Array of namespaces
	 *
	 * @var array
	 */
	public $registrable_namespaces;

	/**
	 * Theme instance
	 *
	 * @var Theme
	 */
	protected static Theme $instance;

	/**
	 * Template engine
	 *
	 * @param array $args [
	 *  'template_engine'           => @param TemplateEngine
	 *  'namespace'                 => @param string
	 *  'base_folder'               => @param string
	 *  'registrable_namespaces'    => @param string
	 * ]
	 */

	public function __construct( array $args ) {
		if (
			! $args['template_engine'] ||
			! ( $args['template_engine'] instanceof TemplateEngine )
		) {
			throw new Error( 'Template engine not provided' );
		}

		$this->template_engine        = $args['template_engine'];
		$this->namespace              = $args['namespace'];
		$this->base_folder            = $args['base_folder'];
		$this->registrable_namespaces = $args['registrable_namespaces'];

		$this->load_registrable_classes();

		self::$instance = $this;
	}

	/**
	 * Get Theme singleton instance
	 *
	 * @return Theme
	 */
	public static function get_instance(): Theme {
		return self::$instance;
	}

	/**
	 * Search in folders for classes that implements Registrable interface,
	 * creates a new instance of those classes and calls the register method.
	 *
	 * @return void
	 */
	protected function load_registrable_classes(): void {
		foreach ( $this->registrable_namespaces as $namespace ) {
			$namespace_dir = implode(
				DIRECTORY_SEPARATOR,
				array(
					get_template_directory(),
					$this->base_folder,
					$namespace,
				)
			);

			foreach ( scandir( $namespace_dir, 1 ) as $file ) {
				if ( strpos( $file, '.php' ) === false ) {
					continue;
				}

				$class_name_array = explode( '.php', $file );
				$class_name       = array_shift( $class_name_array );
				$class_namespaced =
					$this->namespace . '\\' . $namespace . '\\' . $class_name;
				$class_instance   = new $class_namespaced();
				$class_instance->register();
			}
		}
	}
}