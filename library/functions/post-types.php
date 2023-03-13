<?php

// custom post type for testimonials

/*
* Creating a function to create our CPT
*/

function custom_post_type() {

    // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => _x( 'Testimonials', 'Post Type General Name', 'dmtheme' ),
            'singular_name'       => _x( 'Tesimonial', 'Post Type Singular Name', 'dmtheme' ),
            'menu_name'           => __( 'Testimonials', 'dmtheme' ),
            'parent_item_colon'   => __( 'Parent Tesimonial', 'dmtheme' ),
            'all_items'           => __( 'All Testimonials', 'dmtheme' ),
            'view_item'           => __( 'View Tesimonial', 'dmtheme' ),
            'add_new_item'        => __( 'Add New Tesimonial', 'dmtheme' ),
            'add_new'             => __( 'Add New', 'dmtheme' ),
            'edit_item'           => __( 'Edit Tesimonial', 'dmtheme' ),
            'update_item'         => __( 'Update Tesimonial', 'dmtheme' ),
            'search_items'        => __( 'Search Tesimonial', 'dmtheme' ),
            'not_found'           => __( 'Not Found', 'dmtheme' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'dmtheme' ),
        );
        
    // Set other options for Custom Post Type
        
        $args = array(
            'label'               => __( 'Testimonials', 'dmtheme' ),
            'description'         => __( 'Tesimonial news and reviews', 'dmtheme' ),
            'labels'              => $labels,
            // Features this CPT supports in Post Editor
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
            // You can associate this CPT with a taxonomy or custom taxonomy. 
            'taxonomies'          => array( 'genres' ),
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */ 
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon' => 'dashicons-format-quote',
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest' => true,
    
        );
        
        // Registering your Custom Post Type
        register_post_type( 'testimonials', $args );
    
    }
    
    /* Hook into the 'init' action so that the function
    * Containing our post type registration is not 
    * unnecessarily executed. 
    */
    
    add_action( 'init', 'custom_post_type', 0 );


?>