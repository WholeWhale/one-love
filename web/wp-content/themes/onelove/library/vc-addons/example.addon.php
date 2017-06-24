<?php

/**
 * The following is an example of how to add shortcodes to visual composer
 * refer to this for more information: https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
 */

// add_shortcode( 'bartag', 'bartag_func' );
// function bartag_func( $atts ) {
//    extract( shortcode_atts( array(
//       'foo' => 'something'
//    ), $atts ) );
//
//    return "Hello, how are you doing?";
// }
//
// add_action( 'vc_before_init', 'your_name_integrateWithVC' );
// function your_name_integrateWithVC() {
//    vc_map( array(
//       "name" => __( "Bar tag test", "my-text-domain" ),
//       "base" => "bartag",
//       "class" => "",
//       "category" => __( "Content", "my-text-domain"),
//       'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
//       'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
//       "params" => array(
//          array(
//             "type" => "textfield",
//             "holder" => "div",
//             "class" => "",
//             "heading" => __( "Text", "my-text-domain" ),
//             "param_name" => "foo",
//             "value" => __( "Default param value", "my-text-domain" ),
//             "description" => __( "Description for foo param.", "my-text-domain" )
//          )
//       )
//    ) );
// }
