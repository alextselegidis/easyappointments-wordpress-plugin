<?php
/**
 * Plugin Name: Easy!Appointments - WordPress Plugin
 * Plugin URI: https://easyappointments.org
 * Description: Easy!Appointments web scheduling integration with WordPress.
 * Version: 1.2.0
 * Author: A.Tselegidis
 * Author URI: https://alextselegidis.com
 * Text Domain: eawp
 * License: GPLv3
 */

// Base Plugin Path
define('EAWP_BASEPATH', __DIR__);

// Supported Versions
define('EAWP_MIN_VERSION', '1.0.0');
define('EAWP_MAX_VERSION', '1.4.0');

// Integrations Information Source
define('EAWP_INTEGRATIONS_INFORMATION_URL', 'https://easyappointments.org/integrations/integrations.json');

// Setup Autoloader
require EAWP_BASEPATH . '/core/Autoload.php';
$loader = new EAWP\Core\Autoload;
$loader->register();
$loader->addNamespace('EAWP\Core', EAWP_BASEPATH . '/core');

// Initialize Plugin
global $wpdb;
$route = new EAWP\Core\Route();
$plugin = new EAWP\Core\Plugin($wpdb, $route);
$plugin->initialize();
