<?php
/* ----------------------------------------------------------------------------
 * Easy!Appointments - WordPress Plugin
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) 2017 - 2020, Alex Tselegidis
 * @license     http://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        http://easyappointments.org
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

namespace EAWP\Core\ValueObjects;

/**
 * Link Information Entity
 *
 * Contains the connection information between Easy!Appointments and WordPress.
 */
class LinkInformation
{
    /**
     * Link Path
     *
     * @var Path
     */
    protected $path;

    /**
     * Link URL
     *
     * @var Url
     */
    protected $url;

    /**
     * Class Constructor
     *
     * @param Path $path The installation path that points to the
     * Easy!Appointments directory.
     * @param Url $url The installation URL that points to the
     * Easy!Appointments directory.
     */
    public function __construct(Path $path, Url $url)
    {
        $this->path = $path;
        $this->url = $url;
    }

    /**
     * Path getter method.
     *
     * @return Path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * URL getter method.
     *
     * @return Url
     */
    public function getUrl()
    {
        return $this->url;
    }
}
