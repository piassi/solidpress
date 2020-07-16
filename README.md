# SolidPress

A library that uses the best OOP practices to provide a solid project structure for component-based WordPress themes.

## Installation

SolidPress is a [Composer](https://getcomposer.org/) and it's avaliable through [Packagist](https://packagist.org/packages/piassi/solidpress)

## Setup

Require solid as a project dependency

```
composer require piassi/solidpress
```

In "composer.json", setup a folder inside your theme as the root namespace

```json
	{
	...
	"autoload": {
		"psr-4": {
		"App\\": "src/"
		}
	}
}
```

Init Solidpress in your functions.php

```php
use SolidPress\Core\Theme;
use SolidPress\Core\WPTemplate;

// Composer autoload
require get_template_directory() . '/vendor/autoload.php';

$registrable_namespaces = [];

// Check if ACF plugin is active to register fields
if (function_exists('acf_add_local_field_group')) {
	$registrable_namespaces[] = 'FieldsGroups';
	$registrable_namespaces[] = 'Options';
}

// Set core registrables
$registrable_namespaces = array_merge($registrable_namespaces, [
	'Taxonomies',
	'PostTypes',
	'Hooks',
]);

// Setup a theme instance for SolidPress
global $theme_class;
$theme_class = new Theme([
	'template_engine' => new WPTemplate(),
	'namespace' => 'App',
	'base_folder' => 'src',
	'registrable_namespaces' => $registrable_namespaces,
	'theme_name' => 'solidpress-theme',
	'css_dist_path' => get_template_directory_uri() . '/dist/%s.css', // %s will be replaced with page bundle css file.
	'js_dist_path' => get_template_directory_uri() . '/dist/%s.js', // %s will be replaced with page bundle js file.
]);
```

You can check [this theme](https://github.com/piassi/solidpress-theme) as a reference.
