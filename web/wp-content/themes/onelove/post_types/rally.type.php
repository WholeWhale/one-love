<?php
/**
 * Rally Post Type
 */
$labels = array(
	'name'                  => _x( 'Rally', 'Post Type General Name', 'text_domain' ),
	'singular_name'         => _x( 'Rally', 'Post Type Singular Name', 'text_domain' ),
	'menu_name'             => __( 'Rally', 'text_domain' ),
	'name_admin_bar'        => __( 'Rally', 'text_domain' ),
	'archives'              => __( 'Rally Archives', 'text_domain' ),
	'attributes'            => __( 'Rally Attributes', 'text_domain' ),
	'parent_item_colon'     => __( 'Parent Rally:', 'text_domain' ),
	'all_items'             => __( 'All Rally', 'text_domain' ),
	'add_new_item'          => __( 'Add New Rally', 'text_domain' ),
	'add_new'               => __( 'Add New', 'text_domain' ),
	'new_item'              => __( 'New Rally', 'text_domain' ),
	'edit_item'             => __( 'Edit Rally', 'text_domain' ),
	'update_item'           => __( 'Update Rally', 'text_domain' ),
	'view_item'             => __( 'View Rally', 'text_domain' ),
	'view_items'            => __( 'View Rally', 'text_domain' ),
	'search_items'          => __( 'Search Rally', 'text_domain' ),
	'not_found'             => __( 'Not found', 'text_domain' ),
	'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
	'featured_image'        => __( 'Featured Image', 'text_domain' ),
	'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
	'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
	'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
	'insert_into_item'      => __( 'Insert into Rally', 'text_domain' ),
	'uploaded_to_this_item' => __( 'Uploaded to this Rally', 'text_domain' ),
	'items_list'            => __( 'Rally list', 'text_domain' ),
	'items_list_navigation' => __( 'Rally list navigation', 'text_domain' ),
	'filter_items_list'     => __( 'Filter Rally list', 'text_domain' ),
);

$rewrite = array(
  'slug'                  => 'rally',
  'with_front'            => true,
  'pages'                 => true,
  'feeds'                 => true,
);

$args = array(
	'label'                 => __( 'Rally', 'text_domain' ),
	'description'           => __( 'Post Type for Rally', 'text_domain' ),
	'labels'                => $labels,
	'supports'              => array( 'title', 'editor', 'thumbnail',  ),
	'taxonomies'            => array( 'category' ),
	'hierarchical'          => false,
	'public'                => true,
	'show_ui'               => true,
	'show_in_menu'          => true,
	'menu_position'         => 6,
	'menu_icon'             => 'dashicons-universal-access',
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
