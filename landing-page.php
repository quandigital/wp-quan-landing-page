<?php

namespace QuanDigital\LandingPage;

use QuanDigital\WpLib\Autoload;

/**
 * Plugin Name: Quan Landing Page
 * Plugin URI: https://github.com/quandigital/wp-quan-landing-page
 * Author: Quan Digital GmbH
 * Author URI: http://www.quandigital.com/
 * Description: Adds a custom post types for landing pages
 * Version: 1.0.4
 * License: MIT
 */

new Autoload(__DIR__, __NAMESPACE__);

new Plugin(__FILE__);
