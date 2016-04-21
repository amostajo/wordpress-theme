<?php

use Amostajo\WPPluginCore\Config;

/**
 * This file will load configuration file and init Main class.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\WPDevTemplates
 * @version 1.0.2
 */

/**
 * Moved from functions.php
 * @since 1.0.2
 */
require_once( plugin_dir_path( __FILE__ ) . '/../vendor/autoload.php' );

// --

$config = include( __DIR__ . '/../config/theme.php' );

$theme_namespace = $config['namespace'];

$theme_class = $theme_namespace . '\Main';

$theme_reflection = new ReflectionClass( get_parent_class( $theme_class ) );

/**
 * Core version check.
 * @since 1.0.2
 */
if ( $theme_reflection->hasMethod( 'add_hooks' ) ) {

	$theme = new $theme_class( new Amostajo\WPPluginCore\Config( $config ) );

    /**
     * Autoload init to support addons.
     * @since 1.0.1
     */
	$theme->autoload_init();

	//--- ON ADMIN
	if ( is_admin() ) {
        /**
         * Autoload on admin to support addons.
         * @since 1.0.1
         */
		$theme->autoload_on_admin();
	}

    /**
     * WPPluginCore hooks support.
     * @since 1.0.2
     */
    $theme->add_hooks();

} else {
    $plugin_error = $theme_reflection;
    add_action( 'admin_notices', 'wdt_hooks_error' );
}

/**
 * Version notice.
 * @since 1.0.2
 */
if ( ! function_exists( 'wdt_hooks_error' )  ) { 
    /**
     * Displayes wordpress admin notice for missing hooks function.
     * @since 1.0.2
     */
    function wdt_hooks_error()
    {
        global $plugin_error;
        ?>
        <div class="notice notice-error">
            <?php printf(
                'One or more plugins/themes using %s is not updated to the latest version, this will affect those who are update.<br/><strong>%s</strong> can not be used.<br/>File that needs update <strong>%s</strong>.</br>Please notify the developer of this package.',
                '<a href="http://wordpress-dev.evopiru.com/">WP Dev Templates</a>',
                'add_hooks()',
                $plugin_error->getFileName()
            ) ?>
        </div>
        <?php
        unset($plugin_error);
    }
}

/**
 * Add theme_view function
 * @since 1.0.1
 */
if ( ! function_exists( 'theme_view' ) ) {
	/**
	 * Displays view with the parameters passed by.
	 * @since 1.0.1
	 *
	 * @param string $view   Name and location of the view within "theme/views" path.
	 * @param array  $params View parameters passed by.
	 */
	function theme_view ( $view, $params = array() )
	{
		global $theme;

		$theme->view( $view, $params );
	}
}

// Unset
unset($theme_reflection);
unset($config);
unset($theme_namespace);
unset($theme_class);
