<?php
/* ----------------------------------------------------------------------------
 * Easy!Appointments - WordPress Plugin
 *
 * @license GPLv3
 * @copyright A.Tselegidis (C) 2017
 * @link http://easyappointments.org
 * @since v1.0.0
 * ---------------------------------------------------------------------------- */

/*
 * This WordPress administration page will accept user settings and display
 * information about the plugin and the supported operations.
 */

add_thickbox();

?>

<div class="wrap eawp">
    <div class="header">
        <img class="logo" src="<?= plugins_url('assets/img/logo.png', __DIR__) ?>"
             alt="Easy!Appointments Logo"/>
        <h1>
            Easy!Appointments - WordPress Plugin
            <img class="loading hidden" src="<?= admin_url('images/wpspin_light-2x.gif') ?>">
        </h1>
    </div>
    <p>
        <?php _e('Integrate the booking form of Easy!Appointments directly into your WordPress pages. This plugin will  '
            . 'let you create a new Easy!Appointments installation or use an existing one directly from the WordPress '
            . 'back-end section. Add the [easyappointments] shortcode into your pages and leverage your conversion rates.',
            'eawp') ?>
    </p>

    <p>
        <a title="<?php _e('Hints', 'eawp') ?>"
           href="#TB_inline?width=500&height=400&inlineId=hints"
           class="thickbox"><?php _e('Hints', 'eawp') ?></a>
        |
        <a title="<?php _e('Troubleshooting', 'eawp') ?>"
           href="#TB_inline?width=500&height=400&inlineId=troubleshooting"
           class="thickbox"><?php _e('Troubleshooting', 'eawp') ?></a>
        |
        <a title="<?php _e('About', 'eawp') ?>"
           href="#TB_inline?width=500&height=400&inlineId=about"
           class="thickbox"><?php _e('About', 'eawp') ?></a>
    </p>

    <h3 class="title"><?php _e('Connection Information', 'eawp') ?></h3>
    <p>
        <?php _e('Set the path and URL of your Easy!Appointments installation and '
            . 'press either the "Install" or "Link" button to proceed with the operation.', 'eawp') ?>
    </p>

    <table class="form-table">
        <tbody>
        <tr>
            <td>
                <label for="path"><?php _e('Path', 'eawp') ?></label>

                <input type="text" id="path" class="regular-text"
                       value="<?= esc_html(get_option('eawp_path')) ?>"/>
                <p class="description">
                    <?= _('Example') . ': ' . str_replace('\\', '/', ABSPATH . 'easyappointments'); ?>
                </p>
                <p class="description">
                    <?= _('* Make sure that the target directory exists on the server and it\'s writable.') ?>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <label for="url"><?php _e('URL', 'eawp') ?></label>

                <input type="text" id="url" class="regular-text"
                       value="<?= esc_html(get_option('eawp_url')) ?>"/>
                <p class="description">
                    <?= _('Example') . ': ' . get_site_url() . '/easyappointments' ?>
                </p>
            </td>
        </tr>
        <tr>
            <td class="submit link-operations hidden">
                <button id='install' class="button button-primary"><?php _e('Install', 'eawp') ?></button>
                <button id='link' class="button"><?php _e('Link', 'eawp') ?></button>
            </td>
            <td class="sublime unlink-operations hidden">
                <fieldset>
                    <label for="remove-files">
                        <input type="checkbox" id="remove-files">
                        <?php _e('Remove Easy!Appointments Files', 'eawp') ?> *
                    </label>

                    <br>

                    <label for="remove-db-tables">
                        <input type="checkbox" id="remove-db-tables">
                        <?php _e('Remove Easy!Appointments Database Tables', 'eawp') ?> *
                    </label>
                </fieldset>

                <br>

                <button id='unlink' class="button"><?php _e('Unlink', 'eawp') ?></button>

                <p class="description">* <?php _e('These actions cannot be undone!', 'eawp') ?></p>
            </td>
        </tr>
        </tbody>
    </table>

    <br>

    <div id="hints" style="display:none">
        <ul>
            <li>
                <h4><?php _e('Install', 'eawp') ?></h4>
                <?php _e('This operation will create a new installation by placing and configuring '
                    . 'Easy!Appointments files into the requested directory. You will '
                    . 'have to complete the installation by opening the target URL in your browser.', 'eawp') ?>
            </li>
            <li>
                <h4><?php _e('Link', 'eawp') ?></h4>
                <?php _e('This operation will connect an existing Easy!Appointments installation and your '
                    . 'WordPress website. Make sure that you use the correct installation '
                    . 'path and URL of Easy!Appointments.', 'eawp') ?>
            </li>
            <li>
                <h4><?php _e('Unlink', 'eawp') ?></h4>
                <?php _e('This operation will unlink an active connection between Easy!Appointments and '
                    . 'your WordPress website. You can remove the files and database tables as well, even '
                    . 'though this is optional.', 'eawp') ?>
            </li>
            <li>
                <h4><?php _e('Shortcode', 'eawp') ?></h4>
                <?php _e('Display the booking form directly in your pages or posts by adding the [easyappointments] '
                    . 'shortcode. This shortcode accepts some optional attributes that will change its appearance. '
                    . 'These attibutes are "width", "height", "style" and will be applied automatically to the parent '
                    . 'container element (e.g. [easyappointments width="500px" height="300px" style="border: 2px solid black"]).',
                    'eawp') ?>
            </li>
        </ul>
    </div>

    <br>

    <div id="troubleshooting" style="display:none">
        <ul>
            <li>
                <h4><?php _e('Permission Problems', 'eawp') ?></h4>
                <?php _e('Some plugin operations perform various filesystem tasks that might be interrupted due to '
                    . 'lack of permissions. This issues mostly happen in Unix environments because '
                    . 'PHP does not have the required permissions to read/write/delete files or directories. If '
                    . 'you cannot solve the problem try to continue the operation manually with an FTP user (e.g. '
                    . 'if the "Install" operation fails, upload the latest Easy!Appointments version manually and '
                    . 'connect it with WordPress with the "Link" operation).', 'eawp') ?>
            </li>
            <li>
                <h4><?php _e('Broken Connection', 'eawp') ?></h4>
                <?php _e('If this settings page notifies you of a broken Easy!Appointments connection it could be that '
                    . 'the Easy!Appointments files where moved or the installation URL was changed and the connection '
                    . 'couldn\'t be verified.  "Unlink" the current connection without removing the files '
                    . 'or database tables and then "Link" it again with the new information.', 'eawp') ?>
            </li>
            <li>
                <h4><?php _e('Support Forum', 'eawp') ?></h4>
                <?php _e('If you encounter issues but you do not know what to do visit the official Easy!Appointments '
                    . 'support group where active users help each other solve their problems.', 'eawp') ?>
            </li>
            <li>
                <a href="https://groups.google.com/forum/#!categories/easy-appointments"><?php _e('Support Group') ?></a>
            </li>
        </ul>
    </div>

    <div id="about" style="display:none">
        <ul>
            <li>
                <img src="<?= esc_url(plugins_url('assets/img/about.png', __DIR__)) ?>"
                     alt="Easy!Appointments Plugin for WordPress">
            </li>
            <li>
                <h4><?php _e('Easy!Appointments - WordPress Plugin', 'eawp') ?></h4>

                <?php _e('Leverage your conversion rates by integrating the booking form directly in your WordPress pages. '
                    . 'Customers will never have to leave your website for booking an appointment. Take advantage of '
                    . 'the scheduling power of Easy!Appointment which will run smoothly with your WordPress installation.'
                    . 'Include the booking form in your pages with the [easyappointments] shortcode.',
                    'eawp') ?>
            </li>

            <li>
                <h4><?php _e('Get Involved', 'eawp') ?></h4>
                <?php _e('Found a problem or want to add a new feature? Contributors are more than welcome so feel '
                    . 'free to file an issue or make pull requests on the GitHub page of the plugin.', 'eawp') ?>

            </li>
            <li>
                <a href="https://github.com/alextselegidis/easyappointments-wp-plugin">Star and Fork on GitHub</a>
            </li>
        </ul>
    </div>

    <hr>

    <em>
        <?php _e('For more information visit the official website of the project at ', 'eawp') ?>
        <a href="http://easyappointments.org">http://easyappointments.org</a>.
    </em>
</div>
