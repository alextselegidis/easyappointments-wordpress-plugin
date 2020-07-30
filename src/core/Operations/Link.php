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
use function update_option;

/**
 * Link Operation
 *
 * This class implements the "link" of WordPress and an existing Easy!Appointments installation. It will set the
 * configuration information to the WordPress settings table ("eawp_path" and "eawp_url").
 *
 * Important:
 *
 * This operation should also check that the destination path contains a valid E!A installation and it is compatible
 * with the current plugin version (very important for future releases). With  this check we can ensure that the
 * "linked" E!A version will work without defects.
 */
class Link implements OperationInterface
{
    /**
     * Instance of Easy!Appointments WP Plugin
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
     * Class Constructor
     *
     * @param Plugin $plugin Easy!Appointments WordPress plugin instance.
     * @param LinkInformation $link Contains installation information.
     */
    public function __construct(Plugin $plugin, LinkInformation $linkInformation)
    {
        $this->plugin = $plugin;
        $this->linkInformation = $linkInformation;
    }

    /**
     * Invoke Link Operation
     *
     * Will create a link between an existing installation with current WordPress site. This method must add the
     * "eawp_path" and "eawp_url" setting to WP options so that other operations can use  that installation. At first it
     * will read the "configuration.php" file of E!A and then place these information into WP options table in order to
     * be available for other operations.
     */
    public function invoke()
    {
        $this->validateInstallation();
        update_option('eawp_path', (string)$this->linkInformation->getPath());
        update_option('eawp_url', (string)$this->linkInformation->getUrl());
    }

    /**
     * Validate Easy!Appointments installation.
     *
     * This method must check whether the provided path points to an Easy!Appointments installation. Currently it will
     * only check for a "configuration.php" or a "config.php" file.
     *
     * @throws Exception If the provided path does not point to an E!A installation.
     */
    protected function validateInstallation()
    {
        $path = rtrim((string)$this->linkInformation->getPath(), '/');

        if (!file_exists($path . '/configuration.php') && !file_exists($path . '/config.php')) {
            throw new Exception('Provided path does not point to an Easy!Appointments installation: "'
                . (string)$this->linkInformation->getPath() . '"');
        }
    }
}
