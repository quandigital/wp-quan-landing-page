<?php

namespace QuanDigital\LandingPage;

/**
 * Plugin Name: Quan Landing Page
 * Plugin URI: http://www.quandigital.com/
 * Description: Adds a custom post types for landing pages
 * Version: 1.0.0
 * License: MIT
 */

defined('ABSPATH') or die();
// include ABSPATH . '../../vendor/autoload.php';

use QuanDigital\WpLib\Autoload;

new Autoload(__DIR__, __NAMESPACE__);

new Plugin(__FILE__);
