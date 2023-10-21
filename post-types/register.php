<?php

function afn_register_menu_type() {
 
    $labels = array(
        'name' => __( 'Menu Sections', AFNDOMAIN ),
        'singular_name' => __( 'Menu Section', AFNDOMAIN ),
        'add_new_item' => __('Add New Menu Section', AFNDOMAIN),
        'add_new'           => __( 'Add Menu Section', AFNDOMAIN ),
        'add_new_item'      => __( 'Add Menu Section', AFNDOMAIN ),
    );

    $args = array(
        'hierarchical'      => true,
        'rewrite'           => array('heirarchical' => true, 'has_front' => true),
        'labels'            => $labels,
        'public'            => true,
        'show_admin_column' => true,
        'show_in_quick_edit' => true,
        'show_in_rest'      => true,
        'menu_icon'         => 'dashicons-list-view',
        'has_archive' => true,
        'rewrite' => array('slug' => 'menu-section'),
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
    );

    register_post_type( 'menu_section', $args );

}