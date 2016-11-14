<?php
/**
 * Theme Customizer
 *
 * @package SKEL_THEME_PREFIX
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
add_action( 'customize_register', 'SKEL_THEME_PREFIX_customize_register' );
function SKEL_THEME_PREFIX_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
add_action( 'customize_preview_init', 'SKEL_THEME_PREFIX_customize_preview_js' );
function SKEL_THEME_PREFIX_customize_preview_js() {
	wp_enqueue_script( 'SKEL_THEME_PREFIX_customizer', get_template_directory_uri() . '/js/theme/customizer.js', array( 'customize-preview' ), '20130508', true );
}

/**
 * Custom theme logo
 */
add_action( 'customize_register', 'SKEL_THEME_PREFIX_theme_customizer' );
function SKEL_THEME_PREFIX_theme_customizer( $wp_customize ) {
	// create a new section for our logo
	$wp_customize->add_section( 'SKEL_THEME_PREFIX_logo_section' , array(
	    'title'       => __( 'Logo', 'SKEL_THEME_PREFIX' ),
	    'priority'    => 30,
	    'description' => 'Upload a logo to replace the default site name and description in the header',
	) );

	// register the new setting
	$wp_customize->add_setting( 'SKEL_THEME_PREFIX_logo' );

	// use an image uploader
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'SKEL_THEME_PREFIX_logo', array(
	    'label'    => __( 'Logo', 'SKEL_THEME_PREFIX' ),
	    'section'  => 'SKEL_THEME_PREFIX_logo_section',
	    'settings' => 'SKEL_THEME_PREFIX_logo',
	) ) );
}
