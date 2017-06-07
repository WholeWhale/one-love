<?php
/**
 * Campaign Post Type
 */
$labels = array(
	'name'                  => _x( 'Campaigns', 'Post Type General Name', 'text_domain' ),
	'singular_name'         => _x( 'Campaign', 'Post Type Singular Name', 'text_domain' ),
	'menu_name'             => __( 'Campaigns', 'text_domain' ),
	'name_admin_bar'        => __( 'Campaign', 'text_domain' ),
	'archives'              => __( 'Campaign Archives', 'text_domain' ),
	'attributes'            => __( 'Campaign Attributes', 'text_domain' ),
	'parent_item_colon'     => __( 'Parent Campaign:', 'text_domain' ),
	'all_items'             => __( 'All Campaigns', 'text_domain' ),
	'add_new_item'          => __( 'Add New Campaign', 'text_domain' ),
	'add_new'               => __( 'Add New', 'text_domain' ),
	'new_item'              => __( 'New Campaign', 'text_domain' ),
	'edit_item'             => __( 'Edit Campaign', 'text_domain' ),
	'update_item'           => __( 'Update Campaign', 'text_domain' ),
	'view_item'             => __( 'View Campaign', 'text_domain' ),
	'view_items'            => __( 'View Campaign', 'text_domain' ),
	'search_items'          => __( 'Search Campaigns', 'text_domain' ),
	'not_found'             => __( 'Not found', 'text_domain' ),
	'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
	'featured_image'        => __( 'Featured Image', 'text_domain' ),
	'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
	'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
	'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
	'insert_into_item'      => __( 'Insert into Campaign', 'text_domain' ),
	'uploaded_to_this_item' => __( 'Uploaded to this Campaign', 'text_domain' ),
	'items_list'            => __( 'Campaigns list', 'text_domain' ),
	'items_list_navigation' => __( 'Campaigns list navigation', 'text_domain' ),
	'filter_items_list'     => __( 'Filter Campaigns list', 'text_domain' ),
);

$rewrite = array(
  'slug'                  => 'act',
  'with_front'            => true,
  'pages'                 => true,
  'feeds'                 => true,
);

$args = array(
	'label'                 => __( 'Campaign', 'text_domain' ),
	'description'           => __( 'Post Type for Campaigns', 'text_domain' ),
	'labels'                => $labels,
	'supports'              => array( 'title', 'editor','thumbnail',),
	'taxonomies'            => array( ),
	'hierarchical'          => false,
	'public'                => true,
	'show_ui'               => true,
	'show_in_menu'          => true,
	'menu_position'         => 4,
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
