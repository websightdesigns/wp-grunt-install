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
