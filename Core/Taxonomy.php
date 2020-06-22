<?php

namespace SolidPress\Core;

use SolidPress\Interfaces\Registrable;

/**
 * Creates a new interface to wordpress taxonomies.
 */
abstract class Taxonomy implements Registrable
{
	/**
	 * Taxonomy key, must not exceed 32 characters.
	 *
	 * @var string
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_taxonomy/#parameters
	 */
	public $taxonomy;

	/**
	 * Object type or array of object types with which the taxonomy should be associated.
	 *
	 * @var array|string
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_taxonomy/#parameters
	 */
	public $post_types = [];

	/**
	 * Array or query string of arguments for registering a taxonomy.
	 *
	 * @var array
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_taxonomy/#parameters
	 */
	public $args = [];

	/**
	 * Register new wordpress taxonomy.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_taxonomy/
	 *
	 * @return void
	 */
	public function register(): void
	{
		if (!$this->taxonomy) {
			throw new \Error("Property 'taxonomy' is not defined.");
		}

		if (!$this->post_types) {
			throw new \Error("Property 'post_types' is not defined.");
		}

		if (!$this->args) {
			throw new \Error("Property 'args' is not defined.");
		}

		register_taxonomy($this->taxonomy, $this->post_types, $this->args);
	}

	/**
	 * Helper function to return conditional arguments based on taxonomy.
	 *
	 * @param string $taxonomy - string containing the taxonomy.
	 * @return array conditional array
	 */
	public static function isEqualTo(string $taxonomy): array
	{
		return [
			'param' => 'taxonomy',
			'operator' => '==',
			'value' => $taxonomy,
		];
	}
}
