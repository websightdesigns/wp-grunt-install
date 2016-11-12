<?php
/**
* @package WP_Configure
* @version 0.5
*/
/*
Plugin Name: WP-Configure
Description: This plugin allows you to activate the plugin for new sites to automatically configure the wordpress settings.
Author: WebSight Designs
Version: 0.1
Author URI: http://websightdesigns.com/
License: GPL2
*/

/*
Copyright 2013  WebSight Designs  (email : http://websightdesigns.com/contact/)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Runs when plugin is activated */
register_activation_hook( __FILE__, 'wpconfigure_install' );
function wpconfigure_install() {

	/* set up some default settings */
	wpconfigure_setup_defaults();

    /**
     * Configure apache rewrite rules
     */
    $wp_rewrite_rules = <<< EOD
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
EOD;

	$author_rewrite_rules = <<< EOD
<IfModule mod_rewrite.c>
RewriteCond %{QUERY_STRING} author=\d
RewriteRule ^ /? [L,R=301]
</IfModule>
EOD;

	$includes_rewrite_rules = <<< EOD
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^wp-admin/includes/ - [F,L]
RewriteRule !^wp-includes/ - [S=3]
RewriteRule ^wp-includes/[^/]+\.php$ - [F,L]
RewriteRule ^wp-includes/js/tinymce/langs/.+\.php - [F,L]
RewriteRule ^wp-includes/theme-compat/ - [F,L]
</IfModule>
EOD;

	$xmlrpc_rewrite_rules = <<< EOD
RedirectMatch 404 xmlrpc.php
EOD;

    /**
     * Add our rewrite rules to Apache .htaccess
     */
    wpconfigure_insert_apache_rewrite_rules( $wp_rewrite_rules, 'WordPress' );
    wpconfigure_insert_apache_rewrite_rules( $author_rewrite_rules, 'Block Author URLs' );
    wpconfigure_insert_apache_rewrite_rules( $includes_rewrite_rules, 'Block Includes' );
    wpconfigure_insert_apache_rewrite_rules( $xmlrpc_rewrite_rules, 'Block XML-RPC' );

    # Flush WP_Rewrite
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'wpconfigure_remove' );
function wpconfigure_remove() {
	// remove our rewrite rules from Apache .htaccess
	wpconfigure_remove_apache_rewrite_rules( 'Block Author URLs' );
	wpconfigure_remove_apache_rewrite_rules( 'Block Includes' );
	wpconfigure_remove_apache_rewrite_rules( 'Block XML-RPC' );
}

/**
 * Insert apache rewrite rules
 */
function wpconfigure_insert_apache_rewrite_rules( $rewrite_rules, $marker, $before = '# BEGIN WordPress' ) {
	// get path to htaccess file
	$htaccess_file = get_home_path() . '.htaccess';
	// check if htaccess file exists
	$htaccess_exists = file_exists( $htaccess_file );
	// if htaccess file exists, get htaccess contents
	$htaccess_content = $htaccess_exists ? file_get_contents( $htaccess_file ) : '';
	// remove any previously added rules from htaccess contents, to avoid duplication
	$htaccess_content = preg_replace( "/# BEGIN $marker.*# END $marker\n*/is", '', $htaccess_content );

	// add new rules to htaccess contents
	if ( $before && $rewrite_rules ) {

		$rewrite_rules = is_array( $rewrite_rules ) ? implode( "\n", $rewrite_rules ) : $rewrite_rules;
		$rewrite_rules = trim( $rewrite_rules, "\r\n " );

		if ( $rewrite_rules ) {
			// If no WordPress rules exist in .htaccess
			if ( false === strpos( $htaccess_content, $before ) ) {
				// The new content needs to be inserted at the begining of the file.
				$htaccess_content = "# BEGIN $marker\n$rewrite_rules\n# END $marker\n\n$htaccess_content";
			} else {
				// The new content needs to be inserted before the WordPress rules
				$rewrite_rules = "# BEGIN $marker\n$rewrite_rules\n# END $marker\n\n$before";
				$htaccess_content = str_replace( $before, $rewrite_rules, $htaccess_content );
			}
		}
	}

	// Update the .htaccess file
	return (bool) file_put_contents( $htaccess_file , $htaccess_content );
}

