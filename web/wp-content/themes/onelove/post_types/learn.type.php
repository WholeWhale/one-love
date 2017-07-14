<?php
/**
 * Learn Post Type
 */
$labels = array(
	'name'                  => _x( 'Learn', 'Post Type General Name', 'text_domain' ),
	'singular_name'         => _x( 'Learn', 'Post Type Singular Name', 'text_domain' ),
	'menu_name'             => __( 'Learn', 'text_domain' ),
	'name_admin_bar'        => __( 'Learn', 'text_domain' ),
	'archives'              => __( 'Learn Archives', 'text_domain' ),
	'attributes'            => __( 'Learn Attributes', 'text_domain' ),
	'parent_item_colon'     => __( 'Parent Learn:', 'text_domain' ),
	'all_items'             => __( 'All Learn', 'text_domain' ),
	'add_new_item'          => __( 'Add New Learn', 'text_domain' ),
	'add_new'               => __( 'Add New', 'text_domain' ),
	'new_item'              => __( 'New Learn', 'text_domain' ),
	'edit_item'             => __( 'Edit Learn', 'text_domain' ),
	'update_item'           => __( 'Update Learn', 'text_domain' ),
	'view_item'             => __( 'View Learn', 'text_domain' ),
	'view_items'            => __( 'View Learn', 'text_domain' ),
	'search_items'          => __( 'Search Learn', 'text_domain' ),
	'not_found'             => __( 'Not found', 'text_domain' ),
	'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
	'featured_image'        => __( 'Featured Image', 'text_domain' ),
	'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
	'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
	'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
	'insert_into_item'      => __( 'Insert into Learn', 'text_domain' ),
	'uploaded_to_this_item' => __( 'Uploaded to this Learn', 'text_domain' ),
	'items_list'            => __( 'Learn list', 'text_domain' ),
	'items_list_navigation' => __( 'Learn list navigation', 'text_domain' ),
	'filter_items_list'     => __( 'Filter Learn list', 'text_domain' ),
);

$rewrite = array(
  'slug'                  => 'learn',
  'with_front'            => true,
  'pages'                 => true,
  'feeds'                 => true,
);


$args = array(
	'label'                 => __( 'Learn', 'text_domain' ),
	'description'           => __( 'Post Type for Learn', 'text_domain' ),
	'labels'                => $labels,
	'supports'              => array( 'title', 'editor', 'thumbnail' ),
	'taxonomies'            => array(  ),
	'hierarchical'          => false,
	'public'                => true,
	'show_ui'               => true,
	'show_in_menu'          => true,
	'menu_position'         => 20,
	'menu_icon'             => 'dashicons-welcome-learn-more',
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
