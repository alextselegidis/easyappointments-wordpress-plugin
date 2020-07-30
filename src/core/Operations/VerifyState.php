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
use function file_exists;

/**
 * Verify State Operation
 *
 * This class implements the "verify state" operation of the current connection. It will check if Easy!Appointments is
 * correctly connected to WordPress, whether the configuration.php file exists and if the E!A installation is reachable
 * from the web.
 */
class VerifyState implements OperationInterface
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
     * File name to be hit by the request validation.
     *
     * @var string
     */
    protected $filename;

    /**
     * Expected response status code.
     *
     * @var string
     */
    protected $expectedStatusCode;

    /**
     * Class Constructor
     *
     * @param Plugin $plugin Easy!Appointments WordPress Plugin Instance
     * @param LinkInformation $linkInformation Easy!Appointments Link Information
     * @param string $filename (optional) The filename to be hit by the request validation.
     * @param string $expectedStatusCode (optional) The expected status code of the request response.
     */
    public function __construct(
        Plugin $plugin,
        LinkInformation $linkInformation,
        $filename = 'index.php',
        $expectedStatusCode = '200'
    )
    {

        if (!is_string($filename)) {
            throw new InvalidArgumentException('Invalid argument provided (expected string got "'
                . gettype($filename) . '"): ' . $filename);
        }

        if (!is_string($expectedStatusCode)) {
            throw new InvalidArgumentException('Invalid argument provided (expected string got "'
                . gettype($expectedStatusCode) . '"): ' . $expectedStatusCode);
        }

        $this->plugin = $plugin;
        $this->linkInformation = $linkInformation;
        $this->filename = $filename;
        $this->expectedStatusCode = $expectedStatusCode;
    }

    /**
     * Invoke the verify state operation.
     *
     * This method will reset the WordPress options which will automatically disable any used shortcodes.
     */
    public function invoke()
    {
        $this->verifyConfigurationFile();
    }

    /**
     * Verify that the configuration file is where it's supposed to be.
     *
     * @throws Exception If no configuration file is found.
     */
    protected function verifyConfigurationFile()
    {
        if (!file_exists((string)$this->linkInformation->getPath() . '/configuration.php')
            && !file_exists((string)$this->linkInformation->getPath() . '/config.php')
        ) {
            throw new Exception('Configuration file of Easy!Appointments was not found on the given path.');
        }
    }
}
