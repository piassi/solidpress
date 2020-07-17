# SolidPress

A library that uses the best OOP practices to provide a solid project structure for component-based WordPress themes.

-   [Installation](#installation)
-   [Setup](#setup)
-   [Handbook](#handbook)
    -   [Registering a new post type](#registering-a-new-post-type)
    -   [Creating a new custom fields group](#creating-a-new-custom-fields-group)

## Installation

SolidPress is a [Composer](https://getcomposer.org/) and it's avaliable through [Packagist](https://packagist.org/packages/piassi/solidpress)

```
composer require piassi/solidpress
```

## Setup

In "composer.json", setup a folder inside your theme as the root namespace

```json
{
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
	$registrable_namespaces[] = 'FieldsGroup';
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

> You can check [this theme](https://github.com/piassi/solidpress-theme) as a reference.

## Handbook

### Registrables

The _PostType_, _Taxonomy_, and _FieldGroup_ classes extend the Registrable interface, those classes must have a constructor method that will be automatically called at site startup.

### Registering a new post type

In order to register a new post type you must create a new class inside the _PostTypes_ namespace, and set _post_type_ and _args_ properties inside the constructor method, those properties will be forwarded to _register_post_type_ function.

> See _register_post_type_ [docs](https://developer.wordpress.org/reference/functions/register_post_type/) to see more details about the _args_ property.

**Example**

Registering a new post type called "Products"

```php
// Filepath: src/PostTypes/Prodcuts.php

namespace App\PostTypes;

use SolidPress\Core\PostType;

class Products extends PostType{
	public function __construct()
	{
		$this->post_type = "products";

		$labels = [
			"name" => "Prodcuts",
			"singular_name" => "Product",
			"menu_name" => "Products",
			"all_items" => "All Products",
			"add_new" => "Add new",
			"add_new_item" => "Add new product",
			"edit_item" => "Edit product",
			"new_item" => "New product",
			"view_item" => "View proct",
			"insert_into_item" => "Insert in product",
			"view_items" => "View products",
			"search_items" => "Search for products",
			"not_found" => "No products found",
			"not_found_in_trash" => "No products found in trash"
		];

		$this->args = [
			"label"               => "Products",
			"labels"              => $labels,
			"description"         => "",
			"public"              => true,
			"publicly_queryable"  => false,
			"show_ui"             => true,
			"show_in_rest"        => false,
			"rest_base"           => "",
			"has_archive"         => false,
			"show_in_menu"        => true,
			"exclude_from_search" => true,
			"capability_type"     => "post",
			"map_meta_cap"        => true,
			"hierarchical"        => false,
			"menu_position"       => 8,
			'rewrite'             => array("slug" => $this->post_type, "with_front" => false),
			'query_var'           => false,
			"supports"            => array("title", "editor", "revisions", "excerpt"),
			"menu_icon"           => 'dashicons-book-alt',
			"taxonomies"          => []
		];
	}
}

```
