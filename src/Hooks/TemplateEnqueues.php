<?php

namespace SolidPress\Hooks;

class TemplateEnqueues {
	public function __construct() {
		add_action('wp_enqueue_scripts', [$this, 'enqueue_template_scripts']);
	}

	public function enqueue_template_scripts(): void {
		$template_name = $this->get_template_name();

		if (!$template_name) {
			return;
		}

		global $theme_class;

		// Theme scripts & styles
		$css_path = sprintf($theme_class->css_dist_path, $template_name);
		$js_path = sprintf($theme_class->js_dist_path, $template_name);

		wp_enqueue_style(
			"{$theme_class->theme_name}-style",
			$css_path,
			[],
			filemtime(get_template_directory($css_path))
		);
		wp_enqueue_script(
			"{$theme_class->theme_name}-scripts",
			$js_path . '#defer',
			['jquery'],
			filemtime(get_template_directory($js_path)),
			true
		);
	}

	public static function get_template_name(): string {
		if (is_front_page() || is_home()) {
			// Home
			$template_name = 'home';
		} elseif (is_single()) {
			// Article
			$template_name = 'article';
		} elseif (is_category()) {
			// Category
			$template_name = 'category';
		} elseif (is_tax('tag')) {
			// Tags
			$template_name = 'tag';
		} elseif (is_page()) {
			$template_name = 'page';

			// Set $template_name for custom templates.
			if (is_page_template()) {
				$template_name = str_replace(
					['template-', '.php'],
					['', ''],
					get_page_template_slug()
				);
			}
		} elseif (is_search()) {
			// Search
			$template_name = 'search';
		} elseif (is_404()) {
			// 404
			$template_name = '404';
		}

		// Return template name, providing filter hook to add or modify rules
		return apply_filters('solidpress_template_name', $template_name);
	}
}
