<?php

/**
 * Plugin Name:       SM - Cari Gambo
 * Plugin URI:        https://gambo.sulaimanmisri.com
 * Description:       This plugin will allow you to Download any Unsplash images direct to your WordPress site.
 * Version:           1.0
 * Author:            Sulaiman Misri
 * Author URI:        https://github.com/msulaimanmisri
 * Text Domain:       sm-cari-gambo
 * Domain Path:       /languages
 * Tags:              images, optimize
 * Tested up to:      6.2.2
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * This plugin use the Unsplash API.
 * Therefore, the user must have the Access Key in order to make it work.
 * @see https://unsplash.com/developers
 */
require 'Controller/installController.php';
