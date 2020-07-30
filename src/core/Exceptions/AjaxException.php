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

namespace EAWP\Core\Exceptions;

use Exception;

/**
 * AJAX Exception
 *
 * This exception class is used to convert normal caught exceptions to JSON-encoded strings that will be
 * returned back to JavaScript.
 */
class AjaxException extends Exception
{
    /**
     * Get a JSON encoded exception response.
     *
     * @param Exception $ex The exception object to be serialized.
     * @param bool $encode Whether to "json_encode" the result or not.
     *
     * @return mixed Associative array or JSON-encoded information of the provided exception.
     */
    public static function response(Exception $ex, $encode = false)
    {
        $exceptionInformation = [
            'exception' => true,
            'message' => $ex->getMessage(),
            'code' => $ex->getCode(),
            'file' => $ex->getFile(),
            'line' => $ex->getLine(),
            'trace' => $ex->getTrace(),
            'traceAsString' => $ex->getTraceAsString()
        ];

        return ($encode) ? json_encode($exceptionInformation) : $exceptionInformation;
    }
}