/**
 * Remove apache rewrite rules
 */
function wpconfigure_remove_apache_rewrite_rules( $marker ) {
	// get path to htaccess file
	$htaccess_file = get_home_path() . '.htaccess';
	// check if htaccess file exists
	$htaccess_exists = file_exists( $htaccess_file );
	// if htaccess file exists, get htaccess contents
	$htaccess_content = $htaccess_exists ? file_get_contents( $htaccess_file ) : '';

	// remove the added rules from htaccess contents
	$htaccess_content = preg_replace( "/# BEGIN $marker.*# END $marker\n*/is", '', $htaccess_content );

	// Update the .htaccess file
	return (bool) file_put_contents( $htaccess_file , $htaccess_content );
}

function wpconfigure_setup_defaults() {
	// Get rid of 'Uncategorized' category and replace with 'Blog' as default
	wp_update_term(1, 'category', array(
		'name' => 'Blog',
		'slug' => 'blog',
		'description' => 'Blog'
	));

	// Set avatars to hidden
	update_option( 'show_avatars', 0);

	// Start of the Week
	// 0 is Sunday, 1 is Monday and so on
	update_option( 'start_of_week', 1 );

	// Increase the Size of the Post Editor
	update_option( 'defaultPost_edit_rows', 40 );

	// Enable comment moderation
	update_option( 'comment_moderation', 1 );

	/** Before a comment appears the comment author must have a previously approved comment: false */
	update_option( 'comment_whitelist', 0 );

	/** Allow people to post comments on new articles (this setting may be overridden for individual articles): false */
	update_option( 'default_comment_status', 0 );

	// Disable Smilies
	update_option( 'use_smilies', 0 );

	// // Don't Organize Uploads by Date
	// update_option( 'uploads_use_yearmonth_folders', 0 );

	// // Update Permalinks
	// update_option( 'selection','custom' );
	// update_option( 'permalink_structure','/%postname%/' );
}

// Hide welcome panels (doesn't seem to work often)
update_user_meta( 1, 'show_welcome_panel', 0 );

// Remove the default dashboard widgets
add_action('admin_init', 'wpconfigure_remove_dashboard_meta');
function wpconfigure_remove_dashboard_meta() {
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); // Removes the 'incoming links' widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); // Removes the 'plugins' widget
	remove_meta_box('dashboard_primary', 'dashboard', 'normal'); // Removes the 'WordPress News' widget
	remove_meta_box('dashboard_secondary', 'dashboard', 'normal'); // Removes the secondary widget
	remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); // Removes the 'Quick Draft' widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); // Removes the 'Recent Drafts' widget
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Removes the 'Activity' widget
	remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); // Removes the 'At a Glance' widget
	remove_meta_box('dashboard_activity', 'dashboard', 'normal'); // Removes the 'Activity' widget (since 3.8)
}

// Display a dashboard widget with my own welcome message
function wpconfigure_dashboard_widget_function() {
	echo '<p>Welcome to your new wordpress website.</p>
	<p>Wordpress is a powerful platform for you to manage your content.</p>
	<p>Use the links to the left to manage parts of your site.</p>
	<p>If you need technical support, please <a href="post-new.php?post_type=ticket" target="_blank">submit a support ticket</a>.</p>';
}

// Create the dashboard widget above so it can be selected
add_action('wp_dashboard_setup', 'wpconfigure_add_dashboard_widgets' );
function wpconfigure_add_dashboard_widgets() {
	wp_add_dashboard_widget('wpconfigure_dashboard_widget', 'Welcome To Your Wordpress CMS', 'wpconfigure_dashboard_widget_function');
}
