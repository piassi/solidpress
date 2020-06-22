<?php

namespace SolidPress\Core;

use SolidPress\Interfaces\Registrable;

/**
 * Creates a new interface to wordpress custom post types.
 */
abstract class PostType implements Registrable
{
	/**
	 * Post type key. Must not exceed 20 characters and may only contain
	 * lowercase alphanumeric characters, dashes, and underscores.
	 *
	 * @var string
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_post_type/#parameters
	 */
	public $post_type;

	/**
	 * Array or string of arguments for registering a post type.
	 *
	 * @var array
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_post_type/#parameters
	 */
	public $args;

	/**
	 * Register new wordpress post type.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_post_type/
	 *
	 * @return void
	 */
	public function register(): void
	{
		if (!$this->post_type) {
			throw new \Error("Property 'post_type' is not defined.");
		}

		if (!$this->args) {
			throw new \Error("Property 'args' is not defined.");
		}

		register_post_type($this->post_type, $this->args);
	}

	/**
	 * Helper function to return conditional arguments based on post type.
	 *
	 * @param string $post_type - string containing the post type.
	 * @return array conditional array
	 */
	public static function isEqualTo(string $post_type): array
	{
		return [
			'param' => 'post_type',
			'operator' => '==',
			'value' => $post_type,
		];
	}
}
