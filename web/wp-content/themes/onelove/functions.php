<?php

function enqueue_assets() {
  wp_enqueue_style( 'main-style', get_stylesheet_directory_uri() . '/assets/stylesheets/onelove.css' );
  wp_enqueue_script( 'main-js', get_stylesheet_directory_uri() . '/assets/javascript/onelove.js', array('jquery'), '2.9.0', true);
}
add_action( 'wp_enqueue_scripts', 'enqueue_assets' );

/**
 * Allow loading of svg images within media library
 */
function custom_upload_mimes ( $existing_mimes=array() ) {
    $existing_mimes['svg'] = 'mime/type';
    return $existing_mimes;
}
add_filter('upload_mimes', 'custom_upload_mimes');

function register_post_types() {
  foreach (glob(get_stylesheet_directory() . '/post_types/*.type.php') as $type) {
    $typeName = basename($type, '.type.php') . '_post_type';
    $definition = include $type;
    register_post_type($typeName, $definition);
  }
}
add_action('init', 'register_post_types');

function update_admin_menu_pos() {
    global $menu;
    $post_types = array( 5 => 'Posts', 25 => 'Comments' );
    $new_position = 50;
    foreach ($post_types as $key => $value) {
      $copy = $menu[$key];
      unset( $menu[$key] );
      $menu[$new_position] = $copy;
      $new_position++;
    }
}
add_action( 'admin_menu', 'update_admin_menu_pos');

function remove_bloat_assets() {
  wp_dequeue_style('main-stylesheet');
  wp_dequeue_script('foundation');
}
add_action('wp_enqueue_scripts', 'remove_bloat_assets', 100);

/**
 * having a version number attached to files is a cache-buster. No need for a
 * cache-buster for development when FF and Chrome already have cache-busting
 * capabilities. 
 */
function remove_assets_version_num( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
// Remove WP Version From Styles
add_filter( 'style_loader_src', 'remove_assets_version_num', 9999 );
// Remove WP Version From Scripts
add_filter( 'script_loader_src', 'remove_assets_version_num', 9999 );
