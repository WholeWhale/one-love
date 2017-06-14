<?php
/**
 * Conversation Starters Post Type
 */
$labels = array(
	'name'                  => _x( 'Conversation Starters', 'Post Type General Name', 'text_domain' ),
	'singular_name'         => _x( 'Conversation Starters', 'Post Type Singular Name', 'text_domain' ),
	'menu_name'             => __( 'Conversation Starters', 'text_domain' ),
	'name_admin_bar'        => __( 'Conversation Starters', 'text_domain' ),
	'archives'              => __( 'Conversation Starters Archives', 'text_domain' ),
	'attributes'            => __( 'Conversation Starters Attributes', 'text_domain' ),
	'parent_item_colon'     => __( 'Parent Conversation Starters:', 'text_domain' ),
	'all_items'             => __( 'All Conversation Starters', 'text_domain' ),
	'add_new_item'          => __( 'Add New Conversation Starters', 'text_domain' ),
	'add_new'               => __( 'Add New', 'text_domain' ),
	'new_item'              => __( 'New Conversation Starters', 'text_domain' ),
	'edit_item'             => __( 'Edit Conversation Starters', 'text_domain' ),
	'update_item'           => __( 'Update Conversation Starters', 'text_domain' ),
	'view_item'             => __( 'View Conversation Starters', 'text_domain' ),
	'view_items'            => __( 'View Conversation Starters', 'text_domain' ),
	'search_items'          => __( 'Search Conversation Starters', 'text_domain' ),
	'not_found'             => __( 'Not found', 'text_domain' ),
	'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
	'featured_image'        => __( 'Featured Image', 'text_domain' ),
	'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
	'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
	'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
	'insert_into_item'      => __( 'Insert into Conversation Starters', 'text_domain' ),
	'uploaded_to_this_item' => __( 'Uploaded to this Conversation Starters', 'text_domain' ),
	'items_list'            => __( 'Conversation Starters list', 'text_domain' ),
	'items_list_navigation' => __( 'Conversation Starters list navigation', 'text_domain' ),
	'filter_items_list'     => __( 'Filter Conversation Starters list', 'text_domain' ),
);

$rewrite = array(
  'slug'                  => 'start',
  'with_front'            => true,
  'pages'                 => true,
  'feeds'                 => true,
);

$args = array(
	'label'                 => __( 'Conversation Starters', 'text_domain' ),
	'description'           => __( 'Post Type for Conversation Starters', 'text_domain' ),
	'labels'                => $labels,
	'supports'              => array( 'title', 'editor','thumbnail',),
	'taxonomies'            => array( 'category' ),
	'hierarchical'          => false,
	'public'                => true,
	'show_ui'               => true,
	'show_in_menu'          => true,
	'menu_position'         => 21,
	'menu_icon'             => 'dashicons-admin-site',
	'show_in_admin_bar'     => true,
	'show_in_nav_menus'     => true,
	'can_export'            => true,
	'has_archive'           => true,
	'exclude_from_search'   => false,
	'publicly_queryable'    => true,
	'rewrite'               => $rewrite,
	'capability_type'       => 'page',
);

return $args;
