<?php

namespace SolidPress\Core;

use SolidPress\Interfaces\Registrable;

abstract class Hook implements Registrable {
	public function register(): void {}

	public function add_action(
		string $tag,
		string $function_to_add,
		int $priority = 10,
		int $accepted_args = 1
	): void
	{
		add_action($tag, [$this, $function_to_add], $priority, $accepted_args);
	}

	public function add_filter(
		string $tag,
		string $function_to_add,
		int $priority = 10,
		int $accepted_args = 1
	): void
	{
		add_filter($tag, [$this, $function_to_add], $priority, $accepted_args);
	}
}
