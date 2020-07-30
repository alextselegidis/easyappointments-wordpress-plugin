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

/**
 * Verify Connection State
 *
 * If there are link information, this module will make an AJAX request to the main plugin
 * in order to trigger the "Verify State" operation and display the result to the settings
 * page of the plugin.
 */
jQuery(function ($) {

    'use strict';

    var $path = $('#path');
    var $url = $('#url');

    if ($path.val() === '' || $url.val() === '') {
        EAWPPlugin.toggleOperationButtons(false);
        return; // no need to check
    }

    var data = {
        action: 'verify-state',
        path: $path.val(),
        url: $url.val(),
        nonce: EAWPConfig.Ajax.nonce
    };

    $.ajax({
        url: window.ajaxurl,
        data: data,
        method: 'POST',
        dataType: 'json'
    })
        .done(function (response) {
            var status = !response.exception;
            EAWPPlugin.toggleOperationButtons(status);

            $('.eawp .notification').remove();

            if (!response.exception) {
                $('.eawp').prepend(
                    '<div class="updated notification">'
                    + '<span class="dashicons dashicons-yes"></span>'
                    + EAWPConfig.Lang.VerificationSuccess
                    + '</div>'
                );
            } else {
                $('.eawp').prepend(
                    '<div class="error notification">'
                    + '<span class="dashicons dashicons-no"></span>'
                    + EAWPConfig.Lang.VerificationFailure
                    + '</div>'
                );
            }
        })
        .fail(EAWPPlugin.handleAjaxFailure);

});
