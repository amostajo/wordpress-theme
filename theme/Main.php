<?php

namespace Theme;

use Amostajo\WPPluginCore\Plugin as Theme;

/**
 * Configuration class.
 * Registers HOOKS and FILTERS used within the theme.
 * Acts like a bridge or router of actions between Wordpress and the theme.
 */
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