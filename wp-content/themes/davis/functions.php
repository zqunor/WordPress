<?php

/* THEME SETUP
------------------------------------------------ */

function davis_setup() {
	
	// Automatic feed
	add_theme_support( 'automatic-feed-links' );
	
	// Set content-width
	global $content_width;
	if ( ! isset( $content_width ) ) $content_width = 620;
	
	// Post thumbnails
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'post-image', 620, 9999 );
	
	// Title tag
	add_theme_support( 'title-tag' );
	
	// Post formats
	add_theme_support( 'post-formats', array( 'aside' ) );
	
	// Add nav menu
	register_nav_menu( 'primary-menu', __( 'Primary Menu', 'davis' ) );
	
	// Make the theme translation ready
	load_theme_textdomain( 'davis', get_template_directory() . '/languages' );
	
	$locale_file = get_template_directory() . "/languages/" . get_locale();
    
	if ( is_readable( $locale_file ) ) {
        require_once( $locale_file );
    }
	
}
add_action( 'after_setup_theme', 'davis_setup' );


/* ENQUEUE STYLES
------------------------------------------------ */

function davis_load_style() {
	if ( ! is_admin() ) {
        wp_register_style( 'davis_fonts', '//fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic' );
        wp_enqueue_style( 'davis_style', get_stylesheet_uri(), array( 'davis_fonts' ) );
    } 
}
add_action( 'wp_print_styles', 'davis_load_style' );


/* ENQUEUE COMMENT-REPLY.JS
------------------------------------------------ */

function davis_load_scripts(){
    if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_print_scripts', 'davis_load_scripts' );


?>