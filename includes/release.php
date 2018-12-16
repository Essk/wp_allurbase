<?php 
function aub_create_release() {

	$labels = array(
		'name'                  => _x( 'Releases', 'Post Type General Name', 'allurbase' ),
		'singular_name'         => _x( 'Release', 'Post Type Singular Name', 'allurbase' ),
		'menu_name'             => __( 'Releases', 'allurbase' ),
		'name_admin_bar'        => __( 'Releases', 'allurbase' ),
		'archives'              => __( 'Item Archives', 'allurbase' ),
		'attributes'            => __( 'Item Attributes', 'allurbase' ),
		'parent_item_colon'     => __( 'Parent Item:', 'allurbase' ),
		'all_items'             => __( 'All Items', 'allurbase' ),
		'add_new_item'          => __( 'Add New Item', 'allurbase' ),
		'add_new'               => __( 'Add New', 'allurbase' ),
		'new_item'              => __( 'New Item', 'allurbase' ),
		'edit_item'             => __( 'Edit Item', 'allurbase' ),
		'update_item'           => __( 'Update Item', 'allurbase' ),
		'view_item'             => __( 'View Item', 'allurbase' ),
		'view_items'            => __( 'View Items', 'allurbase' ),
		'search_items'          => __( 'Search Item', 'allurbase' ),
		'not_found'             => __( 'Not found', 'allurbase' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'allurbase' ),
		'featured_image'        => __( 'Featured Image', 'allurbase' ),
		'set_featured_image'    => __( 'Set featured image', 'allurbase' ),
		'remove_featured_image' => __( 'Remove featured image', 'allurbase' ),
		'use_featured_image'    => __( 'Use as featured image', 'allurbase' ),
		'insert_into_item'      => __( 'Insert into item', 'allurbase' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'allurbase' ),
		'items_list'            => __( 'Items list', 'allurbase' ),
		'items_list_navigation' => __( 'Items list navigation', 'allurbase' ),
		'filter_items_list'     => __( 'Filter items list', 'allurbase' ),
	);
	$rewrite = array(
		'slug'                  => 'post_type',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'release', 'allurbase' ),
		'description'           => __( 'A software release', 'allurbase' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-album',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'release', $args );

}
add_action( 'init', 'aub_create_release', 0 );
?>
