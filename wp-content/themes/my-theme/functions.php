<?php
/**
 * my_theme functions and definitions
 *
 * @package my_theme
 */

/**
 * Include plugin.php, used to check if plugins are currently activated
 */
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'my_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function my_theme_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on my_theme, use a find and replace
	 * to change 'my_theme' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'my_theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// Declare the dimensions of our Post Thumbnail.
	set_post_thumbnail_size( 215, 215, array( 'center', 'center') );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'my_theme' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'my_theme_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // my_theme_setup
add_action( 'after_setup_theme', 'my_theme_setup' );

/**
 * Register widget areas.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
add_action( 'widgets_init', 'my_theme_widgets_init' );
if ( ! function_exists( 'my_theme_widgets_init' ) ) :
	function my_theme_widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Sidebar', 'my_theme' ),
			'id'            => 'sidebar-1',
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name' => 'Footer Left',
			'id' => 'footer-sidebar-1',
			'description' => 'Appears in the footer area',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => 'Footer Center',
			'id' => 'footer-sidebar-2',
			'description' => 'Appears in the footer area',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => 'Footer Right',
			'id' => 'footer-sidebar-3',
			'description' => 'Appears in the footer area',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => 'Footer Full Width Above',
			'id' => 'footer-sidebar-4',
			'description' => 'Appears in the footer area',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => 'Footer Full Width Below',
			'id' => 'footer-sidebar-5',
			'description' => 'Appears in the footer area',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}
endif;

/**
 * Enqueue scripts and styles.
 */
add_action( 'wp_enqueue_scripts', 'my_theme_scripts' );
if ( ! function_exists( 'my_theme_scripts' ) ) :
	function my_theme_scripts() {
		$port_pos = strpos($_SERVER['HTTP_HOST'], ":");
		if($port_pos === false) {
			$host_parts = array($_SERVER['HTTP_HOST']);
		} else {
			$host_parts = explode(":", $_SERVER['HTTP_HOST']);
		}
		$current_host = $host_parts[0];
		$tld_list = array(
			'.localhost',
			'.local',
			'.dev'
		);
		$host_arr = explode('.', $current_host);
		$current_tld = '.' . $host_arr[count($host_arr) - 1];
		if ( $current_host == 'localhost' || in_array($current_tld, $tld_list) ) $hostname_match = true;
		else $hostname_match = false;

		// Enqueue the theme stylesheet
		if($hostname_match) {
			wp_enqueue_style( 'my_theme-style', get_template_directory_uri() . '/style.css', array(), '1.0' );
		} else {
			wp_enqueue_style( 'my_theme-style', get_template_directory_uri() . '/style.min.css', array(), '1.0' );
		}

		// Enqueue the theme javascript
		if($hostname_match) {
			wp_enqueue_script( 'my_theme-script', get_template_directory_uri() . '/js/script.js', array(), '3.1.1', array( 'colorbox' ) );
		} else {
			wp_enqueue_script( 'my_theme-script', get_template_directory_uri() . '/js/script.min.js', array(), '3.1.1', array( 'colorbox' ) );
		}
	}
	endif;

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Hide the admin bar
 */
add_filter('show_admin_bar', '__return_false');

/**
 * remove _admin_bar_bump_cb() from wp_head()
 * removes the margin-top added to the html element
 */
add_action('get_header', 'my_filter_head');
if ( ! function_exists( 'my_filter_head' ) ) :
	function my_filter_head() {
		remove_action('wp_head', '_admin_bar_bump_cb');
	}
endif;

/**
 * Redirect to home page on logout
 */
add_action('wp_logout','go_home');
if ( ! function_exists( 'go_home' ) ) :
	function go_home() {
	  wp_redirect( home_url() );
	  exit();
	}
endif;

/**
 * Remove the excess markup from the <head> tag
 */
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

