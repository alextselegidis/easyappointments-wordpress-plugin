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

window.EAWPPlugin = window.EAWPPlugin || {};

/**
 * Easy!Appointments WP Plugin
 *
 * This module adds common JS functionality that is shared between the other modules.
 */
(function (exports, $) {

    'use strict';

    /**
     * Create an error message HTML output for the plugin page.
     *
     * @param  {string} message
     */
    function showErrorMessage(message) {
        // Remove previous message and display a new one with exception information.
        $('.eawp .notification').remove();

        $('.eawp').prepend(
            '<div class="error notification">'
            + '<span class="dashicons dashicons-no"></span>'
            + message
            + '</div>'
        );
    }

    /**
     * Handle AJAX Exception
     *
     * This method will display exception information to the user.
     *
     * @param {object} exception
     */
    exports.handleAjaxException = function (exception) {
        var message = EAWPConfig.Lang.AjaxExceptionMessage
            .replace('%file%', exception.file)
            .replace('%line%', exception.line)
            .replace('%message%', exception.message);

        showErrorMessage(message);

        console.log('AJAX Exception: ', exception);
    };

    /**
     * Handle AJAX Failure
     *
     * This method must be bound to the "fail" method of the jqXHR object and must be executed whenever
     * the AJAX request was failed. It will also display a user friendly message to the plugin page.
     *
     * @param  {jqXHR} jqXHR
     * @param  {string} textStatus
     * @param  {Error} errorThrown
     */
    exports.handleAjaxFailure = function (jqXHR, textStatus, errorThrown) {
        var message = EAWPConfig.Lang.AjaxFailureMessage.replace('%message%', errorThrown.message);

        showErrorMessage(message);

        console.log('AJAX Failure: ', jqXHR, textStatus, errorThrown);
    };

    /**
     * Toggle the visibility status of the operation buttons.
     *
     * @param {Boolean} linkStatus A true value states that there is an active connection while
     * a false indicates that there is no active connection.
     */
    exports.toggleOperationButtons = function (linkStatus) {
        if (linkStatus) {
            $('.link-operations').hide();
            $('.unlink-operations').show();
        } else {
            $('.link-operations').show();
            $('.unlink-operations').hide();
        }
    };

})(EAWPPlugin, jQuery);
