<?php

function enqueue_styles() {
  wp_enqueue_style( 'main-style', get_stylesheet_directory_uri() . '/assets/stylesheets/onelove.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_styles' );

/**
 * Allow loading of svg images within media library
 */
function custom_upload_mimes ( $existing_mimes=array() ) {
    $existing_mimes['svg'] = 'mime/type';
    return $existing_mimes;
}
add_filter('upload_mimes', 'custom_upload_mimes');