/**
* Disable update notifications
*/
// add_filter('pre_site_transient_update_core','remove_core_updates');
// add_filter('pre_site_transient_update_plugins','remove_core_updates');
// add_filter('pre_site_transient_update_themes','remove_core_updates');
// if ( ! function_exists( 'remove_core_updates' ) ) :
//     function remove_core_updates(){
//       global $wp_version;
//       return(object) array(
//         'last_checked' => time(),
//         'version_checked'=> $wp_version,
//         );
//     }
// endif;

/**
* Media Library: File type sections
*/
add_filter( 'post_mime_types', 'modify_post_mime_types' );
if ( ! function_exists( 'modify_post_mime_types' ) ) :
	function modify_post_mime_types( $post_mime_types ) {
	  // select the mime type, here: 'application/pdf'
	  // then we define an array with the label values
	  $post_mime_types['application/pdf'] = array( __( 'PDFs', 'my_theme' ), __( 'Manage PDFs', 'SKEL_THEME_PREFIX' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );
	  // then we return the $post_mime_types variable
	  return $post_mime_types;
	}
endif;

/**
 * Fixing a style conflict between the Floating Publish Button plugin and Advanced Custom Fields
 */
// if ( is_plugin_active('floating-publish-button/index.php') ) {
// 	if( is_plugin_active('advanced-custom-fields-pro/acf.php') || is_plugin_active('advanced-custom-fields/acf.php') ) {
// 		add_action( 'admin_head-post.php', 'edit_post_style' );
// 		function edit_post_style() {
// 			echo '
// 			<style>
// 			   .metabox-holder .postbox-container .empty-container {
// 				  border: 0 !important;
// 			  }
// 		  </style>
// 		  ';
// 	  }
//   }
// }

/*
 * Change the search URL to pretty format
 */
if ( ! function_exists( 'special_nav_class' ) ) :
	add_action( 'template_redirect', 'my_theme_change_search_url_rewrite' );
	function my_theme_change_search_url_rewrite() {
		if ( get_option('permalink_structure') != '' && is_search() && ! empty( $_GET['s'] ) ) {
			wp_redirect( home_url( "/search/" ) . urlencode( get_query_var( 's' ) ) );
			exit();
		}
	}
endif;

/*
 * Show no posts on empty search
 */
if ( ! function_exists( 'special_nav_class' ) ) :
	add_filter('pre_get_posts','my_theme_search_filter');
	function my_theme_search_filter($query) {
		// If 's' request variable is set but empty
		if (isset($_GET['s']) && empty($_GET['s']) && $query->is_main_query()){
			$query->is_search = true;
			$query->is_home = false;
		}
		return $query;
	}
endif;

/**
 * Set up the posts column in Users table to not be sortable
 */
// add_filter( 'manage_users_sortable_columns', 'my_theme_sortable_user_table_column' );
// function my_theme_sortable_user_table_column( $columns ) {
//  // To make a column 'un-sortable' remove it from the array
//  unset($columns['posts']);
//  return $columns;
// }

/**
 * Remove the automatic '<p>' tags around the content
 */
// remove_filter('the_content', 'wpautop');

/**
 * Remove the automatic '<p>' tags around the excerpt
 */
// remove_filter('the_excerpt', 'wpautop');

/* disable comments on pages, but not posts */
if ( ! function_exists( 'custometheme_disable_comments_on_pages' ) ) {
	function custometheme_disable_comments_on_pages( $file ) {
		return is_page() ? __FILE__ : $file;
	}
	add_filter( 'comments_template', 'custometheme_disable_comments_on_pages', 11 );
}

/* ******************************************************************** */
/*                   COMMENTS AND POSTS IN USERS TABLE                  */
/* ******************************************************************** */

/**
 * Add a comments column to the users table, and set both comments and posts
 * to be sortable
 */

/**
 * Display comments count in custom column of the Users table
 */
add_filter( 'manage_users_columns', 'my_theme_modify_user_table' );
if ( ! function_exists( 'my_theme_modify_user_table' ) ) :
	function my_theme_modify_user_table( $column ) {
		$column['comments'] = 'Comments';
		return $column;
	}
endif;

add_filter( 'manage_users_custom_column', 'my_theme_modify_user_table_row', 10, 3 );
if ( ! function_exists( 'my_theme_modify_user_table_row' ) ) :
	function my_theme_modify_user_table_row( $val, $column_name, $user_id ) {
		$user = get_userdata( $user_id );
		switch ($column_name) {
			case 'comments' :
		 global $wpdb;
		 $sql_query = 'SELECT COUNT(comment_ID) FROM ' . $wpdb->comments. ' WHERE user_id = "' . $user_id . '"';
		 $count = $wpdb->get_var($sql_query);
		 return $count;
		 break;
		 default:
	 }
	 return $return;
	}
endif;

add_action( 'admin_head-users.php', 'my_theme_users_table_style' );
if ( ! function_exists( 'my_theme_users_table_style' ) ) :
	function my_theme_users_table_style() {
		?><style>
	.fixed .column-comments {
		width: 7.5em;
	}
</style>
	<?php
	}
endif;

/**
 * Set up posts and comments columns in Users table to be sortable
 */
add_filter( 'manage_users_sortable_columns', 'my_theme_sortable_user_table_column' );
if ( ! function_exists( 'my_theme_sortable_user_table_column' ) ) :
	function my_theme_sortable_user_table_column( $columns ) {
		$columns['posts'] = 'posts';
		$columns['comments'] = 'comments';
		return $columns;
	}
endif;

/* ******************************************************************** */
/*                      BOOTSTRAP CUSTOMIZATIONS                        */
/* ******************************************************************** */

/**
 * Add the bootstrap menu navwalker
 */
require_once('wp_bootstrap_navwalker.php');

/**
 * Add 'active' class to active menu list item
 */
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
if ( ! function_exists( 'special_nav_class' ) ) :
	function special_nav_class($classes, $item){
		if( in_array('current-menu-item', $classes) ){
			$classes[] = 'active ';
		}
		return $classes;
	}
endif;

/**
 * Remove the automatic '<p>' tags around '<button>' tags
 */
add_filter('the_content', 'filter_ptags_on_buttons');
if ( ! function_exists( 'filter_ptags_on_buttons' ) ) :
	function filter_ptags_on_buttons($content) {
		$content = str_ireplace('</button></p>', '</button>', $content);
		return str_ireplace('<p><button', '<button', $content);
	}
endif;

/**
 * Remove unwanted '<br>' tags from inside of '<form>' tags
 */
add_filter('the_content', 'remove_bad_br_tags');
if ( ! function_exists( 'remove_bad_br_tags' ) ) :
	function remove_bad_br_tags($content) {
		$content = str_ireplace("</label>\n<br />", "</label>", $content);
		$content = str_ireplace("</label><br />", "</label>", $content);
		$content = str_ireplace("</button>\n<br />", "</button>", $content);
		$content = str_ireplace("</button><br />", "</button>", $content);
		return $content;
	}
endif;

/**
 * Remove dns-prefetch tag
 */
add_filter( 'emoji_svg_url', '__return_false' ); // <link rel='dns-prefetch' href='//s.w.org'>

/**
 * Remove wp-emoji
 */
add_action( 'init', 'gatescarbondrive_disable_wp_emojicons' );
function gatescarbondrive_disable_wp_emojicons() {
	// all actions related to emojis
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	// filter to remove TinyMCE emojis
	add_filter( 'tiny_mce_plugins', 'gatescarbondrive_disable_emojicons_tinymce' );
}
function gatescarbondrive_disable_emojicons_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Remove the wp-includes/js/wp-embed.min.js script (we will include in our grunt build instead)
 */
add_action( 'wp_footer', 'gatescarbondrive_deregister_scripts' );
function gatescarbondrive_deregister_scripts(){
	wp_dequeue_script( 'wp-embed' );
}
