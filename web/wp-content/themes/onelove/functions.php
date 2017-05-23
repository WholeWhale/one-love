<?php

function enqueue_styles() {
  wp_enqueue_style( 'main-style', get_stylesheet_directory_uri() . '/assets/stylesheets/onelove.css' );
}

add_action( 'wp_enqueue_scripts', 'enqueue_styles' );
