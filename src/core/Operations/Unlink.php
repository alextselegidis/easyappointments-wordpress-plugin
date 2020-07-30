<?php
/* ----------------------------------------------------------------------------
 * Easy!Appointments - WordPress Plugin
 *
 * @license GPLv3
 * @copyright A.Tselegidis (C) 2017
 * @link http://easyappointments.org
 * @since v1.0.0
 * ---------------------------------------------------------------------------- */

namespace EAWP\Core\Operations;

use EAWP\Core\Operations\Interfaces\OperationInterface;
use EAWP\Core\Plugin;
use EAWP\Core\ValueObjects\LinkInformation;
use Exception;
use InvalidArgumentException;
use function delete_option;
use function reset;
use function rmdir;

/**
 * Unlink Operation
 *
 * This class implements the "unlink" operation of a given connection between WordPress and
 * Easy!Appointments. It is also possible to entirely remove the installation files and database
 * tables.
 */
class Unlink implements OperationInterface
{
    /**
     * Plugin Instance
     *
     * @var Plugin
     */
    protected $plugin;

    /**
     * Easy!Appointments Link Information
     *
     * @var LinkInformation
     */
    protected $linkInformation;

    /**
     * Remove E!A Files
     *
     * @var bool
     */
    protected $removeFiles;

    /**
     * Remove E!A Database Tables
     *
     * @var bool
     */
    protected $removeDbTables;

    /**
     * Class Constructor
     *
     * @param Plugin $plugin Easy!Appointments WordPress plugin instance.
     * @param LinkInformation $linkInformation Easy!Appointments Link Information
     * @param bool $removeFiles (optional) Whether to remove the Easy!Appointments files.
     * @param bool $removeDbTables (optional) Whether to remove the Easy!Appointments database tables.
     */
    public function __construct(
        Plugin $plugin,
        LinkInformation $linkInformation,
        $removeFiles = false,
        $removeDbTables = false
    )
    {
        if (!is_bool($removeFiles)) {
            throw new InvalidArgumentException('Invalid argument provided (expected bool got "'
                . gettype($removeFiles) . '"): ' . $removeFiles);
        }

        if (!is_bool($removeDbTables)) {
            throw new InvalidArgumentException('Invalid argument provided (expected bool got "'
                . gettype($removeDbTables) . '"): ' . $removeDbTables);
        }

        $this->plugin = $plugin;
        $this->linkInformation = $linkInformation;
        $this->removeFiles = $removeFiles;
        $this->removeDbTables = $removeDbTables;
    }

    /**
     * Invoke the unlink operation.
     *
     * This method will reset the WordPress options which will automatically disable any used shortcodes.
     */
    public function invoke()
    {
        $this->_removeOptions();

        if ($this->removeDbTables) {
            $this->removeDbTables();
        }

        if ($this->removeFiles) {
            $this->removeFiles();
        }
    }

    /**
     * Remove WordPress Options of Plugin
     *
     * Without the eawp_path and eawp_url options there is no connection with E!A and WordPress.
     * The plugin shortcode will not work anymore.
     */
    protected function _removeOptions()
    {
        delete_option('eawp_path');
        delete_option('eawp_url');
    }

    /**
     * Remove E!A database tables.
     */
    protected function removeDbTables()
    {
        $db = $this->plugin->getDatabase();
        $db->query('DROP TABLE IF EXISTS ea_appointments;');
        $db->query('DROP TABLE IF EXISTS ea_secretaries_providers;');
        $db->query('DROP TABLE IF EXISTS ea_services_providers;');
        $db->query('DROP TABLE IF EXISTS ea_settings;');
        $db->query('DROP TABLE IF EXISTS ea_services;');
        $db->query('DROP TABLE IF EXISTS ea_service_categories;');
        $db->query('DROP TABLE IF EXISTS ea_user_settings;');
        $db->query('DROP TABLE IF EXISTS ea_users;');
        $db->query('DROP TABLE IF EXISTS ea_roles;');
    }

    /**
     * Remove E!A files.
     *
     * This method will only remove the files that belong to the Easy!Appointments vendor package.
     */
    protected function removeFiles()
    {
        if (!is_writable((string)$this->linkInformation->getPath())) {
            throw new Exception('Cannot remove installation files, permission denied.');
        }

        $entries = [
            'application/',
            'assets/',
            'engine/',
            'storage/',
            'system/',
            'vendor/'
        ];

        $path = (string)$this->linkInformation->getPath();

        foreach ($entries as $entry) {
            $this->recursiveDelete($path . '/' . $entry);
        }

        @unlink($path . '/autoload.php');
        @unlink($path . '/CHANGELOG.md');
        @unlink($path . '/config.php');
        @unlink($path . '/index.php');
        @unlink($path . '/LICENSE');
        @unlink($path . '/README.md');
    }

    /**
     * Recursive removal of a directory.
     *
     * @param string @dir Directory path to be deleted.
     *
     * @link http://stackoverflow.com/a/3338133/1718162
     */
    protected function recursiveDelete($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        $this->recursiveDelete($dir . "/" . $object);
                    } else {
                        @\unlink($dir . "/" . $object);
                    }
                }
            }
            @reset($objects);
            @rmdir($dir);
        }
    }
}
