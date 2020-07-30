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
 * Easy!Appointments WP Page
 *
 * Defines the JS functionality of the admin settings page.
 */
jQuery(function ($) {

    'use strict';

    /**
     * Execute the install operation with the provided data.
     */
    function install() {
        var data = {
            action: 'install',
            path: $('#path').val(),
            url: $('#url').val(),
            nonce: EAWPConfig.Ajax.nonce
        };

        $.ajax({
            url: window.ajaxurl,
            data: data,
            method: 'POST',
            dataType: 'json'
        })
            .done(function (response) {
                if (response.exception) {
                    return EAWPPlugin.handleAjaxException(response);
                }

                $('.eawp .notification').remove();

                $('.eawp').prepend(
                    '<div class="updated notification">'
                    + '<span class="dashicons dashicons-yes"></span>'
                    + EAWPConfig.Lang.InstallationSuccessMessage
                    + ' &rarr; '
                    + '<a href="' + data.url + '" target="_blank">' + data.url + '</a>'
                    + '</div>'
                );

                EAWPPlugin.toggleOperationButtons(true);
            })
            .fail(EAWPPlugin.handleAjaxFailure);
    }

    /**
     * Execute the link operation with the provided data.
     */
    function link() {
        var data = {
            action: 'link',
            path: $('#path').val(),
            url: $('#url').val(),
            nonce: EAWPConfig.Ajax.nonce
        };

        $.ajax({
            url: window.ajaxurl,
            data: data,
            method: 'POST',
            dataType: 'json'
        })
            .done(function (response) {
                if (response.exception) {
                    return EAWPPlugin.handleAjaxException(response);
                }

                $('.eawp .notification').remove();

                $('.eawp').prepend(
                    '<div class="updated notification">'
                    + '<span class="dashicons dashicons-yes"></span>'
                    + EAWPConfig.Lang.LinkSuccessMessage
                    + '</div>'
                );

                EAWPPlugin.toggleOperationButtons(true);
            })
            .fail(EAWPPlugin.handleAjaxFailure);
    }

    /**
     * Execute the unlink operation with the provided data.
     */
    function unlink() {
        var data = {
            action: 'unlink',
            path: $('#path').val(),
            url: $('#url').val(),
            removeFiles: $('#remove-files').prop('checked'),
            removeDbTables: $('#remove-db-tables').prop('checked'),
            nonce: EAWPConfig.Ajax.nonce
        };

        $.ajax({
            url: window.ajaxurl,
            data: data,
            method: 'POST',
            dataType: 'json'
        })
            .done(function (response) {
                if (response.exception) {
                    return EAWPPlugin.handleAjaxException(response);
                }

                $('.eawp .notification').remove();

                $('.eawp').prepend(
                    '<div class="updated notification">'
                    + '<span class="dashicons dashicons-yes"></span>'
                    + EAWPConfig.Lang.UnlinkSuccessMesssage
                    + '</div>'
                );

                $('#path, #url').val('');

                $('#remove-files, #remove-db-tables').prop('checked', false);

                EAWPPlugin.toggleOperationButtons(false);
            })
            .fail(EAWPPlugin.handleAjaxFailure);
    }

    // ------------------------------------------------------------------------
    //  INITIALIZE PAGE
    // ------------------------------------------------------------------------

    $('#install').on('click', install);

    $('#link').on('click', link);

    $('#unlink').on('click', unlink);

    $(document).ajaxStart(function () {
        $('.eawp img.loading').removeClass('hidden');
    });

    $(document).ajaxComplete(function () {
        $('.eawp img.loading').addClass('hidden');
    });
});
