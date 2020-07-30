<?php
/* ----------------------------------------------------------------------------
 * Easy!Appointments - WordPress Plugin
 *
 * @license GPLv3
 * @copyright A.Tselegidis (C) 2017
 * @link http://easyappointments.org
 * @since v1.0.0
 * ---------------------------------------------------------------------------- */

namespace EAWP\Core;

use db;
use EAWP\Core\Exceptions\AjaxException;
use EAWP\Core\Operations\Install;
use EAWP\Core\Operations\Link;
use EAWP\Core\Operations\Shortcode;
use EAWP\Core\Operations\Unlink;
use EAWP\Core\Operations\VerifyState;
use EAWP\Core\ValueObjects\LinkInformation;
use EAWP\Core\ValueObjects\Path;
use EAWP\Core\ValueObjects\Url;
use Exception;
use wpdb;
use function get_option;
use function wp_create_nonce;
use function wp_send_json;

/**
 * EAWP Plugin Class
 *
 * This class handles the core operations of the plugin. It coordinates the libraries and registers
 * the required hooks for WordPresss.
 */
class Plugin
{
    /**
     * WordPress Database Handler
     *
     * @var mixed(WPDB)
     */
    protected $db;

    /**
     * Handles WordPress Action + Filters Routing
     *
     * @var Route
     */
    protected $route;

    /**
     * Class Constructor
     *
     * @param \WPDB $wpdb WordPress database handler.
     */
    public function __construct(wpdb $wpdb, Route $route)
    {
        $this->db = $wpdb;
        $this->route = $route;
    }

    /**
     * Initialize Plugin
     *
     * Bind necessary actions and filters, register WP admin menu.
     */
    public function initialize()
    {
        $plugin = $this; // Closure Argument
        $route = $this->route;

        $this->route->action('plugins_loaded', function () use ($plugin, $route) {
            load_plugin_textdomain('eawp', false, dirname(plugin_basename(__DIR__)) . '/assets/lang');

            $jsData = [
                'Lang' => [
                    'InstallationSuccessMessage' =>
                        __('Easy!Appointments files were installed successfully! Navigate to your installation URL '
                            . 'complete the configuration of the application.', 'eawp'),
                    'LinkSuccessMessage' =>
                        __('Easy!Appointments installation was linked successfully! You can now use the '
                            . '[easyappointments] shortcode in your pages.', 'eawp'),
                    'UnlinkSuccessMesssage' =>
                        __('Easy!Apppointments installation was unlinked successfully!', 'eawp'),
                    'VerificationSuccess' =>
                        __('Easy!Appointments link is active! Use the [easyappointments] shortcode in your pages/posts.', 'eawp'),
                    'VerificationFailure' =>
                        __('Easy!Appointments link seems to be broken! Make sure Easy!Appointments files are located in the target directory.', 'eawp'),
                    'AjaxExceptionMessage' =>
                        __('An unexpected error occurred in file %file% (line %line%): %message%', 'eawp'),
                    'AjaxFailureMessage' =>
                        __('The AJAX request could not be completed due to an unexpected error: %message%', 'eawp')
                ],
                'Ajax' => [
                    'nonce' => wp_create_nonce('eawp')
                ]
            ];

            $route->view('Easy!Appointments', 'Easy!Appointments',
                'eawp-settings', 'admin', ['plugin.js', 'admin.js', 'verify-state.js', 'style.css'], $jsData);
        });

        $this->route->ajax('install', function () use ($plugin) {
            try {
                $path = new Path(sanitize_text_field($_POST['path']));
                $url = new Url(sanitize_text_field($_POST['url']));
                $linkInformation = new LinkInformation($path, $url);
                $operation = new Install($plugin, $linkInformation);
                $operation->invoke();
            } catch (Exception $ex) {
                wp_send_json(AjaxException::response($ex));
            }
        });

        $this->route->ajax('link', function () use ($plugin) {
            try {
                $path = new Path(sanitize_text_field($_POST['path']));
                $url = new Url(sanitize_text_field($_POST['url']));
                $linkInformation = new LinkInformation($path, $url);
                $operation = new Link($plugin, $linkInformation);
                $operation->invoke();
            } catch (Exception $ex) {
                wp_send_json(AjaxException::response($ex));
            }
        });

        $this->route->ajax('unlink', function () use ($plugin) {
            try {
                $path = new Path(sanitize_text_field($_POST['path']));
                $url = new Url(sanitize_text_field($_POST['url']));
                $removeFiles = filter_var($_POST['removeFiles'], FILTER_VALIDATE_BOOLEAN);
                $removeDbTables = filter_var($_POST['removeDbTables'], FILTER_VALIDATE_BOOLEAN);
                $linkInformation = new LinkInformation($path, $url);
                $operation = new Unlink($plugin, $linkInformation, $removeFiles, $removeDbTables);
                $operation->invoke();
            } catch (Exception $ex) {
                wp_send_json(AjaxException::response($ex));
            }
        });

        $this->route->ajax('verify-state', function () use ($plugin) {
            try {
                $path = new Path(sanitize_text_field($_POST['path']));
                $url = new Url(sanitize_text_field($_POST['url']));
                $linkInformation = new LinkInformation($path, $url);
                $operation = new VerifyState($plugin, $linkInformation);
                $operation->invoke();
            } catch (Exception $ex) {
                wp_send_json(AjaxException::response($ex));
            }
        });

        $this->route->shortcode('easyappointments', function ($attributes) use ($plugin) {
            $path = get_option('eawp_path');
            $url = get_option('eawp_url');

            if (empty($path) || empty($url)) {
                return; // There are no options set so do not proceed with the operation.
            }

            $attributes = (is_array($attributes)) ? $attributes : [];

            $linkInformation = new LinkInformation(new Path($path), new Url($url));
            $operation = new Shortcode($plugin, $linkInformation, $attributes);
            return $operation->invoke();
        });
    }

    /**
     * Get WordPress Database Object.
     *
     * @return db
     */
    public function getDatabase()
    {
        return $this->db;
    }

    /**
     * Install Plugin
     *
     * Performs the required actions for installing this plugin.
     */
    public function install()
    {
        // Add the required operations here ...
        return;
    }

    /**
     * Uninstall Plugin
     *
     * Performs the required actions for uninstalling this plugin.
     */
    public function uninstall()
    {
        // Add the required operations here ...
        return;
    }
}
