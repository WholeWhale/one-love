<?php
/**
 * News Post Type
 */
$labels = array(
	'name'                  => _x( 'News and Press', 'Post Type General Name', 'text_domain' ),
	'singular_name'         => _x( 'News and Press', 'Post Type Singular Name', 'text_domain' ),
	'menu_name'             => __( 'News and Press', 'text_domain' ),
	'name_admin_bar'        => __( 'News and Press', 'text_domain' ),
	'archives'              => __( 'News and Press Archives', 'text_domain' ),
	'attributes'            => __( 'News and Press Attributes', 'text_domain' ),
	'parent_item_colon'     => __( 'Parent News and Press:', 'text_domain' ),
	'all_items'             => __( 'All News and Press', 'text_domain' ),
	'add_new_item'          => __( 'Add New News and Press', 'text_domain' ),
	'add_new'               => __( 'Add New', 'text_domain' ),
	'new_item'              => __( 'New News and Press', 'text_domain' ),
	'edit_item'             => __( 'Edit News and Press', 'text_domain' ),
	'update_item'           => __( 'Update News and Press', 'text_domain' ),
	'view_item'             => __( 'View News and Press', 'text_domain' ),
	'view_items'            => __( 'View News and Press', 'text_domain' ),
	'search_items'          => __( 'Search News and Press', 'text_domain' ),
	'not_found'             => __( 'Not found', 'text_domain' ),
	'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
	'featured_image'        => __( 'Featured Image', 'text_domain' ),
	'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
	'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
	'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
	'insert_into_item'      => __( 'Insert into News and Press', 'text_domain' ),
	'uploaded_to_this_item' => __( 'Uploaded to this News and Press', 'text_domain' ),
	'items_list'            => __( 'News and Press list', 'text_domain' ),
	'items_list_navigation' => __( 'News and Press list navigation', 'text_domain' ),
	'filter_items_list'     => __( 'Filter News and Press list', 'text_domain' ),
);

$rewrite = array(
  'slug'                  => 'news',
  'with_front'            => true,
  'pages'                 => true,
  'feeds'                 => true,
);

$args = array(
	'label'                 => __( 'News and Press', 'text_domain' ),
	'description'           => __( 'Post Type for News and Press', 'text_domain' ),
	'labels'                => $labels,
	'supports'              => array( 'title', 'editor', 'thumbnail', ),
	'taxonomies'            => array(  ),
	'hierarchical'          => false,
	'public'                => true,
	'show_ui'               => true,
	'show_in_menu'          => true,
	'menu_position'         => 27,
	'menu_icon'             => 'dashicons-megaphone',
	'show_in_admin_bar'     => true,
	'show_in_nav_menus'     => true,
	'can_export'            => true,
	'has_archive'           => false,
	'exclude_from_search'   => false,
	'publicly_queryable'    => true,
	'rewrite'               => $rewrite,
	'capability_type'       => 'page',
);

return $args;
