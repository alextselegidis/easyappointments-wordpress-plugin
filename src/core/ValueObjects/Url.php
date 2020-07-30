<?php
/* ----------------------------------------------------------------------------
 * Easy!Appointments - WordPress Plugin
 *
 * @license GPLv3
 * @copyright A.Tselegidis (C) 2017
 * @link http://easyappointments.org
 * @since v1.0.0
 * ---------------------------------------------------------------------------- */

namespace EAWP\Core\ValueObjects;

use InvalidArgumentException;

/**
 * URL Value Object
 *
 * Use this value object to validate server URL strings.
 */
class Url
{
    /**
     * @var string
     */
    protected $url;

    /**
     * Class Constructor
     *
     * @param string $url Provide the application base URL to be used for configuring E!A.
     *
     * @throws InvalidArgumentException When an invalid URL is provided.
     */
    public function __construct($url)
    {
        if (!is_string($url) || empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid $url argument provided: ' . print_r($url, true));
        }

        $this->url = rtrim($url, '/');
    }

    /**
     * Get URL as string literal.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->url;
    }
}
