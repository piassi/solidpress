<?php

namespace SolidPress\Core;

use SolidPress\Interfaces\Renderable;

abstract class Component implements Renderable {

	public $template;
	public $props = array();

	public function __construct( $props = array() ) {
		$this->props = array_merge( $this->props, $props );

		$dynamic_props = $this->get_props();
		if ( $dynamic_props ) {
			$this->props = array_merge( $this->props, $dynamic_props );
		}
	}

	public function __toString(): string {
		try {
			ob_start();
			if ( $this->template ) {
				return Theme::get_instance()->template_engine->render_object( $this );
			}

			$this->template( array_merge( $this->props, $this->get_props() ) );
			return ob_get_clean();
		} catch (\Throwable $e) {
			return $e->getMessage();
		}
	}

	public function template( array $props ): void {
		throw new \Exception( 'Template method not defined' );
	}

	public function get_props(): array {
		return array();
	}
}
