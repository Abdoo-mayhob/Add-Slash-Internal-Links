<?php
/**
 *
 * Plugin Name: Add Slashes at the End of Internal Links
 * Plugin URI: https://github.com/Abdoo-mayhob/Estimated-Reading-Time
 * Description: This plugin will add the missing / at the end of links inside your content. No more redirects !
 * Version: 1.0.0
 * Author: Abdoo
 * Author URI: https://abdoo.me
 * License: GPL2
 * Text Domain: add-slash-internal-links
 * Domain Path: /languages
 *
 * ===================================================================
 * 
 * Copyright 2024  Abdullatif Al-Mayhob, Abdoo abdoo.mayhob@gmail.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 3, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * ===================================================================
 * 
 * TODO:
 * - Add Customization filters and hooks
 */

// If this file is called directly, abort.
defined('ABSPATH') or die;

// Load Translation Files, Only needed in admin area.
add_action('admin_init', function() {
    load_plugin_textdomain('add-slash-internal-links', false, dirname(plugin_basename(__FILE__)) . '/languages');
});


add_action('init', function(){
    AddSlashInternalLinks::I();
});


/**
 * Main Class.
 */
class AddSlashInternalLinks {

    public const SETTINGS_NAME = 'read_eta';

    // Plugin Settings and Default Values (Used when options not set yet)
    public $settings = [];
    public const SETTINGS_DEFAULT = [
    ];

    // Refers to a single instance of this class
	private static $instance = null;

    /**
	 * Creates or returns a single instance of this class
	 *
	 * @return AddSlashInternalLinks a single instance of this class.
	 */
    public static function I() {
        self::$instance = self::$instance ?? new self();
        return self::$instance;
    }

    public function __construct() {
        add_action('admin_menu', [$this, 'admin_menu']);

        // Load Plugin Settings 
        $this->settings = get_option(self::SETTINGS_NAME, self::SETTINGS_DEFAULT);
    }

    // --------------------------------------------------------------------------------------
    // Admin Menu
    public function admin_menu() {
        add_options_page(
            __('Add Slash to Internal Links Settings', 'est-read-time'), 
            __('Add Slash to Internal Links', 'est-read-time'),
            'manage_options', 'est-read-time', [$this, 'view_admin']);
    }

    public function view_admin($post) {
        require_once __DIR__ . '/admin.php';
    }

}