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

namespace EAWP\Core\Operations;

use EAWP\Core\Operations\Interfaces\OperationInterface;
use EAWP\Core\Plugin;
use EAWP\Core\ValueObjects\LinkInformation;
use function wp_enqueue_script;

/**
 * Shortcode Class
 *
 * This class will handle the addition of the booking wizard in a WordPress post/page with the
 * use of a simple short code ("easyappointments").
 *
 * @todo Implement Shortcode Operation
 */
class Shortcode implements OperationInterface
{
    /**
     * Easy!Appointments WordPress Plugin Instance
     *
     * @var Plugin
     */
    protected $plugin;

    /**
     * Easy!Appointments Installation LinkInformation
     *
     * @var LinkInformation
     */
    protected $linkInformation;

    /**
     * Class Constructor
     *
     * @param Plugin $plugin Easy!Appointments WordPress Plugin Instance
     * @param LinkInformation $linkInformation Easy!Appointments Link Information
     */
    public function __construct(Plugin $plugin, LinkInformation $linkInformation, array $attributes)
    {
        $this->plugin = $plugin;
        $this->linkInformation = $linkInformation;
        $this->attributes = $attributes;
    }

    /**
     * Invoke Shortcode Operation
     *
     * This operation must include the E!A booking form into a page that has the "easyappointments"
     * shortcode. The shortcode binding is done from the core plugin and this operation must resolve
     * all the dependencies and load the booking form inside the page so that website users can book
     * an appointment.
     */
    public function invoke()
    {
        $file = (WP_DEBUG) ? 'iframe.js' : 'iframe.min.js';
        wp_enqueue_script(md5($file), plugins_url('../../assets/js/' . $file, __FILE__));

        $width = (isset($this->attributes['width'])) ? $this->attributes['width'] : '100%';
        $height = (isset($this->attributes['height'])) ? $this->attributes['height'] : '700px';
        $style = (isset($this->attributes['style'])) ? $this->attributes['style'] : '';

        return '<iframe class="easyappointments-wp-iframe" src="' . (string)$this->linkInformation->getUrl() . '"
                width="' . $width . '" height="' . $height . '" style="' . $style . '" frameborder="0"></iframe>';
    }
}
