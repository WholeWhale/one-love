<?php
/**
 * Program Post Type
 */
$labels = array(
	'name'                  => _x( 'Programs', 'Post Type General Name', 'text_domain' ),
	'singular_name'         => _x( 'Program', 'Post Type Singular Name', 'text_domain' ),
	'menu_name'             => __( 'Programs', 'text_domain' ),
	'name_admin_bar'        => __( 'Program', 'text_domain' ),
	'archives'              => __( 'Program Archives', 'text_domain' ),
	'attributes'            => __( 'Program Attributes', 'text_domain' ),
	'parent_item_colon'     => __( 'Parent Program:', 'text_domain' ),
	'all_items'             => __( 'All Programs', 'text_domain' ),
	'add_new_item'          => __( 'Add New Program', 'text_domain' ),
	'add_new'               => __( 'Add New', 'text_domain' ),
	'new_item'              => __( 'New Program', 'text_domain' ),
	'edit_item'             => __( 'Edit Program', 'text_domain' ),
	'update_item'           => __( 'Update Program', 'text_domain' ),
	'view_item'             => __( 'View Program', 'text_domain' ),
	'view_items'            => __( 'View Program', 'text_domain' ),
	'search_items'          => __( 'Search Program', 'text_domain' ),
	'not_found'             => __( 'Not found', 'text_domain' ),
	'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
	'featured_image'        => __( 'Featured Image', 'text_domain' ),
	'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
	'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
	'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
	'insert_into_item'      => __( 'Insert into Program', 'text_domain' ),
	'uploaded_to_this_item' => __( 'Uploaded to this Program', 'text_domain' ),
	'items_list'            => __( 'Programs list', 'text_domain' ),
	'items_list_navigation' => __( 'Programs list navigation', 'text_domain' ),
	'filter_items_list'     => __( 'Filter Programs list', 'text_domain' ),
);

$args = array(
	'label'                 => __( 'Program', 'text_domain' ),
	'description'           => __( 'Post Type for Programs', 'text_domain' ),
	'labels'                => $labels,
	'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'page-attributes', 'post-formats', ),
	'taxonomies'            => array( ),
	'hierarchical'          => false,
	'public'                => true,
	'show_ui'               => true,
	'show_in_menu'          => true,
	'menu_position'         => 5,
	'menu_icon'             => 'dashicons-book-alt',
	'show_in_admin_bar'     => true,
	'show_in_nav_menus'     => true,
	'can_export'            => true,
	'has_archive'           => true,
	'exclude_from_search'   => false,
	'publicly_queryable'    => true,
	'rewrite'             => array('slug' => 'programs'),
	'capability_type'       => 'page',
);

return $args;
