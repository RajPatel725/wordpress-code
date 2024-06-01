<?php

// Enqueue parent theme styles
function enqueue_parent_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

// Register navigation menus
function register_theme_menus() {
    register_nav_menus( array(
        'primary' => 'Primary Menu',
        'footer'  => 'Footer Menu',
    ) );
}
add_action( 'init', 'register_theme_menus' );

// Enable featured image support
function theme_support_featured_images() {
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'theme_support_featured_images' );

function my_custom_post_product() {
	$labels = array(
	  'name'               => _x( 'Products', 'post type general name' ),
	  'singular_name'      => _x( 'Product', 'post type singular name' ),
	  'add_new'            => _x( 'Add New', 'book' ),
	  'add_new_item'       => __( 'Add New Product' ),
	  'edit_item'          => __( 'Edit Product' ),
	  'new_item'           => __( 'New Product' ),
	  'all_items'          => __( 'All Products' ),
	  'view_item'          => __( 'View Product' ),
	  'search_items'       => __( 'Search Products' ),
	  'not_found'          => __( 'No products found' ),
	  'not_found_in_trash' => __( 'No products found in the Trash' ), 
	  'menu_name'          => 'Products'
	);
	$args = array(
	  'labels'        => $labels,
	  'description'   => 'Holds our products and product specific data',
	  'public'        => true,
	  'menu_position' => 5,
	  'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
	  'has_archive'   => true,
	);
	register_post_type( 'product', $args ); 

}

add_action( 'init', 'my_custom_post_product' );