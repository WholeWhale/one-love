<?php

function enqueue_styles() {
  wp_enqueue_style( 'main-style', get_stylesheet_directory_uri() . '/assets/stylesheets/onelove.css' );
}

add_action( 'wp_enqueue_scripts', 'enqueue_styles' );

function register_post_types() {
  foreach (glob(get_stylesheet_directory() . '/post_types/*.type.php') as $type) {
    $typeName = basename($type, '.type.php') . '_post_type';
    $definition = include $type;
    register_post_type($typeName, $definition);
  }
}

add_action('init', 'register_post_types');
