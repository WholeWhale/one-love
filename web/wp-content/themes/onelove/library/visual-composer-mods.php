<?php

// Before VC Init
add_action( 'vc_before_init', 'vc_before_init_actions' );

function vc_before_init_actions() {

    // Setup VC to be part of a theme
    if( function_exists('vc_set_as_theme') ){

        vc_set_as_theme( true );

    }

    // Link your VC elements's folder
    if( function_exists('vc_set_shortcodes_templates_dir') ) {

        vc_set_shortcodes_templates_dir( get_stylesheet_directory() . '/library/vc-overrides' );

    }

    // Disable Instructional/Help Pointers
    if( function_exists('vc_pointer_load') ){

        remove_action( 'admin_enqueue_scripts', 'vc_pointer_load' );

    }

}

// After VC Init
add_action( 'vc_after_init', 'vc_after_init_actions' );

function vc_after_init_actions() {

    // Enable VC by default on a list of Post Types
    if( function_exists('vc_set_default_editor_post_types') ){

        $list = array(
            'page',
            'post',
        );

        vc_set_default_editor_post_types( $list );

    }

    // Disable AdminBar VC edit link
    // if( function_exists('vc_frontend_editor') ){
    //
    //     remove_action( 'admin_bar_menu', array( vc_frontend_editor(), 'adminBarEditLink' ), 1000 );
    //
    // }

    // Disable Frontend VC links
    // if( function_exists('vc_disable_frontend') ){
    //
    //     vc_disable_frontend();
    //
    // }

}
