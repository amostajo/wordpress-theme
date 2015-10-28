# WORDPRESS THEME TEMPLATE
--------------------------------

[![Latest Stable Version](https://poser.pugx.org/amostajo/wordpress-theme/v/stable)](https://packagist.org/packages/amostajo/wordpress-theme)
[![Total Downloads](https://poser.pugx.org/amostajo/wordpress-theme/downloads)](https://packagist.org/packages/amostajo/wordpress-theme)
[![License](https://poser.pugx.org/amostajo/wordpress-theme/license)](https://packagist.org/packages/amostajo/wordpress-theme)

The power of **Composer** and **MVC** in your **Wordpress** themes.

**Wordpress THEME** (WPT) is a development template that can be used to create modern and elegant themes. WPT comes with [Composer](https://getcomposer.org/) and [Lightweight MVC](https://github.com/amostajo/lightweight-mvc) framework.

**NOTE:** Need to create a plugin? Use [Wordpress PLUGIN template](https://github.com/amostajo/wordpress-plugin) instead.

The following video tutorial from **Wordpress PLUGIN** can be applied to this theme too:
[![Video tutorial header](http://s10.postimg.org/njeae0ogp/Videotutorialheader.jpg)](http://youtu.be/fXPNMH8vaMI)

- [Requirements](#requirements)
- [Installation](#installation)
- [Updating](#updating)
- [Usage](#usage)
    - [Main Class](#main-class)
        - [Hooks and Filters](#hooks-and-filters)
    - [MVC](#mvc)
    - [Templating](#templating)
        - [Functions](#functions)
        - [Full MVC](#full-mvc)
    - [Config](#config)
- [Coding Guidelines](#coding-guidelines)
- [License](#license)

## Requirements

* PHP >= 5.4.0

## Installation

WPT utilizes [Composer](https://getcomposer.org/) to manage its dependencies. So, before using WPT, make sure you have Composer installed on your machine.

### Step 1

Download the [latest release](https://github.com/amostajo/wordpress-theme/releases) of the software;

### Step 2

Create the folder location where your theme will reside, usually inside the themes folder of your wordpress installation:

```bash
[WORDPRESS ROOT]
 |---> [wp-content]
        |---> [themes]
               |---> "your-theme-name"
```

### Step 3

Copy the content of the release version downloaded into your theme's folder, should look like this:

```bash
[WORDPRESS ROOT]
 |---> [wp-content]
        |---> [themes]
               |---> "your-plugin-name"
               		 |---> [boot]
               		 |---> [config]
               		 |---> [controllers]
               		 |---> [css]
               		 |---> [js]
               		 |---> [theme]
               		 |---> [views]
               		 |---> ayuco
               		 |---> composer.json
               		 |---> LICENSE
               		 |---> functions.php
               		 |---> index.php
               		 |---> README
               		 |---> style.css
```

### Step 4

Open your `Command Prompt` application and change directory to point to your theme's folder, where `composer.json` resides.

Type the following command:

```bash
composer install
```

This will install all the software dependencies of WPT.

### Step 5

In order to prevent conflicts with other themes using this template, it is suggested to set a name and change its namespace.

To do this, type the following in the commando prompt:

```bash
php ayuco setname MyNewName
```

Finally open `style.css` and modify the information located in the first comment section:

```php
/*
Theme Name: [MY THEME]

Theme URI: [MY URL]

Author: [MY NAME OR COMPANY NAME]

Author URI: [MY URL]

Description: [THEME DESCRIPTION]

Version: 1.0

License: [LICENSE]

License URI: [LICENSE URL]

Tags: [TAGS SEPARATED BY COMMAS i.e. bootstrap, red, responsive]

Text Domain: [THEME DOMAIN]

Add additional description here...
*/
```

**INSTALLATION COMPLETED!**

## Updating

To update the current version of the software, in the command prompt type:

```bash
composer update
```

## Usage

Anything you code file that needs to be created must be located inside the `theme` folder.

### Main Class

WPT comes with a master class called `Main.php` and which is located in the `theme` folder.

This class is the **bridge** between Wordpress and WPT. Any Hook or filter should be declared inside this class.

#### Hooks and Filters

`Main.php` has two methods:

```php
class Main extends Theme
{
	/**
	 * Constructor.
	 * Declares HOOKS and FILTERS.
	 */
	public function init()
	{
		// Call public Wordpress HOOKS and FILTERS here
		// --------------------------------------------
		// i.e.
		// add_action( 'save_post', array( &$this, 'save_post' ) );
	}

	/**
	 * Declares HOOKS and FILTERS when on admin dashboard.
	 */
	public function on_admin()
	{
		// Call public Wordpress HOOKS and FILTERS here
		// --------------------------------------------
		// i.e.
		// add_action( 'admin_init', array( &$this, 'admin_init' ) );
	}
}
```

`init()` is where all public declarations. `on_admin()` will be called only when wordpress is on admin dashboard.

In this following example a hook to modify a post content will be added to the main class.

```php
class Main extends Theme
{
	public function init()
	{
		add_filter( 'the_content', array( &$this, 'filter_content' ) );
	}

	public function on_admin()
	{
	}

	public function filter_content( $content )
	{
		// YOUR CODE HERE
		return $content;
	}
}
```

Notice how the `add_filter` is registering a call to the method `filter_content` within `Main.php`.

You can do the same with admin hooks and filters, like displaying a custom metabox in a post admin form:

```php
class Main extends Theme
{
	public function init()
	{
	}

	public function on_admin()
	{
		add_action( 'add_meta_boxes', array( &$this, 'metaboxes' ) );
	}

	public function metaboxes( $post_type, $post )
	{
		// YOUR METABOX DECALARATION HERE
	}
}
```

Your `Main.php` can be accessed by plugins or by your templates by calling the `$theme` variable.

Other naming examples:

```php
$theme->my_function();
```

### MVC

**Lightweight MVC** is a powerfull and small MVC framework that comes with WPT.

To read more about the usar of *Models*, *Views* and *Controllers* we recommed to visit the packages main page:

[Lightweight MVC](https://github.com/amostajo/lightweight-mvc)

#### Main class and MVC

**Lightweight MVC** engine is already integrated with `Main.php`, call the engine with `$this->mvc`.

In the following example, `Main.php` is calling `PostController` to save a post modification:

```php
class Main extends Theme
{
	public function init()
	{
	}

	public function on_admin()
	{
		add_action( 'save_post', array( &$this, 'save_post' ) );
	}

	public function save_post( $post_id )
	{
		$this->mvc->call( 'PostController@save', $post_id );
	}
}
```

Here is where the MVC files are located within your theme:

```bash
[THEME ROOT]
 |---> [controllers]
 |---> [theme]
        |---> [models]
 |---> [views]
```

### Templating

You can do templates like you would normally do, the only differency is that new you have the power of **MVC** to take advantage of.

#### Functions

Using function `theme_view` will let you display views inside your templates.

In the following example, a normal WP template displays `banner.example` view with a parameter called `limit` and with a value of `4`.

```php
<?php get_header() ?>

<?php theme_view( 'banner.example', array( 'limit' => 4 ) ) ?>

<?php get_footer() ?>
```

Sometimes you might want to add extra logic by calling the results of a controller. You can do this by calling your `Main.php` class variable (`$theme`).

```php
<?php get_header() ?>

<?php $theme->controller_results() ?>

<?php get_footer() ?>
```

Your `Main.php` could look like:

```php
class Main extends Theme
{
	public function controller_results()
	{
		$this->mvc->call( 'PostController@search_results' );
	}
}
```

#### Full MVC

You can also use MVC to generate all your templates. Simply call the required function in the template.

```php
/**
 * This is the whole template content for index.php
 */
$theme->generate_index();
```

Your `Main.php` could look like:

```php
class Main extends Theme
{
	public function generate_index()
	{
		$this->mvc->call( 'IndexController@generate' );
	}
}
```

### Config

You can add your own config variables into `config\theme.php` and access them within `Main.php`, like:

```php
class Main extends Theme
{
	public function controller_results()
	{
		$this->mvc->call( 'PostController@search_results' );
	}
}

```php
	// In config\theme.php

	'myapi' => array(
		'key' => 'jdsldjsfl12938nfk',
	),

	'url' => 'http://api.com',
```

```php
class Main extends Theme
{
	public function connect_api()
	{
		$key = $this->config->get('myapi.key');

		$url = $this->config->get('url');

		// MY CODE
	}
}
```

### Add-ons

WPP now supports **Addons** or external **Packages** developed using WP code.

Add your add-ons at the config file, like:

```php
	// In config\theme.php

	'addons' => [
        'SpecialAddonNamespace\AddonClass',
        'PackageAddon\AddonClass',
    ],
```

For more information about add-on development, click [here](https://github.com/amostajo/wordpress-plugin-core).

## Change Log

For version upgrades and change log, click [here](https://github.com/amostajo/wordpress-theme/releases).

## Coding Guidelines

The coding is a mix between PSR-2 and Wordpress PHP guidelines.

## License

**Wordpress Theme** is free software distributed under the terms of the MIT license.
