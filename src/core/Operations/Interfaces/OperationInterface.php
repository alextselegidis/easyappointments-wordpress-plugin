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

namespace EAWP\Core\Operations\Interfaces;

/**
 * Operation Interface
 *
 * Defines a solid interface for all plugin operations so that they have the same public API.
 */
interface OperationInterface
{
    /**
     * Invoke Library
     *
     * This method must define the operation logic that will execute a specific task. Every plugin
     * operation must define a single task.
     */
    public function invoke();
}
