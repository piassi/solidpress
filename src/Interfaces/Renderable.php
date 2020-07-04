<?php

namespace SolidPress\Interfaces;

interface Renderable {
	public function __toString(): string;
	public function get_props(): array;
}
