=== Easy!Appointments ===
Contributors: alextselegidis
Donate link: https://alextselegidis.com
Tags: agenda, appointments, scheduler, google-calendar, online-appointments, booking, service-providers, booking-system, online-meetings, reservation-system, scheduling-software, events, staff, customers, organization, efficiency
Requires at least: 4.0.0
Tested up to: 5.4.2
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Integrate the booking form of Easy!Appointments directly into your WordPress pages.

== Description ==

Leverage your conversion rates by integrating the booking form directly in your WordPress pages. Customers will never have to leave your website for booking an appointment. Take advantage of the scheduling power of Easy!Appointment which will run smoothly with your WordPress installation.Include the booking form in your pages with the [easyappointments] shortcode.

*Minimum Requirements: WordPress v4.0 & PHP v5.6*

= Connecting Easy!Appointments with WordPress =

Install and activate the plugin and navigate to `Settings >> Easy!Appointments` menu of the WordPress admin section. Create a new Easy!Appointments installation or connect to an existing one by providing the preferred URL and destination path in the page form. Once a connection is established you'll be able to include the booking form in your pages.

= Include Booking in your Pages =

WordPress supports the use of custom shortcodes which allow plugins to insert custom content into pages. This plugin takes advantage of this functionality and creates an iframe that displays the booking form of Easy!Appointments. Include the `[easyappointments]` shortcode in the correct place of your published contents as shown in the following example.

`[easyappointments width="100%" height="500px" style="border: 5px solid #1A865F; box-shadow: #454545 1px 1px 5px;"]`

The "width", "height" and "style" attributes are optional but can help you to fine tune the styling of the iframe.

*Find out more about Easy!Appointments at http://easyappointments.org*

== Installation ==

Install and activate the plugin and navigate to `Settings >> Easy!Appointments` menu of the WordPress admin section. Create a new Easy!Appointments installation or connect to an existing one by providing the preferred URL and destination path in the page form. Once a connection is established you'll be able to include the booking form in your pages.

After a successful connection you can use the [easyappointments] shortcode in your posts or pages. This shortcode will display the Easy!Appointments booking form and clients will be able to book appointments without ever leaving your website.

== Screenshots ==

1. Booking form integration in mobile viewport.
2. Booking form integration in desktop viewport.
3. Admin page of the plugin.
4. Plugin information modals.

== Frequently Asked Questions ==

= What should I do if I encounter permission errors? =

Some operations of the plugin (such as the Easy!Appointments installation) require filesystem permissions that are not present in your server. If this is the case you will have to set the required permissions to your server or perform manually the operation with FTP (e.g. install Easy!Appointments manually).

= Easy!Appointments default language does not match my website's language? =

You can change the default language of Easy!Appointments by editing the config.php of your installation.

= Where can I get more help? =

If you encounter issues but you do not know what to do visit the official Easy!Appointments support group where active users help each other solve their problems.

https://groups.google.com/forum/#!categories/easy-appointments

== Changelog ==

= 1.2.0 =
* Support for WordPress 5.x

= 1.1.0 =
* Installation will not try to create a new directory (avoiding permission problems).
* Added minified assets (JS & CSS).
* Enhanced admin UI section.

= 1.0.1 =
* Initial release in WordPress plugin repositories.
* Install, Link, Unlink, Verify and Shortcode operations.
* Shipped with Easy!Appointments v1.1.1
