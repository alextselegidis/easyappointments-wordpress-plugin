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

use InvalidArgumentException;
use function add_action;
use function add_filter;
use function wp_enqueue_script;
use function wp_enqueue_style;
use function wp_verify_nonce;
use const WP_DEBUG;

/**
 * EAWP Route Class
 *
 * This class manages WordPress action hooking and data filtering in order to trigger the required
 * operations through libraries when necessary.
 */
class Route
{
    /**
     * Hook Plugin Action
     *
     * @param string $name Action name (see WordPress action hooks)
     * @param callable $callback Callback function for the action.
     *
     * @throws InvalidArgumentException If arguments are invalid.
     */
    public function action($name, $callback)
    {
        if (!is_string($name) || empty($name)) {
            throw new InvalidArgumentException('Invalid $name argument: ' . print_r($name, true));
        }

        if (!is_callable($callback)) {
            throw new InvalidArgumentException('Invalid $callback argument: ' . print_r($callback, true));
        }

        add_action($name, $callback);
    }

    /**
     * Add WP Filter
     *
     * @param string $name Filter name (see WordPress filter hooks).
     * @param callable $callback Callback function for the filter.
     *
     * @throws InvalidArgumentException If arguments are invalid.
     */
    public function filter($name, $callback)
    {
        if (!is_string($name) || empty($name)) {
            throw new InvalidArgumentException('Invalid $name argument: ' . print_r($name, true));
        }

        if (!is_callable($callback)) {
            throw new InvalidArgumentException('Invalid $callback argument: ' . print_r($callback, true));
        }

        add_filter($name, $callback);
    }

    /**
     * Route AJAX request from JavaScript
     *
     * This method must set a rule in order to route a future request from the user's browser. Always
     * return error responses in JSON format back to client.
     *
     * @param string $name The name of the request that will execute the callback.
     * @param callable $callback Callable that will handle the ajax request.
     *
     * @throws InvalidArgumentException If arguments are invalid.
     */
    public function ajax($name, $callback)
    {
        if (!is_string($name) || empty($name)) {
            throw new InvalidArgumentException('Invalid $name argument: ' . print_r($name, true));
        }

        if (!is_callable($callback)) {
            throw new InvalidArgumentException('Invalid $callback argument: ' . print_r($callback, true));
        }

        add_action('wp_ajax_' . $name, function () use ($callback) {
            if (!wp_verify_nonce($_REQUEST['nonce'], 'eawp')) {
                throw new UnexpectedValueException('The AJAX nonce is not valid!');
            }
            $callback();
        });
    }

    /**
     * Route Plugin Shortcode
     *
     * This method will route a shortcode for the plugin and will execute the callback method.
     *
     * @param string $name Shortcode name to be registered.
     * @param callable $callback Callable that will handle the shortcode execution.
     */
    public function shortcode($name, $callback)
    {
        add_action('init', function () use ($name, $callback) {
            add_shortcode($name, $callback);
        });
    }

    /**
     * Route view display on a specific hook.
     *
     * Example:
     *     $route->view('Easy!Appointments', 'Easy!Appointments', 'admin');
     *
     * @param string $pageTitle The settings page meta title.
     * @param string $menuTitle WP admin menu title (will be displayed in the "Settings" menu).
     * @param string $menuSlug WP admin menu slug (used internally by WordPress).
     * @param string $viewFile View file name (without .php extension) to be included  directly
     * from the "views" directory.
     * @param array $assets This array must include the name of the file (with extensions)from
     * the assets directory for the assets to be loaded (JavaScript or CSS, eg array('admin.js', 'style.css').
     * @param array $jsData Contains PHP values to be passed to the JavaScript code of the view file .
     *
     * @throws InvalidArgumentException If argument is invalid.
     */
    public function view($pageTitle, $menuTitle, $menuSlug, $viewFile, array $assets = [], array $jsData = [])
    {
        if (!is_string($pageTitle) || empty($pageTitle)) {
            throw new InvalidArgumentException('Invalid $pageTitle argument: ' . print_r($pageTitle, true));
        }

        if (!is_string($menuTitle) || empty($menuTitle)) {
            throw new InvalidArgumentException('Invalid $menuTitle argument: ' . print_r($menuTitle, true));
        }

        if (!is_string($menuSlug) || empty($menuSlug)) {
            throw new InvalidArgumentException('Invalid $menuSlug argument: ' . print_r($menuSlug, true));
        }

        if (!is_string($viewFile) || empty($viewFile)) {
            throw new InvalidArgumentException('Invalid $viewFile argument: ' . print_r($viewFile, true));
        }

        add_action('admin_menu', function () use ($pageTitle, $menuTitle, $menuSlug, $viewFile, $assets, $jsData) {
            add_options_page(
                $pageTitle,
                $menuTitle,
                'manage_options',
                $menuSlug,
                function () use ($viewFile, $assets, $jsData) {
                    // Enqueue required assets.
                    foreach ($assets as $file) {
                        if (substr($file, -3) === '.js') {
                            $file = (!WP_DEBUG) ? str_replace('.js', '.min.js', $file) : $file;
                            wp_enqueue_script(md5($file), plugins_url('../assets/js/' . $file, __FILE__));
                            wp_localize_script(md5($file), 'EAWPConfig', $jsData);
                        } else {
                            if (substr($file, -4) === '.css') {
                                $file = (!WP_DEBUG) ? str_replace('.css', '.min.css', $file) : $file;
                                wp_enqueue_style(md5($file), plugins_url('../assets/css/' . $file, __FILE__));
                            }
                        }
                    }
                    // Include view file (loaded from views directory).
                    include EAWP_BASEPATH . '/views/' . $viewFile . '.php';
                }
            );
        });
    }

    /**
     * Enqueue JavaScript File
     *
     * @param string $url The URL to JavaScript file.
     *
     * @throws InvalidArgumentException If argument is invalid.
     */
    public function script($url)
    {
        if (!is_string($url) || empty($url)) {
            throw new InvalidArgumentException('Invalid $url argument: ' . print_r($url, true));
        }
        wp_enqueue_script(md5($url), $url);
    }

    /**
     * Enqueue Style File
     *
     * @param string $url The URL to Style file.
     *
     * @throws InvalidArgumentException If argument is invalid.
     */
    public function style($url)
    {
        if (!is_string($url) || empty($url)) {
            throw new InvalidArgumentException('Invalid $url argument: ' . print_r($url, true));
        }
        wp_enqueue_style(md5($url), $url);
    }
}
