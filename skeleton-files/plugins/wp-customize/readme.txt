=== WP Customize ===
Contributors: websightdesigns
Donate link: http://www.websightdesigns.com/
Tags: admin, customize, login logo, admin footer, custom login, login page, custom page, footer
Requires at least: 3.5
Tested up to: 4.3.1
Stable tag: 1.0.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows you to set up a custom login page, and set a custom footer message in the WordPress Admin.

== Description ==

This plugin allows you to set up a custom login page, including your logo. It also allows you to set a custom footer by adding in your own text or HTML.

* Allows you to specify a URL to an image you'd like to use as your Wordpress Admin login page's logo.
* Allows you to specify your own text and/or HTML to replace the footer of the Wordpress Admin with.
* Sets the URL of your blog as the URL visited when a user clicks the logo on the Wordpress Admin login page.
* Sets the title (seen when you hover your mouse over the logo) of the logo's link to be your blog's name.
* Allows you to specify the background color and the text/links color of the Wordpress Admin login page.

`Please be sure and rate this plugin! Thanks!`

== Installation ==

1. Upload the `wp-customize` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Fill out the settings under `SETTINGS > CUSTOMIZE` in the WordPress Admin

== Frequently Asked Questions ==

= Has this plugin been tested on WordPress version 4.0? =

Yes, and there were no known issues that we found with it. It's a pretty simple plugin but if you should come across a problem just let us know.

= Has this plugin been tested on WordPress version 4.1? =

Yes, and there were no known issues that we found with it.

= Has this plugin been tested on WordPress version 4.2? =

Yes, and there were no known issues that we found with it.

= Has this plugin been tested on WordPress version 4.3? =

Yes, and there were no known issues that we found with it.

== Screenshots ==

1. A screenshot of the Settings page
2. A screenshot of a customized login page

== Changelog ==

= 1.0.8 =
* Fixes the redirect when auto redirect is unchecked. Uses minified versions of js and css files.

= 1.0.7 =
* Fixes custom CSS not parsing on login page template.

= 1.0.6 =
* Fixes path issues with htaccess rules.

= 1.0.5 =
* Fixes path issues with require_once() methods.

= 1.0.4 =
* Just fixing repository commit issues.

= 1.0.3 =
* Just fixing repository commit issues.

= 1.0.2 =
* Add ability to show/hide the Register, Lost Password and Back links.
* Allow register and lostpassword links through.
* Show the custom logo on the default WordPress login page.
* Fixes the media upload buttons and improves their functionality.

= 1.0.1 =
* Fix upload buttons styles in responsive mode

= 1.0 =
* Custom page template for the login page
* Redirect to custom page template from wp-login.php
* Option to set page title on custom login page template
* Option to set the URL for the logo image link on the login page

= 0.9 =
* Only change the default logo when a URL to an alternative logo image is entered.
* Added more colors to the color picker pallette.
* Option to hide the "Register" and "Lost your password?" links from the WP-Admin login form.
* Option to hide the "Back to <site name>" link from the WP-Admin login form.
* Option to check the "Remember me" checkbox by default.
* Option to remove the "login shake" from the login form.
* Option to set a custom login error message. If no error message is entered, sets it to "Incorrect login details. Please try again.".

= 0.8 =
* Fixes SVN issues.

= 0.7 =
* Added a slightly modified version of Spectrum color picker version 1.7.0 (forked from from https://bgrins.github.io/spectrum/)

= 0.6 =
* Removed Spectrum color picker

= 0.5 =
* Added Spectrum color picker version 1.7.0 from https://bgrins.github.io/spectrum/

= 0.4 =
* Added a field to enter custom CSS for the login page.
* Modified the label text and text input sizes.

= 0.3 =
* Modified the markup for the sub-section headers in the Customize page found under the Settings section of the WordPress admin to make it more obvious there are different sections.
* Tested the plugin with WordPress version 4.0 and found no problems.

= 0.2 =
* This version adds the option to set the width of the logo area.

= 0.1 =
* This is the first version of this plugin. There will very likely be enhancements to it as time goes on, so feel free to let us know how we could improve it!

== Upgrade Notice ==

= 0.5 =
This version adds color picker widgets to easily select RGB color codes.